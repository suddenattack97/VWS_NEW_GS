<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지역 적설데이터
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");


#################################################################################################################################
# DB connection
#################################################################################################################################
require_once "../db/_Db.php";

#################################################################################################################################
# class 및 function lib
#################################################################################################################################
require_once "../class/DateMake.php";#시간 class
require_once "../class/Divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
require_once "../class/RtuInfo.php";//지역 Class
require_once "../class/FlowInfo.php";#수위 class
require_once "../class/SnowInfo.php";#적설 class

#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();


    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $arr_rtu_id = $_REQUEST["arr_rtu_id"];
    $area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'stillcut':
    	$arr_data = array();
    	
    	if($arr_rtu_id){
    		foreach($arr_rtu_id as $key => $val){
    			// 스틸컷 장비 정보
    			$qry = " SELECT a.sub_id, b.area_code, b.ltype, b.btype, b.stat_check
						 FROM wr_map_sub_info AS a
						 LEFT JOIN display_info AS b ON a.area_code = b.area_code
						 WHERE a.sub_type = 3 AND a.sub_id = '".$val."' ";
		        $data = $DB->execute($qry);
		        $DB->rs_unset();
		        
		        if($data){
		        	// 마지막 데이터 체크
		        	$qry = " SELECT data_img, data_date 
							 FROM display_hist
							 WHERE area_code = '".$data[0]['area_code']."' 
							 ORDER BY data_date DESC LIMIT 1 ";
		        	$rdata = $DB->execute($qry);
		        	
		        	// 현재 촬영 상태 체크
		        	$tdate = date("Y-m-d H:i:s", strtotime('-5 minutes'));
		        	$mdate = date("Y-m-d H:i:s", strtotime('+5 minutes'));
		        	
		        	$qry = " SELECT app_call_state 
							 FROM display_manualcall 
							 WHERE area_code = '".$data[0]['area_code']."' AND call_time Between {ts '".$tdate."'} AND {ts '".$mdate."'} 
							 ORDER BY idx DESC LIMIT 1 ";
		        	$cdata = $DB->execute($qry);
		        	
		        	$arr_data[$key]['rtu_id']  = $data[0]['sub_id'];
		        	$arr_data[$key]['stat_check'] = $data[0]['stat_check']; // 통신상태
		        	$tmp_img = '';
		        	if( file_exists("../../rainsv".$rdata[0]['data_img']) ){
		        		$tmp_img = '<img src="../rainsv'.$rdata[0]['data_img'].'">';
		        	}else{
		        		$tmp_img = '<img src="../rainsv/Capture/noimage.png">';
		        	}
		        	$arr_data[$key]['stillcut'] =  $tmp_img; // 마지막 촬영 이미지
		        	$arr_data[$key]['stillcut_date'] = $rdata[0]['data_date']; // 마지막 촬영 시간
		        	$arr_data[$key]['camstate']  = $cdata[0]['app_call_state']; // 촬영 상태
		        }
    		}
    	}

        $returnBody = array( 'result' => true, 'list' => $arr_data );
        echo json_encode( $returnBody );
        exit;
    break;
    
    case 'stillcut_slide':
    	$RtuInfo = new RtuInfo($DB);
    	$RtuInfo->getRtuName($area_code);
    	
    	// 스틸컷 타입(0:수위, 1:적설, 2:방송)
    	$sql = " SELECT
		    	 	rtu_name, ltype, btype, sensor_areacode
		    	 FROM
		    	 	display_info
		    	 WHERE
		    	 	area_code = '".$area_code."' ";
    	$data = $DB->execute($sql);
    	$DB->rs_unset();
    	
    	$rtu_name = $data[0]['rtu_name'] ? $data[0]['rtu_name'] : $RtuInfo->RTU_NAME;
    	$ltype = $data[0]['ltype'];
    	$btype = $data[0]['btype'];
    	
    	$startdate = $DM->getStartHour( date("Y-m-d 00") );
    	$enddate = $DM->getEndHour( date("Y-m-d 23") );
    	
    	if(TEST == "1"){
    		if($ltype == "0"){
    			$startdate = $DM->getStartHour("2018-05-31 00");
    			$enddate = $DM->getEndHour("2018-05-31 23");
    		}
    	}
    	
    	// 스틸컷 데이터
    	$arr_data = array();
    	
    	if($ltype == "0"){ // 수위
    		$sql = " SELECT a.num, IFNULL(c.flow_date, '-') AS date, IFNULL(c.flow_avr, '-') AS data, IFNULL(b.data_img, '-') AS img
					 FROM statistics_tmp AS a
					 LEFT JOIN (
					 SELECT * FROM display_hist
					 WHERE area_code = '".$area_code."' AND data_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
					 ) AS b ON a.num = DATE_FORMAT(b.data_date, '%k')
					 LEFT JOIN (
					 SELECT * FROM flow_hist
					 WHERE area_code = '".$data[0]['sensor_areacode']."' AND data_type = 'H' AND flow_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
					 ) AS c ON a.num = DATE_FORMAT(c.flow_date, '%k')
					 WHERE a.type = 'H'
					 ORDER BY num ASC ";
    		$rdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		if($rdata){
    			for($i=0; $i<count($rdata); $i++){
    				$arr_data[$i]['num'] = $rdata[$i]['num'];
    				$arr_data[$i]['date'] = $rdata[$i]['date'];
    				$arr_data[$i]['data'] = $rdata[$i]['data'];
    				$tmp_img = '';
    				if($rdata[$i]['img'] == "-"){
    					$tmp_img = "-";
    				}else{
	    				if( file_exists("../../rainsv".$rdata[$i]['img']) ){
	    					$tmp_img = "../rainsv/".$rdata[$i]['img'];
	    				}else{
	    					$tmp_img = "../divas/images/noimage.png";
	    				}
    				}
    				$arr_data[$i]['img'] = $tmp_img;
    			}
    		}
    		
    	}else if($ltype == "1"){ // 적설
    		$sql = " SELECT a.num, IFNULL(b.data_date, '-') AS date, IFNULL(b.sensor_data, '-') AS data, IFNULL(b.data_img, '-') AS img
					 FROM statistics_tmp AS a
					 LEFT JOIN (
					 SELECT * FROM display_hist
					 WHERE area_code = '".$area_code."' AND data_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
					 ) AS b ON a.num = DATE_FORMAT(b.data_date, '%k')
					 WHERE a.type = 'H'
					 ORDER BY num ASC ";
    		$rdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		if($rdata){
    			for($i=0; $i<count($rdata); $i++){
    				$arr_data[$i]['num'] = $rdata[$i]['num'];
    				$arr_data[$i]['date'] = $rdata[$i]['date'];
    				$arr_data[$i]['data'] = $rdata[$i]['data'];
    				$tmp_img = '';
    				if($rdata[$i]['img'] == "-"){
    					$tmp_img = "-";
    				}else{
	    				if( file_exists("../../rainsv".$rdata[$i]['img']) ){
	    					$tmp_img = "../rainsv/".$rdata[$i]['img'];
	    				}else{
	    					$tmp_img = "../divas/images/noimage.png";
	    				}
    				}
    				$arr_data[$i]['img'] = $tmp_img;
    			}
    		}
    		
    	}else if($ltype == "2"){ // 방송
    		$sql = " SELECT rtu_id 
					 FROM rtu_info 
					 WHERE area_code = '".$area_code."' ";
    		$tdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		$sql = " SELECT a.log_no, a.trans_start, a.trans_flag, a.trans_error, a.vhf_call, a.vhf_result, IFNULL(b.data_date, '-') AS date, IFNULL(b.data_img, '-') AS img
					 FROM rtu_log AS a
					 LEFT JOIN (
					 SELECT * FROM display_hist
					 WHERE area_code = '".$area_code."' AND remark = '1'
					 ) AS b ON SUBSTRING(a.trans_start, 1, 13) = SUBSTRING(b.data_date, 1, 13)
					 WHERE a.rtu_id = '".$tdata[0]['rtu_id']."'
					 GROUP BY a.log_no
					 ORDER BY a.log_no DESC, b.data_date DESC
					 LIMIT 20 ";
    		$rdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		if($rdata){
    			for($i=0; $i<count($rdata); $i++){
    				$tmp_result = "";
    				if($rdata[$i]['trans_flag'] == "99"){
    					$tmp_result = "O";
    				}else if($rdata[$i]['vhf_call'] == "7"){
    					$tmp_result = "O";
    				}else if($rdata[$i]['trans_flag'] == "20" && $rdata[$i]['trans_error'] == "88"){
    					$tmp_result = "O";
    				}else if( ($rdata[$i]['trans_flag'] == "20" || $rdata[$i]['trans_flag'] == "30" || $rdata[$i]['trans_flag'] == "40") && 
    						  ($rdata[$i]['trans_error'] == "13" || $rdata[$i]['trans_error'] == "14" || $rdata[$i]['trans_error'] == "15") ){
    					$tmp_result = "O";
    				}else{
    					$tmp_result = "X";
    				}
    				
    				$arr_data[$i]['num'] = $rdata[$i]['num'];
    				$arr_data[$i]['date'] = $rdata[$i]['trans_start'];
    				$arr_data[$i]['data'] = $tmp_result;
    				$tmp_img = '';
    				if($rdata[$i]['img'] == "-"){
    					$tmp_img = "-";
    				}else{
	    				if( file_exists("../../rainsv".$rdata[$i]['img']) ){
	    					$tmp_img = "../rainsv/".$rdata[$i]['img'];
	    				}else{
	    					$tmp_img = "../divas/images/noimage.png";
	    				}
    				}
    				$arr_data[$i]['img'] = $tmp_img;
    			}
    		}
    		
    	}else{
    		$sql = " SELECT rtu_id
					 FROM rtu_info
					 WHERE area_code = '".$area_code."' ";
    		$tdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		$sql = " SELECT log_no, trans_start, trans_flag, trans_error, vhf_call, vhf_result
					 FROM rtu_log
					 WHERE rtu_id = '".$tdata[0]['rtu_id']."'
					 ORDER BY trans_start DESC
					 LIMIT 20 ";
    		$rdata = $DB->execute($sql);
    		$DB->rs_unset();
    		
    		if($rdata){
    			for($i=0; $i<count($rdata); $i++){
    				$tmp_result = "";
    				if($rdata[$i]['trans_flag'] == "99"){
    					$tmp_result = "O";
    				}else if($rdata[$i]['vhf_call'] == "7"){
    					$tmp_result = "O";
    				}else if($rdata[$i]['trans_flag'] == "20" && $rdata[$i]['trans_error'] == "88"){
    					$tmp_result = "O";
    				}else if( ($rdata[$i]['trans_flag'] == "20" || $rdata[$i]['trans_flag'] == "30" || $rdata[$i]['trans_flag'] == "40") &&
    						($rdata[$i]['trans_error'] == "13" || $rdata[$i]['trans_error'] == "14" || $rdata[$i]['trans_error'] == "15") ){
    							$tmp_result = "O";
    				}else{
    					$tmp_result = "X";
    				}
    				
    				$arr_data[$i]['num'] = $rdata[$i]['num'];
					$arr_data[$i]['log_no'] = $rdata[$i]['log_no'];
    				$arr_data[$i]['date'] = $rdata[$i]['trans_start'];
    				$arr_data[$i]['data'] = $tmp_result;
    				$arr_data[$i]['img'] = "-";
    			}
    		}
    	}
    	
    	$resultArr["rtu_name"] = $rtu_name;
    	$resultArr["ltype"] = $ltype;
    	$resultArr["btype"] = $btype;
    	$resultArr["still"] = $arr_data;
    	
    	$returnBody = array( 'result' => true, 'data' => $resultArr );
    	echo json_encode( $returnBody );
    	exit;
    break;
    	
    case 'playstart':
    	$area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);
    	
    	$todate = date("Y-m-d H:i:s");
    	$qry = " INSERT INTO display_manualcall (area_code, call_time, web_call_state) 
				 VALUES ( '".$area_code."', '".$todate."', '1' ) ";
    	$DB->queryone($qry);
    	# code...
    break;
    
    }
?>


