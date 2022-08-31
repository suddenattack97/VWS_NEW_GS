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

	public FUNCTION QUERYONE($sql) {
		return mysqli_query($this->db['conn'],$sql) or die(mysqli_error($this->db['conn']));
	}

	/******************
	1 limit 리턴
	******************/
	public FUNCTION FIRST_FETCH_ARRAY($sql) {
		$this->QUERY_LiNE($sql, $this->db['conn']);
		return @mysqli_fetch_array($this->query_result);
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

	public FUNCTION test(){
		return var_dump($this->db);
		$SQL = " SELECT * FROM ACCESS_INFO ";
		// echo $SQL;
		$rs = $this->execute($SQL);
	}
}// END DATABASE CLASS
?>