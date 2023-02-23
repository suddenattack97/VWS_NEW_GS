<?
require_once "../include/class/setting.php";

$ott = $_SESSION["OTT"];

$ClassSetting = new ClassSetting($DB);

$ClassSetting->getOrganList(); // 기관정보 조회
$data_list = $ClassSetting->rsOrganList;

$DB->CLOSE();
?>


