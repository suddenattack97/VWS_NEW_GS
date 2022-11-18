<?
require_once "../_conf/_common.php";

$login_kind = $_COOKIE['login_kind'] ? $_COOKIE['login_kind'] : 1;
$ott = getToken();
$_SESSION["OTT"] = $ott;
?>

<!DOCTYPE html>
<html>
<head>
<title>스마트 조기경보 시스템</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="../css/login.css">
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.11.4.min.css">
<link rel="stylesheet" type="text/css" href="../css/outdatedbrowser.min.css">
<link rel="stylesheet" type="text/css" href="../css/sweet-alert.css">

<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.11.4.min.js"></script>
<script type="text/javascript" src="../js/outdatedbrowser.min.js"></script>
<script type="text/javascript" src="../js/ie_check.js"></script>
<script type="text/javascript" src="../js/sweet-alert.js"></script>
<script type="text/javascript" src="../js/spin.min.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/jsencrypt.min.js"></script>
<? if(recaptcha == 1){ ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<? } ?>

</head>
<body>

<!-- 팝업사이즈 : 520x510px -->

<textarea id="publicKey" cols="66" rows="7" style="display:none;">-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpFrdz4NJSmGDVWDjVvIHHTrCn
VXEMXv4XhOQK1DuqwNEJ5X2jD1Ma/maF6BJePK9T4lA99cCAyWZ6ySSUoBVkrEL1
5F2GfzJ9BF31y6HByKYiRc8KUxkMNHesR+00ZvGZsHxfHSYvfRztBffd+IRyy1ep
wd+TfN++aIZJivncuQIDAQAB
-----END PUBLIC KEY-----</textarea>
<div id="outdated"></div><!-- 브라우져 체크 -->


<? 
if(recaptcha == 0){
	$tmp = "";
// }else if(recaptcha == 1){
// 	$tmp = "1";
// }else if(recaptcha == 2){
// 	$tmp = "2";
} 
?>
<form id="login_frm" class="login<?=$tmp?>" autocomplete="off">
	<input type="hidden" name="mode" value="login">
	<input type="hidden" id="target" name="target" value="<?=$_REQUEST['target']?>">
	<input type="hidden" id="l_id" name="l_id">
	<input type="hidden" id="l_pw" name="l_pw">
	<input type="hidden" name="OTT" value="<?=$ott?>">
	<div id="login_wrapper" class="login_wrapper<?=$tmp?>">
		<div class="login_title">
			<div class="txt_box">
				<span id="login_logo"></span>
				<div class="login_txt">
					<span id="logo_img">
						<img src="../images/top/<?=top_img?>">
					</span>
					<span id="top_title"><?=top_title?></span> <span id="top_text"><?=top_text?></span>
				</div>
			</div>
			<div class="close_box">X
			</div>
		</div>
		<fieldset style="margin-bottom:20px;">
			<div class="input">
				<input type="id" id="user_id" name="user_id" onkeypress="if( event.keyCode == 13 ){$('#user_pwd').focus();}" maxlength="15" placeholder="ID" required 
				/>
				<!-- onblur="inputCheck(this,'text','5~15')"/> -->
			</div>
			<div class="input">
				<input type="password" id="user_pwd" name="user_pwd" onkeypress="if( event.keyCode == 13 ){$('#login_ok').click();}" maxlength="20" placeholder="Password" required />
			</div>
			<button type="button" id="login_ok" class="submit">LOGIN</button>
<? if(recaptcha == 0){ ?>
			<input type="hidden" id="recaptcha" name="recaptcha" value="1" maxlength="5">
<? }else if(recaptcha == 1){ ?>
			<input type="hidden" id="recaptcha" name="recaptcha" maxlength="5">
			<div class="g-recaptcha" 
				 data-theme="light"
				 data-sitekey="6LdEtlkUAAAAAOerofVbokb6VG7QqZnO3bPhWl_W" 
				 data-callback="recaptcha" 
				 data-expired-callback="recaptcha_re"></div>
<? }else if(recaptcha == 2){ ?>
			<div class="g-recaptcha2">
				<img src="../func/get_captcha.php" id="captcha" style="" />
				<img src="../images/refresh.png" id="refresh" width="25" style="position: relative; bottom: 10px;" />
				<input type="text" id="recaptcha" name="recaptcha" onkeypress="if( event.keyCode == 13 ){$('#login_ok').click();}" maxlength="5" placeholder="" required />
			</div>
<? } ?>
		</fieldset>
		<div id="login_kind" class="whereto">
			<!-- <input type="radio" name="login_kind" value="1" <? if($login_kind == 1) echo "checked"; ?>></input>통합방재 &nbsp;
			<input type="radio" name="login_kind" value="2" <? if($login_kind == 2) echo "checked"; ?>></input>지도상황판 -->
		</div>
		<div class="infotxt">
		<!-- <span style="padding-bottom:15px; display: block;">지도상황판은 <span style="color:#D95700"> Google 크롬</span>에서 더 원할하게 작동 됩니다.</span>
			<button type="button" id="btn_32bit" class="btn_lbs" style="paddign-right:10px;">32bit 다운로드</button>
			<button type="button" id="btn_64bit" class="btn_lbs">64bit 다운로드</button> -->
		</div>
	</div>
	<div class="copyright">
		본 시스템은 국민의 재산과 생명을 보호하기 위한 것으로<br>관계자 외 접근은 허용하지 않습니다.
</div>
</form>	

<script type="text/javascript">
// 리캡차 체크 여부
<? if(recaptcha == 1){ ?>	
	function recaptcha(){
		tmp_val = $("#g-recaptcha-response").val();
		$("#recaptcha").val(tmp_val);
	}
	function recaptcha_re(){
		$("#recaptcha").val("");
	}
	
<? }else if(recaptcha == 2){ ?>	
	$("img#refresh").click(function(){
		$("#captcha").attr( "src", "../func/get_captcha.php?rnd=" + Math.random() );
		$("#recaptcha").val("");
	});
<? } ?>

$(document).ready(function(){

	//logo 이미지 비율에 따라 위치 조정
	function logoDisChange(){
		var nWidth = $("#logo_img img")[0].naturalWidth;
		var nHeight = $("#logo_img img")[0].naturalHeight;
		var fixVal = nWidth / nHeight;
		// console.log(fixVal);
		if(fixVal > 1.7){
			$("#login_logo").html($("#logo_img").html());
			$(".login_txt #logo_img").html("");
			$(".login_title img").css("top", "7px");
		}
	}
	logoDisChange();

	$("#user_id").focus();
	
	var login_session;
	// 브라우져 체크
    outdatedBrowser({
        bgColor: '#f25648',
        color: '#ffffff',
        lowerThan: 'transform',
        languagePath: 'browser.html'
    })
    
	// 공용 변수 관련 스크립트
	if(common_top_img) $("#top_img").html('<img src="../images/top/'+common_top_img+'">');
	if(common_top_title) $("#top_title").html(common_top_title);
	if(common_top_text) $("#top_text").html(common_top_text);
	
	// 쿠키 생성 arg(이름, 값, 시간)
	function createCookie(name, value, hours) {
		var expires;
		if (hours) {
			var date = new Date();
			date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		} else {
		expires = "";
		}
		document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/;";
	}
	// 로그인 버튼
	$("#login_ok").click(function(){
		var user_id = $("#user_id").val();
		var user_pwd = $("#user_pwd").val();
		var login_kind = $("#login_kind input:checked").val();
		var recaptcha = $("#recaptcha").val();
		var date = new Date();
		
		date = date.setMinutes(date.getMinutes() + 1);
		// date_test = date.setMinutes(date.getMinutes() + 1);
		localStorage.setItem("time", date);
		
		if(!user_id){
		    swal("체크", "아이디를 입력해 주세요.", "warning");
			return false;
		}else if(!user_pwd){
		    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			return false;
		}else if(!login_kind){
		    // swal("체크", "라디오 버튼을 선택해 주세요.", "warning");
			// return false;
		}else if(!recaptcha){
			<? if(recaptcha == 1){ ?>
		    	swal("체크", "하단 리캡차를 체크해 주세요.", "warning");
	    	<? }else if(recaptcha == 2){ ?>
		    	swal("체크", "하단 리캡차를 입력해 주세요.", "warning");
	    	<? } ?>
			return false;
		}

		// 객체 생성
        var crypt = new JSEncrypt();

		var key = $("#publicKey").val();

        // 키 설정
        crypt.setKey(key);

        // 암호화
        var l_id = crypt.encrypt(user_id);
        var l_pw = crypt.encrypt(user_pwd);
		// console.log(l_id);
		$("#user_id").val("");
		$("#user_pwd").val("");

		$("#l_id").val(l_id);
		$("#l_pw").val(l_pw);

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

		// JSON 합침 
		// Object.assign(data,  $("#login_frm").serializeObject());
		
		data = $("#login_frm").serializeObject();
		
		var tmp_spin = null;
		// var param = "mode=login&"+$("#login_frm").serializeArray()+"&l_id="+l_id+"&l_pw="+l_pw;
		$.ajax({
		    type: "POST",
		    url: "../_info/json/_tms_json.php",
			data: data,
		    cache: false,
		    dataType: "json",
		    success : function(data){
		    	if(data.result == 0){

							var ms = new Date().getTime() + 3600000;
							var session_time = new Date(ms);

							localStorage.setItem('ms', ms);	
							// localStorage.setItem('set_login_'+ms, 1);
							// localStorage.setItem('session_time_'+ms, session_time);
							createCookie("set_login_"+ms,"1","1");
							createCookie("session_time_"+ms,"1","1");
							
							// createCookie("set_login","1","1");
							// createCookie("session_time",session_time,"2");
							
							// var user_text = window.parent.parent.document.getElementById("user_id");
							// $(user_text).text("사용자 : "+user_id);

							if($("#target").val()){
								if($("#target").val() == "map"){
									// parent.parent.location.href = "../../tvbrd/index.php";
									parent.parent.location.reload();
									parent.parent.opener.parent.parent.location.reload();
									parent.parent.opener.parent.parent.localStorage.setItem('ms', ms);
									parent.parent.opener.parent.parent.localStorage.setItem('set_login_'+ms, 1);	
									parent.parent.opener.parent.parent.localStorage.setItem('session_time_'+ms, session_time);									
								}else{
									parent.parent.location.href = "main.php?target="+$("#target").val();
								}
							}else{
								parent.parent.location.href = "main.php";
							}
							
							// window.frameElement.parentNode
							// opener.parent.location.reload("main.php?target="+$("#target").val());
							// console.log(window.parent.parent.document.getElementById("user_id"));
							window.close();

		    	}else if(data.result == 1){
					swal("체크", "아이디와 비밀번호를 다시 확인해 주세요.", "warning");
		    	}else if(data.result == 2){
			    	swal("체크", "리캡차 인증 실패 입니다. 다시 인증해 주세요.", "warning");
			    	<? if(recaptcha == 1){ ?>
			    		grecaptcha.reset();
			    	<? }else if(recaptcha == 2){ ?>
					 	$("#captcha").attr( "src", "../func/get_captcha.php?rnd=" + Math.random() );
					 	$("#recaptcha").val("");
					<? } ?>
				}else if(data.result == 3){
					swal("체크", "로그인 시도 횟수 초과입니다. 5분 후에 다시 시도해 주세요.", "warning");
				}else if(data.result == 4){
					swal("체크", data.msg, "warning");
		    	}else{
					swal("체크", "로그인에 실패하였습니다.", "warning");
				}
		    },
	        beforeSend : function(data){ 
	   			tmp_spin = spin_start("#login_wrapper #spin", "230px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#login_wrapper #spin");
	        	}
	        }
		});
	});

	// 로그인 창 닫기 버튼
	$(".close_box").click(function(){
		login_popup_close();

	});

	// // 크롬 다운로드 버튼
	// $("#btn_32bit").click(function(){
	// 	iframe.location.href = "../../ChromeStandaloneSetup.exe";
	// });
	// $("#btn_64bit").click(function(){
	// 	iframe.location.href = "../../ChromeStandaloneSetup64.exe";
	// });
});
</script>
	
</body>
</html>


