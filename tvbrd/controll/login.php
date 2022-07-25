<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 로그인
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
// require_once "../class/RtuInfo.class";//지역 Class

// require_once "../class/RainInfo.class";#강우 class
// require_once "../class/FlowInfo.class";#수위 class
// require_once "../class/SnowInfo.class";#적설 class
// require_once "../class/WindInfo.class";#풍속 class
// require_once "../class/HumiInfo.class";#습도 class
// require_once "../class/TempInfo.class";#온도 class
// require_once "../class/AtmoInfo.class";#기압 class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();


    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $USER_ID = $dvUtil->xss_clean($_REQUEST["USER_ID"]);
    $RUSER_PWD = $dvUtil->xss_clean($_REQUEST["USER_PWD"]);
    $login_kind = $dvUtil->xss_clean($_REQUEST["login_kind"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

	switch($mode) {
	case 'login':
		$qry.= "SELECT  A.USER_ID, A.AREA_CODE, A.USER_TYPE, A.USER_NAME, A.USER_PWD, A.IS_PERMIT, ";
		$qry.= "        B.ORGAN_ID, B.ORGAN_NAME, B.DEPARTMENT, B.SORT_BASE, ";
		$qry.= "        B.ORGAN_TITLE, B.AREA_TAG, B.RELOAD_SECOND, B.COOKIE_EXPIRE_SECOND, ";
		$qry.= "        B.IS_TV_ICON, B.IS_LINK_SITE, B.AREA_CODE AS ORGAN_COD ";
		$qry.= "FROM    USER_INFO A, ORGAN_INFO B ";
		$qry.= "WHERE   A.ORGAN_ID=B.ORGAN_ID AND A.USER_ID = '".$USER_ID."'";
		
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$USER_ID = $data['0']['USER_ID'];
		$USER_TYPE = $data['0']['USER_TYPE'];
		$USER_NAME = $data['0']['USER_NAME'];
		$USER_PWD = $data['0']['USER_PWD'];
		$IS_PERMIT = $data['0']['IS_PERMIT'];
		$ORGAN_ID = $data['0']['ORGAN_ID'];
		$ORGAN_NAME = $data['0']['ORGAN_NAME'];
		$AREA_CODE = $data['0']['AREA_CODE'];
		$DEPARTMENT = $data['0']['DEPARTMENT'];
		$SORT_BASE = $data['0']['SORT_BASE'];
		if($SORT_BASE=='0')			$SORT_BASE_COLUMN = 'SORT_FLAG';
		else if($SORT_BASE=='1')	$SORT_BASE_COLUMN = 'RTU_NAME';
		else if($SORT_BASE=='2')	$SORT_BASE_COLUMN = 'AREA_CODE';
		else                       	$SORT_BASE_COLUMN = 'SORT_FLAG';
		$AREA_TAG = $data['0']['AREA_TAG'];
		$RELOAD_SECOND = $data['0']['RELOAD_SECOND'];
		$COOKIE_EXPIRE_SECOND = $data['0']['COOKIE_EXPIRE_SECOND'];
		$IS_TV_ICON = $data['0']['IS_TV_ICON'];
		$IS_LINK_SITE = $data['0']['IS_LINK_SITE'];
		$IS_ARAIN = $data['0']['IS_ARAIN'];
		$ORGAN_CODE = $data['0']['ORGAN_CODE'];
		
		if(isset($USER_ID) && !empty($USER_ID)){
			if($RUSER_PWD === $USER_PWD){
				//$COOKIE_EXPIRE_TIME = time()+3600*24*30;
				$COOKIE_EXPIRE_TIME = 0;
				setcookie("keyUserID",      $USER_ID, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyUserType",      $USER_TYPE, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyUserName",      $USER_NAME, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyUserPWD",      $USER_PWD, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyIsPermit",     $IS_PERMIT, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyOrganID",      $ORGAN_ID, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyOrganName",      $ORGAN_NAME, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyAreaCode",     $AREA_CODE, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyDepartment",      $DEPARTMENT, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keySortBase",     $SORT_BASE_COLUMN, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyAreaTag",     $AREA_TAG, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyReloadSecond",      $RELOAD_SECOND, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyCookieExpire",      $COOKIE_EXPIRE_SECOND, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyIsTvIcon",      $IS_TV_ICON, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyIsLinkSite",    $IS_LINK_SITE, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyIsArain",     $IS_ARAIN, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyOrganCode",	 substr($ORGAN_CODE,0,5), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyUserID",      strrev($USER_ID), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyUserType",      strrev($USER_TYPE), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyUserName",      strrev($USER_NAME), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyUserPWD",      strrev($USER_PWD), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyIsPermit",     strrev($IS_PERMIT), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyOrganID",      strrev($ORGAN_ID), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyOrganName",      strrev($ORGAN_NAME), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyAreaCode",     strrev($AREA_CODE), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyDepartment",      strrev($DEPARTMENT), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keySortBase",     strrev($SORT_BASE_COLUMN), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyAreaTag",     strrev($AREA_TAG), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyReloadSecond",      strrev($RELOAD_SECOND), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyCookieExpire",      strrev($COOKIE_EXPIRE_SECOND), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyIsTvIcon",      strrev($IS_TV_ICON), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyIsLinkSite",    strrev($IS_LINK_SITE), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyIsArain",     strrev($IS_ARAIN), $COOKIE_EXPIRE_TIME,'/');
				// setcookie("keyOrganCode",	 strrev(substr($ORGAN_CODE,0,5)), $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyLoginKind",      $login_kind, time()+3600*24*30,'/');
				
				$SQL = " SELECT RTU_ID ";
				if($USER_TYPE=='3'){
					$SQL .= " FROM 	USER_RIGHT ";
					$SQL .= " WHERE	USER_ID = '".$USER_ID."' ";
				}else if($USER_TYPE=='1'){
					$SQL .= " FROM RTU_INFO ";
					$SQL .= " WHERE ORGAN_ID = '".$ORGAN_ID."' ";
				}else{
					$SQL .= " FROM RTU_INFO ";
				}
				$data_tos = $DB->execute($SQL);
				$DB->rs_unset();
				
				$tos_rtu_id = '';
				if($data_tos){
					foreach($data_tos as $key => $val){
						$tos_rtu_id .= $val['RTU_ID'].',';
					}
				}
				$tos_rtu_id = substr($tos_rtu_id,0,-1);
				setcookie("keyTosRtuID", $tos_rtu_id, $COOKIE_EXPIRE_TIME,'/');
				
				$SQL = " SELECT * FROM ORGAN_INFO ORDER	BY ORGAN_ID ";
				$data_organ = $DB->execute($SQL);
				$DB->rs_unset();
				
				if($data_organ){
					foreach($data_organ as $key => $val){
						$arrOrganID .= $val['ORGAN_ID'].',';
						$arrOrganName .= $val['ORGAN_NAME'].',';
					}
				}
				setcookie("keyArrOrganID", $arrOrganID, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyArrOrganName", $arrOrganName, $COOKIE_EXPIRE_TIME,'/');
				
				$SQL = " SELECT * FROM
					(SELECT MAX(A.CNT) MAX_CNT_RTU FROM (SELECT COUNT(RTU_ID) AS CNT FROM RTU_INFO GROUP BY ORGAN_ID) A) AS CNT_RTU,
					(SELECT MAX(A.CNT) MAX_CNT_RTU_TYPE FROM (SELECT ORGAN_ID,RTU_TYPE,COUNT(RTU_ID) AS CNT FROM RTU_INFO GROUP BY RTU_TYPE, ORGAN_ID) A) AS CNT_RTU_BY_TYPE,
					(SELECT MAX(A.CNT) MAX_CNT_SCRIPT FROM (SELECT COUNT(SCRIPT_NO) AS CNT FROM BROADCAST_SCRIPT GROUP BY ORGAN_ID) A) AS CNT_SCRIPT ";
				$data_max = $DB->execute($SQL);
				$DB->rs_unset();
				
				if($data_max){
					$MAX_CNT_RTU		= $data_max[0]['MAX_CNT_RTU'];
					$MAX_CNT_RTU_TYPE	= $data_max[0]['MAX_CNT_RTU_TYPE'];
					$MAX_CNT_SCRIPT		= $data_max[0]['MAX_CNT_SCRIPT'];
				}
				setcookie("keyMaxCntRtu", $MAX_CNT_RTU, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyMaxCntRtuType", $MAX_CNT_RTU_TYPE, $COOKIE_EXPIRE_TIME,'/');
				setcookie("keyMaxCntScript", $MAX_CNT_SCRIPT, $COOKIE_EXPIRE_TIME,'/');
				
				$returnBody = array( 'result' => true, 'data' => $resultArr );
				echo json_encode( $returnBody );
				exit;
			}else {
				$returnBody = array( 'result' => false, 'data' => "패스워드가 틀립니다." );
				echo json_encode( $returnBody );
				exit;
			}
			
		}else{
			$returnBody = array( 'result' => false, 'data' => "아이디가 틀립니다." );
			echo json_encode( $returnBody );
			exit;
		}
	break;
	
	case 'logout':
		setcookie("keyUserID",			'', time()-3600,'/');
		setcookie("keyUserType",		'', time()-3600,'/');
		setcookie("keyUserName",		'', time()-3600,'/');
		setcookie("keyUserPWD",			'', time()-3600,'/');
		setcookie("keyIsPermit",		'', time()-3600,'/');
		setcookie("keyOrganID",			'', time()-3600,'/');
		setcookie("keyOrganName",		'', time()-3600,'/');
		setcookie("keyAreaCode",		'', time()-3600,'/');
		setcookie("keyDepartment",		'', time()-3600,'/');
		setcookie("keySortBase",		'', time()-3600,'/');
		setcookie("keyOrganTitle",		'', time()-3600,'/');
		setcookie("keyAreaTag",			'', time()-3600,'/');
		setcookie("keyReloadSecond",	'', time()-3600,'/');
		setcookie("keyCookieExpire",	'', time()-3600,'/');
		setcookie("keyIsTvIcon",		'', time()-3600,'/');
		setcookie("keyIsLinkSite",		'', time()-3600,'/');
		setcookie("keyIsArain",			'', time()-3600,'/');
		setcookie("keyOrganCode",		'', time()-3600,'/');
		setcookie("keyTosRtuID",		'', time()-3600,'/');
		setcookie("keyArrOrganID",		'', time()-3600,'/');
		setcookie("keyArrOrganName",	'', time()-3600,'/');
		setcookie("keyMaxCntRtu",		'', time()-3600,'/');
		setcookie("keyMaxCntRtuType",	'', time()-3600,'/');
		setcookie("keyMaxCntScript",	'', time()-3600,'/');
		
		$returnBody = array( 'result' => true, 'data' => "" );
		echo json_encode( $returnBody );
		exit;
	break;
	
	case 'login_title':
		$SQL = " SELECT top_img, top_text FROM wr_map_setting ";
		$data = $DB->execute($SQL);
		$DB->rs_unset();
		
		$arr_data = array();
		if($data){
			$arr_data['top_img'] = $data[0]['top_img'];
			$arr_data['top_text'] = $data[0]['top_text'];
		}
		
		$returnBody = array( 'result' => true, 'data' => $arr_data);
		echo json_encode( $returnBody );
		exit;
	break;
	}
?>


