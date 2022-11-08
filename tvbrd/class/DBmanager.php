<?php
/***********************************************************
 * 파 일 명 : DBmanager.php  				                       *
 * 작 성 일 : 2010-04-02                                   *
 * 수 정 일 : 2010-04-02                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : DB 검색     							                   *
 ***********************************************************/

CLASS DBmanager{

 public $db=array();
 public $query_result;
 public $result=array();
 public $num_rows;
 public $recordcount;

 /************************
  데이타베이스 초기화
  ************************/
 FUNCTION DBmanager($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE) {

    $this->db[host]=$DB_HOST;
    $this->db[user]=$DB_USER;
    $this->db[passwd]=$DB_PASSWORD;
    $this->db[database]=$DB_DATABASE;
    $this->SET_CONNECT();
    $this->SET_SELECT_DB();
 }

 /******************
       연결
  ******************/
 FUNCTION SET_CONNECT(){
   $this->db[conn] = @mysql_connect($this->db[host], $this->db[user], $this->db[passwd]) or die(mysql_error());
   mysql_query("set names utf8",$this->db[conn]);
 }

 /******************
     테이블 선택
  ******************/
 FUNCTION SET_SELECT_DB(){
  $this->db[slt] = @mysql_select_db($this->db[database], $this->db[conn]) or die(mysql_error());
 }

 /******************
        DB해제
  ******************/
 FUNCTION close(){
                if(isset($this->$query_result))$this->FREE_RESULT();
                if(isset($this->db[conn]))@mysql_close($this->db[conn]);
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
 FUNCTION printDBinfo(){
  echo"<pre>";
  print_r($this->db);
  print_r($this->result);
  echo"</pre>";
 }

 /******************
     메모리 리셑
  ******************/
 FUNCTION parseFree(){
   if ($this->query_result)@mysql_free_result($this->query_result);
   unset($this->num_rows);
 }

/******************
      쿼리전송
******************/
 FUNCTION QUERY($sql="") {
                if(isset($sql))$this->query_result=mysql_query($sql,$this->db[conn]) or die(mysql_error());
                 $this->num_rows = mysql_num_rows($this->query_result);
                 $this->recordcount = $this->num_rows;
 }

  FUNCTION QUERYONE($sql="") {
    			return mysql_query($sql,$this->db[conn]);
 }

 /******************
      1 limit 리턴
  ******************/
 FUNCTION FIRST_FETCH_ARRAY($sql="") {
                $this->QUERY($sql);
                return @mysql_fetch_array($this->query_result);
 }

 /******************
   [] limit 리턴
  ******************/
 FUNCTION execute($sql=""){
 								$this->QUERY($sql);
                $i=0;
                while($row=@mysql_fetch_array($this->query_result)){
                        $this->result[$i]=$row;
                        $i++;
                }
                return $this->result;
 }
 
 /******************
  [] limit 리턴 메모리 리셑
  ******************/
 FUNCTION rs_unset(){
			 	unset($this->result);
			 	return $this->result;
 }

 /******************
    연관배열 리턴
  ******************/
  FUNCTION FETCH_ASSOC($sql=""){
    $this->QUERY($sql);
    $i=0;
    while($row=@mysql_fetch_assoc($this->query_result)){
      $this->result[$i]=$row;
      $i++;
    }
    return $this->result;
  }

 /******************
    연관배열 리턴
  ******************/
 FUNCTION FETCH_ROW() {
                $i=0;
                while($row=@mysql_fetch_row($this->query_result)) {
                        $this->result[$i]=$row;
                        $i++;
                }
                return $this->result;
 }

 /******************
         총수
  ******************/
 FUNCTION NUM_ROW(){
 	//$rows=@mysql_num_rows($this->query_result) or die(mysql_error());
  return $this->num_rows;
 }
}// END DATABASE CLASS
?>
