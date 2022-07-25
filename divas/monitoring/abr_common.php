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
			<img src="../images/title_02_01.png" alt="일반 방송">
		</div>
		<div class="right_bg">
		<ul class="tb_alarm h550p">
		<form id="alarm_frm" name="alarm_frm" method="get">
			<input type="hidden" id="ORGAN_ID" name="ORGAN_ID">
			<input type="hidden" id="USER_ID" name="USER_ID">
			<input type="hidden" id="RTU_CNT" name="RTU_CNT">
			<input type="hidden" id="IS_PLAN" name="IS_PLAN" value="0"><!-- 전송유형 0:즉시, 1:예약 -->
			<input type="hidden" id="SCRIPT_NO" name="SCRIPT_NO">
			<input type="hidden" id="SCRIPT_TYPE" name="SCRIPT_TYPE" value="1"><!-- 방송문안 유형 0:모바일, 1:피씨 -->
			<input type="hidden" id="SCRIPT_UNIT" name="SCRIPT_UNIT" value="T"><!-- 방송문안 구분 T:문자(문자변환), R:음성(음성녹음), M:녹음(장비저장) -->
			<input type="hidden" id="SECTION_NO" name="SECTION_NO">
			<input type="hidden" id="SCRIPT_RECORD_FILE" name="SCRIPT_RECORD_FILE"><!-- 음성녹음 원본 파일 정보 -->
			<input type="hidden" id="SCRIPT_TIMESTAMP" name="SCRIPT_TIMESTAMP">
			<input type="hidden" id="SCRIPT_PLAY_SECONDS" name="SCRIPT_PLAY_SECONDS"><!-- 저장방송 재생 시간(초단위) -->
			<input type="hidden" id="LOG_TYPE" name="LOG_TYPE" value="0"><!-- 로그유형 0:방송, 1:범위호출, 2:원격장비설정 -->
			<input type="hidden" id="MOBILE_SEND_USER" name="MOBILE_SEND_USER"><!-- 모바일 전송 확인용 -->
			<input type="hidden" id="VHF_MSG_GRP" name="VHF_MSG_GRP"><!-- VHF 그룹번호(VHF 사용 시 이용) -->
			<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송지역 RTU_ID -->
			<input type="hidden" id="PLAN_CYCLE" name="PLAN_CYCLE"><!-- 예약방송 방송주기 W:매주, D:매일, M:매월 -->
			<input type="hidden" id="PLAN_CYCLE_WEEK" name="PLAN_CYCLE_WEEK"><!-- 예약방송 매주일 때 요일 -->
			<input type="hidden" id="PLAN_HH24" name="PLAN_HH24"><!-- 예약방송 시간 -->
			<input type="hidden" id="PLAN_MI" name="PLAN_MI"><!-- 예약방송 분 -->
			<input type="hidden" id="PLAN_START_DATE" name="PLAN_START_DATE"><!-- 예약방송 시작날짜 -->
			<input type="hidden" id="PLAN_END_DATE" name="PLAN_END_DATE"><!-- 예약방송 종료날짜 -->
			<input type="hidden" id="SCRIPT_BODY_COUNT"><!-- 글자수 -->
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry"><span style="font-size: 1.5em;">①</span> 방송지역 선택 : <span id="rtu_cnt_text">0</span> 개소
							<button type="button" id="btn_all" class="btn_bs60">전체선택</button>
						</li>
						<li id="tree">					
							<ul>
							<?
							// 관리자 이거나 장비 권한이 있으면 방송지역 가져옴
							if(ss_is_rtu_id || (ss_user_type == 0 || ss_user_type == 1 || ss_user_type == 7)){
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
							}
							?>	
							</ul>
						</li>
					</ul>
				</div>
			</li>
			<li class="mi"></li>
			
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry"><span style="font-size: 1.5em;">②</span> 방송구분
							<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" size="1" class="f333_12">
							<option value="0">전체</option>
						<?
						if($data_gubun){
							foreach($data_gubun as $key => $val){
						?>
							<option value="<?=$val['SECTION_NO']?>"><?=$val['SECTION_NAME']?></option>
						<?
							}
						}
						?>
							</select>
						</li>
						<li id="list_table" class="h100">			
						<?
						if($data_script){
							foreach($data_script as $key => $val){
						?>
							<ul id="list_<?=$val['SCRIPT_NO']?>">
							<li>[<?=$val['SCRIPT_UNIT_NAME']?>] <?=$val['SCRIPT_TITLE']?></li>
							<li id="li_SCRIPT_NO" style="display:none"><?=$val['SCRIPT_NO']?></li>
							<li id="li_OWN_TYPE" style="display:none"><?=$val['OWN_TYPE']?></li>
							<li id="li_ORGAN_ID" style="display:none"><?=$val['ORGAN_ID']?></li>
							<li id="li_USER_ID" style="display:none"><?=$val['USER_ID']?></li>
							<li id="li_SCRIPT_UNIT" style="display:none"><?=$val['SCRIPT_UNIT']?></li>
							<li id="li_SCRIPT_UNIT_NAME" style="display:none"><?=$val['SCRIPT_UNIT_NAME']?></li>
							<li id="li_SECTION_NO" style="display:none"><?=$val['SECTION_NO']?></li>
							<li id="li_SECTION_NAME" style="display:none"><?=$val['SECTION_NAME']?></li>
							<li id="li_SCRIPT_TITLE" style="display:none"><?=$val['SCRIPT_TITLE']?></li>
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
							<li id="li_VHF_MSG_GRP" style="display:none"><?=$val['VHF_MSG_GRP']?></li>
							<li id="li_SCRIPT_SORT" style="display:none"><?=$val['SCRIPT_SORT']?></li>
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
						<li><span style="font-size: 1.5em;">③</span> 방송제목 : 
							<input type="text" id="SCRIPT_TITLE" name="SCRIPT_TITLE" size="60" class="f333_12">
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
								<select id="CHIME_START_CNT" name="CHIME_START_CNT" size="1" class="select_s">
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
								<select id="CHIME_END_NO" name="CHIME_END_NO" size="1" class="select_b">
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
								<select id="CHIME_END_CNT" name="CHIME_END_CNT" size="1" class="select_s">
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
								<select id="SCRIPT_BODY_CNT" name="SCRIPT_BODY_CNT" size="1" class="select_s">
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
						<li class="pT_15">
							<span style="font-size: 1.5em;">④</span>&nbsp;&nbsp;
							<button type="button" id="btn_alarm" class="btn_bb80">방송하기</button>
							<button type="button" id="btn_plan" class="btn_wbb80">방송예약</button>
							<button type="button" id="btn_edit" class="btn_wgb110">방송 등록/편집</button>
						</li>
					</ul>
				</div>
			</li>
		</form>	
		</ul>
		</div>
		<div id="alarm_table">
			&nbsp;
		</div><!-- 최근방송 현황 -->
			
	</div>
	</div>
	<!--본문내용섹션 끝-->


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
							<th>방송성공여부</th>
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

</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout_b">
	<div class="popup_top">방송예약 설정
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con_2">
		<ul>
			<li class="left">방송주기 : </li>
            <li class="right">
				<select id="T_PLAN_CYCLE">
					<option value="W">매주</option>
					<option value="D">매일</option>
					<option value="M">매월</option>
				</select>
				<select id="T_PLAN_CYCLE_WEEK">
					<option value="1">월</option>
					<option value="2">화</option>
					<option value="3">수</option>
					<option value="4">목</option>
					<option value="5">금</option>
					<option value="6">토</option>
					<option value="0">일</option>
				</select>
			</li>
			<li class="left">시간 : </li>
            <li class="right">
				<select id="T_PLAN_HH24">
				<?	
				for($i = 0; $i < 24; $i ++){
					$tmp_h = ($i< 10) ? '0'.$i : $i;
				?>
					<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
				<? 
				}
				?>
				</select> 시
				<select id="T_PLAN_MI">
				<?	
				for($i = 0; $i < 60; $i ++){
					$tmp_m = ($i< 10) ? '0'.$i : $i;
				?>
					<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
				<? 
				}
				?>
				</select> 분
			</li>
			<li class="left">시작일 : </li>
			<li class="right"><input type="text" id="datepicker1" class="f333_12" size="12" value="<?=date("Y-m-d")?>" readonly></li>
			<li class="left bB_1gry">종료일 : </li>
			<li class="right bB_1gry"><input type="text" id="datepicker2" class="f333_12" size="12" value="<?=date("Y-m-d")?>" readonly></li>
			<li class="w100 al_C pT_15 b0 mB20">
				<button type="button" id="btn_plan_ok" class="btn_bb80">예약</button>
			</li>
		</ul>
	</div>
</div>

<form id="alarm_test" name="alarm_test" method="post">
	<input type="hidden" id="SCRIPT_CONTENT" name="SCRIPT_CONTENT"><!-- 미리듣기 내용 -->
	<input type="hidden" id="SCRIPT_FILENAME" name="SCRIPT_FILENAME"><!-- 파일 이름 -->
	<iframe id="alarm_iframe" name="alarm_iframe" width="0" height="0" style="display: none;"></iframe>
</form>

<script type="text/javascript">
$(document).ready(function(){
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
		alarm_table(1, "#alarm_table");
	}

	// 테이블 업데이트
	function table_update(){
		alarm_table(2, "#alarm_table");
	}

	// 트리메뉴 호출
	if(ie_version == "N/A"){ // ie가 아닐 경우
		$("#tree").jstree({
			'plugins':["wholerow", "checkbox"]
		});
	}else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
		$("#tree").jstree({
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

	// 방송목록 선택
	$("#list_table ul").click(function(){
		var tmp_id = "#"+this.id;
		var SCRIPT_UNIT = $(tmp_id+" #li_SCRIPT_UNIT").text();
		var SCRIPT_UNIT_TEXT = "";
		var TRANS_VOLUME = $(tmp_id+" #li_TRANS_VOLUME").text();

		bg_color("selected", "#list_table ul", this); // 리스트 선택 시 배경색
		
		$("#SCRIPT_NO").val( $(tmp_id+" #li_SCRIPT_NO").text() );
		$("#ORGAN_ID").val( $(tmp_id+" #li_ORGAN_ID").text() );
		$("#USER_ID").val( $(tmp_id+" #li_USER_ID").text() );
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
		// 목록 선택시 글자수 300자 체크
		checkWord();
	});
	
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

	// 방송하기
	$("#btn_alarm").click(function(){
		if( abr_check("I") ){
			swal({
				title: '<div class="alpop_top_b">방송전송 확인</div><div class="alpop_mes_b">방송을 보내실 겁니까?</div>',
				text: '확인 시 방송이 전송 됩니다.',
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
					$("#IS_PLAN").val(0); // 전송유형 즉시
					
					var param = "mode=alarm_insert&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result[0]){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.href = "abr_state.php?log_no="+data.result[1]; return false;
					        }else{
							    swal("체크", "방송 전송중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송예약 버튼
	$("#btn_plan").click(function(){
		popup_open(); // 레이어 팝업 열기
	});
	
	// 달력 호출
	datepicker(3, "#datepicker1", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(3, "#datepicker2", "../images/icon_cal_r.png", "yy-mm-dd");
	// 방송예약 시 방송주기 선택
	$("#T_PLAN_CYCLE").change(function(){
		if(this.value == "W"){
			$("#T_PLAN_CYCLE_WEEK").show();
		}else{
			$("#T_PLAN_CYCLE_WEEK").hide();
		}
	});
	
	// 방송예약
	$("#btn_plan_ok").click(function(){
		if( abr_check("I") ){
			$("#IS_PLAN").val(1); // 전송유형 예약
			$("#PLAN_CYCLE").val( $("#T_PLAN_CYCLE").val() );
			$("#PLAN_CYCLE_WEEK").val( $("#T_PLAN_CYCLE_WEEK").val() );
			$("#PLAN_HH24").val( $("#T_PLAN_HH24").val() );
			$("#PLAN_MI").val( $("#T_PLAN_MI").val() );
			$("#PLAN_START_DATE").val( $("#datepicker1").val() );
			$("#PLAN_END_DATE").val( $("#datepicker2").val() );

			swal({
				title: '<div class="alpop_top_b">방송예약 확인</div><div class="alpop_mes_b">방송을 예약 하시겠습니까?</div>',
				text: '확인 시 방송이 예약 됩니다.',
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
					var param = "mode=plan_insert&"+$("#alarm_frm").serialize();
					$.ajax({
						type: "POST",
						url: "../_info/json/_abr_json.php",
						data: param,
						cache: false,
						dataType: "json",
						success : function(data){
							if(data.result){
								popup_main_close(); // 레이어 좌측 및 상단 닫기
								location.href = "abr_date.php"; return false;
							}else{
								swal("체크", "방송 예약중 오류가 발생 했습니다.", "warning");
							}
						}
					});
				}
			}); // swal end
		}
	});

	// 방송 등록편집
	$("#btn_edit").click(function(){
		location.href = "abr_edit.php"; return false;
	});

	// 방송 폼 체크
	function abr_check(kind){
		if(kind == "I" || kind == "U"){
			var SCRIPT_BODY = $("#SCRIPT_BODY").val().replace(/[\r|\n]/g, " ");
			$("#SCRIPT_BODY").val(SCRIPT_BODY);

			if(kind == "U"){
				if( !$("#SCRIPT_NO").val() ){
					 swal("체크", "방송문구를 선택해 주세요.", "warning"); return false;
				}
			}
			if( $("#RTU_CNT").val() == "0" || !$("#RTU_CNT").val() ){
				swal("체크", "방송 지역을 선택해 주세요.", "warning"); return false;
			}else if( !$("#SCRIPT_TITLE").val() ){
				swal("체크", "방송 제목을 입력해 주세요.", "warning");
				$("#SCRIPT_TITLE").focus(); return false;
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
			if( !$("#SCRIPT_NO").val() ){
				swal("체크", "방송문구를 선택해 주세요.", "warning"); return false;
			}else{
				 return true;
			}
		}
	}

	// 뒤로가기 관련 처리
	$("#ORGAN_ID").val("");
	$("#USER_ID").val("");
	$("#RTU_CNT").val("");
	$("#IS_PLAN").val(0);
	$("#SCRIPT_NO").val("");
	$("#SCRIPT_TYPE").val("1");
	$("#SCRIPT_UNIT").val("T");
	$("#SECTION_NO").val("");
	$("#SCRIPT_RECORD_FILE").val("");
	$("#SCRIPT_TIMESTAMP").val("");
	$("#SCRIPT_PLAY_SECONDS").val("");
	$("#LOG_TYPE").val(0);
	$("#MOBILE_SEND_USER").val("");
	$("#VHF_MSG_GRP").val("");
	$("#STR_RTU_ID").val("");
	$("#PLAN_CYCLE").val("");
	$("#PLAN_CYCLE_WEEK").val("");
	$("#PLAN_HH24").val("");
	$("#PLAN_MI").val("");
	$("#PLAN_START_DATE").val("");
	$("#PLAN_END_DATE").val("");
	$("#SECTION_NO_SEARCH").val(0);
	$("#SCRIPT_TITLE").val("");
	$("#T_PLAN_CYCLE").val("W");
	$("#T_PLAN_CYCLE_WEEK").val("1");
	$("#T_PLAN_HH24").val("00");
	$("#T_PLAN_MI").val("00");
	$("#datepicker1").val("<?=date("Y-m-d")?>");
	$("#datepicker2").val("<?=date("Y-m-d")?>");
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


