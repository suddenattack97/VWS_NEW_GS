<?
/***********************************************************
 * 파 일 명 : HumiInfo.class                               *
 * 작 성 일 : 2005-07-28                                   *
 * 수 정 일 : 2005-07-28                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이  기술연구소                 *
 * 작성목적 : 습도 클래스		                               *
 ***********************************************************/

Class HumiInfo {

	public $NowTimeValue;  //현재시간 습도
	public $NowDayValue;   //금일 평균습도
	public $NowDayMax;     //금일 최고습도
	public $NowDayMin;     //금일 최저습도
	public $HumiValue;     //단일검색
	public $HumiListValue;      //기간습도
  public $HumiListDateValue;  //기간습도시간
  public $TimeListValue;	 // 시간 단위 데이터
  public $TimeListDateValue; // 시간 단위 날짜

  Private $getCalc = 0.01;
	Private $setCalc = 100;

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function HumiInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재시간 습도 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT AVR_VAL FROM humi_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND humi_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY humi_date DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND humi_date Between {ts '2005-05-17 21:00:00'} and {ts '2005-08-12 22:59:59'}
		$rs = $this->DB->execute($sql);

		if ($this->DB->num_rows) {
			$this->NowTimeValue   	= $rs[0]['AVR_VAL']*$this->getCalc;
		}else{
			$this->NowTimeValue   	= NULL;
		}
		$this->DB->parseFree();
	}

	/* 금일 평균,최저.최고 */
	function getNowDayValue($area_code) {
		$sql = "SELECT AVR_VAL, MAX_VAL, MIN_VAL FROM humi_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND humi_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY humi_date DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND humi_date = {ts '2005-05-17 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowDayValue   	= $rs[0]['AVR_VAL']*$this->getCalc;
			$this->NowDayMax    	= $rs[0]['MAX_VAL']*$this->getCalc;
			$this->NowDayMin    	= $rs[0]['MIN_VAL']*$this->getCalc;
		}else{
			$this->NowDayValue   	= NULL;
			$this->NowDayMax    	= NULL;
			$this->NowDayMin    	= NULL;
		}
		$this->DB->parseFree();
	}

	/* 기간습도 */
	function getHumiListValue($area_code, $type, $startdate, $enddate) {

		$sql = "SELECT humi_date as HUMI_DATE, avr_val as HUMI FROM humi_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND humi_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY humi_date ASC";

		$rs = $this->DB->execute($sql);

		for($i=0; $i<$this->DB->NUM_ROW(); $i++) {
			$this->HumiListValue[$i]      = round($rs[$i]['HUMI']*$this->getCalc,1);
			$this->HumiListDateValue[$i]  = $rs[$i]['HUMI_DATE'];
		}

		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}
	/* 시간 범위 습도 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.humi_date, '-') AS humi_date, IFNULL(b.avr_val, '-') AS avr_val, a.num
				 FROM statistics_tmp AS a
				 LEFT JOIN (
				 SELECT * FROM humi_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' AND humi_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 ) AS b ON a.num = DATE_FORMAT(b.humi_date, '%k')
				 WHERE a.type = 'H'
				 ORDER BY a.num ASC ";
		$rs = $this->DB->execute($sql);
	
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['avr_val'] != "-") ? $rs[$i]['avr_val']*$this->getCalc : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['humi_date'];
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