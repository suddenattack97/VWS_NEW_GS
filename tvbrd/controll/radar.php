<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 레이더
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");
$mode =  $_REQUEST["mode"];

switch($mode) {
case 'radar':
    $date = date("Ymd");
            $url = "http://apis.data.go.kr/1360000/RadarImgInfoService/getCmpImg?data=CMP_WRC&time=".$date."&ServiceKey=";
            $url .= "72UJgUbwpjoDZhoR%2BEyNSa2b88EZt%2FxzwL30iZXniCBQW969MOyfjJvbMiYsLgL2HR5Dud3q%2Fy2tj0gyUv3Rxw%3D%3D";
                $response = file_get_contents($url);
                $object = simplexml_load_string($response);
                $ch = $object->body->items->item  ;
                $i=0;
                foreach($ch->children() as $val){
                    $rdr_img[$i] = (string) $val[0];
                    $rdr_date[$i] = preg_replace("/[^0-9]*/s","",$rdr_img[$i]);
                            
                    $i++;
                }
            $aresultArr[0]['rader'] = array_pop($rdr_img);
    
            $returnBody = array ( 'result' => true, 'data' => $aresultArr );
            echo json_encode ( $returnBody );
            exit ();
            break;
}
?>
