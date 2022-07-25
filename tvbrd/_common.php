<?
ini_set("session.cache_expire", 180); // 세션 유효시간 (분단위)
ini_set("session.gc_maxlifetime", 3600); // 세션 로그인 후 지속시간 (초단위)
session_start();

// 비로그인 시 로그인 페이지로 이동
if($_SESSION['is_login'] != 1){
	// echo("<script>location.replace('../divas/monitoring/login.php');</script>"); 
}else{
	// 임시 구버전 쿠키 이용
	// $COOKIE_EXPIRE_TIME = 0;
	$COOKIE_EXPIRE_TIME = time()+3600;
	setcookie("keyUserID",      $_SESSION['user_id'], $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyUserType",    $_SESSION['user_type'], $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyUserName",    $_SESSION['user_name'], $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyUserPWD",     $_SESSION['user_pwd'], $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyIsPermit",     strrev($IS_PERMIT), $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyOrganID",     $_SESSION['organ_id'], $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyOrganName",   $_SESSION['organ_name'], $COOKIE_EXPIRE_TIME,'/');
	setcookie("keyAreaCode",    $_SESSION['organ_code'], $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyDepartment",      strrev($DEPARTMENT), $COOKIE_EXPIRE_TIME,'/');
	setcookie("keySortBase",    $_SESSION['sort_base'], $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyAreaTag",     strrev($AREA_TAG), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyReloadSecond",      strrev($RELOAD_SECOND), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyCookieExpire",      strrev($COOKIE_EXPIRE_SECOND), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyIsTvIcon",      strrev($IS_TV_ICON), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyIsLinkSite",    strrev($IS_LINK_SITE), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyIsArain",     strrev($IS_ARAIN), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyOrganCode",	 strrev(substr($ORGAN_CODE,0,5)), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyLoginKind",      $login_kind, time()+3600*24*30,'/');
	setcookie("keyTosRtuID", 	$_SESSION['is_rtu_id'], $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyArrOrganID", strrev($arrOrganID), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyArrOrganName", strrev($arrOrganName), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyMaxCntRtu", strrev($MAX_CNT_RTU), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyMaxCntRtuType", strrev($MAX_CNT_RTU_TYPE), $COOKIE_EXPIRE_TIME,'/');
// 	setcookie("keyMaxCntScript", strrev($MAX_CNT_SCRIPT), $COOKIE_EXPIRE_TIME,'/');
}
?>