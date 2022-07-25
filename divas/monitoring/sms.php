<?
require_once "../_conf/_common.php";
require_once "../_info/_sms.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_03_01.png" alt="SMS 전송">
		</div>
		<div class="right_bg">
		<ul class="tb_sms">
		<form id="sms_frm" name="sms_frm" method="get">
		<input type="hidden" id="SMS_RECEIVER" name="SMS_RECEIVER">
			<!-- 서울 02 경기 031 인천 032 강원 033 충남 041 대전 042 충북 043 부산 051 울산 052 대구 053 경북 054 경남 055 전남 061 광주 062 전북 063 제주 064 -->
			<li class="tb_sms_gry">
				<span class="sel_left">회신번호 : 
					<!-- <select id="NUM_FROM_1" name="NUM_FROM_1" class="f333_12 bg_lgr_d" readonly>
						<option value="02">02</option>
						<option value="031">031</option>
						<option value="032">032</option>
						<option value="033">033</option>
						<option value="041">041</option>
						<option value="042">042</option>
						<option value="043">043</option>
						<option value="051">051</option>
						<option value="052">052</option>
						<option value="053">053</option>
						<option value="054">054</option>
						<option value="055">055</option>
						<option value="061">061</option>
						<option value="062">062</option>
						<option value="063">063</option>
						<option value="064">064</option>
						<option value="010">010</option>
						<option value="011">011</option>
						<option value="016">016</option>
						<option value="017">017</option>
						<option value="018">018</option>
						<option value="019">019</option>
					</select> -->
					<?php 
						$call_num = sms_call;
						if(substr($call_num, 0, 2) == "02"){
							$num_1 = "02";
							$call_num = substr_replace($call_num, "", 0, 2);
							$num_2 = substr($call_num, 0, -4);
							$num_3 = substr_replace($call_num, "", 0, -4);
						}else{
							$num_1 = substr($call_num, 0, 3);
							$call_num = substr_replace($call_num, "", 0, 3);
							$num_2 = substr($call_num, 0, -4);
							$num_3 = substr_replace($call_num, "", 0, -4);
						}
					?>
					<input id="NUM_FROM_1" name="NUM_FROM_1" type="text" class="f333_12 date2322 bg_lgr_d" maxlength="4" value="<?=$num_1?>" readonly>
					-
					<input id="NUM_FROM_2" name="NUM_FROM_2" type="text" class="f333_12 date2322 bg_lgr_d" maxlength="4" value="<?=$num_2?>" readonly>
					-
					<input id="NUM_FROM_3" name="NUM_FROM_3" type="text" class="f333_12 date23222 bg_lgr_d" maxlength="4" value="<?=$num_3?>" readonly> 
					<!-- <input type="checkbox" id="IS_NUM_FROM" name="IS_NUM_FROM" class="chkbox" value="1" checked>사용안함  -->
					&nbsp;&nbsp;&nbsp;&nbsp;
					전송건수 : <input type="text" id="cnt" name="cnt" class="f333_12 date23222223" value="0" readonly> 건 전송
					<div class="mT10"></div>
					전송시각 : 
					<input type="radio" id="SMS_TYPE1" name="SMS_TYPE" class="btn_radio" value="0" checked>즉시전송 
					<input type="radio" id="SMS_TYPE2" name="SMS_TYPE" class="btn_radio" value="1">예약전송 
					<input type="text" name="DD" value="<?=date('Y-m-d')?>" id="DD" class="f333_12 bg_lgr_d" size="10" readonly>
					<select id="HH" name="HH" class="f333_12 bg_lgr_d" disabled>
						<?	
						for($i = 0; $i < 24; $i ++){
							$tmp_h = ($i< 10) ? '0'.$i : $i;
						?>
							<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
						<? 
						}
						?>
					</select> 시 
					<select id="MM" name="MM" class="f333_12 bg_lgr_d" disabled>
						<?	
						for($i = 0; $i < 60; $i ++){
							$tmp_m = ($i< 10) ? '0'.$i : $i;
						?>
							<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
						<? 
						}
						?>
					</select> 분
				</span> 
				<span class="sel_right">
					<button type="button" id="btn_send" class="btn_bsb180">SMS 전송</button>
				</span>
			</li>

			<div class="phone">
				<textarea id="SMS_MSG" name="SMS_MSG" class="textarea2" style="resize: none;">여기에 메세지를 입력해 주세요</textarea>
				<br> 
				<span id="byte" class="byte">29 / 80 byte</span> 
				<button type="button" id="sms_renew" class="sms_renew">&nbsp;</button>
			</div>
			<li class="li100">
				<div style="clear: both;"></div>
				<div class="sms_con">
					<ul>
						<li class="sms_con_gry bg_dark_blue">주소록</li>
						<li class="h13 bg_gry3">
							<select id="SMS_GROUP_ID" name="SMS_GROUP_ID" class="sel_sms">
								<option value="0">그룹전체</option>
							<? 
							if($data_group){
								foreach($data_group as $key => $val){ 
							?>
								<option value="<?=$val['SMS_GROUP_ID']?>"><?=$val['SMS_GROUP_NAME']?></option>
							<? 
								}
							}
							?>	
							</select> 
							<select id="SMS_EQUIPMENT" name="SMS_EQUIPMENT" class="sel_smsr">
								<option value="0">장비선택</option>
							<? 
							if($data_equip){
								foreach($data_equip as $key => $val){ 
							?>
								<option value="<?=$val['RTU_ID']?>" data-idx="<?=implode("/", $val['SMS_IDX'])?>"><?=$val['RTU_NAME']?></option>
							<? 
								}
							}
							?>	
							</select>
							<br> 
							<input id="SMS_SEND_GROUP1" name="SMS_SEND_GROUP1" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_1?> &nbsp; 
							<input id="SMS_SEND_GROUP2" name="SMS_SEND_GROUP2" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_2?> &nbsp; 
							<? if(level_cnt == 3){ ?>
							<input id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_3?> &nbsp;
							<? }else if(level_cnt == 4){ ?>
							<input id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_3?> &nbsp;
							<? }else if(level_cnt == 5){ ?>
							<input id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_3?> &nbsp;
							<input id="SMS_SEND_GROUP4" name="SMS_SEND_GROUP4" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_4?> &nbsp;
							<input id="SMS_SEND_GROUP5" name="SMS_SEND_GROUP5" type="checkbox" value="Y" class="SMS_SEND_GROUP chkbox"> <?=level_5?> &nbsp;
							<? } ?>
							<button type="button" id="btn_all" class="btn_bs60">전체선택</button> 
						</li>
						<li class="max500 bg_w pB45p">
							<table class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<td class="bR_1gry w50i">이름</td>
										<td class="w50i">번호</td>
									</tr>
								</thead>
								<tbody id="list_table">
								<? 
								if($data_user){
									foreach($data_user as $key => $val){ 
								?>
									<tr id="list_<?=$val['IDX']?>" class="hi25" data-idx="<?=$val['IDX']?>" 
									data-group="<?=$val['SMS_GROUP_ID']?>" data-sg1="<?=$val['GROUP1']?>" 
									data-sg2="<?=$val['GROUP2']?>" data-sg3="<?=$val['GROUP3']?>"  
									data-sg4="<?=$val['GROUP4']?>" data-sg5="<?=$val['GROUP5']?>">
										<td class="bR_1gry"><?=$val['USER_NAME']?></td>
										<td id="MOBILE"><?=$val['MOBILE']?></td>
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
				<div class="li10">
					<div class="sms_btn">
						<button type="button" id="btn_in" class="btn_smsgry">
							<img src="../images/sms_btn_add.png">
						</button>
						<button type="button" id="btn_de" class="btn_smsgry">
							<img src="../images/sms_btn_del.png">
						</button>
					</div>
				</div>
				<div class="sms_con">
					<ul>
						<li class="sms_con_gry bg_dark_blue">수신번호</li>
						<li class="bg_gry3" style="height:43px">
							<select id="NUM_TO_1" name="NUM_TO_1" class="f333_12">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
							-
							<input id="NUM_TO_2" name="NUM_TO_2" type="text" class="f333_12 date2322" d="" maxlength="4">
							-
							<input id="NUM_TO_3" name="NUM_TO_3" type="text" class="f333_12 date23222" id="" maxlength="4">
							<button type="button" id="btn_add" class="btn_bs60">번호추가</button> 
						</li>
						<li class="max500 bg_w pB45p">
							<table class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<td class="bR_1gry w50i">이름</td>
										<td class="w50i">번호</td>
									</tr>
								</thead>
								<tbody id="list_table2">
								</tbody>
							</table>
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

<script type="text/javascript">
$(document).ready(function(){
	// 회신번호 사용여부 선택
	$("#IS_NUM_FROM").change(function(){
		if( $("#IS_NUM_FROM").prop("checked") ){
			$("#NUM_FROM_1").addClass("bg_lgr_d");
			$("#NUM_FROM_2").addClass("bg_lgr_d");
			$("#NUM_FROM_3").addClass("bg_lgr_d");
			$("#NUM_FROM_1").prop("disabled", true);
			$("#NUM_FROM_2").prop("disabled", true);
			$("#NUM_FROM_3").prop("disabled", true);
		}else{
			$("#NUM_FROM_1").removeClass("bg_lgr_d");
			$("#NUM_FROM_2").removeClass("bg_lgr_d");
			$("#NUM_FROM_3").removeClass("bg_lgr_d");
			$("#NUM_FROM_1").prop("disabled", false);
			$("#NUM_FROM_2").prop("disabled", false);
			$("#NUM_FROM_3").prop("disabled", false);
		}
	});
	
	// 즉시전송 여부 선택
	$("input[name=SMS_TYPE]").change(function(){
		if( $("#SMS_TYPE1").prop("checked") ){
			$("#DD").addClass("bg_lgr_d");
			$("#HH").addClass("bg_lgr_d");
			$("#MM").addClass("bg_lgr_d");
			$("#DD").prop("disabled", true);
			$("#HH").prop("disabled", true);
			$("#MM").prop("disabled", true);
			$("#DD").datepicker("option", "disabled", true);
		}else{
			$("#DD").removeClass("bg_lgr_d");
			$("#HH").removeClass("bg_lgr_d");
			$("#MM").removeClass("bg_lgr_d");
			$("#DD").prop("disabled", false);
			$("#HH").prop("disabled", false);
			$("#MM").prop("disabled", false);
			$("#DD").datepicker("option", "disabled", false);
		}
	});
	
	// 달력 호출
	datepicker(1, "#DD", "../images/icon_cal.png", "yy-mm-dd");
	$("#DD").datepicker("option", "disabled", true);
	
	// 메세지 byte 체크
	$("#SMS_MSG").keyup(function(){
		var tmp_text = $("#SMS_MSG").val();
	    var tmp_byte = 0;
	    
	    for(var i = 0; i < tmp_text.length; i++){
	        var c = escape(tmp_text.charAt(i));
	        if(c.length == 1) tmp_byte ++;
	        else if(c.indexOf("%u") != -1) tmp_byte += 2;
	        else if(c.indexOf("%") != -1) tmp_byte += c.length/3;
	    }
	    $("#byte").text(tmp_byte+" / 80 byte");
	});

	// 새로쓰기
	$("#sms_renew").click(function(){
		$("#SMS_MSG").val("");
		$("#SMS_MSG").keyup();
	});

	// 그룹 선택
	$("#SMS_GROUP_ID").change(function(){
		$("#list_table tr").removeClass("selected");
		$("#SMS_EQUIPMENT option[value=0]").prop("selected", true);
		$(".SMS_SEND_GROUP").prop("checked", false);
		
		if( $("#SMS_GROUP_ID").val() == 0 ){
			$("#list_table tr").show();
		}else{
			$.each($("#list_table tr"), function(i, v){
				if( $("#SMS_GROUP_ID").val() == $(v).data("group") ){
					$(v).show();
				}else{
					$(v).hide();
				}
			});
		}
	});

	// 장비 선택
	$("#SMS_EQUIPMENT").change(function(){
		$("#list_table tr").removeClass("selected");
		$("#SMS_GROUP_ID option[value=0]").prop("selected", true);
		$(".SMS_SEND_GROUP").prop("checked", false);
		
		if( $("#SMS_EQUIPMENT").val() == 0 ){
			$("#list_table tr").show();
		}else{
			var tmp_arr = [];
			var tmp_idx = String( $("#SMS_EQUIPMENT option:selected").data("idx") );

			if( tmp_idx.indexOf("/") != -1 ){
				tmp_arr = tmp_idx.split("/");
			}else{
				tmp_arr[0] = tmp_idx;
			}
			$.each($("#list_table tr"), function(i, v){
				var tmp_data = String( $(v).data("idx") );
	
				if(jQuery.inArray(tmp_data, tmp_arr) != "-1"){
					$(v).show();
				}else{
					$(v).hide();
				}
			});
		}
	});

	// 경계 단계 선택
	$(".SMS_SEND_GROUP").change(function(){
		$("#list_table tr").removeClass("selected");
		$("#SMS_EQUIPMENT option[value=0]").prop("selected", true);
		$("#SMS_GROUP_ID option[value=0]").prop("selected", true);
		$("#list_table tr").hide();

		if( $(".SMS_SEND_GROUP:checked").length == 0 ){
			$("#list_table tr").show();
		}else{
			$.each($("#list_table tr"), function(i, v){
				if( $("#SMS_SEND_GROUP1").prop("checked") ){
					if( $(v).data("sg1") > 0 ) $(v).show();
				}
				if( $("#SMS_SEND_GROUP2").prop("checked") ){
					if( $(v).data("sg2") > 0 ) $(v).show();
				}
				if( $("#SMS_SEND_GROUP3").prop("checked") ){
					if( $(v).data("sg3") > 0 ) $(v).show();
				}
				if( $("#SMS_SEND_GROUP4").prop("checked") ){
					if( $(v).data("sg4") > 0 ) $(v).show();
				}
				if( $("#SMS_SEND_GROUP5").prop("checked") ){
					if( $(v).data("sg5") > 0 ) $(v).show();
				}
			});
		}
	});

	// 전체 선택
	$("#btn_all").click(function(){
		var all_cnt = $("#list_table tr").length;
		var sel_cnt = $("#list_table tr.selected").length;
		if(all_cnt == sel_cnt){
			$("#list_table tr").removeClass("selected");
		}else{
			$("#list_table tr").addClass("selected");
		}
	});

	// 주소록 선택
	$(document).on("click", "#list_table tr", function(){
		if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
			$(this).addClass("selected");
        }
	});

	// 수신번호 선택
	$(document).on("click", "#list_table2 tr", function(){
		if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
			$(this).addClass("selected");
        }
	});
	
	// 추가 버튼
	$("#btn_in").click(function(){
		$.each($("#list_table tr"), function(i, v){
			if( $(v).hasClass("selected") ){
				$("#list_table2").append(v);
				$(v).removeClass("selected");
				$(v).unbind("click");
			}
		});
		cnt_check(); // 전송건수 체크
	});

	// 삭제 버튼
	$("#btn_de").click(function(){
		$.each($("#list_table2 tr"), function(i, v){
			if( $(v).hasClass("selected") ){
				$("#list_table").append(v);
				$(v).removeClass("selected");
				$(v).unbind("click");
			}
		});
		cnt_check(); // 전송건수 체크
	});

	// 번호추가 버튼
	$("#btn_add").click(function(){
		var check = /^\d{2,3}-\d{3,4}-\d{4}$/;
		var tmp_val = $("#NUM_TO_1").val()+'-'+$("#NUM_TO_2").val()+'-'+$("#NUM_TO_3").val();
		var tmp_arr_address = [];
		var tmp_arr_receiver = [];
		
		$.each($("#list_table tr #MOBILE"), function(i, v){
			tmp_arr_address.push( $(v).text() );
		});
		$.each($("#list_table2 tr #MOBILE"), function(i, v){
			tmp_arr_receiver.push( $(v).text() );
		});
		
		if( !$("#NUM_TO_2").val() || !$("#NUM_TO_3").val() ){
			swal("체크", "수신번호를 입력해 주세요.", "warning"); return false;
		}else if( !check.test(tmp_val) ){
			swal("체크", "수신번호를 확인해 주세요.", "warning"); return false;
		}else if(jQuery.inArray(tmp_val, tmp_arr_address) != "-1"){
			swal("체크", "주소록에 존재하는 번호 입니다.", "warning"); return false;
		}else if(jQuery.inArray(tmp_val, tmp_arr_receiver) != "-1"){
			swal("체크", "수신번호에 존재하는 번호 입니다.", "warning"); return false;
		}else{
			var tmp_el = '';
			tmp_el += '<tr>';
			tmp_el += '<td class="bR_1gry">-</td>';
			tmp_el += '<td id="MOBILE">'+tmp_val+'</td>';
			tmp_el += '</tr>';
			$("#list_table2").append(tmp_el);
			cnt_check(); // 전송건수 체크
		}
	});

	// SMS 전송
	$("#btn_send").click(function(){
		
		if( sms_check() ){
			$("#SMS_RECEIVER").val("");
			$.each($("#list_table2 tr #MOBILE"), function(i, v){
				var SMS_RECEIVER = $("#SMS_RECEIVER").val();
				var MOBILE = $(v).text();
				
				if(SMS_RECEIVER == ""){
					$("#SMS_RECEIVER").val(MOBILE);
				}else{
					$("#SMS_RECEIVER").val(SMS_RECEIVER + "@" + MOBILE);
				}
			});
			//console.log( $("#SMS_RECEIVER").val() );
			
			swal({
				title: '<div class="alpop_top_b">문자전송 확인</div><div class="alpop_mes_b">문자를 보내실 겁니까?</div>',
				text: '확인 시 문자가 전송 됩니다.',
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
					var param = "mode=sms_insert&"+$("#sms_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.href = "sms_hist.php"; return false;
					        }else{
							    swal("체크", "문자 전송중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 전송건수 체크
	function cnt_check(){
		if( $("#list_table2 tr").length ){
			$("#cnt").val( $("#list_table2 tr").length );
		}else{
			$("#cnt").val(0);
		}
	}

	// 문자 폼 체크
	function sms_check(){
		var SMS_MSG = $("#SMS_MSG").val().replace(/[\r|\n]/g, " ");
		$("#SMS_MSG").val(SMS_MSG);
		
		var tmp_text = $("#SMS_MSG").val();
	    var tmp_byte = 0;
	    
	    for(var i = 0; i < tmp_text.length; i++){
	        var c = escape(tmp_text.charAt(i));
	        if(c.length == 1) tmp_byte ++;
	        else if(c.indexOf("%u") != -1) tmp_byte += 2;
	        else if(c.indexOf("%") != -1) tmp_byte += c.length/3;
	    }
		
		if( !$("#SMS_MSG").val() ){
			swal("체크", "메세지를 입력해 주세요.", "warning"); return false;
		}else if( tmp_byte > 80 ){
			swal("체크", "메세지는 80byte까지 보낼 수 있습니다.", "warning"); return false;
		}else if( $("#cnt").val() == "0" ){
			swal("체크", "수신 번호를 추가해 주세요.", "warning"); return false;
		/* }else if( !$("#IS_NUM_FROM").prop("checked") ){
			var check = /^\d{2,3}-\d{3,4}-\d{4}$/;
			var tmp_val = $("#NUM_FROM_1").val()+'-'+$("#NUM_FROM_2").val()+'-'+$("#NUM_FROM_3").val();
			
			if( !$("#NUM_FROM_2").val() || !$("#NUM_FROM_3").val() ){
			    swal("체크", "회신번호 사용 시 번호를 모두 입력해 주세요.", "warning"); return false;
			}else if( !check.test(tmp_val) ){
			    swal("체크", "회신번호 사용 시 번호를 제대로 입력해 주세요.", "warning"); return false;
			}else{
				 return true;
			} */
		}else{
			 return true;
		}
	}

	// 뒤로가기 관련 처리
	$("#SMS_RECEIVER").val("");
	/* $("#NUM_FROM_1").val("02");
	$("#NUM_FROM_2").val("");
	$("#NUM_FROM_3").val(""); */
	$("#IS_NUM_FROM").prop("checked", true);
	$("#cnt").val("");
	$("#DD").val("<?=date('Y-m-d')?>");
	$("#HH").val("00");
	$("#MM").val("00");
	$("#SMS_MSG").val("여기에 메세지를 입력해 주세요");
	$("#SMS_GROUP_ID").val(0);
	$("#SMS_EQUIPMENT").val(0);
	$(".SMS_SEND_GROUP").prop("checked", false);
	$("#NUM_TO_1").val("010");
	$("#NUM_TO_2").val("");
	$("#NUM_TO_3").val("");
});
</script>

</body>
</html>


