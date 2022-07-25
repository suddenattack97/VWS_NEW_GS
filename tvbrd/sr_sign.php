
<div class="slider_top">
	<div class="slider_title">
		<img src="img/icon_botitle.png" class="mR10 fL mT3" />문자전광판
	</div>
	<div class="slider_close">
		<a class="btn_close" href="#"><img src="img/btn_close_off.png" alt="닫기" /></a>
	</div>
</div>

<div class="tb_wrapper">
	<form id="sign_frm" name="sign_frm">
	<input type="hidden" id="mode" name="mode" value="sign_in">
	<input type="hidden" id="rtu_cnt" name="rtu_cnt">
	<input type="hidden" id="str_rtu_id" name="str_rtu_id">
	<input type="hidden" id="str_msg_idx" name="str_msg_idx">

	<ul class="tb_alarm">
		<!--좌-방송지역선택-->
		<li class="tb_alarm_lm">
			<div class="alarm">
				<ul>
					<li class="alarm_gry">전광판 선택 : <span id="rtu_cnt_text">0</span> 개소
						<button type="button" id="all_sel" class="btn_bs60">전체</button>
					</li>
					<li id="sign"></li><!-- 전광판 선택 트리메뉴 -->
				</ul>
			</div>
		</li>
		<!--좌-방송지역선택 끝-->
		<li class="mi"></li>
		<!--중-방송구분-->
		<li class="tb_alarm_lm">
			<div class="alarm">
				<ul>
					<li class="alarm_gry">메세지 구분
						<select id="formselect" size="1" class="f333_12">
							<option value="">전체</option>
							<option value="0">텍스트</option>
							<option value="1">이미지</option>
						</select>
					</li>
					<li id="sign2"></li><!-- 문자 내용 선택 -->
				</ul>
			</div>
		</li>
		<!--중-방송구분 끝-->

		<!--우-방송내용-->
		<li class="tb_alarm_r mT10">
			<div class="alarm">
				<ul>
					<li class="alarm_gry_b">
						<div id="sign_view" class="textw_12 al_C">
							<div class="board_textarea text_sign red">문자 전광판 테스트 입니다</div>
							<div class="board_textarea text_sign yellow">가나다라마바사아자차카타파하</div>
						</div>
					</li>
					<li>
						<span class="sel_left"> 
						효과 : <span id="msgAction"></span>
						</span> 
						<span class="fR">  
						색깔 : <span id="msgColor"></span>
						</span>
					</li>
					<li>
						<span class="sel_left">
						속도 :  <span id="msgSpd"></span> 
						</span> 
						<span class="fR"> 
						정지시간 :  <span id="msgDelay"></span> 
						</span>
					</li>
					<li class="alarm_gry_b">
						<span class="sel_left"> 
						내용 구분 : <span id="type"></span> 
						</span> 
					</li>
					<li class="alarm_100"> 
						<div id="msg" class="f333_12 textarea3 mB5" readonly></div>
					</li>
				</ul>

			</div>
		</li>
		<!--우-방송내용 끝-->
		<li class="w100">
			<a id="sign_detail" href="" target="_blank">
				<div class="text_btn1 btn_lbb80 m_12 w_198 fL mL0 mR0">
					<span>상세설정</span>
				</div>
			</a>
			<button type="button" id="btn_board" class="btn_bb80 m_12 w_198 fR mR0 mR0">전송하기</button>
		</li>
	</ul>
	</form>
</div>


