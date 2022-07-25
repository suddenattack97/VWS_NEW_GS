<?
require_once "../include/class/setting.php";

$ClassSetting = new ClassSetting($DB); // 설정

$ClassSetting->getOrganList(); // 기관정보 조회
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getDngrList(); // 재해위험지역 조회
$data_list = $ClassSetting->rsDngrList;


$DB->CLOSE();
?>


