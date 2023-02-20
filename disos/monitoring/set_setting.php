<?
require_once "../_conf/_common.php";
require_once "../_info/_set_setting.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="set_frm">
		<input type="hidden" name="OTT" value="<? echo $ott; ?>">
		<div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>시스템 설정</span>
					<span id="rtu_name" class="sub_tit mL20"></span>
					</div>  				
		</div>

		<div class="main_contitle mB0">
					<!-- <div class="tit w100 bB_2blue"> -->
					<div class="tit w100">
					<div data-tab="system-tab" class="tab">운영 설정</div>
					<div data-tab="main-tab" class="tab">메인 메뉴 설정</div>
					<div data-tab="sub-tab" class="tab">서브 메뉴 설정</div>
					<div data-tab="popup-tab" class="tab">팝업 메뉴 설정</div>
					<!-- <div data-tab="report-tab" class="tab">기본보고서 설정</div> -->
					
					</div>  				
		</div>

		<div id="system-tab" class="right_bg2 mB20">
		<!-- <ul class="set_ulwrap_nh">
			<li class="li100_nor">
			<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w15i">IP</th>
							<th class="w5">PORT</th>
							<th class="w10i">ID</th>
							<th class="w10i">PASS</th>
							<th class="w15i">DB 이름</th>
						</tr>
					</thead>
			        <tbody>
						<tr class="hh">
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>리캡차</td>
							<td>
								리캡차 :
								<select id="recaptcha" name="recaptcha">
									<option value="0" <?if(recaptcha=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(recaptcha=="1"){echo "selected";}?>>구글</option>
									<option value="2" <?if(recaptcha=="2"){echo "selected";}?>>기본</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>경계 단계</td>
							<td>
								단계 :
								<select id="level_cnt" name="level_cnt">
									<option value="2" <?if(level_cnt=="2"){echo "selected";}?>>2</option>
									<option value="3" <?if(level_cnt=="3"){echo "selected";}?>>3</option>
									<option value="4" <?if(level_cnt=="4"){echo "selected";}?>>4</option>
									<option value="5" <?if(level_cnt=="5"){echo "selected";}?>>5</option>
								</select>
								단계
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>현황 Refresh 간격</td>
							<td>
								시간 : <input type="text" id="load_time" name="load_time" class="f333_12" style="width: 50px" value="<?=load_time*0.001?>"> 초
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>방송현황 표현 개수</td>
							<td>
								표현 개수 : <input type="text" id="alarm_cnt" name="alarm_cnt" class="f333_12" style="width: 50px" value="<?=alarm_cnt?>"> 개
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>최근경보 표현 개수</td>
							<td>
								표현 개수 : <input type="text" id="alert_cnt" name="alert_cnt" class="f333_12" style="width: 50px" value="<?=alert_cnt?>"> 개
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>상황판 타입</td>
							<td>
								타입 : 
								<select id="board_type" name="board_type">
									<option value="0" <?if(board_type=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(board_type=="1"){echo "selected";}?>>통합관제</option>
									<option value="2" <?if(board_type=="2"){echo "selected";}?>>별도</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>별도 상황판 경로</td>
							<td>
								<input type="text" id="board_url" name="board_url" class="w95 f333_12" value="<?=board_url?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>미리듣기</td>
							<td>
								VW_SPEAKER_ID : <input type="text" id="vm_speaker" name="vm_speaker" class="f333_12" style="width: 50px" value="<?=vm_speaker?>">
								&nbsp;&nbsp;
								VW_VOICE_FORMAT : <input type="text" id="vm_voice" name="vm_voice" class="f333_12" style="width: 50px" value="<?=vm_voice?>">
							</td>
							<td>
								<input type="text" id="vm_ip" name="vm_ip" class="w95 f333_12" value="<?=vm_ip?>">
							</td>
							<td>	
								<input type="text" id="vm_port" name="vm_port" class="w95 f333_12" value="<?=vm_port?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>마을방송 사용 여부</td>
							<td>
								마을방송 : 
								<select id="town_use" name="town_use">
									<option value="0" <?if(town_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(town_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>VHF 사용 여부</td>
							<td>
								VHF : 
								<select id="vhf_use" name="vhf_use">
									<option value="0" <?if(vhf_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(vhf_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>SMS 기본 회신 번호</td>
							<td>
								회신 번호 : 
								<input type="text" id="sms_call" name="sms_call" class="f333_12" style="width: 200px" value="<?=sms_call?>" readonly>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>SMS 전송 방식 (문자 방송)</td>
							<td>
								SMS 전송 방식 : 
								<select id="sms_type" name="sms_type">
									<option value="0" <?if(sms_type=="0"){echo "selected";}?>>EMMA</option>
									<option value="1" <?if(sms_type=="1"){echo "selected";}?>>XROSHOT</option>
								</select>
							</td>
							<td>
								<input type="text" id="sms_ip" name="sms_ip" class="w95 f333_12" value="<?=sms_ip?>">
							</td>
							<td>
								<input type="text" id="sms_port" name="sms_port" class="w95 f333_12" value="<?=sms_port?>">
							</td>
							<td>
								<input type="text" id="sms_id" name="sms_id" class="w95 f333_12" value="<?=sms_id?>">
							</td>
							<td>
								<input type="text" id="sms_pw" name="sms_pw" class="w95 f333_12" value="<?=sms_pw?>">
							</td>
							<td>
								<input type="text" id="sms_db" name="sms_db" class="w95 f333_12" value="<?=sms_db?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS (전화 방송)</td>
							<td>
								XROSHOT VMS : 
								<select id="xro_use" name="xro_use">
									<option value="0" <?if(xro_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(xro_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
							<td>
								<input type="text" id="xro_ip" name="xro_ip" class="w95 f333_12" value="<?=xro_ip?>">
							</td>
							<td>
								<input type="text" id="xro_port" name="xro_port" class="w95 f333_12" value="<?=xro_port?>">
							</td>
							<td>
								<input type="text" id="xro_id" name="xro_id" class="w95 f333_12" value="<?=xro_id?>">
							</td>
							<td>
								<input type="text" id="xro_pw" name="xro_pw" class="w95 f333_12" value="<?=xro_pw?>">
							</td>
							<td>
								<input type="text" id="xro_db" name="xro_db" class="w95 f333_12" value="<?=xro_db?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>네이버 지도 api</td>
							<td>
								<input type="text" id="naver_api" name="naver_api" class="w95 f333_12" value="<?=naver_api?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>다음 지도 api</td>
							<td>
								<input type="text" id="daum_api" name="daum_api" class="w95 f333_12" value="<?=daum_api?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
					</tbody>
				</table>
				</li>
				</ul> -->
				<ul class="system_tit">
				<li><i class="fa fa-cog"></i>운영 설정</li>
				<li><button type="button" name="btn_save" class="btn_bb80">저장</button></li></ul>

				<ul class="set_ulwrap_nh">
				<li class="li100_nor">
				<table id="list_table" class="tb_data_system">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w17i">구분</th>
							<th class="w30i" colspan="6">설정</th>
						</tr>
					</thead>
			        <tbody>
						<tr class="hh">
							<td>상단바 로고</td>
							<td colspan="6">
								<input type="text" id="top_img" name="top_img" class="w95 f333_12 pointer" value="<?=top_img?>">
								<input type="file" id="sel_top_img" name="sel_top_img" style="display: none;">
								<input type="text" id="top_img_check" name="top_img_check" value="0" style="display: none;">
								<input type="text" id="mode" name="mode" value="set" style="display: none;">
							</td>
						</tr>
						<tr class="hh">
							<td>상단바 제목</td>
							<td colspan="6">
								<input type="text" id="top_title" name="top_title" class="w95 f333_12" value="<?=top_title?>" maxlength="12">
							</td>
						</tr>
						<!-- <tr class="hh">
							<td>상단바 내용</td>
							<td colspan="6">
								<input type="text" id="top_text" name="top_text" class="w95 f333_12" value="<?=top_text?>">
							</td>
						</tr> -->

						<tr class="hh hd">
							<td>로그인 리캡차</td>
							<td>
								사용여부 :
								<select id="recaptcha" name="recaptcha">
									<option value="0" <?if(recaptcha=="0"){echo "selected";}?>>미사용</option>
									<!-- <option value="1" <?if(recaptcha=="1"){echo "selected";}?>>구글</option> -->
									<option value="2" <?if(recaptcha=="2"){echo "selected";}?>>기본</option>
								</select>
							</td>
						</tr>
						<!-- <tr class="hh hd"> -->
							<!-- <td>경계 단계</td> -->
							<!-- <td> -->
								<!-- 단계 : -->
								<select id="level_cnt" name="level_cnt" style="display:none;">
									<option type="hidden" value="2" <?if(level_cnt=="2"){echo "selected";}?>>2</option>
									<option type="hidden" value="3" <?if(level_cnt=="3"){echo "selected";}?>>3</option>
									<option type="hidden" value="4" <?if(level_cnt=="4"){echo "selected";}?>>4</option>
									<option type="hidden" value="5" <?if(level_cnt=="5"){echo "selected";}?>>5</option>
								</select>
								<!-- 단계 -->
							<!-- </td> -->
						<!-- </tr> -->
						<tr class="hh hd">
							<td>현황 Refresh 간격</td>
							<td>
								시간 : 
								<select id="load_time" name="load_time">
									<option value="30" <?if(load_time*0.001=="30"){echo "selected";}?>>30</option>
									<option value="60" <?if(load_time*0.001=="60"){echo "selected";}?>>60</option>
								</select>
								초
							</td>
						</tr>

					<?
					if(($_SESSION['user_type'] == 7 && $data_area['sig_cd'] == "") || $_REQUEST['area']){
					?>
								<tr class="hh hd">
									<td>지역 코드</td>
									<td>
										<select id="area_code" name="area_code">

										<?if($data_area['sig_cd'] == ""){ ?>
											<option value="" selected>지역을 선택해주세요.</option>
										<? } ?>

					<?
						if($data_area){
							foreach($data_area as $key => $val){
								if($key != "sig_cd"){
					?>			
								<option value="<?=$val['area_code']?>" <?=($data_area['sig_cd'] == $val['area_code'] ? "selected" : "")?>><?=$val['sido']." ".$val['gugun']?></option>				
					<?		
								}
							} 
						}
					}
					?>
						</select>
						</td>
							</tr>
						
						<!-- <tr class="hh hd">
							<td>방송현황 표현 개수</td>
							<td>
								표현 개수 : <input type="text" id="alarm_cnt" name="alarm_cnt" class="f333_12" style="width: 50px" value="<?=alarm_cnt?>"> 개
							</td>
						</tr>
						<tr class="hh hd">
							<td>최근경보 표현 개수</td>
							<td>
								표현 개수 : <input type="text" id="alert_cnt" name="alert_cnt" class="f333_12" style="width: 50px" value="<?=alert_cnt?>"> 개
							</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>상황판 타입</td>
							<td>
								타입 : 
								<select id="board_type" name="board_type">
									<option value="0" <?if(board_type=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(board_type=="1"){echo "selected";}?>>통합관제</option>
									<option value="2" <?if(board_type=="2"){echo "selected";}?>>별도</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>별도 상황판 경로</td>
							<td>
								<input type="text" id="board_url" name="board_url" class="w95 f333_12" value="<?=board_url?>">
							</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>미리듣기</td>
							<td>
								VW_SPEAKER_ID : <input type="text" id="vm_speaker" name="vm_speaker" class="f333_12" style="width: 50px" value="<?=vm_speaker?>"><br>
								VW_VOICE_FORMAT : <input type="text" id="vm_voice" name="vm_voice" class="f333_12" style="width: 50px" value="<?=vm_voice?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>미리듣기 IP</td>
							<td>
								<input type="text" id="vm_ip" name="vm_ip" class="w95 f333_12" value="<?=vm_ip?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>미리듣기 PORT</td>
							<td>	
								<input type="text" id="vm_port" name="vm_port" class="w95 f333_12" value="<?=vm_port?>">
							</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>마을방송 사용 여부</td>
							<td>
								마을방송 : 
								<select id="town_use" name="town_use">
									<option value="0" <?if(town_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(town_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>VHF 사용 여부</td>
							<td>
								VHF : 
								<select id="vhf_use" name="vhf_use">
									<option value="0" <?if(vhf_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(vhf_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS 기본 회신 번호</td>
							<td>
								회신 번호 : 
								<input type="text" id="sms_call" name="sms_call" class="f333_12" style="width: 200px" value="<?=sms_call?>" readonly>
							</td>
						</tr>
						<tr class="hh hd">
						<tr class="hh hd">
							<td>SMS 전송 방식 (문자 방송)</td>
							<td>
								SMS 전송 방식 : 
								<select id="sms_type" name="sms_type">
									<option value="0" <?if(sms_type=="0"){echo "selected";}?>>EMMA</option>
									<option value="1" <?if(sms_type=="1"){echo "selected";}?>>XROSHOT</option>
								</select>
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS IP</td>
							<td>
								<input type="text" id="sms_ip" name="sms_ip" class="w95 f333_12" value="<?=sms_ip?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS PORT</td>
							<td>
								<input type="text" id="sms_port" name="sms_port" class="w95 f333_12" value="<?=sms_port?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS ID</td>
							<td>
								<input type="text" id="sms_id" name="sms_id" class="w95 f333_12" value="<?=sms_id?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS PW</td>
							<td>
								<input type="text" id="sms_pw" name="sms_pw" class="w95 f333_12" value="<?=sms_pw?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>SMS DB명</td>
							<td>
								<input type="text" id="sms_db" name="sms_db" class="w95 f333_12" value="<?=sms_db?>">
							</td>
						</tr>
						<tr class="hh hd">

							<tr class="hh hd">
							<td>XROSHOT VMS (전화 방송)</td>
							<td>
								XROSHOT VMS : 
								<select id="xro_use" name="xro_use">
									<option value="0" <?if(xro_use=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if(xro_use=="1"){echo "selected";}?>>사용</option>
								</select>
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS IP</td>
							<td>
								<input type="text" id="xro_ip" name="xro_ip" class="w95 f333_12" value="<?=xro_ip?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS PORT</td>
							<td>
								<input type="text" id="xro_port" name="xro_port" class="w95 f333_12" value="<?=xro_port?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS ID</td>
							<td>
								<input type="text" id="xro_id" name="xro_id" class="w95 f333_12" value="<?=xro_id?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS PW</td>
							<td>
								<input type="text" id="xro_pw" name="xro_pw" class="w95 f333_12" value="<?=xro_pw?>">
							</td>
						</tr>
						<tr class="hh hd">
							<td>XROSHOT VMS DB명</td>
							<td>
								<input type="text" id="xro_db" name="xro_db" class="w95 f333_12" value="<?=xro_db?>">
							</td>
						</tr> -->
						<!-- <tr class="hh hd">
							<td>네이버 지도 api</td>
							<td>
								<input type="text" id="naver_api" name="naver_api" class="w95 f333_12" value="<?=naver_api?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr>
						<tr class="hh hd">
							<td>다음 지도 api</td>
							<td>
								<input type="text" id="daum_api" name="daum_api" class="w95 f333_12" value="<?=daum_api?>">
							</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
						</tr> -->
					</tbody>
				</table>
			</li>
		</ul>	
		<!-- <div class="guide_btn"> <button type="button" id="btn_save" class="btn_bb80">저장</button></div>	 -->
		</div>
		<!-- <div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>메뉴 설정</span>
					<span id="rtu_name" class="sub_tit mL20"></span>
					</div>  				
		</div> -->
		<div id="main-tab" class="right_bg2 hd">

		<ul class="system_tit">
				<li><i class="fa fa-cog"></i>메인 메뉴 설정</li>
				<li><button type="button" name="btn_save" class="btn_bb80">저장</button></li></ul>
		

		<ul class="set_ulwrap_nh hd">
		<li class="li100_nor">
			<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w20i">상위 메뉴</th>
							<th class="w30i">하위 메뉴 대표</th>
							<!-- <th class="w20i">url</th> -->
							<!-- <th class="w15i">아이콘</th> -->
							<th class="w15i">사용 여부</th>
						</tr>
					</thead>
			        <tbody>
					<? 
					if($data_top){
						foreach($data_top as $key => $val){
							if($val['menu_idx'] != '5'){
					?>
						<tr class="hh">
							<td><?=$val['menu_name']?><input type="hidden" name="top_idx[]" value="<?=$val['menu_idx']?>"></td>
							<td><?=$val['sub_name']?></td>
							<!-- <td><a href="<?=$val['menu_url']?>"><?=$val['menu_url']?></a></td>
							<td class="bg_td_gry"><img src="../img/<?=$val['menu_icon']?>" /></td> -->
							<td>
							<? 
								if($val['menu_idx'] != '4'){
							?>
								<select name="top_use[]">
									<option value="0" <?if($val['menu_use']=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if($val['menu_use']=="1"){echo "selected";}?>>사용</option>
								</select>
							<? 
								}else{
							?>
								<input type="hidden" name="top_use[]" value="1">
								<select name="top_system" disabled>
									<option value="0">미사용</option>
									<option value="1" selected>사용</option>
								</select>
							<? 
								}
							?>
							</td>
						</tr>
					<?
							}
						}
					}
					?>	
					</tbody>
				</table>
			</li>
		</ul>
				</div>

		<div id="sub-tab" class="right_bg2 hd">
		<ul class="system_tit">
				<li><i class="fa fa-cog"></i>서브 메뉴 설정</li>
				<li><button type="button" name="btn_save" class="btn_bb80">저장</button></li></ul>
		
		<ul class="set_ulwrap_nh hd">
					
		<li class="li100_nor">
			<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w20i">상위 메뉴</th>
							<th class="w30i">하위 메뉴</th>
							<!-- <th class="w20i">url</th> -->
							<!-- <th class="w15i">권한</th> -->
							<th class="w15i">사용 여부</th>
						</tr>
					</thead>
			        <tbody>
					<? 
					if($data_top){
						foreach($data_top as $key => $val){
					  		if($data_in[ $val['menu_idx'] ]){
					  	  		foreach($data_in[ $val['menu_idx'] ] as $key2 => $val2){ 
					?>
						<tr class="hh">
							<td class="gubun"><?=$val['menu_name']?></td><input type="hidden" name="sub_idx[]" value="<?=$val['menu_idx']?>">
							<td><?=$val2['menu_name']?><input type="hidden" name="sub_num[]" value="<?=$val2['menu_num']?>"></td>
							<!-- <td><a href="<?=$val2['menu_url']?>"><?=$val2['menu_url']?></a></td> -->
							<!-- <td>
								<select name="sub_level[]">
									<option value="1" <?if($val2['menu_level']=="1"){echo "selected";}?>>관리자</option>
									<option value="3" <?if($val2['menu_level']=="3"){echo "selected";}?>>사용자</option>
								</select> 부터
							</td> -->
							<td>
							<? 
								if($val['menu_idx'] == '4' && $val2['menu_num'] == '1'){
							?>
								<input type="hidden" name="sub_use[]" value="1">
								<select name="sub_system" disabled>
									<option value="0">미사용</option>
									<option value="1" selected>사용</option>
								</select>
							<? 
								}else{
							?>
								<select name="sub_use[]">
									<option value="0" <?if($val2['menu_use']=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if($val2['menu_use']=="1"){echo "selected";}?>>사용</option>
								</select>
							<? 
								}
							?>
							</td>
						</tr>
					<? 
								}
							}
						}
					}
					?>	
					</tbody>
				</table>
			</li>
		</ul>
				</div>

		<div id="popup-tab" class="right_bg2 hd">
		<ul class="system_tit">
				<li><i class="fa fa-cog"></i>팝업 메뉴 설정</li>
				<li><button type="button" name="btn_save" class="btn_bb80">저장</button></li></ul>

		<ul class="set_ulwrap_nh hd">
		<li class="li100_nor">
			<table id="list_table4" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w15i">사용 여부</th>
							<th class="w25i">팝업 메뉴명</th>
							<th class="w60">사이트 주소</th>
							<!-- <th class="w15i">권한</th> -->
						</tr>
					</thead>
			        <tbody>
					<? 
					if($data_url){
						foreach($data_url as $key => $val){
					?>
						<tr class="hh">
							<td>
							<? 
								if($val['menu_idx'] != '0'){
							?>
								<select class="popup_use" name="popup_use[]">
									<option value="0" <?if($val['menu_use']=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if($val['menu_use']=="1"){echo "selected";}?>>사용</option>
								</select>
							<? 
								}else{
							?>
								<input class="popup_use" type="hidden" name="popup_use[]" value="1">
								<select name="popup_system" disabled>
									<option value="0">미사용</option>
									<option value="1" selected>사용</option>
								</select>
							<? 
								}
							?>
							</td>
							<!-- <td><?=$val['menu_name']?><input type="hidden" name="popup_idx[]" value="<?=$val['menu_idx']?>"></td> -->
							<td><input class="popup_name" type="text" name="popup_name[]" value="<?=$val['menu_name']?>" maxlength="20" onblur="inputCheck(this,'text','1~20')">
							<input type="hidden" name="popup_idx[]" value="<?=$val['menu_idx']?>"></td>
							<td>
							<?
								$http_array = array("http://","https://");
							?>
							<select name="url[]" class="url">
								<option value="http://" <?=(strstr($val['menu_url'], "http://") ? 'selected' : '')?>>http://</option>
								<option value="https://" <?=(strstr($val['menu_url'], "https://") ? 'selected' : '')?>>https://</option>
							</select> 
							<input name="popup_url[]" type="text" size="60" maxlength="100" class="popup_url"
									value="<?=str_replace($http_array,"",$val['menu_url'])?>" 
									onblur="this.value = this.value.replace('http:\/\/','').replace('https:\/\/',''); inputCheck(this,'text','0~1000');"> 
							</td>	
							<!-- <td>
								<select name="popup_level[]">
									<option value="1" <?if($val['menu_level']=="1"){echo "selected";}?>>관리자</option>
									<option value="3" <?if($val['menu_level']=="3"){echo "selected";}?>>사용자</option>
								</select> 부터
							</td> -->
							
						</tr>
					<? 
						}
					}
					?>	
					</tbody>
				</table>
			</li>
		</ul>
		</div>

		<div id="report-tab" class="right_bg2 hd">
		<ul class="system_tit">
				<li><i class="fa fa-cog"></i>기본보고서 설정</li>
				<li><button type="button" name="btn_save" class="btn_bb80">저장</button></li></ul>

		<ul class="set_ulwrap_nh hd">
		<li class="li100_nor">
			<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="w20i">Report 순서</th>
							<th class="w20i">Report 이름</th>
							<th class="w15i">사용 여부</th>
						</tr>
					</thead>
			        <tbody>
					<? 
					if($data_report){
						foreach($data_report as $key => $val){
					?>
						<tr class="hh">
							<td><input type="text" name="idx[]" value="<?=$val['idx']?>" style="text-align:center;"></td>
							<td>
							<input type="hidden"   name="report_num[]" value="<?=$val['report_num']?>">
							<input type="text" name="report_name[]" value="<?=$val['report_name']?>" style="text-align:center;">
							</td>	
							<td>
								<select name="report_use[]">
									<option value="0" <?if($val['report_use']=="0"){echo "selected";}?>>미사용</option>
									<option value="1" <?if($val['report_use']=="1"){echo "selected";}?>>사용</option>
								</select>
							<? 
								}
							?>
							</td>
						</tr>
					<? 
					}
					?>	
					</tbody>
				</table>
			</li>
		</ul>
		</div>

		</form>

	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){

	$('#list_table4 tbody tr').each(function(i,v){
		if($(this).find('.popup_use').val() > 0){
			$(this).find('.popup_name').attr('readonly',false).removeClass('bg_lgr_d');
			$(this).find('.url').attr('disabled', false).removeClass('bg_lgr_d');
			$(this).find('.popup_url').attr('readonly',false).removeClass('bg_lgr_d');
		}else{
			$(this).find('.popup_name').attr('readonly',true).addClass('bg_lgr_d');
			$(this).find('.url').attr('disabled',true).addClass('bg_lgr_d');
			$(this).find('.popup_url').attr('readonly',true).addClass('bg_lgr_d');
		}
	});

    // 상단 로고 및 텍스트 변경
    $("#top_img").click(function(){
    	$("#sel_top_img").trigger("click");
    });
    $("#sel_top_img").change(function(){
    	$("#top_img").val(this.value.substring(12));
		$("#top_img_check").val(1);
    });
	// if(<?=$_SESSION['user_type']?> != "7"){
	// 	$(".hd").hide();
	// }

	//http / https
	$("select[name=url]").change(function(){
		var url = $(this).val();
	});

	// 저장
	$("button[name=btn_save]").click(function(){
		// console.log($("#load_time").val());
		if(form_check('I')){
			// if($("#load_time").val() < 10){	
			// 	console.log("Refresh 간격을 10초 보다 작게 설정할 수 없습니다.");
			// 	$("#load_time").val(10);
			// }
			// 파라미터 가지고 가도록
			// $(".hd").show();
			$('#list_table4 .url').attr('disabled', false);
			var param = "mode=set&"+$("#set_frm").serialize();
			var tmp_data = new FormData($("#set_frm")[0]); 
	
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: tmp_data,
				contentType: false,
				  processData: false,
				cache: false,
				dataType: "json",
				success : function(data){
					if(data.result){
						swal({
							title: "시스템 설정 완료",
							text: "설정이 완료 됐습니다.", 
							type: "success",
							timer: 1300,
							showConfirmButton: false,
							allowOutsideClick: false
						}, function(){
							parent.location.reload();
						}); 
						return false;
					}else{
						swal("체크", "시스템 설정중 오류가 발생 했습니다.", "warning");
					}
				}
			});
		}
	});
		
	// 시스템 설정 퀵메뉴 이벤트
	$(".right_bg2").hide();
	$(".tab:first").addClass("tab_hover").show();
	$(".right_bg2:first").show();

	$(".tab").click(function(){
		 var tab_id = $(this).attr('data-tab');

		  $(".tab").removeClass("tab_hover");
		  $(this).addClass("tab_hover");
		 
		  $(".right_bg2").hide();
		  $("#"+tab_id).show();
	});

	//서브메뉴 상위메뉴 rowspan설정 이벤트
	$(".gubun").each(function(){
		var rows = $(".gubun:contains('" + $(this).text()+ "')");
	
		if(rows.length > 1){
			rows.eq(0).attr("rowspan",rows.length);
			rows.not(":eq(0)").remove();
		}
	});

	// hover시 rowspan부분도 라인 색 맞게 바꿔줌
	$(".tb_data tbody tr td").hover(function(){
		$el = $(this);
		$el.parent().addClass('bh');
		if ($el.parent().has('td[rowspan]').length == 0)
		$el.parent().prevAll('tr:has(td[rowspan]):first').find('td[rowspan]').addClass("bh");
	}, function() {
		$el = $(this);
		$el.parent().removeClass('bh');
		$el.parent().prevAll('tr:has(td[rowspan]):first').find('td[rowspan]').removeClass("bh");
	});

	// 팝업매뉴 사용 / 사용안함 바꿨을때,
	$(".popup_use").change(function(){	
		$('#list_table4 tbody tr').each(function(i,v){
			if($(this).find('.popup_use').val() > 0){
				$(this).find('.popup_name').attr('readonly',false).removeClass('bg_lgr_d');
				$(this).find('.url').attr('disabled', false).removeClass('bg_lgr_d');
				$(this).find('.popup_url').attr('readonly',false).removeClass('bg_lgr_d');
			}else{
				$(this).find('.popup_name').attr('readonly',true).addClass('bg_lgr_d');
				$(this).find('.url').attr('disabled',true).addClass('bg_lgr_d');
				$(this).find('.popup_url').attr('readonly',true).addClass('bg_lgr_d');
			}
		});
	});
	
	// 폼 체크
	function form_check(kind){
		var ipPattern = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(:?[0-9]{1,5})$/;
		// var urlPattern = /^([^\/]*)(\.)(com|net|kr|my|shop|php|html|htm)/;
		var urlPattern = /([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?/;

		if(kind == "I"){
			if( $("#load_time").val() < 10 ){
				swal("체크", "현황 Refresh 간격을 10초 이상으로 입력해 주세요.", "warning");
				$("#load_time").val(10);
			    $("#load_time").focus(); return false;	
			}
			// 매뉴명, 사이트 주소 유효성 체크
			let result = [];
			$('#list_table4 tbody tr').each(function(i,v){	// 팝업메뉴명 체크, 팝업메뉴 url 체크
				if($(this).find('.popup_use').val() > 0){
					if($(this).find('.popup_name').val().length < 1 || $(this).find('.popup_name').val().length > 20){
						swal("체크", "팝업메뉴명을 1~20자로 입력해 주세요.", "warning");
						$(this).find('.popup_name').focus();
						result.push(false);
					}else{
						result.push(true);
					}
					if($(this).find('.popup_url').val().length < 4 || $(this).find('.popup_url').val().length > 100){
						swal("체크", "팝업메뉴 사이트 주소를 4~100자로 입력해 주세요.", "warning");
						$(this).find('.popup_url').focus();
						result.push(false);
					}else{
						// 사이트 주소 유효성 체크
						let ipTest = ipPattern.test($(this).find('.popup_url').val());
						let urlTest = urlPattern.test($(this).find('.popup_url').val());
						if(ipTest || urlTest) {
							result.push(true);
						}else{
							swal("체크", "팝업메뉴 사이트 주소를 형식에 맞게 입력해 주세요. \n 예) www.naver.com", "warning");
							$(this).find('.popup_url').focus();
							result.push(false);
						}
					}
				}
			});
			if(result.indexOf(false) != -1) return false;
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#top_img").val("<?=top_img?>");
	$("#top_title").val("<?=top_title?>");
	$("#top_text").val("<?=top_text?>");
	$("#recaptcha").val("<?=recaptcha?>");
	$("#level_cnt").val("<?=level_cnt?>");
	$("#load_time").val("<?=load_time*0.001?>");
	$("#alarm_cnt").val("<?=alarm_cnt?>");
	$("#alert_cnt").val("<?=alert_cnt?>");
	$("#board_type").val("<?=board_type?>");
	$("#board_url").val("<?=board_url?>");
	$("#vm_speaker").val("<?=vm_speaker?>");
	$("#vm_voice").val("<?=vm_voice?>");
	$("#vm_ip").val("<?=vm_ip?>");
	$("#vm_port").val("<?=vm_port?>");
	$("#town_use").val("<?=town_use?>");
	$("#vhf_use").val("<?=vhf_use?>");
	$("#sms_call").val("<?=sms_call?>");
	$("#sms_type").val("<?=sms_type?>");
	$("#sms_ip").val("<?=sms_ip?>");
	$("#sms_port").val("<?=sms_port?>");
	$("#sms_id").val("<?=sms_id?>");
	$("#sms_pw").val("<?=sms_pw?>");
	$("#sms_db").val("<?=sms_db?>");
	$("#xro_use").val("<?=xro_use?>");
	$("#xro_ip").val("<?=xro_ip?>");
	$("#xro_port").val("<?=xro_port?>");
	$("#xro_id").val("<?=xro_id?>");
	$("#xro_pw").val("<?=xro_pw?>");
	$("#xro_db").val("<?=xro_db?>");
	$("#naver_api").val("<?=naver_api?>");
	$("#daum_api").val("<?=daum_api?>");
});
</script>

</body>
</html>


