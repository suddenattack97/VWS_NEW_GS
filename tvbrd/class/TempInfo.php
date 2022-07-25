<?
/***********************************************************
 * 파 일 명 : TempInfo.class                               *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 온도정보		                                 *
 ***********************************************************/

Class TempInfo {




	public $NowTimeValue;  //현재시간 기온

	public $NowDayValue;   //금일 평균기온
	public $NowDayMax;     //금일 최고기온
	public $NowDayMin;     //금일 최저기온

  public $NowTempValue;	 //현재온도
  public $NowTempMaxValue;	 //현재온도최고
  public $NowTempMinValue;	 //현재온도최저

	public $TempValue;     //단일검색
  public $TempListValue;      //기간온도
  public $TempListDateValue;  //기간온도시간
  public $TimeListValue;	 // 시간 단위 데이터
  public $TimeListDateValue; // 시간 단위 날짜

	private $DB;
	private $DM;
	private $rfutil;

	Private $getCalc = 0.01;
	Private $setCalc = 100;

	/* 생성자 */
	function TempInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재시간 기온 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT AVR_VAL, MIN_VAL, MAX_VAL FROM temp_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND temp_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY temp_date DESC";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowTempValue   	= round($rs[0]['AVR_VAL']*$this->getCalc,2);
			$this->NowTempMaxValue   	= round($rs[0]['MAX_VAL']*$this->getCalc,2);
			$this->NowTempMinValue   	= round($rs[0]['MIN_VAL']*$this->getCalc,2);
		}else{
			$this->NowTempValue   	= "-";
			$this->NowTempMaxValue  = "-";
			$this->NowTempMinValue  = "-";
		}
		$this->DB->parseFree();
	}

	/* 금일 평균,최저.최고 */
	function getNowDayValue($area_code) {
		$sql = "SELECT AVR_VAL, MIN_VAL, MAX_VAL FROM temp_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND temp_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY temp_date DESC";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowDayValue   	= round($rs[0]['AVR_VAL']*$this->getCalc,1);
			$this->NowDayMax    	= round($rs[0]['MAX_VAL']*$this->getCalc,1);
			$this->NowDayMin    	= round($rs[0]['MIN_VAL']*$this->getCalc,1);
		}else{
			$this->NowDayValue   	= "-";
			$this->NowDayMax    	= "-";
			$this->NowDayMin    	= "-";
		}
		$this->DB->parseFree();
	}

	/* 기간온도 */
	function getTempListValue($area_code, $type, $startdate, $enddate) {

		$sql = "SELECT temp_date as TEMP_DATE, avr_val as TEMP FROM temp_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND temp_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY temp_date ASC";

		$rs = $this->DB->execute($sql);

		for($i=0; $i<$this->DB->NUM_ROW(); $i++) {
			$this->TempListValue[$i]     = round($rs[$i]['TEMP']*$this->getCalc,1);
			$this->TempListDateValue[$i] = $rs[$i]['TEMP_DATE'];
		}

		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}
	/* 시간 범위 온도 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.temp_date, '-') AS temp_date, IFNULL(b.avr_val, '-') AS avr_val, a.num
				 FROM statistics_tmp AS a
				 LEFT JOIN (
				 SELECT * FROM temp_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' AND temp_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 ) AS b ON a.num = DATE_FORMAT(b.temp_date, '%k')
				 WHERE a.type = 'H'
				 ORDER BY a.num ASC ";
		$rs = $this->DB->execute($sql);
	
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['avr_val'] != "-") ? $rs[$i]['avr_val']*$this->getCalc : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['temp_date'];
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
