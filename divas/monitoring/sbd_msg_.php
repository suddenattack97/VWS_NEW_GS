<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_msg.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<form id="sbd_frm" action="sbd_msg.php" method="get">
		<input type="hidden" id="C_IDX" name="C_IDX"><!-- 선택한 메세지 IDX -->
		
		<div class="main_contitle">
			<img src="../images/title_08_08.png" alt="메세지 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					메세지 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">ize="1">
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
							<th class="li5 bL_1gry">색깔</th>
							<th class="li40 bL_1gry">내용</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['IDX']?>" data-id="<?=$val['IDX']?>">
							<td><?=$val['NUM']?></td>
							<td id="l_TYPE_NAME" class="bL_1gry"><?=$val['TYPE_NAME']?></td>
							<td id="l_ACTIONNAME" class="bL_1gry"><?=$val['ACTIONNAME']?></td>
							<td class="bL_1gry"><?=$val['MSGSPD']?></td>
							<td class="bL_1gry"><?=$val['MSGDELAY']?></td>
							<td class="bL_1gry"><?=$val['COLORNAME']?></td>
							<td id="l_MSG" class="bL_1gry"><?=$val['MSG']?></td>
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
				<span class="top6px">메세지 등록</span>
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
						<td class="bg_lb w10 bold al_C bL0">효과</td>
						<td class="w40">
							<select id="MSGACTION" name="MSGACTION" size="1">
						<? 
						if($data_action){
							foreach($data_action as $key => $val){ 
						?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
						<? 
							}
						}
						?>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">색깔</td>
						<td class="w40">
							<select id="MSGCOLOR" name="MSGCOLOR" size="1">
						<? 
						if($data_color){
							foreach($data_color as $key => $val){ 
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
						<td class="bg_lb w10 bold al_C">정지시간</td>
						<td>
							<select id="MSGDELAY" name="MSGDELAY" size="1">
							<?	
							for($i = 1; $i <= 20; $i ++){
							?>
								<option value="<?=$i?>" <?if($i == 5){?> selected <?}?>><?=$i?></option>
							<? 
							}
							?>
							</select> 초
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">내용 구분</td>
						<td colspan="3">
							<input type="radio" name="TYPE" value="0" checked> 텍스트 
							<input type="radio" name="TYPE" value="1"> 이미지

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


							
							<div id="img_type" style="display:inline;">
								단 구분 : <select style="position:relative; "id="DAN_IMG_TYPE" name="DAN_IMG_TYPE" size="1">
								<option value="" selected hidden></option>
								<?php	
								for($i = 1; $i <= 8; $i ++){
								?>
									<option value="<?php echo $i?>"><?php echo $i?></option>
								<?php
								}
								?>
								</select>
							
								열 구분 : <select style="position:relative; "id="ROW_IMG_TYPE" name="ROW_IMG_TYPE" size="1">

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
						</td>
					</tr>
					<tr id="img_title" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">제목</td>
						<td colspan="3">
							<input type="text" id="TITLE" name="TITLE" class="f333_12" size="50">
						</td>
					</tr>
					<tr id="img_text" style="display: none;">
						<td rowspan="2" class="bg_lb w10 bold al_C bL0">내용</td>
						<td height="35">
							<textarea id="IMG" name="IMG" wrap="off" cols="20" rows="1"></textarea>
							<input type="hidden" id="IMGMSG" name="IMGMSG"><!-- 이미지 내용 -->
							<input type="hidden" id="IMGPATH" name="IMGPATH"><!-- 이미지 경로 -->
						</td>
						<td class="bg_lb w10 bold al_C">이미지</td>
						<td>
							<div id="outerbuffer" style="padding-right:15px; background-color: black; width: 220px; display: table-cell;vertical-align: middle;">
								<div id="img_area" class="img_area"></div>
							</div>
						</td>
					</tr>
					<tr id="msg_text" style="display: none;">
						<td rowspan="2" class="bg_lb w10 bold al_C bL0">내용</td>
						<td height="35" colspan="3">
							<textarea id="MSG" name="MSG" wrap="off" cols="20" rows="1" style="overflow-x: scroll;"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							※ 주의 : 메세지 등록 후 전송 시 화면에 보이는대로 전송 됩니다. 내용이 박스 안에 모두 보이도록 입력해 주세요.
						</td>
					</tr>
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

<script type="text/javascript">
$(document).ready(function(){
	// 조회
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
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});

	// 목록 선택
	$("#list_table tbody tr").click(function(){
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
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
						$("#IMG").val("");
					}else if(TYPE == "1"){
						$("#TITLE").val(data.list.MSG);
						$("#MSG").val("");
						$("#IMGMSG").val(data.list.IMGMSG);
						$("#IMGPATH").val(data.list.IMGPATH);
						$("#IMG").val(data.list.IMGMSG);
					}
					form_change(data.list.TYPE); // 내용 구분에 따른 폼 변경
					$(".jqte_editor").focus(); // 최초 선택 시 포커스 안 잡히는 부분 처리
		        }else{
				    swal("체크", "메세지 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">메세지 등록 확인</div><div class="alpop_mes_b">메세지를 등록하실 겁니까?</div>',
				text: '확인 시 메세지가 등록 됩니다.',
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
			        	var param = "mode=sbd_msg_in&"+$("#sbd_frm").serialize();
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
			        	var target = $("#img_area")[0];
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
										alert($("#IMGPATH").val());
							        	// var param = "mode=sbd_msg_in&"+$("#sbd_frm").serialize();
										// $.ajax({
									    //     type: "POST",
									    //     url: "../_info/json/_sbd_json.php",
										//     data: param,
									    //     cache: false,
									    //     dataType: "json",
									    //     success : function(data){
										//         if(data.result){
								        //         	popup_main_close(); // 레이어 좌측 및 상단 닫기
									    // 			location.reload(); return false;
										//         }else{
										// 			swal("체크", "메세지 등록중 오류가 발생 했습니다.", "warning");
										// 		}
									    //     }
									    // });
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
	});

	// 초기화
	$("#btn_re").click(function(){
		var IDX = $("#C_IDX").val();
		if(IDX == ""){
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
			$("#IMG").val("");
			$("#img_area").empty();
			form_change(0); // 내용 구분에 따른 폼 변경
		}else{
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
							$("#IMG").val("");
						}else if(TYPE == "1"){
							$("#TITLE").val(data.list.MSG);
							$("#MSG").val("");
							$("#IMGMSG").val(data.list.IMGMSG);
							$("#IMGPATH").val(data.list.IMGPATH);
							$("#IMG").val(data.list.IMGMSG);
						}
						form_change(data.list.TYPE); // 내용 구분에 따른 폼 변경
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
									var param = "mode=sbd_msg_up&"+$("#sbd_frm").serialize();
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
							        
						        	var target = $("#img_area")[0];
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
										        	
													var param = "mode=sbd_msg_up&"+$("#sbd_frm").serialize();
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

	// // 에디터 호출
	// $("#IMG").jqte({
	// 	b: true, // 굵게
	// 	br: false,
	// 	center: false, // 가운데 정렬
	// 	color: true, // 색깔
	// 	fsizes: ['10','12'],
	// 	format: false,
	// 	i: true, // 기울기
	// 	indent: false,
	// 	link: false,
	// 	left: false, // 좌측 정렬
	// 	ol: false,
	// 	outdent: false,
	// 	remove: false,
	// 	right: false, // 우측 정렬
	// 	rule: false,
	// 	source: false,
	// 	sub: false,
	// 	strike: false,
	// 	sup: false,
	// 	u: true, // 밑줄
	// 	ul: false,
	// 	unlink: false,
	// 	focus: function(){ 
	// 		var editor = $(".jqte_editor")[0].innerHTML;
	// 		$("#img_area").html(editor);
	// 		$("#IMGMSG").val(editor);
	// 		//$("#IMGPATH").val(editor);
	// 	}
	// });

	var initHeight = 40;
	var initWeight = 60;

	function render() {
			if (tinymce.get('IMG').getBody() != null) {
				$('#img_area').empty().append(tinymce.get('IMG').getBody().innerHTML);
				$('#IMGMSG').val(tinymce.get('IMG').getBody().innerHTML);
			}
			var line_row = $("#img_area").children('p').length;
			var font_size = $('.tox-tbtn__select-label').text();

		} 
	
	function changedDan() {

			var sender = document.getElementById("DAN_IMG_TYPE");
			var sender_row = document.getElementById("ROW_IMG_TYPE");

			//var result_height = document.getElementById("outerbuffer").style.height.replace('px','');
			var result_width = document.getElementById("outerbuffer").style.width.replace('px','');

			tinymce.get('IMG').editorContainer.style.width = (sender_row.selectedIndex * 18) + 'px';
			tinymce.get('IMG').editorContainer.style.height = (sender.selectedIndex * 16) + 'px';
			
			document.getElementById("outerbuffer").style.width = tinymce.get('IMG').editorContainer.style.width;
			document.getElementById("outerbuffer").style.height = tinymce.get('IMG').editorContainer.style.height;
			result_width = document.getElementById("outerbuffer").style.width.replace('px','');

			if(result_width <= 220){
				//initHeight = 40;
				initHeight = 79;
				//tinymce.get('IMG').editorContainer.style.height = '95px';
				tinymce.get('IMG').editorContainer.style.height = (sender.selectedIndex * 17 + initHeight) + 'px';
				document.getElementById("outerbuffer").style.height = (sender.selectedIndex * 16) + 'px';
				document.getElementById("outerbuffer").style.width = tinymce.get('IMG').editorContainer.style.width;
				
			}else{
				initHeight = 40;
				//console.log(initHeight);
				tinymce.get('IMG').editorContainer.style.height = (sender.selectedIndex * 17 + initHeight) + 'px';
				document.getElementById("outerbuffer").style.height = (sender.selectedIndex * 16) + 'px';
				document.getElementById("outerbuffer").style.width = tinymce.get('IMG').editorContainer.style.width;
			}
	}

	var timer = window.setTimeout(function() {
		render();
	}, 100);

	tinymce.init({
		selector: '#IMG',
		menubar: false,
		statusbar: false,
		toolbar: 'bold italic underline forecolor fontsizeselect',
		fontsize_formats: '12px 24px 36px 48px 60px 72px 84px 96px',
		content_style:
			'body { background: black; color: Red; font-size: 12px; font-family: Gulim; overflow-y:hidden!important}' +
			'p { padding: 0; margin: 0px 0; }',
		color_map: [
			'FF0000', 'Red',
			'00FF00', 'Green',
			'FFCC00', 'Yellow'
		],
		custom_colors: false,
		width: 250,
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
	
	// 내용 구분 변경
	$("input[name=TYPE]").change(function(){
		form_change(this.value); // 내용 구분에 따른 폼 변경
	});
	
	// 내용 구분에 따른 폼 변경
	function form_change(type){
		if(type == "0"){ // 텍스트
			$("#msg_text").show();
			$("#img_title").hide();
			$("#img_text").hide();
		}else if(type == "1"){ // 이미지
			$("#img_title").show();
			$("#img_text").show();
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
	$("#IMG").val("");
	$("#img_area").empty();
	form_change(0); // 내용 구분에 따른 폼 변경
});
</script>

</body>
</html>


