<?
/***********************************************************
 * 파 일 명 : AtmoInfo.class                               *
 * 작 성 일 : 2005-07-28                                   *
 * 수 정 일 : 2005-07-28                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 기압정보  		                               *
 ***********************************************************/

Class AtmoInfo {

	/*
	public $NowTimeValue;  //현재시간 기압
	public $NowDayValue;   //금일 평균기압
	public $NowDayMax;     //금일 최고기압
	public $NowDayMin;     //금일 최저기압

	public $AtmoValue;     //단일검색
	*/
	
	public $AtmoListValue;      //기간기압
  public $AtmoListDateValue;  //기간기압시간
  public $TimeListValue;	 // 시간 단위 데이터
  public $TimeListDateValue; // 시간 단위 날짜
  
  Private $getCalc = 0.01;
	Private $setCalc = 100;		    

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function AtmoInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재시간 기압 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT AVR_VAL FROM atmo_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND atmo_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY atmo_date DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND atmo_date Between {ts '2005-05-17 21:00:00'} and {ts '2005-08-12 22:59:59'}
		$rs = $this->DB->execute($sql);
		if ($this->DB->NUM_ROW()) {
 			$this->NowTimeValue   	= round($rs[0]['AVR_VAL']*$this->getCalc,1);
		}else{
			$this->NowTimeValue   	= NULL;
		}
		$this->DB->parseFree();
	}

	/* 금일 평균,최저.최고 */
	function getNowDayValue($area_code) {
		$sql = "SELECT AVR_VAL, MIN_VAL, MAX_VAL FROM atmo_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND atmo_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY atmo_date DESC";
//		    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND atmo_date = {ts '2005-05-17 00:00:00'}

		$rs = $this->DB->execute($sql);
		if($this->DB->NUM_ROW()) {
			$this->NowDayValue   	= round($rs[0]['AVR_VAL']*$this->getCalc,1);
			$this->NowDayMax    	= round($rs[0]['MIN_VAL']*$this->getCalc,1);
			$this->NowDayMin    	= round($rs[0]['MAX_VAL']*$this->getCalc,1);
		}else{
			$this->NowDayValue   	= NULL;
			$this->NowDayMax    	= NULL;
			$this->NowDayMin    	= NULL;
		}
		$this->DB->parseFree();
	}
	
/* 기간기압 */
	function getAtmoListValue($area_code, $type, $startdate, $enddate) {

		$sql = "SELECT atmo_date as ATMO_DATE, avr_val as ATMO FROM atmo_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND atmo_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY atmo_date ASC";
			      
		$rs = $this->DB->execute($sql);
		
		for($i=0; $i<$this->DB->NUM_ROW(); $i++) {
			$this->AtmoListValue[$i]      = round($rs[$i]['ATMO']*$this->getCalc,1);
			$this->AtmoListDateValue[$i]  = $rs[$i]['ATMO_DATE'];
		}
		
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}		
	/* 시간 범위 기압 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.atmo_date, '-') AS atmo_date, IFNULL(b.avr_val, '-') AS avr_val, a.num
				 FROM statistics_tmp AS a
				 LEFT JOIN (
				 SELECT * FROM atmo_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' AND atmo_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 ) AS b ON a.num = DATE_FORMAT(b.atmo_date, '%k')
				 WHERE a.type = 'H'
				 ORDER BY a.num ASC ";
		$rs = $this->DB->execute($sql);
	
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['avr_val'] == "-" || $rs[$i]['avr_val'] >= 50000 ) ? "-" : $rs[$i]['avr_val']*$this->getCalc;
			$this->TimeListDateValue[$i] = $rs[$i]['atmo_date'];
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