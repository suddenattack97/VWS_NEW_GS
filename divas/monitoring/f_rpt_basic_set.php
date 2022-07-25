<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_05_06.png" alt="기본보고서설정">
		</div>

		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry"><span class="sel_left_n"> 검색구분 : <select
					name="search_col[]">
						<option value="SW_PUBLIC">특보발표</option>
						<option value="SW_DESC">특보내용</option>
						<option value="SW_DESC_AREA">특보지역</option>
				</select> <input name="search_word" type="text" id="date2322223222"
					size="10"> 검색기간 : &nbsp; <input type="text" name="DATE_START"
					formtype="YYYYMMDD" readonly value="2016-02-22" id="date222"
					size="8"> <a
					href="javascript:document.searchFrm.DATE_START.click();"
					onfocus="this.blur()"><img src="../images/icon_cal.png" alt="달력보기"
						onclick="MM_showHideLayers('calrenda','','show')" class="top6px"></a>
					부터 <input type="text" name="DATE_END" formtype="YYYYMMDD" readonly
					value="2016-02-22" id="date222" size="8"> <a
					href="javascript:document.searchFrm.DATE_END.click();"
					onfocus="this.blur()"><img src="../images/icon_cal_r.png"
						alt="달력보기" onclick="MM_showHideLayers('calrenda','','show')"
						class="top6px"></a> 까지
			</span> <span class="sel_right_n">
					<button class="btn_bb80">검색</button>
					<button class="btn_lbb80_s">전체목록</button>
			</span></li>
			<li class="li150_or">
				<div style="clear: both;"></div>
				<div class="mi fL"></div>
				<div class="datam_con_29">
					<ul>
						<li class="datam_con_gry">보고서목록</li>
						<li class="p0">
							<div class="datam_list">
								<div class="tb_data">
									<ul class="tb_data_tbg">
										<li class="li15 al_C hi28">선택</li>
										<li class="li35 al_C hi28 bL_1gry">등록일</li>
										<li class="li50 al_C hi28 bL_1gry">기상특보</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul  class="hh">
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>
									<ul class="hh">
										<li class="li15 al_C hi28 "><input type="checkbox"
											name="RTU_ID" onfocus="this.blur()" value="2" class="chkbox"></li>
										<li class="li35 al_C hi28  bL_1gry ">-</li>
										<li class="li50 al_C hi28  bL_1gry ">-</li>
									</ul>


								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="mi fL"></div>
				<div class="datam_con_68">
					<ul>
						<li class="rpt_con_gry">보고서 설정
							<button class="btn_lbs fR">다시쓰기</button>
							<button class="btn_bs60">등록</button>
						</li>
						<li class="p0">
							<div class="datam_list">
								<div class="tb_data">
									<!--보고서설정입력테이블-->
									<table width="100%" border="0" cellpadding="0" cellspacing="0"
										class="rptset">
										<tbody>
											<tr>
												<td width="14%" height="35" align="center" class="bg_lb ">입력일시</td>
												<td colspan="4"><input name="REG_DATE_YMD" type="TEXT"
													formtype="YYYYMMDD" readonly="" value="2016-02-24"> <input
													name="YYYY" type="HIDDEN"> <input name="MM" type="HIDDEN">
													<input name="DD" type="HIDDEN"> <a
													href="javascript:document.frm.REG_DATE_YMD.click();"
													onfocus="this.blur()"> <img src="../images/icon_cal.png"
														alt="달력보기" class="top5px"></a>&nbsp;&nbsp; <select
													name="REG_DATE_HH">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14" selected="">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
												</select> 시 <select name="REG_DATE_MI">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
														<option value="32">32</option>
														<option value="33">33</option>
														<option value="34">34</option>
														<option value="35">35</option>
														<option value="36">36</option>
														<option value="37">37</option>
														<option value="38">38</option>
														<option value="39">39</option>
														<option value="40">40</option>
														<option value="41">41</option>
														<option value="42">42</option>
														<option value="43">43</option>
														<option value="44">44</option>
														<option value="45">45</option>
														<option value="46">46</option>
														<option value="47" selected="">47</option>
														<option value="48">48</option>
														<option value="49">49</option>
														<option value="50">50</option>
														<option value="51">51</option>
														<option value="52">52</option>
														<option value="53">53</option>
														<option value="54">54</option>
														<option value="55">55</option>
														<option value="56">56</option>
														<option value="57">57</option>
														<option value="58">58</option>
														<option value="59">59</option>
												</select> <input type="hidden" name="REG_DATE"
													value="2016-02-24 14:47:45"> 분</td>
											</tr>
											<tr>
												<td width="14%" height="185" rowspan="5" align="center"
													class="bg_lb ">기상특보</td>
												<td width="11%" height="43" align="center" class="bg_lgr">특보발표</td>
												<td width="32%"><textarea name="SW_PUBLIC"
														class="wh100 m0p4"
														onclick="javascript:chkInitString('SW_PUBLIC',this.value);">20자 이내로 기입</textarea>
													<!-- <textarea name="textarea1" cols="30" rows="2"  id="textarea3"  >20자 이내로 기입</textarea> --></td>
												<td width="11%" height="43" align="center" class="bg_lgr">특보내용</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="21"
														rows="2" class=" wh100" name="SW_DESC"
														onclick="javascript:chkInitString('SW_DESC',this.value);">20자 이내로 기입</textarea>
													<!-- <textarea name="textarea" cols="30" rows="2"  id="textarea"  >20자 이내로 기입</textarea> --></td>
											</tr>
											<tr>
												<td width="11%" height="43" align="center" class="bg_lgr">특보지역</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="21"
														rows="1" name="SW_DESC_AREA" class="wh100 m0p4"
														onclick="javascript:chkInitString('SW_DESC_AREA',this.value);">22자 이내로 기입</textarea>
													<!-- <textarea name="textarea2" cols="30" rows="2"  id="textarea2"  >22자 이내로 기입</textarea> --></td>
												<td width="11%" align="center" class="bg_lgr">예상최대파고</td>
												<td width="32%" bgcolor="#FFFFFF"><input type="TEXT"
													name="SW_DESC_WAVEHEIGHT" value=""> m</td>
												</td>
											</tr>
											<tr>
												<td width="11%" height="36" align="center" class="bg_lgr">발효시각</td>
												<td colspan="3" bgcolor="#FFFFFF"><input
													name="SW_DATE_START_YMD" type="TEXT" formtype="YYYYMMDD"
													readonly="" value="2016-02-24"> <a
													href="javascript:document.frm.SW_DATE_START_YMD.click();"
													onfocus="this.blur()"><img src="../images/icon_cal.png"
														alt="달력보기" class="top5px">&nbsp;&nbsp;</a> <select
													name="SW_DATE_START_HH">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14" selected="">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
												</select> 시 <select name="SW_DATE_START_MI">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
														<option value="32">32</option>
														<option value="33">33</option>
														<option value="34">34</option>
														<option value="35">35</option>
														<option value="36">36</option>
														<option value="37">37</option>
														<option value="38">38</option>
														<option value="39">39</option>
														<option value="40">40</option>
														<option value="41">41</option>
														<option value="42">42</option>
														<option value="43">43</option>
														<option value="44">44</option>
														<option value="45">45</option>
														<option value="46">46</option>
														<option value="47" selected="">47</option>
														<option value="48">48</option>
														<option value="49">49</option>
														<option value="50">50</option>
														<option value="51">51</option>
														<option value="52">52</option>
														<option value="53">53</option>
														<option value="54">54</option>
														<option value="55">55</option>
														<option value="56">56</option>
														<option value="57">57</option>
														<option value="58">58</option>
														<option value="59">59</option>
												</select> 분&nbsp;&nbsp; <input type="CHECKBOX"
													name="SW_DATE_START_CHK" value="1" class="chkbox"> <input
													type="HIDDEN" name="SW_DATE_START"
													value="2016-02-24 14:47:45"> 발효시각없음</td>
											</tr>
											<tr>
												<td width="11%" height="36" align="center" class="bg_lgr">해제시각</td>
												<td colspan="3" bgcolor="#FFFFFF"><input
													name="SW_DATE_END_YMD" type="TEXT" formtype="YYYYMMDD"
													readonly="" value="2016-02-24"> <a
													href="javascript:document.frm.SW_DATE_END_YMD.click();"
													onfocus="this.blur()"><img src="../images/icon_cal.png"
														alt="달력보기" class="top5px">&nbsp;&nbsp;</a> <select
													name="SW_DATE_END_HH">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14" selected="">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
												</select> 시 <select name="SW_DATE_END_MI">
														<option value="0">00</option>
														<option value="1">01</option>
														<option value="2">02</option>
														<option value="3">03</option>
														<option value="4">04</option>
														<option value="5">05</option>
														<option value="6">06</option>
														<option value="7">07</option>
														<option value="8">08</option>
														<option value="9">09</option>
														<option value="10">10</option>
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
														<option value="31">31</option>
														<option value="32">32</option>
														<option value="33">33</option>
														<option value="34">34</option>
														<option value="35">35</option>
														<option value="36">36</option>
														<option value="37">37</option>
														<option value="38">38</option>
														<option value="39">39</option>
														<option value="40">40</option>
														<option value="41">41</option>
														<option value="42">42</option>
														<option value="43">43</option>
														<option value="44">44</option>
														<option value="45">45</option>
														<option value="46">46</option>
														<option value="47" selected="">47</option>
														<option value="48">48</option>
														<option value="49">49</option>
														<option value="50">50</option>
														<option value="51">51</option>
														<option value="52">52</option>
														<option value="53">53</option>
														<option value="54">54</option>
														<option value="55">55</option>
														<option value="56">56</option>
														<option value="57">57</option>
														<option value="58">58</option>
														<option value="59">59</option>
												</select> 분&nbsp;&nbsp; <input type="CHECKBOX"
													name="SW_DATE_END_CHK" value="1" class="chkbox"> <input
													type="HIDDEN" name="SW_DATE_END"
													value="2016-02-24 14:47:45"> 해제시각없음</td>
											</tr>
											<tr>
												<td width="11%" height="43" align="center" class="bg_lgr ">풍향/풍속</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="29"
														rows="2" class=" wh100 m0p4" name="SW_DESC_WIND"
														onclick="javascript:chkInitString('SW_DESC_WIND',this.value);">22자 이내로 기입</textarea>
													<!-- <textarea name="textarea3" cols="30" rows="2"  id="textarea4"  >22자 이내로 기입</textarea> --></td>
												<td width="11%" align="center" class="bg_lgr ">예상강우</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="29"
														rows="2" class=" wh100 m0p4" name="SW_DESC_RAIN"
														onclick="javascript:chkInitString('SW_DESC_RAIN',this.value);">20자 이내로 기입</textarea>
													<!-- <textarea name="textarea4" cols="30" rows="2"  id="textarea5"  >20자 이내로 기입</textarea> --></td>
											</tr>
											<tr>
												<td width="14%" height="73" align="center" class="bg_lb ">날씨</td>
												<td width="11%" align="center" class="bg_lgr ">오늘</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="29"
														rows="4" class=" wh100" name="FORECAST_TODAY"
														onclick="javascript:chkInitString('FORECAST_TODAY',this.value);">4줄[56자] 이내로 기입</textarea>
													<!-- <textarea name="textarea5" cols="30" rows="4"  id="textarea6"  >4줄 [56자] 이내로 기입</textarea> --></td>
												<td width="11%" align="center" class="bg_lgr ">내일</td>
												<td width="32%" bgcolor="#FFFFFF"><textarea cols="29"
														rows="4" class=" wh100" name="FORECAST_TOMMROW"
														onclick="javascript:chkInitString('FORECAST_TOMMROW',this.value);">4줄[56자] 이내로 기입</textarea>
													<!-- <textarea name="textarea6" cols="30" rows="4"  id="textarea7"  >4줄 [56자] 이내로 기입</textarea> --></td>
											</tr>
											<tr>
												<td width="14%" height="36" align="center" class="bg_lb ">지역정보</td>
												<td colspan="4" bgcolor="#FFFFFF">최고 <input type="TEXT"
													name="RAIN_MAX_AREA" value="" id="date222222224" size="8">
													<input type="TEXT" name="RAIN_MAX" value="" size="6"> mm
													&nbsp;&nbsp;최저 <input type="TEXT" name="RAIN_MIN_AREA"
													value="" id="date2222222234" size="8"> <input type="TEXT"
													name="RAIN_MIN" value="" id="date2222222334" size="6"> mm
													&nbsp;&nbsp;평균 <input type="TEXT" name="RAIN_AVR" value=""
													id="date22222223222" size="6"> mm
												</td>
											</tr>
											<tr>
												<td width="14%" height="36" align="center" class="bg_lb ">비고</td>
												<td colspan="4" bgcolor="#FFFFFF"><input type="TEXT"
													name="REMARK" value="" class=" wh100" id="date222222232222">
													</b></td>
											</tr>
										</tbody>
									</table>
									<!--보고서설정입력테이블 끝-->
								</div>
							</div>
						</li>
					</ul>
				</div>
			</li>

		</ul>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->
	
<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");

	// 검색 버튼
	$("#btn_search").click(function(){
		$("#form_search").submit();
	});
});
</script>

</body>
</html>


