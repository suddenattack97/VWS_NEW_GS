<?
Class ClassFlowinfo {

	private $DB;

	function __construct($DB){
		$this->DB = $DB;
		
		if(date("i") >= 50) $min = "50";
		else if(date("i") >= 40) $min = "40";
		else if(date("i") >= 30) $min = "30";
		else if(date("i") >= 20) $min = "20";
		else if(date("i") >= 10) $min = "10";
		else $min = "00";
		$this->nowDate = date("Y-m-d H:").$min.":00";
	}
	
	/* 전시간 수위 */
	function getFlowBNValue($localcode){
		$sql = " SELECT IFNULL(FLOW_AVR, '-') AS FLOW_BN 
				 FROM FLOW_HIST 
				 WHERE DATA_TYPE = 'M' AND FLOW_DATE BETWEEN ".R_BBBEF_START." AND ".R_BEF_END." 
				 AND AREA_CODE = '".$localcode."' 
				 ORDER BY FLOW_DATE DESC ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->FLOW_BN = $rs[0]['FLOW_BN'] == "-" ? "-" : $rs[0]['FLOW_BN'];
			}else{
				$this->FLOW_BN = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 현재 수위 */
	function getFlowNValue($localcode){
		$sql .= " SELECT IFNULL(FLOW_AVR, '-') AS FLOW_N 
				  FROM FLOW_HIST 
				  WHERE DATA_TYPE = 'M' AND FLOW_DATE BETWEEN ".R_BEF_START." AND '".$this->nowDate."' 
				  AND AREA_CODE = '".$localcode."'
				  ORDER BY FLOW_DATE DESC LIMIT 1 ";

		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->FLOW_N = $rs[0]['FLOW_N'] == "-" ? "-" : $rs[0]['FLOW_N'];
			}else{
				$this->FLOW_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 통신 상태 */
	function getFlowCallValue($localcode){
		$sql = " SELECT CALL_LAST
				 FROM RTU_INFO
				 WHERE AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				if($rs[0]['CALL_LAST']){
					if( ( ( strtotime(date('Y-m-d H:i:s')) - strtotime($rs[0]['CALL_LAST']) ) / 60 ) < 120 ){
						$this->CALL_LAST = '<img src="../images/icon_ok.png" alt="O"/>';
					}else{
						$this->CALL_LAST = '<img src="../images/icon_no.png" alt="X"/>';
					}
				}else{
					$this->CALL_LAST = '<img src="../images/icon_no.png" alt="X"/>';
				}
			}else{
				$this->CALL_LAST = '<img src="../images/icon_no.png" alt="X"/>';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 수위 10분 자료 */
	/* AND FLOW_DATE IN (".$where_date.") */
	function getFlow10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(FLOW_AVR, '-') AS FLOW, FLOW_DATE
				  	 FROM FLOW_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND FLOW_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY FLOW_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['FLOW'] = $rs[$i]['FLOW'] == "-" ? "-" : $rs[$i]['FLOW'];
				$data[$i]['FLOW_DATE'] = $rs[$i]['FLOW_DATE'];
			}
			$this->rsFlow10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 수위 보고서 */
	function getFlowRpt($area_code, $type, $where_date, $ecnt){
		if(DB == "0"){
			if($type == "M"){
				$format = "%i";
			}else if($type == "H"){
				$format = "%k";
			}else if($type == "D"){
				$format = "%e";
			}else if($type == "N"){
				$format = "%c";
			}
			
			$sql = " SELECT b.NUM, IFNULL(a.FLOW_AVR, '-') AS FLOW, a.FLOW_DATE
				  	 FROM ( SELECT FLOW_AVR, DATE_FORMAT(FLOW_DATE, '".$format."') AS NUM, FLOW_DATE
							FROM FLOW_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND FLOW_DATE IN (".$where_date.") ) AS a
					 RIGHT JOIN ( SELECT NUM
								  FROM STATISTICS_TMP
								  WHERE TYPE = '".$type."' ";
			if($ecnt != ""){
				$sql.= "		  AND NUM <= ".$ecnt." ";
			}	  
			$sql.= " 			) AS b ON a.NUM = b.NUM 
					 ORDER BY b.NUM ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['NUM'] = $rs[$i]['NUM'];
				$data[$i]['FLOW'] = $rs[$i]['FLOW'] == "-" ? "-" : $rs[$i]['FLOW'];
				$data[$i]['FLOW_DATE'] = $rs[$i]['FLOW_DATE'];
			}
			$this->rsFlowRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 수위 자료 평균 */
	function getFlowAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(FLOW_AVR) AS DATA
				 	 FROM FLOW_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND FLOW_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 수위 자료 수정 */
	function setFlowData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM FLOW_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND FLOW_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE FLOW_HIST SET FLOW_AVR = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND FLOW_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO FLOW_HIST (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
}//End Class
?>