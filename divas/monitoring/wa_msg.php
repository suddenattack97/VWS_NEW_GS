<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_msg.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="wa_frm" action="wa_msg.php" method="get">
		<input type="hidden" id="C_IDX" name="C_IDX"><!-- 선택한 메세지 IDX -->
		
		<div class="main_contitle">
			<img src="../images/title_08_08.png" alt="메세지 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>

		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					메세지 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">ize="1">
						<option value="0">제목</option>
						<option value="1">상단문안</option>
						<option value="2">하단문안</option>
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
							<th class="li5 bL_1gry">종류</th>
							<th class="li10 bL_1gry">제목</th>
							<th class="li10 bL_1gry">효과</th>
							<th class="li5 bL_1gry">속도</th>
							<th class="li5 bL_1gry">시간</th>
							<th class="li5 bL_1gry">횟수</th>
							<th class="li5 bL_1gry">밝기</th>
							<th class="li25 bL_1gry">상단문안</th>
							<th class="li25 bL_1gry">하단문안</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['IDX']?>" data-id="<?=$val['IDX']?>">
							<td><?=$val['NUM']?></td>
							<td class="bL_1gry"><?=$val['PANELCOMMANDTEXT']?></td>
							<td id="l_TEXTNAME" class="bL_1gry"><?=$val['TEXTNAME']?></td>
							<td class="bL_1gry"><?=$val['PANELVIEWTYPETEXT']?></td>
							<td class="bL_1gry"><?=$val['PANELVIEWSPEED']?></td>
							<td class="bL_1gry"><?=$val['PANELVIEWTIME']?></td>
							<td class="bL_1gry"><?=$val['PANELVIEWREPEATCNT']?></td>
							<td class="bL_1gry"><?=$val['PANELLUMIN']?></td>
							<td id="l_TEXTA" class="bL_1gry"><?=$val['TEXTA']?></td>
							<td id="l_TEXTB" class="bL_1gry"><?=$val['TEXTB']?></td>
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
						<td class="bg_lb w10 bold al_C bL0">종류</td>
						<td class="w40">
							<select id="PANELCOMMAND" name="PANELCOMMAND" size="1">
								<option value="0">일반</option>
								<option value="1">긴급</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">제목</td>
						<td class="w40">
							<input id="TEXTNAME" name="TEXTNAME" type="text" class="f333_12" size="18">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">효과</td>
						<td>
							<select id="PANELVIEWTYPE" name="PANELVIEWTYPE">
								<option value="0">Normal</option>
								<option value="1">Shift-Left</option>
								<option value="2">Shift-Right</option>
								<option value="7">깜박이며 Shift-Left</option>
								<option value="8">깜박이며 Shift-Right</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">상단문안</td>
						<td>
							<input id="TEXTA" name="TEXTA" type="text" class="f333_12" size="18">
							<input id="TEXTA_C" name="TEXTA_C" type="hidden">
							<span id="TEXTA_B">0 / 16 byte</span>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">속도</td>
						<td>
							<select id="PANELVIEWSPEED" name="PANELVIEWSPEED" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
							</select> 1 : 가장빠르게, 9 : 가장느리게
						</td>
						<td class="bg_lb w10 bold al_C">하단문안</td>
						<td>
							<input id="TEXTB" name="TEXTB" type="text" class="f333_12" size="18">
							<input id="TEXTB_C" name="TEXTB_C" type="hidden">
							<span id="TEXTB_B">0 / 16 byte</span>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">시간</td>
						<td>
							<select id="PANELVIEWTIME" name="PANELVIEWTIME">
								<option value="10">1</option>
								<option value="20">2</option>
								<option value="30" selected>3</option>
								<option value="40">4</option>
								<option value="50">5</option>
								<option value="60">6</option>
								<option value="70">7</option>
								<option value="80">8</option>
								<option value="90">9</option>
							</select> 초
						</td>
						<td class="bg_lb w10 bold al_C">횟수</td>
						<td>
							<select id="PANELVIEWREPEATCNT" name="PANELVIEWREPEATCNT" disabled>
								<option value="99" selected>계속표출</option>
								<?	
								for($i = 1; $i <= 98; $i ++){
								?>
									<option value="<?=$i?>"><?=$i?></option>
								<? 
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">밝기</td>
						<td>
							<select id="PANELLUMIN" name="PANELLUMIN">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
							</select> 1 : 가장어둡게, 9 : 가장밝게
						</td>
						<td class="bg_lb w10 bold al_C">색상</td>
						<td>
							<select id="PANELCOLOR" name="PANELCOLOR">
								<option value="0">RED(상하단)</option>
								<option value="1">GREEN(상하단)</option>
								<option value="2">YELLOW(상하단)</option>
								<option value="3">RED(상단) / YELLOW(하단)</option>
								<option value="4">YELLOW(상단) / RED(하단)</option>
							</select>
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

<script type="text/javascript">
$(document).ready(function(){
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 제목
			search_col_id = "l_TEXTNAME";
		}else if(search_col == "1"){ // 상단문안
			search_col_id = "l_TEXTA";
		}else if(search_col == "2"){ // 하단문안
			search_col_id = "L_TEXTB";
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
		var param = "mode=wa_msg_view&IDX="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#C_IDX").val(data.list.IDX);
					$("#PANELCOMMAND").val(data.list.PANELCOMMAND);
					$("#TEXTNAME").val(data.list.TEXTNAME);
					$("#PANELVIEWTYPE").val(data.list.PANELVIEWTYPE);
					$("#TEXTA").val(data.list.TEXTA);
					$("#PANELVIEWSPEED").val(data.list.PANELVIEWSPEED);
					$("#TEXTB").val(data.list.TEXTB);
					$("#PANELVIEWTIME").val(data.list.PANELVIEWTIME);
					$("#PANELVIEWREPEATCNT").val(data.list.PANELVIEWREPEATCNT);
					$("#PANELLUMIN").val(data.list.PANELLUMIN);
					$("#PANELCOLOR").val(data.list.PANELCOLOR);
					TEXTA_byte();
					TEXTB_byte();
					PANELCOMMAND_check();
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
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
			        var param = "mode=wa_msg_in&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
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
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		var IDX = $("#C_IDX").val();
		if(IDX == ""){
			$("#C_IDX").val("");
			$("#PANELCOMMAND").val(0);
			$("#TEXTNAME").val("");
			$("#PANELVIEWTYPE").val(0);
			$("#TEXTA").val("");
			$("#PANELVIEWSPEED").val(5);
			$("#TEXTB").val("");
			$("#PANELVIEWTIME").val(30);
			$("#PANELVIEWREPEATCNT").val(99);
			$("#PANELLUMIN").val(5);
			$("#PANELCOLOR").val(0);
			TEXTA_byte();
			TEXTB_byte();
			PANELCOMMAND_check();
		}else{
			var param = "mode=wa_msg_view&IDX="+IDX;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_wa_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
						$("#C_IDX").val(data.list.IDX);
						$("#PANELCOMMAND").val(data.list.PANELCOMMAND);
						$("#TEXTNAME").val(data.list.TEXTNAME);
						$("#PANELVIEWTYPE").val(data.list.PANELVIEWTYPE);
						$("#TEXTA").val(data.list.TEXTA);
						$("#PANELVIEWSPEED").val(data.list.PANELVIEWSPEED);
						$("#TEXTB").val(data.list.TEXTB);
						$("#PANELVIEWTIME").val(data.list.PANELVIEWTIME);
						$("#PANELVIEWREPEATCNT").val(data.list.PANELVIEWREPEATCNT);
						$("#PANELLUMIN").val(data.list.PANELLUMIN);
						$("#PANELCOLOR").val(data.list.PANELCOLOR);
						TEXTA_byte();
						TEXTB_byte();
						PANELCOMMAND_check();
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
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					var param = "mode=wa_msg_up&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
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
		        	var param = "mode=wa_msg_de&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
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
				}
			}); // swal end
		}
	});

	// 종류 변경
	$("#PANELCOMMAND").change(function(){
		PANELCOMMAND_check();
	});
	
	// 문안 byte 체크
	$("#TEXTA").keyup(function(){
		TEXTA_byte();
	});
	$("#TEXTB").keyup(function(){
		TEXTB_byte();
	});

	// 종류 체크
	function PANELCOMMAND_check(){
		var PANELCOMMAND = $("#PANELCOMMAND").val();
		if(PANELCOMMAND == "0"){
			$("#PANELVIEWREPEATCNT").prop("disabled", true);
		}else if(PANELCOMMAND == "1"){
			$("#PANELVIEWREPEATCNT").prop("disabled", false);
		}
	}
	
	// 문안 byte 체크
	function TEXTA_byte(){
		var tmp_text = $("#TEXTA").val();
	    var tmp_byte = 0;
	    
	    for(var i = 0; i < tmp_text.length; i++){
	        var c = escape(tmp_text.charAt(i));
	        if(c.length == 1) tmp_byte ++;
	        else if(c.indexOf("%u") != -1) tmp_byte += 2;
	        else if(c.indexOf("%") != -1) tmp_byte += c.length/3;
	    }
		$("#TEXTA_C").val(tmp_byte);
	    $("#TEXTA_B").text(tmp_byte+" / 16 byte");
	}
	function TEXTB_byte(){
		var tmp_text = $("#TEXTB").val();
	    var tmp_byte = 0;
	    
	    for(var i = 0; i < tmp_text.length; i++){
	        var c = escape(tmp_text.charAt(i));
	        if(c.length == 1) tmp_byte ++;
	        else if(c.indexOf("%u") != -1) tmp_byte += 2;
	        else if(c.indexOf("%") != -1) tmp_byte += c.length/3;
	    }
		$("#TEXTB_C").val(tmp_byte);
	    $("#TEXTB_B").text(tmp_byte+" / 16 byte");
	}
			
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#TEXTNAME").val() ){
			    swal("체크", "제목을 입력해 주세요.", "warning");
			    $("#TEXTNAME").focus(); return false;	
			}else if( !$("#TEXTA").val() ){
			    swal("체크", "상단문안을 입력해 주세요.", "warning");
			    $("#TEXTA").focus(); return false;	
			}else if( $("#TEXTA_C").val() > 16 ){
			    swal("체크", "상단문안을 16byte 이하로 입력해 주세요.", "warning");
			    $("#TEXTA").focus(); return false;	
			}else if( !$("#TEXTB").val() ){
			    swal("체크", "하단문안을 입력해 주세요.", "warning");
			    $("#TEXTB").focus(); return false;	
			}else if( $("#TEXTB_C").val() > 16 ){
			    swal("체크", "하단문안을 16byte 이하로 입력해 주세요.", "warning");
			    $("#TEXTB").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#C_IDX").val() ){
			    swal("체크", "메세지를 선택해 주세요.", "warning"); return false;
			}else if( !$("#TEXTNAME").val() ){
			    swal("체크", "제목을 입력해 주세요.", "warning");
			    $("#TEXTNAME").focus(); return false;	
			}else if( !$("#TEXTA").val() ){
			    swal("체크", "상단문안을 입력해 주세요.", "warning");
			    $("#TEXTA").focus(); return false;	
			}else if( $("#TEXTA_C").val() > 16 ){
			    swal("체크", "상단문안을 16byte 이하로 입력해 주세요.", "warning");
			    $("#TEXTA_C").focus(); return false;	
			}else if( !$("#TEXTB").val() ){
			    swal("체크", "하단문안을 입력해 주세요.", "warning");
			    $("#TEXTB").focus(); return false;	
			}else if( $("#TEXTB_C").val() > 16 ){
			    swal("체크", "하단문안을 16byte 이하로 입력해 주세요.", "warning");
			    $("#TEXTB_C").focus(); return false;	
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
	$("#PANELCOMMAND").val(0);
	$("#TEXTNAME").val("");
	$("#PANELVIEWTYPE").val(0);
	$("#TEXTA").val("");
	$("#PANELVIEWSPEED").val(5);
	$("#TEXTB").val("");
	$("#PANELVIEWTIME").val(30);
	$("#PANELVIEWREPEATCNT").val(99);
	$("#PANELLUMIN").val(5);
	$("#PANELCOLOR").val(0);
	TEXTA_byte();
	TEXTB_byte();
	PANELCOMMAND_check();
});
</script>

</body>
</html>


