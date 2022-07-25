<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_send.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<form id="sbd_frm" action="sbd_send.php" method="get">
		<input type="hidden" id="MSG_IDX" name="MSG_IDX"><!-- 전송할 메세지 IDX -->
		<input type="hidden" id="STR_IDX" name="STR_IDX"><!-- 전송할 전광판 아이디 -->
		<input type="hidden" id="SITEID" name="SITEID">
		<input type="hidden" id="DIVISION" name="DIVISION">
		<input type="hidden" id="TYPE_H" name="TYPE_H">

		<div class="main_contitle">
			<img src="../images/title_08_03.png" alt="메세지 전송">
		</div>
		<div class="right_bg">
		<ul class="tb_alarm h550p">
		
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="tb_sms_gry"><span style="font-size: 1.5em;">①</span> 전광판 선택 : <span id="rtu_cnt_text">0</span> 개소
							<button type="button" id="btn_all" class="btn_bs60">전체선택</button>
						</li>
						<li id="tree" class="max500">					
							<ul>
							<?
							if($data_mod_list){
								foreach($data_mod_list as $key => $val){
									$match = $val['modY']."_".$val['modX'];
							?>
								<li id="tree_<?=$val['modY']."_".$val['modX']?>" type="group"><?=$val['modY']."단 ".$val['modX']."열 (".$val['cnt']."개소)"?>
									<ul>
						
							<? 
									if($data_sign){
										foreach($data_sign as $key2 => $val2){
											$match2 = $val2['modY']."_".$val2['modX'];
											if($match == $match2){
							?>
										<li id="tree_<?=$val['modY']?>_<?=$val['modX']?>_<?=$val2['SITEID']?>" type="rtu" group_id="<?=$val['modY'].'_'.$val['modX']?>" rtu_id="<?=$val2['SITEID']?>">
											<?=$val2['SITENAME']?>(<?=$val2['modY']?>단 <?=$val2['modX']?>열)
										</li>
							<?				

												}else{
													continue; // AREAID 다를 경우 다음 배열 시작
												}
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
			</li>
			<li class="mi"></li>
			
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="tb_sms_gry"><span style="font-size: 1.5em;">②</span> 메세지 구분
							<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" size="1" class="f333_12">
								<option value="">전체</option>
								<option value="0">텍스트</option>
								<option value="1">이미지</option>
							</select>
							※메세지를 드래그하면 순서를 변경할 수 있습니다.
						</li>
						<li id="list_spin" class="p0 max500">		
            				<div id="spin"></div>
							<table class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<td class="w15i bR_1gry">순서</td>
										<td class="w85i">메세지</td>	
									</tr>
								</thead>
								<tbody id="list_table">
								<?
								if($data_list){
									foreach($data_list as $key => $val){
								?>
									<tr id="list_<?=$val['IDX']?>" data-id="<?=$val['IDX']?>" data-type="<?=$val['TYPE']?>">
										<td id="NUM" class="bR_1gry"><?=$val['NUM']?></td>
										<td style="text-align: left;">&nbsp;&nbsp;<?=$val['MSG']?></td>
									</tr>
								<?
									}
								}
								?>
								</tbody>
							</table>	
						</li>
					</ul>
				</div>
			</li>
			<li class="mi"></li>
			<li class="tb_alarm_r bg_no">
		
				<ul class="set_ulwrap_nh bT_3blue bb_3blue" id="rtu_info">
					
					<li class="tb_sms_gry">
						<button type="button" id="btnSave" class="btn_bs60 mL5">저장</button>
						<div id="areaname"></div>
					</li>
					<li class="li100_nor">
						<table class="set_tb">
							<tr>
								<td rowspan="4" class="bg_lb w10 bold al_C bL0">밝기</td>
								<td colspan="9">
									<input type="checkbox" id="USEONOFF1" name="USEONOFF1" value="Y"> 사용
									&nbsp;
									<select id="HOURONOFF1" name="HOURONOFF1" disabled>
									<?	
									for($i = 0; $i < 24; $i ++){
										$tmp_h = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
									<? 
									}
									?>
									</select> 시
									<select id="MINONOFF1" name="MINONOFF1" disabled>
									<?	
									for($i = 0; $i < 60; $i ++){
										$tmp_m = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
									<? 
									}
									?>
									</select> 분
									<select id="RIGHTONOFF1" name="RIGHTONOFF1" disabled>
									<? 
									if($data_right){
										foreach($data_right as $key => $val){ 
									?>
										<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
									<? 
										}
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="9">
									<input type="checkbox" id="USEONOFF2" name="USEONOFF2" value="Y"> 사용
									&nbsp;
									<select id="HOURONOFF2" name="HOURONOFF2" disabled>
									<?	
									for($i = 0; $i < 24; $i ++){
										$tmp_h = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
									<? 
									}
									?>
									</select> 시
									<select id="MINONOFF2" name="MINONOFF2" disabled>
									<?	
									for($i = 0; $i < 60; $i ++){
										$tmp_m = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
									<? 
									}
									?>
									</select> 분
									<select id="RIGHTONOFF2" name="RIGHTONOFF2" disabled>
									<? 
									if($data_right){
										foreach($data_right as $key => $val){ 
									?>
										<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
									<? 
										}
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="9">
									<input type="checkbox" id="USEONOFF3" name="USEONOFF3" value="Y"> 사용
									&nbsp;
									<select id="HOURONOFF3" name="HOURONOFF3" disabled>
									<?	
									for($i = 0; $i < 24; $i ++){
										$tmp_h = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
									<? 
									}
									?>
									</select> 시
									<select id="MINONOFF3" name="MINONOFF3" disabled>
									<?	
									for($i = 0; $i < 60; $i ++){
										$tmp_m = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
									<? 
									}
									?>
									</select> 분
									<select id="RIGHTONOFF3" name="RIGHTONOFF3" disabled>
									<? 
									if($data_right){
										foreach($data_right as $key => $val){ 
									?>
										<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
									<? 
										}
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="9">
									<input type="checkbox" id="USEONOFF4" name="USEONOFF4" value="Y"> 사용
									&nbsp;
									<select id="HOURONOFF4" name="HOURONOFF4" disabled>
									<?	
									for($i = 0; $i < 24; $i ++){
										$tmp_h = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
									<? 
									}
									?>
									</select> 시
									<select id="MINONOFF4" name="MINONOFF4" disabled>
									<?	
									for($i = 0; $i < 60; $i ++){
										$tmp_m = ($i< 10) ? '0'.$i : $i;
									?>
										<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
									<? 
									}
									?>
									</select> 분
									<select id="RIGHTONOFF4" name="RIGHTONOFF4" disabled>
									<? 
									if($data_right){
										foreach($data_right as $key => $val){ 
									?>
										<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
									<? 
										}
									}
									?>
									</select>
								</td>
							</tr>
						</table>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="set_ulwrap_nh bb_3blue">
		<li class="tb_sms_gry">
				<span style="font-size: 1.5em;">③</span> 메세지 전송
				<span class="sel_right_n">
					<label><input type="checkbox" id="msg_save" >메세지저장	&nbsp;</label>
					<label><input type="checkbox" id="emer" >긴급전송 &nbsp;	&nbsp;</label>
					<button type="button" id="btn_send" class="btn_bs60 mL5">전송하기</button>
					<button type="button" id="btn_re" class="btn_bs60 mL5">초기화</button>
					<button type="button" id="btn_edit" class="btn_wgb120_s">메세지 등록/편집</button>

				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td  class="bg_lb w10 bold al_C bL0">내용 구분</td>
						<td>
						
							<input type="radio" name="TYPE" value="0" checked> 텍스트 
							<input type="radio" name="TYPE" value="1"> 이미지
						</td>
						<td class="bg_lb w10 bold al_C bL0">효과</td>
						<td class="w40">
							<select id="MSGACTION" name="MSGACTION" size="1">
							<?php
							if($data_action){
								foreach($data_action as $key => $val){ 
							?>
								<option value="<?php echo $val['NUM']?>"><?php echo $val['COMMENT']?></option>
							<?php 
								}
							}
							?>
							</select>
						</td>
					</tr>

					<tr>
						<td class="bg_lb w10 bold al_C bL0">정지시간</td>
						<td>
							<select id="MSGDELAY" name="MSGDELAY" size="1">
							<?php
							for($i = 1; $i <= 20; $i ++){
							?>
								<option value="<?php echo $i?>" <?php if($i == 5){?> selected <?php } ?> ><?php echo $i?></option>
							<?php
							}
							?>
							</select> 초
						</td>
						<td class="bg_lb w10 bold al_C bL0">색상</td>
						<td>
							<select id="MSGCOLOR" name="MSGCOLOR" size="1">
							<?php
							if($data_color){
								foreach($data_color as $key => $val){ 
							?>
									<option value="<?php echo $val['NUM']?>"><?php echo $val['COMMENT']?></option>
							<?php
								}
							}
							?>
								</select>
						</td>
					</tr>

					<tr>
						<td class="bg_lb w10 bold al_C bL0">속도</td>
						<td>
							<select id="MSGSPD" name="MSGSPD" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select> 1 : 가장빠르게, 10 : 가장느리게
						</td>
						<td  class="bg_lb w10 bold al_C bL0">단 / 열</td>
						<td>
							<div id="text_type" style="display:inline;">
								단 구분 : <select style="position:relative; "id="DAN_TEXT_TYPE" name="DAN_TEXT_TYPE" size="1">
								<option value="1" selected>1</option>
								<?php	
								for($i = 2; $i <= 8; $i ++){
								?>
									<option value="<?php echo $i?>"><?php echo $i?></option>
								<?php
								}
								?>
								</select>

								&nbsp;&nbsp;/&nbsp;&nbsp;
								열 구분 : <select style="position:relative; "id="ROW_TEXT_TYPE" name="ROW_TEXT_TYPE" size="1">
								<option value="15" selected>1</option>
								<?php 
								for($i = 2; $i <= 40; $i ++){
								?>
									<option value="<?php echo 15*$i?>"><?php echo $i?></option>
								<?php
								}
								?>
								</select>
							</div>
							
							<div id="img_type" style="display:none;">
								단 구분 : <select style="position:relative; "id="DAN_IMG_TYPE" name="DAN_IMG_TYPE" size="1">
								<option value="1" selected>1</option>
								<?php	
								for($i = 2; $i <= 8; $i ++){
								?>
									<option value="<?php echo $i?>"><?php echo $i?></option>
								<?php
								}
								?>
								</select>
								
								&nbsp;&nbsp;/&nbsp;&nbsp;
								열 구분 : <select style="position:relative; "id="ROW_IMG_TYPE" name="ROW_IMG_TYPE" size="1">
								<option value="16" selected>1</option>
								<?php
								for($i = 2; $i <= 100; $i ++){
								?>
									<option value="<?php echo 16*$i?>"><?php echo $i?></option>
								<?php
								}
								?>
								</select>
							</div>
						</td>
						
					</tr>

					<tr id="img_title" style="display:none;">
						<td class="bg_lb w10 bold al_C bL0">제목</td>
						<td class="w40" colspan="3">
							<input type="text" id="TITLE" name="TITLE" class="f333_12" size="50">
							※ 주의 : 단/열의 크기를 먼저 지정하시고, 줄바꿈을 하지 말고 이어서 글자를 적어주세요. ( 지정한 열 이상 적으시면 자동 줄바꿈이 됩니다. )
						</td>
					</tr>


					<tr id="img_text" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">내용</td>
						<td height="35" colspan="3">
							<textarea id="IMG" name="IMG" wrap="off" cols="20" rows="1"></textarea>
							<br>
							※ 주의 : 메세지 등록 후 전송 시 화면에 보이는대로 전송 됩니다. 내용이 박스 안에 모두 보이도록 입력해 주세요.
							<input type="hidden" id="IMGMSG" name="IMGMSG"><!-- 이미지 내용 -->
							<input type="hidden" id="IMGPATH" name="IMGPATH"><!-- 이미지 경로 -->
						</td>
					</tr>

					<tr id="img_text2" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">이미지</td>
						<td height="300px" colspan="3">
							<div id="outerbuffer" style="overflow: hidden;padding-right:15px; background-color: black; width: 220px; display: block;vertical-align: middle;">
								<div id="img_area" class="img_area"></div>
							</div>
						</td>
					</tr>

					<tr id="msg_text" style="display: none;">
						<td rowspan="3" class="bg_lb w10 bold al_C bL0">내용</td>
						<td height="35"  rowspan="3" colspan="3">
						
							<textarea id="MSG" name="MSG" wrap="off" cols="20" rows="1" style="width: 150px; overflow-x: scroll;"></textarea>
							<br>
							※ 주의 : 메세지 등록 후 전송 시 화면에 보이는대로 전송 됩니다. 내용이 박스 안에 모두 보이도록 입력해 주세요.
						</td>
					</tr>
				</table>
			</li>
		</ul>
		</div>
		
		<input type="hidden" id="ROW_I_CHECK" value="30"/>
		<input type="hidden" id="ROW_T_CHECK" value="10"/>
		<input type="hidden" id="font_size" value="12"/>
		</form>
		<div id="popup_overlay" class="popup_overlay"></div>
		<div id="popup_layout" style="display: none;">
			<div id="pop_1" class="popup_layout_c">
				<div class="popup_top">이미지 원본
					<button id="popup_close" class="btn_lbs fR bold">X</button>
				</div>
				<div class="popup_con_1">	
					<div class="alarm">			
						<form method="get" class="sbd_scroll">
							<table class="tb_data w100">
								<tbody>
									<tr>
										<td><img id="img_area2" class="sbd_scroll" src=""></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){

	// 밝기 조정 숨김
	$("#rtu_info").hide();
	
	var initHeight = 40;

	function render() {
		var font_size = $('.tox-tbtn__select-label').text();
		$("#font_size").val(font_size.substr(0,2));	
		if (tinymce.get('IMG').getBody() != null) {
			$("#img_area").html(tinymce.get('IMG').getContent());
			// $('#img_area').empty().append(tinymce.get('IMG').getBody().innerHTML);
			$('#IMGMSG').val(tinymce.get('IMG').getBody().innerHTML);

			var ftSize = $("#IMGMSG").val();
			var index_n = ftSize.indexOf("px");
			ftSize = ftSize.substr(index_n - 2, 4);
			var ftSizeArray = ["12px", "24px", "36px", "48px"];
			//선택한 전광판목록이 있으면
			if( ftSizeArray.indexOf(ftSize) > 0 ){
				$('.tox-tbtn__select-label').html(ftSize);
			}else{
				// $('.tox-tbtn__select-label').html("24px");
			}
			// 글자크기가 바뀌었을때 - 줄간격, padding-top, 내용 칸 늘림
			var tmpSize = font_size.substr(0,2);
			var m_top = parseInt(tmpSize/10);
			var e_height = m_top;
			if(tmpSize == 48){
				e_height = -13;
				font_size = "50px";
			}else if(tmpSize == 36){
				e_height = -11;
				font_size = "37px";
			}else if(tmpSize == 24){
				e_height = -11;
				font_size = "26px";
			}else{
				e_height = -10;
				font_size = "15px";
			}
			$("#img_area").css("margin-top", e_height + "px");
			$("#img_area").css("line-height", font_size);

			// tinymce.get('IMG').editorContainer.style.height = (20 + tmpSize*2) + "px";
		}
		var line_row = $("#img_area").children('p').length;		
		tmp_bef_height = $("#DAN_IMG_TYPE").val();
		// console.log(tmp_bef_height);
		$("#outerbuffer").css("height", tmp_bef_height*16 + "px");
		// console.log($("#outerbuffer").css("height"));
	} 

	function changedDan() {

			var sender = document.getElementById("DAN_IMG_TYPE");
			var sender_row = document.getElementById("ROW_IMG_TYPE");

			initHeight = 40;
			tinymce.get('IMG').editorContainer.style.width = sender_row.value + 'px';
			if(sender_row.value <= 220){
				initHeight = 79;
			}
			tinymce.get('IMG').editorContainer.style.height = (sender.value * 16 + initHeight) + 'px';

			document.getElementById("outerbuffer").style.width = tinymce.get('IMG').editorContainer.style.width;
			// console.log($("#outerbuffer").css("width"));
			$("#outerbuffer").css("height", (sender.value * 16) + 'px');
	}

	var timer = window.setTimeout(function() {
		render();
	}, 100);

	tinymce.init({
		selector: '#IMG',
		menubar: false,
		statusbar: false,
		toolbar: 'bold italic underline forecolor fontsizeselect',
		fontsize_formats: '12px 24px 36px 48px',
		content_style:
			'body { background: black; color: Red; font-size: 12px; font-family: Gulim; overflow-y:hidden!important; vertical-align: middle;}' +
			'p { padding: 0; margin: 0px 0; }',
		color_map: [
			'FF0000', 'Red',
			'00FF00', 'Green',
			'FFCC00', 'Yellow'
		],
		custom_colors: false,
		width: 160,
		init_instance_callback: function (editor) {
			changedDan();			
			editor.on('Change', function (e) {
				window.clearTimeout(timer);
				timer = window.setTimeout(function () {
					render();
				}, 100);
			});
			editor.on('keyup', function (e) {
				window.clearTimeout(timer);
				timer = window.setTimeout(function () {
					render();
				}, 100);
			});
		},
		max_height: initHeight
	});

	// 기존 단 열 박스 체크 
	$('#ROW_TEXT_TYPE option[value="150"]').attr('selected','selected');
	$('#ROW_IMG_TYPE option[value="480"]').attr('selected','selected');
	$('#DAN_IMG_TYPE option[value="2"]').attr('selected','selected');


	$("#ROW_TEXT_TYPE").change(function(e){
		var row = e.target.value;
		var rowtext = e.target.options[e.target.selectedIndex].text;
		$("#MSG").css("width",row+"px");
		$("#ROW_T_CHECK").val(rowtext);
	});

	var bef_dan_val;
	// 이미지 단 - focus상태(바꾸기 이전 값)에 bef_dan_val에 저장하고 바꾸었을때 크기 체크, 크기 넘으면 이전 값 넣어줌
	$("#DAN_IMG_TYPE").on('focus', function(){
		bef_dan_val = this.value;
	}).change(function(){
		// console.log("bef_dan_val : ", bef_dan_val);
		var dan_val = $("#DAN_IMG_TYPE").val();
		var row_val = $("#ROW_IMG_TYPE").val();
		var total_pixel = row_val * (dan_val*16);
		if(total_pixel > 44500){
			alert("메세지-이미지 크기가 너무 큽니다!");
			$("#DAN_IMG_TYPE option:eq("+(bef_dan_val-1)+")").prop("selected", true);
		}else{
			changedDan();
		}
	});

	// 열 크기 체크
	$("#ROW_IMG_TYPE").change(function(e){
		var dan_val = $("#DAN_IMG_TYPE").val();
		var row_val = $("#ROW_IMG_TYPE").val();
		var bef_row_val = $("#ROW_I_CHECK").val();
		var total_pixel = row_val * (dan_val*16);
		// console.log("total : ", total_pixel);
		if(total_pixel > 44500){
			alert("메세지-이미지 크기가 너무 큽니다!");
			$("#ROW_IMG_TYPE option:eq("+(bef_row_val-1)+")").prop("selected", true);
		}else{
			changedDan();
			$("#ROW_I_CHECK").val($("#ROW_IMG_TYPE option:checked").text());
		}
	});

	var view_type = 0;
	var tmp ="";

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

	// 밝기 사용 여부
	$("#USEONOFF1").change(function(){
		if( $("#USEONOFF1").prop("checked") ){
			$("#HOURONOFF1").prop("disabled", false);
			$("#MINONOFF1").prop("disabled", false);
			$("#RIGHTONOFF1").prop("disabled", false);
		}else{
			$("#HOURONOFF1").prop("disabled", true);
			$("#MINONOFF1").prop("disabled", true);
			$("#RIGHTONOFF1").prop("disabled", true);
		}
	});
	$("#USEONOFF2").change(function(){
		if( $("#USEONOFF2").prop("checked") ){
			$("#HOURONOFF2").prop("disabled", false);
			$("#MINONOFF2").prop("disabled", false);
			$("#RIGHTONOFF2").prop("disabled", false);
		}else{
			$("#HOURONOFF2").prop("disabled", true);
			$("#MINONOFF2").prop("disabled", true);
			$("#RIGHTONOFF2").prop("disabled", true);
		}
	});
	$("#USEONOFF3").change(function(){
		if( $("#USEONOFF3").prop("checked") ){
			$("#HOURONOFF3").prop("disabled", false);
			$("#MINONOFF3").prop("disabled", false);
			$("#RIGHTONOFF3").prop("disabled", false);
		}else{
			$("#HOURONOFF3").prop("disabled", true);
			$("#MINONOFF3").prop("disabled", true);
			$("#RIGHTONOFF3").prop("disabled", true);
		}
	});
	$("#USEONOFF4").change(function(){
		if( $("#USEONOFF4").prop("checked") ){
			$("#HOURONOFF4").prop("disabled", false);
			$("#MINONOFF4").prop("disabled", false);
			$("#RIGHTONOFF4").prop("disabled", false);
		}else{
			$("#HOURONOFF4").prop("disabled", true);
			$("#MINONOFF4").prop("disabled", true);
			$("#RIGHTONOFF4").prop("disabled", true);
		}
	});
	//console.log($("#tree").jstree);
	
	function msgClick(e){
		
        if( $(e).hasClass("selected") ){
			$(e).removeClass("selected");
        }else{
			$(e).addClass("selected");
        }
		var IDX = $(e).data("id");
		// console.log(IDX);
		var param = "mode=sbd_msg&IDX="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sbd_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					var TYPE = data.list.TYPE;
					$("#C_IDX").val(data.list.IDX);
					$("#MSGACTION").val(data.list.MSGACTION);
					$("#MSGCOLOR").val(data.list.MSGCOLOR);
					$("#MSGSPD").val(data.list.MSGSPD);
					$("#MSGDELAY").val(data.list.MSGDELAY);
					$("input[name=TYPE]:input[value="+TYPE+"]").prop("checked", true);

					
					if(TYPE == "0"){
						$("#TITLE").val("");
						$("#MSG").val(data.list.MSG);
						$("#IMGMSG").val("");
						$("#IMGPATH").val("");
						//$("#IMG").jqteVal("");

						var tmp = $("#ROW_TEXT_TYPE option:contains('"+data.list.MODX+"')").val();

						$("#ROW_TEXT_TYPE").val(tmp);
						$("#DAN_TEXT_TYPE").val(data.list.MODY);
						$("#MSG").css('position','relative');

						var ROW_TYPE = $("#ROW_TEXT_TYPE").val();
						var LINE_TYPE = $("#DAN_TEXT_TYPE").val();

						msg_form_change(LINE_TYPE,ROW_TYPE);

					}else if(TYPE == "1"){
						form_change(data.list.TYPE); // 내용 구분에 따른 폼 변경
						$("#DAN_IMG_TYPE").val(data.list.MODY);
						var tmpModX = data.list.MODX - 1;
						$("#ROW_IMG_TYPE option:eq("+tmpModX+")").prop("selected", true);
						$("#TITLE").val(data.list.MSG);
						$("#MSG").val("");
						$("#IMGMSG").val(data.list.IMGMSG);
						$("#IMGPATH").val(data.list.IMGPATH);
						// $("#img_area").html(data.list.IMGMSG);
						$("#ROW_I_CHECK").val($("#ROW_IMG_TYPE option:checked").text());

						if(data.list.FONT != 0){
							// 에디터 font size 변경
							tinymce.activeEditor.execCommand('fontsize', false, data.list.FONT + "px");
							$("#font_size").val(data.list.font);	
						}
						$(tinymce.get('IMG').getBody()).html(data.list.IMGMSG);

						changedDan();
						render();
					}
					//$(".jqte_editor").focus(); // 최초 선택 시 포커스 안 잡히는 부분 처리
		        }else{
				    swal("체크", "메세지 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });

		// MSG_IDX 값 입력
		$("#MSG_IDX").val("");
		$.each($("#list_table tr"), function(i, v){
			if( $(v).hasClass("selected") ){
				var MSG_IDX = $("#MSG_IDX").val();
				var IDX = $(this).data("id");
				
				if(MSG_IDX == ""){
					$("#MSG_IDX").val(IDX);
				}else{
					$("#MSG_IDX").val(MSG_IDX + "-" + IDX);
				}
			}
		});

		// 메세지 저장 체크박스
		if($("#MSG_IDX").val()){
			$("#msg_save").parent().hide();
		}else{
			$("#msg_save").parent().show();
		}
	}

	//########################################################################################## 그룹선택 시작
	var a = 0;
	// 트리메뉴 체크 상태 변경 시
	$("#tree").on("changed.jstree", function(e, data){
		var tree_disabled = []; //선택되지 않은 트리배열
		//console.log(e,data);
		var parent = data.node.parent; 

		if(data.selected.length == 0){
			$.each($("#tree").jstree('get_json'), function(i, v){
				changeStatus(v.id, 'enable');
			});
		}

		if(parent == "#"){ 
			parent = data.node.id;
			data.selected.shift();
			// console.log(data.selected);
		}
		$.each($("#tree").jstree('get_json'), function(i, v){ 
			$("#list_table").empty();
			
			if(data.selected.length != 0){
				if(parent != v.id){
					tree_disabled.push(v.id);
					var areaID = parent.replace("tree_","");
					var areaxy = areaID.split("_");
					
					var modX = areaxy[1];
					var modY = areaxy[0];
					var param = "mode=sbd_sign_mod_list&modY="+modY; //이중 필요데이터만 골라쓴다.
					$.ajax({
						type: "POST",
						url: "../_info/json/_sbd_json.php",
						data: param,
						cache: false,
						dataType: "json",
						success : function(data){
							if(data){
								var tmp = "";
								$.each(data.list, function(i, v){
									tmp += '<tr id="list_'+v.IDX+'" data-id="'+v.IDX+'" data-type="'+v.type+'" class="ui-sortable-handle">';
									tmp += '<td id="NUM" class="bR_1gry">'+v.IDX+'</td>';
									tmp += '<td>'+v.msg+'</td>';
									tmp += '</tr>';
								});
								
								$("#list_table").html(tmp);
								$("#list_table tr").click(function(){
									msgClick(this);
								});
							}else{
								swal("실패", "메세지 목록 조회 실페", "warning"); return false;	
							}
						}
					});
				}
			}
		});

		if(tree_disabled){
			$.each(tree_disabled, function(i, v){
				changeStatus(v, 'disable');
			});
		}

		//########################################################################################## 그룹선택 종료

		$("#STR_IDX").val("");
		$("#SITEID").val("");

		// console.log(data.selected.length);
	    for(i = 0; i < data.selected.length; i ++){
	    	var obj = data.instance.get_node(data.selected[i]);
	    	var type = obj.li_attr.type;
	    	var group_id = obj.li_attr.group_id;
	    	var rtu_id = obj.li_attr.rtu_id;
			
			// console.log(rtu_id);
			if(data.selected.length == 1){ //1개소만 선택됐을때 장비설정의 밝기 저장정보를 보여준다.
				$("#SITEID").val(rtu_id);
				$("#rtu_info").show();
				
				var param = "mode=sbd&SITEID="+rtu_id;
				$.ajax({
					type: "POST",
					url: "../_info/json/_sbd_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.list){
							$("#areaname").text(data.list.AREANAME + " - " +data.list.SITENAME)
							
							var TIMEONOFF1 = data.list.TIMEONOFF1 ? data.list.TIMEONOFF1 : "";
							var TIMEONOFF2 = data.list.TIMEONOFF2 ? data.list.TIMEONOFF2 : "";
							var TIMEONOFF3 = data.list.TIMEONOFF3 ? data.list.TIMEONOFF3 : "";
							var TIMEONOFF4 = data.list.TIMEONOFF4 ? data.list.TIMEONOFF4 : "";

							if(data.list.USEONOFF1 == "Y"){
								$("#USEONOFF1").prop("checked", true);
								$("#HOURONOFF1").prop("disabled", false);
								$("#MINONOFF1").prop("disabled", false);
								$("#RIGHTONOFF1").prop("disabled", false);
							}else{
								$("#USEONOFF1").prop("checked", false);
								$("#HOURONOFF1").prop("disabled", true);
								$("#MINONOFF1").prop("disabled", true);
								$("#RIGHTONOFF1").prop("disabled", true);
							}
							$("#HOURONOFF1").val(TIMEONOFF1.split(":")[0]);
							$("#MINONOFF1").val(TIMEONOFF1.split(":")[1]);
							$("#RIGHTONOFF1").val(data.list.RIGHTONOFF1);
							if(data.list.USEONOFF2 == "Y"){
								$("#USEONOFF2").prop("checked", true);
								$("#HOURONOFF2").prop("disabled", false);
								$("#MINONOFF2").prop("disabled", false);
								$("#RIGHTONOFF2").prop("disabled", false);
							}else{
								$("#USEONOFF2").prop("checked", false);
								$("#HOURONOFF2").prop("disabled", true);
								$("#MINONOFF2").prop("disabled", true);
								$("#RIGHTONOFF2").prop("disabled", true);
							}
							$("#USEONOFF2").val(data.list.USEONOFF2);
							$("#HOURONOFF2").val(TIMEONOFF2.split(":")[0]);
							$("#MINONOFF2").val(TIMEONOFF2.split(":")[1]);
							$("#RIGHTONOFF2").val(data.list.RIGHTONOFF2);
							if(data.list.USEONOFF3 == "Y"){
								$("#USEONOFF3").prop("checked", true);
								$("#HOURONOFF3").prop("disabled", false);
								$("#MINONOFF3").prop("disabled", false);
								$("#RIGHTONOFF3").prop("disabled", false);
							}else{
								$("#USEONOFF3").prop("checked", false);
								$("#HOURONOFF3").prop("disabled", true);
								$("#MINONOFF3").prop("disabled", true);
								$("#RIGHTONOFF3").prop("disabled", true);
							}
							$("#USEONOFF3").val(data.list.USEONOFF3);
							$("#HOURONOFF3").val(TIMEONOFF3.split(":")[0]);
							$("#MINONOFF3").val(TIMEONOFF3.split(":")[1]);
							$("#RIGHTONOFF3").val(data.list.RIGHTONOFF3);
							if(data.list.USEONOFF4 == "Y"){
								$("#USEONOFF4").prop("checked", true);
								$("#HOURONOFF4").prop("disabled", false);
								$("#MINONOFF4").prop("disabled", false);
								$("#RIGHTONOFF4").prop("disabled", false);
							}else{
								$("#USEONOFF4").prop("checked", false);
								$("#HOURONOFF4").prop("disabled", true);
								$("#MINONOFF4").prop("disabled", true);
								$("#RIGHTONOFF4").prop("disabled", true);
							}
							$("#USEONOFF4").val(data.list.USEONOFF4);
							$("#HOURONOFF4").val(TIMEONOFF4.split(":")[0]);
							$("#MINONOFF4").val(TIMEONOFF4.split(":")[1]);
							$("#RIGHTONOFF4").val(data.list.RIGHTONOFF4);
						}
					}
				}); 

			}else{
				$("#rtu_info").hide();
			}
	    	
	    	if(type == "rtu"){
		    	var STR_IDX = $("#STR_IDX").val();
		    	
		    	if(STR_IDX == ""){
		    		$("#STR_IDX").val(rtu_id);
		    	}else{
		    		$("#STR_IDX").val(STR_IDX + "-" + rtu_id);
		    	}
	    	}
		}

		if(data.selected.length == 0){ //선택해제시 장비정보는 감춘다
			$("#rtu_info").hide();
		}

		var tmp_arr_check = [];
	    var tmp_arr_split = $("#STR_IDX").val().split("-");
	    $.each(tmp_arr_split, function(i, v){
	    	if(jQuery.inArray(v, tmp_arr_check) == "-1" && v != ""){
	 		   tmp_arr_check.push(v);
	    	}
	    });

	    $("#STR_IDX").val( tmp_arr_check.join("-") );
	    $("#rtu_cnt_text").text( tmp_arr_check.length );
		a++;
	}).jstree();



	function changeStatus(node_id, changeTo) {
		var node = $("#tree").jstree().get_node(node_id);
		if (changeTo === 'enable') {
			$("#tree").jstree().enable_node(node);
			node.children.forEach(function(child_id) {
				changeStatus(child_id, changeTo);
			})
		} else {
			$("#tree").jstree().disable_node(node);
			node.children.forEach(function(child_id) {
				changeStatus(child_id, changeTo);
			})
		}
	}
	
	// 단열 중복선택 불가 이벤트
	//########################################################
	$("#tree ul li a").click(function(e){
		var $target = $(e.target);
		
		var tmp = "";
		if($target.attr('class') == 'jstree-icon jstree-checkbox'){
			tmp = $target.parent().attr('class');
			if(tmp == "jstree-anchor jstree-disabled jstree-hovered"){
				alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
			}
		}
		if($target.attr('class') == "jstree-anchor jstree-disabled jstree-hovered"){
			alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
		}
	});
	//########################################################
	
	// 단열 중복선택 (자식 노드) 선택 불가 이벤트
	//########################################################
	$(".jstree-children").click(function(e){
		var $target = $(e.target);
		var tmp = "";
		if($target.attr('class') == 'jstree-icon jstree-checkbox'){
			tmp = $target.parent().attr('class');
			if(tmp == "jstree-anchor  jstree-disabled jstree-hovered"){
				alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
			}
		}
		if($target.attr('class') == "jstree-anchor  jstree-disabled jstree-hovered"){
			alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
		}

		if($target.attr('class') == "jstree-anchor jstree-disabled"){
			alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
		}

		if($target.attr('class') == "jstree-anchor jstree-disabled jstree-hovered"){
			alert("중복 선택이 불가합니다. 선택된 단을 해제해주세요.");
		}
	});
	//########################################################


	$("#btnSave").click(function(){ //저장 버튼 선택시
		var SITEID = $("#SITEID").val();
		if($("input:checkbox[name=USEONOFF1]:checked").length == 1) $("#USEONOFF1").val("Y");
		if($("input:checkbox[name=USEONOFF2]:checked").length == 1) $("#USEONOFF2").val("Y");
		if($("input:checkbox[name=USEONOFF3]:checked").length == 1) $("#USEONOFF3").val("Y");
		if($("input:checkbox[name=USEONOFF4]:checked").length == 1) $("#USEONOFF4").val("Y");
		
		if(SITEID){
			var param = "mode=sbd_light_up&SITEID="+SITEID+'&'+$("#sbd_frm").serialize(); //이중 필요데이터만 골라쓴다.
			$.ajax({
				type: "POST",
				url: "../_info/json/_sbd_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					if(data.result){
						location.href = "sbd_send.php";
					}else{
						//alert("옵션 저장 중 오류가 발생 했습니다.");
						swal("체크", "옵션 저장 중 오류가 발생했습니다.", "warning"); return false;	
					}
				}
			});
		}
		//console.log(SITEID);
	});

	$("#btn_re").click(function(){
		$("#list_table tbody tr").removeClass("selected"); 
		$("#MSGACTION option:eq(0)").prop("selected", true);
		$("#MSGCOLOR option:eq(0)").prop("selected", true);
		$("#MSGSPD").val(5);
		$("#MSGDELAY").val(5);
		$("input[name=TYPE]:input[value=0]").prop("checked", true);
		$("#TITLE").val("");
		$("#MSG").val("");
		$("#IMGMSG").val("");
		$("#IMGPATH").val("");
		//$("#IMG").jqteVal("");
		$("#img_area").empty();
		form_change(0); // 내용 구분에 따른 폼 변경
	});

	// 원본보기 클릭시
	$(".sbd_overX").click(function(){
		$("#pop_1").show();
		$("#img_area2").attr("src", $("#img_area").attr('src'));
		popup_open(); // 레이어 팝업 열기
	});

	// 전광판 전체선택
	$("#btn_all").click(function(){
		var now_sel = $("#tree").jstree("get_selected");
		var max_cnt = 0;
		$.each($("#tree").jstree('get_json'), function(i, v){
			max_cnt += Number(v['children'].length + 1);
		});
		
		if(now_sel.length == max_cnt){
			$("#tree").jstree("deselect_all");
		}else{
			$("#tree").jstree("select_all");
		}
	}); 

	// 메세지 구분 셀렉트
	$("#SECTION_NO_SEARCH").change(function(){
		$.each($("#list_table tr"), function(i, v){
			if( $("#SECTION_NO_SEARCH").val() == "" ){
				$(this).closest("tr").show();
			}else if( $("#SECTION_NO_SEARCH").val() != $(v).data("type") ){
				$(this).closest("tr").hide();
			}else if( $("#SECTION_NO_SEARCH").val() == $(v).data("type") ){
				$(this).closest("tr").show();
			}
		});
	});
	
	// 메세지 선택
	$("#list_table tr").click(function(){
		msgClick(this);
	});
	

	
	// 내용 구분 변경
	$("input[name=TYPE]").change(function(){
		//console.log(this.value);
		form_change(this.value); // 내용 구분에 따른 폼 변경
	});

	$("input[name=ROW]").change(function(){ //
		row_level(this.value);
	});

	$("#emer").change(function(){
		var emer = $("input:checkbox[id='emer']:checked").length;
		if(emer == 0){ //체크해제
			$('#emer_tr').hide();
			$('#DIVISION').val('0');
			$("input:radio[name='TYPE']").attr('disabled', false); // 강제 disable
		}else if(emer == 1){ //체크시
			$('#emer_tr').show();
			$('#DIVISION').val('1');
			//강제로 텍스트만 사용하도록 변경해야함.
			//$("input:radio[name='TYPE']:radio[value='0']").attr('checked', true); // 선택하기
			$("input:radio[name='TYPE']:radio[value='0']").prop('checked', true);
			$("input:radio[name='TYPE']").attr('disabled', true); // 강제 disable
			$("#TYPE_H").val("0"); //긴급방송 체크시, type이 disabled 가 되므로 hidden 값으로 전달한다.
			form_change(0); //폼 강제 변경
		}
	});

	function setImgChange(type2){
		//초기화
		$("#img_area").css('min-height','16px');
		$("#img_area").css('line-height','16px');
		if(type2 == "1"){ //1단 한줄
			$("#img_area").css('min-height','16px');
			$("#img_area").css('line-height','16px');
			if($(".jqte_editor > span").length > 0){ //이 존재하면 없앤다.
				$(".jqte_editor").empty('');
			}
			//$("#img_area").css('font-size','12px');
		}else if(type2 == "2"){ // 2단 한줄
			$("#img_area").css('min-height','32px');
			$("#img_area").css('line-height','32px');
			if($(".jqte_editor > span").length == 0){ //span이 없을때만
				$(".jqte_editor").append('<span style="font-size:24px;text-shadow: none;">&nbsp;</span>');
			}
			//$("#img_area").css('font-size','24px');
		}
		//console.log(type2);
	}

	// 메세지 드래그 앤 드롭
	$("#list_table").sortable({
		cursor: "move",
        update: function(event, ui){
            $(this).children().each(function(index){
    			$("#"+this.id+" #NUM").html(index + 1)
        	});
        	
			if( $("#SECTION_NO_SEARCH").val() != "" ){
				swal("체크", "메세지 구분이 전체일 때만 순서를 변경할 수 있습니다.", "warning");
			    $(this).sortable("cancel");
			}else{
	            var str_sort = "";
				$.each($("#list_table tr"), function(i, v){
					var IDX = $(this).data("id");
					
					if(str_sort == ""){
						str_sort = IDX;
					}else{
						str_sort = str_sort + "-" + IDX;
					}
				});
				//console.log(str_sort);
				
	    		var tmp_spin = null;
	    		var param = "mode=sbd_msg_sort&str_sort="+str_sort;
	    		$.ajax({
	    	        type: "POST",
	    	        url: "../_info/json/_sbd_json.php",
	    		    data: param,
	    	        cache: false,
	    	        dataType: "json",
	    	        success : function(data){
	    		        if(data.result){
	    		        }else{
	    				    swal("체크", "메세지 정렬중 오류가 발생 했습니다.", "warning");
	    		        }
	    	        },
	    	        beforeSend : function(data){ 
	    	   			tmp_spin = spin_start("#list_spin #spin", "80px");
	    	        },
	    	        complete : function(data){ 
	    	        	if(tmp_spin){
	    	        		spin_stop(tmp_spin, "#list_spin #spin");
	    	        	}
	    	        }
	    	    });	
			}
        }
	});
            
	// 전송
	$("#btn_send").click(function(){
		  
		//체크여부
		var msg_save = 0; 
		msg_save = $("input:checkbox[id='msg_save']:checked").length;
		var emer = 0;
		emer = $("input:checkbox[id='emer']:checked").length;

		var font_size = $('.tox-tbtn__select-label').text();
		$("#font_size").val(font_size.substr(0,2));	

		if($("#MSG_IDX").val()){ //기존처럼 메세지 선택시.
			if( form_check() ){
				swal({
					title: '<div class="alpop_top_b">메세지 전송 확인</div><div class="alpop_mes_b">선택된 메세지를 전송하시겠습니까?</div>',
					text: '확인 시 메세지가 전송 됩니다.',
					showCancelButton: true,
					confirmButtonColor: '#5b7fda',
					confirmButtonText: '확인',
					cancelButtonText: '취소',
					closeOnConfirm: false,
					html: true
				}, function(isConfirm){
					if(isConfirm){
						
						var param = "mode=sbd_msg_send&"+$("#sbd_frm").serialize();
						$.ajax({
							type: "POST",
							url: "../_info/json/_sbd_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
								if(data.result){
									popup_main_close(); // 레이어 좌측 및 상단 닫기
									location.href = "sbd_info.php";
								}else{
									swal("체크", "메세지 전송중 오류가 발생 했습니다.", "warning");
								}
							}
						});
					}
				}); // swal end
			}
		}else{ //메세지 입력됐을때.
			var type = $("input[name=TYPE]:checked").val();
			if(emer == 0){
				$("#DIVISION").val('0'); 
			}else if(emer > 0){
				$("#DIVISION").val('1'); 
			}
			//console.log(type);
			//return false;
			if(msg_save == 1 && emer == 0){ //메세지 저장 및 전송
				//메세지 저장하고,
				if(type == "0"){
					if( form_check("A") ){
						var ROW_TYPE = $("#ROW_T_CHECK").val();
						var FONT_SIZE = $("#font_size").val();
						var param = "mode=sbd_msg_in&FONT="+FONT_SIZE+"&ROW_TYPE="+ROW_TYPE+"&"+$("#sbd_frm").serialize();
						$.ajax({
							type: "POST",
							url: "../_info/json/_sbd_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
								if(data.result){
									popup_main_close(); // 레이어 좌측 및 상단 닫기
									setMeassgeSend('0',data.max_id); //메세지 전송
									//console.log(data.max_id);
									//location.reload(); return false;
								}else{
									swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
								}
							}
						});
					}
				}else if(type == "1"){
					if( form_check("A") ){
						// var target = $("#img_area")[0];
						var target = $("#outerbuffer")[0];
						//console.log($("#img_area")[0]);
						html2canvas(target).then(function(canvas){
							var img = canvas.toDataURL("image/png");    
							img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
							img = encodeURIComponent(img);
							//console.log(img);
							var param = "mode=sbd_msg_img&img="+img;
							$.ajax({
								type: "POST",
								url: "../_info/json/_sbd_json.php",
								data: param,
								cache: false,
								dataType: "json",
								success : function(data){
									if(data.result){
										$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
										var ROW_TYPE = $("#ROW_I_CHECK").val();
										var param = "mode=sbd_msg_in&FONT="+$("#font_size").val()+"&ROW_TYPE="+ROW_TYPE+"&"+$("#sbd_frm").serialize();
										$.ajax({
											type: "POST",
											url: "../_info/json/_sbd_json.php",
											data: param,
											cache: false,
											dataType: "json",
											success : function(data){
												if(data.result){
													popup_main_close(); // 레이어 좌측 및 상단 닫기
													setMeassgeSend('0',data.max_id); //메세지 전송
													//location.reload(); return false;
												}else{
													swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
												}
											}
										});
									}else{
										swal("체크", "이미지 업로드중 오류가 발생 했습니다.", "warning");
									}
								}
							});	         
						});
					}
				}
			}else if(emer == 1 && msg_save == 0){ // 긴급전송만.
				if( form_check('E') ){ //긴급전송 유효성 체크
					swal({
						title: '<div class="alpop_top_b">긴급 메세지 전송 확인</div><div class="alpop_mes_b">긴급 메세지를 전송하시겠습니까?</div>',
						text: '확인 시 긴급 메세지가 전송 됩니다.',
						showCancelButton: true,
						confirmButtonColor: '#5b7fda',
						confirmButtonText: '확인',
						cancelButtonText: '취소',
						closeOnConfirm: false,
						html: true
					}, function(isConfirm){
						if(isConfirm){
							var type = $("input[name=TYPE]:checked").val();
							if(type == "0"){
								var param = "mode=sbd_urg_send&"+$("#sbd_frm").serialize();
								$.ajax({
									type: "POST",
									url: "../_info/json/_sbd_json.php",
									data: param,
									cache: false,
									dataType: "json",
									success : function(data){
										if(data.result){
											popup_main_close(); // 레이어 좌측 및 상단 닫기
											location.href = "sbd_info.php";
										}else{
											swal("체크", "긴급 메세지 전송중 오류가 발생 했습니다.", "warning");
										}
									}
								});
							}else if(type == "1"){ 
								// var target = $("#img_area")[0];
								var target = $("#outerbuffer")[0];
								html2canvas(target).then(function(canvas){
									var img = canvas.toDataURL("image/png");    
									img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
									img = encodeURIComponent(img);

									var param = "mode=sbd_msg_img&img="+img;
									$.ajax({
										type: "POST",
										url: "../_info/json/_sbd_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
											if(data.result){
												$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
												
												var param = "mode=sbd_urg_send&"+$("#sbd_frm").serialize();
												$.ajax({
													type: "POST",
													url: "../_info/json/_sbd_json.php",
													data: param,
													cache: false,
													dataType: "json",
													success : function(data){
														if(data.result){
															popup_main_close(); // 레이어 좌측 및 상단 닫기
															location.href = "sbd_info.php";
														}else{
															swal("체크", "긴급 메세지 전송중 오류가 발생 했습니다.", "warning");
														}
													}
												});	
											}else{
												swal("체크", "이미지 업로드중 오류가 발생 했습니다.", "warning");
											}
										}
									});	       
								});
							}
						}
					}); // swal end
				}
			}else if(msg_save == 1 && emer == 1){ 
				//console.log(type);
				//return false;
				if( form_check('I') ){
					if(type == "0"){
						if( form_check("A") ){
							//var param = "mode=sbd_msg_in&"+$("#sbd_frm").serialize();
							var ROW_TYPE = $("#ROW_T_CHECK").val();
							
							var param = "mode=sbd_msg_in&FONT="+$("#font_size").val()+"&ROW_TYPE="+ROW_TYPE+"&"+$("#sbd_frm").serialize();
							$.ajax({
								type: "POST",
								url: "../_info/json/_sbd_json.php",
								data: param,
								cache: false,
								dataType: "json",
								success : function(data){
									if(data.result){
										popup_main_close(); // 레이어 좌측 및 상단 닫기
										setMeassgeSend('1',data.max_id); //메세지 전송
									}else{
										swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
									}
								}
							});
						}
					}else if(type == "1"){
						if( form_check("A") ){
							// var target = $("#img_area")[0];
							var target = $("#outerbuffer")[0];
							html2canvas(target).then(function(canvas){
								var img = canvas.toDataURL("image/png");    
								img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
								img = encodeURIComponent(img);
								//console.log(img);
								var param = "mode=sbd_msg_img&img="+img;
								$.ajax({
									type: "POST",
									url: "../_info/json/_sbd_json.php",
									data: param,
									cache: false,
									dataType: "json",
									success : function(data){
										if(data.result){
											$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
											
											//var param = "mode=sbd_msg_in&"+$("#sbd_frm").serialize();
											var ROW_TYPE = $("#ROW_I_CHECK").val();
											var param = "mode=sbd_msg_in&FONT="+$("#font_size").val()+"&ROW_TYPE="+ROW_TYPE+"&"+$("#sbd_frm").serialize();
											$.ajax({
												type: "POST",
												url: "../_info/json/_sbd_json.php",
												data: param,
												cache: false,
												dataType: "json",
												success : function(data){
													if(data.result){
														popup_main_close(); // 레이어 좌측 및 상단 닫기
														setMeassgeSend('1',data.max_id); //메세지 전송
														//location.reload(); return false;
													}else{
														swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
													}
												}
											});
										}else{
											swal("체크", "이미지 업로드중 오류가 발생 했습니다.", "warning");
										}
									}
								});	         
							});
						}
					}					
				}
			}else { //두개다 체크 안됐을때, 일회성 메세지 전송
				//sbd_msg_input
				if(form_check("E")){
					swal({
						title: '<div class="alpop_top_b">메세지 전송 확인</div><div class="alpop_mes_b">메세지를 전송하시겠습니까?</div>',
						text: '확인 시 메세지가 전송 됩니다.',
						showCancelButton: true,
						confirmButtonColor: '#5b7fda',
						confirmButtonText: '확인',
						cancelButtonText: '취소',
						closeOnConfirm: false,
						html: true
					}, function(isConfirm){
						if(isConfirm){
							var type = $("input[name=TYPE]:checked").val();

							if(type == "0"){
								var param = "mode=sbd_msg_input&"+$("#sbd_frm").serialize();
								$.ajax({
									type: "POST",
									url: "../_info/json/_sbd_json.php",
									data: param,
									cache: false,
									dataType: "json",
									success : function(data){
										if(data.result){
											popup_main_close(); // 레이어 좌측 및 상단 닫기
											location.href = "sbd_info.php";
										}else{
											swal("체크", "메세지 전송중 오류가 발생 했습니다.", "warning");
										}
									}
								});
							}else if(type == "1"){
								// var target = $("#img_area")[0];
								var target = $("#outerbuffer")[0];
								html2canvas(target).then(function(canvas){
									var img = canvas.toDataURL("image/png");    
									img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
									img = encodeURIComponent(img);

									var param = "mode=sbd_msg_img&img="+img;
									$.ajax({
										type: "POST",
										url: "../_info/json/_sbd_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
											if(data.result){
												$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
												
												var param = "mode=sbd_msg_input&"+$("#sbd_frm").serialize();
												$.ajax({
													type: "POST",
													url: "../_info/json/_sbd_json.php",
													data: param,
													cache: false,
													dataType: "json",
													success : function(data){
														if(data.result){
															popup_main_close(); // 레이어 좌측 및 상단 닫기
															location.href = "sbd_info.php";
														}else{
															swal("체크", "메세지 전송중 오류가 발생 했습니다.", "warning");
														}
													}
												});	
											}else{
												swal("체크", "이미지 업로드중 오류가 발생 했습니다.", "warning");
											}
										}
									});	       
								});
							}
						}
					}); // swal end
				}
			}
		}
	});

	//실제 전송폼
	function setMeassgeSend(TYPE,IDX){
		if(TYPE == '0'){
			swal({
				title: '<div class="alpop_top_b">메세지 전송 확인</div><div class="alpop_mes_b">메세지를 전송하시겠습니까?</div>',
				text: '확인 시 메세지가 전송 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){
					$("#MSG_IDX").val("");
					if(IDX){
						$("#MSG_IDX").val(IDX);
					}
					var param = "mode=sbd_msg_send&"+$("#sbd_frm").serialize();
					$.ajax({
						type: "POST",
						url: "../_info/json/_sbd_json.php",
						data: param,
						cache: false,
						dataType: "json",
						success : function(data){
							if(data.result){
								popup_main_close(); // 레이어 좌측 및 상단 닫기
								location.href = "sbd_info.php";
							}else{
								swal("체크", "메세지 전송중 오류가 발생 했습니다.", "warning");
							}
						}
					});
				}
			}); // swal end
		}else if(TYPE == '1'){
			if( form_check('E') ){ //긴급전송 유효성 체크
				swal({
					title: '<div class="alpop_top_b">긴급 메세지 전송 확인</div><div class="alpop_mes_b">긴급 메세지를 전송하시겠습니까?</div>',
					text: '확인 시 긴급 메세지가 전송 됩니다.',
					showCancelButton: true,
					confirmButtonColor: '#5b7fda',
					confirmButtonText: '확인',
					cancelButtonText: '취소',
					closeOnConfirm: false,
					html: true
				}, function(isConfirm){
					if(isConfirm){
						var type = $("input[name=TYPE]:checked").val();
						if(type == "0"){
							var param = "mode=sbd_urg_send&"+$("#sbd_frm").serialize();
							$.ajax({
								type: "POST",
								url: "../_info/json/_sbd_json.php",
								data: param,
								cache: false,
								dataType: "json",
								success : function(data){
									if(data.result){
										popup_main_close(); // 레이어 좌측 및 상단 닫기
										location.href = "sbd_info.php";
									}else{
										swal("체크", "긴급 메세지 전송중 오류가 발생 했습니다.", "warning");
									}
								}
							});
						}else if(type == "1"){ //긴급메세지 , 이미지 전송시 텍스트내용이 나옴 확인 필요 -- DB에는 맞게 들어감.
							// var target = $("#img_area")[0];
							var target = $("#outerbuffer")[0];
							html2canvas(target).then(function(canvas){
								var img = canvas.toDataURL("image/png");    
								img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
								img = encodeURIComponent(img);

								var param = "mode=sbd_msg_img&img="+img;
								$.ajax({
									type: "POST",
									url: "../_info/json/_sbd_json.php",
									data: param,
									cache: false,
									dataType: "json",
									success : function(data){
										if(data.result){
											$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
											
											var param = "mode=sbd_urg_send&"+$("#sbd_frm").serialize();
											$.ajax({
												type: "POST",
												url: "../_info/json/_sbd_json.php",
												data: param,
												cache: false,
												dataType: "json",
												success : function(data){
													if(data.result){
														popup_main_close(); // 레이어 좌측 및 상단 닫기
														location.href = "sbd_info.php";
													}else{
														swal("체크", "긴급 메세지 전송중 오류가 발생 했습니다.", "warning");
													}
												}
											});	
										}else{
											swal("체크", "이미지 업로드중 오류가 발생 했습니다.", "warning");
										}
									}
								});	       
							});
						}
					}
				}); // swal end
			}
		}//ELSE IF
	}

	// 메세지 등록편집
	$("#btn_edit").click(function(){
		location.href = "sbd_msg.php"; return false;
	});
	
	// 텍스트 단 구분 박스
	$("#DAN_TEXT_TYPE").change(function(e){
		$("#MSG").css('position','relative');
		var type = $("#DAN_TEXT_TYPE").val();
		if (type == ""){
			$("#MSG").css('height','39px');
		}
		if (type == "1"){
			$("#MSG").css('height','39px');
		}
		if (type == 2){
			$("#MSG").css('height','55px');
		}
		if (type == 3){
			$("#MSG").css('height','71px');
		}
		if (type == 4){
			$("#MSG").css('height','87px');
		}
		if (type == 5){
			$("#MSG").css('height','103px');
		}
		if (type == 6){
			$("#MSG").css('height','119px');
		}
		if (type == 7){
			$("#MSG").css('height','135px');
		}
		if (type == 8){
			$("#MSG").css('height','151px');
		}
	});

	// 내용 구분에 따른 폼 변경
	function form_change(type){
		if(type == "0"){ // 텍스트
			$("#msg_text").show();
			$("#text_type").show();
			$("#img_type").hide();
			$("#img_title").hide();
			$("#img_text").hide();
			$("#img_text2").hide();

		}else if(type == "1"){ // 이미지
			changedDan();
			render();

			$("#img_title").show();
			$("#img_type").show();
			$("#img_text").show();
			$("#img_text2").show();
			$("#text_type").hide();
			$("#msg_text").hide();
		}
	}
	
	// 줄 체크
	function msg_length(msg){
		var cnt = 0;
		for(var i = 0; i < msg.length; i ++){
		    if(msg.substring(i, i + 1) == "\n") {
		    	cnt ++;
		    }
		}
		return cnt;
	}
			
	// 폼 체크
	function form_check(val){
		if(val == "S"){
			if( !$("#STR_IDX").val() ){
				swal("체크", "전광판을 선택해 주세요.", "warning"); return false;	
			}else if( !bg_color_check("selected", "#list_table tr") ){ // 리스트 선택 체크
				swal("체크", "메세지를 선택해 주세요.", "warning"); return false;	
			}
		}else if(val == "I"){ //insert
			if( $("input[name=TYPE]:checked").val() == "0" ){
				if( !$("#MSG").val() ){
				    swal("체크", "내용을 입력해 주세요.", "warning");
				    $("#MSG").focus(); return false;	
				}else if( msg_length( $("#MSG").val() ) > 3 ){
				    swal("체크", "내용은 4줄까지 입력할 수 있습니다.", "warning"); 
				    $("#MSG").focus(); return false;	
				}
			}else if( $("input[name=TYPE]:checked").val() == "1" ){
				if( !$("#TITLE").val() ){
				    swal("체크", "제목을 입력해 주세요.", "warning");
				    $("#TITLE").focus(); return false;	
				}else if( !$("#IMGMSG").val() ){
				    swal("체크", "내용을 입력해 주세요.", "warning"); return false;	
				}
			}
		}else if(val == "A"){ //메세지저장 및 전송
			if( !$("#STR_IDX").val() ){
				swal("체크", "전광판을 선택해 주세요.", "warning"); return false;	
			}
		}else if(val == "E"){ //긴급 전송 체크
			if( !$("#STR_IDX").val() ){
				swal("체크", "전광판을 선택해 주세요.", "warning"); return false;	
			}else if( $("input[name=TYPE]:checked").val() == "0" ){
				if( !$("#MSG").val() ){
					swal("체크", "내용을 입력해 주세요.", "warning");
					$("#MSG").focus(); return false;	
				}else if( msg_length( $("#MSG").val() ) > 3 ){
					swal("체크", "내용은 4줄까지 입력할 수 있습니다.", "warning"); 
					$("#MSG").focus(); return false;	
				}
			}else if( $("input[name=TYPE]:checked").val() == "1" ){
				if( !$("#TITLE").val() ){
					swal("체크", "제목을 입력해 주세요.", "warning");
					$("#TITLE").focus(); return false;	
				}else if( !$("#IMGMSG").val() ){
					swal("체크", "내용을 입력해 주세요.", "warning"); return false;	
				}
			}
		}
		return true;
	}

	function msg_form_change(LINE_TYPE){
			if (LINE_TYPE == 1){
				$("#MSG").css('height','39px');
			}
			if (LINE_TYPE == 2){
				$("#MSG").css('height','55px');
			}
			if (LINE_TYPE == 3){
				$("#MSG").css('height','71px');
			}
			if (LINE_TYPE == 4){
				$("#MSG").css('height','87px');
			}
			if (LINE_TYPE == 5){
				$("#MSG").css('height','103px');
			}
			if (LINE_TYPE == 6){
				$("#MSG").css('height','119px');
			}
			if (LINE_TYPE == 7){
				$("#MSG").css('height','135px');
			}
			if (LINE_TYPE == 8){
				$("#MSG").css('height','151px');
			}
			if (LINE_TYPE == "1"){
				$("#MSG").css('height','39px');
			}
			if (LINE_TYPE == 2){
				$("#MSG").css('height','55px');
			}
			if (LINE_TYPE == 3){
				$("#MSG").css('height','71px');
			}
			if (LINE_TYPE == 4){
				$("#MSG").css('height','87px');
			}
			if (LINE_TYPE == 5){
				$("#MSG").css('height','103px');
			}
			if (LINE_TYPE == 6){
				$("#MSG").css('height','119px');
			}
			if (LINE_TYPE == 7){
				$("#MSG").css('height','135px');
			}
			if (LINE_TYPE == 8){
				$("#MSG").css('height','151px');
			}
	}

	// 뒤로가기 관련 처리
	$("#SECTION_NO_SEARCH").val("");
	$("#STR_IDX").val("");
	$("#MSG_IDX").val("");
	$("#MSGACTION option:eq(0)").prop("selected", true);
	$("#MSGCOLOR option:eq(0)").prop("selected", true);
	$("#MSGSPD").val(5);
	$("#MSGDELAY").val(5);
	$("input[name=TYPE]:input[value=0]").prop("checked", true);
	$("#TITLE").val("");
	$("#MSG").val("");
	$("#IMGMSG").val("");
	$("#IMGPATH").val("");
	$("#img_area").empty();
	form_change(0); // 내용 구분에 따른 폼 변경
});
</script>

</body>
</html>


