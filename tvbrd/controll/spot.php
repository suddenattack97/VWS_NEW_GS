<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 현장중계데이터
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
require_once "../class/divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
//require_once "../class/RtuInfo.class";//지역 Class

#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB);//장비


    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $arr_area_code = $dvUtil->xss_clean($_REQUEST["arr_area_code"]);
    
    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'spot':
    	$qry = " SELECT * FROM dn_spot_log ";
    	if(TEST == "0"){
	    	$qry.= " WHERE spot_idate >= '".$DM->getStartDay(date("Y-m-d"))."'
					 AND spot_idate <= '".$DM->getEndDay(date("Y-m-d"))."'  ";
    	}else{
    		$qry.= " WHERE spot_idate >= '2018-05-31 00:00:00'
					 AND spot_idate <= '2018-05-31 23:59:59'  ";
    	}
    	$data = $DB->execute($qry);
    	$DB->rs_unset();
    	
    	for($i=0; $i<$DB->NUM_ROW(); $i++){
    		$data_list[$i]['spot_idx'] = $data[$i]['spot_idx'];
    		$data_list[$i]['spot_group'] = $data[$i]['spot_group'];
    		$data_list[$i]['spot_title'] = $data[$i]['spot_title'];
    		$data_list[$i]['spot_content'] = $data[$i]['spot_content'];
    		$tmp_img = '';
    		if( file_exists("../../disos/images/spot/".$data[$i]['spot_img']) ){
    			$tmp_img = "../disos/images/spot/".$data[$i]['spot_img'];
    		}else{
    			$tmp_img = "../disos/images/noimage.png";
    		}
    		$data_list[$i]['spot_img'] = $tmp_img;
    		$data_list[$i]['spot_name'] = $data[$i]['spot_name'];
    		$data_list[$i]['spot_idate'] = $data[$i]['spot_idate'];
    		$data_list[$i]['spot_x_point'] = $data[$i]['spot_x_point'];
    		$data_list[$i]['spot_y_point'] = $data[$i]['spot_y_point'];
    		$data_list[$i]['organ_id'] = $data[$i]['organ_id'];
    	}
    	
    	$returnBody = array( 'result' => true, 'list' => $data_list );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'spot_slide':
    	$qry = " SELECT a.*, b.group_name 
				 FROM dn_spot_log AS a
				 LEFT JOIN dn_spot_group AS b ON a.spot_group = b.spot_group
				 ORDER BY a.spot_idate DESC ";
    	$data = $DB->execute($qry);
    	$DB->rs_unset();
    	
    	for($i=0; $i<$DB->NUM_ROW(); $i++){
    		$data_list[$i]['spot_idx'] = $data[$i]['spot_idx'];
    		$data_list[$i]['spot_group'] = $data[$i]['spot_group'];
    		$data_list[$i]['spot_title'] = $data[$i]['spot_title'];
    		$data_list[$i]['spot_content'] = $data[$i]['spot_content'];
    		$tmp_img = '';
    		if( file_exists("../../disos/images/spot/".$data[$i]['spot_img']) ){
    			$tmp_img = "../disos/images/spot/".$data[$i]['spot_img'];
    		}else{
    			$tmp_img = "../disos/images/noimage.png";
    		}
    		$data_list[$i]['spot_img'] = $tmp_img;
    		$data_list[$i]['spot_name'] = $data[$i]['spot_name'];
    		$data_list[$i]['spot_idate'] = $data[$i]['spot_idate'];
    		$data_list[$i]['spot_x_point'] = $data[$i]['spot_x_point'];
    		$data_list[$i]['spot_y_point'] = $data[$i]['spot_y_point'];
    		$data_list[$i]['organ_id'] = $data[$i]['organ_id'];
    		$data_list[$i]['group_name'] = $data[$i]['group_name'];
    	}
    	
    	$returnBody = array( 'result' => true, 'list' => $data_list );
    	echo json_encode( $returnBody );
    	exit;
    break;
    }
?>


