<?
require_once "../include/class/setting.php";

$ClassSetting = new ClassSetting($DB);

$ClassSetting->getOrganList(); // 기관정보 조회
$data_organ = $ClassSetting->rsOrganList;

$ClassSetting->getAlgrList(); // 경보그룹 조회
$data_list = $ClassSetting->rsAlgrList;

// x_organ, y_organ 조회
$sql = " SELECT x_organ, y_organ FROM wr_map_setting ";
$rs = $DB->execute($sql);
			
if($DB->NUM_ROW()){
	$dataXY[0] = $rs[0]['x_organ'];
	$dataXY[1] = $rs[0]['y_organ'];
}
$rsXY = $dataXY;

$DB->CLOSE();
?>


