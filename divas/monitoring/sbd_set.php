<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_set.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<form id="sbd_frm" action="sbd_set.php" method="get">
		<input type="hidden" id="C_SITEID" name="C_SITEID"><!-- 선택한 전광판 아이디 -->
		<input type="hidden" id="C_SITENAME" name="C_SITENAME"><!-- 선택한 전광판 설치장소 -->
		<input type="hidden" id="STR_AREA_CODE" name="STR_AREA_CODE"><!-- 선택한 자동 발령 장비 AREA_CODE -->
		
		<div class="main_contitle">
			<img src="../images/title_08_09.png" alt="전광판 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					전광판 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">상위지역</option>
						<option value="1">지역</option>
						<option value="2">설치장소</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
				</span>  
			</li>
			<li class="li100_nor d_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">번호</th>
							<th class="li10 bL_1gry">상위지역</th>
							<th class="li10 bL_1gry">지역</th>
							<th class="li20 bL_1gry">설치장소</th>
							<th class="li5 bL_1gry">가로크기</th>
							<th class="li5 bL_1gry">세로크기</th>
							<th class="li5 bL_1gry">통신방식</th>
							<th class="li5 bL_1gry">통신속도</th>
							<th class="li10 bL_1gry">IP/전화번호</th>
							<th class="li5 bL_1gry">PORT</th>
							<th class="li10 bL_1gry">GateWay</th>
							<th class="li10 bL_1gry">NetMask</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['NUM']?>" data-id="<?=$val['SITEID']?>">
							<td class="li5"><?=$val['NUM']?></td>
							<td id="l_AREABESTNAME" class="li10 bL_1gry"><?=$val['AREABESTNAME']?></td>
							<td id="l_AREANAME" class="li10 bL_1gry"><?=$val['AREANAME']?></td>
							<td id="l_SITENAME" class="li20 bL_1gry"><?=$val['SITENAME']?></td>
							<td class="li5 bL_1gry"><?=$val['MODX']?></td>
							<td class="li5 bL_1gry"><?=$val['MODY']?></td>
							<td class="li5 bL_1gry"><?=$val['SYSTYPE_NAME']?></td>
							<td class="li5 bL_1gry"><?=$val['BAUDRATE']?></td>
							<td class="li10 bL_1gry"><?=$val['CONTYPE']?></td>
							<td class="li5 bL_1gry"><?=$val['PORT']?></td>
							<td class="li10 bL_1gry"><?=$val['GATEWAY']?></td>
							<td class="li10 bL_1gry"><?=$val['NETMASK']?></td>
						</tr>
				<? 
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="top6px">전광판 등록</span> 
				<span class="sel_right_n">
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL0">상위 지역 / 지역</td>
						<td colspan="4">
							<input type="text" id="AREABESTNAME" name="AREABESTNAME" class="f333_12" size="15" readonly>
							<input type="hidden" id="AREABESTID" name="AREABESTID">
							/
							<input type="text" id="AREANAME" name="AREANAME" class="f333_12" size="15" readonly>
							<input type="hidden" id="AREAID" name="AREAID">
						</td>
						<td class="bg_lb w10 bold al_C">설치 장소</td>
						<td colspan="4"><input type="text" id="SITENAME" name="SITENAME" class="f333_12" size="20"></td>
					</tr>
					<tr>
						<td rowspan="4" class="bg_lb w10 bold al_C bL0">밝기</td>
						<td colspan="9">
							<input type="checkbox" id="USEONOFF1" name="USEONOFF1" value="Y"> 사용
							&nbsp;
							<select id="HOURONOFF1" name="HOURONOFF1" disabled>
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select> 시
							<select id="MINONOFF1" name="MINONOFF1" disabled>
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select> 분
							<select id="RIGHTONOFF1" name="RIGHTONOFF1" disabled>
							<? 
							if($data_right){
								foreach($data_right as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<input type="checkbox" id="USEONOFF2" name="USEONOFF2" value="Y"> 사용
							&nbsp;
							<select id="HOURONOFF2" name="HOURONOFF2" disabled>
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select> 시
							<select id="MINONOFF2" name="MINONOFF2" disabled>
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select> 분
							<select id="RIGHTONOFF2" name="RIGHTONOFF2" disabled>
							<? 
							if($data_right){
								foreach($data_right as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<input type="checkbox" id="USEONOFF3" name="USEONOFF3" value="Y"> 사용
							&nbsp;
							<select id="HOURONOFF3" name="HOURONOFF3" disabled>
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select> 시
							<select id="MINONOFF3" name="MINONOFF3" disabled>
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select> 분
							<select id="RIGHTONOFF3" name="RIGHTONOFF3" disabled>
							<? 
							if($data_right){
								foreach($data_right as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="9">
							<input type="checkbox" id="USEONOFF4" name="USEONOFF4" value="Y"> 사용
							&nbsp;
							<select id="HOURONOFF4" name="HOURONOFF4" disabled>
							<?	
							for($i = 0; $i < 24; $i ++){
								$tmp_h = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_h?>"><?=$tmp_h?></option>
							<? 
							}
							?>
							</select> 시
							<select id="MINONOFF4" name="MINONOFF4" disabled>
							<?	
							for($i = 0; $i < 60; $i ++){
								$tmp_m = ($i< 10) ? '0'.$i : $i;
							?>
								<option value="<?=$tmp_m?>"><?=$tmp_m?></option>
							<? 
							}
							?>
							</select> 분
							<select id="RIGHTONOFF4" name="RIGHTONOFF4" disabled>
							<? 
							if($data_right){
								foreach($data_right as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">통신</td>
						<td colspan="4">
							<select id="SYSTYPE" name="SYSTYPE">
							<? 
							if($data_type){
								foreach($data_type as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">자동 발령</td>
						<td colspan="4">
							<button type="button" id="btn_rtu" class="btn_lbs">장비 설정</button>
						</td>
					</tr>
					<tr id="sys_a" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">IP</td>
						<td colspan="4"><input type="text" id="A_CONTYPE" name="CONTYPE" class="f333_12" size="20"></td>
						<td class="bg_lb w10 bold al_C">PORT</td>
						<td colspan="4"><input type="text" id="A_PORT" name="PORT" class="f333_12" size="20"></td>
					</tr>
					<tr id="sys_b" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">전화번호</td>
						<td colspan="4">
							<input type="text" id="B_CONTYPE" name="CONTYPE" size="20">
						</td>
						<td class="bg_lb w10 bold al_C">포트설정</td>
						<td colspan="2">
							<select id="B_PORT" name="PORT" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">통신속도</td>
						<td colspan="2">
							<select id="B_BAUDRATE" name="BAUDRATE">
								<option value="2400">2400</option>
								<option value="4800">4800</option>
								<option value="9600">9600</option>
								<option value="19200">19200</option>
								<option value="38400">38400</option>
								<option value="57600">57600</option>
							</select>
						</td>
					</tr>
					<tr id="sys_c" style="display: none;">
						<td class="bg_lb w10 bold al_C">포트설정</td>
						<td colspan="4">
							<select id="C_PORT" name="PORT" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<!-- <option value="6">6</option> -->
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">통신속도</td>
						<td colspan="4">
							<select id="C_BAUDRATE" name="BAUDRATE">
								<option value="2400">2400</option>
								<option value="4800">4800</option>
								<option value="9600">9600</option>
								<option value="19200">19200</option>
								<option value="38400">38400</option>
								<option value="57600">57600</option>
							</select>
						</td>
					</tr>
					<tr id="sys_a2" style="display: none;">
						<td class="bg_lb w10 bold al_C bL0">Gateway</td>
						<td colspan="4"><input type="text" id="GATEWAY" name="GATEWAY" class="f333_12" size="20"></td>
						<td class="bg_lb w10 bold al_C">NetMask</td>
						<td colspan="4"><input type="text" id="NETMASK" name="NETMASK" class="f333_12" size="20"></td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">가로 크기</td>
						<td colspan="4">
							<select id="MODX" name="MODX" size="1">
							<?	
							for($i = 1; $i <= 32; $i ++){
							?>
								<option value="<?=$i?>" <?if($i == 10){?> selected <?}?>><?=$i?></option>
							<? 
							}
							?>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">세로 크기</td>
						<td colspan="4">
							<select id="MODY" name="MODY" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">긴급 효과</td>
						<td colspan="4">
							<select id="URGACTION" name="URGACTION" size="1">
							<? 
							if($data_action){
								foreach($data_action as $key => $val){ 
							?>
								<option value="<?=$val['NUM']?>"><?=$val['COMMENT']?></option>
							<? 
								}
							}
							?>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">긴급 속도</td>
						<td colspan="4">
							<select id="URGSPD" name="URGSPD" size="1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select> 1 : 가장빠르게, 10 : 가장느리게
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">긴급 정지시간</td>
						<td colspan="4">
							<select id="URGDELAY" name="URGDELAY" size="1">
							<?	
							for($i = 1; $i <= 20; $i ++){
							?>
								<option value="<?=$i?>" <?if($i == 5){?> selected <?}?>><?=$i?></option>
							<? 
							}
							?>
							</select> 초
						</td>
						<td class="bg_lb w10 bold al_C">긴급 지속시간</td>
						<td colspan="4">
							<input id="URGHOUR" name="URGHOUR" type="text" value="1" size="3">
							시간 
							<input id="URGMIN" name="URGMIN" type="text" value="0" size="3">
							분 (기본 1시간)
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">설치좌표 X</td>
						<td colspan="4"><input type="text" id="POINTX" name="POINTX" class="f333_12" size="15"></td>
						<td class="bg_lb w10 bold al_C">설치좌표 Y</td>
						<td colspan="4"><input type="text" id="POINTY" name="POINTY" class="f333_12" size="15"></td>
					</tr>
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

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" style="display: none;">
	<div id="pop_1" class="popup_layout_c">
		<div class="popup_top">장비 설정
			<button id="popup_close" class="btn_lbs fR bold">X</button>
		</div>
		<div class="popup_con">	
	        <div class="alarm">			
				<div class="w100 alarm_gry h50p bold">
					<span class="fL">설치 장소 :&nbsp;</span>
					<span id="site_name" class="fL"></span>
					<button type="button" id="rtu_all" class="btn_bs fR">전체선택</button>
				</div>
				<form id="rtu_frm" method="get" class="m_scroll">
					<table id="rtu_table" class="tb_data w100">
						<thead>
							<tr class="tb_data_tbg">
								<th>장비명</th>
							</tr>
						</thead>
						<tbody>
							<? 
							if($data_rtu){
								foreach($data_rtu as $key => $val){ 
							?>
							<tr id="rtu_<?=$val['AREA_CODE']?>" data-id="<?=$val['AREA_CODE']?>">
								<td><?=$val['RTU_NAME']?></td>
							</tr>
							<? 
								}
							}
							?>	
						</tbody>
					</table>
				</form>
	        </div>
		</div>
	</div>
	<div id="pop_2" class="popup_layout_b">
		<div class="popup_top">상위지역 설정
			<button id="popup_close" class="btn_lbs fR bold">X</button>
		</div>
		<div class="popup_con_1">		
			<dl>
				<dd id="areab_table" class="group_table bB_1gry">
				<?
				if($data_areab){
					foreach($data_areab as $key => $val){
				?>
					<ul id="areab_<?=$val['AREABESTID']?>">
						<li id="li_AREABESTNAME"><?=$val['AREABESTNAME']?></li>
						<li id="li_AREABESTID" style="display:none"><?=$val['AREABESTID']?></li>
					</ul>
				<?
					}
				}
				?>						
				</dd>
				<dd>
					<ul> 
						<li class="b0 w100 p0 bold">
							<form id="areab_frm" name="areab_frm" method="post">
								지역명 : <input type="text" id="P_AREABESTNAME" name="AREABESTNAME" style="width:260px;">
								<input type="hidden" id="P_AREABESTID" name="AREABESTID">
								<input type="hidden" id="P_AREAB" name="P_AREAB" value="0">
							</form>
						</li>
						<li class="b0 al_C w100">
							<button type="button" id="btn_a_ok" class="btn_bb60">사용</button>
							<button type="button" id="btn_a_in" class="btn_bb60">등록</button>
							<button type="button" id="btn_a_up" class="btn_wbb60">수정</button>
							<button type="button" id="btn_a_de" class="btn_wbb60">삭제</button>
						</li>
					</ul>
				</dd>				
			</dl>	
		</div>
	</div>
	<div id="pop_3" class="popup_layout_b">
		<div class="popup_top">지역 설정
			<button id="popup_close" class="btn_lbs fR bold">X</button>
		</div>
		<div class="popup_con_1">		
			<dl>
				<dd id="area_table" class="group_table bB_1gry">
				<?
				if($data_area){
					foreach($data_area as $key => $val){
				?>
					<ul id="area_<?=$val['AREAID']?>">
						<li id="li_AREANAME"><?=$val['AREANAME']?></li>
						<li id="li_AREAID" style="display:none"><?=$val['AREAID']?></li>
					</ul>
				<?
					}
				}
				?>						
				</dd>
				<dd>
					<ul> 
						<li class="b0 w100 p0 bold">
							<form id="area_frm" name="area_frm" method="post">
								지역명 : <input type="text" id="P_AREANAME" name="AREANAME" style="width:260px;">
								<input type="hidden" id="P_AREAID" name="AREAID">
								<input type="hidden" id="P_AREA" name="P_AREA" value="0">
							</form>
						</li>
						<li class="b0 al_C w100">
							<button type="button" id="btn_b_ok" class="btn_bb60">사용</button>
							<button type="button" id="btn_b_in" class="btn_bb60">등록</button>
							<button type="button" id="btn_b_up" class="btn_wbb60">수정</button>
							<button type="button" id="btn_b_de" class="btn_wbb60">삭제</button>
						</li>
					</ul>
				</dd>				
			</dl>	
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 상위지역
			search_col_id = "l_AREABESTNAME";
		}else if(search_col == "1"){ // 지역
			search_col_id = "l_AREANAME";
		}else if(search_col == "2"){ // 설치장소
			search_col_id = "l_SITENAME";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		$("#rtu_table tbody tr").removeClass("selected"); // 자동 발령 전체 해제
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var SITEID = $(this).data("id");
		
		var param = "mode=sbd&SITEID="+SITEID;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sbd_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
			        var TIMEONOFF1 = data.list.TIMEONOFF1 ? data.list.TIMEONOFF1 : "";
			        var TIMEONOFF2 = data.list.TIMEONOFF2 ? data.list.TIMEONOFF2 : "";
			        var TIMEONOFF3 = data.list.TIMEONOFF3 ? data.list.TIMEONOFF3 : "";
			        var TIMEONOFF4 = data.list.TIMEONOFF4 ? data.list.TIMEONOFF4 : "";
			        var SYSTYPE = data.list.SYSTYPE;
			        var AREA_CODE = data.list.AREA_CODE ? data.list.AREA_CODE : "";
			        
					$("#C_SITEID").val(data.list.SITEID);
					$("#C_SITENAME").val(data.list.SITENAME);
					$("#AREABESTID").val(data.list.AREABESTID);
					$("#AREABESTNAME").val(data.list.AREABESTNAME);
					$("#AREAID").val(data.list.AREAID);
					$("#AREANAME").val(data.list.AREANAME);
					$("#SITENAME").val(data.list.SITENAME);
					if(data.list.USEONOFF1 == "Y"){
						$("#USEONOFF1").prop("checked", true);
						$("#HOURONOFF1").prop("disabled", false);
						$("#MINONOFF1").prop("disabled", false);
						$("#RIGHTONOFF1").prop("disabled", false);
					}else{
						$("#USEONOFF1").prop("checked", false);
						$("#HOURONOFF1").prop("disabled", true);
						$("#MINONOFF1").prop("disabled", true);
						$("#RIGHTONOFF1").prop("disabled", true);
					}
					$("#HOURONOFF1").val(TIMEONOFF1.split(":")[0]);
					$("#MINONOFF1").val(TIMEONOFF1.split(":")[1]);
					$("#RIGHTONOFF1").val(data.list.RIGHTONOFF1);
					if(data.list.USEONOFF2 == "Y"){
						$("#USEONOFF2").prop("checked", true);
						$("#HOURONOFF2").prop("disabled", false);
						$("#MINONOFF2").prop("disabled", false);
						$("#RIGHTONOFF2").prop("disabled", false);
					}else{
						$("#USEONOFF2").prop("checked", false);
						$("#HOURONOFF2").prop("disabled", true);
						$("#MINONOFF2").prop("disabled", true);
						$("#RIGHTONOFF2").prop("disabled", true);
					}
					$("#USEONOFF2").val(data.list.USEONOFF2);
					$("#HOURONOFF2").val(TIMEONOFF2.split(":")[0]);
					$("#MINONOFF2").val(TIMEONOFF2.split(":")[1]);
					$("#RIGHTONOFF2").val(data.list.RIGHTONOFF2);
					if(data.list.USEONOFF3 == "Y"){
						$("#USEONOFF3").prop("checked", true);
						$("#HOURONOFF3").prop("disabled", false);
						$("#MINONOFF3").prop("disabled", false);
						$("#RIGHTONOFF3").prop("disabled", false);
					}else{
						$("#USEONOFF3").prop("checked", false);
						$("#HOURONOFF3").prop("disabled", true);
						$("#MINONOFF3").prop("disabled", true);
						$("#RIGHTONOFF3").prop("disabled", true);
					}
					$("#USEONOFF3").val(data.list.USEONOFF3);
					$("#HOURONOFF3").val(TIMEONOFF3.split(":")[0]);
					$("#MINONOFF3").val(TIMEONOFF3.split(":")[1]);
					$("#RIGHTONOFF3").val(data.list.RIGHTONOFF3);
					if(data.list.USEONOFF4 == "Y"){
						$("#USEONOFF4").prop("checked", true);
						$("#HOURONOFF4").prop("disabled", false);
						$("#MINONOFF4").prop("disabled", false);
						$("#RIGHTONOFF4").prop("disabled", false);
					}else{
						$("#USEONOFF4").prop("checked", false);
						$("#HOURONOFF4").prop("disabled", true);
						$("#MINONOFF4").prop("disabled", true);
						$("#RIGHTONOFF4").prop("disabled", true);
					}
					$("#USEONOFF4").val(data.list.USEONOFF4);
					$("#HOURONOFF4").val(TIMEONOFF4.split(":")[0]);
					$("#MINONOFF4").val(TIMEONOFF4.split(":")[1]);
					$("#RIGHTONOFF4").val(data.list.RIGHTONOFF4);
					$("#SYSTYPE").val(SYSTYPE);
					form_change(SYSTYPE); // 통신에 따른 폼 변경
					if(SYSTYPE == "1"){
						$("#A_CONTYPE").val(data.list.CONTYPE);
						$("#A_PORT").val(data.list.PORT);
					}else if(SYSTYPE == "2"){
						$("#B_CONTYPE").val(data.list.CONTYPE);
						$("#B_PORT").val(data.list.PORT);
						$("#B_BAUDRATE").val(data.list.BAUDRATE);
					}else if(SYSTYPE == "3"){
						$("#C_PORT").val(data.list.PORT);
						$("#C_BAUDRATE").val(data.list.BAUDRATE);
					}
					$("#GATEWAY").val(data.list.GATEWAY);
					$("#NETMASK").val(data.list.NETMASK);
					$("#MODX").val(data.list.MODX);
					$("#MODY").val(data.list.MODY);
					$("#URGACTION").val(data.list.URGACTION);
					$("#URGSPD").val(data.list.URGSPD);
					$("#URGDELAY").val(data.list.URGDELAY);
					$("#URGHOUR").val(data.list.URGHOUR);
					$("#URGMIN").val(data.list.URGMIN);
					$("#POINTX").val(data.list.POINTX);
					$("#POINTY").val(data.list.POINTY);

			        if(AREA_CODE != ""){
						$.each(AREA_CODE.split(","), function(i, v){
							//console.log(i, v);
							$("#rtu_table tbody #rtu_"+v).addClass("selected");
						});
			        }
		        }else{
				    swal("체크", "전광판 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">전광판 등록 확인</div><div class="alpop_mes_b">전광판을 등록하실 겁니까?</div>',
				text: '확인 시 전광판이 등록 됩니다.',
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
					$("#STR_AREA_CODE").val("");
					$.each($("#rtu_table tbody tr"), function(i, v){
				        if( $(v).hasClass("selected") ){
							var STR_AREA_CODE = $("#STR_AREA_CODE").val();
							var AREA_CODE = $(v).data("id");
							
							if(STR_AREA_CODE == ""){
								$("#STR_AREA_CODE").val(AREA_CODE);
							}else{
								$("#STR_AREA_CODE").val(STR_AREA_CODE + "-" + AREA_CODE);
							}
				        }
					});
					//console.log( $("#STR_AREA_CODE").val() );

					var param = "mode=sbd_in&"+$("#sbd_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
								swal("체크", "전광판 등록중 오류가 발생 했습니다.", "warning");
							}
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		$("#rtu_table tbody tr").removeClass("selected"); // 자동 발령 전체 해제
		var SITEID = $("#C_SITEID").val();
		if(SITEID == ""){
			$("#SITEID").val("");
			$("#AREABESTID").val("");
			$("#AREABESTNAME").val("");
			$("#AREAID").val("");
			$("#AREANAME").val("");
			$("#SITENAME").val("");
			$("#USEONOFF1").prop("checked", false);
			$("#HOURONOFF1").prop("disabled", true);
			$("#MINONOFF1").prop("disabled", true);
			$("#RIGHTONOFF1").prop("disabled", true);
			$("#USEONOFF2").prop("checked", false);
			$("#HOURONOFF2").prop("disabled", true);
			$("#MINONOFF2").prop("disabled", true);
			$("#RIGHTONOFF2").prop("disabled", true);
			$("#USEONOFF3").prop("checked", false);
			$("#HOURONOFF3").prop("disabled", true);
			$("#MINONOFF3").prop("disabled", true);
			$("#RIGHTONOFF3").prop("disabled", true);
			$("#USEONOFF4").prop("checked", false);
			$("#HOURONOFF4").prop("disabled", true);
			$("#MINONOFF4").prop("disabled", true);
			$("#RIGHTONOFF4").prop("disabled", true);
			$("#SYSTYPE").val("1");
			form_change(1); // 통신에 따른 폼 변경
			$("#A_CONTYPE").val("");
			$("#A_PORT").val("");
			$("#GATEWAY").val("");
			$("#NETMASK").val("");
			$("#MODX").val(10);
			$("#MODY").val(1);
			$("#URGACTION option:eq(0)").prop("selected", true);
			$("#URGSPD").val(5);
			$("#URGDELAY").val(5);
			$("#URGHOUR").val("1");
			$("#URGMIN").val("0");
			$("#POINTX").val("");
			$("#POINTY").val("");
		}else{
			var param = "mode=sbd&SITEID="+SITEID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_sbd_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
				        var TIMEONOFF1 = data.list.TIMEONOFF1 ? data.list.TIMEONOFF1 : "";
				        var TIMEONOFF2 = data.list.TIMEONOFF2 ? data.list.TIMEONOFF2 : "";
				        var TIMEONOFF3 = data.list.TIMEONOFF3 ? data.list.TIMEONOFF3 : "";
				        var TIMEONOFF4 = data.list.TIMEONOFF4 ? data.list.TIMEONOFF4 : "";
				        var SYSTYPE = data.list.SYSTYPE;
				        var AREA_CODE = data.list.AREA_CODE ? data.list.AREA_CODE : "";
				        
						$("#C_SITEID").val(data.list.SITEID);
						$("#C_SITENAME").val(data.list.SITENAME);
						$("#AREABESTID").val(data.list.AREABESTID);
						$("#AREABESTNAME").val(data.list.AREABESTNAME);
						$("#AREAID").val(data.list.AREAID);
						$("#AREANAME").val(data.list.AREANAME);
						$("#SITENAME").val(data.list.SITENAME);
						if(data.list.USEONOFF1 == "Y"){
							$("#USEONOFF1").prop("checked", true);
							$("#HOURONOFF1").prop("disabled", false);
							$("#MINONOFF1").prop("disabled", false);
							$("#RIGHTONOFF1").prop("disabled", false);
						}else{
							$("#USEONOFF1").prop("checked", false);
							$("#HOURONOFF1").prop("disabled", true);
							$("#MINONOFF1").prop("disabled", true);
							$("#RIGHTONOFF1").prop("disabled", true);
						}
						$("#HOURONOFF1").val(TIMEONOFF1.split(":")[0]);
						$("#MINONOFF1").val(TIMEONOFF1.split(":")[1]);
						$("#RIGHTONOFF1").val(data.list.RIGHTONOFF1);
						if(data.list.USEONOFF2 == "Y"){
							$("#USEONOFF2").prop("checked", true);
							$("#HOURONOFF2").prop("disabled", false);
							$("#MINONOFF2").prop("disabled", false);
							$("#RIGHTONOFF2").prop("disabled", false);
						}else{
							$("#USEONOFF2").prop("checked", false);
							$("#HOURONOFF2").prop("disabled", true);
							$("#MINONOFF2").prop("disabled", true);
							$("#RIGHTONOFF2").prop("disabled", true);
						}
						$("#USEONOFF2").val(data.list.USEONOFF2);
						$("#HOURONOFF2").val(TIMEONOFF2.split(":")[0]);
						$("#MINONOFF2").val(TIMEONOFF2.split(":")[1]);
						$("#RIGHTONOFF2").val(data.list.RIGHTONOFF2);
						if(data.list.USEONOFF3 == "Y"){
							$("#USEONOFF3").prop("checked", true);
							$("#HOURONOFF3").prop("disabled", false);
							$("#MINONOFF3").prop("disabled", false);
							$("#RIGHTONOFF3").prop("disabled", false);
						}else{
							$("#USEONOFF3").prop("checked", false);
							$("#HOURONOFF3").prop("disabled", true);
							$("#MINONOFF3").prop("disabled", true);
							$("#RIGHTONOFF3").prop("disabled", true);
						}
						$("#USEONOFF3").val(data.list.USEONOFF3);
						$("#HOURONOFF3").val(TIMEONOFF3.split(":")[0]);
						$("#MINONOFF3").val(TIMEONOFF3.split(":")[1]);
						$("#RIGHTONOFF3").val(data.list.RIGHTONOFF3);
						if(data.list.USEONOFF4 == "Y"){
							$("#USEONOFF4").prop("checked", true);
							$("#HOURONOFF4").prop("disabled", false);
							$("#MINONOFF4").prop("disabled", false);
							$("#RIGHTONOFF4").prop("disabled", false);
						}else{
							$("#USEONOFF4").prop("checked", false);
							$("#HOURONOFF4").prop("disabled", true);
							$("#MINONOFF4").prop("disabled", true);
							$("#RIGHTONOFF4").prop("disabled", true);
						}
						$("#USEONOFF4").val(data.list.USEONOFF4);
						$("#HOURONOFF4").val(TIMEONOFF4.split(":")[0]);
						$("#MINONOFF4").val(TIMEONOFF4.split(":")[1]);
						$("#RIGHTONOFF4").val(data.list.RIGHTONOFF4);
						$("#SYSTYPE").val(SYSTYPE);
						form_change(SYSTYPE); // 통신에 따른 폼 변경
						if(SYSTYPE == "1"){
							$("#A_CONTYPE").val(data.list.CONTYPE);
							$("#A_PORT").val(data.list.PORT);
						}else if(SYSTYPE == "2"){
							$("#B_CONTYPE").val(data.list.CONTYPE);
							$("#B_PORT").val(data.list.PORT);
							$("#B_BAUDRATE").val(data.list.BAUDRATE);
						}else if(SYSTYPE == "3"){
							$("#C_PORT").val(data.list.PORT);
							$("#C_BAUDRATE").val(data.list.BAUDRATE);
						}
						$("#GATEWAY").val(data.list.GATEWAY);
						$("#NETMASK").val(data.list.NETMASK);
						$("#MODX").val(data.list.MODX);
						$("#MODY").val(data.list.MODY);
						$("#URGACTION").val(data.list.URGACTION);
						$("#URGSPD").val(data.list.URGSPD);
						$("#URGDELAY").val(data.list.URGDELAY);
						$("#URGHOUR").val(data.list.URGHOUR);
						$("#URGMIN").val(data.list.URGMIN);
						$("#POINTX").val(data.list.POINTX);
						$("#POINTY").val(data.list.POINTY);

				        if(AREA_CODE != ""){
							$.each(AREA_CODE.split(","), function(i, v){
								//console.log(i, v);
								$("#rtu_table tbody #rtu_"+v).addClass("selected");
							});
				        }
			        }else{
					    swal("체크", "초기화중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });
		}
	});

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var SITENAME = $("#C_SITENAME").val();
			swal({
				title: '<div class="alpop_top_b">전광판 수정 확인</div><div class="alpop_mes_b">['+SITENAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 전광판이 수정 됩니다.',
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
					$("#STR_AREA_CODE").val("");
					$.each($("#rtu_table tbody tr"), function(i, v){
				        if( $(v).hasClass("selected") ){
							var STR_AREA_CODE = $("#STR_AREA_CODE").val();
							var AREA_CODE = $(v).data("id");
							
							if(STR_AREA_CODE == ""){
								$("#STR_AREA_CODE").val(AREA_CODE);
							}else{
								$("#STR_AREA_CODE").val(STR_AREA_CODE + "-" + AREA_CODE);
							}
				        }
					});
					//console.log( $("#STR_AREA_CODE").val() );

					var param = "mode=sbd_up&"+$("#sbd_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
								swal("체크", "전광판 수정중 오류가 발생 했습니다.", "warning");
							}
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 삭제
	$("#btn_de").click(function(){
		if( form_check("D") ){
			var SITENAME = $("#C_SITENAME").val();
			swal({
				title: '<div class="alpop_top_b">전광판 삭제 확인</div><div class="alpop_mes_b">['+SITENAME+']을 등록하실 겁니까?</div>',
				text: '확인 시 전광판이 삭제 됩니다.',
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
					$("#STR_AREA_CODE").val("");
					$.each($("#rtu_table tbody tr"), function(i, v){
				        if( $(v).hasClass("selected") ){
							var STR_AREA_CODE = $("#STR_AREA_CODE").val();
							var AREA_CODE = $(v).data("id");
							
							if(STR_AREA_CODE == ""){
								$("#STR_AREA_CODE").val(AREA_CODE);
							}else{
								$("#STR_AREA_CODE").val(STR_AREA_CODE + "-" + AREA_CODE);
							}
				        }
					});
					//console.log( $("#STR_AREA_CODE").val() );

					var param = "mode=sbd_de&"+$("#sbd_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
								swal("체크", "전광판 삭제중 오류가 발생 했습니다.", "warning");
							}
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 상위지역 선택
	$("#AREABESTNAME").click(function(){
		$("#pop_2").show();
		$("#pop_1").hide();
		$("#pop_3").hide();
		popup_open(); // 레이어 팝업 열기
	});

	// 상위지역 설정 선택
	$(document).on("click", "#areab_table ul", function(){
		bg_color("bg_sel", "#areab_table ul", this); // 리스트 선택 시 배경색
		
		var tmp_id = "#"+this.id;
		$("#P_AREABESTNAME").val( $(tmp_id+" #li_AREABESTNAME").text() );
		$("#P_AREABESTID").val( $(tmp_id+" #li_AREABESTID").text() );
		$("#P_AREAB").val(1); // 사용 버튼 사용가능
	});

	// 상위지역 설정 지역명 변경 시
	$("#P_AREABESTNAME").change(function(){
		$("#P_AREAB").val(0); // 사용 버튼 사용불가
	});

	// 상위지역 설정 사용
	$("#btn_a_ok").click(function(){
		if( !$("#P_AREABESTID").val() ){
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else if( $("#P_AREAB").val() == "0" ){
			swal("체크", "지역명 변경 시 수정 후 이용해 주세요.", "warning");
			return false;
		}else{
			$("#AREABESTNAME").val( $("#P_AREABESTNAME").val() );
			$("#AREABESTID").val( $("#P_AREABESTID").val() );
			popup_close(); // 레이어 팝업 닫기
		}
	});
		
	// 상위지역 설정 등록
	$("#btn_a_in").click(function(){
		bg_color("bg_sel", "#areab_table ul", null); // 리스트 선택 시 배경색

		if( !$("#P_AREABESTNAME").val() ){
			swal("체크", "지역명을 입력해 주세요.", "warning");
			$("#P_AREABESTNAME").focus(); return false;
		}else{
			var param = "mode=areab_in&"+$("#areab_frm").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_sbd_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result[0]){
						var AREABESTNAME = $("#P_AREABESTNAME").val();
						var tmp_ul = '<ul id="areab_'+data.result[1]+'">';
						tmp_ul += '<li id="li_AREABESTNAME">'+AREABESTNAME+'</li>';
						tmp_ul += '<li id="li_AREABESTID" style="display:none">'+data.result[1]+'</li>';
						tmp_ul += '</ul>';
						$("#areab_table").append(tmp_ul);
						$("#P_AREABESTID").val("");
						$("#P_AREABESTNAME").val("");
						$("#P_AREAB").val(0); // 사용 버튼 사용불가
			        }else{
					    swal("체크", "상위지역 등록중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });	
		}
	});
	
	// 상위지역 설정 수정
	$("#btn_a_up").click(function(){
		if( !bg_color_check("bg_sel", "#areab_table ul") ){ // 리스트 선택 체크
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">상위지역 수정 확인</div>\
						<div class="alpop_mes_b">['+$("#P_AREABESTNAME").val()+']로 수정하실 겁니까?</div>',
				text: '확인 시 바로 수정 됩니다.',
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
					var param = "mode=areab_up&"+$("#areab_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
								var AREABESTID = $("#P_AREABESTID").val();
								var AREABESTNAME = $("#P_AREABESTNAME").val();
								$("#areab_"+AREABESTID+" #li_AREABESTNAME").text(AREABESTNAME);
								$("#P_AREAB").val(1); // 사용 버튼 사용가능
								swal.close();
					        }else{
							    swal("체크", "상위지역 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 상위지역 설정 삭제
	$("#btn_a_de").click(function(){
		if( !bg_color_check("bg_sel", "#areab_table ul") ){ // 리스트 선택 체크
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">상위지역 삭제 확인</div>\
						<div class="alpop_mes_b">['+$("#P_AREABESTNAME").val()+']를 삭제하실 겁니까?</div>',
				text: '확인 시 바로 삭제 됩니다.',
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
					var param = "mode=areab_de&"+$("#areab_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result == 0){
							    swal("체크", "상위지역 삭제중 오류가 발생 했습니다.", "warning");
					        }else if(data.result == 1){
							    swal("체크", "전광판 목록에서 사용중인 지역은 삭제할 수 없습니다.", "warning");
					        }else if(data.result == 2){
								var AREABESTID = $("#P_AREABESTID").val();
								var AREABESTNAME = $("#P_AREABESTNAME").val();
								$("#areab_"+AREABESTID).remove();
								$("#P_AREABESTID").val("");
								$("#P_AREABESTNAME").val("");
								$("#P_AREAB").val(0); // 사용 버튼 사용불가
								swal.close();
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 지역 선택
	$("#AREANAME").click(function(){
		$("#pop_3").show();
		$("#pop_1").hide();
		$("#pop_2").hide();
		popup_open(); // 레이어 팝업 열기
	});

	// 지역 설정 선택
	$(document).on("click", "#area_table ul", function(){
		bg_color("bg_sel", "#area_table ul", this); // 리스트 선택 시 배경색
		
		var tmp_id = "#"+this.id;
		$("#P_AREANAME").val( $(tmp_id+" #li_AREANAME").text() );
		$("#P_AREAID").val( $(tmp_id+" #li_AREAID").text() );
		$("#P_AREA").val(1); // 사용 버튼 사용가능
	});

	// 지역 설정 지역명 변경 시
	$("#P_AREANAME").change(function(){
		$("#P_AREA").val(0); // 사용 버튼 사용불가
	});

	// 지역 설정 사용
	$("#btn_b_ok").click(function(){
		if( !$("#P_AREAID").val() ){
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else if( $("#P_AREA").val() == "0" ){
			swal("체크", "지역명 변경 시 수정 후 이용해 주세요.", "warning");
			return false;
		}else{
			$("#AREANAME").val( $("#P_AREANAME").val() );
			$("#AREAID").val( $("#P_AREAID").val() );
			popup_close(); // 레이어 팝업 닫기
		}
	});
	
	// 지역 설정 등록
	$("#btn_b_in").click(function(){
		bg_color("bg_sel", "#area_table ul", null); // 리스트 선택 시 배경색

		if( !$("#P_AREANAME").val() ){
			swal("체크", "지역명을 입력해 주세요.", "warning");
			$("#P_AREANAME").focus(); return false;
		}else{
			var param = "mode=area_in&"+$("#area_frm").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_sbd_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result[0]){
						var AREANAME = $("#P_AREANAME").val();
						var tmp_ul = '<ul id="area_'+data.result[1]+'">';
						tmp_ul += '<li id="li_AREANAME">'+AREANAME+'</li>';
						tmp_ul += '<li id="li_AREAID" style="display:none">'+data.result[1]+'</li>';
						tmp_ul += '</ul>';
						$("#area_table").append(tmp_ul);
						$("#P_AREAID").val("");
						$("#P_AREANAME").val("");
						$("#P_AREA").val(0); // 사용 버튼 사용불가
			        }else{
					    swal("체크", "지역 등록중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });	
		}
	});
	
	// 지역 설정 수정
	$("#btn_b_up").click(function(){
		if( !bg_color_check("bg_sel", "#area_table ul") ){ // 리스트 선택 체크
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">지역 수정 확인</div>\
						<div class="alpop_mes_b">['+$("#P_AREANAME").val()+']로 수정하실 겁니까?</div>',
				text: '확인 시 바로 수정 됩니다.',
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
					var param = "mode=area_up&"+$("#area_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
								var AREAID = $("#P_AREAID").val();
								var AREANAME = $("#P_AREANAME").val();
								$("#area_"+AREAID+" #li_AREANAME").text(AREANAME);
								$("#P_AREA").val(1); // 사용 버튼 사용가능
								swal.close();
					        }else{
							    swal("체크", "지역 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 지역 설정 삭제
	$("#btn_b_de").click(function(){
		if( !bg_color_check("bg_sel", "#area_table ul") ){ // 리스트 선택 체크
			swal("체크", "지역을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">지역 삭제 확인</div>\
						<div class="alpop_mes_b">['+$("#P_AREANAME").val()+']를 삭제하실 겁니까?</div>',
				text: '확인 시 바로 삭제 됩니다.',
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
					var param = "mode=area_de&"+$("#area_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_sbd_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result == 0){
							    swal("체크", "지역 삭제중 오류가 발생 했습니다.", "warning");
					        }else if(data.result == 1){
							    swal("체크", "전광판 목록에서 사용중인 지역은 삭제할 수 없습니다.", "warning");
					        }else if(data.result == 2){
								var AREAID = $("#P_AREAID").val();
								var AREANAME = $("#P_AREANAME").val();
								$("#area_"+AREAID).remove();
								$("#P_AREAID").val("");
								$("#P_AREANAME").val("");
								$("#P_AREA").val(0); // 사용 버튼 사용불가
								swal.close();
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 밝기 사용 여부
	$("#USEONOFF1").change(function(){
		if( $("#USEONOFF1").prop("checked") ){
			$("#HOURONOFF1").prop("disabled", false);
			$("#MINONOFF1").prop("disabled", false);
			$("#RIGHTONOFF1").prop("disabled", false);
		}else{
			$("#HOURONOFF1").prop("disabled", true);
			$("#MINONOFF1").prop("disabled", true);
			$("#RIGHTONOFF1").prop("disabled", true);
		}
	});
	$("#USEONOFF2").change(function(){
		if( $("#USEONOFF2").prop("checked") ){
			$("#HOURONOFF2").prop("disabled", false);
			$("#MINONOFF2").prop("disabled", false);
			$("#RIGHTONOFF2").prop("disabled", false);
		}else{
			$("#HOURONOFF2").prop("disabled", true);
			$("#MINONOFF2").prop("disabled", true);
			$("#RIGHTONOFF2").prop("disabled", true);
		}
	});
	$("#USEONOFF3").change(function(){
		if( $("#USEONOFF3").prop("checked") ){
			$("#HOURONOFF3").prop("disabled", false);
			$("#MINONOFF3").prop("disabled", false);
			$("#RIGHTONOFF3").prop("disabled", false);
		}else{
			$("#HOURONOFF3").prop("disabled", true);
			$("#MINONOFF3").prop("disabled", true);
			$("#RIGHTONOFF3").prop("disabled", true);
		}
	});
	$("#USEONOFF4").change(function(){
		if( $("#USEONOFF4").prop("checked") ){
			$("#HOURONOFF4").prop("disabled", false);
			$("#MINONOFF4").prop("disabled", false);
			$("#RIGHTONOFF4").prop("disabled", false);
		}else{
			$("#HOURONOFF4").prop("disabled", true);
			$("#MINONOFF4").prop("disabled", true);
			$("#RIGHTONOFF4").prop("disabled", true);
		}
	});

	// 통신 변경
	$("#SYSTYPE").change(function(){
		form_change(this.value); // 통신에 따른 폼 변경
	});
	
	// 자동 발령
	$("#btn_rtu").click(function(){
		$("#site_name").text( $("#SITENAME").val() );
		$("#pop_1").show();
		$("#pop_2").hide();
		$("#pop_3").hide();
		popup_open(); // 레이어 팝업 열기
	});	

	// 자동 발령 선택
	$("#rtu_table tbody tr").click(function(){
        if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
			$(this).addClass("selected");
        }
	});
	
	// 자동 발령 전체 선택
	$("#rtu_all").click(function(){
		var all_cnt = $("#rtu_table tbody tr").length;
		var sel_cnt = $("#rtu_table tbody tr.selected").length;
		if(all_cnt == sel_cnt){
			$("#rtu_table tbody tr").removeClass("selected");
		}else{
			$("#rtu_table tbody tr").addClass("selected");
		}
	});

	// 통신에 따른 폼 변경
	function form_change(type){
		if(type == "1"){ // TCP/IP
			$("#sys_a").show();
			$("#sys_a2").show();
			$("#sys_b").hide();
			$("#sys_c").hide();
			$("#sys_a input").prop("disabled", false);
			$("#sys_a2 input").prop("disabled", false);
			$("#sys_b input").prop("disabled", true);
			$("#sys_b select").prop("disabled", true);
			$("#sys_c select").prop("disabled", true);
		}else if(type == "2"){ // CDMA
			$("#sys_b").show();
			$("#sys_a").hide();
			$("#sys_a2").hide();
			$("#sys_c").hide();
			$("#sys_b input").prop("disabled", false);
			$("#sys_b select").prop("disabled", false);
			$("#sys_a input").prop("disabled", true);
			$("#sys_a2 input").prop("disabled", true);
			$("#sys_c select").prop("disabled", true);
		}else if(type == "3"){ // 232 통신
			$("#sys_c").show();
			$("#sys_a").hide();
			$("#sys_a2").hide();
			$("#sys_b").hide();
			$("#sys_c select").prop("disabled", false);
			$("#sys_a input").prop("disabled", true);
			$("#sys_a2 input").prop("disabled", true);
			$("#sys_b input").prop("disabled", true);
			$("#sys_b select").prop("disabled", true);
		}
	}
	
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#AREABESTID").val() ){
			    swal("체크", "상위 지역을 선택해 주세요.", "warning");
			    $("#AREABESTID").focus(); return false;	
			}else if( !$("#AREAID").val() ){
			    swal("체크", "지역을 선택해 주세요.", "warning");
			    $("#AREAID").focus(); return false;	
			}else if( !$("#SITENAME").val() ){
			    swal("체크", "설치 장소를 입력해 주세요.", "warning");
			    $("#SITENAME").focus(); return false;	
			}else if( $("#SYSTYPE").val() == "1" ){
				if( !$("#A_CONTYPE").val() ){
				    swal("체크", "IP를 입력해 주세요.", "warning");
				    $("#A_CONTYPE").focus(); return false;	
				}else if( !$("#A_PORT").val() ){
			    	swal("체크", "PORT를 입력해 주세요.", "warning");
			    	$("#A_PORT").focus(); return false;	
				}else if( !$("#GATEWAY").val() ){
				    swal("체크", "Gateway를 입력해 주세요.", "warning");
				    $("#GATEWAY").focus(); return false;	
				}else if( !$("#NETMASK").val() ){
			    	swal("체크", "NetMask를 입력해 주세요.", "warning");
			    	$("#NETMASK").focus(); return false;	
				}
			}else if( $("#SYSTYPE").val() == "2" ){
				if( !$("#B_CONTYPE").val() ){
				    swal("체크", "전화번호를 입력해 주세요.", "warning");
				    $("#B_CONTYPE").focus(); return false;	
				}else if( !$("#B_PORT").val() ){
			    	swal("체크", "포트설정을 선택해 주세요.", "warning");
			    	$("#B_PORT").focus(); return false;	
				}else if( !$("#B_BAUDRATE").val() ){
			    	swal("체크", "통신속도를 선택해 주세요.", "warning");
			    	$("#B_BAUDRATE").focus(); return false;	
				}
			}else if( $("#SYSTYPE").val() == "3" ){
				if( !$("#C_PORT").val() ){
			    	swal("체크", "포트설정을 선택해 주세요.", "warning");
			    	$("#C_PORT").focus(); return false;	
				}else if( !$("#C_BAUDRATE").val() ){
			    	swal("체크", "통신속도를 선택해 주세요.", "warning");
			    	$("#C_BAUDRATE").focus(); return false;	
				}
			}
		}else if(kind == "U"){
			if( !$("#C_SITEID").val() ){
			    swal("체크", "전광판을 선택해 주세요.", "warning"); return false;
			}else if( !$("#AREABESTID").val() ){
			    swal("체크", "상위 지역을 선택해 주세요.", "warning");
			    $("#AREABESTID").focus(); return false;	
			}else if( !$("#AREAID").val() ){
			    swal("체크", "지역을 선택해 주세요.", "warning");
			    $("#AREAID").focus(); return false;	
			}else if( !$("#SITENAME").val() ){
			    swal("체크", "설치 장소를 입력해 주세요.", "warning");
			    $("#SITENAME").focus(); return false;	
			}else if( $("#SYSTYPE").val() == "1" ){
				if( !$("#A_CONTYPE").val() ){
				    swal("체크", "IP를 입력해 주세요.", "warning");
				    $("#A_CONTYPE").focus(); return false;	
				}else if( !$("#A_PORT").val() ){
			    	swal("체크", "PORT를 입력해 주세요.", "warning");
			    	$("#A_PORT").focus(); return false;	
				}else if( !$("#GATEWAY").val() ){
				    swal("체크", "Gateway를 입력해 주세요.", "warning");
				    $("#GATEWAY").focus(); return false;	
				}else if( !$("#NETMASK").val() ){
			    	swal("체크", "NetMask를 입력해 주세요.", "warning");
			    	$("#NETMASK").focus(); return false;	
				}
			}else if( $("#SYSTYPE").val() == "2" ){
				if( !$("#B_CONTYPE").val() ){
				    swal("체크", "전화번호를 입력해 주세요.", "warning");
				    $("#B_CONTYPE").focus(); return false;	
				}else if( !$("#B_PORT").val() ){
			    	swal("체크", "포트설정을 선택해 주세요.", "warning");
			    	$("#B_PORT").focus(); return false;	
				}else if( !$("#B_BAUDRATE").val() ){
			    	swal("체크", "통신속도를 선택해 주세요.", "warning");
			    	$("#B_BAUDRATE").focus(); return false;	
				}
			}else if( $("#SYSTYPE").val() == "3" ){
				if( !$("#C_PORT").val() ){
			    	swal("체크", "포트설정을 선택해 주세요.", "warning");
			    	$("#C_PORT").focus(); return false;	
				}else if( !$("#C_BAUDRATE").val() ){
			    	swal("체크", "통신속도를 선택해 주세요.", "warning");
			    	$("#C_BAUDRATE").focus(); return false;	
				}
			}
		}else if(kind == "D"){
			if( !$("#C_SITEID").val() ){
			    swal("체크", "전광판을 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#C_SITEID").val("");
	$("#C_SITENAME").val("");
	$("#STR_AREA_CODE").val("");
	$("#SITEID").val("");
	$("#AREABESTID").val("");
	$("#AREABESTNAME").val("");
	$("#AREAID").val("");
	$("#AREANAME").val("");
	$("#SITENAME").val("");
	$("#USEONOFF1").prop("checked", false);
	$("#HOURONOFF1").prop("disabled", true);
	$("#MINONOFF1").prop("disabled", true);
	$("#RIGHTONOFF1").prop("disabled", true);
	$("#USEONOFF2").prop("checked", false);
	$("#HOURONOFF2").prop("disabled", true);
	$("#MINONOFF2").prop("disabled", true);
	$("#RIGHTONOFF2").prop("disabled", true);
	$("#USEONOFF3").prop("checked", false);
	$("#HOURONOFF3").prop("disabled", true);
	$("#MINONOFF3").prop("disabled", true);
	$("#RIGHTONOFF3").prop("disabled", true);
	$("#USEONOFF4").prop("checked", false);
	$("#HOURONOFF4").prop("disabled", true);
	$("#MINONOFF4").prop("disabled", true);
	$("#RIGHTONOFF4").prop("disabled", true);
	$("#SYSTYPE").val("1");
	form_change(1); // 통신에 따른 폼 변경
	$("#A_CONTYPE").val("");
	$("#A_PORT").val("");
	$("#GATEWAY").val("");
	$("#NETMASK").val("");
	$("#MODX").val(10);
	$("#MODY").val(1);
	$("#URGACTION option:eq(0)").prop("selected", true);
	$("#URGSPD").val(5);
	$("#URGDELAY").val(5);
	$("#URGHOUR").val("1");
	$("#URGMIN").val("0");
	$("#POINTX").val("");
	$("#POINTY").val("");
});
</script>

</body>
</html>


