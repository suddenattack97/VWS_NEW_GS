<?
/***********************************************************
 * �� �� �� : NoticeInfo.class                               *
 * �� �� �� : 2015-11-06                                   *
 * �� �� �� : 2015-11-06                                   *
 * �� �� �� : ����ȣ                                       *
 * ��    �� : (��)ȭ��Ƽ������ ���������                  *
 * �ۼ����� : ��������(û�ֽ�)		                               *
 ***********************************************************/

Class NoticeInfo {
	
	public $NoticeDesc; //��������

	private $DB;
	private $DM;
	private $rfutil;

	/* ������ */
	function NoticeInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* �� ������ �������� ���� */
	function getNoticeData($area_code){

		$sql = "SELECT NOTICE_DESC FROM NOTICE_NEW WHERE AREA_CODE='".$area_code."'";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$this->NoticeDescValue = $rs[0]['NOTICE_DESC'];
		}else{
			$this->NoticeDescValue   	= "-";
		}
		unset($rs);
		$this->DB->parseFree();


	}



	/*��õ�� �������ý���(����)*/
/*	function getImgData(){

		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' AND END_DATE >= '".date('Y-m-d')."' LIMIT 0,1";

		$rs = $this->DB->execute($sql);
		$Row = $this->DB->num_rows;
		$this->NOTI_FILENAME = $rs[0]['FILE_DIR'];

		unset($rs);
		$this->DB->parseFree();

	}

*/
	
	/*��õ�� �������ý���*/
	function getImgData(){

//		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' AND END_DATE >= '".date('Y-m-d')."' LIMIT 0,1";
		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' AND NOTI_TYPE2='1' AND END_DATE >= '".date('Y-m-d')."' order by noti_id desc";
 		$rs = $this->DB->execute($sql);
		$Row = $this->DB->num_rows;
//		$this->NOTI_FILENAME = $rs[0]['FILE_DIR'];

		for($i=0;$i<$Row;$i++){
			if ($Row) {
				$NOTI_ID[$i] = $rs[$i]['NOTI_ID'];
				$this->NOTI_FILENAME[$i] = $rs[$i]['FILE_DIR'];

			}else{
				$this->NOTI_FILENAME = NULL;
			}
		}

		$this->imgCnt = $i;
		unset($rs);
		$this->DB->parseFree();
	}

	/*��õ�� ������ý���*/
	function getvideoData(){
		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' AND NOTI_TYPE2='2' AND END_DATE >= '".date('Y-m-d')."' order by noti_id desc";
 		$rs = $this->DB->execute($sql);
		$Row = $this->DB->num_rows;
		for($i=0;$i<$Row;$i++){
			if ($Row) {
				$NOTI_ID[$i] = $rs[$i]['NOTI_ID'];
				$this->NOTI_FILENAME[$i] = $rs[$i]['FILE_DIR2'];

			}else{
				$this->NOTI_FILENAME = NULL;
			}
		}

		$this->imgCnt = $i;
		unset($rs);
		$this->DB->parseFree();
	}



}//END CLASS



?>
