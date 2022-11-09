<?
Class ClassRtuInfo {

	private $DB;

	function ClassRtuInfo($DB, $senser_type=null, $main_check=null){
		$this->DB = $DB;
		$this->SENSERTYPE = $senser_type;
		$this->MAINTYPE = $main_check;
	}
	
	/* RTU 정보 */
	function getRtuInfo($area_code=null){
		if(DB == "0"){
			/* 환경 정보 ************************************************************************************
			 장비 타입(RTU_TYPE)
			 - B00: 방송 / A00: AWS / R00: 강우 / F00: 수위 / RF0: 강우수위 / S00: 적설 / DP0: 변위
			 
			 센서 타입(RTU_SENSER)
			 - 0: 강우(RAIN) / 1: 수위(FLOW) / 2: 적설(SNOW) / 4: 변위(DISP)
			 - A: 기압(ATMO) / T: 기온(TEMP) / W: 풍향풍속(WIND) / H: 습도(HUMI) / R: 일사(RADI) / S: 일조(SUNS)
			 
			 메인 타입
			 - 1: 주요지점 현황
			***********************************************************************************************/
			Switch($this->SENSERTYPE){
				Case "0"  : $w_sensertype = "'0'"; $w_rtutype = "'B00','BR0','BA0','R00','RF0','RS0'"; break;
				Case "1"  : $w_sensertype = "'1'"; $w_rtutype = "'B00','BF0','BA0','F00','RF0'"; break;
				Case "2"  : $w_sensertype = "'2'"; $w_rtutype = "'S00'"; break;
				Case "3"  : $w_sensertype = "'0','A','T','W','H','R','S'"; $w_rtutype = "'A00'"; break;
				Case "4"  : $w_sensertype = "'DP'"; $w_rtutype = "'DP0'"; break;
				default: $w_sensertype = "'0'"; break;
			}
			
			$sql = " SELECT	A.RTU_ID, A.AREA_CODE, A.RTU_NAME, A.CALL_LAST, A.RTU_TYPE, D.GROUP_ID, D.GROUP_NAME,
						    SUM(IF(B.SENSOR_TYPE='0', 1, 0)) AS RAIN,
						 	SUM(IF(B.SENSOR_TYPE='1', 1, 0)) AS FLOW,
						 	SUM(IF(B.SENSOR_TYPE='A', 1, 0)) AS ATMO,
						 	SUM(IF(B.SENSOR_TYPE='T', 1, 0)) AS TEMP,
						 	SUM(IF(B.SENSOR_TYPE='W', 1, 0)) AS WIND,
						 	SUM(IF(B.SENSOR_TYPE='H', 1, 0)) AS HUMI,
						 	SUM(IF(B.SENSOR_TYPE='R', 1, 0)) AS RADI,
						 	SUM(IF(B.SENSOR_TYPE='S', 1, 0)) AS SUNS,
							A.FLOW_WARNING,
							A.FLOW_DANGER,
						    SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL1, 0)) AS RAIN_LEVEL1,
						    SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL2, 0)) AS RAIN_LEVEL2,
						    SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL3, 0)) AS RAIN_LEVEL3 ";
			if(level_cnt == 4){
				$sql.= "  ,	SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL4, 0)) AS RAIN_LEVEL4 ";
			}elseif(level_cnt == 5){
				$sql.= "  ,	SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL4, 0)) AS RAIN_LEVEL4,
						    SUM(IF(B.SENSOR_TYPE='0', B.BASE_RISKLEVEL5, 0)) AS RAIN_LEVEL5 ";
			} 
			$sql.= "	  ,	SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL1, 0)) AS FLOW_LEVEL1,
						    SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL2, 0)) AS FLOW_LEVEL2,
						    SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL3, 0)) AS FLOW_LEVEL3 ";
			if(level_cnt == 4){
				$sql.= "  , SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL4, 0)) AS FLOW_LEVEL4 ";
			}elseif(level_cnt == 5){
				$sql.= "  , SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL4, 0)) AS FLOW_LEVEL4,
						    SUM(IF(B.SENSOR_TYPE='1', B.BASE_RISKLEVEL5, 0)) AS FLOW_LEVEL5 ";
			}
			$sql.= " FROM RTU_INFO AS A
					 LEFT JOIN RTU_SENSOR AS B ON A.RTU_ID = B.RTU_ID 
					 LEFT JOIN DN_MAIN_MEMBER AS C ON A.RTU_ID = C.RTU_ID
					 LEFT JOIN DN_MAIN_GROUP AS D ON C.GROUP_ID = D.GROUP_ID
					 WHERE A.ORGAN_ID = ".ss_organ_id." ";
			if($area_code != ""){
				$sql.= " AND A.AREA_CODE = '".$area_code."' ";
			}else{
				$sql.= " AND A.RTU_TYPE IN (". $w_rtutype .")
						 AND B.SENSOR_TYPE IN (". $w_sensertype .") ";
			}
			if($this->MAINTYPE == "1"){
				$sql.= " AND D.GROUP_ID IS NOT NULL ";
				//$sql.= " GROUP BY A.RTU_ID ORDER BY D.GROUP_SORT, A.".sort." ASC ";
				 $sql.= " GROUP BY A.RTU_ID
						 ORDER BY D.GROUP_ID, A.".sort." ASC ";
			}else if($this->MAINTYPE == "2"){
				$sql.= " GROUP BY A.RTU_ID 
						 ORDER BY F.DONG ASC ";
			}else{
				$sql.= " GROUP BY A.RTU_ID 
				ORDER BY A.".sort." ASC ";
			}
			//  echo $sql."<br><Br>";
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$this->RTU_ID[$i] = $rs[$i]['RTU_ID'];
				$this->AREA_CODE[$i] = $rs[$i]['AREA_CODE'];
				$this->RTU_NAME[$i] = $rs[$i]['RTU_NAME'];
				$this->CALL_LAST[$i] = $rs[$i]['CALL_LAST'];
				$this->RTU_TYPE[$i] = $rs[$i]['RTU_TYPE'];
				$this->GROUP_ID[$i] = $rs[$i]['GROUP_ID'];
				$this->GROUP_NAME[$i] = $rs[$i]['GROUP_NAME'];
				// $this->WR_EMD_CD[$i] = $rs[$i]['WR_EMD_CD'];
				// $this->REAL_ORGAN_CODE[$i] = $rs[$i]['REAL_ORGAN_CODE'];
				// $this->ORGAN_NAME[$i] = $rs[$i]['ORGAN_NAME'];
				// $this->DONG[$i] = $rs[$i]['DONG'];
				$this->RAIN[$i] = $rs[$i]['RAIN'];
				$this->FLOW[$i] = $rs[$i]['FLOW'];
				$this->ATMO[$i] = $rs[$i]['ATMO'];
				$this->TEMP[$i] = $rs[$i]['TEMP'];
				$this->WIND[$i] = $rs[$i]['WIND'];
				$this->HUMI[$i] = $rs[$i]['HUMI'];
				$this->RADI[$i] = $rs[$i]['RADI'];
				$this->SUNS[$i] = $rs[$i]['SUNS'];
				$this->FLOW_WARNING[$i] = $rs[$i]['FLOW_WARNING'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_WARNING'] * 0.01);
				$this->FLOW_DANGER[$i] = $rs[$i]['FLOW_DANGER'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_DANGER'] * 0.01);
				$this->FLOW_LEVEL1[$i] = $rs[$i]['FLOW_LEVEL1'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_LEVEL1'] * 0.01);
				$this->FLOW_LEVEL2[$i] = $rs[$i]['FLOW_LEVEL2'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_LEVEL2'] * 0.01);
				$this->FLOW_LEVEL3[$i] = $rs[$i]['FLOW_LEVEL3'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_LEVEL3'] * 0.01);
				$this->FLOW_LEVEL4[$i] = $rs[$i]['FLOW_LEVEL4'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_LEVEL4'] * 0.01);
				$this->FLOW_LEVEL5[$i] = $rs[$i]['FLOW_LEVEL5'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['FLOW_LEVEL5'] * 0.01);
			}
			$this->rsCnt = $i;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 변위 RTU 정보 */
	function getDispRtuInfo($area_code=null){
		if(DB == "0"){
			
			$sql = " SELECT	A.RTU_ID, A.AREA_CODE, A.RTU_NAME,						    
						B.BASE_RISKLEVEL1 AS DISP_LEVEL1,
						B.BASE_RISKLEVEL2 AS DISP_LEVEL2,
						B.BASE_RISKLEVEL3 AS DISP_LEVEL3,
						C.RTU_AREA_CODE, C.SENSOR_AREA_CODE, C.SENSOR_ID
					 FROM RTU_INFO AS A
					 LEFT JOIN RTU_SENSOR AS B ON A.RTU_ID = B.RTU_ID "; 
			if(DISP_GROUP == "1"){
				$sql.= " LEFT JOIN displacement_group AS C ON A.AREA_CODE = C.RTU_AREA_CODE
						WHERE A.ORGAN_ID = ".ss_organ_id." ";
				if($area_code != ""){
					$sql.= " AND C.SENSOR_AREA_CODE = '".$area_code."' ";
				}
			}else{
				$sql.= " LEFT JOIN displacement_group AS C ON A.AREA_CODE = C.SENSOR_AREA_CODE
						WHERE A.ORGAN_ID = ".ss_organ_id." ";
				if($area_code != ""){
					$sql.= " AND A.AREA_CODE = '".$area_code."' ";
				}
			}
			$sql.= " AND A.RTU_TYPE LIKE 'DP%'
					 AND B.SENSOR_TYPE  = 'DP'
					 ORDER BY C.RTU_AREA_CODE, C.SENSOR_ID ASC";

			// echo $sql."<br><Br>";
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$this->RTU_ID[$i] = $rs[$i]['RTU_ID'];
				if(DISP_GROUP == "1"){
					$this->RTU_NAME[$i] = $rs[$i]['RTU_NAME']. $rs[$i]['SENSOR_ID'];
				}else{
					$this->RTU_NAME[$i] = $rs[$i]['RTU_NAME'];
				}
				$this->AREA_CODE[$i] = $rs[$i]['AREA_CODE'];
				$this->DISP_LEVEL1[$i] = $rs[$i]['DISP_LEVEL1'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['DISP_LEVEL1'] );
				$this->DISP_LEVEL2[$i] = $rs[$i]['DISP_LEVEL2'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['DISP_LEVEL2'] );
				$this->DISP_LEVEL3[$i] = $rs[$i]['DISP_LEVEL3'] == "0" ? "-" : sprintf("%.2f", $rs[$i]['DISP_LEVEL3'] );
				$this->RTU_AREA_CODE[$i] = $rs[$i]['RTU_AREA_CODE'];
				$this->SENSOR_AREA_CODE[$i] = $rs[$i]['SENSOR_AREA_CODE'];
				$this->SENSOR_ID[$i] = $rs[$i]['SENSOR_ID'];
			}
			$this->rsCnt = $i;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 장비상태 리스트 */
	function getRtuStateList(){
		if(DB == "0"){
			$sql = " SELECT
					  	a.AREA_CODE, a.RTU_NAME, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT,
						b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, b.DOOR_STAT, b.SENSOR_STAT,
						b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE
					 FROM
						rtu_info AS a
					 LEFT JOIN (SELECT * FROM (SELECT * FROM STATE_HIST
											   WHERE DATE_FORMAT(LOG_DATE, '%Y%m%d') = DATE_FORMAT(NOW(), '%Y%m%d')
											   ORDER BY LOG_DATE DESC) AS tmp
								GROUP BY tmp.AREA_CODE) AS b
					 ON a.AREA_CODE = b.AREA_CODE
					 WHERE
						a.ORGAN_ID = ".ss_organ_id." ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['RTU_NAME'] = $rs[$i]['RTU_NAME'];
				if($rs[$i]['SOLA_VOLT'] == 0){
					$data[$i]['AC'] = 'O'; // 상전
					$data[$i]['DC'] = 'X'; // 태양전지
				}else{
					$data[$i]['AC'] = 'X';
					$data[$i]['DC'] = 'O';
				}
				$data[$i]['SOLA_VOLT'] = $rs[$i]['SOLA_VOLT'] ? sprintf('%.2f', $rs[$i]['SOLA_VOLT'] * 0.1) : '-';
				$data[$i]['SOLA_AMPERE'] = $rs[$i]['SOLA_AMPERE'] ? sprintf('%.2f', $rs[$i]['SOLA_AMPERE'] * 0.1) : '-';
				$data[$i]['BATT_VOLT'] = $rs[$i]['BATT_VOLT'] ? sprintf('%.2f', $rs[$i]['BATT_VOLT'] * 0.1) : '-';
				$data[$i]['LOAD1_AMPERE'] = $rs[$i]['LOAD1_AMPERE'] ? sprintf('%.2f', $rs[$i]['LOAD1_AMPERE'] * 0.01) : '-';
				$data[$i]['LOAD2_AMPERE'] = $rs[$i]['LOAD2_AMPERE'] ? sprintf('%.2f', $rs[$i]['LOAD2_AMPERE'] * 0.01) : '-';
				$data[$i]['LOGGER_STAT'] = $rs[$i]['LOGGER_STAT'] ? ($rs[$i]['LOGGER_STAT'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['DOOR_STAT'] = $rs[$i]['DOOR_STAT'] ? ($rs[$i]['DOOR_STAT'] == 0 ? '<font color="red">열림</font>' : '닫힘') : '-';
				$data[$i]['SENSOR_STAT'] = $rs[$i]['SENSOR_STAT'] ? ($rs[$i]['SENSOR_STAT'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['MAINAMP_STAT'] = $rs[$i]['MAINAMP_STAT'] ? ($rs[$i]['MAINAMP_STAT'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['AMP_POWER'] = $rs[$i]['AMP_POWER'] ? ($rs[$i]['AMP_POWER'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['AUDIO_VOLUME'] = $rs[$i]['AUDIO_VOLUME'] ? $rs[$i]['AUDIO_VOLUME'] : '-';
				switch($rs[$i]['SPEAKER_SELECT']){
					case '0' : $SPEAKER_SELECT = 'TTS'; break;
					case '1' : $SPEAKER_SELECT = 'TelLine'; break;
					case '2' : $SPEAKER_SELECT = 'HDLC'; break;
					default : $SPEAKER_SELECT = 'TTS'; break;
				}
				$data[$i]['SPEAKER_SELECT'] = $SPEAKER_SELECT ? $SPEAKER_SELECT : '-';
				$data[$i]['LOG_DATE'] = $rs[$i]['LOG_DATE'] ? (substr($rs[$i]['LOG_DATE'], 0, 10) == date("Y-m-d") ? $rs[$i]['LOG_DATE'] : '<font color="red">'.$rs[$i]['LOG_DATE'].'</font>') : '-';
			}
			$sql = "  SELECT DISTINCT
			a.AREA_CODE ,a.RTU_ID, a.RTU_NAME, b.SPEAKER_USE1, b.SPEAKER_USE2, b.SPEAKER_USE3,
			b.SPEAKER_USE4, b.SPEAKER_USE5 , b.SPEAKER_USE6 , b.SPEAKER_USE7 , b.SPEAKER_USE8,
			c.SPEAKER1,c.SPEAKER2,c.SPEAKER3,c.SPEAKER4,c.SPEAKER5,c.SPEAKER6,c.SPEAKER7,c.SPEAKER8
		 	FROM
		 	rtu_info AS a 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_USE
		 	ORDER BY UPDATE_TIME DESC) AS tmp
		 	GROUP BY tmp.RTU_ID) AS b
		 	ON a.RTU_ID = b.RTU_ID 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_STATUS
		 	ORDER BY LOG_NO DESC) AS tmp1
		 	GROUP BY tmp1.RTU_ID) AS c
		 	ON a.RTU_ID = c.RTU_ID
		 	WHERE a.ORGAN_ID = ".ss_organ_id."";

			$rs = $this->DB->execute($sql);
			
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['SPEAKER_ERROR_CNT'] = 0;
				$data[$i]['SPEAKER_CNT'] = 0;
				for($j = 0; $j < 9; $j++){
					if($rs[$i]['SPEAKER_USE'.$j] == 1){
						$data[$i]['SPEAKER_CNT'] ++;
						$data[$i]['SPEAKER_USE_NUM'] .= $j."||";
						
						if($rs[$i]['SPEAKER'.$j] == 1){
							$data[$i]['SPEAKER_ERROR_CNT'] ++;
							$data[$i]['SPEAKER_ERROR'] .= $j."||";
						
						}

					}
				}

			}

			$this->rsRtuStateList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 장비상태 리스트 */
	function getTotalRtuStateList(){
		if(DB == "0"){
			$sql = " SELECT DISTINCT a.AREA_CODE, a.RTU_ID ,a.RTU_NAME, b.AREA_CODE as AREA_CODE2, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT, b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, 
					b.DOOR_STAT, b.SENSOR_STAT, b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE
					,ifnull(d.AREA_CODE, '-') AS SMART_USE, ifnull(d.SOLA_VOLT1, '-') AS SOLA_VOLT1, ifnull(d.SOLA_CURR1, '-') AS SOLA_CURR1, ifnull(d.SOLA_VOLT2, '-') AS SOLA_VOLT2
					, ifnull(d.SOLA_CURR2, '-') AS SOLA_CURR2, ifnull(d.BATT_VOLT1, '-') AS BATT_VOLT1, ifnull(d.BATT_VOLT2, '-') AS BATT_VOLT2, ifnull(d.LOAD_CURR1, '-') AS LOAD_CURR1
					, ifnull(d.LOAD_CURR2, '-') AS LOAD_CURR2, ifnull(d.LOAD_CURR3, '-') AS LOAD_CURR3
					FROM rtu_info AS a 
					LEFT JOIN 
					(SELECT * FROM 
						(SELECT * FROM SMARTPOWER_HIST WHERE DATE_FORMAT(NOW(), '%Y%m%d') = DATE_FORMAT(LOG_DATE, '%Y%m%d') ORDER BY LOG_DATE DESC) AS TEMP 
						GROUP BY TEMP.AREA_CODE
					) AS d on a.AREA_CODE = d.AREA_CODE
					LEFT JOIN 
					(SELECT * FROM 
						(SELECT * FROM STATE_HIST_NEW WHERE DATE_FORMAT(LOG_DATE, '%Y') = DATE_FORMAT(NOW(), '%Y') ORDER BY LOG_DATE DESC) AS tmp 
						GROUP BY tmp.AREA_CODE
					) AS b ON a.AREA_CODE = b.AREA_CODE 
					 WHERE
						a.ORGAN_ID = ".ss_organ_id." ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['RTU_NAME'] = $rs[$i]['RTU_NAME'];
				$data[$i]['SMART_USE'] = $rs[$i]['SMART_USE'];
				
				$data[$i]['SOLA_VOLT'] = $rs[$i]['SOLA_VOLT'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT'] * 0.1) : '-';
				$data[$i]['SOLA_AMPERE'] = $rs[$i]['SOLA_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['SOLA_AMPERE'] * 0.1) : '-';
				$data[$i]['BATT_VOLT'] = $rs[$i]['BATT_VOLT'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT'] * 0.1) : '-';
				$data[$i]['LOAD1_AMPERE'] = $rs[$i]['LOAD1_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD1_AMPERE'] * 0.01) : '-';
				$data[$i]['LOAD2_AMPERE'] = $rs[$i]['LOAD2_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD2_AMPERE'] * 0.01) : '-';
				// $data[$i]['LOGGER_STAT'] = $rs[$i]['LOGGER_STAT'] != null ? ($rs[$i]['LOGGER_STAT'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['DOOR_STAT'] = $rs[$i]['DOOR_STAT'] != null ? ($rs[$i]['DOOR_STAT'] == 0 ? '<img src="../images/icon_no.png" alt="이상">' : '<img src="../images/icon_ok.png" alt="정상">') : '-';
				$data[$i]['SENSOR_STAT'] = $rs[$i]['SENSOR_STAT'] != null ? ($rs[$i]['SENSOR_STAT'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				$data[$i]['MAINAMP_STAT'] = $rs[$i]['MAINAMP_STAT'] != null ? ($rs[$i]['MAINAMP_STAT'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				$data[$i]['AMP_POWER'] = $rs[$i]['AMP_POWER'] != null ? ($rs[$i]['AMP_POWER'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				// $data[$i]['AUDIO_VOLUME'] = $rs[$i]['AUDIO_VOLUME'] ? $rs[$i]['AUDIO_VOLUME'] : '-';
				$data[$i]['SOLA_VOLT1'] = $rs[$i]['SOLA_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT1'] * 0.001) : '-';
				$data[$i]['SOLA_CURR1'] = $rs[$i]['SOLA_CURR1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR1'] * 0.001) : '-';
				$data[$i]['SOLA_VOLT2'] = $rs[$i]['SOLA_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT2'] * 0.001) : '-';
				$data[$i]['SOLA_CURR2'] = $rs[$i]['SOLA_CURR2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR2'] * 0.001) : '-';
				$data[$i]['BATT_VOLT1'] = $rs[$i]['BATT_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT1'] * 0.001) : '-';
				$data[$i]['BATT_VOLT2'] = $rs[$i]['BATT_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR1'] = $rs[$i]['LOAD_CURR1'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR1'] * 0.001) : '-';
				$data[$i]['LOAD_CURR2'] = $rs[$i]['LOAD_CURR2'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR3'] = $rs[$i]['LOAD_CURR3'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR3'] * 0.001) : '-';

				$data[$i]['SPEAKER_SELECT'] = $SPEAKER_SELECT != null ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">';
				$data[$i]['LOG_DATE'] = $rs[$i]['LOG_DATE'] ? (substr($rs[$i]['LOG_DATE'], 0, 10) == date("Y-m-d") ? $rs[$i]['LOG_DATE'] : '<font color="red">'.$rs[$i]['LOG_DATE'].'</font>') : '-';
			}
			$sql = "  SELECT DISTINCT
			a.AREA_CODE ,a.RTU_ID, a.RTU_NAME, b.SPEAKER_USE1, b.SPEAKER_USE2, b.SPEAKER_USE3,
			b.SPEAKER_USE4, b.SPEAKER_USE5 , b.SPEAKER_USE6 , b.SPEAKER_USE7 , b.SPEAKER_USE8,
			c.SPEAKER1,c.SPEAKER2,c.SPEAKER3,c.SPEAKER4,c.SPEAKER5,c.SPEAKER6,c.SPEAKER7,c.SPEAKER8
		 	FROM
		 	rtu_info AS a 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_USE
		 	ORDER BY UPDATE_TIME DESC) AS tmp
		 	GROUP BY tmp.RTU_ID) AS b
		 	ON a.RTU_ID = b.RTU_ID 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_STATUS
		 	ORDER BY LOG_NO DESC) AS tmp1
		 	GROUP BY tmp1.RTU_ID) AS c
		 	ON a.RTU_ID = c.RTU_ID
		 	WHERE a.ORGAN_ID = ".ss_organ_id."";

			$rs = $this->DB->execute($sql);
			
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['SPEAKER_ERROR_CNT'] = 0;
				$data[$i]['SPEAKER_CNT'] = 0;
				for($j = 0; $j < 9; $j++){
					if($rs[$i]['SPEAKER_USE'.$j] == 1){
						$data[$i]['SPEAKER_CNT'] ++;
						$data[$i]['SPEAKER_USE_NUM'] .= $j."||";
						
						if($rs[$i]['SPEAKER'.$j] == 1){
							$data[$i]['SPEAKER_ERROR_CNT'] ++;
							$data[$i]['SPEAKER_ERROR'] .= $j."||";
						
						}

					}
				}

			}

			$this->rsRtuStateList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 스피커상태 리스트 */
	function getSpeakerStateList(){
		if(DB == "0"){
			$sql = "  SELECT DISTINCT
			a.AREA_CODE ,a.RTU_ID, a.RTU_NAME, b.SPEAKER_USE1, b.SPEAKER_USE2, b.SPEAKER_USE3,
			b.SPEAKER_USE4, b.SPEAKER_USE5 , b.SPEAKER_USE6 , b.SPEAKER_USE7 , b.SPEAKER_USE8,
			c.SPEAKER1,c.SPEAKER2,c.SPEAKER3,c.SPEAKER4,c.SPEAKER5,c.SPEAKER6,c.SPEAKER7,c.SPEAKER8
		 	FROM
		 	rtu_info AS a 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_USE
		 	ORDER BY UPDATE_TIME DESC) AS tmp
		 	GROUP BY tmp.RTU_ID) AS b
		 	ON a.RTU_ID = b.RTU_ID 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_STATUS
		 	ORDER BY LOG_NO DESC) AS tmp1
		 	GROUP BY tmp1.RTU_ID) AS c
		 	ON a.RTU_ID = c.RTU_ID
			WHERE a.ORGAN_ID = ".ss_organ_id."  
			AND a.AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."'";

			//echo $sql;

			$rs = $this->DB->execute($sql);
			
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['RTU_NAME'] = $rs[$i]['RTU_NAME'];
				$data[$i]['SPEAKER_ERROR_CNT'] = 0;
				$data[$i]['SPEAKER_CNT'] = 0;
				for($j = 1; $j < 9; $j++){
					if($rs[$i]['SPEAKER_USE'.$j] == 1){
						$data[$i]['SPEAKER_CNT'] ++;
						$data[$i]['SPEAKER_USE_NUM'] .= $j."||";
						if($rs[$i]['SPEAKER'.$j] == 1){
							$data[$i]['SPEAKER_ERROR_CNT'] ++;
							$data[$i]['SPEAKER_ERROR'] .= $j."||";
						}
					}
				}
			}

			$this->rsSpeakerStateList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* 그룹별 장비상태 리스트 */
	function getGroupStateList(){
		if(DB == "0"){
			/*
			$sql = " SELECT
					  	a.AREA_CODE, a.RTU_NAME, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT,
						b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, b.DOOR_STAT, b.SENSOR_STAT,
						b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE
					 FROM
						rtu_info AS a
					 LEFT JOIN (SELECT * FROM (SELECT * FROM STATE_HIST
											   WHERE DATE_FORMAT(LOG_DATE, '%Y') = DATE_FORMAT(NOW(), '%Y')
											   ORDER BY LOG_DATE DESC) AS tmp
								GROUP BY tmp.AREA_CODE) AS b
					 ON a.AREA_CODE = b.AREA_CODE
					 WHERE
						a.ORGAN_ID = ".ss_organ_id." ";
			*/

			/* 느려 
			$sql = " SELECT  a.AREA_CODE, a.RTU_ID ,a.RTU_NAME, b.AREA_CODE as AREA_CODE2, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT, b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, 
				 b.DOOR_STAT, b.SENSOR_STAT, b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE FROM rtu_info AS a 
				 LEFT JOIN 
				 (SELECT * FROM (SELECT * FROM STATE_HIST WHERE DATE_FORMAT(LOG_DATE, '%Y') = DATE_FORMAT(NOW(), '%Y') ORDER BY LOG_DATE DESC) AS tmp 
				 GROUP BY tmp.AREA_CODE) AS b ON a.AREA_CODE = b.AREA_CODE LEFT JOIN STATE_RTU_GROUP c on a.RTU_ID = c.RTU_ID WHERE a.ORGAN_ID = ".ss_organ_id." AND c.GROUP_ID='".$_REQUEST['GROUP_ID']."' ";
			*/
			 /* 트리거로 만든 테이블로 변경 */
			/* $sql = " SELECT  a.AREA_CODE, a.RTU_ID ,a.RTU_NAME, b.AREA_CODE as AREA_CODE2, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT, b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, 
				 b.DOOR_STAT, b.SENSOR_STAT, b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE FROM rtu_info AS a 
				 LEFT JOIN 
				 (SELECT * FROM (SELECT * FROM STATE_HIST_NEW WHERE DATE_FORMAT(LOG_DATE, '%Y') = DATE_FORMAT(NOW(), '%Y') ORDER BY LOG_DATE DESC) AS tmp 
				 GROUP BY tmp.AREA_CODE) AS b ON a.AREA_CODE = b.AREA_CODE LEFT JOIN STATE_RTU_GROUP c on a.RTU_ID = c.RTU_ID WHERE a.ORGAN_ID = ".ss_organ_id." AND c.GROUP_ID='".$_REQUEST['GROUP_ID']."' "; */
				 
			$sql = " SELECT DISTINCT a.AREA_CODE, a.RTU_ID ,a.RTU_NAME, b.AREA_CODE as AREA_CODE2, b.SOLA_VOLT, b.SOLA_AMPERE, b.BATT_VOLT, b.LOAD1_AMPERE, b.LOAD2_AMPERE, b.LOGGER_STAT, 
					b.DOOR_STAT, b.SENSOR_STAT, b.MAINAMP_STAT, b.AMP_POWER, b.AUDIO_VOLUME, b.SPEAKER_SELECT, b.LOG_DATE
					,ifnull(d.AREA_CODE, '-') AS SMART_USE, ifnull(d.SOLA_VOLT1, '-') AS SOLA_VOLT1, ifnull(d.SOLA_CURR1, '-') AS SOLA_CURR1, ifnull(d.SOLA_VOLT2, '-') AS SOLA_VOLT2
					, ifnull(d.SOLA_CURR2, '-') AS SOLA_CURR2, ifnull(d.BATT_VOLT1, '-') AS BATT_VOLT1, ifnull(d.BATT_VOLT2, '-') AS BATT_VOLT2, ifnull(d.LOAD_CURR1, '-') AS LOAD_CURR1
					, ifnull(d.LOAD_CURR2, '-') AS LOAD_CURR2, ifnull(d.LOAD_CURR3, '-') AS LOAD_CURR3
					FROM rtu_info AS a 
					LEFT JOIN 
					(SELECT * FROM 
						(SELECT * FROM SMARTPOWER_HIST WHERE DATE_FORMAT(NOW(), '%Y%m%d') = DATE_FORMAT(LOG_DATE, '%Y%m%d') ORDER BY LOG_DATE DESC) AS TEMP 
						GROUP BY TEMP.AREA_CODE
					) AS d on a.AREA_CODE = d.AREA_CODE
					LEFT JOIN 
					(SELECT * FROM 
						(SELECT * FROM STATE_HIST_NEW WHERE DATE_FORMAT(LOG_DATE, '%Y') = DATE_FORMAT(NOW(), '%Y') ORDER BY LOG_DATE DESC) AS tmp 
						GROUP BY tmp.AREA_CODE
					) AS b ON a.AREA_CODE = b.AREA_CODE 
					LEFT JOIN 
					STATE_RTU_GROUP c on a.RTU_ID = c.RTU_ID WHERE a.ORGAN_ID = ".ss_organ_id." ";
			// 전체 선택이 아닐때	
			if($this->DB->html_encode($_REQUEST['GROUP_ID']) != '001'){
				$sql .=	" AND c.GROUP_ID='".$this->DB->html_encode($_REQUEST['GROUP_ID'])."' ";
			}
/*
//, ifnull(d.ROOM_TEMP, '-') AS ROOM_TEMP			
echo $sql;
exit;
*/
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['RTU_NAME'] = $rs[$i]['RTU_NAME'];
				$data[$i]['SMART_USE'] = $rs[$i]['SMART_USE'];
				/* if($rs[$i]['SOLA_VOLT'] == 0){
					$data[$i]['AC'] = 'O'; // 상전
					$data[$i]['DC'] = 'X'; // 태양전지
				}else{
					$data[$i]['AC'] = 'X';
					$data[$i]['DC'] = 'O';
				} */
				$data[$i]['SOLA_VOLT'] = $rs[$i]['SOLA_VOLT'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT'] * 0.1) : '-';
				$data[$i]['SOLA_AMPERE'] = $rs[$i]['SOLA_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['SOLA_AMPERE'] * 0.1) : '-';
				$data[$i]['BATT_VOLT'] = $rs[$i]['BATT_VOLT'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT'] * 0.1) : '-';
				$data[$i]['LOAD1_AMPERE'] = $rs[$i]['LOAD1_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD1_AMPERE'] * 0.01) : '-';
				$data[$i]['LOAD2_AMPERE'] = $rs[$i]['LOAD2_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD2_AMPERE'] * 0.01) : '-';
				// $data[$i]['LOGGER_STAT'] = $rs[$i]['LOGGER_STAT'] != null ? ($rs[$i]['LOGGER_STAT'] == 0 ? '정상' : '<font color="red">이상</font>') : '-';
				$data[$i]['DOOR_STAT'] = $rs[$i]['DOOR_STAT'] != null ? ($rs[$i]['DOOR_STAT'] == 0 ? '<img src="../images/icon_no.png" alt="이상">' : '<img src="../images/icon_ok.png" alt="정상">') : '-';
				$data[$i]['SENSOR_STAT'] = $rs[$i]['SENSOR_STAT'] != null ? ($rs[$i]['SENSOR_STAT'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				$data[$i]['MAINAMP_STAT'] = $rs[$i]['MAINAMP_STAT'] != null ? ($rs[$i]['MAINAMP_STAT'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				$data[$i]['AMP_POWER'] = $rs[$i]['AMP_POWER'] != null ? ($rs[$i]['AMP_POWER'] == 0 ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">') : '-';
				// $data[$i]['AUDIO_VOLUME'] = $rs[$i]['AUDIO_VOLUME'] ? $rs[$i]['AUDIO_VOLUME'] : '-';
				$data[$i]['SOLA_VOLT1'] = $rs[$i]['SOLA_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT1'] * 0.001) : '-';
				$data[$i]['SOLA_CURR1'] = $rs[$i]['SOLA_CURR1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR1'] * 0.001) : '-';
				$data[$i]['SOLA_VOLT2'] = $rs[$i]['SOLA_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT2'] * 0.001) : '-';
				$data[$i]['SOLA_CURR2'] = $rs[$i]['SOLA_CURR2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR2'] * 0.001) : '-';
				$data[$i]['BATT_VOLT1'] = $rs[$i]['BATT_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT1'] * 0.001) : '-';
				$data[$i]['BATT_VOLT2'] = $rs[$i]['BATT_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR1'] = $rs[$i]['LOAD_CURR1'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR1'] * 0.001) : '-';
				$data[$i]['LOAD_CURR2'] = $rs[$i]['LOAD_CURR2'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR3'] = $rs[$i]['LOAD_CURR3'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR3'] * 0.001) : '-';

				// switch($rs[$i]['SPEAKER_SELECT']){
				// 	case '0' : $SPEAKER_SELECT = 'TTS'; break;
				// 	case '1' : $SPEAKER_SELECT = 'TelLine'; break;
				// 	case '2' : $SPEAKER_SELECT = 'HDLC'; break;
				// 	default : $SPEAKER_SELECT = 'TTS'; break;
				// }
				// $data[$i]['SPEAKER_SELECT'] = $SPEAKER_SELECT != null ? $SPEAKER_SELECT : '-';
				$data[$i]['SPEAKER_SELECT'] = $SPEAKER_SELECT != null ? '<img src="../images/icon_ok.png" alt="정상">' : '<img src="../images/icon_no.png" alt="이상">';
				$data[$i]['LOG_DATE'] = $rs[$i]['LOG_DATE'] ? (substr($rs[$i]['LOG_DATE'], 0, 10) == date("Y-m-d") ? $rs[$i]['LOG_DATE'] : '<font color="red">'.$rs[$i]['LOG_DATE'].'</font>') : '-';
			}

			$sql = "  SELECT DISTINCT
			a.AREA_CODE ,a.RTU_ID, a.RTU_NAME, b.SPEAKER_USE1, b.SPEAKER_USE2, b.SPEAKER_USE3,
			b.SPEAKER_USE4, b.SPEAKER_USE5 , b.SPEAKER_USE6 , b.SPEAKER_USE7 , b.SPEAKER_USE8,
			c.SPEAKER1,c.SPEAKER2,c.SPEAKER3,c.SPEAKER4,c.SPEAKER5,c.SPEAKER6,c.SPEAKER7,c.SPEAKER8
		 	FROM
		 	rtu_info AS a 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_USE
		 	ORDER BY UPDATE_TIME DESC) AS tmp
		 	GROUP BY tmp.RTU_ID) AS b
		 	ON a.RTU_ID = b.RTU_ID 
		 	LEFT JOIN (SELECT * FROM (SELECT * FROM RTU_SPEAKER_STATUS
		 	ORDER BY LOG_NO DESC) AS tmp1
		 	GROUP BY tmp1.RTU_ID) AS c
		 	ON a.RTU_ID = c.RTU_ID
			LEFT JOIN 
				STATE_RTU_GROUP d on a.RTU_ID = d.RTU_ID WHERE a.ORGAN_ID = ".ss_organ_id." ";
			 // 전체 선택이 아닐때	
			if($this->DB->html_encode($_REQUEST['GROUP_ID']) != '001'){
				$sql .=	" AND d.GROUP_ID='".$this->DB->html_encode($_REQUEST['GROUP_ID'])."' ";
			}

			//echo $sql;

			$rs = $this->DB->execute($sql);
			
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['SPEAKER_ERROR_CNT'] = 0;
				$data[$i]['SPEAKER_CNT'] = 0;
				for($j = 0; $j < 9; $j++){
					if($rs[$i]['SPEAKER_USE'.$j] == 1){
						$data[$i]['SPEAKER_CNT'] ++;
						$data[$i]['SPEAKER_USE_NUM'] .= $j."||";
						
						if($rs[$i]['SPEAKER'.$j] == 1){
							$data[$i]['SPEAKER_ERROR_CNT'] ++;
							$data[$i]['SPEAKER_ERROR'] .= $j."||";
						
						}

					}
				}
			}

			$this->rsRtuStateList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/* getSmartPowerList */
	function getSmartPowerList(){
		if(DB == "0"){
			$sql = " SELECT * from SMARTPOWER_HIST
					WHERE AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."'
					AND LOG_DATE < now() 
					AND LOG_DATE > date_add(now(), interval -24 hour)
					AND IDX in (
						SELECT MAX(IDX)
						from SMARTPOWER_HIST 
						WHERE AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."'
						AND LOG_DATE < now() 
						AND LOG_DATE > date_add(now(), interval -24 hour)
						group by HOUR(LOG_DATE)
					) ";
					//  ORDER BY LOG_DATE DESC ";
			/* $sql = " SELECT * FROM SMARTPOWER_HIST WHERE LOG_DATE < now() AND LOG_DATE > date_add(now(), interval -1 day)
					 AND AREA_CODE = '".$_REQUEST['AREA_CODE']."' "; */
		/*			
		echo $sql;
		*/
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['LOG_DATE'] = $rs[$i]['LOG_DATE'];
				$data[$i]['SOLA_VOLT1'] = $rs[$i]['SOLA_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT1'] * 0.001) : '-';
				$data[$i]['SOLA_CURR1'] = $rs[$i]['SOLA_CURR1'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR1'] * 0.001) : '-';
				$data[$i]['SOLA_VOLT2'] = $rs[$i]['SOLA_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT2'] * 0.001) : '-';
				$data[$i]['SOLA_CURR2'] = $rs[$i]['SOLA_CURR2'] != null ? sprintf('%.2f', $rs[$i]['SOLA_CURR2'] * 0.001) : '-';
				$data[$i]['BATT_VOLT1'] = $rs[$i]['BATT_VOLT1'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT1'] * 0.001) : '-';
				$data[$i]['BATT_VOLT2'] = $rs[$i]['BATT_VOLT2'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR1'] = $rs[$i]['LOAD_CURR1'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR1'] * 0.001) : '-';
				$data[$i]['LOAD_CURR2'] = $rs[$i]['LOAD_CURR2'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR2'] * 0.001) : '-';
				$data[$i]['LOAD_CURR3'] = $rs[$i]['LOAD_CURR3'] != null ? sprintf('%.2f', $rs[$i]['LOAD_CURR3'] * 0.001) : '-';

				// 삭제?
				$data[$i]['ROOM_TEMP'] = $rs[$i]['ROOM_TEMP'] != null ? $rs[$i]['ROOM_TEMP'] : '-';
				$data[$i]['ROOM_HUMI'] = $rs[$i]['ROOM_HUMI'] != null ? $rs[$i]['ROOM_HUMI'] : '-';
			}
			$this->rsSmartPowerList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* getStateHistList */
	function getStateHistList(){
		if(DB == "0"){
			$sql = " SELECT * FROM STATE_HIST_NEW 
					WHERE LOG_DATE < now() 
					AND LOG_DATE > date_add(now(), interval -24 hour)
					AND AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."'
					GROUP BY LOG_DATE ";
					//  ORDER BY LOG_DATE DESC ";
					
		/* echo $sql; */
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['LOG_DATE'] = $rs[$i]['LOG_DATE'];
				$data[$i]['SOLA_VOLT1'] = $rs[$i]['SOLA_VOLT'] != null ? sprintf('%.2f', $rs[$i]['SOLA_VOLT'] * 0.1) : '-';
				$data[$i]['SOLA_CURR1'] = $rs[$i]['SOLA_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['SOLA_AMPERE'] * 0.1) : '-';
				$data[$i]['BATT_VOLT1'] = $rs[$i]['BATT_VOLT'] != null ? sprintf('%.2f', $rs[$i]['BATT_VOLT'] * 0.1) : '-';
				$data[$i]['LOAD_CURR1'] = $rs[$i]['LOAD1_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD1_AMPERE'] * 0.01) : '-';
				$data[$i]['LOAD_CURR2'] = $rs[$i]['LOAD2_AMPERE'] != null ? sprintf('%.2f', $rs[$i]['LOAD2_AMPERE'] * 0.01) : '-';
			}
			$this->rsStateHistList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* as 로그 리스트 */
	function getAsLogList($sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT a.as_idx, a.as_case, a.area_code, b.rtu_name, a.as_state, 
							a.as_content, a.as_iname, a.as_uname, a.as_idate, a.as_udate
					 FROM dn_as_log AS a
					 LEFT JOIN rtu_info AS b ON a.area_code = b.area_code
					 WHERE as_idate BETWEEN CAST('".$sdate." 00:00:00' AS DATETIME) AND CAST('".$edate." 23:59:59' AS DATETIME)
					 AND a.organ_id = ".ss_organ_id."
					 ORDER BY a.as_idx DESC ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['as_idx'] = $rs[$i]['as_idx'];
				$data[$i]['as_case'] = $rs[$i]['as_case'];
				$data[$i]['area_code'] = $rs[$i]['area_code'];
				$data[$i]['rtu_name'] = $rs[$i]['rtu_name'];
				$data[$i]['as_state'] = $rs[$i]['as_state'];
				$data[$i]['as_content'] = $rs[$i]['as_content'];
				$data[$i]['as_iname'] = $rs[$i]['as_iname'];
				$data[$i]['as_uname'] = $rs[$i]['as_uname'];
				$data[$i]['as_idate'] = $rs[$i]['as_idate'];
				$data[$i]['as_udate'] = $rs[$i]['as_udate'];
			}
			$this->rsAsLogList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 현장중계 그룹 */
	function getSpotGroup(){
		if(DB == "0"){
			$sql = " SELECT spot_group, group_name
					 FROM dn_spot_group
					 ORDER BY spot_group ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['spot_group'] = $rs[$i]['spot_group'];
				$data[$i]['group_name'] = $rs[$i]['group_name'];
			}
			$this->rsSpotGroup = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/* 현장중계 리스트 */
	function getSpotList($sdate, $edate){
		if(DB == "0"){
			$sql = " SELECT a.spot_idx, b.group_name, a.spot_title, a.spot_content, a.spot_img, a.spot_name, a.spot_idate, a.spot_x_point, a.spot_y_point
					 FROM dn_spot_log AS a
					 LEFT JOIN dn_spot_group AS b ON a.spot_group = b.spot_group
					 WHERE a.spot_idate BETWEEN CAST('".$sdate." 00:00:00' AS DATETIME) AND CAST('".$edate." 23:59:59' AS DATETIME)
					 AND a.organ_id = ".ss_organ_id." ";
			if($this->DB->html_encode($_REQUEST['spot_group']) != ""){
				$sql.= " AND b.spot_group = '".$this->DB->html_encode($_REQUEST['spot_group'])."'";
			}
			$sql.="	 ORDER BY a.spot_idx DESC ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$tmp_img = "";
				if( file_exists("../images/spot/".$rs[$i]['spot_img']) ){
					$tmp_img = '<a href="../images/spot/'.$rs[$i]['spot_img'].'" class="magnific-popup" style="border:0; text-decoration:none; outline:none;">';
					$tmp_img.= '<img src="../images/spot/'.$rs[$i]['spot_img'].'" alt="현장사진" width="165px" height="80px">';
					$tmp_img.= '</a>';
				}else{
					$tmp_img = '<div style="width: 100%; height: 87px; background-color: #BFD2EB; text-align: center;">';
					$tmp_img.= '<span style="position: relative; top: 32px;">이미지가 없습니다.</span>';
					$tmp_img.= '</div>';
				}
				
				$data[$i]['spot_idx'] = $rs[$i]['spot_idx'];
				$data[$i]['group_name'] = $rs[$i]['group_name'];
				$data[$i]['spot_title'] = $rs[$i]['spot_title'];
				$data[$i]['spot_content'] = $rs[$i]['spot_content'];
				$data[$i]['spot_img'] = $tmp_img;
				$data[$i]['spot_name'] = $rs[$i]['spot_name'];
				$data[$i]['spot_idate'] = $rs[$i]['spot_idate'];
				$data[$i]['spot_x_point'] = $rs[$i]['spot_x_point'];
				$data[$i]['spot_y_point'] = $rs[$i]['spot_y_point'];
			}
			$this->rsSpotList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

}//End Class
?>