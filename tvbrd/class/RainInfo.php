<?
/***********************************************************
 * 파 일 명 : RainInfo.class                               *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 강우량정보		                               *
 ***********************************************************/

Class RainInfo {
	public $BsenSingValue;	//강우감지
	public $BefTimeValue;		//이전시간 정시강우자료
	public $NowTimeValue;		//현재시간 강우최신자료
	public $NowDayValue;		//금일 강우량 누계
	public $BefDayValue;		//전일 강우량 누계
	public $NowMonValue;		//금월 강우량 누계
	public $YearSumValue;   //년간누계
	public $RainListValue;      //기간강우
	public $RainListDateValue;  //기간강우시간
	public $RainDate; // 날짜
	public $TimeListValue; 	   // 시간 단위 데이터
	public $TimeListDateValue; // 시간 단위 날짜

	private $DB;
	private $DM;
	private $rfutil;

	Private $getCalc = 0.01;
	Private $setCalc = 100;

	/* 생성자 */
	function RainInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재 강우감지 */
	function getBsensingValue($area_code) {
		$sql = "SELECT Sensing, rain FROM rain_hist
			    WHERE area_code = '" . $area_code . "' and data_type = 'M' AND rain_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowMinTime()."'}
		        ORDER BY rain_date DESC";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			if($rs[0]['rain']>0) $this->BsenSingValue   	= "유";
			else                    $this->BsenSingValue   	= "무";
		}else{
			$this->BsenSingValue   	= NULL;
		}
		$this->DB->parseFree();
	}

	/* 십분전 강우량 */
	function getMinTimeValue($area_code) {
		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and  data_type = 'M' AND rain_date = {TS '".$this->DM->getMinTime()."'}";
		$rs = $this->DB->execute($sql);

		if ($this->DB->num_rows) {
			$this->MinTimeValue   	= round($rs[0]['RAIN']*$this->getCalc,2);
		}else{
			$this->MinTimeValue   	= "-";
		}
		$this->DB->parseFree();
	}


	/* 전시간 강우량 */
	function getBefTimeValue($area_code) {
		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and  data_type = 'H' AND rain_date = {TS '".$this->DM->getBefTime()."'}";
		$rs = $this->DB->execute($sql);

		if ($this->DB->num_rows) {
			$this->BefTimeValue   	= round($rs[0]['RAIN']*$this->getCalc,2);
		}else{
			$this->BefTimeValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 현재시간 강우량 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and data_type = 'H' AND rain_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY rain_date DESC";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowTimeValue   	= round($rs[0]['RAIN']*$this->getCalc,2);
		}else{
			$this->NowTimeValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 금일 강우량 */
	function getNowDayValue($area_code) {
		$sql = "SELECT RAIN, RAIN_DATE FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and  data_type = 'D' AND rain_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY rain_date DESC";

//echo $sql;

		$rs = $this->DB->execute($sql);

		if ($this->DB->num_rows) {
			$this->NowDayValue   	= round($rs[0]['RAIN']*$this->getCalc,2);
			$this->RainDate   		= $rs[0]['RAIN_DATE'];
		}else{
			$this->NowDayValue   	= "-";
			$this->RainDate   		= "-";
		}
		$this->DB->parseFree();
	}

	/* 전일 강우량 */
	function getBefDayValue($area_code) {
		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and  data_type = 'D' AND rain_date = {ts '".$this->DM->getBefDay()."'}
			    ORDER BY rain_date DESC";
//			    WHERE data_type = 'D' AND rain_date = {ts '2005-05-16 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->BefDayValue   	= round($rs[0]['RAIN']*$this->getCalc,2);
		}else{
			$this->BefDayValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 월간 강우량 */
	function getNowMonValue($area_code) {
		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and data_type = 'N' AND rain_date = {ts '".$this->DM->getNowMon()."'}
			    ORDER BY rain_date DESC";
//		    WHERE data_type = 'N' AND rain_date = {ts '2005-05-01 00:00:00'}

		//echo $sql."<br>";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowMonValue   	= $rs[0]['RAIN']*$this->getCalc;
		}else{
			$this->NowMonValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 년간누계 강우량 */
	function getYearSumValue($area_code) {
		$sql = "SELECT sum(RAIN) as RAIN FROM rain_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = 'H' AND rain_date Between {ts '$STAT_DATE'} and {ts '".$this->DM->getNowTime()."'}
			      ORDER BY rain_date DESC";

		$sql = "SELECT RAIN FROM rain_hist
			    WHERE  area_code = '" . $area_code . "' and data_type = 'Y' AND rain_date = {ts '".$this->DM->getNowYear()."'}
			    ORDER BY rain_date DESC";


		//echo $sql."<br>";


		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->YearSumValue   	= $rs[0]['RAIN']*$this->getCalc;
		}else{
			$this->YearSumValue   	= "-";
		}
		$this->DB->parseFree();
	}
	

	
	/* 전체지역 평균 강우량 */
	function getAvgall() {

		$sql = "SELECT SUM(RAIN) as RAIN FROM RAIN_HIST WHERE RAIN_DATE BETWEEN '".date("Y-m-d 00:00:00",time())."' AND '".date("Y-m-d 23:59:59",time())."' AND DATA_TYPE='M' GROUP BY AREA_CODE";
//		$sql = "SELECT SUM(RAIN) as RAIN FROM RAIN_HIST WHERE RAIN_DATE BETWEEN '2015-10-27 00:00:00' AND '2015-10-27 23:59:59' AND DATA_TYPE='M' GROUP BY AREA_CODE";
		//echo $sql."<br>";
/*확인쿼리*/
//SELECT B.RTU_NAME ,A.AREA_CODE, SUM(A.RAIN) FROM RAIN_HIST A ,RTU_INFO B  WHERE A.RAIN_DATE BETWEEN '2015-10-27 00:00:00' AND '2015-10-27 23:59:59' AND A.DATA_TYPE='M' AND A.AREA_CODE=B.AREA_CODE GROUP BY A.AREA_CODE;


		$rs = $this->DB->execute($sql);
		for($j=0;$j<$this->DB->num_rows;$j++){
			$SumRainValue	+= $rs[$j]['RAIN']*$this->getCalc;
//echo			$rs[$j]['RAIN']*$this->getCalc;
		}
		if($this->DB->num_rows){
			$this->SumRainValue = $SumRainValue;	//전지역 합계
		}else{
			$this->SumRainValue = "-";	//전지역 합계
		}

		$this->ACnt = $j;
		$this->DB->parseFree();
	}



	/* 기간강우 강우량 */
	function getRainListValue($area_code, $type, $startdate, $enddate) {
	$sql = "SELECT rain_date as RAIN_DATE, rain as RAIN FROM rain_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND rain_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY rain_date asc";
//echo $sql;
//exit;

		$rs = $this->DB->execute($sql);

		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->RainListValue[$i]     = $rs[$i]['RAIN']*$this->getCalc;
			$this->RainListDateValue[$i] = $rs[$i]['RAIN_DATE'];
		}

		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}
	
	/* 시간 범위 강우량 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.rain_date, '-') AS rain_date, IFNULL(b.rain, '-') AS rain, a.num 
				 FROM statistics_tmp AS a
				 LEFT JOIN (
				 SELECT * FROM rain_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' AND rain_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 ) AS b ON a.num = DATE_FORMAT(b.rain_date, '%k')
				 WHERE a.type = 'H'
				 ORDER BY a.num ASC ";
		$rs = $this->DB->execute($sql);

		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['rain'] != "-") ? $rs[$i]['rain']*$this->getCalc : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['rain_date'];
			$this->Num[$i] 				 = $rs[$i]['num'];
		}
	
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}

	/* 쿼리실행 */
	public function exe_Query($sql) {
//		echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}

}//End Class

?>