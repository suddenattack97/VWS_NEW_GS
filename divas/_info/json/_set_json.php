<?
require_once "../../_conf/_common.php";

require_once "../../include/class/setting.php";

require_once "../../include/reader.php";

$mode = $_REQUEST["mode"];

$ClassSetting = new ClassSetting($DB); // 설정

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
		
	// 주요지점 상세 조회
	case 'main':
		$ClassSetting->getMainView();
		$data_list = $ClassSetting->rsMainView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
	
	// 주요지점 정렬
	case 'main_sort':
		$result = $ClassSetting->setMainSort();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 등록
	case 'main_in':
		$result = $ClassSetting->setMainIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 수정
	case 'main_up':
		$result = $ClassSetting->setMainUp();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 삭제
	case 'main_de':
		$result = $ClassSetting->setMainDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 소속 장비 조회
	case 'main_comin_view':
		$ClassSetting->getMainComInView();
		$data_list = $ClassSetting->rsMainComInView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 등록 가능 장비 조회
	case 'main_comde_view':
		$ClassSetting->getMainComDeView();
		$data_list = $ClassSetting->rsMainComDeView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 구성 추가
	case 'main_com_in':
		$result = $ClassSetting->setMainComIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 주요지점 구성 삭제
	case 'main_com_de':
		$result = $ClassSetting->setMainComDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 그룹 상세 조회
	case 'group':
		$ClassSetting->getGroupView();
		$data_list = $ClassSetting->rsGroupView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 등록
	case 'group_in':
		if( $ClassSetting->getGroupCheck() ){
			$result = $ClassSetting->setGroupIn();
		}else{
			$result = false;
			$msg = "등록하려는 행정 코드가 이미 사용중 입니다.";
		}
		
		$returnBody = array( 'result' => $result, 'msg' => $msg );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 수정
	case 'group_up':
		if( $ClassSetting->getGroupCheck() ){
			$result = $ClassSetting->setGroupUp();
		}else{
			$result = false;
			$msg = "수정하려는 행정 코드가 이미 사용중 입니다.";
		}
		
		$returnBody = array( 'result' => $result, 'msg' => $msg );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 삭제
	case 'group_de':
		$result = $ClassSetting->setGroupDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 소속 장비 조회
	case 'group_comin_view':
		$ClassSetting->getGroupComInView();
		$data_list = $ClassSetting->rsGroupComInView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 등록 가능 장비 조회
	case 'group_comde_view':
		$ClassSetting->getGroupComDeView();
		$data_list = $ClassSetting->rsGroupComDeView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 구성 추가
	case 'group_com_in':
		$result = $ClassSetting->setGroupComIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 그룹 구성 삭제
	case 'group_com_de':
		$result = $ClassSetting->setGroupComDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 상세 조회
	case 'algr':
		$ClassSetting->getAlgrView();
		$data_list = $ClassSetting->rsAlgrView;
		// 경보그룹별 선택이 기능 있을때,
		$ClassSetting->getAreaView();
		$map_info = $ClassSetting->rsAreaView;
		
		$returnBody = array( 'list' => $data_list , 'mapData' => $map_info );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 등록
	case 'algr_in':
		$result1 = $ClassSetting->setAlgrIn();
		// 경보그룹별 선택이 기능 있을때,
		$result2 = $ClassSetting->setAreaIn();
		$result = ($result1 && $result2) ? true : false;
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 수정
	case 'algr_up':
		$result1 = $ClassSetting->setAlgrUp();
		// 경보그룹별 선택이 기능 있을때,
		$result2 = $ClassSetting->setAreaUp();
		$result = ($result1 && $result2) ? true : false;
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 삭제
	case 'algr_de':
		$result1 = $ClassSetting->setAlgrDe();
		// 경보그룹별 선택이 기능 있을때,
		$result2 = $ClassSetting->setAreaDe();
		$result = ($result1 && $result2) ? true : false;
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
	
	// 경보그룹 소속 장비 조회
	case 'algr_comin_view':
		$ClassSetting->getAlgrComInView();
		$data_list = $ClassSetting->rsAlgrComInView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 등록 가능 장비 조회
	case 'algr_comde_view':
		$ClassSetting->getAlgrComDeView();
		$data_list = $ClassSetting->rsAlgrComDeView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 구성 추가
	case 'algr_com_in':
		$result = $ClassSetting->setAlgrComIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
		
	// 경보그룹 구성 삭제
	case 'algr_com_de':
		$result = $ClassSetting->setAlgrComDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	// 장비상태 그룹 상세 조회
	case 'state_group':
		$ClassSetting->getStateGroupView();
		$data_list = $ClassSetting->rsStateGroupView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 등록
	case 'stategroup_in':
		$result = $ClassSetting->setStateGroupIn();
		/*if( $ClassSetting->getGroupCheck() ){
			$result = $ClassSetting->setGroupIn();
		}else{
			$result = false;
			//$msg = "등록하려는 행정 코드가 이미 사용중 입니다.";
		}*/
		
		$returnBody = array( 'result' => $result, 'msg' => $msg );
		echo json_encode( $returnBody );
	break;

	// 장비상태 그룹 상세 조회
	case 'state_group':
		$ClassSetting->getStateGroupView();
		$data_list = $ClassSetting->rsGroupView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 수정
	case 'state_group_up':
		$result = $ClassSetting->setStateGroupUp();
		/*if( $ClassSetting->getGroupCheck() ){
			$result = $ClassSetting->setGroupUp();
		}else{
			$result = false;
			$msg = "수정하려는 행정 코드가 이미 사용중 입니다.";
		}*/
		
		$returnBody = array( 'result' => $result, 'msg' => $msg );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 삭제
	case 'state_group_de':
		$result = $ClassSetting->setStateGroupDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 소속 장비 조회
	case 'state_group_comin_view':
		$ClassSetting->getStateGroupComInView();
		$data_list = $ClassSetting->rsGroupComInView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

	// 장비상태 그룹 등록 가능 장비 조회
	case 'state_group_comde_view':
		$ClassSetting->getStateGroupComDeView();
		$data_list = $ClassSetting->rsGroupComDeView;
		
		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 구성 추가
	case 'state_group_com_in':
		$result = $ClassSetting->setStateGroupComIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	//장비상태 그룹 구성 삭제
	case 'state_group_com_de':
		$result = $ClassSetting->setStateGroupComDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	//재해위험지역 조회
	case 'dngr':
		$ClassSetting->getDngrList(); // 재해위험지역 조회
		$data_list = $ClassSetting->rsDngrList;

		$returnBody = array( 'data' => $data_list );
		echo json_encode( $returnBody );
	break;

	//재해위험지역 선택
	case 'dngr_select':
		$ClassSetting->selectDngr();
		$data_list = $ClassSetting->rsSelectDngr;

		$returnBody = array( 'list' => $data_list );
		echo json_encode( $returnBody );
	break;

	//재해위험지역 등록
	case 'dngr_in':
		$result = $ClassSetting->setDngrIn();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	//재해위험지역 수정
	case 'dngr_up':
		$result = $ClassSetting->setDngrUp();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;

	//재해위험지역 삭제
	case 'dngr_de':
		$result = $ClassSetting->setDngrDe();
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
	break;
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


