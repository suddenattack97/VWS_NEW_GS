<?
Class AlarmInfo {
	// 방송 지역 리스트
	public $TREE_PATH;
	public $GROUP_ID;
	public $ORGAN_ID;
	public $ORGAN_NAME;
	public $GROUP_NAME;
	public $RTU_ID;
	public $RTU_NAME;
	public $AREA_CODE;
	public $PARENT_ID;
	public $TREE_DEPTH;
	public $USER_RIGHT_X;
	public $G_GROUP_ID;
	public $G_RTU_CNT;
	// 방송 내용 리스트
	public $S_SCRIPT_NO;
	public $S_OWN_TYPE;
	public $S_ORGAN_ID;
	public $S_USER_ID;
	public $S_SCRIPT_UNIT_NAME;
	public $S_SCRIPT_UNIT;
	public $S_SECTION_NO;
	public $S_SECTION_NAME;
	public $S_SCRIPT_TITLE;
	public $S_CHIME_START_NO;
	public $S_CHIME_START_CNT;
	public $S_CHIME_END_NO;
	public $S_CHIME_END_CNT;
	public $S_SCRIPT_BODY;
	public $S_SCRIPT_BODY_CNT;
	public $S_SCRIPT_RECORD_FILE;
	public $S_SCRIPT_TIMESTAMP;
	public $S_TRANS_VOLUME;
	// 방송 구분 셀렉트
	public $SE_SECTION_NO;
	public $SE_SECTION_NAME;
	// 효과음 셀렉트
	public $CH_CHIME_NO;
	public $CH_CHIME_NAME;
	// 긴급방송등록 리스트
	public $EM_ID;
	public $EM_NAME;
	public $EM_SCRIPT_NO;
	public $EM_SORT;
	// 긴급방송시 스크립트 번호 체크
	public $EM_NO;
	// 방송 로그 번호
	public $LOG_NO;
	
	private $DB;
	private $DM;
	private $rfutil;
	
	function AlarmInfo($DB, $DateMake, $rfutil=null) {
		$this->DB = $DB;
		$this->DM = $DateMake;
		$this->rfutil = $rfutil;
	}
	
	// 방송 지역 리스트
	function getAlarmRtuInfo(){
		$SQL.= "SELECT	* 																				";
		$SQL.= "FROM 																					";
		$SQL.= "(																						";
		$SQL.= "	SELECT	ORGAN_ID, TREE_DEPTH, GROUP_ID, GROUP_NAME, 								";
		$SQL.= "			0 RTU_ID, 0 RTU_NAME, AREA_CODE, PARENT_ID, TREE_PATH, 						";
		$SQL.= "			0 SORT_FLAG																	";
		$SQL.= "	FROM	GROUP_INFO  																";
		// 		$SQL.= "	WHERE	 ORGAN_ID='".CK_ORGAN_ID."'	  												";
		$SQL.= "	UNION 	/*------------------------------------------------------------------------*/";
		$SQL.= "	SELECT	A.ORGAN_ID, A.TREE_DEPTH, A.GROUP_ID, A.GROUP_NAME, 						";
		$SQL.= "			IFNULL(B.RTU_ID,0) RTU_ID, B.RTU_NAME, B.AREA_CODE, 0 PARENT_ID, TREE_PATH, ";
		$SQL.= "			B.SORT_FLAG																	";
		if($_COOKIE['keyTosRtuID']){ // 쿠키 값에 따른 방송 장비 표시 제한
			$SQL.= "	FROM	GROUP_INFO A, (SELECT * FROM RTU_INFO WHERE rtu_id IN (".$_COOKIE['keyTosRtuID'].")) B, RTU_GROUP C ";
		}else{
		$SQL.= "	FROM	GROUP_INFO A, RTU_INFO B, RTU_GROUP C										";
		}
		//$SQL.= "	WHERE	A.ORGAN_ID=B.ORGAN_ID AND A.GROUP_ID=B.GROUP_ID								";
		// 			$SQL.= "	WHERE	C.ORGAN_ID='".CK_ORGAN_ID."' AND A.GROUP_ID=C.GROUP_ID AND B.RTU_ID=C.RTU_ID";
		$SQL.= "	WHERE	A.GROUP_ID=C.GROUP_ID AND B.RTU_ID=C.RTU_ID";
		$SQL.= "			AND A.ORGAN_ID=B.ORGAN_ID													";
		// 			if(CK_TOS_RTU_ID!=''){
		// 				$SQL.= "			AND A.GROUP_ID IN															";
		// 				$SQL.= "			(SELECT GROUP_ID FROM RTU_GROUP WHERE RTU_ID IN (".CK_TOS_RTU_ID.") )		";
		// 			}
		//$SQL.= "			AND B.RTU_TYPE = 'B00'														";
		$SQL.= "			AND B.RTU_TYPE like 'B%'													";
		$SQL.= "	ORDER	BY TREE_PATH, SORT_FLAG														";
		//$SQL.= "	ORDER	BY TREE_PATH, B.".CK_SORT_COLUMN."											";
		/*----------------------------------------------------------------------------------------------*/
		$SQL.= ") A LEFT JOIN 																			";
		$SQL.= "(																						";
		$SQL.= "	SELECT	RTU_ID USER_RTU, '1' USER_RIGHT_X 											";
		//$SQL.= "	FROM	USER_RIGHT 																	";
		//$SQL.= "	WHERE	USER_ID='".CK_USER_ID."'													";
		$SQL.= "	FROM	RTU_INFO 																	";
		//$SQL.= "	WHERE	ORGAN_ID='".CK_ORGAN_ID."' AND RTU_TYPE = 'B00'								";
		// 		$SQL.= "	WHERE	ORGAN_ID='".CK_ORGAN_ID."' AND RTU_TYPE IN ('B00', 'BD0')					";
		$SQL.= "	WHERE	RTU_TYPE IN ('B00', 'BD0')					";
		if($_COOKIE['keyTosRtuID']){ // 쿠키 값에 따른 방송 장비 표시 제한
			$SQL.= " AND rtu_id IN (".$_COOKIE['keyTosRtuID'].") ";
		}
		// 		if(CK_TOS_RTU_ID!=''){
		// 			$SQL.= "			AND RTU_ID IN (".CK_TOS_RTU_ID.")											";
		// 		}
		// 		$SQL.= "	ORDER	BY ".CK_SORT_COLUMN;
		$SQL.= "	ORDER	BY SORT_FLAG";
		$SQL.= ") B 																					";
		$SQL.= "ON A.RTU_ID=B.USER_RTU																	";

		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->TREE_PATH[$i] = $row['TREE_PATH'];
				$this->GROUP_ID[$i] = $row['GROUP_ID'];
				$this->ORGAN_ID[$i] = $row['ORGAN_ID'];
				$this->ORGAN_NAME[$i] = $row['ORGAN_NAME'];
				$this->GROUP_NAME[$i] = $row['GROUP_NAME'];
				$this->RTU_ID[$i] = $row['RTU_ID'];
				$this->RTU_NAME[$i] = $row['RTU_NAME'];
				$this->AREA_CODE[$i] = $row['AREA_CODE'];
				$this->PARENT_ID[$i] = $row['PARENT_ID'];
				$this->TREE_DEPTH[$i] = $row['TREE_DEPTH'];
				/*
				 * USER_TYPE	0:최상위관리1:지역최상위관리2:지역관리3:일반사용자
				 */
				if(CK_USER_TYPE != '0'){
					$this->USER_RIGHT_X[$i] = $row['USER_RIGHT_X'];
				}else{
					$this->USER_RIGHT_X[$i] = '1';
				}
				$i++;
			}
		}
		
		$SQL = " SELECT G.GROUP_ID, COUNT(G.RTU_ID) RTU_CNT
				 FROM RTU_INFO I, RTU_GROUP G
				 WHERE I.RTU_TYPE like 'B%' ";
		if($_COOKIE['keyTosRtuID']){
			$SQL .= " AND I.RTU_ID IN (".$_COOKIE['keyTosRtuID'].") "; // 쿠키 값에 따른 방송 장비 표시 제한
		}
		$SQL .=  " AND I.RTU_ID=G.RTU_ID GROUP BY G.GROUP_ID ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->G_GROUP_ID[$i] = $row['GROUP_ID'];
				$this->G_RTU_CNT[$i] = $row['RTU_CNT'];
				$i++;
			}
		}
	}
	
	// 방송 내용 리스트
	function getAlarmScriptInfo(){
		$SQL = " SELECT	*
				 FROM BROADCAST_SCRIPT A
				 LEFT JOIN BROADCAST_SECTION B ON A.SECTION_NO = B.SECTION_NO
				 ORDER BY SCRIPT_SORT ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->S_SCRIPT_NO[$i] = $row['SCRIPT_NO'];
				$this->S_OWN_TYPE[$i] = $row['OWN_TYPE'];
				$this->S_ORGAN_ID[$i] = $row['ORGAN_ID'];
				$this->S_USER_ID[$i] = $row['USER_ID'];
				if($row['SCRIPT_UNIT'] == "T"){
					$SCRIPT_UNIT_STR = "문자";
				}else if($row['SCRIPT_UNIT'] == "R"){
					$SCRIPT_UNIT_STR = "음성";
				}else{ // M
					$SCRIPT_UNIT_STR = "녹음";
				}
				$this->S_SCRIPT_UNIT_NAME[$i] = $SCRIPT_UNIT_STR;
				$this->S_SCRIPT_UNIT[$i] = $row['SCRIPT_UNIT'];
				$this->S_SECTION_NO[$i] = $row['SECTION_NO'];
				$this->S_SECTION_NAME[$i] = $row['SECTION_NAME'];
				
				$this->S_SCRIPT_TITLE[$i] = $row['SCRIPT_TITLE'];
				$this->S_CHIME_START_NO[$i] = $row['CHIME_START_NO'];
				$this->S_CHIME_START_CNT[$i] = $row['CHIME_START_CNT'];
				$this->S_CHIME_END_NO[$i] = $row['CHIME_END_NO'];
				$this->S_CHIME_END_CNT[$i] = $row['CHIME_END_CNT'];
				$this->S_SCRIPT_BODY[$i] = $row['SCRIPT_BODY'];
				$this->S_SCRIPT_BODY_CNT[$i] = $row['SCRIPT_BODY_CNT'];
				$this->S_SCRIPT_RECORD_FILE[$i] = $row['SCRIPT_RECORD_FILE'];
				$this->S_SCRIPT_TIMESTAMP[$i] = $row['SCRIPT_TIMESTAMP'];
				$this->S_TRANS_VOLUME[$i] = $row['TRANS_VOLUME'];
				$i++;
			}
		}
	}
	
	// 방송 구분 셀렉트
	function getSectionInfo(){
		$SQL = " SELECT * FROM BROADCAST_SECTION ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->SE_SECTION_NO[$i] = $row['SECTION_NO'];
				$this->SE_SECTION_NAME[$i] = $row['SECTION_NAME'];
				$i++;
			}
		}
	}
	
	// 효과음 셀렉트
	function getChimeInfo(){
		$SQL = " SELECT * FROM CHIME_INFO ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->CH_CHIME_NO[$i] = $row['CHIME_NO'];
				$this->CH_CHIME_NAME[$i] = $row['CHIME_NAME'];
				$i++;
			}
		}
	}
	
	// 긴급방송 리스트
	function getEmerInfo(){
		$SQL = " SELECT * FROM wr_alarm_emer ORDER BY sort ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$i = 0;
			foreach($rs as $key => $row){
				$this->EM_ID[$i] = $row['id'];
				$this->EM_NAME[$i] = $row['name'];
				$this->EM_SCRIPT_NO[$i] = $row['script_no'];
				$this->EM_SORT[$i] = $row['sort'];
				$i++;
			}
		}
	}
	
	// 긴급방송 스크립트
	function getEmerScript(){
		$EMER_ID = $_REQUEST["id"];
		
		$SQL = " SELECT * FROM wr_alarm_emer WHERE id = '".$EMER_ID."' LIMIT 1 ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		$EMER_NO = $rs[0]['script_no'];
		$this->EM_NO = $EMER_NO;
		
		$SQL = " SELECT	*
				 FROM rtu_info
				 WHERE rtu_type like 'B%' ";
		if($_COOKIE['keyTosRtuID']){ // 쿠키 값에 따른 방송 장비 표시 제한
			$SQL .= " AND rtu_id IN (".$_COOKIE['keyTosRtuID'].") "; 
		}
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		if($rs){
			$rtu_cnt = 0;
			foreach($rs as $key => $row){
				if($key == 0){
					$_REQUEST["STR_RTU_ID"] .= $row['RTU_ID'];
				}else{
					$_REQUEST["STR_RTU_ID"] .= "-".$row['RTU_ID'];
				}
				$rtu_cnt++;
			}
		}
		
		$SQL = " SELECT	*
				 FROM BROADCAST_SCRIPT A
				 LEFT JOIN BROADCAST_SECTION B ON A.SECTION_NO = B.SECTION_NO
				 WHERE script_no = '".$EMER_NO."' LIMIT 1 ";
		$rs = $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		$_REQUEST["USER_ID"] = $rs[0]['USER_ID'];
		$_REQUEST["RTU_CNT"] = $rtu_cnt;
		$_REQUEST["PLAN_NO"] = null;
		$_REQUEST["IS_PLAN"] = "0";
		$_REQUEST["SCRIPT_NO"] = $rs[0]['SCRIPT_NO'];
		$_REQUEST["SCRIPT_TYPE"] = "1";
		$_REQUEST["SCRIPT_UNIT"] = $rs[0]['SCRIPT_UNIT'];
		$_REQUEST["SECTION_NO"] = $rs[0]['SECTION_NO'];
		$_REQUEST["SCRIPT_TITLE"] = $rs[0]['SCRIPT_TITLE'];
		$_REQUEST["CHIME_START_NO"] = $rs[0]['CHIME_START_NO'];
		$_REQUEST["CHIME_START_CNT"] = $rs[0]['CHIME_START_CNT'];
		$_REQUEST["CHIME_END_NO"] = $rs[0]['CHIME_END_NO'];
		$_REQUEST["CHIME_END_CNT"] = $rs[0]['CHIME_END_CNT'];
		$_REQUEST["SCRIPT_BODY"] = $rs[0]['SCRIPT_BODY'];
		$_REQUEST["SCRIPT_BODY_CNT"] = $rs[0]['SCRIPT_BODY_CNT'];
		$_REQUEST["SCRIPT_RECORD_FILE"] = $rs[0]['SCRIPT_RECORD_FILE'];
		$_REQUEST["SCRIPT_TIMESTAMP"] = $rs[0]['SCRIPT_TIMESTAMP'];
		$_REQUEST["TRANS_VOLUME"] = $rs[0]['TRANS_VOLUME'];
	}
	
// 방송 로그 저장 1
function setBroadcastLogIn(){

	$sql = " SELECT NOW() as log_date";
	$rs = $this->DB->execute($sql);
	$this->DB->parseFree();

	$log_date = $this->log_date = $rs[0]['log_date'];

	$valid =
	$this->log_date = substr($rs[0]['log_date'], 0, 4)+		// 년
	$this->log_date = substr($rs[0]['log_date'], 5, 2)+		// 월
	$this->log_date = substr($rs[0]['log_date'], 8, 2)+    // 날
	$this->log_date = substr($rs[0]['log_date'], 11, 2)+  // 시
	$this->log_date = substr($rs[0]['log_date'], 14, 2)+ //분
	$this->log_date = substr($rs[0]['log_date'], 17, 2); //초

	$SQL = " SELECT IFNULL( MAX(LOG_NO)+1, 1 ) AS max_id FROM BROADCAST_LOG ";
	$rs = $this->DB->execute($SQL);
	$this->DB->rs_unset();
	$this->LOG_NO = $rs[0]['max_id'];
	
	$SQL = " INSERT INTO BROADCAST_LOG ";
	$SQL.= " ( ";
	if($_REQUEST["USER_ID"]!='') {$SQL.= " USER_ID, ";}
	if($_REQUEST["RTU_CNT"]!='') {$SQL.= " RTU_CNT, ";}
	if($_REQUEST["PLAN_NO"]!='') {$SQL.= " PLAN_NO, ";}
	if($_REQUEST["IS_PLAN"]!='') {$SQL.= " IS_PLAN, ";}
	if($_REQUEST["SCRIPT_NO"]!='') {$SQL.= " SCRIPT_NO, ";}
	if($_REQUEST["SCRIPT_TYPE"]!='') {$SQL.= " SCRIPT_TYPE, ";}
	if($_REQUEST["SCRIPT_UNIT"]!='') {$SQL.= " SCRIPT_UNIT, ";}
	if($_REQUEST["SECTION_NO"]!='') {$SQL.= " SECTION_NO, ";}
	if($_REQUEST["SCRIPT_TITLE"]!='') {$SQL.= " SCRIPT_TITLE, ";}
	if($_REQUEST["CHIME_START_NO"]!='') {$SQL.= " CHIME_START_NO, ";}
	if($_REQUEST["CHIME_START_CNT"]!='') {$SQL.= " CHIME_START_CNT, ";}
	if($_REQUEST["CHIME_END_NO"]!='') {$SQL.= " CHIME_END_NO, ";}
	if($_REQUEST["CHIME_END_CNT"]!='') {$SQL.= " CHIME_END_CNT, ";}
	if($_REQUEST["SCRIPT_BODY"]!='') {$SQL.= " SCRIPT_BODY, ";}
	if($_REQUEST["SCRIPT_BODY_CNT"]!='') {$SQL.= " SCRIPT_BODY_CNT, ";}
	if($_REQUEST["SCRIPT_RECORD_FILE"]!='') {$SQL.= " SCRIPT_RECORD_FILE, ";}
	if($_REQUEST["SCRIPT_TIMESTAMP"]!='') {$SQL.= " SCRIPT_TIMESTAMP, ";}
	if($_REQUEST["TRANS_VOLUME"]!='') {$SQL.= " TRANS_VOLUME, ";}
	$SQL.= " LOG_TYPE, ";
	if($_REQUEST["SCRIPT_UNIT"]=='M' && $_REQUEST["SCRIPT_NO"]!='') {$SQL.= " SCRIPT_PLAY_SECONDS, ";}
	$SQL.= " LOG_DATE, ";
	$SQL.= " ORGAN_ID, ";
	//$SQL.= " BROAD_IP, "; // 없는 곳도 있음
	$SQL.= " LOG_NO, ";
	$SQL.= " VALID ";
	$SQL.= " ) ";
	$SQL.= " VALUES ";
	$SQL.= " ( ";
	if($_REQUEST["USER_ID"]!='') {$SQL.= " '".$_REQUEST["USER_ID"]."', ";}
	if($_REQUEST["RTU_CNT"]!='') {$SQL.= " '".$_REQUEST["RTU_CNT"]."', ";}
	if($_REQUEST["PLAN_NO"]!='') {$SQL.= " '".$_REQUEST["PLAN_NO"]."', ";}
	if($_REQUEST["IS_PLAN"]!='') {$SQL.= " '".$_REQUEST["IS_PLAN"]."', ";}
	if($_REQUEST["SCRIPT_NO"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_NO"]."', ";}
	if($_REQUEST["SCRIPT_TYPE"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_TYPE"]."', ";}
	if($_REQUEST["SCRIPT_UNIT"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_UNIT"]."', ";}
	if($_REQUEST["SECTION_NO"]!='') {$SQL.= " '".$_REQUEST["SECTION_NO"]."', ";}
	if($_REQUEST["SCRIPT_TITLE"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_TITLE"]."', ";}
	if($_REQUEST["CHIME_START_NO"]!='') {$SQL.= " '".$_REQUEST["CHIME_START_NO"]."', ";}
	if($_REQUEST["CHIME_START_CNT"]!='') {$SQL.= " '".$_REQUEST["CHIME_START_CNT"]."', ";}
	if($_REQUEST["CHIME_END_NO"]!='') {$SQL.= " '".$_REQUEST["CHIME_END_NO"]."', ";}
	if($_REQUEST["CHIME_END_CNT"]!='') {$SQL.= " '".$_REQUEST["CHIME_END_CNT"]."', ";}
	if($_REQUEST["SCRIPT_BODY"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_BODY"]."', ";}
	if($_REQUEST["SCRIPT_BODY_CNT"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_BODY_CNT"]."', ";}
	if($_REQUEST["SCRIPT_RECORD_FILE"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_RECORD_FILE"]."', ";}
	if($_REQUEST["SCRIPT_TIMESTAMP"]!='') {$SQL.= " '".$_REQUEST["SCRIPT_TIMESTAMP"]."', ";}
	if($_REQUEST["TRANS_VOLUME"]!='') {$SQL.= " '".$_REQUEST["TRANS_VOLUME"]."', ";}
	$SQL.= " '0', ";
	if($_REQUEST["SCRIPT_UNIT"]=='M' && $_REQUEST["SCRIPT_NO"]!=''){
		$SQL.= " (SELECT SCRIPT_PLAY_SECONDS FROM BROADCAST_SCRIPT WHERE SCRIPT_NO='".$_REQUEST["SCRIPT_NO"]."'), ";
	}
	$SQL.= " NOW(), ";
	$SQL.= " (SELECT ORGAN_ID FROM ORGAN_INFO LIMIT 1), ";
	//$SQL.= " '".$_SERVER['REMOTE_ADDR']."', "; // 없는 곳도 있음
	$SQL.= $this->LOG_NO;

	$tmpvalid = $this->LOG_NO + $valid + 32956;
	$valid = md5($tmpvalid);

	$SQL .= " , '".$valid."' ";
	$SQL.= " ) ";

	$rs = $this->DB->queryone($SQL);
	$this->DB->parseFree();
	return $rs;
}
	// 방송 로그 저장 2
	function setRtuLogIn(){
		$ARR_RTU_ID = explode("-", $_REQUEST["STR_RTU_ID"]);
		$SQL = " INSERT INTO RTU_LOG (LOG_NO, RTU_ID, TRANS_START, TRANS_CHECK) VALUES ";
		for($i = 0; $i < count($ARR_RTU_ID); $i++) {
			if($i != 0) $SQL.= " , ";
			$SQL.= " ( ".$this->LOG_NO.", ".$ARR_RTU_ID[$i].", NOW(), NOW() ) ";
		}
		$rs = $this->DB->queryone($SQL);
		$this->DB->parseFree();
		return $rs;
	}
	// 방송 내용 순서 변경
	function setScriptSort(){
		$arr_sort = $_REQUEST["arr_sort"];
		if($arr_sort){
			foreach($arr_sort as $key => $row){
				$SQL = " UPDATE BROADCAST_SCRIPT SET SCRIPT_SORT = '".$key."' WHERE SCRIPT_NO = '".$row."' ";
				$rs = $this->DB->queryone($SQL);
				$this->DB->parseFree();
			}
		}
		return $rs;
	}
	// 긴급방송 등록
	function setEmerIn(){
		$EMER_text = $_REQUEST["text"];
		$EMER_no = $_REQUEST["no"];
		
		$SQL = " SELECT IFNULL(COUNT(*), 0) AS cnt FROM wr_alarm_emer WHERE script_no = ".$EMER_no." ";
		$rs1= $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		$msg = 0;
		if($rs1[0]['cnt'] == 0){
			$SQL = " INSERT INTO wr_alarm_emer (name, script_no, sort) VALUES ('".$EMER_text."', ".$EMER_no.", null) ";
			$rs2 = $this->DB->queryone($SQL);
			$this->DB->parseFree();
			($rs2) ? $msg = 1 : $msg = 2; // 1: 성공, 2: 오류
		}else{
			$msg = 3; // 3: 중복
		}
		return $msg;
	}
	// 긴급방송 삭제
	function setEmerDe(){
		$EMER_id= $_REQUEST["id"];
		
		$SQL = " SELECT IFNULL(COUNT(*), 0) AS cnt FROM wr_alarm_emer WHERE id = ".$EMER_id." ";
		$rs1= $this->DB->execute($SQL);
		$this->DB->rs_unset();
		
		$msg = 0;
		if($rs1[0]['cnt'] != 0){
			$SQL = " DELETE FROM wr_alarm_emer WHERE id = '".$EMER_id."' ";
			$rs2 = $this->DB->queryone($SQL);
			$this->DB->parseFree();
			($rs2) ? $msg = 1 : $msg = 2; // 1: 성공, 2: 오류
		}else{
			$msg = 3; // 3: 해당 긴급방송 버튼이 없음
		}
		return $msg;
	}
	// 긴급방송 변경 > 미사용
	function setEmerUp(){
		$EMER_ID = $_REQUEST["id"];
		$EMER_NO = $_REQUEST["no"];
		$SQL = " UPDATE wr_alarm_emer SET script_no = '".$EMER_NO."' WHERE id = '".$EMER_ID."' ";
		$rs = $this->DB->queryone($SQL);
		$this->DB->parseFree();
		return $rs;
	}
	// 긴급방송 순서 변경 > 미사용
	function setEmerSort(){
		$arr_sort = $_REQUEST["arr_sort"];
		if($arr_sort){
			foreach($arr_sort as $key => $row){
				$SQL = " UPDATE wr_alarm_emer SET SORT = '".$key."' WHERE id = '".$row."' ";
				$rs = $this->DB->queryone($SQL);
				$this->DB->parseFree();
			}
		}
		return $rs;
	}
} // Class end
?>

