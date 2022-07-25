<?
require_once "../include/class/broadcast.php";

$sel_date = $_REQUEST['sel_date'] ? $_REQUEST['sel_date'] : "a";
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d", strtotime("-1 month", time())); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 종료 날짜
$IS_PLAN = $_REQUEST['IS_PLAN'];
$search_sel = $_REQUEST['search_sel'] ? $_REQUEST['search_sel'] : "SCRIPT_TITLE";
$search_text = $_REQUEST['search_text'];
$USER_ID = $_REQUEST['USER_ID'];

if($sel_date == "y"){
	$isdate = substr($sdate, 0, 4)."-01-01";
	$iedate = substr($sdate, 0, 4)."-12-31";
}else if($sel_date == "m"){
	$isdate = substr($sdate, 0, 4)."-".substr($sdate, 5, 2)."-01";
	$iedate = substr($sdate, 0, 4)."-".substr($sdate, 5, 2)."-31";
}else if($sel_date == "d"){
	$isdate = $sdate." 00:00:00";
	$iedate = $sdate." 23:59:59";
}else{
	$isdate = $sdate." 00:00:00";
	$iedate = $edate." 23:59:59";
}

//방송
$ClassBroadCast = new ClassBroadCast($DB);

$ClassBroadCast->getBroadCastList($isdate, $iedate);
$data_list = $ClassBroadCast->rsBroadCastList;

$DB->CLOSE();
?>


