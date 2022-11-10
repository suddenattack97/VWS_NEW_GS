<?
require_once "../../_conf/_common.php";

require_once "../../include/class/setting.php";

require_once "../../include/reader.php";

$mode = $_REQUEST["mode"];

$ClassSetting = new ClassSetting($DB); // 설정

// 검증
if($_SESSION["OTT"] == $_POST["OTT"]){
	switch($mode){
		// 시스템 설정
		case 'set':
			$result1 = $ClassCommon->setSetting();
			$result2 = $ClassCommon->setMenu();
			$result = ($result1 && $result2) ? true : false;
			
			$returnBody = array( 'result' => $result);
			echo json_encode( $returnBody );
		break;
			
		// 기관정보 상세 조회
		case 'organ':
			$ClassSetting->getOrganView();
			$data_list = $ClassSetting->rsOrganView;
			
			$returnBody = array( 'list' => $data_list );
			echo json_encode( $returnBody );
		break;
		
		// 기관정보 등록
		case 'organ_in':
			if( $ClassSetting->getOrganCheck() ){
				$result = $ClassSetting->setOrganIn();
			}else{
				$result = false;
				$msg = "등록하려는 기관명 또는 행정 코드가 이미 존재 합니다.";
			}
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 기관정보 수정
		case 'organ_up':
			if( $ClassSetting->getOrganCheck() ){
				$result = $ClassSetting->setOrganUp();
			}else{
				$result = false;
				$msg = "수정하려는 기관명 또는 행정 코드가 이미 존재 합니다.";
			}
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 기관정보 삭제
		case 'organ_de':
			$result = $ClassSetting->setOrganDe();
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
		
		// 행정구역 조회
		case 'area':
			$ClassSetting->getAreaTotal();
			$data_tot = $ClassSetting->rsAreaTotal;
			
			$ClassSetting->getAreaCnt();
			$data_cnt = $ClassSetting->rsAreaCnt;
			
			$ClassSetting->getAreaInfo();
			$data_list = $ClassSetting->rsAreaInfo;
			
			if($data_cnt == "0") $data_list = array();
			
			$returnBody = array( 'recordsTotal' => $data_tot, 'recordsFiltered' => $data_cnt, 'data' => $data_list );
			echo json_encode( $returnBody );
		break;
			
		// 사용자 상세 조회
		case 'user':
			$ClassSetting->getUserView();
			$data_list = $ClassSetting->rsUserView;
			
			// $ClassSetting->getRightView();
			// $data_right = $ClassSetting->rsRightView;
			
			$returnBody = array( 'list' => $data_list, 'right' => $data_right );
			echo json_encode( $returnBody );
		break;
	
	
		// 사용자 아이디 중복 체크
		case 'user_dup':
			$result = $ClassSetting->getUserDupCheck();
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
		
		// 사용자 등록
		case 'user_in':
			$USER_TYPE = $_REQUEST['USER_TYPE'];
			// $USER_PWD = $_REQUEST['USER_PWD'];
			$CNT = ($_REQUEST['STR_RTU_ID'] == "") ? 0 : count( explode("-", $_REQUEST['STR_RTU_ID']) );
			if( $ClassSetting->getUserCheck() ){
				
				// $rst = passwordCheck($USER_PWD);
				// if($rst[0] == false){
				// 	$result = false;
				// 	$msg = $rst[1]; 
				// }else{
					if($USER_TYPE == "0" || $USER_TYPE == "1"){
						$result = $ClassSetting->setUserIn();
					}else{
						$result1 = $ClassSetting->setUserIn();
						$result2 = ($CNT == 0) ? true : $ClassSetting->setRightIn();
						$result = ($result1 && $result2) ? true : false; 
					}
				// }
			}else{
				$result = false;
				$msg = "등록하려는 사용자 ID 또는 휴대폰 번호는 이미 사용중 입니다.";
			}
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 사용자 수정
		case 'user_up':
			$USER_TYPE = $_REQUEST['USER_TYPE'];
			// $USER_PWD = $_REQUEST['USER_PWD'];
			$CNT = ($_REQUEST['STR_RTU_ID'] == "") ? 0 : count( explode("-", $_REQUEST['STR_RTU_ID']) );
	
			// $rst = passwordCheck($USER_PWD);
			// if($rst[0] == false){
			// 	$result = false;
			// 	$msg = $rst[1]; 
			// }else{
				if( $ClassSetting->getUserCheck() ){
					if($USER_TYPE == "0" || $USER_TYPE == "1"){
						$result1 = $ClassSetting->setUserUp();
						$result2 = $ClassSetting->setRightDe();
						$result = ($result1 && $result2) ? true : false;
					}else{
						$result1 = $ClassSetting->setUserUp();
						$result2 = $ClassSetting->setRightDe();
						$result3 = ($CNT == 0) ? true : $ClassSetting->setRightIn();
						$result = ($result1 && $result2 && $result3) ? true : false;
					}
				}else{
					$result = false;
					$msg = "수정하려는 사용자 ID 또는 휴대폰 번호는 이미 사용중 입니다.";
				}
			// }
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 사용자 삭제
		case 'user_de':
			$result1 = $ClassSetting->setUserDe();
			$result2 = $ClassSetting->setRightDe();
			$result = ($result1 && $result2) ? true : false; 
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
			
		// 장비 상세 조회
		case 'equip':
			$ClassSetting->getEquipView();
			$data_list = $ClassSetting->rsEquipView;
			
			$returnBody = array( 'list' => $data_list );
			echo json_encode( $returnBody );
		break;
		
		// 장비 센서 조회
		case 'equip_sensor':
			$ClassSetting->getSensorView();
			$data_list = $ClassSetting->rsSensorView;
			
			$returnBody = array( 'list' => $data_list );
			echo json_encode( $returnBody );
		break;
			
		// 장비 센서 설정
		case 'equip_sensor_change':
			$result = $ClassSetting->setSensorChange();
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
			
		// 장비 행정 코드 중복 체크
		case 'equip_dup':
			$result = $ClassSetting->getEquipDupCheck();
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
			
		// 계측기 코드 중복 체크
		case 'equip_dup2':
			$result = $ClassSetting->getEquipDupCheck2();
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
		
		// 장비 등록
		case 'equip_in':
			if( $ClassSetting->getEquipCheck() ){
				$result1 = $ClassSetting->setEquipIn();
				$result2 = $ClassSetting->setLocatIn();
				$result3 = $ClassSetting->setSensorIn();
				// 트리거 사용 안할 시 주석 제거, 교체
				// $result4 = $ClassSetting->setEquipGroupIn();
				// $result = ($result1 && $result2 && $result3 && $result4) ? true : false;
				$result = ($result1 && $result2 && $result3) ? true : false;
			}else{
				$result = false;
				$msg = "등록하려는 장비 ID 또는 통신 ID는 이미 사용중 입니다.";
			}
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 장비 수정
		case 'equip_up':
			if( $ClassSetting->getEquipCheck() ){
				$result1 = $ClassSetting->setEquipUp();
				// $result2 = $ClassSetting->setEquipGroupUp();
				$result2 = $ClassSetting->setSensorDe();
				$result3 = $ClassSetting->setSensorIn();
				$result = ($result1 && $result2 && $result3) ? true : false;
			}else{
				$result = false;
				$msg = "수정하려는 장비 ID 또는 통신 ID는 이미 사용중 입니다.";
			}
			
			$returnBody = array( 'result' => $result, 'msg' => $msg );
			echo json_encode( $returnBody );
		break;
			
		// 장비 삭제
		case 'equip_de':
			$result1 = $ClassSetting->setEquipDe();
			// $result2 = $ClassSetting->setEquipGroupDe();
			$result2 = $ClassSetting->setLocatDe();
			$result3 = $ClassSetting->setSensorDe();
			$result = ($result1 && $result2 && $result3) ? true : false;
			
			$returnBody = array( 'result' => $result );
			echo json_encode( $returnBody );
		break;
	}

}

// 비밀번호 유효성 체크
function passwordCheck($_str){
    $pw = $_str;
    $num = preg_match('/[0-9]/u', $pw);
    $eng = preg_match('/[a-z]/u', $pw);
    $spe = preg_match("/[\!\@\#\$\%\^\&\*]/u",$pw);
 
    if(strlen($pw) < 8 || strlen($pw) > 20)
    {
        return array(false,"비밀번호는 최소 8자리 ~ 최대 20자리 이내로 입력해주세요.");
        exit;
    }
 
    if(preg_match("/\s/u", $pw) == true)
    {
        return array(false, "비밀번호는 공백없이 입력해주세요.");
        exit;
    }
 
    if( $num == 0 || $eng == 0 || $spe == 0)
    {
        return array(false, "영문, 숫자, 특수문자를 혼합하여 입력해주세요.");
        exit;
    }
 
    return array(true);
}
	
$DB->CLOSE();
?>


