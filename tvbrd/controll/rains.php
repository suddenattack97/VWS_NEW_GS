<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지역 강우데이터
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
require_once "../class/divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
require_once "../class/RtuInfo.php";//지역 Class

require_once "../class/RainInfo.php";#강우 class




#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
$AwsLocalDB = new RtuInfo($DB,0);//장비
$RainInfo = new RainInfo($DB,$DM, $dvUtil);//강우


    $mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
    $area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'rains':
    $AwsLocalDB->getRtuInfo();
    for($i=0; $i<$AwsLocalDB->rsCnt; $i++) {
         $resultArr[$i]["rtuname"]   = rawurlencode( $AwsLocalDB->RTU_NAME[$i]);
         $area_code = $AwsLocalDB->AREA_CODE[$i];

        //강수유무 (비가 0mm 이상이면 "유" 로 나옴)
        $RainInfo->getBsensingValue($area_code);
        $resultArr[$i]["rainuse"] = $RainInfo->BsenSingValue;

        //전일강우
        $RainInfo->getBefDayValue($area_code);
        $rainbefday += $resultArr[$i]["rainbefday"] =  $RainInfo->BefDayValue;

        //강우(금일)
        $RainInfo->getNowDayValue($area_code);
        $rainday += $resultArr[$i]["rainday"] =  $RainInfo->NowDayValue;

        //강우(월간)
        $RainInfo->getNowMonValue($area_code);
        $rainmon += $resultArr[$i]["rainmon"] =  $RainInfo->NowMonValue;

        //강우(년간)
        $RainInfo->getYearSumValue($area_code);
        $resultArr[$i]["rainyear"] = $RainInfo->YearSumValue;

        //강우(이전시간)
        $RainInfo->getBefTimeValue($area_code);
        $rainbeftime += $resultArr[$i]["rainbeftime"] = $RainInfo->BefTimeValue;

        //강우(현재시간)
        $RainInfo->getNowTimeValue($area_code);
        $rainnowtime += $resultArr[$i]["rainnowtime"] = $RainInfo->NowTimeValue;
    }

        $presultArr["prainbefday"] =  round($rainbefday/$AwsLocalDB->rsCnt,1);
        $presultArr["prainday"] =   round($rainday/$AwsLocalDB->rsCnt,1);
        $presultArr["prainmon"] =   round($rainmon/$AwsLocalDB->rsCnt,1);
        $presultArr["prainbeftime"] =   round($rainbeftime/$AwsLocalDB->rsCnt,1);
        $presultArr["prainnowtime"] =   round($rainnowtime/$AwsLocalDB->rsCnt,1);

        $returnBody = array( 'result' => true, 'data' => $resultArr,  'ddata' => $presultArr );
         echo json_encode( $returnBody );
        exit;

    break;
    }
?>
