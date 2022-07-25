<?
require_once "../_conf/_common.php";
require_once "../_info/_set_group.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="set_frm" action="set_group.php" method="get">
		<input type="hidden" id="GROUP_ID" name="GROUP_ID"><!-- 선택한 그룹 아이디 -->
		
		<div class="main_contitle">
			<img src="../images/title_06_01.png" alt="그룹 설정">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="fL"> 
					소속 기관 :
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
					<br>
					그룹명 : <input type="text" id="GROUP_NAME" name="GROUP_NAME" class="f333_12_bm" size="25">
					&nbsp;
					행정 코드 : <input type="text" id="AREA_CODE" name="AREA_CODE" class="f333_12" size="10" readonly>
					<button type="button" id="btn_area" class="btn_lgs">행정구역 조회</button>
				</span> 
				<span class="fR">
					<button type="button" id="btn_in" class="btn_bb80_l">등 록</button>
					<button type="button" id="btn_re" class="btn_lbb80_l">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_l">수 정</button>
					<button type="button" id="btn_de" class="btn_lbb80_l">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li10">그룹 ID</th>
							<th class="li70 bL_1gry">그룹명</th>
							<th class="li20 bL_1gry">행정 코드</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['GROUP_ID']?>">
							<td id="l_GROUP_ID" class="li10"><?=$val['GROUP_ID']?></td>
							<td id="l_GROUP_NAME" class="li70 bL_1gry"><?=$val['GROUP_NAME']?></td>
							<td class="li20 bL_1gry"><?=$val['AREA_CODE']?></td>
						</tr>
				<? 
					}
				}else{
				?>
						<tr id="data_not">
							<td colspan="3">데이터가 없습니다.</td>
						</tr>
				<? 
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		</div>
		
		</form>

	</div>
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
	<div class="popup_con" style="overflow-y : scroll;">
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
    	bg_color("selected", "#list_table2 tbody tr", this); // 리스트 선택 시 배경색
    	var TEXT = table.row(this).data().TEXT;
    	var AREA_CODE = table.row(this).data().AREA_CODE;
    	$("#AREA_CODE").val(AREA_CODE);
		popup_close(); // 레이어 팝업 닫기
    });
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		if(this.id == "data_not") return false;
		
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var l_GROUP_ID = $("#"+this.id+" #l_GROUP_ID").text();

		var param = "mode=group&GROUP_ID="+l_GROUP_ID;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#GROUP_ID").val(data.list.GROUP_ID);
					$("#ORGAN_ID").val(data.list.ORGAN_ID);
					$("#GROUP_NAME").val(data.list.GROUP_NAME);
					$("#AREA_CODE").val(data.list.AREA_CODE);
		        }else{
				    swal("체크", "그룹 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">그룹 등록 확인</div><div class="alpop_mes_b">그룹을 등록하실 겁니까?</div>',
				text: '확인 시 그룹이 등록 됩니다.',
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
					var param = "mode=group_in&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
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
							    	swal("체크", "그룹 등록중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
							}
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		var GROUP_ID = $("#GROUP_ID").val();
		if(GROUP_ID == ""){
			$("#GROUP_ID").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			$("#GROUP_NAME").val("");
			$("#AREA_CODE").val("");
		}else{
			var param = "mode=group&GROUP_ID="+GROUP_ID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
						$("#GROUP_ID").val(data.list.GROUP_ID);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#GROUP_NAME").val(data.list.GROUP_NAME);
						$("#AREA_CODE").val(data.list.AREA_CODE);
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
			var l_GROUP_NAME = $("#list_"+$("#GROUP_ID").val()+" #l_GROUP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">그룹 수정 확인</div><div class="alpop_mes_b">['+l_GROUP_NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 그룹이 수정 됩니다.',
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
					var param = "mode=group_up&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
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
							    	swal("체크", "그룹 수정중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
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
			var l_GROUP_NAME = $("#list_"+$("#GROUP_ID").val()+" #l_GROUP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">그룹 삭제 확인</div><div class="alpop_mes_b">['+l_GROUP_NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 그룹이 삭제 됩니다.',
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
					var param = "mode=group_de&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "그룹 삭제중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
    
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#GROUP_NAME").val() ){
			    swal("체크", "그룹명을 입력해 주세요.", "warning");
			    $("#GROUP_NAME").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#GROUP_ID").val() ){
			    swal("체크", "그룹을 선택해 주세요.", "warning"); return false;
			}else if( !$("#GROUP_NAME").val() ){
			    swal("체크", "그룹명을 입력해 주세요.", "warning");
			    $("#GROUP_NAME").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#GROUP_ID").val() ){
			    swal("체크", "그룹을 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#GROUP_ID").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	$("#GROUP_NAME").val("");
	$("#AREA_CODE").val("");
});
</script>

</body>
</html>


