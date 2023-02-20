$(document).ready(function(){
	$.post("./tvbrd/controll/login.php", { "mode" : "login_title" }, function(response){
		var tmp_src = "./tvbrd/"+response.data.top_img;
		$("#login_logo").attr("src", tmp_src);
		$("#login_text").text(response.data.top_text);
	}, "json");
	
	$("#btn_32bit").click(function(){
		iframe.location.href = "/ChromeStandaloneSetup.exe";
	});
	$("#btn_64bit").click(function(){
		iframe.location.href = "/ChromeStandaloneSetup64.exe";
	});
	$("#login_ok").submit(function(){
		var userid = $("#userid").val();
		var userpass = $("#userpass").val();
		var login_kind = $("#login_kind input:checked").val();
		
		if(!userid){
			alert("아이디를 입력해 주세요.");
			return false;
		}else if(!userpass){
			alert("비밀번호를 입력해 주세요.");
			return false;
		}else if(!login_kind){
			alert("라디오 버튼을 선택해 주세요.");
			return false;
		}
		
		$.post("./tvbrd/controll/login.php", {
			"mode" : "login",
			"USER_ID" : userid,
			"USER_PWD" : userpass,
			"login_kind" : login_kind
		}, function(response){
			var rs = response.data;
			if(response.result){
				if(login_kind == 1){
					location.href = "./tvbrd/index.php";
				}else if(login_kind == 2){
					location.href = "./disos_link.php?divas_url=./disos/template/rfmainMonitoring/all_out.php";
				}
				return false;
			}else{
				alert(rs);
				return false;
			}
		}, "json");
	});

});


