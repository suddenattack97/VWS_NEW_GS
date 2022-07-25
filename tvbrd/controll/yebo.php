<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 예보 기상청 api ## http://www.kma.go.kr/weather/lifenindustry/sevice_rss.jsp
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");
require_once "../class/Divas_Util.php";//유틸 class
$dvUtil   = new Divas_Util();

$mode =  $dvUtil->xss_clean($_REQUEST["mode"]);
$rtu_name =  $dvUtil->xss_clean($_REQUEST["rtu_name"]);

$fp = fopen("../output.txt","r"); //  text.txt파일을 한 줄씩 읽습니다.
if(!$fp) {  // $fp파일이 없으면 에러 출력
 echo "error";
}

while(!feof($fp)) { //문자의 마지막 행까지 간다
  $str = fgets($fp,10000); // 10000길이까지 읽어드리지만 중간에 개행문자가 있으면 알아서 멈춘다.
  $arr[] = $str; // $arr배열에 하나씩 넣는다. $b[1] = "첫번째 줄" 뭐 이런식
}

//print_r($arr);
for($i=0;$i<sizeof($arr);$i++) { // 행만큼돌려준다.-
    $checkname =$arr[$i];
	//echo$rtu_name.'-'.$checkname;
	//echo $rtu_name;
	//echo "\n\n";
	
 if(strpos($checkname, $rtu_name) !== false) {
     $checkword = explode(",", $arr[$i]);
	//echo $checkword;
}


}
//print_R($rtu_name);
    $checkword = explode("=", $checkword[0]);
    $cword = $checkword[1];
	//print_r($checkword);


fclose($fp);


     switch($mode) {
    case 'yebo':

    if(!isset($cword) && empty($cword)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

/*
echo $rtu_name;
exit;
*/
    $url = "http://www.kma.go.kr/wid/queryDFSRSS.jsp?zone=".$cword;


//     $response = file_get_contents($url);
//     $object = simplexml_load_string($response);
    
    $ch = cURL_init();
    cURL_setopt($ch, CURLOPT_URL, $url);
    cURL_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = cURL_exec($ch);
    cURL_close($ch);
	//var_dump($response);
    $object = simplexml_load_string($response);
//echo $url;
//exit; 
    $z=0;$a = 0; $b = 0; $c = 0; $i=0;
    $channel = $object->channel->item->description->body  ;
    $iforesultArr["to_title"] =  $tchannel = $object->channel->pubDate ;
    $array1 = array( "맑음");
    $array2 = array("구름많음","구름 많음");
    $array3 = array("흐림");
    $array4 = array("비","흐리고 비");
    $array5 = array("눈");
    $array6 = array("흐리고 비/눈", "흐리고 눈/비", "눈/비", "비/눈");
    $array7 = array("구름 조금","구름조금");


    foreach($channel->children() as $value) {
        //var_dump($value);
             if($z==0){
                $iforesultArr[$z]["day_tempnow"] = $value->temp;
                $iforesultArr[$z]["day_tempmax"] = $value->tmx;
                $iforesultArr[$z]["day_tempmin"] = $value->tmn;
                $iforesultArr[$z]["day_rain"] = $value->r06;//
                $iforesultArr[$z]["day_weather"] =    $value->wfKor;
                $iforesultArr[$z]["day_tommer_hour"] = $value->hour;//
                  if(in_array($value->wfKor, $array1)){ $iforesultArr[$z]["day_icon"] = "weather_icon_06";  }
                  if(in_array($value->wfKor, $array2)){ $iforesultArr[$z]["day_icon"] = "weather_icon_04";  }
                  if(in_array($value->wfKor, $array3)){ $iforesultArr[$z]["day_icon"] = "weather_icon_01";  }
                  if(in_array($value->wfKor, $array4)){ $iforesultArr[$z]["day_icon"] = "weather_icon_07";  }
                  if(in_array($value->wfKor, $array5)){ $iforesultArr[$z]["day_icon"] = "weather_icon_17";  }
                  if(in_array($value->wfKor, $array6)){ $iforesultArr[$z]["day_icon"] = "weather_icon_20";  }
                  if(in_array($value->wfKor, $array7)){ $iforesultArr[$z]["day_icon"] = "weather_icon_05";  }

            }




             if($z==1){
                $iforesultArr[$z]["tommer_tempnow"] = $value->temp;
                $iforesultArr[$z]["tommer_tempmax"] = $value->tmx;
                $iforesultArr[$z]["tommer_tempmin"] = $value->tmn;
                $iforesultArr[$z]["tommer_rain"] = $value->r06;//
                $iforesultArr[$z]["tommer_weather"] =    $value->wfKor;
                $iforesultArr[$z]["tommer_tommer_hour"] = $value->hour;//

                  if(in_array($value->wfKor, $array1)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_06";  }
                  if(in_array($value->wfKor, $array2)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_04";  }
                  if(in_array($value->wfKor, $array3)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_01";  }
                  if(in_array($value->wfKor, $array4)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_07";  }
                  if(in_array($value->wfKor, $array5)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_17";  }
                  if(in_array($value->wfKor, $array6)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_20";  }
                  if(in_array($value->wfKor, $array7)){ $iforesultArr[$z]["tommer_icon"] = "weather_icon_05";  }


            }

             if($z==2){
                $iforesultArr[$z]["af_tommer_tempnow"] = $value->temp;
                $iforesultArr[$z]["af_tommer_tempmax"] = $value->tmx;
                $iforesultArr[$z]["af_tommer_tempmin"] = $value->tmn;
                $iforesultArr[$z]["af_tommer_rain"] = $value->r06;//
                $iforesultArr[$z]["af_tommer_weather"] =    $value->wfKor;
                $iforesultArr[$z]["af_tommer_hour"] = $value->hour;//
                  if(in_array($value->wfKor, $array1)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_06";  }
                  if(in_array($value->wfKor, $array2)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_04";  }
                  if(in_array($value->wfKor, $array3)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_01";  }
                  if(in_array($value->wfKor, $array4)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_07";  }
                  if(in_array($value->wfKor, $array5)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_17";  }
                  if(in_array($value->wfKor, $array6)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_20";  }
                  if(in_array($value->wfKor, $array7)){ $iforesultArr[$z]["af_tommer_icon"] = "weather_icon_05";  }


            }

         $z++;
    }


        $returnBody = array( 'result' => true, 'data' => $iforesultArr );
        echo json_encode( $returnBody );
        exit;
    break;

    }

?>
