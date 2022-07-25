<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_urgs.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="sbd_frm" action="sbd_urgs.php" method="get">
		<input type="hidden" id="STR_IDX" name="STR_IDX"><!-- 전송할 전광판 아이디 -->
		
		<div class="main_contitle">
			<img src="../images/title_08_10.png" alt="긴급메세지 전송">
		</div>

		<ul class="tb_alarm h550p">
		
			<li class="tb_alarm_lm w49i">
				<div class="alarm">
					<ul>
						<li class="alarm_gry">전광판 선택 : <span id="rtu_cnt_text">0</span> 개소
							<button type="button" id="btn_all" class="btn_bs60">전체선택</button>
						</li>
						<li id="tree">					
							<ul>
							<?
							if($data_area){
								foreach($data_area as $key => $val){
							?>
								<li id="tree_<?=$val['AREAID']?>" type="group"><?=$val['AREANAME']."(".$val['CNT']."개소)"?>
									<ul>
						
							<? 
									if($data_sign){
										foreach($data_sign as $key2 => $val2){
											if($val['AREAID'] == $val2['AREAID']){
							?>
										<li id="tree_<?=$val['AREAID']?>_<?=$val2['SITEID']?>" type="rtu" group_id="<?=$val['AREAID']?>" rtu_id="<?=$val2['SITEID']?>">
											<?=$val2['SITENAME']?>
										</li>
							<?
											}else{
												continue; // AREAID 다를 경우 다음 배열 시작
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
			</li>
			<li class="mi"></li>
			
			<li class="tb_alarm_r bg_no w50i">
				<div class="alarm">
					<ul>
						<li class="tb_sms_gry">
							<button type="button" id="btn_send" class="btn_bs60">전송하기</button>
						</li>
						<li class="li100_nor p0">
							<table class="set_tb">
								<tr>
									<td class="bg_lb w15 bold al_C bL0">긴급 지속시간</td>
									<td colspan="3" class="w40">
										<input type="text" id="URGHOUR" name="URGHOUR" class="f333_12" value="1" size="1">
										시간 
										<input type="text" id="URGMIN" name="URGMIN" class="f333_12" value="0" size="1">
										분
									</td>
								</tr>
								<tr>
									<td class="bg_lb w15 bold al_C bL0">효과</td>
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
									<td class="bg_lb w15 bold al_C">색깔</td>
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
									<td class="bg_lb w15 bold al_C bL0">속도</td>
									<td class="w40">
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
									<td class="bg_lb w15 bold al_C">정지시간</td>
									<td class="w40">
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
						<td class="bg_lb w15 bold al_C bL0">내용 구분</td>
						<td colspan="3">
							<input type="radio" name="TYPE" value="0" checked> 텍스트 
							<input type="radio" name="TYPE" value="1"> 이미지
						</td>
					</tr>
					<tr id="img_title" style="display: none;">
						<td class="bg_lb w15 bold al_C bL0">제목</td>
						<td class="w40">
							<input type="text" id="TITLE" name="TITLE" class="f333_12" size="50">
						</td>
					</tr>
					<tr id="text_type">
					<td class="bg_lb w15 bold al_C bL0">선택(단,열)</td>
						<td class="w40">
							<!-- <input type="radio" name="TYPE2" value="1" checked> 1단 한줄
							<input type="radio" name="TYPE2" value="2"> 2단 한줄 -->
							단 구분 : <select style="position:relative; "id="DAN_TEXT_TYPE" name="DAN_TEXT_TYPE" size="1">
							<option value="1" selected>1</option>
							<?	
							for($i = 2; $i <= 8; $i ++){
							?>
								<option value="<?=$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>
							

							열 구분 : <select style="position:relative; "id="ROW_TEXT_TYPE" name="ROW_TEXT_TYPE" size="1">
							<option value="15" selected>1</option>
							<?	
							for($i = 2; $i <= 40; $i ++){
							?>
								<option value="<?=15*$i?>"><?=$i?></option>
							<?
							}
							?>
							</select>
							<!-- 높이 : <input id="TOP_VALUE" type="text" value="높이" size="1">
							<input type="button" id="up" value="UP">
							<input type="button" id="down" value="DOWN"> -->
						</td>
					</tr>
					<tr id="img_type">
					<td class="bg_lb w15 bold al_C bL0">선택(단,열)</td>
						<td class="w40" colspan="3">
							<!-- <input type="radio" name="TYPE2" value="1" checked> 1단 한줄
							<input type="radio" name="TYPE2" value="2"> 2단 한줄 -->
							단 구분 : <select style="position:relative; "id="DAN_IMG_TYPE" name="DAN_IMG_TYPE" size="1">
							<option value="1" selected>1</option>
							<?	
							for($i = 2; $i <= 8; $i ++){
							?>
								<option value="<?=$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>
						
							열 구분 : <select style="position:relative; "id="ROW_IMG_TYPE" name="ROW_IMG_TYPE" size="1">
							<option value="0" selected>0</option>
							<option value="15" selected>1</option>
							<?	
							for($i = 2; $i <= 40; $i ++){
							?>
								<option value="<?=15*$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>
							
							<!-- 높이 : <input id="TOP_VALUE" type="text" value="높이" size="1">
							<input type="button" id="up" value="UP">
							<input type="button" id="down" value="DOWN"> -->
						</td>
					</tr>
					<tr class="img_text" style="display: none;">
						<td class="bg_lb w15 bold al_C bL0">내용</td>
						<td height="35" colspan="3">
							<textarea id="IMG" name="IMG" wrap="off" cols="20" rows="1"></textarea>
							<input type="hidden" id="IMGMSG" name="IMGMSG"><!-- 이미지 내용 -->
							<input type="hidden" id="IMGPATH" name="IMGPATH"><!-- 이미지 경로 -->
						</td>
					<tr>
					<tr id="msg_text" style="display: none;">
						<td rowspan="2" class="bg_lb w15 bold al_C bL0">내용</td>
						<td height="35" colspan="3">
						<!-- <p>단 구분 : <select style="position:relative; "id="LINE_TYPE" name="LINE_TYPE" size="1">
							<option value="" selected></option>
							<?	
							for($i = 1; $i <= 8; $i ++){
							?>
								<option value="<?=$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>
							</p> -->
							<textarea id="MSG" name="MSG" wrap="off" cols="20" rows="1" style="width: 150px; overflow-x: scroll;"></textarea>
						</td>
					</tr>
					<tr class="img_text" style="display: none;">
						<td class="bg_lb w10 bold al_C">이미지</td>
						<td colspan="3">
							<div id="img_area" class="img_area"></div>
						</td> 
					</tr>
					<tr>
						<td colspan="4">
							※ 주의 : 메세지 등록 후 전송 시 화면에 보이는대로 전송 됩니다. 내용이 박스 안에 모두 보이도록 입력해 주세요.
						</td>
					</tr>
							</table>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

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

	$('#ROW_TEXT_TYPE option[value="150"]').attr('selected','selected');
	$('#ROW_IMG_TYPE option[value="150"]').attr('selected','selected');

	$("#ROW_TEXT_TYPE").change(function(e){
		var row = e.target.value;
		var rowtext = e.target.options[e.target.selectedIndex].text;
		$("#MSG").css("width",row+"px");
		$("#ROW_T_CHECK").val(rowtext);
		console.log(rowtext);
	});

	$("#ROW_IMG_TYPE").change(function(e){
		var row = e.target.value;
		var rowtext = e.target.options[e.target.selectedIndex].text;
		$(".jqte").css("width",row+"px");
		$("#ROW_I_CHECK").val(rowtext);
		//$(".img_area").css("width",row+"px");
	});

	// 트리메뉴 체크 상태 변경 시
	$("#tree").on("changed.jstree", function(e, data){
		$("#STR_IDX").val("");

		var tree_disabled = []; //선택되지 않은 트리배열

		var parent = data.node.parent; 

		if(data.selected.length == 0){
			$.each($("#tree").jstree('get_json'), function(i, v){
				changeStatus(v.id, 'enable');
			});
		}

		if(parent == "#"){ 
			parent = data.node.id;

			$.each($("#tree").jstree('get_json'), function(i, v){ 
				if(data.selected.length != 0){
					if(parent != v.id){
						tree_disabled.push(v.id);
					}
				}
			});
		}

	    for(i = 0; i < data.selected.length; i ++){
	    	var obj = data.instance.get_node(data.selected[i]);
	    	var type = obj.li_attr.type;
	    	var group_id = obj.li_attr.group_id;
	    	var rtu_id = obj.li_attr.rtu_id;
	    	//console.log(type, group_id, rtu_id);
	    	
	    	if(type == "rtu"){
		    	var STR_IDX = $("#STR_IDX").val();
		    	
		    	if(STR_IDX == ""){
		    		$("#STR_IDX").val(rtu_id);
		    	}else{
		    		$("#STR_IDX").val(STR_IDX + "-" + rtu_id);
		    	}
			}
			
			if(tree_disabled){
				$.each(tree_disabled, function(i, v){
					changeStatus(v, 'disable');
				});
			}
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
	}).jstree();
	
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

	
	
	$('#MSG').keydown(function(){
		var rows = $('#MSG').val().split('\n').length;
		var low = $('#MSG').val().length;
		console.log(low);
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
	
	// 전송
	$("#btn_send").click(function(){
		if( form_check() ){
			swal({
				title: '<div class="alpop_top_b">긴급 메세지 전송 확인</div><div class="alpop_mes_b">긴급 메세지를 전송하실 겁니까?</div>',
				text: '확인 시 긴급 메세지가 전송 됩니다.',
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

					console.log("타입:" + type);

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
			        	var target = $("#img_area")[0];
						html2canvas(target).then(function(canvas){
							var img = canvas.toDataURL("image/png");    
							img = img.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
				         	img = encodeURIComponent(img);

							console.log("이미지 내용" + img);

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
	});

	// 에디터 호출
	$("#IMG").jqte({
		b: true, // 굵게
		br: false,
		center: false, // 가운데 정렬
		color: true, // 색깔
		//fsize: false,
		fsizes: ["14","24","34"],
		format: false,
		i: true, // 기울기
		indent: false,
		link: false,
		left: false, // 좌측 정렬
		ol: false,
		outdent: false,
		remove: false,
		right: false, // 우측 정렬
		rule: false,
		source: false,
		sub: false,
		strike: false,
		sup: false,
		u: true, // 밑줄
		ul: false,
		unlink: false,
		focus: function(){ 
			var editor = $(".jqte_editor")[0].innerHTML;
			$("#img_area").html(editor);
			$("#IMGMSG").val(editor);
			//$("#IMGPATH").val(editor);
		}
	});

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


	// 텍스트 단 구분 박스
	$("#DAN_IMG_TYPE").change(function(e){
		//$("#img_area").css('position','relative');
			var type = $("#DAN_IMG_TYPE").val();
			if (type == "1"){
				$(".jqte").css('height','55px');
				$(".jqte_editor").css('height','22px');
				$("#img_area").css('height','16px');
				$("#img_area").css('max-height','16px');
			}
			if (type == 2){
				$(".jqte").css('height','72px');
				$(".jqte_editor").css('height','38px');
				$("#img_area").css('height','32px');
				$("#img_area").css('max-height','32px');
			}
			if (type == 3){
				$(".jqte").css('height','89px');
				$(".jqte_editor").css('height','55px');
				$("#img_area").css('height','48px');
				$("#img_area").css('max-height','48px');
			}
			if (type == 4){
				$(".jqte").css('height','104px');
				$(".jqte_editor").css('height','70px');
				$("#img_area").css('height','64px');
				$("#img_area").css('max-height','64px');
			}
			if (type == 5){
				$(".jqte").css('height','120px');
				$(".jqte_editor").css('height','86px');
				$("#img_area").css('height','80px');
				$("#img_area").css('max-height','80px');
			}
			if (type == 6){
				$(".jqte").css('height','136px');
				$(".jqte_editor").css('height','102px');
				$("#img_area").css('height','96px');
				$("#img_area").css('max-height','96px');
			}
			if (type == 7){
				$(".jqte").css('height','152px');
				$(".jqte_editor").css('height','118px');
				$("#img_area").css('height','112px')
				$("#img_area").css('max-height','112px');
			}
			if (type == 8){
				$(".jqte").css('height','168px');
				$(".jqte_editor").css('height','134px');
				$("#img_area").css('height','128px');
				$("#img_area").css('max-height','128px');
			}
	});
	
	// 내용 구분에 따른 폼 변경
	function form_change(type){
		if(type == "0"){ // 텍스트
			$("#msg_text").show();
			$("#text_type").show();
			$("#img_type").hide();
			$("#img_title").hide();
			$(".img_text").hide();
		}else if(type == "1"){ // 이미지
			$("#img_title").show();
			$("#img_type").show();
			$(".img_text").show();
			$("#text_type").hide();
			$("#msg_text").hide();
		}
	}
	

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
	function form_check(){
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
		return true;
	}

	// 뒤로가기 관련 처리
	$("#STR_IDX").val("");
	$("#URGHOUR").val(1);
	$("#URGMIN").val(0);
	$("#MSGACTION option:eq(0)").prop("selected", true);
	$("#MSGCOLOR option:eq(0)").prop("selected", true);
	$("#MSGSPD").val(5);
	$("#MSGDELAY").val(5);
	$("input[name=TYPE]:input[value=0]").prop("checked", true);
	$("#TITLE").val("");
	$("#MSG").val("");
	$("#IMGMSG").val("");
	$("#IMGPATH").val("");
	$("#IMG").jqteVal("");
	$("#img_area").empty();
	form_change(0); // 내용 구분에 따른 폼 변경
});
</script>

</body>
</html>


