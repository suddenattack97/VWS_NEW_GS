<?php
/*
 * FileName		: toRecording.php
 * Description	: 텍스트음성변환 파일 생성 전 동명파일처리
 * Modify		: 2007-02-26
 * Company		: Hwajin T&I
 * Author		: jykim (jykim@hwajintni.co.kr)
 *
 * Description
 *
 */

require_once('../../_conf/_common.php');
/*

$_desc_tts_file	= $strFileName.'WAV';
if(file_exists(FWRITE_TEMP_DIR.$_desc_tts_file)){
	system ('del '.FWRITE_TEMP_DIR.$_desc_tts_file);
	print('<font color=red>'.FWRITE_TEMP_DIR.$_desc_tts_file.'</font>');
}*/
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.makeRecording('<?=TPL_DIR?>','<?=addslashes(FWRITE_DESC_DIR)?>');
//alert(parent.document.frm.CLIENT_FILE.value);
//-->
</SCRIPT>