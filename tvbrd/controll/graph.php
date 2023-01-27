<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");

#################################################################################################################################
# DB connection
#################################################################################################################################
require_once "../db/_Db.php";

#################################################################################################################################
# class 및 function lib
#################################################################################################################################
require_once "../class/DateMake.php";#시간 class
require_once "../class/Divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
require_once "../class/RtuInfo.php";//지역 Class

require_once "../class/RainInfo.php";#강우 class
require_once "../class/FlowInfo.php";#수위 class
require_once "../class/SnowInfo.php";#적설 class
require_once "../class/WindInfo.php";#풍속 class
require_once "../class/HumiInfo.php";#습도 class
require_once "../class/TempInfo.php";#온도 class
require_once "../class/AtmoInfo.php";#기압 class
require_once "../class/DisplaceInfo.php";#변위 class


#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();

    $mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
    $kind =  $dvUtil->xss_clean($_REQUEST["kind"]);
    $option =  $dvUtil->xss_clean($_REQUEST["option"]);
    $area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
	    case 'graph_slide':
	    $RtuInfo = new RtuInfo($DB);
	    
		if($kind == "flow" || $kind == "disp"){
			$RtuInfo->getRtuNameAndLevel($area_code);
		} else {
			$RtuInfo->getRtuName($area_code);
		}
	    
	    $startdate = $DM->getStartHour( date("Y-m-d 00", strtotime("-1 days")) );
	    $enddate = $DM->getEndHour( date("Y-m-d 23") );
	    
	    if(TEST == "1"){
	    	$startdate = $DM->getStartHour("2018-05-31 00");
	    	$enddate = $DM->getEndHour("2018-05-31 23");
	    }
	    
	    // 데이터
	    $arr_data = array();
	    
	    if($kind == "rain"){
	    	$RainInfo = new RainInfo($DB,$DM, $dvUtil); // 강우
	    	$tmpInfo = $RainInfo;
	    }else if($kind == "flow"){
	    	$FlowInfo = new FlowInfo($DB,$DM, $dvUtil); // 수위
	    	$tmpInfo = $FlowInfo;
	    }else if($kind == "snow"){
	    	$SnowInfo = new SnowInfo($DB,$DM, $dvUtil); // 적설
	    	$tmpInfo = $SnowInfo;
	    }else if($kind == "wind"){
	    	$WindInfo = new WindInfo($DB,$DM, $dvUtil); // 풍속
	    	$tmpInfo = $WindInfo;
	    }else if($kind == "damp"){
	    	$HumiInfo = new HumiInfo($DB,$DM, $dvUtil); // 습도
	    	$tmpInfo = $HumiInfo;
	    }else if($kind == "temp"){
	    	$TempInfo = new TempInfo($DB,$DM, $dvUtil); // 온도
	    	$tmpInfo = $TempInfo;
	    }else if($kind == "pres"){
	    	$AtmoInfo = new AtmoInfo($DB,$DM, $dvUtil); // 기압
	    	$tmpInfo = $AtmoInfo;
	    }else if($kind == "disp"){
	    	$AtmoInfo = new DisplaceInfo($DB,$DM, $dvUtil); // 기압
	    	$tmpInfo = $AtmoInfo;
		}
		$calc = 1;
	    if($tmpInfo){
			if($kind == "flow" || $kind == "disp"){
				if($kind == "disp"){
					$calc = 0.01;
				}
				$tmpInfo->getTimeListValue( $area_code, $option, $startdate, $enddate);
				for($i=0; $i<$tmpInfo->rsCnt; $i++){
					$arr_data[$i]['num'] = $tmpInfo->Num[$i];
					$arr_data[$i]['date'] = $tmpInfo->TimeListDateValue[$i];
					$arr_data[$i]['data'] = $tmpInfo->TimeListValue[$i];
					$arr_data[$i]['data1'] = $RtuInfo->level1*$calc;
					$arr_data[$i]['data2'] = $RtuInfo->level2*$calc;
				}
			}else{
				$tmpInfo->getTimeListValue( $area_code, $option, $startdate, $enddate);
				for($i=0; $i<$tmpInfo->rsCnt; $i++){
					$arr_data[$i]['num'] = $tmpInfo->Num[$i];
					$arr_data[$i]['date'] = $tmpInfo->TimeListDateValue[$i];
					$arr_data[$i]['data'] = $tmpInfo->TimeListValue[$i];
				}
			}
			// if(count($arr_data) % 2 == 0) {
				$arr_data[$i]['num'] = '';
				$arr_data[$i]['date'] = '';
				$arr_data[$i]['data'] = '-';
			// }
	    }
	    
	    $resultArr["rtuname"] = $RtuInfo->RTU_NAME;
	    $resultArr["hour"] = $arr_data;
	
	 	$returnBody = array( 'result' => true, 'data' => $resultArr );
		echo json_encode( $returnBody );
		exit;
	
	    break;
    }
?>
