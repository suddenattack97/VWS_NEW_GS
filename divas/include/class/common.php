<?
Class ClassCommon {

	private $DB;

	function ClassCommon($DB){
		$this->DB = $DB;
	}
	

	function getAccessInfo(){
		$SQL = " SELECT * FROM ACCESS_INFO ";
		$rs = $this->DB->execute ( $SQL );
		
		for($i = 0; $i < $this->DB->NUM_ROW(); $i ++) {
			$data[$i] = $rs[$i]['ACCESS_IP'];
		}
		unset ( $rs );

		$this->DB->parseFree();
		// return $data;
		$ip_list = array();
		for($i=0;$i<count($data);$i++){
			array_push($ip_list,$data[$i]); 
		}
		 //var_dump($ip_list);
		if( in_array($_SERVER["REMOTE_ADDR"],$ip_list) ){ //허용된 ip
				return true;
		}else{
				// echo "<script> parent.location.href='".$http_request."';</script>";
				// exit;
				return false;
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
		$private_key = @file_get_contents('private.key');
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

	/**
	 *   로그인 세션 체크
	 */
	function getSession(){
		if(MobileCheck() == "Computer"){
			if( $_SERVER['PHP_SELF'] == ROOT."/index.php" || 
				$_SERVER['PHP_SELF'] == ROOT."/divas/monitoring/main.php" || 
				$_SERVER['PHP_SELF'] == ROOT."/divas/monitoring/login.php" ||
				$_SERVER['PHP_SELF'] == ROOT."/divas/monitoring/page_out.php" ||
				$_SERVER['PHP_SELF'] == ROOT."/divas/monitoring/page_not.php" ||
				$_SERVER['PHP_SELF'] == ROOT."/divas/monitoring/test.php" ){
			}else{
				if( !preg_match("/".$_SERVER['HTTP_HOST']."/i", $_SERVER['HTTP_REFERER']) ){
					// exit("No direct access allowed.");
				}
				if( (!$_SESSION['is_login'] || $_SESSION['is_login'] == 0) && !strpos($_SERVER["PHP_SELF"], "_json") ){
					// $str = ' <script> ';
					// $str.= ' parent.document.location.href="'.ROOT.'/divas/monitoring/login.php"; ';
					// $str.= ' </script> ';
					// echo $str;
					// exit;
				}
				if( !strpos($_SERVER["PHP_SELF"], "_json") ) $this->getMenuCheck(); // 메뉴 권한 체크
			}
		}else if(MobileCheck() == "Mobile"){
			if( (!$_SESSION['is_login'] || $_SESSION['is_login'] == 0) && !strpos($_SERVER["PHP_SELF"], "_json") ){
				$tmp_alert = "승인되지 않은 단말기 입니다. 관리자에게 문의해 주세요.";
				echo('<script>alert("'.iconv("utf-8", "euc-kr", $tmp_alert).'");</script>'); exit;
			}
		}
	}
	
	/**
	 *   로그인 시도 중인 아이디의 정보
	 */
	function getLoginIdInfo(){
		if(DB == "0"){

			// openssl 모듈 체크
			if(extension_loaded("openssl")){

				$l_id = $this->rsa_decrypt($_REQUEST['l_id']);
				
				$sql = " SELECT a.user_id, a.user_pwd, a.FAIL_CNT, a.LAST_FAIL_DATE
						 FROM user_info AS a
						 LEFT JOIN organ_info AS b ON a.organ_id = b.organ_id
						 WHERE a.user_id = '".$l_id."' ";
			
				$rs = $this->DB->execute($sql);
				
				if($this->DB->num_rows){
					$user_id = $rs[0]['user_id'];
					$user_pwd = $rs[0]['user_pwd'];
					$FAIL_CNT = $rs[0]['FAIL_CNT'];
					$LAST_FAIL_DATE = $rs[0]['LAST_FAIL_DATE'];
	
					if( $LAST_FAIL_DATE == date("Y-m-d H", time()).":00:00" && $FAIL_CNT >= 10){
						$result = false;
					}else{
						$result = true;
					}
				}else{
					$result = true;
				}			
				unset($rs);
				$this->DB->parseFree();
	
				$returnBody = array( 'result' => $result, 'user_id' => $user_id, 'FAIL_CNT' => $FAIL_CNT, 'LAST_FAIL_DATE' => $LAST_FAIL_DATE );

			} else{
				$returnBody = array( 'result' => false, 'msg' => "php_openssl loading failed!" );
			}
			return $returnBody;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   로그인 세션 처리
	 */
	function setLogin(){
		if(DB == "0"){
			
			if(MobileCheck() == "Computer"){

				$l_id = $this->rsa_decrypt($_REQUEST['l_id']);
				$l_pw = $this->rsa_decrypt($_REQUEST['l_pw']);
				
				$sql = " SELECT a.user_id, a.user_pwd, a.user_type, a.user_name, 
								a.organ_id, b.area_code, b.organ_name, b.sort_base
						 FROM user_info AS a
						 LEFT JOIN organ_info AS b ON a.organ_id = b.organ_id
						 WHERE a.user_id = '".$l_id."' AND a.user_pwd = '".$l_pw."' ";
			}else if(MobileCheck() == "Mobile"){
				$mynumber = substr($_REQUEST['mynumber'], 0, 3)."-".substr($_REQUEST['mynumber'], 3, 4)."-".substr($_REQUEST['mynumber'], 7, 4);
				
				$sql = " SELECT a.user_id, a.user_pwd, a.user_type, a.user_name,
							a.organ_id, b.area_code, b.organ_name, b.sort_base
						 FROM user_info AS a
						 LEFT JOIN organ_info AS b ON a.organ_id = b.organ_id ";
					// $sql .= " WHERE a.smart_use = 1 AND a.smart_mobile = HEX(AES_ENCRYPT('".$mynumber."', MD5('".ss_organ_code."'))) ";
					$sql .= " WHERE a.smart_use = 1 AND a.smart_mobile = '".$mynumber."'";
					
					/*
				if($_REQUEST['device_id'] == "null"){
					$sql .= " WHERE a.smart_use = 1 AND a.smart_mobile = '".$mynumber."' ";
				}else{
					$sql .= " WHERE a.user_id = 'admin' ";
				}
				*/
			}
			
			$rs = $this->DB->execute($sql);
			
			if($this->DB->num_rows){
				$_SESSION['user_id'] = $rs[0]['user_id'];
				if(MobileCheck() == "Computer"){
					$_SESSION['user_pwd'] = $this->rsa_encrypt($rs[0]['user_pwd'], public_key);
				}else if(MobileCheck() == "Mobile"){
					$_SESSION['user_pwd'] = $rs[0]['user_pwd'];
				}
				$_SESSION['user_type'] = $rs[0]['user_type'];
				$_SESSION['user_name'] = $rs[0]['user_name'];
				$_SESSION['organ_id'] = $rs[0]['organ_id'];
				// $_SESSION['organ_code'] = $rs[0]['area_code'];
				$_SESSION['organ_name'] = $rs[0]['organ_name'];
				$_SESSION['sort_base'] = $rs[0]['sort_base'];
				

				
				$sql = " SELECT rtu_id, rtu_right
					 	 FROM user_right 
						 WHERE user_id = '".$rs[0]['user_id']."' ";
				
				$rs2 = $this->DB->execute($sql);
				
				$is_rtu_id = "";
				if($this->DB->num_rows){
					for($i=0; $i<$this->DB->NUM_ROW(); $i++){
						if( $i == 0 ) {$is_rtu_id .= $rs2[$i]['rtu_id'];}
						else {$is_rtu_id .= ",".$rs2[$i]['rtu_id']; } 
					}
				}
				$_SESSION['is_rtu_id'] = $is_rtu_id;
				$_SESSION['is_login'] = 1;
				setcookie("login_kind", $_REQUEST['login_kind_data'], time()+3600*24*30, "/");
			}else{
				$_SESSION['is_login'] = 0;

				$IdInfo = $this->getLoginIdInfo();
				
				$tmp_id = $IdInfo['user_id'];
				$FAIL_CNT = $IdInfo['FAIL_CNT'] + 1;
				$LAST_FAIL_DATE = $IdInfo['LAST_FAIL_DATE'];

				if( $LAST_FAIL_DATE != date("Y-m-d H", time()).":00:00" ){
					$FAIL_CNT = 1;
				}

				$sql = " UPDATE user_info SET FAIL_CNT = ".$FAIL_CNT.", LAST_FAIL_DATE = DATE_FORMAT(now(), '%Y-%m-%d %H')
						 WHERE user_id = '".$tmp_id."' ";
				
				if($this->DB->QUERYONE($sql)) $sqlReturn = true;
				
				/* 5회 이상일때 리캡챠 업로드 시 - 문제1) location.reload,  문제2) 로그인 성공 할때까지 다른 아이디도 리캡챠 해야 됨
					if($FAIL_CNT > 5){
					$sql = " UPDATE dn_setting SET recaptcha = 2
							 WHERE set_idx = 1 ";
					
					if($this->DB->QUERYONE($sql)) $sqlReturn = true;
				} */
				// $this->DB->parseFree();
				// return $sqlReturn;
			}
			
			unset($rs);
			$this->DB->parseFree();
			
			return $_SESSION['is_login'];
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   로그아웃 세션 처리
	 */
	function setLogout(){
		session_destroy();
	}
	
	/**
	 *   리캡차 체크
	 */
	function setCaptcha(){
		if(recaptcha == 1){
			function objectToArray($d){
				if( is_object($d) ){
					$d = get_object_vars($d);
				}
				
				if( is_array($d) ){
					return array_map(__FUNCTION__, $d);
				}else{
					return $d;
				}
			}
			
			$response = $_REQUEST['recaptcha'];
			$post_data = "secret=6LdEtlkUAAAAACe6vK4x4BeIR1q3VD81Rip3nck0&response=".$response."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=utf-8', 'Content-Length: '.strlen($post_data)));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			$googresp = curl_exec($ch);
			$decgoogresp = json_decode($googresp);
			curl_close($ch);
			
			//print_r( $decgoogresp );
			//print_r( objectToArray($decgoogresp) );
			$success = objectToArray($decgoogresp);
			$success = $success['success'];
		}else if(recaptcha == 2){
			$recaptcha = $_REQUEST['recaptcha'];
			if( strtolower($recaptcha) == strtolower($_SESSION['random_number']) ){
				$success = 1;
			}else{
				$success = 2;
			}
		}

		if($success == 1){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 *   메뉴 권한 체크
	 */
	function getMenuCheck(){
		if(DB == "0"){
			$front = ROOT."/divas/monitoring/";
			$url = explode("/", $_SERVER['PHP_SELF']);
			$url = $url[count($url) - 1];
			if($url == "abr_state.php") $url = "abr_common.php";
			if($url == "wa_state.php") $url = "wa_send.php";

				$sql = " SELECT b.menu_level, b.menu_idx 
					 FROM dn_menu_top AS a
					 LEFT JOIN dn_menu_in AS b ON a.menu_idx = b.menu_idx
					 WHERE a.menu_use = 1 AND b.menu_use = 1 AND b.menu_url = '".$url."' ";
		
			$rs = $this->DB->execute($sql);

			if($_SESSION['user_type'] != 0 && $_SESSION['user_type'] != 7){
				if($rs[0]['menu_idx'] == 4 || $rs[0]['menu_idx'] == 2){
					$str = ' <script> ';
					$str.= ' location.href="'.ROOT.'/divas/monitoring/page_out.php"; ';
					$str.= ' </script>';

					echo $str;
					exit;
				}
			}

			
			// switch($rs[0]['menu_level']){
			// 	case 1: $check = array(0, 7); break;
			// 	case 2: $check = array(0, 1, 7); break;
			// 	case 3: $check = array(0, 1, 3, 7); break;
			// 	case 4: $check = array(0, 1, 3, 4, 7); break;
			// }
			
			// if($check){
			// 	if( !in_array($_SESSION['user_type'], $check) ){
			// 		// $str = ' <script> ';
			// 		// $str.= ' location.href="'.ROOT.'/divas/monitoring/page_out.php"; ';
			// 		// $str.= ' </script> ';
					
			// 		// echo $str;
			// 		// exit;
			// 	}
			// }else{
				
			// 	if($url == "set_setting.php"){
			// 		if($_REQUEST['check'] != "*&32956"){
			// 			// $str = ' <script> ';
			// 			// $str.= ' location.href="'.ROOT.'/divas/monitoring/page_out.php"; ';
			// 			// $str.= ' </script> ';
						
			// 			// echo $str;
			// 			// exit;
						
			// 		}
			// 	}else{
			// 		/*
			// 		$str = ' <script> ';
			// 		$str.= ' location.href="'.ROOT.'/divas/monitoring/page_not.php"; ';
			// 		$str.= ' </script> ';
			// 		echo $str;
			// 		exit;
			// 		*/
			// 	}
				
			// }
			
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   메뉴 정보 호출
	 */
	function getMenuView(){
		if(DB == "0"){
			$menu_level = "";
			switch($_SESSION['user_type']){
				case 7: $menu_level = " AND b.menu_level IN ('1','2','3','4') "; break;
				case 0: $menu_level = " AND b.menu_level IN ('1','2','3','4') "; break;
				case 1: $menu_level = " AND b.menu_level IN ('2','3','4') "; break;
				case 3: $menu_level = " AND b.menu_level IN ('3','4') "; break;
				case 4: $menu_level = " AND b.menu_level IN ('4') "; break;
			}
			
			$sql = " SELECT a.menu_idx, a.menu_name, b.menu_url, a.menu_icon
					 FROM dn_menu_top AS a
					 LEFT JOIN dn_menu_in AS b ON a.menu_idx = b.menu_idx AND a.menu_num = b.menu_num
					 WHERE a.menu_use = 1 ".$menu_level." ";
			
			$rs_top = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data_top[$i]['menu_idx'] = $rs_top[$i]['menu_idx'];
				$data_top[$i]['menu_name'] = $rs_top[$i]['menu_name'];
				$data_top[$i]['menu_url'] = $rs_top[$i]['menu_url'];
				$data_top[$i]['menu_icon'] = $rs_top[$i]['menu_icon'];
			}
			$this->rsMenuTop = $data_top;
			
			$sql = " SELECT b.menu_idx, b.menu_num, b.menu_name, b.menu_url
					 FROM dn_menu_top AS a
					 LEFT JOIN dn_menu_in AS b ON a.menu_idx = b.menu_idx
					 WHERE a.menu_use = 1 AND b.menu_use = 1 ".$menu_level." ";
					 
			$rs_in = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$idx = $rs_in[$i]['menu_idx'];
				$num = $rs_in[$i]['menu_num'];
				$data_in[$idx][$num]['menu_num'] = $rs_in[$i]['menu_num'];
				$data_in[$idx][$num]['menu_name'] = $rs_in[$i]['menu_name'];
				$data_in[$idx][$num]['menu_url'] = $rs_in[$i]['menu_url'];
			}
			$this->rsMenuIn = $data_in;

			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   메뉴 정보 리스트
	 */
	function getMenuList(){
		if(DB == "0"){
			$sql = " SELECT a.menu_idx, a.menu_name, b.menu_name AS sub_name, b.menu_url, a.menu_icon, a.menu_use
					 FROM dn_menu_top AS a
					 LEFT JOIN dn_menu_in AS b ON a.menu_idx = b.menu_idx AND a.menu_num = b.menu_num ";
			
			$rs_top = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data_top[$i]['menu_idx'] = $rs_top[$i]['menu_idx'];
				$data_top[$i]['menu_name'] = $rs_top[$i]['menu_name'];
				$data_top[$i]['sub_name'] = $rs_top[$i]['sub_name'];
				$data_top[$i]['menu_url'] = $rs_top[$i]['menu_url'];
				$data_top[$i]['menu_icon'] = $rs_top[$i]['menu_icon'];
				$data_top[$i]['menu_use'] = $rs_top[$i]['menu_use'];
			}
			$this->rsMenuTop = $data_top;
			
			$sql = " 	SELECT b.menu_idx, b.menu_num, b.menu_name, b.menu_url, b.menu_level, b.menu_use
						FROM dn_menu_top AS a
						LEFT JOIN dn_menu_in AS b ON a.menu_idx = b.menu_idx
						where a.menu_use = '1' ";
			
			$rs_in = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$idx = $rs_in[$i]['menu_idx'];
				$num = $rs_in[$i]['menu_num'];
				$data_in[$idx][$num]['menu_idx'] = $rs_in[$i]['menu_idx'];
				$data_in[$idx][$num]['menu_num'] = $rs_in[$i]['menu_num'];
				$data_in[$idx][$num]['menu_name'] = $rs_in[$i]['menu_name'];
				$data_in[$idx][$num]['menu_url'] = $rs_in[$i]['menu_url'];
				$data_in[$idx][$num]['menu_level'] = $rs_in[$i]['menu_level'];
				$data_in[$idx][$num]['menu_use'] = $rs_in[$i]['menu_use'];
			}
			$this->rsMenuIn = $data_in;

			$sql = " SELECT b.menu_idx, b.menu_name , b.menu_url , b.menu_level , b.menu_use, b.login_check
			FROM dn_direct_url as b
			order by b.menu_idx asc  ";
						
			$rs_url = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data_url[$i]['menu_idx'] = $rs_url[$i]['menu_idx'];
				$data_url[$i]['menu_name'] = $rs_url[$i]['menu_name'];
				$data_url[$i]['menu_url'] = $rs_url[$i]['menu_url'];
				$data_url[$i]['menu_icon'] = $rs_url[$i]['menu_icon'];
				$data_url[$i]['menu_use'] = $rs_url[$i]['menu_use'];
				$data_url[$i]['login_check'] = $rs_url[$i]['login_check'];
			}
			$this->rsMenuUrl = $data_url;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}

	/**
	 *   지역 코드 설정
	 */
	function getAreaCode(){
		if(DB == "0"){
			$sql = "SELECT left(area_code,5) as area_code, sido, gugun FROM area_info WHERE substring(area_code,5,5) = 0 AND area_level='1' AND sido='경기도' ";

			$ar_code = $this->DB->execute($sql);

			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data_area[$i]['area_code'] = $ar_code[$i]['area_code'];
				$data_area[$i]['sido'] = $ar_code[$i]['sido'];
				$data_area[$i]['gugun'] = $ar_code[$i]['gugun'];
			}
			// var_dump($data_area);

			$sql = "SELECT sig_cd FROM wr_map_setting limit 1";

			$ar_code = $this->DB->execute($sql);

			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data_area['sig_cd'] = $ar_code[$i]['sig_cd'];
			}

			// echo $data_area['sig_cd'];
			$this->Menu_area = $data_area;
			
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}

		
	}
	
	/**
	 *   기본 환경설정
	 */
	function getSetting(){
		if(DB == "0"){
			$organ_id = isset($_SESSION['organ_id']) ? $_SESSION['organ_id'] : 1;
			
			$sql = " SELECT *
					 FROM dn_setting
					 WHERE set_idx = '".$organ_id."' ";

			$rs = $this->DB->execute($sql);
			
			$tmp_top_img = "";
			if( file_exists(ROOT_DIR."/divas/images/top/".$rs[0]['top_img']) ){
				$tmp_top_img = $rs[0]['top_img'];
			}else{
				$tmp_top_img = "hwajin.jpg";
			}
			
			define("ss_user_id", $_SESSION['user_id']);			//사용자 아이디
			define("ss_user_pwd", $_SESSION['user_pwd']);		//사용자 비밀번호
			define("ss_user_type", $_SESSION['user_type']);		//사용자 구분
			define("ss_user_name", $_SESSION['user_name']);		//사용자 이름
			define("ss_organ_id", $organ_id);					//지자체 아이디
			// define("ss_organ_code", $_SESSION['organ_code']);	//지자체 지역코드
			define("ss_organ_name", $_SESSION['organ_name']);	//지자체 이름
			define("ss_sort_base", $_SESSION['sort_base']);		//장비 정렬 기준(0: 정렬순서, 1: 행정코드, 2: 장비이름)
			define("ss_is_rtu_id", $_SESSION['is_rtu_id']);		//방송장비 권한
			define("ss_is_login", $_SESSION['is_login']);		//로그인 상태(0: 비로그인, 1: 로그인)
			
			define("top_img", $tmp_top_img);					//상단바 로고 경로
			define("top_title", $rs[0]['top_title']);			//상단바 타이틀 제목
			define("top_text", $rs[0]['top_text']);				//상단바 타이틀 내용
			define("recaptcha", $rs[0]['recaptcha']);			//리캡차(0: 미사용, 1: 구글, 2: 기본)
			define("level_cnt", $rs[0]['level_cnt']);			//경계 단계(2, 3, 5)
			define("load_time", $rs[0]['load_time'] * 1000);	//현황 Refresh 간격
			define("alarm_cnt", $rs[0]['alarm_cnt']);			//방송현황 표현 개수
			define("alert_cnt", $rs[0]['alert_cnt']);			//최근경보 표현 개수
			define("board_type", $rs[0]['board_type']);			//상황판 타입(0: 미사용, 1: 통합관제, 2: 별도상황판)
			define("board_url", $rs[0]['board_url']);			//별도상황판 사용 시 경로
			define("vm_speaker", $rs[0]['vm_speaker']);			//VW_SPEAKER_ID
			define("vm_voice", $rs[0]['vm_voice']);				//VW_VOICE_FORMAT
			define("vm_ip", $rs[0]['vm_ip']);					//미리듣기 아이피 *
			define("vm_port", $rs[0]['vm_port']);				//미리듣기 포트 *
			define("town_use", $rs[0]['town_use']);				//마을방송 사용 여부(0: 미사용, 1: 사용)
			define("vhf_use", $rs[0]['vhf_use']);				//vhf 사용 여부(0: 미사용, 1: 사용)
			define("sms_call", $rs[0]['sms_call']);				//sms 기본 회신 번호 *
			define("sms_type", $rs[0]['sms_type']);				//sms 전송 방식(0: emma, 1: xroshot)
			define("sms_ip", $rs[0]['sms_ip']);					//sms ip *
			define("sms_port", $rs[0]['sms_port']);				//sms port *
			define("sms_id", $rs[0]['sms_id']);					//sms id *
			define("sms_pw", $rs[0]['sms_pw']);					//sms pw *
			define("sms_db", $rs[0]['sms_db']);					//sms db명 *
			define("xro_use", $rs[0]['xro_use']);				//xroshot vms 사용 여부(0: 미사용, 1: 사용)
			define("xro_ip", $rs[0]['xro_ip']);					//xroshot vms ip *
			define("xro_port", $rs[0]['xro_port']);				//xroshot vms port *
			define("xro_id", $rs[0]['xro_id']);					//xroshot vms id *
			define("xro_pw", $rs[0]['xro_pw']);					//xroshot vms pw *
			define("xro_db", $rs[0]['xro_db']);					//xroshot vms db명 *
			define("naver_api", $rs[0]['naver_api']);			//네이버 api key *
			define("daum_api", $rs[0]['daum_api']);				//다음 api key *
			
			if(ss_sort_base == 0){
				// define("sort", "SORT_FLAG");
				define("sort", "DISPLAY_IDX");
			}else if(ss_sort_base == 1){
				define("sort", "AREA_CODE");
			}else if(ss_sort_base == 2){
				define("sort", "RTU_NAME");
			}

			if(level_cnt == 2){
				define("level_1", "경계치");		
				define("level_2", "위험치");		
				define("event_code_on", "19, 20, 23, 25");
				define("event_code_off", "22, 24, 26");
				define("event_code_all", "19, 20, 22, 23, 24, 25, 26");
			}else if(level_cnt == 3){
				define("level_1", "경계치");
				define("level_2", "위험치");
				define("level_3", "중위험");
				define("event_code_on", "19, 20, 21, 23, 25, 27");
				define("event_code_off", "22, 24, 26, 28");
				define("event_code_all", "19, 20, 21, 22, 23, 24, 25, 26, 27, 28");
			}else if(level_cnt == 4){
				define("level_1", "주의보");
				define("level_2", "경보");
				define("level_3", "대피");
				// define("level_4", "심각");
				define("event_code_on", "19, 20, 21, 23, 25, 27, 33, 37, 101, 102, 103, 104");
				define("event_code_off", "22, 24, 26, 28, 35, 105, 106, 107, 108");
				define("event_code_all", "19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 33, 35, 37, 101, 102, 103, 104, 105, 106, 107, 108");
			}else if(level_cnt == 5){
				define("level_1", "둔치주의");
				define("level_2", "둔치대피");
				define("level_3", "홍수주의");
				define("level_4", "홍수경보");
				define("level_5", "하천범람");
				define("event_code_on", "19, 20, 21, 23, 25, 27, 33, 34, 37, 38, 101, 102, 103, 104");
				define("event_code_off", "22, 24, 26, 28, 35, 36, 105, 106, 107, 108");
				define("event_code_all", "19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 33, 34, 35, 36, 37, 38, 101, 102, 103, 104, 105, 106, 107, 108");
			}
			
			unset($rs); unset($rs2);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   기본 환경설정 저장
	 */
	function setSetting(){
		if(DB == "0"){
			$sql = " UPDATE dn_setting SET 
					 top_img = '".$_REQUEST['top_img']."',
					 top_title = '".$_REQUEST['top_title']."',
					 top_text = '".$_REQUEST['top_text']."',
					 recaptcha = ".$_REQUEST['recaptcha'].",
					 level_cnt = ".$_REQUEST['level_cnt'].",
					 load_time = ".$_REQUEST['load_time']."";
			$sql.= " WHERE set_idx = ".ss_organ_id." ";

			// echo $sql;
			//시스템 지역 코드 설정
			if($_SESSION['user_type'] == 7 && $_REQUEST['area_code']){
				$sql = " UPDATE wr_map_setting SET
				SIG_CD = '".$_REQUEST['area_code']."' ";
			}
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   메뉴 설정 저장
	 */
	function setMenu(){
		if( $this->setMenuTop() && $this->setMenuSub()  && $this->popUpmenu() && $this->Reportmenu()){
			return true;
		}else{
			return false;
		}
	}
	function setMenuTop(){
		if(DB == "0"){
			$top_idx = $_REQUEST['top_idx'];
			$top_use = $_REQUEST['top_use'];
			foreach($top_idx as $key => $val){
				if($top_idx[$key] != '7'){	// 환경설정은 사용 변경하지 않음
					$sql = " UPDATE dn_menu_top SET menu_use = '".$top_use[$key]."'
						 WHERE menu_idx = '".$val."' ";
					
					if( $this->DB->QUERYONE($sql) ){
						$arrReturn[] = true;
					}else{
						$arrReturn[] = false;
					}
					$this->DB->parseFree();
				}
			}
			
			if( in_array(false, $arrReturn) ){
				$sqlReturn = false;
			}else{
				$sqlReturn = true;
			}
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	function setMenuSub(){
		if(DB == "0"){
			$sub_idx = $_REQUEST['sub_idx'];
			$sub_num = $_REQUEST['sub_num'];
			$sub_level = $_REQUEST['sub_level'];
			$sub_use = $_REQUEST['sub_use'];
			foreach($sub_idx as $key => $val){
				if($sub_use[$key] == '0'){	// 미사용 선택 => 최고관리자 이하이면 menu_level -1(한단계 올림), 사용으로...21/01/06 서정명
					if($sub_level[$key] != '1'){
						$sub_level[$key] = $sub_level[$key] - 1;
						$sub_use[$key] = '1';
					}
				}
				$sql = " UPDATE dn_menu_in SET menu_level = '".$sub_level[$key]."', menu_use = '".$sub_use[$key]."'
						 WHERE menu_idx = '".$val."' AND menu_num = '".$sub_num[$key]."' ";
					
				if( $this->DB->QUERYONE($sql) ){
					$arrReturn[] = true;
				}else{
					$arrReturn[] = false;
				}
				$this->DB->parseFree();
			}
			
			if( in_array(false, $arrReturn) ){
				$sqlReturn = false;
			}else{
				$sqlReturn = true;
			}
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}

	function popUpmenu(){
		if(DB == "0"){
			$popup_http = $_REQUEST['url'];
			$popup_idx = $_REQUEST['popup_idx'];
			$popup_level = $_REQUEST['popup_level'];
			$popup_use = $_REQUEST['popup_use'];
			$popup_url = $_REQUEST['popup_url'];
			foreach($popup_idx as $key => $val){
				if($popup_use[$key] == '0'){	// 미사용 선택 => 최고관리자 이하이면 menu_level -1(한단계 올림), 사용으로...21/01/06 서정명
					if($popup_level[$key] != '1'){
						$popup_level[$key] = $popup_level[$key] - 1;
						$popup_use[$key] = '1';
						// $popup_url[$key] = $popup_url[$key];
					}
				}
				$sql = " UPDATE dn_direct_url SET menu_url = '".$popup_http[$key].$popup_url[$key]."' , menu_level = '".$popup_level[$key]."', menu_use = '".$popup_use[$key]."'
						 WHERE menu_idx = '".$val."' ";

						 if( $this->DB->QUERYONE($sql) ){
							$arrReturn[] = true;
						}else{
							$arrReturn[] = false;
						}
						$this->DB->parseFree();
					}
					
					if( in_array(false, $arrReturn) ){
						$sqlReturn = false;
					}else{
						$sqlReturn = true;
					}
					return $sqlReturn;
				}else if(DB == "1"){
					// ORACLE
				}
			}

	function Reportmenu(){
		if(DB == "0"){
			$report_idx = $_REQUEST['idx'];
			$report_num = $_REQUEST['report_num'];
			$report_name = $_REQUEST['report_name'];
			$report_use = $_REQUEST['report_use'];
			foreach($report_idx as $key => $val){
				$sql = " UPDATE dn_report_url SET ";		
				if($report_use){
					$sql .= "report_use = '".$report_use[$key]."'";
				}
					$sql .=	" WHERE report_num = '".$report_num[$key]."' ";

							if( $this->DB->QUERYONE($sql) ){
							$arrReturn[] = true;
						}else{
							$arrReturn[] = false;
						}
						

						$this->DB->parseFree();
					}
					
					if( in_array(false, $arrReturn) ){
						$sqlReturn = false;
					}else{
						$sqlReturn = true;
					}
					return $sqlReturn;
				}else if(DB == "1"){
					// ORACLE
				}
			}
	
	/**
	*   레이아웃 정보
	*/
	function getLayout(){
		if(DB == "0"){
			$sql = " SELECT lay_idx, lay_case
					 FROM dn_layout
					 WHERE lay_idx = ".ss_organ_id." ";
		
			$rs = $this->DB->execute($sql);
		
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['lay_idx'] = $rs[$i]['lay_idx'];
				$data[$i]['lay_case'] = $rs[$i]['lay_case'];
			}
			$this->rsLayoutList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	function getLayoutItem(){
		if(DB == "0"){
			$sql = " SELECT b.lay_area, b.lay_item, b.lay_ival
					 FROM dn_layout AS a
					 LEFT JOIN dn_layout_item AS b ON a.lay_idx = b.lay_idx 
					 WHERE a.lay_idx = ".ss_organ_id." 
					 ORDER BY b.lay_area, b.lay_item ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['lay_area'] = $rs[$i]['lay_area'];
				$data[$i]['lay_item'] = $rs[$i]['lay_item'];
				$data[$i]['lay_ival'] = $rs[$i]['lay_ival'];
			}
			$this->rsItemList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	function getLayoutIval(){
		if(DB == "0"){
			$sql = " SELECT lay_ival, lay_text
					 FROM dn_layout_ival ";
		
			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['lay_ival'] = $rs[$i]['lay_ival'];
				$data[$i]['lay_text'] = $rs[$i]['lay_text'];
			}
			$this->rsIvalList = $data;
			
			unset($rs); unset($data);
			$this->DB->parseFree();
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
	/**
	 *   레이아웃 저장
	 */
	function setLayout(){
		if( $this->setCase() && $this->setItem() ){
			return true;
		}else{
			return false;
		}
	}
	function setCase(){
		if(DB == "0"){
			$sql = " SELECT * FROM dn_layout
					 WHERE lay_idx = ".ss_organ_id." ";
			
			$rs = $this->DB->execute($sql);
			$this->DB->parseFree();
			
			if($rs[0]){
				$sql = " DELETE FROM dn_layout 
						 WHERE lay_idx = ".ss_organ_id." ";
				$this->DB->QUERYONE($sql);
				$this->DB->parseFree();
				
				$sql = " DELETE FROM dn_layout_item
						 WHERE lay_idx = ".ss_organ_id." ";
				$this->DB->QUERYONE($sql);
				$this->DB->parseFree();
			}
	
			$sql = " INSERT INTO dn_layout (lay_idx, lay_case)
					 VALUES (".ss_organ_id.", ".$_REQUEST['lay_case'].") ";
			
			if($this->DB->QUERYONE($sql)) $sqlReturn = true;
			$this->DB->parseFree();
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}
	function setItem(){
		if(DB == "0"){
			foreach($_REQUEST['data'] as $key => $val){
				foreach($val as $key2 => $val2){
					$sql = " INSERT INTO dn_layout_item (lay_idx, lay_area, lay_item, lay_ival)
							 VALUES (".ss_organ_id.", ".($key + 1).", ".($key2 + 1).", ".$val2." ) ";
					
					if( $this->DB->QUERYONE($sql) ){
						$arrReturn[] = true;
					}else{
						$arrReturn[] = false;
					}
					$this->DB->parseFree();
				}
			}
			
			if( in_array(false, $arrReturn) ){
				$sqlReturn = false;
			}else{
				$sqlReturn = true;
			}
			return $sqlReturn;
		}else if(DB == "1"){
			// ORACLE
		}
	}

	function getReportList($type){
		if(DB == "0"){
			
			$sql = " SELECT * FROM dn_report_url ";
			if($type == 1){
			$sql .= "WHERE report_use = '1' order by idx ";
			}else{
			$sql .= "order by idx ";	
			}

			$rs = $this->DB->execute($sql);
			
			for($i=0; $i<$this->DB->NUM_ROW(); $i++){
				$data[$i]['idx'] = $rs[$i]['idx'];
				$data[$i]['report_num'] = $rs[$i]['report_num'];
				$data[$i]['report_name'] = $rs[$i]['report_name'];
				$data[$i]['report_use'] = $rs[$i]['report_use'];
			}
			$this->rsReportOri = $data;
			
		}else if(DB == "1"){
			// ORACLE
		}
	}
	
}//End Class
?>