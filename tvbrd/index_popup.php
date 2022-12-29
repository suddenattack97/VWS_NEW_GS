<?
// require_once "../divas/_conf/_common.php";
require_once "./_common.php";
require_once "./head_popup.php";
?>

	<div id="wrapper">
	    <!-- <div id="top">
	    </div> -->
		<div id="map_data">
			<div class="tv_unit_s mB05p">
				<span id="r_img" style="display:none;"></span>
				<span class="tv_subtitle tv_blue">
				</span>
				<span class="tv_subcon">
					<img src=""  width='100%' height='100%'/>
				</span>
			  </div>
		</div>
	</div>	
		
<script type="text/javascript">
$(document).ready(function(){
	var type = opener.document.getElementById("popupType").value;
	// console.log(type);
	
	$(".tv_subcon").addClass(type);
	var radar = setInterval(function(){
		callRadar();
	},180000);
	if(type == "radar"){
		$(".tv_subtitle").text("레이더");
		callRadar();
		radar;
	}else if(type == "heroes"){
		$(".tv_subtitle").text("위성");
		heroes();
	}else if(type == 4){ // 없음
		rains();
	}

});

	Date.prototype.getFromFormat = function(format) {
	    var yyyy = this.getFullYear().toString();
	    format = format.replace(/yyyy/g, yyyy)
	    var mm = (this.getMonth()+1).toString(); 
	    format = format.replace(/mm/g, (mm[1]?mm:"0"+mm[0]));
	    var dd  = this.getDate().toString();
	    format = format.replace(/dd/g, (dd[1]?dd:"0"+dd[0]));
	    var hh = this.getHours().toString();
	    format = format.replace(/hh/g, (hh[1]?hh:"0"+hh[0]));
	    var ii = this.getMinutes().toString();
	    format = format.replace(/ii/g, (ii[1]?ii:"0"+ii[0]));

	    return format;
	};

	// 이미지 존재여부 판단 
	function callRadarImg(time, now) {
		var url_pre = "https://www.weather.go.kr/repositary/image/rdr/img/RDR_CMP_WRC_";
		var url_post = ".png";
		var image = new Image(200, 200);
		image.src = url_pre + time + url_post;
		$("#r_img").append(image);
		
		image.onload = function(e){
			if($(".radar").html().trim() == ""){
				$(".radar").html("<img class='raderloading' src='"+image.src+"' width='100%' height='100%'>");
			}else{
				$(".radar img").attr("src", image.src);
			}
			$("#r_img img").remove();
		};

		image.onerror = function(e) {
			$("#r_img img").remove();
			now = new Date(now.getTime() - 10 * 60000);
			var time = now.getFromFormat("yyyymmddhhii").substring(0, 11) + "0";
			// console.log("error : ",image.src);
			callRadarImg(time, now);
		};
		//console.log(image.src);
	}

	function callRadar(){
		var now = new Date();
		now = new Date(now.getTime());
		var time = now.getFromFormat("yyyymmddhhii").substring(0, 11) + "0";
		callRadarImg(time, now);
	}


// // 환경설정 토글
// function setToggle(sets){
// 	var set = document.getElementById(sets);
// 	if(set.style.display=="block"){
// 		set.style.display="none";
// 	}else{
// 		set.style.display="block";
// 	}
// }
	
// $("#btn_link").css("float", "right;");
// $("#btn_link2").css("float", "right;");

// // 소수점 자르기
// function toFixedOf(n, pos){
// 	var digits = Math.pow(10, pos);
//  	var num = Math.floor(n * digits) / digits;
//  	return num.toFixed(pos);
// }

// // 모바일 여부 체크
// function isMobile(){
// 	var UserAgent = navigator.userAgent;

// 	if (UserAgent.match(/iPhone|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null){
// 		return true;
// 	}else{
// 		return false;
// 	}
// }

// // 네이버 api 호출
// function naver_api(){
// 	var lib_max = 0;
// 	var lib_cnt = 0;
	
// 	$.ajax({
//         type: "POST",
//         url: "controll/setting.php",
//         data: { "mode" : "setting" },
//         cache: false,
//         dataType: "json",
//         success : function(data){
//     		list = data.data[0].setval.split(',');
//     		lib_max = list.length;
    		
//     		$.each(list, function(i, v){
//         		var val = $.trim(v);
// 				var url = "lib/tv_"+val+".js";
// 				//console.log(url);
// 				$.ajax({
//     				url: url,
//     			    cache: false,
//     				dataType: "script",
//     			    success : function(data2){
//     			    	lib_cnt ++;
//     			    	ready_lib();
//         			},
//         		   	error: function(xhr, ajaxOptions, thrownError){
// 						//console.log(val, thrownError); // 없는 파일이 eqk이거나 displace이면 통과
// 						if(val == "eqk" || val == "displace" || val == "status"){
// 							lib_cnt ++;
// 							ready_lib();
// 						}
//         		    }
//     			});
//     		});
//         }
// 	});

// 	function ready_lib(){
// 		if(lib_max == lib_cnt) tutor();
// 	}
// }
</script>

</body>
</html>


