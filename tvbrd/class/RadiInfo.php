<?
/***********************************************************
 * 파 일 명 : RadiInfo.class                               *
 * 작 성 일 : 2005-07-28                                   *
 * 수 정 일 : 2005-07-28                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 일사정보  		                               *
 ***********************************************************/

Class RadiInfo {

	public $NowTimeValue;   //현재 일사량

	public $SolaValue;     //단일검색

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function RadiInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재시간 일사 */
	function getNowTimeValue($area_code) {
		$sql = "SELECT RADIATION FROM radi_hist
			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND RADI_DATE Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowTime()."'}
//			    WHERE area_code = '" . $area_code ."' and data_type = 'M' AND RADI_DATE Between {ts '2010-08- 21:00:00'} and {ts '2005-08-12 22:59:59'}			    
		        ORDER BY RADI_DATE DESC";

		$rs = $this->DB->execute($sql);
		if ($rs->recordcount) {
			$this->NowTimeValue   	= round($rs->RADIATION*0.01,1);
		}else{
			$this->NowTimeValue   	= NULL;
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