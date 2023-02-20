<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 강우데이터
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
//require_once "../class/RtuInfo.class";//지역 Class

//require_once "../class/RainInfo.class";#강우 class
#################################################################################################################################
# 객체 생성
#################################################################################################################################
$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();
//$AwsLocalDB = new RtuInfo($DB,0);//장비
//$RainInfo = new RainInfo($DB,$DM, $dvUtil);//강우


    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $arr_area_code = $_REQUEST["arr_area_code"];

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'eqk':
    	$arr_data = array();
    	$calc = 0.01;
    	
    	if($arr_area_code){
    		foreach($arr_area_code as $key => $val){
				
		    	$qry = " SELECT eqk, eqk_date FROM eqk_hist
						 WHERE area_code = '".$val."'
						 AND data_type = 'M' ";
		    	if(TEST == "0"){
		    		$qry.= " AND eqk_date BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	}else{
		    		$qry.= " AND eqk_date = '".TEST_DATE."' ";
		    	}
				$qry.= " ORDER BY eqk_date DESC LIMIT 2 ";
				

		    	// $qry = " SELECT realdata as rain,realtime as rain_date FROM realtime_data
				// 		 WHERE area_code = '".$val."'
				// 		 AND sensor_type = 'DP' ";

		    	// if(TEST == "0"){
		    	// 	$qry.= " AND realtime BETWEEN {TS '".$DM->getMinDisTime()."'} AND {TS '".$DM->getMinTime()."'} ";
		    	// }else{
		    	// 	$qry.= " AND realtime = '".TEST_DATE."' ";
		    	// }

				// $qry.= " ORDER BY realtime DESC LIMIT 1 ";
				
				// echo $qry;

		    	$data = $DB->execute($qry);
		    	$DB->rs_unset();
				

		    	$arr_data[$key]['area_code'] = $val;
				$arr_data[$key]['eqk'] = "-";
				$arr_data[$key]['eqk_date'] = "-";
				$arr_data[$key]['day'] = "-";
				$arr_data[$key]['date'] = "-";
				$arr_data[$key]['state'] = false;

		    	if( isset($data[0]['eqk_date']) ){
					if( $data[0]['eqk_date'] < $DM->getMinDisTime()){
					}else{
					$arr_data[$key]['day'] = $data[0]['eqk']*$calc;
		    		$arr_data[$key]['date'] = $data[0]['eqk_date'];
					}

					if($data[0]['eqk'] < $data[1]['eqk'] || $data[0]['eqk'] > $data[1]['eqk']){
						$arr_data[$key]['state'] = true;
					}else{
						$arr_data[$key]['state'] = false;
					}
		    	}
    		}
    	}
    	
    	$returnBody = array( 'result' => true, 'list' => $arr_data);
        echo json_encode( $returnBody );
        exit;
    break;
    }
?>


