<?
require_once "../include/class/broadcast.php";

$STAT_TERM = $_REQUEST['STAT_TERM'] ? $_REQUEST['STAT_TERM'] : "N"; // 검색기간
$STAT_DATE = $_REQUEST['STAT_DATE'] ? $_REQUEST['STAT_DATE'] : date("Y-m-d"); // 날짜
$STAT_TYPE = $_REQUEST['STAT_TYPE'] ? $_REQUEST['STAT_TYPE'] : "0"; // 통계유형
$yy = substr($STAT_DATE, 0, 4);
$mm = substr($STAT_DATE, 5, 2);
$dd = substr($STAT_DATE, 8, 2);

if($STAT_TERM == "D"){
	$scnt = 1;
	$ecnt = date("t", strtotime($STAT_DATE));
	$isdate = $yy."-".$mm."-01 00:00:00";
	$iedate = $yy."-".$mm."-".$ecnt." 23:59:59";
}else if($STAT_TERM == "N"){
	$scnt = 1;
	$ecnt = 12;
	$isdate = $yy."-01-01 00:00:00";
	$iedate = $yy."-12-31 23:59:59";
}

//방송
$ClassBroadCast = new ClassBroadCast($DB);

if($STAT_TYPE == "0"){
	$ClassBroadCast->getBroadcastCnt($isdate, $iedate, $STAT_TERM);
	
	if($ClassBroadCast->rsBroadcastCnt){
		foreach($ClassBroadCast->rsBroadcastCnt as $key => $val){
			$data_list[ $val['RTU_ID'] ]['RTU_NAME'] = $val['RTU_NAME'];
			$data_list[ $val['RTU_ID'] ]['CNT'][ $val['NUM'] ] = $val['CNT'];
			$data_list[ $val['RTU_ID'] ]['SUM'] += $val['CNT'];
		}
	}
}else if($STAT_TYPE == "1"){
	$ClassBroadCast->getIsPlanCnt($isdate, $iedate, $STAT_TERM);
	
	if($ClassBroadCast->rsIsPlanCnt){
		foreach($ClassBroadCast->rsIsPlanCnt as $key => $val){
			$data_list['NOW'][$key]['T'] = $val['CNT0_T'];
			$data_list['NOW'][$key]['F'] = $val['CNT0_F'];
			$data_list['NOW'][$key]['C'] = $val['CNT0'];
			$data_list['NOW_TS'] += $val['CNT0_T'];
			$data_list['NOW_FS'] += $val['CNT0_F'];
			$data_list['NOW_CS'] += $val['CNT0'];
			$data_list['PLAN'][$key]['T'] = $val['CNT1_T'];
			$data_list['PLAN'][$key]['F'] = $val['CNT1_F'];
			$data_list['PLAN'][$key]['C'] = $val['CNT1'];
			$data_list['PLAN_TS'] += $val['CNT1_T'];
			$data_list['PLAN_FS'] += $val['CNT1_F'];
			$data_list['PLAN_CS'] += $val['CNT1'];
			$data_list['AUTO'][$key]['T'] = $val['CNT2_T'];
			$data_list['AUTO'][$key]['F'] = $val['CNT2_F'];
			$data_list['AUTO'][$key]['C'] = $val['CNT2'];
			$data_list['AUTO_TS'] += $val['CNT2_T'];
			$data_list['AUTO_FS'] += $val['CNT2_F'];
			$data_list['AUTO_CS'] += $val['CNT2'];
		}
	}
}

$DB->CLOSE();
?>


