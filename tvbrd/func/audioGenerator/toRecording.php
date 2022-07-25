<?php
/*
 * FileName		: toRecording.php
 * Description	: 음성녹음파일 업로드 후 미리듣기 생성 함수 호출
 * Modify		: 2007-02-23
 * Company		: Hwajin T&I
 * Author		: jykim (jykim@hwajintni.co.kr)
 *
 * Description
 *
 */
require_once('../../_conf/_common.php');

# 음성녹음파일 UPLOAD -> RENAME

$_file_ori		= AUDIO_TEMP_DIR . $_FILES['CLIENT_FILE']['name'];
$_file_ori2		= FWRITE_TEMP_DIR . $_FILES['CLIENT_FILE']['name'];
$_file_ext		= pathinfo($_file_ori);
$_file_new		= $_REQUEST['SCRIPT_TIMESTAMP'].'_R.'.$_file_ext['extension'];
$_file_tmp		= $_FILES['CLIENT_FILE']['tmp_name'];
$_file_new_up	= $_REQUEST['CLIENT_FILE_NEW'];

echo '_file_ori'.$_file_ori.'<br>';		
echo '_file_ori2'.$_file_ori2.'<br>';		
echo '_file_ext'.$_file_ext.'<br>';		
echo '_file_new'.$_file_new.'<br>';		
echo '_file_tmp'.$_file_tmp.'<br>';		
echo '_file_new_up'.$_file_new_up.'<br>';

/*
 * IF			: 방송문구 수정시 기존 음성파일 사용하는 경우]
 * Description	: 기등록된 음성파일 temp 폴더에 복사 : 미리듣기용
 * 				: 1. copy
 * 				: 2. makeASX
 */
if($_file_new_up!='' && $_FILES['CLIENT_FILE']['name']==''){


	system ('copy '.$_REQUEST['audio_dir'].$_REQUEST['SCRIPT_NO'].$_REQUEST['AUDIO_LOCALE'].'_R.WAV '.FWRITE_TEMP_DIR.$_REQUEST['SCRIPT_TIMESTAMP'].'_R.WAV');
	//echo ('copy '.$_REQUEST['audio_dir'].$_REQUEST['DESC_ID'].$_REQUEST['AUDIO_LOCALE'].'_R.WAV '.FWRITE_TEMP_DIR.$_REQUEST['SCRIPT_TIMESTAMP'].'_R.WAV');
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
/*----------------------------------------------------------------------------------
 *	DEBUG		copy	기존녹음파일사용시
 * --------------------------------------------------------------------------------*/	
		alert('기존 녹음파일을 사용합니다.');
		parent.makeASX('<?=TPL_DIR?>');
	//-->
	</SCRIPT>
<?
/*
 * IF			: 방송문구 등록시
 * Description	: 파일 업로드 후 미리듣기 파일 생성
 * 				: 1. upload
 * 				: 2. makeASX
 * 				: #. fileHeader check !
 */
}else if(uploadFile(FWRITE_TEMP_DIR, $_file_ori2, $_file_tmp, $_file_new)){
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert('파일을 업로드합니다.');
/*----------------------------------------------------------------------------------
 *	DEBUG		upload ori2	파일 업로드시
 * --------------------------------------------------------------------------------*/	
		//alert('upload ori2 <?=$_FILES['CLIENT_FILE']['name']?>');
		<?
		#WAVE FILE FORMAT CHECK !
		$fileChkResult = fileChk(FWRITE_TEMP_DIR.$_file_new);
		if($fileChkResult=='0'){
		?>
		parent.document.frm.CLIENT_FILE_NEW.value = '<?=$_file_new?>';
		parent.makeASX('<?=TPL_DIR?>');
		<?
		}else if($fileChkResult=='1'){
		?>
		alert('파일 사이즈는 5MB를 초과하실 수 없습니다.');
		<?
		}else if($fileChkResult=='2'){
		?>
		alert('음성파일 형식이 맞지 않습니다.');
		<?
		}
		?>
	//-->
	</SCRIPT>
<?
/*
 * IF			:
 * Description	:
 * 				:
 * 				:
 */
}else{
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
/*----------------------------------------------------------------------------------
 *	DEBUG		upload ori2	파일 업로드시
 * --------------------------------------------------------------------------------*/	
	//alert('<?=$_file_ori?>---<?=$_file_new_up?>');
//-->
</SCRIPT>
<?
}
?>