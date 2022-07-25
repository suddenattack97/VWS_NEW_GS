<?
//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 controll
//# content : 기상상황판 위성
//################################################################################################################################

@header('Content-Type: application/json');
@header("Content-Type: text/html; charset=utf-8");
$mode =  $_REQUEST["mode"];

switch($mode) {
case 'heroes':
	$time = time();
	$hour = "-9 hour";
	$coms = "";
	//$hour = "15 hour";
	//$hour = "-11 hour";

	$date = date("Ymd", strtotime($hour, $time));

	//전일 구하기 -- 데이터 불러오기 실패시 전일 데이터로 검색필요
	$bef_date = date("Ymd", strtotime(date('Ymd')." -1 day"));


	//http://newsky2.kma.go.kr/FileService/SatlitVideoInfoService/InsightSatelite?sat=C&data=ir1&area=cf&time=20180430ServiceKey=TEST_SERVICE_KEY
	$ch = curl_init();
	$url = 'http://apis.data.go.kr/1360000/SatlitImgInfoService/getInsightSatlit'; /*URL*/
	$queryParams = '?' . urlencode('ServiceKey') . '=72UJgUbwpjoDZhoR%2BEyNSa2b88EZt%2FxzwL30iZXniCBQW969MOyfjJvbMiYsLgL2HR5Dud3q%2Fy2tj0gyUv3Rxw%3D%3D'; /*Service Key*/
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
			}else{
				//데이터 없을때 전일로 검색
				//echo "aa";
				$ch = curl_init();
				$url = 'http://apis.data.go.kr/1360000/SatlitImgInfoService/getInsightSatlit'; 
				$queryParams = '?' . urlencode('ServiceKey') . '=72UJgUbwpjoDZhoR%2BEyNSa2b88EZt%2FxzwL30iZXniCBQW969MOyfjJvbMiYsLgL2HR5Dud3q%2Fy2tj0gyUv3Rxw%3D%3D'; 
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
    $returnBody = array( 'result' => true, 'data' => $coms );
     echo json_encode( $returnBody );
    exit;

break;
}
?>
