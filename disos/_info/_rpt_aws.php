<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/rainInfo.php";
require_once "../include/class/awsInfo.php";

$option = $_REQUEST['option'] ? $_REQUEST['option'] : "0"; // 구분
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

//aws
$LocalDB = new ClassRtuInfo($DB, 3);
$LocalDB->getRtuInfo();

for($i=0; $i<$LocalDB->rsCnt; $i++) {
	$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
}
if(!$area_code) $area_code = $data_sel[0]['AREA_CODE'];

//강우자료
$ClassRainInfo = new ClassRainInfo($DB);
//aws자료
$ClassAwsInfo = new ClassAwsInfo($DB);

$max = array(); // 검색기간별 최고
$min = array(); // 검색기간별 최저
$row = array(); // 검색기간별 합계
$row_cnt = array(); // 검색기간별 개수
$sum_max = 0; // 최고 누계
$sum_min = 0; // 최저 누계
$sum_avr = 0; // 평균 누계
$sum_cnt = 0; // 검색기간별 누계 개수

if($option == "0"){
	$chart_data = "rain";
	$chart_name = "강우";
	
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
				$data_list[$i]['RAIN'][$j] = "-";

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
							$data_list[$i]['RAIN'][$c] = round_data($val['RAIN'], 0.01, 10);

							if($val['RAIN'] != "-"){
								$sum += round_data($val['RAIN'], 0.01, 10);
								$cnt ++;
								$max[ $c ] = ($max[ $c ]) ? ( ($max[ $c ] < round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $max[ $c ] ) : round_data($val['RAIN'], 0.01, 10);
								$min[ $c ] = ($min[ $c ]) ? ( ($min[ $c ] > round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $min[ $c ] ) : round_data($val['RAIN'], 0.01, 10);
								$row[ $c ] += round_data($val['RAIN'], 0.01, 10);
								$row_cnt[ $c ] = $LocalDB->rsCnt;
							}
						}
					}
				}
			}
			$data_list[$i]['RAIN_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);	
		}else{
			$ClassRainInfo->getRainRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassRainInfo->rsRainRpt){
				foreach($ClassRainInfo->rsRainRpt as $key => $val) {
					$data_list[$i]['RAIN'][ $val['NUM'] ] = round_data($val['RAIN'], 0.01, 10);
					if($val['RAIN'] != "-"){
						$sum += round_data($val['RAIN'], 0.01, 10);
						$cnt ++;
						$max[ $val['NUM'] ] = ($max[ $val['NUM'] ]) ? ( ($max[ $val['NUM'] ] < round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $max[ $val['NUM'] ] ) : round_data($val['RAIN'], 0.01, 10);
						$min[ $val['NUM'] ] = ($min[ $val['NUM'] ]) ? ( ($min[ $val['NUM'] ] > round_data($val['RAIN'], 0.01, 10)) ? round_data($val['RAIN'], 0.01, 10) : $min[ $val['NUM'] ] ) : round_data($val['RAIN'], 0.01, 10);					$row[ $val['NUM'] ] += round_data($val['RAIN'], 0.01, 10);
					}
					$row_cnt[ $val['NUM'] ] ++;
				}
			}
			$data_list[$i]['RAIN_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		}
	}
	// 최고, 최저, 평균
	for($i=0; $i<$tcnt; $i++){
		$j = ($type == "H" || $type == "A") ? $i : $i + 1;
		$data_row['MAX'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.1f", $max[$j]);
		$data_row['MIN'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.1f", $min[$j]);
		$data_row['AVR'][$i] = ($row_cnt[$j] == 0) ? "-" : sprintf("%.1f", $row[$j]/$row_cnt[$j]);
		if($row_cnt[$i] != 0){
			$sum_max += $data_row['MAX'][$i];
			$sum_min += $data_row['MIN'][$i];
			$sum_avr += $data_row['AVR'][$i];
			$sum_cnt ++;
		}
	}
	$data_row['MAX_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.1f", $sum_max);
	$data_row['MIN_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.1f", $sum_min);
	$data_row['AVR_SUM'] = ($sum_cnt == 0) ? "-" : sprintf("%.1f", $sum_avr);

}else if($option == "1"){
	$chart_data = "temp";
	$chart_name = "온도";
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$cnt = 0;
		$sum_max = 0;
		$sum_min = 0;
		$cnt_max = 0;
		$cnt_min = 0;
		
		if($type == "A"){
			$s_type = "D";
			// 시간 설정
			$t_sdate = $sdate." 00:00:00";
			$t_edate = $edate." 23:50:00";
	
			$ClassAwsInfo->getTemp10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['TEMP'][$j] = "-";
				$data_list[$i]['TEMP_MAX'][$j] = "-";
				$data_list[$i]['TEMP_MIN'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsTemp10m){
				foreach($ClassAwsInfo->rsTemp10m as $key => $val) {
					$val['NUM'] = substr($val['TEMP_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['TEMP'][$c] = round_data($val['TEMP'], 0.01, 10);
							$data_list[$i]['TEMP_MAX'][ $c ] = round_data($val['TEMP_MAX'], 0.01, 10);
							$data_list[$i]['TEMP_MIN'][ $c ] = round_data($val['TEMP_MIN'], 0.01, 10);
	
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
				}
			}
		}else{
			$ClassAwsInfo->getTempRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassAwsInfo->rsTempRpt){
				foreach($ClassAwsInfo->rsTempRpt as $key => $val) {
					$data_list[$i]['TEMP'][ $val['NUM'] ] = round_data($val['TEMP'], 0.01, 10);
					$data_list[$i]['TEMP_MAX'][ $val['NUM'] ] = round_data($val['TEMP_MAX'], 0.01, 10);
					$data_list[$i]['TEMP_MIN'][ $val['NUM'] ] = round_data($val['TEMP_MIN'], 0.01, 10);
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
		}
		$data_list[$i]['TEMP_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		$data_list[$i]['TEMP_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
		$data_list[$i]['TEMP_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
		$data_list[$i]['TEMP_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
		$data_list[$i]['TEMP_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
		$data_list[$i]['TEMP_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);
	}
		
}else if($option == "2"){
	$chart_data = "wind";
	$chart_name = "풍속";
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum_vel = 0;
		$sum_vel_max = 0;
		$sum_deg = 0;
		$sum_deg_max = 0;
		$cnt_vel = 0;
		$cnt_vel_max = 0;
		$cnt_deg = 0;
		$cnt_deg_max = 0;
		
		if($type == "A"){
			$s_type = "D";
			// 시간 설정
			$t_sdate = $sdate." 00:00:00";
			$t_edate = $edate." 23:50:00";
	
			$ClassAwsInfo->getWind10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['VEL'][$j] = "-";
				$data_list[$i]['VEL_MAX'][$j] = "-";
				$data_list[$i]['DEG'][$j] = "-";
				$data_list[$i]['DEG_MAX'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsWind10m){
				foreach($ClassAwsInfo->rsWind10m as $key => $val) {
					$val['NUM'] = substr($val['WIND_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['VEL'][$c] = round_data($val['VEL'], 0.01, 10);
							$data_list[$i]['VEL_MAX'][ $c ] = round_data($val['VEL_MAX'], 0.01, 10);
							$data_list[$i]['DEG'][$c] = $val['DEG'];
							$data_list[$i]['DEG_MAX'][ $c ] = $val['DEG_MAX'];
	
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
				}
			}
		}else{
			$ClassAwsInfo->getWindRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
				
			if($ClassAwsInfo->rsWindRpt){
				foreach($ClassAwsInfo->rsWindRpt as $key => $val) {
					$data_list[$i]['VEL'][ $val['NUM'] ] = round_data($val['VEL'], 0.01, 10);
					$data_list[$i]['VEL_MAX'][ $val['NUM'] ] = round_data($val['VEL_MAX'], 0.01, 10);
					$data_list[$i]['DEG'][ $val['NUM'] ] = $val['DEG'];
					$data_list[$i]['DEG_MAX'][ $val['NUM'] ] = $val['DEG_MAX'];
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
		}
		
		$data_list[$i]['VEL_SUM'] = ($cnt_vel == 0) ? "-" : sprintf("%.1f", $sum_vel);
		$data_list[$i]['VEL_AVR'] = ($cnt_vel == 0) ? "-" : sprintf("%.1f", $sum_vel/$cnt_vel);
		$data_list[$i]['VEL_MAX_SUM'] = ($cnt_vel_max == 0) ? "-" : sprintf("%.1f", $sum_vel_max);
		$data_list[$i]['VEL_MAX_AVR'] = ($cnt_vel_max == 0) ? "-" : sprintf("%.1f", $sum_vel_max/$cnt_vel_max);
		$data_list[$i]['DEG_SUM'] = ($cnt_deg == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg);
		$data_list[$i]['DEG_AVR'] = ($cnt_deg == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg/$cnt_deg);
		$data_list[$i]['DEG_MAX_SUM'] = ($cnt_deg_max == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg_max);
		$data_list[$i]['DEG_MAX_AVR'] = ($cnt_deg_max == 0) ? "-" : $ClassAwsInfo->getDegreeString($sum_deg_max/$cnt_deg_max);
	}
	
}else if($option == "3"){
	$chart_data = "atmo";
	$chart_name = "기압";
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$sum_max = 0;
		$sum_min = 0;
		$cnt = 0;
		$cnt_max = 0;
		$cnt_min = 0;
		
		if($type == "A"){
			$s_type = "D";
			// 시간 설정
			$t_sdate = $sdate." 00:00:00";
			$t_edate = $edate." 23:50:00";
	
			$ClassAwsInfo->getAtmo10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['ATMO'][$j] = "-";
				$data_list[$i]['ATMO_MAX'][$j] = "-";
				$data_list[$i]['ATMO_MIN'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsAtmo10m){
				foreach($ClassAwsInfo->rsAtmo10m as $key => $val) {
					$val['NUM'] = substr($val['ATMO_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['ATMO'][$c] = round_data($val['ATMO'], 0.01, 10);
							$data_list[$i]['ATMO_MAX'][ $c ] = round_data($val['ATMO_MAX'], 0.01, 10);
							$data_list[$i]['ATMO_MIN'][ $c ] = round_data($val['ATMO_MIN'], 0.01, 10);
					
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
						}
			}
		}else{
			$ClassAwsInfo->getAtmoRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassAwsInfo->rsAtmoRpt){
				foreach($ClassAwsInfo->rsAtmoRpt as $key => $val) {
					$data_list[$i]['ATMO'][ $val['NUM'] ] = round_data($val['ATMO'], 0.01, 10);
					$data_list[$i]['ATMO_MAX'][ $val['NUM'] ] = round_data($val['ATMO_MAX'], 0.01, 10);
					$data_list[$i]['ATMO_MIN'][ $val['NUM'] ] = round_data($val['ATMO_MIN'], 0.01, 10);
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
		}
		$data_list[$i]['ATMO_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		$data_list[$i]['ATMO_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
		$data_list[$i]['ATMO_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
		$data_list[$i]['ATMO_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
		$data_list[$i]['ATMO_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
		$data_list[$i]['ATMO_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);
	}
	
}else if($option == "4"){
	$chart_data = "humi";
	$chart_name = "습도";
	
	for($i=0; $i<$LocalDB->rsCnt; $i++){
		
		$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
		$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		
		$sum = 0;
		$sum_max = 0;
		$sum_min = 0;
		$cnt = 0;
		$cnt_max = 0;
		$cnt_min = 0;
		
		if($type == "A"){
			$s_type = "D";
			// 시간 설정
			$t_sdate = $sdate." 00:00:00";
			$t_edate = $edate." 23:50:00";
	
			$ClassAwsInfo->getHumi10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['HUMI'][$j] = "-";
				$data_list[$i]['HUMI_MAX'][$j] = "-";
				$data_list[$i]['HUMI_MIN'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsHumi10m){
				foreach($ClassAwsInfo->rsHumi10m as $key => $val) {
					$val['NUM'] = substr($val['HUMI_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['HUMI'][$c] = round_data($val['HUMI'], 0.01, 10);
							$data_list[$i]['HUMI_MAX'][ $c ] = round_data($val['HUMI_MAX'], 0.01, 10);
							$data_list[$i]['HUMI_MIN'][ $c ] = round_data($val['HUMI_MIN'], 0.01, 10);
	
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
				}
			}
		}else{
			$ClassAwsInfo->getHumiRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassAwsInfo->rsHumiRpt){
				foreach($ClassAwsInfo->rsHumiRpt as $key => $val) {
					$data_list[$i]['HUMI'][ $val['NUM'] ] = round_data($val['HUMI'], 0.01, 10);
					$data_list[$i]['HUMI_MAX'][ $val['NUM'] ] = round_data($val['HUMI_MAX'], 0.01, 10);
					$data_list[$i]['HUMI_MIN'][ $val['NUM'] ] = round_data($val['HUMI_MIN'], 0.01, 10);
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
		}
		$data_list[$i]['HUMI_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		$data_list[$i]['HUMI_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
		$data_list[$i]['HUMI_MAX_SUM'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max);
		$data_list[$i]['HUMI_MAX_AVR'] = ($cnt_max == 0) ? "-" : sprintf("%.1f", $sum_max/$cnt_max);
		$data_list[$i]['HUMI_MIN_SUM'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min);
		$data_list[$i]['HUMI_MIN_AVR'] = ($cnt_min == 0) ? "-" : sprintf("%.1f", $sum_min/$cnt_min);
	}
	
}else if($option == "5"){
	$chart_data = "radi";
	$chart_name = "일사";
	
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
	
			$ClassAwsInfo->getRadi10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['RADI'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsRadi10m){
				foreach($ClassAwsInfo->rsRadi10m as $key => $val) {
					$val['NUM'] = substr($val['RADI_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['RADI'][$c] = round_data($val['RADI'], 0.01, 10);
	
							if($val['RADI'] != "-"){
								$sum += round_data($val['RADI'], 0.01, 10);
								$cnt ++;
							}
						}
					}
				}
			}
		}else{
			$ClassAwsInfo->getRadiRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);
			
			if($ClassAwsInfo->rsRadiRpt){
				foreach($ClassAwsInfo->rsRadiRpt as $key => $val) {
					$data_list[$i]['RADI'][ $val['NUM'] ] = round_data($val['RADI'], 0.01, 10);
					if($val['RADI'] != "-"){
						$sum += round_data($val['RADI'], 0.01, 10);
						$cnt ++;
					}
				}
			}
		}
		$data_list[$i]['RADI_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		$data_list[$i]['RADI_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
	}
	
}else if($option == "6"){
	$chart_data = "suns";
	$chart_name = "일조";
	
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
	
			$ClassAwsInfo->getSuns10m($LocalDB->AREA_CODE[$i], $s_type, $t_sdate, $t_edate);
	
			$eedate = true;
			$tmp_sdate = $sdate;
			$j = 0;
			$tcnt = 0;
			// 배열생성
			while($eedate){
				$tmp_date = $tmp_sdate;
				$data_nums['NUM'][$j] = substr($tmp_date, 8,2);
				$data_nums['MON'][$j] = substr($tmp_date, 5,2);
				$data_list[$i]['SUNS'][$j] = "-";
	
				$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
				if($tmp_sdate > $edate) $eedate = false;
				$j++;
				$tcnt ++;
			}
	
			if($ClassAwsInfo->rsSuns10m){
				foreach($ClassAwsInfo->rsSuns10m as $key => $val) {
					$val['NUM'] = substr($val['SUNS_DATE'], 8,2);
					for($c = 0; $c <= $j; $c++){
						if($data_nums['NUM'][$c] == $val['NUM']){
							$data_list[$i]['SUNS'][$c] = round_data($val['SUNS'], 0.01, 10);
	
							if($val['SUNS'] != "-"){
								$sum += round_data($val['SUNS'], 0.01, 10);
								$cnt ++;
							}
						}
					}
				}
			}
		}else{
			$ClassAwsInfo->getSunsRpt($LocalDB->AREA_CODE[$i], $type, $where_date, $ecnt);

			if($ClassAwsInfo->rsSunsRpt){
				foreach($ClassAwsInfo->rsSunsRpt as $key => $val) {
					$data_list[$i]['SUNS'][ $val['NUM'] ] = round_data($val['SUNS'], 0.01, 10);
					if($val['SUNS'] != "-"){
						$sum += round_data($val['SUNS'], 0.01, 10);
						$cnt ++;
					}
				}
			}
		}
		$data_list[$i]['SUNS_SUM'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum);
		$data_list[$i]['SUNS_AVR'] = ($cnt == 0) ? "-" : sprintf("%.1f", $sum/$cnt);
	}
}

$DB->CLOSE();
?>


