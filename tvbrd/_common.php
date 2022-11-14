<?
require_once "class/Divas_Util.php";
session_start();

$dvUtil   = new Divas_Util();

if($_SESSION['is_login'] != 1){
}else{
	$user_setting = (array) json_decode($dvUtil->rsa_decrypt($_SESSION['user_setting']));
	define("user_id", $user_setting['id']);
	define("organ_id", $user_setting['organ_id']);
	define("is_rtu_id", $user_setting['is_rtu_id']);
	define("organ_name", $user_setting['organ_name']);
}
?>