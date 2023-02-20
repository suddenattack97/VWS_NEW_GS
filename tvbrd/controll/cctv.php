<?
@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");

require_once "../db/_Db.php";

require_once "../class/DateMake.php";#시간 class
require_once "../class/divas_Util.php";//유틸 class
require_once "../class/DBmanager.php";#DB class

$DB       = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$DM       = new DateMake();
$dvUtil   = new Divas_Util();

    $mode = $dvUtil->xss_clean($_REQUEST["mode"]);
    $sub_id = $_REQUEST["sub_id"];

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'cctv':
    	$cctv = array();
    	$url = "http://openapi.its.go.kr:8081/api/NCCTVInfo?key=1525846320587&ReqType=2&MinX=126.5&MaxX=127.5&MinY=37&MaxY=38&type=e";
//     	$url = "http://openapi.its.go.kr/api/NCCTVInfo?key=1525846320587&ReqType=2&MinX=105&MaxX=150&MinY=30&MaxY=43&type=e";
    	$response = file_get_contents($url);
    	$object = simplexml_load_string($response);
    	$data = $object->{'data'};
    	$cnt = 0;
    	if($data){
	    	foreach($data as $key => $val){
	    		$cctv[$cnt]['cctvname'] = (string)$val->cctvname;
	    		$cctv[$cnt]['cctvtype'] = (string)$val->cctvtype;
	    		$cctv[$cnt]['cctvformat'] = (string)$val->cctvformat;
	    		$cctv[$cnt]['cctvurl'] = (string)$val->cctvurl;
	    		$cctv[$cnt]['coordx'] = (string)$val->coordx;
	    		$cctv[$cnt]['coordy'] = (string)$val->coordy;
	    		$cctv[$cnt]['roadsectionid'] = (string)$val->roadsectionid;
	    		$cctv[$cnt]['filecreatetime'] = (string)$val->filecreatetime;
	    		$cctv[$cnt]['cctvresolution'] = (string)$val->cctvresolution;
	    		$cnt ++;
	    	}
    	}
    	//print_r($cctv);
    	
    	$arr_data = array();
    	
    	// cctv 장비 정보
    	$qry = " SELECT sub_id, sub_x_point, sub_y_point
						 FROM wr_map_sub_info
						 WHERE sub_type = 1 AND sub_id = '".$sub_id."' ";
    	$data = $DB->execute($qry);
    	$DB->rs_unset();
    	
    	if($data){
    		$arr_data['sub_id'] = $data[0]['sub_id'];
    		$arr_data['x_point'] = $data[0]['sub_x_point'];
    		$arr_data['y_point'] = $data[0]['sub_y_point'];
    		$arr_data['url'] = $cctv[0]['cctvurl']; // 일단 0번 배열 것으로
    		$arr_data['time'] = date("Y.m.d H:i:s");
    	}

        $returnBody = array( 'result' => true, 'list' => $arr_data );
        echo json_encode( $returnBody );
        exit;
    break;
    }
?>


