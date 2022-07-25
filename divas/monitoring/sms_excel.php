<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_03_02.png" alt="엑셀 전송">
		</div>

		<ul class="tb_sms">
		<form id="sms_frm" name="sms_frm" method="post" enctype="multipart/form-data">
			<input type="hidden" id="mode" name="mode">
			<li class="tb_sms_gry">
				<span class="w50 fL"> 
					파일선택 : 
					<input type="text" id="EXCEL_STR" name="EXCEL_STR" class="f333_12" size="20" readonly>
					<input type="file" id="EXCEL_SEL" name="EXCEL_SEL" style="display: none;">
				
					<button type="button" id="btn_file" class="btn_wbb130">파일 선택</button>
					<button type="button" id="btn_load" class="btn_lbs">내용불러오기</button>
					<button type="button" id="btn_sample" class="btn_lbs">샘플양식받기</button>  
					<div class="mB5"></div> 
					회신번호 : 
					<select id="NUM_FROM" name="NUM_FROM" class="f333_12">
							<option value="0">직접입력</option>
							<option value="1">A</option>
							<option value="2">B</option>
							<option value="3">C</option>
							<option value="4">D</option>
							<option value="5">E</option>
							<option value="6">F</option>
							<option value="7">G</option>
							<option value="8">H</option>
							<option value="9">I</option>
							<option value="10">J</option>
							<option value="11">K</option>
							<option value="12">L</option>
							<option value="13">M</option>
							<option value="14">N</option>
							<option value="15">O</option>
							<option value="16">P</option>
							<option value="17">Q</option>
							<option value="18">R</option>
							<option value="19">S</option>
							<option value="20">T</option>
							<option value="21">U</option>
							<option value="22">V</option>
							<option value="23">W</option>
							<option value="24">X</option>
							<option value="25">Y</option>
							<option value="26">Z</option>
					</select>
					<select id="NUM_FROM_1" name="NUM_FROM_1" class="f333_12">
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
					</select>
					-
					<input id="NUM_FROM_2" name="NUM_FROM_2" type="text" class="f333_12 date2322" maxlength="4">
					-
					<input id="NUM_FROM_3" name="NUM_FROM_3" type="text" class="f333_12 date23222" maxlength="4">
					<br> 
					수신번호 : 
					<select id="NUM_TO" name="NUM_TO" class="f333_12_bm">
							<option value="0">--------</option>
							<option value="1">A</option>
							<option value="2">B</option>
							<option value="3">C</option>
							<option value="4">D</option>
							<option value="5">E</option>
							<option value="6">F</option>
							<option value="7">G</option>
							<option value="8">H</option>
							<option value="9">I</option>
							<option value="10">J</option>
							<option value="11">K</option>
							<option value="12">L</option>
							<option value="13">M</option>
							<option value="14">N</option>
							<option value="15">O</option>
							<option value="16">P</option>
							<option value="17">Q</option>
							<option value="18">R</option>
							<option value="19">S</option>
							<option value="20">T</option>
							<option value="21">U</option>
							<option value="22">V</option>
							<option value="23">W</option>
							<option value="24">X</option>
							<option value="25">Y</option>
							<option value="26">Z</option>
					</select> 
					<br> 
					전송시각 : 
					<input type="radio" id="SMS_TYPE1" name="SMS_TYPE" class="btn_radio" value="0" checked>즉시 
					<input type="radio" id="SMS_TYPE2" name="SMS_TYPE" class="btn_radio" value="1">예약 
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

					<div class="mT5"></div>
					
					전송범위설정 : 
					<input type="text" id="startRow" name="startRow" class="f333_12 date23222223" maxlength="3" value="1"> 부터 
					<input type="text" id="endRow" name="endRow" class="f333_12 date23222223" maxlength="3" value="10"> 까지 
					<input type="text" id="cntRow" name="cntRow" class="f333_12 date23222223" value="10" readonly> 건 전송
				</span> 
				
				<span class="w50 fR al_R">
					<div class="sms_excel_btnwrap">
						<button type="button" id="btn_check" class="btn_wbb130">오류검사</button>
						<button type="button" id="btn_send" class="btn_bsb130">SMS 전송</button>
					</div>
					<div class="box_lb">
						<img src="../images/arrow.png"> 메세지입력
						<textarea id="SMS_STR" name="SMS_STR" class="textarea_e2" style="resize: none;"></textarea>
						<span class="ex_sp">엑셀 열변수 삽입</span> 
						<select id="SMS_STR_COLS" name="SMS_STR_COLS" class="f333_12_exf">
							<option value="">---</option>
							<option value="1">A</option>
							<option value="2">B</option>
							<option value="3">C</option>
							<option value="4">D</option>
							<option value="5">E</option>
							<option value="6">F</option>
							<option value="7">G</option>
							<option value="8">H</option>
							<option value="9">I</option>
							<option value="10">J</option>
							<option value="11">K</option>
							<option value="12">L</option>
							<option value="13">M</option>
							<option value="14">N</option>
							<option value="15">O</option>
							<option value="16">P</option>
							<option value="17">Q</option>
							<option value="18">R</option>
							<option value="19">S</option>
							<option value="20">T</option>
							<option value="21">U</option>
							<option value="22">V</option>
							<option value="23">W</option>
							<option value="24">X</option>
							<option value="25">Y</option>
							<option value="26">Z</option>
						</select>
					</div>
				</span>
			</li>
			<li class="li100_nor">
				<iframe id="excel_iframe" name="excel_iframe" width="100%" height="600px" frameborder="0" framespacing="0" marginheight="0" marginwidth="0"></iframe>
			</li>
		</form>
		</ul>
	
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<iframe id="sms_iframe" name="sms_iframe" width="0" height="0" style="display: none;"></iframe>

<script type="text/javascript">
$(document).ready(function(){
	// 샘플 파일 로드
	excel_iframe.location.href = "../func/excelReader/load.php?type=2&file=sms_excel_send_sample.xls";
	
	// 파일 선택
	$("#btn_file").click(function(){
		$("#EXCEL_SEL").trigger("click");
	});
	$("#EXCEL_SEL").change(function(){
		$("#EXCEL_STR").val(this.value);
		$("#NUM_TO").val(0);
		$("#NUM_FROM").val(0);
		$("#NUM_FROM_1").removeClass("bg_lgr_d");
		$("#NUM_FROM_2").removeClass("bg_lgr_d");
		$("#NUM_FROM_3").removeClass("bg_lgr_d");
		$("#NUM_FROM_1").prop("disabled", false);
		$("#NUM_FROM_2").prop("disabled", false);
		$("#NUM_FROM_3").prop("disabled", false);
	});

	// 내용불러오기
	$("#btn_load").click(function(){
		if( !$("#EXCEL_SEL").val() ){
			swal("체크", "엑셀 파일을 선택해 주세요.", "warning"); return false;
		}else{         
			$("#mode").val("sms_ex_load");
        	$("#sms_frm").ajaxForm({
        		url: "../_info/json/_sms_json.php",
        		enctype: "multipart/form-data",
		        dataType: "json",
                success: function(response, status){
                    if(response.result){
                        excel_iframe.location.href = "../func/excelReader/load.php?file="+response.file;
            			$("#startRow").val(1);
            			$("#endRow").val(10);
            			$("#cntRow").val(10);
                    }else{
                    	swal("체크", "엑셀 파일을 불러오는 중 오류가 발생 했습니다.", "warning");
                    }
                },
                error: function(e){
                	swal("체크", "엑셀 파일을 불러오는 중 오류가 발생 했습니다.", "warning");
                }                               
            }).submit();
		}
	});

	// 샘플양식받기
	$("#btn_sample").click(function(){
		sms_iframe.location.href = "../_files/sample/sms_excel_send_sample.xls";
	});

	// 수신번호 선택
	$("#NUM_TO").change(function(){
		var num_to = $("#NUM_TO").val();
		if(num_to == "0"){
			$("#excel_iframe").contents().find("#send_table input[name='NUM_TO[]']").val("");
		}else{
			$("#excel_iframe").contents().find("#send_table input[name='NUM_TO[]']").val("");
			$.each($("#excel_iframe").contents().find("#view_table tbody tr"), function(i, v){
				tmp_num = i+1;
				tmp_val = $("#excel_iframe").contents().find("#row_"+tmp_num+" #col_"+num_to).text();
				$("#excel_iframe").contents().find("#send_table #NUM_TO_"+tmp_num).val(tmp_val);
			});
		}
	});
	
	// 회신번호 선택
	$("#NUM_FROM").change(function(){
		var num_from = $("#NUM_FROM").val();
		if(num_from == "0"){
			$("#NUM_FROM_1").removeClass("bg_lgr_d");
			$("#NUM_FROM_2").removeClass("bg_lgr_d");
			$("#NUM_FROM_3").removeClass("bg_lgr_d");
			$("#NUM_FROM_1").prop("disabled", false);
			$("#NUM_FROM_2").prop("disabled", false);
			$("#NUM_FROM_3").prop("disabled", false);

			var tmp_from = $("#NUM_FROM_1").val()+"-"+$("#NUM_FROM_2").val()+"-"+$("#NUM_FROM_3").val();
			$("#excel_iframe").contents().find("#send_table input[name='NUM_FROM[]']").val(tmp_from);
		}else{
			$("#NUM_FROM_1").addClass("bg_lgr_d");
			$("#NUM_FROM_2").addClass("bg_lgr_d");
			$("#NUM_FROM_3").addClass("bg_lgr_d");
			$("#NUM_FROM_1").prop("disabled", true);
			$("#NUM_FROM_2").prop("disabled", true);
			$("#NUM_FROM_3").prop("disabled", true);

			$("#excel_iframe").contents().find("#send_table input[name='NUM_FROM[]']").val("");
			$.each($("#excel_iframe").contents().find("#view_table tbody tr"), function(i, v){
				tmp_num = i+1;
				tmp_val = $("#excel_iframe").contents().find("#row_"+tmp_num+" #col_"+num_from).text();
				$("#excel_iframe").contents().find("#send_table #NUM_FROM_"+tmp_num).val(tmp_val);
			});
		}
	});
	$("#NUM_FROM_1").change(function(){
		var tmp_from = $("#NUM_FROM_1").val()+"-"+$("#NUM_FROM_2").val()+"-"+$("#NUM_FROM_3").val();
		$("#excel_iframe").contents().find("#send_table input[name='NUM_FROM[]']").val(tmp_from);
	});
	$("#NUM_FROM_2").keyup(function(){
		var tmp_from = $("#NUM_FROM_1").val()+"-"+$("#NUM_FROM_2").val()+"-"+$("#NUM_FROM_3").val();
		$("#excel_iframe").contents().find("#send_table input[name='NUM_FROM[]']").val(tmp_from);
	});
	$("#NUM_FROM_3").keyup(function(){
		var tmp_from = $("#NUM_FROM_1").val()+"-"+$("#NUM_FROM_2").val()+"-"+$("#NUM_FROM_3").val();
		$("#excel_iframe").contents().find("#send_table input[name='NUM_FROM[]']").val(tmp_from);
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

	// 전송범위 설정
	$("#startRow").keyup(function(){
		cnt_check();
	});
	$("#endRow").keyup(function(){
		cnt_check();
	});

	// 메세지 입력
	$("#SMS_STR").keyup(function(){
		var startRow = parseInt( $("#startRow").val() );
		var endRow = parseInt( $("#endRow").val() );
		var col_cnt = $("#excel_iframe").contents().find("#view_table thead th").length - 1;

		for(var i = startRow; i <= endRow; i ++){
			var sms_str = $("#SMS_STR").val();
			if(col_cnt == 0){
				$("#excel_iframe").contents().find("#send_table input[name='MSG_STR[]']").val(sms_str);
			}else{
				for(var j = 1; j <= col_cnt; j ++){
					var tmp_val = $("#excel_iframe").contents().find("#row_"+i+" #col_"+j).text();
					var pattern = "<%"+j+"%>";
					var regex = new RegExp(pattern, "gi");
					sms_str = sms_str.replace(regex, tmp_val);
					$("#excel_iframe").contents().find("#send_table #MSG_STR_"+i).val(sms_str);
					$("#excel_iframe").contents().find("#send_table #MSG_LEN_"+i).val( byte_check(sms_str) );
				}
			}
		}
	});

	// 오류 검사
	$("#btn_check").click(function(){
		sms_check();
	});

	// SMS 전송
	$("#btn_send").click(function(){
		if( sms_check() ){
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
					$("#mode").val("sms_ex_insert");
					var param = $("#sms_frm").serialize()+"&"+$("#excel_iframe").contents().find("#excel_frm").serialize();
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
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 엑셀 열변수 삽입
	$("#SMS_STR_COLS").change(function(){
		var sms_str_cols = $("#SMS_STR_COLS").val();
		var sms_str = $("#SMS_STR").val();
		
		if(sms_str_cols != 0){
			$("#SMS_STR").val(sms_str+"<%"+sms_str_cols+"%>");
			$("#SMS_STR").keyup();
		}
	});

	// 전송범위 체크
	function cnt_check(){
		var startRow = parseInt( $("#startRow").val() );
		var endRow = parseInt( $("#endRow").val() );
		var cntRow = endRow - startRow + 1;

		if(startRow <= 0 || endRow <= 0){
			$("#startRow").val(1);
			$("#endRow").val(10);
			$("#cntRow").val(10);
			cnt_reset(10);
		    swal("체크", "전송 범위를 다시 확인해 주세요.", "warning"); return false;
		}else if(cntRow > 0){
			$("#cntRow").val(cntRow);
		}else{
			$("#startRow").val(1);
			$("#endRow").val(10);
			$("#cntRow").val(10);
			cnt_reset(10);
		    swal("체크", "전송 범위를 다시 확인해 주세요.", "warning"); return false;
		}

		var send_cnt = $("#excel_iframe").contents().find("#send_table tbody tr").length;
		if(send_cnt != endRow){
			cnt_reset(endRow);
		}
	}

	// 전송목록 변경
	function cnt_reset(endRow){
		$("#excel_iframe").contents().find("#send_table tbody").empty();
		var send_tbody = '';
		for(var i = 0; i < endRow; i ++){
			tmp_num = i+1;
			send_tbody += '<tr>';
			send_tbody += '<th>'+tmp_num+'</th>';
			send_tbody += '<td class="center" style="height:22px;"><input type="text" id="NUM_FROM_'+tmp_num+'" name="NUM_FROM[]" style="width:85px; border:0;" readonly></td>';
			send_tbody += '<td class="center"><input type="text" id="NUM_TO_'+tmp_num+'" name="NUM_TO[]" style="width:85px; border:0;" readonly></td>';
			send_tbody += '<td class="center"><input type="text" id="MSG_STR_'+tmp_num+'" name="MSG_STR[]" style="width:278px; border:0;" readonly></td>';
			send_tbody += '<td class="center"><input type="text" id="MSG_LEN_'+tmp_num+'" name="MSG_LEN[]" style="width:38px; border:0;" readonly></td>';
			send_tbody += '<td class="center red"><input type="text" id="ERR_STR_'+tmp_num+'" name="ERR_STR[]" style="width:88px; border:0;" readonly></td>';
			send_tbody += '</tr>';
		}
		$("#excel_iframe").contents().find("#send_table tbody").append(send_tbody);
	}

	// 문자 길이
	function byte_check(tmp_text){
	    var tmp_byte = 0;
	    
	    for(var i = 0; i < tmp_text.length; i++){
	        var c = escape(tmp_text.charAt(i));
	        if(c.length == 1) tmp_byte ++;
	        else if(c.indexOf("%u") != -1) tmp_byte += 2;
	        else if(c.indexOf("%") != -1) tmp_byte += c.length/3;
	    }
	    return (tmp_byte == 0) ? "" : tmp_byte;
	}
	
	// 문자 폼 체크
	function sms_check(){
		var check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/;
		var startRow = parseInt( $("#startRow").val() );
		var endRow = parseInt( $("#endRow").val() );
		var errRow = 0;

		for(var i = 1; i <= endRow; i ++){
			$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("");
		}
		
		for(var i = startRow; i <= endRow; i ++){
			if( !$("#excel_iframe").contents().find("#send_table #MSG_STR_"+i).val() ){
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("메세지 미입력"); errRow ++;
			}else if( $("#excel_iframe").contents().find("#send_table #MSG_LEN_"+i).val() > 80 ){
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("80byte 초과"); errRow ++;
			}else if( !$("#excel_iframe").contents().find("#send_table #NUM_TO_"+i).val() ){
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("수신번호 미입력"); errRow ++;
			}else if( !check.test( $("#excel_iframe").contents().find("#send_table #NUM_TO_"+i).val() ) ){
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("수신번호 이상"); errRow ++;
			}else if( !check.test( $("#excel_iframe").contents().find("#send_table #NUM_FROM_"+i).val() ) &&
					$("#excel_iframe").contents().find("#send_table #NUM_FROM_"+i).val() ){
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("회신번호 이상"); errRow ++;
			}else{
				$("#excel_iframe").contents().find("#send_table #ERR_STR_"+i).val("");
			}
		}

		if(errRow == 0){
			swal("체크", "오류가 없습니다.", "success"); return true;
		}else{
			swal("체크", "오류가 "+errRow+"개 있습니다.", "warning"); return false;
		}
	}

	// 뒤로가기 관련 처리
	$("#EXCEL_STR").val("");
	$("#EXCEL_SEL").val("");
	$("#NUM_FROM").val(0);
	$("#NUM_FROM_1").val("02");
	$("#NUM_FROM_2").val("");
	$("#NUM_FROM_3").val("");
	$("#NUM_TO").val(0);
	$("#SMS_TYPE1").prop("checked", true);
	$("#DD").val("<?=date('Y-m-d')?>");
	$("#HH").val("00");
	$("#MM").val("00");
	$("#startRow").val(1);
	$("#endRow").val(10);
	$("#cntRow").val(10);
	$("#SMS_STR").val("");
	$("#SMS_STR_COLS").val("");
});
</script>

</body>
</html>


