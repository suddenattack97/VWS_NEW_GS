<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 문자전광판
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
require_once "../class/Divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class
//require_once "../class/RtuInfo.class";//지역 Class

#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB,0);//장비

$mode = $dvUtil->xss_clean($_REQUEST["mode"]);
$arr_siteID = $_REQUEST["arr_siteID"];

if(!isset($mode) && empty($mode)){
	$returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
	echo json_encode( $returnBody );
	exit;
}

switch($mode) {
	case 'sign':
		$arr_data = array();
		
		if($arr_siteID){
			foreach($arr_siteID as $key => $val){
				$qry = " SELECT
		        			rtu_id
		        		 FROM
		        			wr_map_sub_info
		        		 WHERE
		        			sub_id = ".$val." ";
				$data_list = $DB->execute($qry);
				$DB->rs_unset();
				
				$qry = " SELECT
		        			*
		        		 FROM
		        			sb_message
		        		 WHERE
		        			success IN ('1', '2', '3') AND division IN (1, 2) AND siteID = ".$data_list[0]['rtu_id']."
							AND enddate > NOW()
		        		 ORDER BY areaBestID, areaID, siteID, ordernum ";
				$data_urg = $DB->execute($qry);
				$DB->rs_unset();
				
				$qry = " SELECT
		        			*
		        		 FROM
		        			sb_message
		        		 WHERE
		        			success IN ('1', '2', '3') AND division = 0 AND siteID = ".$data_list[0]['rtu_id']."
		        		 ORDER BY areaBestID, areaID, siteID, ordernum ";
				$data_msg = $DB->execute($qry);
				$DB->rs_unset();
				
				if($data_urg){
					$data = $data_urg;
				}else{
					$data = $data_msg;
				}
				
				if($data){
					foreach($data as $key2 => $val2){
						foreach($val2 as $key3 => $val3){
							$arr_data[$key][$key2][$key3] = $val3;
							$arr_data[$key][$key2]['sub_id'] = $val;
						}
					}
				}
			}
		}
		
		$returnBody = array( 'result' => true, 'list' => $arr_data );
		echo json_encode( $returnBody );
		exit;
	break;
	
	case 'sign_script_sort':
		$arr_sort = $_REQUEST["arr_sort"];
		if($arr_sort){
			foreach($arr_sort as $key => $row){
				$SQL = " UPDATE SB_MESSAGELIST SET ORDERNUM = '".$key."' WHERE IDX = '".$row."' ";
				if( $DB->queryone($SQL) ){
					$arrReturn[] = true;
				}else{
					$arrReturn[] = false;
				}
				$DB->parseFree();
			}
			if( in_array(false, $arrReturn) ){
				$result = false;
			}else{
				$result = true;
			}
		}else{
			$result = false;
		}
		
		$returnBody = array( 'result' => $result );
		echo json_encode( $returnBody );
		exit;
	break;
		
	case 'sign_slide':
		// 전광판 리스트
		$qry = " SELECT * FROM sb_areainfo
    			 ORDER BY areaID ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$qry = " SELECT * FROM sb_signInfo
    			 ORDER BY siteID ";
		$data2 = $DB->execute($qry);
		$DB->rs_unset();
		
		// 메세지 리스트
		$qry = " SELECT a.IDX, a.TYPE, a.MSGACTION, a.MSGCOLOR, a.MSGSPD, a.MSGDELAY, a.MSG,
						b.COMMENT AS ACTIONNAME, c.COMMENT AS COLORNAME
				 FROM SB_MESSAGELIST AS a
				 LEFT JOIN SB_SIGNACTION AS b ON a.MSGACTION = b.NUM AND b.TYPE = 1
				 LEFT JOIN SB_SIGNACTION AS c ON a.MSGCOLOR = c.NUM AND c.TYPE = 4
				 ORDER BY a.ORDERNUM ";
		$data3 = $DB->execute($qry);
		$DB->rs_unset();
		
		$returnBody = array( 'result' => true, 'data' => $data, 'data2' => $data2, 'data3' => $data3 );
		echo json_encode( $returnBody );
		exit;
	break;
		
	case 'sign_in':
		// 테이블 구조를 바꾸는 게 맞는데 그렇게 되면 바꿀 게 많아져서 일단 소스상에서 처리함
		$qry = " SELECT * FROM sb_areabinfo LIMIT 1 ";
		$data = $DB->execute($qry);
		$DB->rs_unset();
		
		$arr_idx = $_REQUEST["idx"];
		$arr_rtu_id = explode("-", $_REQUEST["str_rtu_id"]); // 전광판
		$arr_msg_idx = explode("@", $_REQUEST["str_msg_idx"]); // 메세지
		$userID = $_COOKIE["keyUserID"];
		
		// 전광판
		for($i = 0; $i < count($arr_rtu_id); $i ++){
			$qry = " DELETE FROM SB_MESSAGE 
					 WHERE DIVISION = '0' AND SITEID = '".$arr_rtu_id[$i]."' ";
			$DB->queryone($qry);
			$DB->parseFree();
			
			$sql_sbd = " SELECT AREABESTID, AREAID, SITEID, MODX, MODY
						 FROM SB_SIGNINFO
						 WHERE SITEID = '".$arr_rtu_id[$i]."' ";
			$rs_sbd = $DB->execute($sql_sbd);
			$DB->rs_unset();
			
			$AREABESTID[$i] = $rs_sbd[0]['AREABESTID'];
			$AREAID[$i] = $rs_sbd[0]['AREAID'];
			$SITEID[$i] = $rs_sbd[0]['SITEID'];
			$MODX[$i] = $rs_sbd[0]['MODX'];
			$MODY[$i] = $rs_sbd[0]['MODY'];
		}
		
		// 메세지
		for($i = 0; $i < count($arr_msg_idx); $i ++){
			$sql_msg = " SELECT IDX, MSGCOLOR, MSGACTION, MSGSPD, MSGDELAY, TYPE, MSG, IMGMSG, IMGPATH, TM
						 FROM SB_MESSAGELIST
						 WHERE IDX = '".$arr_msg_idx[$i]."' ";
			$rs_msg = $DB->execute($sql_msg);
			$DB->rs_unset();
			
			$REF_IDX[$i] = $rs_msg[0]['IDX'];
			$MSGCOLOR[$i] = $rs_msg[0]['MSGCOLOR'];
			$MSGACTION[$i] = $rs_msg[0]['MSGACTION'];
			$ORDERNUM[$i] = $i + 1;
			$MSGSPD[$i] = $rs_msg[0]['MSGSPD'];
			$MSGDELAY[$i] = $rs_msg[0]['MSGDELAY'];
			$TYPE[$i] = $rs_msg[0]['TYPE'];
			$MSG[$i] = $rs_msg[0]['MSG'];
			$IMGPATH[$i] = $rs_msg[0]['IMGPATH'];
			$TM[$i] = $rs_msg[0]['TM'];
		}
		
		
		$sql = " INSERT INTO SB_MESSAGE (AREABESTID, AREAID, SITEID, DIVISION, MSGCOLOR, MSGACTION, ORDERNUM, MSGSPD, MSGDELAY, TYPE, MSG, IMGPATH,
										 MODX, MODY, SUCCESS, USERID, USERIP, TM, SENDDATE, REF_IDX) ";
		$sql.= " VALUES ";
		for($i = 0; $i < count($arr_rtu_id); $i++){
			for($j = 0; $j < count($arr_msg_idx); $j++){
				if( !($i == 0 && $j == 0) ) $sql.= " , ";
				$sql.= " ( '".$AREABESTID[$i]."', '".$AREAID[$i]."', '".$SITEID[$i]."', '0', '".$MSGCOLOR[$j]."', '".$MSGACTION[$j]."', '".$ORDERNUM[$j]."',
						 '".$MSGSPD[$j]."', '".$MSGDELAY[$j]."', '".$TYPE[$j]."', '".$MSG[$j]."', '".$IMGPATH[$j]."', '".$MODX[$i]."', '".$MODY[$i]."', '1',
						 '".$userID."', '".$_SERVER['REMOTE_ADDR']."', '".$TM[$j]."', NOW(), '".$REF_IDX[$j]."' ) ";
			}
		}
		$sqlReturn = $DB->queryone($sql);
		
		$returnBody = array( 'result' => $sqlReturn );
		echo json_encode( $returnBody );
		exit;
	break;
}
?>


