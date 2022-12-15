<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 금일발령상황
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


#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();


$mode =  $dvUtil->xss_clean($_REQUEST["mode"]);

if(!isset($mode) && empty($mode)){
	$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
	echo json_encode( $returnBody );
	exit;
}

switch($mode) {
	case 'danger_check':
		
		$qry = " SELECT RI.AREA_CODE , RI.RTU_TYPE
		FROM rtu_info AS RI
		LEFT JOIN REALTIME_DATA AS RD ON RI.AREA_CODE = RD.AREA_CODE
		WHERE RI.AREA_CODE = RD.AREA_CODE
		AND RI.DANGER_USE = 1 ORDER BY RI.AREA_CODE*1";

		$data1 = $DB->execute($qry);
		$DB->rs_unset();

		
		$qry = " SELECT RI.AREA_CODE , RI.RTU_NAME , RD.SENSOR_TYPE , RI.FLOW_DANGER , RI.FLOW_DANGER_OFF , RI.FLOW_WARNING , RI.FLOW_WARNING_OFF , RI.RTU_TYPE , RD.REALDATA
		FROM rtu_info AS RI
		LEFT JOIN REALTIME_DATA AS RD ON RI.AREA_CODE = RD.AREA_CODE
		WHERE RI.AREA_CODE = RD.AREA_CODE AND RD.REALTIME BETWEEN {ts '".$DM->getBefTime()."'} and {ts '".$DM->getNowMinTime()."'} 
		AND RI.DANGER_USE = 1 
		AND RD.SENSOR_TYPE IN ('0','1','2')
		ORDER BY RI.AREA_CODE*1";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$event['RAIN_WARNING'] = Array();
		$event['FLOW_WARNING'] = Array();
		$event['SNOW_WARNING'] = Array();
		$event['AWS_WARNING'] = Array();
		
		$event['RAIN_DANGER'] = Array();
		$event['FLOW_DANGER'] = Array();
		$event['SNOW_DANGER'] = Array();
		$event['AWS_DANGER'] = Array();
		
		$event['RAIN_CANCEL'] = Array();
		$event['FLOW_CANCEL'] = Array();
		$event['SNOW_CANCEL'] = Array();
		$event['AWS_CANCEL'] = Array();
		
		
		foreach($data1 as $key => $val1){
			$arr_data[$key]['ALL_AREA_CODE'] = $val1['AREA_CODE'];
			$arr_data[$key]['RTU_TYPE'] = $val1['RTU_TYPE'];
			if($arr_data[$key]['RTU_TYPE'] == "R00"){
				array_push($event['RAIN_CANCEL'], $arr_data[$key]['ALL_AREA_CODE']);
			}else if($arr_data[$key]['RTU_TYPE'] == "F00"){
				array_push($event['FLOW_CANCEL'], $arr_data[$key]['ALL_AREA_CODE']);
			}else if($arr_data[$key]['RTU_TYPE'] == "A00"){
				array_push($event['AWS_CANCEL'], $arr_data[$key]['ALL_AREA_CODE']);
			}else if($arr_data[$key]['RTU_TYPE'] == "S00"){
				array_push($event['SNOW_CANCEL'], $arr_data[$key]['ALL_AREA_CODE']);
			}
		}
		
    	foreach($data as $key => $val){
			$arr_data[$key]['AREA_CODE'] = $val['AREA_CODE'];
			$arr_data[$key]['RTU_NAME'] = $val['RTU_NAME'];
			$arr_data[$key]['SENSOR_TYPE'] = $val['SENSOR_TYPE'];
			$arr_data[$key]['FLOW_DANGER'] = $val['FLOW_DANGER'];
			$arr_data[$key]['FLOW_DANGER_OFF'] = $val['FLOW_DANGER_OFF'];
			$arr_data[$key]['FLOW_WARNING'] = $val['FLOW_WARNING'];
			$arr_data[$key]['FLOW_WARNING_OFF'] = $val['FLOW_WARNING_OFF'];
			$arr_data[$key]['RTU_TYPE'] = $val['RTU_TYPE'];
			$arr_data[$key]['REALDATA'] = $val['REALDATA'];

			if($arr_data[$key]['REALDATA'] >= $arr_data[$key]['FLOW_WARNING']){
				if($arr_data[$key]['REALDATA'] >= $arr_data[$key]['FLOW_DANGER']){
					if($arr_data[$key]['RTU_TYPE'] == "R00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['RAIN_CANCEL'] );
						array_splice( $event['RAIN_CANCEL'], $key_index, 1 );
						array_push($event['RAIN_DANGER'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "F00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['FLOW_CANCEL'] );
						array_splice( $event['FLOW_CANCEL'], $key_index, 1 );
						array_push($event['FLOW_DANGER'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "A00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['AWS_CANCEL'] );
						array_splice( $event['AWS_CANCEL'], $key_index, 1 );
						array_push($event['AWS_DANGER'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "S00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['SNOW_CANCEL'] );
						array_splice( $event['SNOW_CANCEL'], $key_index, 1 );
						array_push($event['SNOW_DANGER'], $arr_data[$key]['AREA_CODE']);
					}
				}else{
					if($arr_data[$key]['RTU_TYPE'] == "R00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['RAIN_CANCEL'] );
						array_splice( $event['RAIN_CANCEL'], $key_index, 1 );
						array_push($event['RAIN_WARNING'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "F00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['FLOW_CANCEL'] );
						array_splice( $event['FLOW_CANCEL'], $key_index, 1 );
						array_push($event['FLOW_WARNING'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "A00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['AWS_CANCEL'] );
						array_splice( $event['AWS_CANCEL'], $key_index, 1 );
						array_push($event['AWS_WARNING'], $arr_data[$key]['AREA_CODE']);
					}else if($arr_data[$key]['RTU_TYPE'] == "S00"){
						$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['SNOW_CANCEL'] );
						array_splice( $event['SNOW_CANCEL'], $key_index, 1 );
						array_push($event['SNOW_WARNING'], $arr_data[$key]['AREA_CODE']);
					}
				}
			}else if($arr_data[$key]['REALDATA'] <= $arr_data[$key]['FLOW_WARNING_OFF']){
				if($arr_data[$key]['RTU_TYPE'] == "R00"){
					array_push($event['RAIN_CANCEL'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "F00"){
					array_push($event['FLOW_CANCEL'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "A00"){
					array_push($event['AWS_CANCEL'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "S00"){
					array_push($event['SNOW_CANCEL'], $arr_data[$key]['AREA_CODE']);
				}
			}else if($arr_data[$key]['REALDATA'] > $arr_data[$key]['FLOW_WARNING_OFF'] && $arr_data[$key]['REALDATA'] < $arr_data[$key]['FLOW_WARNING']){
				if($arr_data[$key]['RTU_TYPE'] == "R00"){
					$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['RAIN_CANCEL'] );
					array_splice( $event['RAIN_CANCEL'], $key_index, 1 );
					array_push($event['RAIN_WARNING'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "F00"){
					$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['FLOW_CANCEL'] );
					array_splice( $event['FLOW_CANCEL'], $key_index, 1 );
					array_push($event['FLOW_WARNING'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "A00"){
					$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['AWS_CANCEL'] );
					array_splice( $event['AWS_CANCEL'], $key_index, 1 );
					array_push($event['AWS_WARNING'], $arr_data[$key]['AREA_CODE']);
				}else if($arr_data[$key]['RTU_TYPE'] == "S00"){
					$key_index = array_search( $arr_data[$key]['AREA_CODE'] , $event['SNOW_CANCEL'] );
					array_splice( $event['SNOW_CANCEL'], $key_index, 1 );
					array_push($event['SNOW_WARNING'], $arr_data[$key]['AREA_CODE']);
				}
			}

    	}
		$returnBody = array(
		'result' => true, 'data' => $arr_data ,
		'RAIN_DANGER' => $event['RAIN_DANGER'],
		'FLOW_DANGER' => $event['FLOW_DANGER'],
		'SNOW_DANGER' => $event['SNOW_DANGER'],
		'AWS_DANGER' => $event['AWS_DANGER'],
		'RAIN_WARNING' => $event['RAIN_WARNING'],
		'FLOW_WARNING' => $event['FLOW_WARNING'],
		'SNOW_WARNING' => $event['SNOW_WARNING'],
		'AWS_WARNING' => $event['AWS_WARNING'],
		'RAIN_CANCEL' => $event['RAIN_CANCEL'],
		'FLOW_CANCEL' => $event['FLOW_CANCEL'],
		'SNOW_CANCEL' => $event['SNOW_CANCEL'],
		'AWS_CANCEL' => $event['AWS_CANCEL']
		 );
		echo json_encode( $returnBody );
		exit;
	break;

}
?>


