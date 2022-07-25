<?
require_once "../_conf/_common.php";
require_once "../_info/_abr.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_02_03.png" alt="방송 일정">
		</div>
		<div class="right_bg">
		<ul class="tb_edit">
		<form id="alarm_frm" name="alarm_frm" method="get">
			<input type="hidden" id="PLAN_NO" name="PLAN_NO">
			<input type="hidden" id="ORGAN_ID" name="ORGAN_ID">
			<input type="hidden" id="USER_ID" name="USER_ID">
			<input type="hidden" id="RTU_CNT" name="RTU_CNT">
			<input type="hidden" id="SCRIPT_NO" name="SCRIPT_NO">
			<input type="hidden" id="SCRIPT_TYPE" name="SCRIPT_TYPE" value="1"><!-- 방송문안 유형 0:모바일, 1:피씨 -->
			<input type="hidden" id="SCRIPT_UNIT" name="SCRIPT_UNIT" value="T"><!-- 방송문안 구분 T:문자(문자변환), R:음성(음성녹음), M:녹음(장비저장) -->
			<input type="hidden" id="SECTION_NO" name="SECTION_NO">
			<input type="hidden" id="SCRIPT_TITLE" name="SCRIPT_TITLE">
			<input type="hidden" id="SCRIPT_RECORD_FILE" name="SCRIPT_RECORD_FILE"><!-- 음성녹음 원본 파일 정보 -->
			<input type="hidden" id="SCRIPT_TIMESTAMP" name="SCRIPT_TIMESTAMP">
			<input type="hidden" id="SCRIPT_PLAY_SECONDS" name="SCRIPT_PLAY_SECONDS"><!-- 저장방송 재생 시간(초단위) -->
			<input type="hidden" id="VHF_MSG_GRP" name="VHF_MSG_GRP"><!-- VHF 그룹번호(VHF 사용 시 이용) -->
			<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송지역 RTU_ID -->
			<input type="hidden" id="SCRIPT_BODY_COUNT"><!-- 글자수 -->
			<li class="tb_edit_lm">
				<div class="conte_sel">
					<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" class="select_conte_l">
						<option value="0" data-sort="0">전체</option>
					<?
					if($data_gubun){
						foreach($data_gubun as $key => $val){
					?>
						<option value="<?=$val['SECTION_NO']?>" data-sort="<?=$val['SORT_FLAG']?>"><?=$val['SECTION_NAME']?></option>
					<?
						}
					}
					?>
					</select>
                    <button type="button" id="btn_search" class="btn_bs60">조회</button>
                    <input type="text" id="search_text" name="search_text" class="input_conte">
                    <select id="search_sel" name="search_sel" class="select_conte_r">  
                     	<option value="SCRIPT_TITLE">방송제목</option>
						<option value="SCRIPT_BODY">방송문구</option>
						<option value="USER_ID">작성자ID</option>
						<option value="SECTION_NO">방송구분번호</option>
					</select>   
				</div>
				
				<div class="conte">
						<ul>
	                        <li class="conte_gry">
	                        	<ul>
	                            <li class="li15">시작일</li>
	                            <li class="li15">종료일</li>
	                            <li class="li10">방송시각</li>
	                      		<li class="li10">주기</li>
	                      		<li class="li30">제목</li>
	                      		<li class="li10">예약자</li>
	                      		<li class="li10">상태</li>
	                            </ul>
	                        </li>
	                        <li id="list_table" class="h100 w100">	
							<?
							if($data_plan){
								foreach($data_plan as $key => $val){
							?>
	                        	<ul id="list_<?=$val['PLAN_NO']?>">
	                            <li id="li_PLAN_START_DATE" class="li15"><?=$val['PLAN_START_DATE']?></li>
	                            <li id="li_PLAN_END_DATE" class="li15"><?=$val['PLAN_END_DATE']?></li>
	                            <li id="li_PLAN_HHMI" class="li10"><?=$val['PLAN_HH24'].":".$val['PLAN_MI']?></li>
	                            <li id="li_PLAN_CYCLE_NAME" class="li10"><?=$val['PLAN_CYCLE_NAME']?></li>
	                            <li id="li_SCRIPT_TITLE" class="li30"><?=$val['SCRIPT_TITLE']?></li>
	                            <li id="li_USER_ID" class="li10"><?=$val['USER_ID']?></li>
	                      		<li id="li_IS_PAUSE_NAME" class="li10"><?=$val['IS_PAUSE_NAME']?></li>
	                      		
	                            <li id="li_PLAN_HH24" style="display:none"><?=$val['PLAN_HH24']?></li>
	                            <li id="li_PLAN_MI" style="display:none"><?=$val['PLAN_MI']?></li>
								<li id="li_PLAN_NO" style="display:none"><?=$val['PLAN_NO']?></li>
								<li id="li_ORGAN_ID" style="display:none"><?=$val['ORGAN_ID']?></li>
								<li id="li_RTU_CNT" style="display:none"><?=$val['RTU_CNT']?></li>
								<li id="li_SCRIPT_NO" style="display:none"><?=$val['SCRIPT_NO']?></li>
								<li id="li_SCRIPT_TYPE" style="display:none"><?=$val['SCRIPT_TYPE']?></li>
								<li id="li_SCRIPT_UNIT" style="display:none"><?=$val['SCRIPT_UNIT']?></li>
								<li id="li_SECTION_NO" style="display:none"><?=$val['SECTION_NO']?></li>
								<li id="li_CHIME_START_NO" style="display:none"><?=$val['CHIME_START_NO']?></li>
								<li id="li_CHIME_START_CNT" style="display:none"><?=$val['CHIME_START_CNT']?></li>
								<li id="li_CHIME_END_NO" style="display:none"><?=$val['CHIME_END_NO']?></li>
								<li id="li_CHIME_END_CNT" style="display:none"><?=$val['CHIME_END_CNT']?></li>
								<li id="li_SCRIPT_BODY" style="display:none"><?=$val['SCRIPT_BODY']?></li>
								<li id="li_SCRIPT_BODY_CNT" style="display:none"><?=$val['SCRIPT_BODY_CNT']?></li>
								<li id="li_SCRIPT_RECORD_FILE" style="display:none"><?=$val['SCRIPT_RECORD_FILE']?></li>
								<li id="li_SCRIPT_TIMESTAMP" style="display:none"><?=$val['SCRIPT_TIMESTAMP']?></li>
								<li id="li_TRANS_VOLUME" style="display:none"><?=$val['TRANS_VOLUME']?></li>
								<li id="li_SCRIPT_PLAY_SECONDS" style="display:none"><?=$val['SCRIPT_PLAY_SECONDS']?></li>
								<li id="li_PLAN_CYCLE" style="display:none"><?=$val['PLAN_CYCLE']?></li>
								<li id="li_IS_PAUSE" style="display:none"><?=$val['IS_PAUSE']?></li>
								<li id="li_VHF_MSG_GRP" style="display:none"><?=$val['VHF_MSG_GRP']?></li>
	                            </ul>	
							<?
								}
							}
							?>
	                        </li>
                        </ul>
                    </div>
				</li>
				<li class="mi"></li>
				
				<li class="tb_alarm_r">
					<div class="alarm">
						<ul>
							<li>
								방송상태 : 
								<select id="IS_PAUSE" name="IS_PAUSE" class="mT5">
									<option value="0">정상</option>
									<option value="1">일시중지</option>
								</select>
								<button type="button" id="btn_rtu" class="btn_lbb80 fR">방송지역변경</button><span class="mT3 fR"  style="font-size: 1.5em; color:yellowgreen;">★&nbsp;</span>
							</li>
							<li>
                           		 방송주기 : 
								<select id="PLAN_CYCLE" name="PLAN_CYCLE">
									<option value="W">매주</option>
									<option value="D">매일</option>
									<option value="M">매월</option>
								</select> 
								<select id="PLAN_CYCLE_WEEK" name="PLAN_CYCLE_WEEK">
									<option value="1">월</option>
									<option value="2">화</option>
									<option value="3">수</option>
									<option value="4">목</option>
									<option value="5">금</option>
									<option value="6">토</option>
									<option value="0">일</option>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;방송시간 : 
								<select id="PLAN_HH24" name="PLAN_HH24">
								<?	
								for($i = 0; $i < 24; $i ++){
									$tmp_h = ($i< 10) ? '0'.$i : $i;
								?>
									<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
								<? 
								}
								?>
								</select>시 
								<select id="PLAN_MI" name="PLAN_MI">
									<?	
									for($i = 0; $i < 60; $i ++){
										$tmp_m = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
									<? 
									}
									?>
								</select>분
							</li>
							<li class="alarm_gry_b">
								시작일 : <input type="text" name="PLAN_START_DATE" value="<?=date('Y-m-d')?>" id="PLAN_START_DATE" class="f333_12" size="12" readonly>
								&nbsp;종료일 : <input type="text" name="PLAN_END_DATE" value="<?=date('Y-m-d')?>" id="PLAN_END_DATE" class="f333_12" size="12" readonly>
							</li>
							<li>
								<span class="sel_left">시작효과음 : 
									<select id="CHIME_START_NO" name="CHIME_START_NO" size="1" class="select_b">
										<option value="">시작음선택</option>
								<?
								if($data_chime){
									foreach($data_chime as $key => $val){
								?>
										<option value="<?=$val['CHIME_NO']?>" <?if($val['CHIME_NO']==19) echo "selected"?>>
											<?=$val['CHIME_NAME']?>
										</option>
								<?
									}
								}
								?>
									</select>
								</span> 
								<span class="sel_right"> 시작효과반복횟수 : 
									<select id="CHIME_START_CNT" name="CHIME_START_CNT" class="select_s">
											<option value="0">0</option>
											<option value="1" selected="">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<span class="sel_left"> 종료효과음 : 
									<select id="CHIME_END_NO" name="CHIME_END_NO" class="select_b">
										<option value="">종료음선택</option>
								<?
								if($data_chime){
									foreach($data_chime as $key => $val){
								?>
										<option value="<?=$val['CHIME_NO']?>" <?if($val['CHIME_NO']==19) echo "selected"?>>
											<?=$val['CHIME_NAME']?>
										</option>
								<?
									}
								}
								?>
									</select>
								</span> 
								<span class="sel_right"> 종료효과반복횟수 : 
									<select id="CHIME_END_CNT" name="CHIME_END_CNT" class="select_s">
										<option value="0">0</option>
										<option value="1" selected="">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<span class="sel_left"> 방송종류 : 
									<span id="SCRIPT_UNIT_TEXT" class="fbb_12">문자음성변환방송</span>
								</span> 
								<span class="sel_right"> 방송내용반복횟수 : 
									<select id="SCRIPT_BODY_CNT" name="SCRIPT_BODY_CNT" class="select_s">
											<option value="0">0</option>
											<option value="1" selected="">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<button type="button" id="btn_alarm_test" class="btn_lbb80">미리듣기</button>
								<div class="vcontrol">
									<span class="vcon_span">볼륨</span> 
									<span class="volnum">
										<select id="TRANS_VOLUME" name="TRANS_VOLUME">
											<? for($i=0; $i<=16; $i++){ ?>
			                                <option value="<?=$i?>" <?if($i==16) echo "selected"?>><?=$i?></option>
			                                <? } ?>
										</select>
									</span>
								</div>
							</li>
							<li class="alarm_100">
								<textarea id="SCRIPT_BODY" name="SCRIPT_BODY" class="f333_12 textarea3"></textarea>
							</li>
							<li class="alarm_gry_b">
								<span id="counter" style="font-size:16px; float:right;">/ 300&nbsp;</span>
							</li>
							<li class="pT_15" style="text-align: right;">
								<button type="button" id="btn_reset" class="btn_bb80">초기화</button>
								<button type="button" id="btn_update" class="btn_wbb80">수정</button>
								<button type="button" id="btn_delete" class="btn_wbb80">삭제</button>
							</li>
						</ul>
					</div>
				</li>
			</form>	
			</ul>
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div class="popup_top">방송지역 변경
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con">
		<div class="alarm">
			<ul>
				<li class="alarm_gry">방송지역 선택 : <span id="rtu_cnt_text">0</span> 개소
					<button type="button" id="btn_all" class="btn_bs60">전체선택</button>
				</li>
				<li id="tree">					
					<ul>
					<?
					if($data_equip){
						foreach($data_equip as $key => $val){
					?>
						<li id="tree_<?=$val['GROUP_ID']?>" type="group"><?=$val['GROUP_NAME']."(".$val['RTU_CNT']."개소)"?>
							<ul>
						
					<? 
							if($data_equip2){
								foreach($data_equip2 as $key2 => $val2){
									if($val['GROUP_ID'] == $val2['GROUP_ID']){
					?>
								<li id="tree_<?=$val['GROUP_ID']?>_<?=$val2['RTU_ID']?>" type="rtu" group_id="<?=$val['GROUP_ID']?>" rtu_id="<?=$val2['RTU_ID']?>">
									<?=$val2['RTU_NAME']?>
								</li>
					<?
									}else{
										continue; // GROUP_ID 다를 경우 다음 배열 시작
									}
									//echo "<script>console.log('".$key."/".$key2."');</script>";
								}
							}
					?>	
							
							</ul>
						</li>
					<?
						}
					}
					?>	
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

<form id="alarm_test" name="alarm_test" method="post">
	<input type="hidden" id="SCRIPT_CONTENT" name="SCRIPT_CONTENT"><!-- 미리듣기 내용 -->
	<input type="hidden" id="SCRIPT_FILENAME" name="SCRIPT_FILENAME"><!-- 파일 이름 -->
	<iframe id="alarm_iframe" name="alarm_iframe" width="0" height="0" style="display: none;"></iframe>
</form>

<script type="text/javascript">
$(document).ready(function(){
	// 트리메뉴 호출
	if(ie_version == "N/A"){ // ie가 아닐 경우
		$('#tree').jstree({
			'plugins':["wholerow", "checkbox"]
		});
	}else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
		$('#tree').jstree({
			'plugins':["checkbox"]
		});
	}

	// 트리메뉴 체크 상태 변경 시
	$('#tree').on("changed.jstree", function(e, data){
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

	    $("#RTU_CNT").val( tmp_arr_check.length );
	    $("#STR_RTU_ID").val( tmp_arr_check.join("-") );
	    $("#rtu_cnt_text").text( tmp_arr_check.length );
	}).jstree();
	
	// 방송지역 전체선택
	$("#btn_all").click(function(){
		var now_sel = $('#tree').jstree('get_selected');
		var max_cnt = 0;
		$.each($('#tree').jstree('get_json'), function(i, v){
			max_cnt += Number(v['children'].length + 1);
		});
		
		if(now_sel.length == max_cnt){
			$('#tree').jstree('deselect_all');
		}else{
			$('#tree').jstree('select_all');
		}
	}); 
	
	// 방송구분 셀렉트
	$("#SECTION_NO_SEARCH").change(function(){
		$.each($("#list_table ul #li_SECTION_NO"), function(i, v){
			if( $("#SECTION_NO_SEARCH").val() == 0 ){
				$(this).closest("ul").show();
			}else if( $("#SECTION_NO_SEARCH").val() != $(this).text() ){
				$(this).closest("ul").hide();
			}else if( $("#SECTION_NO_SEARCH").val() == $(this).text() ){
				$(this).closest("ul").show();
			}
		});
	});
	
	// 상단 조회
	$("#btn_search").click(function(){
		$("#SECTION_NO_SEARCH").val(0);
		
		var sel = $("#search_sel").val();
		var text = $("#search_text").val();
		
		$.each($("#list_table ul #li_"+sel), function(i, v){
			//console.log($(this).text());
			if( $(this).text().indexOf(text) == -1 ){
				$(this).closest("ul").hide();
			}else{
				$(this).closest("ul").show();
			}
		});
	});

	$("#SCRIPT_BODY").keyup(function(){
		var text_length = this.value.length;
		checkWord();
	});

	var tmp_script = "";

	// 방송문구 300자 이상, 특수문자 체크
	function checkWord(){
		var script = $("#SCRIPT_BODY").val(); 
		var tmp_length = $("#SCRIPT_BODY").val().length;
		if(tmp_length > 300){
			alert('300자 이상일경우 방송이 제한됩니다.');
			$("#SCRIPT_BODY").val(tmp_script);
			return false;
		}
		// var regex = /^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|]*$/;
		// if(!regex.test($("#SCRIPT_BODY").val())){
		//     alert('특수문자는 사용할 수 없습니다.');
		//     $("#SCRIPT_BODY").val(tmp_script);
		//     return false;
		// }
		$('#SCRIPT_BODY_COUNT').val(tmp_length);
		$('#counter').html(tmp_length + " / 300&nbsp;");
		tmp_script = script;
	}

	// 방송목록 선택
	$("#list_table ul").click(function(){
		$('#tree').jstree('deselect_all'); // jstree 전체 체크 해제
		
		var tmp_id = "#"+this.id;
		var SCRIPT_UNIT = $(tmp_id+" #li_SCRIPT_UNIT").text();
		var SCRIPT_UNIT_TEXT = "";
		var TRANS_VOLUME = $(tmp_id+" #li_TRANS_VOLUME").text();
		var PLAN_CYCLE = $(tmp_id+" #li_PLAN_CYCLE").text();

		bg_color("selected", "#list_table ul", this); // 리스트 선택 시 배경색

		$("#PLAN_START_DATE").val( $(tmp_id+" #li_PLAN_START_DATE").text() );
		$("#PLAN_END_DATE").val( $(tmp_id+" #li_PLAN_END_DATE").text() );
		$("#PLAN_HH24").val( $(tmp_id+" #li_PLAN_HH24").text() );
		$("#PLAN_MI").val( $(tmp_id+" #li_PLAN_MI").text() );
		
		$("#PLAN_NO").val( $(tmp_id+" #li_PLAN_NO").text() );
		$("#ORGAN_ID").val( $(tmp_id+" #li_ORGAN_ID").text() );
		$("#USER_ID").val( $(tmp_id+" #li_USER_ID").text() );
		$("#RTU_CNT").val( $(tmp_id+" #li_RTU_CNT").text() );
		$("#SCRIPT_NO").val( $(tmp_id+" #li_SCRIPT_NO").text() );
		$("#SCRIPT_TYPE").val( $(tmp_id+" #li_SCRIPT_TYPE").text() );
		$("#SCRIPT_UNIT").val(SCRIPT_UNIT);
		if(SCRIPT_UNIT == "T"){
			SCRIPT_UNIT_TEXT = "문자음성변환방송";
		}else if(SCRIPT_UNIT == "R"){
			SCRIPT_UNIT_TEXT = "음성녹음방송";
		}else{ // M
			SCRIPT_UNIT_TEXT = "장비저장방송";
		}
		$("#SCRIPT_UNIT_TEXT").text(SCRIPT_UNIT_TEXT);
		$("#SECTION_NO").val( $(tmp_id+" #li_SECTION_NO").text() );
		$("#SCRIPT_TITLE").val( $(tmp_id+" #li_SCRIPT_TITLE").text() );
		$("#CHIME_START_NO").val( $(tmp_id+" #li_CHIME_START_NO").text() );
		$("#CHIME_START_CNT").val( $(tmp_id+" #li_CHIME_START_CNT").text() );
		$("#CHIME_END_NO").val( $(tmp_id+" #li_CHIME_END_NO").text() );
		$("#CHIME_END_CNT").val( $(tmp_id+" #li_CHIME_END_CNT").text() );
		$("#SCRIPT_BODY").val( $(tmp_id+" #li_SCRIPT_BODY").text() );
		$("#SCRIPT_BODY_CNT").val( $(tmp_id+" #li_SCRIPT_BODY_CNT").text() );
		$("#SCRIPT_RECORD_FILE").val( $(tmp_id+" #li_SCRIPT_RECORD_FILE").text() );
		$("#SCRIPT_TIMESTAMP").val( $(tmp_id+" #li_SCRIPT_TIMESTAMP").text() );
		$("#TRANS_VOLUME").val(TRANS_VOLUME);
		$("#slider").slider("value", TRANS_VOLUME);
		$("#SCRIPT_PLAY_SECONDS").val( $(tmp_id+" #li_SCRIPT_PLAY_SECONDS").text() );
		if(PLAN_CYCLE == "D" || PLAN_CYCLE == "M"){		
			$("#PLAN_CYCLE").val(PLAN_CYCLE);
			$("#PLAN_CYCLE_WEEK").hide();
		}else{
			$("#PLAN_CYCLE").val("W");
			$("#PLAN_CYCLE_WEEK").val(PLAN_CYCLE);
			$("#PLAN_CYCLE_WEEK").show();
		}
		$("#IS_PAUSE").val( $(tmp_id+" #li_IS_PAUSE").text() );
		$("#VHF_MSG_GRP").val( $(tmp_id+" #li_VHF_MSG_GRP").text() );

		// 방송예약 장비 체크
		var param = "mode=plan_rtu&"+$("#alarm_frm").serialize();
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_abr_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$.each(data.list, function(i, v){
						//console.log(i, v);
						var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
						$('#tree').jstree('select_node', tmp_id); // jstree 해당 id 체크
					});
		        }
	        }
	    });
	});
	
	// 방송예약 시 방송주기 선택
	$("#PLAN_CYCLE").change(function(){
		if(this.value == "W"){
			$("#PLAN_CYCLE_WEEK").show();
		}else{
			$("#PLAN_CYCLE_WEEK").hide();
		}
	});
	
	// 달력 호출
	datepicker(3, "#PLAN_START_DATE", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(3, "#PLAN_END_DATE", "../images/icon_cal_r.png", "yy-mm-dd");
	
	// 미리듣기
	$("#btn_alarm_test").click(function(){
		if( $("#SCRIPT_BODY").val() ){
			var CONTENT = $("#SCRIPT_BODY").val().replace(/[\r|\n]/g, " ");
			CONTENT = encodeURI(CONTENT);
			$("#SCRIPT_CONTENT").val(CONTENT);
			var FILENAME = $("#SCRIPT_TIMESTAMP").val();
			$("#SCRIPT_FILENAME").val(FILENAME);
			
			$("#alarm_test").attr("action", "../func/audioGenerator/toTTS2.php");
			$("#alarm_test").attr("target", "alarm_iframe");
			$("#alarm_test").submit();
		}else{
			swal("체크", "방송 내용을 입력해 주세요.", "warning");
		}
	});
	
	// 볼륨 슬라이더
	var select = $("#TRANS_VOLUME");
	if( $("#slider").length == 0 ){
		var slider = $( "<div id='slider'></div>" ).insertAfter(select).slider({
			min: 0,
			max: 16,
			range: "min",
			value: select[0].selectedIndex,
			slide: function(event, ui) {
				select[0].selectedIndex = ui.value;
			}
		});
	}
	$("#TRANS_VOLUME").change(function(){
		$("#slider").slider("value", this.value);
	});

	// 초기화
	$("#btn_reset").click(function(){
		$("#list_"+$("#PLAN_NO").val()).trigger("click");
	});
	
	// 방송예약 수정
	$("#btn_update").click(function(){
		if( abr_check("U") ){
			swal({
				title: '<div class="alpop_top_b">방송예약 수정 확인</div><div class="alpop_mes_b">방송예약을 수정하실 겁니까?</div>',
				text: '확인 시 예약이 수정 됩니다.',
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
					var param = "mode=plan_update&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "방송예약 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송예약 삭제
	$("#btn_delete").click(function(){
		if( abr_check("D") ){
			swal({
				title: '<div class="alpop_top_b">방송예약 삭제 확인</div><div class="alpop_mes_b">방송예약을 삭제하실 겁니까?</div>',
				text: '확인 시 예약이 삭제 됩니다.',
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
					var param = "mode=plan_delete&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "방송예약 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 방송지역변경
	$("#btn_rtu").click(function(){
		if( !$("#PLAN_NO").val() ){
			swal("체크", "방송예약 문구를 선택해 주세요.", "warning"); return false;
		}else{			
			popup_open(); // 레이어 팝업 열기
		}
	});
	
	// 방송 폼 체크
	function abr_check(kind){
		if(kind == "I" || kind == "U"){
			var SCRIPT_BODY = $("#SCRIPT_BODY").val().replace(/[\r|\n]/g, " ");
			$("#SCRIPT_BODY").val(SCRIPT_BODY);

			if(kind == "U"){
				if( !$("#PLAN_NO").val() ){
					 swal("체크", "방송예약 문구를 선택해 주세요.", "warning"); return false;
				}
			}
			if( $("#RTU_CNT").val() == "0" || !$("#RTU_CNT").val() ){
				swal("체크", "방송 지역을 선택해 주세요.", "warning"); return false;
			}else if( !$("#CHIME_START_NO").val() ){
			    swal("체크", "시작 효과음을 선택해 주세요.", "warning");
			    $("#CHIME_START_NO").focus(); return false;	
			}else if( !$("#CHIME_END_NO").val() ){
			    swal("체크", "종료 효과음을 선택해 주세요.", "warning");
			    $("#CHIME_END_NO").focus(); return false;
			}else if( $("#SCRIPT_UNIT").val() == 'T' && !$("#SCRIPT_BODY").val() ){
			    swal("체크", "방송 내용을 입력해 주세요.", "warning");
				$("#SCRIPT_BODY").focus(); return false;
			}else if( $("#SCRIPT_BODY_COUNT").val() > 300 ){
			    swal("체크", "300자 이상일경우 방송이 제한됩니다.", "warning");
				$("#SCRIPT_BODY").focus(); return false;
			}else{
				 return true;
			}
		}else if(kind == "D"){
			if( !$("#PLAN_NO").val() ){
				swal("체크", "방송예약 문구를 선택해 주세요.", "warning"); return false;
			}else{
				 return true;
			}
		}
	}

	// 뒤로가기 관련 처리
	$("#PLAN_NO").val("");
	$("#ORGAN_ID").val("");
	$("#USER_ID").val("");
	$("#RTU_CNT").val("");
	$("#SCRIPT_NO").val("");
	$("#SCRIPT_TYPE").val("1");
	$("#SCRIPT_UNIT").val("T");
	$("#SECTION_NO").val("");
	$("#SCRIPT_TITLE").val("");
	$("#SCRIPT_RECORD_FILE").val("");
	$("#SCRIPT_TIMESTAMP").val("");
	$("#SCRIPT_PLAY_SECONDS").val("");
	$("#VHF_MSG_GRP").val("");
	$("#STR_RTU_ID").val("");
	$("#SECTION_NO_SEARCH").val(0);
	$("#search_sel option:eq(0)").prop("selected", true);
	$("#search_text").val("");
	$("#IS_PAUSE").val(0);
	$("#PLAN_CYCLE").val("W");
	$("#PLAN_CYCLE_WEEK").val(1);
	$("#PLAN_HH24").val("00");
	$("#PLAN_MI").val("00");
	$("#CHIME_START_NO").val("19");
	$("#CHIME_END_NO").val("19");
	$("#CHIME_START_CNT").val(1);
	$("#CHIME_END_CNT").val(1);
	$("#SCRIPT_BODY_CNT").val(1);
	$("#TRANS_VOLUME").val("16");
	$("#slider").slider("value", 16);
	$("#SCRIPT_BODY").val("");
});
</script>

</body>
</html>


