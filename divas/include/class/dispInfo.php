<?
Class ClassDispInfo {

	private $DB;

	function __construct($DB){
		$this->DB = $DB;
	}

	/* 10분 변위량 */
	function getDispMValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_M , IFNULL(DISPLACEMENT_DIFFDATE, '-') AS DISPLACEMENT_DIFFDATE
				  	 FROM DISPLACEMENT_HIST 
				  	 WHERE DATA_TYPE = 'M' AND DISPLACEMENT_DATE BETWEEN ".R_BEF_START." AND ".R_NOW_END." 
				  	 AND AREA_CODE = '".$area_code."'
				  	 ORDER BY DISPLACEMENT_DATE DESC LIMIT 1 ";
			// echo $sql;
			$rs = $this->DB->execute($sql);

			if($this->DB->num_rows){
				$this->DISPLACEMENT_M = $rs[0]['DISPLACEMENT_M'] == "-" ? "-" : $rs[0]['DISPLACEMENT_M'];
				$this->DISPLACEMENT_DIFFDATE = $rs[0]['DISPLACEMENT_DIFFDATE'] == "-" ? "-" : $rs[0]['DISPLACEMENT_DIFFDATE'];
			}else{
				$this->DISPLACEMENT_M = '-';
				$this->DISPLACEMENT_DIFFDATE = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 시간 변위량 */
	function getDispHValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_H 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'H' AND DISPLACEMENT_DATE = ".R_NOW_START." 
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_H = $rs[0]['DISPLACEMENT_H'] == "-" ? "-" : $rs[0]['DISPLACEMENT_H'];
			}else{
				$this->DISPLACEMENT_H = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전시간 변위량 */
	function getDispBHValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_BH 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'H' AND DISPLACEMENT_DATE = ".R_BEF_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_BH = $rs[0]['DISPLACEMENT_BH'] == "-" ? "-" : $rs[0]['DISPLACEMENT_BH'];
			}else{
				$this->DISPLACEMENT_BH = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 금일 변위량 */
	function getDispDValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_D 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'D' AND DISPLACEMENT_DATE = ".R_DAY_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_D = $rs[0]['DISPLACEMENT_D'] == "-" ? "-" : $rs[0]['DISPLACEMENT_D'];
			}else{
				$this->DISPLACEMENT_D = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 전일 변위량 */
	function getDispBDValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_BD 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'D' AND DISPLACEMENT_DATE = ".R_BDAY_START."
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_BD = $rs[0]['DISPLACEMENT_BD'] == "-" ? "-" : $rs[0]['DISPLACEMENT_BD'];
			}else{
				$this->DISPLACEMENT_BD = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 월간 변위량 */
	function getDispNValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_N 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'N' AND DISPLACEMENT_DATE = ".R_MONTH_START." 
				 	 AND AREA_CODE = '".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_N = $rs[0]['DISPLACEMENT_N'] == "-" ? "-" : $rs[0]['DISPLACEMENT_N'];
			}else{
				$this->DISPLACEMENT_N = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 년간 변위량 */
	function getDispYValue($area_code){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT_Y 
				 	 FROM DISPLACEMENT_HIST 
				 	 WHERE DATA_TYPE = 'Y' AND DISPLACEMENT_DATE = ".R_YEAR_START."
				 	 AND AREA_CODE='".$area_code."' ";
		
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$this->DISPLACEMENT_Y = $rs[0]['DISPLACEMENT_Y'] == "-" ? "-" : $rs[0]['DISPLACEMENT_Y'];
			}else{
				$this->DISPLACEMENT_Y = '-';
			}
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 주요지점 변위 평균 */
	function getDispMain(){
		if(DB == "0"){
			$sql = " SELECT a.GROUP_ID, a.GROUP_NAME, IFNULL(AVG(e.DISPLACEMENT_CURR), '-') AS DISPLACEMENT_AVR
				 	 FROM dn_main_group AS a
				 	 LEFT JOIN dn_main_member AS b ON a.GROUP_ID = b.GROUP_ID
				 	 LEFT JOIN rtu_info AS c ON b.RTU_ID = c.RTU_ID
				 	 LEFT JOIN rtu_sensor AS d ON c.RTU_ID = d.RTU_ID
				 	 LEFT JOIN rain_hist AS e ON c.AREA_CODE = e.AREA_CODE AND e.DATA_TYPE = 'H' AND e.DISPLACEMENT_DATE = ".R_NOW_START."
				 	 WHERE d.SENSOR_TYPE = 0 
				 	 GROUP BY a.GROUP_ID
				 	 ORDER BY a.GROUP_SORT ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['GROUP_ID'] = $rs[$i]['GROUP_ID'];
				$data[$i]['GROUP_NAME'] = $rs[$i]['GROUP_NAME'];
				$data[$i]['DISPLACEMENT_AVR'] = $rs[$i]['DISPLACEMENT_AVR'] == "-" ? "-" : $rs[$i]['DISPLACEMENT_AVR'];
			}
			$this->rsDispMain = $data;
			
			unset($rs);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 통신 상태 */
	function getDispCallValue($area_code){
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
	
	/* 변위 현황 그래프 자료 */
	function getDispGraph($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT IFNULL(DISPLACEMENT_CURR, '-') AS DISPLACEMENT, DISPLACEMENT_DATE
				  	 FROM DISPLACEMENT_HIST
					 WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."'
					 AND DISPLACEMENT_DATE between '".$sdate."' and '".$edate."'
					 ORDER BY DISPLACEMENT_DATE ";
			
			$rs = $this->DB->execute($sql);
			// echo $sql;
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['DISPLACEMENT'] = $rs[$i]['DISPLACEMENT'] == "-" ? "-" : $rs[$i]['DISPLACEMENT'];
				$data[$i]['DISPLACEMENT_DATE'] = $rs[$i]['DISPLACEMENT_DATE'];
			}
			$this->rsDisp10m = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 변위 보고서 */
	function getDispRpt($area_code, $type, $where_date, $ecnt){
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
		
			$sql = " SELECT b.NUM, IFNULL(a.DISPLACEMENT_CURR, '-') AS DISPLACEMENT, a.DISPLACEMENT_DATE
				  	 FROM ( SELECT DISPLACEMENT_CURR, DATE_FORMAT(DISPLACEMENT_DATE, '".$format."') AS NUM, DISPLACEMENT_DATE
							FROM DISPLACEMENT_HIST
							WHERE DATA_TYPE = '".$type."' AND AREA_CODE = '".$area_code."' 
							AND DISPLACEMENT_DATE IN (".$where_date.") ) AS a
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
				$data[$i]['DISPLACEMENT'] = $rs[$i]['DISPLACEMENT'] == "-" ? "-" : $rs[$i]['DISPLACEMENT'];
				$data[$i]['DISPLACEMENT_DATE'] = $rs[$i]['DISPLACEMENT_DATE'];
			}
			$this->rsDispRpt = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 변위 자료 합계 */
	function getDispSum($area_code, $type, $sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT SUM(DISPLACEMENT_DIFF) AS DATA
				 	 FROM DISPLACEMENT_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."'
 					 AND DISPLACEMENT_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsData = $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 변위 1시간 자료 합계 */
	function getDispSumH($area_code){
		if(DB == "0"){
			$time = time();
			$sdate = date("Y-m-d H:i:00",strtotime("-1 hours", $time))."";
			$edate = date("Y-m-d H:i:00");
			
			$sql = " SELECT SUM(DISPLACEMENT_DIFF) AS DATA
				 	 FROM DISPLACEMENT_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = 'M'
					 AND DISPLACEMENT_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
			$rs = $this->DB->execute($sql);

			$this->DISPLACEMENT_BH_DIFF =  $rs[0]['DATA'];

			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 변위 1일 자료 합계 */
	function getDispSumD($area_code){
		if(DB == "0"){
			$time = time();
			$sdate = date("Y-m-d H:i:00",strtotime("-1 days", $time))."";
			$edate = date("Y-m-d H:i:00");

				$sql = " SELECT SUM(DISPLACEMENT_DIFF) AS DATA
						  FROM DISPLACEMENT_HIST
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = 'H'
						 AND DISPLACEMENT_DATE BETWEEN '".$sdate."' AND '".$edate."' ";
				$rs = $this->DB->execute($sql);
				
				$this->DISPLACEMENT_D_DIFF = $rs[0]['DATA'];
				
				unset($rs); unset($data);
				$this->DB->parseFree();
			}else if(DB == "1"){
				// ORACLE
		}
	}
		

	/* 변위 1월 자료 합계 */
	function getDispSumN($area_code){
		if(DB == "0"){
			$time = time();
			$sdate = date("Y-m-d H:i:00",strtotime("-1 months", $time))."";
			$edate = date("Y-m-d H:i:00");

			$sql = " SELECT SUM(DISPLACEMENT_DIFF) AS DATA
				 	 FROM DISPLACEMENT_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = 'D'
					 AND DISPLACEMENT_DATE BETWEEN '".$sdate."' AND '".$edate."' ";

			$rs = $this->DB->execute($sql);
			
			$this->DISPLACEMENT_N_DIFF =  $rs[0]['DATA'];
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 변위 CURR 자료 수정 */
	function setDispData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM DISPLACEMENT_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
 					 AND DISPLACEMENT_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE DISPLACEMENT_HIST SET DISPLACEMENT_CURR = ".$data."
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
						 AND DISPLACEMENT_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO DISPLACEMENT_HIST (AREA_CODE, DATA_TYPE, DISPLACEMENT_DATE, DISPLACEMENT_CURR)
					 	 VALUES ('".$area_code."', '".$type."', '".$where_date."', ".$data.") ";
			}
				
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 변위 DIFF 자료 수정 */
	function setDispDiffData($area_code, $type, $where_date, $data){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS cnt
				 	 FROM DISPLACEMENT_HIST
					 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
 					 AND DISPLACEMENT_DATE = '".$where_date."' ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]['cnt']){
				$sql = " UPDATE DISPLACEMENT_HIST SET DISPLACEMENT_DIFF = abs(".$data.")
						 WHERE AREA_CODE = '".$area_code."' AND DATA_TYPE = '".$type."' 
						 AND DISPLACEMENT_DATE = '".$where_date."' ";
			}else{
				$sql = " INSERT INTO DISPLACEMENT_HIST (AREA_CODE, DATA_TYPE, DISPLACEMENT_DATE, DISPLACEMENT_DIFF)
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