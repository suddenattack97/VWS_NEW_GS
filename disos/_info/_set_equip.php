<?
require_once "../include/class/setting.php";
// require_once "../include/class/broadcast.php";

$ott = $_SESSION["OTT"];

$ClassSetting = new ClassSetting($DB); // 설정
// $ClassBroadCast = new ClassBroadCast($DB); // 방송

$ClassSetting->getEquipList(); // 장비 조회
$data_list = $ClassSetting->rsEquipList;

$ClassSetting->getEquipId(); // 장비 ID
$data_id = $ClassSetting->rsEquipId;

$ClassSetting->getOrganList(); // 소속기관
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getLineInfo(); // 회선
$data_line = $ClassSetting->rsLineInfo;

$ClassSetting->getModelInfo(); // 모델
$data_model = $ClassSetting->rsModelInfo;

$DB->CLOSE();
?>


