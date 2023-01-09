<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지역 풍향풍속데이터
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

//require_once "../class/WindInfo.class";//풍향 class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB);//장비
//$WindInfo = new WindInfo($DB,$DM, $dvUtil);//풍향


	$mode = $dvUtil->xss_clean($_REQUEST["mode"]);
	$arr_area_code = $_REQUEST["arr_area_code"];
	
	if(!isset($mode) && empty($mode)){
		$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
		echo json_encode( $returnBody );
		exit;
	}

	switch($mode) {
	case 'wind':
		$arr_data = array();
		$calc = 0.01;
		
		if($arr_area_code){
			foreach($arr_area_code as $key => $val){
				/*
				$qry = " SELECT avr_deg1, avr_vel1, wind_date FROM wind_hist
						 WHERE area_code = '".$val."'
						 AND data_type = 'M' ";
		    	if(TEST == "0"){
		    		$qry.= " AND wind_date BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND wind_date = '".TEST_DATE."' ";
		    	}
		    	$qry.= " ORDER BY wind_date DESC LIMIT 1 ";
				*/

				$qry = " SELECT realdata as avr_vel1,realtime as wind_date FROM realtime_data
						 WHERE area_code = '".$val."'
						AND sensor_type in ('W','WD')
						AND realtime BETWEEN {ts '".$DM->getBefTime()."'} and {ts '".$DM->getNowMinTime()."'}";
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
				$arr_data[$key]['deg'] = "-";
				$arr_data[$key]['day'] = "-";
				$arr_data[$key]['date'] = "-";
				
				if( isset($data[0]['wind_date']) ){
					
					if( $data[0]['wind_date'] < $DM->getMinDisTime()){
					}else{
					
					$tmp_deg = $data[0]['avr_deg1'];
					$tmp_deg = (int)((($tmp_deg/100)+3)/22.5);
					$num = (int)(fmod($tmp_deg,16));
					switch($num){
						case 0	:	$tmp_deg = "북";				break;
						case 1	:	$tmp_deg = "북북동";			break;
						case 2	:	$tmp_deg = "북동";			break;
						case 3	:	$tmp_deg = "동북동";			break;
						case 4	:	$tmp_deg = "동";				break;
						case 5	:	$tmp_deg = "동남동";			break;
						case 6	:	$tmp_deg = "남동";			break;
						case 7	:	$tmp_deg = "남남동";			break;
						case 8	:	$tmp_deg = "남";				break;
						case 9	:	$tmp_deg = "남남서";			break;
						case 10	:	$tmp_deg = "남서";			break;
						case 11	:	$tmp_deg = "서남서";			break;
						case 12	:	$tmp_deg = "서";				break;
						case 13	:	$tmp_deg = "서북서";			break;
						case 14	:	$tmp_deg = "북서";			break;
						case 15	:	$tmp_deg = "북북서";			break;
						default:	$tmp_deg = "-";				break;
					}
					$arr_data[$key]['deg'] = $tmp_deg;
					$arr_data[$key]['day'] = $data[0]['avr_vel1']*$calc;
					$arr_data[$key]['date'] = $data[0]['wind_date'];
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
