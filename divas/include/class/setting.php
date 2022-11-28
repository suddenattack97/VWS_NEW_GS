<?
Class ClassSetting {

	private $DB;

	function ClassSetting($DB){
		$this->DB = $DB;
	}
	
	/**
	 *   행정구역 전체 개수
	 */
	function getAreaTotal(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM AREA_INFO ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsAreaTotal = $rs[0]['CNT'];
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   행정구역 검색 개수
	 */
	function getAreaCnt(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM AREA_INFO ";
			if($this->DB->html_encode($_REQUEST['search']['value']) != ""){
				$sql.= " WHERE AREA_CODE LIKE '%".$this->DB->html_encode($_REQUEST['search']['value'])."%' OR
						 CONCAT(SIDO,' ',GUGUN,' ',DONG,' ',LI) LIKE '%".$this->DB->html_encode($_REQUEST['search']['value'])."%' ";
			}
			
			$rs = $this->DB->execute($sql);
			
			$this->rsAreaCnt = $rs[0]['CNT'];
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   행정구역 조회
	 */
	function getAreaInfo(){
		if(DB == "0"){
			$SEARCH = explode(" ", $this->DB->html_encode($_REQUEST['search']['value']));
			
			$sql = " SELECT * FROM AREA_INFO ";
			if($this->DB->html_encode($_REQUEST['search']['value']) != ""){
				$sql.= " WHERE AREA_CODE LIKE '%".$this->DB->html_encode($_REQUEST['search']['value'])."%' OR
						 CONCAT(SIDO,' ',GUGUN,' ',DONG,' ',LI) LIKE '%".$this->DB->html_encode($_REQUEST['search']['value'])."%' ";
			}
			$sql.= " ORDER BY AREA_CODE
					 LIMIT ".$this->DB->html_encode($_REQUEST['start']).", ".$this->DB->html_encode($_REQUEST['length'])." ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['NUM'] = $i + 1;
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['TEXT'] = $rs[$i]['SIDO']." ".$rs[$i]['GUGUN']." ".$rs[$i]['DONG']." ".$rs[$i]['LI'];
			}
			$this->rsAreaInfo = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 조회
	 */
	function getOrganList(){
		if(DB == "0"){
			$sql = " SELECT * FROM ORGAN_INFO
					 ORDER BY ORGAN_ID ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['ORGAN_ID'] = $rs[$i]['ORGAN_ID'];
				$data[$i]['ORGAN_NAME'] = $rs[$i]['ORGAN_NAME'];
				$data[$i]['DEPARTMENT'] = $rs[$i]['ORGAN_DESC'];
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['TEXT'] = $rs[$i]['AREA_MAIN']." ".$rs[$i]['AREA_SUB'];
				$data[$i]['SORT_BASE'] = $rs[$i]['SORT_BASE'];
				if($rs[$i]['SORT_BASE'] == "0"){
					$data[$i]['SORT_BASE_NAME'] = "지정순서";
				}else if($rs[$i]['SORT_BASE'] == "1"){
					$data[$i]['SORT_BASE_NAME'] = "행정코드";
				}else if($rs[$i]['SORT_BASE'] == "2"){
					$data[$i]['SORT_BASE_NAME'] = "장비이름";
				}
			}
			$this->rsOrganList = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 상세 조회
	 */
	function getOrganView(){
		if(DB == "0"){
			$sql = " SELECT * FROM ORGAN_INFO
					 WHERE ORGAN_ID = '".$this->DB->html_encode($_REQUEST['ORGAN_ID'])."' ";
			
			$rs = $this->DB->execute($sql);
			
			$data['ORGAN_ID'] = $rs[0]['ORGAN_ID'];
			$data['ORGAN_NAME'] = $rs[0]['ORGAN_NAME'];
			$data['DEPARTMENT'] = $rs[0]['ORGAN_DESC'];
			$data['AREA_CODE'] = $rs[0]['AREA_CODE'];
			$data['TEXT'] = $rs[0]['AREA_MAIN']." ".$rs[0]['AREA_SUB'];
			if($rs[0]['SORT_BASE'] == "0"){
				$data['SORT_BASE_NAME'] = "정렬순서";
			}else if($rs[0]['SORT_BASE'] == "1"){
				$data['SORT_BASE_NAME'] = "행정코드";
			}else if($rs[0]['SORT_BASE'] == "2"){
				$data['SORT_BASE_NAME'] = "장비이름";
			}
			$data['AREA_MAIN'] = $rs[0]['AREA_MAIN'];
			$data['AREA_SUB'] = $rs[0]['AREA_SUB'];
			$data['SORT_BASE'] = $rs[0]['SORT_BASE'];
			
			$this->rsOrganView = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 체크
	 */
	function getOrganCheck(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM ORGAN_INFO
					 WHERE (ORGAN_NAME = '".$this->DB->html_encode($_REQUEST['ORGAN_NAME'])."' OR  
					 AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."') ";
			if($this->DB->html_encode($_REQUEST['mode']) == "organ_up"){
				$sql.= " AND ORGAN_ID != '".$this->DB->html_encode($_REQUEST['ORGAN_ID'])."' ";
			}
			
			$rs = $this->DB->execute($sql);
			
			return $rs[0]['CNT'] == 0 ? true : false;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 등록
	 */
	function setOrganIn(){
		if(DB == "0"){
			$sql = " SELECT IFNULL( MAX(ORGAN_ID) + 1, 1 ) AS max_id
				 	 FROM ORGAN_INFO ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			$sql = " INSERT INTO ORGAN_INFO (ORGAN_ID, ORGAN_NAME, ORGAN_DESC, AREA_CODE, SORT_BASE, AREA_MAIN, AREA_SUB)
					 VALUES (".$rs[0]['max_id'].", '".$this->DB->html_encode($_REQUEST['ORGAN_NAME'])."', '".$this->DB->html_encode($_REQUEST['DEPARTMENT'])."', '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."', 
					 ".$this->DB->html_encode($_REQUEST['SORT_BASE']).", '".$this->DB->html_encode($_REQUEST['AREA_MAIN'])."', '".$this->DB->html_encode($_REQUEST['AREA_SUB'])."') ";
		//	echo $sql;
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 수정
	 */
	function setOrganUp(){
		if(DB == "0"){
			$sql = " UPDATE ORGAN_INFO SET ORGAN_NAME = '".$this->DB->html_encode($_REQUEST['ORGAN_NAME'])."', ORGAN_DESC = '".$this->DB->html_encode($_REQUEST['DEPARTMENT'])."', AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."', 
					 SORT_BASE = ".$this->DB->html_encode($_REQUEST['SORT_BASE']).", AREA_MAIN = '".$this->DB->html_encode($_REQUEST['AREA_MAIN'])."', AREA_SUB = '".$this->DB->html_encode($_REQUEST['AREA_SUB'])."'
					 WHERE ORGAN_ID = ".$this->DB->html_encode($_REQUEST['ORGAN_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기관정보 삭제
	 */
	function setOrganDe(){
		if(DB == "0"){
			$sql = " DELETE FROM ORGAN_INFO 
					 WHERE ORGAN_ID = ".$this->DB->html_encode($_REQUEST['ORGAN_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 조회
	 */
	function getUserList(){
		if(DB == "0"){
			$sql = " SELECT a.USER_ID, a.USER_NAME, (SELECT ORGAN_NAME FROM ORGAN_INFO WHERE ORGAN_ID = a.ORGAN_ID) AS ORGAN_NAME,
							a.USER_TYPE, a.IS_PERMIT , a.MOBILE
					 FROM USER_INFO AS a ";
			if(ss_user_type == "1"){
				$sql.= " WHERE (a.USER_TYPE != 0 AND a.USER_TYPE != 1) OR a.USER_ID = '".$_SESSION['user_id']."' ";
			}else if(ss_user_type == "3"){
				$sql.= " WHERE a.USER_ID = '".$_SESSION['user_id']."' ";
			}else if(ss_user_type == "4"){
				$sql.= " WHERE a.USER_ID = '".$_SESSION['user_id']."' ";
			}
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['NUM'] = $i + 1;
				$data[$i]['USER_ID'] = $rs[$i]['USER_ID'];
				$data[$i]['USER_NAME'] = $rs[$i]['USER_NAME'];
				$data[$i]['ORGAN_NAME'] = $rs[$i]['ORGAN_NAME'];
				$data[$i]['USER_TYPE'] = $rs[$i]['USER_TYPE'];
				$data[$i]['MOBILE'] = $rs[$i]['MOBILE'];
				if($rs[$i]['USER_TYPE'] == "0"){
					$data[$i]['USER_TYPE_NAME'] = "관리자";
				}else if($rs[$i]['USER_TYPE'] == "1"){
					$data[$i]['USER_TYPE_NAME'] = "지역관리자";
				}else if($rs[$i]['USER_TYPE'] == "3"){
					$data[$i]['USER_TYPE_NAME'] = "사용자";
				}else if($rs[$i]['USER_TYPE'] == "4"){
					$data[$i]['USER_TYPE_NAME'] = "GUEST";
				}
				if($rs[$i]['IS_PERMIT'] == "0"){
					$data[$i]['IS_PERMIT_NAME'] = '<img src="../images/icon_no.png" alt="이상">';
				}else if($rs[$i]['IS_PERMIT'] == "1"){
					$data[$i]['IS_PERMIT_NAME'] = '<img src="../images/icon_ok.png" alt="정상">';
				}
			}
			$this->rsUserList = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 상세 조회
	 */
	function getUserView(){
		if(DB == "0"){
			$sql = " SELECT a.ORGAN_ID, (SELECT ORGAN_NAME FROM ORGAN_INFO WHERE ORGAN_ID = a.ORGAN_ID ) AS ORGAN_NAME,
			a.USER_TYPE, a.MENU_TYPE, a.USER_ID, a.USER_PWD, a.USER_NAME, a.EMAIL, MOBILE as MOBILE, a.IS_PERMIT, 
			SMART_MOBILE as SMART_MOBILE , a.SMART_USE  
	 		FROM USER_INFO AS a 
	 		WHERE a.USER_ID = '".$this->DB->html_encode($_REQUEST['USER_ID'])."' ";
			
			$rs = $this->DB->execute($sql);

			$tmp_pw_len = strlen($rs[0]['USER_PWD']);
			$tmp_pw = $this->rsa_encrypt($rs[0]['USER_PWD'], public_key);

			$data['ORGAN_ID'] = $rs[0]['ORGAN_ID'];
			$data['ORGAN_NAME'] = $rs[0]['ORGAN_NAME'];
			$data['USER_TYPE'] = $rs[0]['USER_TYPE'];
			$data['MENU_TYPE'] = $rs[0]['MENU_TYPE'];
			$data['USER_ID'] = $rs[0]['USER_ID'];
			$data['USER_PWD'] = $tmp_pw;
			$data['USER_PWD_LEN'] = $tmp_pw_len;
			$data['USER_NAME'] = $rs[0]['USER_NAME'];
			$data['EMAIL'] = $rs[0]['EMAIL'];
			$data['MOBILE'] = $rs[0]['MOBILE'];
			$data['IS_PERMIT'] = $rs[0]['IS_PERMIT'];
			$data['SMART_MOBILE'] = $rs[0]['SMART_MOBILE'];
			$data['SMART_USE'] = $rs[0]['SMART_USE'];
			
			$this->rsUserView = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/**
	 *   사용자 아이디 중복 체크
	 */
	function getUserDupCheck(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM USER_INFO
					 WHERE USER_ID = '".$this->DB->html_encode($_REQUEST['USER_ID'])."' AND USER_ID != '".$this->DB->html_encode($_REQUEST['C_USER_ID'])."' ";
			
			$rs = $this->DB->execute($sql);
			
			return $rs[0]['CNT'] == 0 ? true : false;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 체크
	 */
	function getUserCheck(){
		if(DB == "0"){
			$MOBILE = $this->DB->html_encode($_REQUEST['MOBILE1'])."-".$this->DB->html_encode($_REQUEST['MOBILE2'])."-".$this->DB->html_encode($_REQUEST['MOBILE3']);
			$SMART_MOBILE = $this->DB->html_encode($_REQUEST['SMART_MOBILE1'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE2'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE3']);
			if($MOBILE == "010--" || $MOBILE == "011--" || $MOBILE == "016--" || $MOBILE == "017--" || $MOBILE == "019--" || $MOBILE == "1" || $MOBILE == "--") $MOBILE = "";
			if($SMART_MOBILE == "010--" || $SMART_MOBILE == "011--" || $SMART_MOBILE == "016--" || $SMART_MOBILE == "017--" || $SMART_MOBILE == "019--" || $SMART_MOBILE == "1" || $SMART_MOBILE == "--") $SMART_MOBILE = "";
			
			$sql = " SELECT COUNT(*) AS CNT FROM USER_INFO
						 WHERE (USER_ID = '".$this->DB->html_encode($_REQUEST['USER_ID'])."' ";
			if($MOBILE != ""){
				$sql.= " OR MOBILE = '".$MOBILE."' ";
			}
			if($SMART_MOBILE != ""){
				$sql.= " OR SMART_MOBILE = '".$SMART_MOBILE."' ";
			}
			$sql.= " ) ";
			if($this->DB->html_encode($_REQUEST['mode']) == "user_up"){
				$sql.= " AND USER_ID != '".$this->DB->html_encode($_REQUEST['C_USER_ID'])."' ";
			}
			// echo $sql;
			$rs = $this->DB->execute($sql);
			
			return $rs[0]['CNT'] == 0 ? true : false;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 등록
	 */
	function setUserIn(){
		if(DB == "0"){
			$l_pw = $this->rsa_decrypt($_REQUEST['USER_PWD']);
			$EMAIL = $this->DB->html_encode($_REQUEST['EMAIL1'])."@".$this->DB->html_encode($_REQUEST['EMAIL3']);
			$MOBILE = $this->DB->html_encode($_REQUEST['MOBILE1'])."-".$this->DB->html_encode($_REQUEST['MOBILE2'])."-".$this->DB->html_encode($_REQUEST['MOBILE3']);
			$SMART_MOBILE = $this->DB->html_encode($_REQUEST['SMART_MOBILE1'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE2'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE3']);
			if($MOBILE == "010--" || $MOBILE == "011--" || $MOBILE == "016--" || $MOBILE == "017--" || $MOBILE == "019--" || $MOBILE == "1") $MOBILE = "";
			if($SMART_MOBILE == "010--" || $SMART_MOBILE == "011--" || $SMART_MOBILE == "016--" || $SMART_MOBILE == "017--" || $SMART_MOBILE == "019--" || $SMART_MOBILE == "1") $SMART_MOBILE = "";
			
			$sql = " INSERT INTO USER_INFO (ORGAN_ID,AREA_CODE, USER_TYPE, MENU_TYPE, USER_ID, USER_PWD, USER_NAME, EMAIL, MOBILE, IS_PERMIT, SMART_MOBILE, SMART_USE, REG_DATE)
					VALUES (".$this->DB->html_encode($_REQUEST['ORGAN_ID']).",
					(SELECT area_code FROM organ_info WHERE organ_id = ".$this->DB->html_encode($_REQUEST['ORGAN_ID'])."),'".$this->DB->html_encode($_REQUEST['USER_TYPE'])."', '".$this->DB->html_encode($_REQUEST['MENU_TYPE'])."', '".$this->DB->html_encode($_REQUEST['USER_ID'])."', '".$this->DB->html_encode($l_pw)."',
					'".$this->DB->html_encode($_REQUEST['USER_NAME'])."', '".$EMAIL."', '".$MOBILE."', '".$this->DB->html_encode($_REQUEST['IS_PERMIT'])."', '".$SMART_MOBILE."', '".$this->DB->html_encode($_REQUEST['SMART_USE'])."', NOW()) ";
			//echo $sql;
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 수정
	 */
	function setUserUp(){
		if(DB == "0"){
			$l_pw = $this->rsa_decrypt($_REQUEST['USER_PWD']);
			$EMAIL = $this->DB->html_encode($_REQUEST['EMAIL1'])."@".$this->DB->html_encode($_REQUEST['EMAIL3']);
			$MOBILE = $this->DB->html_encode($_REQUEST['MOBILE1'])."-".$this->DB->html_encode($_REQUEST['MOBILE2'])."-".$this->DB->html_encode($_REQUEST['MOBILE3']);
			$SMART_MOBILE = $this->DB->html_encode($_REQUEST['SMART_MOBILE1'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE2'])."-".$this->DB->html_encode($_REQUEST['SMART_MOBILE3']);
			if($MOBILE == "010--" || $MOBILE == "011--" || $MOBILE == "016--" || $MOBILE == "017--" || $MOBILE == "019--" || $MOBILE == "1") $MOBILE = "";
			if($SMART_MOBILE == "010--" || $SMART_MOBILE == "011--" || $SMART_MOBILE == "016--" || $SMART_MOBILE == "017--" || $SMART_MOBILE == "019--" || $SMART_MOBILE == "1") $SMART_MOBILE = "";
			
			$sql = " UPDATE USER_INFO SET ORGAN_ID = ".$this->DB->html_encode($_REQUEST['ORGAN_ID']).", USER_TYPE = '".$this->DB->html_encode($_REQUEST['USER_TYPE'])."', MENU_TYPE = '".$this->DB->html_encode($_REQUEST['MENU_TYPE'])."',
					 USER_PWD = '".$this->DB->html_encode($l_pw)."', USER_NAME = '".$this->DB->html_encode($_REQUEST['USER_NAME'])."', EMAIL = '".$EMAIL."', MOBILE = '".$MOBILE."', 
					 IS_PERMIT = '".$this->DB->html_encode($_REQUEST['IS_PERMIT'])."', SMART_MOBILE = '".$SMART_MOBILE."', SMART_USE = '".$this->DB->html_encode($_REQUEST['SMART_USE'])."'
					 WHERE USER_ID = '".$this->DB->html_encode($_REQUEST['C_USER_ID'])."' ";		 
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 삭제
	 */
	function setUserDe(){
		if(DB == "0"){
			$sql = " DELETE FROM USER_INFO
					 WHERE USER_ID = '".$this->DB->html_encode($_REQUEST['C_USER_ID'])."' ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	// 긴급방송 비밀번호 확인
	function checkEmerPwd($rePwd){
		
		$SQL = " SELECT COUNT(*) AS CNT FROM USER_INFO WHERE USER_ID = '".$this->DB->html_encode($_REQUEST["id"])."' AND USER_PWD = '".$rePwd."' ";
		// echo $SQL;
		$rs = $this->DB->execute($SQL);
		
		return $rs[0]['CNT'] == 0 ? false : true;
		$this->DB->parseFree();
	}

	/**
	 *   사용자 방송권한 지역 상세 조회
	 */
	function getRightView(){
		if(DB == "0"){
			$sql = " SELECT b.GROUP_ID, a.RTU_ID
					 FROM USER_RIGHT AS a
					 LEFT JOIN RTU_GROUP AS b ON a.RTU_ID = b.RTU_ID
					 WHERE a.USER_ID = '".$this->DB->html_encode($_REQUEST['USER_ID'])."' ";

			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['GROUP_ID'] = $rs[$i]['GROUP_ID'];
				$data[$i]['RTU_ID'] = $rs[$i]['RTU_ID'];
			}
			$this->rsRightView = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 방송권한 지역 등록
	 */
	function setRightIn(){
		if(DB == "0"){
			$STR_RTU_ID = explode("-", $this->DB->html_encode($_REQUEST['STR_RTU_ID']));
			
			$sql = " INSERT INTO USER_RIGHT (USER_ID, RTU_ID, RTU_RIGHT) VALUES ";
			for($i=0; $i<count($STR_RTU_ID); $i++){
				if($i != 0) $sql.= " , ";
				$sql .= " ( '".$this->DB->html_encode($_REQUEST['USER_ID'])."', ".$STR_RTU_ID[$i].", 7 ) ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   사용자 방송권한 지역 삭제
	 */
	function setRightDe(){
		if(DB == "0"){
			$sql = " DELETE FROM USER_RIGHT
					 WHERE USER_ID = '".$this->DB->html_encode($_REQUEST['C_USER_ID'])."' ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 ID 조회
	 */
	function getEquipId(){
		if(DB == "0"){
			$sql = " SELECT IFNULL( MAX(RTU_ID) + 1, 1 ) AS max_id
				 	 FROM RTU_INFO ";
			
			$rs = $this->DB->execute($sql);
			
			$this->rsEquipId = $rs[0]['max_id'];
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   회선 조회
	 */
	function getLineInfo(){
		if(DB == "0"){
			$sql = " SELECT * FROM LINE_INFO
					 ORDER BY LINE_TYPE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['LINE_NO'] = $rs[$i]['LINE_TYPE'];
				$data[$i]['LINE_NAME'] = $rs[$i]['LINE_NAME'];
			}
			$this->rsLineInfo = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   모델 조회
	 */
	function getModelInfo(){
		if(DB == "0"){
			$sql = " SELECT * FROM MODEL_INFO
					 ORDER BY MODEL_TYPE ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['MODEL_NO'] = $rs[$i]['MODEL_TYPE'];
				$data[$i]['MODEL_NAME'] = $rs[$i]['MODEL_NAME'];
			}
			$this->rsModelInfo = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 조회
	 */
	function getEquipList(){
		if(DB == "0"){
			$sql = " SELECT a.* , b.LINE_NAME, c.MODEL_NAME, a.CONNECTION_INFO as decryt_con_info
					 FROM RTU_INFO AS a
					 LEFT JOIN LINE_INFO AS b ON a.LINE_NO = b.LINE_TYPE
					 LEFT JOIN MODEL_INFO AS c ON a.MODEL_NO = c.MODEL_TYPE
					 ORDER BY ISNULL(a.".sort.") ASC , a.".sort." ASC ";
			

			//echo $sql;

			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['NUM'] = $i + 1;
				$data[$i]['RTU_ID'] = $rs[$i]['RTU_ID'];
				$data[$i]['SIGNAL_ID'] = $rs[$i]['SIGNAL_ID'];
				$data[$i]['RTU_NAME'] = $rs[$i]['RTU_NAME'];
				if($rs[$i]['RTU_TYPE'] == "B00"){
					$data[$i]['RTU_TYPE_NAME'] = "방송(단독)";
				}else if($rs[$i]['RTU_TYPE'] == "BR0"){
					$data[$i]['RTU_TYPE_NAME'] = "방송(우량)";
				}else if($rs[$i]['RTU_TYPE'] == "BF0"){
					$data[$i]['RTU_TYPE_NAME'] = "방송(수위)";
				}else if($rs[$i]['RTU_TYPE'] == "BA0"){
					$data[$i]['RTU_TYPE_NAME'] = "방송(우+수)";
				}else if($rs[$i]['RTU_TYPE'] == "R00"){
					$data[$i]['RTU_TYPE_NAME'] = "강우계";
				}else if($rs[$i]['RTU_TYPE'] == "F00"){
					$data[$i]['RTU_TYPE_NAME'] = "수위계";
				}else if($rs[$i]['RTU_TYPE'] == "RF0"){
					$data[$i]['RTU_TYPE_NAME'] = "강우수위계";
				}else if($rs[$i]['RTU_TYPE'] == "A00"){
					$data[$i]['RTU_TYPE_NAME'] = "AWS";
				}else if($rs[$i]['RTU_TYPE'] == "S00"){
					$data[$i]['RTU_TYPE_NAME'] = "적설계";
				}else if($rs[$i]['RTU_TYPE'] == "DP0"){
					$data[$i]['RTU_TYPE_NAME'] = "변위계";
				}else if($rs[$i]['RTU_TYPE'] == "EQ0"){
					$data[$i]['RTU_TYPE_NAME'] = "지진계";
				}
				$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
				$data[$i]['LINE_NAME'] = $rs[$i]['LINE_NAME'];
				$data[$i]['MODEL_NAME'] = $rs[$i]['MODEL_NAME'];
				//$data[$i]['CONNECTION_INFO'] = $rs[$i]['CONNECTION_INFO'];
				$data[$i]['CONNECTION_INFO'] = $rs[$i]['decryt_con_info'];
				$data[$i]['PORT'] = $rs[$i]['PORT'];
				$data[$i]['BAUDRATE'] = $rs[$i]['BAUD_RATE'];
				
			if($rs[$i]['RTU_TYPE'] == 'F00'){
				$data[$i]['FLOW_WARNING'] = round_data($rs[$i]['FLOW_WARNING'], 0.01, 100);
				$data[$i]['FLOW_DANGER'] = round_data($rs[$i]['FLOW_DANGER'], 0.01, 100);
			}else if($rs[$i]['RTU_TYPE'] == 'S00'){
				$data[$i]['FLOW_WARNING'] = round_data($rs[$i]['FLOW_WARNING'], 0.001, 10);
				$data[$i]['FLOW_DANGER'] = round_data($rs[$i]['FLOW_DANGER'], 0.001, 10);
			}else{
				$data[$i]['FLOW_WARNING'] = round_data($rs[$i]['FLOW_WARNING'], 0.01, 10);
				$data[$i]['FLOW_DANGER'] = round_data($rs[$i]['FLOW_DANGER'], 0.01, 10);
			}
			
			//var_dump($data[$i]['CONNECTION_INFO']);

			}
			$this->rsEquipList = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 상세 조회
	 */
	function getEquipView(){
		if(DB == "0"){
			$sql = " SELECT * FROM RTU_INFO 
					 WHERE RTU_ID = '".$this->DB->html_encode($_REQUEST['RTU_ID'])."' ";
			
			$rs = $this->DB->execute($sql);
			
			$data['RTU_ID'] = $rs[0]['RTU_ID'];
			$data['SIGNAL_ID'] = $rs[0]['SIGNAL_ID'];
			$data['AREA_CODE'] = $rs[0]['AREA_CODE'];
			$data['RTU_NAME'] = $rs[0]['RTU_NAME'];
			$data['ORGAN_ID'] = $rs[0]['ORGAN_ID'];
			$data['LINE_NO'] = $rs[0]['LINE_NO'];
			$data['MODEL_NO'] = $rs[0]['MODEL_NO'];
			$data['RTU_TYPE'] = $rs[0]['RTU_TYPE'];
			$data['CONNECTION_INFO'] = $rs[0]['CONNECTION_INFO'];
			$data['CALL_LAST_D'] = substr($rs[0]['CALL_LAST'], 0, 10);
			$data['CALL_LAST_H'] = substr($rs[0]['CALL_LAST'], 11, 2);
			$data['CALL_LAST_M'] = substr($rs[0]['CALL_LAST'], 14, 2);
			$data['SORT_FLAG'] = $rs[0]['SORT_FLAG'];
			$data['PORT'] = $rs[0]['PORT'];
			$data['BAUDRATE'] = $rs[0]['BAUD_RATE'];
			$data['VHF_USE'] = $rs[0]['VHF_USE'];
			$data['VHF_SYSTEM_ID'] = $rs[0]['VHF_SYSTEM_ID'];
			$data['VHF_RTU_ID'] = $rs[0]['VHF_RTU_ID'];
			$data['VHF_TRANS_ID'] = $rs[0]['VHF_TRANS_ID'];

			if($rs[0]['RTU_TYPE'] == 'F00'){
				$data['FLOW_WARNING'] = round_data($rs[0]['FLOW_WARNING'], 0.01, 100);
				$data['FLOW_DANGER'] = round_data($rs[0]['FLOW_DANGER'], 0.01, 100);
				$data['FLOW_WARNING_OFF'] = round_data($rs[0]['FLOW_WARNING_OFF'], 0.01, 100);
				$data['FLOW_DANGER_OFF'] = round_data($rs[0]['FLOW_DANGER_OFF'], 0.01, 100);
			}else if($rs[0]['RTU_TYPE'] == 'S00'){
				$data['FLOW_WARNING'] = round_data($rs[0]['FLOW_WARNING'], 0.001, 10);
				$data['FLOW_DANGER'] = round_data($rs[0]['FLOW_DANGER'], 0.001, 10);
				$data['FLOW_WARNING_OFF'] = round_data($rs[0]['FLOW_WARNING_OFF'], 0.001, 10);
				$data['FLOW_DANGER_OFF'] = round_data($rs[0]['FLOW_DANGER_OFF'], 0.001, 10);
			}else{
				$data['FLOW_WARNING'] = round_data($rs[0]['FLOW_WARNING'], 0.01, 10);
				$data['FLOW_DANGER'] = round_data($rs[0]['FLOW_DANGER'], 0.01, 10);
				$data['FLOW_WARNING_OFF'] = round_data($rs[0]['FLOW_WARNING_OFF'], 0.01, 10);
				$data['FLOW_DANGER_OFF'] = round_data($rs[0]['FLOW_DANGER_OFF'], 0.01, 10);
			}
			$data['DANGER_USE'] = $rs[0]['DANGER_USE'];

			$this->rsEquipView = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 센서 조회
	 */
	function getSensorView(){
		if(DB == "0"){
			$sql = " SELECT * FROM RTU_SENSOR 
					 WHERE RTU_ID = '".$this->DB->html_encode($_REQUEST['RTU_ID'])."' ";
			
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$tmp_time = $rs[$i]['LAST_TIME'] ? $rs[$i]['LAST_TIME'] : date("Y-m-d 00:00");
				$data[$i]['SENSOR_TYPE'] = $rs[$i]['SENSOR_TYPE'];
				$data[$i]['BASE_RISKLEVEL1'] = $rs[$i]['BASE_RISKLEVEL1'];
				$data[$i]['BASE_RISKLEVEL2'] = $rs[$i]['BASE_RISKLEVEL2'];
				$data[$i]['BASE_RISKLEVEL3'] = $rs[$i]['BASE_RISKLEVEL3'];
				$data[$i]['BASE_RISKLEVEL4'] = $rs[$i]['BASE_RISKLEVEL4'];
				$data[$i]['BASE_RISKLEVEL5'] = $rs[$i]['BASE_RISKLEVEL5'];
				$data[$i]['BASE_RISKLEVEL1_OFF'] = $rs[$i]['BASE_RISKLEVEL1_OFF'];
				$data[$i]['BASE_RISKLEVEL2_OFF'] = $rs[$i]['BASE_RISKLEVEL2_OFF'];
				$data[$i]['BASE_RISKLEVEL3_OFF'] = $rs[$i]['BASE_RISKLEVEL3_OFF'];
				$data[$i]['BASE_RISKLEVEL4_OFF'] = $rs[$i]['BASE_RISKLEVEL4_OFF'];
				$data[$i]['BASE_RISKLEVEL5_OFF'] = $rs[$i]['BASE_RISKLEVEL5_OFF'];
				$data[$i]['AUTO_EVENT_USE'] = $rs[$i]['AUTO_EVENT_USE'];
				$data[$i]['IS_AVERAGE'] = $rs[$i]['IS_AVERAGE'];
				$data[$i]['LAST_TIME_DD'] = substr($tmp_time, 0, 10);
				$data[$i]['LAST_TIME_HH'] = substr($tmp_time, 11, 2);
				$data[$i]['LAST_TIME_MM'] = substr($tmp_time, 14, 2);
			}
			$this->rsSensorView = $data;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 센서 설정
	 */
	function setSensorChange(){
		if(DB == "0"){
			$sql = " DELETE FROM RTU_SENSOR
					 WHERE RTU_ID = ".$this->DB->html_encode($_REQUEST['S_RTU_ID'])." ";
			
			$this->DB->QUERYONE($sql);
			$this->DB->parseFree();
			
			if(count($_REQUEST['IS_SENSOR']) != 0){
				$sql = " INSERT INTO RTU_SENSOR (RTU_ID, SENSOR_TYPE, BASE_RISKLEVEL1, BASE_RISKLEVEL1_OFF, BASE_RISKLEVEL2, BASE_RISKLEVEL2_OFF, ";
				if(level_cnt == 3){
					$sql.= " BASE_RISKLEVEL3, BASE_RISKLEVEL3_OFF, ";
				}else if(level_cnt == 4){
					$sql.= " BASE_RISKLEVEL3, BASE_RISKLEVEL3_OFF, ";
				}else if(level_cnt == 5){
					$sql.= " BASE_RISKLEVEL3, BASE_RISKLEVEL3_OFF, BASE_RISKLEVEL4, BASE_RISKLEVEL4_OFF, BASE_RISKLEVEL5, BASE_RISKLEVEL5_OFF, ";
				}
				$sql.= " AUTO_EVENT_USE, IS_AVERAGE, LAST_TIME) VALUES ";
				for($i=0; $i<count($_REQUEST['IS_SENSOR']); $i++){
					$LAST_TIME = $this->DB->html_encode($_REQUEST['LAST_TIME_DD'][$i])." ".$this->DB->html_encode($_REQUEST['LAST_TIME_HH'][$i]).":".$this->DB->html_encode($_REQUEST['LAST_TIME_MM'][$i]).":00";
					
					if($i != 0) $sql.= " , ";
					$sql .= " ('".$this->DB->html_encode($_REQUEST['S_RTU_ID'])."', '".$this->DB->html_encode($_REQUEST['IS_SENSOR'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL1'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL1_OFF'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL2'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL2_OFF'][$i])."', ";
					if(level_cnt == 3){
						$sql.= " '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3_OFF'][$i])."', ";
					}else if(level_cnt == 4){
						$sql.= " '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3_OFF'][$i])."', ";
					}else if(level_cnt == 5){
						$sql.= " '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL3_OFF'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL4'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL4_OFF'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL5'][$i])."', '".$this->DB->html_encode($_REQUEST['BASE_RISKLEVEL5_OFF'][$i])."', ";
					}
					$sql.= " '".$this->DB->html_encode($_REQUEST['AUTO_EVENT_USE'][$i])."', '".$this->DB->html_encode($_REQUEST['IS_AVERAGE'][$i])."', '".$LAST_TIME."') ";
				}
			}
			// echo "sql : ".$sql;
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 행정 코드 중복 체크
	 */
	function getEquipDupCheck(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM RTU_INFO
					 WHERE AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."' AND RTU_ID != '".$this->DB->html_encode($_REQUEST['C_RTU_ID'])."' ";
			
			$rs = $this->DB->execute($sql);
			
			return $rs[0]['CNT'] == 0 ? true : false;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 체크
	 */
	function getEquipCheck(){
		if(DB == "0"){
			$sql = " SELECT COUNT(*) AS CNT FROM RTU_INFO
					 WHERE (RTU_ID = '".$this->DB->html_encode($_REQUEST['RTU_ID'])."' OR SIGNAL_ID = '".$this->DB->html_encode($_REQUEST['SIGNAL_ID'])."') ";
			if($this->DB->html_encode($_REQUEST['mode']) == "equip_up"){
				$sql.= " AND RTU_ID != '".$this->DB->html_encode($_REQUEST['C_RTU_ID'])."' ";
			}
			
			$rs = $this->DB->execute($sql);
			
			return $rs[0]['CNT'] == 0 ? true : false;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 등록
	 */
	function setEquipIn(){
		if(DB == "0"){
			$CALL_LAST = $this->DB->html_encode($_REQUEST['CALL_LAST_D'])." ".$this->DB->html_encode($_REQUEST['CALL_LAST_H']).":".$this->DB->html_encode($_REQUEST['CALL_LAST_M']).":00";

			if($this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BR0' || $this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BF0' || $this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BA0'){ //방송장비 경보방송에 안나오기때문에 등록시 처리 --20181220
				$RTU_TYPE = "B00";
			}

			if($this->DB->html_encode($_REQUEST[0]['RTU_TYPE']) == 'S00'){
				$FLOW_WARNING = $this->DB->html_encode($_REQUEST['FLOW_WARNING'])*1000;
				$FLOW_DANGER = $this->DB->html_encode($_REQUEST['FLOW_DANGER'])*1000;
				$FLOW_WARNING_OFF = $this->DB->html_encode($_REQUEST['FLOW_WARNING_OFF'])*1000;
				$FLOW_DANGER_OFF = $this->DB->html_encode($_REQUEST['FLOW_DANGER_OFF'])*1000;
			}else{
				$FLOW_WARNING = $this->DB->html_encode($_REQUEST['FLOW_WARNING'])*100;
				$FLOW_DANGER = $this->DB->html_encode($_REQUEST['FLOW_DANGER'])*100;
				$FLOW_WARNING_OFF = $this->DB->html_encode($_REQUEST['FLOW_WARNING_OFF'])*100;
				$FLOW_DANGER_OFF = $this->DB->html_encode($_REQUEST['FLOW_DANGER_OFF'])*100;
			}
			
			$sql = " INSERT INTO RTU_INFO (RTU_ID, SIGNAL_ID, AREA_CODE, RTU_NAME, ORGAN_ID, LINE_NO, MODEL_NO, RTU_TYPE, CONNECTION_INFO,
					 CALL_LAST, SORT_FLAG, PORT, BAUD_RATE, VHF_USE, VHF_SYSTEM_ID, VHF_RTU_ID, VHF_TRANS_ID, REG_DATE, FLOW_DANGER, FLOW_WARNING, FLOW_DANGER_OFF, FLOW_WARNING_OFF, DANGER_USE)
					 VALUES ('".$this->DB->html_encode($_REQUEST['RTU_ID'])."', '".$this->DB->html_encode($_REQUEST['SIGNAL_ID'])."', '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."', '".$this->DB->html_encode($_REQUEST['RTU_NAME'])."', '".$this->DB->html_encode($_REQUEST['ORGAN_ID'])."',
					 '".$this->DB->html_encode($_REQUEST['LINE_NO'])."', '".$this->DB->html_encode($_REQUEST['MODEL_NO'])."', '".$this->DB->html_encode($_REQUEST['RTU_TYPE'])."', '".$this->DB->html_encode($_REQUEST['CONNECTION_INFO'])."',
					 '".$CALL_LAST."', '".$this->DB->html_encode($_REQUEST['SORT_FLAG'])."', '".$this->DB->html_encode($_REQUEST['PORT'])."', '".$this->DB->html_encode($_REQUEST['BAUDRATE'])."', '".$this->DB->html_encode($_REQUEST['VHF_USE'])."', 
					 '".$this->DB->html_encode($_REQUEST['VHF_SYSTEM_ID'])."', '".$this->DB->html_encode($_REQUEST['VHF_RTU_ID'])."', '".$this->DB->html_encode($_REQUEST['VHF_TRANS_ID'])."',
					 NOW(), '".$FLOW_DANGER."', '".$FLOW_WARNING."', '".$FLOW_DANGER_OFF."', '".$FLOW_WARNING_OFF."', '".$this->DB->html_encode($_REQUEST['DANGER_USE'])."') ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 수정
	 */
	function setEquipUp(){
		if(DB == "0"){
			$CALL_LAST = $this->DB->html_encode($_REQUEST['CALL_LAST_D'])." ".$this->DB->html_encode($_REQUEST['CALL_LAST_H']).":".$this->DB->html_encode($_REQUEST['CALL_LAST_M']).":00";

			if($this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BR0' || $this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BF0' || $this->DB->html_encode($_REQUEST['RTU_TYPE'])=='BA0'){ //방송장비 경보방송에 안나오기때문에 등록시 처리 --20181220
				$RTU_TYPE = "B00";
			}
			
			if($this->DB->html_encode($_REQUEST[0]['RTU_TYPE']) == 'S00'){
				$FLOW_WARNING = $this->DB->html_encode($_REQUEST['FLOW_WARNING'])*1000;
				$FLOW_DANGER = $this->DB->html_encode($_REQUEST['FLOW_DANGER'])*1000;
				$FLOW_WARNING_OFF = $this->DB->html_encode($_REQUEST['FLOW_WARNING_OFF'])*1000;
				$FLOW_DANGER_OFF = $this->DB->html_encode($_REQUEST['FLOW_DANGER_OFF'])*1000;
			}else{
				$FLOW_WARNING = $this->DB->html_encode($_REQUEST['FLOW_WARNING'])*100;
				$FLOW_DANGER = $this->DB->html_encode($_REQUEST['FLOW_DANGER'])*100;
				$FLOW_WARNING_OFF = $this->DB->html_encode($_REQUEST['FLOW_WARNING_OFF'])*100;
				$FLOW_DANGER_OFF = $this->DB->html_encode($_REQUEST['FLOW_DANGER_OFF'])*100;
			}
			
			$sql = " UPDATE RTU_INFO SET SIGNAL_ID = '".$this->DB->html_encode($_REQUEST['SIGNAL_ID'])."', AREA_CODE = '".$this->DB->html_encode($_REQUEST['AREA_CODE'])."', RTU_NAME = '".$this->DB->html_encode($_REQUEST['RTU_NAME'])."',
					 ORGAN_ID = '".$this->DB->html_encode($_REQUEST['ORGAN_ID'])."', LINE_NO = '".$this->DB->html_encode($_REQUEST['LINE_NO'])."', MODEL_NO = '".$this->DB->html_encode($_REQUEST['MODEL_NO'])."', RTU_TYPE = '".$this->DB->html_encode($_REQUEST['RTU_TYPE'])."',
					 CONNECTION_INFO = '".$this->DB->html_encode($_REQUEST['CONNECTION_INFO'])."', CALL_LAST = '".$CALL_LAST."',
					 SORT_FLAG = '".$this->DB->html_encode($_REQUEST['SORT_FLAG'])."', PORT = '".$this->DB->html_encode($_REQUEST['PORT'])."', BAUD_RATE = '".$this->DB->html_encode($_REQUEST['BAUDRATE'])."', VHF_USE = '".$this->DB->html_encode($_REQUEST['VHF_USE'])."', 
					 VHF_SYSTEM_ID = '".$this->DB->html_encode($_REQUEST['VHF_SYSTEM_ID'])."', VHF_RTU_ID = '".$this->DB->html_encode($_REQUEST['VHF_RTU_ID'])."', VHF_TRANS_ID = '".$this->DB->html_encode($_REQUEST['VHF_TRANS_ID'])."',
					 FLOW_DANGER = '".$FLOW_DANGER."', FLOW_WARNING = '".$FLOW_WARNING."', FLOW_DANGER_OFF = '".$FLOW_DANGER_OFF."', FLOW_WARNING_OFF = '".$FLOW_WARNING_OFF."', DANGER_USE = '".$this->DB->html_encode($_REQUEST['DANGER_USE'])."'
					 WHERE RTU_ID = '".$this->DB->html_encode($_REQUEST['C_RTU_ID'])."' ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 그룹  입력
	 */
	function setEquipGroupIn(){
		if(DB == "0"){
			
			$sql = " insert into state_rtu_group values (
					'".$this->DB->html_encode($_REQUEST['C_RTU_ID'])."' , 
					(select group_id from state_group_info where '".$this->DB->html_encode($_REQUEST['RTU_TYPE'])."' like concat(rtu_type, '%') )
					, '1') ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/**
	 *   장비 그룹  수정
	 */
	function setEquipGroupUp(){
		if(DB == "0"){

			// if($this->DB->html_encode($_REQUEST['RTU_TYPE']=='A00'){ 
			// 	$GROUP_ID = "001";
			// }elseif($this->DB->html_encode($_REQUEST['RTU_TYPE']=='R00'){ 
			// 	$GROUP_ID = "002";
			// }elseif($this->DB->html_encode($_REQUEST['RTU_TYPE']=='F00'){ 
			// 	$GROUP_ID = "003";
			// }elseif($this->DB->html_encode($_REQUEST['RTU_TYPE']=='BR0' || $this->DB->html_encode($_REQUEST['RTU_TYPE']=='BF0' || $this->DB->html_encode($_REQUEST['RTU_TYPE']=='BA0'){ //방송장비 경보방송에 안나오기때문에 등록시 처리 --20181220
			// 	$GROUP_ID = "004";
			// }elseif($this->DB->html_encode($_REQUEST['RTU_TYPE']=='S00'){ 
			// 	$GROUP_ID = "005";
			// }else{
			// 	$GROUP_ID = "004";
			// }
			
			$sql = " update state_rtu_group set 
					group_id = (select group_id from state_group_info where '".$this->DB->html_encode($_REQUEST['RTU_TYPE'])."'  like concat(rtu_type, '%'))
					 where rtu_id = '".$this->DB->html_encode($_REQUEST['C_RTU_ID'])."' ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 삭제
	 */
	function setEquipDe(){
		if(DB == "0"){
			$sql = " DELETE FROM RTU_INFO
					 WHERE RTU_ID = ".$this->DB->html_encode($_REQUEST['C_RTU_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 그룹 삭제
	 */
	function setEquipGroupDe(){
		if(DB == "0"){
			$sql = " DELETE FROM state_rtu_group
					 WHERE RTU_ID = ".$this->DB->html_encode($_REQUEST['C_RTU_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 위치 등록
	 */
	function setLocatIn(){
		if(DB == "0"){
			$sql = " SELECT X_CENT, Y_CENT, EMD_CD
				 	 FROM WR_MAP_INFO ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();

			$sql = " INSERT INTO RTU_LOCATION (RTU_ID, WR_X_POINT, WR_Y_POINT, WR_EMD_CD) 
					 VALUES ('".$this->DB->html_encode($_REQUEST['RTU_ID'])."', '".$rs[0]['X_CENT']."', '".$rs[0]['Y_CENT']."', '".$rs[0]['EMD_CD']."') ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 위치 삭제
	 */
	function setLocatDe(){
		if(DB == "0"){
			$sql = " DELETE FROM RTU_LOCATION
					 WHERE RTU_ID = ".$this->DB->html_encode($_REQUEST['C_RTU_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 센서 등록
	 */
	function setSensorIn(){
		if(DB == "0"){
			$RTU_TYPE = $this->DB->html_encode($_REQUEST['RTU_TYPE']);
			$RTU_ID = $this->DB->html_encode($_REQUEST['RTU_ID']);
			
			if($RTU_TYPE == "B00"){
				return true;
			}else{
				$sql = " INSERT INTO RTU_SENSOR (RTU_ID, SENSOR_TYPE)
						 VALUES ";
				if($RTU_TYPE == "BR0" || $RTU_TYPE == "R00"){
					$sql.=" ('".$RTU_ID."', '0') ";
				}else if($RTU_TYPE == "BF0" || $RTU_TYPE == "F00"){
					$sql.=" ('".$RTU_ID."', '1') ";
				}else if($RTU_TYPE == "BA0" || $RTU_TYPE == "RF0"){
					$sql.=" ('".$RTU_ID."', '0'), ";
					$sql.=" ('".$RTU_ID."', '1') ";
				}else if($RTU_TYPE == "A00"){
					$sql.=" ('".$RTU_ID."', '0'), ";
					$sql.=" ('".$RTU_ID."', 'A'), ";
					$sql.=" ('".$RTU_ID."', 'T'), ";
					$sql.=" ('".$RTU_ID."', 'W'), ";
					$sql.=" ('".$RTU_ID."', 'H'), ";
					$sql.=" ('".$RTU_ID."', 'S'), ";
					$sql.=" ('".$RTU_ID."', 'R') ";
				}else if($RTU_TYPE == "S00"){
					$sql.=" ('".$RTU_ID."', '2') ";
				}else if($RTU_TYPE == "DP0"){
					$sql.=" ('".$RTU_ID."', 'DP') ";
				}else if($RTU_TYPE == "EQ0"){
					$sql.=" ('".$RTU_ID."', 'EQ') ";
				}
				
				if($this->DB->QUERYONE($sql)) $sqlReturn = true;
				$this->DB->parseFree();
				return $sqlReturn;
			}
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   장비 센서 삭제
	 */
	function setSensorDe(){
		if(DB == "0"){
			$sql = " DELETE FROM RTU_SENSOR
					 WHERE RTU_ID = ".$this->DB->html_encode($_REQUEST['C_RTU_ID'])." ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	function rsa_encrypt($plaintext, $public_key){

		// 공개키를 사용하여 암호화한다.
		$pubkey_decoded = @openssl_pkey_get_public($public_key);
		if ($pubkey_decoded === false) return false;
		
		$ciphertext = false;
		$status = @openssl_public_encrypt($plaintext, $ciphertext, $pubkey_decoded);
		if (!$status || $ciphertext === false) return false;
		
		// 암호문을 base64로 인코딩하여 반환한다.
		return base64_encode($ciphertext);
	}
	
	function rsa_decrypt($ciphertext){
			
		// 암호문을 base64로 디코딩한다.
		$ciphertext = @base64_decode($ciphertext, true);
		if ($ciphertext === false) return false;
		
		// 개인키를 읽어온다.
		$private_key = @file_get_contents(str_replace("/", "\\", $_SERVER['DOCUMENT_ROOT']).'/divas/_info/json/private.key');
		// 개인키를 사용하여 복호화한다.
		
		$privkey_decoded = @openssl_pkey_get_private($private_key);
		if ($privkey_decoded === false)	return false;
		
		$plaintext = false;
		$status = @openssl_private_decrypt($ciphertext, $plaintext, $privkey_decoded);
		
		@openssl_pkey_free($privkey_decoded);
		if (!$status || $plaintext === false) return false;
		// 이상이 없는 경우 평문을 반환한다.
		
		return $plaintext;
	}	

}//End Class
?>
			