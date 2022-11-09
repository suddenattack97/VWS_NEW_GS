<?php

CLASS DBmanager extends mysqli{

	public $db=array();
	public $query_result;
	public $result=array();
	public $num_rows;
	public $recordcount;

	/************************
	데이타베이스 초기화
	************************/
	function __construct($HOST, $USER, $PASS, $DB) {
		if(strpos($HOST, ":") !== false){
			$arr_h = explode(":", $HOST);
			$this->db['host']=$arr_h[0];
			$this->db['port']=$arr_h[1];
		}else{
			$this->db['host']=$HOST;
		}
		$this->db['user']=$USER;
		$this->db['passwd']=$PASS;
		$this->db['database']=$DB;
		$this->SET_CONNECT();
		$this->SET_SELECT_DB();
	}
	
	/******************
	연결        
	******************/
	public FUNCTION SET_CONNECT(){
		$this->db['conn'] = @mysqli_connect($this->db['host'], $this->db['user'], $this->db['passwd'], $this->db['database'], $this->db['port']);
		if(!$this->db['conn']){die("연결 실패 : ".mysqli_connect_error());}
		else{mysqli_set_charset($this->db['conn'],"utf8");}
	}

	/******************
	테이블 선택
	******************/
	public FUNCTION SET_SELECT_DB(){
		$this->db['slt'] = @mysqli_select_db($this->db['conn'],$this->db['database']) or die(mysqli_error($this->db['conn']));
	}

	/******************
	DB해제
	******************/
	public FUNCTION close(){
		// if(isset($this->$query_result))$this->FREE_RESULT();
		if(isset($this->db['conn']))@mysqli_close($this->db['conn']);
	}

	// XSS 보안
	function html_encode($str){
		// SQL 과 XSS 공격을 모두 막는 함수
		// htmlentities는 문자열에서 모든 HTML을 제거한다. 한글이 깨질수 있다.
		// ENT_QUOTES : 홑따옴표와 겹따옴표 모두 변환
		// htmlspecialchars, htmlentities 두개다 기본 euc-kr을 지원하지 않는다.
		return htmlspecialchars($this->mysql_fix_string($this->db['conn'], $str), ENT_QUOTES, "UTF-8");
	}
	
	function mysql_fix_string($db, $str){
		// global $db;
		// escape variables for security
		// mysqli_real_escape_string() 함수는 SQL 문에서 특수 문자열을 이스케이프한다.
		// $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
		if(get_magic_quotes_gpc()) $str = stripslashes($str);
		return mysqli_real_escape_string($db,$str);
	}
	
	function html_decode($str){
		return htmlspecialchars_decode(stripslashes($str));
	}

	/******************
	정보 
	******************/
	public FUNCTION printDBinfo(){
		echo"<pre>";
		print_r($this->db);
		print_r($this->result);
		echo"</pre>";
	}

	/******************
	메모리 리셑
	******************/
	public FUNCTION parseFree(){
		if ($this->query_result)@mysqli_free_result($this->query_result);
			unset($this->num_rows);
	}

	/******************
	쿼리전송
	******************/
	public FUNCTION QUERY_LiNE($sql) {
		if(isset($sql))$this->query_result=mysqli_query($this->db['conn'],$sql) or die(mysqli_error($this->db['conn']));
		$this->num_rows = mysqli_num_rows($this->query_result);
		$this->recordcount = $this->num_rows;
	}
	
	/******************
	[] limit 리턴
	******************/
	public FUNCTION execute($sql){
		$this->QUERY_LiNE($sql);
		$i=0;
		while($row=@mysqli_fetch_array($this->query_result)){
			$this->result[$i]=$row;
			$i++;
		}
		return $this->result;
	}

	FUNCTION updaterTrace($sql, $result) {	
		$result = $result == 1 ? "true" : $result;
		$btArr = debug_backtrace();
		
		$rootIdx = !strpos($btArr[count($btArr)-1]['file'], "\\divas\\") ? strpos($btArr[count($btArr)-1]['file'], "\\tvbrd\\") : strpos($btArr[count($btArr)-1]['file'], "\\divas\\");
		$rootFile = substr($btArr[count($btArr)-1]['file'], $rootIdx+1);

		$btVal = $rootFile .",".$btArr[count($btArr)-1]['function'];
		$sql2 = " INSERT INTO updater_log (USER_ID, IP, BACKTRACE, UP_SQL, UP_RESULT, LOG_DATE) VALUE 
				( '".ss_user_id."', '".get_client_ip()."', '".addslashes($btVal)."', '".addslashes($sql)."', '".$result."', DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s')) "; 
		$this->query_result=mysqli_query($this->db['conn'],$sql2) or die(mysqli_error($this->db['conn']));
	}

	public FUNCTION QUERYONE($sql) {
		if(isset($sql))$this->query_result=mysqli_query($this->db['conn'],$sql) or die(mysqli_error($this->db['conn']));
		$this->updaterTrace($sql, $this->query_result);
		return $this->query_result;
	}

	/******************
	1 limit 리턴
	******************/
	public FUNCTION FIRST_FETCH_ARRAY($sql) {
		$this->QUERY_LiNE($sql, $this->db['conn']);
		return @mysqli_fetch_array($this->query_result);
	}

	/******************
	연관배열 리턴
	******************/
	public FUNCTION FETCH_ASSOC(){
		$i=0;
		while($row=@mysqli_fetch_assoc($this->query_result)){
			$this->result[$i]=$row;
			$i++;
		}
		return $this->result;
	}

	/******************
	연관배열 리턴
	******************/
	public FUNCTION FETCH_ROW() {
		$i=0;
		while($row=@mysqli_fetch_row($this->query_result)) {
			$this->result[$i]=$row;
			$i++;
		}
		return $this->result;
	}

	/******************
	총수
	******************/
	public FUNCTION NUM_ROW(){
		return $this->num_rows;
	}
}// END DATABASE CLASS
?>