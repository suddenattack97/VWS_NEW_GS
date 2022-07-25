<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지역 습도데이터
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
//require_once "../class/RtuInfo.class";//지역 Class

//require_once "../class/HumiInfo.class";//습도 class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB);//장비
//$HumiInfo = new HumiInfo($DB,$DM, $dvUtil);//습도


$mode = $dvUtil->xss_clean($_REQUEST["mode"]);
$arr_area_code = $_REQUEST["arr_area_code"];

	if(!isset($mode) && empty($mode)){
		$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
		echo json_encode( $returnBody );
		exit;
	}

	switch($mode) {
	case 'damp':
		$arr_data = array();
		$calc = 0.01;
		
		if($arr_area_code){
			foreach($arr_area_code as $key => $val){
				/*
				$qry = " SELECT avr_val, humi_date FROM humi_hist
						 WHERE area_code = '".$val."'
						 AND data_type = 'M' ";
		    	if(TEST == "0"){
		    		$qry.= " AND humi_date BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND humi_date = '".TEST_DATE."' ";
		    	}
		    	$qry.= " ORDER BY humi_date DESC LIMIT 1 ";
				*/

				$qry = " SELECT realdata as avr_val,realtime as humi_date FROM realtime_data
						 WHERE area_code = '".$val."'
						 AND sensor_type = 'H'
						 AND realtime BETWEEN {ts '".$DM->getBefTime()."'} and {ts '".$DM->getNowMinTime()."'} ";
						 /*
		    	if(TEST == "0"){
		    		$qry.= " AND realtime BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND realtime = '".TEST_DATE."' ";
		    	}
				*/
				//$qry.= " ORDER BY realtime DESC LIMIT 1 ";

				$data = $DB->execute($qry);
				$DB->rs_unset();
				
				$arr_data[$key]['area_code'] = $val;
				$arr_data[$key]['day'] = "-";
				$arr_data[$key]['date'] = "-";
				
				if( isset($data[0]['humi_date']) ){
					
					if( $data[0]['humi_date'] < $DM->getMinDisTime()){
					}else{
					
					$arr_data[$key]['day'] = $data[0]['avr_val']*$calc;
					$arr_data[$key]['date'] = $data[0]['humi_date'];
					}
				}
			}
		}
		
		$returnBody = array( 'result' => true, 'list' => $arr_data);
		echo json_encode( $returnBody );
		exit;
	break;
}
?>
