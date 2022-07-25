<?
require_once "../include/class/common.php";

$ClassCommon->getMenuList(); // 메뉴 정보 리스트
$data_top = $ClassCommon->rsMenuTop;
$data_in = $ClassCommon->rsMenuIn;

$DB->CLOSE();
?>


