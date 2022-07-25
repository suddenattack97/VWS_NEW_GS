<?
require_once "../include/class/common.php";

$ClassCommon->getMenuList(); // 메뉴 정보 리스트
$data_top = $ClassCommon->rsMenuTop;
$data_in = $ClassCommon->rsMenuIn;
$data_url = $ClassCommon->rsMenuUrl;

$ClassCommon->getReportList(0); // 기본 보고서 설정
$data_report = $ClassCommon->rsReportOri;

$ClassCommon->getAreaCode(); //메뉴 지역 코드 
$data_area = $ClassCommon->Menu_area;

$DB->CLOSE();
?>


