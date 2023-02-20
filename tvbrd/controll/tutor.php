<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지도 DB con
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");

#################################################################################################################################
# DB connection
#################################################################################################################################
require_once "../db/_Db.php";
require_once "../_common.php";
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

$mode = $dvUtil->xss_clean($_REQUEST["mode"]);
$sub_mode = $dvUtil->xss_clean($_REQUEST['sub_mode']);

define("event_code_on", "19, 20, 21, 23, 25, 27, 33, 37, 101, 102, 103, 104, 105, 106, 107, 108");
define("event_code_all", "19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 33, 35, 37, 101, 102, 103, 104, 105, 106, 107, 108");

if(!isset($mode) && empty($mode)){
	$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
	echo json_encode( $returnBody );
	exit;
}

switch($mode) {
	case 'locallist':
		// 지도 기본 세팅
		$qry = " SELECT
					setval, x_organ, y_organ, top_text, top_img, map_skin, map_type, map_sub, x_cent, y_cent,
					map_level, map_move, map_size, map_box, map_data, map_kind, over_level, clus_level, sig_cd, api_key, udate
				 FROM
					wr_map_setting
				 LIMIT 1 ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		$arr_setting = array();
		$arr_setting['setval'] = $data[0]['setval'];
		$arr_setting['top_text'] = $data[0]['top_text'];
		$arr_setting['top_img'] = $data[0]['top_img'];
		$arr_setting['x_organ'] = $data[0]['x_organ'];
		$arr_setting['y_organ'] = $data[0]['y_organ'];
		$arr_setting['map_skin'] = $data[0]['map_skin'];
		$arr_setting['map_type'] = $data[0]['map_type'];
		$arr_setting['map_sub'] = $data[0]['map_sub'];
		$arr_setting['map_cent'][0] = $data[0]['x_cent'];
		$arr_setting['map_cent'][1] = $data[0]['y_cent'];
		$arr_setting['map_level'] = $data[0]['map_level'];
		$arr_setting['map_move'] = $data[0]['map_move'];
		$arr_setting['map_size'] = $data[0]['map_size'];
		$arr_setting['map_box'] = $data[0]['map_box'];
		$arr_setting['map_data'] = $data[0]['map_data'];
		$arr_setting['map_kind'] = $data[0]['map_kind'];
		$arr_setting['over_level'] = $data[0]['over_level'];
		$arr_setting['clus_level'] = $data[0]['clus_level'];
		$arr_setting['sig_cd'] = $data[0]['sig_cd'];
		$arr_setting['api_key'] = $data[0]['api_key'];
		$arr_setting['udate'] = $data[0]['udate'];

		// 폴리곤 세팅 및 json 파일 체크
		$qry = " SELECT ctprvn_cd, sig_cd, emd_cd, emd_kor_nm, x_cent, y_cent 
				 FROM wr_map_info 
				 WHERE sig_cd LIKE CONCAT(LEFT('".$data[0]['sig_cd']."',4),'%')";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$arr_json = array();
		$arr_poly = array();
		$arr_emdnm = array();
		if($data){
			foreach($data as $key => $val){
				if( !$arr_json[ $val['sig_cd'] ] ){
					$arr_json[ $val['sig_cd'] ]['json_url'] = $val['ctprvn_cd']."/".$val['sig_cd'];
					
					$tmp_path = "../geojson/".$val['ctprvn_cd']."/".$val['sig_cd'].".geojson";
					if( file_exists($tmp_path) ){
						$arr_json[ $val['sig_cd'] ]['check'] = true;
					}else{
						$arr_json[ $val['sig_cd'] ]['check'] = false;
					}
				}
				$arr_poly[ $val['emd_cd'] ]['emd_name'] = $val['emd_kor_nm']; // 폴리곤 읍면동 이름
				$arr_poly[ $val['emd_cd'] ]['x_cent'] = $val['x_cent']; // 폴리곤 중심 x 좌표
				$arr_poly[ $val['emd_cd'] ]['y_cent'] = $val['y_cent']; // 폴리곤 중심 y 좌표
				$arr_poly[ $val['emd_cd'] ]['type'] = ""; // 폴리곤 타입
				$arr_poly[ $val['emd_cd'] ]['path'] = array(); // 폴리곤 좌표
				$arr_poly[ $val['emd_cd'] ]['hole'] = array(); // 폴리곤 구멍 좌표
				$arr_poly[ $val['emd_cd'] ]['polygon'] = array(); // 폴리곤 객체
				$arr_poly[ $val['emd_cd'] ]['polygon_cnt'] = 0; // 읍면동 장비 개수
				$arr_poly[ $val['emd_cd'] ]['polygon_sum'] = 0; // 읍면동 강우 합계
				$arr_poly[ $val['emd_cd'] ]['yebo_marker'] = ""; // 예보 마커
				$arr_poly[ $val['emd_cd'] ]['yebo_overlay'] = ""; // 예보 오버레이
				$arr_emdnm[ $val['emd_kor_nm'] ] = $val['emd_cd']; // 읍면동 이름에 따른 읍면동 코드
			}
		}
		
		// 메인 장비 정보와 읍면동 정보 매칭
		$qry = " SELECT c.ctprvn_cd, c.sig_cd, c.emd_cd, a.area_code, a.rtu_id, a.rtu_type, a.rtu_name, b.wr_x_point, b.wr_y_point, d.x , d.y
				 FROM rtu_info AS a
				 LEFT JOIN rtu_location AS b ON a.rtu_id = b.rtu_id
				 LEFT JOIN wr_map_info AS c ON b.wr_emd_cd = c.emd_cd
				 LEFT JOIN overlay_state AS d ON a.area_code = d.area_code
				 WHERE a.area_code IS NOT NULL ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		$arr_data = array(); // 장비 센서별 정보
		$arr_name = array('rain', 'flow', 'snow', 'aws', 'alarm', 'mix', 'cctv', 'sign', 'stillcut', 'displace', 'eqk');
		foreach($arr_name as $key => $val){
			$arr_data[$val]['cnt'] = 0;
			$arr_data[$val]['area_code'] = array();
		}
		$arr_rtu = array();
		if($data){
			// $keyTosRtuID = keyTosRtuID;
			// $arr_keyTosRtuID = split(",", $keyTosRtuID);
			
			foreach($data as $key => $val){
				// 쿠키 값에 따른 방송 장비 표시 제한
// 				if($keyTosRtuID){
// // 					if($val['rtu_type'] == "B00"){
// 						if( !in_array($val['rtu_id'], $arr_keyTosRtuID) ) continue;
// // 					}
// 				}
				$arr_rtu[ $val['area_code'] ]['ctprvn_cd'] = $val['ctprvn_cd'];
				$arr_rtu[ $val['area_code'] ]['sig_cd'] = $val['sig_cd'];
				$arr_rtu[ $val['area_code'] ]['emd_cd'] = $val['emd_cd'];
				$arr_rtu[ $val['area_code'] ]['area_code'] = $val['area_code'];
				$arr_rtu[ $val['area_code'] ]['rtu_id'] = $val['rtu_id'];
				$arr_rtu[ $val['area_code'] ]['rtu_name'] = $val['rtu_name'];
				$arr_rtu[ $val['area_code'] ]['x_point'] = $val['wr_x_point'];
				$arr_rtu[ $val['area_code'] ]['y_point'] = $val['wr_y_point'];
				$arr_rtu[ $val['area_code'] ]['overlay_x'] = $val['x'];
				$arr_rtu[ $val['area_code'] ]['overlay_y'] = $val['y'];
				$arr_rtu[ $val['area_code'] ]['marker'] = "";
				$arr_rtu[ $val['area_code'] ]['overlay'] = "";
				$arr_rtu[ $val['area_code'] ]['polyline'] = ""; // 장비 상태 선
				$arr_rtu[ $val['area_code'] ]['overlay_on'] = ""; // 장비 오버레이 온오프 상태
				$arr_rtu[ $val['area_code'] ]['state'] = ""; // 장비 상태
				$arr_rtu[ $val['area_code'] ]['line'] = ""; // 장비 통신 상태
				$arr_rtu[ $val['area_code'] ]['alert_state'] = ""; // 장비 경고 온오프 상태
				$arr_rtu[ $val['area_code'] ]['alert_step'] = ""; // 장비 경고 진행 단계
				$arr_rtu[ $val['area_code'] ]['alert_error'] = array(); // 장비 경고 에러 정보(에러 여부, 에러 코드)
				$arr_rtu[ $val['area_code'] ]['sensor_kind'] = array(); // 장비 센서 종류
				$arr_rtu[ $val['area_code'] ]['sensor_cnt'] = 0; // 장비 센서 개수(방송 센서가 없기 때문에 방송 장비는 + 1)
				$arr_rtu[ $val['area_code'] ]['sensor_type'] = array(); // 장비 센서 타입
				$arr_rtu[ $val['area_code'] ]['rtu_type'] = $val['rtu_type']; // 장비 타입
				$arr_rtu[ $val['area_code'] ]['rain'] = "-"; // 강우 데이터
				$arr_id[ $val['rtu_id'] ] = $val['area_code'];
				
				// 장비 센서별 개수
				if($val['rtu_type'] == "A00") $arr_data['aws']['cnt']++;
				else if($val['rtu_type'] == "B00" || $val['rtu_type'] == "BR0" || $val['rtu_type'] == "BF0" || $val['rtu_type'] == "BA0") $arr_data['alarm']['cnt']++;
			}
		}
		
		// 메인 장비 타입 및 센서
		$qry = " SELECT a.area_code, a.rtu_type, b.sensor_type, c.rtu_id
				 FROM rtu_info AS a
				 LEFT JOIN rtu_sensor AS b ON a.rtu_id = b.rtu_id
				 LEFT JOIN rtu_location AS c ON b.rtu_id = c.rtu_id
				 WHERE b.sensor_type IS NOT NULL AND c.rtu_id IS NOT NULL ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		if($data){
			foreach($data as $key => $val){
				if($arr_rtu[ $val['area_code'] ]){
					
					$arr_rtu[ $val['area_code'] ]['sensor_cnt']++;
					$arr_rtu[ $val['area_code'] ]['sensor_type'][] = $val['sensor_type'];
					
					// 장비 센서별 개수 (R, F, S 센서는 배제함)
					if($val['sensor_type'] == "0") $arr_data['rain']['cnt']++;
					else if($val['sensor_type'] == "1") $arr_data['flow']['cnt']++;
					else if($val['sensor_type'] == "2") $arr_data['snow']['cnt']++;
				}
			}
		}
		
		if($arr_rtu){
			foreach($arr_rtu as $key => $val){
				//var_dump($val);
				if($val['rtu_type'] == "A00"){
					$arr_data['aws']['area_code'][] = $val['area_code'];
				}else{
					if( $val['rtu_type'] == "B00" || $val['rtu_type'] == "BR0" || $val['rtu_type'] == "BF0" || $val['rtu_type'] == "BA0" ){
						if( $val['sensor_cnt'] == 0 ){
							$arr_data['alarm']['area_code'][] = $val['area_code'];
						}else{
							if($arr_rtu[ $val['area_code'] ]['sensor_type'] == "3"){
								$arr_data['alarm']['area_code'][] = $val['area_code'];
							}else{
								$arr_data['mix']['area_code'][] = $val['area_code'];
								$arr_data['mix']['cnt']++;
							}
						}
						$arr_rtu[ $val['area_code'] ]['sensor_cnt']++;
					}else{
						if( $val['sensor_cnt'] > 1 ){
							$arr_data['mix']['area_code'][] = $val['area_code'];
							$arr_data['mix']['cnt']++;
						}else if( $val['sensor_cnt'] == 0 ){
							if($val['rtu_type'] == "R00"){
								$arr_data['rain']['area_code'][] = $val['area_code'];
							}else if($val['rtu_type'] == "F00"){
								$arr_data['flow']['area_code'][] = $val['area_code'];
							}else if($val['rtu_type'] == "S00"){
								$arr_data['snow']['area_code'][] = $val['area_code'];
							}else if($val['rtu_type'] == "RF0"){
								$arr_data['mix']['area_code'][] = $val['area_code'];
								$arr_data['mix']['cnt']++;
							}else if($val['rtu_type'] == "DP0"){
								$arr_data['displace']['area_code'][] = $val['area_code'];
								$arr_data['displace']['cnt']++;
							}else if($val['rtu_type'] == "EQ0"){
								$arr_data['eqk']['area_code'][] = $val['area_code'];
								$arr_data['eqk']['cnt']++;
							}
						}else if( $val['sensor_cnt'] == 1 ){
							if( in_array("0", $val['sensor_type']) || in_array("R", $val['sensor_type']) ){
								$arr_data['rain']['area_code'][] = $val['area_code'];
							}else if( in_array("1", $val['sensor_type']) || in_array("F", $val['sensor_type']) ){
								$arr_data['flow']['area_code'][] = $val['area_code'];
							}else if( in_array("2", $val['sensor_type']) || in_array("S", $val['sensor_type']) ){
								$arr_data['snow']['area_code'][] = $val['area_code'];
							}else if( in_array("DP", $val['sensor_type'])){
								$arr_data['displace']['area_code'][] = $val['area_code'];
								$arr_data['displace']['cnt']++;
							}else if( in_array("EQ", $val['sensor_type'])){
								$arr_data['eqk']['area_code'][] = $val['area_code'];
								$arr_data['eqk']['cnt']++;
							}
						}
					} // if($val['rtu_type'] == "B00") else end
				} // if($val['rtu_type'] == "A00") else end
				
				if( $val['rtu_type'] == "B00" || $val['rtu_type'] == "BR0" || $val['rtu_type'] == "BF0" || $val['rtu_type'] == "BA0" ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "alarm");
				}
				if( in_array("0", $val['sensor_type']) || in_array("R", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "rain");
				}
				if( in_array("1", $val['sensor_type']) || in_array("F", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "flow");
				}
				if( in_array("2", $val['sensor_type']) || in_array("S", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "snow");
				}
				if( in_array("W", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "wind");
				}
				if( in_array("H", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "damp");
				}
				if( in_array("T", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "temp");
				}
				if( in_array("A", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "pres");
				}
				if( in_array("DP", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "displace");
				}
				if( in_array("EQ", $val['sensor_type']) ){
					array_push($arr_rtu[ $val['area_code'] ]['sensor_kind'], "eqk");
				}
			}
		}
		
		// 서브 장비 정보 (cctv, 문자전광판, 스틸컷, 먹는물)
		$qry = " SELECT sub_id, rtu_id, area_code, sub_name, sub_type, sub_x_point, sub_y_point
			 	 FROM wr_map_sub_info ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		$arr_data['cctv']['cnt'] = 0;
		$arr_data['sign']['cnt'] = 0;
		$arr_data['stillcut']['cnt'] = 0;
		$arr_data['water']['cnt'] = 0;
		// $arr_data['displace']['cnt'] = 0;
		$arr_sub_rtu = array();
		if($data){
			foreach($data as $key => $val){
				$arr_sub_rtu[ $val['sub_id'] ]['sub_id'] = $val['sub_id'];
				$arr_sub_rtu[ $val['sub_id'] ]['rtu_id'] = $val['rtu_id'];
				$arr_sub_rtu[ $val['sub_id'] ]['area_code'] = $val['area_code'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_name'] = $val['sub_name'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_type'] = $val['sub_type'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_x_point'] = $val['sub_x_point'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_y_point'] = $val['sub_y_point'];
				$arr_sub_rtu[ $val['sub_id'] ]['marker'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['overlay'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['polyline'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['overlay_on'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['state'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['change'] = "";
				
				// 장비 센서별 개수
				if($val['sub_type'] == 1){
					$arr_data['cctv']['cnt']++;
					$arr_data['cctv']['sub_id'][] = $val['sub_id'];
				}else if($val['sub_type'] == 2){
					$arr_data['sign']['cnt']++;
					$arr_data['sign']['sub_id'][] = $val['sub_id'];
				}else if($val['sub_type'] == 3){
					$arr_data['stillcut']['cnt']++;
					$arr_data['stillcut']['sub_id'][] = $val['sub_id'];
				}else if($val['sub_type'] == 4){
					$arr_data['water']['cnt']++;
					$arr_data['water']['sub_id'][] = $val['sub_id'];
				}else if($val['sub_type'] == 5){
					$arr_data['farm']['cnt']++;
					$arr_data['farm']['sub_id'][] = $val['sub_id'];
				}

			}
		}

		/*
		// 축산 정보
		$qry = " SELECT animal_kind1, IDX as sub_id , BUSINESS_NAME as sub_name , AREA_CODE as area_code
		, WR_X_POINT as sub_x_point , WR_Y_POINT as sub_y_point , license_num , BUSINESS_STATE
		FROM FARM_INFO order by animal_kind1 ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		$arr_data['farm']['cnt'] = 0;
		
		$arr_farm_rtu = array();
		if($data){
			foreach($data as $key => $val){
				
				$arr_sub_rtu[ $val['sub_id'] ]['animal_kind'] = $val['animal_kind1'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_id'] = $val['sub_id'];
				$arr_sub_rtu[ $val['sub_id'] ]['rtu_id'] = $val['sub_id'];
				$arr_sub_rtu[ $val['sub_id'] ]['license_num'] = $val['license_num'];
				$arr_sub_rtu[ $val['sub_id'] ]['area_code'] = $val['area_code'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_name'] = $val['sub_name'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_type'] = $val['sub_type'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_x_point'] = $val['sub_x_point'];
				$arr_sub_rtu[ $val['sub_id'] ]['sub_y_point'] = $val['sub_y_point'];
				$arr_sub_rtu[ $val['sub_id'] ]['BUSINESS_STATE'] = $val['BUSINESS_STATE'];
				$arr_sub_rtu[ $val['sub_id'] ]['marker'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['overlay'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['polyline'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['overlay_on'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['state'] = "";
				$arr_sub_rtu[ $val['sub_id'] ]['change'] = "";
				// 장비 센서별 개수
				$arr_data['farm']['cnt']++;
				$arr_data['farm']['sub_id'][ $val['sub_id'] ] = $val['sub_id'];
				$arr_data['farm']['animal_kind'][ $val['sub_id'] ] = $val['animal_kind1'];
			
			}
			//   var_dump($arr_data['farm']);
		}
		*/
		
		// 긴급방송등록 셀렉트
		$qry = " SELECT id, name, script_no 
				 FROM wr_alarm_emer 
				 ORDER BY sort LIMIT 8 ";
		$data = $DB->execute($qry);
		$DB->rs_unset();

		$arr_emer = array();
		if($data){
			foreach($data as $key => $val){
				$arr_emer[$key]['id'] = $val['id'];
				$arr_emer[$key]['name'] = $val['name'];
				$arr_emer[$key]['script_no'] = $val['script_no'];
			}
		}

		// 지구 별 선택 셀렉트
		$sql = " SELECT  *
				FROM WR_RTU_GROUP_INFO ORDER BY AREA_GRP_NO ";	  

		// echo $sql;
		$area_list = $DB->execute($sql);
		$DB->rs_unset();

		if($area_list){
			foreach($area_list as $key => $val){
				
				// 그룹별 RTU_ID - 주요지점(DN_MAIN_MEMBER)
				// $sql = "SELECT AREA_CODE FROM RTU_INFO WHERE RTU_ID IN (SELECT RTU_ID FROM DN_MAIN_MEMBER WHERE GROUP_ID = '".$val['AREA_GRP_NO']."') ";	  
				
				// 그룹별 RTU_ID - 경보그룹(ALARM_GROUP_MEMBER)
				$sql = "SELECT AREA_CODE FROM RTU_INFO WHERE RTU_ID IN (SELECT ORIGIN_RTU_ID FROM ALARM_GROUP_MEMBER WHERE ALARM_GRP_NO = '".$val['AREA_GRP_NO']."') ";	  
		
				// $area_rtu_list = $DB->FETCH_ASSOC($sql);
				$area_rtu_list = $DB->FETCH_ASSOC($sql);
				$DB->rs_unset();
				// var_dump($area_rtu_list);
				$temp_list = array();
				if($area_rtu_list){
					foreach($area_rtu_list as $key2 => $val2){
						if($val2["AREA_CODE"]){
							$temp_list[] = $val2["AREA_CODE"];
						}
					}
				}
				$arr_area_group[$key]['AREA_GRP_RTU_CDS'] = $temp_list;
				$arr_area_group[$key]['AREA_GRP_NO'] = $val['AREA_GRP_NO'];
				$arr_area_group[$key]['AREA_GRP_NAME'] = $val['AREA_GRP_NAME'];
				$arr_area_group[$key]['CENTER_X'] = $val['CENTER_X'];
				$arr_area_group[$key]['CENTER_Y'] = $val['CENTER_Y'];
				$arr_area_group[$key]['ZOOM_LEVEL'] = $val['ZOOM_LEVEL'];
			}
				$arr_area_group['result'] = true;
		}else{
			$arr_area_group['result'] = false;
		}
				
		$DB->close();
		$array = array( 'result' => true, 'setting' => $arr_setting, 'data' => $arr_data, 'json' => $arr_json, 'poly' => $arr_poly,
						'emdnm' => $arr_emdnm, 'id' => $arr_id, 'rtu' => $arr_rtu, 'sub_rtu' => $arr_sub_rtu, 'farm_rtu' => $arr_farm_rtu ,
						'emer' => $arr_emer, 'group' => $arr_area_group);
		echo json_encode( $array );
		exit;
		break;

	case 'map_setting':
		$data = $_REQUEST['data'];

		// 지도 스킨
		if($sub_mode == "map_skin"){
			$qry = " UPDATE wr_map_setting SET map_skin = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 지도 타입
		}else if($sub_mode == "map_type"){
			$qry = " UPDATE wr_map_setting SET map_type = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 우측 공간
		}else if($sub_mode == "map_sub"){
			$qry = " UPDATE wr_map_setting SET map_sub = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 지도 중심 좌표
		}else if($sub_mode == "map_cent"){
			$qry = " UPDATE wr_map_setting SET x_cent = '".$data[1]."', y_cent = '".$data[0]."' ";
			$rs = $DB->queryone($qry);
		// 지도 확대 레벨
		}else if($sub_mode == "map_level"){
			$qry = " UPDATE wr_map_setting SET map_level = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 지도 장비 이동 여부
		}else if($sub_mode == "map_move"){
			$qry = " UPDATE wr_map_setting SET map_move = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 오버레이 사이즈
		}else if($sub_mode == "map_size"){
			$qry = " UPDATE wr_map_setting SET map_size = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 오버레이 단위
		}else if($sub_mode == "map_box"){
			$qry = " UPDATE wr_map_setting SET map_box = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 표현 데이터
		}else if($sub_mode == "map_data"){
			$data = ($data) ? join(",", $data) : "";
			$qry = " UPDATE wr_map_setting SET map_data = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 지도 종류
		}else if($sub_mode == "map_kind"){
			$qry = " UPDATE wr_map_setting SET map_kind = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 오버레이 줌레벨
		}else if($sub_mode == "over_level"){
			$qry = " UPDATE wr_map_setting SET over_level = '".$data."' ";
			$rs = $DB->queryone($qry);
		// 클러스터 줌레벨
		}else if($sub_mode == "clus_level"){
			$qry = " UPDATE wr_map_setting SET clus_level = '".$data."' ";
			$rs = $DB->queryone($qry);
		}else if($sub_mode == "update_time"){
			$qry = " UPDATE wr_map_setting SET udate = '".$data."' ";
			$rs = $DB->queryone($qry);
		}

		$DB->close();
		$array = array( 'result' => true, 'check' => $rs );
		echo json_encode( $array );
		exit;
		break;
		
	case 'rtu_move_check':
		
		//print_r( $_REQUEST['name']);
		$name = $_REQUEST['name'];
		
		// 지역 이름 비교
		$qry = " SELECT a.ctprvn_cd, a.sig_cd, a.emd_cd
				 FROM wr_map_info as a , wr_map_setting as b
				 WHERE a.sig_kor_nm = '".$name[0]."' AND a.emd_kor_nm = '".$name[1]."' ";

				 
				//  echo $qry;
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		// json file 존재 여부 체크
		$data_check = false;
		$tmp_path = "../geojson/".$data[0]['ctprvn_cd']."/".$data[0]['sig_cd'].".geojson";
		if( file_exists($tmp_path) ){
			$data_check = true;
		}
		// 네이버 api 특정 위치 지역명 리턴 안하는 오류 있음
		if($name[0] == "" && $name[1] == ""){
			$data_check = true;
		}
			
		$DB->close();
		$array = array( 'result' => true, 'check' => $data_check );
		echo json_encode( $array );
		exit;
		break;
		
	case 'rtu_move':
		$rtu_id = $_REQUEST['rtu_id'];
		$point = $_REQUEST['point'];
		$name = $_REQUEST['name'];
		
		// 읍면동 코드 가져오기
		$qry = " SELECT ctprvn_cd, sig_cd, emd_cd
			 	 FROM wr_map_info
			 	 WHERE sig_kor_nm = '".$name[0]."' AND emd_kor_nm = '".$name[1]."' ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		// 장비 위치 변경
		$POINTX = substr( str_replace(".","",$point[0]), 0, 8 ); // 앞에서부터 8자리, 소수점 제거
		$POINTY = substr( str_replace(".","",$point[1]), 0, 9 ); // 앞에서부터 9자리, 소수점 제거
		// var_dump($POINTX);
		// var_dump($point[0]);
		$qry = " UPDATE rtu_location SET POINTX = '".$POINTX."', POINTY = '".$POINTY."',
					 	wr_x_point = '".$point[1]."', wr_y_point = '".$point[0]."', wr_emd_cd = '".($data[0]['emd_cd'] ? $data[0]['emd_cd'] : "")."'
			     WHERE rtu_id = '".$rtu_id."' ";
		$rs = $DB->queryone($qry);
			// echo $qry;
		$DB->close();
		$array = array( 'result' => true );
		echo json_encode( $array );
		exit;
		break;

	case 'overlay_move':
		$rtu_id = $_REQUEST['rtu_id'];
		$point = $_REQUEST['point'];
			// 장비 위치 변경
		$POINTX = substr( str_replace(".","",$point[0]), 0, 8 ); // 앞에서부터 8자리, 소수점 제거
		$POINTY = substr( str_replace(".","",$point[1]), 0, 9 ); // 앞에서부터 9자리, 소수점 제거
			$qry = "SELECT area_code FROM overlay_state
		WHERE area_code = '".$rtu_id."' ";
		$rs = $DB->execute($qry);
			if($rs[0]['area_code']){
			$qry = " UPDATE overlay_state SET x = '".$point[0]."', y = '".$point[1]."'
					WHERE area_code = '".$rtu_id."' ";
		}else{
			$qry = " INSERT INTO overlay_state (area_code,x,y) VALUES ('".$rtu_id."','".$point[0]."','".$point[1]."')";
		}
		$rs = $DB->queryone($qry);
			$DB->close();
			$DB->rs_unset();
		$array = array( 'result' => true );
		echo json_encode( $array );
		exit;
	break;
	

	case 'rtu_sub_move':
		$sub_id= $_REQUEST['sub_id'];
		$sub_type = $_REQUEST['sub_type'];
		$point = $_REQUEST['point'];

		if($sub_type == "cctv") $sub_type = 1;
		else if($sub_type == "sign") $sub_type = 2;
		else if($sub_type == "still") $sub_type = 3;

		// 서브 장비 위치 변경
		$qry = " UPDATE wr_map_sub_info SET sub_x_point = '".$point[0]."', sub_y_point = '".$point[1]."'
			 	 WHERE sub_id = '".$sub_id."' AND sub_type = '".$sub_type."' ";
		$rs = $DB->queryone($qry);

		$DB->close();
		$array = array( 'result' => true );
		echo json_encode( $array );
		exit;
		break;

	case 'farm_rtu_move':
		$sub_id= $_REQUEST['sub_id'];
		$point = $_REQUEST['point'];
		
		// 서브 장비 위치 변경
		$qry = " UPDATE farm_info SET wr_x_point = '".$point[0]."', wr_y_point = '".$point[1]."'
				  WHERE IDX = '".$sub_id."' ";
		$rs = $DB->queryone($qry);
	
		$DB->close();
		$array = array( 'result' => true );
		echo json_encode( $array );
		exit;
	break;	

	case 'event_setting':

		$top = $_REQUEST['top'];
		$left = $_REQUEST['left'];

		if($sub_mode == "move"){
			$qry = " UPDATE wr_map_alert SET x_point = '".$left."' , y_point ='".$top."' ";
			$rs = $DB->queryone($qry);
		}else if($sub_mode == "sizeEdit"){
			// $qry = " UPDATE wr_map_alert SET x_point = '".$left."' , y_point ='".$top."' ";
			// $rs = $DB->queryone($qry);
		}else if($sub_mode == "setting"){
			$qry = " SELECT x_point , y_point FROM wr_map_alert";
			$rs = $DB->execute($qry);
			$arr_data['x_point'] = $rs[0]['x_point'];
			$arr_data['y_point'] = $rs[0]['y_point'];
		}
		// echo $qry;
	
		$DB->close();
		$array = array( 'result' => true , 'data' => $arr_data );
		echo json_encode( $array );
		exit;
	break;

	case 'rtu_event':
		$arr_rtu_id = $_REQUEST['arr_rtu_id'];
		$arr_area_code = $_REQUEST['arr_area_code'];
		$now_date = date("Y-m-d H:i:s");

		// 장비 경보 체크
		$arr_data = array();

		if($arr_rtu_id && $arr_area_code){
			foreach($arr_rtu_id as $key => $val){
				$arr_data[$key]['area_code'] = $arr_area_code[$key];

				$qry = " SELECT * FROM rtu_log
						 WHERE rtu_id = '".$val."'
						 ORDER BY log_no DESC LIMIT 1 ";
				$rtu_log = $DB->execute($qry);
				$DB->rs_unset();
				$arr_data[$key]['rtu_rs'] = ($rtu_log[0]) ? true : false;
				$arr_data[$key]['rtu_log'] = $rtu_log[0];

				$qry = " SELECT event_code FROM event_hist
						 WHERE rtu_id = '".$val."'
						 AND event_code IN (".event_code_on.")
						 AND event_date >= '".$DM->getStartDay(date("Y-m-d"))."'
						 AND event_date <= '".$DM->getEndDay(date("Y-m-d"))."'
						 ORDER BY event_seq ";
						//  echo $qry;
				$event_hist = $DB->execute($qry);
				$DB->rs_unset();
				$arr_data[$key]['event_rs'] = ($event_hist) ? true : false;
				$arr_data[$key]['event_hist'] = $event_hist;
			}
		}
		$DB->close();
		$array = array( 'result' => true, 'data' => $arr_data, 'now_date' => $now_date );
		echo json_encode( $array );
		exit;
		break;
		
	case 'rtu_state':
		// 장비 상태 체크 > 미사용
		$qry = " SELECT area_code, call_last FROM rtu_info ";
		$rs = $DB->execute($qry);
		$DB->rs_unset();
		
		$DB->close();
		$array = array( 'result' => true, 'state' => $rs );
		echo json_encode( $array );
		exit;
		break;


	case 'event_update' :
		$now_date = date("Y-m-d H:i:s");

		$arr_rtu_id = $_REQUEST['arr_rtu_id'];
		$arr_area_code = $_REQUEST['arr_area_code'];

		// 장비 경보 체크
		$arr_data = array();
		$event = array();
		
		$sql .= " SELECT a.EVENT_SEQ, c.AREA_CODE, c.RTU_TYPE, c.RTU_NAME, a.EVENT_TIME, a.EVENT_TYPE, a.EVENT_LEVEL , a.EVENT_VALUE FROM 
				(SELECT * FROM event_alarm_log WHERE EVENT_TIME BETWEEN '".$DM->getStartDay(date("Y-m-d", strtotime("-1 month", time())))."' AND '".$DM->getEndDay(date("Y-m-d"))."' ) AS a
				LEFT JOIN event_config AS b ON a.AREA_CODE = b.AREA_CODE AND a.EVENT_TYPE = b.EVENT_TYPE
				LEFT JOIN rtu_info AS c ON a.AREA_CODE = c.AREA_CODE ";
				//	  WHERE c.AREA_CODE IS NOT NULL  
				// if(level_cnt == 2 || level_cnt == 3){
			// $sql .= " AND a.EVENT_TYPE IN (".event_code_all.") ";
			$sql .= " WHERE a.EVENT_TYPE IN (1,2,11,12,21,22,31) ";
				// }else if(level_cnt == 5){
					// $sql .= " AND a.EVENT_CODE IN (19, 20, 21, 23, 25, 27, 29, 33, 35 , 37 , 38 , 40) ";
					// }
			// $sql .= " AND a.EVENT_TIME BETWEEN '".$DM->getStartDay(date("Y-m-d"))."' AND '".$DM->getEndDay(date("Y-m-d"))."' ";

			$sql .= " ORDER BY a.EVENT_SEQ DESC LIMIT 100 ";
						
			// echo $sql;
						
				$event_hist = $DB->execute($sql);
				$DB->rs_unset();
				
				foreach($event_hist as $key => $val){
					$event[$key]['EVENT_SEQ'] = $val['EVENT_SEQ'];
					$event[$key]['AREA_CODE'] = $val['AREA_CODE'];
					$event[$key]['RTU_TYPE'] = $val['RTU_TYPE'];
					$event[$key]['RTU_NAME'] = $val['RTU_NAME'];
					$event[$key]['EVENT_BRANCH'] = $val['EVENT_BRANCH'];
					$event[$key]['EVENT_COMMENT'] = $val['EVENT_COMMENT'];
					$event[$key]['EVENT_DATE'] = $val['EVENT_TIME'];
					$event[$key]['EVENT_LEVEL'] = $val['EVENT_LEVEL'];
					$event[$key]['EVENT_CODE'] = $val['EVENT_TYPE'];
					$event[$key]['EVENT_VALUE'] = $val['EVENT_VALUE'];
				}

				if($arr_rtu_id && $arr_area_code){
					foreach($arr_rtu_id as $key => $val){
						$arr_data[$key]['area_code'] = $arr_area_code[$key];
		
						$qry = " SELECT * FROM rtu_log
								 WHERE rtu_id = '".$val."'
								 ORDER BY log_no DESC LIMIT 1 ";
						$rtu_log = $DB->execute($qry);
						$DB->rs_unset();
						$arr_data[$key]['rtu_rs'] = ($rtu_log[0]) ? true : false;
						$arr_data[$key]['rtu_log'] = $rtu_log[0];
		
						$qry = " SELECT event_type FROM event_alarm_log
								 WHERE area_code = '".$arr_data[$key]['area_code']."'
								 AND event_type IN (".event_code_all.")
								 AND event_time >= '".$DM->getStartDay(date("Y-m-d"))."'
								 AND event_time <= '".$DM->getEndDay(date("Y-m-d"))."'
								 ORDER BY event_seq ";
								//  echo $qry;
						$event_hist = $DB->execute($qry);
						$DB->rs_unset();
						$arr_data[$key]['event_rs'] = ($event_hist) ? true : false;
						$arr_data[$key]['event_hist'] = $event_hist;
					}
				}
		
		$DB->close();
		$array = array( 'result' => true, 'data' => $arr_data, 'data2' => $event, 'now_date' => $now_date );
		echo json_encode( $array );
		exit;
		break;



		case 'sub_event_update' :
			$now_date = date("Y-m-d H:i:s");
	
			// 장비 경보 체크
			$arr_data = array();
	
					$sql .= " SELECT * from ( SELECT c.rtu_id,
							  a.EVENT_SEQ, c.AREA_CODE, c.RTU_TYPE, c.RTU_NAME, b.EVENT_BRANCH, b.EVENT_COMMENT,
							a.EVENT_DATE, a.BATTERY_VOLT, a.EVENT_CODE, a.EVENT_VALUE
						  FROM
							event_hist AS a
						  LEFT JOIN event_info AS b ON a.EVENT_CODE = b.EVENT_CODE
						  LEFT JOIN rtu_info AS c ON a.RTU_ID = c.RTU_ID
						  WHERE c.RTU_ID IS NOT NULL ";	  
					// if(level_cnt == 2 || level_cnt == 3){
						$sql .= " AND a.EVENT_CODE IN (".event_code_all.") ";
					// }else if(level_cnt == 5){
						// $sql .= " AND a.EVENT_CODE IN (19, 20, 21, 23, 25, 27, 29, 33, 35 , 37 , 38 , 40) ";
					// }
						// $sql .= " AND a.EVENT_DATE BETWEEN '".$DM->getStartDay(date("Y-m-d"))."' AND '".$DM->getEndDay(date("Y-m-d"))."' ";
					$sql .= "ORDER BY a.EVENT_SEQ DESC ) as d ";
					$sql .= "GROUP BY d.rtu_id";

	
					// echo $sql;
	
					$event_hist = $DB->execute($sql);
					$DB->rs_unset();
	
					foreach($event_hist as $key => $val){
						$event[$key]['EVENT_SEQ'] = $val['EVENT_SEQ'];
						$event[$key]['AREA_CODE'] = $val['AREA_CODE'];
						$event[$key]['RTU_TYPE'] = $val['RTU_TYPE'];
						$event[$key]['RTU_NAME'] = $val['RTU_NAME'];
						$event[$key]['EVENT_BRANCH'] = $val['EVENT_BRANCH'];
						$event[$key]['EVENT_COMMENT'] = $val['EVENT_COMMENT'];
						$event[$key]['EVENT_DATE'] = $val['EVENT_DATE'];
						$event[$key]['BATTERY_VOLT'] = $val['BATTERY_VOLT'];
						$event[$key]['EVENT_CODE'] = $val['EVENT_CODE'];
						$event[$key]['EVENT_VALUE'] = $val['EVENT_VALUE'];
					}
			
			$DB->close();
			$array = array( 'result' => true, 'data' => $event, 'now_date' => $now_date );
			echo json_encode( $array );
			exit;
			break;
		
	case 'top_change':
		$kind = $_REQUEST['kind'];
		$data = $_REQUEST['data'];

		// 상단 이미지, 텍스트 변경
		if($kind == "img"){
			$rs_img = $dvUtil->imgUpload(1, "sel_top_img", null);
			if($rs_img[0] == 1){
				$qry = " UPDATE wr_map_setting SET top_img = '".$rs_img[1]."' ";
				$rs = $DB->queryone($qry);
			}
			$check = $rs_img;
		}else if($kind == "text"){
			$qry = " UPDATE wr_map_setting SET top_text = '".$data."' ";
			$rs = $DB->queryone($qry);

			if($rs){
				$check = array(1, "");
			}else{
				$check = array(2, "");
			}
		}
		$DB->close();
		$array = array( 'result' => true, 'check' => $check );
		echo json_encode( $array );
		exit;
		break;
		
	case 'cookie_check':
		$cookie = $_COOKIE;
		
		$array = array( 'result' => true, 'cookie' => $cookie);
		echo json_encode( $array );
		exit;
		break;
		
}
?>
