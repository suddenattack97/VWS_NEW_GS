<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 방송하기
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");

#################################################################################################################################
# DB connection
#################################################################################################################################
require_once "../db/_Db.php";

#################################################################################################################################
# class 및 function lib
#################################################################################################################################
require_once "../class/DateMake.php";#시간 class
require_once "../class/Divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
require_once "../class/RtuInfo.php";//지역 Class

require_once "../class/AlarmInfo.php";#방송 class

require_once "../../divas/include/class/setting.php";#세팅 class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
$AwsLocalDB = new RtuInfo($DB);
$AlarmInfo = new AlarmInfo($DB,$DM, $dvUtil);

$ClassSetting = new ClassSetting($DB,$DM, $dvUtil); // 설정

    $mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
    $area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);
    $arr_area_code = $_REQUEST["arr_area_code"];
    $arr_rtu_id = $_REQUEST["arr_rtu_id"];

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
	case 'alarm':
		$arr_data = array();
		
		if($arr_rtu_id){
			foreach($arr_rtu_id as $key => $val){
				$qry = " SELECT trans_flag, trans_error, vhf_call, trans_check FROM rtu_log
						 WHERE rtu_id = '".$val."'
						 ORDER BY log_no DESC LIMIT 1 ";
				$data = $DB->execute($qry);
				$DB->rs_unset();
				
				$arr_data[$key]['area_code'] = $arr_area_code[$key];
				$arr_data[$key]['flag'] = $data[0]['trans_flag'];
				$arr_data[$key]['error'] = $data[0]['trans_error'];
				$arr_data[$key]['call'] = $data[0]['vhf_call'];
				$arr_data[$key]['date'] = isset($data[0]['trans_check']) ? $data[0]['trans_check'] : "-";
			}
		}
		
		$returnBody = array( 'result' => true, 'list' => $arr_data);
		echo json_encode( $returnBody );
		exit;
	break;
	
    case 'alarm_slide':
    	$AlarmInfo->getAlarmRtuInfo();
    	$resultArr["TREE_PATH"] = $AlarmInfo->TREE_PATH;
    	$resultArr["GROUP_ID"] = $AlarmInfo->GROUP_ID;
    	$resultArr["ORGAN_ID"] = $AlarmInfo->ORGAN_ID;
    	$resultArr["ORGAN_NAME"] = $AlarmInfo->ORGAN_NAME;
    	$resultArr["GROUP_NAME"] = $AlarmInfo->GROUP_NAME;
    	$resultArr["RTU_ID"] = $AlarmInfo->RTU_ID;
    	$resultArr["RTU_NAME"] = $AlarmInfo->RTU_NAME;
    	$resultArr["AREA_CODE"] = $AlarmInfo->AREA_CODE;
    	$resultArr["PARENT_ID"] = $AlarmInfo->PARENT_ID;
    	$resultArr["TREE_DEPTH"] = $AlarmInfo->TREE_DEPTH;
		$resultArr["USER_RIGHT_X"] = $AlarmInfo->USER_RIGHT_X;
		
    	$resultArr2["GROUP_ID"] = $AlarmInfo->G_GROUP_ID;
    	$resultArr2["RTU_CNT"] = $AlarmInfo->G_RTU_CNT;


    	$AlarmInfo->getAlarmScriptInfo();
    	$resultArr3["SCRIPT_NO"] = $AlarmInfo->S_SCRIPT_NO;
    	$resultArr3["OWN_TYPE"] = $AlarmInfo->S_OWN_TYPE;
    	$resultArr3["ORGAN_ID"] = $AlarmInfo->S_ORGAN_ID;
    	$resultArr3["USER_ID"] = $AlarmInfo->S_USER_ID;
    	$resultArr3["SCRIPT_UNIT_NAME"] = $AlarmInfo->S_SCRIPT_UNIT_NAME;
    	$resultArr3["SCRIPT_UNIT"] = $AlarmInfo->S_SCRIPT_UNIT;
    	$resultArr3["SECTION_NO"] = $AlarmInfo->S_SECTION_NO;
    	$resultArr3["SECTION_NAME"] = $AlarmInfo->S_SECTION_NAME;
    	$resultArr3["SCRIPT_TITLE"] = $AlarmInfo->S_SCRIPT_TITLE;
    	$resultArr3["CHIME_START_NO"] = $AlarmInfo->S_CHIME_START_NO;
    	$resultArr3["CHIME_START_CNT"] = $AlarmInfo->S_CHIME_START_CNT;
    	$resultArr3["CHIME_END_NO"] = $AlarmInfo->S_CHIME_END_NO;
    	$resultArr3["CHIME_END_CNT"] = $AlarmInfo->S_CHIME_END_CNT;
    	$resultArr3["SCRIPT_BODY"] = $AlarmInfo->S_SCRIPT_BODY;
    	$resultArr3["SCRIPT_BODY_CNT"] = $AlarmInfo->S_SCRIPT_BODY_CNT;
    	$resultArr3["SCRIPT_RECORD_FILE"] = $AlarmInfo->S_SCRIPT_RECORD_FILE;
    	$resultArr3["SCRIPT_TIMESTAMP"] = $AlarmInfo->S_SCRIPT_TIMESTAMP;
    	$resultArr3["TRANS_VOLUME"] = $AlarmInfo->S_TRANS_VOLUME;
		
    	$AlarmInfo->getSectionInfo();
    	$resultSel["SECTION_NO"] = $AlarmInfo->SE_SECTION_NO;
		$resultSel["SECTION_NAME"] = $AlarmInfo->SE_SECTION_NAME;
		
    	$AlarmInfo->getChimeInfo();
    	$resultSel["CHIME_NO"] = $AlarmInfo->CH_CHIME_NO;
    	$resultSel["CHIME_NAME"] = $AlarmInfo->CH_CHIME_NAME;
    	
    	$AlarmInfo->getEmerInfo();
    	$resultEmer["ID"] = $AlarmInfo->EM_ID;
    	$resultEmer["NAME"] = $AlarmInfo->EM_NAME;
    	$resultEmer["SCRIPT_NO"] = $AlarmInfo->EM_SCRIPT_NO;
    	$resultEmer["SORT"] = $AlarmInfo->EM_SORT;
    	
        $returnBody = array( 'result' => true, 'data' => $resultArr, 'data2' => $resultArr2, 'data3' => $resultArr3, 
        					 'sel' => $resultSel, 'emer' => $resultEmer );
        echo json_encode( $returnBody );
        exit;
    break;
    
    case 'alarm_in':
    	$result['broadcast'] = $AlarmInfo->setBroadcastLogIn();
    	$result['rtu'] = $AlarmInfo->setRtuLogIn();
    	
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_in_all':
    	if( $_REQUEST["id"] ){
    		$AlarmInfo->getEmerScript();
    		if($AlarmInfo->EM_NO == 0){
    			$result['broadcast'] = false;
    			$result['rtu'] = false;
    		}else{    		
    			$result['broadcast'] = $AlarmInfo->setBroadcastLogIn();
    			$result['rtu'] = $AlarmInfo->setRtuLogIn();
    		}
    	}else{
    		$result['broadcast'] = false;
    		$result['rtu'] = false;
    	}
    	
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_script_sort':
    	if( $_REQUEST["arr_sort"] ){
    		$result['sort'] = $AlarmInfo->setScriptSort();
    	}else{
    		$result['sort'] = false;
    	}
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_emer_insert':
    	$result = $AlarmInfo->setEmerIn();
    	
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_emer_delete':
    	$result = $AlarmInfo->setEmerDe();
    	
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_emer_change':
    	$result = $AlarmInfo->setEmerUp();
    	
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    
    case 'alarm_emer_sort':
    	if( $_REQUEST["arr_sort"] ){
    		$result['sort'] = $AlarmInfo->setEmerSort();
    	}else{
    		$result['sort'] = false;
    	}
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
	break;
	
    case 'alarm_emer_pwd':
    	if( $_REQUEST["pwd"] ){

			$ciphertext = $_REQUEST["pwd"];

			// 암호문을 base64로 디코딩한다.
			$ciphertext = @base64_decode($ciphertext, true);
			if ($ciphertext === false) return false;
			
			// 개인키를 읽어온다.
			$private_key = @file_get_contents('../../divas/_info/json/private.key');
			// 개인키를 사용하여 복호화한다.
			
			$privkey_decoded = @openssl_pkey_get_private($private_key);
			if ($privkey_decoded === false)	return false;
			
			$plaintext = false;
			$status = @openssl_private_decrypt($ciphertext, $plaintext, $privkey_decoded);
			
			@openssl_pkey_free($privkey_decoded);
			if (!$status || $plaintext === false) return false;
			// 이상이 없는 경우 평문을 반환한다.

    		$result = $ClassSetting->checkEmerPwd($plaintext);
    	}else{
    		$result = false;
		}
		// var_dump($result);
    	$returnBody = array( 'result' => $result );
    	echo json_encode( $returnBody );
    	exit;
    break;
    }
    
?>
