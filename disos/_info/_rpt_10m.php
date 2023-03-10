<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/flowInfo.php";
require_once "../include/class/snowInfo.php";
require_once "../include/class/awsInfo.php";

$option = $_REQUEST['option'] ? $_REQUEST['option'] : "0"; // 구분
$area_code = $_REQUEST['area_code']; // 지역 코드
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 끝 날짜
/* $yy = substr($sdate, 0, 4);
$mm = substr($sdate, 5, 2);
$dd = substr($sdate, 8, 2); */
$type = 'M';

$t_sdate = $sdate." 00:00:00";
$t_edate = $edate." 23:50:00";
$today = date("Y-m-d");

if(date("i") >= 50) $min = "50";
else if(date("i") >= 40) $min = "40";
else if(date("i") >= 30) $min = "30";
else if(date("i") >= 20) $min = "20";
else if(date("i") >= 10) $min = "10";
else $min = "00";
$nowDate = date("Y-m-d H:").$min.":00";

$eedate = true;
$todayF = false;
$tmp_sdate = $edate;
while($eedate){
	if($today == $tmp_sdate) $todayF = true;
	if($todayF){
		for($i=(int)date("H"); $i>=0; $i--){
			if($i < 10){
				$tmp_i = "0".$i;
			}else{
				$tmp_i = $i;
			}
			for($j=5; $j>=0; $j--){
				if($tmp_i != (int)date("H")){
					$tmp_date = $tmp_sdate." ".$tmp_i.":".$j."0:00";
					$data_list[$tmp_date]['DATE'] = $tmp_date;
					$data_list[$tmp_date]['DATA'] = "-";
				}else if( $j."0" < date("i") ){
					$tmp_date = $tmp_sdate." ".$tmp_i.":".$j."0:00";
					$data_list[$tmp_date]['DATE'] = $tmp_date;
					$data_list[$tmp_date]['DATA'] = "-";
				}
			}
		}
		$todayF = false;
	}else{
		for($i=23; $i>=0; $i--){
			if($i < 10){
				$tmp_i = "0".$i;
			}else{
				$tmp_i = $i;
			}
			for($j=5; $j>=0; $j--){
				
				$tmp_date = $tmp_sdate." ".$tmp_i.":".$j."0:00";
				$data_list[$tmp_date]['DATE'] = $tmp_date;
				$data_list[$tmp_date]['DATA'] = "-";
			}
		}
	}

	$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' - 1 days'));
	if($tmp_sdate < $sdate) $eedate = false;
}
$sensor = $option > 3 ? 3 : $option;
$LocalDB = new ClassRtuInfo($DB, $sensor);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

$lastDate = '-';
if($option == "0"){
	//강우자료
	$ClassRainInfo = new ClassRainInfo($DB);
	
	$ClassRainInfo->getRain10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassRainInfo->rsRain10m){
		foreach($ClassRainInfo->rsRain10m as $key => $val) {
			$data_list[ $val['RAIN_DATE'] ]['DATE'] = $val['RAIN_DATE'];
			$data_list[ $val['RAIN_DATE'] ]['DATA'] = round_data($val['RAIN'], 0.01, 10);
			$lastDate = $val['RAIN_DATE'];
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
			$lastDate = $val['FLOW_DATE'];
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
			$lastDate = $val['SNOW_DATE'];
		}
	}
}else if($option == "3"){
	//온도자료
	$ClassAwsInfo = new ClassAwsInfo($DB);
	
	$ClassAwsInfo->getTemp10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassAwsInfo->rsTemp10m){
		foreach($ClassAwsInfo->rsTemp10m as $key => $val) {
			$data_list[ $val['TEMP_DATE'] ]['DATE'] = $val['TEMP_DATE'];
			$data_list[ $val['TEMP_DATE'] ]['DATA'] = round_data($val['TEMP'], 0.01, 10);
			$lastDate = $val['TEMP_DATE'];
		}
	}
}else if($option == "4"){
	//풍속자료
	$ClassAwsInfo = new ClassAwsInfo($DB);
	
	$ClassAwsInfo->getWind10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassAwsInfo->rsWind10m){
		foreach($ClassAwsInfo->rsWind10m as $key => $val) {
			$data_list[ $val['WIND_DATE'] ]['DATE'] = $val['WIND_DATE'];
			$data_list[ $val['WIND_DATE'] ]['DATA'] = round_data($val['VEL'], 0.01, 10);
			$data_list[ $val['WIND_DATE'] ]['DEG'] = "../../tvbrd/img/wind/".$val['DEG_EN'];
			$lastDate = $val['WIND_DATE'];
		}
	}
}else if($option == "5"){
	//습도자료
	$ClassAwsInfo = new ClassAwsInfo($DB);
	
	$ClassAwsInfo->getHumi10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassAwsInfo->rsHumi10m){
		foreach($ClassAwsInfo->rsHumi10m as $key => $val) {
			$data_list[ $val['HUMI_DATE'] ]['DATE'] = $val['HUMI_DATE'];
			$data_list[ $val['HUMI_DATE'] ]['DATA'] = round_data($val['HUMI'], 0.01, 10);
			$lastDate = $val['HUMI_DATE'];
		}
	}
}else if($option == "6"){
	//기압자료
	$ClassAwsInfo = new ClassAwsInfo($DB);
	
	$ClassAwsInfo->getAtmo10m($area_code, $type, $t_sdate, $t_edate);
	
	if($ClassAwsInfo->rsAtmo10m){
		foreach($ClassAwsInfo->rsAtmo10m as $key => $val) {
			$data_list[ $val['ATMO_DATE'] ]['DATE'] = $val['ATMO_DATE'];
			$data_list[ $val['ATMO_DATE'] ]['DATA'] = round_data($val['ATMO'], 0.01, 10);
			$lastDate = $val['ATMO_DATE'];
		}
	}
}

if($lastDate != '-'){
	if($lastDate < $nowDate) unset($data_list[$nowDate]);
}

$DB->CLOSE();
?>
