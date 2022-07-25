<?
require_once "../_conf/_common.php";
require_once "../_info/_set_farm.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="set_frm" action="_set_farm.php" method="get">
		<input type="hidden" id="ALARM_GRP_NO" name="ALARM_GRP_NO"><!-- 선택한 경보그룹 번호 -->
		<input type="hidden" id="IN_RTU_ID" name="IN_RTU_ID"><!-- 추가할 장비 아이디 -->
		<input type="hidden" id="DE_RTU_ID" name="DE_RTU_ID"><!-- 삭제할 장비 아이디 -->
		<input type="hidden" id="SET_DISEASE" name="SET_DISEASE">
		<!-- <input type="hidden" id="IDX" name="IDX" value=""> -->
		<input type="hidden" id="DISEASE_IDX" name="DISEASE_IDX" value="">
		<input type="hidden" id="REG_TIME" name="REG_TIME" value="">
		<input type="hidden" id="END_TIME" name="END_TIME" value="">
		<input type="hidden" id="POSTTYPE" name="POSTTYPE" value="0">

		<div class="main_contitle">
			<img src="../images/title_06_16.png" alt="농가 질병 설정">
		</div>
		
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					농가 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">사업장명칭</option>
						<option value="1">질병명칭</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
				</span> 
				<!--
				<span class="sel_right_n top5px"> 
					※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다. 
				</span>
				-->
			</li>
			<li class="li100_nor d_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
					<tr>
										<th class="li10 hi25">번호</th>
										<th class="li20 hi25">사업장명칭</th>
										<th class="li10 hi25">사육종류</th>
										<th class="li20 hi25">감염질병</th>
					</tr>
					</thead>
					<tbody>
					<? 		
							$sdate = date("Y-m-d", time())." ".date("H:i:s", time());
							if($data_list2){
								foreach($data_list2 as $key => $val){ 
							?>
									<tr id="list_<?=$val['NUM']?>">
										<td id="l_ALARM_GRP_NO" class="li10 hi25"><?=$val['NUM']?></td>
										<td id="BUSINESS_NAME" class="li20 hi25"><?=$val['BUSINESS_NAME']?></td>
										<td class="li10 hi25"><?=($val['ANIMAL_KIND1'] == 0 ? "<img id='cow_".$val['NUM']."' src='../images/farm/cow_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 1 ? "<img id='pig_".$val['NUM']."' src='../images/farm/pig_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 2 ? "<img id='chicken_".$val['NUM']."' src='../images/farm/chicken_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 3 ? "<img id='pig_".$val['NUM']."' src='../images/farm/pig_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='../images/farm/chicken_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 4 ? "<img id='cow_".$val['NUM']."' src='../images/farm/cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='../images/farm/chicken_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 5 ? "<img id='cow_".$val['NUM']."' src='../images/farm/cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='pig_".$val['NUM']."' src='../images/farm/pig_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 6 ? "<img id='cow_".$val['NUM']."' src='../images/farm/cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='pig_".$val['NUM']."' src='../images/farm/pig_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='chicken_1.png' width='20' class='farm_animal'>" : "없음") ) ) ) ) ) ) 
										?></td>
										<td id="DISEASE_CHECK" class="li10 hi25">
										<span id="xtext_<?=$val['NUM']?>">X</span>
										<?
										if($data_FarmComInView){
											foreach($data_FarmComInView as $key => $val2){
										
										if($val['NUM'] == $val2['FARM_ID']){
											if($sdate < $val2['END_TIME']){
												if($val['ANIMAL_KIND1'] == 0){$kind = "0";}
												if($val['ANIMAL_KIND1'] == 1){$kind = "1";}
												if($val['ANIMAL_KIND1'] == 2){$kind = "2";}		
												if($val['ANIMAL_KIND1'] == 3){$kind = "1,2";}
												if($val['ANIMAL_KIND1'] == 4){$kind = "0,2";}
												if($val['ANIMAL_KIND1'] == 5){$kind = "0,1";}
												if($val['ANIMAL_KIND1'] == 6){$kind = "0,1,2";}

												if(strpos($kind,$val2['KIND']) !== false){
												$check = $check + count($val2['DISEASE_NAME']);
												if($check > 1){
													?>
													<script type="text/javascript">
													$("#xtext_<?=$val['NUM']?>").empty();
													$("#<?=($val2['KIND'] == 0 ? "cow_".$val['NUM'] : ($val2['KIND'] == 1 ? "pig_".$val['NUM'] : ($val2['KIND'] == 2 ? "chicken_".$val['NUM'] : "")));?>").attr("src", "../images/farm/<?=($val2['KIND'] == 0 ? "cow_2" : ($val2['KIND'] == 1 ? "pig_2" : ($val2['KIND'] == 2 ? "chicken_2" : "")));?>.png");
													</script>
													<?
												 echo "<span style='color:red'>, ".$val2['DISEASE_NAME']."</span>";
												}else{
													?>
													<script type="text/javascript">
													$("#xtext_<?=$val['NUM']?>").empty();
													$("#<?=($val2['KIND'] == 0 ? "cow_".$val['NUM'] : ($val2['KIND'] == 1 ? "pig_".$val['NUM'] : ($val2['KIND'] == 2 ? "chicken_".$val['NUM'] : "")));?>").attr("src", "../images/farm/<?=($val2['KIND'] == 0 ? "cow_2" : ($val2['KIND'] == 1 ? "pig_2" : ($val2['KIND'] == 2 ? "chicken_2" : "")));?>.png");
													</script>
													<?
												echo "<span style='color:red'>".$val2['DISEASE_NAME']."</span>";
												}

													}
												}
											}


									}
									$check = 0;
								}
										?>
										</td>
									</tr>
							<? 
								}
							}
							?>
					</tbody>
				</table>
			</li>
		</ul>
		</form>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->


<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout" style="width: 540px; height: 460px; left: 35%;display: none;">
	<form id="set_frm2" action="" method="get">

	<!-- <input type="text" id="SELECT" name="SELECT">선택 _ID -->
	<div class="popup_top" style="background: rgb(144, 94, 79);">농가 질병 상세설정
		<button id="popup_close" class="btn_lbs fR bold">X</button>
		<input id="FARM_ID" name="FARM_ID" type="hidden">
		<input id="DISEASE_ID" name="DISEASE_ID" type="hidden">
		<input id="KIND" name="KIND" type="hidden">
		<input id="IDX" name="IDX" type="hidden">
		
	</div>
	<div class="popup_con">
		<div class="farm" style="border-top: 3px solid
		 rgb(144, 94, 79); border-bottom: 3px solid rgb(144, 94, 79);">
			<ul>
				<li class="farm_gry">발생 동물 선택 <span class="unit" style="position:relative; left:130px; color:gray;">※ 항목을 클릭하면 질병상태를 등록/해제 할 수 있습니다.</span> 
					<!-- <button type="button" id="btn_all" class="btn_bs60">수정</button> --> 
					
				</li>
				<div class="popup_img">
    <p><img id="farm_cow_6" src="../images/farm/icon_farm_04.png"><img id="farm_chicken_6" src="../images/farm/icon_farm_05.png"></p>
</div>

				
				<div>
<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="top6px">발생 질병 선택</span> 
				<span class="sel_right_n">
										<button type="button" id="btn_in" class="btn_bb80">발병</button>
										<button type="button" id="btn_re" class="btn_lbb80_s">해제</button>
					
					
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tbody><tr>
					
						<td class="bg_lb bold al_C bL0 w20">질병명 </td>
						<td colspan="3">
							<select id="ANIMAL_TYPE" name="ANIMAL_TYPE" class="f333_12">
						</select>
						</td>
						

						
						
					</tr>
					<tr>
						
						<td class="bg_lb w10 bold al_C bL0">질병시작시각</td>
						<td>
						
						<input type="text" id="starttime" name="starttime" class="time" size="8">
						<input type="text" id="starttime_sub" name="starttime_sub" class="timesub" size="8" style="margin:0px 23px;">
						</td>
						
						
					</tr>

<tr>
<td class="bg_lb w10 bold al_C">질병종료시각</td>

						<td colspan="5">
						<input type="text" id="endtime" name="endtime" class="time" size="8">
						<input type="text" id="endtime_sub" name="endtime_sub" class="timesub" size="8" style="margin:0px 23px;" >
						<!-- <input type="checkbox" id="empty" name="empty" value="0">없음 -->
						</td>
    </tr>
						
				</tbody></table>
			</li>
		</ul>			

				</div>

			</ul>
    
		</div>
	</div>
	
	</form>
</div>


<script type="text/javascript">
$(document).ready(function(){

	/**** 팝업 레이아웃 변경 ****/
	
	/*
	$(".popup_layout").css("width","580px");
	$(".popup_layout").css("left","35%");
	$(".popup_top").css("background","#905e4f");
	$(".farm").css("border-top","3px solid #905e4f");
	$(".farm").css("border-bottom","3px solid #905e4f");
	*/
	
	/**** 캘린더 함수 호출 ****/
	datepicker(3, "#starttime", "../images/icon_cal_r.png", "yy-mm-dd");
	datepicker(3, "#endtime", "../images/icon_cal.png", "yy-mm-dd");

	/**** 캘린더 시간 선택 함수 호출 ****/
	$("#starttime_sub").timepicker({
		step: 5,            //시간간격 : 5분
		timeFormat: "H:i:s"    //시간:분 으로표시
		});
	$("#endtime_sub").timepicker({
		step: 5,            //시간간격 : 5분
		timeFormat: "H:i:s"    //시간:분 으로표시
		});	




			// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 사용자 ID
			search_col_id = "BUSINESS_NAME";
		}else if(search_col == "1"){ // 사용자명
			search_col_id = "DISEASE_CHECK";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});
	
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	

		$("#ANIMAL_TYPE").change(function(){
			if($("#ANIMAL_TYPE").val() !== 0){
				var sdate = getTimeStamp();
				$("#starttime").val(sdate.substr(0,10));
			}
		});




		/*********************************************************************************************
												팝업 삭제 버튼
		*********************************************************************************************/
		$("#btn_re").click(function(){
			//popup_close();
			var FARM_ID = $('#FARM_ID').val();
			var DISEASE_ID = $('#ANIMAL_TYPE').val();
			var CHECK_DISEASE = $('#DISEASE_ID').val();
			swal({
				title: '<div class="alpop_top_b">발생 질병 해제</div><div class="alpop_mes_b">정말로 질병을 해제하실 겁니까?</div>',
				text: '확인 시 질병이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=hist_empty_up&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID;
					$.ajax({
					type: "POST",
					url: "../_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
								location.reload(); return false;
					        }else{
							    swal("체크", "질병 해제 중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		});



		/*********************************************************************************************
												팝업 저장 버튼
		*********************************************************************************************/
		$("#btn_in").click(function(){
			var FARM_ID = $('#FARM_ID').val();
			var DISEASE_ID = $('#ANIMAL_TYPE').val();
			var CHECK_DISEASE = $('#DISEASE_ID').val();
			var POSTTYPE = $('#POSTTYPE').val();
			//console.log(DISEASE_ID);
						

			var param = "mode=data_check&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&POSTTYPE="+POSTTYPE+"&CHECK_DISEASE="+CHECK_DISEASE+"&"+$("#set_frm2").serialize();
			//console.log($("#set_frm").serialize());
					$.ajax({
					type: "POST",
					url: "../_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
							if(data.list['SUCCESS'] == 1){   // ( ★ 수정 ★ ) 이미 농가에 질병이 등록 되어 있을 경우

								swal({
									title: '<div class="alpop_top_b">발생 질병 수정</div><div class="alpop_mes_b">질병이 등록되어 있습니다.<br>수정 하시겠습니까?</div>',
									text: '확인 시 질병이 수정 됩니다.',
									showCancelButton: true,
									confirmButtonColor: '#5b7fda',
									confirmButtonText: '확인',
									cancelButtonText: '취소',
									closeOnConfirm: false,
									html: true
								}, function(isConfirm){
									if(isConfirm){					
										var param = "mode=hist_up&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&POSTTYPE="+POSTTYPE+"&CHECK_DISEASE="+CHECK_DISEASE+"&"+$("#set_frm2").serialize();
										$.ajax({
										type: "POST",
										url: "../_info/json/_set_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
												if(data.result){
													popup_main_close(); // 레이어 좌측 및 상단 닫기
													location.reload(); return false;
												}else{
													swal("체크", " 수정 중 오류가 발생 했습니다.", "warning");
												}
											}
										});	
									}
								}); // swal end
							}   // SUCCESS 1 체크 END
						
						 if(data.list['SUCCESS'] == 0){                           // ( ★ 등록 ★ ) 농가에 질병이 등록 되어 있지 않을 경우 

								swal({
									title: '<div class="alpop_top_b">발생 질병 등록</div><div class="alpop_mes_b">정말로 질병을 등록 하시겠습니까?</div>',
									text: '확인 시 질병이 등록 됩니다.',
									showCancelButton: true,
									confirmButtonColor: '#5b7fda',
									confirmButtonText: '확인',
									cancelButtonText: '취소',
									closeOnConfirm: false,
									html: true
								}, function(isConfirm){
									if(isConfirm){

										var param = "mode=hist_in&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&POSTTYPE="+POSTTYPE+"&CHECK_DISEASE="+CHECK_DISEASE+"&"+$("#set_frm2").serialize();
										
										$.ajax({
										type: "POST",
										url: "../_info/json/_set_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
												if(data.result){
													popup_main_close(); // 레이어 좌측 및 상단 닫기
													location.reload(); return false;
												}else{
													swal("체크", " 등록 중 오류가 발생 했습니다.", "warning");
												}
											}
										});	
									}
								}); // swal end
							} 	// SUCCESS 0 체크 END

							}});
			
		//}   // 미발생 체크 else 문 end 

		});







		/*********************************************************************************************
												목록 선택
		*********************************************************************************************/

		// 농가 질병 설정 페이지에서 농가 선택 했을 경우 // 팝업에서 동물 선택 시 설정창
		$("#list_table tbody tr").click(function(){

						$(".popup_img").empty();
						var day = new Date();
						var dd = day.getDate();
						//var afterdd = day.getDate()+7;
						var afterdd = '2099-12-31';
						var mm = day.getMonth()+1; //January is 0!
						var yyyy = day.getFullYear();
						var H = day.getHours();
						var M = day.getMinutes();
						var S = day.getSeconds();
						var SELECT = $("#"+this.id+" #l_ALARM_GRP_NO").text();
						//$("#SELECT").val(SELECT);
						var today = yyyy+"-"+mm+"-"+dd;
						var afterday = afterdd;

						var sdate = getTimeStamp();

						var tmpid = "";
						
						$("#ANIMAL_TYPE").val("");
						$("#DISEASE_NAME").val("");
						$("#starttime").val("");
						$("#starttime_sub").val("");
						$("#endtime").val("");
						$("#endtime_sub").val("");



						$("#ANIMAL_TYPE").change(function(){
						var ANIMAL_TYPE = $("#ANIMAL_TYPE").val();
						var param = "mode=change_check&DISEASE_ID="+ANIMAL_TYPE+"&FARM_ID="+SELECT;
						$.ajax({
							type: "POST",
							url: "../_info/json/_set_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
								if(data.list){
									$.each(data.list, function (index, v) {
											if(SELECT == v['FARM_ID']){
												if(ANIMAL_TYPE == v['DISEASE_IDX']){
													//console.log(1);
													//$("#IDX").val(v['IDX']);
													$("#starttime").val(v['START_TIME'].substring(0,10));
													$("#starttime_sub").val(v['START_TIME'].substring(11,19));
													$("#endtime").val(v['END_TIME'].substring(0,10));
													$("#endtime_sub").val(v['END_TIME'].substring(11,19));
												
													}
												}
										});
									}
								}});
						});						
								
						var param = "mode=farm_list";
						$.ajax({
							type: "POST",
							url: "../_info/json/_set_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
								if(data.list){
									$.each(data.list, function (index, v) {
										if(SELECT == v['NUM']){
											$(".popup_img").empty();

											(v['ANIMAL_KIND1'] == 0 ? tmp = "<p><img class='farm_img' id='farm_cow_"+ v['NUM'] +"' src='../images/farm/icon_farm_04.png'></p>" : 
											(v['ANIMAL_KIND1'] == 1 ? tmp = "<p><img class='farm_img' id='farm_pig_"+ v['NUM'] +"' src='../images/farm/icon_farm_06.png'></p>" : 
											(v['ANIMAL_KIND1'] == 2 ? tmp = "<p><img class='farm_img' id='farm_chicken_"+ v['NUM'] +"' src='../images/farm/icon_farm_05.png'></p>" : 
											(v['ANIMAL_KIND1'] == 3 ? tmp = "<p><img class='farm_img' id='farm_pig_"+ v['NUM'] +"' src='../images/farm/icon_farm_06.png'><img class='farm_img' id='farm_chicken_"+ v['NUM'] +"' src='../images/farm/icon_farm_05.png'></p>" : 
											(v['ANIMAL_KIND1'] == 4 ? tmp = "<p><img class='farm_img' id='farm_cow_"+ v['NUM'] +"' src='../images/farm/icon_farm_04.png'><img class='farm_img' id='farm_chicken_"+ v['NUM'] +"' src='../images/farm/icon_farm_05.png'></p>" : 
											(v['ANIMAL_KIND1'] == 5 ? tmp = "<p><img class='farm_img' id='farm_cow_"+ v['NUM'] +"' src='../images/farm/icon_farm_04.png'><img class='farm_img' id='farm_pig_"+ v['NUM'] +"' src='../images/farm/icon_farm_06.png'></p>" : 
											(v['ANIMAL_KIND1'] == 6 ? tmp = "<p><img class='farm_img' id='farm_cow_"+ v['NUM'] +"' src='../images/farm/icon_farm_04.png'><img class='farm_img' id='farm_pig_"+ v['NUM'] +"' src='../images/farm/icon_farm_06.png'><img class='farm_img' id='farm_chicken_"+ v['NUM'] +"' src='../images/farm/icon_farm_05.png'></p>" : "" )))))))
											$(".popup_img").append(tmp);
											

										
																
														var param2 = "mode=farm_disease_group";
														$.ajax({
															type: "POST",
															url: "../_info/json/_set_json.php",
															data: param2,
															cache: false,
															dataType: "json",
															success : function(data){

															$.each(data.list, function (index, e) {

																if(v['ANIMAL_KIND1'] == 0){kind = "0";}
																if(v['ANIMAL_KIND1'] == 1){kind = "1";}
																if(v['ANIMAL_KIND1'] == 2){kind = "2";}		
																if(v['ANIMAL_KIND1'] == 3){kind = "1,2";}
																if(v['ANIMAL_KIND1'] == 4){kind = "0,2";}
																if(v['ANIMAL_KIND1'] == 5){kind = "0,1";}
																if(v['ANIMAL_KIND1'] == 6){kind = "0,1,2";}

																	if(kind.indexOf(e['KIND']) !== false){
																		if(e['END_TIME'] > sdate){

																			(e['KIND'] == 0 ? kind="farm_cow_" : (e['KIND'] == 1 ?  kind="farm_pig_" : (e['KIND'] == 2 ? kind="farm_chicken_" : ""))); // 선택한 농가 동물종류
																			(e['KIND'] == 0 ? kind2="04" : (e['KIND'] == 1 ?  kind2="06" : (e['KIND'] == 2 ? kind2="05" : ""))); // 선택한 농가에 변경할 이미지 구분
																			$("#"+kind+e['FARM_ID']).attr('src','../images/farm/icon_farm_'+kind2+'_1.png'); // 이미지 변경
																		
																		}
																	}

													});  // disease each

												}});
											

											//function optionchange(){              
											$(".farm_img").click(function(){                       // 팝업창에서 동물 클릭 이벤트
											var gubun = $(this).attr('src');
											if(gubun.match("1")){                                   // 팝업창에서 발생한 아이콘 클릭시 뿌려줌
											var select = $(this).attr('id');
											
											/***************동물 선택 시 빨간 테두리 적용 **************/
											$(".farm_img").css('border','0px solid red');
											$(".farm_img").css('border-radius','0%');
											$("#ANIMAL_TYPE").css('width','300px');
											$(this).css('border','2px solid red');
											$(this).css('border-radius','5%');

											var farm_kind = "";
											if(select.match("cow")){farm_kind = 0;}
											if(select.match("pig")){farm_kind = 1;}
											if(select.match("chicken")){farm_kind = 2;}
											
											
											var param2 = "mode=farm_disease_group";
												$.ajax({
													type: "POST",
													url: "../_info/json/_set_json.php",
													data: param2,
													cache: false,
													dataType: "json",
													success : function(data){
													if(data.list !== null){
													$.each(data.list, function (index, x) {
														var tmp = "";
														if(x['FARM_ID'] == SELECT){
															if(x['KIND'] == farm_kind){
																if(x['END_TIME'] > sdate){
																	
																	var param3 = "mode=Diseasekind&kind="+farm_kind;
																	$.ajax({
																		type: "POST",
																		url: "../_info/json/_set_json.php",
																		data: param3,
																		cache: false,
																		dataType: "json",
																		success : function(data){
																		$.each(data.list, function (index, e) {	
																			
																			if(e['KIND'] == farm_kind){
																					if(e['END_TIME'] > sdate){																							
																							$("#ANIMAL_TYPE").empty();
																							tmp += '<option id="ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
																							//$("#ANIMAL_TYPE").html(tmp);
																					}
																				}
																	
																	$("#ANIMAL_TYPE").html(tmp);

																	//$("#ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
																	$("#ANIMAL_TYPE").val(x['DISEASE_IDX']).prop("selected", true);
																	$("#FARM_ID").val(SELECT);
																	$("#KIND").val(x['KIND']);
																	$("#DISEASE_ID").val(x['DISEASE_IDX']);
																	$("#starttime").val(x['START_TIME'].substring(0,10));
																	$("#starttime_sub").val(x['START_TIME'].substring(11,19));
																	$("#endtime").val(x['END_TIME'].substring(0,10));
																	$("#endtime_sub").val(x['END_TIME'].substring(11,19));
																	
																			});  // disease each
																		
																		}});
																		
																}
																
															}
														
														}
														});  // disease each

														}else{  // data.list null 체크

															var tmp = "";
															var param3 = "mode=Diseasekind&kind="+farm_kind;
																	$.ajax({
																		type: "POST",
																		url: "../_info/json/_set_json.php",
																		data: param3,
																		cache: false,
																		dataType: "json",
																		success : function(data){
																		$.each(data.list, function (index, e) {	
																			
																			if(e['KIND'] == farm_kind){
																					if(e['END_TIME'] > sdate){
																							$("#ANIMAL_TYPE").empty();
																							tmp += '<option id="ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
																							//$("#ANIMAL_TYPE").html(tmp);
																					}
																				}
																	
																	$("#ANIMAL_TYPE").html(tmp);
																	$("#FARM_ID").val(SELECT);
																	//$("#DISEASE_ID").val(e['DISEASE_IDX']);

																			});  // disease each
																		}});
														} 

													}});	
												
												} else{  // gubun if end   미발생 아이콘 선택시 팝업 설정창에 뿌려 줌

											var select = $(this).attr('id');
											var farm_kind = "";
										

											/***************동물 선택 시 빨간 테두리 적용 **************/
											$(".farm_img").css('border','0px solid red');
											$(".farm_img").css('border-radius','0%');
											$("#ANIMAL_TYPE").css('width','300px');
											$(this).css('border','2px solid red');
											$(this).css('border-radius','5%');

											if(select.match("cow")){farm_kind = 0;}
											if(select.match("pig")){farm_kind = 1;}
											if(select.match("chicken")){farm_kind = 2;}

											var param2 = "mode=farm_disease_group";
												$.ajax({
													type: "POST",
													url: "../_info/json/_set_json.php",
													data: param2,
													cache: false,
													dataType: "json",
													success : function(data){
													if(data.list !== null){
													$.each(data.list, function (index, x) {
														var tmp = "";
																	var param3 = "mode=Diseasekind&kind="+farm_kind;
																	$.ajax({
																		type: "POST",
																		url: "../_info/json/_set_json.php",
																		data: param3,
																		cache: false,
																		dataType: "json",
																		success : function(data){
																		$.each(data.list, function (index, e) {	
																			
																			if(e['KIND'] == farm_kind){
																					if(e['END_TIME'] > sdate){
																							$("#ANIMAL_TYPE").empty();
																							tmp += '<option id="ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
																							//$("#ANIMAL_TYPE").html(tmp);
																							
																					}
																				}
																	
																	$("#ANIMAL_TYPE").html(tmp);

																	$("#FARM_ID").val(SELECT);
																	$("#KIND").val(x['KIND']);
																	
																	$("#DISEASE_ID").val(e['DISEASE_IDX']);
																	$("#starttime").val(today);
																	$("#starttime_sub").val("00:00:00");
																	$("#endtime").val(afterday);
																	$("#endtime_sub").val("00:00:00");
																			});  // disease each
																		}});
														
														});  // disease each

														
													}else{  // data.list null 체크
														
														var tmp = "";
																	var param3 = "mode=Diseasekind&kind="+farm_kind;
																	$.ajax({
																		type: "POST",
																		url: "../_info/json/_set_json.php",
																		data: param3,
																		cache: false,
																		dataType: "json",
																		success : function(data){
																		$.each(data.list, function (index, e) {	
																			
																			if(e['KIND'] == farm_kind){
																					if(e['END_TIME'] > sdate){
																							$("#ANIMAL_TYPE").empty();
																							tmp += '<option id="ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
																							//$("#ANIMAL_TYPE").html(tmp);
																					}
																				}
																	
																	$("#ANIMAL_TYPE").html(tmp);

																	//$("#ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
																	//$("#ANIMAL_TYPE").val(0).prop("selected", true);
																	$("#FARM_ID").val(SELECT);
																	$("#DISEASE_ID").val(e['DISEASE_IDX']);
																	$("#starttime").val(today);
																	$("#starttime_sub").val("00:00:00");
																	$("#endtime").val(afterday);
																	$("#endtime_sub").val("00:00:00");

																			});  // disease each
																		}});
														} 
														
													}});
												}
													



												});
											//}  // function optionchange end
										}
									});

							
								}
							}
						});

						popup_open();
					
					});



	
	/*   시간 스탬프 함수   */
function getTimeStamp() {
		var d = new Date();
	  
		var s =
		  leadingZeros(d.getFullYear(), 4) + '-' +
		  leadingZeros(d.getMonth() + 1, 2) + '-' +
		  leadingZeros(d.getDate(), 2) + ' ' +
	  
		  leadingZeros(d.getHours(), 2) + ':' +
		  leadingZeros(d.getMinutes(), 2) + ':' +
		  leadingZeros(d.getSeconds(), 2);
	  
		return s;
	  }
	
	  function leadingZeros(n, digits) {
		var zero = '';
		n = n.toString();
	  
		if (n.length < digits) {
		  for (i = 0; i < digits - n.length; i++)
			zero += '0';
		}
		return zero + n;
	  }






	});

</script>
</body>
</html>


