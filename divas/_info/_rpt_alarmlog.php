<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/broadcast.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/flowInfo.php";
require_once "../include/class/dispInfo.php";

$REPORT_TYPE = $_REQUEST['REPORT_TYPE'] ? $_REQUEST['REPORT_TYPE'] : "1"; // 구분
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
	$isdate = $sdate." 00:00:00";
	$iedate = $sdate." 23:59:59";
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
	$isdate = $yy."-".$mm."-01 00:00:00";
	$iedate = $yy."-".$mm."-".$ecnt." 23:59:59";
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
	$isdate = $yy."-01-01 00:00:00";
	$iedate = $yy."-12-31 23:59:59";
	for($i=$scnt; $i<=$ecnt; $i++){
		if($i != $scnt) $where_date .= " , ";
		if($i < 10){
			$where_date .= " '".$yy."-0".$i."-01 00:00:00' ";
		}else{
			$where_date .= " '".$yy."-".$i."-01 00:00:00' ";
		}
	}
}else if($type == "A"){
	$s_type = "D";
	// 시간 설정
	$t_sdate = $sdate." 00:00:00";
	$t_edate = $edate." 23:50:00";
}

if($REPORT_TYPE == "0"){
	//강우
	$LocalDB = new ClassRtuInfo($DB, 0);
	$LocalDB->getRtuInfo();
	
	//강우자료
	$ClassRainInfo = new ClassRainInfo($DB);
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$cnt = 0;
		
		if($type == "A"){

			$ClassRainInfo->getRain10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);

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
			if($ClassRainInfo->rsRain10m){
				foreach($ClassRainInfo->rsRain10m as $key => $val) {
					$val['NUM'] = substr($val['RAIN_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['LIST'][$c] = round_data($val['RAIN'], 0.01, 10);

							if($val['RAIN'] != "-"){
								$sum += round_data($val['RAIN'], 0.01, 10);
								$cnt ++;
							}
						}
					}
				}
			}
			$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);		
		}else{
			$ClassRainInfo->getRainRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassRainInfo->rsRainRpt){
				foreach($ClassRainInfo->rsRainRpt as $key => $val) {
					$data_list[$i]['LIST'][ $val['NUM'] ] = round_data($val['RAIN'], 0.01, 10);
					if($val['RAIN'] != "-"){
						$sum += round_data($val['RAIN'], 0.01, 10);
						$cnt ++;
					}
				}
			}
			$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		}
	}
	
	$tmp_cnt = $i;
	
	//수위
	$LocalDB = new ClassRtuInfo($DB, 1);
	$LocalDB->getRtuInfo();
	
	//수위자료
	$ClassFlowInfo = new ClassFlowInfo($DB);
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i + $tmp_cnt]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i + $tmp_cnt]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$cnt = 0;
		
		if($type == "A"){
	
			$ClassFlowInfo->getFlow10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i + $tmp_cnt]['LIST'][$j] = "-";
	
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
							$data_list[$i + $tmp_cnt]['LIST'][$c] = round_data($val['FLOW'], 0.01, 10);
	
							if($val['FLOW'] != "-"){
								$sum += round_data($val['FLOW'], 0.01, 10);
								$cnt ++;
							}
						}
					}
				}
			}
			$data_list[$i + $tmp_cnt]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);		
		}else{
			$ClassFlowInfo->getFlowRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassFlowInfo->rsFlowRpt){
				foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
					$data_list[$i + $tmp_cnt]['LIST'][ $val['NUM'] ] = round_data($val['FLOW'], 0.01, 100);
					if($val['FLOW'] != "-"){
						$sum += round_data($val['FLOW'], 0.01, 100);
						$cnt ++;
					}
				}
			}
			$data_list[$i + $tmp_cnt]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		}
	}

	$tmp_cnt2 = $i + $tmp_cnt;

	//변위 - 수정 할 것!
	$LocalDB = new ClassRtuInfo($DB, 4);
	$LocalDB->getDispRtuInfo();

	for($i=0; $i<$LocalDB->rsCnt; $i++) {
		$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
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
		$ClassDispInfo->getDispRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
		
		$data_list[$i + $tmp_cnt2]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i + $tmp_cnt2]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$cnt = 0;
		if($ClassDispInfo->rsDispRpt){
			foreach($ClassDispInfo->rsDispRpt as $key => $val) {
				$data_list[$i + $tmp_cnt2]['LIST'][ $val['NUM'] ] = round_data($val['DISPLACEMENT'], 0.0001, 100);
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
		$data_list[$i + $tmp_cnt2]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
	}
	
	//방송
	$ClassBroadCast = new ClassBroadCast($DB);
	
	//경보자료
	if($type == "A"){

		$eedate = true;
		$tmp_sdate = $sdate;
		$j = 0;
		// 배열생성
		while($eedate){
			$tmp_date = $tmp_sdate;
			$data_alert['1step'][$j]['NUM'] = substr($tmp_date, 8,2);
			$data_alert['1step'][$j]['CNT'] = 0;
			$data_alert['2step'][$j]['NUM'] = substr($tmp_date, 8,2);
			$data_alert['2step'][$j]['CNT'] = 0;
			if(level_cnt == 3){
				$data_alert['3step'][$j]['NUM'] = substr($tmp_date, 8,2);
				$data_alert['3step'][$j]['CNT'] = 0;
			}else if(level_cnt == 5){
				$data_alert['3step'][$j]['NUM'] = substr($tmp_date, 8,2);
				$data_alert['3step'][$j]['CNT'] = 0;
				$data_alert['4step'][$j]['NUM'] = substr($tmp_date, 8,2);
				$data_alert['4step'][$j]['CNT'] = 0;
				$data_alert['5step'][$j]['NUM'] = substr($tmp_date, 8,2);
				$data_alert['5step'][$j]['CNT'] = 0;
			}

			$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
			if($tmp_sdate > $edate) $eedate = false;
			$j++;
		}
		$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 1);
		if($ClassBroadCast->rsAlertCntTerm){
			foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
				for($c = 0; $c <= $j; $c++){
					if($data_alert['1step'][$c]['NUM'] == $val['NUM']){
						$data_alert['1step'][$c]['CNT'] = $val['CNT'];
					}
				}
			}
		}
		$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 2);
		if($ClassBroadCast->rsAlertCntTerm){
			foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
				for($c = 0; $c <= $j; $c++){
					if($data_alert['2step'][$c]['NUM'] == $val['NUM']){
						$data_alert['2step'][$c]['CNT'] = $val['CNT'];
					}
				}
			}
		}
		if(level_cnt == 3){
			$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 3);
			if($ClassBroadCast->rsAlertCntTerm){
				foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
					for($c = 0; $c <= $j; $c++){
						if($data_alert['3step'][$c]['NUM'] == $val['NUM']){
							$data_alert['3step'][$c]['CNT'] = $val['CNT'];
						}
					}
				}
			}
		}else if(level_cnt == 5){
			$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 3);
			if($ClassBroadCast->rsAlertCntTerm){
				foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
					for($c = 0; $c <= $j; $c++){
						if($data_alert['3step'][$c]['NUM'] == $val['NUM']){
							$data_alert['3step'][$c]['CNT'] = $val['CNT'];
						}
					}
				}
			}
			$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 4);
			if($ClassBroadCast->rsAlertCntTerm){
				foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
					for($c = 0; $c <= $j; $c++){
						if($data_alert['4step'][$c]['NUM'] == $val['NUM']){
							$data_alert['4step'][$c]['CNT'] = $val['CNT'];
						}
					}
				}
			}
			$ClassBroadCast->getAlertCntTerm($t_sdate, $t_edate, $s_type, 5);
			if($ClassBroadCast->rsAlertCntTerm){
				foreach($ClassBroadCast->rsAlertCntTerm as $key => $val) {
					for($c = 0; $c <= $j; $c++){
						if($data_alert['5step'][$c]['NUM'] == $val['NUM']){
							$data_alert['5step'][$c]['CNT'] = $val['CNT'];
						}
					}
				}
			}
		}
	}else{
		$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 1);
		$data_alert['1step'] = $ClassBroadCast->rsAlertCnt;
		$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 2);
		$data_alert['2step']= $ClassBroadCast->rsAlertCnt;
		if(level_cnt == 3){
			$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 3);
			$data_alert['3step']= $ClassBroadCast->rsAlertCnt;
		}else if(level_cnt == 4){
			$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 3);
			$data_alert['3step']= $ClassBroadCast->rsAlertCnt;
		}else if(level_cnt == 5){
			$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 3);
			$data_alert['3step']= $ClassBroadCast->rsAlertCnt;
			$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 4);
			$data_alert['4step']= $ClassBroadCast->rsAlertCnt;
			$ClassBroadCast->getAlertCnt($isdate, $iedate, $type, 5);
			$data_alert['5step']= $ClassBroadCast->rsAlertCnt;
		}
	}
	
}else if($REPORT_TYPE == "1"){
	//방송
	$ClassBroadCast = new ClassBroadCast($DB);
	
	//경보자료
	if($type == "A"){
		$ClassBroadCast->getAlertList($t_sdate, $t_edate);
		$data_alert = $ClassBroadCast->rsAlertList;
	}else{
		$ClassBroadCast->getAlertList($isdate, $iedate);
		$data_alert = $ClassBroadCast->rsAlertList;
	}

	// 방송송출여부 -> 매칭 안됨
	// $ClassBroadCast->getBroadCastResult($isdate, $iedate);
	// $data_alarm = $ClassBroadCast->rsBroadCastList;
	
}

$DB->CLOSE();
?>


