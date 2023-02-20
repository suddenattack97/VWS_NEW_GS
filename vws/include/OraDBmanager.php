<?php
class OraDBmanager {
	
	private $dbLink;
	private $host;
	private $user;
	private $password;
	public $WHERE_STRING;
	
	public function OraDBmanager($dsn, $user, $password) {
		$this -> dsn = $dsn;
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
		return $this -> dbLink = ocilogon($this -> user, $this -> password, $this -> dsn) or DIE("DATABASE FAILED TO RESPOND.");
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
		return OCIParse($this -> dbLink, $sql);
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
		return OCIParse($this -> dbLink, $sql);
	}
	
	/**
	 * DB Close
	 */
	public function dbClose() {
		# DEBUG
		/*if (PRINT_DEBUG == true) {
		 echo "dbClose()!!<br/>";
		 }*/
		return OCILogoff($this -> dbLink);
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
		return OCILogoff($this -> dbLink);
	}
}
?>