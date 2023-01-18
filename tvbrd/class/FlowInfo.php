<?
/***********************************************************
 * 파 일 명 : FlowInfo.class                               *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 강우량정보		                               *
 ***********************************************************/

Class FlowInfo {

/*
	public $BefTimeValue;     //이전시간 정시수위자료
	public $BefMaxTimeValue;  //이전시간 최고
	public $BefMinTimeValue;  //현재시간 최저
	
	public $NowTimeValue;      //현재시간 수위최신자료
	public $NowMaxTimeValue;  //현재시간 최고
	public $NowMinTimeValue;  //현재시간 최저
	
	public $NowDayValue;      //금일 수위최신자료
	public $NowDayMaxeValue;  //금일 최고
	public $NowDayMinValue;   //금일 최저	

	public $FlowValueAvr;  //단일검색수위
	public $FlowValue;     //단일검색수위

	public $FlowData;	     //M자료수정
*/

  public $FlowListValue;      //기간수위
  public $FlowListDateValue;  //기간수위시간
  public $TimeListValue;	 // 시간 단위 데이터
  public $TimeListDateValue; // 시간 단위 날짜

	private $DB;
	private $DM;
	private $rfutil;
	
	Private $getCalc = 0.01;
	Private $setCalc = 100;		

	/* 생성자 */
	function FlowInfo($DB, $DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}
	
	/* 전시간 수위 */
	function getBefTimeValue($area_code) {
	
		$sql = "SELECT FLOW_AVR, FLOW_MAX, FLOW_MIN FROM FLOW_HIST
			    WHERE area_code = '" . $area_code . "' and data_type = 'H' AND flow_date = {TS '".$this->DM->getBefTime()."'}";
			    
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->BefTimeValue       = $rs[0]['FLOW_AVR']*$this->getCalc;
			$this->BefMaxTimeValue   	= $rs[0]['FLOW_MAX']*$this->getCalc;
			$this->BefMinTimeValue   	= $rs[0]['FLOW_MIN']*$this->getCalc;
		}else{
			$this->BefTimeValue   	  = "-";
			$this->BefMaxTimeValue   	= "-";			
			$this->BefMinTimeValue   	= "-";			
		}

		$this->DB->parseFree();
	}

	/* 현재시간 수위 */
	function getNowTimeValue($area_code) {
		
		$sql = "SELECT  FLOW_AVR, FLOW_MAX, FLOW_MIN  FROM FLOW_HIST
			    WHERE area_code = '" . $area_code . "' and data_type = 'M' AND flow_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY flow_date DESC";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowTimeValue   	  = $rs[0]['FLOW_AVR']*$this->getCalc;
			$this->NowMaxTimeValue   	= $rs[0]['FLOW_MAX']*$this->getCalc;
			$this->NowMinTimeValue   	= $rs[0]['FLOW_MIN']*$this->getCalc;
		}else{
			$this->NowTimeValue   	  = "-";
			$this->NowMaxTimeValue   	= "-";			
			$this->NowMinTimeValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 금일 수위 */
	function getNowDayFlowInfo($area_code) {
		
		$sql = "SELECT  FLOW_AVR, FLOW_MAX, FLOW_MIN  FROM FLOW_HIST
			    WHERE area_code = '" . $area_code . "' and data_type = 'D' AND flow_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY flow_date DESC";

		$rs = $this->DB->execute($sql);
		
		if ($this->DB->num_rows) {
			$this->NowDayValue   	    = $rs[0]['FLOW_AVR']*$this->getCalc;
			$this->NowDayMaxValue   	= $rs[0]['FLOW_MAX']*$this->getCalc;
			$this->NowDayMinValue   	= $rs[0]['FLOW_MIN']*$this->getCalc;
		}else{
			$this->NowDayValue   	    = "-";
			$this->NowDayMaxValue   	= "-";			
			$this->NowDayMinValue   	= "-";			
		}
		$this->DB->parseFree();
	}
	
	/* 기간수위 */
	function getFlowListValue($area_code, $type, $startdate, $enddate) {
	$sql = "SELECT flow_date as FLOW_DATE, flow_avr as FLOW FROM flow_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND flow_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY flow_date asc";

		$rs = $this->DB->execute($sql);
		
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->FlowListValue[$i]     = $rs[$i]['FLOW']*$this->getCalc;
			$this->FlowListDateValue[$i] = $rs[$i]['FLOW_DATE'];
		}		
		
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}	
	
	/* 시간 범위 수위량 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.flow_date, '-') AS flow_date, IFNULL(b.flow_avr, '-') AS flow_avr,
				 concat(LPAD(t1.num,2,'0'), concat(':', LPAD(t2.num,2,'0'))) as numC
				 FROM (select num from statistics_tmp where type = 'H') as t1
				 join (select num from statistics_tmp where type = 'M') as t2	
				 RIGHT JOIN (
				 SELECT * FROM flow_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' 
				 AND flow_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 order by flow_date desc
				 ) AS b 
				 ON t1.num = DATE_FORMAT(b.flow_date, '%k') 
				 AND t2.num = DATE_FORMAT(b.flow_date, '%i') 
				 group by numC
				 ORDER BY b.flow_date DESC";
		$rs = $this->DB->execute($sql);

		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['flow_avr'] != "-") ? $rs[$i]['flow_avr']*$this->getCalc : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['flow_date'];
			$this->Num[$i] 				 = $rs[$i]['numC'];
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