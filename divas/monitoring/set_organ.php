<?
require_once "../_conf/_common.php";
require_once "../_info/_set_organ.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
			
		<form id="set_frm" action="set_organ.php" method="get">
		<input type="hidden" id="ORGAN_ID" name="ORGAN_ID" value="<? echo $data_list[0]['ORGAN_ID'] ?>">
		<input type="hidden" id="AREA_MAIN" name="AREA_MAIN" value="<? echo $data_list[0]['AREA_MAIN'] ?>">
		<input type="hidden" id="AREA_SUB" name="AREA_SUB" value="<? echo $data_list[0]['AREA_SUB'] ?>">

		<div class="main_contitle">
			<div class="tit"><img src="../images/board_icon_aws.png"> <span>기관정보 설정</span>
			</div>  				
		</div>
		<div class="dp0">
				<ul id="search_box">
					<li>
					<span class="tit">기관 목록</span>
					<!-- <span class="tit">기관 목록 조회 : </span>
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">기관명</option>
						<option value="1">부서명</option>
						<option value="2">행정코드</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bb80 mL_10"><i class="fa fa-search mR_5 font15"></i>조회</button>
					<button type="button" id="btn_search_all" class="btn_lbb80_s w90p"><i class="fa fa-list-alt mR_5 font15"></i>전체목록</button> -->
</li></ul>
					
		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">ID</th>
							<th class="li10 bL_1gry">기관명</th>
							<th class="li15 bL_1gry">부서명</th>
							<th class="li40 bL_1gry">행정코드</th>
							<!-- <th class="li15 bL_1gry">행정구역</th> -->
							<th class="li15 bL_1gry">정렬기준</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					$rowCnt = set_cnt;
					$rowNum = 0;
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['ORGAN_ID']?>">
							<td id="l_ORGAN_ID" class="li5"><?=$val['ORGAN_ID']?></td>
							<td id="l_ORGAN_NAME" class="li10 bL_1gry"><?=$val['ORGAN_NAME']?></td>
							<td id="l_DEPARTMENT" class="li15 bL_1gry"><?=$val['DEPARTMENT']?></td>
							<td id="l_AREA_CODE" class="li40 bL_1gry"><?=$val['AREA_CODE']?></td>
							<!-- <td class="li15 bL_1gry"><?=$val['TEXT']?></td> -->
							<td class="li15 bL_1gry"><?=$val['SORT_BASE_NAME']?></td>
						</tr>
				<? 
						$rowNum++;
					}
					for($i=0; $i<($rowCnt-$rowNum); $i++){
						echo "<tr>
						<td></td><td></td><td></td><td></td><td></td>
						</tr>";
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<div class="guide_txt"> <ul><li class="icon"><i class="fa fa-exclamation-circle col_org"></i></li><li class="txt02">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</li></ul></div>
				</div>
		</div>

		<div class="right_bg2">
		<ul id="search_box">
					<li>
					<span class="tit">기관정보 설정</span>
				<!-- <span class="sel_right_n">
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span> -->
			</li>
			</ul>
			<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">기관명</td>
						<td><input type="text" id="ORGAN_NAME" name="ORGAN_NAME" class="f333_12" size="20" maxlength="20"
							value="<? echo $data_list[0]['ORGAN_NAME'] ?>">
						</td>
						<td class="bg_lb w10 bold al_C">부서명</td>
						<td><input type="text" id="DEPARTMENT" name="DEPARTMENT" class="f333_12" size="20" maxlength="20"
							value="<? echo $data_list[0]['DEPARTMENT'] ?>"></td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">행정코드</td>
						<td>
							<input type="text" id="AREA_CODE" name="AREA_CODE" class="f333_12 bg_lgr_d" size="20" 
							value="<? echo $data_list[0]['AREA_CODE'] ?>" readonly>
							<button type="button" id="btn_area" class="btn_bbr w100p">행정구역 조회</button>
						</td>
						<td class="bg_lb w10 bold al_C">장비정렬기준</td>
						<td>
							<select id="SORT_BASE" name="SORT_BASE" class="f333_12" size="1">
								<option value="2" <? if($data_list[0]['SORT_BASE'] == 2){echo "selected";} ?> >장비이름</option>
								<option value="1" <? if($data_list[0]['SORT_BASE'] == 1){echo "selected";} ?> >행정코드</option>
								<option value="0" <? if($data_list[0]['SORT_BASE'] == 0){echo "selected";} ?> >지정순서</option>
							</select>
						</td>
					</tr>
				</table>
			</li>
		</ul>
		<div class="guide_btn"> 
					<!-- <button type="button" id="btn_in" class="btn_bb80"><i class="fa fa-plus mR5 font15"></i>등록</button> -->
					<!-- <button type="button" id="btn_re" class="btn_lbb80_s"><i class="fa fa-repeat mR5 font15"></i>초기화</button> -->
					<button type="button" id="btn_up" class="btn_lbb80_s"><i class="fa fa-edit mR5 font15"></i>저장</button>
					<!-- <button type="button" id="btn_de" class="btn_lbb80_s"><i class="fa fa-times mR5 font15"></i>삭제</button> -->
		</div>
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
		<table id="list_table2" class="tb_data2 bL_1gry bR_1gry" style="border-top:1px solid #6e96de !important; width: 99.7%;">
			<thead>
				<tr class="tb_data2_tbg">
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

	// 엔터키 - 조회버튼
	$('input[name=search_word]').keydown(function(key){
		if(key.keyCode == 13){
			$("#btn_search").click();
			return false;
		}
	});

	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 기관명
			search_col_id = "l_ORGAN_NAME";
		}else if(search_col == "1"){ // 부서명
			search_col_id = "l_DEPARTMENT";
		}else if(search_col == "2"){ // 행정코드
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
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		if(this.id){
			var l_ORGAN_ID = $("#"+this.id+" #l_ORGAN_ID").text();
	
			var param = "mode=organ&ORGAN_ID="+l_ORGAN_ID;
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					if(data.list){
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#ORGAN_NAME").val(data.list.ORGAN_NAME);
						$("#DEPARTMENT").val(data.list.DEPARTMENT);
						$("#AREA_CODE").val(data.list.AREA_CODE);
						$("#AREA_MAIN").val(data.list.AREA_MAIN);
						$("#AREA_SUB").val(data.list.AREA_SUB);
						$("#SORT_BASE").val(data.list.SORT_BASE);
					}else{
						swal("체크", "기관정보 상세 조회중 오류가 발생 했습니다.", "warning");
					}
				}
			});
		}
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">기관정보 등록 확인</div><div class="alpop_mes_b">기관정보를 등록하실 겁니까?</div>',
				text: '확인 시 기관정보가 등록 됩니다.',
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
					var param = "mode=organ_in&"+$("#set_frm").serialize();
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
							    	swal("체크", "기관정보 등록중 오류가 발생 했습니다.", "warning");
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
	// $("#btn_re").click(function(){
	// 	var ORGAN_ID = $("#ORGAN_ID").val("");

	// 		$("#ORGAN_ID").val("");
	// 		$("#ORGAN_NAME").val("");
	// 		$("#DEPARTMENT").val("");
	// 		$("#AREA_CODE").val("");
	// 		$("#AREA_MAIN").val("");
	// 		$("#AREA_SUB").val("");
	// 		$("#SORT_BASE").val(0);
	// 		$("#list_table tbody tr").removeClass('selected');
	// });

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var l_ORGAN_NAME = $("#list_"+$("#ORGAN_ID").val()+" #l_ORGAN_NAME").text();
			swal({
				title: '<div class="alpop_top_b">기관정보 저장 확인</div><div class="alpop_mes_b">['+l_ORGAN_NAME+']의 변경사항을 저장 하시겠습니까?</div>',
				text: '확인 시 기관정보가 저장 됩니다.',
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
					var param = "mode=organ_up&"+$("#set_frm").serialize();
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
							    	swal("체크", "기관정보 수정중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	
	if($("#list_table tbody tr").length == 1){
		$("#btn_de").attr("disabled", true);
		$("#btn_de").css("background-color","#666");
	}
	
	// 삭제
	$("#btn_de").click(function(){
		if( form_check("D") ){
			var l_ORGAN_NAME = $("#list_"+$("#ORGAN_ID").val()+" #l_ORGAN_NAME").text();
			swal({
				title: '<div class="alpop_top_b">기관정보 삭제 확인</div><div class="alpop_mes_b">['+l_ORGAN_NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 기관정보가 삭제 됩니다.',
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
					var param = "mode=organ_de&"+$("#set_frm").serialize();
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
							    swal("체크", "기관정보 삭제중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
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
    	bg_color("selected", "#list_table2 tbody tr", this); // 리스트 선택 시 배경색
    	var TEXT = table.row(this).data().TEXT;
    	var AREA_CODE = table.row(this).data().AREA_CODE;
    	var AREA_MAIN = TEXT.split(" ")[0];
    	var AREA_SUB = TEXT.split(" ")[1];
    	$("#AREA_CODE").val(AREA_CODE);
    	$("#AREA_MAIN").val(AREA_MAIN);
    	$("#AREA_SUB").val(AREA_SUB);
		popup_close(); // 레이어 팝업 닫기
    });
    
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#ORGAN_NAME").val() ){
			    swal("체크", "기관명을 입력해 주세요.", "warning");
			    $("#ORGAN_NAME").focus(); return false;	
			}else if( !$("#DEPARTMENT").val() ){
			    swal("체크", "부서명을 입력해 주세요.", "warning");
			    $("#DEPARTMENT").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#ORGAN_ID").val() ){
			    swal("체크", "기관을 선택해 주세요.", "warning"); return false;
			}else if( !$("#ORGAN_NAME").val() ){
			    swal("체크", "기관명을 입력해 주세요.", "warning");
			    $("#ORGAN_NAME").focus(); return false;	
			}else if( !$("#DEPARTMENT").val() ){
			    swal("체크", "부서명을 입력해 주세요.", "warning");
			    $("#DEPARTMENT").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#ORGAN_ID").val() ){
			    swal("체크", "기관을 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	// $("#search_col").val(0);
	// $("#search_word").val("");
	// $("#ORGAN_ID").val("");
	// $("#ORGAN_NAME").val("");
	// $("#DEPARTMENT").val("");
	// $("#AREA_CODE").val("");
	// $("#AREA_MAIN").val("");
	// $("#AREA_SUB").val("");
	// $("#SORT_BASE").val(0);
});
</script>

</body>
</html>


