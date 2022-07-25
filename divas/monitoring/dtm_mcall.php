<?
require_once "../_conf/_common.php";
require_once "../_info/_dtm_mcall.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
			<div class="main_contitle">
				<div class="tit"><img src="../images/board_icon_aws.png"> <span>자료수동호출</span></div>
			<!-- <img src="../images/title_04_01.png" alt="강우 자료"> -->
				</div>

			<div class="right_bg2">
			<ul id="search_box">
			<form id="form_mcall" method="get">
				<li>
				<input type="hidden" name="mode" value="mcall">
			<input type="hidden" id="RTU_CNT" name="RTU_CNT">
			<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID">
			<span class="tit">검색 기간  : </span>
			<input type="radio" class="btn_radio" name="tran_date" value="y" <?if($DATE=="y"){echo "checked";}?>><span class="tit">연간  </span>
				<input type="radio" class="btn_radio" name="tran_date" value="m" <?if($DATE=="m"){echo "checked";}?>><span class="tit">월간  </span>
				<input type="radio" class="btn_radio" name="tran_date" value="d" <?if($DATE=="d"){echo "checked";}?>><span class="tit">일간  </span>
				<input type="radio" class="btn_radio" name="tran_date" value="" <?if($DATE==""){echo "checked";}?>><span class="tit mR15">기간  </span>
			
				<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
				<span class="mL3">-</span>
				<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
				</li>
				</form>
				</ul>
				<!-- <ul class="stitle_box">
		             <li><?=$sdate?></li>
		             <li></li>
		         </ul> -->


			<ul>
			<li class="li150_or">
				<div style="clear: both;"></div>
				<div class="mi fL"></div>
				<div class="datam_con_29_new">
					<ul>
						<li class="datam_con_blue">장비목록
							<button type="button" id="btn_mcall" class="fR">호출</button>
							<button type="button" id="btn_all" class="fR">전체선택</button>
						</li>
						<li class="p0" style="height:637px;overflow:scroll">
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
									
									<tr class="hh" id="list_<?=$val['RTU_ID']?>">
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
				<div class="datam_con_68_new">
					<ul>
						<li class="datam_con_blue">호출결과</li>
						<li class="p0" style="height:637px;overflow:scroll">
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
										<tr class="hh">
											<td id="RTU_NAME" class="li30 al_C hi32 bL_1gry"></td>
											<td id="STATE" class="li40 al_C hi32 bL_1gry"></td>
											<td id="RESULT" class="li30 al_C hi32 bL_1gry bR_1gry"></td>
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
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");

	$(".btn_radio").click(function(e){
			if(e.target.value == 'y'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else if(e.target.value == 'm'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else if(e.target.value == 'd'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else{
				$("#edate").show();
				$("#edate").prev().show();
				$("#edate").next().show();
			}
		});
	
	// 장비 선택 - 사용하면 -> 체크박스 체크 안됨
	// $("#list_check tbody tr").click(function(){
	// 	var tmp_el = $("#"+this.id+" input")[0];
	// 	if( $(tmp_el).prop("checked") ){
	// 		$(tmp_el).prop("checked", false);
	// 	}else{
	// 		$(tmp_el).prop("checked", true);
	// 	}
	// });
	
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
		var STR_RTU_ID = "";
		$.each($("input[name='RTU_ID[]']:checked"), function(i,v){
			RTU_CNT ++;
			if(STR_RTU_ID != "") STR_RTU_ID += "-";
    		STR_RTU_ID += v.value;
		});
		$("#RTU_CNT").val(RTU_CNT);
		$("#STR_RTU_ID").val(STR_RTU_ID);

		if(RTU_CNT == 0){
			swal("체크", "장비를 선택해 주세요.", "warning");
		}else{
			var param = $("#form_mcall").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_dtm_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
	                if(data.result[0]){
	                	mcall_set(data.result[1]);
	                }else{
						swal("체크", "수동 호출중 오류가 발생 했습니다.", "warning");
	                }
		        }
		    });	
		}
	});

	// 5초 간격으로 호출
	var setInt_data = null;

	function mcall_set(log_no){
    	if(setInt_data) clearInterval(setInt_data);
    	
		mcall_log(1, log_no);
		setInt_data = setInterval(function(){
			mcall_log(2, log_no);
		}, 5000);
	}
	
	// 수동 호출 결과
	function mcall_log(type, log_no){
		var tmp_spin = null;
		var param = "mode=mcall_log&log_no="+log_no;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_dtm_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	if(type == 1){
					if(data.list){
	    	        	var tmp_html = '';
	                    var leng = data.list.length;
						console.log(data);
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
							console.log(v);
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
	$("#STR_RTU_ID").val("");
	$("input[name=tran_date]:input[value='']").prop("checked", true);
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");

	var select_obj = '';

$('.btn_radio:checked').each(function (index) {
	select_obj += $(this).val();
});
if(select_obj ==  'y' ){
	$("#edate").prev().hide();
	$("#edate").next().hide();
	$("#edate").hide();
}else if(select_obj == 'm'){
	$("#edate").prev().hide();
	$("#edate").next().hide();
	$("#edate").hide();
}else if(select_obj == 'd'){
  $("#edate").prev().hide();
  $("#edate").next().hide();
  $("#edate").hide();
}else if(select_obj == 'a'){
	$("#edate").prev().show();
	$("#edate").next().show();
	$("#edate").show();
}
});
</script>

</body>
</html>


	