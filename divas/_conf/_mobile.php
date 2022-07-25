<?
require_once "./divas/_conf/_common.php";

if($_REQUEST['menu'] == "rtulocation"){ // 위치정보 xml
	header("Location: ./divas/mobile/rtu/rtulocation.php?menu=".$_REQUEST['menu']."&mynumber=".$_REQUEST['mynumber']); exit;
}

// 모바일 기기 체크 후 메뉴별 페이지 이동
if(MobileCheck() == "Mobile"){
	//if( empty($_REQUEST['mynumber']) || $_REQUEST['device_id'] == "null" ){
	if( empty($_REQUEST['mynumber']) ){
		$tmp_alert = "통합방재 시스템 (라이센스) 에 등록해 주세요.";
		echo('<script>alert("'.iconv("utf-8", "euc-kr", $tmp_alert).'");</script>'); exit;
	}else{
		$url = "./divas/mobile/index.php?menu=".$_REQUEST['menu']."&mynumber=".$_REQUEST['mynumber']."&device_id=".$_REQUEST['device_id'];
		header("Location: ".$url); exit;
	}
}
?>