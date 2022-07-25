<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/flowInfo.php";

$rain_rtu_name = "";
$flow_rtu_name = "";
$rain_area_code = $_REQUEST['rain_area_code']; // 강우 지역 코드
$flow_area_code = $_REQUEST['flow_area_code']; // 수위 지역 코드
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

//강우
$LocalDB = new ClassRtuInfo($DB, 0);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$rain_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$rain_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	if($rain_area_code == $LocalDB->AREA_CODE[$i]){
		$rain_rtu_name = $LocalDB->RTU_NAME[$i];
	}
}
if(!$rain_area_code){
	$rain_area_code = $rain_sel[0]['AREA_CODE'];
	$rain_rtu_name = $rain_sel[0]['RTU_NAME'];
}

//강우자료
$ClassRainInfo = new ClassRainInfo($DB);

$max = array(); // 검색기간별 최고
$min = array(); // 검색기간별 최저
$row = array(); // 검색기간별 합계
$row_cnt = array(); // 검색기간별 개수

$rain_list['AREA_CODE'] = $rain_area_code;
$rain_list['RTU_NAME'] = $rain_rtu_name;

$sum = 0;
$cnt = 0;

if($type == "A"){
	$s_type = "D";
	// 시간 설정
	$t_sdate = $sdate." 00:00:00";
	$t_edate = $edate." 23:50:00";

	$ClassRainInfo->getRain10m($rain_area_code, $s_type, $t_sdate, $t_edate);

	$eedate = true;
	$tmp_sdate = $sdate;
	$j = 0;
	$tcnt = 0;
	// 배열생성
	while($eedate){
		$tmp_date = $tmp_sdate;
		$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
		$data_nums['MON'][$j] = substr($tmp_date, 5,2);
		$rain_list['LIST'][$j] = "-";

		$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
		if($tmp_sdate > $edate) $eedate = false;
		$j++;
		$tcnt ++;
	}
	if($ClassRainInfo->rsRain10m){
		foreach($ClassRainInfo->rsRain10m as $key => $val) {
			$val['NUM'] = substr($val['RAIN_DATE'], 8,2);
			for($c = 0; $c <= $j; $c++){
				if($data_nums['NUM'][$c] == $val['NUM']){
					$rain_list['LIST'][$c] = round_data($val['RAIN'], 0.01, 10);

					if($val['RAIN'] != "-"){
						$sum += round_data($val['RAIN'], 0.01, 10);
						$cnt ++;
						$max[ $c ] = ($max[ $c ] < round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $max[ $c ];
						$min[ $c ] = ($min[ $c ] > round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $min[ $c ];
						$row[ $c ] += round_data($val['RAIN'], 0.01, 10);
						$row_cnt[ $c ] ++;
					}
				}
			}
		}
	}
	$rain_list['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);		
}else{
	$ClassRainInfo->getRainRpt($rain_area_code, $type, $where_date, $ecnt);

	if($ClassRainInfo->rsRainRpt){
		foreach($ClassRainInfo->rsRainRpt as $key => $val) {
			$rain_list['LIST'][ $val['NUM'] ] = round_data($val['RAIN'], 0.01, 10);
			if($val['RAIN'] != "-"){
				$sum += round_data($val['RAIN'], 0.01, 10);
				$cnt ++;
				$max[ $val['NUM'] ] = ($max[ $val['NUM'] ] < round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $max[ $val['NUM'] ];
				$min[ $val['NUM'] ] = ($min[ $val['NUM'] ] > round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $min[ $val['NUM'] ];
				$row[ $val['NUM'] ] += round_data($val['RAIN'], 0.01, 10);
				$row_cnt[ $val['NUM'] ] ++;
			}
		}
	}
	$rain_list['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
}

//수위
$LocalDB = new ClassRtuInfo($DB, 1);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$flow_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$flow_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	if($flow_area_code == $LocalDB->AREA_CODE[$i]){
		$flow_rtu_name = $LocalDB->RTU_NAME[$i];
	}
}
if(!$flow_area_code){
	$flow_area_code = $flow_sel[0]['AREA_CODE'];
	$flow_rtu_name = $flow_sel[0]['RTU_NAME'];
}

//수위자료
$ClassFlowInfo = new ClassFlowInfo($DB);

$max = array(); // 검색기간별 최고
$min = array(); // 검색기간별 최저
$row = array(); // 검색기간별 합계
$row_cnt = array(); // 검색기간별 개수

$flow_list['AREA_CODE'] = $flow_area_code;
$flow_list['RTU_NAME'] = $flow_rtu_name;

$sum = 0;
$cnt = 0;

if($type == "A"){
	$s_type = "D";
	// 시간 설정
	$t_sdate = $sdate." 00:00:00";
	$t_edate = $edate." 23:50:00";

	$ClassFlowInfo->getFlow10m($flow_area_code, $s_type, $t_sdate, $t_edate);

	$eedate = true;
	$tmp_sdate = $sdate;
	$j = 0;
	$tcnt = 0;
	// 배열생성
	while($eedate){
		$tmp_date = $tmp_sdate;
		$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
		$data_nums['MON'][$j] = substr($tmp_date, 5,2);
		$flow_list['LIST'][$j] = "-";

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
					$flow_list['LIST'][$c] = round_data($val['FLOW'], 0.01, 10);

					if($val['FLOW'] != "-"){
						$sum += round_data($val['FLOW'], 0.01, 10);
						$cnt ++;
						$max[ $c ] = ($max[ $c ] < round_data($val['FLOW'], 0.01, 10)) ? round_data($val['FLOW'], 0.01, 10) : $max[ $c ];
						$min[ $c ] = ($min[ $c ] > round_data($val['FLOW'], 0.01, 10)) ? round_data($val['FLOW'], 0.01, 10) : $min[ $c ];
						$row[ $c ] += round_data($val['FLOW'], 0.01, 10);
						$row_cnt[ $c ] ++;
					}
				}
			}
		}
	}
	$flow_list['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);		
}else{
	$ClassFlowInfo->getFlowRpt($flow_area_code, $type, $where_date, $ecnt);

	if($ClassFlowInfo->rsFlowRpt){
		foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
			$flow_list['LIST'][ $val['NUM'] ] = round_data($val['FLOW'], 0.01, 100);
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
	$flow_list['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
}

$DB->CLOSE();
?>


