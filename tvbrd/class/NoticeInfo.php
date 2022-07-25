<?
/***********************************************************
 * 파 일 명 : NoticeInfo.class                               *
 * 작 성 일 : 2015-11-06                                   *
 * 수 정 일 : 2015-11-06                                   *
 * 작 성 자 : 음종호                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 공지사항(청주시)		                               *
 ***********************************************************/

Class NoticeInfo {
	
	public $NoticeDesc; //공지사항

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function NoticeInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 각 지역별 공지사항 내용 */
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



	/*사천시 현수막시스템(기존)*/
/*	function getImgData(){

		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' AND END_DATE >= '".date('Y-m-d')."' LIMIT 0,1";

		$rs = $this->DB->execute($sql);
		$Row = $this->DB->num_rows;
		$this->NOTI_FILENAME = $rs[0]['FILE_DIR'];

		unset($rs);
		$this->DB->parseFree();

	}

*/
	
	/*사천시 현수막시스템*/
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

	/*사천시 동영상시스템*/
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
