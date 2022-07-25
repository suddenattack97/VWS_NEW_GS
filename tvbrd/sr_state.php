
<div class="slider_top">
	<div class="slider_title">
		<img src="img/icon_etitle.png" class="mR10 fL mT5" /><span id="title_name"></span>
	</div>
	<div class="slider_type">상태</div>
	<div class="slider_close">
		<a class="btn_close" href="#"><img src="img/btn_close_off.png" alt="닫기" /></a>
	</div>
	<a id="btn_state_detail" href="" target="_blink">
		<div class="text_btn2 btn_lbb80 fR m_12">
			<span>자세히보기</span>
		</div>
	</a>
</div>

<div class="tb_wrapper">
	<button type="button" id="btn_tab_state" class="btn_bb80 w50 mT10 fL">장비상태</button>
	<button type="button" id="btn_tab_as" class="btn_wbb w50 mT10 fL">A/S 접수 및 현황</button>
	<ul class="tb_equip">
		<li class="equip_st">
			<div class="alarm mT10">
				<ul>
					<li class="alarm_gry">장비 상태 <span class="fR w60"> 전압:V / 전류:A </span></li>
					<li class="p0">
						<table class="st_table">
							<tr>
								<td rowspan="2" scope="rowgroup" class="bbg" width="20%">전원</td>
								<td class="gbg" width="25%">상전(AC)</td>
								<td id="SANG" width="15%"></td>
								<td class="gbg" width="25%">전압</td>
								<td id="SOLA_VOLT"></td>
							</tr>
							<tr class="2px">
								<td class="gbg">태양전지(DC)</td>
								<td id="SUN"></td>
								<td class="gbg">충전전류</td>
								<td id="SOLA_AMPERE"></td>
							</tr>
							<tr>
								<td rowspan="2" scope="rowgroup" class="bbg">배터리</td>
								<td class="gbg">전압-18V이상</td>
								<td colspan="3" id="BATT_VOLT"></td>
							</tr>
							<tr class="2px">
								<td class="gbg">소비전류1</td>
								<td id="LOAD1_AMPERE"></td>
								<td class="gbg">소비전류2</td>
								<td id="LOAD2_AMPERE"></td>
							</tr>
							<tr>
								<td scope="rowgroup" class="bbg">메인엠프</td>
								<td class="gbg">상태</td>
								<td id="MAINAMP_STAT"></td>
								<td class="gbg">전원</td>
								<td id="AMP_POWER"></td>
							</tr>
							<tr>
								<td rowspan="4" scope="rowgroup" class="bbg">일반</td>
								<td class="gbg">로거</td>
								<td id="LOGGER_STAT"></td>
								<td class="gbg">도어</td>
								<td id="DOOR_STAT"></td>
							</tr>
							<tr>
								<td class="gbg">센서</td>
								<td id="SENSOR_STAT"></td>
								<td class="gbg">볼륨</td>
								<td id="AUDIO_VOLUME"></td>
							</tr>
							<tr>
								<td class="gbg">스피커</td>
								<td colspan="3" id="SPEAKER_SELECT"></td>
							</tr>
							<tr>
								<td class="gbg">최종로깅시각</td>
								<td colspan="3" id="LOG_DATE"></td>
							</tr>
						</table>
					</li>
				</ul>
			</div>
			<div class="alarm mT10">
				<ul>
					<li class="alarm_gry">장비 정보
					<span class="fR w60">
						<div class="file_input fR">
							<label id="btn_state_edit">정보 수정</label>
							<label id="btn_state_ok" class="dp0">수정 완료</label>
							<label id="btn_state_no" class="dp0">수정 취소</label>
						</div>
						<div class="file_input fR">
							<form id="state_img_frm" class="dp0">
							<input type="hidden" name="mode" value="state_img_up"> 
							<input type="hidden" id="kind" name="kind"> 
							<input type="hidden" id="area_code" name="area_code"> 
							<input type="hidden" id="type" name="type">
							<input type="text" id="view_state_img" name="state_img" readonly style="cursor: pointer;" placeholder="장비사진 업로드"> 
							<input type="file" id="sel_state_img" name="state_img2" class="dp0">
							</form>
						</div>	
					</span>
					</li>
					<li id="rtu_img" class="p0"></li>
					<li class="p0">
					<form id="state_frm" method="post">
						<input type="hidden" name="mode" value="state_text_up"> 
						<input type="hidden" id="kind" name="kind">
						<input type="hidden" id="area_code" name="area_code"> 
						<input type="hidden" id="type" name="type">
						<table class="equip_table">
							<tr>
								<th scope="row">장비명</th>
								<td colspan="3">
									<span id="v_rtu_name"></span>
								</td>
							</tr>
							<tr>
								<th scope="row">시설구분</th>
								<td colspan="3">
									<span id="v_classify"></span>
									<span id="classify" class="dp0"><input type="text" name="classify"></span>
								</td>
							</tr>
							<tr>
								<th scope="row">주소</th>
								<td colspan="3">
									<span id="v_addr"></span>
									<span id="addr" class="dp0"><input type="text" name="addr"></span>
								</td>
							</tr>
							<tr>
								<th scope="row">상세위치</th>
								<td colspan="3">
									<span id="v_addr_detail"></span>
									<span id="addr_detail" class="dp0"><input type="text" name="addr_detail"></span>
								</td>
							</tr>
							<tr>
								<th scope="row">착공일자</th><!-- 설치 시작 -->
								<td>
									<span id="v_start_date"></span>
									<span id="start_date" class="dp0"><input type="text" name="start_date" size="10"></span>
								</td>
								<th scope="row">준공일자</th><!-- 설치 완료 -->
								<td>
									<span id="v_end_date"></span>
									<span id="end_date" class="dp0"><input type="text" name="end_date" size="10"></span>
								</td>
							</tr>
						</table>
					</form>
					</li>
				</ul>
			</div>
		</li>
		
		<li class="as_st">
			<div class="alarm mT10">
				<ul>
					<li class="alarm_gry">A/S 접수 내역</li>
					<li class="p0">
						<table id="as_table" class="tb_astb">
						<!--  
							<tr>
								<th scope="col">A/S신청일</th>
								<th scope="col">신청내용</th>
								<th scope="col">작성자</th>
							</tr>
							<tr>
								<td>2015.10.22</td>
								<td>전원상태 불량</td>
								<td>홍길동</td>
							</tr>
						-->
						</table>
					</li>
				</ul>
			</div>
			<div class="alarm mT10">
				<form id="state_as_frm" method="post" accept-charset="euc-kr">
					<input type="hidden" name="mode" value="state_as"> 
					<input type="hidden" id="kind" name="kind"> 
					<input type="hidden" id="SYS_TYPE" name="SYS_TYPE"> 
					<input type="hidden" id="RTU_NAME" name="RTU_NAME"> 
					<input type="hidden" id="RTU_TYPE" name="RTU_TYPE"> 
					<input type="hidden" id="SIGNAL_ID" name="SIGNAL_ID"> 
					<input type="hidden" id="CONNECTION_INFO" name="CONNECTION_INFO"> 
					<input type="hidden" id="RTU_ADDRESS" name="RTU_ADDRESS"> 
					<input type="hidden" id="RTU_REAL_X" name="RTU_REAL_X"> 
					<input type="hidden" id="RTU_REAL_Y" name="RTU_REAL_Y"> 
					<input type="hidden" id="POINTX" name="POINTX">
					<input type="hidden" id="POINTY" name="POINTY"> 
					<input type="hidden" id="AREA_CODE" name="AREA_CODE"> 
					<input type="hidden" id="LOCAL_CODE" name="LOCAL_CODE"> 
					<input type="hidden" id="REPAIR" name="REPAIR"> 
					<input type="hidden" id="DEMANDER" name="DEMANDER"> 
					<input type="hidden" id="EQUIPMENT_ERROR" name="EQUIPMENT_ERROR"> 
					<input type="hidden" id="MODIFY_REQUEST" name="MODIFY_REQUEST"> 
					<input type="hidden" id="GUBUN" name="GUBUN"> 
					<input type="hidden" id="ERROR" name="ERROR">
					<ul>
						<li class="alarm_gry">A/S 접수하기</li>
						<li class="alarm_100">
							<textarea id="as_content" name="as_content" class="f333_12 w100" id="textarea3" placeholder="내용을 간략히 작성해 주세요."></textarea>
						</li>
					</ul>
			</div>
			<div class="w100">
				<button type="button" id="btn_state_as" class="btn_bb80 w100 mT10">A/S 접수하기</button>
			</div>
		</li>
	</ul>
</div>


