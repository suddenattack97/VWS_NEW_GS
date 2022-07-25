<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/dispInfo.php";

$area_code = $_REQUEST['area_code']; // 지역 코드
$type = $_REQUEST['type'] ? $_REQUEST['type'] : "H"; // 검색기간
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$yy = substr($sdate, 0, 4);
$mm = substr($sdate, 5, 2);
$dd = substr($sdate, 8, 2);

if($type == "H"){
	$scnt = 0;
	$ecnt = 23;
	$tcnt = 24;
	for($i=$scnt; $i<=$ecnt; $i++){
		if($i != $scnt) $where_date .= " , ";
		if($i < 10){
			$where_date .= " '".$sdate." 0".$i.":00:00' ";
		}else{
			$where_date .= " '".$sdate." ".$i.":00:00' ";
		}
	}
}else if($type == "D"){
	$scnt = 1;
	$ecnt = date("t", strtotime($sdate));
	$tcnt = $ecnt;
	for($i=$scnt; $i<=$ecnt; $i++){
		if($i != $scnt) $where_date .= " , ";
		if($i < 10){
			$where_date .= " '".$yy."-".$mm."-0".$i." 00:00:00' ";
		}else{
			$where_date .= " '".$yy."-".$mm."-".$i." 00:00:00' ";
		}
	}
}else if($type == "N"){
	$scnt = 1;
	$ecnt = 12;
	$tcnt = 12;
	for($i=$scnt; $i<=$ecnt; $i++){
		if($i != $scnt) $where_date .= " , ";
		if($i < 10){
			$where_date .= " '".$yy."-0".$i."-01 00:00:00' ";
		}else{
			$where_date .= " '".$yy."-".$i."-01 00:00:00' ";
		}
	}
}


//변위
$LocalDB = new ClassRtuInfo($DB, 4);
$LocalDB->getDispRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	if(DISP_GROUP == "1"){
		$data_sel[$i]['AREA_CODE'] = $LocalDB->SENSOR_AREA_CODE[$i];
	}else{
		$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	}
	$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

//변위자료
$ClassDispInfo = new ClassDispInfo($DB);

$max = array(); // 검색기간별 최고
$min = array(); // 검색기간별 최저
$row = array(); // 검색기간별 합계
$row_cnt = array(); // 검색기간별 개수
$sum_max = 0; // 최고 누계
$sum_min = 0; // 최저 누계
$sum_avr = 0; // 평균 누계
$sum_cnt = 0; // 검색기간별 누계 개수

for($i=0; $i<$LocalDB->rsCnt; $i++){
	if(DISP_GROUP == "1"){
		$ClassDispInfo->getDispRpt($LocalDB->SENSOR_AREA_CODE[$i], $type, $where_date, $ecnt);
		$data_list[$i]['AREA_CODE'] = $LocalDB->SENSOR_AREA_CODE[$i];
	}else{
		$ClassDispInfo->getDispRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
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
				$max[ $val['NUM'] ] = ($max[ $val['NUM'] ] < round_data($val['DISPLACEMENT'], 0.0001, 100)) ? round_data($val['DISPLACEMENT'], 0.0001, 100) : $max[ $val['NUM'] ];
				$min[ $val['NUM'] ] = ($min[ $val['NUM'] ] > round_data($val['DISPLACEMENT'], 0.0001, 100)) ? round_data($val['DISPLACEMENT'], 0.0001, 100) : $min[ $val['NUM'] ];
				$row[ $val['NUM'] ] += round_data($val['DISPLACEMENT'], 0.0001, 100);
				$row_cnt[ $val['NUM'] ] ++;
			}
		}
	}
	// $data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.2f", $sum);
}

/* for($i=0; $i<$tcnt; $i++){
	$j = ($type == "H") ? $i : $i + 1;
	$data_row['MAX'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.2f", $max[$j]);
	$data_row['MIN'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.2f", $min[$j]);
	$data_row['AVR'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.2f", $row[$j]/$row_cnt[$j]);
	if($row_cnt[$i] != 0){
		$sum_max += $data_row['MAX'][$i];
		$sum_min += $data_row['MIN'][$i];
		$sum_avr += $data_row['AVR'][$i];
		$sum_cnt ++;
	}
}
$data_row['MAX_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.2f", $sum_max);
$data_row['MIN_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.2f", $sum_min);
$data_row['AVR_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.2f", $sum_avr); */

$DB->CLOSE();
?>


