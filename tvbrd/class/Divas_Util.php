<?
/***********************************************************
 * 파 일 명 : Divas_Util.class                             *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : ssNam                                        *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 유틸함수 모음                                *
 ***********************************************************/

Class Divas_Util {

	private $DB;

	/* 생성자 */
	function Divas_Util($DB=null) {
		$this->DB = $DB;
	}



	//***********************************************************************************************************************
	// 장비상태 출력 (O and X)
	//***********************************************************************************************************************
	function getState($state) {
		if($state != "" && $state = "0") {
			$reState = "0";
		}else if($state != "" && $state = "1") {
			$reState = "X";
		}else {
			$reState = "&nbsp;";
		}
		return $reState;
	}

	//***********************************************************************************************************************
	// 시간변환쿼리 변환 (To_Date) insert
	//***********************************************************************************************************************
	function toDate($date, $dateForm) {
		if($this->checkDatabase() == "oracle") {
			switch ($dateForm) {
				Case 0 : $convDate = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI:SS') "; break;
				Case 1 : $convDate = "TO_DATE('" . $date . "', 'YYYY-MM-DD') ";            break;
				Case 2 : $convDate = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24') ";       break;
				Case 3 : $convDate = "TO_DATE('" . $date . "', 'YYYY-MM-DD HH24:MI') ";    break;
				Case 4 : $convDate = "TO_DATE('" . $date . "', 'YYYY-MM') ";               break;
				Case 5 : $convDate = "TO_DATE('" . $date . "', 'YYYY') ";                  break;
			}
		}else {
			$convDate = "'" . $date . "'";
		}
		return $convDate;
	}

	//***********************************************************************************************************************
	// 시간변환쿼리 변환 (To_Char)
	//***********************************************************************************************************************
	function toChar($dateField, $dateForm) {
		if($this->checkDatabase() == "oracle") {
			Switch ($dateForm) {
				Case 0 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY-MM-DD HH24:MI:SS') " ;	break;
				Case 1 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY-MM-DD') ";		break;
				Case 2 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY-MM-DD HH24') ";		break;
				Case 3 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY-MM-DD HH24:MI') ";	break;
				Case 4 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY-MM') ";			break;
				Case 5 : $convDate = "TO_CHAR(" . $dateField . ", 'YYYY') ";			break;
			}
		}else {
			$convDate = $dateField;
		}
		return $convDate;
	}

	//***********************************************************************************************************************
	// 널체크하여 정해진 값으로 대체 (&nbsp;)
	//***********************************************************************************************************************
	Function nullNbsp($value) {
		if (is_null($value) || $value == "") {
			$value = "&nbsp;";
		}
		return $value;
	}

	//***********************************************************************************************************************
	//  2자리수
	//***********************************************************************************************************************
	Function DoubleFit($num) {
		if ($num < 10) {
			$num = "0" . $num;
		}
		return $num;
	}

	//***********************************************************************************************************************
	// 널체크하여 정해진 값으로 대체 (-)
	//***********************************************************************************************************************
	Function nullHyphen($value) {
		if (is_null($value)) {
			$value = "-";
		}
		return $value;
	}

	//************************************************************************************************************
	//* print_rr (배열 출력)
	//************************************************************************************************************
	Function print_rr($arr) {
    print "<pre>";
    print_r($arr);
    print "</pre>";
  }

	/******************************************************************************************
	 * 로그기록
	 ******************************************************************************************/
	Function userLog($homeDir, $filename, $text){
	         $fp = fopen($homeDir.$filename, "w");
					 fwrite($fp, date("H:i:s") . $text."\r\n");
	         fclose($fp);
	}

	/******************************************************************************************
   * 문자열 암호화
	 ******************************************************************************************/
function getEncodedString($str) {
    return strrev($str);
}

	/******************************************************************************************
   * 문자열 복호화
	 ******************************************************************************************/
function getDecodedString($str) {
    return strrev($str);
}


/******************************************************************************************
 * 배열 최소값
 ******************************************************************************************/
    function array_min( &$arr )
    {
        $min = FALSE;
        foreach( $arr as $a )
            if( $min === FALSE || $a < $min ) $min = $a;
        return $min;
    }

/******************************************************************************************
 * 배열 최대값
 ******************************************************************************************/
    function array_max( &$arr )
    {
        $max = FALSE;
        foreach( $arr as $a )
            if( $max === FALSE || $a > $max ) $max = $a;
        return $max;
    }


/******************************************************************************************
 * 배열 평균
 ******************************************************************************************/
   function array_avg( &$arr )
    {
        $sum = 0;
        foreach( $arr as $a )
            $sum += $a;
        return $sum / count($arr);
    }

/******************************************************************************************
 * 배열 표준편차
 ******************************************************************************************/
    function array_dev( &$arr, $avg = NULL )
    {
        if( $avg == NULL ) $avg = array_avg($arr);

        $dev = 0;
        foreach( $arr as $a )
            $dev += pow(($a - $avg),2);
        return sqrt($dev);
    }


/******************************************************************************************
 * xss필터
 ******************************************************************************************/
    /*xss 필터 함수*/
    function xss_clean($data)
    {
            // Fix &entity\n;
            $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
            $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
            $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
            $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

            // Remove any attribute starting with "on" or xmlns
            $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

            // Remove javascript: and vbscript: protocols
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

            // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
                        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?ssion[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

            // Remove namespaced elements (we do not need them)
            $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

            do
            {
                    // Remove really unwanted tags
                    $old_data = $data;
                    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
            }
            while ($old_data !== $data);

            // we are done...
            return $data;
    }

/******************************************************************************************
 * 암호화
 ******************************************************************************************/

    // 엔코드
    function encode($data) {
        return base64_encode($data)."||";
    }

    // 디코드
    function decode($data){
        $vars=explode("&",base64_decode(str_replace("||","",$data)));
        $vars_num=count($vars);
        for($i=0;$i<$vars_num;$i++) {
            $elements=explode("=",$vars[$i]);
            $var[$elements[0]]=$elements[1];
        }
        return $var;
    }

    // 문자열 자르는 부분
    function strCut($str, $len) {
        if ($len >= strlen($str)) return $str;
        $klen = $len - 1;
        while(ord($str[$klen]) & 0x80) $klen--;
        return substr($str, 0, $len - (($len + $klen + 1) % 2)) ."..";
    }

    // HTML 출력
    function strHtml($str) {
        $str = trim($str);
        $str = stripslashes($str);
        return $str;
    }

    // 문자열 HTML BR 형태 출력
    function strHtmlBr($str) {
        $str = trim($str);
        $str = stripslashes($str);

        ##2008 05 29 추가 공백을 nbsp로 변환
        ## 혹시나 다른부분에서 버그 가 발생하면. 우선. 하단 한줄을 주석처리하시길 바랍니다.
        $str = str_replace(" ","&nbsp",$str);
        $str = str_replace("\n","<br>", $str);
        return $str;
    }

    // 문자열 TEXT 형태 출력
    function strHtmlNo($str) {
        $str = trim($str);
        $str = htmlspecialchars($str);
        $str = stripslashes($str);

        ##2008 05 29 추가 공백을 nbsp로 변환
        ## 혹시나 다른부분에서 버그 가 발생하면. 우선. 하단 한줄을 주석처리하시길 바랍니다.
        $str = str_replace(" ","&nbsp",$str);
        $str = str_replace("\n","<br>", $str);
        return $str;
    }

    // 문자열 TEXT 형태 출력
    function strHtmlNoBr($str) {
        $str = trim($str);
        $str = htmlspecialchars($str);
        $str = stripslashes($str);
        return $str;
    }

    // 날자출력 형태
    function strDateCut($str, $chk = 1) {
        if( $chk==1 ) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $str    =   $year."/".$mon."/".$day;
        } else if( $chk==2 ) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $time   =   substr($str,11,2);
            $minu   =   substr($str,14,2);
            $str    =   $year."/".$mon."/".$day." ".$time.":".$minu;
        } else if( $chk==3 ) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $str    =   $year."-".$mon."-".$day;
        } else if( $chk==4 ) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $time   =   substr($str,11,2);
            $minu   =   substr($str,14,2);
            $str    =   $year."-".$mon."-".$day." ".$time.":".$minu;
        } else if( $chk==5 ) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $str    =   $year."년 ".$mon."월 ".$day."일";
        } else if( $chk==6) {
            $year   =   substr($str,0,4);
            $mon    =   substr($str,5,2);
            $day    =   substr($str,8,2);
            $time   =   substr($str,11,2);
            $minu   =   substr($str,14,2);
            $str    =   $year."년 ".$mon."월 ".$day."일 ".$time."시 ".$minu."분";
        }
        return $str;
    }

    // 숫자로 된 값을 요일로 변환한다. (0:월요일, 1:화요일, 6:일요일)
    function strDateWeek($chk) {
        if( $chk==0 ) {
            $str="월요일";
        } else if( $chk==1 ) {
            $str="화요일";
        } else if( $chk==2 ) {
            $str="수요일";
        } else if( $chk==3 ) {
            $str="목요일";
        } else if( $chk==4 ) {
            $str="금요일";
        } else if( $chk==5 ) {
            $str="토요일";
        } else if( $chk==6) {
            $str="일요일";
        }
        return $str;
    }

    # E-MAIL 주소가 정확한 것인지 검사하는 함수
    #
    # eregi - 정규 표현식을 이용한 검사 (대소문자 무시)
    #         http://www.php.net/manual/function.eregi.php
    # gethostbynamel - 호스트 이름으로 ip 를 얻어옴
    #          http://www.php.net/manual/function.gethostbynamel.php
    # checkdnsrr - 인터넷 호스트 네임이나 IP 어드레스에 대응되는 DNS 레코드를 체크함
    #          http://www.php.net/manual/function.checkdnsrr.php
    function chkMail($email,$hchk=0) {
        $url = trim($email);
        if($hchk) {
            $host = explode("@",$url);
            if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) {
                if(checkdnsrr($host[1],"MX") || gethostbynamel($host[1])) return $url;  else return false;
            }
        } else {
            if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) return $url;  else return false;
        }
    }
    // 주민등록번호진위여부 확인 함수
    function chkJumin($resno1,$resno2) {
        $resno = $resno1.$resno2;
        $len = strlen($resno);
        if ($len <> 13) return false;
        if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false;
        $birthYear = ('2' >= $resno[6]) ? '19' : '20';
        $birthYear += substr($resno, 0, 2);
        $birthMonth = substr($resno, 2, 2);
        $birthDate = substr($resno, 4, 2);
        if (!checkdate($birthMonth, $birthDate, $birthYear)) return false;
        for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];
        $multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);
        for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);
        if ((11 - ($sum % 11)) % 10 != $buf[12]) return false;
        return true;
    }

    // 사업자등록번호 체크 함수
    function chkCompany($reginum) {
        $weight = '137137135';
        $len = strlen($reginum);
        $sum = 0;
        if ($len <> 10) return false;
        for ($i = 0; $i < 9; $i++) $sum = $sum + (substr($reginum,$i,1)*substr($weight,$i,1));
        $sum = $sum + ((substr($reginum,8,1)*5)/10);
        $rst = $sum%10;
        if ($rst == 0) $result = 0;
        else $result = 10 - $rst;
        $saub = substr($reginum,9,1);
        if ($result <> $saub) return false;
        return true;
    }

    # 문자열에 한글이 포함되어 있는지 검사하는 함수
    function chkHan($str) {
        # 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
        $strCnt=0;
        while( strlen($str) >= $strCnt) {
            $char = ord($str[$strCnt]);
            if($char >= 0xa1 && $char <= 0xfe) return true;
            $strCnt++;
        }
    }

    // 문자열 체크(숫자)
    function chkDigit($str) {
        if(ereg("^[1-9]+[0-9]*$",$str))  return true;
        else return false;
    }

    // 문자열 체크(알파)
    function chkAlpha($str) {
        if(ereg("^[a-zA-Z]+[a-zA-Z]*$",$str))  return true;
        else return false;
    }

    // 문자열 체크(알파+숫자)
    function chkAlnum($str) {
        if(ereg("^[1-9a-zA-Z]+[0-9a-zA-Z]*$",$str))  return true;
        else return false;
    }

    // 문자열 체크(알파+숫자+특수문자)
    function chkAlnumAll($str) {
        if(ereg("^[1-9a-zA-Z_-]+[0-9a-zA-Z_-]*$",$str))  return true;
        else return false;
    }

    // 메세지 출력
    function msg($msg) {
        echo "<script language='javascript'> alert('$msg'); </script>";
    }

    // 메세지 출력후 BACK
    function errMsg($msg) {
        echo "<script language='javascript'> alert('$msg'); history.back(); </script>";
        exit();
    }

    // 메세지 출력후 이동하는 자바스크립트
    function alertJavaGo($msg,$url) {
        echo "<script language='javascript'> alert('$msg'); location.replace('$url'); </script>";
        exit();
    }

    // 메세지 출력후 이동하는 메타테그
    function alertMetaGo($msg,$url) {
        echo "<script language='javascript'> alert('$msg'); </script>";
        echo "<meta http-equiv='refresh' content='0;url=$url'>";
        exit();
    }

    // 메타태그로 바로 가기
    function metaGo($url) {
        echo "<meta http-equiv='refresh' content='0;url=$url'>";
        exit();
    }

    // 자바스크립트로 바로 가기
    function javaGo($url) {
        echo "<script language='javascript'> location.href='$url'; </script>";
        exit();
    }

    // 창을 닫기
    function winClose() {
        echo "<script language='javascript'> window.close(); </script>";
        exit();
    }

    // 메세지 출력후 창을 닫기
    function msgClose($msg) {
        echo "<script language='javascript'> alert('$msg'); window.close(); </script>";
        exit();
    }


    // 창을 닫고 가는 함수
    function javaGoClose($url) {
        echo "<script language='javascript'> opener.location.replace('$url'); self.close(); </script>";
        exit();
    }

    // 프레임으로 된 경우 상위 프레임으로 가는 함수
    function javaGoTop($url) {
        echo "<script language='javascript'> parent.frames.top.location.replace('$url'); </script>";
        exit();
    }

	// 이미지 업로드 관련 함수
	function imgUpload($kind, $name, $data){ // kind = (1: 상단 로고, 2: 장비 상태 이미지), name = file name, data = 기타
		$file_name = $_FILES[$name]['name'];           // 업로드한 파일명
		$file_tmp_name = $_FILES[$name]['tmp_name'];   // 임시 디렉토리에 저장한 파일명
		$file_size = $_FILES[$name]['size'];           // 업로드한 파일의 크기
		$file_type = $_FILES[$name]['type'];           // 업로드한 파일의 타입
		
		if($file_size > 5000000){
			return array(2, "이미지는 5mb 이하만 등록하실 수 있습니다.");
		}else if($file_type != "image/jpeg" && $file_type != "image/png"){
			return array(2, "jpeg 또는 png만 등록하실 수 있습니다.");
		}
		
		$real_name = $file_name; // 업로드 하기 전 파일명
		$arr = explode(".", $real_name);
		$file_exe = $arr[1];

		if($kind == 1){
			$upload_time = time(); // 업로드 되는 시간
			$upload_name = "file_".$upload_time.".".$file_exe; // 업로드 되는 파일명
			$upload_dir = "../img/top/".$upload_name; // 파일을 저장할 디렉토리
			$db_dir = "img/top/".$upload_name; // 디비에 저장할 디렉토리
		}else if($kind == 2){
			$upload_time = time();
			$upload_name = "file_".$upload_time.".".$file_exe;
			//$upload_dir = "../img/state/".$upload_name;
			$upload_dir = "../../divas/images/state/".$upload_name;
			//$db_dir = "img/state/".$upload_name;
			$db_dir = $upload_name;
		}
		
		// 파일을 지정한 디렉토리에 업로드
		if( !move_uploaded_file($file_tmp_name, $upload_dir) ){
			return array(2, "파일 업로드 중 오류가 발생 했습니다.");
		}else{
			return array(1, $db_dir);
		}
	}

}//End Class
?>
