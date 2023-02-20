<?
require_once "class/divas_Util.php";
session_start();

$dvUtil   = new Divas_Util();

if($_SESSION['is_login'] != 1){
}else{
	$user_setting = (array) json_decode($dvUtil->rsa_decrypt($_SESSION['user_setting']));
	define("keyUserID", $user_setting['user_id']);
	define("keyOrganID", $user_setting['organ_id']);
	define("keyTosRtuID", $user_setting['is_rtu_id']);
	define("keyOrganName", $user_setting['organ_name']);
	define("keyIsLogin", $user_setting['is_login']);
}
?>