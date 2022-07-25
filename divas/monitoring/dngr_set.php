<?
require_once "../_conf/_common.php";
require_once "../_info/_set_dngr.php";
require_once "./head.php";

?>
<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="set_dngr" action="dngr_set.php" method="get">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 사용자 아이디 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_USER_ID" name="C_USER_ID"><!-- 선택한 사용자 아이디 -->
		<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송권한 지역 RTU_ID -->
		
		<div class="main_contitle">
			<img src="../images/title_06_29.png" alt="재해위험지역 관리">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>
		
		<ul class="ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					재해위험지역 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">지역명</option>
						<option value="1">시설명</option>
						<option value="2">유형</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
					<!-- <input type="file" id="excell_load" class="btn_lbs" size="3" style="width:100px; height:20px;">
					<button type="button" id="btn_excell" class="btn_lbs">엑셀등록</button> -->
					<!-- <button type="button" id="excellsample" class="btn_lbs">샘플양식</button>
					<div class="fileBox">	
					<form enctype="multipart/form-data" id="ajaxForm" method="post">			
					<input type="text" id="fileName" class="fileName" readonly="readonly">
					<label for="uploadBtn" class="btn_file" style="cursor:pointer;" onclick="">엑셀등록</label>
					<input type="file" id="uploadBtn" class="uploadBtn" name="uploadBtn" onchange="">
				
					</div>
					<button type="button" id="excellxyupdate" class="btn_lbs">좌표변환</button> -->
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
							<th class="li2">번호</th>
							<th class="li5 bL_1gry">재해위험지역코드</th>
							<th class="li5 bL_1gry">재해위험지역명</th>
							<th class="li10 bL_1gry">재해위험지역 대표주소</th>
							<th class="li5 bL_1gry">법정동코드</th>
							<th class="li3 bL_1gry">지정일자</th>
							<th class="li5 bL_1gry">유형</th>
							<th class="li5 bL_1gry">시설명</th>
							<th class="li8 bL_1gry">지정사유</th>
							<th class="li5 bL_1gry">관리기관코드</th>
							<th class="li5 bL_1gry">등록일시</th>
							<th class="li5 bL_1gry">수정일시</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['DSCODE']?>">
							<td class="li2 bL_1gry"><?=$key+1?></td>
							<td class="li5 bL_1gry" id="l_DSCODE"><?=$val['DSCODE']?></td>
							<td class="li5 bL_1gry" id="l_DSNAME"><?=$val['DSNAME']?></td>
							<td class="li10 bL_1gry" id="l_DSADDR"><?=$val['DSADDR']?></td>
							<td class="li5 bL_1gry" id="l_BDONG_CD" ><?=$val['BDONG_CD']?></td>
							<td class="li3 bL_1gry" id="l_DSAPPDAY"><?=$val['DSAPPDAY']?></td>
							<td class="li5 bL_1gry" id="l_DSTYPE"><?=$val['DSTYPE']?></td>
							<td class="li5 bL_1gry" id="l_DSFACNM"><?=$val['DSFACNM']?></td>
							<td class="li8 bL_1gry" id="l_DSRESN"><?=$val['DSRESN']?></td>
							<td class="li5 bL_1gry" id="l_ADMCODE"><?=$val['ADMCODE']?></td>
							<td class="li5 bL_1gry" id="l_RGSDE"><?=$val['RGSDE']?></td>
							<td class="li5 bL_1gry" id="l_UPDDE"><?=$val['UPDDE']?></td>
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
				<input type="hidden" id="IDX" name="IDX">
				<input type="hidden" id="LICENSE" name="LICENSE">
				<input type="hidden" id="NAME" name="NAME">
				<span class="sel_right_n">
					<? if(ss_user_type == 0 || ss_user_type == 1 || ss_user_type == 7){ ?>
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
						<td class="bg_lb w15 bold al_C bL0">재해위험지역코드</td>
						<td colspan="1">
							<input id="DSCODE" name="DSCODE" type="text" class="f333_12" size="13" readonly> *법정동코드(5자리) + 구분코드(1자리) + 일련번호(4자리)
						</td>
						<td class="bg_lb w15 bold al_C bL0">재해위험지역명</td>
						<td colspan="1">
							<input id="DSNAME" name="DSNAME" type="text" class="f333_12" size="20">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w15 bold al_C">시설명</td>
						<td colspan="1">
							<input id="DSFACNM" name="DSFACNM" type="text" class="f333_12" size="20">
						</td>
						<td class="bg_lb w15 bold al_C bL0">유형</td>
						<td colspan="1">
							<input id="tmpType" type="text" class="f333_12" size="8" style="display:none;" readonly>
							<select id="DSTYPE" name="DSTYPE" size="1" class="gaigi12">
								<option value="">유형 선택</option>
								<option value="0">하천</option>
								<option value="1">내수</option>
								<option value="2">해일</option>
								<option value="3">저수지</option>
								<option value="4">급경사지</option>
								<option value="9">기타</option>
							</select> 
						</td>
					</tr>
					<tr>
						<td class="bg_lb w15 bold al_C">재해위험지역 대표주소(지번)</td>
						<td colspan="1">
							<input name="COPR_ADDRESS2" type="text" id="COPR_ADDRESS2_IN" placeholder="" class="f333_12" size="25" style="display:none;">
							<input name="DSADDR" type="text" id="COPR_ADDRESS1_IN" placeholder="" class="f333_12" size="25">
							<button type="button" onclick="postcode(1)" value="우편번호 검색" class="btn_lbb80_s_post">우편번호 검색</button>
						</td>
						<td class="bg_lb w15 bold al_C bL0">법정동코드</td>
						<td colspan="1">
							<input id="BDONG_CD" name="BDONG_CD" type="text" maxlength="5" class="f333_12" size="13" readonly>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w15 bold al_C bL0">지정일자</td>
						<td class="w400p">
							<input name="DSAPPDAY" type="text" id="DSAPPDAY" maxlength="8" class="f333_12" size="13"> *yyyymmdd(년월일)
						</td>
						<td class="bg_lb w15 bold al_C">지정사유</td>
						<td colspan="1">
							<input id="DSRESN" name="DSRESN" type="text" class="f333_12" size="40">
						</td>
						
					</tr>
					<tr>
						<td class="bg_lb w15 bold al_C">관리기관</td>
						<td class="w400p" colspan="1">
							<select id="ADMCODE" name="ADMCODE" class="f333_12">
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
							<!-- <input name="ADMCODE" type="text" id="ADMCODE" placeholder="" class="f333_12" size="13">
							<button type="button" value="" class="btn_lbb80_s_post">관리기관코드 검색</button> -->
						</td>
						<td class="bg_lb w15 bold al_C bL0">위도/경도</td>
						<td class="w400p">
							<input name="LAT" type="text" id="LAT" placeholder="" class="f333_12" size="13"> / 
							<input name="LOT" type="text" id="LOT" placeholder="" class="f333_12" size="13">
						</td>
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

	/***************좌표 변환 ***************/
	function excell_xy_update(){
		var row = $("#list_table tbody tr").length;
		var param = "mode=farm_list";
		$.ajax({
		type: "POST",
		url: "../_info/json/_set_json.php",
		data: param,
		cache: false,
		dataType: "json",
		success : function(data){
			if(data.list){

				$.each(data.list, function (index, v) {
				
					var realaddress = v['BUSINESS_ADDRESS1'];
					naver.maps.Service.geocode({
					address: realaddress
					}, function(status, response) {
					if (status !== naver.maps.Service.Status.OK) {
					return alert('Something wrong!');
					}
					var result = response.result, // 검색 결과의 컨테이너
					items = result.items; // 검색 결과의 배열 x= 127 y = 37
					x_point = items[0].point.y;	// 37.3139221 
					y_point = items[0].point.x; // 127.1054065
					//console.log(items);
					//console.log(items[0].point.y);
						var param = "mode=excell_xy_update&x_point="+x_point+"&y_point="+y_point+"&LICENSE_NUM="+v['LICENSE_NUM'];
							$.ajax({
							type: "POST",
							url: "../_info/json/_set_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
							
								}});
							
					});
				});
			}
		}});
	}



	/***************엑셀 등록 ***************/
	var uploadFile = $('.fileBox .uploadBtn');
	uploadFile.on('change', function(){
		swal({
				title: '<div class="alpop_top_b">엑셀 등록 확인</div><div class="alpop_mes_b">엑셀을 정말로 등록하실 겁니까?</div>',
				text: '확인 시 엑셀이 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){
					var form = jQuery("#ajaxFrom")[0];
					var formData = new FormData(form);
					//formData.append("message", "ajax로 파일 전송하기");
					formData.append("file", jQuery("#uploadBtn")[0].files[0]);
					formData.append("mode", "excell_in");

					jQuery.ajax({
						url : "../_info/json/_set_json.php",
						type : "POST",
						processData : false,
						contentType : false,
						data : formData,
						success:function(json) {
							location.reload(); return false;
						}
					});
				}
			}); // swal end

	});

	/***************엑셀 샘플양식 다운로드 ***************/
	$("#excellsample").click(function(){
		window.location.assign('../_files/sample/farm_excell_sample.xls');
	});

	/***************엑셀 좌표변환 클릭 ***************/
	$("#excellxyupdate").click(function(){
		excell_xy_update();
	});

	// 엔터키 - 조회버튼
	$('#search_word').keypress(function(event){
		if ( event.which == 13 ) {
         $('#btn_search').click();
         return false;
     }
	});

	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 지역명
			search_col_id = "l_DSNAME";
		}else if(search_col == "1"){ // 시설명
			search_col_id = "l_DSFACNM";
		}else if(search_col == "2"){ // 유형
			search_col_id = "l_DSTYPE";
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
		$("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var l_DSCODE = $("#"+this.id+" #l_DSCODE").text();
		//console.log(l_USER_ID);
		var param = "mode=dngr_select&DSCODE="+l_DSCODE;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
				    $("#DSCODE").val(data.list.DSCODE);
				    $("#DSNAME").val(data.list.DSNAME);
				    $("#COPR_ADDRESS1_IN").val(data.list.DSADDR);
				    $("#BDONG_CD").val(data.list.BDONG_CD);
				    $("#DSAPPDAY").val(data.list.DSAPPDAY);

				    $("#tmpType").val(data.list.DSTYPE);
				    $("#DSTYPE").hide(); // 유형 값 변경 못하도록
				    $("#tmpType").show();

				    $("#DSFACNM").val(data.list.DSFACNM);
				    $("#DSRESN").val(data.list.DSRESN);
				    $("#ADMCODE").val(data.list.ADMCODE);
				    $("#RGSDE").val(data.list.RGSDE);
				    $("#UPDDE").val(data.list.UPDDE);
				    $("#LAT").val(data.list.LAT);
				    $("#LOT").val(data.list.LOT);
				}else{
					if(data.msg){
					   	swal("체크", data.msg, "warning");
					}else{
						swal("체크", "재해위험지역 상세 조회중 오류가 발생 했습니다.", "warning");
					}
				}
			}
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">재해위험지역 등록 확인</div><div class="alpop_mes_b">재해위험지역을 등록하실 겁니까?</div>',
				text: '확인 시 재해위험지역이 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){
					var param = "mode=dngr_in&"+$("#set_dngr").serialize();
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
								    swal("체크", "재해위험지역 등록중 오류가 발생 했습니다.", "warning");
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
		var C_DSCODE = $("#DSCODE").val();
		if(C_DSCODE != ""){
			$("#DSCODE").val("");
			$("#DSNAME").val("");
			$("#COPR_ADDRESS2_IN").val("");
			$("#BDONG_CD").val("");
			$("#DSAPPDAY").val("");
			$("#DSTYPE").val("");
			$("#DSTYPE").show(); // 유형
			$("#tmpType").hide();
			$("#DSFACNM").val("");
			$("#DSRESN").val("");
			$("#ADMCODE").val("");
			$("#RGSDE").val("");
			$("#UPDDE").val("");
			$("#LAT").val("");
			$("#LOT").val("");
		}
	});


	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			$("#DSTYPE").show(); 
			$("#tmpType").hide();
			var NAME = $("#DSNAME").val();
			//console.log(C_USER_ID);
			swal({
				title: '<div class="alpop_top_b">재해위험지역 수정 확인</div><div class="alpop_mes_b">['+NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 재해위험지역이 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=dngr_up&"+$("#set_dngr").serialize();
					
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
								    swal("체크", "재해위험지역 수정중 오류가 발생 했습니다.", "warning");
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
			var NAME = $("#DSNAME").val();
			var D_DSCODE = $("#DSCODE").val();
			swal({
				title: '<div class="alpop_top_b">재해위험지역 삭제 확인</div><div class="alpop_mes_b">['+NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 재해위험지역이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=dngr_de&DSCODE="+D_DSCODE;
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
							    swal("체크", "재해위험지역 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
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
    
	// 폼 체크

	function form_check(kind){
		
		var id_check = /^[a-zA-Z0-9]{1,15}$/; // 영어 대소문자 또는 숫자이며 15자리 이하
		//var pwd_check = /^(?=.*?[#?!@$%^&*-]).{4,}$/; // 적어도 하나의 특수문자가 들어가며 4자리 이상
		var mobile_check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/; // 전화번호 형식
		
		if(kind == "I"){
			if( !$("#DSNAME").val() ){
			    swal("체크", "재해위험지역명을 입력해 주세요.", "warning");
			    $("#DSNAME").focus(); return false;	
			}else if( !$("#DSTYPE").val() ){
			    swal("체크", "재해위험지역 유형을 입력해 주세요.", "warning");
			    $("#DSTYPE").focus(); return false;	
			}else if( !$("#COPR_ADDRESS1_IN").val() ){
			    swal("체크", "재해위험지역 대표주소를 입력해 주세요.", "warning");
			    $("#COPR_ADDRESS1_IN").focus(); return false;	
			}else if( !$("#ADMCODE").val() ){
			    swal("체크", "관리기관을 입력해 주세요.", "warning");
			    $("#ADMCODE").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#DSNAME").val() ){
			    swal("체크", "재해위험지역명을 입력해 주세요.", "warning");
			    $("#DSNAME").focus(); return false;	
			}else if( !$("#COPR_ADDRESS1_IN").val() ){
			    swal("체크", "재해위험지역 대표주소를 입력해 주세요.", "warning");
			    $("#COPR_ADDRESS1_IN").focus(); return false;	
			}else if( !$("#ADMCODE").val() ){
			    swal("체크", "관리기관을 입력해 주세요.", "warning");
			    $("#ADMCODE").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#DSCODE").val() ){
			    swal("체크", "재해위험지역을 선택해 주세요.", "warning"); return false;
			}
		}
		
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
<script type="text/javascript" src="//openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=2mnlt88fmn&submodules=geocoder&callback=naver_api"></script>
						</div>
<!---------------------  주소검색 API호출 ------------------------->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="../js/postcode_layer.js"></script>


</body>
</html>


