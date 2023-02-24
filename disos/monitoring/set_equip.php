<?
require_once "../_conf/_common.php";
require_once "../_info/_set_equip.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="set_frm" action="set_equip.php" method="post">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 행정 코드 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="dup_check2" name="dup_check2" value="0"><!-- 계측기 번호 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_RTU_ID" name="C_RTU_ID"><!-- 선택한 장비 아이디 -->
		<input type="hidden" id="C_SIGNAL_ID" name="C_SIGNAL_ID"><!-- 선택한 장비 통신 아이디 -->
		<input type="hidden" id="C_AREA_CODE" name="C_AREA_CODE"><!-- 선택한 장비 행정 코드 -->
		<input type="hidden" id="GB_OBSY" name="GB_OBSY"><!-- 재해위험지역 계측기 구분 -->
		<input type="hidden" name="OTT" value="<? echo $ott; ?>">

		<div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>장비 설정</span>
					<span id="rtu_name" class="sub_tit mL20"></span>
					</div>  				
		</div>
		<div class="right_bg2 mB20">
		<ul id="search_box">
					<li>
					<span class="tit">장비 목록 조회 :</span>
					<select id="search_col">
						<option value="0">장비명</option>
						<option value="1">장비구분</option>
						<option value="2">행정코드</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bb80 mL_10"><i class="fa fa-search mR_5 font15"></i>조회</button>
					<button type="button" id="btn_search_all" class="btn_lbb80_s w90p"><i class="fa fa-list-alt mR_5 font15"></i>전체목록</button>
					<span id="button" class="sel_right_n mL5">
					<!--
 					<button type="button" id="btn_print" class="btn_lbs">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbs">엑셀변환</button> 
 					-->
				</span>
					</li>
			</ul>
			
		<ul class="set_ulwrap_nh">
			<li class="li100_nor s_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">번호</th>
							<th class="li5">지역 정렬 번호</th>
							<th class="li5 bL_1gry">장비 ID</th>
							<th class="li5 bL_1gry">통신 ID</th>
							<th class="li20 bL_1gry">장비명</th>
							<th class="li10 bL_1gry">장비 구분</th>
							<th class="li10 bL_1gry">행정코드</th>
							<th class="li5 bL_1gry">회선</th>
							<th class="li5 bL_1gry">모델</th>
							<th class="li10 bL_1gry">통신정보</th>
							<th class="li5 bL_1gry">Port</th>
							<th class="li5 bL_1gry">Baudrate</th>
							<th class="li5 bL_1gry">경계치</th>
							<th class="li5 bL_1gry">위험치</th>
							<!-- <th class="li5 bL_1gry">센서</th> -->
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					$rowCnt = set_cnt - 3;
					$rowNum = 0;
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['NUM']?>" name="list_<?=$val['RTU_ID']?>" class="hh">
							<td class="li5"><?=$val['NUM']?></td>
							<td id="l_SORT_FLAG"class="li5"><?=$val['SORT_FLAG']?></td>
							<td id="l_RTU_ID" class="li5 bL_1gry"><?=$val['RTU_ID']?></td>
							<td id="l_SIGNAL_ID"class="li5 bL_1gry"><?=$val['SIGNAL_ID']?></td>
							<td id="l_RTU_NAME" class="li20 bL_1gry"><?=$val['RTU_NAME']?></td>
							<td id="l_RTU_TYPE_NAME"  class="li10 bL_1gry"><?=$val['RTU_TYPE_NAME']?></td>
							<td id="l_AREA_CODE" class="li10 bL_1gry"><?=$val['AREA_CODE']?></td>
							<td id="l_LINE_NAME"class="li5 bL_1gry"><?=$val['LINE_NAME']?></td>
							<td id="l_MODEL_NAME"class="li5 bL_1gry"><?=$val['MODEL_NAME']?></td>
							<td id="l_CONNECTION_INFO"class="li10 bL_1gry"><?=$val['CONNECTION_INFO']?></td>
							<td id="l_PORT"class="li5 bL_1gry"><?=$val['PORT']?></td>
							<td id="l_BAUDRATE"class="li5 bL_1gry"><?=$val['BAUDRATE']?></td>
							<td id="l_FLOW_WARNING"class="li5 bL_1gry"><?=$val['FLOW_WARNING']?></td>
							<td id="l_FLOW_DANGER"class="li5 bL_1gry"><?=$val['FLOW_DANGER']?></td>
							<!-- <td class="li5 bL_1gry">
							<? if($val['RTU_TYPE_NAME'] == "방송(단독)"){ ?>
								<button type="button" id="btn_sensor" class="btn_wbs" disabled>센서</button>
							<? }else{ ?>
								<button type="button" id="btn_sensor" class="btn_bbr w35p">센서</button>
							<? } ?>
							</td> -->
						</tr>
				<? 
						$rowNum++;
					}
					for($i=0; $i<($rowCnt-$rowNum); $i++){
						echo "<tr class='not_d'>
						<td></td><td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td>
						<td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td>
						<td class='bL_1gry'></td><td class='bL_1gry'></td><td class='bL_1gry'></td>
						</tr>";
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<div class="guide_txt"> <ul><li class="icon"><i class="fa fa-exclamation-circle col_org"></i></li><li class="txt02">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</li></ul></div>
				</div>
				<div class="right_bg2">
				<ul id="search_box">
					<li>
					<span class="tit">설정값 입력</span>
					<!-- <button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button> -->
			</li>
			</ul>
		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL0">장비 ID</td>
						<td class="w20"><input type="text" id="RTU_ID" name="RTU_ID" class="f333_12" size="10" value="<?=$data_id?>" oninput="inputCheck(this,'onlyNumber','1~9999')"></td>
						<td class="bg_lb w10 bold al_C">통신 ID</td>
						<td><input type="text" id="SIGNAL_ID" name="SIGNAL_ID" class="f333_12" size="10" oninput="inputCheck(this,'onlyNumber','1~9999')"></td>
						<td class="bg_lb w10 bold al_C">행정 코드</td>
						<td colspan="3">
							<input type="text" id="AREA_CODE" name="AREA_CODE" class="f333_12 bg_lgr_d" size="12" maxlength="10" readonly>
							<button type="button" id="btn_check" class="btn_bbr">중복체크</button>
							<button type="button" id="btn_area" class="btn_bbr w100p">행정구역 조회</button>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C">장비명</td>
						<td>
							<input type="text" id="RTU_NAME" name="RTU_NAME" class="f333_12" size="22" maxlength="30" onblur="inputCheck(this,'text','1~30')">
						</td>
						<td class="bg_lb w10 bold al_C">장비 구분</td>
						<td colspan="5">
							<select id="RTU_TYPE" name="RTU_TYPE" size="1" class="gaigi12">
								<option value="">장비구분 선택</option>
								<!-- <option value="B00">방송(단독)</option>
								<option value="BR0">방송(우량)</option>
								<option value="BF0">방송(수위)</option>
								<option value="BA0">방송(우+수)</option> -->
								<!-- <option value="BD0">방송(수문)</option> -->
								<!-- <option value="BT0">방송(온도)</option> -->
								<option value="R00">강우계</option>
								<option value="F00">수위계</option>
								<!-- <option value="DP0">변위계</option> -->
								<!-- <option value="EQ0">지진계</option> -->
								<!-- <option value="RF0">강우수위계</option> -->
								<option value="A00">AWS</option>
								<option value="S00">적설계</option>
							</select> 
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C dngr">기준치 사용여부</td>
						<td>
							<input type="radio" id="DANGER_USE0" class="DANGER_USE" name="DANGER_USE" value="0" checked>미사용
							<input type="radio" id="DANGER_USE1" class="DANGER_USE" name="DANGER_USE" value="1">사용
						</td>
						<td class="bg_lb w10 bold al_C dngr">경계치 / 위험치</td>
						<td class="">
							<input type="text" id="FLOW_WARNING" name="FLOW_WARNING" class="warn f333_12" size="10" maxlength="5" oninput="inputCheck(this,'onlyNumber','0.1~9999')">
							 / 
							<input type="text" id="FLOW_DANGER" name="FLOW_DANGER" class="warn f333_12" size="10" maxlength="5" oninput="inputCheck(this,'onlyNumber','0.1~9999')">
						</td>
						<td class="bg_lb w10 bold al_C dngr">경계치 해제 / 위험치 해제</td>
						<td class=""  colspan="3">
							<input type="text" id="FLOW_WARNING_OFF" name="FLOW_WARNING_OFF" class="warn f333_12" size="10" maxlength="5" oninput="inputCheck(this,'onlyNumber','0.1~9999')">
							 / 
							<input type="text" id="FLOW_DANGER_OFF" name="FLOW_DANGER_OFF" class="warn f333_12" size="10" maxlength="5" oninput="inputCheck(this,'onlyNumber','0.1~9999')">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C">소속 기관</td>
						<td>
							<input type="hidden" id="ORGAN_ID" name="ORGAN_ID" class="f333_12" size="15"
								value="<? echo $data_organ[0]['ORGAN_ID'] ?>" readonly>
							<input type="text" id="ORGAN_NAME" name="ORGAN_NAME" class="f333_12 bg_lgr_d" size="15"
								value="<? echo $data_organ[0]['ORGAN_NAME'] ?>" readonly>
						</td>
						<td class="bg_lb w10 bold al_C">지역 정렬 번호</td>
						<td><input id="SORT_FLAG" name="SORT_FLAG" type="text" class="f333_12" size="6" value="0" oninput="inputCheck(this,'onlyNumber','1~9999')"></td>
						<td class="bg_lb w10 bold al_C bT_1gry">회선 / 모델</td>
						<td class="bT_1gry" colspan="3">
							<select id="LINE_NO" name="LINE_NO" size="1" class="f333_12">
								<option value="">회선 선택</option>
						<? 
						if($data_line){
							foreach($data_line as $key => $val){ 
						?>
								<option value="<?=$val['LINE_NO']?>"><?=$val['LINE_NAME']?></option> 
						<? 
							}
						}
						?>
							</select>
							/ 
							<select id="MODEL_NO" name="MODEL_NO" size="1" class="f333_12">
								<option value="">모델 선택</option>
						<? 
						if($data_model){
							foreach($data_model as $key => $val){ 
						?>
								<option value="<?=$val['MODEL_NO']?>"><?=$val['MODEL_NAME']?></option> 
						<? 
							}
						}
						?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">최종 호출시각</td>
						<td>
							<input type="text" id="CALL_LAST_D" name="CALL_LAST_D" value="<?=date("Y-m-d")?>" class="f333_12" size="7" readonly> 
							<select id="CALL_LAST_H" name="CALL_LAST_H" class="f333_12" size="1">
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select>시 
							<select id="CALL_LAST_M" name="CALL_LAST_M" class="gaigi12" size="1">
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select>분
						</td>
						<td class="bg_lb w10 bold al_C">PORT</td>
						<td><input type="text" id="PORT" name="PORT" class="f333_12" size="6" maxlength="5" value="0" oninput="inputCheck(this,'onlyPort','')"></td>
						<td class="bg_lb w10 bold al_C">통신정보</td>
						<td><input type="text" id="CONNECTION_INFO" name="CONNECTION_INFO" class="f333_12" size="18" onblur="inputCheck(this,'onlyIp','')" maxlength="16"></td>
						<td class="bg_lb w10 bold al_C">Baudrate</td>
						<td>
							<select id="BAUDRATE" name="BAUDRATE" size="1" class="f333_12">
								<option value="300">300</option>
								<option value="600">600</option>
								<option value="1200">1200</option>
								<option value="2400">2400</option>
								<option value="9600">9600</option>
								<option value="14400">14400</option>
								<option value="19200">19200</option>
								<option value="38400">38400</option>
								<option value="57600">57600</option>
								<option value="115200">115200</option>
							</select>
						</td>
					</tr>
					<!-- <tr>
						<td class="bg_lb w10 bold al_C">VHF 사용 여부</td>
						<td>
							<select id="VHF_USE" name="VHF_USE" class="f333_12" size="1">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">VHF 그룹</td>
						<td><input id="VHF_SYSTEM_ID" name="VHF_SYSTEM_ID" type="text" class="f333_12" size="6"></td>
						<td class="bg_lb w10 bold al_C">VHF 통신 ID</td>
						<td><input id="VHF_RTU_ID" name="VHF_RTU_ID" type="text" class="f333_12" size="6"></td>
						<td class="bg_lb w10 bold al_C">VHF 중계국</td>
						<td><input id="VHF_TRANS_ID" name="VHF_TRANS_ID" type="text" class="f333_12" size="6"></td>
					</tr> -->
				</table>
			</li>
		</ul>
		<div class="guide_btn"> 
					<button type="button" id="btn_in" class="btn_bb80"><i class="fa fa-plus mR5 font15"></i>등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s"><i class="fa fa-repeat mR5 font15"></i>초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s"><i class="fa fa-edit mR5 font15"></i>수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s"><i class="fa fa-times mR5 font15"></i>삭제</button>
		</div>
		</div>
		
		</form>

	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" style="display: none;">
	<div id="pop_1" class="popup_layout">
		<div class="popup_top">행정구역 조회
			<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		</div>
		<div class="popup_con" style="overflow-y : scroll;">
			<table id="list_table2" class="tb_data2 bL_1gry bR_1gry" style="border-top:1px solid #6e96de !important; width: 99.7%;">
				<thead>
					<tr class="tb_data2_tbg">
						<th class="li10">번호</th>
						<th class="li50">행정코드</th>
						<th class="li40">행정구역</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- <div id="pop_3" class="popup_layout">
		<div class="popup_top">재해위험지구 조회
			<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		</div>
		<div class="popup_con" style="overflow-y : scroll;">
			<table id="list_table4" class="tb_data bL_1gry bR_1gry">
				<thead>
					<tr class="tb_data_tbg">
						<th class="li20">재해위험지역코드</th>
						<th class="li20">재해위험지역명</th>
						<th class="li40">주소</th>
						<th class="li20">유형</th>
					</tr>
				</thead>
			</table>
		</div>
	</div> -->
	<div id="pop_2" class="popup_layout_d">
		<div class="popup_top">센서 정보 설정
			<button id="popup_close" class="btn_pop_blue fR bold mT-5">X</button>
			<button id="sensor_submit" class="btn_pop_blue fR bold mR5 w60p mT-5">저장</button>
		</div>
		<div class="popup_con">
			<form id="sensor_frm" method="post">
			<input type="hidden" id="S_RTU_ID" name="S_RTU_ID">
			<table id="list_table3" border="1" class="pop_tb bg_gry3 m0">
				<thead>
					<tr>
						<th class="w10i">센서</th>
						<th class="w7">기준</th>
					<? 
						if(level_cnt == 2){ 
					?>
						<th><?=level_1?></th>
						<th><?=level_2?></th>
					<? 
						}else if(level_cnt == 3){ 
					?>
						<th><?=level_1?></th>
						<th><?=level_2?></th>
						<th><?=level_3?></th>
					<? 
						}else if(level_cnt == 4){ 
					?>
						<th><?=level_1?></th>
						<th><?=level_2?></th>
						<th><?=level_3?></th>
					<? 
						}else if(level_cnt == 5){ 
					?>
						<th><?=level_1?></th>
						<th><?=level_2?></th>
						<th><?=level_3?></th>
						<th><?=level_4?></th>
						<th><?=level_5?></th>
					<? 
						}
					?>
						<th class="w90p">기준치<br>사용여부</th>
						<th class="w120p">최종 호출시각</th>
						<th>평균 산출</th>
					</tr>
				</thead>
				<tbody>
					<? 
					$sensor_kind = array("0", "1", "2", "DP");
					$sensor_name = array("강우", "수위", "적설", "변위");
					$sensor_judg = array("0", "1", "DP");
					foreach($sensor_kind as $key => $val){ 
					?>
					<tr id="sensor_<?=$val?>">
						<td class="h40p" rowspan="2"><?=$sensor_name[$key]?><input type="hidden" id="IS_SENSOR" name="IS_SENSOR[]" class="IS_SENSOR" value="<?=$val?>"></td>
						<td class="h40p">발령</td>
					<? if(level_cnt == 2){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1" name="BASE_RISKLEVEL1[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2" name="BASE_RISKLEVEL2[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 3){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1" name="BASE_RISKLEVEL1[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2" name="BASE_RISKLEVEL2[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3" name="BASE_RISKLEVEL3[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 4){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1" name="BASE_RISKLEVEL1[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2" name="BASE_RISKLEVEL2[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3" name="BASE_RISKLEVEL3[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 5){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1" name="BASE_RISKLEVEL1[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2" name="BASE_RISKLEVEL2[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3" name="BASE_RISKLEVEL3[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL4" name="BASE_RISKLEVEL4[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL5" name="BASE_RISKLEVEL5[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? } ?>
						<td rowspan="2">
							<select id="IS_USE" name="AUTO_EVENT_USE[]">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
						</td>
						<td rowspan="2">
							<input type="text" id="LAST_TIME_<?=$val?>" name="LAST_TIME_DD[]" value="<?=date("Y-m-d")?>" class="f333_12 LAST_TIME" size="8" readonly> 
							<select id="LAST_TIME_HH" name="LAST_TIME_HH[]" class="f333_12" size="1">
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select>
							시 
							<select id="LAST_TIME_MM" name="LAST_TIME_MM[]" class="gaigi12" size="1">
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select>
							분
						</td>
						<td rowspan="2">
						<? if($val == "0" || $val == "1"){ ?>
							<select id="IS_AVERAGE" name="IS_AVERAGE[]">
								<option value="0">제외</option>
								<option value="1">산출</option>
							</select>
						<? }else{ ?>
							<input type="hidden" id="IS_AVERAGE" name="IS_AVERAGE[]" size="2" value="1">
							<input type="text" class="IS_AVERAGE" size="2" value="산출" readonly>
						<? } ?>
						</td>
					</tr>
					<tr id="sensor_<?=$val?>">
						<td class="h40p">해제</td>
					<? if(level_cnt == 2){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1_OFF" name="BASE_RISKLEVEL1_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2_OFF" name="BASE_RISKLEVEL2_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 3){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1_OFF" name="BASE_RISKLEVEL1_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2_OFF" name="BASE_RISKLEVEL2_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3_OFF" name="BASE_RISKLEVEL3_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 4){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1_OFF" name="BASE_RISKLEVEL1_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2_OFF" name="BASE_RISKLEVEL2_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3_OFF" name="BASE_RISKLEVEL3_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? }else if(level_cnt == 5){ ?>
						<td><input type="text" id="BASE_RISKLEVEL1_OFF" name="BASE_RISKLEVEL1_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL2_OFF" name="BASE_RISKLEVEL2_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL3_OFF" name="BASE_RISKLEVEL3_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL4_OFF" name="BASE_RISKLEVEL4_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
						<td><input type="text" id="BASE_RISKLEVEL5_OFF" name="BASE_RISKLEVEL5_OFF[]" size="2" <? if(!in_array($val, $sensor_judg)){ ?> class="bg_lgr_d2" readonly <? } ?>></td>
					<? } ?>
					</tr>
					<? } ?>
					<tr id="no_sensor" style="display:none;"><td colspan="9">센서가 없습니다.</td></tr>
				</tbody>
			</table>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	localStorage.setItem("layout","set_equip.php");
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 장비명
			search_col_id = "l_RTU_NAME";
		}else if(search_col == "1"){ // 장비구분
			search_col_id = "l_RTU_TYPE_NAME";
		}else if(search_col == "2"){ // 행정코드
			search_col_id = "l_AREA_CODE";
		}
		
		$("#list_table .not_d").hide();
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});

	// 엔터키 - 조회버튼
	$('#search_word').keypress(function(event){
		if ( event.which == 13 ) {
         $('#btn_search').click();
         return false;
     }
	});

	var now_client_time = new Date();
	
	var now_date = now_client_time;
	var now_y = now_date.getFullYear();
	var now_m = now_date.getMonth() + 1;
	var now_d = now_date.getDate();
	var now_h = now_date.getHours();
	var now_i = now_date.getMinutes();
	var date_text = now_y + "년 " + now_m + "월 " + now_d + "일 "

	var timestamp = makeTimestamp();
	
	// 테이블 호출
	var table = $("#list_table").DataTable({
		processing: true,
		paging: false,
		ordering: false,
		searching: false,
		info: false,
		autoWidth: false,
		columnDefs: [
			{className: "dt-center", targets: "_all"}
		],
		language: {
			"emptyTable": "데이터가 없습니다.",       
			  "loadingRecords": "로딩중...", 
			  "processing": "처리중...",
			"search" : "검색 : ",
			  "paginate": {
				  "previous": "<",
				  "next": ">",
			  },
			  "zeroRecords": "검색 결과 데이터가 없습니다."
		}
	});
	var button = new $.fn.dataTable.Buttons(table, {
		buttons: [
			   {
				extend: "print",
				text: "인쇄",
				className: "btn_lbb80_s",
				autoPrint: true,
				title: "장비 내역 출력",
				customize: function(win){
					$(win.document.body).find("body").css("overflow", "visible");
					$(win.document.body).find("h1").css("text-align", "center").css("font-size", "18px").css("margin", "20px");
					$(win.document.body).find("table").css("font-size", "12px").css("margin", "20px").css("width", "97%").css("border-right", "1px solid #C4C4C4");
					$(win.document.body).find("table").attr("border", "1");
					$(win.document.body).find("tr").css("text-align", "center");
				}
			},
			   {
				extend: "excel",
				text: "엑셀변환",
				className: "btn_lbb80_s",
				filename: '장비목록조회_' + timestamp, 
				title: "장비 목록",
				messageTop: date_text,
				customize: function(xlsx){
					var sheet = xlsx.xl.worksheets["sheet1.xml"];
					//$("row:first c", sheet).attr("s", "42");
					$("row c", sheet).attr("s", "51");
					$("row:eq(1) c", sheet).attr("s", "52");
					var col = $("col", sheet);
					col.each(function(){
							// 센서 버튼 삭제?
						  $(col[0]).attr("width", 10);
						  $(col[1]).attr("width", 10);
						  $(col[2]).attr("width", 10);
						  $(col[3]).attr("width", 35);
						  $(col[4]).attr("width", 20);
						  $(col[5]).attr("width", 20);
					   });
				}, customizeData: function(data) {
					// 센서부분 삭제
					// $.each(data.body, function(i,v){
					// 	v.pop(11);
					// });
					// data.header.pop(11);
				}
			}
		]
	}).container().appendTo($("#button"));
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});

	// 기준치 사용여부 변경시
	$(".DANGER_USE").change(function(){
		if($(this).val() == 1){
			$.each($(".warn"), function(i, v){
				if( !$.isNumeric($(v).val()) ){
					alert("숫자를 넣어주세요!");
					$(v).focus();
					$("#DANGER_USE0").prop('checked', true);
					return false;
				}else if($(v).val() <= 0){
					alert("0보다 큰 값을 넣어주세요!");
					$(v).focus();
					$("#DANGER_USE0").prop('checked', true);
					return false;
				}
			});
		}
	});

	// $(".dngr").hide();

	// // 장비구분 선택시
	// $("#RTU_TYPE").change(function(){ 
	// 	if(this.value == "R00" || this.value == "F00" || this.value == "DP0" || this.value == "S00" || this.value == "A00"){
	// 		$("#no_dngr").hide();
	// 		$(".dngr").show();
	// 	}else{
	// 		$(".dngr").hide();
	// 		$("#no_dngr").show();
	// 	}
	// });
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		$("#dup_check").val(0); // 행정코드 중복체크 리셋
		// $("#dup_check2").val(0); // 계측기코드 중복체크 리셋
		
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		if(this.id){
			var l_RTU_ID = $("#"+this.id+" #l_RTU_ID").text();
	
			var list_id = '#'+$(this).attr("id");
			sessionStorage.setItem('list_rtu', $(this).attr('name').substring(5,10));
			
			var param = "mode=equip&RTU_ID="+l_RTU_ID+"&OTT="+'<?=$ott?>';
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					if(data.list){
						$("#C_RTU_ID").val(data.list.RTU_ID);
						$("#C_SIGNAL_ID").val(data.list.SIGNAL_ID);
						$("#C_AREA_CODE").val(data.list.AREA_CODE);
						$("#RTU_ID").val(data.list.RTU_ID);
						$("#SIGNAL_ID").val(data.list.SIGNAL_ID);
						$("#AREA_CODE").val(data.list.AREA_CODE);
						$("#RTU_NAME").val(data.list.RTU_NAME);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#LINE_NO").val(data.list.LINE_NO);
						$("#MODEL_NO").val(data.list.MODEL_NO);
						$("#RTU_TYPE").val(data.list.RTU_TYPE);
						$("#CONNECTION_INFO").val(data.list.CONNECTION_INFO);
						$("#BROADCAST_SETTING").val(data.list.BROADCAST_SETTING);
						$("#CALL_LAST_D").val(data.list.CALL_LAST_D);
						$("#CALL_LAST_H").val(data.list.CALL_LAST_H);
						$("#CALL_LAST_M").val(data.list.CALL_LAST_M);
						$("#SORT_FLAG").val(data.list.SORT_FLAG);
						$("#PORT").val(data.list.PORT);
						$("#BAUDRATE").val(data.list.BAUDRATE);
						// $("#VHF_USE").val(data.list.VHF_USE);
						// $("#VHF_SYSTEM_ID").val(data.list.VHF_SYSTEM_ID);
						// $("#VHF_RTU_ID").val(data.list.VHF_RTU_ID);
						// $("#VHF_TRANS_ID").val(data.list.VHF_TRANS_ID);
						$("#FLOW_DANGER").val(data.list.FLOW_DANGER);
						$("#FLOW_WARNING").val(data.list.FLOW_WARNING);
						$("#FLOW_DANGER_OFF").val(data.list.FLOW_DANGER_OFF);
						$("#FLOW_WARNING_OFF").val(data.list.FLOW_WARNING_OFF);
						if(data.list.DANGER_USE == 1){
							$("#DANGER_USE1").prop("checked", true);
						}else{
							$("#DANGER_USE0").prop("checked", true);
						}
	
						$("#AREA_CODE").attr('disabled',true);
						$("#RTU_ID").attr('readonly',true);
						$("#RTU_ID").addClass('bg_lgr_d');
						$("#btn_check").hide();
						$("#btn_area").hide();
						$("#btn_in").hide();
						// $("#DSCODE").val(data.list.DSCODE);
						// $("#CD_DIST_OBSV").val(data.list.CD_DIST_OBSV);
	
						// if(data.list.RTU_TYPE == "R00" || data.list.RTU_TYPE == "F00" || data.list.RTU_TYPE == "DP0" || data.list.RTU_TYPE == "S00" || this.value == "A00"){
						// 	$("#no_dngr").hide();
						// 	$(".dngr").show();
						// }else{
						// 	$(".dngr").hide();
						// 	$("#no_dngr").show();
						// }
					}else{
						swal("체크", "장비 상세 조회중 오류가 발생 했습니다.", "warning");
					}
				}
			});
		}
	});

	// 장비 센서 조회
	$("#list_table tbody tr #btn_sensor").click(function(){
		// 장비 센서 리셋
		$.each($("#list_table3 tr"), function(i, v){
			$(v.id+" #S_RTU_ID").val("");
			$(v.id+" #BASE_RISKLEVEL1").val(0);
			$(v.id+" #BASE_RISKLEVEL2").val(0);
			$(v.id+" #BASE_RISKLEVEL3").val(0);
			$(v.id+" #BASE_RISKLEVEL4").val(0);
			$(v.id+" #BASE_RISKLEVEL5").val(0);
			$(v.id+" #BASE_RISKLEVEL1_OFF").val(0);
			$(v.id+" #BASE_RISKLEVEL2_OFF").val(0);
			$(v.id+" #BASE_RISKLEVEL3_OFF").val(0);
			$(v.id+" #BASE_RISKLEVEL4_OFF").val(0);
			$(v.id+" #BASE_RISKLEVEL5_OFF").val(0);
			$(v.id+" #LAST_TIME_HH").val("00");
			$(v.id+" #LAST_TIME_MM").val("00");
			$(v.id+" #IS_AVERAGE").val(1);
			$(v.id+" #IS_USE").val(0);
	    });
		// disalbed 처리
		$("#list_table3 tr input").addClass("bg_lgr_d");
		$("#list_table3 tr input").prop("disabled", true);
		$("#list_table3 tr select").prop("disabled", true);
		$("#list_table3 tr #IS_USE").removeClass("bg_lgr_d");
		$("#list_table3 tr .LAST_TIME").removeClass("bg_lgr_d");
		// $("#list_table3 tr .LAST_TIME").prop("disabled", false);
		// $("#list_table3 tr #IS_USE").prop("disabled", false);
		$("#list_table3 tr input[name='LAST_TIME_DD[]']").datepicker("option", "disabled", true);
		
	    var now = "<?=date("Y-m-d")?>";
		$("#LAST_TIME_0").val(now);
		$("#LAST_TIME_1").val(now);
		$("#LAST_TIME_2").val(now);
		$("#LAST_TIME_DP").val(now);
		$("#LAST_TIME_EQ").val(now);
		$("#LAST_TIME_A").val(now);
		$("#LAST_TIME_T").val(now);
		$("#LAST_TIME_W").val(now);
		$("#LAST_TIME_H").val(now);
		$("#LAST_TIME_R").val(now);
		$("#LAST_TIME_S").val(now);

		$("#list_table3 tbody tr").css("display", "none");
		
		var l_RTU_ID = $(this).closest("tr").find("#l_RTU_ID").text();
		$("#S_RTU_ID").val(l_RTU_ID);
		
		var param = "mode=equip_sensor&RTU_ID="+l_RTU_ID+"&OTT="+'<?=$ott?>';
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$.each(data.list, function(i, v){
			        	var tr_id = "#sensor_"+v.SENSOR_TYPE;
						$(tr_id+" #BASE_RISKLEVEL1").val(v.BASE_RISKLEVEL1);
						$(tr_id+" #BASE_RISKLEVEL2").val(v.BASE_RISKLEVEL2);
						$(tr_id+" #BASE_RISKLEVEL3").val(v.BASE_RISKLEVEL3);
						$(tr_id+" #BASE_RISKLEVEL4").val(v.BASE_RISKLEVEL4);
						$(tr_id+" #BASE_RISKLEVEL5").val(v.BASE_RISKLEVEL5);
						$(tr_id+" #BASE_RISKLEVEL1_OFF").val(v.BASE_RISKLEVEL1_OFF);
						$(tr_id+" #BASE_RISKLEVEL2_OFF").val(v.BASE_RISKLEVEL2_OFF);
						$(tr_id+" #BASE_RISKLEVEL3_OFF").val(v.BASE_RISKLEVEL3_OFF);
						$(tr_id+" #BASE_RISKLEVEL4_OFF").val(v.BASE_RISKLEVEL4_OFF);
						$(tr_id+" #BASE_RISKLEVEL5_OFF").val(v.BASE_RISKLEVEL5_OFF);
						$(tr_id+" #IS_AVERAGE").val(v.IS_AVERAGE);
						$(tr_id+" #IS_USE").val(v.AUTO_EVENT_USE);
						$(tr_id+" #LAST_TIME_"+v.SENSOR_TYPE).val(v.LAST_TIME_DD);
						$(tr_id+" #LAST_TIME_HH").val(v.LAST_TIME_HH);
						$(tr_id+" #LAST_TIME_MM").val(v.LAST_TIME_MM);
						if(v.AUTO_EVENT_USE == '1') {
							$(tr_id+" input").removeClass("bg_lgr_d");
							$(tr_id+" input").css("background","#d9d9d9");
							$(tr_id+" input").prop("disabled", false);
						}	
						$(tr_id+" select").prop("disabled", false);
						$(tr_id+" .IS_SENSOR").prop("disabled", false);
						$(tr_id+" .IS_AVERAGE").prop("disabled", true);
						$(tr_id+" input[name='LAST_TIME_DD[]']").datepicker("option", "disabled", false);

						$("#list_table3 " + tr_id).css("display", "table-row");
				    });
		        } else {
					$("#list_table3 #no_sensor").css("display", "table-row");
				}
		        
				$("#pop_1").hide();
				$("#pop_2").show();
				$("#pop_3").hide();
				popup_open(); // 레이어 팝업 열기
	        }
	    });
	});
	
	// 달력 호출
	datepicker(1, "#LAST_TIME_0", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_1", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_2", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_DP", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_EQ", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_A", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_T", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_W", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_H", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_R", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#LAST_TIME_S", "../images/icon_cal.png", "yy-mm-dd");

	// 센서 사용 여부 변경
	$("#list_table3 tbody tr #IS_USE").change(function(){
		var tr_id = "#"+$(this).closest("tr")[0].id;
		if(this.value == 0){ // 미사용
			$(tr_id+" input").addClass("bg_lgr_d");
			$(tr_id+" #IS_USE").removeClass("bg_lgr_d");
			$(tr_id+" input").prop("disabled", true);
			$(tr_id+" .LAST_TIME").removeClass("bg_lgr_d");
			$(tr_id+" .LAST_TIME").prop("disabled", false);
			$(tr_id+" .IS_SENSOR").prop("disabled", false);
			$(tr_id+" #IS_USE").prop("disabled", false);
		}else if(this.value == 1){ // 사용
			$(tr_id+" input").removeClass("bg_lgr_d");
			$(tr_id+" input").css("background","#d9d9d9");
			$(tr_id+" input").prop("disabled", false);
			$(tr_id+" .IS_AVERAGE").prop("disabled", true);
		}
	});
		
	// 센서 적용
	$("#sensor_submit").click(function(){
		// array 객체로 display = none이 아닌것의 아이디 가져옴
		var displayArr = $.makeArray($("#list_table3 tbody tr").map(function(){
			if($(this).css("display") != "none"){
				return $(this).attr('id');
			}
		}));
		// set에 담아 중복제거, 다시 array로 담음
		var set = new Set(displayArr);
		var idArr = new Array();
		set.forEach(function(el){
			idArr.push(el);
		});
		// console.log(idArr);

		// 이하 함수 이전 익스플로러 버전에서 사용 안됨
		// var idArr = [...set];
		// var idArr = Array.from(set);
		/* idArr.forEach( id => {
			$("#" + id + " input").attr("disabled", false);
		}); */
		
		//forEach문 돌려서 disabled 해제
		$.each( idArr, function(i, v) {
			$("#" + v + " input").attr("disabled", false);
		});

		swal({
			title: '<div class="alpop_top_b">센서 정보 설정 확인</div><div class="alpop_mes_b">센서 정보 설정을 저장하실 겁니까?</div>',
			text: '확인 시 센서 정보가 저장 됩니다.',
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
				var param = "mode=equip_sensor_change&"+$("#sensor_frm").serialize();
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
							swal("체크", "센서 정보 설정중 오류가 발생 했습니다.", "warning");
						}
			        }
			    });	
			}
		}); // swal end
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">장비 등록 확인</div><div class="alpop_mes_b">등록 하시겠습니까?</div>',
				text: '확인 시 장비가 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if($("#RTU_TYPE").val() == "R00" || $("#RTU_TYPE").val() == "A00"){
					$("#GB_OBSY").val("01");
				}else if( $("#RTU_TYPE").val() == "F00" ){
					$("#GB_OBSY").val("02");
				}else if( $("#RTU_TYPE").val() == "DP0" ){
					$("#GB_OBSY").val("03");
				}else if( $("#RTU_TYPE").val() == "S00" ){
					$("#GB_OBSY").val("06");
				}

				if(isConfirm){			

					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					$("#AREA_CODE").attr('disabled',false);
					var param = "mode=equip_in&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
							var rtu_id = $("#RTU_ID").val();
							// var l_rtu_id = 'list_'+rtu_id;
							sessionStorage.setItem('list_id', rtu_id);
							sessionStorage.setItem('list_rtu', '<?=$rowNum+1?>');

					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
							    	swal("체크", "장비 등록중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
							}
				        }
				    });	
					$("#AREA_CODE").attr('disabled',true);
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		// $("#dup_check").val(0); // 행정코드 중복체크 리셋
		// $("#dup_check2").val(0); // 계측기코드 중복체크 리셋

		var C_RTU_ID = $("#C_RTU_ID").val("");
	
			$("#C_RTU_ID").val("");
			$("#C_SIGNAL_ID").val("");
			$("#C_AREA_CODE").val("");
			$("#RTU_ID").val("<?=$data_id?>");
			$("#SIGNAL_ID").val("");
			$("#AREA_CODE").val("");
			$("#RTU_NAME").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			$("#LINE_NO").val("");
			$("#MODEL_NO").val("");
			$("#RTU_TYPE").val("");
			$("#CONNECTION_INFO").val("");
			$("#BROADCAST_SETTING").val("1");
			$("#CALL_LAST_D").val("<?=date("Y-m-d")?>");
			$("#CALL_LAST_H").val("00");
			$("#CALL_LAST_M").val("00");
			$("#SORT_FLAG").val("0");
			$("#PORT").val("0");
			$("#BAUDRATE").val("300");
			$("#FLOW_DANGER").val("");
			$("#FLOW_WARNING").val("");
			$("#FLOW_DANGER_OFF").val("");
			$("#FLOW_WARNING_OFF").val("");
			$("#DANGER_USE0").prop("checked", true);
			$("#AREA_CODE").attr('disabled',false);
			$("#RTU_ID").attr('readonly',false);
			$("#RTU_ID").removeClass('bg_lgr_d');
			$("#btn_check").show();
			$("#btn_area").show();
			$("#btn_in").show();
			$("#list_table tbody tr").removeClass('selected');
			
		
	});

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var C_RTU_ID = $("#C_RTU_ID").val();
			swal({
				title: '<div class="alpop_top_b">장비 수정 확인</div><div class="alpop_mes_b">수정 하시겠습니까?</div>',
				text: '확인 시 장비가 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){

				if($("#RTU_TYPE").val() == "R00" || $("#RTU_TYPE").val() == "A00"){
					$("#GB_OBSY").val("01");
				}else if( $("#RTU_TYPE").val() == "F00" ){
					$("#GB_OBSY").val("02");
				}else if( $("#RTU_TYPE").val() == "DP0" ){
					$("#GB_OBSY").val("03");
				}else if( $("#RTU_TYPE").val() == "S00" ){
					$("#GB_OBSY").val("06");
				}
				
				if(isConfirm){
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					$("#AREA_CODE").attr('disabled',false);
					var param = "mode=equip_up&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
								var list_id = sessionStorage.getItem('list_rtu');
								$("#list_table tbody tr #list_"+list_id).click()
								var formData = $('#set_frm').serializeArray();

								$("tr[name='list_"+list_id+"'] #l_SIGNAL_ID").text(formData[3].value);
								$("tr[name='list_"+list_id+"'] #l_RTU_NAME").text(formData[10].value);
								$("tr[name='list_"+list_id+"'] #l_RTU_TYPE_NAME").text(formData[11].value == "R00" ? "강우계" : formData[11].value == "F00" ? "수위계" : formData[11].value == "A00" ? "AWS" : formData[11].value == "S00" ? "적설계" : "");
								$("tr[name='list_"+list_id+"'] #l_LINE_NAME").text(formData[20].value);
								$("tr[name='list_"+list_id+"'] #l_MODEL_NAME").text(formData[21].value);
								$("tr[name='list_"+list_id+"'] #l_CONNECTION_INFO").text(formData[26].value);
								$("tr[name='list_"+list_id+"'] #l_PORT").text(formData[25].value);
								$("tr[name='list_"+list_id+"'] #l_BAUDRATE").text(formData[27].value);
								$("tr[name='list_"+list_id+"'] #l_FLOW_WARNING").text(formData[13].value);
								$("tr[name='list_"+list_id+"'] #l_FLOW_DANGER").text(formData[14].value);
					    		swal.close();
								doubleSubmitFlag = false;
								// location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
							    	swal("체크", "장비 수정중 오류가 발생 했습니다.", "warning");
					        	}
								doubleSubmitFlag = false;
					        }
				        }
				    });	
					$("#AREA_CODE").attr('disabled',true);
				}
			}); // swal end
		}
	});

	if(sessionStorage.getItem('list_rtu')){
		var row_item_id = "list_"+sessionStorage.getItem('list_rtu');
		$("tr[name="+row_item_id+"]").addClass('selected');
		$("tr[name="+row_item_id+"]").click();
		console.log($("tr[name="+row_item_id+"]").attr('id'));
		var row_item = $("tr[name="+row_item_id+"]").attr('id').substring(5,10);

			//클릭 시 스크롤 이동
		var firstOffset = $("#list_table tr").eq(0).offset();
		var offset = $("#list_table tr").eq(row_item).offset();
		$('.s_scroll').animate({scrollTop : offset.top - firstOffset.top}, 400);
		
		// 전체 blink 클래스 삭제 후 blink 클래스 추가
		$("#list_table tr .effect").removeClass('blink');
		$("#list_table tr").eq(row_item).find('.effect').addClass('blink');

	  }

	// 삭제
	$("#btn_de").click(function(){
		if( form_check("D") ){
			var C_RTU_ID = $("#C_RTU_ID").val();
			swal({
				title: '<div class="alpop_top_b">장비 삭제 확인</div><div class="alpop_mes_b">삭제 하시겠습니까?</div>',
				text: '확인 시 장비가 삭제 됩니다.',
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
					$("#AREA_CODE").attr('disabled',false);
					var param = "mode=equip_de&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
								sessionStorage.setItem('list_row', '');
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "장비 삭제중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });
					$("#AREA_CODE").attr('disabled',true);
				}
			}); // swal end
		}
	});
		
	// 행정 코드 입력 시
	$("#AREA_CODE").change(function(){
		$("#dup_check").val(0); // 행정 코드 중복체크 리셋
	});

	// 행정 코드 중복체크
	$("#btn_check").click(function(){
		if( !$("#AREA_CODE").val() ){
		    swal("체크", "행정 코드를 입력해 주세요.", "warning");
		    $("#AREA_CODE").focus(); return false;	
		}else{
			var param = "mode=equip_dup&AREA_CODE="+$("#AREA_CODE").val()+"&C_RTU_ID="+$("#C_RTU_ID").val()+"&OTT="+'<?=$ott?>';
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result){
					    swal("체크", "사용하실 수 있는 행정 코드 입니다.", "success");
				  		$("#dup_check").val(1);
			        }else{
					    swal("체크", "이미 사용중인 행정 코드 입니다.", "warning");
				  		$("#dup_check").val(0);
					}
		        }
		    });
		}
	});
		
	// 행정구역 조회
	$("#btn_area").click(function(){
		$("#pop_1").show();
		$("#pop_2").hide();
		$("#pop_3").hide();
		popup_open(); // 레이어 팝업 열기
	});
	
	// 행정구역 테이블 호출
	var table2 = $("#list_table2").DataTable({
		serverSide: true,
        processing: true,
        paging: true,
        ordering: false,
        searching: true,
        info: false,
		autoWidth: false,
        columnDefs: [
        	{className: "dt-center", targets: "_all"}
    	],
	    language: {
	    	"emptyTable": "데이터가 없습니다.",       
	      	"loadingRecords": "로딩중...", 
	      	"processing": "처리중...",
	        "search" : "검색 : ",
	      	"paginate": {
	      		"previous": "<",
	      		"next": ">",
	      	},
	      	"zeroRecords": "검색 결과 데이터가 없습니다."
	    },
        ajax: {
            url: "../_info/json/_set_json.php",
            type: "POST",
            data: { "mode" : "area", "OTT" : "<? echo $ott; ?>" },
            idSrc: "AREA_CODE"
        },
        columns: [
            {data: "NUM"},
            {data: "AREA_CODE"},
            {data: "TEXT"}
        ],
        pageLength: 20,
        bLengthChange: false
	});
	
	// 행정구역 선택
    $("#list_table2 tbody").on("click", "tr", function(){
		$("#dup_check").val(0); // 행정 코드 중복체크 리셋
    	bg_color("selected", "#list_table2 tbody tr", this); // 리스트 선택 시 배경색
    	var AREA_CODE = table2.row(this).data().AREA_CODE;
    	$("#AREA_CODE").val(AREA_CODE);
		popup_close(); // 레이어 팝업 닫기
	});

	// 재해위험지구 조회
	// $("#btn_dngr").click(function(){
	// 	$("#pop_3").show();
	// 	$("#pop_1").hide();
	// 	$("#pop_2").hide();
	// 	popup_open(); // 레이어 팝업 열기
	// });
	
	// // 재해위험지구 테이블 호출
	// var table4 = $("#list_table4").DataTable({
	// 	serverSide: true,
    //     processing: true,
    //     paging: true,
    //     ordering: false,
    //     searching: false,
    //     info: false,
	// 	autoWidth: false,
    //     columnDefs: [
    //     	{className: "dt-center", targets: "_all"}
    // 	],
	//     language: {
	//     	"emptyTable": "데이터가 없습니다.",       
	//       	"loadingRecords": "로딩중...", 
	//       	"processing": "처리중...",
	//         "search" : "검색 : ",
	//       	"paginate": {
	//       		"previous": "<",
	//       		"next": ">",
	//       	},
	//       	"zeroRecords": "검색 결과 데이터가 없습니다."
	//     },
    //     ajax: {
    //         url: "../_info/json/_set_json.php",
    //         type: "POST",
    //         data: { "mode" : "dngr" },
    //         idSrc: "DSADDR"
    //     },
    //     columns: [
    //         {data: "DSCODE"},
    //         {data: "DSNAME"},
    //         {data: "DSADDR"},
    //         {data: "DSTYPE"}
    //     ],
    //     pageLength: 5,
    //     bLengthChange: false
	// });
	
	// // 재해위험지구 선택
    // $("#list_table4 tbody").on("click", "tr", function(){
	// 	$("#dup_check2").val(0); // 계측기번호 중복체크 리셋
    // 	bg_color("selected", "#list_table4 tbody tr", this); // 리스트 선택 시 배경색
    // 	var DSCODE = table4.row(this).data().DSCODE;
    // 	$("#DSCODE").val(DSCODE);
	// 	popup_close(); // 레이어 팝업 닫기
    // });
	
	// // 계측기번호
	// $("#CD_DIST_OBSV").change(function(){
	// 	$("#dup_check2").val(0); // 계측기번호 중복체크 리셋
	// });

	// // 계측기번호 중복체크
	// $("#btn_check2").click(function(){
	// 	if( !$("#CD_DIST_OBSV").val() ){
	// 	    swal("체크", "계측기 번호를 입력해 주세요.", "warning");
	// 	    $("#CD_DIST_OBSV").focus(); return false;	
	// 	}else{
	// 		var param = "mode=equip_dup2&CD_DIST_OBSV="+$("#CD_DIST_OBSV").val()+"&C_RTU_ID="+$("#C_RTU_ID").val();
	// 		$.ajax({
	// 	        type: "POST",
	// 	        url: "../_info/json/_set_json.php",
	// 		    data: param,
	// 	        cache: false,
	// 	        dataType: "json",
	// 	        success : function(data){
	// 		        if(data.result){
	// 				    swal("체크", "사용하실 수 있는 계측기 번호 입니다.", "success");
	// 			  		$("#dup_check2").val(1);
	// 		        }else{
	// 				    swal("체크", "이미 사용중인 계측기 번호 입니다.", "warning");
	// 			  		$("#dup_check2").val(0);
	// 				}
	// 	        }
	// 	    });
	// 	}
	// });

	// 달력 호출
	datepicker(1, "#CALL_LAST_D", "../images/icon_cal.png", "yy-mm-dd");

	// 폼 체크
	function form_check(kind){
		var num_check = /^[0-9]*$/; // 숫자만
		var num_length_check = /^[0-9]{1,4}$/; // 숫자이면서 10자리
		var area_check = /^[0-9]*$/; // 숫자만
		var id_arr = [];
		var cid_arr = [];
		var code_arr = [];
		$.each($('#list_table tbody tr'), function(i,v){
			id_arr.push($(v).find('td').eq(1).text());
			cid_arr.push($(v).find('td').eq(2).text());
			code_arr.push($(v).find('td').eq(5).text());
		});
		
		if(kind == "I"){
			if( !$("#RTU_ID").val() ){
			    swal("체크", "장비 ID를 입력해 주세요.", "warning");
			    $("#RTU_ID").focus(); return false;	
			// }else if( !num_length_check.test( $("#RTU_ID").val() ) ){
			//     swal("체크", "장비 ID는 1~9999까지 숫자만 사용해 주세요.", "warning"); 
			    $("#RTU_ID").focus(); return false;	
			}else if( id_arr.indexOf($("#RTU_ID").val()) > -1 ){
			    swal("체크", "이미 사용중인 장비 ID 입니다.", "warning");
			    $("#RTU_ID").focus(); return false;	
			}else if( !$("#SIGNAL_ID").val() ){
			    swal("체크", "통신 ID를 입력해 주세요.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !num_check.test( $("#SIGNAL_ID").val() ) ){
			    swal("체크", "통신 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( cid_arr.indexOf($("#SIGNAL_ID").val()) > -1 ){
			    swal("체크", "이미 사용중인 통신 ID 입니다.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( !area_check.test( $("#AREA_CODE").val() ) ){
			    swal("체크", "행정 코드는  숫자만 사용하여 10자리로 입력해 주세요.", "warning"); 
			    $("#AREA_CODE").focus(); return false;	
			}else if( code_arr.indexOf($("#AREA_CODE").val()) > -1 ){
			    swal("체크", "이미 사용중인 행정 코드 입니다.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "행정 코드 중복체크를 진행해 주세요.", "warning"); return false;
			// }else if( $("#CD_DIST_OBSV").val() != "" ){
			// 	if( $("#dup_check2").val() == "0" ){
			//     	swal("체크", "계측기 번호 중복체크를 진행해 주세요.", "warning"); return false;
			// 	}else{
			// 		return true;
			// 	}
			}else if( !$("#RTU_NAME").val() ){
			    swal("체크", "장비명을 입력해 주세요.", "warning");
			    $("#RTU_NAME").focus(); return false;	
			}else if( !$("#LINE_NO").val() ){
			    swal("체크", "회선을 선택해 주세요.", "warning");
			    // $("#LINE_NO").focus(); 
				return false;	
			}else if( !$("#MODEL_NO").val() ){
			    swal("체크", "모델을 선택해 주세요.", "warning"); 
			    $("#MODEL_NO").focus(); return false;	
			}else if( !$("#RTU_TYPE").val() ){
			    swal("체크", "장비 구분을 선택해 주세요.", "warning"); 
			    // $("#RTU_TYPE").focus(); 
				return false;	
			// }else if( $("#VHF_USE").val() == "1" ){
				// if( !$("#VHF_SYSTEM_ID").val() ){
			    // 	swal("체크", "VHF 그룹을 입력해 주세요.", "warning"); 
			    // 	$("#VHF_SYSTEM_ID").focus(); return false;	
				// }else if( !$("#VHF_RTU_ID").val() ){
			    // 	swal("체크", "VHF 통신 ID를 입력해 주세요.", "warning"); 
			    // 	$("#VHF_RTU_ID").focus(); return false;	
				// }else if( !$("#VHF_TRANS_ID").val() ){
			    // 	swal("체크", "VHF 중계국을 입력해 주세요.", "warning"); 
			    // 	$("#VHF_TRANS_ID").focus(); return false;	
				// }else{
				// 	return true;
				// }
			}else if($("input[name='DANGER_USE']:checked").val() == 1){
				var result = [];
				$.each($(".warn"), function(i, v){
					if( !$.isNumeric($(v).val()) ){
						swal("체크", "경계치/위험치에 숫자를 넣어주세요!", "warning");
						$(v).focus();
						$("#DANGER_USE0").prop("checked", true);
						result[i] = "false";
					}else if($(v).val() <= 0){
						swal("체크", "경계치/위험치에 0보다 큰 값을 넣어주세요!", "warning");
						$(v).focus();
						$("#DANGER_USE0").prop("checked", true);
						result[i] = "false";
					}else{
						result[i] = "true";
					}
				});
				if(result.indexOf("false") == -1) return true;
				else return false;
			}else{
				return true;
			}
		}else if(kind == "U"){
			if( !$("#C_RTU_ID").val() ){
			    swal("체크", "장비를 선택해 주세요.", "warning"); return false;
			}else if( !$("#RTU_ID").val() ){
			    swal("체크", "장비 ID를 입력해 주세요.", "warning");
			    $("#RTU_ID").focus(); return false;	
			// }else if( !num_length_check.test( $("#RTU_ID").val() ) ){
			//     swal("체크", "장비 ID는 1~9999까지 숫자만 사용해 주세요.", "warning"); 
			    $("#RTU_ID").focus(); return false;	
			}else if( !$("#SIGNAL_ID").val() ){
			    swal("체크", "통신 ID를 입력해 주세요.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !num_check.test( $("#SIGNAL_ID").val() ) ){
			    swal("체크", "통신 ID는 숫자만 사용해 주세요.", "warning"); 
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( cid_arr.indexOf($("#SIGNAL_ID").val()) > -1 && !($("#SIGNAL_ID").val() == $("#C_SIGNAL_ID").val())){
			    swal("체크", "이미 사용중인 통신 ID 입니다.", "warning");
			    $("#SIGNAL_ID").focus(); return false;	
			}else if( !$("#AREA_CODE").val() ){
			    swal("체크", "행정 코드를 입력해 주세요.", "warning");
			    $("#AREA_CODE").focus(); return false;	
			}else if( !area_check.test( $("#AREA_CODE").val() ) ){
			    swal("체크", "행정 코드는  숫자만 사용하여 10자리로 입력해 주세요.", "warning"); 
			    $("#AREA_CODE").focus(); return false;	
			}else if( !$("#RTU_NAME").val() ){
			    swal("체크", "장비명을 입력해 주세요.", "warning");
			    $("#RTU_NAME").focus(); return false;	
			}else if( !$("#LINE_NO").val() ){
			    swal("체크", "회선을 선택해 주세요.", "warning");
			    $("#LINE_NO").focus(); return false;	
			}else if( !$("#MODEL_NO").val() ){
			    swal("체크", "모델을 선택해 주세요.", "warning"); 
			    $("#MODEL_NO").focus(); return false;	
			}else if( !$("#RTU_TYPE").val() ){
			    swal("체크", "장비 구분을 선택해 주세요.", "warning"); 
			    $("#RTU_TYPE").focus(); return false;	
			// }else if( $("#VHF_USE").val() == "1" ){
			// 	if( !$("#VHF_SYSTEM_ID").val() ){
			//     	swal("체크", "VHF 그룹을 입력해 주세요.", "warning"); 
			//     	$("#VHF_SYSTEM_ID").focus(); return false;	
			// 	}else if( !$("#VHF_RTU_ID").val() ){
			//     	swal("체크", "VHF 통신 ID를 입력해 주세요.", "warning"); 
			//     	$("#VHF_RTU_ID").focus(); return false;	
			// 	}else if( !$("#VHF_TRANS_ID").val() ){
			//     	swal("체크", "VHF 중계국을 입력해 주세요.", "warning"); 
			//     	$("#VHF_TRANS_ID").focus(); return false;	
			// 	}else{
			// 		return true;
			// 	}
			}else if($("input[name='DANGER_USE']:checked").val() == 1){
				var result = [];
				$.each($(".warn"), function(i, v){
					if( !$.isNumeric($(v).val()) ){
						swal("체크", "경계치/위험치에 숫자를 넣어주세요!", "warning");
						$(v).focus();
						$("#DANGER_USE0").prop("checked", true);
						result[i] = "false";
					}else if($(v).val() <= 0){
						swal("체크", "경계치/위험치에 0보다 큰 값을 넣어주세요!", "warning");
						$(v).focus();
						$("#DANGER_USE0").prop("checked", true);
						result[i] = "false";
					}else{
						result[i] = "true";
					}
				});
				if(result.indexOf("false") == -1) return true;
				else return false;
			}else{
				return true;
			}
		}else if(kind == "D"){
			if( !$("#C_RTU_ID").val() ){
			    swal("체크", "장비를 선택해 주세요.", "warning"); return false;
			}else{
				return true;
			}
		}
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#dup_check").val(0); // 행정코드 중복체크 리셋
	$("#dup_check2").val(0); // 행정코드 중복체크 리셋
	$("#C_RTU_ID").val("");
	$("#C_SIGNAL_ID").val("");
	$("#C_AREA_CODE").val("");
	$("#RTU_ID").val("<?=$data_id?>");
	$("#SIGNAL_ID").val("");
	$("#AREA_CODE").val("");
	$("#RTU_NAME").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	$("#LINE_NO").val("");
	$("#MODEL_NO").val("");
	$("#RTU_TYPE").val("");
	$("#CONNECTION_INFO").val("");
	$("#BROADCAST_SETTING").val("1");
	$("#CALL_LAST_D").val("<?=date("Y-m-d")?>");
	$("#CALL_LAST_H").val("00");
	$("#CALL_LAST_M").val("00");
	$("#SORT_FLAG").val("0");
	$("#PORT").val("0");
	$("#BAUDRATE").val("300");
	// $("#VHF_USE").val("0");
	// $("#VHF_SYSTEM_ID").val("");
	// $("#VHF_RTU_ID").val("");
	// $("#VHF_TRANS_ID").val("");
});
</script>

</body>
</html>


