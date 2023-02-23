<?
require_once "../include/class/setting.php";
// require_once "../include/class/broadcast.php";

$ott = $_SESSION["OTT"];

$ClassSetting = new ClassSetting($DB); // 설정
// $ClassBroadCast = new ClassBroadCast($DB); // 방송

$ClassSetting->getOrganList(); // 기관정보 조회
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getUserList(); // 사용자 조회
$data_list = $ClassSetting->rsUserList;

// $ClassBroadCast->getBroadcastEquipmentList(); // 방송지역 리스트
// $data_equip = $ClassBroadCast->rsBroadcastEquipList;
// $data_equip2 = $ClassBroadCast->rsBroadcastEquipList2;

$DB->CLOSE();
?>


