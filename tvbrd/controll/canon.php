<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 지역 태풍데이터
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
require_once "../class/RtuInfo.php";//지역 Class




#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
$AwsLocalDB = new RtuInfo($DB);//장비


    $mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
    //$area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'canon':
    	$sel_ymdh = $_GET['sel_ymdh']; // 선택한 날짜 > 일단 사용 안 함
    	$sel_typ = $_POST['sel_typ']; // 선택한 태풍
    	
    	$arr_now_typ = array(); // 현재 진행중인 태풍 배열
    	$arr_sel_typ = array(); // 셀렉트바 태풍 배열
    	$arr_typ_seq = array(); // 선택한 태풍 배열
    	$arr_typ = array(); // 태풍 데이터 배열
    	$now_ymd = date("Ymd");
    	$now_ymdh = date("Ymdh");
    	$now_ymdhi = date("Ymdhi");
//     	$now_ymd = "20161019"; // 태풍 2개 발생 시 테스트용
//     	$now_ymdh = "2016101903";
//     	$now_ymdhi = "201610190300";
    	
    	$qry = " SELECT *
			 	 FROM wr_typ_info
			 	 ORDER BY typOc DESC ";
    	$rs= $DB->execute($qry);
    	
    	$i = 0;
    	foreach($rs as $key => $obj){
    		$tmp_oc = substr($obj['typOc'], 0, 8);
    		$tmp_ex = substr($obj['typEx'], 0, 8);
    		
    		if($tmp_oc <= $now_ymd  &&  $tmp_ex >= $now_ymd){
    			$arr_now_typ[] = $obj['year']."/".$obj['typSeq'];
    		}
    		$arr_sel_typ[$i]['year'] = $obj['year']; // 태풍 년도
    		$arr_sel_typ[$i]['typSeq'] = $obj['typSeq']; // 태풍 번호
    		$arr_sel_typ[$i]['typName'] = $obj['typName']; // 태풍 이름
    		$i++;
    	}
    	$DB->rs_unset();
    	
    	// 선택한 값이 없거나 최초 접속일 경우 현재 진행중인 태풍 표시
    	if(!$sel_typ) $sel_typ = $arr_now_typ;
    	$arr_typ_seq = $sel_typ;
    	
    	foreach($arr_typ_seq as $key => $val){
    		$arr_val = explode('/' , $val);
    		$tmp_year = $arr_val[0];
    		$tmp_typSeq = $arr_val[1];
    		
    		$qry = " SELECT * FROM wr_typ_data
				 WHERE year = ".$tmp_year." AND typSeq = ".$tmp_typSeq."
				 ORDER BY typTm DESC ";
    		$rs = $DB->execute($qry);
    		
    		$i = 0;
    		foreach($rs as $key2 => $obj){
    			$arr_typ[$key][$i]['typSeq'] = $obj['typSeq']; // 태풍 번호
    			$arr_typ[$key][$i]['typName'] = $obj['typName']; // 태풍 이름
    			$arr_typ[$key][$i]['typTm'] = $obj['typTm']; // 태풍 시각
    			$rem = $obj['rem']; // 태풍 내용
    			$arr_typ[$key][$i]['online'] = "on"; // 태풍 상태(종료 상태 값이 없기 때문에 이걸로 체크)
    			if( strpos($rem, "종료함") != false ) $arr_typ[$key][$i]['online'] = "off";
    			$arr_typ[$key][$i]['typLat'] = $obj['typLat']; // 위도
    			$arr_typ[$key][$i]['typLon'] = $obj['typLon']; // 경도
    			$arr_typ[$key][$i]['state'] = $obj['state']; // 상태
    			if($sel_ymdh == "" || !$sel_ymdh){
    				if( $obj['typTm'] < $now_ymdhi ){
    					if($obj['state'] == 2) continue; // 예상 데이터가 현재 시점 기준으로 과거라면 무시
    					$arr_typ[$key][$i]['state'] = 0;
    				}else if( substr($obj['typTm'], 0, 10) == $now_ymdh ){
    					$arr_typ[$key][$i]['state'] = 1;
    				}else if( $obj['typTm'] > $now_ymdhi ){
    					$arr_typ[$key][$i]['state'] = 2;
    				}
    			}else{
    				if( $obj['typTm'] < $sel_ymdh."00" ){
    					if($obj['state'] == 2) continue;
    					$arr_typ[$key][$i]['state'] = 0;
    				}else if( substr($obj['typTm'], 0, 10) == $sel_ymdh ){
    					$arr_typ[$key][$i]['state'] = 1;
    				}else if( $obj['typTm'] > $sel_ymdh."00" ){
    					$arr_typ[$key][$i]['state'] = 2;
    				}
    			}
    			$arr_typ[$key][$i]['typ15'] = ($obj['typ15'] * 10000); // 태풍 크기
    			//$arr_typ[$key][$i]['typ15'] = ($obj['typ15']); // 태풍 크기
    			$i++;
    		}
    		$DB->rs_unset();
    	}
    	
    	$returnBody = array( 'result' => true, 'arr_typ' => $arr_typ, 'arr_sel_typ' => $arr_sel_typ, );
    	echo json_encode( $returnBody );
    	exit;
    break;
    }
?>
