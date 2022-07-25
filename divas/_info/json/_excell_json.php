<?
require_once "../../_conf/_common.php";

$mode = $_REQUEST["mode"];


switch($mode){
	// 농가 상세 조회
	case 'excell':
		
		$ClassSetting->getFarmView();
		$data_list = $ClassSetting->rsFarmView;
		

		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

}
	
$DB->CLOSE();
?>


