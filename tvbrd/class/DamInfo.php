<?
/***********************************************************
 * 파 일 명 : DamInfo.class                                *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : Dam 정보		                                 *
 ***********************************************************/

Class DamInfo {

	public $Waterlevel;		  //댐수위
	public $InflowVol;		  //댐유입량
	public $OutFlow_1;		  //남강방류
	public $OutFlow_2;		  //사천방류
	public $PowerGenWater;  //발전방류

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function DamInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 현재 */
	function getNowTimeValue($localcode) {
		$sql = "SELECT  Waterlevel, InflowVol, OutFlow_1, OutFlow_2, PowerGenWater, DayRain  FROM dam".$localcode."
			    WHERE btype = 'M' AND damdate Between {ts '".$this->DM->getBefTime()."'} and {ts '".$this->DM->getNowMinTime()."'}
		        ORDER BY damdate DESC";
		$rs = $this->DB->execute($sql);
		if ($rs->recordcount) {
			
			$this->Waterlevel		  = $rs->Waterlevel*0.01;
			$this->InflowVol		    = $rs->InflowVol; 
			$this->OutFlow_1		    = $rs->OutFlow_1;
			$this->OutFlow_2		    = $rs->OutFlow_2;
			$this->PowerGenWater   = $rs->PowerGenWater*0.01;
		}else{
			$this->Waterlevel		  = NULL;
			$this->InflowVol		    = NULL;
			$this->OutFlow_1		    = NULL;
			$this->OutFlow_2		    = NULL;
			$this->PowerGenWater   = NULL;
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