<?
/***********************************************************
 * 파 일 명 : SnowInfo.class                               *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 강설량정보(청주는 적설이 1000 으로 들어옴.)	                               *
 ***********************************************************/

Class SnowInfo {

  
	public $BefTimeValue;  //이전시간 정시강설자료
	public $NowTimeValue;  //현재시간 강설최신자료
	public $NowDayValue;   //금일 강설량 누계
	public $NowDayMax;     //금일 강설량 최심
	public $BefDayValue;   //전일 강설량 누계
	public $BefDayMax;     //전일 강설량 최심
	public $NowMonValue;   //금월 강설량 누계

	public $SnowValue;     //단일검색	
	
	
	public $SnowListValue;      //기간적설
  public $SnowListDateValue;  //기간적설시간
  public $TimeListValue;	 // 시간 단위 데이터
  public $TimeListDateValue; // 시간 단위 날짜
  Private $getCalc = 0.001;
	Private $setCalc = 100;		    	

	private $DB;
	private $DM;
	private $rfutil;


	/* 생성자 */
	function SnowInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}
	
	/* 전시간 강설량 */
	function getBefTimeValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'H' AND snow_date = {TS '".$this->DM->getBefTime()."'}";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->BefTimeValue   	= $rs[0]['SNOW']*0.001;
		}else{
			$this->BefTimeValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 현재시간 강설량 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'H' AND snow_date Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
		        ORDER BY snow_date DESC";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowTimeValue   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->NowTimeValue   	= "-";
		}
		$this->DB->parseFree();

	}

	/* 금일 강설량 */
	function getNowDayValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND snow_date = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY snow_date DESC";

		$rs = $this->DB->execute($sql);
		$this->getNowDay = $this->DM->getNowDay();
		if ($this->DB->num_rows) {
			$this->NowDayValue   	= round($rs[0]['SNOW']*$this->getCalc,1);
		}else{
			$this->NowDayValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 전일 강설량 */
	function getBefDayValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND snow_date = {ts '".$this->DM->getBefDay()."'}
			    ORDER BY snow_date DESC";

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->BefDayValue   	= round($rs[0]['SNOW']*0.001,1);
			
		}else{
			$this->BefDayValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 월간 강설량 */
	function getNowMonValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'N' AND snow_date = {ts '".$this->DM->getNowMon()."'}
			    ORDER BY snow_date DESC";
//			    WHERE data_type = 'N' AND snow_date = {ts '2005-05-01 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowMonValue   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->NowMonValue   	= "-";
		}
		$this->DB->parseFree();
	}

	/* 연간 강설량 */
	function getNowYearValue($area_code) {
		$sql = "SELECT SNOW FROM snow_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'Y' AND snow_date = {ts '".$this->DM->getNowYear()."'}
			    ORDER BY snow_date DESC";
//			    WHERE data_type = 'N' AND snow_date = {ts '2005-05-01 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NowYearValue   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->NowYearValue   	= "-";
		}
		$this->DB->parseFree();
	}
	
/* 기간적설*/
	function getSnowListValue($area_code, $type, $startdate, $enddate) {

		$sql = "SELECT Snow_date as SNOW_DATE, snow as SNOW FROM snow_hist
			      WHERE  area_code = '" . $area_code . "' and data_type = '".$type."' AND snow_date Between {ts '".$startdate."'} and {ts '".$enddate."'}
			      ORDER BY snow_date ASC";
			      
		$rs = $this->DB->execute($sql);
		
		for($i=0; $i<$this->DB->NUM_ROW(); $i++) {
			$this->SnowListValue[$i]      = round($rs[$i]['SNOW']*$this->getCalc,1);
			$this->SnowListDateValue[$i]  = $rs[$i]['SNOW_DATE'];
		}
		
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}



	/* 전전일적설(청주) */	
	function getSinSnowBdef($area_code){

		$sql = "SELECT MAX(SNOW) AS SNOW FROM snow_hist WHERE AREA_CODE='" . $area_code . "' AND DATA_TYPE='M' AND SNOW_DATE BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -2 DAY),'%Y-%m-%d 00:00:00') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -2 DAY),'%Y-%m-%d 23:59:59')";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->SinBDef   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->SinBDef   	= "-";	
		}
	
		$this->DB->parseFree();
	}


	/* 전일적설(청주) */
	function getSinSnowBef($area_code){
	
		$sql = "SELECT MAX(SNOW) AS SNOW FROM snow_hist WHERE AREA_CODE='" . $area_code . "' AND DATA_TYPE='M' AND SNOW_DATE BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y-%m-%d 00:00:00') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -1 DAY),'%Y-%m-%d 23:59:59')";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->SinBef   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->SinBef   	= "-";
		}
		
		$this->DB->parseFree();
	}
	
	/* 금일적설(청주) */
	function getSinSnowDay($area_code){
	
		$sql = "SELECT MAX(SNOW) AS SNOW FROM snow_hist WHERE AREA_CODE='" . $area_code . "' AND DATA_TYPE='M' AND SNOW_DATE BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d 00:00:00') AND DATE_FORMAT(NOW(),'%Y-%m-%d 23:59:59');";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->SinDay   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->SinDay   	= "-";
		}
		
		$this->DB->parseFree();
	

	}

	/* 월간적설(청주) */
	function getMonthValue($area_code){
//		$today = time();
//		$end_day = date("t", $today);
		$sql = "SELECT MAX(SNOW) AS SNOW FROM snow_hist WHERE AREA_CODE='" . $area_code . "' AND DATA_TYPE='M' AND SNOW_DATE BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01 00:00:00') AND DATE_FORMAT(NOW(),'%Y-%m-31 23:59:59')";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->Month_value   	= round($rs[0]['SNOW']*0.001,1);
		}else{
			$this->Month_value   	= "-";
		}


		$this->DB->parseFree();
	

	}
	
	/* 시간 범위 적설량 */
	function getTimeListValue($area_code, $type, $startdate, $enddate) {
		$sql = " SELECT IFNULL(b.snow_date, '-') AS snow_date, IFNULL(b.snow, '-') AS snow,
				concat(LPAD(t1.num,2,'0'), concat(':', LPAD(t2.num,2,'0'))) as numC
				FROM (select num from statistics_tmp where type = 'H') as t1
				join (select num from statistics_tmp where type = 'M') as t2
				RIGHT JOIN (
				 SELECT * FROM snow_hist
				 WHERE area_code = '" . $area_code . "' AND data_type = '".$type."' 
				 AND snow_date BETWEEN {ts '".$startdate."'} AND {ts '".$enddate."'}
				 order by snow_date desc
				 ) AS b 
				 ON t1.num = DATE_FORMAT(b.snow_date, '%k') 
				 AND t2.num = DATE_FORMAT(b.snow_date, '%i') 
				 group by numC
				 ORDER BY b.snow_date DESC ";
		$rs = $this->DB->execute($sql);
	
		for($i=0; $i<$this->DB->NUM_ROW(); $i++){
			$this->TimeListValue[$i]     = ($rs[$i]['snow'] != "-") ? $rs[$i]['snow']*$this->getCalc : "-";
			$this->TimeListDateValue[$i] = $rs[$i]['snow_date'];
			$this->Num[$i] 				 = $rs[$i]['numC'];
		}
	
		unset($rs);
		$this->rsCnt = $i;
		$this->DB->parseFree();
	}
	
	/* 쿼리실행 */
	public function exe_Query($sql) {
	//echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}
}//End Class

?>