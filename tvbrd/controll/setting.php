<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 셋팅 데이터
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
    $area_code =  $dvUtil->xss_clean($_REQUEST["area_code"]);

    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'setting':
        $sql = " SELECT
                                *
                        FROM
                                wr_map_setting ";
        $resultArr = $DB->execute($sql);

        $returnBody = array( 'result' => true, 'data' => $resultArr );
         echo json_encode( $returnBody );
        exit;

    break;
    }
?>
