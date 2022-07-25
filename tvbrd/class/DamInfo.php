<?
/***********************************************************
 * �� �� �� : DamInfo.class                                *
 * �� �� �� : 2010-04-01                                   *
 * �� �� �� : 2010-04-01                                   *
 * �� �� �� : �����                                       *
 * ��    �� : (��)ȭ��Ƽ������ ���������                  *
 * �ۼ����� : Dam ����		                                 *
 ***********************************************************/

Class DamInfo {

	public $Waterlevel;		  //�����
	public $InflowVol;		  //�����Է�
	public $OutFlow_1;		  //�������
	public $OutFlow_2;		  //��õ���
	public $PowerGenWater;  //�������

	private $DB;
	private $DM;
	private $rfutil;

	/* ������ */
	function DamInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* ���� */
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

	/* �������� */
	public function exe_Query($sql) {
//		echo $sql."<br>";
		$this->DB->execute($sql);
		$this->DB->parseFree();
	}

}//End Class

?>