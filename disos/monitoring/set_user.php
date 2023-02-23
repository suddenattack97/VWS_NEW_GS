<?
require_once "../_conf/_common.php";
require_once "../_info/_set_user.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	<textarea id="publicKey" cols="66" rows="7" style="display:none;">-----BEGIN PUBLIC KEY-----
	MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpFrdz4NJSmGDVWDjVvIHHTrCn
	VXEMXv4XhOQK1DuqwNEJ5X2jD1Ma/maF6BJePK9T4lA99cCAyWZ6ySSUoBVkrEL1
	5F2GfzJ9BF31y6HByKYiRc8KUxkMNHesR+00ZvGZsHxfHSYvfRztBffd+IRyy1ep
	wd+TfN++aIZJivncuQIDAQAB
	-----END PUBLIC KEY-----</textarea>
		<form id="set_frm" action="set_user.php" method="post">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 사용자 아이디 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_USER_ID" name="C_USER_ID"><!-- 선택한 사용자 아이디 -->
		<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송권한 지역 RTU_ID -->
		<input type="hidden" id="mode" name="mode">
		<input type="hidden" name="OTT" value="<? echo $ott; ?>">
		<div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>관리자 설정</span>
					<span id="rtu_name" class="sub_tit mL20"></span>
					</div>  				
		</div>
		<div class="right_bg2 mB20">
		<ul id="search_box">
					<li>
					<span class="tit"> 관리자 목록 조회 : </span>
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">관리자 ID</option>
						<option value="1">관리자명</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bb80 mL_10"><i class="fa fa-search mR_5 font15"></i>조회</button>
					<button type="button" id="btn_search_all" class="btn_lbb80_s w90p"><i class="fa fa-list-alt mR_5 font15"></i>전체목록</button>
			</li>
			</ul>
		<ul class="set_ulwrap_nh">
			<li class="li100_nor s_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">번호</th>
							<th class="li15 bL_1gry">관리자 ID</th>
							<th class="li25 bL_1gry">관리자명</th>
							<th class="li25 bL_1gry">휴대폰 번호</th>
							<!-- <th class="li15 bL_1gry">사용자 구분</th> -->
							<!-- <th class="li15 bL_1gry">문자 알림</th> -->
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					$rowCnt = set_cnt - 3;
					$num = 0;
					foreach($data_list as $key => $val){ 
							$num++;
							?>
						<tr id="list_<?=$num?>">
							<td class="li5"><?=$num?></td>
							<td id="l_USER_ID" class="li15 bL_1gry"><?=$val['USER_ID']?></td>
							<td id="l_USER_NAME" class="li25 bL_1gry"><?=$val['USER_NAME']?></td>
							<td class="li25 bL_1gry"><?=$val['MOBILE']?></td>
							<!-- <td class="li15 bL_1gry"><?=$val['USER_TYPE_NAME']?></td> -->
							<!-- <td class="li15 bL_1gry"><?=$val['IS_PERMIT_NAME']?></td> -->
						</tr>
				<? 
					}
					for($i=0; $i<($rowCnt-$num); $i++){
						echo "<tr class='not_d'>
						<td></td><td></td><td></td><td></td>
						</tr>";
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		</div>
			<div class="right_bg2">
			<ul id="search_box">
					<li>
					<span class="tit">	설정값 입력 </span>
					<!--<span class="sel_right_n">
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span>-->
					</li>
					</ul>
		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL0">소속기관</td>
						<td colspan="3">
						<?
						if($data_organ){
							foreach($data_organ as $key => $val){
						?>
								<input type="text" value="<?=$val['ORGAN_NAME']?>" size="18" class="f333_12 bg_lgr_d" readonly>
						<? 
								break;
							}
						}
						?>
							<input id="ORGAN_ID" name="ORGAN_ID" class="f333_12" type="hidden" value="1">
						</td>
					</tr>
					
					<tr>
						<td class="bg_lb w10 bold al_C bL0">관리자 ID</td>
						<td colspan="3">
							<input id="USER_ID" name="USER_ID" type="text" class="f333_12" size="18" maxlength="15">
							<button type="button" id="btn_check"  class="btn_bbr w100p">중복체크</button>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">비밀번호</td>
						<td colspan="3">
							<input id="USER_PWD_LEN" name="USER_PWD_LEN" type="password" class="f333_12" size="18" maxlength="20">
							<input id="USER_PWD" name="USER_PWD" type="password" style="display:none" maxlength="20">
							<span> <i class="fa fa-exclamation-circle col_org mR_5"></i>영어, 숫자, <span class="spc">특수문자(!@#$%^&*)</span>를 적어도 하나씩 사용해서 8자리 이상, 20자리 이하</spna>
							<!-- <div id="popSpc">! @ # $ % ^ & *</div> -->
						</td>
					</tr>
					<!-- <tr>
						<td class="bg_lb w10 bold al_C bL0">비밀번호 확인</td>
						<td colspan="3"><input id="USER_PWD_RE" type="password" class="f333_12" size="18"></td>
					</tr> -->
					<tr>
						<td class="bg_lb w10 bold al_C bL0">관리자명</td>
						<td colspan="3"><input id="USER_NAME" name="USER_NAME" type="text" class="f333_12" size="18" maxlength="10"></td>
					</tr>
					<tr>
						<td height="35" class="bg_lb w10 bold al_C bL0">이메일</td>
						<td colspan="3">
							<input id="EMAIL1" name="EMAIL1" type="text" class="f333_12" size="10" maxlength="20"> @ 
							<select id="EMAIL2" name="EMAIL2" class="f333_12">
								<option value="naver.com">naver.com</option>
								<option value="hanmail.net">hanmail.net</option>
								<option value="daum.net">daum.net</option>
								<option value="nate.com">nate.com</option>
								<option value="gmail.com">gmail.com</option>
								<option value="0">직접입력</option>
							</select> / 
							<input id="EMAIL3" name="EMAIL3" type="text" class="f333_12" size="32" maxlength="20" onblur="inputCheck(this,'onlyEmail','')">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">휴대폰 번호 (SMS)</td>
						<td colspan="3" class="w400p">
							<select id="MOBILE1" name="MOBILE1" size="1" class="f333_12">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="019">019</option>
							</select>
							- 
							<input id="MOBILE2" name="MOBILE2" type="text" class="f333_12" size="6" maxlength="4" oninput="inputCheck(this,'onlyNumber','0~9999')">
							-
							<input id="MOBILE3" name="MOBILE3" type="text" class="f333_12" size="6" maxlength="4" oninput="inputCheck(this,'onlyNumber','0~9999')">
						</td>
						<!-- <td class="bg_lb w10 bold al_C">장비 상태 알림</td>
						<td>
							<select id="IS_PERMIT" name="IS_PERMIT" class="f333_12">
								<option value="0">미알림</option>
								<option value="1">알림</option>
							</select>
						</td> -->
					</tr>
					<!-- <tr>
						<td class="bg_lb w10 bold al_C bL0">휴대폰 번호 (APP)</td>
						<td>
							<select id="SMART_MOBILE1" name="SMART_MOBILE1" size="1" class="gaigi12">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="019">019</option>
							</select> 
							- 
							<input id="SMART_MOBILE2" name="SMART_MOBILE2" type="text" class="f333_12" size="6" maxlength="4">
							-
							<input id="SMART_MOBILE3" name="SMART_MOBILE3" type="text" class="f333_12" size="6" maxlength="4">
						</td>
						<td class="bg_lb w10 bold al_C">어플 접속 승인</td>
						<td>
							<select id="SMART_USE" name="SMART_USE" size="1" class="f333_12">
								<option value="0">미승인</option>
								<option value="1">승인</option>
							</select>
						</td>
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
<!-- <div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div class="popup_top">방송권한 지역선택
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con">
		<div class="alarm">
			<ul>
				<li class="alarm_gry">방송지역 선택 : <span id="rtu_cnt_text">0</span> 개소
					<button type="button" id="btn_all" class="btn_bs60">전체선택</button>
				</li>
				<li id="tree">					
					<ul>
					<?
					if($data_equip){
						foreach($data_equip as $key => $val){
					?>
						<li id="tree_<?=$val['GROUP_ID']?>" type="group"><?=$val['GROUP_NAME']."(".$val['RTU_CNT']."개소)"?>
							<ul>
						
					<? 
							if($data_equip2){
								foreach($data_equip2 as $key2 => $val2){
									if($val['GROUP_ID'] == $val2['GROUP_ID']){
					?>
								<li id="tree_<?=$val['GROUP_ID']?>_<?=$val2['RTU_ID']?>" type="rtu" group_id="<?=$val['GROUP_ID']?>" rtu_id="<?=$val2['RTU_ID']?>">
									<?=$val2['RTU_NAME']?>
								</li>
					<?
									}else{
										continue; // GROUP_ID 다를 경우 다음 배열 시작
									}
									//echo "<script>console.log('".$key."/".$key2."');</script>";
								}
							}
					?>	
							
							</ul>
						</li>
					<?
						}
					}
					?>	
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div> -->

<script type="text/javascript">
$(document).ready(function(){
	localStorage.setItem("layout","set_user.php");
	$("#popSpc").hide();
	
// 객체 생성
var crypt = new JSEncrypt();

var key = $("#publicKey").val();
// 키 설정
crypt.setKey(key);

	var pwFlag = false;

	// 엔터키 - 조회버튼
	$('input[name=search_word]').keydown(function(key){
		if(key.keyCode == 13){
			$("#btn_search").click();
			return false;
		}
	});

	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 사용자 ID
			search_col_id = "l_USER_ID";
		}else if(search_col == "1"){ // 사용자명
			search_col_id = "l_USER_NAME";
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

	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});

	// USER_PWD_LEN 바꿨을때 USER_PWD에 변경된 비밀번호 입력
	$("#USER_PWD_LEN").change(function(){
		$("#USER_PWD").val($("#USER_PWD_LEN").val());
		pwFlag = true;
	});

	// 비밀번호를 바꿨을때 중복 서브밋 flag = false로 바꿔준다
	$("#USER_PWD").change(function(){
		doubleSubmitFlag = false;
	});
	
	// 비밀번호 확인 일치 확인
	$("#USER_PWD_RE").change(function(){
		if( $("#USER_PWD").val() != $("#USER_PWD_RE").val() ){
			swal("체크", "비밀번호 확인이 일치하지 않습니다.", "warning");
			$("#USER_PWD_RE").focus();
		}	
	});

	// 특문 show hide
	$(".spc").hover(function(){
		$("#popSpc").show();
	}, function(){
		$("#popSpc").hide();
	});

	// 목록 선택
	$("#list_table tbody tr").click(function(){
		// $("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(1); // 아이디 중복체크 리셋
		pwFlag = false;	// 비밀번호 체크 리셋
		// $("#btn_check").css("display","none"); // 아이디 중복체크 버튼 비활성화
		// $("#USER_ID").attr("readonly","true"); // 아이디 중복체크 버튼 비활성화
		
		$("#USER_ID").attr('disabled','true');

		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		if(this.id){
			var l_USER_ID = $("#"+this.id+" #l_USER_ID").text();
			
			var param = "mode=user&USER_ID="+l_USER_ID+"&OTT="+'<?=$ott?>';
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					if(data.list){
						var EMAIL = data.list.EMAIL ? data.list.EMAIL : "";
						var MOBILE = data.list.MOBILE ? data.list.MOBILE : "";
						var SMART_MOBILE = data.list.SMART_MOBILE ? data.list.SMART_MOBILE : "";
						$("#C_USER_ID").val(data.list.USER_ID);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						// $("#USER_TYPE").val(data.list.USER_TYPE);
						// $("#MENU_TYPE").val(data.list.MENU_TYPE);
						$("#USER_ID").val(data.list.USER_ID);
						$("#USER_PWD").val(data.list.USER_PWD);
	
						var pwLen = parseInt(data.list.USER_PWD_LEN);
						var tmpLen = "";
						while(pwLen > tmpLen.length){
							tmpLen += "1"; 
						}
						$("#USER_PWD_LEN").val(tmpLen);
						$("#USER_NAME").val(data.list.USER_NAME);
						$("#EMAIL1").val(EMAIL.split("@")[0]);
						// $("#EMAIL2").val(0);
						// $("#EMAIL2").val(EMAIL.split("@")[1]);
						$("#EMAIL3").val("");
						var email_check = 0;
						$("#EMAIL2 > option").each(function(){
							if(EMAIL.split("@")[1] == this.text){
								// console.log("일치");
								$("#EMAIL2").val(this.text);
								$("#EMAIL3").val(this.text);
								email_check++;
								$("#EMAIL3").addClass("bg_lgr_d");
								$("#EMAIL3").prop("readonly", true);
								return false;
							}
						});
						if(email_check == 0) {
							$("#EMAIL2").val(0);
							$("#EMAIL3").val(EMAIL.split("@")[1]);
							$("#EMAIL3").removeClass("bg_lgr_d");
							$("#EMAIL3").prop("readonly", false);
						}
						$("#MOBILE1").val(MOBILE.split("-")[0] ? MOBILE.split("-")[0] : "010");
						$("#MOBILE2").val(MOBILE.split("-")[1]);
						$("#MOBILE3").val(MOBILE.split("-")[2]);
						$("#IS_PERMIT").val(data.list.IS_PERMIT);
						$("#SMART_MOBILE1").val(SMART_MOBILE.split("-")[0] ? SMART_MOBILE.split("-")[0] : "010");
						$("#SMART_MOBILE2").val(SMART_MOBILE.split("-")[1]);
						$("#SMART_MOBILE3").val(SMART_MOBILE.split("-")[2]);
						$("#SMART_USE").val(data.list.SMART_USE);
						
						// if(data.right){
						// 	$.each(data.right, function(i, v){
						// 		//console.log(i, v);
						// 		var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
						// 		$("#tree").jstree("select_node", tmp_id); // jstree 해당 id 체크
						// 	});
						// }
						$("#btn_check").hide();
						$("#btn_in").css('display', 'none');
					}else{
						swal("체크", "관리자 상세 조회중 오류가 발생 했습니다.", "warning");
					}
				}
			});
		}
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){

			$("#mode").val("user_in");

			swal({
				title: '<div class="alpop_top_b">관리자 등록 확인</div><div class="alpop_mes_b">관리자를 등록하실 겁니까?</div>',
				text: '확인 시 관리자가 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){			
					
					if(pwFlag){
						var user_pwd = $("#USER_PWD").val();
						// 암호화
						var tmp_pw = CryptoJS.CRT($("#USER_PWD").val()).toString();
						// tmp_pw = crypt.encrypt(tmp_pw);

						$("#USER_PWD").val(tmp_pw);

						$("#USER_PWD_LEN").val(user_pwd.length);
					}

					// frm.serialize() 대신 serializeArray() 써서 JSON으로 생성 
					jQuery.fn.serializeObject = function() {
						var obj = null;
						try {
							if (this[0].tagName && this[0].tagName.toUpperCase() == "FORM") {
								var arr = this.serializeArray();
								if (arr) {
									obj = {};
									jQuery.each(arr, function() {
										obj[this.name] = this.value;
									});
								}//if ( arr ) {
							}
						} catch (e) {
							alert(e.message);
						} finally {
						}
						return obj;
					};

					var param = $("#set_frm").serializeObject();
					
					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					// var param = "mode=user_in&"+$("#set_frm").serialize();
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
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
								    swal("체크", "관리자 등록중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		// $("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋

		var C_USER_ID = $("#C_USER_ID").val("");
			btn = document.getElementById('USER_ID');
			btn.removeAttribute('disabled');	
			$("#btn_check").show();
			$("#C_USER_ID").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			// $("#USER_TYPE").val("");
			$("#MENU_TYPE").val(0);
			$("#USER_ID").val("");
			$("#USER_PWD").val("");
			$("#USER_PWD_LEN").val("");
			$("#USER_NAME").val("");
			$("#EMAIL1").val("");
			$("#EMAIL2").val(0);
			$("#EMAIL3").val("");
			$("#MOBILE1").val("010");
			$("#MOBILE2").val("");
			$("#MOBILE3").val("");
			$("#IS_PERMIT").val(0);
			$("#SMART_MOBILE1").val("010");
			$("#SMART_MOBILE2").val("");
			$("#SMART_MOBILE3").val("");
			$("#SMART_USE").val(0);
			$("#list_table tbody tr").removeClass('selected');
			$("#btn_in").show();
		
	});

	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var C_USER_ID = $("#C_USER_ID").val();
			$("#mode").val("user_up");
			
			swal({
				title: '<div class="alpop_top_b">관리자 수정 확인</div><div class="alpop_mes_b">['+C_USER_ID+']을 수정하실 겁니까?</div>',
				text: '확인 시 관리자가 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){			
					
					if(pwFlag){
						var user_pwd = $("#USER_PWD").val();
						$("#USER_PWD_LEN").val($("#USER_PWD").val().length);
						// 암호화
						var tmp_pw = CryptoJS.CRT(user_pwd).toString();
						// tmp_pw = crypt.encrypt(tmp_pw);

						$("#USER_PWD").val(tmp_pw);
					}else{
						$("#USER_PWD_LEN").val($("#USER_PWD_LEN").val().length)
					}
					
					// frm.serialize() 대신 serializeArray() 써서 JSON으로 생성 
					jQuery.fn.serializeObject = function() {
						var obj = null;
						try {
							if (this[0].tagName && this[0].tagName.toUpperCase() == "FORM") {
								var arr = this.serializeArray();
								if (arr) {
									obj = {};
									jQuery.each(arr, function() {
										obj[this.name] = this.value;
									});
								}//if ( arr ) {
							}
						} catch (e) {
							alert(e.message);
						} finally {
						}
						return obj;
					};

					var param = $("#set_frm").serializeObject();

					//중복 submit 방지
					if(doubleSubmitCheck()) return;
					// var param = "mode=user_up&"+$("#set_frm").serialize();
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
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
								    swal("체크", "관리자 수정중 오류가 발생 했습니다.", "warning");
						        }
								doubleSubmitFlag = false;
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
			$("#mode").val("user_de");
			var C_USER_ID = $("#C_USER_ID").val();
			swal({
				title: '<div class="alpop_top_b">관리자 삭제 확인</div><div class="alpop_mes_b">['+C_USER_ID+']을 삭제하실 겁니까?</div>',
				text: '확인 시 관리자가 삭제 됩니다.',
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
					var param = $("#set_frm").serialize();
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
							    swal("체크", "관리자 삭제중 오류가 발생 했습니다.", "warning");
								doubleSubmitFlag = false;
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	
		
	// 아이디 입력 시
	$("#USER_ID").change(function(){
		$("#dup_check").val(0); // 아이디 중복체크 리셋
	});

	// 아이디 중복체크
	$("#btn_check").click(function(){
		var id_check = /^[a-zA-Z0-9]{5,15}$/; // 영어 대소문자 또는 숫자이며 5~15자리

		if( !$("#USER_ID").val() ){
		    swal("체크", "관리자 ID를 입력해 주세요.", "warning");
		    $("#USER_ID").focus(); return false;	
		}else if( !id_check.test( $("#USER_ID").val() ) ){
			swal("체크", "관리자 ID는 영어와 숫자만 사용하여 5~15자리로 입력해 주세요.", "warning"); 
			$("#USER_ID").focus(); return false;	
		}else{
			var param = "mode=user_dup&USER_ID="+$("#USER_ID").val()+"&C_USER_ID="+$("#C_USER_ID").val()+"&OTT="+'<?=$ott?>';
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result){
					    swal("체크", "사용하실 수 있는 아이디 입니다.", "success");
				  		$("#dup_check").val(1);
			        }else{
					    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
				  		$("#dup_check").val(0);
			        }
		        }
		    });
		}
	});

	// 이메일 직접입력
	$("#EMAIL2").change(function(){
		if( $("#EMAIL2").val() == 0 ){
			$("#EMAIL3").val("");
			$("#EMAIL3").removeClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", false);
		}else{
			$("#EMAIL3").val( $("#EMAIL2").val() );
			$("#EMAIL3").addClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", true);
		}
	});
    
	// 폼 체크
	function form_check(kind){
		var id_check = /^[a-zA-Z0-9]{5,15}$/; // 영어 대소문자 또는 숫자이며 5~15자리
		var pwd_check = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,20}$/; // 영어, 숫자, 특수문자가 들어가며 8자리 이상 20자리 이하
		var mobile_check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/; // 전화번호 형식
		
		if(kind == "I"){
			if( !$("#USER_ID").val() ){
			    swal("체크", "관리자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "관리자 ID는 영어와 숫자만 사용하여 5~15자리로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			}else if( $("#USER_ID").val() == $("#C_USER_ID").val() ){
			    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "관리자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;
			}else if( !$("#EMAIL1").val() || !$("#EMAIL3").val() ){
				swal("체크", "이메일 주소를 입력해 주세요.", "warning"); 
				$("#EMAIL1").focus(); return false;
			}else if( !$("#MOBILE2").val() || !$("#MOBILE3").val() ){
			    swal("체크", "휴대폰 번호를 입력해 주세요.", "warning"); 
			    $("#MOBILE2").focus(); return false;
			}else if( $("#MOBILE2").val().length < 3 || $("#MOBILE3").val().length < 4 ){
				swal("체크", "휴대폰 번호를 확인해 주세요.", "warning"); 
			    $("#MOBILE2").focus(); return false;
			}
			if(pwFlag){
				if( !pwd_check.test( $("#USER_PWD").val() ) ){
					swal("체크", "비밀번호 형식에 맞게 입력해 주세요.", "warning");
					$("#USER_PWD").focus(); return false;
				}
			}
		}else if(kind == "U"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "관리자를 선택해 주세요.", "warning"); return false;
			}else if( !$("#USER_ID").val() ){
			    swal("체크", "관리자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "관리자 ID는 영어와 숫자만 사용하여 5~15자리로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			// }else if( $("#dup_check").val() == "0" ){
			//     swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "관리자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;	
			}else if( !$("#EMAIL1").val() || !$("#EMAIL3").val() ){
				swal("체크", "이메일 주소를 입력해 주세요.", "warning"); 
				$("#EMAIL1").focus(); return false;
			}else if( !$("#MOBILE2").val() || !$("#MOBILE3").val() ){
			    swal("체크", "휴대폰 번호를 입력해 주세요.", "warning"); 
			    $("#MOBILE2").focus(); return false;
			}else if( $("#MOBILE2").val().length < 3 || $("#MOBILE3").val().length < 4 ){
			    swal("체크", "휴대폰 번호를 확인해 주세요.", "warning"); 
			    $("#MOBILE2").focus(); return false;
			}
			if(pwFlag){
				if( !pwd_check.test( $("#USER_PWD").val() ) ){
					swal("체크", "비밀번호 형식에 맞게 입력해 주세요.", "warning");
					$("#USER_PWD").focus(); return false;
				}
			}
		}else if(kind == "D"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "관리자를 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#dup_check").val(0); // 아이디 중복체크 리셋
	$("#C_USER_ID").val("");
	$("#STR_RTU_ID").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	// $("#USER_TYPE").val("");
	$("#MENU_TYPE").val(0);
	$("#USER_ID").val("");
	$("#USER_PWD").val("");
	$("#USER_NAME").val("");
	$("#EMAIL1").val("");
	$("#EMAIL2").val(0);
	$("#EMAIL3").val("");
	$("#MOBILE1").val("010");
	$("#MOBILE2").val("");
	$("#MOBILE3").val("");
	$("#IS_PERMIT").val(0);
	$("#SMART_MOBILE1").val("010");
	$("#SMART_MOBILE2").val("");
	$("#SMART_MOBILE3").val("");
	$("#SMART_USE").val(0);
});
</script>

</body>
</html>


