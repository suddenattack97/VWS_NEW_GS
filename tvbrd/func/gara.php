<?
// 갈아 데이터 insert
exit;

require_once "../db/_Db.php";
require_once "../class/DBmanager.php";
$DB = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

$in_date = "2018-05-31";
$in_y = substr($in_date, 0, 4);
$in_m = substr($in_date, 5, 2);
$in_d = substr($in_date, 8, 2);
$data_sensor = array();

// sensor_type 조회
$sql = " SELECT a.rtu_name, a.area_code, a.rtu_type, b.sensor_type
		 FROM rtu_info AS a
		 LEFT JOIN rtu_sensor AS b ON a.rtu_id = b.rtu_id ";
$rs = $DB->execute($sql);

for($i=0; $i<$DB->NUM_ROW(); $i++){
	$data_sensor[$i]['area_code'] = $rs[$i]['area_code'];
	$data_sensor[$i]['sensor_type'] = $rs[$i]['sensor_type'];
}
$DB->parseFree();

// 각 센서 데이터 저장
if($data_sensor){
	for($i=0; $i<count($data_sensor); $i++){
		if($data_sensor[$i]['sensor_type'] == "0"){ // 강우
			$tmp_array = array("0", "5", "10", "15", "20", "25", "30", "35", "40", "45", "50");
			
			// M
			$m_sql = " INSERT INTO rain_hist (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN, SENSING) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."', '1') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();

			// H
			$h_sql = " INSERT INTO rain_hist (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN, SENSING) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT SUM(RAIN) AS sum
						 FROM rain_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 RAIN_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['sum'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."', '1') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO rain_hist (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN, SENSING) VALUES ";
			$sql = " SELECT SUM(RAIN) AS sum
					 FROM rain_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 RAIN_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
				
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
				
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."', '1') ";
				
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO rain_hist (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN, SENSING) VALUES ";
			$sql = " SELECT SUM(RAIN) AS sum
					 FROM rain_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 RAIN_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."', '1') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO rain_hist (AREA_CODE, DATA_TYPE, RAIN_DATE, RAIN, SENSING) VALUES ";
			$sql = " SELECT SUM(RAIN) AS sum
					 FROM rain_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 RAIN_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."', '1') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 강우 end
		
		if($data_sensor[$i]['sensor_type'] == "1"){ // 수위
			$tmp_array = array("0", "5", "10", "15", "20", "25", "30", "35", "40", "45", "50");
			
			// M
			$m_sql = " INSERT INTO flow_hist (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO flow_hist (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT AVG(FLOW_AVR) AS avr
						 FROM flow_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 FLOW_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['avr'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO flow_hist (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR) VALUES ";
			$sql = " SELECT AVG(FLOW_AVR) AS avr
					 FROM flow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 FLOW_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO flow_hist (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR) VALUES ";
			$sql = " SELECT AVG(FLOW_AVR) AS avr
					 FROM flow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 FLOW_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO flow_hist (AREA_CODE, DATA_TYPE, FLOW_DATE, FLOW_AVR) VALUES ";
			$sql = " SELECT AVG(FLOW_AVR) AS avr
					 FROM flow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 FLOW_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 수위 end
		
		if($data_sensor[$i]['sensor_type'] == "2"){ // 적설
			$tmp_array = array("0", "50", "100", "150", "200", "250", "300", "350", "400", "450", "500");
			
			// M
			$m_sql = " INSERT INTO snow_hist (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW, SENSING) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."', '1') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO snow_hist (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW, SENSING) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT SUM(SNOW) AS sum
						 FROM snow_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 SNOW_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['sum'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."', '1') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO snow_hist (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW, SENSING) VALUES ";
			$sql = " SELECT SUM(SNOW) AS sum
					 FROM snow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 SNOW_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."', '1') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO snow_hist (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW, SENSING) VALUES ";
			$sql = " SELECT SUM(SNOW) AS sum
					 FROM snow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 SNOW_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."', '1') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO snow_hist (AREA_CODE, DATA_TYPE, SNOW_DATE, SNOW, SENSING) VALUES ";
			$sql = " SELECT SUM(SNOW) AS sum
					 FROM snow_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 SNOW_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['sum'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."', '1') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 적설 end
		
		if($data_sensor[$i]['sensor_type'] == "T"){ // 온도
			$tmp_array = array("1500", "1625", "1750", "1875", "2000", "2125", "2250", "2375", "2500", "2625", "2750", "2875", "3000");
			
			// M
			$m_sql = " INSERT INTO temp_hist (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO temp_hist (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT AVG(AVR_VAL) AS avr
						 FROM temp_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 TEMP_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['avr'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO temp_hist (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM temp_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 TEMP_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO temp_hist (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM temp_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 TEMP_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO temp_hist (AREA_CODE, DATA_TYPE, TEMP_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM temp_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 TEMP_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 온도 end
		
		if($data_sensor[$i]['sensor_type'] == "W"){ // 풍향풍속
			$tmp_array = array("0", "50", "100", "150", "200", "250", "300", "350", "400", "450", "500");
			
			// M
			$m_sql = " INSERT INTO wind_hist (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1, AVR_DEG1) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."', '".$tmp_data."') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO wind_hist (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1, AVR_DEG1) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT AVG(AVR_VEL1) AS avr
						 FROM wind_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 WIND_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['avr'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."', '".$tmp_data."') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO wind_hist (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1, AVR_DEG1) VALUES ";
			$sql = " SELECT AVG(AVR_VEL1) AS avr
					 FROM wind_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 WIND_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."', '".$tmp_data."') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO wind_hist (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1, AVR_DEG1) VALUES ";
			$sql = " SELECT AVG(AVR_VEL1) AS avr
					 FROM wind_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 WIND_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."', '".$tmp_data."') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO wind_hist (AREA_CODE, DATA_TYPE, WIND_DATE, AVR_VEL1, AVR_DEG1) VALUES ";
			$sql = " SELECT AVG(AVR_VEL1) AS avr
					 FROM wind_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 WIND_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."', '".$tmp_data."') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 풍향풍속 end
		
		if($data_sensor[$i]['sensor_type'] == "A"){ // 기압
			$tmp_array = array("1400", "1425", "1450", "1475", "1500", "1525", "1550", "1575", "1600", "1625");
			
			// M
			$m_sql = " INSERT INTO atmo_hist (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO atmo_hist (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT AVG(AVR_VAL) AS avr
						 FROM atmo_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 ATMO_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['avr'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO atmo_hist (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM atmo_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 ATMO_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO atmo_hist (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM atmo_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 ATMO_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO atmo_hist (AREA_CODE, DATA_TYPE, ATMO_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM atmo_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 ATMO_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 기압 end
		
		if($data_sensor[$i]['sensor_type'] == "H"){ // 습도
			$tmp_array = array("4400", "4425", "4450", "4475", "4500", "4525", "4550", "4575", "4600", "4625");
			
			// M
			$m_sql = " INSERT INTO humi_hist (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				for($k=0; $k<6; $k++){
					if( !($j == 0 && $k == 0) ) $m_sql.= ", ";
					$tmp_m = $k."0";
					$tmp_key = array_rand($tmp_array);
					$tmp_data = $tmp_array[$tmp_key];
					$m_sql.= " ('".$data_sensor[$i]['area_code']."', 'M', '".$in_date." ".$tmp_h.":".$tmp_m.":00', '".$tmp_data."') ";
				}
			}
			$DB->QUERYONE($m_sql);
			$DB->parseFree();
			
			// H
			$h_sql = " INSERT INTO humi_hist (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL) VALUES ";
			for($j=0; $j<24; $j++){
				$tmp_h = ($j < 10) ? "0".$j : $j;
				
				$sql = " SELECT AVG(AVR_VAL) AS avr
						 FROM humi_hist
						 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'M' AND
						 HUMI_DATE BETWEEN '".$in_date." ".$tmp_h.":00:00' AND '".$in_date." ".$tmp_h.":59:59' ";
				$rs = $DB->execute($sql);
				
				$tmp_sum = $rs[0]['avr'];
				$DB->parseFree();
				
				if($j != 0) $h_sql.= ", ";
				$tmp_data = $tmp_sum;
				$h_sql.= " ('".$data_sensor[$i]['area_code']."', 'H', '".$in_date." ".$tmp_h.":00:00', '".$tmp_data."') ";
			}
			$DB->QUERYONE($h_sql);
			$DB->parseFree();
			
			// D
			$d_sql = " INSERT INTO humi_hist (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM humi_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'H' AND
					 HUMI_DATE BETWEEN '".$in_date." 00:00:00' AND '".$in_date." 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$d_sql.= " ('".$data_sensor[$i]['area_code']."', 'D', '".$in_date." 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($d_sql);
			$DB->parseFree();
			
			// N
			$n_sql = " INSERT INTO humi_hist (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM humi_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'D' AND
					 HUMI_DATE BETWEEN '".$in_y."-".$in_m."-01 00:00:00' AND '".$in_y."-".$in_m."-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$n_sql.= " ('".$data_sensor[$i]['area_code']."', 'N', '".$in_y."-".$in_m."-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($n_sql);
			$DB->parseFree();
			
			// Y
			$y_sql = " INSERT INTO humi_hist (AREA_CODE, DATA_TYPE, HUMI_DATE, AVR_VAL) VALUES ";
			$sql = " SELECT AVG(AVR_VAL) AS avr
					 FROM humi_hist
					 WHERE AREA_CODE = '".$data_sensor[$i]['area_code']."' AND DATA_TYPE = 'N' AND
					 HUMI_DATE BETWEEN '".$in_y."-01-01 00:00:00' AND '".$in_y."-12-31 23:59:59' ";
			$rs = $DB->execute($sql);
			
			$tmp_sum = $rs[0]['avr'];
			$DB->parseFree();
			
			$tmp_data = $tmp_sum;
			$y_sql.= " ('".$data_sensor[$i]['area_code']."', 'Y', '".$in_y."-01-01 00:00:00', '".$tmp_data."') ";
			
			$DB->QUERYONE($y_sql);
			$DB->parseFree();
		} // 기압 end
		
	} // for end
}
echo 1;
?>


