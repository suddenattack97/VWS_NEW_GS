<?php
/*
 * FileName		: toRecording.php
 * Description	: ������������ ���ε� �� �̸���� ���� �Լ� ȣ��
 * Modify		: 2007-02-23
 * Company		: Hwajin T&I
 * Author		: jykim (jykim@hwajintni.co.kr)
 *
 * Description
 *
 */
require_once('../../_conf/_common.php');

# ������������ UPLOAD -> RENAME

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
 * IF			: ��۹��� ������ ���� �������� ����ϴ� ���]
 * Description	: ���ϵ� �������� temp ������ ���� : �̸�����
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
 *	DEBUG		copy	�����������ϻ���
 * --------------------------------------------------------------------------------*/	
		alert('���� ���������� ����մϴ�.');
		parent.makeASX('<?=TPL_DIR?>');
	//-->
	</SCRIPT>
<?
/*
 * IF			: ��۹��� ��Ͻ�
 * Description	: ���� ���ε� �� �̸���� ���� ����
 * 				: 1. upload
 * 				: 2. makeASX
 * 				: #. fileHeader check !
 */
}else if(uploadFile(FWRITE_TEMP_DIR, $_file_ori2, $_file_tmp, $_file_new)){
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert('������ ���ε��մϴ�.');
/*----------------------------------------------------------------------------------
 *	DEBUG		upload ori2	���� ���ε��
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
		alert('���� ������� 5MB�� �ʰ��Ͻ� �� �����ϴ�.');
		<?
		}else if($fileChkResult=='2'){
		?>
		alert('�������� ������ ���� �ʽ��ϴ�.');
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
 *	DEBUG		upload ori2	���� ���ε��
 * --------------------------------------------------------------------------------*/	
	//alert('<?=$_file_ori?>---<?=$_file_new_up?>');
//-->
</SCRIPT>
<?
}
?>