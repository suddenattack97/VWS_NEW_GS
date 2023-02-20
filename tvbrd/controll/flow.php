<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 수위데이터
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

//require_once "../class/FlowInfo.class";//수위class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB);//장비
//$FlowInfo = new FlowInfo($DB,$DM, $dvUtil);//수위


    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $arr_area_code = $_REQUEST["arr_area_code"];
    
    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'flow':
    	$arr_data = array();
    	$calc = 0.01;
    	
    	if($arr_area_code){
    		foreach($arr_area_code as $key => $val){
				/*
    			$qry = " SELECT flow_avr, flow_date FROM flow_hist
						 WHERE area_code = '".$val."'
						 AND data_type = 'M' ";
		    	if(TEST == "0"){
		    		$qry.= " AND flow_date BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND flow_date = '".TEST_DATE."' ";
		    	}
				$qry.= " ORDER BY flow_date DESC LIMIT 1 ";
				*/
				
				$qry = " SELECT realdata as flow_avr,realtime as flow_date FROM realtime_data
						 WHERE area_code = '".$val."'
						 AND sensor_type = '1'
						 AND realtime BETWEEN {ts '".$DM->getBefTime()."'} and {ts '".$DM->getNowMinTime()."'} ";
						 /*
		    	if(TEST == "0"){
		    		$qry.= " AND realtime BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND realtime = '".TEST_DATE."' ";
		    	}
				*/
				$qry.= " ORDER BY realtime DESC LIMIT 1 ";

				//echo $qry;

    			$data = $DB->execute($qry);
    			$DB->rs_unset();
    			
    			$arr_data[$key]['area_code'] = $val;
    			$arr_data[$key]['day'] = "-";
    			$arr_data[$key]['date'] = "-";
    			
    			if( isset($data[0]['flow_date']) ){
					
					if( $data[0]['flow_date'] < $DM->getMinDisTime()){
					}
					else{
    				
					$arr_data[$key]['day'] = $data[0]['flow_avr']*$calc;
    				$arr_data[$key]['date'] = $data[0]['flow_date'];
					}
    			}
    		}
    	}
		$DB->close();
    	$returnBody = array( 'result' => true, 'list' => $arr_data);
    	echo json_encode( $returnBody );
    	exit;
    break;
    }
?>
