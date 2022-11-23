<? // 공용 함수

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

/* 일회용 토큰 생성 */
function getToken(){
	require_once "_enc_lib.php";
    return create_hash(date("smYiHd"));
}


?>