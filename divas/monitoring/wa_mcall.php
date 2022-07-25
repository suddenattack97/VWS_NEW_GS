<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_mcall.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<div class="main_contitle">
			<img src="../images/title_04_04.png" alt="수동 호출">
		</div>
		
		<ul class="set_ulwrap_nh">
			<form id="form_mcall" method="get">
			<input type="hidden" name="mode" value="wa_mcall">
			<input type="hidden" id="RTU_CNT" name="RTU_CNT">
			<input type="hidden" id="STR_IDX" name="STR_IDX">
			<li class="tb_sms_gry" style="height: 42px;">
			</li>
			<li class="li150_or">
				<div style="clear: both;"></div>
				<div class="mi fL"></div>
				<div class="datam_con_29">
					<ul>
						<li class="datam_con_gry">장비목록
							<button type="button" id="btn_mcall" class="btn_bs60 mL5">호출</button>
							<button type="button" id="btn_all" class="btn_lbs fR">전체선택</button>
						</li>
						<li class="p0">
							<div class="datam_list">
								<table id="list_check" class="tb_data">
									<thead class="tb_data_tbg">
										<tr>
											<th class="w15i hi28">선택</th>
											<th class="w85i hi28 bL_1gry">장비명</th>
										</tr>
									</thead>
					
									<tbody>
									<? 
									if($data_list){
										foreach($data_list as $key => $val){ 
									?>
										<tr id="list_<?=$val['RTU_ID']?>">
											<td class="w15i hi28">
												<input type="checkbox" name="RTU_ID[]" class="chkbox" value="<?=$val['RTU_ID']?>">
											</td>
											<td class="w85i hi28 bL_1gry"><?=$val['RTU_NAME']?></td>
										</tr>
									<? 
										}
									}
									?>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
				<div class="mi fL"></div>
				<div class="datam_con_68">
					<ul>
						<li class="datam_con_gry">호출결과</li>
						<li class="p0">
							<div id="list_spin" class="datam_list">
            					<div id="spin"></div>
								<table id="list_table" class="tb_data">
									<thead class="tb_data_tbg">
										<tr>
											<th class="li30 al_C hi28 bL_1gry">장비명</th>
											<th class="li40 al_C hi28 bL_1gry">호출상태</th>
											<th class="li30 al_C hi28 bL_1gry bR_1gry">호출결과</th>
										</tr>
									</thead>
					
									<tbody>
									<? 
									for($i = 0; $i < 20; $i ++){ 
									?>
										<tr>
											<td id="RTU_NAME" class="li30 al_C hi28 bL_1gry"></td>
											<td id="STATE" class="li40 al_C hi28 bL_1gry"></td>
											<td id="RESULT" class="li30 al_C hi28 bL_1gry bR_1gry"></td>
										</tr>
									<? 
									}
									?>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
			</li>
			</form>
		</ul>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 장비 선택
	$("#list_check tbody tr").click(function(){
		var tmp_el = $("#"+this.id+" input")[0];
		if( $(tmp_el).prop("checked") ){
			$(tmp_el).prop("checked", false);
		}else{
			$(tmp_el).prop("checked", true);
		}
	});
	
	// 전체 선택
	$("#btn_all").click(function(){
		var tmp_cnt = $("input[name='RTU_ID[]']:not(:checked)").length;
		if(tmp_cnt == 0){
			$("input[name='RTU_ID[]']").prop("checked", false);
		}else{
			$("input[name='RTU_ID[]']").prop("checked", true);
		}
	});

	// 수동 호출
	$("#btn_mcall").click(function(){
		var RTU_CNT = 0;
		var STR_IDX = "";
		$.each($("input[name='RTU_ID[]']:checked"), function(i, v){
			RTU_CNT ++;
			if(STR_IDX != "") STR_IDX += "-";
    		STR_IDX += v.value;
		});
		$("#RTU_CNT").val(RTU_CNT);
		$("#STR_IDX").val(STR_IDX);

		if(RTU_CNT == 0){
			swal("체크", "장비를 선택해 주세요.", "warning");
		}else{
			var param = $("#form_mcall").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_wa_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
	                if(data.result[0]){
	                	mcall_set(data.result[1], data.result[2]);
	                }else{
						swal("체크", "수동 호출중 오류가 발생 했습니다.", "warning");
	                }
		        }
		    });	
		}
	});

	// 5초 간격으로 호출
	var setInt_data = null;
	
	function mcall_set(sno, cnt){
    	if(setInt_data) clearInterval(setInt_data);
    	
		mcall_log(1, sno, cnt);
		setInt_data = setInterval(function(){
			mcall_log(2, sno, cnt);
		}, 5000);
	}
	
	// 수동 호출 결과
	function mcall_log(type, sno, cnt){
		var tmp_spin = null;
		var param = "mode=wa_mcall_log&sno="+sno+"&cnt="+cnt;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	if(type == 1){
					if(data.list){
	    	        	var tmp_html = '';
	                    var leng = data.list.length;
	                    
						$.each(data.list, function(i, v){
			            	tmp_html += ' <tr id="mcall_'+v.RTU_ID+'"> ';
			            	tmp_html += ' <td id="RTU_NAME" class="li30 al_C hi28 bL_1gry">'+v.RTU_NAME+'</td> ';
			            	tmp_html += ' <td id="STATE" class="li40 al_C hi28 bL_1gry">'+v.STATE+'</td> ';
			            	tmp_html += ' <td id="RESULT" class="li30 al_C hi28 bL_1gry bR_1gry">'+v.RESULT+'</td> ';
							tmp_html += ' </tr>';
						});
						for(var i = leng; i < 20; i ++){
			            	tmp_html += ' <tr> ';
			            	tmp_html += ' <td id="RTU_NAME" class="li30 al_C hi28 bL_1gry"></td> ';
			            	tmp_html += ' <td id="STATE" class="li40 al_C hi28 bL_1gry"></td> ';
			            	tmp_html += ' <td id="RESULT" class="li30 al_C hi28 bL_1gry bR_1gry"></td> ';
							tmp_html += ' </tr>';
						}
					}else{
						for(var i = 0; i < 20; i ++){
			            	tmp_html += ' <tr> ';
			            	tmp_html += ' <td id="RTU_NAME" class="li30 al_C hi28 bL_1gry"></td> ';
			            	tmp_html += ' <td id="STATE" class="li40 al_C hi28 bL_1gry"></td> ';
			            	tmp_html += ' <td id="RESULT" class="li30 al_C hi28 bL_1gry bR_1gry"></td> ';
							tmp_html += ' </tr>';
						}
					}
					$("#list_table tbody").html(tmp_html);
                }else if(type == 2){
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#mcall_"+v.RTU_ID;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #STATE").html(v.STATE);
							$(tmp_id+" #RESULT").html(v.RESULT);
			            });
			        }
		        } 
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		    		tmp_spin = spin_start("#list_spin #spin", "80px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, "#list_spin #spin");
		        	}
	        	}
	        }
	    });	
	}

	// 뒤로가기 관련 처리
	$("input[name='RTU_ID[]']").prop("checked", false);
	$("#RTU_CNT").val("");
	$("#STR_IDX").val("");
});
</script>

</body>
</html>


	