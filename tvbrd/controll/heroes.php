<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 위성
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");

require_once "../class/Divas_Util.php";//유틸 class

$dvUtil   = new Divas_Util();
$mode =  $_REQUEST["mode"];

switch($mode) {
case 'heroes':
	$time = time();
	$hour = "-9 hour";
	$coms = array();
	//$hour = "15 hour";
	//$hour = "-11 hour";

	$date = date("Ymd", strtotime($hour, $time));

	//전일 구하기 -- 데이터 불러오기 실패시 전일 데이터로 검색필요
	$bef_date = date("Ymd", strtotime(date('Ymd')." -1 day"));

	$dir = "../img/heroes/";
	// 10분내 img 파일 존재 여부 확인
	$imgFlag = true;
	$lastName = "";
	if (is_dir($dir)){   
		if ($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false){
				$name = date("YmdHi", strtotime(date('YmdHi')." -550 minutes")); // -9시간 10분
				$fileName = explode(".", $file);
				if($fileName[0] != "def_sat"){
					if(strtotime($name) >  strtotime($fileName[0])){
						if(strlen($fileName[0]) > 5) unlink($dir.$file); // 삭제
					}else{
						if($lastName == ""){
							$lastName = $fileName[0];
						}else{
							if(strtotime($lastName) < strtotime($fileName[0])) $lastName = $fileName[0];
						}
						// 최근 10분 파일
						// echo "name:" . $name . "<br>"; 
						// echo "filename:" . $fileName[0] . "<br>"; 
						$imgFlag = false;
					}
				}
			}
			closedir($dh);
		}
	}else{	// 경로에 폴더 없으면 만들어 준다.
		@mkdir($dir, 0777, true);
		@chmod($dir, 0777);
	}
	$coms['heroes'] = $lastName . ".thn.png";

	if($imgFlag){
		//http://newsky2.kma.go.kr/FileService/SatlitVideoInfoService/InsightSatelite?sat=C&data=ir1&area=cf&time=20180430ServiceKey=TEST_SERVICE_KEY
		$ch = curl_init();
		$url = 'http://apis.data.go.kr/1360000/SatlitImgInfoService/getInsightSatlit'; /*URL*/
		$queryParams = '?' . urlencode('ServiceKey') . '=NdQ4g%2B%2B7DldAW7gcYCYyafS85Jh0wXEqRuS4QYTbJCUlfoUyRSbFMJ3gn7w3TQGckHfkiRgp%2BYDYxaxLCuPn0Q%3D%3D'; /*Service Key*/
		$queryParams .= '&' . urlencode('sat') . '=' . urlencode('G2'); /*위성구분 -C: COMS(천리안위성) */
		$queryParams .= '&' . urlencode('data') . '=' . urlencode('ir105'); /*영상구분 -적외영상(ir1), -가시영상(vis), -수증기영상(wv), -단파적외영상(swir), -합성영상(com), -적외강조영상(eir) */
		$queryParams .= '&' . urlencode('area') . '=' . urlencode('ko'); /*지역구분 -전지구(cf), -아시아(a), -한반도(k), -한반도지역(lk) */
		$queryParams .= '&' . urlencode('time') . '=' . urlencode($date); /*년월일(YYYYMMDD)*/
		//$queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('P%2FzKRL5R77%2Bq9SjKOFUprJFFMUFeucm3%2BTbalGn7wpzDwMSL8GxqXZ5nyXBeeLRcaKDCDRIg8RPIzhPH%2Ff0uEQ%3D%3D'); /*서비스 인증*/

		// echo $url . $queryParams;


		curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		curl_close($ch);

		//var_dump($response);
		$object = simplexml_load_string($response);
		$channel = $object->body->items->item;
		
		// print_r($channel);
		//echo $channel->children();
			$arr_coms = array();
			if($channel){
				if($channel->children()){
					$i = 0;
					foreach($channel->children() as $val){
						$arr_coms[$i] = (string) $val;
						$i++;
					}
					//print_r($arr_coms);
					$coms['heroes'] = array_pop($arr_coms); //배열의 마지막 값만 
					// 저장할 파일명
					$linkArray = explode("lc_", $coms['heroes']);
					$filename = $dir.$linkArray[count($linkArray)-1];
					$result = $dvUtil->imgDownload($filename, $coms['heroes']);
					if($result) $coms['heroes'] = $linkArray[count($linkArray)-1];
					else $coms['heroes'] = "def_sat.png";
				}else{
					//데이터 없을때 전일로 검색
					//echo "aa";
					$ch = curl_init();
					$url = 'http://apis.data.go.kr/1360000/SatlitImgInfoService/getInsightSatlit'; 
					$queryParams = '?' . urlencode('ServiceKey') . '=P%2FzKRL5R77%2Bq9SjKOFUprJFFMUFeucm3%2BTbalGn7wpzDwMSL8GxqXZ5nyXBeeLRcaKDCDRIg8RPIzhPH%2Ff0uEQ%3D%3D'; 
					$queryParams .= '&' . urlencode('sat') . '=' . urlencode('G2'); 
					$queryParams .= '&' . urlencode('data') . '=' . urlencode('ir105'); 
					$queryParams .= '&' . urlencode('area') . '=' . urlencode('ko'); 
					$queryParams .= '&' . urlencode('time') . '=' . urlencode($bef_date); 
					//$queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('P%2FzKRL5R77%2Bq9SjKOFUprJFFMUFeucm3%2BTbalGn7wpzDwMSL8GxqXZ5nyXBeeLRcaKDCDRIg8RPIzhPH%2Ff0uEQ%3D%3D'); 

					// echo $url . $queryParams;


					curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
					$response = curl_exec($ch);
					curl_close($ch);

					//var_dump($response);
					$object = simplexml_load_string($response);
					$channel = $object->body->items->item;
					$arr_coms = array();
					if($channel){
						$i = 0;
						foreach($channel->children() as $val){
							$arr_coms[$i] = (string) $val;
							$i++;
						}
						//print_r($arr_coms);
						//$comsURL = array_pop($arr_coms); //배열의 마지막 값만 
						$coms['heroes'] = array_pop($arr_coms); //배열의 마지막 값만 
					}
				}
			}
	}
    $returnBody = array( 'result' => true, 'data' => $coms );
     echo json_encode( $returnBody );
    exit;

break;
}
?>
