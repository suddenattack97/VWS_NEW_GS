
<div class="slider_top">
	<div class="slider_title">
		<img src="img/icon_altitle.png" class="mR10 fL mT3" /><span id="title_name"></span>
	</div>
	<div class="slider_type">방송</div>
	<div class="slider_close">
		<a class="btn_close" href="#"><img src="img/btn_close_off.png" alt="닫기" /></a>
	</div>
</div>

<div class="tb_wrapper">
	<form id="alarm_frm" name="alarm_frm" method="post" accept-charset="euc-kr">
	<input type="hidden" id="mode" name="mode" value="alarm_in">
	<input type="hidden" id="USER_ID" name="USER_ID">
	<input type="hidden" id="RTU_CNT" name="RTU_CNT">
	<input type="hidden" id="PLAN_NO" name="PLAN_NO"><!-- 방송일정 일련번호 (예약 시) -->
	<input type="hidden" id="IS_PLAN" name="IS_PLAN" value="0"><!-- 전송유형 0:즉시, 1:예약 -->
	<input type="hidden" id="SCRIPT_NO" name="SCRIPT_NO">
	<input type="hidden" id="SCRIPT_TYPE" name="SCRIPT_TYPE" value="1"><!-- 방송문안 유형 0:모바일, 1:피씨 -->
	<input type="hidden" id="SCRIPT_UNIT" name="SCRIPT_UNIT">
	<input type="hidden" id="SECTION_NO" name="SECTION_NO">
	<input type="hidden" id="SCRIPT_RECORD_FILE" name="SCRIPT_RECORD_FILE">
	<input type="hidden" id="SCRIPT_TIMESTAMP" name="SCRIPT_TIMESTAMP">
	<input type="hidden" id="LOG_TYPE" name="LOG_TYPE" value="0"><!-- 로그유형 0:방송, 1:범위호출, 2:원격장비설정 -->
	<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID">

	<ul class="tb_alarm">
		<!--좌-방송지역선택-->
		<li class="tb_alarm_lm">
			<div class="alarm">
				<ul>
					<li class="alarm_gry">방송지역 선택 : <span id="rtu_cnt_text">0</span> 개소
						<button type="button" id="all_sel" class="btn_bs60">전체</button>
					</li>
					<li id="alarm"></li><!-- 방송지역 선택 트리메뉴 -->
				</ul>
			</div>
		</li>
		<!--좌-방송지역선택 끝-->
		<li class="mi"></li>
		<!--중-방송구분-->
		<li class="tb_alarm_lm">
			<div class="alarm">
				<ul>
					<li class="alarm_gry">방송구분 
						<select id="formselect" name="SECTION_NO_SEARCH" size="1" class="f333_12">
						</select>
					</li>
					<li id="alarm2"></li><!-- 방송내용 선택 -->
                    <li class="alarm_gry_s">긴급방송
                        <!-- <button id="btn_emer_del" type="button" class="btn_lbs60 fR mL5">삭제</button> -->
                        <button id="btn_emer_ins" type="button" class="btn_bs60">등록</button>
					</li>
				</ul>
			</div>
		</li>
		<!--중-방송구분 끝-->

		<!--우-방송내용-->
		<li class="tb_alarm_r mT10">
			<div class="alarm">
				<ul>
					<li class="alarm_gry_b">방송제목 : 
						<input id="SCRIPT_TITLE" name="SCRIPT_TITLE" type="text" size="44" class="f333_12 fR mR0">
					</li>
					<li>
						<span class="sel_left"> 시작효과음 : 
						<select id="CHIME_START_NO" name="CHIME_START_NO" size="1" class="select_b">
						</select>
						</span> 
						<span class="fR"> 시작효과반복횟수 : 
						<select id="CHIME_START_CNT" name="CHIME_START_CNT" size="1" class="select_s">
								<option value="0">0</option>
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
						</select>
						</span>
					</li>
					<li>
						<span class="sel_left"> 종료효과음 : 
						<select id="CHIME_END_NO" name="CHIME_END_NO" size="1" class="select_b">
						</select>
						</span> 
						<span class="fR"> 종료효과반복횟수 : 
						<select id="CHIME_END_CNT" name="CHIME_END_CNT" size="1" class="select_s">
								<option value="0">0</option>
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
						</select>
						</span>
					</li>
					<li class="alarm_gry_b">
						<span class="sel_left"> 방송종류 : 
						<span id="SCRIPT_UNIT_STRING" class="fbb_12"></span>
						</span> 
						<span class="fR"> 방송내용반복횟수 : 
						<select id="SCRIPT_BODY_CNT" name="SCRIPT_BODY_CNT" size="1" class="select_s">
								<option value="0">0</option>
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
						</select>
						</span>
					</li>
					<li>
						<button type="button" id="btn_alert_test" class="btn_lbb80">미리듣기</button>
						<div class="vcontrol">
							<span class="vcon_span">볼륨</span>
							<select id="TRANS_VOLUME" name="TRANS_VOLUME" class="volnum mR5">
								<? for($i=1; $i<=16; $i++){ ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <? } ?>
							</select>
						</div>
					</li>
					<li class="alarm_100">
						<textarea id="SCRIPT_BODY" name="SCRIPT_BODY" class="f333_12 textarea3"></textarea>
					</li>
				</ul>

			</div>
		</li>
		<!--우-방송내용 끝-->
		<li class="w100">
			<a id="alarm_detail" href="" target="_blank"> 
				<div class="text_btn1 btn_lbb80 m_12 w_198 fL mL0 mR0">
					<span>상세설정</span>
				</div>
			</a>
			<button type="button" id="btn_broadcast" class="btn_bb80 m_12 w_198 fR mR0 mR0">방송하기</button>
		</li>
	</ul>
	</form>
</div>
<iframe id="alert_iframe" name="alert_iframe" width="0" height="0"></iframe>


