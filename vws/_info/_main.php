<?
require_once "../include/class/common.php";

$ClassCommon->getMenuView(); // 메뉴 정보 호출
$data_top = $ClassCommon->rsMenuTop;
$data_in = $ClassCommon->rsMenuIn;

$DB->CLOSE();
?>


