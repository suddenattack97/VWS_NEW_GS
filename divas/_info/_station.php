<?
require_once "../../include/class/rtuInfo.php";
require_once "../../include/class/rainInfo.php";
require_once "../../include/class/flowInfo.php";
require_once "../../include/class/awsInfo.php";
require_once "../../include/class/snowInfo.php";
require_once "../../include/class/dispInfo.php";

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

	
//aws
$AwsLocalDB = new ClassRtuInfo($DB, 3);
$AwsLocalDB->getRtuInfo();
		
//aws자료
$ClassAwsInfo = new ClassAwsInfo($DB);
		
for($i=0; $i<$AwsLocalDB->rsCnt; $i++) {
	//지역코드
	$data_aws[$i]['AREA_CODE'] = $AwsLocalDB->AREA_CODE[$i];
			
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
			
	//풍향풍속 현재 
	$ClassAwsInfo->getWindNValue($AwsLocalDB->AREA_CODE[$i]);
	$data_aws[$i]['WIND_DEG'] = $ClassAwsInfo->WIND_DEG;
	$data_aws[$i]['WIND_VEL'] = $ClassAwsInfo->WIND_VEL;
			
	//풍향풍속 최대
	$ClassAwsInfo->getWindMaxValue($AwsLocalDB->AREA_CODE[$i]);
	$data_aws[$i]['WIND_MAX_DEG'] = $ClassAwsInfo->WIND_MAX_DEG;
	$data_aws[$i]['WIND_MAX_VEL'] = $ClassAwsInfo->WIND_MAX_VEL;
			
	//통신상태
	$ClassAwsInfo->getAwsCallValue($AwsLocalDB->AREA_CODE[$i]);
	$data_aws[$i]['CALL_LAST'] = $ClassAwsInfo->CALL_LAST;
}
$aws_cnt = $i;


//적설
$SnowLocalDB = new ClassRtuInfo($DB, 2);
$SnowLocalDB->getRtuInfo();
		
//적설자료
$ClassSnowInfo = new ClassSnowInfo($DB);
		
for($i=0; $i<$SnowLocalDB->rsCnt; $i++) {
	$ClassSnowInfo->getSnowBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BM
	$ClassSnowInfo->getSnowBBHValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_BBM
	$ClassSnowInfo->getSnowDMAXValue($SnowLocalDB->AREA_CODE[$i]); //SNOW_MAX
			
	//전일신적설 계산
	if($ClassSnowInfo->SNOW_BM - $ClassSnowInfo->SNOW_BBM > 0){
		$BM_TEMP = $ClassSnowInfo->SNOW_BM - $ClassSnowInfo->SNOW_BBM;
	}else{
		if($ClassSnowInfo->SNOW_BBM > 0){
			$BM_TEMP = 0;
		}else{
			$BM_TEMP = $ClassSnowInfo->SNOW_BM;
		}
	}
	//금일신적설 계산
	if($ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM > 0){
		$M_TEMP = $ClassSnowInfo->SNOW_MAX - $ClassSnowInfo->SNOW_BM;
	}else{
		if($ClassSnowInfo->SNOW_BM > 0){
			$M_TEMP = 0;
		}else{
			$M_TEMP = $ClassSnowInfo->SNOW_MAX;
		}
	}
			
	//지역코드
	$data_snow[$i]['AREA_CODE'] = $SnowLocalDB->AREA_CODE[$i];
			
	//장비이름
	$data_snow[$i]['RTU_NAME'] = $SnowLocalDB->RTU_NAME[$i];
			
	//전일신적설
	$data_snow[$i]['SNOW_SBM'] = $BM_TEMP;
			
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



//변위
$DispLocalDB = new ClassRtuInfo($DB, 4);
$DispLocalDB->getRtuInfo();
		
//변위자료
$ClassDispInfo = new ClassDispInfo($DB);
		
for($i=0; $i<$DispLocalDB->rsCnt; $i++){
	//지역코드
	$data_disp[$i]['AREA_CODE'] = $DispLocalDB->AREA_CODE[$i];
	
	//장비이름
	$data_disp[$i]['RTU_NAME'] = $DispLocalDB->RTU_NAME[$i];
	
	//10분
	$ClassDispInfo->getDispMValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_M'] = $ClassDispInfo->DISPLACEMENT_M;
	$data_disp[$i]['DISPLACEMENT_DIFFDATE'] = $ClassDispInfo->DISPLACEMENT_DIFFDATE;

	//1시간 변화량
	$ClassDispInfo->getDispSumH($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_BH_DIFF'] = $ClassDispInfo->DISPLACEMENT_BH_DIFF;
	
	//1일간 변화량
	$ClassDispInfo->getDispSumD($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_D_DIFF'] = $ClassDispInfo->DISPLACEMENT_D_DIFF;

	//1월간 변화량
	$ClassDispInfo->getDispSumN($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_N_DIFF'] = $ClassDispInfo->DISPLACEMENT_N_DIFF;

	//전시간
	$ClassDispInfo->getDispBHValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_BH'] = $ClassDispInfo->DISPLACEMENT_BH;
	
	//시간
	$ClassDispInfo->getDispHValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_H'] = $ClassDispInfo->DISPLACEMENT_H;
	
	//금일
	$ClassDispInfo->getDispDValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_D'] = $ClassDispInfo->DISPLACEMENT_D;
	
	//전일
	$ClassDispInfo->getDispBDValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_BD'] = $ClassDispInfo->DISPLACEMENT_BD;
	
	//월간
	$ClassDispInfo->getDispNValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_N'] = $ClassDispInfo->DISPLACEMENT_N;
	
	//년간
	$ClassDispInfo->getDispYValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['DISPLACEMENT_Y'] = $ClassDispInfo->DISPLACEMENT_Y;
	
	//통신상태
	$ClassDispInfo->getDispCallValue($DispLocalDB->AREA_CODE[$i]);
	$data_disp[$i]['CALL_LAST'] = $ClassDispInfo->CALL_LAST;
}

$disp_cnt = $i;

$DB->CLOSE();
?>


