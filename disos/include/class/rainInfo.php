<?
Class ClassRainInfo {

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

	/* 10분 강우량 */
	function getRainMValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_M 
				  	 FROM RAIN_HIST 
				  	 WHERE DATA_TYPE = 'M' AND RAIN_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."' 
				  	 AND AREA_CODE = '".$area_code."'
				  	 ORDER BY RAIN_DATE DESC LIMIT 1 ";
			
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_M = $rs[0]['RAIN_M'] == "-" ? "-" : $rs[0]['RAIN_M'];
			}else{
				$this->RAIN_M = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		} 
	}

	/* 시간 강우량 */
	function getRainHValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_H 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'H' AND RAIN_DATE = ".R_NOW_START." 
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_H = $rs[0]['RAIN_H'] == "-" ? "-" : $rs[0]['RAIN_H'];
			}else{
				$this->RAIN_H = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전시간 강우량 */
	function getRainBHValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_BH 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'H' AND RAIN_DATE = ".R_BEF_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_BH = $rs[0]['RAIN_BH'] == "-" ? "-" : $rs[0]['RAIN_BH'];
			}else{
				$this->RAIN_BH = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 금일 강우량 */
	function getRainDValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_D 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'D' AND RAIN_DATE = ".R_DAY_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_D = $rs[0]['RAIN_D'] == "-" ? "-" : $rs[0]['RAIN_D'];
			}else{
				$this->RAIN_D = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전일 강우량 */
	function getRainBDValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_BD 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'D' AND RAIN_DATE = ".R_BDAY_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_BD = $rs[0]['RAIN_BD'] == "-" ? "-" : $rs[0]['RAIN_BD'];
			}else{
				$this->RAIN_BD = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 월간 강우량 */
	function getRainNValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_N 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'N' AND RAIN_DATE = ".R_MONTH_START." 
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_N = $rs[0]['RAIN_N'] == "-" ? "-" : $rs[0]['RAIN_N'];
			}else{
				$this->RAIN_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 년간 강우량 */
	function getRainYValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN_Y 
				 	 FROM RAIN_HIST 
				 	 WHERE DATA_TYPE = 'Y' AND RAIN_DATE = ".R_YEAR_START."
				 	 AND AREA_CODE='".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->RAIN_Y = $rs[0]['RAIN_Y'] == "-" ? "-" : $rs[0]['RAIN_Y'];
			}else{
				$this->RAIN_Y = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 주요지점 강우 평균 */
	function getRainMain(){
		if(DB == "0"){
			$sql = " SELECT a.GROUP_ID, a.GROUP_NAME, IFNULL(AVG(e.RAIN), '-') AS RAIN_AVR
				 	 FROM dn_main_group AS a
				 	 LEFT JOIN dn_main_member AS b ON a.GROUP_ID = b.GROUP_ID
				 	 LEFT JOIN rtu_info AS c ON b.RTU_ID = c.RTU_ID
				 	 LEFT JOIN rtu_sensor AS d ON c.RTU_ID = d.RTU_ID
				 	 LEFT JOIN rain_hist AS e ON c.AREA_CODE = e.AREA_CODE AND e.DATA_TYPE = 'H' AND e.RAIN_DATE = ".R_NOW_START."
				 	 WHERE d.SENSOR_TYPE = 0 
				 	 GROUP BY a.GROUP_ID
				 	 ORDER BY a.GROUP_SORT ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['GROUP_ID'] = $rs[$i]['GROUP_ID'];
				$data[$i]['GROUP_NAME'] = $rs[$i]['GROUP_NAME'];
				$data[$i]['RAIN_AVR'] = $rs[$i]['RAIN_AVR'] == "-" ? "-" : $rs[$i]['RAIN_AVR'];
			}
			$this->rsRainMain = $data;
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 통신 상태 */
	function getRainCallValue($area_code){
		if(DB == "0"){
			$sql = " SELECT CALL_LAST
				 	 FROM RTU_INFO
				 	 WHERE AREA_CODE = '".$area_code."' ";
		
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
	
	/* 강우 10분 자료 */
	/* AND RAIN_DATE IN (".$where_date.") */
	function getRain10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RAIN, '-') AS RAIN, RAIN_DATE
				  	 FROM RAIN_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND RAIN_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY RAIN_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['RAIN'] = $rs[$i]['RAIN'] == "-" ? "-" : $rs[$i]['RAIN'];
				$data[$i]['RAIN_DATE'] = $rs[$i]['RAIN_DATE'];
			}
			$this->rsRain10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 강우 보고서 */
	function getRainRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.RAIN, '-') AS RAIN, a.RAIN_DATE
				  	 FROM ( SELECT RAIN, DATE_FORMAT(RAIN_DATE, '".$format."') AS NUM, RAIN_DATE
							FROM RAIN_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."' 
							AND RAIN_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['RAIN'] = $rs[$i]['RAIN'] == "-" ? "-" : $rs[$i]['RAIN'];
				$data[$i]['RAIN_DATE'] = $rs[$i]['RAIN_DATE'];
			}
			$this->rsRainRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 강우 자료 합계 */
	function getRainSum($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT SUM(RAIN) AS DATA
				 	 FROM RAIN_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND RAIN_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 강우 자료 수정 */
	function setRainData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM RAIN_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
 					 AND RAIN_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE RAIN_HIST SET RAIN = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
						 AND RAIN_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO RAIN_HIST (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN)
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