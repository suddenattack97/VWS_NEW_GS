<?
require_once "../include/class/setting.php";

$ClassSetting = new ClassSetting($DB);

$ClassSetting->getOrganList(); // 기관정보 조회
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getStateGroup(); // 그룹 조회
$data_list = $ClassSetting->rsGroupList;

$DB->CLOSE();
?>


