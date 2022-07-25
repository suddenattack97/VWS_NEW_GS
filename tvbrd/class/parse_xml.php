<?
	class Xml_Yebo{
			
			public $url;	
			public $Today_sky; //하늘자료
			public $Today_wsd; //풍속
			public $Today_t3h; //3시간온도
			public $Today_pop; //강수확률
			public $Today_r06; //6시간 강우량
			public $Yebo_data;
			public $Today_pty;
			public $Today_s06;
			public $time_HH;

			public $Tomm_sky;
			public $Tomm_wsd;
			public $Tomm_t3h;
			public $Tomm_pop;
			public $Tomm_r06;
			public $tomm_data;
			public $Tomm_pty;
			public $Tomm_s06;

	function Getxml_load($url){
			$curl = curl_init();
			$timeout = 5; 
			//$url = "http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService/ForecastSpaceData?ServiceKey=".$serviceKey."&base_date=".$reg_date."&base_time=0200&nx=57&ny=126&numOfRows=14";
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
			$xml = curl_exec($curl);
			curl_close($curl);
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
//			$doc->loadXML($xml); 

if ($doc->loadXML($xml)) { 
    $items = $doc->getElementsByTagName('item'); 
    $headlines = array(); 
    
    foreach($items as $item) { 
        $yebo_data = array(); 
        
        if($item->childNodes->length) { 
            foreach($item->childNodes as $i) { 
                $yebo_data[$i->nodeName] = $i->nodeValue; 
            } 
        } 
        
       $yebo_datas[] = $yebo_data; 
    } 




//3시간뒤   
//if(date("H") == )
  $time_H = strftime("%H");
//date("H",strtotime(" + 3 hour "))."00"; 

if($time_H <= '01' and $time_H >= "00"){
$time_H ='02';
}else if($time_H <= '05' and $time_H >= "02"){
$time_H ='06';
}else if($time_H <= '08' and $time_H >= "06"){
$time_H ='09';
}else if($time_H <= '11' and $time_H >= "09"){
$time_H ='12';
}else if($time_H <= '14' and $time_H >= "12"){
$time_H ='15';
}else if($time_H <= '17' and $time_H >= "15"){
$time_H ='18';
}else if($time_H <= '20' and $time_H >= "18"){
$time_H ='21';
}else{
echo $reg_date = strftime("%Y%m%d",strtotime('1 day')); 
$time_H ='00';
}

 $today_date = date("Ymd");
 $time_HH = $time_H."00";
 $this->time_HH = $time_HH;
 if($yebo_data != null){
        foreach($yebo_datas as $yebo_data) { 
	$yebo_data['category']."<br>";
	if($yebo_data['fcstDate'] == $today_date){
//echo $yebo_data['fcstTime'] .  $time_HH;
	if($yebo_data['category'] == "SKY" and $yebo_data['fcstTime'] == $time_HH){
		$today_SKY = $yebo_data['fcstValue'];
			if($today_SKY == "1"){
				$Today_sky = "맑음";
			}else if($today_SKY == "2"){
				$Today_sky = "구름조금";
			}else if($today_SKY == "3"){
				$Today_sky = "구름많음";
			}else if($today_SKY == "4"){
				$Today_sky = "흐림";
			}else{
				$Today_sky = "-";
			}

        }else{
		$today_sky = "-";
	}
	$this->Today_sky = $Today_sky;

	if($yebo_data['category'] == "WSD" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_wsd = $yebo_data['fcstValue'];
        } 
	$this->Today_wsd = $Today_wsd;
	if($yebo_data['category'] == "T3H" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_t3h = $yebo_data['fcstValue'];
 	$this->Today_t3h = $Today_t3h;
        } 
/*	if($yebo_data['category'] == "POP" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_pop = $yebo_data['fcstValue'];
 	$this->Today_pop = $Today_pop;
	}*/

	if($yebo_data['category'] == "PTY" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_pty = $yebo_data['fcstValue'];
			if($Today_pty == "0"){
				$Today_pty = "없음";
			}
			if($Today_pty == "1"){
				$Today_pty = "비";
			}
			if($Today_pty == "2"){
				$Today_pty = "비/눈";
			}
			if($Today_pty == "3"){
				$Today_pty = "눈";
			}
	$this->Today_pty = $Today_pty;
        } 
	if($yebo_data['category'] == "R06" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_r06 = $yebo_data['fcstValue'];
		if($Today_r06 == "0"){
			$Today_r06 = "0";
		}
		if($Today_r06 == "1"){
			$Today_r06 = "1";
		}
		if($Today_r06 == "5"){
			$Today_r06 = "1~4";
		}
		if($Today_r06 == "10"){
			$Today_r06 = "5~9";
		}

		if($Today_r06 == "20"){
			$Today_r06 = "10~19";
		}
		if($Today_r06 == "40"){
			$Today_r06 = "20~39";
		}
		if($Today_r06 == "70"){
			$Today_r06 = "40~69";
		}
		if($Today_r06 == "100"){
			$Today_r06 = "70";
		}
 		$this->Today_r06 = $Today_r06;
        } 
	if($yebo_data['category'] == "S06" and $yebo_data['fcstTime'] ==  $time_HH){
		$Today_s06 = $yebo_data['fcstValue'];
			if($Today_s06 == '0'){
				$Today_s06 = "0";
			}
			if($Today_s06 == '1'){
				$Today_s06 = "1";
			}
			if($Today_s06 == '5'){
					$Today_s06 = "1~4";
			}
			if($Today_s06 == '10'){
					$Today_s06 = "5~9";
			}
			if($Today_s06 == '20'){
					$Today_s06 = "10~19";
			}
			if($Today_s06 == '100'){
					$Today_s06 = "20";
			}
		 	$this->Today_s06 = $Today_s06;
	} 

      }
    } 
  }
  }
}





	function Getxml_load2($url2){
			$curl = curl_init();
			$timeout = 5; 
			//$url = "http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService/ForecastSpaceData?ServiceKey=".$serviceKey."&base_date=".$reg_date."&base_time=0200&nx=57&ny=126&numOfRows=14";
			//$url2 = "http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService/ForecastSpaceData?ServiceKey=".$serviceKey."&base_date=".$reg_date."&base_time=0200&nx=57&ny=126&pageNo=9&numOfRows=14";
			curl_setopt($curl, CURLOPT_URL, $url2);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
			$xml = curl_exec($curl);
			curl_close($curl);
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
//			$doc->loadXML( $xml); 

if ($doc->loadXML($xml)) { 
    $items = $doc->getElementsByTagName('item'); 
    $headlines = array(); 
    
    foreach($items as $item) { 
        $tomm_data = array(); 
        
        if($item->childNodes->length) { 
            foreach($item->childNodes as $i) { 
                $tomm_data[$i->nodeName] = $i->nodeValue; 
            } 
        } 
        
        $tomm_datas[] = $tomm_data; 
    } 

 $tomm_date = strftime("%Y%m%d",strtotime('1 day'));//내일날짜
 $tomm_time_H = "0600";
if($tomm_data != null){
   foreach($tomm_datas as $tomm_data) { 
//echo	$tomm_data['category']."<br>";
//echo $tomm_data['fcstDate'];
//echo $tomm_date;
     if($tomm_data['fcstDate'] == $tomm_date){
//echo $tomm_data['fcstTime'] .":" .$tomm_time_H."<br>";
	if($tomm_data['category'] == "SKY" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_sky = $tomm_data['fcstValue'];
			if($today_SKY == "1"){
				$Tomm_sky = "맑음";
			}else if($Tomm_sky == "2"){
				$Tomm_sky = "구름조금";
			}else if($Tomm_sky == "3"){
				$Tomm_sky = "구름많음";
			}else if($Tomm_sky == "4"){
				$Tomm_sky = "흐림";
			}else{
				$Tomm_sky = "-";
			}

        }
	$this->Tomm_sky = $Tomm_sky;

	if($tomm_data['category'] == "WSD" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_wsd = $tomm_data['fcstValue'];
        }
	$this->Tomm_wsd = $Tomm_wsd;
	if($tomm_data['category'] == "T3H" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_t3h = $tomm_data['fcstValue'];
 	} 
	$this->Tomm_t3h = $Tomm_t3h;

/*	if($tomm_data['category'] == "POP" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_pop = $tomm_data['fcstValue'];
 	$this->Tomm_pop = $Tomm_pop;
	}*/

	if($tomm_data['category'] == "PTY" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_pty = $tomm_data['fcstValue'];
			if($Tomm_pty == "0"){
				$Tomm_pty = "없음";
			}
			if($Tomm_pty == "1"){
				$Tomm_pty = "비";
			}
			if($Tomm_pty == "2"){
				$Tomm_pty = "비/눈";
			}
			if($Tomm_pty == "3"){
				$Tomm_pty = "눈";
			}
	$this->Tomm_pty = $Tomm_pty;
        } 
	if($tomm_data['category'] == "R06" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_r06 = $tomm_data['fcstValue'];
		if($Tomm_r06 == "0"){
			$Tomm_r06 = "0";
		}
		if($Tomm_r06 == "1"){
			$Tomm_r06 = "1";
		}
		if($Tomm_r06 == "5"){
			$Tomm_r06 = "1~4";
		}
		if($Tomm_r06 == "10"){
			$Tomm_r06 = "5~9";
		}

		if($Tomm_r06 == "20"){
			$Tomm_r06 = "10~19";
		}
		if($Tomm_r06 == "40"){
			$Tomm_r06 = "20~39";
		}
		if($Tomm_r06 == "70"){
			$Tomm_r06 = "40~69";
		}
		if($Tomm_r06 == "100"){
			$Tomm_r06 = "70";
		}
 	$this->Tomm_r06 = $Tomm_r06;
        } 
	if($tomm_data['category'] == "S06" and $tomm_data['fcstTime'] == "$tomm_time_H"){
		$Tomm_s06 = $tomm_data['fcstValue'];
			if($Tomm_s06 == '0'){
				$Tomm_s06 = "0";
			}
			if($Tomm_s06 == '1'){
				$Tomm_s06 = "1";
			}
			if($Tomm_s06 == '5'){
					$Tomm_s06 = "1~4";
			}
			if($Tomm_s06 == '10'){
					$Tomm_s06 = "5~9";
			}
			if($Tomm_s06 == '20'){
					$Tomm_s06 = "10~19";
			}
			if($Tomm_s06 == '100'){
					$Tomm_s06 = "20";
			}
		 	$this->Tomm_s06 = $Tomm_s06;
	} 

      }
    } 
   }
  }

}

}

?>