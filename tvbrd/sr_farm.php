
<div class="slider_top">
	<div class="slider_title">
		<img src="img/icon_altitle.png" class="mR10 fL mT3" /><span id="title_name"></span>
	</div>
	<div class="slider_type">농가</div>

	<div class="slider_close">
		<a class="btn_close" href="#"><img src="img/btn_close_off.png" alt="닫기" /></a>
	</div>
	<a id="btn_farm_detail" href="" target="_blink">
		<div class="text_btn2 btn_lbb80 fR m_12">
			<span>자세히보기</span>
		</div>
	</a>
</div>

<div class="tb_wrapper">
<ul class="tb_cow">
		<li class="tb_cow_r sidr-class-mT10">
			<div class="cow-btm1">
				<ul>
					<li class="alarm_gry_b" style="color: #2c55aa;">축산농가 정보 		</li>
				</ul>
			</div>
		</li>
		<table class="tg-1px" id="sidr-id-graph_table">
		<tbody id="sidr-id-graph_tbody">
		<input type="hidden" id="FARM_ID" name="FARM_ID">
			<tr>	<td class="tg-1px-title">사업장 명칭</td>	<td id="BUSINESS_NAME" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">주 사육 업종</td>	<td id="ANIMAL_KIND" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">권리주체명</td>	<td id="COPR_NAME" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">권리주체 등록번호</td>	<td id="COPR_NUM" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">권리주체 소재지</td>	<td id="COPR_ADDRESS" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">사업장 소재지</td>	<td id="BUSINESS_ADDRESS1" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">사육두수</td>	<td id="ANIMAL_COUNT" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">행정동명</td>	<td id="AREA_CODE" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">영업상태구분</td>	<td id="BUSINESS_STATE" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">연락처</td>	<td id="SMART_MOBILE" class="gbg-farm name Lh63"></td></tr>
			<tr>	<td class="tg-1px-title">질병여부</td>	<td id="DISEASE_STATE" class="gbg-farm name Lh63"></td></tr>
			</tbody>
		</table>
	</ul>

	<ul class="tb_cow">
		<form id="set_frm2" action="" method="get">
		<input id="FARM_ID" name="FARM_ID" type="hidden">
		<input id="DISEASE_ID" name="DISEASE_ID" type="hidden">
		<input id="KIND" name="KIND" type="hidden">
		<input id="POSTTYPE" name="POSTTYPE" type="hidden">
		<input id="IDX" name="IDX" type="hidden">

		<div class="tb-cow_br"></div>
		<form id="set_frm2" action="" method="get">

	<!-- <input type="text" id="SELECT" name="SELECT">선택 _ID -->
	<div class="popup_top" style="background: rgb(144, 94, 79);">

		<input id="FARM_ID" name="FARM_ID" type="hidden">
		<input id="DISEASE_ID" name="DISEASE_ID" type="hidden">
		<input id="KIND" name="KIND" type="hidden">
	</div>
	<div class="popup_con">
		<div class="farm" style="border-top: 3px solid
		 rgb(144, 94, 79); border-bottom: 3px solid rgb(144, 94, 79);">
			<ul>
				<li class="farm_gry">발생 동물 선택 <span class="unit" style="position:relative; left:170px; color:gray;"></span> 
					<!-- <button type="button" id="btn_all" class="btn_bs60">수정</button> --> 
					
				</li>
				<div class="popup_img">
    <p><img id="farm_cow_6" src="img/icon_farm_04.png"><img id="farm_chicken_6" src="img/icon_farm_05.png"></p>
		</div>
		<table class="tb-1px" id="sidr-id-sidr-id-graph_table">
		<tbody id="sidr-id-sidr-id-graph_tbody">
		<input type="hidden" id="FARM_ID" name="FARM_ID" value="4">
			
			
			<tr><td class="tb-1px-title">발생 질병 선택</td>	<td id="COPR_NAME" class="gbg-farm name Lh63">
<button type="button" id="btn_in" class="btn_bbb80">발병</button>
										<button type="button" id="btn_re" class="btn_wbb80">해제</button>
					
</td></tr>
			<tr>	
				<td class="tg-1px-title">질병명</td>	
			<td id="COPR_NUM" class="gbg-farm name Lh63">
<select id="ANIMAL_TYPE" name="ANIMAL_TYPE" class="ANIMAL_TYPE" style="width:165px;"></select>
</td></tr>
			
			<tr>	<td class="tg-1px-title">질병시작시각</td>	<td id="ANIMAL_KIND" class="gbg-farm name Lh63">
						<input type="text" id="starttime" name="starttime" class="time" size="8">
						<input type="text" id="starttime_sub" name="starttime_sub" class="timesub" size="8" autocomplete="off">
						</td></tr><tr>	
							
						<td class="tg-1px-title">질병종료시각</td>	<td id="DISEASE_STATE" class="gbg-farm name Lh63">
						<input type="text" id="endtime" name="endtime" class="time" size="8" style="align:center;">
						<input type="text" id="endtime_sub" name="endtime_sub" class="timesub" size="8" autocomplete="off">
						<!-- <input type="checkbox" id="empty" name="empty" value="0">없음 --></td></tr>
			</tbody>
		</table>
				

    
		</div>
	</div>
	
	</form>
		

	</ul>
</div>



<iframe id="alert_iframe" name="alert_iframe" width="0" height="0"></iframe>

<script type="text/javascript">
	$(document).ready(function(){
	});
	</script>

