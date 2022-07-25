<?
require_once "../include/class/broadcast.php";

$ALARM_GRP_NO = $_REQUEST['ALARM_GRP_NO'];
$ALARM_RTU_ID = $_REQUEST['ALARM_RTU_ID'];
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 종료 날짜
$EVENT_CODE = $_REQUEST['EVENT_CODE'] ? $_REQUEST['EVENT_CODE'] : array("");

$ClassBroadCast = new ClassBroadCast($DB); // 방송

$ClassBroadCast->getAlertGroupList(); // 경보그룹
$data_equip = $ClassBroadCast->rsAlertGroupList;

$ClassBroadCast->getBroadcastEquipmentList(); // 방송지역
$data_equip2 = $ClassBroadCast->rsBroadcastEquipList2;

$ClassBroadCast->getEventInfo(); // 이벤트 정보
$data_event = $ClassBroadCast->rsEventInfo;

$ClassBroadCast->getEventList($sdate." 00:00:00", $edate." 23:59:59"); // 이벤트 리스트
$data_list = $ClassBroadCast->rsEventList;

$DB->CLOSE();
?>


