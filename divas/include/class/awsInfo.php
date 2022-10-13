<?
Class ClassAwsInfo {

	private $DB;

	function ClassAwsInfo($DB){
		$this->DB = $DB;

		if(date("i") >= 50) $min = "50";
		else if(date("i") >= 40) $min = "40";
		else if(date("i") >= 30) $min = "30";
		else if(date("i") >= 20) $min = "20";
		else if(date("i") >= 10) $min = "10";
		else $min = "00";
		$this->nowDate = date("Y-m-d H:").$min.":00";
	}

	/* 현재 온도  */
	function getTempNValue($localcode){
		
		$sql .= " SELECT IFNULL(AVR_VAL, '-') AS TEMP_N 
				  FROM TEMP_HIST 
				  WHERE DATA_TYPE = 'M' AND TEMP_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."' 
				  AND AREA_CODE = '".$localcode."'
				  ORDER BY TEMP_DATE DESC LIMIT 1 ";

		if(DB == "0"){
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->TEMP_N = $rs[0]['TEMP_N'] == "-" ? "-" : $rs[0]['TEMP_N'];
			}else{
				$this->TEMP_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 최고최저 온도 */
	function getTempValue($localcode){
		$sql = " SELECT IFNULL(MAX_VAL, '-') AS TEMP_MAX, IFNULL(MIN_VAL, '-') AS TEMP_MIN 
				 FROM TEMP_HIST 
				 WHERE DATA_TYPE = 'D' AND TEMP_DATE = ".R_DAY_START." 
				 AND AREA_CODE = '".$localcode."' ";

		if(DB == "0"){
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->TEMP_MAX = $rs[0]['TEMP_MAX'] == "-" ? "-" : $rs[0]['TEMP_MAX'];
				$this->TEMP_MIN = $rs[0]['TEMP_MIN'] == "-" ? "-" : $rs[0]['TEMP_MIN'];
			}else{
				$this->TEMP_MAX = '-';
				$this->TEMP_MIN = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 현재 풍향풍속 */
	function getWindNValue($localcode){
		$sql .= " SELECT IFNULL(AVR_VEL1, '-') AS WIND_VEL, IFNULL(AVR_DEG1, '-') AS WIND_DEG 
				  FROM WIND_HIST 
				  WHERE DATA_TYPE = 'M' AND WIND_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."' 
				  AND AREA_CODE = '".$localcode."'
				  ORDER BY WIND_DATE DESC LIMIT 1 ";

		if(DB == "0"){
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->WIND_VEL = $rs[0]['WIND_VEL'] == "-" ? "-" : $rs[0]['WIND_VEL'];

				if($rs[0]['WIND_DEG'] == "" || $rs[0]['WIND_DEG'] == 0 || $rs[0]['WIND_DEG'] == '-' ||
					$rs[0]['WIND_VEL'] == "" || $rs[0]['WIND_VEL'] == 0 || $rs[0]['WIND_VEL'] == '-'){
					$this->WIND_DEG = '-';
				}else{
					$this->WIND_DEG = $this->getDegreeString($rs[0]['WIND_DEG']);
				}
			}else{
				$this->WIND_VEL = '-';
				$this->WIND_DEG = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 최대 풍향풍속 */
	function getWindMaxValue($localcode){
		$sql = " SELECT IFNULL(MAX_VEL, '-') AS WIND_MAX_VEL, IFNULL(MAX_DEG, '-') AS WIND_MAX_DEG 
				 FROM WIND_HIST WHERE DATA_TYPE = 'D' AND WIND_DATE = ".R_DAY_START." 
				 AND AREA_CODE = '".$localcode."' ";

		if(DB == "0"){
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->WIND_MAX_VEL = $rs[0]['WIND_MAX_VEL'] == "-" ? "-" : $rs[0]['WIND_MAX_VEL'];

				if($rs[0]['WIND_MAX_DEG'] == "" || $rs[0]['WIND_MAX_DEG'] == 0 || $rs[0]['WIND_MAX_DEG'] == '-' ||
					$rs[0]['WIND_MAX_VEL'] == "" || $rs[0]['WIND_MAX_VEL'] == 0 || $rs[0]['WIND_MAX_VEL'] == '-'){
					$this->WIND_MAX_DEG = '-';
				}else{
					$this->WIND_MAX_DEG = $this->getDegreeString($rs[0]['WIND_MAX_DEG']);
				}
			}else{
				$this->WIND_MAX_VEL = '-';
				$this->WIND_MAX_DEG = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 현재 습도  */
	function getHumiNValue($localcode){
		$sql = " SELECT IFNULL(AVR_VAL, '-') AS HUMI_N
				  FROM HUMI_HIST
				  WHERE DATA_TYPE = 'M' AND HUMI_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."'
				  AND AREA_CODE = '".$localcode."'
				  ORDER BY HUMI_DATE DESC LIMIT 1 ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->HUMI_N = $rs[0]['HUMI_N'] == "-" ? "-" : $rs[0]['HUMI_N'];
			}else{
				$this->HUMI_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 최고최저 습도 */
	function getHumiValue($localcode){
		$sql = " SELECT IFNULL(MAX_VAL, '-') AS HUMI_MAX, IFNULL(MIN_VAL, '-') AS HUMI_MIN
				 FROM HUMI_HIST
				 WHERE DATA_TYPE = 'D' AND HUMI_DATE = ".R_DAY_START."
				 AND AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->HUMI_MAX = $rs[0]['HUMI_MAX'] == "-" ? "-" : $rs[0]['HUMI_MAX'];
				$this->HUMI_MIN = $rs[0]['HUMI_MIN'] == "-" ? "-" : $rs[0]['HUMI_MIN'];
			}else{
				$this->HUMI_MAX = '-';
				$this->HUMI_MIN = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 현재 기압  */
	function getAtmoNValue($localcode){
		$sql = " SELECT IFNULL(AVR_VAL, '-') AS ATMO_N
				  FROM ATMO_HIST
				  WHERE DATA_TYPE = 'M' AND ATMO_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."'
				  AND AREA_CODE = '".$localcode."'
				  ORDER BY ATMO_DATE DESC LIMIT 1 ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->HUMI_N = $rs[0]['ATMO_N'] == "-" ? "-" : $rs[0]['ATMO_N'];
			}else{
				$this->HUMI_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 최고최저 기압 */
	function getAtmoValue($localcode){
		$sql = " SELECT IFNULL(MAX_VAL, '-') AS ATMO_MAX, IFNULL(MIN_VAL, '-') AS ATMO_MIN
				 FROM ATMO_HIST
				 WHERE DATA_TYPE = 'D' AND ATMO_DATE = ".R_DAY_START."
				 AND AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->ATMO_MAX = $rs[0]['ATMO_MAX'] == "-" ? "-" : $rs[0]['ATMO_MAX'];
				$this->ATMO_MIN = $rs[0]['ATMO_MIN'] == "-" ? "-" : $rs[0]['ATMO_MIN'];
			}else{
				$this->ATMO_MAX = '-';
				$this->ATMO_MIN = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}


		/* 현재 일사  */
		function getRadiNValue($localcode){
			$sql = " SELECT IFNULL(AVR_VAL, '-') AS RADI_N
					  FROM RADI_HIST
					  WHERE DATA_TYPE = 'M' AND RADI_DATE BETWEEN ".R_BBBEF_START." AND '".$this->nowDate."'
					  AND AREA_CODE = '".$localcode."'
					  ORDER BY RADI_DATE DESC LIMIT 1 ";
			
			if(DB == "0"){
				$rs = $this->DB->execute($sql);
				
				if($this->DB->num_rows){
					$this->HUMI_N = $rs[0]['RADI_N'] == "-" ? "-" : $rs[0]['RADI_N'];
				}else{
					$this->HUMI_N = '-';
				}
				
				unset($rs);
				$this->DB->parseFree();
			}else if(DB == "1"){
				// ORACLE
			}
		}
		
		/* 최고최저 일사 */
		function getRadiValue($localcode){
			$sql = " SELECT IFNULL(MAX_VAL, '-') AS RADI_MAX, IFNULL(MIN_VAL, '-') AS RADI_MIN
					 FROM RADI_HIST
					 WHERE DATA_TYPE = 'D' AND RADI_DATE = ".R_DAY_START."
					 AND AREA_CODE = '".$localcode."' ";
			
			if(DB == "0"){
				$rs = $this->DB->execute($sql);
				
				if($this->DB->num_rows){
					$this->RADI_MAX = $rs[0]['RADI_MAX'] == "-" ? "-" : $rs[0]['RADI_MAX'];
					$this->RADI_MIN = $rs[0]['RADI_MIN'] == "-" ? "-" : $rs[0]['RADI_MIN'];
				}else{
					$this->RADI_MAX = '-';
					$this->RADI_MIN = '-';
				}
				
				unset($rs);
				$this->DB->parseFree();
			}else if(DB == "1"){
				// ORACLE
			}
		}
	
	/* 주요지점 aws 평균 */
	function getAwsMain(){
		if(DB == "0"){
			$sql = " SELECT a.GROUP_ID, a.GROUP_NAME, IFNULL(AVG(e.RAIN), '-') AS RAIN_AVR, 
							IFNULL(AVG(f.AVR_VAL), '-') AS TEMP_AVR, IFNULL(AVG(g.AVR_DEG1), '-') AS DEG_AVR, 
							IFNULL(AVG(g.AVR_VEL1), '-') AS VEL_AVR, IFNULL(AVG(h.AVR_VAL), '-') AS HUMI_AVR
				 	 FROM dn_main_group AS a
				 	 LEFT JOIN dn_main_member AS b ON a.GROUP_ID = b.GROUP_ID
				 	 LEFT JOIN rtu_info AS c ON b.RTU_ID = c.RTU_ID
				 	 LEFT JOIN rain_hist AS e ON c.AREA_CODE = e.AREA_CODE AND e.DATA_TYPE = 'H' AND e.RAIN_DATE = ".R_BBBEF_START."
				 	 LEFT JOIN temp_hist AS f ON c.AREA_CODE = f.AREA_CODE AND f.DATA_TYPE = 'H' AND f.TEMP_DATE = ".R_BBBEF_START."
				 	 LEFT JOIN wind_hist AS g ON c.AREA_CODE = g.AREA_CODE AND g.DATA_TYPE = 'H' AND g.WIND_DATE = ".R_BBBEF_START."
				 	 LEFT JOIN humi_hist AS h ON c.AREA_CODE = h.AREA_CODE AND h.DATA_TYPE = 'H' AND h.HUMI_DATE = ".R_BBBEF_START."
				 	 WHERE c.RTU_TYPE = 'A00'
				 	 GROUP BY a.GROUP_ID
				 	 ORDER BY a.GROUP_SORT ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['GROUP_ID'] = $rs[$i]['GROUP_ID'];
				$data[$i]['GROUP_NAME'] = $rs[$i]['GROUP_NAME'];
				$data[$i]['RAIN_AVR'] = $rs[$i]['RAIN_AVR'] == "-" ? "-" : $rs[$i]['RAIN_AVR'];
				$data[$i]['TEMP_AVR'] = $rs[$i]['TEMP_AVR'] == "-" ? "-" : $rs[$i]['TEMP_AVR'];
				$data[$i]['DEG_AVR'] = $rs[$i]['DEG_AVR'] == "-" ? "-" : $this->getDegreeString($rs[0]['DEG_AVR']);
				$data[$i]['VEL_AVR'] = $rs[$i]['VEL_AVR'] == "-" ? "-" : $rs[$i]['VEL_AVR'];
				$data[$i]['HUMI_AVR'] = $rs[$i]['HUMI_AVR'] == "-" ? "-" : $rs[$i]['HUMI_AVR'];
			}
			$this->rsAwsMain = $data;
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 통신 상태 */
	function getAwsCallValue($localcode){
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
	
	/* 온도 보고서 */
	function getTempRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.AVR_VAL, '-') AS TEMP, 
							IFNULL(a.MAX_VAL, '-') AS TEMP_MAX, IFNULL(a.MIN_VAL, '-') AS TEMP_MIN
				  	 FROM ( SELECT AVR_VAL, MAX_VAL, MIN_VAL, DATE_FORMAT(TEMP_DATE, '".$format."') AS NUM
							FROM TEMP_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND TEMP_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['TEMP'] = $rs[$i]['TEMP'] == "-" ? "-" : $rs[$i]['TEMP'];
				$data[$i]['TEMP_MAX'] = $rs[$i]['TEMP_MAX'] == "-" ? "-" : $rs[$i]['TEMP_MAX'];
				$data[$i]['TEMP_MIN'] = $rs[$i]['TEMP_MIN'] == "-" ? "-" : $rs[$i]['TEMP_MIN'];
			}
			$this->rsTempRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도 자료 평균 */
	function getTempAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(AVR_VAL) AS DATA
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도 자료 수정 */
	function setTempData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE TEMP_HIST SET AVR_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND TEMP_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO TEMP_HIST (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도(최고) 자료 */
	function getTempMaxAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "temp_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MAX_VAL';
			}else $col = 'MAX_VAL';

			$sql = " SELECT MAX(".$col.") AS DATA
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도(최고) 자료 수정 */
	function setTempMaxData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE TEMP_HIST SET MAX_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND TEMP_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO TEMP_HIST (AREA_CODE, DATA_TYPE, TEMP_DATE, MAX_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도(최저) 자료 */
	function getTempMinAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "temp_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MIN_VAL';
			}else $col = 'MIN_VAL';

			$sql = " SELECT MIN(".$col.") AS DATA
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도(최저) 자료 수정 */
	function setTempMinData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM TEMP_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND TEMP_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE TEMP_HIST SET MIN_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND TEMP_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO TEMP_HIST (AREA_CODE, DATA_TYPE, TEMP_DATE, MIN_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍향풍속 보고서 */
	function getWindRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.AVR_VEL1, '-') AS VEL, IFNULL(a.MAX_VEL, '-') AS VEL_MAX, 
							IFNULL(a.AVR_DEG1, '-') AS DEG, IFNULL(a.MAX_DEG, '-') AS DEG_MAX
				  	 FROM ( SELECT AVR_VEL1, MAX_VEL, AVR_DEG1, MAX_DEG, DATE_FORMAT(WIND_DATE, '".$format."') AS NUM
							FROM WIND_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND WIND_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['VEL'] = $rs[$i]['VEL'] == "-" ? "-" : $rs[$i]['VEL'];
				$data[$i]['VEL_MAX'] = $rs[$i]['VEL_MAX'] == "-" ? "-" : $rs[$i]['VEL_MAX'];
				$data[$i]['DEG'] = $rs[$i]['DEG'] == "-" ? "-" : $this->getDegreeString($rs[$i]['DEG']);
				$data[$i]['DEG_MAX'] = $rs[$i]['DEG_MAX'] == "-" ? "-" : $this->getDegreeString($rs[$i]['DEG_MAX']);
				$data[$i]['DEG_OR'] = $rs[$i]['DEG'] == "-" ? "-" : $rs[$i]['DEG'];
				$data[$i]['DEG_MAX_OR'] = $rs[$i]['DEG_MAX'] == "-" ? "-" : $rs[$i]['DEG_MAX'];
			}
			$this->rsWindRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍속 자료 평균 */
	function getVelAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(AVR_VEL1) AS DATA
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍속 자료 수정 */
	function setVelData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE WIND_HIST SET AVR_VEL1 = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND WIND_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO WIND_HIST (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍속(최고) 자료 평균 */
	function getVelMaxAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "vel_save"){
				if($type == "M") $col = 'AVR_VEL1';
				else $col = 'MAX_VEL';
			}else $col = 'MAX_VEL';

			$sql = " SELECT MAX(".$col.") AS DATA
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍속(최고) 자료 수정 */
	function setVelMaxData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE WIND_HIST SET MAX_VEL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND WIND_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO WIND_HIST (AREA_CODE, DATA_TYPE, WIND_DATE, MAX_VEL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍향 자료 평균 */
	function getDegAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(AVR_DEG1) AS DATA
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍향 자료 수정 */
	function setDegData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE WIND_HIST SET AVR_DEG1 = ".$data.", MAX_DEG = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND WIND_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO WIND_HIST (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_DEG1, MAX_DEG)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.", ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍향(최고) 자료 평균 */
	function getDegMaxAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(MAX_DEG) AS DATA
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 풍향(최고) 자료 수정 */
	function setDegMaxData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM WIND_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND WIND_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE WIND_HIST SET MAX_DEG = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND WIND_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO WIND_HIST (AREA_CODE, DATA_TYPE, WIND_DATE, MAX_DEG)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압 보고서 */
	function getAtmoRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.AVR_VAL, '-') AS ATMO,
							IFNULL(a.MAX_VAL, '-') AS ATMO_MAX, IFNULL(a.MIN_VAL, '-') AS ATMO_MIN
				  	 FROM ( SELECT AVR_VAL, MAX_VAL, MIN_VAL, DATE_FORMAT(ATMO_DATE, '".$format."') AS NUM
							FROM ATMO_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND ATMO_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['ATMO'] = $rs[$i]['ATMO'] == "-" || $rs[$i]['ATMO'] >= 5000000 ? "-" : $rs[$i]['ATMO'];
				$data[$i]['ATMO_MAX'] = $rs[$i]['ATMO_MAX'] == "-" || $rs[$i]['ATMO_MAX'] >= 5000000 ? "-" : $rs[$i]['ATMO_MAX'];
				$data[$i]['ATMO_MIN'] = $rs[$i]['ATMO_MIN'] == "-" || $rs[$i]['ATMO_MIN'] >= 5000000 ? "-" : $rs[$i]['ATMO_MIN'];
			}
			$this->rsAtmoRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압 자료 평균 */
	function getAtmoAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(AVR_VAL) AS DATA
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압 자료 수정 */
	function setAtmoData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE ATMO_HIST SET AVR_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND ATMO_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO ATMO_HIST (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압(최고) 자료 평균 */
	function getAtmoMaxAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "atmo_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MAX_VAL';
			}else $col = 'MAX_VAL';

			$sql = " SELECT MAX(".$col.") AS DATA
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압(최고) 자료 수정 */
	function setAtmoMaxData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE ATMO_HIST SET MAX_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND ATMO_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO ATMO_HIST (AREA_CODE, DATA_TYPE, ATMO_DATE, MAX_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압(최저) 자료 평균 */
	function getAtmoMinAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "atmo_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MIN_VAL';
			}else $col = 'MIN_VAL';

			$sql = " SELECT MIN(".$col.") AS DATA
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 기압(최저) 자료 수정 */
	function setAtmoMinData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM ATMO_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND ATMO_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE ATMO_HIST SET MIN_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND ATMO_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO ATMO_HIST (AREA_CODE, DATA_TYPE, ATMO_DATE, MIN_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도 보고서 */
	function getHumiRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.AVR_VAL, '-') AS HUMI,
							IFNULL(a.MAX_VAL, '-') AS HUMI_MAX, IFNULL(a.MIN_VAL, '-') AS HUMI_MIN
				  	 FROM ( SELECT AVR_VAL, MAX_VAL, MIN_VAL, DATE_FORMAT(HUMI_DATE, '".$format."') AS NUM
							FROM HUMI_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND HUMI_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['HUMI'] = $rs[$i]['HUMI'] == "-" ? "-" : $rs[$i]['HUMI'];
				$data[$i]['HUMI_MAX'] = $rs[$i]['HUMI_MAX'] == "-" ? "-" : $rs[$i]['HUMI_MAX'];
				$data[$i]['HUMI_MIN'] = $rs[$i]['HUMI_MIN'] == "-" ? "-" : $rs[$i]['HUMI_MIN'];
			}
			$this->rsHumiRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도 자료 평균 */
	function getHumiAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(AVR_VAL) AS DATA
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도 자료 수정 */
	function setHumiData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE HUMI_HIST SET AVR_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND HUMI_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO HUMI_HIST (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도(최고) 자료 */
	function getHumiMaxAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "humi_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MAX_VAL';
			}else $col = 'MAX_VAL';

			$sql = " SELECT MAX(".$col.") AS DATA
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도(최고) 자료 수정 */
	function setHumiMaxData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE HUMI_HIST SET MAX_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND HUMI_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO HUMI_HIST (AREA_CODE, DATA_TYPE, HUMI_DATE, MAX_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도(최저) 자료 */
	function getHumiMinAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			if($_REQUEST['mode'] == "humi_save"){
				if($type == "M") $col = 'AVR_VAL';
				else $col = 'MIN_VAL';
			}else $col = 'MIN_VAL';

			$sql = " SELECT MIN(".$col.") AS DATA
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 습도(최저) 자료 수정 */
	function setHumiMinData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM HUMI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND HUMI_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE HUMI_HIST SET MIN_VAL = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND HUMI_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO HUMI_HIST (AREA_CODE, DATA_TYPE, HUMI_DATE, MIN_VAL)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일사 보고서 */
	function getRadiRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.RADIATION, '-') AS RADI
				  	 FROM ( SELECT RADIATION, DATE_FORMAT(RADI_DATE, '".$format."') AS NUM
							FROM RADI_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND RADI_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['RADI'] = $rs[$i]['RADI'] == "-" ? "-" : $rs[$i]['RADI'];
			}
			$this->rsRadiRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일사 자료 평균 */
	function getRadiAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(RADIATION) AS DATA
				 	 FROM RADI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND RADI_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일사 자료 수정 */
	function setRadiData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM RADI_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND RADI_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE RADI_HIST SET RADIATION = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND RADI_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO RADI_HIST (AREA_CODE, DATA_TYPE, RADI_DATE, RADIATION)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일조 보고서 */
	function getSunsRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.SUNSHINE, '-') AS SUNS
				  	 FROM ( SELECT SUNSHINE, DATE_FORMAT(SUNS_DATE, '".$format."') AS NUM
							FROM SUNS_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND SUNS_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['SUNS'] = $rs[$i]['SUNS'] == "-" ? "-" : $rs[$i]['SUNS'];
			}
			$this->rsSunsRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일조 자료 평균 */
	function getSunsAvg($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT AVG(SUNSHINE) AS DATA
				 	 FROM SUNS_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND SUNS_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 일조 자료 수정 */
	function setSunsData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM SUNS_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND SUNS_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE SUNS_HIST SET SUNSHINE = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND SUNS_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO SUNS_HIST (AREA_CODE, DATA_TYPE, SUNS_DATE, SUNSHINE)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 온도 10분 자료 */
	function getTemp10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(AVR_VAL, '-') AS TEMP, MIN_VAL AS TEMP_MIN, MAX_VAL AS TEMP_MAX, TEMP_DATE
				  	 FROM TEMP_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND TEMP_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY TEMP_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['TEMP'] = $rs[$i]['TEMP'] == "-" ? "-" : $rs[$i]['TEMP'];
				$data[$i]['TEMP_DATE'] = $rs[$i]['TEMP_DATE'];
				$data[$i]['TEMP_MIN'] = $rs[$i]['TEMP_MIN'] == "-" ? "-" : $rs[$i]['TEMP_MIN'];
				$data[$i]['TEMP_MAX'] = $rs[$i]['TEMP_MAX'] == "-" ? "-" : $rs[$i]['TEMP_MAX'];
			}
			$this->rsTemp10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 풍속, 풍향 10분 자료 */
	function getWind10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(AVR_VEL1, '-') AS VEL, IFNULL(MAX_VEL, '-') AS VEL_MAX, 
					IFNULL(AVR_DEG1, '-') AS DEG, IFNULL(MAX_DEG, '-') AS DEG_MAX, WIND_DATE
				  	 FROM WIND_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND WIND_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY WIND_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['VEL'] = $rs[$i]['VEL'] == "-" ? "-" : $rs[$i]['VEL'];
				$data[$i]['VEL_MAX'] = $rs[$i]['VEL_MAX'] == "-" ? "-" : $rs[$i]['VEL_MAX'];
				$data[$i]['DEG'] = $rs[$i]['DEG'] == "-" ? "-" : $this->getDegreeString($rs[$i]['DEG']);
				$data[$i]['DEG_MAX'] = $rs[$i]['DEG_MAX'] == "-" ? "-" : $this->getDegreeString($rs[$i]['DEG_MAX']);
				$data[$i]['WIND_DATE'] = $rs[$i]['WIND_DATE'];
			}
			$this->rsWind10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 기압 10분 자료 */
	function getAtmo10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(AVR_VAL, '-') AS ATMO, MIN_VAL AS ATMO_MIN, MAX_VAL AS ATMO_MAX, ATMO_DATE
				  	 FROM ATMO_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND ATMO_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY ATMO_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['ATMO'] = $rs[$i]['ATMO'] == "-" ? "-" : $rs[$i]['ATMO'];
				$data[$i]['ATMO_DATE'] = $rs[$i]['ATMO_DATE'];
				$data[$i]['ATMO_MIN'] = $rs[$i]['ATMO_MIN'] == "-" ? "-" : $rs[$i]['ATMO_MIN'];
				$data[$i]['ATMO_MAX'] = $rs[$i]['ATMO_MAX'] == "-" ? "-" : $rs[$i]['ATMO_MAX'];
			}
			$this->rsAtmo10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 습도 10분 자료 */
	function getHumi10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(AVR_VAL, '-') AS HUMI, MIN_VAL AS HUMI_MIN, MAX_VAL AS HUMI_MAX, HUMI_DATE
				  	 FROM HUMI_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND HUMI_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY HUMI_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['HUMI'] = $rs[$i]['HUMI'] == "-" ? "-" : $rs[$i]['HUMI'];
				$data[$i]['HUMI_DATE'] = $rs[$i]['HUMI_DATE'];
				$data[$i]['HUMI_MIN'] = $rs[$i]['HUMI_MIN'] == "-" ? "-" : $rs[$i]['HUMI_MIN'];
				$data[$i]['HUMI_MAX'] = $rs[$i]['HUMI_MAX'] == "-" ? "-" : $rs[$i]['HUMI_MAX'];
			}
			$this->rsHumi10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 일사 10분 자료 */
	function getRadi10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(RADIATION, '-') AS RADI, RADI_DATE
				  	 FROM RADI_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND RADI_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY RADI_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['RADI'] = $rs[$i]['RADI'] == "-" ? "-" : $rs[$i]['RADI'];
				$data[$i]['RADI_DATE'] = $rs[$i]['RADI_DATE'];
			}
			$this->rsRadi10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 일조 10분 자료 */
	function getSuns10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(SUNSHINE, '-') AS SUNS, SUNS_DATE
				  	 FROM SUNS_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND SUNS_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY SUNS_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['SUNS'] = $rs[$i]['SUNS'] == "-" ? "-" : $rs[$i]['SUNS'];
				$data[$i]['SUNS_DATE'] = $rs[$i]['SUNS_DATE'];
			}
			$this->rsSuns10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	function getDegreeString($degree){
		$degree = (string)$degree;
		if($degree == '-'){
			$dispDeg = '-';
		}else{
			$tmp_degree	= (int)((($degree/100)+3)/22.5);
			$num = (int)(fmod($tmp_degree,16));
			switch($num){
				case 0	:	$dispDeg = "북";			break;
				case 1	:	$dispDeg = "북북동";		break;
				case 2	:	$dispDeg = "북동";		break;
				case 3	:	$dispDeg = "동북동";		break;
				case 4	:	$dispDeg = "동";			break;
				case 5	:	$dispDeg = "동남동";		break;
				case 6	:	$dispDeg = "남동";		break;
				case 7	:	$dispDeg = "남남동";		break;
				case 8	:	$dispDeg = "남";			break;
				case 9	:	$dispDeg = "남남서";		break;
				case 10	:	$dispDeg = "남서";		break;
				case 11	:	$dispDeg = "서남서";		break;
				case 12	:	$dispDeg = "서";			break;
				case 13	:	$dispDeg = "서북서";		break;
				case 14	:	$dispDeg = "북서";		break;
				case 15	:	$dispDeg = "북북서";		break;
				default:	$dispDeg = "-";			break;
			}
		}
		return $dispDeg;
	}
	
	function getNumDegree($num){
		$degree = ($num * 22.5) * 100;
		return $degree;
	}
	
}//End Class
?>