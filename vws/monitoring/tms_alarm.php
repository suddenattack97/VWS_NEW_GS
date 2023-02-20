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
<div id="popup_total_overlay" class="popup_total_overlay"></div>
<div id="popup_total_layout" class="popup_total_layout">
	<div class="popup_top">방송전송 이력<span id="title"></span>

		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		<button id="popup_move" class="btn_pop_blue fR bold" style="position:relative;left:-50px;">방송 상세 페이지</button>
	</div>
	<div class="popup_con">
	    <div id="list_view" class="alarm popup_big">
            <div id="spin"></div>
	    	<table class="tb_data_p">
	    		<tr>
	    			<th class="bg_lgr">사용자 정보</th>
	    			<td><span id="USER_ID_POP"></span></td>
	    			<th class="bg_lgr">전송 유형</th>
	    			<td><span id="IS_PLAN_GUBUN_POP"></span></td>
	    			<th class="bg_lgr">전송 시작 시각</th>
	    			<td><span id="LOG_DATE"></span></td>
	    		</tr>
	    		<tr>
	    			<th class="bg_lgr">방송문안</th>
	    			<td colspan="5" class="al_L"><span id="SCRIPT_BODY"></span></td>
	    		</tr>
	    	</table>
			<div class="w100 yauto" style="height:456px;">
				<table class="tb_data">
					<thead>
						<tr class="tb_data_tbg">
							<th>장비 ID</th>
							<th>장비명</th>
							<th>방송전송여부</th>
							<!-- <th>2차망 전송결과</th> -->
							<th>에러 정보</th>
							<th>최종 로깅시각</th>
							<th>녹음파일</th>
						</tr>
					</thead>
					<tbody id="list_state">
					</tbody>
				</table>
	    	</div>
	    </div>    
	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	table_load(); // 레이아웃 및 데이터 호출
	function getParam(sname) {
		var params = location.search.substr(location.search.indexOf("?") + 1);
		var sval = "";
		params = params.split("&");
		for (var i = 0; i < params.length; i++) {
			temp = params[i].split("=");
			if ([temp[0]] == sname) { sval = temp[1]; }
		}
		return sval;
	}
	if(getParam("num")){
		alarm_popup(getParam("num"));
	}
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
		alarm_table(1, "#content");
	}

	// 테이블 업데이트
	function table_update(){
		alarm_table(2, "#content");
	}
});
</script>
	
</body>
</html>


