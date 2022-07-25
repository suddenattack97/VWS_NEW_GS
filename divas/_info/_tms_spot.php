<?
require_once "../include/class/rtuInfo.php";

$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] :  date("Y-m-d", strtotime("-1 month", time())); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 종료 날짜

//현장중계
$ClassSpotLog = new ClassRtuInfo($DB);

$ClassSpotLog->getSpotGroup();
$data_group = $ClassSpotLog->rsSpotGroup;

$ClassSpotLog->getSpotList($sdate, $edate);
$data_spotlog = $ClassSpotLog->rsSpotList;

$DB->CLOSE();
?>


