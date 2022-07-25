<!--
	FileName	: toTTS.asp
	Description	: 텍스트음성변환 파일 생성 후 미리듣기 생성 함수 호출
	Modify		: 2007-02-23
	Company		: Hwajin T&I 
	Author		: jykim (jykim@hwajintni.co.kr)  
-->

<html>
<head>
<title></title>
</head>
<body>
<%
	strServer		= Request("serverip")
	strPort			= Request("serverport")
	strSpeaker		= Request("speakerid")
	strFormat		= Request("voiceformat")
	strContent		= Request("content")
	strTextFormat	= 1
	strVolume		= 300
	strSpeed		= 200
	strPitch		= 100
	strDictIndex	= 1

	strFileName = Request("filename")
	strDirName = Request("dirname")
	TPL_AUDIO_DIR = Request("TPL_AUDIO_DIR")
		
	Set objTTS=server.CreateObject("TTSSrvApiCom.TTSSrvAPI")	
	objTTS.TTSFile strServer, strPort, strContent, Len(strContent), strDirName, strFileName, strSpeaker, strFormat
	
	'Response.Write "<br> Server IP - " & strServer
	'response.end
	'Response.Write "<br> Server Port - " & strPort
	'Response.Write "<br> Speaker ID - " & strSpeaker
	'Response.Write "<br> Voice Format - " & strFormat
	'Response.Write "<br> Content - " & strContent
	'if objTTS.returncode > 0 then
	'	Response.Write "<br><br>TTSFile Success!!! Please check the result file in server. "
	'else
	'	Response.Write "<br><br>TTSFile Failed!!! Please check the return code : " & objTTS.returncode
	'end if
%>
<SCRIPT LANGUAGE="JavaScript">
<!--
	//parent.document.frm.DESC_TTS_FILE.value = '<%=strFileName%>.WAV';	
	parent.makeASX('./../../template/');
//-->
</SCRIPT>
<!-- <embed src="<%=TPL_AUDIO_DIR & strFileName%>.WAV" loop="false" autostart="true" hidden="true"> -->
</body>
</html>