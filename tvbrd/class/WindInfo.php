<?
/***********************************************************
 * 파 일 명 : WindInfo.class                               *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 풍향풍속정보		                             *
 ***********************************************************/

Class WindInfo {

	/*
	public $NowTimeValue;	//현재시간 풍속
	public $NowTimeDeg;	//현재시간 풍향
	public $NowDayMaxValue; //금일 최대풍속
	public $NowDayMaxDeg;   //금일 최대풍향
  */	

	public $AVR_VEL1;	  //풍속1
	public $AVR_DEG1;	  //풍향1
	public $WIND_DATE;	//시간
	public $TimeListValue;	 // 시간 단위 데이터
	public $TimeListDegValue;	 // 시간 단위 데이터
	public $TimeListDateValue; // 시간 단위 날짜

	private $DB;
	private $DM;
	private $rfutil;

	Private $getCalc = 0.01;
	Private $setCalc = 100;

	/* 생성자 */
	function WindInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재시간 풍향,풍속 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT AVR_VEL1, AVR_DEG1 FROM wind_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND WIND_DATE Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY WIND_DATE DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND WIND_DATE Between {ts '2005-05-17 21:00:00'} and {ts '2005-08-12 22:59:59'}
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowTimeValue   	= round($rs[0]['AVR_VEL1']*$this->getCalc,2);
			//$this->NowTimeDeg   	  = $this->windAngle($rs[0]['AVR_DEG1']*$this->getCalc);
			$this->NowTimeDeg   	  = $this->windAngle($rs[0]['AVR_DEG1']);
		}else{
			$this->NowTimeValue   = "-";
			$this->NowTimeDeg   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 금일 최대 풍향,풍속 */
	function getNowDayMaxValue($area_code) {
		$sql = "SELECT MAX_VEL, MAX_DEG FROM wind_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND WIND_DATE = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY WIND_DATE DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'D'' AND WIND_DATE = {ts '2005-05-17 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowDayMaxValue  	= round($rs[0]['MAX_VEL']*$this->getCalc,2);
			$this->NowDayMaxDeg    	= $this->windAngle($rs[0]['MAX_DEG']*$this->getCalc);
		}else{
			$this->NowDayMaxValue  	= "-";
			$this->NowDayMaxDeg    	= "-";
		}
		$this->DB->parseFree();
	}
	
	/* 기간풍향/풍속*/
	function getWindListValue($area_code, $type, $startdate, $enddate) {
		$sql = "SELECT wind_date as WIND_DATE, avr_deg1 as AVR_DEG1, avr_vel1 as AVR_VEL1 FROM wind_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND wind_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY wind_date asc";

		$rs = $this->DB->execute($sql);
		
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->AVR_VEL1[$i] = $rs[$i]['AVR_VEL1']*$this->getCalc;
			$this->AVR_DEG1[$i] = $this->windAngleFlex($rs[$i]['AVR_DEG1']);
			$this->WIND_DATE[$i] = $rs[$i]['WIND_DATE'];
		}		
		
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}	
	
	/* 시간 범위 풍속 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.wind_date, '-') AS wind_date, IFNULL(b.avr_deg1, '-') AS avr_deg1, IFNULL(b.avr_vel1, '-') AS avr_vel1, 
				concat(LPAD(t1.num,2,'0'), concat(':', LPAD(t2.num,2,'0'))) as numC
				FROM (select num from statistics_tmp where type = 'H') as t1
				join (select num from statistics_tmp where type = 'M') as t2	
				 RIGHT JOIN (
				 SELECT * FROM wind_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' 
				 AND wind_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 order by wind_date desc
				) AS b 
				ON t1.num = DATE_FORMAT(b.wind_date, '%k') 
				AND t2.num = DATE_FORMAT(b.wind_date, '%i') 
				group by numC
				ORDER BY b.wind_date DESC ";
		$rs = $this->DB->execute($sql);
	
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['avr_vel1'] != "-") ? $rs[$i]['avr_vel1']*$this->getCalc : "-";
			$this->TimeListDegValue[$i]     = ($this->windAngle($rs[$i]['avr_deg1']) != "-") ? ($this->windAngle($rs[$i]['avr_deg1'])) : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['wind_date'];
			$this->Num[$i] 				 = $rs[$i]['numC'];
		}
	
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}
	
/* 풍향 */
function windAngleFlex($degree) {

	if($degree=='-'){
		$dispDeg = "-";
	}else{
		/*
		 * NewDeg = cint((deg/100 + 3) / 22.5)
		 * num = NewDeg mod 16
		*/
		$tmp_degree	= (int)((($degree/100)+3)/22.5);
		$num = (int)(fmod($tmp_degree,16));
		switch		($num) {
		case 0	:	$dispDeg = "0";				break;
		case 1	:	$dispDeg = "15";			break;
		case 2	:	$dispDeg = "45";			break;
		case 3	:	$dispDeg = "70";			break;
		case 4	:	$dispDeg = "90";				break;
		case 5	:	$dispDeg = "85";			break;
		case 6	:	$dispDeg = "120";			break;
		case 7	:	$dispDeg = "150";			break;
		case 8	:	$dispDeg = "180";				break;
		case 9	:	$dispDeg = "215";			break;
		case 10	:	$dispDeg = "235";			break;
		case 11	:	$dispDeg = "250";			break;
		case 12	:	$dispDeg = "270";				break;
		case 13	:	$dispDeg = "285";			break;
		case 14	:	$dispDeg = "310";			break;
		case 15	:	$dispDeg = "330";			break;
		default:	$dispDeg = "0";				break;
		}


	}
	return $dispDeg;
}		
	
	
/* 풍향 */
function windAngle($degree) {

	if($degree=='-'){
		$dispDeg = "-";
	}else{
		/*
		 * NewDeg = cint((deg/100 + 3) / 22.5)
		 * num = NewDeg mod 16
		*/
		$tmp_degree	= (int)((($degree/100)+3)/22.5);
		$num = (int)(fmod($tmp_degree,16));
		switch		($num) {
		case 0	:	$dispDeg = "buk.png";				break;
		case 1	:	$dispDeg = "bukbukdong.png";			break;
		case 2	:	$dispDeg = "bukdong.png";			break;
		case 3	:	$dispDeg = "dongbukdong.png";			break;
		case 4	:	$dispDeg = "dong.png";				break;
		case 5	:	$dispDeg = "dongnamdong.png";			break;
		case 6	:	$dispDeg = "namdong.png";			break;
		case 7	:	$dispDeg = "namnamdong.png";			break;
		case 8	:	$dispDeg = "nam.png";				break;
		case 9	:	$dispDeg = "namnamseo.png";			break;
		case 10	:	$dispDeg = "namseo.png";			break;
		case 11	:	$dispDeg = "seonamseo.png";			break;
		case 12	:	$dispDeg = "seo.png";				break;
		case 13	:	$dispDeg = "seobukseo.png";			break;
		case 14	:	$dispDeg = "bukseo.png";			break;
		case 15	:	$dispDeg = "bukbukseo.png";			break;
		default:	$dispDeg = "-";				break;
		}
	}
	return $dispDeg;
}	

/* 풍향 */
function windAngleOri($degree) {

	if($degree=='-'){
		$dispDeg = "-";
	}else{
		/*
		 * NewDeg = cint((deg/100 + 3) / 22.5)
		 * num = NewDeg mod 16
		*/
		$tmp_degree	= (int)((($degree/100)+3)/22.5);
		$num = (int)(fmod($tmp_degree,16));
		switch		($num) {
			case 0	:	$dispDeg = "북";				break;
			case 1	:	$dispDeg = "북북동";			break;
			case 2	:	$dispDeg = "북동";			break;
			case 3	:	$dispDeg = "동북동";			break;
			case 4	:	$dispDeg = "동";				break;
			case 5	:	$dispDeg = "동남동";			break;
			case 6	:	$dispDeg = "남동";			break;
			case 7	:	$dispDeg = "남남동";			break;
			case 8	:	$dispDeg = "남";				break;
			case 9	:	$dispDeg = "남남서";			break;
			case 10	:	$dispDeg = "남서";			break;
			case 11	:	$dispDeg = "서남서";			break;
			case 12	:	$dispDeg = "서";				break;
			case 13	:	$dispDeg = "서북서";			break;
			case 14	:	$dispDeg = "북서";			break;
			case 15	:	$dispDeg = "북북서";			break;
		default:	$dispDeg = "-";				break;
		}
	}
	return $dispDeg;
}	
	

	/* 쿼리실행 */
	public function exe_Query($sql) {
//		echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}

	/* 널체크 */
	public function nullCheck($var) {
		if($var == null) {
			$var = 0;
		}
		return $var;
	}

}//End Class
?>