<?
require_once "../include/class/rtuInfo.php";

$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d", strtotime("-1 month", time())); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 종료 날짜

$ClassAsLog = new ClassRtuInfo($DB);

$ClassAsLog->getAsLogList($sdate, $edate); // as 로그 리스트
$data_aslog = $ClassAsLog->rsAsLogList;

$DB->CLOSE();
?>


