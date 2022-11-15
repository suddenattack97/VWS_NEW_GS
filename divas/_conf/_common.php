<? // 환경 설정
ini_set("session.cache_expire", 180); // 세션 유효시간 (분단위)
ini_set("session.gc_maxlifetime", 3600); // 세션 로그인 후 지속시간 (초단위)
session_start();
require_once ("_lib.php");

define("DB", "0"); // DB 종류(mysql : 0, oracle : 1)
define("HOST", "http://".$_SERVER ['HTTP_HOST']); // URL(http://192.168.1.63:5000)
define("ROOT_USE", "0"); // 루트(미지정 : 0, 지정 : 1)
if(ROOT_USE == "0"){
	define("ROOT", ""); // 루트
	define("ROOT_DIR", str_replace("/", "\\", $_SERVER['DOCUMENT_ROOT'])); // 절대경로 루트(D:\\LMH_TEST\\divas_new)
}else{
	define("ROOT", "/divas_new");
	define('ROOT_DIR', "D:\\APM_Setup\\htdocs\\divas_new");
}
define("IMG_DIR", ROOT."/divas/images/"); // 이미지 경로
define("IMG_DIR2", ROOT."/divas/mobile/images/"); // 이미지 경로
define("DIFF", ""); // 해당 수치만큼 뺀 기준으로 데이터 표출
// define("DIFF", "-1 hour");
define("TEST", "0"); // 테스트(open : 0, test : 1)
define("TEST_y", "2019");
define("TEST_m", "05");
define("TEST_d", "31");
define("TEST_h", "23");
define("DISP_GROUP", "0"); // 0 : rtu_info에 변위센서 전부 등록, 1 : rtu_info에는 대표 하나만 등록 후 displacement_group에 자식 센서 등록

//HTMLPurifier
require_once(ROOT_DIR.'/divas/func/library/HTMLPurifier.auto.php');

// 기본 설정을 불러옴
$config = HTMLPurifier_Config::createDefault();
$config->set('Attr.EnableID', false);
$config->set('Attr.DefaultImageAlt', '');

// EUC-KR인 경우 iconv로 UTF-8 변환후 사용
$config->set('Core.Encoding', 'UTF-8');

// 설정을 저장하고 필터링 라이브러리 초기화
$purifier = new HTMLPurifier($config);

/**
 *  전체 줄 수
 */
define("dtm_cnt", "8");	// 자료관리
define("rpt_cnt", "0");	// 보고서
define("set_cnt", "10");	// 설정

/* 
* 화진 개발자 user_info.user_type
*/
define("DEV", "7");

if(DB == "0"){
	require_once "_db.php";
	require_once ROOT_DIR."/divas/include/DBmanager.php";
	$DB = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
}else if(DB == "1"){
	require_once "_db_oracle.php";
	require_once ROOT_DIR."/divas/include/OraDBmanager.php";
	$DB = new OraDBmanager(ORA_DSN, ORA_ID, ORA_PW);
}

define("ss_organ_code", '32956');	//지자체 지역코드
define("public_key", '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpFrdz4NJSmGDVWDjVvIHHTrCn
VXEMXv4XhOQK1DuqwNEJ5X2jD1Ma/maF6BJePK9T4lA99cCAyWZ6ySSUoBVkrEL1
5F2GfzJ9BF31y6HByKYiRc8KUxkMNHesR+00ZvGZsHxfHSYvfRztBffd+IRyy1ep
wd+TfN++aIZJivncuQIDAQAB
-----END PUBLIC KEY-----');	//공개키

require_once ROOT_DIR."/divas/include/class/common.php";

//공용
$ClassCommon = new ClassCommon($DB);
if(MobileCheck() == "Mobile"){
   //$ClassCommon->setLogout(); //캐시
}
if(MobileCheck() == "Mobile" && $_SESSION['is_login'] != 1){
   $ClassCommon->setLogin();
}
$ClassCommon->getSession();
$ClassCommon->getSetting();

if($_SESSION['is_login'] != 1){
}else{
	$user_setting = (array) json_decode($ClassCommon->rsa_decrypt($_SESSION['user_setting']));
	define("user_id", $user_setting['id']);
	define("organ_id", $user_setting['organ_id']);
	define("is_rtu_id", $user_setting['is_rtu_id']);
	define("organ_name", $user_setting['organ_name']);
	define("login_kind", $user_setting['login_kind']);
}

function round_data($data=0, $num=0.01, $fl=10){
	if($data == "-"){
		return $data;
	}else{
		if($fl == 10){
			$dv = "%.1f";
		}elseif($fl == 100){
			$dv = "%.2f";
		}elseif($fl == 1000){
			$dv = "%.3f";
		}elseif($fl == 10000){
			$dv = "%.4f";
		}
		return sprintf($dv, round(($data*$num)*$fl)/$fl);
	}
}

?>