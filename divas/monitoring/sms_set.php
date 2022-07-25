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
			<img src="../images/title_03_04.png" alt="수신자 설정">
		</div>
		<div class="right_bg">
		<ul class="tb_edit">
		<form id="sms_frm" name="sms_frm" method="post" enctype="multipart/form-data">
			<input type="hidden" id="mode" name="mode">
			<input type="hidden" id="IDX" name="IDX"><!-- 선택한 수신자 IDX -->
			<input type="hidden" id="OLD_MOBILE" name="OLD_MOBILE"><!-- 선택한 수신자 전화번호 -->
			<li class="tb_sms_set tb_sms">
				<div class="set_ulwrap_nh">
					<div class="tb_sms_gry_top tb_sms_gry">
						<span class="sel_left_n"> 
							이름
							<input id="USER_NAME" name="USER_NAME" type="text" class="f333_12" size="10"> 
							&nbsp;&nbsp;
							휴대폰 
							<select id="MOBILE1" name="MOBILE1" class="f333_12" size="1">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
							-
							<input id="MOBILE2" name="MOBILE2" type="text" class="f333_12" size="4" maxlength="4">
							-
							<input id="MOBILE3" name="MOBILE3" type="text" class="f333_12" size="4" maxlength="4"> 
							&nbsp;&nbsp; 
							소속및직책 
							<input id="MEMO" name="MEMO" type="text" class="f333_12" size="10" value=""> 
							<br>
							그룹
							<select id="SMS_GROUP_ID" name="SMS_GROUP_ID" size="1" class="f333_12_bm" style="width: 100px">
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
							&nbsp;
							<button type="button" id="btn_group" class="btn_wbs">그룹설정</button>
							&nbsp;
							<button type="button" id="btn_step" class="btn_bs">장비별 SMS 자동 발송 설정</button>
							<br> 
							엑셀 등록 : 
							<!-- <input type="text" id="EXCEL_STR" name="EXCEL_STR" class="f333_12" size="20" readonly>&nbsp; -->
							<!-- <input type="file" id="EXCEL_SEL" name="EXCEL_SEL" style="display: none;"> -->
							<!-- <button type="button" id="btn_file" class="btn_lbs">파일선택</button>&nbsp; -->
							<!-- <button type="button" id="btn_excel" class="btn_lbs">엑셀등록</button>&nbsp; -->

							<button type="button" id="btn_sample" class="btn_wbs">샘플받기</button>

							<div class="fileBox">	
							<form enctype="multipart/form-data" id="ajaxForm" method="post">			
							<input type="text" id="fileName" class="fileName" readonly="readonly">
							<label for="uploadBtn" class="btn_file" style="cursor:pointer;" onclick="">엑셀등록</label>
							<input type="file" id="uploadBtn" class="uploadBtn" name="uploadBtn" onchange="">
						
							</div>


						</span> 
						<span class="sel_right_n">
							<button type="button" id="btn_in" class="btn_wbb130">등 록</button>
							<button type="button" id="btn_up" class="btn_wbb130_l">수 정</button>
							<button type="button" id="btn_de" class="btn_wbb130_l">삭 제</button>
						</span>
					</div>
					<div class="sms_conte_sel">
						검색구분 : 
						<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" class="select_sms">
							<option value="1" <?if($_REQUEST['SECTION_NO_SEARCH'] == "1"){echo "selected";}?>>이름</option>
							<option value="2" <?if($_REQUEST['SECTION_NO_SEARCH'] == "2"){echo "selected";}?>>그룹</option>
							<option value="3" <?if($_REQUEST['SECTION_NO_SEARCH'] == "3"){echo "selected";}?>>소속및직책</option>
						</select> 
						<input type="text" id="search_text" name="search_text" class="input_sms" value="<?=$_REQUEST['search_text']?>">
						<button type="button" id="btn_search" class="btn_bs60_sms">조회</button>
						<button type="button" id="btn_all" class="btn_bs">전체목록</button>
					</div>
					<div class="w100 fL">
						<div class="tb_sms_rtitle">
							<ul>
								<? if(level_cnt == 2){ ?>
								<li class="li20">그룹</li>
								<li class="li20">이름</li>
								<li class="li25">휴대폰</li>
								<li class="li25">소속및직책</li>
								<li class="li5"><?=level_1?></li>
								<li class="li5"><?=level_2?></li>
								<? }else if(level_cnt == 3){ ?>
								<li class="li15">그룹</li>
								<li class="li20">이름</li>
								<li class="li25">휴대폰</li>
								<li class="li20">소속및직책</li>
								<li class="li5"><?=level_1?></li>
								<li class="li5"><?=level_2?></li>
								<li class="li5"><?=level_3?></li>
								<? }else if(level_cnt == 4){ ?>
								<li class="li15">그룹</li>
								<li class="li15">이름</li>
								<li class="li25">휴대폰</li>
								<li class="li20">소속및직책</li>
								<li class="li5"><?=level_1?></li>
								<li class="li5"><?=level_2?></li>
								<li class="li5"><?=level_3?></li>
								<? }else if(level_cnt == 5){ ?>
								<li class="li15">그룹</li>
								<li class="li15">이름</li>
								<li class="li20">휴대폰</li>
								<li class="li20">소속및직책</li>
								<li class="li5"><?=level_1?></li>
								<li class="li5"><?=level_2?></li>
								<li class="li5"><?=level_3?></li>
								<li class="li5"><?=level_4?></li>
								<li class="li5"><?=level_5?></li>
								<? } ?>
							</ul>
						</div>
						<div id="user_table" class="tb_sms_rlist max570 pB40p">
							<? 
							if($data_user){
								foreach($data_user as $key => $val){ 
							?>
							<ul id="user_<?=$val['IDX']?>" data-id="<?=$val['IDX']?>">
								<? if(level_cnt == 2){ ?>
								<li id="l_SMS_GROUP_ID" class="dp0"><?=$val['SMS_GROUP_ID']?></li>
								<li id="l_SMS_GROUP_NAME" class="li20"><?=$val['SMS_GROUP_NAME']?></li>
								<li class="li20"><?=$val['USER_NAME']?></li>
								<li class="li25"><?=$val['MOBILE']?></li>
								<li class="li25"><?=$val['MEMO']?></li>
								<li class="li5"><?=$val['GROUP1']?></li>
								<li class="li5"><?=$val['GROUP2']?></li>
								<? }else if(level_cnt == 3){ ?>
								<li id="l_SMS_GROUP_ID" class="dp0"><?=$val['SMS_GROUP_ID']?></li>
								<li id="l_SMS_GROUP_NAME" class="li15"><?=$val['SMS_GROUP_NAME']?></li>
								<li class="li20"><?=$val['USER_NAME']?></li>
								<li class="li25"><?=$val['MOBILE']?></li>
								<li class="li20"><?=$val['MEMO']?></li>
								<li class="li5"><?=$val['GROUP1']?></li>
								<li class="li5"><?=$val['GROUP2']?></li>
								<li class="li5"><?=$val['GROUP3']?></li>
								<? }else if(level_cnt == 4){ ?>
								<li id="l_SMS_GROUP_ID" class="dp0"><?=$val['SMS_GROUP_ID']?></li>
								<li id="l_SMS_GROUP_NAME" class="li15"><?=$val['SMS_GROUP_NAME']?></li>
								<li class="li15"><?=$val['USER_NAME']?></li>
								<li class="li25"><?=$val['MOBILE']?></li>
								<li class="li20"><?=$val['MEMO']?></li>
								<li class="li5"><?=$val['GROUP1']?></li>
								<li class="li5"><?=$val['GROUP2']?></li>
								<li class="li5"><?=$val['GROUP3']?></li>
								<? }else if(level_cnt == 5){ ?>
								<li id="l_SMS_GROUP_ID" class="dp0"><?=$val['SMS_GROUP_ID']?></li>
								<li id="l_SMS_GROUP_NAME" class="li15"><?=$val['SMS_GROUP_NAME']?></li>
								<li class="li15"><?=$val['USER_NAME']?></li>
								<li class="li20"><?=$val['MOBILE']?></li>
								<li class="li20"><?=$val['MEMO']?></li>
								<li class="li5"><?=$val['GROUP1']?></li>
								<li class="li5"><?=$val['GROUP2']?></li>
								<li class="li5"><?=$val['GROUP3']?></li>
								<li class="li5"><?=$val['GROUP4']?></li>
								<li class="li5"><?=$val['GROUP5']?></li>
								<? } ?>
							</ul>
							<? 
								}
							}else{
							?>	
							<ul>
								<li class="li100_or">데이터가 없습니다.</li>
							</ul>
							<? 
							}
							?>
						</div>
					</div>
				</div>
			</li>
		</ul>
		</form>
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" style="display: none;">
	<div id="pop_1" class="popup_layout_b">
		<div class="popup_top">그룹설정
			<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		</div>
		<div class="popup_con_1">		
			<dl>
				<dd id="group_table" class="bB_1gry max300">
				<?
				if($data_group){
					foreach($data_group as $key => $val){
				?>
					<ul id="group_<?=$val['SMS_GROUP_ID']?>">
						<li id="li_SMS_GROUP_NAME"><?=$val['SMS_GROUP_ID']?>.&nbsp;<?=$val['SMS_GROUP_NAME']?></li>
						<li id="li_SMS_GROUP_ID" style="display:none"><?=$val['SMS_GROUP_ID']?></li>
					</ul>
				<?
					}
				}
				?>						
				</dd>
				<dd>
					<ul> 
						<li class="b0 w100 p0 bold">
							<form id="group_frm" name="group_frm" method="post">
								그룹명 : <input type="text" id="S_SMS_GROUP_NAME" name="SMS_GROUP_NAME" style="width:236px;" class="f333_12">
								<input type="hidden" id="S_SMS_GROUP_ID" name="SMS_GROUP_ID">
							</form>
						</li>
						<li class="b0 al_C w100">
							<button type="button" id="btn_s_in" class="btn_bb80">등록</button>
							<button type="button" id="btn_s_up" class="btn_wbb80">수정</button>
							<button type="button" id="btn_s_de" class="btn_wbb80">삭제</button>
						</li>
					</ul>
				</dd>				
			</dl>	
		</div>
	</div>
	<div id="pop_2" class="popup_layout_s">
		<div class="popup_top">장비별 SMS 자동 발송 설정
			<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		</div>
		<div class="popup_con">	
        	<div class="alarm">		
			<div class="w100 alarm_gry h50p bold">
				<span class="fL">수신자 :&nbsp;</span>
				<span id="rtu_user_name" class="fL"></span>
				<button type="button" id="rtu_all" class="btn_tb_in w20 fR">전체선택</button>
			</div>

			<form id="rtu_frm" method="get" class="m_scroll">
				<input type="hidden" id="RTU_ID" name="RTU_ID">
				<input type="hidden" id="SMS_SEND_GROUP" name="SMS_SEND_GROUP">
				<input type="hidden" id="SENSOR_TYPE" name="SENSOR_TYPE">
				<table id="rtu_table" class="tb_data w100">
					<thead>
						<tr class="tb_data_tbg">
							<th class="w25i">장비명</th>
							<th class="w25i">센서타입 : &nbsp;
							<?
								$sensor_kind = array("0", "1", "2", "DP");
								$sensor_name = array("강우", "수위", "적설", "변위");
								// $sensor_kind = array("0", "1", "2", "DP", "EQ", "A", "T", "W", "H", "R", "S");
								// $sensor_name = array("강우", "수위", "적설", "변위", "지진", "기압", "온도", "풍향풍속", "습도", "일사", "일조");
							?>
								<select id="sensor_change">
									<option value="-1">전체</option>
									<?
									// 센서별 선택 추가
									for($i = 0; $i < count($sensor_kind); $i++){
										?>
										<option value="<?=$sensor_kind[$i]?>"><?=$sensor_name[$i]?></option>
										<?
									}
									?>
								</select>
							</th>
							<th class="w10i"><span id="1_step" class="btn_tb_in group_all"><?=level_1?></span></th>
							<th class="w10i"><span id="2_step" class="btn_tb_in group_all"><?=level_2?></span></th>
							<? if(level_cnt == 3){ ?>
							<th class="w10i"><span id="3_step" class="btn_tb_in group_all"><?=level_3?></span></th>
							<? }else if(level_cnt == 4){ ?>
							<th class="w10i"><span id="3_step" class="btn_tb_in group_all"><?=level_3?></span></th>
							<? }else if(level_cnt == 5){ ?>
							<th class="w10i"><span id="3_step" class="btn_tb_in group_all"><?=level_3?></span></th>
							<th class="w10i"><span id="4_step" class="btn_tb_in group_all"><?=level_4?></span></th>
							<th class="w10i"><span id="5_step" class="btn_tb_in group_all"><?=level_5?></span></th>
							<? } ?>
						</tr>
					</thead>
					<tbody>
						<? 
						if($data_rtu){
							foreach($data_rtu as $key => $val){ 
								$kind = array_search( $val['SENSOR_TYPE'], $sensor_kind);
								if($kind !== false){ 
									$kind = $sensor_name[$kind];
						?>
						<tr id="rtu_<?=$val['RTU_ID']?>_<?=$val['SENSOR_TYPE']?>" class="sensor_<?=$val['SENSOR_TYPE']?>" data-id="<?=$val['RTU_ID']?>|<?=$val['SENSOR_TYPE']?>">
							<td id="rtu_name"><span class="btn_tb_in w80"><?=$val['RTU_NAME']?></span></td>
							<td class="sensor_type"><?=$kind?></td>
							<td><input type="checkbox" id="SMS_SEND_GROUP1" name="SMS_SEND_GROUP1" value="1"></td>
							<td><input type="checkbox" id="SMS_SEND_GROUP2" name="SMS_SEND_GROUP2" value="2"></td>
							<? if(level_cnt == 3){ ?>
							<td><input type="checkbox" id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" value="3"></td>
							<? }else if(level_cnt == 4){ ?>
							<td><input type="checkbox" id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" value="3"></td>
							<? }else if(level_cnt == 5){ ?>
							<td><input type="checkbox" id="SMS_SEND_GROUP3" name="SMS_SEND_GROUP3" value="3"></td>
							<td><input type="checkbox" id="SMS_SEND_GROUP4" name="SMS_SEND_GROUP4" value="4"></td>
							<td><input type="checkbox" id="SMS_SEND_GROUP5" name="SMS_SEND_GROUP5" value="5"></td>
							<? } ?>
						</tr>
						<? 		}
							}
						}
						?>	
					</tbody>
				</table>
			</form>
            </div>
		</div>
	</div>
</div>

<iframe id="sms_iframe" name="sms_iframe" width="0" height="0" style="display: none;"></iframe>

<script type="text/javascript">
$(document).ready(function(){
	// 그룹설정
	$("#btn_group").click(function(){
		$("#pop_1").show();
		$("#pop_2").hide();
		popup_open(); // 레이어 팝업 열기
	});	

	// 그룹설정 그룹 선택
	$(document).on("click", "#group_table ul", function(){
		bg_color("bg_sel", "#group_table ul", this); // 리스트 선택 시 배경색
		
		var tmp_id = "#"+this.id;
		var tmp_idx = $(tmp_id+" #li_SMS_GROUP_ID").text() + ". ";
		var tmp_name = $(tmp_id+" #li_SMS_GROUP_NAME").text();

		$("#S_SMS_GROUP_NAME").val(tmp_name.substring(tmp_idx.length));
		$("#S_SMS_GROUP_ID").val( $(tmp_id+" #li_SMS_GROUP_ID").text() );
	});

	// 그룹설정 그룹 등록
	$("#btn_s_in").click(function(){
		bg_color("bg_sel", "#group_table ul", null); // 리스트 선택 시 배경색

		if( !$("#S_SMS_GROUP_NAME").val() ){
			swal("체크", "그룹명을 입력해 주세요.", "warning");
			$("#S_SMS_GROUP_NAME").focus(); return false;
		}else{
			var param = "mode=sms_group_in&"+$("#group_frm").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_sms_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result[0]){
						var SMS_GROUP_NAME = $("#S_SMS_GROUP_NAME").val();
						$("#SMS_GROUP_ID").append('<option value="'+data.result[1]+'">'+SMS_GROUP_NAME+'</option>');
						var tmp_ul = '<ul id="group_'+data.result[1]+'">';
						tmp_ul += '<li id="li_SMS_GROUP_NAME">'+data.result[1]+'. '+SMS_GROUP_NAME+'</li>';
						tmp_ul += '<li id="li_SMS_GROUP_ID" style="display:none">'+data.result[1]+'</li>';
						tmp_ul += '</ul>';
						$("#group_table").append(tmp_ul);
			        }else{
					    swal("체크", "그룹 등록중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });	
		}
	});
	
	// 그룹설정 그룹  수정
	$("#btn_s_up").click(function(){
		if( !bg_color_check("bg_sel", "#group_table ul") ){ // 리스트 선택 체크
			swal("체크", "그룹을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">그룹 수정 확인</div>\
						<div class="alpop_mes_b">그룹명을 ['+$("#S_SMS_GROUP_NAME").val()+']로 수정하실 겁니까?</div>',
				text: '확인 시 바로 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){
					var param = "mode=sms_group_up&"+$("#group_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
								var SMS_GROUP_ID = $("#S_SMS_GROUP_ID").val();
								var SMS_GROUP_NAME = $("#S_SMS_GROUP_NAME").val();
								$("#SMS_GROUP_ID option[value="+SMS_GROUP_ID+"]").text(SMS_GROUP_NAME);
								$.each($("#user_table ul"), function(i, v){
					        		var tmp_id = "#"+v.id;
									if( $(tmp_id).length ){
										if( $(tmp_id+" #l_SMS_GROUP_ID").text() == SMS_GROUP_ID ){
						        			$(tmp_id+" #l_SMS_GROUP_NAME").text(SMS_GROUP_NAME);
										}
									}
					            });
								$("#group_"+SMS_GROUP_ID+" #li_SMS_GROUP_NAME").text(SMS_GROUP_NAME);
								swal.close();
					        }else{
							    swal("체크", "그룹 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 그룹설정 그룹  삭제
	$("#btn_s_de").click(function(){
		if( !bg_color_check("bg_sel", "#group_table ul") ){ // 리스트 선택 체크
			swal("체크", "그룹을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">그룹 삭제 확인</div>\
						<div class="alpop_mes_b">['+$("#S_SMS_GROUP_NAME").val()+']를 삭제하실 겁니까?</div>',
				text: '확인 시 바로 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){
					var param = "mode=sms_group_de&"+$("#group_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result == 0){
							    swal("체크", "그룹 삭제중 오류가 발생 했습니다.", "warning");
					        }else if(data.result == 1){
							    swal("체크", "수신자 목록에서 사용중인 그룹은 삭제할 수 없습니다.", "warning");
					        }else if(data.result == 2){
								var SMS_GROUP_ID = $("#S_SMS_GROUP_ID").val();
								var SMS_GROUP_NAME = $("#S_SMS_GROUP_NAME").val();
								$("#SMS_GROUP_ID option[value="+SMS_GROUP_ID+"]").remove();
								$("#group_"+SMS_GROUP_ID).remove();
								$("#S_SMS_GROUP_ID").val("");
								$("#S_SMS_GROUP_NAME").val("");
								swal.close();
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
		
	// 장비별 SMS 자동 발송 설정
	$("#btn_step").click(function(){
		$("#rtu_user_name").text( $("#USER_NAME").val() );
		$("#pop_1").hide();
		$("#pop_2").show();
		popup_open(); // 레이어 팝업 열기
	});	

	// 장비 센서종류 선택
	$("#sensor_change").change(function(){
		var sensor_type = this.value;
		if(sensor_type == -1){
			$("tbody tr").css("display", "table-row");
		}else{
			$("tbody tr").css("display", "none");
			$("tbody .sensor_"+sensor_type).css("display", "table-row");
		}
	});	
		
	// 장비별 SMS 자동 발송 설정 전체 선택 - 센서별 선택시 장비 전체선택 -> 센서 전체선택으로 바꿈
	$("#rtu_all").click(function(){
		var sensor_type = $("#sensor_change").val();
		if(sensor_type == -1){
			var tmp_cnt = $("#rtu_table input:not(:checked)").length;
			if(tmp_cnt == 0){
				$("#rtu_table input").prop("checked", false);
			}else{
				$("#rtu_table input").prop("checked", true);
			}
		}else{
			var tmp_cnt = $("tbody .sensor_"+sensor_type+" input:not(:checked)").length;
			if(tmp_cnt == 0){
				$("tbody .sensor_"+sensor_type+" input").prop("checked", false);
			}else{
				$("tbody .sensor_"+sensor_type+" input").prop("checked", true);
			}
		}
	});

	//장비별 SMS 자동 발송 설정 - 단계별 전체 선택
	$(".group_all").click(function(){
		var sensor_type = $("#sensor_change").val();
		var step = "SMS_SEND_GROUP" + $(this).attr("id").substring(0,1);
		if(sensor_type == -1){
			var tmp_cnt1 = $("#rtu_table #"+step).length;
			var tmp_cnt2 = $("#rtu_table #"+step+":checked").length;
			if(tmp_cnt1 == tmp_cnt2){
				$("#rtu_table #"+step).prop("checked", false);
			}else{
				$("#rtu_table #"+step).prop("checked", true);
			}
		}else{
			var tmp_cnt1 = $("tbody .sensor_"+sensor_type+" #"+step).length;
			var tmp_cnt2 = $("tbody .sensor_"+sensor_type+" #"+step+":checked").length;
			if(tmp_cnt1 == tmp_cnt2){
				$("tbody .sensor_"+sensor_type+" #"+step).prop("checked", false);
			
			}else{
				$("tbody .sensor_"+sensor_type+" #"+step).prop("checked", true);
			}
		}
	});

	// 장비별 SMS 자동 발송 설정 장비 이름 클릭 시 모든 단계 선택
	$("#rtu_table tbody #rtu_name").click(function(){
		var tmp_id = $(this).closest("tr")[0].id;
		var tmp_cnt1 = $("#"+tmp_id+" input").length;
		var tmp_cnt2 = $("#"+tmp_id+" input:checked").length;
		if(tmp_cnt1 == tmp_cnt2){
			$("#"+tmp_id+" input").prop("checked", false);
		}else{
			$("#"+tmp_id+" input").prop("checked", true);
		}
	});
	
	// 파일 선택
	$("#btn_file").click(function(){
		$("#EXCEL_SEL").trigger("click");
	});
	$("#EXCEL_SEL").change(function(){
		$("#EXCEL_STR").val(this.value);
	});


		/***************엑셀 등록 ***************/
		var uploadFile = $('.fileBox .uploadBtn');
			uploadFile.on('change', function(){
				swal({
						title: '<div class="alpop_top_b">엑셀 등록 확인</div><div class="alpop_mes_b">엑셀을 정말로 등록하실 겁니까?</div>',
						text: '확인 시 엑셀이 등록 됩니다.',
						showCancelButton: true,
						confirmButtonColor: '#5b7fda',
						confirmButtonText: '확인',
						cancelButtonText: '취소',
						closeOnConfirm: false,
						html: true
					}, function(isConfirm){
						if(isConfirm){
							var form = jQuery("#ajaxFrom")[0];
							var formData = new FormData(form);
							//formData.append("message", "ajax로 파일 전송하기");
							formData.append("file", jQuery("#uploadBtn")[0].files[0]);
							formData.append("mode", "excell_sms_in");

							jQuery.ajax({
								url : "../_info/json/_set_json.php",
								type : "POST",
								processData : false,
								contentType : false,
								data : formData,
								success:function(json) {
									location.reload(); return false;
								}
							});
						}
					}); // swal end

			});

	// // 엑셀등록
	// $("#btn_excel").click(function(){
	// 	var exResult = "true";
	// 	if( !$("#EXCEL_SEL").val() ){
	// 		swal("체크", "엑셀 파일을 선택해 주세요.", "warning"); return false;
	// 	}else{
	// 		$("#mode").val("sms_user_ex");
    //     	$("#sms_frm").ajaxForm({
    //     		url: "../_info/json/_sms_json.php",
    //     		enctype: "multipart/form-data",
	// 	        dataType: "json",
    //             success: function(response, status){
    //                 if(response.result){
    //                 	popup_main_close(); // 레이어 좌측 및 상단 닫기
	// 		    		location.reload(); return false;
    //                 }else{
    //                     if(response.msg){
    //                 		swal("체크", response.msg, "warning");
    //                     }else{
    //                 		swal("체크", "엑셀 등록 중 오류가 발생 했습니다.", "warning");
    //                     }
    //                 }
    //             },
    //             error: function(e){
	// 				swal("체크", "엑셀 등록 중 오류가 발생 했습니다.", "warning");
	// 				// 실패시 ajaxFormUnbind 실행시켜 submit 실행되지 않도록 함.
	// 				$("#sms_frm").ajaxFormUnbind();
    //             }                               
	// 		}).submit();
	// 	}
	// });	

	// 샘플양식받기
	$("#btn_sample").click(function(){
		sms_iframe.location.href = "../_files/sample/sms_people_sample.xls";
	});

	// 등록
	$("#btn_in").click(function(){
		if( sms_check("I") ){
			swal({
				title: '<div class="alpop_top_b">수신자 등록 확인</div><div class="alpop_mes_b">수신자를 등록하실 겁니까?</div>',
				text: '확인 시 수신자가 등록 됩니다.',
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
					sms_ready(); // 폼 준비
					
					$("#mode").val("sms_user_in");
					var param = $("#sms_frm").serialize()+"&"+$("#rtu_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
		                    if(data.result){
		                    	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
		                    }else{
		                        if(data.msg){
		                    		swal("체크", data.msg, "warning");
		                        }else{
								    swal("체크", "수신자 등록중 오류가 발생 했습니다.", "warning");
		                        }
								doubleSubmitFlag = false;
		                    }
				        }
				    });	
				}
			}); // swal end
		}
	});	

	// 수정
	$("#btn_up").click(function(){
		if( sms_check("U") ){
			swal({
				title: '<div class="alpop_top_b">수신자 수정 확인</div><div class="alpop_mes_b">수신자를 수정하실 겁니까?</div>',
				text: '확인 시 수신자가 수정 됩니다.',
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
					sms_ready(); // 폼 준비
					
					$("#mode").val("sms_user_up");
					var param = $("#sms_frm").serialize()+"&"+$("#rtu_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
		                    if(data.result){
		                    	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
		                    }else{
		                        if(data.msg){
		                    		swal("체크", data.msg, "warning");
		                        }else{
								    swal("체크", "수신자 수정중 오류가 발생 했습니다.", "warning");
		                        }
								doubleSubmitFlag = false;
		                    }
				        }
				    });	
				}
			}); // swal end
		}
	});	

	// 삭제
	$("#btn_de").click(function(){
		if( sms_check("D") ){
			swal({
				title: '<div class="alpop_top_b">수신자 삭제 확인</div><div class="alpop_mes_b">수신자를 삭제하실 겁니까?</div>',
				text: '확인 시 수신자가 삭제 됩니다.',
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
					$("#mode").val("sms_user_de");
					var param = $("#sms_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sms_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "수신자 삭제중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});	

	// 조회
	$("#btn_search").click(function(){
		if( !$("#search_text").val() ){
			swal("체크", "검색어를 입력해 주세요.", "warning");
			$("#search_text").focus(); return false;
		}else{
			$("#sms_frm").submit();
		}
	});	

	// 전체목록
	$("#btn_all").click(function(){
		$("#search_text").val("");
		$("#sms_frm").submit();
	});	
	
	// 수신자 선택
	$("#user_table ul").click(function(){
		sms_reset(); // 폼 초기화
		bg_color("selected", "#user_table ul", this); // 리스트 선택 시 배경색

		var IDX = $(this).data("id");
		var param = "mode=sms_user_view&IDX="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sms_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
				if(data.user){
					$.each(data.user, function(i, v){
						var mob = v.MOBILE.replace(/[-]/g, "");
						var mob1 = mob.substring(0, 3);
						if(mob.length == 10){
							var mob2 = mob.substring(3, 6);
							var mob3 = mob.substring(6, 10);
						}else if(mob.length == 11){
							var mob2 = mob.substring(3, 7);
							var mob3 = mob.substring(7, 11);
						}
						$("#IDX").val(v.IDX);
						$("#OLD_MOBILE").val(mob);
		        		$("#USER_NAME").val(v.USER_NAME);
		        		$("#MOBILE1").val(mob1);
		        		$("#MOBILE2").val(mob2);
		        		$("#MOBILE3").val(mob3);
		        		$("#MEMO").val(v.MEMO);
		        		$("#SMS_GROUP_ID").val(v.SMS_GROUP_ID);
		            }); 
			        if(data.equip){
						$.each(data.equip, function(i, v){
		        			$("#rtu_"+v.RTU_ID+"_"+v.SENSOR_TYPE+" #SENSOR_TYPE").val(v.SENSOR_TYPE);
							$("#rtu_"+v.RTU_ID+"_"+v.SENSOR_TYPE+" #SMS_SEND_GROUP"+v.SMS_SEND_GROUP).prop("checked", true);
			            }); 
			        }
		        }else{
				    swal("체크", "수신자 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });	
	});	

	// 폼 준비 (장비별 SMS 자동 발송 설정) 
	function sms_ready(){
		var rtu_id = "";
		var sensor_type = "";
		var sms_send_group = "";
		
		$.each($("#rtu_table tbody tr"), function(i, v){
			var tmp_cnt = 0;
			$.each($("#"+v.id+" input"), function(i2, v2){
				if( $(v2).prop("checked") ){
					if(sms_send_group != ""){
						if(tmp_cnt == 0) sms_send_group += "|";
					}
					if(tmp_cnt != 0) sms_send_group += ",";
					sms_send_group += v2.value;
					tmp_cnt++;
				}
			});
			// rtu_id , sensor_type
			if(tmp_cnt != 0){
				var tmpArray = "";
				var tmpStr = $(v).data("id");
				tmpArray = tmpStr.split("|");
				if(rtu_id == ""){
					rtu_id += tmpArray[0];
					sensor_type += tmpArray[1];
				}else{
					rtu_id += "|"+tmpArray[0];
					sensor_type += "|"+tmpArray[1];
				}
			}
		});
		// alert(sensor_type);
		$("#RTU_ID").val(rtu_id);
		$("#SENSOR_TYPE").val(sensor_type);
		$("#SMS_SEND_GROUP").val(sms_send_group);
	}
	
	// 폼 초기화
	function sms_reset(){
		$("#IDX").val("");
		$("#OLD_MOBILE").val("");
		$("#USER_NAME").val("");
		$("#MOBILE1").val("010");
		$("#MOBILE2").val("");
		$("#MOBILE3").val("");
		$("#MEMO").val("");
		$("#SMS_GROUP_ID option:eq(0)").prop("selected", true);
		$("#RTU_ID").val("");
		$("#SMS_SEND_GROUP").val("");
		$("#rtu_table input").prop("checked", false);
	}
	
	// 폼 체크
	function sms_check(kind){
		var check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/;
		var mobile = $("#MOBILE1").val()+$("#MOBILE2").val()+$("#MOBILE3").val();
		
		if(kind == "I"){
			if( !$("#USER_NAME").val() ){
				swal("체크", "이름을 입력해 주세요.", "warning");
				$("#USER_NAME").focus(); return false;
			}else if( !check.test(mobile) ){
			    swal("체크", "휴대폰 번호를 제대로 입력해 주세요.", "warning"); return false;	
			}
		}else if( kind == "U" || kind == "D" ){
			if( !$("#IDX").val() ){
				swal("체크", "수신자를 선택해 주세요.", "warning"); return false;
			}else if( !$("#USER_NAME").val() ){
				swal("체크", "이름을 입력해 주세요.", "warning");
				$("#USER_NAME").focus(); return false;
			}else if( !check.test(mobile) ){
			    swal("체크", "휴대폰 번호를 제대로 입력해 주세요.", "warning"); return false;	
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#SECTION_NO_SEARCH").val(1);
	$("#search_text").val("");
	sms_reset();
});
</script>

</body>
</html>
		
		
		