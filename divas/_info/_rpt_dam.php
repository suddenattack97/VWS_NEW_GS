<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/DamInfo.php";

$area_code = $_REQUEST['area_code']; // 지역 코드
$type = $_REQUEST['sel_date'] ? $_REQUEST['sel_date'] : "H"; // 검색기간
$sel_date = $_REQUEST['sel_date'] ? $_REQUEST['sel_date'] : "H"; // 검색기간
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 끝 날짜
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

//수위
$LocalDB = new ClassRtuInfo($DB, 4);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

//수위자료
$ClassDamInfo = new ClassDamInfo($DB);

$max = array(); // 검색기간별 최고
$min = array(); // 검색기간별 최저
$row = array(); // 검색기간별 합계
$row_cnt = array(); // 검색기간별 개수
$sum_max = 0; // 최고 누계
$sum_min = 0; // 최저 누계
$sum_avr = 0; // 평균 누계
$sum_cnt = 0; // 검색기간별 누계 개수

for($i=0; $i<$LocalDB->rsCnt; $i++){
	
	$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	$sum = 0;
	$cnt = 0;
	
	if($type == "A"){
		$s_type = "D";
		// 시간 설정
		$t_sdate = $sdate." 00:00:00";
		$t_edate = $edate." 23:50:00";

		$ClassDamInfo->getDam10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);

		$eedate = true;
		$tmp_sdate = $sdate;
		$j = 0;
		$tcnt = 0;
		// 배열생성
		while($eedate){
			$tmp_date = $tmp_sdate;
			$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
			$data_nums['MON'][$j] = substr($tmp_date, 5,2);
			$data_list[$i]['LIST'][$j] = "-";

			$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
			if($tmp_sdate > $edate) $eedate = false;
			$j++;
			$tcnt ++;
		}

		if($ClassFlowInfo->rsFlow10m){
			foreach($ClassFlowInfo->rsFlow10m as $key => $val) {
				$val['NUM'] = substr($val['FLOW_DATE'], 8,2);
				for($c = 0; $c <= $j; $c++){
					if($data_nums['NUM'][$c] == $val['NUM']){
						$data_list[$i]['LIST'][$c] = round_data($val['FLOW'], 0.01, 100);

						if($val['FLOW'] != "-"){
							$sum += round_data($val['FLOW'], 0.01, 100);
							$cnt ++;
							$max[ $c ] = ($max[ $c ] < round_data($val['FLOW'], 0.01, 100)) ? round_data($val['FLOW'], 0.01, 100) : $max[ $c ];
							$min[ $c ] = ($min[ $c ] > round_data($val['FLOW'], 0.01, 100)) ? round_data($val['FLOW'], 0.01, 100) : $min[ $c ];
							$row[ $c ] += round_data($val['FLOW'], 0.01, 100);
							$row_cnt[ $c ] ++;
						}
					}
				}
			}
		}
		$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);		
	}else{
		$ClassFlowInfo->getFlowRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
	
		if($ClassFlowInfo->rsFlowRpt){
			foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
				$data_list[$i]['LIST'][ $val['NUM'] ] = round_data($val['FLOW'], 0.01, 100);
				if($val['FLOW'] != "-"){
					$sum += round_data($val['FLOW'], 0.01, 100);
					$cnt ++;
					$max[ $val['NUM'] ] = ($max[ $val['NUM'] ] < round_data($val['FLOW'], 0.01, 100)) ? round_data($val['FLOW'], 0.01, 100) : $max[ $val['NUM'] ];
					$min[ $val['NUM'] ] = ($min[ $val['NUM'] ] > round_data($val['FLOW'], 0.01, 100)) ? round_data($val['FLOW'], 0.01, 100) : $min[ $val['NUM'] ];
					$row[ $val['NUM'] ] += round_data($val['FLOW'], 0.01, 100);
					$row_cnt[ $val['NUM'] ] ++;
				}
			}
		}
		$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.2f", $sum);
	}
}

for($i=0; $i<$tcnt; $i++){
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
$data_row['AVR_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.2f", $sum_avr);

$DB->CLOSE();
?>


