<?
// require_once "../divas/_conf/_common.php";
require_once "./_common.php";
require_once "./head.php";
?>

	<div id="wrapper">
	    <div id="top">
	    	<div class="settings">
	    		<a id="setToggle" href="#" onclick="setToggle('set'); return false">
	    			<img src="img/settings.png">
	    		</a>
	    	</div>
	        <div id="top_img"></div>
	        <div class="ttext">
	        	<span id="top_text"></span> <span class="txtcolor_lb"><?=$_SESSION['top_title']?></span>
	        </div>
			<div id="now_date" class="date"></div>
    	</div>

	    <div id="set">
	      <form id="tutor_form" name="frm">
	      <div class="conte">
	        <ul>
              <li class="conte_gry">
				<!-- <span class="fL w70">현재 접속자 : <?=strrev($_COOKIE['keyUserID'])?></span> -->
                <span class="fL w70">현재 접속자 : <?=$_COOKIE['keyUserID']?></span>
                <!-- <span class="fR">
              		<div class="file_input">
              			<label id="btn_logout">로그아웃</label>
                	</div>
                </span> -->
              </li>
	          <li class="p8 bB_1gry w100 bg_lgr_d">
              <span class="fL w40">상황판 로고 삽입</span>
              <span class="fR w60">
              	<div class="file_input">
              		<label id="btn_top_img">확인</label>
              		<input type="text" name="mode" value="top_change" style="display: none;">
              		<input type="text" name="kind" value="img" style="display: none;">
              		<input type="text" id="view_top_img" name="view_top_img" readonly style="cursor: pointer;" placeholder="상단로고 업로드">
              		<input type="file" id="sel_top_img" name="sel_top_img" style="display: none;">
            	</div>
              </span>
              </li>
	          <li class="p8 bB_1gry w100 bg_lgr_d">
              <span class="fL w40">상황판 제목 삽입</span>
              <span class="fR w60">
              	<div class="file_input">
              		<label id="btn_top_text">확인</label>
              		<input type="text" id="sel_top_text" name="sel_top_text">
            	</div>
              </span>
              </li>
              <!--
              <li id="sel_box" class="p8 bB_1gry w100 bg_lgr_d">
                <span class="fL w30">표시 단위</span>
                <span class="fR"><input type="radio" name="sel_box" class="btn_radio" value="2" />국소별</span>
                <span class="fR mR5"><input type="radio" name="sel_box" class="btn_radio" value="1" />읍,면,동</span>
              </li>
              -->
              <!--
              <li id="sel_size" class="p8 bB_1gry w100 bg_lgr_d">
              	<span class="fL w30">마커 종류</span>
              	<span class="fR"><input type="radio" name="sel_size" class="btn_radio" value="3" />대 </span>
              	<span class="fR mR5"><input type="radio" name="sel_size" class="btn_radio" value="2" />중 </span>
              	<span class="fR mR5"><input type="radio" name="sel_size" class="btn_radio" value="1" />소 </span>
              </li>
			  -->
              <!-- <li id="sel_clus_level" class="p8 bB_1gry w100 bg_lgr_d">
              <span class="fL w40">장비 그룹 줌레벨</span>
              <span class="fL w35 mT5 mR10">
              	<div id="slider_clus"></div>
              </span>
              <span class="fL w15">
              	<select>
					<? for($i=0; $i<=22; $i++){ ?>
                	<option value="<?=$i?>"><?=$i?></option>
                	<? } ?>
				</select>
              </span>
              </li> -->
              <li id="sel_over_level" class="p8 bB_1gry w100 bg_lgr_d">
              <span class="fL w40">라벨 표시 줌레벨</span>
              <span class="fL w35 mT5 mR10">
              	<div id="slider_over"></div>
              </span>
              <span class="fL w15">
              	<select>
					<? for($i=8; $i<=22; $i++){ ?>
                	<option value="<?=$i?>"><?=$i?></option>
                	<? } ?>
				</select>
              </span>
              </li>
              <li id="sel_setting" class="p8 bB_1gry w100 bg_lgr_d">
                <span class="fL w80">현재 중심 좌표 및 줌레벨 저장</span>
                <span class="fR">
              		<div class="file_input">
              			<label id="btn_setting">확인</label>
                	</div>
                </span>
                <!-- <input type="checkbox" name="sel_reset" class="chkbox" />리셋 -->
              </li>
              <li class="p8 bB_1gry w100 bg_lgr_d">
              	<span class="fL w60">장비 위치 이동 가능 여부</span>
              	<span class="fR">
              		<input type="checkbox" id="sel_move" name="sel_move" value="1" />
                </span>
              </li>
			  <!-- <li class="p8 bB_1gry w100 bg_lgr_d">
              	<span class="fL w60">오버레이 위치 이동 여부</span>
              	<span class="fR">
              		<input type="checkbox" id="overlay_move" name="overlay_move" value="0" />
                </span>
              </li> -->
			  <li class="p8 bB_1gry w100 bg_lgr_d">
				상황판 타입(택1)
	          </li>
	          <li id="sel_type" class="p8 bB_1gry w100">
	            <ul>
	            <li class="w50 fL al_C mB5"><img src="img/set_layout_01.png"><br>
	            <input type="radio" name="sel_type" class="btn_radio" value="1" />지도만 표시
	            </li>
	            <li class="w50 fL al_C mB5"><img src="img/set_layout_02.png"><br>
	            <input type="radio" name="sel_type" class="btn_radio" value="2" />추가데이터 표시
	            </li>
	            </ul>
	          </li>
	          <li class="p8 bB_1gry w100 bg_lgr_d">
				선택①에 추가로 표시할 데이터
	          </li>
	          <li id="sel_sub" class="p8 bB_1gry w100 ">
	          <div class="w100 bo_gry_d">
	              <ul>
	              <li class="bg_lb w100 bB_1gry p8">선택①</li>
	              </ul>
	              <ul class="bB_1gry hb">
	              <li class="w50 bR_1gry fL al_C p5 bg_lgr">
	              	<label>
	              	<img src="img/map_set_01.png">
	              	<input type="radio" name="sel_sub" value="1" style="display: none;" />
	              	</label>
	              </li>
	              <!--
	              <li class="w50 fL al_C p5 bg_lgr">
	              	<label>
	              	<img src="img/map_set_02.png">
	              	<input type="radio" name="sel_sub" value="2" style="display: none;" />
	              	</label>
	              </li>
	              </ul>
	              <ul class="bB_1gry hb">
	              <li class="w50 bR_1gry fL al_C p5 bg_lgr">
	              	<label>
	              	<img src="img/map_set_03.png">
	              	<input type="radio" name="sel_sub" value="3" style="display: none;" />
	              	</label>
	              </li>
	              <li class="w50 fL al_C p5 bg_lgr">
	              	<label>
	              	<img src="img/map_set_04.png">
	              	<input type="radio" name="sel_sub" value="4" style="display: none;" />
	              	</label>
	              </li>
	              -->
	              </ul>
	          </div>
	          </li>
	        </ul>
	      </div>
	      </form>
		</div>
	    <div id="con">
	      <ul id="con_ul" class="w100 h100">
	        <li id="map_wrap" class="w75 h100 fL">
	        	<div id="legend2"></div>
	        	<div id="legend"><img src="img/mapcolor_bar.png" /><img id="img_tag" src="img/mapcolor_500.jpg" /></div>
		    	<!--레프트메뉴-->				
			    <!--레프트메뉴 끝-->

			    <!--일반위성선택-->
			    <div class="menu_map">
					
			      <ul id="sel_skin">
			        <li><label><img src="img/menu_map_01.png"><input type="radio" name="sel_skin" value="1"></label></li><!--일반-->
			        <li><label><img src="img/menu_map_02.png"><input type="radio" name="sel_skin" value="2"></label></li><!--위성-->
					<li><label><img src="img/menu_map_03.png"><input type="radio" name="sel_skin" value="3"></label></li><!--회색-->
					<li><label><img src="img/menu_map_04.png"><input type="radio" name="sel_skin" value="4"></label></li><!--하이브리드-->
					<li><label><img src="img/menu_map_05.png"><input type="radio" name="sel_skin" value="5"></label></li><!--야간-->
				  </ul>
				  
			    </div>
			    <!--일반위성선택 끝-->
                <div class="m_menu">
			    <!--표출선택-->
			    <div id="menu_show" class="menu_show">
			      <ul id="sel_data"></ul>
			    </div>
			    <!--표출선택 끝-->
                <!--긴급방송-->
			    <!-- <div id="menu_bro" class="menu_bro">
			      <ul id="sel_emer">
			      </ul>
			    </div> -->
			    <!--긴급방송 끝-->
				<!--지구 선택-->
				<div id="menu_area2" class="menu_local2">
				  <ul id="sel_area2">
				  </ul>
			    </div>
			    <!--지구 선택 끝-->
                </div>
			    <!--현재상황-->
			    <!-- <div class="menu_now">
			      <ul id="btn_event">
			        <li class="bg_gry al_C"><img src="img/menu_now_00.png"></li>
			        <li class="danger_2"><img src="img/menu_now_4_02.png"><span id="danger_1" class="fR">0건</span></li>
			        <li class="danger_3 bg_gry"><img src="img/menu_now_4_03.png"><span id="danger_2" class="fR">0건</span></li>
			        <li class="danger_4"><img src="img/menu_now_4_04.png"><span id="danger_3" class="fR">0건</span></li>
			      </ul>
			    </div> -->
				<!--현재상황 끝-->
				<!--지구 선택-->
				<div id="menu_area1" class="menu_local1">
				  <ul id="sel_area1">
				  </ul>
			    </div>
				 <!--지구 선택 끝-->
			</li>
			<li id="map_data"></li>
			
			<input type="hidden" id="popupType">
          </ul>
	    </div>
	</div>
	<div id="con_forec"></div>
	<textarea id="publicKey" cols="66" rows="7" style="display:none;">-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpFrdz4NJSmGDVWDjVvIHHTrCn
VXEMXv4XhOQK1DuqwNEJ5X2jD1Ma/maF6BJePK9T4lA99cCAyWZ6ySSUoBVkrEL1
5F2GfzJ9BF31y6HByKYiRc8KUxkMNHesR+00ZvGZsHxfHSYvfRztBffd+IRyy1ep
wd+TfN++aIZJivncuQIDAQAB
-----END PUBLIC KEY-----</textarea>
		
<script type="text/javascript">

//우클릭 방지 추가
document.oncontextmenu = function(){return false;}

// 환경설정 토글
function setToggle(sets){

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
	var checkLogin = getCookie("set_login");


	var set = document.getElementById(sets);
	if(set.style.display=="block"){
		set.style.display="none";
	}else{
		if (checkLogin !== "1" || !checkLogin) {
			swal({ 
			title: '',
			text: '<div><iframe width="451px" height="530px" scrolling="no" src="../divas/monitoring/login.php?target=map" style="border: 0;margin-top:-30px;margin-left: -5px;"></iframe></div>',
			showConfirmButton: false,
			html: true,
			customClass: 'swal-wide'
			});
			// swal("로그인", "로그인이 필요합니다.", "warning"); return false;
		}else{
			set.style.display="block";
		}
	}
}

// 소수점 자르기
function toFixedOf(n, pos){
	var digits = Math.pow(10, pos);
 	var num = Math.floor(n * digits) / digits;
 	return num.toFixed(pos);
}

// 모바일 여부 체크
function isMobile(){
	var UserAgent = navigator.userAgent;

	if (UserAgent.match(/iPhone|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null){
		return true;
	}else{
		return false;
	}
}


var lib_max = 0;
var lib_cnt = 0;
$.ajax({
        type: "POST",
        url: "controll/setting.php",
        data: { "mode" : "setting" },
        cache: false,
        dataType: "json",
        success : function(data){
    		list = data.data[0].setval.split(',');
			// status 제외 - wr_map_setting에 status 값 앞뒤로 공백 없어야 함
			var statusId = $.inArray("status", list);
			if(statusId != -1){
				list.splice(statusId, 1);
			}
			
    		lib_max = list.length;
    		
    		$.each(list, function(i, v){
        		var val = $.trim(v);
				var url = "lib/tv_"+val+".js";
				// console.log(url);
				$.ajax({
    				url: url,
    			    cache: false,
    				dataType: "script",
    			    success : function(data2){
    			    	lib_cnt ++;
    			    	// ready_lib();
						if(val == "tutor"){
							tutor();
						}
        			},
        		   	error: function(xhr, ajaxOptions, thrownError){
						console.log(val, thrownError); 
						// 없는 파일이 eqk이거나 displace이면 통과
						if(val == "eqk" || val == "displace" || val == "status"){
							lib_cnt ++;
							// ready_lib();
							// tutor();
						}
        		    }
    			});
    		});
        }
	});

</script>

</body>
</html>


