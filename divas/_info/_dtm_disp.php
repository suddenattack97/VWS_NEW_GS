<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/dispInfo.php";

$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜

for($i=0; $i<=23; $i++){
	if($i != $scnt) $where_date .= " , ";
	if($i < 10){
		$where_date .= " '".$sdate." 0".$i.":00:00' ";
	}else{
		$where_date .= " '".$sdate." ".$i.":00:00' ";
	}
}

//변위
$LocalDB = new ClassRtuInfo($DB, 4);
$LocalDB->getDispRtuInfo();

//변위자료
$ClassDispInfo = new ClassDispInfo($DB);

for($i=0; $i<$LocalDB->rsCnt; $i++){
	if(DISP_GROUP == "1"){
		$ClassDispInfo->getDispRpt($LocalDB->SENSOR_AREA_CODE[$i], "H", $where_date, "");
		$data_list[$i]['AREA_CODE'] = $LocalDB->SENSOR_AREA_CODE[$i];
	}else{
		$ClassDispInfo->getDispRpt($LocalDB->AREA_CODE[$i], "H", $where_date, "");
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	}
	
	$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	$sum = 0;
	$cnt = 0;
	if($ClassDispInfo->rsDispRpt){
		foreach($ClassDispInfo->rsDispRpt as $key => $val) {
			$data_list[$i]['LIST'][ $val['NUM'] ] = round_data($val['DISPLACEMENT'], 0.0001, 100);
			if($val['DISPLACEMENT'] != "-"){
				$sum += round_data($val['DISPLACEMENT'], 0.0001, 100);
				$cnt ++;
			}
		}
	}
	$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.2f", $sum);
}

$DB->CLOSE();
?>


