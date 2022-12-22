<?
require_once "../../_conf/_common.php";

require_once "../../include/class/rtuInfo.php";
require_once "../../include/class/rainInfo.php";
require_once "../../include/class/flowInfo.php";
require_once "../../include/class/awsInfo.php";
require_once "../../include/class/snowInfo.php";
// require_once "../../include/class/dispInfo.php";
// require_once "../../include/class/broadcast.php";

$mode = $_REQUEST["mode"];
$area_code = $_REQUEST['area_code']; // 지역 코드
$type = $_REQUEST['type'] ? $_REQUEST['type'] : "H"; // 검색기간
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

$yy = substr($sdate, 0, 4);
$mm = substr($sdate, 5, 2);
$dd = substr($sdate, 8, 2);

$t_sdate = $sdate." 00:00:00";
$t_edate = $edate." 23:50:00";
if($type == 'S'){
	$t_sdate = $sTdate.":00:00";
	$t_edate = $eTdate.":59:00";
}else{
	$t_sdate = $sdate." 00:00:00";
	$t_edate = $edate." 23:50:00";
}

if($sdate == "graph"){
	$where_date = "graph";
}else{
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
}


switch($mode){
	// 비교 그래프
	case 'mix':
		// 그래프 호출
		$rain_area_code = $_REQUEST['rain_area_code']; // 강우 지역 코드
		$flow_area_code = $_REQUEST['flow_area_code']; // 수위 지역 코드
		
		$ClassRainInfo = new ClassRainInfo($DB);
		$ClassRainInfo->getRainRpt($rain_area_code, $type, $where_date, $ecnt);
		
		$ClassFlowInfo = new ClassFlowInfo($DB);
		$ClassFlowInfo->getFlowRpt($flow_area_code, $type, $where_date, $ecnt);
		
		for($i=$scnt; $i<=$ecnt; $i++){
			$chart_list['LEG'][] = $i;
		}
		$chart_list['RAIN_MAX'] = null; // 강우 최고
		$chart_list['RAIN_MIN'] = null; // 강우 최저
		$chart_list['FLOW_MAX'] = null; // 수위 최고
		$chart_list['FLOW_MIN'] = null; // 수위 최저
		
		if($ClassRainInfo->rsRainRpt){
			foreach($ClassRainInfo->rsRainRpt as $key => $val){
				$chart_list['DATA']['RAIN'][] = (round_data($val['RAIN'], 0.01, 10) == "-") ? null : round_data($val['RAIN'], 0.01, 10);
				if(round_data($val['RAIN'], 0.01, 10) != "-"){
					$chart_list['RAIN_MAX'] = ($chart_list['RAIN_MAX'] < round_data($val['RAIN'], 0.01, 10) || !$chart_list['RAIN_MAX']) ? round_data($val['RAIN'], 0.01, 10) : $chart_list['RAIN_MAX'];
					$chart_list['RAIN_MIN'] = ($chart_list['RAIN_MIN'] > round_data($val['RAIN'], 0.01, 10) || !$chart_list['RAIN_MIN']) ? round_data($val['RAIN'], 0.01, 10) : $chart_list['RAIN_MIN'];
				}
			}
		}
		if($ClassFlowInfo->rsFlowRpt){
			foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
				$chart_list['DATA']['FLOW'][] = (round_data($val['FLOW'], 0.01, 100) == "-") ? null : round_data($val['FLOW'], 0.01, 100);
				if(round_data($val['FLOW'], 0.01, 100) != "-"){
					$chart_list['FLOW_MAX'] = ($chart_list['FLOW_MAX'] < round_data($val['FLOW'], 0.01, 100) || !$chart_list['FLOW_MAX']) ? round_data($val['FLOW'], 0.01, 100) : $chart_list['FLOW_MAX'];
					$chart_list['FLOW_MIN'] = ($chart_list['FLOW_MIN'] > round_data($val['FLOW'], 0.01, 100) || !$chart_list['FLOW_MIN']) ? round_data($val['FLOW'], 0.01, 100) : $chart_list['FLOW_MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $chart_list );
		echo json_encode( $returnBody );
	break;
		
	// 비교 그래프
	case 'mix_term':
		// 그래프 호출
		$rain_area_code = $_REQUEST['rain_area_code']; // 강우 지역 코드
		$flow_area_code = $_REQUEST['flow_area_code']; // 수위 지역 코드
		
		// 시간 설정
		$t_sdate = $sdate." 00:00:00";
		$t_edate = $edate." 23:50:00";

		$ClassRainInfo = new ClassRainInfo($DB);
		$ClassFlowInfo = new ClassFlowInfo($DB);

		//강우
		$LocalDB = new ClassRtuInfo($DB, 0);
		$LocalDB->getRtuInfo($rain_area_code);

		$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		
		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저

		$ClassRainInfo->getRain10m($rain_area_code, $type, $t_sdate, $t_edate);

		if($ClassRainInfo->rsRain10m){
			$i = 0;
			foreach($data_list as $key2 => $val2){
				foreach($ClassRainInfo->rsRain10m as $key => $val){
					$sub_date = substr($val['RAIN_DATE'], 8,2);
					if($data_list[ $i ]['LEG'] == $sub_date){
						$data_list[ $i ]['DATA'] = round_data($val['RAIN'], 0.01, 10);
					};
					if($val['RAIN'] != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['RAIN'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['RAIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MIN'];
					}
				}
				$i++;
			}
		}
		
		//수위
		$LocalDB = new ClassRtuInfo($DB, 1);
		$LocalDB->getRtuInfo($flow_area_code);

		$area_data2['RISK_1'] = ($LocalDB->FLOW_LEVEL1[0] == 0) ? null : $LocalDB->FLOW_LEVEL1[0];
		$area_data2['RISK_2'] = ($LocalDB->FLOW_LEVEL2[0] == 0) ? null : $LocalDB->FLOW_LEVEL2[0];
		$area_data2['RISK_3'] = ($LocalDB->FLOW_LEVEL3[0] == 0) ? null : $LocalDB->FLOW_LEVEL3[0];
		$area_data2['RISK_4'] = ($LocalDB->FLOW_LEVEL4[0] == 0) ? null : $LocalDB->FLOW_LEVEL4[0];
		$area_data2['RISK_5'] = ($LocalDB->FLOW_LEVEL5[0] == 0) ? null : $LocalDB->FLOW_LEVEL5[0];
			
		$data_list2 = getDateAndArrayD($sdate, $edate, $area_data2);

		$ClassFlowInfo->getFlow10m($flow_area_code, $type, $t_sdate, $t_edate);

		$area_data2['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data2['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data2['MAX'] = null; // 최고
		$area_data2['MIN'] = null; // 최저
		
		if($ClassFlowInfo->rsFlow10m){
			$i = 0;
			foreach($data_list2 as $key2 => $val2){
				foreach($ClassFlowInfo->rsFlow10m as $key => $val){
					$sub_date = substr($val['FLOW_DATE'], 8,2);
					if($data_list2[ $i ]['LEG'] == $sub_date){
						$data_list2[ $i ]['DATA'] = round_data($val['FLOW'], 0.01, 10);
					};
					if($val['FLOW'] != "-"){
						$area_data2['MAX'] = ($area_data2['MAX'] < round_data($val['FLOW'], 0.01, 10) || !$area_data2['MAX']) ? round_data($val['FLOW'], 0.01, 10) : $area_data2['MAX'];
						$area_data2['MIN'] = ($area_data2['MIN'] > round_data($val['FLOW'], 0.01, 10) || !$area_data2['MIN']) ? round_data($val['FLOW'], 0.01, 10) : $area_data2['MIN'];
					}
				}
				$i++;
			}
		}

		$returnBody = array( 'list' => $data_list, 'area' => $area_data, 'list2' => $data_list2, 'area2' => $area_data2 );
		echo json_encode( $returnBody );
	break;
		
	// 강우 그래프
	case 'rain':
		//강우
		$LocalDB = new ClassRtuInfo($DB, 0);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassRainInfo = new ClassRainInfo($DB);
		
		$ClassRainInfo->getRainRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassRainInfo->rsRainRpt){
			foreach($ClassRainInfo->rsRainRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['RAIN'], 0.01, 10) == "-") ? null : round_data($val['RAIN'], 0.01, 10);
				if(round_data($val['RAIN'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['RAIN'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['RAIN'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['RAIN'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['RAIN'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
			
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 수위 그래프
	case 'flow':
		//수위
		$LocalDB = new ClassRtuInfo($DB, 1);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassFlowInfo = new ClassFlowInfo($DB);
		
		$ClassFlowInfo->getFlowRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		$data_list['RISK_1'] = ($LocalDB->FLOW_WARNING[0] == 0) ? null : $LocalDB->FLOW_WARNING[0];
		$data_list['RISK_2'] = ($LocalDB->FLOW_DANGER[0] == 0) ? null : $LocalDB->FLOW_DANGER[0];
		
		if($ClassFlowInfo->rsFlowRpt){
			foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['FLOW'], 0.01, 100) == "-") ? null : round_data($val['FLOW'], 0.01, 100);
				$data_list['DATA1'][] = $data_list['RISK_1'];
				$data_list['DATA2'][] = $data_list['RISK_2'];
				if(round_data($val['FLOW'], 0.01, 100) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['FLOW'], 0.01, 100) || !$data_list['MAX']) ? round_data($val['FLOW'], 0.01, 100) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['FLOW'], 0.01, 100) || !$data_list['MIN']) ? round_data($val['FLOW'], 0.01, 100) : $data_list['MIN'];
				}
			}
		}
		if(level_cnt == 2){
			$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_2']) ? $data_list['RISK_2'] : $data_list['MAX'];
		}else if(level_cnt == 3){
			$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_3']) ? $data_list['RISK_3'] : $data_list['MAX'];
		}else if(level_cnt == 4){
			$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_3']) ? $data_list['RISK_3'] : $data_list['MAX'];
		}else if(level_cnt == 5){
			$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_5']) ? $data_list['RISK_5'] : $data_list['MAX'];
		}
		$data_list['MIN'] = ($data_list['MIN'] > $data_list['RISK_1']) ? $data_list['RISK_1'] : $data_list['MIN'];
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 적설 그래프
	case 'snow':
		//적설
		$LocalDB = new ClassRtuInfo($DB, 2);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassSnowInfo = new ClassSnowInfo($DB);
		
		$ClassSnowInfo->getSnowRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassSnowInfo->rsSnowRpt){
			foreach($ClassSnowInfo->rsSnowRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['SNOW'], 0.001, 10) == "-") ? null : round_data($val['SNOW'], 0.001, 10);
				if(round_data($val['SNOW'], 0.001, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['SNOW'], 0.001, 10) || !$data_list['MAX']) ? round_data($val['SNOW'], 0.001, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['SNOW'], 0.001, 10) || !$data_list['MIN']) ? round_data($val['SNOW'], 0.001, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 변위 그래프
	case 'disp':
		//변위
		$LocalDB = new ClassRtuInfo($DB, 4);
		$LocalDB->getDispRtuInfo($area_code);
		
		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		$area_data['RISK_1'] = ($LocalDB->DISP_LEVEL1[0] == 0) ? null : $LocalDB->DISP_LEVEL1[0];
		$area_data['RISK_2'] = ($LocalDB->DISP_LEVEL2[0] == 0) ? null : $LocalDB->DISP_LEVEL2[0];
		$area_data['RISK_3'] = ($LocalDB->DISP_LEVEL3[0] == 0) ? null : $LocalDB->DISP_LEVEL3[0];

		$ClassDispInfo = new ClassDispInfo($DB);
		
		$time = time();
		// $sd_date = date("Y-m-d",strtotime("-1 week", $time));
		$sd_date = date("Y-m-d",strtotime("-1 months", $time));
		if($where_date == "graph"){
			$data_list = getDispDateAndArray($sd_date, date("Y-m-d"), $area_data);

			$ClassDispInfo->getDispGraph($area_code, $type, $sd_date, date("Y-m-d"));
		}else{
			$ClassDispInfo->getDispRpt($area_code, $type, $where_date, $ecnt);
		}
		
		if($where_date == "graph"){
			if($ClassDispInfo->rsDisp10m){
				foreach($ClassDispInfo->rsDisp10m as $key => $val){
					$data_list[ $val['DISPLACEMENT_DATE'] ]['LEG'] = $val['DISPLACEMENT_DATE'];
					$data_list[ $val['DISPLACEMENT_DATE'] ]['DATA'] = (round_data($val['DISPLACEMENT'], 0.0001, 100) == "-") ? null : round_data($val['DISPLACEMENT'], 0.0001, 100);
				}
			}
		}else{
			if($ClassDispInfo->rsDispRpt){
				foreach($ClassDispInfo->rsDispRpt as $key => $val){
					$data_list['LEG'][] = $val['NUM'];
					$data_list['DATA'][] = (round_data($val['DISPLACEMENT'], 0.0001, 100) == "-") ? null : round_data($val['DISPLACEMENT'], 0.0001, 100);
					$data_list['DATA1'][] = $data_list['RISK_1'];
					$data_list['DATA2'][] = $data_list['RISK_2'];
					$data_list['DATA3'][] = $data_list['RISK_3'];

					if(round_data($val['DISPLACEMENT'], 0.0001, 100) != "-"){
						$data_list['MAX'] = ($data_list['MAX'] < round_data($val['DISPLACEMENT'], 0.0001, 100) || !$data_list['MAX']) ? round_data($val['DISPLACEMENT'], 0.0001, 100) : $data_list['MAX'];
						$data_list['MIN'] = ($data_list['MIN'] > round_data($val['DISPLACEMENT'], 0.0001, 100) || !$data_list['MIN']) ? round_data($val['DISPLACEMENT'], 0.0001, 100) : $data_list['MIN'];
					}
				}
			}

			if(level_cnt == 2){
				$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_2']) ? $data_list['RISK_2'] : $data_list['MAX'];
			}else if(level_cnt == 3){
				$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_3']) ? $data_list['RISK_3'] : $data_list['MAX'];
			}else if(level_cnt == 4){
				$data_list['MAX'] = ($data_list['MAX'] < $data_list['RISK_3']) ? $data_list['RISK_3'] : $data_list['MAX'];
			}
			$data_list['MIN'] = ($data_list['MIN'] > $data_list['RISK_1']) ? $data_list['RISK_1'] : $data_list['MIN'];
		}
			
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;
			
	// 강우 10분, 1분 그래프
	case 'rain_10m':
		
		//강우
		$LocalDB = new ClassRtuInfo($DB, 0);
		$LocalDB->getRtuInfo($area_code);

		$ClassRainInfo = new ClassRainInfo($DB);

		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassRainInfo->getRain10m($area_code, $type, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassRainInfo->rsRain10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassRainInfo->rsRain10m as $key => $val){
						$sub_date = substr($val['RAIN_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['RAIN'], 0.01, 10);
						};
						if($val['RAIN'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['RAIN'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['RAIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassRainInfo->rsRain10m){
				foreach($ClassRainInfo->rsRain10m as $key => $val){
					$data_list[ $val['RAIN_DATE'] ]['LEG'] = $val['RAIN_DATE'];
					$data_list[ $val['RAIN_DATE'] ]['DATA'] = round_data($val['RAIN'], 0.01, 10);
					if(round_data($val['RAIN'], 0.01, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['RAIN'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['RAIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['RAIN'], 0.01, 10) : $area_data['MIN'];
					}
				}
			}
		}	
		
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;
			
	// 수위 10분, 1분 그래프
	case 'flow_10m':
		
		//수위
		$LocalDB = new ClassRtuInfo($DB, 1);
		$LocalDB->getRtuInfo($area_code);

		$area_data['RISK_1'] = ($LocalDB->FLOW_WARNING[0] == 0) ? null : $LocalDB->FLOW_WARNING[0];
		$area_data['RISK_2'] = ($LocalDB->FLOW_DANGER[0] == 0) ? null : $LocalDB->FLOW_DANGER[0];
		
		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassFlowInfo = new ClassFlowInfo($DB);
		
		$ClassFlowInfo->getFlow10m($area_code, $type, $t_sdate, $t_edate);
		
		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassFlowInfo->rsFlow10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassFlowInfo->rsFlow10m as $key => $val){
						$sub_date = substr($val['FLOW_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['FLOW'], 0.01, 100);
						};
						if($val['FLOW'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['FLOW'], 0.01, 100) || !$area_data['MAX']) ? round_data($val['FLOW'], 0.01, 100) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['FLOW'], 0.01, 100) || !$area_data['MIN']) ? round_data($val['FLOW'], 0.01, 100) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassFlowInfo->rsFlow10m){
				foreach($ClassFlowInfo->rsFlow10m as $key => $val){

					$data_list[ $val['FLOW_DATE'] ]['LEG'] = $val['FLOW_DATE'];
					$data_list[ $val['FLOW_DATE'] ]['DATA'] = round_data($val['FLOW'], 0.01, 100);
					if(round_data($val['FLOW'], 0.01, 100) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['FLOW'], 0.01, 100) || !$area_data['MAX']) ? round_data($val['FLOW'], 0.01, 100) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['FLOW'], 0.01, 100) || !$area_data['MIN']) ? round_data($val['FLOW'], 0.01, 100) : $area_data['MIN'];
					}
				}
			}
		}
		// min max 바꿈
		$area_data['MAX'] = ($area_data['MAX'] < $area_data['RISK_5']) ? $area_data['RISK_5'] : $area_data['MAX'];
		$area_data['MIN'] = ($area_data['MIN'] > $area_data['RISK_1']) ? $area_data['RISK_1'] : $area_data['MIN'];
			
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;
			
	// 적설 10분, 1분 그래프
	case 'snow_10m':
		
		//적설
		$LocalDB = new ClassRtuInfo($DB, 2);
		$LocalDB->getRtuInfo($area_code);

		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassSnowInfo = new ClassSnowInfo($DB);
		
		$ClassSnowInfo->getSnow10m($area_code, $type, $t_sdate, $t_edate);
		// $ClassSnowInfo->getSnow10m($area_code, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassSnowInfo->rsSnow10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassSnowInfo->rsSnow10m as $key => $val){
						$sub_date = substr($val['SNOW_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['SNOW'], 0.001, 10);
						};
						if($val['RAIN'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['SNOW'], 0.001, 10) || !$area_data['MAX']) ? round_data($val['SNOW'], 0.001, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['SNOW'], 0.001, 10) || !$area_data['MIN']) ? round_data($val['SNOW'], 0.001, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassSnowInfo->rsSnow10m){
				foreach($ClassSnowInfo->rsSnow10m as $key => $val){
					$data_list[ $val['SNOW_DATE'] ]['LEG'] = $val['SNOW_DATE'];
					$data_list[ $val['SNOW_DATE'] ]['DATA'] = round_data($val['SNOW'], 0.001, 10);
					if(round_data($val['SNOW'], 0.001, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['SNOW'], 0.001, 10) || !$area_data['MAX']) ? round_data($val['SNOW'], 0.001, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['SNOW'], 0.001, 10) || !$area_data['MIN']) ? round_data($val['SNOW'], 0.001, 10) : $area_data['MIN'];
					}
				}
			}
		}
			
		// var_dump($data_list);
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;

	// 온도 10분, 1분 그래프
	case 'temp_10m':
		
		//온도
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);

		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassAwsInfo->getTemp10m($area_code, $type, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassAwsInfo->rsTemp10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassAwsInfo->rsTemp10m as $key => $val){
						$sub_date = substr($val['TEMP_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['TEMP'], 0.01, 10);
							$data_list[ $i ]['DATA2'] = round_data($val['TEMP_MIN'], 0.01, 10);
							$data_list[ $i ]['DATA3'] = round_data($val['TEMP_MAX'], 0.01, 10);
						};
						if($val['TEMP'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['TEMP_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['TEMP_MAX'], 0.01, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['TEMP_MIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['TEMP_MIN'], 0.01, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassAwsInfo->rsTemp10m){
				foreach($ClassAwsInfo->rsTemp10m as $key => $val){
					$data_list[ $val['TEMP_DATE'] ]['LEG'] = $val['TEMP_DATE'];
					$data_list[ $val['TEMP_DATE'] ]['DATA'] = round_data($val['TEMP'], 0.01, 10);
					$data_list[ $val['TEMP_DATE'] ]['DATA2'] = round_data($val['TEMP_MIN'], 0.01, 10);
					$data_list[ $val['TEMP_DATE'] ]['DATA3'] = round_data($val['TEMP_MAX'], 0.01, 10);
					if(round_data($val['TEMP'], 0.01, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['TEMP_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['TEMP_MAX'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['TEMP_MIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['TEMP_MIN'], 0.01, 10) : $area_data['MIN'];
					}
				}
			}
		}	
		
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;


		// 풍속 10분, 1분 그래프
	case 'wind_10m':
		
		//풍속
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);

		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassAwsInfo->getWind10m($area_code, $type, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassAwsInfo->rsWind10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassAwsInfo->rsWind10m as $key => $val){
						$sub_date = substr($val['WIND_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['VEL'], 0.01, 10);
							$data_list[ $i ]['DATA3'] = round_data($val['VEL_MAX'], 0.01, 10);
						};
						if($val['VEL'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['VEL_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['VEL_MAX'], 0.01, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['VEL'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['VEL'], 0.01, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassAwsInfo->rsWind10m){
				foreach($ClassAwsInfo->rsWind10m as $key => $val){
					$data_list[ $val['WIND_DATE'] ]['LEG'] = $val['WIND_DATE'];
					$data_list[ $val['WIND_DATE'] ]['DATA'] = round_data($val['VEL'], 0.01, 10);
					$data_list[ $val['WIND_DATE'] ]['DATA3'] = round_data($val['VEL_MAX'], 0.01, 10);
					if(round_data($val['VEL'], 0.01, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['VEL_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['VEL_MAX'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['VEL'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['VEL'], 0.01, 10) : $area_data['MIN'];
					}
				}
			}
		}	
		
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;


	// 기압 10분, 1분 그래프
	case 'atmo_10m':
		
		//풍속
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);

		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassAwsInfo->getAtmo10m($area_code, $type, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassAwsInfo->rsAtmo10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassAwsInfo->rsAtmo10m as $key => $val){
						$sub_date = substr($val['ATMO_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['ATMO'], 0.01, 10);
						};
						if($val['ATMO'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['ATMO'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['ATMO'], 0.01, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['ATMO'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['ATMO'], 0.01, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassAwsInfo->rsAtmo10m){
				foreach($ClassAwsInfo->rsAtmo10m as $key => $val){
					$data_list[ $val['ATMO_DATE'] ]['LEG'] = $val['ATMO_DATE'];
					$data_list[ $val['ATMO_DATE'] ]['DATA'] = round_data($val['ATMO'], 0.01, 10);
					if(round_data($val['ATMO'], 0.01, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['ATMO'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['ATMO'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['ATMO'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['ATMO'], 0.01, 10) : $area_data['MIN'];
					}
				}
			}
		}	
		
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;

	// 습도 10분, 1분 그래프
	case 'humi_10m':
		
		//습도
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);

		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($type == 'S'){
			$data_list = getDateAndArray1m($sTdate, $eTdate, $area_data);
		}else if($type == 'D'){
			$data_list = getDateAndArrayD($sdate, $edate, $area_data);
		}else{
			$data_list = getDateAndArray($sdate, $edate, $area_data);
		}
		
		$ClassAwsInfo->getHumi10m($area_code, $type, $t_sdate, $t_edate);

		$area_data['AREA_CODE'] = $LocalDB->AREA_CODE;
		$area_data['RTU_NAME'] = $LocalDB->RTU_NAME;
		$area_data['MAX'] = null; // 최고
		$area_data['MIN'] = null; // 최저
		
		if($type == 'D'){
			if($ClassAwsInfo->rsHumi10m){
				$i = 0;
				foreach($data_list as $key2 => $val2){
					foreach($ClassAwsInfo->rsHumi10m as $key => $val){
						$sub_date = substr($val['HUMI_DATE'], 8,2);
						if($data_list[ $i ]['LEG'] == $sub_date){
							$data_list[ $i ]['DATA'] = round_data($val['HUMI'], 0.01, 10);
							$data_list[ $i ]['DATA2'] = round_data($val['HUMI_MIN'], 0.01, 10);
							$data_list[ $i ]['DATA3'] = round_data($val['HUMI_MAX'], 0.01, 10);
						};
						if($val['HUMI'] != "-"){
							$area_data['MAX'] = ($area_data['MAX'] < round_data($val['HUMI_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['HUMI_MAX'], 0.01, 10) : $area_data['MAX'];
							$area_data['MIN'] = ($area_data['MIN'] > round_data($val['HUMI_MIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['HUMI_MIN'], 0.01, 10) : $area_data['MIN'];
						}
					}
					$i++;
				}
			}
		}else{
			if($ClassAwsInfo->rsHumi10m){
				foreach($ClassAwsInfo->rsHumi10m as $key => $val){
					$data_list[ $val['HUMI_DATE'] ]['LEG'] = $val['HUMI_DATE'];
					$data_list[ $val['HUMI_DATE'] ]['DATA'] = round_data($val['HUMI'], 0.01, 10);
					$data_list[ $val['HUMI_DATE'] ]['DATA2'] = round_data($val['HUMI_MIN'], 0.01, 10);
					$data_list[ $val['HUMI_DATE'] ]['DATA3'] = round_data($val['HUMI_MAX'], 0.01, 10);
					
					if(round_data($val['HUMI'], 0.01, 10) != "-"){
						$area_data['MAX'] = ($area_data['MAX'] < round_data($val['HUMI_MAX'], 0.01, 10) || !$area_data['MAX']) ? round_data($val['HUMI_MAX'], 0.01, 10) : $area_data['MAX'];
						$area_data['MIN'] = ($area_data['MIN'] > round_data($val['HUMI_MIN'], 0.01, 10) || !$area_data['MIN']) ? round_data($val['HUMI_MIN'], 0.01, 10) : $area_data['MIN'];
					}
				}
			}
		}	
		
		$returnBody = array( 'list' => $data_list, 'area' => $area_data  );
		echo json_encode( $returnBody );
	break;

	// 온도 그래프
	case 'temp':
		//온도
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getTempRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsTempRpt){
			foreach($ClassAwsInfo->rsTempRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['TEMP'], 0.01, 10) == "-") ? null : round_data($val['TEMP'], 0.01, 10);
				$data_list['DATA2'][] = (round_data($val['TEMP_MIN'], 0.01, 10) == "-") ? null : round_data($val['TEMP_MIN'], 0.01, 10);
				$data_list['DATA3'][] = (round_data($val['TEMP_MAX'], 0.01, 10) == "-") ? null : round_data($val['TEMP_MAX'], 0.01, 10);
				if(round_data($val['TEMP'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['TEMP_MAX'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['TEMP_MAX'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['TEMP_MIN'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['TEMP_MIN'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 풍속 그래프
	case 'wind':
		//풍속
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getWindRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsWindRpt){
			foreach($ClassAwsInfo->rsWindRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['VEL'], 0.01, 10) == "-") ? null : round_data($val['VEL'], 0.01, 10);
				$data_list['DATA3'][] = (round_data($val['VEL_MAX'], 0.01, 10) == "-") ? null : round_data($val['VEL_MAX'], 0.01, 10);
				if(round_data($val['VEL'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['VEL_MAX'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['VEL_MAX'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['VEL'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['VEL'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;


	
	// 기압 그래프
	case 'atmo':
		//기압
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getAtmoRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsAtmoRpt){
			foreach($ClassAwsInfo->rsAtmoRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['ATMO'], 0.01, 10) == "-") ? null : round_data($val['ATMO'], 0.01, 10);
				if(round_data($val['ATMO'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['ATMO'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['ATMO'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['ATMO'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['ATMO'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 일사 그래프
	case 'radi':
		//기압
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getRadiRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsRadiRpt){
			foreach($ClassAwsInfo->rsRadiRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['RADI'], 0.01, 10) == "-") ? null : round_data($val['RADI'], 0.01, 10);
				if(round_data($val['RADI'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['RADI'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['RADI'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['RADI'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['RADI'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 일조 그래프
	case 'suns':
		//일조
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getSunsRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsSunsRpt){
			foreach($ClassAwsInfo->rsSunsRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['SUNS'], 0.01, 10) == "-") ? null : round_data($val['SUNS'], 0.01, 10);
				if(round_data($val['SUNS'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['SUNS'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['SUNS'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['SUNS'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['SUNS'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 습도 그래프
	case 'humi':
		//습도
		$LocalDB = new ClassRtuInfo($DB, 3);
		$LocalDB->getRtuInfo($area_code);
		
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getHumiRpt($area_code, $type, $where_date, $ecnt);
		
		$data_list['AREA_CODE'] = $LocalDB->AREA_CODE;
		$data_list['RTU_NAME'] = $LocalDB->RTU_NAME;
		$data_list['MAX'] = null; // 최고
		$data_list['MIN'] = null; // 최저
		
		if($ClassAwsInfo->rsHumiRpt){
			foreach($ClassAwsInfo->rsHumiRpt as $key => $val){
				$data_list['LEG'][] = $val['NUM'];
				$data_list['DATA'][] = (round_data($val['HUMI'], 0.01, 10) == "-") ? null : round_data($val['HUMI'], 0.01, 10);
				$data_list['DATA2'][] = (round_data($val['HUMI_MIN'], 0.01, 10) == "-") ? null : round_data($val['HUMI_MIN'], 0.01, 10);
				$data_list['DATA3'][] = (round_data($val['HUMI_MAX'], 0.01, 10) == "-") ? null : round_data($val['HUMI_MAX'], 0.01, 10);
				if(round_data($val['HUMI'], 0.01, 10) != "-"){
					$data_list['MAX'] = ($data_list['MAX'] < round_data($val['HUMI_MAX'], 0.01, 10) || !$data_list['MAX']) ? round_data($val['HUMI_MAX'], 0.01, 10) : $data_list['MAX'];
					$data_list['MIN'] = ($data_list['MIN'] > round_data($val['HUMI_MIN'], 0.01, 10) || !$data_list['MIN']) ? round_data($val['HUMI_MIN'], 0.01, 10) : $data_list['MIN'];
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 구분에 따른 지역 리스트
	case 'option':
		$LocalDB = new ClassRtuInfo($DB, $_REQUEST['option']);
		$LocalDB->getRtuInfo();
		
		for($i=0; $i<$LocalDB->rsCnt; $i++) {
			$data_sel[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
			$data_sel[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
		}
		
		$returnBody = array( 'list' => $data_sel );
		echo json_encode( $returnBody );
	break;
}

// data_list 배열 반환 type = D
function getDateAndArrayD($sdate, $edate, $area_data){
	$eedate = true;
	$tmp_sdate = $sdate;
	$i = 0;
	while($eedate){
		$tmp_date = $tmp_sdate;
		$tmp_reg = substr($tmp_date, 8,2);
		$tmp_mon = substr($tmp_date, 5,2)." / ".$tmp_reg;
		$data_list[$i]['LEG'] = $tmp_reg;
		$data_list[$i]['MON'] = $tmp_mon;
		$data_list[$i]['DATA'] = "-";

		if($area_data != null){
			$data_list[$i]['DATA1'] = $area_data['RISK_1'];
			$data_list[$i]['DATA2'] = $area_data['RISK_2'];
		}
		$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
		$i++;
		if($tmp_sdate > $edate) $eedate = false;
	}
	// var_dump($data_list);
	return $data_list;
}

// 변위현황 data_list 배열 반환
function getDispDateAndArray($sdate, $edate, $area_data){
	
	$eedate = true;
	$tmp_sdate = $sdate;
	while($eedate){
		$tmp_date = $tmp_sdate." 00:00:00";
		$data_list[$tmp_date]['LEG'] = $tmp_date;
		$data_list[$tmp_date]['DATA'] = "-";
		// if($area_data != null){
		// 	$data_list[$tmp_date]['DATA1'] = $area_data['RISK_1'];
		// 	$data_list[$tmp_date]['DATA2'] = $area_data['RISK_2'];
		// 	$data_list[$tmp_date]['DATA3'] = $area_data['RISK_3'];
		// 	$data_list[$tmp_date]['DATA4'] = $area_data['RISK_4'];
		// 	$data_list[$tmp_date]['DATA5'] = $area_data['RISK_5'];
		// }
		$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
		if($tmp_sdate > $edate) $eedate = false;
	}
	return $data_list;
}

// data_list 배열 반환
function getDateAndArray($sdate, $edate, $area_data){

	$eedate = true;
	$tmp_sdate = $sdate;
	while($eedate){
		for($i=0; $i<=23; $i++){
			if($i < 10){
				$tmp_i = "0".$i;
			}else{
				$tmp_i = $i;
			}
			for($j=0; $j<=5; $j++){
				
				$tmp_date = $tmp_sdate." ".$tmp_i.":".$j."0:00";
				$data_list[$tmp_date]['LEG'] = $tmp_date;
				$data_list[$tmp_date]['DATA'] = "-";
				if($area_data != null){
					$data_list[$tmp_date]['DATA1'] = $area_data['RISK_1'];
					$data_list[$tmp_date]['DATA2'] = $area_data['RISK_2'];
				}
			}
		}
		$tmp_sdate = date("Y-m-d", strtotime($tmp_sdate.' + 1 days'));
		if($tmp_sdate > $edate) $eedate = false;
	}
	
	return $data_list;
}

// data_list 배열 반환 1분
function getDateAndArray1m($sTdate, $eTdate, $area_data){
	// echo $sTdate." / ".$eTdate;
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
			$data_list[$tmp_date]['LEG'] = $tmp_date;
			$data_list[$tmp_date]['DATA'] = "-";
			if($area_data != null){
				$data_list[$tmp_date]['DATA1'] = $area_data['RISK_1'];
				$data_list[$tmp_date]['DATA2'] = $area_data['RISK_2'];
			}
		}
		$tmp_sdate = date("Y-m-d H", strtotime($tmp_date.' + 1 hours'));

		if($tmp_sdate > $eTdate) $eedate = false;
	}
	
	return $data_list;
}

$DB->CLOSE();
?>


