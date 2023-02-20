var as_ajax = "";
function state_slide(type, get_area_code){
	$("#sidr-id-btn_state_detail").attr("href", "../disos/monitoring/main.php?url=tms_equip.php&num=1");
	
	if( $(".sidr-class-equip_st").css("display") != "none" ){
		$(".sidr-class-as_st").hide();
	}
	
	var ORGAN_NAME = "";
	var RTU_NAME = "";
	var MODIFY_NAME = "";
	var RTU_TYPE = "";
	var SIGNAL_ID = "";
	var CONNECTION_INFO = "";
	var RTU_ADDRESS = "";
	var RTU_REAL_X = "";
	var RTU_REAL_Y = "";
	var POINTX = "";
	var POINTY = "";
	
	var classify = ""; // 시설 구분
	var addr = ""; // 장비 주소
	var addr_detail = ""; // 장비 상세주소
	var img = ""; // 이미지 경로
	var start_date = ""; // 착공일
	var view_start_date = "";
	var end_date = ""; // 준공일
	var view_end_date = "";
	
	var sang = ""; // 전원 상전
	var sola_volt = ""; // 전원 전압
	var sun = ""; // 전원 태양전지
	var sola_ampere = ""; // 전원 충전전류
	var batt_volt = ""; // 배터리 전압-18V이상
	var load1_ampere = ""; // 배터리 소비전류1
	var load2_ampere = ""; // 배터리 소비전류2
	var mainamp_stat = ""; // 메인엠프 상태
	var amp_power = ""; // 메인엠프 전원
	var logger_stat = ""; // 일반 로거
	var door_stat = ""; // 일반 도어
	var sensor_stat = ""; // 일반 센서
	var audio_volume = ""; // 일반 볼륨
	var speaker_select = ""; // 일반 스피커
	var log_date = ""; // 일반 최종로깅시각
	
	$("#sidr-id-state_img_frm #sidr-id-area_code").val(get_area_code);
	$("#sidr-id-state_frm #sidr-id-area_code").val(get_area_code);
	$("#sidr-id-state_img_frm #sidr-id-type").val(type);
	$("#sidr-id-state_frm #sidr-id-type").val(type);
	
	// 메인 장비 데이터
	if(type == 0){
		$("#sidr-id-state_img_frm #sidr-id-kind").val(1);
		$("#sidr-id-state_frm #sidr-id-kind").val(1);
		$("#sidr-id-state_as_frm #sidr-id-kind").val(1);
		
    	$.post( "controll/state.php", { "mode" : "state_slide", "area_code" : get_area_code }, function(response) {
    		//console.log(response);
        	var data = response.data;
        	var data2 = response.data2;
        	var data3 = response.data3;
        	var data4 = response.data4;
        	var as = response.as;
        	
        	if(data) ORGAN_NAME = data.ORGAN_NAME;
        	if(data2){
        		RTU_NAME = data2.RTU_NAME;
        		RTU_TYPE = data2.RTU_TYPE;
        		SIGNAL_ID = data2.SIGNAL_ID;
        		CONNECTION_INFO = data2.CONNECTION_INFO;
        		RTU_ADDRESS = data2.RTU_ADDRESS;
        		RTU_REAL_X = data2.RTU_REAL_X;
        		RTU_REAL_Y = data2.RTU_REAL_Y;
        		POINTX = data2.POINTX;
        		POINTY = data2.POINTY;
        		
        		var tmp_rtu_name = RTU_NAME;
        	    tmp_rtu_name = (tmp_rtu_name.length > 10) ? tmp_rtu_name.substring(0, 10)+".." : tmp_rtu_name;
        		$("#sidr-id-title_name").text(tmp_rtu_name);
        	}
        	if(data3){
        		classify = data3.classify;
        		addr = data3.addr;
        		addr_detail = data3.addr_detail;
        		img = data3.img;
        		start_date = data3.start_date;
        		end_date = data3.end_date;
        		
        		if(start_date != "") view_start_date = start_date.substr(0, 4)+"."+start_date.substr(4, 2)+"."+start_date.substr(6, 2);
        		if(end_date != "") view_end_date = end_date.substr(0, 4)+"."+end_date.substr(4, 2)+"."+end_date.substr(6, 2);
        	}
        	if(data4){
        		sola_volt = toFixedOf(data4.SOLA_VOLT * 0.1, 2);
        		sola_ampere = toFixedOf(data4.SOLA_AMPERE * 0.1, 2);
        		batt_volt = toFixedOf(data4.BATT_VOLT * 0.1, 2);
        		load1_ampere = toFixedOf(data4.LOAD1_AMPERE * 0.01, 2);
        		load2_ampere = toFixedOf(data4.LOAD2_AMPERE * 0.1, 2);
        		mainamp_stat = data4.MAINAMP_STAT;
        		amp_power = data4.AMP_POWER;
        		logger_stat = data4.LOGGER_STAT;
        		door_stat = data4.DOOR_STAT;
        		sensor_stat = data4.SENSOR_STAT;
        		audio_volume = data4.AUDIO_VOLUME;
        		speaker_select = data4.SPEAKER_SELECT;
        		log_date = data4.LOG_DATE;
        		
        		if(sola_volt == 0){
        			sang = "O";
        			sun = "X";
        			$("#sidr-id-SUN").attr("class", "sidr-class-red");
        		}else{
        			sang = "X";
        			sun = "O";
        			$("#sidr-id-SANG").attr("class", "sidr-class-red");
        		}
        		if(mainamp_stat == 0){
        			mainamp_stat = "정상"
        		}else{
        			mainamp_stat = "이상";	
            		$("#sidr-id-MAINAMP_STAT").attr("class", "sidr-class-red");
        		}
        		if(amp_power == 0){
        			amp_power = "정상";
        		}else{
        			amp_power = "이상";	
            		$("#sidr-id-AMP_POWER").attr("class", "sidr-class-red");
        		}
        		if(logger_stat == 0){
        			logger_stat = "정상";
        		}else{
        			logger_stat = "이상";
            		$("#sidr-id-LOGGER_STAT").attr("class", "sidr-class-red");
        		}
        		if(door_stat == 0){
        			door_stat = "열림";	
            		$("#sidr-id-DOOR_STAT").attr("class", "sidr-class-red");
        		}else{
        			door_stat = "닫힘";
        		}
        		if(sensor_stat == 0){
        			sensor_stat = "정상";
        		}else{
        			sensor_stat = "이상";
            		$("#sidr-id-SENSOR_STAT").attr("class", "sidr-class-red");
        		}
        		if(speaker_select == 0) speaker_select = "TTS";
        		else if(speaker_select == 1) speaker_select = "TelLine";
        		else if(speaker_select == 2) speaker_select = "HDLC";
        		else speaker_select = "TTS";	
        		
        		$("#sidr-id-SANG").text(sang);
        		$("#sidr-id-SOLA_VOLT").text(sola_volt);
        		$("#sidr-id-SUN").text(sun);
        		$("#sidr-id-SOLA_AMPERE").text(sola_ampere);
        		$("#sidr-id-BATT_VOLT").text(batt_volt);
        		$("#sidr-id-LOAD1_AMPERE").text(load1_ampere);
        		$("#sidr-id-LOAD2_AMPERE").text(load2_ampere);
        		$("#sidr-id-MAINAMP_STAT").text(mainamp_stat);
        		$("#sidr-id-AMP_POWER").text(amp_power);
        		$("#sidr-id-LOGGER_STAT").text(logger_stat);
        		$("#sidr-id-DOOR_STAT").text(door_stat);
        		$("#sidr-id-SENSOR_STAT").text(sensor_stat);
        		$("#sidr-id-AUDIO_VOLUME").text(audio_volume);
        		$("#sidr-id-SPEAKER_SELECT").text(speaker_select);
        		$("#sidr-id-LOG_DATE").text(log_date);
        	}
	        $("#sidr-id-v_rtu_name").text(RTU_NAME);
	        $("#sidr-id-classify input").val(classify);
	        $("#sidr-id-v_classify").text(classify);
	        $("#sidr-id-addr input").val(addr);
	        $("#sidr-id-v_addr").text(addr);
	        $("#sidr-id-addr_detail input").val(addr_detail);
	        $("#sidr-id-v_addr_detail").text(addr_detail);
	        var tmp_src = '';
	        if(img){
	        	tmp_src += '<a href="../../disos/images/state/'+img+'" class="magnific-popup">\n\
	        				<img src="../../disos/images/state/'+img+'" class="equip_img" style="width: 100%; height: 220px; margin-top: 0px !important; top: 0px !important;">\n\
	        				</a>';
	        }else{
	        	tmp_src += '<div style="width: 100%; height: 220px; background-color: #BFD2EB; text-align: center;">\n\
	        					<span style="position: relative; top: 100px;">이미지를 업로드 해주세요.</span>\n\
	        				</div>';
	        }
	        $("#sidr-id-rtu_img").html(tmp_src);
	        $("#sidr-id-start_date input").val(start_date);
	        $("#sidr-id-v_start_date").text(view_start_date);
	        $("#sidr-id-end_date input").val(end_date);
	        $("#sidr-id-v_end_date").text(view_end_date);
	        
		    // 이미지 팝업
		    $(".magnific-popup").magnificPopup({
		    	type: 'image',
		        callbacks: {
			     	open: function(){
			     		$(".mfp-bg").css("z-index", "10000");
			     		$(".mfp-wrap").css("z-index", "10001");
			     		$(".mfp-img").css("height", "800px");
			     	},
		     		close: function(){
	
		     		}
		        }
		    });
    		
        	var out = '';
        	out += '<tr>\n\
        		   	<th scope="col">A/S신청일</th>\n\
					<th scope="col">신청내용</th>\n\
					<th scope="col">작성자</th>\n\
        		   </tr>';
	        if(as){
	        	$.each(as, function(index, item){
	        		var tmp_idate = item['as_idate'].substr(0, 4)+"."+item['as_idate'].substr(5, 2)+"."+item['as_idate'].substr(8, 2);
	        		var tmp_content = "";
	        		if(item['as_content']){
	        			tmp_content = (item['as_content'].length > 20) ? item['as_content'].substr(0, 20)+".." : item['as_content'];
	        		}
		        	out += '<tr>\n\
	        		   		<td>'+tmp_idate+'</th>\n\
	        		   		<td>'+tmp_content+'</th>\n\
	        		   		<td>'+item['as_iname']+'</th>\n\
	        		   	   </tr>';
	        	});
	        }
	        $("#sidr-id-as_table").html(out);
	        
        	MODIFY_NAME = "["+ORGAN_NAME+" - "+RTU_NAME+"]";
        }, "json");
    	
    // 서브 장비 데이터	
	}else{
		$("#sidr-id-state_img_frm #sidr-id-kind").val(2);
		$("#sidr-id-state_frm #sidr-id-kind").val(2);
		$("#sidr-id-state_as_frm #sidr-id-kind").val(2);
		
    	$.post( "controll/state.php", { "mode" : "state_slide2", "area_code" : get_area_code, "type" : type }, function(response) {
    		//console.log(response);
        	var data = response.data;
        	var data2 = response.data2;
        	var data3 = response.data3;
        	var as = response.as;
        	
        	if(data) ORGAN_NAME = data.ORGAN_NAME;
        	if(data2){
        		if(type == 2){ // 문자전광판
	        		RTU_NAME = data2.sub_name;
	        		RTU_TYPE = "sign";
	        		SIGNAL_ID = data2.SIGNAL_ID;
	        		CONNECTION_INFO = "";
        		}else if(type == 3){ // 스틸컷
	        		RTU_NAME = data2.sub_name;
	        		RTU_TYPE = "stillcut";
	        		SIGNAL_ID = data2.SIGNAL_ID;
	        		CONNECTION_INFO = data2.CONNECTION_INFO;
        		}
        		var tmp_rtu_name = RTU_NAME;
        	    tmp_rtu_name = (tmp_rtu_name.length > 10) ? tmp_rtu_name.substring(0, 10)+".." : tmp_rtu_name;
        		$("#sidr-id-title_name").text(tmp_rtu_name);
        	}
        	if(data3){
        		classify = data3.classify;
        		addr = data3.addr;
        		addr_detail = data3.addr_detail;
        		img = data3.img;
        		start_date = data3.start_date;
        		end_date = data3.end_date;
        		
        		if(start_date != "") view_start_date = start_date.substr(0, 4)+"."+start_date.substr(4, 2)+"."+start_date.substr(6, 2);
        		if(end_date != "") view_end_date = end_date.substr(0, 4)+"."+end_date.substr(4, 2)+"."+end_date.substr(6, 2);
        	}
	        $("#sidr-id-v_rtu_name").text(RTU_NAME);
	        $("#sidr-id-classify input").val(classify);
	        $("#sidr-id-v_classify").text(classify);
	        $("#sidr-id-addr input").val(addr);
	        $("#sidr-id-v_addr").text(addr);
	        $("#sidr-id-addr_detail input").val(addr_detail);
	        $("#sidr-id-v_addr_detail").text(addr_detail);
	        var tmp_src = '';
	        if(img){
	        	tmp_src += '<img src="../../disos/images/state/'+img+'" class="equip_img" style="width: 100%; height: 220px; margin-top: 0px !important; top: 0px !important;">';
	        }else{
	        	tmp_src += '<div style="width: 100%; height: 220px; background-color: #BFD2EB; text-align: center;">\n\
	        					<span style="position: relative; top: 100px;">이미지를 업로드 해주세요.</span>\n\
	        				</div>';
	        }
	        $("#sidr-id-rtu_img").html(tmp_src);
	        $("#sidr-id-start_date input").val(start_date);
	        $("#sidr-id-v_start_date").text(view_start_date);
	        $("#sidr-id-end_date input").val(end_date);
	        $("#sidr-id-v_end_date").text(view_end_date);
    		
        	var out = '';
        	out += '<tr>\n\
        		   	<th scope="col">A/S신청일</th>\n\
					<th scope="col">신청내용</th>\n\
					<th scope="col">작성자</th>\n\
        		   </tr>';
	        if(as){
	        	$.each(as, function(index, item){
	        		var tmp_idate = item['as_idate'].substr(0, 4)+"."+item['as_idate'].substr(5, 2)+"."+item['as_idate'].substr(8, 2);
	        		var tmp_content = "";
	        		if(item['as_content']){
	        			tmp_content = (item['as_content'].length > 20) ? item['as_content'].substr(0, 20)+".." : item['as_content'];
	        		}
		        	out += '<tr>\n\
	        		   		<td>'+tmp_idate+'</th>\n\
	        		   		<td>'+tmp_content+'</th>\n\
	        		   		<td>'+item['as_iname']+'</th>\n\
	        		   	   </tr>';
	        	});
	        }
	        $("#sidr-id-as_table").html(out);
	        
        	MODIFY_NAME = "["+ORGAN_NAME+" - "+RTU_NAME+"]";
        }, "json");
	}
	
	as_ajax = function(){
		var MODIFY_TEXT = $("#sidr-id-as_content").val();
		if( MODIFY_TEXT == "" ){
			swal("체크", "A/S 내용을 입력해 주세요.", "warning"); return false;
		}
		var SYS_TYPE = "스마트 통합관제";
		var AREA_CODE = get_area_code;
		var LOCAL_CODE = get_area_code.substr(0,5);
		var REPAIR = 1; // 호출 분류(0: 정기호출, 1: 결측 및 개별 이상)
		var DEMANDER = "스마트 통합관제"; // 구분(통합방재, 강우수집, 자동우량 혹은 자동경보, 스마트 통합관제)
		var EQUIPMENT_ERROR = 11; // 장비 이상 상태(10: 정기호출, 11: 결측, 12: 개별)
		var MODIFY_REQUEST = MODIFY_NAME+" "+MODIFY_TEXT; // AS 발생 내용
		var GUBUN = 0; // url 파싱 여부(1: 파싱 안 함)
		var ERROR = 1; // 장비 이상 여부(0: 없음, 1: 있음)

		// 유지보수 사이트 circumstances 테이블 관련 필드
		$("#sidr-id-SYS_TYPE").val(SYS_TYPE);
		$("#sidr-id-RTU_NAME").val(RTU_NAME);
		$("#sidr-id-RTU_TYPE").val(RTU_TYPE);
		$("#sidr-id-SIGNAL_ID").val(SIGNAL_ID);
		$("#sidr-id-CONNECTION_INFO").val(CONNECTION_INFO);
		$("#sidr-id-RTU_ADDRESS").val(RTU_ADDRESS);
		$("#sidr-id-RTU_REAL_X").val(RTU_REAL_X);
		$("#sidr-id-RTU_REAL_Y").val(RTU_REAL_Y);
		$("#sidr-id-POINTX").val(POINTX);
		$("#sidr-id-POINTY").val(POINTY);
		
		// 위의 내용 포함 repair 테이블 관련 필드
		$("#sidr-id-AREA_CODE").val(AREA_CODE);
		$("#sidr-id-LOCAL_CODE").val(LOCAL_CODE);
		$("#sidr-id-REPAIR").val(REPAIR);
		$("#sidr-id-DEMANDER").val(DEMANDER);
		$("#sidr-id-EQUIPMENT_ERROR").val(EQUIPMENT_ERROR);
		$("#sidr-id-MODIFY_REQUEST").val(MODIFY_REQUEST);
		$("#sidr-id-GUBUN").val(GUBUN);
		$("#sidr-id-ERROR").val(ERROR);
		
		var data = $("#sidr-id-state_as_frm").serialize();
		$.ajax({
		    type: "POST",
		    url: "controll/state.php",
		    data: data,
		    cache: false, 
		    dataType: "json",
		    success : function(response) {
		    	//console.log(response);
		    	var msg = response.msg;
		    	var error = response.error;
		    	if(error){
		    		swal("오류", msg, "warning");
		    	}else{
		    		swal("성공", msg, "success");
			    	state_slide(type, get_area_code);
			    	$("#sidr-id-as_content").val("");
		    	}
		    },
		    error : function(xhr, status, error) {
		        console.log("as_error");
		    }
		});
	}
} // function state_slide(type, get_area_code) end

// 탭 버튼
$(document).on("click","#sidr-id-btn_tab_state", function(){
	$("#sidr-id-btn_tab_state").attr("class", "sidr-class-btn_bb80 sidr-class-w50 sidr-class-mT10 sidr-class-fL");
	$("#sidr-id-btn_tab_as").attr("class", "sidr-class-btn_wbb sidr-class-w50 sidr-class-mT10 sidr-class-fL");
	$(".sidr-class-equip_st").show();
	$(".sidr-class-as_st").hide();
});
$(document).on("click","#sidr-id-btn_tab_as", function(){
	$("#sidr-id-btn_tab_state").attr("class", "sidr-class-btn_wbb sidr-class-w50 sidr-class-mT10 sidr-class-fL");
	$("#sidr-id-btn_tab_as").attr("class", "sidr-class-btn_bb80 sidr-class-w50 sidr-class-mT10 sidr-class-fL");
	$(".sidr-class-equip_st").hide();
	$(".sidr-class-as_st").show();
});
$(document).on("click","#sidr-id-btn_state_as", function(){
	swal({
		title: "<div class='alpop_top_b'>A/S 접수 확인</div><div class='alpop_mes_b'>해당 장비에 A/S 신청하실 겁니까?</div>",
		text: "확인 시 바로 신청 됩니다.",
		showCancelButton: true,
		confirmButtonColor: "#5b7fda",
		confirmButtonText: "확인",
		cancelButtonText: "취소",
		closeOnConfirm: false,
		html: true
	}, function(isConfirm){
		if(isConfirm){
			as_ajax();
		}
	});
});
$(document).on("click","#sidr-id-view_state_img", function(){
	$("#sidr-id-sel_state_img").trigger("click");
});
$(document).on("change","#sidr-id-sel_state_img", function(){
	$("#sidr-id-view_state_img").val(this.value);
});

// 정보 수정 버튼
$(document).on("click", "#sidr-id-btn_state_edit", function(){
	$("#sidr-id-state_img_frm").attr("class", "");
	$("#sidr-id-classify").attr("class", "");
	$("#sidr-id-v_classify").attr("class", "sidr-class-dp0");
	$("#sidr-id-addr").attr("class", "");
	$("#sidr-id-v_addr").attr("class", "sidr-class-dp0");
	$("#sidr-id-addr_detail").attr("class", "");
	$("#sidr-id-v_addr_detail").attr("class", "sidr-class-dp0");
	$("#sidr-id-start_date").attr("class", "");
	$("#sidr-id-v_start_date").attr("class", "sidr-class-dp0");
	$("#sidr-id-end_date").attr("class", "");
	$("#sidr-id-v_end_date").attr("class", "sidr-class-dp0");
	
	$("#sidr-id-btn_state_edit").attr("class", "sidr-class-dp0");
	$("#sidr-id-btn_state_ok").attr("class", "");
	$("#sidr-id-btn_state_no").attr("class", "");
});
// 수정 취소 버튼
$(document).on("click", "#sidr-id-btn_state_no", function(){
	$("#sidr-id-state_img_frm").attr("class", "sidr-class-dp0");
	$("#sidr-id-classify").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_classify").attr("class", "");
	$("#sidr-id-addr").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_addr").attr("class", "");
	$("#sidr-id-addr_detail").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_addr_detail").attr("class", "");
	$("#sidr-id-start_date").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_start_date").attr("class", "");
	$("#sidr-id-end_date").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_end_date").attr("class", "");
	
	$("#sidr-id-btn_state_edit").attr("class", "");
	$("#sidr-id-btn_state_ok").attr("class", "sidr-class-dp0");
	$("#sidr-id-btn_state_no").attr("class", "sidr-class-dp0");
});
$(document).on("submit", "#sidr-id-state_frm", function(){
	var tmp_data = new FormData($(this)[0]); 
	$.ajax({
		url: "controll/state.php",
		type: "POST",
		data: tmp_data,
		dataType: "json",
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			//console.log(response);
			if(response['check']){
				$("#sidr-id-state_img_frm").submit(); // 이미지 업로드
			}else{
				swal("오류", "장비 정보 수정중 오류가 발생 했습니다.", "warning");
			}
		}
	});
	return false;
});
$(document).on("submit", "#sidr-id-state_img_frm", function(){
	var tmp_data = new FormData($(this)[0]); 
	$.ajax({
		url: "controll/state.php",
		type: "POST",
		data: tmp_data,
		dataType: "json",
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			//console.log(response);
			var tmp_area_code = $("#sidr-id-state_img_frm #sidr-id-area_code").val(); 
			var tmp_type = $("#sidr-id-state_img_frm #sidr-id-type").val();   	
			if(response['check'][0] == 1){
				swal("성공", "장비 정보 수정이 완료 됐습니다.", "success");
				state_slide(tmp_type, tmp_area_code);
			}else{
				swal("오류", response['check'][1], "warning");
				state_slide(tmp_type, tmp_area_code);
			}
		}
	});
	return false;
});
// 수정 완료 버튼
$(document).on("click", "#sidr-id-btn_state_ok", function(){
	var check = /-/g;
	$("#sidr-id-start_date input").val( $("#sidr-id-start_date input").val().replace(check, "") );
	$("#sidr-id-end_date input").val( $("#sidr-id-end_date input").val().replace(check, "") );
	if( $("#sidr-id-start_date input").val() != "" && $("#sidr-id-start_date input").val().length != 8 ){
		swal("체크", "착공일자를 제대로 입력해 주세요. (예시: 2017-03-01 또는 20170301 또는 미입력)", "warning");
		return false;
	}else if( $("#sidr-id-end_date input").val() != "" && $("#sidr-id-end_date input").val().length != 8 ){
		swal("체크", "준공일자를 제대로 입력해 주세요. (예시: 2017-03-01 또는 20170301 또는 미입력)", "warning");
		return false;
	}
	$("#sidr-id-state_frm").submit(); // 텍스트 수정 후 이미지 업로드
	
	$("#sidr-id-state_img_frm").attr("class", "sidr-class-dp0");
	$("#sidr-id-classify").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_classify").attr("class", "");
	$("#sidr-id-addr").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_addr").attr("class", "");
	$("#sidr-id-addr_detail").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_addr_detail").attr("class", "");
	$("#sidr-id-start_date").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_start_date").attr("class", "");
	$("#sidr-id-end_date").attr("class", "sidr-class-dp0");
	$("#sidr-id-v_end_date").attr("class", "");
	
	$("#sidr-id-btn_state_edit").attr("class", "");
	$("#sidr-id-btn_state_ok").attr("class", "sidr-class-dp0");
	$("#sidr-id-btn_state_no").attr("class", "sidr-class-dp0");
});

    
