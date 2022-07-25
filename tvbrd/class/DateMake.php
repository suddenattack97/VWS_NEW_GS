<?
/***********************************************************
 * 파 일 명 : DateMake.class                               *
 * 작 성 일 : 2010-04-02                                   *
 * 수 정 일 : 2010-04-02                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 시간 생성 		                               *
 ***********************************************************/

Class DateMake {

	public $BefTime;  //이전시간
	public $NowTime;     //현재시간
	public $NowMinTime;  //현재시간분(한성이랑 맞추기 위해)
	public $NowDay;   //금일시간
	public $NowMon;   //금월시간
	public $NowYear;  //금년시간
	public $BefDay;   //어제시간

	/*단일검색*/
	public $StartHour; //시간시작시간
	public $EndHour;   //시간끝시간
	public $StartDay;  //일시작시간
	public $EndDay;    //일끝시간
	public $StartMon;  //월시작시간
	public $EndMon;    //월끝시간
	public $StartYear; //년시작시간
	public $EndYear;   //년끝시간
	
	public $BefOneTime; // 1시간 전
	public $BefTwoTime; // 2시간 전

	/* 생성자 */
	function DateMake() { 
	}
	
	/* 1시간 전 */
	function getBefOneTime() {
		$this->BefOneTime= date("Y-m-d H:i:s",time()-3600);
		return $this->BefOneTime;
	}	
	/* 2시간 전 */
	function getBefTwoTime() {
		$this->BefTwoTime= date("Y-m-d H:i:s",time()-3600*2);
		return $this->BefTwoTime;
	}
	/* 시간 비교 */
	function getCompare($one, $two) {
		if( strtotime($one) >= strtotime($two) ){
			$check = true;
		}else{
			$check = false;
		}
		return $check;
	}
	/* 시간 비교 */
	function getBeCompare($one, $two, $tree) {
		if( strtotime($one) <= strtotime($two) && strtotime($two) <= strtotime($tree) ){
			$check = true;
		}else{
			$check = false;
		}
		return $check;
	}

	/* 이전시간 */
	function getBefTime() {
		$this->BefTime	= date("Y-m-d H:00:00",time()-3600);
		return $this->BefTime;
	}
	
	/* 10분 */
	function getMinTime() {
		$this->MinTime	= strftime("%Y-%m-%d %H:",time()).substr(date("i"),0,1).'0:00';
		return $this->MinTime;
	}
	
	/* 10분 단위 - 2시간 */
	function getMinDisTime() {
		$this->MinDisTime = strftime("%Y-%m-%d %H:",time()-7200).substr(date("i",time()-120),0,1).'0:00';
		return $this->MinDisTime;
	}
	
	/* 현재시간 */
	function getNowTime() {
		$this->NowTime	= date("Y-m-d H:59:59",time());
		return $this->NowTime;
	}
	
 	/* 현재분 */
	function getNowMinTime() {
		$this->NowMinTime	= date("Y-m-d H:i:s",time());
		return $this->NowMinTime;
	}	

	/* 금일시간 */
	function getNowDay() {
		$this->NowDay	= date("Y-m-d 00:00:00",time());
		return $this->NowDay;
	}

	/* 금월시간 */
	function getNowMon() {
		$this->NowMon	= date("Y-m-01 00:00:00",time());
		return $this->NowMon;
	}

	/* 금년시간 */
	function getNowYear() {
		$this->NowYear	= date("Y-01-01 00:00:00",time());
		return $this->NowYear;
	}

	/* 전일시간 */
	function getBefDay() {
		$this->BefDay	= date("Y-m-d 00:00:00",time()-86400);
		return $this->BefDay;
	}

	/*
	 *단일검색
	 */
	function getStartHour($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$Day  = substr($dtime,8,2);
		$Hour  = substr($dtime,11,2);
		$this->StartHour = Date("Y-m-d H:00:00", mktime($Hour,0,0,$Mon,$Day,$Year));
		return $this->StartHour;
	}
	function getEndHour($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$Day  = substr($dtime,8,2);
		$Hour  = substr($dtime,11,2);
		$this->EndHour = Date("Y-m-d H:59:59", mktime($Hour,0,0,$Mon,$Day,$Year));
		return $this->EndHour;
	}
	function getStartDay($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$Day  = substr($dtime,8,2);
		$this->StartDay = Date("Y-m-d 00:00:00", mktime(0,0,0,$Mon,$Day,$Year));
		return $this->StartDay;
	}
	function getEndDay($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$Day  = substr($dtime,8,2);
		$this->EndDay = Date("Y-m-d 23:59:59", mktime(0,0,0,$Mon,$Day,$Year));
		return $this->EndDay;
	}
	function getStartMon($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$this->StartMon = Date("Y-m-01 00:00:00", mktime(0,0,0,$Mon,1,$Year));
		return $this->StartMon;
	}
	function getEndMon($dtime) {
		$Year = substr($dtime,0,4);
		$Mon  = substr($dtime,5,2);
		$this->EndMon = Date("Y-m-31 00:00:00", mktime(0,0,0,$Mon,1,$Year));
		return $this->EndMon;
	}
	function getStartYear($dtime) {
		$Year = substr($dtime,0,4);
		$this->StartYear = Date("Y-01-01 00:00:00", mktime(0,0,0,1,1,$Year));
		return $this->StartYear;
	}
	function getEndYear($dtime) {
		$Year = substr($dtime,0,4);
		$this->EndYear = Date("Y-12-31 00:00:00", mktime(0,0,0,1,1,$Year));
		return $this->EndYear;
	}
	
	/* 설정 이전 시간값 계산 */
	function getBefDateTime($dtime) {
		$this->BefDay	= date("Y-m-d H:00:00",time()-(3600*$dtime));
		return $this->BefDay;
	}
	
}//End Class
?>