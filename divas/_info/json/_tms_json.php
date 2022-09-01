<?
require_once "../../_conf/_common.php";

require_once "../../include/class/rtuInfo.php";
require_once "../../include/class/rainInfo.php";
require_once "../../include/class/flowInfo.php";
require_once "../../include/class/awsInfo.php";
require_once "../../include/class/snowInfo.php";
require_once "../../include/class/dispInfo.php";

$mode = $_REQUEST["mode"];

switch($mode){
	// 로그인 세션 처리
	case 'login':
		$IdInfo = $ClassCommon->getLoginIdInfo();
		if( $IdInfo['result'] ){
			if(recaptcha == 0){
				if( $ClassCommon->setLogin() ){
					$result = 0;
				}else{
					$result = 1;
				}
			}else{
				if( $ClassCommon->setCaptcha() ){ // 리캡차 체크
					if( $ClassCommon->setLogin() ){
						$result = 0;
					}else{
						$result = 1;
					}
				}else{
					$result = 2;
				}
			}
		} else {
			if($IdInfo['msg']){
				$result = 4;
			}else{
				$result = 3;
			}
		}
		
		$returnBody = array( 'result' => $result , "msg" => $IdInfo['msg']);
		echo json_encode( $returnBody );
	break;
	
	// 로그아웃 세션 처리
	case 'logout':
		$result = $ClassCommon->setLogout();
		
		$returnBody = array( 'result' => true );
		echo json_encode( $returnBody );
	break;
		
	// 기본 환경설정
	case 'common':
		$data_common['top_img'] = top_img;
		$data_common['top_title'] = top_title;
		$data_common['top_text'] = top_text;
		$data_common['level_cnt'] = level_cnt;
		$data_common['load_time'] = load_time;
		$data_common['alarm_cnt'] = alarm_cnt;
		$data_common['alert_cnt'] = alert_cnt;
		$data_common['board_type'] = board_type;
		$data_common['board_url'] = board_url;
		$data_common['root_dir'] = ROOT_DIR;
		$data_common['vhf_use'] = vhf_use;
		
		$returnBody = array( 'common' => $data_common );
		echo json_encode( $returnBody );
	break;
		
	// 레이아웃 정보
	case 'layout':
		$ClassCommon->getLayout();
		$data_layout = $ClassCommon->rsLayoutList;
		
		$ClassCommon->getLayoutItem();
		$data_layout_item = $ClassCommon->rsItemList;
		
		$returnBody = array( 'layout' => $data_layout, 'layout_item' => $data_layout_item );
		echo json_encode( $returnBody );
	break;
	
	// 레이아웃 옵션
	case 'layout_ival':
		$ClassCommon->getLayoutIval();
		$data_layout_ival = $ClassCommon->rsIvalList;
		
		$returnBody = array( 'layout_ival' => $data_layout_ival );
		echo json_encode( $returnBody );
	break;
	
	// 레이아웃 저장
	case 'layout_save':
		$result = $ClassCommon->setLayout();
		
		$returnBody = array( 'result' => $result);
		echo json_encode( $returnBody );
	break;
		
	// 강우 테이블
	case 'rain':
		//강우
		$RainLocalDB = new ClassRtuInfo($DB, 0);
		$RainLocalDB->getRtuInfo();
		
		//강우자료
		$ClassRainInfo = new ClassRainInfo($DB);
		
		for($i=0; $i<$RainLocalDB->rsCnt; $i++){
			//지역코드
			$data_rain[$i]['AREA_CODE'] = $RainLocalDB->AREA_CODE[$i];
			
			//장비이름
			$data_rain[$i]['RTU_NAME'] = $RainLocalDB->RTU_NAME[$i];
			
			//10분
			$ClassRainInfo->getRainMValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_M'] = $ClassRainInfo->RAIN_M;
			
			//전시간
			$ClassRainInfo->getRainBHValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_BH'] = $ClassRainInfo->RAIN_BH;
			
			//시간
			$ClassRainInfo->getRainHValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_H'] = $ClassRainInfo->RAIN_H;
			
			//금일
			$ClassRainInfo->getRainDValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_D'] = $ClassRainInfo->RAIN_D;
			
			//전일
			$ClassRainInfo->getRainBDValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_BD'] = $ClassRainInfo->RAIN_BD;
			
			//월간
			$ClassRainInfo->getRainNValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_N'] = $ClassRainInfo->RAIN_N;
			
			//년간
			$ClassRainInfo->getRainYValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['RAIN_Y'] = $ClassRainInfo->RAIN_Y;
			
			//통신상태
			$ClassRainInfo->getRainCallValue($RainLocalDB->AREA_CODE[$i]);
			$data_rain[$i]['CALL_LAST'] = $ClassRainInfo->CALL_LAST;
		}
		$rain_cnt = $i;
		
		$returnBody = array( 'list' => $data_rain );
		echo json_encode( $returnBody );
	break;
	
	// 수위 테이블
	case 'flow':
		//수위
		$FlowLocalDB = new ClassRtuInfo($DB, 1);
		$FlowLocalDB->getRtuInfo();
		
		//수위자료
		$ClassFlowinfo = new ClassFlowinfo($DB);
		
		for($i=0; $i<$FlowLocalDB->rsCnt; $i++) {
			//지역코드
			$data_flow[$i]['AREA_CODE'] = $FlowLocalDB->AREA_CODE[$i];
			
			//장비이름
			$data_flow[$i]['RTU_NAME'] = $FlowLocalDB->RTU_NAME[$i];
			
			//전시간
			$ClassFlowinfo->getFlowBNValue($FlowLocalDB->AREA_CODE[$i]);
			$data_flow[$i]['FLOW_BN'] = $ClassFlowinfo->FLOW_BN;
			
			//현재
			$ClassFlowinfo->getFlowNValue($FlowLocalDB->AREA_CODE[$i]);
			$data_flow[$i]['FLOW_N'] = $ClassFlowinfo->FLOW_N;
			
			//경계
			$data_flow[$i]['FLOW_WARNING'] = $FlowLocalDB->FLOW_WARNING[$i];
			
			//위험
			$data_flow[$i]['FLOW_DANGER'] = $FlowLocalDB->FLOW_DANGER[$i];

			//1단계
			$data_flow[$i]['FLOW_LEVEL1'] = $FlowLocalDB->FLOW_LEVEL1[$i];
			
			//2단계
			$data_flow[$i]['FLOW_LEVEL2'] = $FlowLocalDB->FLOW_LEVEL2[$i];
			
			if(level_cnt == 3){
				//3단계
				$data_flow[$i]['FLOW_LEVEL3'] = $FlowLocalDB->FLOW_LEVEL3[$i];
			}else if(level_cnt == 4){
				//3단계
				$data_flow[$i]['FLOW_LEVEL3'] = $FlowLocalDB->FLOW_LEVEL3[$i];
				
			}else if(level_cnt == 5){
				//3단계
				$data_flow[$i]['FLOW_LEVEL3'] = $FlowLocalDB->FLOW_LEVEL3[$i];
				
				//4단계
				$data_flow[$i]['FLOW_LEVEL4'] = $FlowLocalDB->FLOW_LEVEL4[$i];
				
				//5단계
				$data_flow[$i]['FLOW_LEVEL5'] = $FlowLocalDB->FLOW_LEVEL5[$i];
			}
			
			//통신상태
			$ClassFlowinfo->getFlowCallValue($FlowLocalDB->AREA_CODE[$i]);
			$data_flow[$i]['CALL_LAST'] = $ClassFlowinfo->CALL_LAST;
		}
		$flow_cnt = $i;
		
		$returnBody = array( 'list' => $data_flow );
		echo json_encode( $returnBody );
	break;

	// 변위 테이블
	case 'disp':
		//강우
		$DispLocalDB = new ClassRtuInfo($DB, 4);
		$DispLocalDB->getDispRtuInfo();
		
		//강우자료
		$ClassDispInfo = new ClassDispInfo($DB);
		
		for($i=0; $i<$DispLocalDB->rsCnt; $i++){
			//지역코드
			if(DISP_GROUP == "1"){
				$data_disp[$i]['AREA_CODE'] = $DispLocalDB->SENSOR_AREA_CODE[$i];
			}else{
				$data_disp[$i]['AREA_CODE'] = $DispLocalDB->AREA_CODE[$i];
			}
			
			//장비이름
			$data_disp[$i]['RTU_NAME'] = $DispLocalDB->RTU_NAME[$i];
			
			//10분
			$ClassDispInfo->getDispMValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_M'] = $ClassDispInfo->DISPLACEMENT_M;
			$data_disp[$i]['DISPLACEMENT_DIFFDATE'] = $ClassDispInfo->DISPLACEMENT_DIFFDATE;

			//1시간 변화량
			$ClassDispInfo->getDispSumH($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_BH_DIFF'] = $ClassDispInfo->DISPLACEMENT_BH_DIFF;
			
			//1일간 변화량
			$ClassDispInfo->getDispSumD($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_D_DIFF'] = $ClassDispInfo->DISPLACEMENT_D_DIFF;

			//1월간 변화량
			$ClassDispInfo->getDispSumN($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_N_DIFF'] = $ClassDispInfo->DISPLACEMENT_N_DIFF;

			//전시간
			$ClassDispInfo->getDispBHValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_BH'] = $ClassDispInfo->DISPLACEMENT_BH;
			
			//시간
			$ClassDispInfo->getDispHValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_H'] = $ClassDispInfo->DISPLACEMENT_H;
			
			//금일
			$ClassDispInfo->getDispDValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_D'] = $ClassDispInfo->DISPLACEMENT_D;
			
			//전일
			$ClassDispInfo->getDispBDValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_BD'] = $ClassDispInfo->DISPLACEMENT_BD;
			
			//월간
			$ClassDispInfo->getDispNValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_N'] = $ClassDispInfo->DISPLACEMENT_N;
			
			//년간
			$ClassDispInfo->getDispYValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['DISPLACEMENT_Y'] = $ClassDispInfo->DISPLACEMENT_Y;
			
			//통신상태
			$ClassDispInfo->getDispCallValue($data_disp[$i]['AREA_CODE']);
			$data_disp[$i]['CALL_LAST'] = $ClassDispInfo->CALL_LAST;
		}
		$rain_cnt = $i;
		
		$returnBody = array( 'list' => $data_disp );
		echo json_encode( $returnBody );
	break;
	
	// aws 테이블
	case 'aws':
		//강우
		$RainLocalDB = new ClassRtuInfo($DB, 0);
		$RainLocalDB->getRtuInfo();
		//aws
		$AwsLocalDB = new ClassRtuInfo($DB, 3);
		$AwsLocalDB->getRtuInfo();
		
		//강우자료
		$ClassRainInfo = new ClassRainInfo($DB);
		//aws자료
		$ClassAwsInfo = new ClassAwsInfo($DB);
		$data_sensor['ATMO'] = 0;
		$data_sensor['RADI'] = 0;
		$data_sensor['SUNS'] = 0;
		for($i=0; $i<$AwsLocalDB->rsCnt; $i++) {
			//지역코드
			$data_aws[$i]['AREA_CODE'] = $AwsLocalDB->AREA_CODE[$i];

			$data_sensor['ATMO'] += $AwsLocalDB->ATMO[$i];
			$data_sensor['RADI'] += $AwsLocalDB->RADI[$i];
			$data_sensor['SUNS'] += $AwsLocalDB->SUNS[$i];
			
			//장비이름
			$data_aws[$i]['RTU_NAME'] = $AwsLocalDB->RTU_NAME[$i];
			
			//강우 시간
			$ClassRainInfo->getRainHValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['RAIN_H'] = $ClassRainInfo->RAIN_H;
			
			//강우 금일
			$ClassRainInfo->getRainDValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['RAIN_D'] = $ClassRainInfo->RAIN_D;
			
			//온도 현재
			$ClassAwsInfo->getTempNValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['TEMP_N'] = $ClassAwsInfo->TEMP_N;
			
			//온도 최고최저
			$ClassAwsInfo->getTempValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['TEMP_MAX'] = $ClassAwsInfo->TEMP_MAX;
			$data_aws[$i]['TEMP_MIN'] = $ClassAwsInfo->TEMP_MIN;

			//기압 현재
			$ClassAwsInfo->getAtmoNValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['ATMO_N'] = $ClassAwsInfo->ATMO_N;
			
			//기압 최고최저
			$ClassAwsInfo->getAtmoValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['ATMO_MAX'] = $ClassAwsInfo->ATMO_MAX;
			$data_aws[$i]['ATMO_MIN'] = $ClassAwsInfo->ATMO_MIN;
			
			//풍향풍속 현재 
			$ClassAwsInfo->getWindNValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['WIND_DEG'] = $ClassAwsInfo->WIND_DEG;
			$data_aws[$i]['WIND_VEL'] = $ClassAwsInfo->WIND_VEL;
			
			//풍향풍속 최대
			$ClassAwsInfo->getWindMaxValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['WIND_MAX_DEG'] = $ClassAwsInfo->WIND_MAX_DEG;
			$data_aws[$i]['WIND_MAX_VEL'] = $ClassAwsInfo->WIND_MAX_VEL;
			
			//습도 현재
			$ClassAwsInfo->getHumiNValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['HUMI_N'] = $ClassAwsInfo->HUMI_N;
			
			//습도 최고최저
			$ClassAwsInfo->getHumiValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['HUMI_MAX'] = $ClassAwsInfo->HUMI_MAX;
			$data_aws[$i]['HUMI_MIN'] = $ClassAwsInfo->HUMI_MIN;
			
			//통신상태
			$ClassAwsInfo->getAwsCallValue($AwsLocalDB->AREA_CODE[$i]);
			$data_aws[$i]['CALL_LAST'] = $ClassAwsInfo->CALL_LAST;
		}
		$aws_cnt = $i;
		
		$returnBody = array( 'list' => $data_aws , 'sensor' => $data_sensor);
		echo json_encode( $returnBody );
	break;
		
	// 적설 테이블
	case 'snow':
		//적설
		$SnowLocalDB = new ClassRtuInfo($DB, 2);
		$SnowLocalDB->getRtuInfo();
		
		//적설자료
		$ClassSnowInfo = new ClassSnowInfo($DB);
		
		for($i=0; $i<$SnowLocalDB->rsCnt; $i++) {
			$ClassSnowInfo->getSnowBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BM 전일 마지막 적설
			$ClassSnowInfo->getSnowBMAXValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BM 전일 최심 적설
			$ClassSnowInfo->getSnowBBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BBM 전전일 최심 적설
			$ClassSnowInfo->getSnowDMAXValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_MAX
			
			//전일신적설 계산
			// if($ClassSnowInfo->SNOW_BMAX - $ClassSnowInfo->SNOW_BBM > 0) {
			// 	$BM_TEMP = $ClassSnowInfo->SNOW_BMAX - $ClassSnowInfo->SNOW_BBM;
			// }else {
			// 	if($ClassSnowInfo->SNOW_BBM > 0){
			// 		$BM_TEMP = 0;
			// 	}else{
			// 		$BM_TEMP = $ClassSnowInfo->SNOW_BMAX;
			// 	}
			// }
			if($ClassSnowInfo->SNOW_MAX != '-' || $ClassSnowInfo->SNOW_MAX != '-'){
				//금일신적설 계산
				if($ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM > 0) {
					$M_TEMP = $ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM;
				}else {
					if($ClassSnowInfo->SNOW_BM > 0){
						$M_TEMP = 0;
					}else{
						$M_TEMP = $ClassSnowInfo->SNOW_MAX;
					}
				}
			}else{
				$M_TEMP = '-';
			}
			
			//지역코드
			$data_snow[$i]['AREA_CODE'] = $SnowLocalDB->AREA_CODE[$i];
			
			//장비이름
			$data_snow[$i]['RTU_NAME'] = $SnowLocalDB->RTU_NAME[$i];
			
			//전일신적설
			// $data_snow[$i]['SNOW_SBM'] = $BM_TEMP;

			//전일최심적설
			$data_snow[$i]['SNOW_SBM'] = $ClassSnowInfo->SNOW_BMAX;
			
			//전일적설
			$data_snow[$i]['SNOW_BM'] = $ClassSnowInfo->SNOW_BM;
			
			//금일신적설
			$data_snow[$i]['SNOW_SM'] = $M_TEMP;
			
			//현재적설
			$ClassSnowInfo->getSnowMValue($SnowLocalDB->AREA_CODE[$i]);
			$data_snow[$i]['SNOW_M'] = $ClassSnowInfo->SNOW_M;
			
			/*
			//금일적설
			$ClassSnowInfo->getSnowDValue($SnowLocalDB->AREA_CODE[$i]);
			$data_snow[$i]['SNOW_D'] = $ClassSnowInfo->SNOW_D;
			*/
			
			//금일최고 적설
			$data_snow[$i]['SNOW_D'] = $ClassSnowInfo->SNOW_MAX;
			
			//통신상태
			$ClassSnowInfo->getSnowCallValue($SnowLocalDB->AREA_CODE[$i]);
			$data_snow[$i]['CALL_LAST'] = $ClassSnowInfo->CALL_LAST;
		}
		$snow_cnt = $i;
		
		$returnBody = array( 'list' => $data_snow );
		echo json_encode( $returnBody );
	break;
	
	// 방송현황 테이블
	case 'alarm':
		//최근방송 현황
		$ClassBroadCast = new ClassBroadCast($DB);
		
		$ClassBroadCast->getBroadCastList('', '');
		$data_alarm = $ClassBroadCast->rsBroadCastList;
			
		$returnBody = array( 'list' => $data_alarm );
		echo json_encode( $returnBody );
	break;
		
	// 경보현황 테이블
	case 'alert':
		$ClassBroadCast = new ClassBroadCast($DB);
		
		//경보그룹 현황
		$ClassBroadCast->getAlertGroupList();
		$data_group = $ClassBroadCast->rsAlertGroupList;
		
		//최근경보 현황
		$ClassBroadCast->getAlertList('', '');
		$data_alert = $ClassBroadCast->rsAlertList;
		
		$returnBody = array( 'group' => $data_group, 'list' => $data_alert );
		echo json_encode( $returnBody );
	break;
		
	// 이전 장비상태 테이블
	case 'equip':
		//장비상태
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getRtuStateList();
		$data_equip = $ClassEquip->rsRtuStateList;
		
		// var_dump($data_equip);

		$returnBody = array( 'list' => $data_equip );
		echo json_encode( $returnBody );
	break;
	
	// 장비상태 테이블 수정
	case 'totalEquip':
		//장비상태
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getTotalRtuStateList();
		$data_equip = $ClassEquip->rsRtuStateList;
		
		// var_dump($data_equip);

		$returnBody = array( 'list' => $data_equip );
		echo json_encode( $returnBody );
	break;
	
	// 스피커상태 테이블
	case 'speaker':
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getSpeakerStateList();
		$data_speaker = $ClassEquip->rsSpeakerStateList;
		
		$returnBody = array( 'list' => $data_speaker );
		echo json_encode( $returnBody );
	break;	

	// 그룹별 장비상태 테이블
	case 'group_equip':
		//장비상태
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getGroupStateList();
		
		$state_equip = $ClassEquip->rsRtuStateList;
		
		$returnBody = array( 'list' => $state_equip );
		echo json_encode( $returnBody );
	break;

	// 스마트베터리장치 상태 테이블
	case 'smart_equip_monitoring':
		//장비상태
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getSmartPowerList();
		
		$smart_equip = $ClassEquip->rsSmartPowerList;
		// var_dump($smart_equip);
		$returnBody = array( 'list' => $smart_equip );
		echo json_encode( $returnBody );
	break;

	// 일반베터리장치 상태 테이블
	case 'equip_monitoring':
		//장비상태
		$ClassEquip = new ClassRtuInfo($DB);
		
		$ClassEquip->getStateHistList();
		
		$equip_hist = $ClassEquip->rsStateHistList;
		// var_dump($equip_hist);
		$returnBody = array( 'list' => $equip_hist );
		echo json_encode( $returnBody );
	break;
		
		// 강우 주요지점 테이블
		case 'rain_main':
			//강우
			$RainLocalDB = new ClassRtuInfo($DB, 0, 1);
			$RainLocalDB->getRtuInfo();
			
			//강우자료
			$ClassRainInfo = new ClassRainInfo($DB);
			
			for($i=0; $i<$RainLocalDB->rsCnt; $i++){
				//지역코드
				$data_rain[$i]['AREA_CODE'] = $RainLocalDB->AREA_CODE[$i];
				
				//주요지점
				$data_rain[$i]['GROUP_ID'] = $RainLocalDB->GROUP_ID[$i];
				$data_rain[$i]['GROUP_NAME'] = $RainLocalDB->GROUP_NAME[$i];
				
				//장비이름
				$data_rain[$i]['RTU_NAME'] = $RainLocalDB->RTU_NAME[$i];
				
				//10분
				$ClassRainInfo->getRainMValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_M'] = $ClassRainInfo->RAIN_M;
				
				//전시간
				$ClassRainInfo->getRainBHValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_BH'] = $ClassRainInfo->RAIN_BH;
				
				//시간
				$ClassRainInfo->getRainHValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_H'] = $ClassRainInfo->RAIN_H;
				
				//금일
				$ClassRainInfo->getRainDValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_D'] = $ClassRainInfo->RAIN_D;
				
				//전일
				$ClassRainInfo->getRainBDValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_BD'] = $ClassRainInfo->RAIN_BD;
				
				//월간
				$ClassRainInfo->getRainNValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_N'] = $ClassRainInfo->RAIN_N;
				
				//년간
				$ClassRainInfo->getRainYValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_Y'] = $ClassRainInfo->RAIN_Y;
				
				//통신상태
				$ClassRainInfo->getRainCallValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['CALL_LAST'] = $ClassRainInfo->CALL_LAST;
			}
			$rain_cnt = $i;
			
			$returnBody = array( 'list' => $data_rain );
			echo json_encode( $returnBody );
		break;
	
		// 강우 읍면동 그룹 테이블
		case 'rain_emd_main':
			//강우
			$RainLocalDB = new ClassRtuInfo($DB, 0, 2);
			$RainLocalDB->getRtuInfo();
			
			//강우자료
			$ClassRainInfo = new ClassRainInfo($DB);
			
			for($i=0; $i<$RainLocalDB->rsCnt; $i++){
				//지역코드
				$data_rain[$i]['AREA_CODE'] = $RainLocalDB->AREA_CODE[$i];
				
				//주요지점
				$data_rain[$i]['GROUP_ID'] = $RainLocalDB->GROUP_ID[$i];
				$data_rain[$i]['GROUP_NAME'] = $RainLocalDB->GROUP_NAME[$i];
				
				$data_rain[$i]['WR_EMD_CD'] = $RainLocalDB->WR_EMD_CD[$i];
				$data_rain[$i]['DONG'] = $RainLocalDB->DONG[$i];
				//장비이름
				$data_rain[$i]['RTU_NAME'] = $RainLocalDB->RTU_NAME[$i];
				$data_rain[$i]['ORGAN_NAME'] = $RainLocalDB->ORGAN_NAME[$i];
				// if($RainLocalDB->REAL_ORGAN_CODE[$i] == "1"){
				// 	$data_rain[$i]['REAL_ORGAN_CODE'] = "파주시";
				// }else if($RainLocalDB->REAL_ORGAN_CODE[$i] == "2"){
				// 	$data_rain[$i]['REAL_ORGAN_CODE'] = "경기도청";
				// }else if($RainLocalDB->REAL_ORGAN_CODE[$i] == "3"){
				// 	$data_rain[$i]['REAL_ORGAN_CODE'] = "기상청";
				// }else if($RainLocalDB->REAL_ORGAN_CODE[$i] == "4"){
				// 	$data_rain[$i]['REAL_ORGAN_CODE'] = "한강홍수통제소";
				// }
				
				//10분
				$ClassRainInfo->getRainMValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_M'] = $ClassRainInfo->RAIN_M;
				
				//전시간
				$ClassRainInfo->getRainBHValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_BH'] = $ClassRainInfo->RAIN_BH;
				
				//시간
				$ClassRainInfo->getRainHValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_H'] = $ClassRainInfo->RAIN_H;
				
				//금일
				$ClassRainInfo->getRainDValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_D'] = $ClassRainInfo->RAIN_D;
				
				//전일
				$ClassRainInfo->getRainBDValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_BD'] = $ClassRainInfo->RAIN_BD;
				
				//월간
				$ClassRainInfo->getRainNValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_N'] = $ClassRainInfo->RAIN_N;
				
				//년간
				$ClassRainInfo->getRainYValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['RAIN_Y'] = $ClassRainInfo->RAIN_Y;
				
				//통신상태
				$ClassRainInfo->getRainCallValue($RainLocalDB->AREA_CODE[$i]);
				$data_rain[$i]['CALL_LAST'] = $ClassRainInfo->CALL_LAST;
			}
			$rain_cnt = $i;
			
			$returnBody = array( 'list' => $data_rain );
			echo json_encode( $returnBody );
		break;
			
		// 수위 주요지점 테이블
		case 'flow_main':
			//수위
			$FlowLocalDB = new ClassRtuInfo($DB, 1, 1);
			$FlowLocalDB->getRtuInfo();
			
			//수위자료
			$ClassFlowinfo = new ClassFlowinfo($DB);
			
			for($i=0; $i<$FlowLocalDB->rsCnt; $i++) {
				//지역코드
				$data_flow[$i]['AREA_CODE'] = $FlowLocalDB->AREA_CODE[$i];
				
				//주요지점
				$data_flow[$i]['GROUP_ID'] = $FlowLocalDB->GROUP_ID[$i];
				$data_flow[$i]['GROUP_NAME'] = $FlowLocalDB->GROUP_NAME[$i];
				
				//장비이름
				$data_flow[$i]['RTU_NAME'] = $FlowLocalDB->RTU_NAME[$i];
				$data_flow[$i]['ORGAN_NAME'] = $FlowLocalDB->ORGAN_NAME[$i];
				// if($FlowLocalDB->REAL_ORGAN_CODE[$i] == "1"){
				// 	$data_flow[$i]['REAL_ORGAN_CODE'] = "파주시";
				// }else if($FlowLocalDB->REAL_ORGAN_CODE[$i] == "2"){
				// 	$data_flow[$i]['REAL_ORGAN_CODE'] = "경기도청";
				// }else if($FlowLocalDB->REAL_ORGAN_CODE[$i] == "3"){
				// 	$data_flow[$i]['REAL_ORGAN_CODE'] = "기상청";
				// }else if($FlowLocalDB->REAL_ORGAN_CODE[$i] == "4"){
				// 	$data_flow[$i]['REAL_ORGAN_CODE'] = "한강홍수통제소";
				// }

				
				//전시간
				$ClassFlowinfo->getFlowBNValue($FlowLocalDB->AREA_CODE[$i]);
				$data_flow[$i]['FLOW_BN'] = $ClassFlowinfo->FLOW_BN;
				
				//현재
				$ClassFlowinfo->getFlowNValue($FlowLocalDB->AREA_CODE[$i]);
				$data_flow[$i]['FLOW_N'] = $ClassFlowinfo->FLOW_N;
				
				//1단계
				$data_flow[$i]['FLOW_LEVEL1'] = $FlowLocalDB->FLOW_LEVEL1[$i];
				
				//2단계
				$data_flow[$i]['FLOW_LEVEL2'] = $FlowLocalDB->FLOW_LEVEL2[$i];
				
				if(level_cnt == 3 || level_cnt == 4){
					//3단계
					$data_flow[$i]['FLOW_LEVEL3'] = $FlowLocalDB->FLOW_LEVEL3[$i];
				}else if(level_cnt == 5){
					//3단계
					$data_flow[$i]['FLOW_LEVEL3'] = $FlowLocalDB->FLOW_LEVEL3[$i];
					
					//4단계
					$data_flow[$i]['FLOW_LEVEL4'] = $FlowLocalDB->FLOW_LEVEL4[$i];
					
					//5단계
					$data_flow[$i]['FLOW_LEVEL5'] = $FlowLocalDB->FLOW_LEVEL5[$i];
				}
				
				//통신상태
				$ClassFlowinfo->getFlowCallValue($FlowLocalDB->AREA_CODE[$i]);
				$data_flow[$i]['CALL_LAST'] = $ClassFlowinfo->CALL_LAST;
			}
			$flow_cnt = $i;
			
			$returnBody = array( 'list' => $data_flow );
			echo json_encode( $returnBody );
		break;
			
		// aws 주요지점 테이블
		case 'aws_main':
			//강우
			$RainLocalDB = new ClassRtuInfo($DB, 0, 1);
			$RainLocalDB->getRtuInfo();
			//aws
			$AwsLocalDB = new ClassRtuInfo($DB, 3, 1);
			$AwsLocalDB->getRtuInfo();
			
			//강우자료
			$ClassRainInfo = new ClassRainInfo($DB);
			//aws자료
			$ClassAwsInfo = new ClassAwsInfo($DB);
			
			for($i=0; $i<$AwsLocalDB->rsCnt; $i++) {
				//지역코드
				$data_aws[$i]['AREA_CODE'] = $AwsLocalDB->AREA_CODE[$i];
				
				//주요지점
				$data_aws[$i]['GROUP_ID'] = $AwsLocalDB->GROUP_ID[$i];
				$data_aws[$i]['GROUP_NAME'] = $AwsLocalDB->GROUP_NAME[$i];
				
				//장비이름
				$data_aws[$i]['RTU_NAME'] = $AwsLocalDB->RTU_NAME[$i];
				$data_aws[$i]['ORGAN_NAME'] = $AwsLocalDB->ORGAN_NAME[$i];
				// if($AwsLocalDB->REAL_ORGAN_CODE[$i] == "1"){
				// 	$data_aws[$i]['REAL_ORGAN_CODE'] = "파주시";
				// }else if($AwsLocalDB->REAL_ORGAN_CODE[$i] == "2"){
				// 	$data_aws[$i]['REAL_ORGAN_CODE'] = "경기도청";
				// }else if($AwsLocalDB->REAL_ORGAN_CODE[$i] == "3"){
				// 	$data_aws[$i]['REAL_ORGAN_CODE'] = "기상청";
				// }else if($AwsLocalDB->REAL_ORGAN_CODE[$i] == "4"){
				// 	$data_aws[$i]['REAL_ORGAN_CODE'] = "한강홍수통제소";
				// }
				
				//강우 시간
				$ClassRainInfo->getRainHValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['RAIN_H'] = $ClassRainInfo->RAIN_H;
				
				//강우 금일
				$ClassRainInfo->getRainDValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['RAIN_D'] = $ClassRainInfo->RAIN_D;
				
				//온도 현재
				$ClassAwsInfo->getTempNValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['TEMP_N'] = $ClassAwsInfo->TEMP_N;
				
				//온도 최고최저
				$ClassAwsInfo->getTempValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['TEMP_MAX'] = $ClassAwsInfo->TEMP_MAX;
				$data_aws[$i]['TEMP_MIN'] = $ClassAwsInfo->TEMP_MIN;
				
				//풍향풍속 현재
				$ClassAwsInfo->getWindNValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['WIND_DEG'] = $ClassAwsInfo->WIND_DEG;
				$data_aws[$i]['WIND_VEL'] = $ClassAwsInfo->WIND_VEL;
				
				//풍향풍속 최대
				$ClassAwsInfo->getWindMaxValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['WIND_MAX_DEG'] = $ClassAwsInfo->WIND_MAX_DEG;
				$data_aws[$i]['WIND_MAX_VEL'] = $ClassAwsInfo->WIND_MAX_VEL;
				
				//습도 현재
				$ClassAwsInfo->getHumiNValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['HUMI_N'] = $ClassAwsInfo->HUMI_N;
				
				//습도 최고최저
				$ClassAwsInfo->getHumiValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['HUMI_MAX'] = $ClassAwsInfo->HUMI_MAX;
				$data_aws[$i]['HUMI_MIN'] = $ClassAwsInfo->HUMI_MIN;
				
				//통신상태
				$ClassAwsInfo->getAwsCallValue($AwsLocalDB->AREA_CODE[$i]);
				$data_aws[$i]['CALL_LAST'] = $ClassAwsInfo->CALL_LAST;
			}
			$aws_cnt = $i;
			
			$returnBody = array( 'list' => $data_aws );
			echo json_encode( $returnBody );
		break;
			
		// 적설 주요지점 테이블
		case 'snow_main':
			//적설
			$SnowLocalDB = new ClassRtuInfo($DB, 2, 1);
			$SnowLocalDB->getRtuInfo();
			
			//적설자료
			$ClassSnowInfo = new ClassSnowInfo($DB);
			
			for($i=0; $i<$SnowLocalDB->rsCnt; $i++) {
				$ClassSnowInfo->getSnowBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BM 전일 마지막 적설
				$ClassSnowInfo->getSnowBMAXValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BM 전일 최심 적설
				$ClassSnowInfo->getSnowBBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BBM 전전일 최심 적설
				$ClassSnowInfo->getSnowDMAXValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_MAX
				
				//전일신적설 계산
				if($ClassSnowInfo->SNOW_BMAX - $ClassSnowInfo->SNOW_BBM > 0) {
					$BM_TEMP = $ClassSnowInfo->SNOW_BMAX - $ClassSnowInfo->SNOW_BBM;
				}else {
					if($ClassSnowInfo->SNOW_BBM > 0){
						$BM_TEMP = 0;
					}else{
						$BM_TEMP = $ClassSnowInfo->SNOW_BMAX;
					}
				}
				//금일신적설 계산
				if($ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM > 0) {
					$M_TEMP = $ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM;
				}else {
					if($ClassSnowInfo->SNOW_BM > 0){
						$M_TEMP = 0;
					}else{
						$M_TEMP = $ClassSnowInfo->SNOW_MAX;
					}
				}
				
				//지역코드
				$data_snow[$i]['AREA_CODE'] = $SnowLocalDB->AREA_CODE[$i];
				
				//주요지점
				$data_snow[$i]['GROUP_ID'] = $SnowLocalDB->GROUP_ID[$i];
				$data_snow[$i]['GROUP_NAME'] = $SnowLocalDB->GROUP_NAME[$i];
				
				//장비이름
				$data_snow[$i]['RTU_NAME'] = $SnowLocalDB->RTU_NAME[$i];
				
				//전일신적설
				// $data_snow[$i]['SNOW_SBM'] = $BM_TEMP;
	
				//전일최심적설
				$data_snow[$i]['SNOW_SBM'] = $ClassSnowInfo->SNOW_BMAX;
				
				//전일적설
				$data_snow[$i]['SNOW_BM'] = $ClassSnowInfo->SNOW_BM;
				
				//금일신적설
				$data_snow[$i]['SNOW_SM'] = $M_TEMP;
				
				//현재적설
				$ClassSnowInfo->getSnowMValue($SnowLocalDB->AREA_CODE[$i]);
				$data_snow[$i]['SNOW_M'] = $ClassSnowInfo->SNOW_M;
				
				/*
				 //금일적설
				 $ClassSnowInfo->getSnowDValue($SnowLocalDB->AREA_CODE[$i]);
				 $data_snow[$i]['SNOW_D'] = $ClassSnowInfo->SNOW_D;
				 */
				
				//금일최고 적설
				$data_snow[$i]['SNOW_D'] = $ClassSnowInfo->SNOW_MAX;
				
				//통신상태
				$ClassSnowInfo->getSnowCallValue($SnowLocalDB->AREA_CODE[$i]);
				$data_snow[$i]['CALL_LAST'] = $ClassSnowInfo->CALL_LAST;
			}
			$snow_cnt = $i;
			
			$returnBody = array( 'list' => $data_snow );
			echo json_encode( $returnBody );
		break;
		
	// 강우 평균 테이블
	case 'rain_avr':
		//강우자료
		$ClassRainInfo = new ClassRainInfo($DB);
		
		$ClassRainInfo->getRainMain();
		$data_rain = $ClassRainInfo->rsRainMain;
	
		$returnBody = array( 'list' => $data_rain );
		echo json_encode( $returnBody );
	break;
		
	// aws 평균 테이블
	case 'aws_avr':
		//aws자료
		$ClassAwsInfo = new ClassAwsInfo($DB);
		
		$ClassAwsInfo->getAwsMain();
		$data_aws = $ClassAwsInfo->rsAwsMain;
		
		$returnBody = array( 'list' => $data_aws );
		echo json_encode( $returnBody );
	break;
}

$DB->CLOSE();
?>


