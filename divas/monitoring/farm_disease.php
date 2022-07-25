<?
require_once "../_conf/_common.php";
require_once "../_info/_set_farm.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="set_frm" action="set_farm.php" method="get">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 사용자 아이디 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_USER_ID" name="C_USER_ID"><!-- 선택한 사용자 아이디 -->
		<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송권한 지역 RTU_ID -->
		
		<div class="main_contitle">
			<img src="../images/title_06_15.png" alt="질병 등록">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>
		
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					질병 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">질병이름</option>
						<option value="1">동물종류</option>
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
							<th class="li3">번호</th>
							<!-- <th class="li5 bL_1gry">질병코드</th> -->
							<th class="li10 bL_1gry">질병이름</th>
							<th class="li5 bL_1gry">동물종류</th>
							<th class="li5 bL_1gry">등록시간</th>
							<th class="li10 bL_1gry">질병발생시각</th>
							<th class="li10 bL_1gry">질병종료시각</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_Diseaselist){
					foreach($data_Diseaselist as $key => $val){ 
				?>
						<tr id="list_<?=$val['DISEASE_IDX']?>">
							<td id="IDX" name ="IDX" class="li3"><?=$val['DISEASE_IDX']?></td>
							<!-- <td id="DISEASE_CODE" class="li5 bL_1gry"><?=$val['DISEASE_CODE']?></td> -->
							<td id="DISEASE_NAME" class="li5 bL_1gry"><?=$val['DISEASE_NAME']?></td>
							<td id="ANIMAL_KIND" class="li10 bL_1gry"><?=($val['KIND'] == 0 ? "소" : ($val['KIND'] == 1 ? "돼지" : ($val['KIND'] == 2 ? "닭" :
							($val['KIND'] == 3 ? "돼지,닭" : ($val['KIND'] == 4 ? "소,닭" : ($val['KIND'] == 5 ? "소,돼지" : 
							($val['KIND'] == 6 ? "소,돼지,닭" : "미분류") ) ) ) ) ) ) 
							?></td>
							<td id="REG_TIME" class="li5 bL_1gry"><?=$val['REG_TIME']?></td>
							<td class="li10 bL_1gry"><?=$val['START_TIME']?></td>
							<td class="li10 bL_1gry"><?=$val['END_TIME']?></td>
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
					<? if(ss_user_type == 0 || ss_user_type == 1){ ?>
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<? } ?>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
					
						<td class="bg_lb w10 bold al_C bL0">질병이름</td>
						<td >
							<input id="DISEASE_NAME_IN" name="DISEASE_NAME_IN" type="text" class="f333_12" size="13">
						</td>
						<!-- <td class="bg_lb w10 bold al_C bL0">질병코드</td>
						<td>
							<input id="DISEASE_IDX_IN" name="DISEASE_CODE_IN" type="hidden">
							<input id="DISEASE_CODE_IN" name="DISEASE_CODE_IN" type="text" class="f333_12" size="13">
						</td> -->

						<td class="bg_lb w10 bold al_C">질병발생시각</td>
						<td colspan="1">
						<input type="text" id="starttime" name="starttime" class="time" size="8" value="<?=date("Y-m-d")?>" readonly>
						<input type="text" id="starttime_sub" name="starttime_sub" class="timesub" size="8" value="00:00:00">
						</td>
					</tr>
					<tr>
						<!-- <td class="bg_lb w10 bold al_C bL0">질병이름</td>
						<td >
							<input id="DISEASE_NAME_IN" name="DISEASE_NAME_IN" type="text" class="f333_12" size="13">
						</td> -->
						<td class="bg_lb w10 bold al_C bL0">동물종류</td>
						<td >
						<select id="ANIMAL_TYPE" name="ANIMAL_TYPE" class="f333_12">
						<? 
						if($data_Animallist){
						foreach($data_Animallist as $key => $val){ 
						?>
						<option value="<?=$val['ANIMAL_NO']?>"><?=$val['ANIMAL_NAME']?></option>
						<?
							}
						}
						?>
						</select>
						</td>
						
						<td class="bg_lb w10 bold al_C">질병종료시각</td>
						<td colspan="5">
						<input type="text" id="endtime" name="endtime" class="time" size="8" value="<?=date("Y-m-d")?>" readonly>
						<input type="text" id="endtime_sub" name="endtime_sub" class="timesub" size="8" value="00:00:00">
						<!-- <input type="checkbox" id="empty" name="empty" value="0">없음 -->
						</td>
					</tr>
					<tr>
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


<script type="text/javascript">
$(document).ready(function(){


	datepicker(3, "#starttime", "../images/icon_cal_r.png", "yy-mm-dd");
	datepicker(3, "#endtime", "../images/icon_cal.png", "yy-mm-dd");

	$(".ui-datepicker-trigger").css("left","10px");
	$("#starttime_sub").css("left","7px");
	$("#endtime_sub").css("left","7px");
	
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 사용자 ID
			search_col_id = "DISEASE_NAME";
		}else if(search_col == "1"){ // 사용자명
			search_col_id = "ANIMAL_KIND";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});

	// 동물 종류 구분
	$("#ANIMAL_TYPE").change(function(){
		var search_col = $("#ANIMAL_TYPE").val();
		console.log(search_col);
		if(search_col == "0"){ // 사용자 ID
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('소 : <input id="COW_NO" name="COW_NO" type="text" class="f333_12" size="3" value="">');
		}else if(search_col == "1"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('돼지 : <input id="PIG_NO" name="PIG_NO" type="text" class="f333_12" size="3" value="">');
		}else if(search_col == "2"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('닭 : <input id="CHICKEN_NO" name="CHICKEN_NO" type="text" class="f333_12" size="3" value="">');
		}else if(search_col == "3"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('돼지 : <input id="PIG_NO" name="PIG_NO" type="text" class="f333_12" size="3" value="">닭 : <input id="CHICKEN_NO" name="CHICKEN_NO" type="text" class="f333_12" size="3">');
		}else if(search_col == "4"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('소 : <input id="COW_NO" name="COW_NO" type="text" class="f333_12" size="3">닭 : <input id="CHICKEN_NO" name="CHICKEN_NO" type="text" class="f333_12" size="3">');
		}else if(search_col == "5"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('소 : <input id="COW_NO" name="COW_NO" type="text" class="f333_12" size="3">돼지 : <input id="PIG_NO" name="PIG_NO" type="text" class="f333_12" size="3">');
		}else if(search_col == "6"){ // 사용자명
			$('#ANIMAL_COUNT').empty();
			$('#ANIMAL_COUNT').html('소 : <input id="COW_NO" name="COW_NO" type="text" class="f333_12" size="3">돼지 : <input id="PIG_NO" name="PIG_NO" type="text" class="f333_12" size="3">닭 : <input id="CHICKEN_NO" name="CHICKEN_NO" type="text" class="f333_12" size="3">');
		}

	});
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		$("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var IDX = $("#"+this.id+" #IDX").text();
		//console.log(l_USER_ID);
		var param = "mode=Disease&IDX="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#IDX").val(data.list.DISEASE_IDX);
					$("#DISEASE_IDX_IN").val(data.list.DISEASE_IDX);
					$("#DISEASE_CODE_IN").val(data.list.DISEASE_CODE);
					$("#DISEASE_NAME_IN").val(data.list.DISEASE_NAME);
					$("#ANIMAL_TYPE").val(data.list.KIND);
					$("#REG_TIME_IN").val(data.list.REG_TIME);
					$("#starttime").val(data.list.START_TIME.substr(0,10));
					$("#starttime_sub").val(data.list.START_TIME.substr(11,9));
					$("#endtime").val(data.list.END_TIME.substr(0,10));
					$("#endtime_sub").val(data.list.END_TIME.substr(11,9));
			        if(data.right){
						$.each(data.right, function(i, v){
							//console.log(i, v);
							var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
							$("#tree").jstree("select_node", tmp_id); // jstree 해당 id 체크
						});
			        }
		        }else{
				    swal("체크", "질병 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">질병 등록 확인</div><div class="alpop_mes_b">질병을 등록하실 겁니까?</div>',
				text: '확인 시 질병이 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=disease_in&"+$("#set_frm").serialize();
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
								    swal("체크", "질병 등록중 오류가 발생 했습니다.", "warning");
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
		$("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋
		var C_USER_ID = $("#C_USER_ID").val();
		if(C_USER_ID == ""){
			$("#C_USER_ID").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			$("#USER_TYPE").val("");
			$("#MENU_TYPE").val(0);
			$("#USER_ID").val("");
			$("#USER_PWD").val("");
			$("#USER_NAME").val("");
			$("#EMAIL1").val("");
			$("#EMAIL2").val(0);
			$("#EMAIL3").val("");
			$("#MOBILE1").val("010");
			$("#MOBILE2").val("");
			$("#MOBILE3").val("");
			$("#IS_PERMIT").val(0);
			$("#SMART_MOBILE1").val("010");
			$("#SMART_MOBILE2").val("");
			$("#SMART_MOBILE3").val("");
			$("#SMART_USE").val(0);
		}else{
			var param = "mode=farm&AREA_CODE="+C_USER_ID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
				        var EMAIL = data.list.EMAIL ? data.list.EMAIL : "";
				        var MOBILE = data.list.MOBILE ? data.list.MOBILE : "";
				        var SMART_MOBILE = data.list.SMART_MOBILE ? data.list.SMART_MOBILE : "";
						$("#C_USER_ID").val(data.list.USER_ID);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#USER_TYPE").val(data.list.USER_TYPE);
						$("#MENU_TYPE").val(data.list.MENU_TYPE);
						$("#USER_ID").val(data.list.USER_ID);
						$("#USER_PWD").val(data.list.USER_PWD);
						$("#USER_NAME").val(data.list.USER_NAME);
						$("#EMAIL1").val(EMAIL.split("@")[0]);
						$("#EMAIL2").val(0);
						$("#EMAIL3").val(EMAIL.split("@")[1]);
						$("#MOBILE1").val(MOBILE.split("-")[0]);
						$("#MOBILE2").val(MOBILE.split("-")[1]);
						$("#MOBILE3").val(MOBILE.split("-")[2]);
						$("#IS_PERMIT").val(data.list.IS_PERMIT);
						$("#SMART_MOBILE1").val(SMART_MOBILE.split("-")[0]);
						$("#SMART_MOBILE2").val(SMART_MOBILE.split("-")[1]);
						$("#SMART_MOBILE3").val(SMART_MOBILE.split("-")[2]);
						$("#SMART_USE").val(data.list.SMART_USE);
						
				        if(data.right){
							$.each(data.right, function(i, v){
								//console.log(i, v);
								var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
								$("#tree").jstree("select_node", tmp_id); // jstree 해당 id 체크
							});
				        }
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
			var C_USER_ID = $("#DISEASE_NAME_IN").val();
			var IDX = $("#IDX").val();
			var NAME = $("#list_"+IDX+" #DISEASE_NAME").text();
			//console.log(C_USER_ID);
			swal({
				title: '<div class="alpop_top_b">질병 수정 확인</div><div class="alpop_mes_b">['+NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 질병이 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					//var param = "mode=farm_up&AREA_CODE="+AREA_CODE+""+$("#set_frm").serialize();
					var param = "mode=disease_up&IDX="+IDX+"&"+$("#set_frm").serialize();
					/*
					var param = "mode=farm_up&AREA_CODE="+AREA_CODE+"&BUSINESS_NAME_IN="+BUSINESS_NAME_IN+"&COPR_NUM="+COPR_NUM+
					"&COPR_NAME="+COPR_NAME+"&COPR_ADDRESS1_IN="+COPR_ADDRESS1_IN+"&COPR_ADDRESS2_IN="+COPR_ADDRESS2_IN+
					"&COPR_ADDRESS3_IN="+COPR_ADDRESS3_IN+"&BUSINESS_ADDRESS1_IN="+BUSINESS_ADDRESS1_IN+"&BUSINESS_ADDRESS2_IN="
					+BUSINESS_ADDRESS2_IN+"&BUSINESS_ADDRESS3_IN="+BUSINESS_ADDRESS3_IN+$("#set_frm").serialize();
					*/
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
								    swal("체크", "질병 수정중 오류가 발생 했습니다.", "warning");
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
			//var C_USER_ID = $("#IDX").val();
			var IDX = $("#IDX").val();
			var NAME = $("#list_"+IDX+" #DISEASE_NAME").text();
			console.log(NAME);
			//var AREA_CODE = $("#"+this.id+" #AREA_CODE").text();
			swal({
				title: '<div class="alpop_top_b">질병 삭제 확인</div><div class="alpop_mes_b">['+NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 질병이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=disease_de&IDX="+IDX;
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
							    swal("체크", "질병 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 방송권한 지역 선택
	$("#btn_right").click(function(){
		
		if( !$("#USER_TYPE").val() ){
	    	swal("체크", "사용자 구분을 선택해 주세요.", "warning");
	    	$("#USER_TYPE").focus(); return false;	
		}else if( $("#USER_TYPE").val() == "0" || $("#USER_TYPE").val() == "1" ){
	    	swal("체크", "관리자의 경우 소속기관의 모든 장비에 방송권한이 있습니다.", "warning");
	    	$("#USER_TYPE").focus(); return false;	
		}else{
			popup_open(); // 레이어 팝업 열기
		}
	});
	
	// 트리메뉴 호출
	if(ie_version == "N/A"){ // ie가 아닐 경우
		$("#tree").jstree({
			"plugins":["wholerow", "checkbox"]
		});
	}else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
		$("#tree").jstree({
			"plugins":["checkbox"]
		});
	}

	// 트리메뉴 체크 상태 변경 시
	$("#tree").on("changed.jstree", function(e, data){
		$("#STR_RTU_ID").val("");
		
	    for(i = 0; i < data.selected.length; i ++){
	    	var obj = data.instance.get_node(data.selected[i]);
	    	var type = obj.li_attr.type;
	    	var group_id = obj.li_attr.group_id;
	    	var rtu_id = obj.li_attr.rtu_id;
	    	//console.log(type, group_id, rtu_id);
	    	
	    	if(type == "rtu"){
		    	var STR_RTU_ID = $("#STR_RTU_ID").val();
		    	
		    	if(STR_RTU_ID == ""){
		    		$("#STR_RTU_ID").val(rtu_id);
		    	}else{
		    		$("#STR_RTU_ID").val(STR_RTU_ID + "-" + rtu_id);
		    	}
	    	}
	    }

		var tmp_arr_check = [];
	    var tmp_arr_split = $("#STR_RTU_ID").val().split("-");
	    $.each(tmp_arr_split, function(i, v){
	    	if(jQuery.inArray(v, tmp_arr_check) == "-1" && v != ""){
	 		   tmp_arr_check.push(v);
	    	}
	    });

	    $("#STR_RTU_ID").val( tmp_arr_check.join("-") );
	    $("#rtu_cnt_text").text( tmp_arr_check.length );
	}).jstree();
	
	// 방송권한 지역 전체선택
	$("#btn_all").click(function(){
		var now_sel = $("#tree").jstree("get_selected");
		var max_cnt = 0;
		$.each($("#tree").jstree("get_json"), function(i, v){
			max_cnt += Number(v["children"].length + 1);
		});
		
		if(now_sel.length == max_cnt){
			$("#tree").jstree("deselect_all");
		}else{
			$("#tree").jstree("select_all");
		}
	}); 
		
	// 아이디 입력 시
	$("#USER_ID").change(function(){
		$("#dup_check").val(0); // 아이디 중복체크 리셋
	});

	// 아이디 중복체크
	$("#btn_check").click(function(){
		if( !$("#USER_ID").val() ){
		    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
		    $("#USER_ID").focus(); return false;	
		}else{
			var param = "mode=user_dup&USER_ID="+$("#USER_ID").val()+"&C_USER_ID="+$("#C_USER_ID").val();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result){
					    swal("체크", "사용하실 수 있는 아이디 입니다.", "success");
				  		$("#dup_check").val(1);
			        }else{
					    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
				  		$("#dup_check").val(0);
			        }
		        }
		    });
		}
	});

	// 이메일 직접입력
	$("#EMAIL2").change(function(){
		if( $("#EMAIL2").val() == 0 ){
			$("#EMAIL3").val("");
			$("#EMAIL3").removeClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", false);
		}else{
			$("#EMAIL3").val( $("#EMAIL2").val() );
			$("#EMAIL3").addClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", true);
		}
	});
    
	// 폼 체크

	function form_check(kind){
		/*
		var id_check = /^[a-zA-Z0-9]{1,15}$/; // 영어 대소문자 또는 숫자이며 15자리 이하
		//var pwd_check = /^(?=.*?[#?!@$%^&*-]).{4,}$/; // 적어도 하나의 특수문자가 들어가며 4자리 이상
		var mobile_check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/; // 전화번호 형식
		
		if(kind == "I"){

			if( !$("#USER_TYPE").val() ){
			    swal("체크", "사용자 구분을 선택해 주세요.", "warning");
			    $("#USER_TYPE").focus(); return false;	
			}else if( !$("#USER_ID").val() ){
			    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "사용자 ID는 영어와 숫자만 사용하여 15자리 이하로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			}else if( $("#USER_ID").val() == $("#C_USER_ID").val() ){
			    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			/*    
			}else if( !pwd_check.test( $("#USER_PWD").val() ) ){
			    swal("체크", "비밀번호는 특수문자를 사용해야 하며 4자리 이상으로 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;
			*/ 
				


			/*
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "사용자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "사용자를 선택해 주세요.", "warning"); return false;
			}else if( !$("#USER_TYPE").val() ){
			    swal("체크", "사용자 구분을 선택해 주세요.", "warning");
			    $("#USER_TYPE").focus(); return false;	
			}else if( !$("#USER_ID").val() ){
			    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "사용자 ID는 영어와 숫자만 사용하여 15자리 이하로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			/*    
			}else if( !pwd_check.test( $("#USER_PWD").val() ) ){
			    swal("체크", "비밀번호는 특수문자를 사용해야 하며 4자리 이상으로 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;
			*/  
				

			/*
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "사용자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "사용자를 선택해 주세요.", "warning"); return false;
			}
		}
		*/
		return true;
		
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#dup_check").val(0); // 아이디 중복체크 리셋
	$("#C_USER_ID").val("");
	$("#STR_RTU_ID").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	$("#USER_TYPE").val("");
	$("#MENU_TYPE").val(0);
	$("#USER_ID").val("");
	$("#USER_PWD").val("");
	$("#USER_NAME").val("");
	$("#EMAIL1").val("");
	$("#EMAIL2").val(0);
	$("#EMAIL3").val("");
	$("#MOBILE1").val("010");
	$("#MOBILE2").val("");
	$("#MOBILE3").val("");
	$("#IS_PERMIT").val(0);
	$("#SMART_MOBILE1").val("010");
	$("#SMART_MOBILE2").val("");
	$("#SMART_MOBILE3").val("");
	$("#SMART_USE").val(0);
});


</script>


<!---------------------  주소검색 API 레이어팝업 오버레이------------------------>
<!--
<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:absolute;left:380px;top:380px;">
						<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
						</div>
-->
<div id="layer" style="display:none; position:absolute; left:450px; top:300px; overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">

						</div>
<!---------------------  주소검색 API호출 ------------------------->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="../js/postcode_layer.js"></script>

</body>
</html>


