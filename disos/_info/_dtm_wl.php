<?
require_once "../include/class/rtuInfo.php";
require_once "../include/class/flowInfo.php";

$ott = $_SESSION["OTT"];

$scnt = 0;
$ecnt = 23;

$sdate = $_REQUEST['sdate'] ? $_REQUEST['sdate'] : date("Y-m-d"); // 시작 날짜

for($i=0; $i<=23; $i++){
	if($i != $scnt) $where_date .= " , ";
	if($i < 10){
		$where_date .= " '".$sdate." 0".$i.":00:00' ";
	}else{
		$where_date .= " '".$sdate." ".$i.":00:00' ";
	}
}

//수위
$LocalDB = new ClassRtuInfo($DB, 1);
$LocalDB->getRtuInfo();

//수위자료
$ClassFlowInfo = new ClassFlowInfo($DB);

for($i=0; $i<$LocalDB->rsCnt; $i++){
	$ClassFlowInfo->getFlowRpt($LocalDB->AREA_CODE[$i], "H", $where_date, "");
	
	$data_list[$i]['AREA_CODE'] = $LocalDB->AREA_CODE[$i];
	$data_list[$i]['RTU_NAME'] = $LocalDB->RTU_NAME[$i];
	
	$sum = 0;
	$cnt = 0;
	if($ClassFlowInfo->rsFlowRpt){
		foreach($ClassFlowInfo->rsFlowRpt as $key => $val) {
			$data_list[$i]['LIST'][ $val['NUM'] ] = round_data($val['FLOW'], 0.01, 100);
			if($val['FLOW'] != "-"){
				$sum += round_data($val['FLOW'], 0.01, 100);
				$cnt ++;
			}
		}
	}
	$data_list[$i]['SUM'] = ($cnt == 0) ? "-" : sprintf("%.2f", $sum);
}

$DB->CLOSE();
?>


