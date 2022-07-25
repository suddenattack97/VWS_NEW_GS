<?
/***********************************************************
 * 파 일 명 : SunsInfo.class                               *
 * 작 성 일 : 2005-07-28                                   *
 * 수 정 일 : 2005-07-28                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 일조정보  		                               *
 ***********************************************************/

Class SunsInfo {

	public $NowDayValue;	//금일 일조시간

	public $ShinValue;     //단일검색

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function SunsInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 금일 일조시간 */
	function getNowDayValue($area_code) {
		$sql = "SELECT SUNSHINE FROM suns_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND SUNS_DATE = {ts '".$this->DM->getNowDay()."'}
			    ORDER BY SUNS_DATE DESC";
//			    WHERE area_code = '" . $area_code ."' and data_type = 'D' AND SUNS_DATE = {ts '2005-05-17 00:00:00'}

		$rs = $this->DB->execute($sql);
		if ($rs->recordcount) {
			$this->NowDayValue   	= $this->HourConv($rs->SUNSHINE)*0.01;
		}else{
			$this->NowDayValue   	= NULL;
		}
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