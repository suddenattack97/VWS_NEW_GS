<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/awsInfo.php";

$ott = getToken();
$_SESSION["OTT"] = $ott;

$scnt = 0;
$ecnt = 23;

$area_code = $_REQUEST['area_code']; // 지역 코드
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜

for($i=0; $i<=23; $i++){
	if($i != $scnt) $where_date .= " , ";
	if($i < 10){
		$where_date .= " '".$sdate." 0".$i.":00:00' ";
	}else{
		$where_date .= " '".$sdate." ".$i.":00:00' ";
	}
}

//aws
$SelLocalDB = new ClassRtuInfo($DB, 3);
$SelLocalDB->getRtuInfo();

for($i=0; $i<$SelLocalDB->rsCnt; $i++) {
	$data_sel[$i]['AREA_CODE'] = $SelLocalDB->AREA_CODE[$i];
	$data_sel[$i]['RTU_NAME'] = $SelLocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

//강우
$RainLocalDB = new ClassRtuInfo($DB, 0);
$RainLocalDB->getRtuInfo($area_code);
//aws
$AwsLocalDB = new ClassRtuInfo($DB, 3);
$AwsLocalDB->getRtuInfo($area_code);

//강우자료
$ClassRainInfo = new ClassRainInfo($DB);
//aws자료
$ClassAwsInfo = new ClassAwsInfo($DB);
	
// 강우
$ClassRainInfo->getRainRpt($area_code, "H", $where_date, "");
	
$sum = 0;
$cnt = 0;
if($ClassRainInfo->rsRainRpt){
	foreach($ClassRainInfo->rsRainRpt as $key => $val) {
		$data_list['RAIN'][ $val['NUM'] ] = round_data($val['RAIN'], 0.01, 10);
		if($val['RAIN'] != "-"){
			$sum += round_data($val['RAIN'], 0.01, 10);
			$cnt ++;
		}
	}
}
$data_list['RAIN_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['RAIN_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);

// 온도
$ClassAwsInfo->getTempRpt($area_code, "H", $where_date, "");

$sum = 0;
$sum_max = 0;
$sum_min = 0;
$cnt = 0;
$cnt_max = 0;
$cnt_min = 0;
if($ClassAwsInfo->rsTempRpt){
	foreach($ClassAwsInfo->rsTempRpt as $key => $val) {
		$data_list['TEMP'][ $val['NUM'] ] = round_data($val['TEMP'], 0.01, 10);
		$data_list['TEMP_MAX'][ $val['NUM'] ] = round_data($val['TEMP_MAX'], 0.01, 10);
		$data_list['TEMP_MIN'][ $val['NUM'] ] = round_data($val['TEMP_MIN'], 0.01, 10);
		if($val['TEMP'] != "-"){
			$sum += round_data($val['TEMP'], 0.01, 10);
			$cnt ++;
		}
		if($val['TEMP_MAX'] != "-"){
			$sum_max += round_data($val['TEMP_MAX'], 0.01, 10);
			$cnt_max ++;
		}
		if($val['TEMP_MIN'] != "-"){
			$sum_min += round_data($val['TEMP_MIN'], 0.01, 10);
			$cnt_min ++;
		}
	}
}
$data_list['TEMP_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['TEMP_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
$data_list['TEMP_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
$data_list['TEMP_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
$data_list['TEMP_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
$data_list['TEMP_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);

// 풍향풍속
$ClassAwsInfo->getWindRpt($area_code, "H", $where_date, "");

$sum_vel = 0;
$sum_vel_max = 0;
$sum_deg = 0;
$sum_deg_max = 0;
$cnt_vel = 0;
$cnt_vel_max = 0;
$cnt_deg = 0;
$cnt_deg_max = 0;
if($ClassAwsInfo->rsWindRpt){
	foreach($ClassAwsInfo->rsWindRpt as $key => $val) {
		$data_list['VEL'][ $val['NUM'] ] = round_data($val['VEL'], 0.01, 10);
		$data_list['VEL_MAX'][ $val['NUM'] ] = round_data($val['VEL_MAX'], 0.01, 10);
		$data_list['DEG'][ $val['NUM'] ] = $val['DEG'];
		$data_list['DEG_MAX'][ $val['NUM'] ] = $val['DEG_MAX'];
		if($val['VEL'] != "-"){
			$sum_vel += round_data($val['VEL'], 0.01, 10);
			$cnt_vel ++;
		}
		if($val['VEL_MAX'] != "-"){
			$sum_vel_max += round_data($val['VEL_MAX'], 0.01, 10);
			$cnt_vel_max ++;
		}
		if($val['DEG_OR'] != "-"){
			$sum_deg += $val['DEG_OR'];
			$cnt_deg ++;
		}
		if($val['DEG_MAX_OR'] != "-"){
			$sum_deg_max += $val['DEG_MAX_OR'];
			$cnt_deg_max ++;
		}
	}
}
$data_list['VEL_SUM'] = ($cnt_vel == 0) ? "-" : sprintf("%.1f", $sum_vel);
$data_list['VEL_AVR'] = ($cnt_vel == 0) ? "-" : sprintf("%.1f", $sum_vel/$cnt_vel);
$data_list['VEL_MAX_SUM'] = ($cnt_vel_max == 0) ? "-" : sprintf("%.1f", $sum_vel_max);
$data_list['VEL_MAX_AVR'] = ($cnt_vel_max == 0) ? "-" : sprintf("%.1f", $sum_vel_max/$cnt_vel_max);
$data_list['DEG_SUM'] = ($cnt_deg == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg);
$data_list['DEG_AVR'] = ($cnt_deg == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg/$cnt_deg);
$data_list['DEG_MAX_SUM'] = ($cnt_deg_max == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg_max);
$data_list['DEG_MAX_AVR'] = ($cnt_deg_max == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg_max/$cnt_deg_max);

// 기압
$ClassAwsInfo->getAtmoRpt($area_code, "H", $where_date, "");

$sum = 0;
$sum_max = 0;
$sum_min = 0;
$cnt = 0;
$cnt_max = 0;
$cnt_min = 0;
if($ClassAwsInfo->rsAtmoRpt){
	foreach($ClassAwsInfo->rsAtmoRpt as $key => $val) {
		$data_list['ATMO'][ $val['NUM'] ] = round_data($val['ATMO'], 0.01, 10);
		$data_list['ATMO_MAX'][ $val['NUM'] ] = round_data($val['ATMO_MAX'], 0.01, 10);
		$data_list['ATMO_MIN'][ $val['NUM'] ] = round_data($val['ATMO_MIN'], 0.01, 10);
		if($val['ATMO'] != "-"){
			$sum += round_data($val['ATMO'], 0.01, 10);
			$cnt ++;
		}
		if($val['ATMO_MAX'] != "-"){
			$sum_max += round_data($val['ATMO_MAX'], 0.01, 10);
			$cnt_max ++;
		}
		if($val['ATMO_MIN'] != "-"){
			$sum_min += round_data($val['ATMO_MIN'], 0.01, 10);
			$cnt_min ++;
		}
	}
}
$data_list['ATMO_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['ATMO_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
$data_list['ATMO_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
$data_list['ATMO_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
$data_list['ATMO_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
$data_list['ATMO_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);

// 습도
$ClassAwsInfo->getHumiRpt($area_code, "H", $where_date, "");

$sum = 0;
$sum_max = 0;
$sum_min = 0;
$cnt = 0;
$cnt_max = 0;
$cnt_min = 0;
if($ClassAwsInfo->rsHumiRpt){
	foreach($ClassAwsInfo->rsHumiRpt as $key => $val) {
		$data_list['HUMI'][ $val['NUM'] ] = round_data($val['HUMI'], 0.01, 10);
		$data_list['HUMI_MAX'][ $val['NUM'] ] = round_data($val['HUMI_MAX'], 0.01, 10);
		$data_list['HUMI_MIN'][ $val['NUM'] ] = round_data($val['HUMI_MIN'], 0.01, 10);
		if($val['HUMI'] != "-"){
			$sum += round_data($val['HUMI'], 0.01, 10);
			$cnt ++;
		}
		if($val['HUMI_MAX'] != "-"){
			$sum_max += round_data($val['HUMI_MAX'], 0.01, 10);
			$cnt_max ++;
		}
		if($val['HUMI_MIN'] != "-"){
			$sum_min += round_data($val['HUMI_MIN'], 0.01, 10);
			$cnt_min ++;
		}
	}
}
$data_list['HUMI_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['HUMI_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
$data_list['HUMI_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
$data_list['HUMI_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
$data_list['HUMI_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
$data_list['HUMI_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);

// 일사
$ClassAwsInfo->getRadiRpt($area_code, "H", $where_date, "");

$sum = 0;
$cnt = 0;
if($ClassAwsInfo->rsRadiRpt){
	foreach($ClassAwsInfo->rsRadiRpt as $key => $val) {
		$data_list['RADI'][ $val['NUM'] ] = round_data($val['RADI'], 0.01, 10);
		if($val['RADI'] != "-"){
			$sum += round_data($val['RADI'], 0.01, 10);
			$cnt ++;
		}
	}
}
$data_list['RADI_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['RADI_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);

// 일조
$ClassAwsInfo->getSunsRpt($area_code, "H", $where_date, "");

$sum = 0;
$cnt = 0;
if($ClassAwsInfo->rsSunsRpt){
	foreach($ClassAwsInfo->rsSunsRpt as $key => $val) {
		$data_list['SUNS'][ $val['NUM'] ] = round_data($val['SUNS'], 0.01, 10);
		if($val['SUNS'] != "-"){
			$sum += round_data($val['SUNS'], 0.01, 10);
			$cnt ++;
		}
	}
}
$data_list['SUNS_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
$data_list['SUNS_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);

$DB->CLOSE();
?>


