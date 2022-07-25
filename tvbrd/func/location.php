<?
// db 기존 버전에서 통합관제 버전으로 변경 및 추가
exit;

require_once "../db/_Db.php";
require_once "../class/DBmanager.php";
$DB = new DBmanager(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// rtu_info 테이블 rtu_id 조회
$sql = " SELECT rtu_id
		 FROM rtu_info ";
$rs = $DB->execute($sql);

for($i=0; $i<$DB->NUM_ROW(); $i++){
	$data_a[$i]['rtu_id'] = $rs[$i]['rtu_id'];
}
$DB->parseFree();

// wr_map_info 테이블 좌표 조회
$sql = " SELECT x_cent, y_cent, emd_cd
		 FROM wr_map_info ";

$rs_map = $DB->execute($sql);
$DB->parseFree();

// rtu_location 테이블 데이터 추가
$sql = " INSERT INTO rtu_location (rtu_id, wr_x_point, wr_y_point, wr_emd_cd) VALUES ";
for($i=0; $i<count($data_a); $i++) {
	if($i != 0) $sql.= " , ";
	$sql .= " ( '".$data_a[$i]['rtu_id']."', '".$rs_map[0]['x_cent']."', '".$rs_map[0]['y_cent']."', '".$rs_map[0]['emd_cd']."' ) ";
}
echo $sql;
$DB->QUERYONE($sql);
$DB->parseFree();
?>


