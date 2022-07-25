<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/flowInfo.php";
require_once "../include/class/snowInfo.php";

$option = $_REQUEST['option'] ? $_REQUEST['option'] : "0"; // 구분
$area_code = $_REQUEST['area_code']; // 지역 코드
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 끝 날짜

if($_REQUEST['stime'] == '0' || $_REQUEST['stime']){
	$stime = $_REQUEST['stime'];
	$sTdate = $stime < 10 ? $sdate." 0".$stime : $sdate." ".$stime;
}else{
	$stime = date("H");
	$sTdate = date("Y-m-d H");
}

if($_REQUEST['etime'] == '0' || $_REQUEST['etime']){
	$etime = $_REQUEST['etime'];
	$eTdate = $etime < 10 ? $edate." 0".$etime : $edate." ".$etime;
}else{
	$etime = date("H");
	$eTdate = date("Y-m-d H");
}

// $stime = $_REQUEST['stime'] == '0' || $_REQUEST['stime'] ? $_REQUEST['stime'] : date("H"); // 시작 시간
// $etime = $_REQUEST['etime'] == '0' || $_REQUEST['etime'] ? $_REQUEST['etime'] : date("H"); // 끝 시간
// $sTdate = $_REQUEST['stime'] == '0' || $_REQUEST['stime'] ? $stime < 10 ? $sdate." 0".$stime : $sdate." ".$stime : date("Y-m-d H"); // 시작 날짜
// $eTdate = $_REQUEST['etime'] == '0' || $_REQUEST['etime'] ? $etime < 10 ? $edate." 0".$etime : $edate." ".$etime : date("Y-m-d H"); // 끝 날짜
/* $yy = substr($sdate, 0, 4);
$mm = substr($sdate, 5, 2);
$dd = substr($sdate, 8, 2); */
$type = 'S';

$t_sdate = $sTdate.":00:00";
$t_edate = $eTdate.":59:00";
$eedate = true;

$tmp_sdate = $sTdate;
while($eedate){
	$tmp_date = "";
	for($j=0; $j<=59; $j++){
		if($j < 10){
			$tmp_j = "0".$j;
		}else{
			$tmp_j = $j;
		}
		$tmp_date = $tmp_sdate.":".$tmp_j.":00";
		$data_list[$tmp_date]['DATE'] = $tmp_date;
		$data_list[$tmp_date]['DATA'] = "-";
	}
	$tmp_sdate = date("Y-m-d H", strtotime($tmp_date.' + 1 hours'));

	if($tmp_sdate > $eTdate) $eedate = false;
}
// var_dump($data_list);

$LocalDB = new ClassRtuInfo($DB, $option);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

if($option == "0"){
	//강우자료
	$ClassRainInfo = new ClassRainInfo($DB);
	
	$ClassRainInfo->getRain10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassRainInfo->rsRain10m){
		foreach($ClassRainInfo->rsRain10m as $key => $val) {
			$data_list[ $val['RAIN_DATE'] ]['DATE'] = $val['RAIN_DATE'];
			$data_list[ $val['RAIN_DATE'] ]['DATA'] = round_data($val['RAIN'], 0.01, 10);
		}
	}
}else if($option == "1"){
	//수위자료
	$ClassFlowInfo = new ClassFlowInfo($DB);
	
	$ClassFlowInfo->getFlow10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassFlowInfo->rsFlow10m){
		foreach($ClassFlowInfo->rsFlow10m as $key => $val) {
			$data_list[ $val['FLOW_DATE'] ]['DATE'] = $val['FLOW_DATE'];
			$data_list[ $val['FLOW_DATE'] ]['DATA'] = round_data($val['FLOW'], 0.01, 100);
		}
	}
}else if($option == "2"){
	//적설자료
	$ClassSnowInfo = new ClassSnowInfo($DB);
	
	$ClassSnowInfo->getSnow10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassSnowInfo->rsSnow10m){
		foreach($ClassSnowInfo->rsSnow10m as $key => $val) {
			$data_list[ $val['SNOW_DATE'] ]['DATE'] = $val['SNOW_DATE'];
			$data_list[ $val['SNOW_DATE'] ]['DATA'] = round_data($val['SNOW'], 0.001, 10);
		}
	}
}

$DB->CLOSE();
?>


