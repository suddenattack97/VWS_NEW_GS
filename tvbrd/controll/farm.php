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

//require_once "../../disos/_info/_set_farm.php";//축산 Class
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
	$arr_sub_id= $_REQUEST["arr_sub_id"];
    if(!isset($mode) && empty($mode)){
        $returnBody = array( 'result' => false, 'msg' => '잘못된 접근입니다.' );
        echo json_encode( $returnBody );
        exit;
    }

    switch($mode) {
    case 'farm':
    	$arr_data = array();
		/*
		$qry = " SELECT IDX , ANIMAL_KIND1 , DISEASE_STATE
		FROM FARM_INFO ORDER BY IDX ASC ";
		*/
		$qry = "SELECT DISTINCT a.IDX , a.ANIMAL_KIND1 , a.DISEASE_STATE , b.KIND , (SELECT state from farm_hist where a.IDX = FARM_ID ORDER BY IDX DESC LIMIT 1) as STATE
		FROM FARM_INFO as a
		LEFT JOIN FARM_DISEASE AS b ON 
		IF(a.ANIMAL_KIND1 = 0 , b.KIND = 0 , 
		IF(a.ANIMAL_KIND1 = 1 , b.KIND = 1 , 
		IF(a.ANIMAL_KIND1 = 2 , b.KIND = 2 ,
		b.KIND = 99)))
		ORDER BY IDX ASC";

		$rs = $DB->execute($qry);
		
		for($i=0; $i< $DB->NUM_ROW(); $i++){
		$data[$i]['NUM'] = $rs[$i]['IDX'];
		$data[$i]['ANIMAL_KIND1'] = $rs[$i]['ANIMAL_KIND1'];
		//$data[$i]['DISEASE_STATE'] = $rs[$i]['DISEASE_STATE'];
		$data[$i]['STATE'] = $rs[$i]['STATE'];
		$data[$i]['KIND'] = $rs[$i]['KIND'];
		}
		
		$DB->rs_unset();
		/*
			$qry = "SELECT 
			a.FARM_ID , IFNULL(b.DISEASE_IDX, '-') as  DISEASE_IDX,
			IFNULL(b.DISEASE_CODE,'-') as DISEASE_CODE,
			IFNULL(b.DISEASE_NAME,'-') as DISEASE_NAME,
			IFNULL(b.KIND,'-') as KIND , a.REG_TIME, a.START_TIME,a.END_TIME ,a.STATE
			FROM FARM_HIST as a
				LEFT JOIN FARM_DISEASE AS b ON a.DISEASE_ID = b.DISEASE_IDX
			WHERE b.DISEASE_IDX NOT IN ('-') AND a.STATE = 1 AND a.START_TIME < now()
			ORDER BY b.KIND , a.DISEASE_ID asc";
			
			$rs = $DB->execute($qry);
			
			for($i=0; $i< $DB->NUM_ROW(); $i++){
		
					$data2[$i]['FARM_ID'] = $rs[$i]['FARM_ID'];
					$data2[$i]['DISEASE_IDX'] = $rs[$i]['DISEASE_IDX'];	
					$data2[$i]['DISEASE_CODE'] = $rs[$i]['DISEASE_CODE'];
					$data2[$i]['DISEASE_NAME'] = $rs[$i]['DISEASE_NAME'];
					$data2[$i]['KIND'] = $rs[$i]['KIND'];
					//$data2[$i]['STATE'] = $rs[$i]['STATE'];
					$data2[$i]['REG_TIME'] = $rs[$i]['REG_TIME'];
					$data2[$i]['START_TIME'] = $rs[$i]['START_TIME'];
					$data2[$i]['END_TIME'] = $rs[$i]['END_TIME'];
				}
	
				$DB->rs_unset();
		*/
			if($data){
				foreach($data as $key => $val2){
					$cow = "<img id='cow_".$val2['NUM']."' src='img/icon_farm_01.png' width='' class='farm_animal'>";
					$pig = "<img id='pig_".$val2['NUM']."' src='img/icon_farm_03.png' width='' class='farm_animal'>";
					$chicken = "<img id='chicken_".$val2['NUM']."' src='img/icon_farm_02.png' width='' class='farm_animal'>";

					$cow_off = "<img id='cow_".$val2['NUM']."' src='img/icon_farm_01_off.png' width='' class='farm_animal'>";
					$pig_off = "<img id='pig_".$val2['NUM']."' src='img/icon_farm_03_off.png' width='' class='farm_animal'>";
					$chicken_off = "<img id='chicken_".$val2['NUM']."' src='img/icon_farm_02_off.png' width='' class='farm_animal'>";


					($val2['ANIMAL_KIND1'] == 0 ? $result = $cow_off : 
					($val2['ANIMAL_KIND1'] == 1 ? $result = $pig_off : 
					($val2['ANIMAL_KIND1'] == 2 ? $result = $chicken_off : 
					($val2['ANIMAL_KIND1'] == 3 ? $result = $pig_off.$chicken_off : 
					($val2['ANIMAL_KIND1'] == 4 ? $result = $cow_off.$chicken_off : 
					($val2['ANIMAL_KIND1'] == 5 ? $result = $cow_off.$pig_off : 
					($val2['ANIMAL_KIND1'] == 6 ? $result = $cow_off.$pig_off.$chicken_off : "없음"
					) ) ) ) ) ) );

					$arr_data[$val2['NUM']]['sub_id'] = $val2['NUM'];
					$arr_data[$val2['NUM']]['day'] = $result;
			

							if($val2['STATE'] == 1){
	
								//if($sdate < $val3['END_TIME']){
									$arr_data[$val2['NUM']]['sub_id'] = $val2['NUM'];
									$arr_data[$val2['NUM']]['kind'] = $val2['KIND'];
									$arr_data[$val2['NUM']]['state'] = "1";
									$arr_data[$val2['NUM']]['day'] = $result;	
								//}
					
							}else{
								$arr_data[$val2['NUM']]['sub_id'] = $val2['NUM'];
								$arr_data[$val2['NUM']]['day'] = $result;
							}



			
				} // foreach data
			} // if (data)

				/*********** 팝업 레이어 상황판 쿼리  **********/
				
		    	$qry = " SELECT COUNT(IDX) as row FROM FARM_INFO ";
				
				$data = $DB->execute($qry);
		    	$DB->rs_unset();
			
		    	$arr_total[0]['farmtotal'] = 0;

				$arr_total[0]['farmtotal'] = $data[0]['row'];

				
		    	$qry = " SELECT
				COUNT((SELECT DISTINCT FARM_ID FROM FARM_HIST WHERE a.IDX = FARM_ID AND NOW() < END_TIME AND NOW() > START_TIME AND STATE = 1)) as SUB
				FROM FARM_INFO as a
				ORDER BY SUB DESC ";
				
				$data = $DB->execute($qry);
		    	$DB->rs_unset();
				
				$arr_total[0]['farmcount'] = 0;
				$arr_total[0]['farmcount'] = $data[0]['SUB'];

				



		
		$returnBody = array( 'result' => true, 'list' => $arr_data , 'total' => $arr_total );
				
        echo json_encode( $returnBody );
        exit;
	break;
	

	/**************************
	*************************** 슬라이드 시작 **************************** 
											 *****************************/

	case 'farm_slide':
		
		// ############################# 농가 정보 ############################## */
		$qry = " SELECT
		a.IDX, a.BUSINESS_NAME , a.ANIMAL_KIND1 , a.AREA_CODE , a.COPR_NUM , a.COPR_NAME , a.COPR_ADDRESS1 , a.COPR_ADDRESS2 , 
		a.BUSINESS_ADDRESS1 , a.BUSINESS_ADDRESS2 , a.BUSINESS_STATE , a.SMART_MOBILE , a.DISEASE_STATE , a.COW_NO , a.PIG_NO , a.CHICKEN_NO , a.LICENSE_NUM ,
		IFNULL((SELECT DISTINCT FARM_ID FROM FARM_HIST WHERE a.IDX = FARM_ID AND IF(NOW() < END_TIME , 'Y','N' ) = 'Y'),'X') as SUB
		FROM FARM_INFO as a
		ORDER BY SUB DESC ";
				
				$rs = $DB->execute($qry);
		    	$DB->rs_unset();
			
		    	for($i=0; $i< $DB->NUM_ROW(); $i++){
					$data[$i]['SUB'] = $rs[$i]['SUB'];
					$data[$i]['NUM'] = $rs[$i]['IDX'];
					$data[$i]['LICENSE_NUM'] = $rs[$i]['LICENSE_NUM'];	
					$data[$i]['BUSINESS_NAME'] = $rs[$i]['BUSINESS_NAME'];
					$data[$i]['ANIMAL_KIND1'] = $rs[$i]['ANIMAL_KIND1'];
					$data[$i]['AREA_CODE'] = $rs[$i]['AREA_CODE'];
					$data[$i]['COPR_NUM'] = $rs[$i]['COPR_NUM'];
					$data[$i]['COPR_NAME'] = $rs[$i]['COPR_NAME'];
					$data[$i]['COPR_ADDRESS1'] = $rs[$i]['COPR_ADDRESS1'];
					$data[$i]['COPR_ADDRESS2'] = $rs[$i]['COPR_ADDRESS2'];
					$data[$i]['BUSINESS_ADDRESS1'] = $rs[$i]['BUSINESS_ADDRESS1'];
					$data[$i]['BUSINESS_ADDRESS2'] = $rs[$i]['BUSINESS_ADDRESS2'];
					$data[$i]['BUSINESS_STATE'] = $rs[$i]['BUSINESS_STATE'];
					$data[$i]['SMART_MOBILE'] = $rs[$i]['SMART_MOBILE'];
					$data[$i]['COW_NO'] = $rs[$i]['COW_NO'];
					$data[$i]['CHICKEN_NO'] = $rs[$i]['CHICKEN_NO'];
					$data[$i]['PIG_NO'] = $rs[$i]['PIG_NO'];
					$data[$i]['ANIMAL_COUNT'] = $rs[$i]['COW_NO'] + $rs[$i]['CHICKEN_NO'] +$rs[$i]['PIG_NO'];
					$data[$i]['DISEASE_STATE'] = $rs[$i]['DISEASE_STATE'];
					//$data[$i]['DISEASE_IDX'] = $rs[$i]['DISEASE_IDX'];
					}
					
					$resultArr["farm"] = $data;

		// ############################# 농가 질병 정보 ############################## */
		$qry = " SELECT 
			a.FARM_ID , IFNULL(b.DISEASE_IDX, '-') as  DISEASE_IDX,
			IFNULL(b.DISEASE_CODE,'-') as DISEASE_CODE,
			IFNULL(b.DISEASE_NAME,'-') as DISEASE_NAME,
			IFNULL(b.KIND,'-') as KIND , a.REG_TIME, a.START_TIME,a.END_TIME ,a.STATE
			FROM FARM_HIST as a
				LEFT JOIN FARM_DISEASE AS b ON a.DISEASE_ID = b.DISEASE_IDX
			WHERE b.DISEASE_IDX NOT IN ('-') AND a.STATE = 1 AND a.START_TIME < now()
			ORDER BY b.KIND , a.DISEASE_ID asc ";
					
					$rs = $DB->execute($qry);
					$DB->rs_unset();
					
					for($i=0; $i< $DB->NUM_ROW(); $i++){
						$data[$i]['FARM_ID'] = $rs[$i]['FARM_ID'];
						$data[$i]['DISEASE_IDX'] = $rs[$i]['DISEASE_IDX'];	
						$data[$i]['DISEASE_CODE'] = $rs[$i]['DISEASE_CODE'];
						$data[$i]['DISEASE_NAME'] = $rs[$i]['DISEASE_NAME'];
						$data[$i]['KIND'] = $rs[$i]['KIND'];
						$data[$i]['REG_TIME'] = $rs[$i]['REG_TIME'];
						$data[$i]['START_TIME'] = $rs[$i]['START_TIME'];
						$data[$i]['END_TIME'] = $rs[$i]['END_TIME'];
						$data[$i]['STATE'] = $rs[$i]['STATE'];
					}
				
					$resultArr["disease"] = $data;
		

    	$returnBody = array( 'result' => true, 'data' => $resultArr );
    	echo json_encode( $returnBody );
		exit;
		
	break;    // 슬라이드 종료






	case 'farm_icon_change':
		
		$qry = " SELECT
		a.ANIMAL_KIND1,
		IFNULL((SELECT DISTINCT FARM_ID FROM FARM_HIST WHERE a.IDX = FARM_ID AND IF(NOW() < END_TIME , 'Y','N' ) = 'Y'),'X') as SUB
		FROM FARM_INFO as a
		ORDER BY SUB DESC ";
				
				$rs = $DB->execute($qry);
		    	$DB->rs_unset();
			
		    	for($i=0; $i< $DB->NUM_ROW(); $i++){
					$data[$i]['ANIMAL_KIND1'] = $rs[$i]['ANIMAL_KIND1'];
					}
					
					$resultArr["farm"] = $data;

		$qry = " SELECT
			IFNULL(b.KIND,'-') as KIND ,a.END_TIME ,a.STATE
			FROM FARM_HIST as a
				LEFT JOIN FARM_DISEASE AS b ON a.DISEASE_ID = b.DISEASE_IDX
			WHERE b.DISEASE_IDX NOT IN ('-') AND a.STATE = 1 AND a.START_TIME < now()
			ORDER BY b.KIND , a.DISEASE_ID asc ";
					
					$rs = $DB->execute($qry);
					$DB->rs_unset();
					
					for($i=0; $i< $DB->NUM_ROW(); $i++){
						$data[$i]['KIND'] = $rs[$i]['KIND'];
						$data[$i]['END_TIME'] = $rs[$i]['END_TIME'];
						$data[$i]['STATE'] = $rs[$i]['STATE'];
					}
				
					$resultArr["disease"] = $data;
		

    	$returnBody = array( 'result' => true, 'data' => $resultArr );
    	echo json_encode( $returnBody );
		exit;
		
	break;    // 슬라이드 종료

	} // switch 종료
	
?>





