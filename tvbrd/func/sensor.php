<?
// db 기존 버전에서 통합관제 버전으로 변경 및 추가
exit;

require_once "../db/_Db.php";
require_once "../class/DBmanager.php";
$DB = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// rtu_info 테이블 rtu_type 조회 (B00 제외)
$sql = " SELECT rtu_id, rtu_type
		 FROM rtu_info 
		 WHERE rtu_type != 'B00' ";
$rs = $DB->execute($sql);

for($i=0; $i<$DB->NUM_ROW(); $i++){
	$data_a[$i]['rtu_id'] = $rs[$i]['rtu_id'];
	$data_a[$i]['rtu_type'] = $rs[$i]['rtu_type'];
}
$DB->parseFree();


// rtu_sensor 테이블 데이터 추가
$sql = " INSERT INTO rtu_sensor (rtu_id, sensor_type) VALUES ";
for($i=0; $i<count($data_a); $i++) {
	if($i != 0) $sql.= " , ";
	if($data_a[$i]['rtu_type'] == "R00"){
		$sql .= " ( '".$data_a[$i]['rtu_id']."', '0' ) ";
	}else if($data_a[$i]['rtu_type'] == "F00"){
		$sql .= " ( '".$data_a[$i]['rtu_id']."', '1' ) ";
	}else if($data_a[$i]['rtu_type'] == "S00"){
		$sql .= " ( '".$data_a[$i]['rtu_id']."', '2' ) ";
	}else if($data_a[$i]['rtu_type'] == "A00"){
		$sql .= " ( '".$data_a[$i]['rtu_id']."', '0' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'A' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'T' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'W' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'H' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'R' ) ";
		$sql .= " , ( '".$data_a[$i]['rtu_id']."', 'S' ) ";
	}
}
echo $sql;
$DB->QUERYONE($sql);
$DB->parseFree();
?>


