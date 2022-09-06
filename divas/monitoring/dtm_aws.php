<?
require_once "../_conf/_common.php";
require_once "../_info/_dtm_aws.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state"><div id="content">

	<div class="main_contitle">
	<div class="tit"><img src="../images/board_icon_aws.png"> <span>AWS자료</span></div>
			<!-- <img src="../images/title_04_01.png" alt="강우 자료"> -->
		</div>

		<div class="right_bg2">
		<ul id="search_box">
		<form id="form_search" action="dtm_aws.php" method="get">
			<li>
			<span class="tit">지역</span>
			<select id="area_code" name="area_code">
						<? 
						if($data_sel){
							foreach($data_sel as $key => $val){ 
						?>
							<option value="<?=$val['AREA_CODE']?>" <?if($area_code == $val['AREA_CODE']){echo "selected";}?>><?=$val['RTU_NAME']?></li>
						<? 
							}
						}else{
						?>
							<option value="">장비 없음</option>
						<?
						}
						?>	
					</select> 
				<span class="tit mL15">검색날짜</span>
                                <button type="button" id="btn_left" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
                                <input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="w100p" readonly>
                                <button type="button"  id="btn_right"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
                                <button type="button" id="btn_img" alt="달력보기" class="tb_btn_blue w45p"><i class="fa fa-calendar"></i></button>
			</li>
			</form>
			
			</ul>
			<!-- <ul class="stitle_box">
                 <li><?=$sdate?></li>
                 <li></li>
             </ul> -->
		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<div class="tb_data">
					<ul>
						<li class="li100">
							<table id="view_table" class="tb_data">
								<thead class="tb_data_tbg">
									<tr class="hh_aws">
										<th colspan="2" class="bL0">구분</th>
										<td>00</td>
										<td>01</td>
										<td>02</td>
										<td>03</td>
										<td>04</td>
										<td>05</td>
										<td>06</td>
										<td>07</td>
										<td>08</td>
										<td>09</td>
										<td>10</td>
										<td>11</td>
										<td>12</td>
										<td>13</td>
										<td>14</td>
										<td>15</td>
										<td>16</td>
										<td>17</td>
										<td>18</td>
										<td>19</td>
										<td>20</td>
										<td>21</td>
										<td>22</td>
										<td>23</td>
										<td class="mint_L" style="line-height: 19px;">누계／평균</td>
									</tr>
								</thead>
								<tbody>
									<tr class="hh_aws">
										<td colspan="2" class="blue_L_1">우량 (mm)</td>
									<? 
									if($data_list['RAIN']){
										foreach($data_list['RAIN'] as $key => $val){ 
									?>
										<td id="data" data-mode="rain" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['RAIN_SUM']?></td>
									</tr>
									<tr class="hh_aws">
										<td colspan="2" class="blue_L_1 line14">온도 (℃)</td>
									<? 
									if($data_list['TEMP']){
										foreach($data_list['TEMP'] as $key => $val){ 
									?>
										<td id="data" data-mode="temp" data-kind="TEMP" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['TEMP_AVR']?></td>
									</tr>
									<!-- <tr>
										<td class="blue_L_1">최고</td>
									<? 
									if($data_list['TEMP_MAX']){
										foreach($data_list['TEMP_MAX'] as $key => $val){ 
									?>
										<td id="data" data-mode="temp" data-kind="TEMP_MAX" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['TEMP_MAX_AVR']?></td>
									</tr>
									<tr>
										<td class="blue_L_1">최저</td>
									<? 
									if($data_list['TEMP_MIN']){
										foreach($data_list['TEMP_MIN'] as $key => $val){ 
									?>
										<td id="data" data-mode="temp" data-kind="TEMP_MIN" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['TEMP_MIN_AVR']?></td>
									</tr> -->
									<tr class="hh_aws"> 
										<td colspan="2" rowspan="2" class="blue_L_1 line14">풍향 / 풍속<br> (㎧)</td>
									<? 
									if($data_list['DEG']){
										foreach($data_list['DEG'] as $key => $val){ 
									?>
										<td id="data" data-mode="wind" data-kind="DEG" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['DEG_AVR']?></td>
									</tr>
									<tr class="hh_aws">
									<? 
									if($data_list['VEL']){
										foreach($data_list['VEL'] as $key => $val){ 
									?>
										<td id="data" data-mode="wind" data-kind="VEL" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['VEL_AVR']?></td>
									</tr>
									<!-- <tr>
										<td rowspan="2" class="blue_L_1">최고</td>
									<? 
									if($data_list['DEG_MAX']){
										foreach($data_list['DEG_MAX'] as $key => $val){ 
									?>
										<td id="data" data-mode="wind" data-kind="DEG_MAX" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['DEG_MAX_AVR']?></td>
									</tr>
									<tr>
									<? 
									if($data_list['VEL_MAX']){
										foreach($data_list['VEL_MAX'] as $key => $val){ 
									?>
										<td id="data" data-mode="wind" data-kind="VEL_MAX" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['VEL_MAX_AVR']?></td>
									</tr> -->
									<!-- <tr class="hh_aws"> 
										<td colspan="2" class="blue_L_1 line14">기압 (hPa)</td>
									<? 
									if($data_list['ATMO']){
										foreach($data_list['ATMO'] as $key => $val){ 
									?>
										<td id="data" data-mode="atmo" data-kind="ATMO" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['ATMO_AVR']?></td>
									</tr>
									<tr>
										<td class="blue_L_1">최고</td>
									<? 
									if($data_list['ATMO_MAX']){
										foreach($data_list['ATMO_MAX'] as $key => $val){ 
									?>
										<td id="data" data-mode="atmo" data-kind="ATMO_MAX" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['ATMO_MAX_AVR']?></td>
									</tr>
									<tr>
										<td class="blue_L_1">최저</td>
									<? 
									if($data_list['ATMO_MIN']){
										foreach($data_list['ATMO_MIN'] as $key => $val){ 
									?>
										<td id="data" data-mode="atmo" data-kind="ATMO_MIN" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['ATMO_MIN_AVR']?></td>
									</tr> -->
									<tr class="hh_aws">
										<td colspan="2" class="blue_L_1 line14">습도 (%)</td>
									<? 
									if($data_list['HUMI']){
										foreach($data_list['HUMI'] as $key => $val){ 
									?>
										<td id="data" data-mode="humi" data-kind="HUMI" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['HUMI_AVR']?></td>
									</tr>
									<!-- <tr>
										<td class="blue_L_1">최고</td>
									<? 
									if($data_list['HUMI_MAX']){
										foreach($data_list['HUMI_MAX'] as $key => $val){ 
									?>
										<td id="data" data-mode="humi" data-kind="HUMI_MAX" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['HUMI_MAX_AVR']?></td>
									</tr>
									<tr>
										<td class="blue_L_1">최저</td>
									<? 
									if($data_list['HUMI_MIN']){
										foreach($data_list['HUMI_MIN'] as $key => $val){ 
									?>
										<td id="data" data-mode="humi" data-kind="HUMI_MIN" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['HUMI_MIN_AVR']?></td>
									</tr> -->
									<!-- <tr class="hh">
										<td colspan="2" class="blue_L_1">일사 (MJ/m2)</td>
									<? 
									if($data_list['RADI']){
										foreach($data_list['RADI'] as $key => $val){ 
									?>
										<td id="data" data-mode="radi" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['RADI_AVR']?></td>
									</tr>
									<tr class="hh">
										<td colspan="2" class="blue_L_1"> 일조(hr)</td>
									<? 
									if($data_list['SUNS']){
										foreach($data_list['SUNS'] as $key => $val){ 
									?>
										<td id="data" data-mode="suns" data-hour="<?=$key?>"><?=$val?></td>
									<? 
										}
									}
									?>	
										<td class="mint_L"><?=$data_list['SUNS_AVR']?></td>
									</tr> -->
								</tbody>
							</table>
						</li>
					</ul>

				</div>
			</li>

		</ul>

		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout_e">
	<div class="popup_top"><span id="sel_top"></span>
		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
	</div>
	<div class="popup_con_2">
		<form id="dtm_frm" name="dtm_frm" method="post">
			<input type="hidden" id="mode" name="mode" value="">
			<input type="hidden" id="p_area_code" name="area_code">
			<input type="hidden" id="p_sdate" name="sdate">
			<input type="hidden" id="p_hour" name="hour">
			<div class="pop_stitle">
				수정 일시 : <span id="sel_date"></span>
			</div>
            <table class="tb_data_p2 bL_1gry mT10 bg_gry3">
              <tr class="tb_data_tbg bT_1blue2">
                <th>00-09분</th>
                <th class="bL_1blue2">10-19분</th>
                <th class="bL_1blue2">20-29분</th>
                <th class="bL_1blue2">30-39분</th>
                <th class="bL_1blue2">40-49분</th>
                <th class="bL_1blue2">50-59분</th>
              </tr>
              <tr id="input">
                <td><input type="text" id="min_1" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_2" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_3" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_4" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_5" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_6" name="min[]" class="f333_12 al_c" oninput="inputCheck(this,'onlyNumber','0~9999')"></td>
              </tr>
              <tr id="select">
              	<? for($i=1; $i<=6; $i++){ ?>
                <td>
                	<select id="min_s_<?=$i?>" name="min[]" style="width: 63px;">
                		<option value="-">-</option>
                		<option value="0">북</option>
                		<option value="1">북북동</option>
                		<option value="2">북동</option>
                		<option value="3">동북동</option>
                		<option value="4">동</option>
                		<option value="5">동남동</option>
                		<option value="6">남동</option>
                		<option value="7">남남동</option>
                		<option value="8">남</option>
                		<option value="9">남남서</option>
                		<option value="10">남서</option>
                		<option value="11">서남서</option>
                		<option value="12">서</option>
                		<option value="13">서북서</option>
                		<option value="14">북서</option>
                		<option value="15">북북서</option>
                	</select>
                </td>
                <? } ?>
              </tr>
            </table>
			<div class="w100 fL mT10 al_C">
				<button type="button" id="btn_save" class="btn_bb80">저장</button>
            </div>
            <div id="spin"></div>
		</form>	
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 지역 선택
	$("#area_code").change(function(){
        $("#form_search").submit();
	});
	
	// 달력 호출
	datepicker(2, "#sdate", null, "yy-mm-dd", "#form_search");

	// 좌측 버튼
	$("#btn_left").click(function(){
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() - 1);

		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        $("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
        $("#form_search").submit();
	});
	
	// 우측 버튼
	$("#btn_right").click(function(){
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() + 1);

		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        $("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
        $("#form_search").submit();
	});

	// 텍스트
	$("#sdate").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	});
	
	// 달력 버튼
	$("#btn_img").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	});
	
	// 검색 버튼
	$("#btn_search").click(function(){
		$("#form_search").submit();
	});

	// 자료 보기
	$("#view_table #data").click(function(){
		bg_color("selected", "#view_table tbody tr", $(this).closest("tr"));
		popup_open(); // 레이어 팝업 열기
		
		var mode = $(this).data("mode");
		var kind = $(this).data("kind");
		var hour = $(this).data("hour");
		var name = $("#area_code option:checked").text();
		var mode_val = "";
		var mode_text = "";
		if(mode == "rain"){
			mode_val = "rain_save";
			mode_text = "강우 자료 수정";
			
			$("#min_1").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_2").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_3").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_4").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_5").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_6").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");

		}else if(mode == "temp"){
			if(kind == "TEMP"){
				mode_val = "temp_save";
				mode_text = "온도 자료 수정";
			}else if(kind == "TEMP_MAX"){
				mode_val = "temp_max_save";
				mode_text = "온도(최고) 자료 수정";
			}else if(kind == "TEMP_MIN"){
				mode_val = "temp_min_save";
				mode_text = "온도(최저) 자료 수정";
			}

			$("#min_1").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");
			$("#min_2").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");
			$("#min_3").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");
			$("#min_4").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");
			$("#min_5").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");
			$("#min_6").attr('oninput', "inputCheck(this,'onlyNumber','-100~100')");

		}else if(mode == "wind"){
			if(kind == "VEL"){
				mode_val = "vel_save";
				mode_text = "풍속 자료 수정";
				
				$("#min_1").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				$("#min_2").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				$("#min_3").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				$("#min_4").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				$("#min_5").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				$("#min_6").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
				
			}else if(kind == "VEL_MAX"){
				mode_val = "vel_max_save";
				mode_text = "풍속(최고) 자료 수정";
			}else if(kind == "DEG"){
				mode_val = "deg_save";
				mode_text = "풍향 자료 수정";
				
				$("#min_1").attr('oninput', "");
				$("#min_2").attr('oninput', "");
				$("#min_3").attr('oninput', "");
				$("#min_4").attr('oninput', "");
				$("#min_5").attr('oninput', "");
				$("#min_6").attr('oninput', "");
				
			}else if(kind == "DEG_MAX"){
				mode_val = "deg_max_save";
				mode_text = "풍향(최고) 자료 수정";
			}

		}else if(mode == "atmo"){
			if(kind == "ATMO"){
				mode_val = "atmo_save";
				mode_text = "기압 자료 수정";
			}else if(kind == "ATMO_MAX"){
				mode_val = "atmo_max_save";
				mode_text = "기압(최고) 자료 수정";
			}else if(kind == "ATMO_MIN"){
				mode_val = "atmo_min_save";
				mode_text = "기압(최저) 자료 수정";
			}
			
			$("#min_1").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_2").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_3").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_4").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_5").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			$("#min_6").attr('oninput', "inputCheck(this,'onlyNumber','0~9999')");
			
		}else if(mode == "humi"){
			if(kind == "HUMI"){
				mode_val = "humi_save";
				mode_text = "습도 자료 수정";
			}else if(kind == "HUMI_MAX"){
				mode_val = "humi_max_save";
				mode_text = "습도(최고) 자료 수정";
			}else if(kind == "HUMI_MIN"){
				mode_val = "humi_min_save";
				mode_text = "습도(최저) 자료 수정";
			}
			
			$("#min_1").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
			$("#min_2").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
			$("#min_3").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
			$("#min_4").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
			$("#min_5").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");
			$("#min_6").attr('oninput', "inputCheck(this,'onlyNumber','0~100')");

		}else if(mode == "radi"){
			mode_val = "radi_save";
			mode_text = "일사 자료 수정";
		}else if(mode == "suns"){
			mode_val = "suns_save";
			mode_text = "일조 자료 수정";
		}

		if(kind == "DEG" || kind == "DEG_MAX"){
			$("#select").show();
			$("#select select").prop("disabled", false);
			$("#input").hide();
			$("#input input").prop("disabled", true);
		}else{
			$("#input").show();
			$("#input input").prop("disabled", false);
			$("#select").hide();
			$("#select select").prop("disabled", true);
		}

		$("#mode").val(mode_val);
		$("#sel_top").text(name + " - " + mode_text);
		$("#sel_text").text("수정");

		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_dtm_json.php",
		    data: { "mode" : mode, "kind" : kind, "area_code" : "<?=$area_code?>", "sdate" : "<?=$sdate?>", "hour" : hour },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
			        $("#p_area_code").val("<?=$area_code?>");
			        $("#p_sdate").val("<?=$sdate?>");
			        $("#p_hour").val(hour);
					$("#sel_date").text(data.list['DATE']+" "+data.list['HOUR']+"시");
					if(kind == "DEG" || kind == "DEG_MAX"){
						$("#min_s_1").val( getStringNum(data.list['MIN'][0]) );
						$("#min_s_2").val( getStringNum(data.list['MIN'][1]) );
						$("#min_s_3").val( getStringNum(data.list['MIN'][2]) );
						$("#min_s_4").val( getStringNum(data.list['MIN'][3]) );
						$("#min_s_5").val( getStringNum(data.list['MIN'][4]) );
						$("#min_s_6").val( getStringNum(data.list['MIN'][5]) );
					}else{
						$("#min_1").val(data.list['MIN'][0]);
						$("#min_2").val(data.list['MIN'][1]);
						$("#min_3").val(data.list['MIN'][2]);
						$("#min_4").val(data.list['MIN'][3]);
						$("#min_5").val(data.list['MIN'][4]);
						$("#min_6").val(data.list['MIN'][5]);
					}
		        }
	        },
	        beforeSend : function(data){ 
	   			tmp_spin = spin_start("#dtm_frm #spin", "-40px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#dtm_frm #spin");
	        	}
	        }
        });
	});

	// 자료 수정
	$("#btn_save").click(function(){
		// console.log($("#mode").val());
		var tmp_spin = null;
		// let check = [];

		// // 풍향이 아닐때만 숫자, 음수 체크
		// if($("#mode").val() == 'deg_save'){
		// 	var param = $("#dtm_frm").serialize();
		// 	$.ajax({
		// 		type: "POST",
		// 		url: "../_info/json/_dtm_json.php",
		// 		data: param,
		// 		cache: false,
		// 		dataType: "json",
		// 		success : function(data){
		// 			if(data.result){
		// 				popup_main_close(); // 레이어 좌측 및 상단 닫기
		// 				location.reload(); return false;
		// 			}else{
		// 				swal("체크", "자료 수정중 오류가 발생 했습니다.", "warning");
		// 			}
		// 		},
		// 		beforeSend : function(data){ 
		// 			   tmp_spin = spin_start("#dtm_frm #spin", "-40px");
		// 		},
		// 		complete : function(data){ 
		// 			if(tmp_spin){
		// 				spin_stop(tmp_spin, "#dtm_frm #spin");
		// 			}
		// 		}
		// 	});
		// }else{
		// 	// 숫자, 음수 체크
		// 	$('.tb_data_p2 .f333_12').each(function(idx){    
		// 		var value = $(this).val();
		// 		if($.isNumeric(value)){
		// 			if($("#mode").val() == 'temp_save') check[idx] = 1; // 온도 타입일때
		// 			else check[idx] = value >= 0 ? 1 : 2;		// 온도 타입 아닐때
		// 		}else{
		// 			check[idx] = 0;
		// 		}
		// 	  });
		// 	console.log(check);
		// 	if(check.indexOf(0) != -1){
		// 		let eq = check.indexOf(0);
		// 		swal("체크", "숫자만 입력해 주세요!", "warning");
		// 		// $(".tb_data_p2 .f333_12").eq(eq).focus();
		// 	}else if(check.indexOf(2) != -1){
		// 		let eq = check.indexOf(2);
		// 		swal("체크", "양수로 입력해 주세요!", "warning");
		// 		// $(".tb_data_p2 .f333_12").eq(eq).focus();
		// 	}else{
				var param = $("#dtm_frm").serialize();
				$.ajax({
					type: "POST",
					url: "../_info/json/_dtm_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.result){
							popup_main_close(); // 레이어 좌측 및 상단 닫기
							location.reload(); return false;
						}else{
							swal("체크", "자료 수정중 오류가 발생 했습니다.", "warning");
						}
					},
					beforeSend : function(data){ 
						   tmp_spin = spin_start("#dtm_frm #spin", "-40px");
					},
					complete : function(data){ 
						if(tmp_spin){
							spin_stop(tmp_spin, "#dtm_frm #spin");
						}
					}
				});
			// }
		// }
	});

	// 풍향 변환
	function getStringNum(str){
		switch(str){
			case "북":		dispDeg = 0;		break;
			case "북북동":	dispDeg = 1;		break;
			case "북동":		dispDeg = 2;		break;
			case "동북동":	dispDeg = 3;		break;
			case "동":		dispDeg = 4;		break;
			case "동남동":	dispDeg = 5;		break;
			case "남동":		dispDeg = 6;		break;
			case "남남동":	dispDeg = 7;		break;
			case "남":		dispDeg = 8;		break;
			case "남남서":	dispDeg = 9;		break;
			case "남서":		dispDeg = 10;		break;
			case "서남서":	dispDeg = 11;		break;
			case "서":		dispDeg = 12;		break;
			case "서북서":	dispDeg = 13;		break;
			case "북서":		dispDeg = 14;		break;
			case "북북서":	dispDeg = 15;		break;
			default:		dispDeg = "-";		break;
		}
		return dispDeg;
	}

	// 뒤로가기 관련 처리
	$("#area_code").val("<?=$area_code?>");
	$("#sdate").val("<?=$sdate?>");
});
</script>

</body>
</html>


