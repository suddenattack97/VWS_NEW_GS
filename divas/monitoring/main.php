<?
require_once "../_conf/_common.php";
require_once "./head.php";

// require_once "../_repair/updatedataClass.php"; // 유지관리 장비 정보 동기화
// $_UpdateData = new UpdateData($DB);
// $log_path = "../_repair/date_log.txt";
// $log_path = str_replace("/", "\\" , $log_path);

// if($_UpdateData->getDateLog($log_path) < date("Ymd")){
// 	$_UpdateData->setDateLog($log_path);
// 	$_UpdateData->AutoRtuUpdate();
// }
$url = $_REQUEST['url'] ? $_REQUEST['url'] : ($_REQUEST['target'] ? $_REQUEST['target'] : "tms_main.php");
$num = $_REQUEST['num'] ? $_REQUEST['num'] : "1";
?>

<!-- 상단 메뉴 시작 -->
<? require_once "topmenu.php"; ?>
<!-- 상단 메뉴 끝 -->
<!-- 좌측 메뉴 시작 -->
<? //require_once "left.php"; ?>
<!-- 좌측 메뉴 끝 -->

<!-- 부모 오버레이 시작 -->
<div id="popup_over_main1" class="popup_over_main1"></div>
<div id="popup_over_main2" class="popup_over_main2"></div>
<!-- 부모 오버레이 끝 -->

<!-- 자식 페이지 시작 -->
<iframe id="main" name="main" src="<?=$url?>" width="100%" height="100%" style="border: 0;"></iframe>
<!-- 자식 페이지 끝 -->

<script type="text/javascript">
$(document).ready(function(){

	//logo 이미지 사이즈, 비율 조절
	function logoImgChange(){
		var nWidth = $("#top_img img")[0].naturalWidth;
		var nHeight = $("#top_img img")[0].naturalHeight;
		var fixVal = nHeight / 60;
		if(nWidth/fixVal > 100){
			$("#top_img").css("overflow", "hidden");	
		}
		$("#logo_area").css("width", nWidth/fixVal);
		// console.log($("#top_img img")[0].naturalWidth);
	}
	logoImgChange();

	var main_src = $("#main").attr("src");
	setInterval(function(){
		if(main_src == "tms_main.php"){
				location.reload(); 
				return false;
		}
	}, 3600000 * 4); // 4시간마다 한번씩 리로드해서 메모리 초기화 하도록

	// 공용 변수 관련 스크립트
	if(common_top_img) $("#logo_area").html('<img src="../images/top/'+common_top_img+'" width="100%" height="100%">');
	if(common_top_title && common_top_text) $("#top_title").html(common_top_title +" "+ common_top_text);
	// if(common_top_text) $("#top_text").html(common_top_text);
	if(common_board_type == 0){

	}else if(common_board_type == 1){
		$("#btn_board").click(function(){
			window.open("../../tvbrd", "");
		});
	}else if(common_board_type == 2){
		if(common_board_url){
			$("#btn_board").click(function(){
				window.open(common_board_url, "");
			});
		}else{

		}
	}

	// 1초에 한번 시간 업데이트
	var server_time = new Date(<?=date("Y")?>, <?=date("m")?>-1, <?=date("d")?>, <?=date("H")?>, <?=date("i")?>, <?=date("s")?>);
	var client_time = new Date();
	var time_diff = server_time.getTime() - client_time.getTime();
	var session_dead = 0;
	var checkLogin = getCookie("set_login");
	var session_cookie = getCookie("session_time");

	var ms_token = localStorage.getItem("ms");
	var login_token = "<?=keyIsLogin?>";
	var sesstiontime_token = getCookie("session_time_"+ms_token);

	// const countDownTimer = function (id, date) {
	// 	var _vDate = new Date(date); // 전달 받은 일자
	// 	var _vDate_stamp = new Date(date).getTime(); // 전달 받은 일자
	// 	var _second = 1000;
	// 	var _minute = _second * 60;
	// 	var _hour = _minute * 60;
	// 	var _day = _hour * 24;
	// 	var timer;

	// 	function showRemaining() {
	// 		// var now = new Date();
	// 		var ms = new Date().getTime();
	// 		var now = new Date(ms);
			
	// 		// var distDt = _vDate - now;
	// 		var distDt = _vDate_stamp - ms;

	// 		login_token = localStorage.getItem("set_login_"+ms_token);

	// 		if (distDt < 0 || login_token !== "1" || !login_token) {
				
	// 			login_token = 0;
	// 			// console.log("Session Expired!");
	// 			// console.log(login_token);
	// 			clearInterval(timer);
	// 			document.getElementById(id).textContent = "X";
	// 			document.getElementById("user_id").textContent = "X";
	
	// 			$("#btn_logout").addClass('dp0');
	// 			$("#btn_layout").addClass('dp0');
	// 			$("#btn_login").removeClass('dp0');
	// 			$("#user_id").addClass("dp0");
	// 			$("#session_time").addClass("dp0");
	// 			$("#session_time").prev().addClass("dp0");
	// 			var tmp_src = $("#main").attr("src");
	
	// 			localStorage.clear();
	// 			history.pushState(null, null, location.href);
	// 			window.onpopstate = function () {
	// 				history.go(1);
	// 			};
	
	// 			return;
	// 		}
			
	// 		var days = Math.floor(distDt / _day);
	// 		var hours = Math.floor((distDt % _day) / _hour);
	// 		var minutes = Math.floor((distDt % _hour) / _minute);
	// 		var seconds = Math.floor((distDt % _minute) / _second);

	// 		document.getElementById(id).textContent = minutes + '분 ';
	// 		document.getElementById(id).textContent += seconds + '초';
	// 	}
	// 		timer = setInterval(showRemaining, 1000);
	// }
	var login_time = localStorage.getItem('time');

	setInt_time = setInterval(function(){
		var now_client_time = new Date();
		var now_server_time = new Date(now_client_time.getTime() + time_diff);
		
		var now_date = now_server_time;
		var now_y = now_date.getFullYear();
		var now_m = now_date.getMonth() + 1;
		var now_d = now_date.getDate();
		var now_h = now_date.getHours();
		var now_i = now_date.getMinutes();
		if(String(now_i).length == 1) now_i = '0'+now_i;
		var now_s = now_date.getSeconds();
		if(String(now_s).length == 1) now_s = '0'+now_s;
		$("#now_date").html(now_y+'년 '+now_m+'월 '+now_d+'일 '+now_h+'시 '+now_i+'분 '+now_s+'초');

		// var checkLogin = getCookie("set_login");
		var session_time = getCookie("session_time_"+ms_token);
		
		var tmp_src = $("#main").attr("src");

		// countDownTimer('session_time', session_time);
		if(login_time < Date.now()){
			$("#btn_logout").addClass('dp0');
			$("#btn_layout").addClass('dp0');
			$("#user_id_front").addClass('dp0');
			$("#user_id").addClass('dp0');
			$("#session_time_front").addClass('dp0');
			$("#session_time").addClass('dp0');
			$("#btn_login").removeClass('dp0');
			// if(login_token !== "1"){
				if(tmp_src == "dtm_rain.php" || tmp_src == "dtm_wl.php" || tmp_src == "dtm_aws.php" || tmp_src == "dtm_snow.php" || tmp_src == "dtm_mcall.php" ||
				tmp_src == "rpt_ori.php" || tmp_src == "set_setting.php" || tmp_src == "set_organ.php" || tmp_src == "set_user.php" || tmp_src == "set_equip.php"){
					location.reload();
					return false;
				}
			// }
		}
		
	}, 1000);

	// setInt_time 정지
	stop_time = function(){
		clearInterval(setInt_time);
	}



	$("#logo").click(function(){
		location.href = "./main.php"; return false;
	});


	// 레이아웃 버튼
	$("#btn_layout").click(function(){
		if( $("#main").contents().find("#popup_overlay").css("display") == "none" ){
			$("#popup_over_main1").show();
			$("#popup_over_main2").show();
			$("#main").contents().find("#popup_overlay").show();
			$("#main").contents().find("#popup_layout").show();
		}else{
			$("#popup_over_main1").hide();
			$("#popup_over_main2").hide();
			$("#main").contents().find("#popup_overlay").hide();
			$("#main").contents().find("#popup_layout").hide();
		}
	});


	// 로그인 버튼
	$("#btn_login").click(function(){
		// var checkLogin = getCookie("set_login");
		login("tms_main.php");
		// window.open("./login.php", "로그인을 해주세요.", "width=533, height=533 , status=no");
	});


	// 로그아웃 버튼
	$("#btn_logout").click(function(){
		$.ajax({
		    type: "POST",
		    url: "../_info/json/_tms_json.php",
		    data: { "mode" : "logout" },
		    cache: false,
		    dataType: "json",
			beforeSend : function(){
				history.pushState(null, null, location.href);
				window.onpopstate = function () {
					history.go(1);
				};
			},
		    success : function(data){
		    	if(data.result){
	    			// location.href = "./login.php"; return false;
					// createCookie("set_login","0","1");
					// localStorage.setItem("set_login_"+ms_token,0);
					localStorage.clear();
					deleteCookie("set_login_"+ms_token);
					deleteCookie("session_time_"+ms_token);
					deleteCookie("keyUserID");
					deleteCookie("keyUserName");
					deleteCookie("keyUserPWD");
					deleteCookie("keyOrganID");
					deleteCookie("keyOrganName");
					deleteCookie("keySortBase");

					
					history.pushState(null, null, location.href);
					window.onpopstate = function () {
						history.go(1);
					};
					location.href = "./main.php"; return false;
		    	}
		    },
			complete : function(){
				history.pushState(null, null, location.href);
				window.onpopstate = function () {
					history.go(1);
				};
			}
		});
	});

	// quick_menu 페이지 호출 스크립트
	$("#quick_menu li a").click(function(){
		var tmp_num = $(this).data("num");
		var checkLogin = getCookie("set_login");
		var tmp_href = $(this).attr("target");

		ms_token = localStorage.getItem("ms");
		login_token = "<?=keyIsLogin?>";
		sesstiontime_token = getCookie("session_time_"+ms_token);

		if(login_token != "1"){ //0: 로그인X 1:로그인O
			if(tmp_num == 10 || tmp_num == 11 || tmp_num == 12){
				login(tmp_href);
			}
		}	
	});

	// 부모 창에서 레이어 팝업 닫기
	$("#popup_over_main1, #popup_over_main2").click(function(){
		$("#main").get(0).contentWindow.parent_main_close();
	});
	
	// 좌측 서브메뉴 펼침 스크립트
	$("#left_sidebar li").hover(function(){
    	$('.left_for',this).show();
  	}, function(){
    	$('.left_for',this).hide();
  	});

  	// 상단 메뉴 페이지 호출 스크립트
	  $("#top_menu ul > li i").click(function(){
		var tmp_num = $(this).data("num");
		var tmp_href = $(this).attr("href");
		var checkLogin = getCookie("set_login");

		ms_token = localStorage.getItem("ms");
		login_token = "<?=keyIsLogin?>";
		sesstiontime_token = getCookie("session_time_"+ms_token);

		if(login_token != "1"){
			if(tmp_num == 2 || tmp_num == 4 || tmp_href == "rpt_ori.php"){
				// $("#main").attr("src", ");
				// window.open("./login.php?target="+tmp_href, "로그인을 해주세요.", "width=533, height=533 , status=no");
				login(tmp_href);
			}else{
				$("#main").attr("src", tmp_href);
			}
		}else{
			$("#main").attr("src", tmp_href);
		}
	});

  	// 상단 하위 메뉴 페이지 호출 스크립트
	$("#left_sidebar ul .column > li i").click(function(){
		var tmp_num = $(this).data("num");
		var tmp_href = $(this).attr("href");
		var checkLogin = getCookie("set_login");
		
		ms_token = localStorage.getItem("ms");
		login_token = "<?=keyIsLogin?>";
		sesstiontime_token = getCookie("session_time_"+ms_token);

		if(login_token != "1"){
			if(tmp_num == 2 || tmp_num == 4 || tmp_href == "rpt_ori.php"){
				// $("#main").attr("src", ");
				// window.open("./login.php?target="+tmp_href, "로그인을 해주세요.", "width=533, height=533, toolbar=no,status=no,menubar=no,resizable=yes, location=no");
				login(tmp_href);
			}else{
				$("#main").attr("src", tmp_href);
			}
		}else{
			$("#main").attr("src", tmp_href);
		}
	});

    //아이프레임 로드 시
	$("#main").load(function(){
		var tmp_src = $(this).attr("src");
		if(login_token == "1" && login_token) {
			if(tmp_src == "tms_main.php"){
				$("#btn_layout").removeClass("dp0");
			}else{
				$("#btn_layout").addClass("dp0");
			}
		}
	});
});

//쿠키 가져오기 함수
function getCookie(cName) {
   cName = cName + '=';
   var cookieData = document.cookie;
   var start = cookieData.indexOf(cName);
   var cValue = '';
   if(start != -1){
      start += cName.length;
      var end = cookieData.indexOf(';', start);
      if(end == -1)end = cookieData.length;
      cValue = cookieData.substring(start, end);
   }
   return unescape(cValue);
}
function deleteCookie(cookie_name) {
        document.cookie = cookie_name + '=; expires=Thu, 01 Jan 1999 00:00:10 GMT; path=/';
}
// 아이프레임 url 확인
function ifr(){
	console.log( $("#main").attr("src") );
	return false;
}
</script>

</body>
</html>


