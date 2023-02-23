<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	localStorage.setItem("layout","tms_rain.php");
	table_load(); // 레이아웃 및 데이터 호출

	// load_time마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		table_update();
	}, common_load_time);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}
	
	// 테이블 호출
	function table_load(){
		rain_table(1, "#content");
	}

	// 테이블 업데이트
	function table_update(){
		rain_table(2, "#content");
	}
});
</script>
	
</body>
</html>


