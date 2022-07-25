<?
/***********************************************************
 * 파 일 명 : ImgInfo.class                               *
 * 작 성 일 : 2016-02-29                                   *
 * 수 정 일 : 2016-02-29                                   *
 * 작 성 자 : 음종호                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 사천시(현수막Img 클래스)		                               *
 ***********************************************************/

Class ImageInfo {
	
	public $NOTI_FILENAME; 

	private $DB;
	private $DM;
	private $rfutil;

	/* 생성자 */
	function ImageInfo($DB,$DateMake,$rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}

	/* 각 지역별 공지사항 내용 */
	function getImgData(){

		$sql = "SELECT * FROM NOTICE WHERE NOTI_TYPE='01' LIMIT 0,1";
		$rs = $this->DB->execute($sql);
		if ($this->DB->num_rows) {
			$NOTI_ID = $rs[0]['NOTI_ID'];
			$NOTI_NAME = $rs[0]['FILE_NAME'];
			$this->NOTI_FILENAME = $NOTI_ID."_".$NOTI_NAME;
		}else{
			$this->NOTI_FILENAME   	= NULL;
		}
		unset($rs);
		$this->DB->parseFree();

	}

}//END CLASS


?>