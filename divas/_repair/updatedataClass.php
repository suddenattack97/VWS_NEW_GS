<? 
/***********************************************************
 * 작 성 일 : 2018-02-21                                   *
 * 소    속 : (주)화진티엔아이 기술연구소                   *
 * 작성목적 : 유지관리 시스템 장비정보 동기화 클래스     *
 *****************************************************/
@header("Content-Type: text/html; charset=EUC-KR");
class UpdateData{
	private $DB;
	
	public $SetupCode; //기관코드
	
	function element($item, $array, $default = NULL)
    {
        return is_array($array) && array_key_exists($item, $array) ? $array[$item] : $default;
    }

	function UpdateData($DB){
		$this->DB = $DB;
	}

	/* 자동업데이트 */
	function AutoRtuUpdate(){
		$SetupCode = $this->getAgencyCode(); //기관코드 LOCAL_CODE -- 넘겨야됨
		
		//$this->getRtuInfo();
		$SQL = " SELECT * FROM RTU_INFO A LEFT OUTER JOIN  RTU_LOCATION B ON A.RTU_ID = B.RTU_ID "; //장비등록 페이지
		$rs = $this->DB->execute($SQL);

		$cnt = $this->DB->recordcount;

		for($i = 0; $i < $cnt; $i++){
			$AREA_CODE .= $rs [$i] ['AREA_CODE']."||";
			$RTU_NAME .= $rs [$i] ['RTU_NAME']."||";
			$RTU_TYPE .= $rs [$i] ['RTU_TYPE']."||";
			$SIGNAL_ID .= $rs [$i] ['SIGNAL_ID']."||";
			$CONNECTION_INFO .= $rs [$i] ['CONNECTION_INFO']."||";
			$RTU_REAL_X .= $rs [$i] ['RTU_REAL_X']."||";
			$RTU_REAL_Y .= $rs [$i] ['RTU_REAL_Y']."||";
			$POINTX .= $rs [$i] ['POINTX']."||";
			$POINTY .= $rs [$i] ['POINTY']."||";
			$RTU_ADDRESS .= $rs [$i] ['RTU_ADDRESS']."||";
			//$rs [$i] ['CNT'];
		}
		
		$SYS_TYPE = "통합방재"; //타입
		$CNT = $cnt; //총수
		//유지관리서버 접속여부 확인
		$serverConn = $this-> getServerConncet();

		if($serverConn == true) {
			//echo "접속가능";
			//장비데이터 전송
			$this-> sendRtuInfo($AREA_CODE,$RTU_NAME,$RTU_TYPE,$SIGNAL_ID,$CONNECTION_INFO,$RTU_REAL_X,$RTU_REAL_Y,$POINTX,$POINTY,$RTU_ADDRESS,$CNT,$SYS_TYPE,$SetupCode);
		}else{
			//echo "접속불가";
		}
		
	}

	function getAgencyCode(){
		$SQL = " SELECT * FROM ORGAN_INFO WHERE ORGAN_ID='1' ORDER BY ORGAN_ID ASC LIMIT 1 ";//
		$rs = $this->DB->execute($SQL);
		
		$AgencyCode = substr($rs [0] ['AREA_CODE'],0,5);
		return $AgencyCode;
		unset($rs);
		$this->DB->parseFree();
	}

	function setDateLog($log_path){
		$fp = fopen($log_path, 'w');
		fwrite($fp, date("Ymd"));
		fclose($fp);
	}

	function getDateLog($log_path){
		$fp		= fopen($log_path,"r");
		$date	= fread($fp,1000);
		fclose($fp);
		return $date;
	}

	//장비정보를 서버로 전송
	function sendRtuInfo($AREA_CODE,$RTU_NAME,$RTU_TYPE,$SIGNAL_ID,$CONNECTION_INFO,$RTU_REAL_X,$RTU_REAL_Y,$POINTX,$POINTY,$RTU_ADDRESS,$CNT,$SYS_TYPE,$SetupCode){
		/*
		echo "<body onload='javascript:document.post_rtu.submit();'>";
		//echo "<form name='post_rtu' action='http://hwajintni.co.kr:9499/_map/insert_add_outer.php' method='post' >";
		echo "<form name='post_rtu' action='http://192.168.1.24:8048/insert_add_outer.php' method='post' >";
		echo "<input type='hidden' name='AREA_CODE' id='AREA_CODE' value='".$AREA_CODE."'>";
		echo "<input type='hidden' name='RTU_NAME' id='RTU_NAME' value='".$RTU_NAME."'>";
		echo "<input type='hidden' name='RTU_TYPE' id='RTU_TYPE' value='".$RTU_TYPE."'>";
		echo "<input type='hidden' name='SIGNAL_ID' id='SIGNAL_ID' value='".$SIGNAL_ID."'>";
		echo "<input type='hidden' name='CONNECTION_INFO' id='CONNECTION_INFO' value='".$CONNECTION_INFO."'>";
		echo "<input type='hidden' name='RTU_REAL_X' ID='RTU_REAL_X' value='".$RTU_REAL_X."'>";
		echo "<input type='hidden' name='RTU_REAL_Y' ID='RTU_REAL_Y' value='".$RTU_REAL_Y."'>";
		echo "<input type='hidden' name='POINTX' ID='POINTX' value='".$POINTX."'>";
		echo "<input type='hidden' name='POINTY' ID='POINTY' value='".$POINTY."'>";
		echo "<input type='hidden' name='RTU_ADDRESS' ID='RTU_ADDRESS' value='".$RTU_ADDRESS."'>";
		echo "<input type='hidden' name='CNT' ID='CNT' value='".$CNT."'>";
		echo "<input type='hidden' name='SYS_TYPE' ID='SYS_TYPE' value='".$SYS_TYPE."'>";
		echo "<input type='hidden' name='LOCAL_CODE' ID='LOCAL_CODE' value='".$SetupCode."'>";
		echo "<input type='hidden' name='SYNC' ID='SYNC' value='1'>";
		exit;
		*/
	}

	// 서버에 접속가능한지 확인하다.
	function getServerConncet(){
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', -1);

		$host = 'hwajintni.co.kr';
		$port = 9499;

		$connection = @fsockopen($host, $port, $errno, $errstr, 2);
		if (is_resource($connection))
		{
			//$ret = "SUCCESS";
			$ret = true;
			fclose($connection);
		}
		else
		{
			$ret = false;
		}
		return $ret;
/*		$ports = array(21, 25, 80, 81, 110, 143, 443, 587, 2525, 3306);

		foreach ($ports as $port)
		{
			$connection = @fsockopen($host, $port, $errno, $errstr, 2);

			if (is_resource($connection))
			{
				echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

				fclose($connection);
			}
			else
			{
				echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
			}
		}
		*/
	}

}//end class

?>