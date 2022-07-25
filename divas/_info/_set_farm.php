<?
require_once "../include/class/setting.php";

$ClassSetting = new ClassSetting($DB); // 설정

$ClassSetting->getOrganList(); // 기관정보 조회
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getFarmList(); // 농가 조회
$data_list = $ClassSetting->rsFarmList;

$ClassSetting->getFarmList2(); // 농가 조회 (질병여부 포함)
$data_list2 = $ClassSetting->rsFarmList2;

$ClassSetting->getAnimalList(); // 동물 구분 조회
$data_Animallist = $ClassSetting->rsAnimalList;

$ClassSetting->getDiseaseList(); // 질병 상세 조회
$data_Diseaselist = $ClassSetting->rsDiseaseList;

$ClassSetting->getDiseaseList2(); // 질병 상세 조회 ()
$data_Diseaselist2 = $ClassSetting->rsDiseaseList2;

$ClassSetting->getFarmComInView(); // 농가 질병 상태
$data_FarmComInView = $ClassSetting->rsFarmComInView;

$ClassSetting->getRptallfarm(); // 축산 보고서 전체농가
$data_rptlist = $ClassSetting->rsRptallfarm;

/*
$ClassSetting->getRptpartfarm(); // 축산 보고서 발병농가
$data_rptpartlist = $ClassSetting->rsRptpartfarm;
*/

/*
$ClassSetting->getFarmDiseaseList(); // 농가 질병 상태
$data_FarmDisease = $ClassSetting->rsFarmDiseaseList;
*/

$DB->CLOSE();
?>


