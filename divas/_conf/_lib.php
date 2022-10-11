<? // 공용 함수
/**
 *	방송문자열 TTS <-> WAVE 파일명 전환
 * 	$type:0 TTS <- WAVE
 * 	$type:1 TTS -> WAVE
 */
function asxString($string, $filename, $tts, $type) {
	if ($type == 0) {
		$STRING_REPLACE = str_replace ( $filename, $tts, $string );
	} else {
		$STRING_REPLACE = str_replace ( $tts, $filename, $string );
	}
	return $STRING_REPLACE;
}

/**
 * 	$chk_file : 파일 전체경로
 * 	$chk_result : 0 - TRUE / IMA_ADPCM WAVE FILE
 * 	: 1 - FALSE / FILE SIZE OVER (MAX 5M)
 * 	: 2 - FALSE / FILE FORMAT ERROR
 */
function fileChk($chk_file) {
	$chk_result = '0';
	if (filesize ( $chk_file ) > (5242880)) {
		$chk_result = '1';
	} else {
		if ($stream = fopen ( $chk_file, 'rb' )) {
			
			$file_info = fread ( $stream, 22 );
			$info_substr0 = substr ( $file_info, 0, 4 );
			$info_substr1 = substr ( $file_info, 4, 4 );
			$info_substr2 = substr ( $file_info, 8, 4 );
			$info_substr3 = substr ( $file_info, 12, 4 );
			$info_substr4 = substr ( $file_info, 16, 4 );
			$info_substr5 = bin2hex ( substr ( $file_info, 20, 1 ) );
			$info_substr6 = bin2hex ( substr ( $file_info, 21, 1 ) );
			$info_substr7 = $info_substr6 . $info_substr5;
			fclose ( $stream );
		}
		if ($info_substr0 != 'RIFF' || $info_substr2 != 'WAVE' || $info_substr7 != '0011') {
			$chk_result = '2';
		}
	}
	return $chk_result;
}

/**
 * 	파일 업로드
 * 	$dir_temp : 파일저장경로
 * 	$file_ori : 원본파일명
 * 	$file_tmp : 업로드시 임시파일명
 * 	$file_new : 업로드시 새로운 파일명
 * 	Description : unlink(), rename() 함수 사용시 에러 => system(copy/del) 대체
 * 	: if(file_exists($file_new)) unlink($file_new);
 * 	: if(file_exists($file_ori)) rename ($file_ori, $file_new);
 * 	: $this -> output[0]['err_msg'] = 에러메세지 확인용
 * 	: $this -> output[0]['err_msg'] = $_FILES;
 * 	: $this -> output[0]['err_msg'] = "파일 업로드 공격 가능성!:".$_FILES;
 */
function uploadFile($dir_temp, $file_ori, $file_tmp, $file_new) {
	$file_new = $dir_temp . $file_new;
	if (move_uploaded_file ( $file_tmp, $file_ori )) {
		exec( 'copy ' . $file_ori . ' ' . $file_new );
		exec( 'del ' . $file_ori );
		return true;
	} else {
		return false;
	}
}

/**
 * 	파일중복체크 후 삭제
 * 	Description : unlink() 함수 사용시 에러 => system(del) 대체
 * 	: unlink($fwrite_audio_path.$asx_file_name);
 */
function dupDelete($fwrite_audio_path, $asx_file_name) {
	// FILE CHECK
	if ($fwrite_audio_path != '' && $asx_file_name != '' && $fwrite_audio_path != null && $asx_file_name != null) {
		if (file_exists ( $fwrite_audio_path . $asx_file_name )) {
			exec( 'del ' . $fwrite_audio_path . $asx_file_name );
			// DEBUGGING PRINT
			// print('del ------------------------------------------'.$fwrite_audio_path.$asx_file_name);
		}
	}
}

/**
 * 	미리듣기 목록 파일 생성
 * 	$script_body : 전체 조합 문자열
 * 	$fwrite_audio_path : asx 파일 저장경로
 * 	$fwrite_unit_path : 메모리 파일 저장 경로
 * 	$asx_file_name : asx 파일 이름
 * 	Description : fopen mode w+
 * 	: 읽기 쓰기가 가능; 파일포인터를 파일의 맨 앞에 놓습니다. 그리고 파일의 크기를0으로 만듭니다. 파일이 없으면 만듭니다.
 */
function makeASX($script_body, $fwrite_temp_dir, $audio_temp_dir, $audio_unit_dir, $asx_file_name, $script_unit) {
	$fd = fopen ( $fwrite_temp_dir . $asx_file_name, "w+" );
	
	if ($fd) {
		// FILE WRITE : <ASX>
		fwrite ( $fd, "<asx version=\"3.0\" bannerbar=\"auto\">\n" );
		if ($script_unit == 'T') {
			fwrite ( $fd, "<entry><ref href = \"" . $audio_temp_dir . str_replace ( 'A.asx', 'T.wav', $asx_file_name ) . "\"/></entry>\n" );
		} else if ($script_unit == 'R') {
			fwrite ( $fd, "<entry><ref href = \"" . $audio_temp_dir . str_replace ( 'A.asx', 'R.wav', $asx_file_name ) . "\"/></entry>\n" );
		}
		// FILE WRITE : <ENTRY>
		/*
		 * $desc_sub_string = explode("#", $script_body);
		 *
		 * for($i=1;$i<sizeof($desc_sub_string);$i++){
		 *
		 * if(substr($desc_sub_string[$i],0,1)=='T' || substr($desc_sub_string[$i],0,1)=='R'){
		 * $tmp_preview = $audio_temp_dir.substr($desc_sub_string[$i],1,strlen($desc_sub_string[$i]));
		 * }else{
		 * $tmp_preview = $audio_unit_dir.$desc_sub_string[$i].'.WAV';
		 * }
		 * fwrite($fd, "<entry><ref href = \"".$tmp_preview."\"/></entry>\n");
		 * }
		 */
		// FILE WRITE : </ASX>
		fwrite ( $fd, "</asx>" );
		
		// FILE CLOSE
		fclose ( $fd );
	}
}

/**
 * 	구 문자열 암호화
 */
function getEncodedString($str) {
	return strrev ( $str );
}

/**
 * 	구 문자열 복호화
 */
function getDecodedString($str) {
	return strrev ( $str );
}

/**
 * 	경고메시지 출력 후 실행 중단
 * 	$message : 출력메세지 문자열
 * 
 * 	@return void
 */
function breakProcess($message) {
	@mysql_close ();
	if ($message != "") {
		echo "<script language=javascript>";
		echo "alert('" . $message . "');";
		echo "history.back();";
		echo "</script>";
	}
	exit ();
}

/**
 * 	실행중단 및 에러출력
 * 
 * 	@return void
 */
function breakProcessAndShowError($message) {
	@mysql_close ();
	if ($message != "") {
		echo $message;
	}
	exit ();
}

/**
 * 	유효성 검사
 * 
 * 	@return void
 */
function validCheck($vObj) {
	foreach ( $vObj as $validator ) {
		// 유효하지 않으면..
		if (! $validator->isValid ()) {
			// 에러 메시지를 가져옴.
			while ( $error = $validator->getError () ) {
				$errorMsg .= $error . " ";
			}
			// 실행 중지 (alert메시지 없이..)
			$this->breakProcess ( $errorMsg );
		}
	}
}

/**
 * 	한글 적용하여 문자열을 자른다
 * 
 * 	@return string
 */
function cutStr($str, $len, $tail = "..") {
	if ($len >= strlen ( $str ))
		return $str;
	$klen = $len - 1;
	while ( ord ( $str [$klen] ) & 0x80 )
		$klen --;
	return substr ( $str, 0, $len - (($len + $klen + 1) % 2) ) . $tail;
}

/**
 * 	필터링 대상 단어가 있는지 체크
 * 	대상 단어가 없으면 공백을 리턴한다
 * 
 * 	@return string
 */
function isFilterWord($string, $filterList) {
	$separators = ",";
	for($token = strtok ( $filterList, $separators ); $token !== false; $token = strtok ( $separators )) {
		if (eregi ( trim ( $token ), $string )) {
			return $token;
		}
	}
	return "";
}

/**
 * 	최근 새 RS인지 확인
 * 
 * 	@return boolean
 */
function isNew($Y_m_d, $H_i_s, $hourTerm) {
	$day_array = explode ( "-", $Y_m_d );
	$second_array = explode ( ":", $H_i_s );
	$writeTime = mktime ( $second_array [0], $second_array [1], $second_array [2], $day_array [1], $day_array [2], $day_array [0] );
	
	$result = date ( "Y-m-d  H:i:s", $writeTime + ($hourTerm * 60 * 60) );
	$year = substr ( $result, 0, 4 );
	$month = substr ( $result, 5, 2 );
	$day = substr ( $result, 8, 2 );
	
	if (( int ) ((mktime ( 0, 0, 0, $month, $day, $year ) - time ()) / ($hourTerm * 60 * 60)) < 0) {
		return false;
	} else {
		return true;
	}
}

/**
 * 	금지된 태그 속성을 제거한다
 * 
 * 	@return string
 */
function removeEvilAttributes($tagSource) {
	return stripslashes ( preg_replace ( "/" . B_REJECT_ATTRIBUTE . "/i", 'forbidden', $tagSource ) );
}

/**
 * 	금지된 태그를 제거한다
 * 
 * 	@return string
 */
function removeEvilTags($source) {
	return $source = strip_tags ( $source, B_ALLOW_TAG );
}

/**
 * 	하이퍼 링크를 만든다
 * 
 * 	@return string
 */
function textToLink($text) {
	$string = " $text ";
	
	static $repl = array (
			"(\s)(www\.[-\.a-zA-Z]+\w)" => "\\1<a href=http://\\2 target=_blank>\\2</a>",
			"(\s)http:\/\/([^\s<]+)" => "\\1<a href=http://\\2 target=_blank>http://\\2</a>",
			"(\s)https:\/\/([^\s<]+)" => "\\1<a href=https://\\2 target=_blank>https://\\2</a>",
			"(\s)ftp:\/\/([^\s<]+)" => "\\1<a href=ftp://\\2 target=_blank>ftp://\\2</a>",
			
			"(\s)mailto:([^\s@:<]+@[^\s@<]+\w)" => "\\1<a href=mailto:\\2>\\2</a>",
			"(\s)([^\s@:<]+@[^\s@<]+\w)" => "\\1<a href=mailto:\\2>\\2</a>" 
	);
	
	foreach ( $repl as $match => $replace )
		$string = preg_replace ( "/$match/", $replace, $string );
	
	return $string;
}

/**
 * 	원격지 파일 존재 여부
 *
 * 	@return string
 */
function curlFileCheck($filepath){
	if(!$filepath) return false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $filepath);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if(curl_exec($ch) !== false) {
		return true;
	} else {
		return false;
	}
}

/**
 *	모바일 기기 체크
 *	
 *	@return string
 */
function MobileCheck(){
	$MobileArray = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");
	$checkCount = 0;
	for($i=0; $i<sizeof($MobileArray); $i++){
		if( preg_match( "/$MobileArray[$i]/", strtolower($_SERVER['HTTP_USER_AGENT']) ) ){ 
			$checkCount++; break; 
		}
	}
	return ($checkCount >= 1) ? "Mobile" : "Computer"; 
}

/**
 *	XSS(크로스사이트 스크립트) 공격 취약점 체크
 *	해당 되는 문자열 삭제
 *	@return string
 */
function XSSCheck($str){
	// $filters = array('','<','>','&lt;','&gt;','"',"'",'&','%','%00');	// 특수문자 제거는 정규식으로
	$filters = array('','INNERHTML','JAVASCRIPT','EVAL','ONMOUSEWHEEL','ONACTIVE','ONFOCUSOUT'
	,'EXPRESSION','CHARSET','ONDATAAVAILABLE','ONCUT','ONKEYUP','APPLET','DOCUMENT','ONAFTERIPUDATE','ONCLICK','ONKEYPRESS','META','STRING'
	,'ONMOUSEDOWN','ONCHANGE','ONLOAD','XML','CREATE','ONBEFOREACTIVATE','ONBEFORECUT','ONBOUNCE','BLINK','APPEND','ONBEFORECOPY','ONDBCLICK'
	,'ONMOUSEENTER','LINK','BINDING','ONBEFOREDEACTIVATE','ONDEACTIVATE','ONMOUSEOUT','STYLE','ALERT','ONDATASETCHAGED','ONDRAG','ONMOUSEOVER'
	,'SCRIPT','MSGBOX','CNBEFOREPRINT','ONDRAGEND','ONSUBMIT','EMBED','REFRESH','CNBEFOREPASTE','ONDRAGENTER','ONMOUSEEND','OBJECT','VOID'
	,'ONBEFOREEDITFOCUS','ONDRAGLEAVE','ONRESIZESTART','IFRAME','COOKIE','ONBEFOREULOAD','ONDRAGOVER','ONULOAD','FRAME','HREF','ONBEFOREUPDATE'
	,'ONDRAGSTART','ONSELECTSTART','FRAMESET','ONPASTE','ONPROPERTYCHANGE','ONDROP','ONRESET','ILAYER','ONRESIZE','ONDATASETCOMPLETE','ONERROR'
	,'ONMOVE','LAYER','ONSELECT','ONCELLCHANGE','ONFINISH','ONSTOP','BGSOUND','BASE','ONLAYOUTCOMPLETE','ONFOCUS','ONROWEXIT','TITLE','ONBLUR'
	,'ONSELECTIONCHANGE','VBSCRIPT','ONERRORUPDATE','ONBEFORE','ONSTART','ONROWSINSERTED','ONKEYDOWN','ONFILTERCHAGE','ONMOUSEUP','ONFOCUSIN'
	,'ONCONTROLSELECTED','ONROWSDELETE','ONLOSECAPTURE','ONROWENTER','ONHELP','ONREADYSTATECHANGE','ONMOUSELEAVE','ONMOUSEMOVE'
	,'innerHTML','javascript','eval','onmousewheel','onactive','onfocusout','expression','charset'
	,'ondataavailable','oncut','onkeyup','applet','document','onafteripudate','onclick','onkeypress','meta','string','onmousedown','onchange'
	,'onload','xml','create','onbeforeactivate','onbeforecut','onbounce','blink','append','onbeforecopy','ondbclick','onmouseenter','link'
	,'binding','onbeforedeactivate','ondeactivate','onmouseout','style','alert','ondatasetchaged','ondrag','onmouseover','script','msgbox'
	,'cnbeforeprint','ondragend','onsubmit','embed','refresh','cnbeforepaste','ondragenter','onmouseend','object','void','onbeforeeditfocus'
	,'ondragleave','onresizestart','iframe','cookie','onbeforeuload','ondragover','onuload','frame','Href','onbeforeupdate','ondragstart'
	,'onselectstart','frameset','onpaste','onpropertychange','ondrop','onreset','ilayer','onresize','ondatasetcomplete','onerror','onmove'
	,'layer','onselect','oncellchange','onfinish','onstop','bgsound','base','onlayoutcomplete','onfocus','onrowexit','title','onblur'
	,'onselectionchange','vbscript','onerrorupdate','onbefore','onstart','onrowsinserted','onkeydown','onfilterchage','onmouseup','onfocusin'
	,'oncontrolselected','onrowsdelete','onlosecapture','onrowenter','onhelp','onreadystatechange','onmouseleave','onmousemove');
	
	$indices = array();
	$tmpStr = trim($str);
	$tmpStr = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $tmpStr);
	$tmpStr = "!".$tmpStr;
	foreach($filters as $key => $val){
		if($key > 0){
			if(strlen($tmpStr) > 0){
				$idx = strpos($tmpStr, $val);
				if($idx){
					array_push($indices, $filters[$key]);
					$tmpStr = str_replace($filters[$key], '', $tmpStr);
				}
			}
		}
	}
	$tmpStr = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $tmpStr);
	return $tmpStr; 
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>