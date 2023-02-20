<?php
class MsDBmanager {
	
	private $dbLink;
	private $host;
	private $user;
	private $password;
	public $WHERE_STRING;
	
	public function MsDBmanager($host, $user, $password) {
		$this -> host = $host;
		$this -> user = $user;
		$this -> password = $password;
		$this -> dbConn();
	}
	
	/**
	 * DB Connect
	 * @return int
	 */
	public function dbConn() {
		# DEBUG
		/*if (PRINT_DEBUG == true) {
		 echo "dbConn()!!<br/>";
		 }*/
		return $this -> dbLink = @odbc_connect($this -> host, $this -> user, $this -> password) or DIE("DATABASE FAILED TO RESPOND.");
	}
	
	/**
	 * Execute Query
	 * @param $sql
	 */
	public function QUERYONE($sql) {
		
		# DEBUG
		/*if (PRINT_DEBUG == true) {
		 echo nl2br($sql)."<br/>";
		 }*/
		
		# utf8 encoding error
		//odbc_do($this -> dbLink, "set names euckr");
		return @odbc_do($this -> dbLink, $sql);
	}
	/**
	 * Execute Query
	 * @param $sql
	 */
	public function utf8QUERYONE($sql) {
		
		# DEBUG
		/*if (PRINT_DEBUG == true) {
		 echo nl2br($sql)."<br/>";
		 }*/
		
		# utf8 encoding
		return odbc_do($this -> dbLink, $sql);
	}
	
	/**
	 * DB Close
	 */
	public function dbClose() {
		# DEBUG
		/*if (PRINT_DEBUG == true) {
		 echo "dbClose()!!<br/>";
		 }*/
		return @odbc_close($this -> dbLink);
	}
	
	/******************
	 총수
	 ******************/
	public function NUM_ROW(){
		return $this->num_rows;
	}
	
	/******************
	 DB해제
	 ******************/
	public function close(){
		return @odbc_close($this -> dbLink);
	}
	
}
?>