<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/setting.php";

$area_code = $_REQUEST['area_code']; // 지역 코드
$type = $_REQUEST['sel_date'] ? $_REQUEST['sel_date'] : "H"; // 검색기간
$sel_date = $_REQUEST['sel_date'] ? $_REQUEST['sel_date'] : "H"; // 검색기간
$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜
$edate = $_REQUEST['edate'] ? $_REQUEST['edate'] : date("Y-m-d"); // 끝 날짜
$REPORT_TYPE = $_REQUEST['option'] ? $_REQUEST['option'] : "1"; // 레포트 종류

$ClassCommon = new ClassCommon($DB);

$ClassCommon->getReportList(1); // 그룹 조회
$data_list = $ClassCommon->rsReportOri;

$DB->CLOSE();
?>


