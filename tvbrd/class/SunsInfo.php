<?
/***********************************************************
 * �� �� �� : SunsInfo.class                               *
 * �� �� �� : 2005-07-28                                   *
 * �� �� �� : 2005-07-28                                   *
 * �� �� �� : �����                                       *
 * ��    �� : (��)ȭ��Ƽ������ ���������                  *
 * �ۼ����� : ��������  		                               *
 ***********************************************************/

Class SunsInfo {

	public $NowDayValue;	//���� �����ð�

	public $ShinValue;     //���ϰ˻�

	private $DB;
	private $DM;
	private $rfutil;

	/* ������ */
	function SunsInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* ���� �����ð� */
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


	/* �������� */
	public function exe_Query($sql) {
//		echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}

}//End Class

?>