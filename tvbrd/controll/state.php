<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 장비상태
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");


#################################################################################################################################
# DB connection
#################################################################################################################################
require_once "../db/_Db.php";


#################################################################################################################################
# class 및 function lib
#################################################################################################################################
require_once "../class/DateMake.php";#시간 class
require_once "../class/divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class


#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();


$mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
$arr_area_code = $_REQUEST["arr_area_code"];
$area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);
$siteID =  $dvUtil->xss_clean($_REQUEST["siteID"]);

if(!isset($mode) && empty($mode)){
	$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
	echo json_encode( $returnBody );
	exit;
}

switch($mode) {
	case 'state':
		$arr_data = array();
		
		if($arr_area_code){
			foreach($arr_area_code as $key => $val){
				$qry = " SELECT * FROM state_hist
						 WHERE area_code = '".$val."'
						 ORDER BY log_date DESC LIMIT 1 ";

				//echo $qry;
				$data = $DB->execute($qry);
				$DB->rs_unset();
				
				$arr_data[$key]['area_code'] = $val;
				$arr_data[$key]['mainamp_stat'] = false;
				$arr_data[$key]['amp_power'] = false;
				$arr_data[$key]['logger_stat'] = false;
				$arr_data[$key]['door_stat'] = false;
				$arr_data[$key]['sensor_stat'] = false;
				$arr_data[$key]['log_date'] = "";
				$arr_data[$key]['line'] = false;
				
				if( isset($data[0]['LOG_DATE']) ){
					$arr_data[$key]['mainamp_stat'] = ($data[0]['MAINAMP_STAT'] == 0) ? true : false;
					$arr_data[$key]['amp_power'] = ($data[0]['AMP_POWER'] == 0) ? true : false;
					$arr_data[$key]['logger_stat'] = ($data[0]['LOGGER_STAT'] == 0) ? true : false;
					$arr_data[$key]['door_stat'] = ($data[0]['DOOR_STAT'] == 0) ? false : true;
					$arr_data[$key]['sensor_stat'] = ($data[0]['SENSOR_STAT'] == 0) ? true : false;
					$arr_data[$key]['log_date'] = $data[0]['LOG_DATE'];
					
					// 현재 시간 2시간 전 데이터가 있을 경우
					if( $DM->getCompare( $data[0]['LOG_DATE'], $DM->getBefTwoTime() ) ){
						$arr_data[$key]['line'] = true;
					}else{
						$arr_data[$key]['line'] = false;
					}
				}
			}
		}
		
		$returnBody = array( 'result' => true, 'list' => $arr_data );
		echo json_encode( $returnBody );
		exit;
		break;
		
	case 'state_slide':
		// 기본 장비상태 내역
		$qry = " SELECT * FROM organ_info ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM rtu_info AS a
				 LEFT JOIN rtu_location AS b ON a.rtu_id = b.rtu_id
    			 WHERE area_code = '".$area_code."' ";
		$data2 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM wr_rtu_state
    			 WHERE kind = 1 AND area_code = '".$area_code."' ";
		$data3 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM state_hist
    			 WHERE area_code = '".$area_code."' 
				 ORDER BY log_date DESC LIMIT 1 ";
		$data4 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM dn_as_log
    			 WHERE as_case = 1 AND area_code = '".$area_code."'
    			 ORDER BY as_idate DESC LIMIT 3 ";
		$as = $DB->execute($qry);
		$DB->rs_unset();
		
		$returnBody = array( 'result' => true, 'data' => $data[0], 'data2' => $data2[0], 'data3' => $data3[0], 'data4' => $data4[0], 'as' => $as );
		echo json_encode( $returnBody );
		exit;
		break;
		
	case 'state_slide2':
		$type =  $_REQUEST["type"];
		
		// 서브 장비상태 내역
		$qry = " SELECT * FROM organ_info ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		if($type == 2){ // 문자전광판
			$qry = " SELECT * FROM wr_map_sub_info AS a
					 LEFT JOIN sb_signinfo AS b ON a.sub_id = b.siteID
	    			 WHERE a.area_code = '".$area_code."' AND a.sub_type = '2' ";
		}else if($type == 3){ // 스틸컷
			$qry = " SELECT * FROM wr_map_sub_info AS a
					 LEFT JOIN display_info AS b ON a.area_code = b.area_code
	    			 WHERE a.area_code = '".$area_code."' AND a.sub_type = '3' ";
		}
		$data2 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM wr_rtu_state
    			 WHERE kind = 2 AND area_code = '".$area_code."' ";
		$data3 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM state_hist
    			 WHERE area_code = '".$area_code."'
				 ORDER BY log_date DESC LIMIT 1 ";
		$data4 = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM dn_as_log
    			 WHERE as_case = 2 AND area_code = '".$area_code."'
    			 ORDER BY as_idate DESC LIMIT 3 ";
		$as = $DB->execute($qry);
		$DB->rs_unset();
		
		$returnBody = array( 'result' => true, 'data' => $data[0], 'data2' => $data2[0], 'data3' => $data3[0], 'data4' => $data4[0], 'as' => $as );
		echo json_encode( $returnBody );
		exit;
		break;
		
	case 'state_img_up':
		$kind = $_REQUEST['kind'];
		
		// 장비 이미지 변경
		if($_FILES['state_img2']['tmp_name']){
			$rs_img = $dvUtil->imgUpload(2, "state_img2", 0);
			if($rs_img[0] == 1){
				$qry = " UPDATE wr_rtu_state SET img = '".$rs_img[1]."'
						 WHERE kind = '".$kind."' AND area_code = '".$area_code."' ";
				$rs = $DB->queryone($qry);
			}
			$check = $rs_img;
			$DB->close();
		}else{
			$check = array(1, "");
		}
		$array = array( 'result' => true, 'check' => $check );
		echo json_encode( $array );
		exit;
		break;
		
	case 'state_text_up':
		$kind = $_REQUEST['kind'];
		$classify = $_REQUEST['classify'];
		$addr = $_REQUEST['addr'];
		$addr_detail = $_REQUEST['addr_detail'];
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];
		
		// 장비 정보 체크
		$qry = " SELECT idx FROM wr_rtu_state
    			 WHERE kind = '".$kind."' AND area_code = '".$area_code."' ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		if($data[0]){
			// 장비 정보 변경
			$qry = " UPDATE wr_rtu_state SET classify = '".$classify."', addr = '".$addr."',
				 addr_detail = '".$addr_detail."', start_date = '".$start_date."',
				 end_date = '".$end_date."'
				 WHERE kind = '".$kind."' AND area_code = '".$area_code."' ";
			$rs = $DB->queryone($qry);
			$DB->close();
		}else{
			// 장비 정보 등록
			$qry = " INSERT INTO wr_rtu_state (kind, area_code, classify, addr, addr_detail, start_date, end_date)
				     VALUES ('".$kind."', '".$area_code."', '".$classify."', '".$addr."', '".$addr_detail."',
				     '".$start_date."', '".$end_date."') ";
			$rs = $DB->queryone($qry);
			$DB->close();
		}
		$array = array( 'result' => true, 'check' => $rs );
		echo json_encode( $array );
		exit;
		break;
		
	case 'state_as':
		// 장비 정보 등록 START
		//$url = "http://192.168.1.63:8092/wr_insert_add_outer.php";
		$url = "http://hwajintni.co.kr:9499/_map/wr_insert_add_outer.php";
		$post_data = $_POST;
		
		// CURL 세션 초기화
		$curl = curl_init();
		
		// CURL 옵션 설정
		curl_setopt($curl, CURLOPT_URL, $url); // url 설정
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 결과 값 텍스트로 저장
		
		// CURL 세션 실행
		$rs = curl_exec($curl);
		$ck = curl_getinfo($curl);
		
		// CURL 세션 종료
		curl_close($curl);
		// 장비 정보 등록 END
		
		if($ck['http_code'] == 200){
			if($rs == "1"){
				// AS 신청 START
				//$url2 = "http://192.168.1.63:8092/monitoring/wr_monitoring.php";
				$url2 = "http://hwajintni.co.kr:9499/_map/monitoring/wr_monitoring.php";
				$post_data2 = $_POST;
				
				// CURL 세션 초기화
				$curl2 = curl_init();
				
				// CURL 옵션 설정
				curl_setopt($curl2, CURLOPT_URL, $url2); // url 설정
				curl_setopt($curl2, CURLOPT_POST, 1);
				curl_setopt($curl2, CURLOPT_POSTFIELDS, $post_data2);
				curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1); // 결과 값 텍스트로 저장
				
				// CURL 세션 실행
				$rs2 = curl_exec($curl2);
				$ck2 = curl_getinfo($curl2);
				
				// CURL 세션 종료
				curl_close($curl2);
				// AS 신청 END
				
				if($ck2['http_code'] == 200){
					if($rs2 == "1"){
						$msg = "AS 신청이 완료 됐습니다. ";
						$error = false;
						
						// AS 접수 내역
						$kind = $_REQUEST['kind'];
						$area_code = $_REQUEST['AREA_CODE'];
						$as_content = $_REQUEST['as_content'];
						//$name = strrev($_COOKIE["keyUserName"]);
						$name = $_COOKIE["keyUserName"];
						
						$qry = " INSERT INTO dn_as_log (as_case, area_code, as_content, as_iname, as_idate)
				    	         VALUES ( '".$kind."', '".$area_code."', '".$as_content."', '".$name."', NOW() ) ";
						$rs = $DB->queryone($qry);
						$DB->close();
						
					}else if($rs2 == "2"){
						$msg = "AS 신청중 오류가 발생 했습니다.";
						$error = true;
					}
				}else{
					$msg = "AS 신청중 오류가 발생 했습니다.";
					$error = true;
				}
			}
		}else{
			$msg = "장비 정보 전송중 오류가 발생 했습니다.";
			$error = true;
		}
		
		$returnBody = array( 'result' => true, 'msg' => $msg, 'error' => $error);
		echo json_encode( $returnBody );
		exit;
		break;
}
?>


