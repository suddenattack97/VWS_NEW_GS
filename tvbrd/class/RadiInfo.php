<?
/***********************************************************
 * �� �� �� : RadiInfo.class                               *
 * �� �� �� : 2005-07-28                                   *
 * �� �� �� : 2005-07-28                                   *
 * �� �� �� : �����                                       *
 * ��    �� : (��)ȭ��Ƽ������ ���������                  *
 * �ۼ����� : �ϻ�����  		                               *
 ***********************************************************/

Class RadiInfo {

	public $NowTimeValue;   //���� �ϻ緮

	public $SolaValue;     //���ϰ˻�

	private $DB;
	private $DM;
	private $rfutil;

	/* ������ */
	function RadiInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* ����ð� �ϻ� */
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


	/* �������� */
	public function exe_Query($sql) {
//		echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}

}//End Class

?>