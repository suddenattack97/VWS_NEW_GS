<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/snowInfo.php";

$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜

for($i=0; $i<=23; $i++){
	if($i != $scnt) $where_date .= " , ";
	if($i < 10){
		$where_date .= " '".$sdate." 0".$i.":00:00' ";
	}else{
		$where_date .= " '".$sdate." ".$i.":00:00' ";
	}
}

//적설
$LocalDB = new ClassRtuInfo($DB, 2);
$LocalDB->getRtuInfo();

//적설자료
$ClassSnowInfo = new ClassSnowInfo($DB);

for($i=0; $i<$LocalDB->rsCnt; $i++){
	$ClassSnowInfo->getSnowRpt($LocalDB->AREA_CODE[$i], "H", $where_date, "");
	
	$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	// $sum = 0;
	// $cnt = 0;
	if($ClassSnowInfo->rsSnowRpt){
		foreach($ClassSnowInfo->rsSnowRpt as $key => $val) {
			$data_list[$i]['LIST'][ $val['NUM'] ] = round_data($val['SNOW'], 0.001, 10);
			// if($val['SNOW'] != "-"){
			// 	$sum += round_data($val['SNOW'], 0.001, 10);
			// 	$cnt ++;
			// }
		}
	}
	$ClassSnowInfo->getSnowMax($LocalDB->AREA_CODE[$i], "H", $sdate." 00:00:00", $sdate." 23:59:59");
	$data_list[$i]['SUM'] = ($ClassSnowInfo->rsData == "-") ? "-" : round_data($ClassSnowInfo->rsData, 0.001, 10);
}

$DB->CLOSE();
?>


