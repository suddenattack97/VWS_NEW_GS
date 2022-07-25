<?php 
require_once "../_conf/_common.php";
require_once "../_info/_sbd_msg.php";
require_once "./head.php";
?>
<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
		<form id="sbd_frm" action="sbd_msg.php" method="get">
		<input type="hidden" id="C_IDX" name="C_IDX"><!-- 선택한 메세지 IDX -->
		
		<div class="main_contitle">
			<img src="../images/title_08_08.png" alt="메세지 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>

		<ul class="ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					메세지 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">구분</option>
						<option value="1">효과</option>
						<option value="2">내용</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
				</span>  
			</li>
			<li class="li100_nor d_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">번호</th>
							<th class="li10 bL_1gry">구분</th>
							<th class="li30 bL_1gry">효과</th>
							<th class="li5 bL_1gry">속도</th>
							<th class="li5 bL_1gry">정지시간</th>
							<th class="li5 bL_1gry">색상</th>
							<th class="li40 bL_1gry">내용</th>
						</tr>
					</thead>
					<tbody>
				<?php
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?php echo $val['IDX']?>" data-id="<?php echo $val['IDX']?>">
							<td><?php echo $val['NUM']?></td>
							<td id="l_TYPE_NAME" class="bL_1gry"><?php echo $val['TYPE_NAME']?></td>
							<td id="l_ACTIONNAME" class="bL_1gry"><?php echo $val['ACTIONNAME']?></td>
							<td class="bL_1gry"><?php echo $val['MSGSPD']?></td>
							<td class="bL_1gry"><?php echo $val['MSGDELAY']?></td>
							<td class="bL_1gry"><?php echo $val['COLORNAME']?></td>
							<td id="l_MSG" class="bL_1gry"><?php echo stripslashes($val['MSG'])?></td>
						</tr>
				<?php
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="top6px">메세지 등록</span>
				<span class="sel_right_n">
					<!-- <button type="button" id="chrome32" class="btn_wgb130_a">크롬32bit 다운로드</button>
					<button type="button" id="chrome64" class="btn_wgb130_a">크롬64bit 다운로드</button> -->
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
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
		
		<input type="hidden" id="ROW_I_CHECK" value="30"/>
		<input type="hidden" id="ROW_T_CHECK" value="10"/>
		<input type="hidden" id="font_size" value="12"/>

		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){

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
				'body { background: black; color: Red; font-size: 12px; font-family: Gulim; overflow-y:hidden!important}' +
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

	$("#chrome32").hide(); 
	$("#chrome64").hide();

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
	
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 구분
			search_col_id = "l_TYPE_NAME";
		}else if(search_col == "1"){ // 효과
			search_col_id = "l_ACTIONNAME";
		}else if(search_col == "2"){ // 내용
			search_col_id = "l_MSG";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});


	$('#MSG').keydown(function(){
		var rows = $('#MSG').val().split('\n').length;
		var low = $('#MSG').val().length;
		var maxRows = $("#DAN_TEXT_TYPE").val();

		if(maxRows == ""){
			alert('단을 선택해주세요.');
            modifiedText = $('#MSG').val().split("\n").slice(0, maxRows);
            $('#MSG').val(modifiedText.join("\n"));
		}
		else if( rows > maxRows){
            alert('지정한 '+ maxRows + '단 까지 입력이 가능합니다.');
            modifiedText = $('#MSG').val().split("\n").slice(0, maxRows);
            $('#MSG').val(modifiedText.join("\n"));
        }
	});
	
	$('#MSG').click(function(){
		var maxRows = $("#DAN_TEXT_TYPE").val();
		
		if(maxRows == ""){
			alert('단을 선택해주세요.');
            $('#MSG').empty();
		}
    });


	//#########################################################################버튼 시작############################################################################

	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});

	// 목록 선택
	$("#list_table tbody tr").click(function(){
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		$("#DAN_IMG_TYPE").val(0); 	//처음 초기화 단 구분 메세지 안나오도록 예외처리

		var IDX = $(this).data("id");
		
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
					// $(".jqte_editor").focus(); // 최초 선택 시 포커스 안 잡히는 부분 처리
		        }else{
				    swal("체크", "메세지 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			//if (confirm("메세지를 등록하시겠습니까?") == true){    //확인
			swal({
				title: '<div class="alpop_top_b">메세지 등록 확인</div><div class="alpop_mes_b">메세지를 등록 하시겠습니까?</div>',
				text: '확인 시 메세지가 등록 됩니다.',
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
					var type = $("input[name=TYPE]:checked").val();
					if(type == "0"){
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
										location.reload(); return false;
									}else{
										swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
									}
								}
							});
						}else if(type == "1"){
							var agent = navigator.userAgent.toLowerCase();
							if( agent.indexOf('msie 7') > -1 && agent.indexOf('trident') > -1 ){  //호환성모드
								swal("호환성보기를 지원하지 않습니다. 호환성보기설정을 해제하거나.\n 크롬브라우저를 이용해주세요(IE 7)");
								$("#chrome32").show(); //다운로드 버튼 
								$("#chrome64").show();
							}
							else if(agent.indexOf('msie 8') > -1 && agent.indexOf('trident') > -1 ){
								swal("호환성보기를 지원하지 않습니다. 호환성보기설정을 해제하거나.\n 크롬브라우저를 이용해주세요(IE 8)");
								$("#chrome32").show(); //다운로드 버튼 
								$("#chrome64").show();
							}
							else if(agent.indexOf('msie 9') > -1 && agent.indexOf('trident') > -1 ){
								swal("호환성보기를 지원하지 않습니다. 호환성보기설정을 해제하거나.\n 크롬브라우저를 이용해주세요(IE 9)");
								$("#chrome32").show(); //다운로드 버튼 
								$("#chrome64").show();
							}
							else if( agent.indexOf('msie') > -1 || agent.indexOf('trident') > -1 ){  //호환성모드
							//향후 브라우저 체크시 사용
								$("#chrome32").show(); //다운로드 버튼 
								$("#chrome64").show();
								swal("호환성보기를 지원하지 않습니다. 호환성보기설정을 해제하거나.\n 크롬브라우저를 이용해주세요(IE 5)");
								//alert("호환성보기를 지원하지 않습니다. 호환성보기설정을 해제해주세요.\nIE 상단 도구 - 호환성보기설정 - 하단체크박스 모두 해제");
							}
							else { //해당되지 않을때 실행
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
												$("#IMGPATH").val("<?php echo HOST?>/divas/images/sbd/"+data.name);
												var row_type = $("#ROW_I_CHECK").val();
												//console.log(row_type);

												var font_size = $('.tox-tbtn__select-label').text();
												$("#font_size").val(font_size.substr(0,2));	
												var FONT_SIZE = $("#font_size").val();
												var param = "mode=sbd_msg_in&FONT="+FONT_SIZE+"&ROW_TYPE="+row_type+"&"+$("#sbd_frm").serialize();
												$.ajax({
													type: "POST",
													url: "../_info/json/_sbd_json.php",
													data: param,
													cache: false,
													dataType: "json",
													success : function(data){
														if(data.result){
															popup_main_close(); // 레이어 좌측 및 상단 닫기
															location.reload(); return false;
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
			}); // swal end

		}
	});

	//크롬 다운로드 추가
	$("#chrome32").click(function(){
		location.href = "../../ChromeStandaloneSetup.exe";
	});
	$("#chrome64").click(function(){
		location.href = "../../ChromeStandaloneSetup64.exe";
	});

	// 초기화
	$("#btn_re").click(function(){
		$("#list_table tbody tr").removeClass("selected"); 
		var IDX = $("#C_IDX").val();
		//if(IDX == ""){
			$("#C_IDX").val("");
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

			$("#font_12").css('display','block');
			$("#font_24").css('display','none');
			$("#font_34").css('display','none');
			$("#img_area").css('height','16px');
			$("#img_area").css('max-height','16px');
			$("#img_area").css('padding-top','0px');
			$(".jqte").css('height','55px');
			$(".jqte_editor").css('height','22px');
			$("input[name=DAN_TEXT_TYPE]:input[value=1]").prop("checked", true);
			$("input[name=DAN_IMG_TYPE]:input[value=1]").prop("checked", true);
			$("#DAN_IMG_TYPE").val("1");
	});

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			swal({
				title: '<div class="alpop_top_b">메세지 수정 확인</div><div class="alpop_mes_b">메세지를 수정하실 겁니까?</div>',
				text: '확인 시 메세지가 수정 됩니다.',
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
					// 송출 체크
					var param = "mode=sbd_msg_check&"+$("#sbd_frm").serialize();
					
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
					        	var type = $("input[name=TYPE]:checked").val();
					        	
						        if(type == "0"){
									var row_type = $("#ROW_T_CHECK").val();
									var FONT_SIZE = $("#font_size").val();
									var param = "mode=sbd_msg_up&FONT="+FONT_SIZE+"&ROW_TYPE="+row_type+"&"+$("#sbd_frm").serialize();
									//var param = "mode=sbd_msg_up&"+$("#sbd_frm").serialize();
									$.ajax({
								        type: "POST",
								        url: "../_info/json/_sbd_json.php",
									    data: param,
								        cache: false,
								        dataType: "json",
								        success : function(data){
									        if(data.result){
							                	popup_main_close(); // 레이어 좌측 및 상단 닫기
									    		location.reload(); return false;
									        }else{
											    swal("체크", "메세지 수정중 오류가 발생 했습니다.", "warning");
									        }
								        }
								    });	
						        }else if(type == "1"){
									var name_org = $("#IMGPATH").val().split("/");
									name_org = name_org[name_org.length - 1];
									name_org = name_org.replace(".bmp", "");
							        
						        	// var target = $("#img_area")[0];
									var target = $("#outerbuffer")[0];
									html2canvas(target).then(function(canvas){
										var img = canvas.toDataURL("image/png");    
										img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
							         	img = encodeURIComponent(img);

										var param = "mode=sbd_msg_img&img="+img+"&name_org="+name_org;
										$.ajax({
									        type: "POST",
									        url: "../_info/json/_sbd_json.php",
										    data: param,
									        cache: false,
									        dataType: "json",
									        success : function(data){
										        if(data.result){
										        	$("#IMGPATH").val("<?=HOST?>/divas/images/sbd/"+data.name);
										        	
													//var param = "mode=sbd_msg_up&"+$("#sbd_frm").serialize();
													var row_type = $("#ROW_I_CHECK").val();
													var font_size = $('.tox-tbtn__select-label').text();
													$("#font_size").val(font_size.substr(0,2));	
													var FONT_SIZE = $("#font_size").val();
													var param = "mode=sbd_msg_up&FONT="+FONT_SIZE+"&ROW_TYPE="+row_type+"&"+$("#sbd_frm").serialize();
													$.ajax({
												        type: "POST",
												        url: "../_info/json/_sbd_json.php",
													    data: param,
												        cache: false,
												        dataType: "json",
												        success : function(data){
													        if(data.result){
											                	popup_main_close(); // 레이어 좌측 및 상단 닫기
													    		location.reload(); return false;
													        }else{
															    swal("체크", "메세지 수정중 오류가 발생 했습니다.", "warning");
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
					        }else{
							    swal("체크", "현재 송출중인 메세지는 수정할 수 없습니다.", "warning");
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
			swal({
				title: '<div class="alpop_top_b">메세지 삭제 확인</div><div class="alpop_mes_b">메세지를 삭제하실 겁니까?</div>',
				text: '확인 시 바로 삭제 됩니다.',
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
					// 송출 체크
					var param = "mode=sbd_msg_check&"+$("#sbd_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
					        	var param = "mode=sbd_msg_de&"+$("#sbd_frm").serialize();
								$.ajax({
							        type: "POST",
							        url: "../_info/json/_sbd_json.php",
								    data: param,
							        cache: false,
							        dataType: "json",
							        success : function(data){
								        if(data.result){
						                	popup_main_close(); // 레이어 좌측 및 상단 닫기
								    		location.reload(); return false;
								        }else{
										    swal("체크", "메세지 삭제중 오류가 발생 했습니다.", "warning");
								        }
							        }
							    });

					        }else{
								swal("체크", "현재 송출중인 메세지는 삭제할 수 없습니다.", "warning");
						    }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	//#########################################################################버튼 끝############################################################################

	// 내용 구분 변경
	$("input[name=TYPE]").change(function(){
		form_change(this.value); // 내용 구분에 따른 폼 변경
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
			//단, 열 기본값 변경
			// $("#DAN_IMG_TYPE option:eq(2)").prop("selected", true);
			// $("#ROW_IMG_TYPE option:eq(49)").prop("selected", true);
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
	}

	function img_form_change(LINE_TYPE,ROW_TYPE,FONT){
		
		$("#img_area").css('padding-top','0px');
		if (LINE_TYPE == null){
			$("#img_area").css('height','16px');
			$("#img_area").css('max-height','16px');
		}
		if (LINE_TYPE == 1){

			$("#img_area").css('height','16px');
			$("#img_area").css('max-height','16px');
		}
		if (LINE_TYPE == 2){
			$("#img_area").css('height','32px');
			$("#img_area").css('max-height','32px');
		}
		if (LINE_TYPE == 3){

			$("#img_area").css('height','48px');
			$("#img_area").css('max-height','48px');
		}
		if (LINE_TYPE == 4){
			$("#img_area").css('height','64px');
			$("#img_area").css('max-height','64px');
		}
		if (LINE_TYPE == 5){
			$("#img_area").css('height','80px');
			$("#img_area").css('max-height','80px');
		}
		if (LINE_TYPE == 6){
			$("#img_area").css('height','96px');
			$("#img_area").css('max-height','96px');
		}
		if (LINE_TYPE == 7){
			$("#img_area").css('height','112px')
			$("#img_area").css('max-height','112px');
		}
		if (LINE_TYPE == 8){
			$("#img_area").css('height','128px');
			$("#img_area").css('max-height','128px');
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
	function form_check(kind){
		if(kind == "I"){
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
		}else if(kind == "U"){
			if( !$("#C_IDX").val() ){
			    swal("체크", "메세지를 선택해 주세요.", "warning"); return false;
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
		}else if(kind == "D"){
			if( !$("#C_IDX").val() ){
			    swal("체크", "메세지를 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#C_IDX").val("");
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


</script>

</body>
</html>


