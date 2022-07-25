<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_set.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="wa_frm" action="wa_set.php" method="get">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 행정 코드 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_RTU_ID" name="C_RTU_ID"><!-- 선택한 장비 아이디 -->
		<input type="hidden" id="C_SIGNAL_ID" name="C_SIGNAL_ID"><!-- 선택한 장비 통신 아이디 -->
		<input type="hidden" id="C_AREA_CODE" name="C_AREA_CODE"><!-- 선택한 장비 행정 코드 -->
		
		<div class="main_contitle">
			<img src="../images/title_06_02.png" alt="장비 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>

		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					장비 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">장비명</option>
						<option value="1">행정코드</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
				</span> 
				<!--
				<span class="sel_right_n top5px"> 
					※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다. 
				</span>
				-->
			</li>
			<li class="li100_nor d_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li10">번호</th>
							<th class="li10 bL_1gry">장비 ID</th>
							<th class="li10 bL_1gry">통신 ID</th>
							<th class="li35 bL_1gry">장비명</th>
							<th class="li15 bL_1gry">행정코드</th>
							<th class="li20 bL_1gry">통신정보</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['NUM']?>" data-id="<?=$val['RTU_ID']?>">
							<td><?=$val['NUM']?></td>
							<td class="bL_1gry"><?=$val['RTU_ID']?></td>
							<td class="bL_1gry"><?=$val['SIGNAL_ID']?></td>
							<td id="l_RTU_NAME" class="bL_1gry"><?=$val['RTU_NAME']?></td>
							<td id="l_AREA_CODE" class="bL_1gry"><?=$val['AREA_CODE']?></td>
							<td class="bL_1gry"><?=$val['CONNECTION_INFO']?></td>
						</tr>
				<? 
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="top6px">설정값 입력</span> 
				<span class="sel_right_n">
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL0">장비 ID</td>
						<td class="w20"><input type="text" id="RTU_ID" name="RTU_ID" class="f333_12" size="10" value="<?=$data_id?>"></td>
						<td class="bg_lb w10 bold al_C">통신 ID</td>
						<td><input type="text" id="SIGNAL_ID" name="SIGNAL_ID" class="f333_12" size="10"></td>
						<td class="bg_lb w10 bold al_C">행정 코드</td>
						<td colspan="3">
							<input type="text" id="AREA_CODE" name="AREA_CODE" class="f333_12" size="12" maxlength="10">
							<button type="button" id="btn_check" class="btn_lgs">중복체크</button>
							<button type="button" id="btn_area" class="btn_lgs">행정구역 조회</button>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">장비명</td>
						<td>
							<input type="text" id="RTU_NAME" name="RTU_NAME" class="f333_12" size="22">
						</td>
						<td class="bg_lb w10 bold al_C">소속 기관</td>
						<td>
							<select id="ORGAN_ID" name="ORGAN_ID" class="f333_12">
						<? 
						if($data_organ){
							foreach($data_organ as $key => $val){ 
						?>
								<option value="<?=$val['ORGAN_ID']?>"><?=$val['ORGAN_NAME']?></option>
						<? 
							}
						}
						?>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">정렬 순서</td>
						<td colspan="3">
							<input id="SORT_FLAG" name="SORT_FLAG" type="text" class="f333_12" size="6">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">최종 호출시각</td>
						<td colspan="3">
							<input type="text" id="CALL_LAST_D" name="CALL_LAST_D" value="<?=date("Y-m-d")?>" class="f333_12" size="7" readonly> 
							<select id="CALL_LAST_H" name="CALL_LAST_H" class="f333_12" size="1">
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select>시 
							<select id="CALL_LAST_M" name="CALL_LAST_M" class="gaigi12" size="1">
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select>분
						</td>
						<td class="bg_lb w10 bold al_C">통신정보</td>
						<td colspan="3"><input type="text" id="CONNECTION_INFO" name="CONNECTION_INFO" class="f333_12" size="18"></td>
					</tr>
				</table>
			</li>
		</ul>
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div class="popup_top">행정구역 조회
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con">
		<table id="list_table2" class="tb_data bL_1gry bR_1gry">
			<thead>
				<tr class="tb_data_tbg">
					<th class="li10">번호</th>
					<th class="li50">행정코드</th>
					<th class="li40">행정구역</th>
				</tr>
			</thead>
		</table>
	</div>	
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 장비명
			search_col_id = "l_RTU_NAME";
		}else if(search_col == "1"){ // 행정코드
			search_col_id = "l_AREA_CODE";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		$("#dup_check").val(0); // 행정코드 중복체크 리셋
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색

		var IDX = $(this).data("id");
		var param = "mode=wa_rtu_view&RTU_ID="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#C_RTU_ID").val(data.list.RTU_ID);
					$("#C_SIGNAL_ID").val(data.list.SIGNAL_ID);
					$("#C_AREA_CODE").val(data.list.AREA_CODE);
					$("#RTU_ID").val(data.list.RTU_ID);
					$("#SIGNAL_ID").val(data.list.SIGNAL_ID);
					$("#AREA_CODE").val(data.list.AREA_CODE);
					$("#RTU_NAME").val(data.list.RTU_NAME);
					$("#CONNECTION_INFO").val(data.list.CONNECTION_INFO);
					$("#ORGAN_ID").val(data.list.ORGAN_ID);
					$("#SORT_FLAG").val(data.list.SORT_FLAG);
					$("#CALL_LAST_D").val(data.list.CALL_LAST_D);
					$("#CALL_LAST_H").val(data.list.CALL_LAST_H);
					$("#CALL_LAST_M").val(data.list.CALL_LAST_M);
		        }else{
				    swal("체크", "장비 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});
	
	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">장비 등록 확인</div><div class="alpop_mes_b">장비를 등록하실 겁니까?</div>',
				text: '확인 시 장비가 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){			
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					var param = "mode=wa_rtu_in&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
							    	swal("체크", "장비 등록중 오류가 발생 했습니다.", "warning");
						        }
							}
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		$("#dup_check").val(0); // 행정코드 중복체크 리셋
		var C_RTU_ID = $("#C_RTU_ID").val();
		if(C_RTU_ID == ""){
			$("#C_RTU_ID").val("");
			$("#C_SIGNAL_ID").val("");
			$("#C_AREA_CODE").val("");
			$("#RTU_ID").val("<?=$data_id?>");
			$("#SIGNAL_ID").val("");
			$("#AREA_CODE").val("");
			$("#RTU_NAME").val("");
			$("#CONNECTION_INFO").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			$("#SORT_FLAG").val("");
			$("#CALL_LAST_D").val("<?=date("Y-m-d")?>");
			$("#CALL_LAST_H").val("00");
			$("#CALL_LAST_M").val("00");
		}else{
			var param = "mode=wa_rtu_view&RTU_ID="+C_RTU_ID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_wa_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
						$("#C_RTU_ID").val(data.list.RTU_ID);
						$("#C_SIGNAL_ID").val(data.list.SIGNAL_ID);
						$("#C_AREA_CODE").val(data.list.AREA_CODE);
						$("#RTU_ID").val(data.list.RTU_ID);
						$("#SIGNAL_ID").val(data.list.SIGNAL_ID);
						$("#AREA_CODE").val(data.list.AREA_CODE);
						$("#RTU_NAME").val(data.list.RTU_NAME);
						$("#CONNECTION_INFO").val(data.list.CONNECTION_INFO);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#SORT_FLAG").val(data.list.SORT_FLAG);
						$("#CALL_LAST_D").val(data.list.CALL_LAST_D);
						$("#CALL_LAST_H").val(data.list.CALL_LAST_H);
						$("#CALL_LAST_M").val(data.list.CALL_LAST_M);
			        }else{
					    swal("체크", "초기화중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });
		}
	});

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var C_RTU_ID = $("#C_RTU_ID").val();
			swal({
				title: '<div class="alpop_top_b">장비 수정 확인</div><div class="alpop_mes_b">장비 ID ['+C_RTU_ID+']을 수정하실 겁니까?</div>',
				text: '확인 시 장비가 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					var param = "mode=wa_rtu_up&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
							    	swal("체크", "장비 수정중 오류가 발생 했습니다.", "warning");
					        	}
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 삭제
	$("#btn_de").click(function(){
		if( form_check("D") ){
			var C_RTU_ID = $("#C_RTU_ID").val();
			swal({
				title: '<div class="alpop_top_b">장비 삭제 확인</div><div class="alpop_mes_b">장비 ID ['+C_RTU_ID+']을 삭제하실 겁니까?</div>',
				text: '확인 시 장비가 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){					
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					var param = "mode=wa_rtu_de&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "장비 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
		
	// 행정 코드 입력 시
	$("#AREA_CODE").change(function(){
		$("#dup_check").val(0); // 행정 코드 중복체크 리셋
	});

	// 행정 코드 중복체크
	$("#btn_check").click(function(){
		if( !$("#AREA_CODE").val() ){
		    swal("체크", "행정 코드를 입력해 주세요.", "warning");
		    $("#AREA_CODE").focus(); return false;	
		}else{
			var param = "mode=wa_rtu_dup&AREA_CODE="+$("#AREA_CODE").val()+"&C_RTU_ID="+$("#C_RTU_ID").val();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_wa_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result){
					    swal("체크", "사용하실 수 있는 행정 코드 입니다.", "success");
				  		$("#dup_check").val(1);
			        }else{
					    swal("체크", "이미 사용중인 행정 코드 입니다.", "warning");
				  		$("#dup_check").val(0);
			        }
		        }
		    });
		}
	});
		
	// 행정구역 조회
	$("#btn_area").click(function(){
		popup_open(); // 레이어 팝업 열기
	});

	// 행정구역 테이블 호출
	var table = $("#list_table2").DataTable({
		serverSide: true,
        processing: true,
        paging: true,
        ordering: false,
        searching: true,
        info: false,
		autoWidth: false,
        columnDefs: [
        	{className: "dt-center", targets: "_all"}
    	],
	    language: {
	    	"emptyTable": "데이터가 없습니다.",       
	      	"loadingRecords": "로딩중...", 
	      	"processing": "처리중...",
	        "search" : "검색 : ",
	      	"paginate": {
	      		"previous": "<",
	      		"next": ">",
	      	},
	      	"zeroRecords": "검색 결과 데이터가 없습니다."
	    },
        ajax: {
            url: "../_info/json/_set_json.php",
            type: "POST",
            data: { "mode" : "area" },
            idSrc: "AREA_CODE"
        },
        columns: [
            {data: "NUM"},
            {data: "AREA_CODE"},
            {data: "TEXT"}
        ],
        pageLength: 20,
        bLengthChange: false
	});
	
	// 행정구역 선택
    $("#list_table2 tbody").on("click", "tr", function(){
		$("#dup_check").val(0); // 행정 코드 중복체크 리셋
    	bg_color("selected", "#list_table2 tbody tr", this); // 리스트 선택 시 배경색
    	var AREA_CODE = table.row(this).data().AREA_CODE;
    	$("#AREA_CODE").val(AREA_CODE);
		popup_close(); // 레이어 팝업 닫기
    });
	
	// 달력 호출
	datepicker(1, "#CALL_LAST_D", "../images/icon_cal.png", "yy-mm-dd");

	// 폼 체크
	function form_check(kind){
		var num_check = /^[0-9]*$/; // 숫자만
		//var area_check = /^[0-9]{10,10}$/; // 숫자이면서 10자리
		var area_check = /^[0-9]*$/; // 숫자만
		
		if(kind == "I"){
			if( !$("#RTU_ID").val() ){
			    swal("체크", "장비 ID를 입력해 주세요.", "warning");
			    $("#RTU_ID").focus(); return false;	
			}else if( !num_check.test( $("#RTU_ID").val() ) ){
			    swal("체크", "장비 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#RTU_ID").focus(); return false;	
			}else if( $("#RTU_ID").val() == $("#C_RTU_ID").val() ){
			    swal("체크", "이미 사용중인 장비 ID 입니다.", "warning");
			    $("#RTU_ID").focus(); return false;	
			}else if( !$("#SIGNAL_ID").val() ){
			    swal("체크", "통신 ID를 입력해 주세요.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !num_check.test( $("#SIGNAL_ID").val() ) ){
			    swal("체크", "통신 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( $("#SIGNAL_ID").val() == $("#C_SIGNAL_ID").val() ){
			    swal("체크", "이미 사용중인 통신 ID 입니다.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( !area_check.test( $("#AREA_CODE").val() ) ){
			    swal("체크", "행정 코드는  숫자만 사용하여 10자리로 입력해 주세요.", "warning"); 
			    $("#AREA_CODE").focus(); return false;	
			}else if( $("#AREA_CODE").val() == $("#C_AREA_CODE").val() ){
			    swal("체크", "이미 사용중인 행정 코드 입니다.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "행정 코드 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#RTU_NAME").val() ){
			    swal("체크", "장비명을 입력해 주세요.", "warning");
			    $("#RTU_NAME").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#C_RTU_ID").val() ){
			    swal("체크", "장비를 선택해 주세요.", "warning"); return false;
			}else if( !$("#RTU_ID").val() ){
			    swal("체크", "장비 ID를 입력해 주세요.", "warning");
			    $("#RTU_ID").focus(); return false;	
			}else if( !num_check.test( $("#RTU_ID").val() ) ){
			    swal("체크", "장비 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#RTU_ID").focus(); return false;	
			}else if( !$("#SIGNAL_ID").val() ){
			    swal("체크", "통신 ID를 입력해 주세요.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !num_check.test( $("#SIGNAL_ID").val() ) ){
			    swal("체크", "통신 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( !area_check.test( $("#AREA_CODE").val() ) ){
			    swal("체크", "행정 코드는  숫자만 사용하여 10자리로 입력해 주세요.", "warning"); 
			    $("#AREA_CODE").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "행정 코드 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#RTU_NAME").val() ){
			    swal("체크", "장비명을 입력해 주세요.", "warning");
			    $("#RTU_NAME").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#C_RTU_ID").val() ){
			    swal("체크", "장비를 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#dup_check").val(0); // 행정코드 중복체크 리셋
	$("#C_RTU_ID").val("");
	$("#C_SIGNAL_ID").val("");
	$("#C_AREA_CODE").val("");
	$("#RTU_ID").val("<?=$data_id?>");
	$("#SIGNAL_ID").val("");
	$("#AREA_CODE").val("");
	$("#RTU_NAME").val("");
	$("#CONNECTION_INFO").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	$("#SORT_FLAG").val("");
	$("#CALL_LAST_D").val("<?=date("Y-m-d")?>");
	$("#CALL_LAST_H").val("00");
	$("#CALL_LAST_M").val("00");
});
</script>

</body>
</html>


