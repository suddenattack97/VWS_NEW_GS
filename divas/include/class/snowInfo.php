<?
Class ClassSnowInfo {

	private $DB;

	function ClassSnowInfo($DB){
		$this->DB = $DB;
	}

	/* 전전일 적설 */
	function getSnowBBHValue($localcode){
		$sql = " SELECT IFNULL(MAX(SNOW), '-') AS SNOW_BBM 
				 FROM SNOW_HIST 
				 WHERE SNOW_DATE BETWEEN ".R_BBDAY_START." AND ".R_BBDAY_END." 
				 AND AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->SNOW_BBM = $rs[0]['SNOW_BBM'] == "-" ? "-" : $rs[0]['SNOW_BBM'];
			}else{
				$this->SNOW_BBM = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전일 마지막 측정 적설 */
	function getSnowBHValue($localcode){
		$sql = " SELECT IFNULL(SNOW, '-') AS SNOW_BM
				 FROM SNOW_HIST
				 WHERE SNOW_DATE BETWEEN ".R_BDAY_START." AND ".R_BDAY_END." 
				 AND AREA_CODE = '".$localcode."'
				 ORDER BY SNOW_DATE DESC LIMIT 1 ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->SNOW_BM = $rs[0]['SNOW_BM'] == "-" ? "-" : $rs[0]['SNOW_BM'];
			}else{
				$this->SNOW_BM = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전일 최심 적설 */
	function getSnowBMAXValue($localcode){
		$sql = " SELECT IFNULL(MAX(SNOW), '-') AS SNOW_BMAX
				 FROM SNOW_HIST
				 WHERE SNOW_DATE BETWEEN ".R_BDAY_START." AND ".R_BDAY_END." 
				 AND AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->SNOW_BMAX = $rs[0]['SNOW_BMAX'] == "-" ? "-" : $rs[0]['SNOW_BMAX'];
			}else{
				$this->SNOW_BMAX = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 금일 적설 */
	function getSnowDValue($localcode){
		$sql = " SELECT IFNULL(SNOW, '-') AS SNOW_D 
				 FROM SNOW_HIST 
				 WHERE DATA_TYPE = 'D' AND SNOW_DATE = ".R_DAY_START."
				 AND AREA_CODE = '".$localcode."' ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->SNOW_D = $rs[0]['SNOW_D'] == "-" ? "-" : $rs[0]['SNOW_D'];
			}else{
				$this->SNOW_D = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 금일최고 적설 */
	function getSnowDMAXValue($localcode){
		$sql = " SELECT IFNULL(SNOW, '-') AS SNOW_MAX 
				 FROM SNOW_HIST 
				 WHERE DATA_TYPE = 'M' AND SNOW_DATE BETWEEN ".R_DAY_START." AND ".R_DAY_END."
				 AND AREA_CODE = '".$localcode."'				 
				 ORDER BY SNOW DESC LIMIT 1 ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->SNOW_MAX = $rs[0]['SNOW_MAX'] == "-" ? "-" : $rs[0]['SNOW_MAX'];
			}else{
				$this->SNOW_MAX = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 현재 적설 */
	function getSnowMValue($localcode){
		$sql = " SELECT IFNULL(SNOW, '-') AS SNOW_M 
				 FROM SNOW_HIST 
				 WHERE DATA_TYPE = 'M' AND SNOW_DATE > ".R_BBEF_START." 
				 AND AREA_CODE = '".$localcode."' 
				 ORDER BY SNOW_DATE DESC ";
		
		if(DB == "0"){
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->SNOW_M = $rs[0]['SNOW_M'] == "-" ? "-" : $rs[0]['SNOW_M'];
			}else{
				$this->SNOW_M = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}

	}

	/* 통신 상태 */
	function getSnowCallValue($localcode){
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
	
	/* 적설 10분 자료 */
	/* AND SNOW_DATE IN (".$where_date.") */
	function getSnow10m($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(SNOW, '-') AS SNOW, SNOW_DATE
				  	 FROM SNOW_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND SNOW_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY SNOW_DATE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['SNOW'] = $rs[$i]['SNOW'] == "-" ? "-" : $rs[$i]['SNOW'];
				$data[$i]['SNOW_DATE'] = $rs[$i]['SNOW_DATE'];
			}
			$this->rsSnow10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 적설 보고서 */
	function getSnowRpt($area_code, $type, $where_date, $ecnt){
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
			
			$sql = " SELECT b.NUM, IFNULL(a.SNOW, '-') AS SNOW, a.SNOW_DATE
				  	 FROM ( SELECT SNOW, DATE_FORMAT(SNOW_DATE, '".$format."') AS NUM, SNOW_DATE
							FROM SNOW_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
							AND SNOW_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['SNOW'] = $rs[$i]['SNOW'] == "-" ? "-" : $rs[$i]['SNOW'];
				$data[$i]['SNOW_DATE'] = $rs[$i]['SNOW_DATE'];
			}
			$this->rsSnowRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 최고 적설 자료 */
	function getSnowMax($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT MAX(SNOW) AS DATA
				 	 FROM SNOW_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND SNOW_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 적설 자료 합계 */
	function getSnowSum($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT SUM(SNOW) AS DATA
				 	 FROM SNOW_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND SNOW_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData2 = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 적설 자료 수정 */
	function setSnowData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM SNOW_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND SNOW_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE SNOW_HIST SET SNOW = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
						 AND SNOW_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO SNOW_HIST (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW)
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