<?
require_once "../../_conf/_common.php";

require_once "../../include/class/rtuInfo.php";
require_once "../../include/class/rainInfo.php";
require_once "../../include/class/flowInfo.php";
require_once "../../include/class/awsInfo.php";
require_once "../../include/class/snowInfo.php";
require_once "../../include/class/dispInfo.php";
// require_once "../../include/class/broadcast.php";

$mode = $_REQUEST["mode"];
$kind = $_REQUEST["kind"];
$area_code = $_REQUEST['area_code'];
$sdate = $_REQUEST['sdate'];
$hour = $_REQUEST['hour'];
$min = $_REQUEST['min'];
$yy = substr($sdate, 0, 4);
$mm = substr($sdate, 5, 2);
$dd = substr($sdate, 8, 2);

if($hour < 10) $hour = "0".$hour;
$where_date .= " '".$sdate." ".$hour.":00:00', ";
$where_date .= " '".$sdate." ".$hour.":10:00', ";
$where_date .= " '".$sdate." ".$hour.":20:00', ";
$where_date .= " '".$sdate." ".$hour.":30:00', ";
$where_date .= " '".$sdate." ".$hour.":40:00', ";
$where_date .= " '".$sdate." ".$hour.":50:00' ";

switch($mode){
	// 강우 자료 보기
	case 'rain':
		$ClassRainInfo = new ClassRainInfo($DB);
		
		$ClassRainInfo->getRainRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassRainInfo->rsRainRpt){
			foreach($ClassRainInfo->rsRainRpt as $key => $val){
				$data_list['MIN'][] = ($val['RAIN'] == "-") ? "" : round_data($val['RAIN'], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 강우 자료 수정
	case 'rain_save':
		$ClassRainInfo = new ClassRainInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassRainInfo->setRainData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassRainInfo->getRainSum($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassRainInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassRainInfo->setRainData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassRainInfo->getRainSum($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassRainInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassRainInfo->setRainData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassRainInfo->getRainSum($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassRainInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassRainInfo->setRainData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassRainInfo->getRainSum($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassRainInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassRainInfo->setRainData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 수위 자료 보기
	case 'flow':
		$ClassFlowInfo = new ClassFlowInfo($DB);
		
		$ClassFlowInfo->getFlowRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassFlowInfo->rsFlowRpt){
			foreach($ClassFlowInfo->rsFlowRpt as $key => $val){
				$data_list['MIN'][] = ($val['FLOW'] == "-") ? "" : round_data($val['FLOW'], 0.01, 100);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 수위 자료 수정
	case 'flow_save':
		$ClassFlowInfo = new ClassFlowInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassFlowInfo->setFlowData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassFlowInfo->getFlowAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassFlowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassFlowInfo->setFlowData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassFlowInfo->getFlowAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassFlowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassFlowInfo->setFlowData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassFlowInfo->getFlowAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassFlowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassFlowInfo->setFlowData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassFlowInfo->getFlowAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassFlowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassFlowInfo->setFlowData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 적설 자료 보기
	case 'snow':
		$ClassSnowInfo = new ClassSnowInfo($DB);
		
		$ClassSnowInfo->getSnowRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassSnowInfo->rsSnowRpt){
			foreach($ClassSnowInfo->rsSnowRpt as $key => $val){
				$data_list['MIN'][] = ($val['SNOW'] == "-") ? "" : round_data($val['SNOW'], 0.001, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 적설 자료 수정
	case 'snow_save':
		$ClassSnowInfo = new ClassSnowInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*1000;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassSnowInfo->setSnowData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassSnowInfo->getSnowSum($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassSnowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassSnowInfo->setSnowData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassSnowInfo->getSnowSum($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassSnowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassSnowInfo->setSnowData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassSnowInfo->getSnowSum($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassSnowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassSnowInfo->setSnowData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassSnowInfo->getSnowSum($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassSnowInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassSnowInfo->setSnowData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	// 변위 자료 보기
	case 'disp':
		$ClassDispInfo = new ClassDispInfo($DB);
		
		$ClassDispInfo->getDispRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassDispInfo->rsDispRpt){
			foreach($ClassDispInfo->rsDispRpt as $key => $val){
				$data_list['MIN'][] = ($val['DISPLACEMENT'] == "-") ? "" : round_data($val['DISPLACEMENT'], 0.0001, 100);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 변위 자료 수정
	case 'disp_save':
		$ClassDispInfo = new ClassDispInfo($DB);

		$where_date2 .= " '".date('Y-m-d H:i:s', strtotime(substr($where_date, 2, 19)) - 60 * 10)."' ";
		// $where_date2 .= substr($where_date, 0, 118)." ";
		
		if($min){
			$ClassDispInfo->getDispRpt($area_code, "M", $where_date2, "");
		
			if($ClassDispInfo->rsDispRpt){
				foreach($ClassDispInfo->rsDispRpt as $key => $val){
					$bef_disp = ($val['DISPLACEMENT'] == "-") ? "-" : $val['DISPLACEMENT'];
				}
			}

			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*10000;
					// 이전값과 현재값의 차이
					if($i==0){
						$diff_min[$i] = $min[$i]-$bef_disp;
					}else{
						$diff_min[$i] = $min[$i]-$tmp_bef;
					}
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassDispInfo->setDispData($area_code, "M", $where_date, $min[$i]);
					$arrReturn[] = $ClassDispInfo->setDispDiffData($area_code, "M", $where_date, $diff_min[$i]);
					$tmp_bef = $min[$i];
				}
			}
			// 시단위 데이터
			$ClassDispInfo->getDispSum($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassDispInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassDispInfo->setDispData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassDispInfo->getDispSum($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassDispInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassDispInfo->setDispData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassDispInfo->getDispSum($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassDispInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassDispInfo->setDispData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassDispInfo->getDispSum($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassDispInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassDispInfo->setDispData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 온도 자료 보기
	case 'temp':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getTempRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsTempRpt){
			foreach($ClassAwsInfo->rsTempRpt as $key => $val){
				$data_list['MIN'][] = ($val[$kind] == "-") ? "" : round_data($val[$kind], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 온도 자료 수정
	case 'temp_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setTempData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getTempAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setTempData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getTempAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getTempAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getTempAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 온도(최고) 자료 수정
	case 'temp_max_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setTempMaxData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getTempMaxAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMaxData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getTempMaxAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMaxData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getTempMaxAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMaxData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getTempMaxAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMaxData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 온도(최저) 자료 수정
	case 'temp_min_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setTempMinData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getTempMinAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMinData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getTempMinAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMinData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getTempMinAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMinData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getTempMinAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setTempMinData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 풍향풍속 자료 보기
	case 'wind':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getWindRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsWindRpt){
			foreach($ClassAwsInfo->rsWindRpt as $key => $val){
				if($kind == "DEG"){
					$data_list['MIN'][] = ($val[$kind] == "-") ? "" : $val[$kind];
				}else{
					$data_list['MIN'][] = ($val[$kind] == "-") ? "" : round_data($val[$kind], 0.01, 10);
				}
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 풍속 자료 수정
	case 'vel_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setVelData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getVelAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setVelData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getVelAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getVelAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getVelAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 풍속(최고) 자료 수정
	case 'vel_max_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setVelMaxData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getVelMaxAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setVelMaxData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getVelMaxAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelMaxData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getVelMaxAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelMaxData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getVelMaxAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setVelMaxData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 풍향 자료 수정
	case 'deg_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != "-"){
					$min[$i] = $ClassAwsInfo->getNumDegree($min[$i]);
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setDegData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getDegAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setDegData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getDegAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getDegAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getDegAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 풍향(최고) 자료 수정
	case 'deg_max_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != "-"){
					$min[$i] = $ClassAwsInfo->getNumDegree($min[$i]);
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setDegMaxData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getDegMaxAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setDegMaxData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getDegMaxAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegMaxData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getDegMaxAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegMaxData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getDegMaxAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setDegMaxData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 기압 자료 보기
	case 'atmo':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getAtmoRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsAtmoRpt){
			foreach($ClassAwsInfo->rsAtmoRpt as $key => $val){
				$data_list['MIN'][] = ($val[$kind] == "-") ? "" : round_data($val[$kind], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 기압 자료 수정
	case 'atmo_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setAtmoData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getAtmoAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getAtmoAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getAtmoAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getAtmoAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 기압(최고) 자료 수정
	case 'atmo_max_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setAtmoMaxData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getAtmoMaxAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMaxData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getAtmoMaxAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMaxData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getAtmoMaxAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMaxData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getAtmoMaxAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMaxData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 기압(최저) 자료 수정
	case 'atmo_min_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setAtmoMinData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getAtmoMinAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMinData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getAtmoMinAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMinData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getAtmoMinAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMinData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getAtmoMinAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setAtmoMinData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 습도 자료 보기
	case 'humi':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getHumiRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsHumiRpt){
			foreach($ClassAwsInfo->rsHumiRpt as $key => $val){
				$data_list['MIN'][] = ($val[$kind] == "-") ? "" : round_data($val[$kind], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 습도 자료 수정
	case 'humi_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setHumiData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getHumiAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getHumiAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getHumiAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getHumiAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 습도(최고) 자료 수정
	case 'humi_max_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setHumiMaxData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getHumiMaxAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMaxData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getHumiMaxAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMaxData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getHumiMaxAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMaxData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getHumiMaxAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMaxData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 습도(최저) 자료 수정
	case 'humi_min_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setHumiMinData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getHumiMinAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMinData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getHumiMinAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMinData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getHumiMinAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMinData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getHumiMinAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setHumiMinData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 일사 자료 보기
	case 'radi':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getRadiRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsRadiRpt){
			foreach($ClassAwsInfo->rsRadiRpt as $key => $val){
				$data_list['MIN'][] = ($val['RADI'] == "-") ? "" : round_data($val['RADI'], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 일사 자료 수정
	case 'radi_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setRadiData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getRadiAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setRadiData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getRadiAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setRadiData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getRadiAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setRadiData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getRadiAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setRadiData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 일조 자료 보기
	case 'suns':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getSunsRpt($area_code, "M", $where_date, "");
		
		$data_list['DATE'] = $sdate;
		$data_list['HOUR'] = $hour;
		if($ClassAwsInfo->rsSunsRpt){
			foreach($ClassAwsInfo->rsSunsRpt as $key => $val){
				$data_list['MIN'][] = ($val['SUNS'] == "-") ? "" : round_data($val['SUNS'], 0.01, 10);
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 일조 자료 수정
	case 'suns_save':
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		if($min){
			// 분단위 데이터
			for($i=0; $i<6; $i++){
				if($min[$i] != null){
					$min[$i] = $min[$i]*100;
					$where_date = $sdate." ".$hour.":".$i."0:00";
					$arrReturn[] = $ClassAwsInfo->setSunsData($area_code, "M", $where_date, $min[$i]);
				}
			}
			// 시단위 데이터
			$ClassAwsInfo->getSunsAvg($area_code, "M", $sdate." ".$hour.":00:00", $sdate." ".$hour.":59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." ".$hour.":00:00";
			$arrReturn[] = $ClassAwsInfo->setSunsData($area_code, "H", $where_date, $tmp_data);
			// 일단위 데이터
			$ClassAwsInfo->getSunsAvg($area_code, "H", $sdate." 00:00:00", $sdate." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $sdate." 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setSunsData($area_code, "D", $where_date, $tmp_data);
			// 월단위 데이터
			$last = date("t", strtotime($sdate));
			$ClassAwsInfo->getSunsAvg($area_code, "D", $yy."-".$mm."-01 00:00:00", $yy."-".$mm."-".$last." 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-".$mm."-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setSunsData($area_code, "N", $where_date, $tmp_data);
			// 연단위 데이터
			$ClassAwsInfo->getSunsAvg($area_code, "N", $yy."-01-01 00:00:00", $yy."-12-31 23:59:59");
			$tmp_data = $ClassAwsInfo->rsData;
			$tmp_data = ($tmp_data != null) ? $tmp_data : "null";
			$where_date = $yy."-01-01 00:00:00";
			$arrReturn[] = $ClassAwsInfo->setSunsData($area_code, "Y", $where_date, $tmp_data);
		}
		
		if( in_array(false, $arrReturn) ){
			$result = false;
		}else{
			$result = true;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 수동호출
	case 'mcall':
		$ClassBroadCast = new ClassBroadCast($DB);
		
		$result = $ClassBroadCast->setRtuMCall();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 수동호출 결과
	case 'mcall_log':
		$ClassBroadCast = new ClassBroadCast($DB);
		
		$ClassBroadCast->getMCallLog();
		
		if($ClassBroadCast->rsMCallLog){
			foreach($ClassBroadCast->rsMCallLog as $key => $val){
				$tmp_img_1 = ''; // 호출상태
				$tmp_img_2 = ''; // 호출결과
				
				if($val['TRANS_ERROR'] == 0){
					$tmp_state = $ClassBroadCast->getSentence(1, $val['TRANS_FLAG']);
					
					if($val['TRANS_FLAG'] == 0){
						if($val['VHF_CALL'] == 1){
							$tmp_img_1 = '<img src="'.IMG_DIR.'aniok.gif">';
							$tmp_img_2 = "VHF 명령 등록";
						}else if($val['VHF_CALL'] == 7){
							$tmp_img_1 = '<img src="'.IMG_DIR.'iconok.gif">';
							$tmp_img_2 = "VHF 명령 전송 종료";
						}else if($val['VHF_CALL'] == 9){
							$tmp_img_1 = '<img src="'.IMG_DIR.'iconfail.gif">';
							$tmp_img_2 = "VHF 명령 전송 실패";
						}else{
							$tmp_img_1 = '<img src="'.IMG_DIR.'aniok.gif">';
							$tmp_img_2 = $tmp_state;
						}
					}else if($val['TRANS_FLAG'] == "99"){
						$tmp_img_1 = '<img src="'.IMG_DIR.'iconok.gif">';
						$tmp_img_2 = $tmp_state;
					}else{
						$tmp_img_1 = '<img src="'.IMG_DIR.'aniok.gif">';
						$tmp_img_2 = $tmp_state;
					}
				}else{
					$tmp_state = $ClassBroadCast->getSentence("e", $val['TRANS_ERROR']);
					
					$tmp_img_1 = '<img src="'.IMG_DIR.'iconfail.gif">';
					$tmp_img_2 = $tmp_state;
				}
				
				// 패킷 오류 처리
				if(	($val['TRANS_FLAG'] == 20 || $val['TRANS_FLAG'] == 30 || $val['TRANS_FLAG'] == 40) &&
					($val['TRANS_ERROR'] == 13 || $val['TRANS_ERROR'] == 14 || $val['TRANS_ERROR'] == 15) ){
					$tmp_img_1 = '<img src="'.IMG_DIR.'iconok.gif">';
					$tmp_img_2 = "명령 전송 종료";
				}
				
				$data_list[$key]['RTU_ID'] = $val['RTU_ID'];
				$data_list[$key]['RTU_NAME'] = $val['RTU_NAME'];
				$data_list[$key]['STATE'] = $tmp_img_1;
				$data_list[$key]['RESULT'] = $tmp_img_2;
			}
		}
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
}

$DB->CLOSE();
?>


