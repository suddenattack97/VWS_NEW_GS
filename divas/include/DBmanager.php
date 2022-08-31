<?php

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
	연관배열 리턴
	******************/
	FUNCTION FETCH_ASSOC(){
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
		return $this->num_rows;
	}
}// END DATABASE CLASS
?>