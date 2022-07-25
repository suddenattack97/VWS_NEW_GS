<? require_once('../../../divas/_conf/_common.php');?>

<!--
	FileName	: toTTS2.php
	Description	: 텍스트음성변환 파일 생성 후 미리듣기 파일 호출
	Modify		: 2012-04-23
	Company		: Hwajin T&I 
	Author		: ssnam (ssnam@hwajintni.co.kr)  
-->

<html>
<head>
<title></title>
</head>
<body>
<?
	$URL = $_POST["SCRIPT_BODY"];
	$FILENAME = $_POST["SCRIPT_TIMESTAMP"]."_T";
	echo $ttttt = 'java HwajinVoiceMakeNew ' . VW_IP . ' ' . VW_PORT . ' "' . $URL . '" ' . FWRITE_TEMP_DIR . '' . $FILENAME . '.WAV';
	system ( $ttttt );
?>

<embed src="<?=AUDIO_TEMP_DIR?><?=$FILENAME?>.WAV" loop="false" autostart="true">
</body>
</html>