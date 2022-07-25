<?php
/*
 * FileName		: toASX.php
 * Description	: 미리듣기 파일 생성
 * Modify		: 2007-02-23
 * Company		: Hwajin T&I 
 * Author		: jykim (jykim@hwajintni.co.kr)
 * 
 * Description	
 * unlink 후 바로 fopen 시 permission denied ! => system 함수 이용
 * 
 */
require_once('../../_conf/_common.php');

$_asx_file_name		= $_REQUEST['SCRIPT_TIMESTAMP']."_A.asx";
$_script_body	= $_REQUEST['SCRIPT_BODY'];
$_script_unit	= $_REQUEST['SCRIPT_UNIT'];

dupDelete(FWRITE_TEMP_DIR, $_asx_file_name);
//makeASX($_script_body, FWRITE_TEMP_DIR, AUDIO_TEMP_DIR, AUDIO_UNIT_DIR, $_asx_file_name, $_script_unit);
?>
<body>
<!-- <?=$_asx_file_name?> / 
<?=$_script_body?> -->
<embed src="<?=AUDIO_TEMP_DIR.$_REQUEST['SCRIPT_TIMESTAMP']?>_<?=$_REQUEST['SCRIPT_UNIT']?>.WAV" loop="false" autostart="true" hidden="false">

</body>