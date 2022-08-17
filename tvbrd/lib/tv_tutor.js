//################################################################################################################################
//# date : 20170515
//# title : 스마트 통합관제 시스템 tutor.js
//# content : 스마트 통합관제 시스템 네이버 지도 api 이용
//################################################################################################################################
	var map = ""; // 지도 객체
	var view = "";
	var box = ""; // 박스 폴리곤 객체
    var cluster = ""; // 클러스터 객체
    var arr_clus_marker = []; // 클러스터에 추가한 마커
    var arr_data = []; // 장비 센서별 정보
    var arr_json = []; // json 체크
    var arr_poly = []; // 폴리곤 정보
    var arr_emdnm = []; // 읍면동 이름에 따른 읍면동 코드
    var arr_id = []; // 메인 장비 id => area_code
    var arr_rtu = []; // 메인 장비 정보
	var arr_sub_rtu = []; // 서브 장비 정보
	var arr_farm_rtu = []; // 축산 장비 정보
	var arr_spot = []; // 현장중계 데이터
	var circle = [];
	
	var setval = []; // 사용 js 목록
    var top_img = ""; // 상황판 로고
    var top_text = ""; // 상황판 제목
    var x_organ = ""; // 시군청 x 좌표
    var y_organ = ""; // 시군청 y 좌표
	var map_skin = ""; // 지도 스킨 => 1: 일반, 2: 위성
	var map_type = ""; // 지도 타입 => 1: 지도, 2: 지도 및 우측 공간
	var map_sub = ""; // 우측 공간 => 1: 레이더/위성, 2: 레이더/태풍, 3: 위성/태풍, 4: 테이블
	var map_cent = ""; // 지도 중심 좌표
	var map_level = ""; // 지도 확대 레벨
	var ori_map_level = ""; // 지도 DB 확대 레벨
	var map_move = ""; // 지도 장비 이동 여부 => 1: 장비 이동 불가, 2: 장비 이동 가능
	var map_size = ""; // 오버레이 사이즈 => 0: 아이콘, 1: 소, 2: 중, 3: 대 > 미사용
	var map_box = ""; // 오버레이 단위 선택 => 1: 읍면동, 2: 장비 > 미사용
    var map_data = ""; // 표현 데이터 => 1: 강우, 2: 수위, 3: 적설, 4: aws, 5: 방송, 6: cctv, 7: 문자전광판, 8: 스틸컷, 9: 현장중계, 10: 약수
    var map_kind = ""; // 지도 종류 => 1: 상황판, 2: 장비상태, 3: 태풍, 4: 예보
    var over_level = ""; // 오버레이가 사라지는 확대 레벨
    var clus_level = ""; // 클러스터가 생기는 확대 레벨
	var api_key = "";

	var add_zindex = 1; // 오버레이 최고 zindex
    var move_state = false; // 장비 마커 이동 상태
    var moveCheck = false; // 예보 오버레이 이동 상태
    var startOverlayEmd = ""; // 클릭한 예보 오버레이 emd_cd
    var startX = ""; // 클릭한 예보 오버레이 x 좌표
    var startY = ""; // 클릭한 예보 오버레이 y 좌표
    var startOverlayPoint = ""; // 클릭한 예보 오버레이 화면 픽셀 좌표 
    var sig_marker = ""; // 시군청 마커
    var over_last = ""; // 마지막으로 클릭한 오버레이의 area_code
    var over_sub_last = ""; // 마지막으로 클릭한 오버레이의 sub_id

	var box_ajax = []; // box 폴리곤 관련 ajax 함수
	var json_ajax = []; // json 파일 ajax 함수
	var state_ajax = ""; // 상태 업데이트 ajax 함수
	var event_ajax = ""; // 이벤트 업데이트 ajax 함수
	var map_load = ""; // map_load 완료 함수
	var box_update = ""; // 박스 업데이트 함수
	var state_update = ""; // 상태 업데이트 함수
	var event_update = ""; // 이벤트 업데이트 함수
	var farm_update =""; 
	var time_update = ""; // 시간 업데이트 함수
	var rain_ajax = []; // rain ajax 함수
	var farm_ajax = []; // farm ajax 함수

	var slide_state = []; // 그래프 슬라이드 오픈 상태
	var slide_value = []; // 그래프 슬라이드 인자 값
	var setInt_data1 = ""; // 5초마다 데이터 업데이트 함수
	var setInt_data2 = ""; // 10초마다 상태 업데이트 함수
	var setInt_data3 = ""; // 1분마다 api 업데이트 함수
	var setInt_data4 = ""; // 1초마다 시간 업데이트 함수
	var setInt_slide = ""; // 1분마다 슬라이드 업데이트 함수
	var ani_kind = 0;
	var arr_area_group = []; // 알람 그룹별
	var tmp_arr_rtu = [];
	var group_mode = false;
	var checkInput;
	var box_polygon_feature = [];
	var polygon_feature = [];

			
	$.fn.getUrlParameter = function (sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	};


	var map_control_type = $.fn.getUrlParameter('type');

	/**
     * 중복서브밋 방지
     * 
     * @returns {Boolean}
     */
    var doubleSubmitFlag = false;
    function doubleSubmitCheck(){
        if(doubleSubmitFlag){
            return doubleSubmitFlag;
        }else{
            doubleSubmitFlag = true;
            return false;
        }
	}

    function tutor(){

    	// if( typeof naver === "undefined" ) return false;
    	
        $.post( "controll/tutor.php", { "mode" : "locallist" }, function(response){
        	//console.log(response); return false;
        	setval = response.setting.setval.replace(/ /gi, "").split(",");
        	top_img = response.setting.top_img;
        	top_text = response.setting.top_text;
        	x_organ = response.setting.x_organ;
        	y_organ = response.setting.y_organ;
        	map_skin = response.setting.map_skin;
        	map_type = response.setting.map_type;
        	map_sub = response.setting.map_sub;
        	map_cent = (!map_cent) ? response.setting.map_cent : map_cent;
        	map_level = (!map_level) ? response.setting.map_level : map_level;
        	ori_map_level = (!map_level) ? response.setting.map_level : map_level;
        	map_move = (!map_move) ? response.setting.map_move : map_move;
      		map_size = (!map_size) ? response.setting.map_size : map_size;
        	map_box = response.setting.map_box;
        	map_data = (response.setting.map_data) ? response.setting.map_data.split(',') : [];
        	map_kind = response.setting.map_kind;
        	over_level = response.setting.over_level;
            clus_level = response.setting.clus_level;
			api_key = response.setting.api_key;
            
        	$("#view_top_img").val(top_img);
        	$("#sel_top_text").val(top_text);
        	if(top_img != null){
        		top_img = '<img src="'+top_img+'" alt="로고"/>';
            	$("#top_img").html(top_img);
        	}
        	$("#top_text").html(top_text);
        	
        	$("#sel_skin input:radio[value='"+map_skin+"']").prop("checked", true);
    		$("#sel_skin input:radio[value='"+map_skin+"']").closest("li").attr("class", "bg_act");
        	$("#sel_type input:radio[value='"+map_type+"']").prop("checked", true);
        	$("#sel_sub input:radio[value='"+map_sub+"']").prop("checked", true);
        	$("#sel_size input:radio[value='"+map_size+"']").prop("checked", true);
        	$("#sel_box input:radio[value='"+map_box+"']").prop("checked", true);
        	$("#sel_kind input:radio[value='"+map_kind+"']").prop("checked", true);
        	$("#sel_kind input:radio[value='"+map_kind+"']").closest("li").attr("class", "bg_act");
        	$("#sel_over_level select").val(over_level);
        	$("#slider_over").slider("value", over_level);
        	// $("#sel_clus_level select").val(clus_level);
        	// $("#slider_clus").slider("value", clus_level);
        	
        	arr_data = response.data;
            $.each(response.json, function(index, item){
            	arr_json[index] = item;
            });
            $.each(response.poly, function(index, item){
            	arr_poly[index] = item;
            });
            $.each(response.emdnm, function(index, item){
            	arr_emdnm[index] = item;
            });
            $.each(response.id, function(index, item){
            	arr_id[index] = item;
            });
            $.each(response.rtu, function(index, item){
            	arr_rtu[index] = item;
            });
            $.each(response.sub_rtu, function(index, item){
            	arr_sub_rtu[index] = item;
            });
			
            var groupType = 1; // groupType == 1이면 전체 목록 나열 버튼, groupType == 2이면 화살표 이동 
			var txt = "";
			var m_num = groupType;
			var maxLeng = 0;
			txt = '<li><label class="grp_name" for="grpRd_9999">선택 해제</label><input type="radio" name="areaGroup" id="grpRd_9999" class="btn_selectArea" value="9999"></li>';
            $.each(response.group, function(index, item){
				if(response.group.result){
					if(item.AREA_GRP_NO){
						arr_area_group[index] = item;
						if(item.AREA_GRP_NAME.length > maxLeng) {
							maxLeng = item.AREA_GRP_NAME.length;
							for(var i = 0; i < item.AREA_GRP_NAME.length; i++) { // 열 하나하나를 체크.
								var chr = item.AREA_GRP_NAME.substr(i,1); 
								var korean = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/;
								if(!korean.test(chr)) { 
									maxLeng = maxLeng - 0.5;
								}
							}
						}
						if(groupType == 1){
							txt += '<li><label class="grp_name" for="grpRd_'+index+'">'+arr_area_group[index]['AREA_GRP_NAME']+'</label><input type="radio" name="areaGroup" id="grpRd_'+index+'" class="btn_selectArea" value="'+index+'"></li>';
						}else if(groupType == 2){
							if(index == 0){
								txt += '<li id="btn_left" class="arr"><i class="fa fa-angle-left"></i></li> <li>';
								txt += '<label class="grp_name">'+arr_area_group[index]['AREA_GRP_NAME']+'<input type="checkbox" class="btn_selectArea" value="0"></label>';
								txt += '</li> <li id="btn_right" class="arr"><i class="fa fa-angle-right"></i></li>';
							}
						}
					}
				}
            });
			if(response.group.result){
				$("#sel_area"+m_num).html(txt);
				maxLeng = maxLeng*14 + 20;
				if(maxLeng > 100){
					$(".menu_local"+m_num).css("width", maxLeng+"px");
				}
				$(".menu_local"+m_num).css("border", "1px solid #000");
			}
			
            // var txt = '<li id="btn_emer">긴급방송</li>';
            // $.each(response.emer, function(index, item){
            // 	txt += '<li><label>'+item['name']+'<input type="checkbox" name="sel_emer" value="'+item['id']+'"></label></li>';
            // });
        	// $("#sel_emer").html(txt);
        	
            var txt = '<li id="sel_data2">장비표시</li>';
            if( arr_data['rain']['cnt'] != 0 && jQuery.inArray("rain", setval) != "-1" ){
            	txt += '<li><label>강우<input type="checkbox" name="sel_data" value="1" class="label_input"></label></li>';
            }
            if( arr_data['flow']['cnt'] != 0 && jQuery.inArray("flow", setval) != "-1" ){
            	txt += '<li><label>수위<input type="checkbox" name="sel_data" value="2" class="label_input"></label></li>';
            }
            if( arr_data['aws']['cnt'] != 0 && jQuery.inArray("aws", setval) != "-1" ){ 
            	txt += '<li><label>AWS<input type="checkbox" name="sel_data" value="4" class="label_input"></label></li>';
            }
            if( arr_data['snow']['cnt'] != 0 && jQuery.inArray("snow", setval) != "-1" ){ 
            	txt += '<li><label>적설<input type="checkbox" name="sel_data" value="3"></label></li>';
            }
            if( arr_data['alarm']['cnt'] != 0 && jQuery.inArray("alarm", setval) != "-1" ){ 
            	txt += '<li><label>방송<input type="checkbox" name="sel_data" value="5" class="label_input"></label></li>';
            }
            if( arr_data['cctv']['cnt'] != 0 && jQuery.inArray("cctv", setval) != "-1" ){ 
            	txt += '<li><label>CCTV<input type="checkbox" name="sel_data" value="6"></label></li>';
			}
			/*
            if( arr_data['sign']['cnt'] != 0 && jQuery.inArray("sign", setval) != "-1" ){ 
            	txt += '<li><label>문자전광판<input type="checkbox" name="sel_data" value="7"></label></li>';
            }*/
			// if( arr_data['farm']['cnt'] != 0 && jQuery.inArray("farm", setval) != "-1" ){ 
			// 	//txt += '<li><label>스틸컷<input type="checkbox" name="sel_data" value="8"></label></li>';
			// 	txt += '<li><label>축산정보<input type="checkbox" name="sel_data" value="18" id="farm"></label></li>';
			// }
			
			if( arr_data['displace']['cnt'] != 0 && jQuery.inArray("displace", setval) != "-1" ){ 
            	txt += '<li><label>변위계<input type="checkbox" name="sel_data" value="11"></label></li>';
			}
			
			if( arr_data['eqk']['cnt'] != 0 && jQuery.inArray("eqk", setval) != "-1" ){ 
            	txt += '<li><label>지진계<input type="checkbox" name="sel_data" value="12"></label></li>';
            }
			/*
            if( jQuery.inArray("spot", setval) != "-1" ){ 
            	txt += '<li><label>현장중계<input type="checkbox" name="sel_data" value="9"></label></li>';
            }
            if( arr_data['water']['cnt'] != 0 && jQuery.inArray("water", setval) != "-1" ){ 
            	txt += '<li><label>약수<input type="checkbox" name="sel_data" value="10"></label></li>';
            }
			*/
           
        	$("#sel_data").html(txt);
        	
        	$.each(map_data, function(index, item){
        		$("#sel_data input:checkbox[value='"+item+"']").prop("checked", true);
        		$("#sel_data input:checkbox[value='"+item+"']").closest("li").attr("class", "bg_act");
        	});

			if(map_control_type == 1){
				map_type = 1;
				$("#top").hide();
				$("#wrapper").append("<div id='new'><span id='widescr'>전체보기</span></div>");
				// $(".sidr").css('top','0px');
				$("#widescr").click( function(){
					window.open('./index.php?','');
				});
				$("#sel_move").lcs_off(); // 미니모드일 경우에는 무조건 장비이동 끄도록 설정
				// $("#sel_move").lcs_on();
			}

            if( $("#tutor").length == 0 ){
	            if(map_type == 1){
	            	$("#map_wrap").attr("class", "w100 h100 fL");
	            	$("#map_data").attr("class", "");
			    	$("#map_data").empty();

			    	$(".menu_map").attr("style", "");
					$(".menu_now").attr("style", "");
					$(".menu_animal").css("right", $("#map_data").width() + 120);
			    	$(".m_menu").attr("style", "");

					var out = '<div id="map"></div>';
			    	$("#map_wrap").prepend(out); out = null;

	            }else if(map_type == 2){
	            	$("#map_wrap").attr("class", "w75 h100 fL");
			    	$("#map_data").attr("class", "w25 h100 fL pT42");
			    	$("#map_data").empty();

			    	$(".menu_map").css("right", $("#map_data").width() + 10);
					$(".menu_now").css("right", $("#map_data").width() + 10);
					$(".menu_animal").css("right", $("#map_data").width() + 120);
			    	$(".m_menu").css("right", $("#map_data").width() + 120);

	            	var out = '<div id="map"></div>';
			    	$("#map_wrap").prepend(out); out = null;

			    	$("#map_data").load("map_data.php?sel_sub="+map_sub, function(response, status, xhr){
            			if(status == "success"){
	                        if(map_sub == 1){
	                        	radar();
	                        	heroes();
	                        }else if(map_sub == 2){
	                        	radar();
	                        }else if(map_sub == 3){
	                        	heroes();
	                        }else if(map_sub == 4){
	                        	rains();
	                        }
	                    }else if(status == "error"){
	                    	console.log("#map_data load() error");
	                    }
	                });
	            }
            }
            
			var tile = new ol.layer.Group({
				layers: [
					new ol.layer.Tile({
						source: new ol.source.XYZ({
							url: 'http://api.vworld.kr/req/wmts/1.0.0/'+api_key+'/'+(map_skin == 1 ? 'Base' : (map_skin == 2 ? 'Satellite' : (map_skin == 3 ? 'Hybrid' : (map_skin == 4 ? 'gray' : (map_skin == 5 ? 'midnight' : 'base')))))+'/{z}/{y}/{x}.'+(map_skin == 1 ? 'png' :(map_skin == 2 ? 'jpeg' : 'png'))
							// url: "https://{a-c}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png"
						})
					})
				]
			});

			view = new ol.View({
					center: ol.proj.transform([Number(map_cent[1]), Number(map_cent[0])], 'EPSG:4326', 'EPSG:900913'),
					zoom: map_level
				});
			map = new ol.Map({
				target: 'map',
				layers: [tile],
				view: view,
				controls: [
					new ol.control.Attribution({
						collapsible: true
					}),
					// new ol.control.MousePosition({
					// 	undefinedHTML: ' ',
					// 	projection: 'EPSG:4326',
					// 	coordinateFormat: function(coordinate) {
					// 		return ol.coordinate.format(coordinate, '{x}, {y}', 4);
					// 	}
					// }),
					// new ol.control.OverviewMap({
					// 	layers: [
					// 		new ol.layer.Tile({
					// 			source: new ol.source.XYZ({
					// 				url: 'http://api.vworld.kr/req/wmts/1.0.0/'+api_key+'/'+(map_skin == 1 ? 'Satellite' : (map_skin == 2 ? 'Base' : (map_skin == 3 ? 'Hybrid' : (map_skin == 4 ? 'gray' : (map_skin == 5 ? 'midnight' : 'base')))))+'/{z}/{y}/{x}.'+(map_skin == 1 ? 'jpeg' :(map_skin == 2 ? 'png' : 'png'))
					// 			})
					// 		})
					// 	],
					// 	collapsed: false
					// }),
					new ol.control.ScaleLine(),
					new ol.control.Zoom(),
					new ol.control.ZoomSlider()
					// new ol.control.FullScreen()
				]
			}); 
			

			$(".ol-attribution button").click(function(){
				if($(".ol-attribution button").attr("aria-expanded") == "false"){
					view.animate({
						duration: 700,
						easing: elastic,
						center: ol.proj.transform([Number(map_cent[1]), Number(map_cent[0])], 'EPSG:4326', 'EPSG:900913'),
						zoom : ori_map_level
					});
				}
			})
			
			// 속성 타이틀 제거 
			$(".ol-attribution button").removeAttr("title");
			$(".ol-full-screen button").removeAttr("title");
			$(".ol-zoom-in").removeAttr("title");
			$(".ol-zoom-out").removeAttr("title");

			map.on('moveend', function(evt) {
				map_level = map.getView().getZoom();
				// $(".ol-attribution-expand").text("현재 줌 레벨 : "+Math.floor(map_level));
				// $(".ol-attribution-expand").text("현재 줌 레벨 : "+Math.floor(map_level));
				$(".ol-attribution-expand").text("현재 줌 레벨 : "+(map_level.toFixed(4)));
				if(map_level < 9){
					$(".ol-overviewmap-box").hide();
				}else{
					$(".ol-overviewmap-box").show();
				}
				box_update();
			});

			map.getView().setMinZoom(8); // 최소 줌 8로 제한
			map.getView().setMaxZoom(20); // 최대 줌 21로 제한
			
    		if(map_kind == 1){ // 상황판 선택
				$("#menu_bro").show();
				$("#menu_show").show();
				$("#legend").show();
				$("#legend2").show();
				$(".menu_animal").hide();
				var txt = '<img src="img/legend_label_title.png" />';
	            if( arr_data['mix']['cnt'] != 0 && jQuery.inArray("mix", setval) != "-1" ){
	            	txt += '<img id="img_tag" src="img/legend_label_09.jpg" />';
	            }
	            if( arr_data['rain']['cnt'] != 0 && jQuery.inArray("rain", setval) != "-1" ){
	            	txt += '<img id="img_tag" src="img/legend_label_01.jpg" />';
	            }
	            if( arr_data['flow']['cnt'] != 0 && jQuery.inArray("flow", setval) != "-1" ){
	            	txt += '<img id="img_tag" src="img/legend_label_02.jpg" />';
	            }
	            if( arr_data['aws']['cnt'] != 0 && jQuery.inArray("aws", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_03.jpg" />';
	            }
	            if( arr_data['snow']['cnt'] != 0 && jQuery.inArray("snow", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_04.jpg" />';
	            }
	            if( arr_data['alarm']['cnt'] != 0 && jQuery.inArray("alarm", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_05.jpg" />';
	            }
	            if( arr_data['cctv']['cnt'] != 0 && jQuery.inArray("cctv", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_08.jpg" />';
	            }
	            if( arr_data['sign']['cnt'] != 0 && jQuery.inArray("sign", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_06.jpg" />';
	            }
	            if( arr_data['stillcut']['cnt'] != 0 && jQuery.inArray("stillcut", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_07.jpg" />';
	            }
	            if( jQuery.inArray("spot", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_11.jpg" />';
	            }
	            if( arr_data['water']['cnt'] != 0 && jQuery.inArray("water", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_12.jpg" />';
	            }
	            if( arr_data['alarm']['cnt'] != 0 && jQuery.inArray("alarm", setval) != "-1" ){ 
	            	txt += '<img id="img_tag" src="img/legend_label_status.jpg" />';
	            }
				$("#legend2").html(txt);
				$("#legend2").css("right", "530px");
    		}
			
          	map_load = function(){ // json_ajax > state_ajax > event_ajax > box_update()
          		event_update();
				danger();
            	$.when(null, event_ajax).done(function(){
            		box_update();
            	});
				var time = (map_control_type == 1 ? 30000 : 5000);
          		// 5초에 한번 데이터 업데이트
          		setInt_data1 = setInterval(function(){
          			event_update();
					danger();
                	$.when(null, event_ajax).done(function(){
						box_update();
                	});
        		}, time);

          		// 10초에 한번 상태 업데이트
          		setInt_data2 = setInterval(function(){
            		if(map_kind == 2){
            			// state_update(2);
            		}
        		}, 10000);

          		// 1분에 한번 api 업데이트
          		setInt_data3 = setInterval(function(){
            		if(map_kind == 4){
            			//box_update();
            		}
        		}, 60000);

          		// 1초에 한번 시간 업데이트
          		setInt_data4 = setInterval(function(){
            		time_update();
        		}, 1000);
          		
          		// 1분에 한번 그래프 업데이트
          		setInt_slide = setInterval(function(){
      				//console.log(slide_value[0], slide_value[1]);
	      			if(slide_state[0]){
	      				state_slide(slide_value[0], slide_value[1]);
	      			}
	      			if(slide_state[1]){
	 	 		    	graph_slide(slide_value[0], slide_value[1]);
	      			}
	      			if(slide_state[2]){
	      				spot_slide();
	      			}
	      			if(slide_state[4]){
	 		    		stillcut_slide(slide_value[0]);
					  }
					if(slide_state[5]){
						farm_slide(slide_value[0]);
					 }
        		}, 60000);
          		
          		// 함수 호출 중지
				if(map_kind == 1){
					clearInterval(setInt_data2); // 장비상태 호출 중지
					clearInterval(setInt_data3); // 예보 호출 중지
				}else if(map_kind == 2){
					clearInterval(setInt_data3); // 예보 호출 중지
				}else if(map_kind == 3){
					clearInterval(setInt_data1); // 상황판 호출 중지
					clearInterval(setInt_data2); // 장비상태 호출 중지
					clearInterval(setInt_data3); // 예보 호출 중지
					clearInterval(setInt_slide); // 슬라이드 호출 중지
				}else if(map_kind == 4){
					clearInterval(setInt_data1); // 상황판 호출 중지
					clearInterval(setInt_data2); // 장비상태 호출 중지
				}
            } // map_load() end
			
			var checkInput;
			if(groupType == 1){
				checkInput = $('input[name="areaGroup"]');
			}else{
				checkInput = $(".btn_selectArea");
				// 그룹 좌측
				$("#btn_left").click(function(){
					var arr_i = parseInt($(".btn_selectArea").val());
					var arr_max = arr_area_group.length;
					if(arr_i > 0){
						$(".grp_name").html(arr_area_group[arr_i-1]["AREA_GRP_NAME"]);
						$(".btn_selectArea").val(arr_i-1);
					}else{
						$(".grp_name").html(arr_area_group[arr_max-1]["AREA_GRP_NAME"]);
						$(".btn_selectArea").val(arr_max-1);
					}
				});
				// 그룹 우측
				$("#btn_right").click(function(){
					var arr_i = parseInt($(".btn_selectArea").val());
					var arr_max = arr_area_group.length;
					if(arr_i >= arr_max-1){
						$(".grp_name").html(arr_area_group[0]["AREA_GRP_NAME"]);
						$(".btn_selectArea").val(0);
					}else{
						$(".grp_name").html(arr_area_group[arr_i+1]["AREA_GRP_NAME"]);
						$(".btn_selectArea").val(arr_i+1);
					}
				});
			}
			
			map_api();

		}, "json");
    } // tutor() end


	function box_polygon(){ // 박스 폴리곤 그리는 함수

		var box_geo = []; // 지도 전체 사각형 폴리곤 좌표
    	var sig_geo = []; // 시군구 폴리곤 좌표

		var sig_41111 = []; // 수원시 장안구 폴리곤 좌표
		var sig_41113 = []; // 수원시 권선구 폴리곤 좌표
		var sig_41115 = []; // 수원시 팔달구 폴리곤 좌표
		var sig_41117 = []; // 수원시 영통구 폴리곤 좌표

		var sig_41131 = []; // 성남시 수정구 폴리곤 좌표
		var sig_41133 = []; // 성남시 중원구 폴리곤 좌표
		var sig_41135 = []; // 성남시 분당구 폴리곤 좌표

		var sig_41281 = []; // 고양시 덕양구 폴리곤 좌표
		var sig_41285 = []; // 고양시 일산동구 폴리곤 좌표
		var sig_41287 = []; // 고양시 일산서구 폴리곤 좌표

		var sig_41171 = []; // 안양시 만안구 폴리곤 좌표
		var sig_41173 = []; // 안양시 동안구 폴리곤 좌표

		var sig_41271 = []; // 안산시 상록구 폴리곤 좌표
		var sig_41273 = []; // 안산시 단원구 폴리곤 좌표

		var sig_41461 = []; // 용인시 처인구 폴리곤 좌표
		var sig_41463 = []; // 용인시 기흥구 폴리곤 좌표
		var sig_41465 = []; // 용인시 수지구 폴리곤 좌표

		var sig_48840 = []; // 용인시 수지구 폴리곤 좌표

		var parser = new jsts.io.OL3Parser();
    	// box_geo[0] = [];
    	// box_geo[0][0] = new naver.maps.LatLng(42.6, 105);
    	// box_geo[0][1] = new naver.maps.LatLng(42.6, 150);
    	// box_geo[0][2] = new naver.maps.LatLng(30, 140);
    	// box_geo[0][3] = new naver.maps.LatLng(30, 115);

		var coordinates = 
		[[13149726.167615778, 3757032.8137500044],
		[13149726.167615778,5635543.612951094],
		[15028131.255,5635543.612951094],
		[15028131.255,3757032.8137500044],
		[13149726.167615778, 3757032.8137500044]];
		var tmp_geo = []; 

    	for(var i in arr_json){
    		if(!arr_json[i]['check']) return true; // json 파일이 없는 지역은 제외
    		
    	
			box_ajax[i] =
			$.ajax({
	            type: "POST",
	            url: "geojson/" + arr_json[i]['json_url'] + "_sig.geojson",
	            cache: false,
	            dataType: "json",
				beforeSend: function(data){
					swal({
						title : "타일 변경 중 ...",
						text : "타일 변경 중 입니다. 조금만 기다려주세요.",
						type : "warning",
						showCancelButton : false,
						showConfirmButton : false,
						closeOnConfirm : false,
						closeOnCancel : false
					});
					$("body").css("cursor","not-allowed");
				},
				complete: function(data){
					swal.close();
					$("body").css("cursor","Default");
				},
	            success : function(data) {
					// console.log(data);
					var name = data.name;
					if(name == "41111_sig") sig_41111 = [];
					else if(name == "41113_sig") sig_41113 = [];
					else if(name == "41115_sig") sig_41115 = [];
					else if(name == "41117_sig") sig_41117 = [];

					else if(name == "41131_sig") sig_41131 = [];
					else if(name == "41133_sig") sig_41133 = [];
					else if(name == "41135_sig") sig_41135 = [];

					else if(name == "41281_sig") sig_41281 = [];
					else if(name == "41285_sig") sig_41285 = [];
					else if(name == "41287_sig") sig_41287 = [];

					else if(name == "41171_sig") sig_41171 = [];
					else if(name == "41173_sig") sig_41173 = [];

					else if(name == "41271_sig") sig_41271 = [];
					else if(name == "41273_sig") sig_41273 = [];

					else if(name == "41450_sig") sig_41450 = [];

					else if(name == "41461_sig") sig_41461 = [];
					else if(name == "41463_sig") sig_41463 = [];
					else if(name == "41465_sig") sig_41465 = [];

					else if(name == "41570_sig") sig_41570 = [];
					else if(name == "41590_sig") sig_41590 = [];

					else if(name == "48840_sig") sig_48840 = [];

	            	else sig_geo = [];
					
					if(name == "41273_sig"){    // 안산시 떨어진 부분 예외처리
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									if(index2 == 0){
											$.each(item2, function(index3, item3){
													if(name == "41273_sig") sig_41273[index3] = [];
													if(name == "41273_sig") sig_41273[index3][index3] = [];
													$.each(item3, function(index4, item4){
														if(name == "41273_sig"){
															sig_41273[index3][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														}
													});
											});
									}else{
										$.each(item2, function(index3, item3){
											if(name == "41273_sig") sig_41273[sig_41273.length] = [];
											if(name == "41273_sig") sig_41273[sig_41273.length-1][index3] = [];
											$.each(item3, function(index4, item4){
												if(name == "41273_sig"){
													sig_41273[sig_41273.length-1][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
										});
									}
									// console.log(sig_41273);
								});
							}
						});
					}else if(name == "48840_sig"){
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									if(index2 == 0){
											$.each(item2, function(index3, item3){
													if(name == "48840_sig") sig_48840[index3] = [];
													if(name == "48840_sig"){
															sig_48840[index3][index3] = [];
													}
													$.each(item3, function(index4, item4){
														// console.log(index4);
														if(name == "48840_sig"){
															sig_48840[index3][index4] = ol.proj.transform([item4[0] ,item4[1] - 0.0032], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														}
													});
											});
									}else{
										$.each(item2, function(index3, item3){
											if(name == "48840_sig") sig_48840[sig_48840.length] = [];
											if(name == "48840_sig") sig_48840[sig_48840.length-1][index3] = [];
											$.each(item3, function(index4, item4){
												if(name == "48840_sig"){
													sig_48840[sig_48840.length-1][index4] = ol.proj.transform([item4[0] ,item4[1] - 0.0032], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
										});
									}
								});
							}
						});
					}else if(name == "41450_sig"){
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									if(index2 == 0){
											$.each(item2, function(index3, item3){
													if(name == "41450_sig") sig_41450[index3] = [];
													if(name == "41450_sig"){
															sig_41450[index3][index3] = [];
													}
													$.each(item3, function(index4, item4){
														if(name == "41450_sig"){
															sig_41450[index3][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														}
													});
											});
									}else{
										$.each(item2, function(index3, item3){
											if(name == "41450_sig") sig_41450[sig_41450.length] = [];
											if(name == "41450_sig") sig_41450[sig_41450.length-1][index3] = [];
											$.each(item3, function(index4, item4){
												if(name == "41450_sig"){
													sig_41450[sig_41450.length-1][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
										});
									}
									// console.log(sig_41570);
								});
							}
						});
					}else if(name == "41570_sig"){
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									if(index2 == 0){
											$.each(item2, function(index3, item3){
													if(name == "41570_sig") sig_41570[index3] = [];
													if(name == "41570_sig"){
														if(index3 == 4){
															sig_41570[index3][index3-1] = [];
														}else{
															sig_41570[index3][index3] = [];
														}
													}
													$.each(item3, function(index4, item4){
														if(name == "41570_sig"){
															sig_41570[index3][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														}
													});
											});
									}else{
										$.each(item2, function(index3, item3){
											if(name == "41570_sig") sig_41570[sig_41570.length] = [];
											if(name == "41570_sig") sig_41570[sig_41570.length-1][index3] = [];
											$.each(item3, function(index4, item4){
												if(name == "41570_sig"){
													sig_41570[sig_41570.length-1][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
										});
									}
									// console.log(sig_41570);
								});
							}
						});
					}else if(name == "41590_sig"){
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								// console.log(item);
								$.each(item.geometry.coordinates, function(index2, item2){
									if(index2 == 0){
											$.each(item2, function(index3, item3){
													if(name == "41590_sig") sig_41590[index3] = [];
													if(name == "41590_sig") sig_41590[index3][index3] = [];
													$.each(item3, function(index4, item4){
														if(name == "41590_sig"){
															sig_41590[index3][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														}
													});
											});
									}else{
										$.each(item2, function(index3, item3){
											if(name == "41590_sig") sig_41590[sig_41590.length] = [];
											if(name == "41590_sig") sig_41590[sig_41590.length-1][index3] = [];
											$.each(item3, function(index4, item4){
												if(name == "41590_sig"){
													sig_41590[sig_41590.length-1][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
										});
									}
									// console.log(sig_41590);
								});
							}
						});
					}else{
						$.each(data.features, function(index, item){
							if(item.geometry.type == "MultiPolygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									// console.log(item2);
									if(index2 == 0){
										if(name == "41111_sig") sig_41111[index2] = [];
										else if(name == "41113_sig") sig_41113[index2] = [];
										else if(name == "41115_sig") sig_41115[index2] = [];
										else if(name == "41117_sig") sig_41117[index2] = [];
					
										else if(name == "41131_sig") sig_41131[index2] = [];
										else if(name == "41133_sig") sig_41133[index2] = [];
										else if(name == "41135_sig") sig_41135[index2] = [];
					
										else if(name == "41281_sig") sig_41281[index2] = [];
										else if(name == "41285_sig") sig_41285[index2] = [];
										else if(name == "41287_sig") sig_41287[index2] = [];
					
										else if(name == "41171_sig") sig_41171[index2] = [];
										else if(name == "41173_sig") sig_41173[index2] = [];
					
										else if(name == "41271_sig") sig_41271[index2] = [];
										else if(name == "41273_sig") ;//sig_41273[index2] = [];
										
										else if(name == "41461_sig") sig_41461[index2] = [];
										else if(name == "41463_sig") sig_41463[index2] = [];
										else if(name == "41465_sig") sig_41465[index2] = [];
										
										else sig_geo[index2] = [];
									
											$.each(item2, function(index3, item3){
												// console.log(item3);
												if(name == "41111_sig") sig_41111[index2][index3] = [];
												else if(name == "41113_sig") sig_41113[index2][index3] = [];
												else if(name == "41115_sig") sig_41115[index2][index3] = [];
												else if(name == "41117_sig") sig_41117[index2][index3] = [];
							
												else if(name == "41131_sig") sig_41131[index2][index3] = [];
												else if(name == "41133_sig") sig_41133[index2][index3] = [];
												else if(name == "41135_sig") sig_41135[index2][index3] = [];
							
												else if(name == "41281_sig") sig_41281[index2][index3] = [];
												else if(name == "41285_sig") sig_41285[index2][index3] = [];
												else if(name == "41287_sig") sig_41287[index2][index3] = [];
							
												else if(name == "41171_sig") sig_41171[index2][index3] = [];
												else if(name == "41173_sig") sig_41173[index2][index3] = [];
							
												else if(name == "41271_sig") sig_41271[index2][index3] = [];
												else if(name == "41273_sig"); //sig_41273[index2][index3] = [];
												
												else if(name == "41461_sig") sig_41461[index2][index3] = [];
												else if(name == "41463_sig") sig_41463[index2][index3] = [];
												else if(name == "41465_sig") sig_41465[index2][index3] = [];
												
												else sig_geo[index2][index3] = [];
												$.each(item3, function(index4, item4){
													
													//수원시 오차 미수정 #1
													if(name == "41111_sig") sig_41111[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41113_sig") sig_41113[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41115_sig") sig_41115[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41117_sig") sig_41117[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													
													//성남시 오차 수정 #1
													else if(name == "41131_sig") sig_41131[index2][index4] = ol.proj.transform([item4[0] - 0.0028 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41133_sig") sig_41133[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41135_sig") sig_41135[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
								
													else if(name == "41281_sig") sig_41281[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41285_sig") sig_41285[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41287_sig") sig_41287[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													
													//안양시 오차 미수정 #1
													else if(name == "41171_sig") sig_41171[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41173_sig") sig_41173[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													
													//용인시 오차 미수정 #1
													else if(name == "41461_sig") sig_41461[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41463_sig") sig_41463[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													else if(name == "41465_sig") sig_41465[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													
													//성남시 오차 미수정 #1
													else if(name == "41271_sig") sig_41271[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산

													//여기부터 일반 지역들 좌표 오차 틀어진거 수정
													//가평군 오차 수정 ★
													else if(name == "41820_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0012 ,item4[1] - 0.0032], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//고양시 오차 미수정
													else if(name == "41281_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//과천시 오차 미수정
													else if(name == "41290_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//광명시 오차 미수정
													else if(name == "41210_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//광주시 오차 미수정
													else if(name == "41610_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//구리시 오차 미수정
													else if(name == "41310_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//군포시 오차 미수정
													else if(name == "41410_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//김포시 오차 미수정
													else if(name == "41570_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//남양주시 오차 미수정
													else if(name == "41360_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//동두천시 오차 미수정
													else if(name == "41250_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//부천시 오차 수정 ★
													else if(name == "41190_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0031 ,item4[1] + 0.00005], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//시흥시 오차 미수정
													else if(name == "41390_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//안성시 오차 미수정
													else if(name == "41550_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//양주시 오차 미수정
													else if(name == "41630_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//양평군 오차 수정 ★
													else if(name == "41830_sig_mult") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//여주시 오차 미수정
													else if(name == "41670_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//연천군 오차 미수정
													else if(name == "41800_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//오산시 오차 수정 ★
													else if(name == "41370_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0031 ,item4[1] + 0.0001], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//의왕시 오차 수정 ★
													else if(name == "41430_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0031 ,item4[1] + 0.0002], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//의정부시 오차 미수정
													else if(name == "41150_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//이천시 오차 수정 ★
													else if(name == "41500_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0003 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//파주시 오차 미수정
													else if(name == "41480_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//평택시 오차 미수정
													else if(name == "41220_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//포천시 오차 수정 ★
													else if(name == "41650_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//하남시 오차 미수정
													else if(name == "41450_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													//화성시 오차 미수정
													else if(name == "41590_sig") sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													


													//성남시 오차 수정 #2 특이지역이라 위에서 수정
													//수원시 오차 미수정 #2 특이지역이라 위에서 수정
													//안산시 오차 미수정 #2 특이지역이라 위에서 수정
													//안양시 오차 미수정 #2 특이지역이라 위에서 수정
													//용인시 오차 미수정 #2 특이지역이라 위에서 수정
													
													// 안산시 단원구
													else if(name == "41273_sig"){
													}

													else sig_geo[index2][index4] = ol.proj.transform([item4[0] - 0.0032 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													
													
													
													
												});
											});
									}
								});
							}else if(item.geometry.type == "Polygon"){
								
							}
						});
					}
	            }
			});

			json_ajax[i] =
    			$.ajax({
		            type: "POST",
		            url: "geojson/" + arr_json[i]['json_url'] + ".geojson",
		            cache: false,
		            dataType: "json",
		            success : function(data) {
						// console.log(data);
		            	$.each(data.features, function(index, item){
							// console.log(item);
							if( !arr_poly[ item.properties.EMD_CD ] ) return true; // db에 없는 지역은 제외
		            		
		            		arr_poly[ item.properties.EMD_CD ]['type'] = item.geometry.type;
		            		
		    				if(item.geometry.type == "MultiPolygon"){
								// console.log(item);
		    	        		$.each(item.geometry.coordinates, function(index2, item2){
									// console.log(index2);
									// console.log(item2);
		    	        			arr_poly[ item.properties.EMD_CD ]['path'][index2] = [];
		    	        			arr_poly[ item.properties.EMD_CD ]['hole'][index2] = [];

		    	        			if(item2.length > 1){ // 폴리곤 중 구멍이 있는 폴리곤
		    	        				$.each(item2, function(index3, item3){
											// console.log(item3);

		    	        					if(index3 == 0){
		    	        						$.each(item3, function(index4, item4){
													if(item.properties.EMD_CD){
		    	        								arr_poly[ item.properties.EMD_CD ]['path'][index2][index4] = [];
														arr_poly[ item.properties.EMD_CD ]['path'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														// console.log(arr_poly[ item.properties.EMD_CD ]['path'][index2][index4]);
													}
													if(item.properties.A2){
														arr_poly[ item.properties.A2 ]['path'][index2][index4] = [];
														arr_poly[ item.properties.A2 ]['path'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													}
												});
		    	        					}else{
												$.each(item3, function(index4, item4){
													if(item.properties.EMD_CD){
														arr_poly[ item.properties.EMD_CD ]['hole'][index2][index4] = [];
														arr_poly[ item.properties.EMD_CD ]['hole'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
														// console.log(arr_poly[ item.properties.EMD_CD ]['hole'][index2][index4]);
													}
													if(item.properties.A2){
														arr_poly[ item.properties.A2 ]['hole'][index2][index4] = [];
														arr_poly[ item.properties.A2 ]['path'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
													}
			    	        					});
		    		        				}
		    	        				});
		    	        			}else{
										$.each(item2, function(index3, item3){
											$.each(item3, function(index4, item4){
												if(item.properties.EMD_CD){
													arr_poly[ item.properties.EMD_CD ]['path'][index2][index4] = [];
													arr_poly[ item.properties.EMD_CD ]['path'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
												if(item.properties.A2){
													arr_poly[ item.properties.A2 ]['path'][index2][index4] = [];
													arr_poly[ item.properties.A2 ]['path'][index2][index4] = ol.proj.transform([item4[0] - 0.0002 ,item4[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
											});
		    	        				});
		    	        			}
		    	        		});
		    				}else if(item.geometry.type == "Polygon"){
								$.each(item.geometry.coordinates, function(index2, item2){
									if(item2.length > 1){ // 폴리곤 중 구멍이 있는 폴리곤
		    	        				$.each(item2, function(index3, item3){
											if(index2 == 0){
												if(item.properties.EMD_CD){
													arr_poly[ item.properties.EMD_CD ]['path'][index3] = [];
													arr_poly[ item.properties.EMD_CD ]['path'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
												if(item.properties.A2){
													arr_poly[ item.properties.A2 ]['path'][index3] = [];
													arr_poly[ item.properties.A2 ]['path'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
		    	        					}else{
												if(item.properties.EMD_CD){
													arr_poly[ item.properties.EMD_CD ]['hole'][index3] = [];
													arr_poly[ item.properties.EMD_CD ]['hole'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
												if(item.properties.A2){
													arr_poly[ item.properties.A2 ]['hole'][index3] = [];
													arr_poly[ item.properties.A2 ]['hole'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
												}
		    	        					}
		    	        				});
		    	        			}else{
		    	        				$.each(item2, function(index3, item3){
											if(item.properties.EMD_CD){
		    	        						arr_poly[ item.properties.EMD_CD ]['path'][index3] = [];
												arr_poly[ item.properties.EMD_CD ]['hole'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
											}
											if(item.properties.A2){
												arr_poly[ item.properties.A2 ]['path'][index3] = [];
												arr_poly[ item.properties.A2 ]['hole'][index3] = ol.proj.transform([item3[0] - 0.0002 ,item3[1]], 'EPSG:4326', 'EPSG:3857'); // 오차 계산
											}
		    	        				});
		    	        			}
		    					});
		    				}
							// var poly_style = new ol.style.Style({
							// 	stroke: new ol.style.Stroke({
							// 		color: '#004c80',//[20, 0, 5, .7],
							// 		opacity: 1,
							// 		width: 2
							// 	}),
							// 	fill: new ol.style.Fill({
							// 		color: [255,255,255, 0],//[20, 0, 5, .7],
							// 		opacity: 1,
							// 	})
							// });

			    			// 폴리곤 추가
			    		    if(arr_poly[ item.properties.EMD_CD ]['type'] == "MultiPolygon"){
								if(arr_poly[ item.properties.EMD_CD ]['path'].length > 1){
									polygon_feature[item.properties.EMD_CD] = [];
									$.each(arr_poly[ item.properties.EMD_CD ]['path'], function(index, item2){
										
										polygon_feature[item.properties.EMD_CD ][index] = new ol.Feature({
											geometry : new ol.geom.Polygon([ item2 ])
										});
										
										// polygon_feature[item.properties.EMD_CD].setStyle(poly_style);
										
										arr_poly[ item.properties.EMD_CD ]['polygon'] = new ol.layer.Vector({
											source : new ol.source.Vector({
												features : [ polygon_feature[item.properties.EMD_CD][index] ]
											})
										});
										map.addLayer(arr_poly[ item.properties.EMD_CD ]['polygon']);
									});
								}
			    		    }else if(arr_poly[ item.properties.EMD_CD ]['type'] == "Polygon"){

								// console.log(arr_poly[41271113]['polygon']);
								polygon_feature[item.properties.EMD_CD] = new ol.Feature({
									geometry : new ol.geom.Polygon([ arr_poly[ item.properties.EMD_CD ]['path'] ])
								});

								// polygon_feature[item.properties.EMD_CD].setStyle(poly_style);
								
								
								arr_poly[ item.properties.EMD_CD ]['polygon'] = new ol.layer.Vector({
									source : new ol.source.Vector({
									  features : [ polygon_feature[item.properties.EMD_CD] ]
									})
								});

								map.addLayer(arr_poly[ item.properties.EMD_CD ]['polygon']);
			    		    }
		            	}); // $.each(data.features, function(index, item) end
		            },
		            error : function(xhr, status, error){
		            	console.log("geojson error");
		            }
		      	}); // ajax end
    	} // for(var i in arr_json) end
		
    	$.when.apply(null, box_ajax).done(function(){ // box_ajax 결과 리턴

			var i_cnt = 0;

			var un;
	
			var tile_value = $("#sel_skin .bg_act input").val();

			var box_style = new ol.style.Style({
				fill : new ol.style.Fill({
						color : (tile_value == 2 || tile_value == 3 || tile_value == 5 ? [255,255,255, 0.5] : [ 0, 0, 0, 0.5])
				})
			});

			var polygon_feature2 = new ol.Feature({
				geometry : new ol.geom.Polygon([ coordinates ])
			});

			var jstsGeom2 = parser.read(polygon_feature2.getGeometry());

			for(var i in arr_json){
				if(i == 41111) sig_geo = sig_41111;
				else if(i == 41113) sig_geo = sig_41113;
				else if(i == 41115) sig_geo = sig_41115;
				else if(i == 41117) sig_geo = sig_41117;
			
				else if(i == 41131) sig_geo = sig_41131;
				else if(i == 41133) sig_geo = sig_41133;
				else if(i == 41135) sig_geo = sig_41135;
			
				else if(i == 41281) sig_geo = sig_41281;
				else if(i == 41285) sig_geo = sig_41285;
				else if(i == 41287) sig_geo = sig_41287;
			
				else if(i == 41171) sig_geo = sig_41171;
				else if(i == 41173) sig_geo = sig_41173;
			
				else if(i == 41271) sig_geo = sig_41271;
				else if(i == 41273) sig_geo = sig_41273;
				
				else if(i == 41450) sig_geo = sig_41450;

				else if(i == 48840) sig_geo = sig_48840;

				else if(i == 41461) sig_geo = sig_41461;
				else if(i == 41463) sig_geo = sig_41463;
				else if(i == 41465) sig_geo = sig_41465;

				else if(i == 41570) sig_geo = sig_41570;
				else if(i == 41590) sig_geo = sig_41590;
				
				else sig_geo = sig_geo;
				if(i == 41273 || i == 41590 || i == 41570 || i == 41450 || i == 48840 ){
					for(var sig_i in sig_geo){
						box_polygon_feature = new ol.Feature({
							geometry : new ol.geom.Polygon([ sig_geo[sig_i] ])
						});
							var jstsGeom1 = parser.read(box_polygon_feature.getGeometry());
							if(i_cnt == 0){
								un = jstsGeom2.difference(jstsGeom1);
							}else{
								un = un.difference(jstsGeom1);
							}
							i_cnt++;
					}
				}else{
					box_polygon_feature = new ol.Feature({
						geometry : new ol.geom.Polygon([ sig_geo ])
					});
						var jstsGeom1 = parser.read(box_polygon_feature.getGeometry());
						if(i_cnt == 0){
							un = jstsGeom2.difference(jstsGeom1);
						}else{
							un = un.difference(jstsGeom1);
						}
						i_cnt++;
				}
					box_polygon_feature.setGeometry(parser.write(un));
					box_polygon_feature.setStyle(box_style);
						
					var vector_layer = new ol.layer.Vector({
						source : new ol.source.Vector({
						features : [ box_polygon_feature ]
						})
					});
				} // for end
					map.addLayer(vector_layer);
    	});
	}

	function map_center(){
		var tmp_location = map.getView().getCenter();
		tmp_location = ol.proj.transform([tmp_location[0] , tmp_location[1]] , 'EPSG:3857', 'EPSG:4326');
		return tmp_location;
	}

    function map_api(){

		box_polygon(); // 박스 폴리곤 호출

    	$.when.apply(null, json_ajax).done(function(){ // json_ajax 결과 리턴

			$.post("controll/tutor.php", { "mode" : "event_setting", "sub_mode" : "setting" }, function(rs){
				$(".event_now").css('left' , parseInt(rs.data.x_point));
				$(".event_now").css('top' , parseInt(rs.data.y_point));
			}, "json");

    		if( jQuery.inArray("rain", setval) != "-1" ) rain(1, arr_data['rain']['area_code']); // 강우 tv_rain.js
			//console.log(arr_data['rain']['area_code']);
    		if( jQuery.inArray("flow", setval) != "-1" ) flow(1, arr_data['flow']['area_code']); // 수위 tv_flow.js
    		if( jQuery.inArray("snow", setval) != "-1" ) snow(1, arr_data['snow']['area_code']); // 적설 tv_snow.js
    		if( jQuery.inArray("aws", setval) != "-1" ) aws(1, arr_data['aws']['area_code']); // AWS tv_aws.js
    		if( jQuery.inArray("alarm", setval) != "-1" ) alarm(1, arr_data['alarm']['area_code']); // 방송 tv_alarm.js
    		if( jQuery.inArray("mix", setval) != "-1" ) mix(1, arr_data['mix']['area_code']); // 믹스 tv_mix.js
    		if( jQuery.inArray("cctv", setval) != "-1" ) cctv(1, arr_data['cctv']['sub_id']); // CCTV tv_cctv.js
    		if( jQuery.inArray("sign", setval) != "-1" ) sign(1, arr_data['sign']['sub_id']); // 문자전광판 tv_sign.js
			if( jQuery.inArray("stillcut", setval) != "-1" ) stillcut(1, arr_data['stillcut']['sub_id']); // 스틸컷 tv_stillcut.js
			if( jQuery.inArray("spot", setval) != "-1" ) spot(1); // 현장중계 tv_spot.js
    		if( jQuery.inArray("water", setval) != "-1" ) water(1, arr_data['water']['sub_id']); // 약수 tv_water.js
			if( jQuery.inArray("yebo", setval) != "-1" ) yebo(1); // 예보 tv_yebo.js
			if( jQuery.inArray("displace", setval) != "-1" ) displace(1, arr_data['displace']['area_code']); // 변위계 tv_displace.js
			if( jQuery.inArray("eqk", setval) != "-1" ) eqk(1, arr_data['eqk']['area_code']); // 지진계 tv_displace.js
			if( jQuery.inArray("farm", setval) != "-1" ) {
				$("#farm_kind").show();
				farm(1, arr_data['farm'], "0"); // 축산 tv_farm.js
			}else{
				$("#farm_kind").hide();

			}
			if( jQuery.inArray("status", setval) != "-1") $(".event_now").css("display", "inline-flex").draggable(
				{
				containment:'parent', //부모 요소 안에서만 이동 범위 제한
				handle: '.move_area', // drag 대상 안 특정 요소에 제한 (여러개 사용 가능)
				stop: function(event, ui){
					var pos = $(this).offset();
					var mapWidth = $("#map").width();
					var mapHeight = $("#map").height();
					var top = pos.top;
					var left = pos.left;
					if( (top-40) < 0 || left < 0 || mapWidth < (left+450) || mapHeight < (top+250) ){
						$(this).css('left', $("#pos_left").val()+'px');
						$(this).css('top', $("#pos_top").val()+'px');
					}else{
						$("#pos_top").val(top);
						$("#pos_left").val(left);
					}
					//   $.ajax({
					// 	method: "POST",
					// 	url: "insert.php",
					// 	data: { name: current.left, location: current.top }
					// 	})
				}
				
			});
				
    		// 지도 장비 이동 가능 여부
        	if(map_move == 1){
        		$("#sel_move").lcs_off();
        	}else if(map_move == 2){
        		$("#sel_move").lcs_on();
        	}
        	
			state_update(1);
    	});
			
    	// 마커 및 오버레이 업데이트
    	box_update = function(){
			
    		if(move_state) return false; // 좌표 이동 중 업데이트 중지

    		//arr_clus_marker = []; //BB
			arr_clus_marker.length = 0;
    		if( jQuery.inArray("rain", setval) != "-1" )  rain(2, arr_data['rain']['area_code']); // 강우 tv_rain.js

    		if( jQuery.inArray("flow", setval) != "-1" ) flow(2, arr_data['flow']['area_code']); // 수위 tv_flow.js
    		
			if( jQuery.inArray("snow", setval) != "-1" ) snow(2, arr_data['snow']['area_code']); // 적설 tv_snow.js
    		
			if( jQuery.inArray("aws", setval) != "-1" ) aws(2, arr_data['aws']['area_code']); // AWS tv_aws.js
    		
    		// cluster.setMarkers(arr_clus_marker);
    		// cluster._redraw(); //BB 재생성해야 하기 때문에 업데이트만 하고 라벨 클릭 시 재생성하는 것으로 변경
    		// cluster._updateClusters();
    		
    		$.when.apply(null, rain_ajax).done(function(){ // rain_ajax 결과 리턴
        		for(var i in arr_poly){
        			arr_poly[i]['polygon_cnt'] = 0;
        			arr_poly[i]['polygon_sum'] = 0;
        		}
        		for(var i in arr_rtu){
        			if(arr_rtu[i]['rain'] != "-" && arr_rtu[i]['emd_cd']){
        				arr_poly[ arr_rtu[i]['emd_cd'] ]['polygon_cnt']++;
        				arr_poly[ arr_rtu[i]['emd_cd'] ]['polygon_sum'] += arr_rtu[i]['rain'];
        			}
        		}
    			for(var i in arr_poly){
    				var tmp_color = 0;
    				if( arr_poly[i]['polygon_sum'] != 0 ){
    					tmp_color = arr_poly[i]['polygon_sum'] / arr_poly[i]['polygon_cnt'];
    					tmp_color = toFixedOf(arr_poly[i]['polygon_sum'], 2);
    				}
    				tmp_color = get_color(tmp_color);
					
					if(polygon_feature[i]){
						// console.log(polygon_feature[41273111].length);
						if(polygon_feature[i].length > 1){
							for(var z in polygon_feature[i]){
								polygon_feature[i][z].setStyle(tmp_color);
							}
						}else{
							polygon_feature[i].setStyle(tmp_color);
						}
					}
					
    			}
    		});
		}
		
    	// 상태 업데이트
    	state_update = function(kind){
    		// var tmp_arr_area_code = [];
    		// var tmp_arr_state = [];
    		// var tmp_arr_line = [];
    		
			// for(var i in arr_rtu){
			// 	tmp_arr_area_code.push(i);
			// 	tmp_arr_state[i] = [];
			// 	tmp_arr_line[i] = [];
			// }
			// state_ajax = $.post( "controll/state.php", { "mode" : "state", "arr_area_code" : tmp_arr_area_code }, function(response){
			// 	$.each(response.list, function(index, item){
			// 		tmp_arr_state[item.area_code][0] = item.mainamp_stat;
			// 		tmp_arr_state[item.area_code][1] = item.amp_power;
			// 		tmp_arr_state[item.area_code][2] = item.logger_stat;
			// 		tmp_arr_state[item.area_code][3] = item.door_stat;
			// 		tmp_arr_state[item.area_code][4] = item.sensor_stat;
			// 		tmp_arr_line[item.area_code] = item.line;
			// 	});
			// }, "json");

			// $.when(null, state_ajax).done(function(){ // state_ajax 결과 리턴
    		// 	for(var i in tmp_arr_state){
    		// 		//console.log(tmp_arr_state[i]);
    		// 		if( jQuery.inArray(false, tmp_arr_state[i]) != "-1" ){
    		// 			arr_rtu[i]['state'] = false;
    		// 		}
    		// 		arr_rtu[i]['line'] = tmp_arr_line[i];
    		// 	}
				
    		// 	if(kind == 1) map_load(); // 처음만 map_load() 호출
        	// });
			map_load();
    	} // state_update() end
    	

		// 교집합 함수
		function intersect(a, b){
			var tmp={}, res=[];
			if(Array.isArray(b) && b.length !== 0){
				for(var i=0;i<a.length;i++) tmp[a[i]]=1;
				for(var i=0;i<b.length;i++) if(tmp[b[i]]) res.push(b[i]);
				// console.log(res);
			}
			return res;
		}
		// m값 만큼 곱한 후 n자리수까지 표현
		function toFixedOfNum(txt, n, m){
			// console.log(txt);
			if(txt == "-") return txt;
			if(typeof n != "number" || n > 12) return NaN;
			if(typeof m != "number") return NaN;
			var reck = 1;
			for (var i=0; i<n; i++) reck *= 10;
			var result = Math.round((txt*m) * reck) / reck;
			return result.toFixed(n);
		}
		// 원인자료 - 이벤트코드에 따라 단위 변경
		function toFixedOfEventValue(EVENT_CODE, EVENT_VALUE){
			var fixNum = 0;
			var unitNum = 1;
			var unitText = "";

			if(EVENT_CODE >= 19 && EVENT_CODE <= 22){
				fixNum = 1;
				// 강우 *0.01 빠짐 21/06/28 서정명
				unitText = "mm";
			}else if(EVENT_CODE >= 23 && EVENT_CODE <= 29){
				fixNum = 2;
				unitNum = 0.01;
				unitText = "m";
			}else if(EVENT_CODE >= 101 && EVENT_CODE <= 108){
				fixNum = 2;
				unitNum = 0.0001;
				unitText = "˚";
			}else{
				fixNum = 0;
				unitNum = 1;
				unitText = "";
			}
			return toFixedOfNum(EVENT_VALUE, fixNum, unitNum)+unitText;
		}

    	// 이벤트 업데이트
    	event_update = function(){
			var tmp_data = [];
			tmp_data[0] = [];
			tmp_data[1] = [];
			for(var i in arr_rtu){
				tmp_data[0].push(arr_rtu[i]['rtu_id']);
				tmp_data[1].push(i);
			}

			event_check_ajax = $.ajax({
			    type: "POST",
			    url: "controll/tutor.php",
			    data: { "mode" : "event_update"},
			    cache: false,
			    dataType: "json",
			    success : function(response) {
					var e_code_on = ["19", "20", "21", "23", "25", "27", "33", "37", "101", "102", "103", "104"];
					var e_code_off = ["22", "24", "26", "28", "35", "105", "106", "107", "108"];
					// var e_code_all = ["19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "33", "35", "37", "101", "102", "103", "104", "105", "106", "107", "108"];
					var step_on_1 = ["19", "23", "101"];
					var step_on_2 = ["20", "25", "102"];
					var step_on_3 = ["21", "27", "103"];
					// var step_on_4 = ["37", "33", "104"];
					var step_off_1 = ["22", "24", "105"];
					var step_off_2 = ["26", "106"];
					var step_off_3 = ["28", "107"];
					var iconImg = "";
					var list = response.data2;
					var tmp_html = "";
					var event_cnt = 0;
					var rain_true = true;
					var flow_true = true;
					var aws_true = true;
					var snow_true = true;
					
					if(list.length > 0){
						$.each(list, function(i, v){			
							if(v.EVENT_CODE == 1 || v.EVENT_CODE == 2){ // 호우 경보 && 다우 경보
								if(rain_true || aws_true){
									if(v.EVENT_LEVEL == 0){
										if(v.RTU_TYPE == "A00"){
											aws_event(v.AREA_CODE, 0 , 1); // 호우 경보 & 다우 경보 해제
											aws_true = false;
										}else{
											rain_event(v.AREA_CODE, 0 , 1); // 호우 경보 & 다우 경보 해제
											rain_true = false;
										}
									}else if(v.EVENT_LEVEL == 1){
										if(v.RTU_TYPE == "A00"){
											aws_event(v.AREA_CODE, 1 , 1); // 호우 & 다우 주의보
											aws_true = false;
										}else{
											rain_event(v.AREA_CODE, 1 , 1); // 호우 & 다우 주의보
											rain_true = false;
										}
									}else if(v.EVENT_LEVEL == 2){
										if(v.RTU_TYPE == "A00"){
											aws_event(v.AREA_CODE, 1 , 2); // 호우 & 다우 경보
											aws_true = false;
										}else{
											rain_event(v.AREA_CODE, 1 , 2); // 호우 & 다우 경보
											rain_true = false;
										}
									}
								}
							}else if(v.EVENT_CODE == 11 || v.EVENT_CODE == 12){ // 수위 급상승 경보
								if(flow_true){
									if(v.EVENT_LEVEL == 0){
										flow_event(v.AREA_CODE, 0 , 1); // 다우경보 해제
									}else if(v.EVENT_LEVEL == 1){
										flow_event(v.AREA_CODE, 1 , 1); // 다우 주의보 
									}else if(v.EVENT_LEVEL == 2){
										flow_event(v.AREA_CODE, 1 , 2); // 다우 경보
									}
									flow_true = false;
								}
							}else if(v.EVENT_CODE == 21 || v.EVENT_CODE == 22 || v.EVENT_CODE == 31){ // 한파경보 & 폭염경보 & 강풍주의보
								if(aws_true){
									if(v.EVENT_LEVEL == 0){
										aws_event(v.AREA_CODE, 0 , 1); // 다우경보 해제
									}else if(v.EVENT_LEVEL == 1){
										aws_event(v.AREA_CODE, 1 , 1); // 다우 주의보 
									}else if(v.EVENT_LEVEL == 2){
										aws_event(v.AREA_CODE, 1 , 2); // 다우 경보
									}
								}
							}else if(v.EVENT_CODE == 254 || v.EVENT_CODE == 255){ // 장비 상태 & 통신 상태 
								if(v.RTU_TYPE == "R00"){
									if(v.EVENT_LEVEL == 0){
										rain_event(v.AREA_CODE, 0 , 1); // 강우 장비 상태 이상 해제
									}else if(v.EVENT_LEVEL == 1){
										rain_event(v.AREA_CODE, 1 , 1); // 강우 장비 상태 주의보 해제
									}else if(v.EVENT_LEVEL == 2){
										rain_event(v.AREA_CODE, 1 , 2); // 강우 장비 상태 경보 해제
									}
								}else if(v.RTU_TYPE == "F00"){
									if(v.EVENT_LEVEL == 0){
										flow_event(v.AREA_CODE, 0 , 1); // 수위 장비 상태 이상 해제
									}else if(v.EVENT_LEVEL == 1){
										flow_event(v.AREA_CODE, 1 , 1); // 수위 장비 상태 주의보 해제
									}else if(v.EVENT_LEVEL == 2){
										flow_event(v.AREA_CODE, 1 , 2); // 수위 장비 상태 경보 해제
									}
								}else if(v.RTU_TYPE == "A00"){
									if(v.EVENT_LEVEL == 0){
										aws_event(v.AREA_CODE, 0 , 1); // AWS 장비 상태 이상 해제
									}else if(v.EVENT_LEVEL == 1){
										aws_event(v.AREA_CODE, 1 , 1); // AWS 장비 상태 주의보 해제
									}else if(v.EVENT_LEVEL == 2){
										aws_event(v.AREA_CODE, 1 , 2); // AWS 장비 상태 경보 해제
									}
								}
							}
						});
					}
			    },
			    error : function(xhr, status, error) {
					console.log("event_update() error");
				}
			}); // ajax end

			event_ajax = $.ajax({
			    type: "POST",
			    url: "controll/tutor.php",
			    data: { "mode" : "event_update", "arr_rtu_id" : tmp_data[0], "arr_area_code" : tmp_data[1] },
			    cache: false,
			    dataType: "json",
			    success : function(response) {

			    	var now_date = response.now_date; // 현재 시간
					var event_1 = 0; // 관심 -> 주의
					var event_2 = 0; // 주의 -> 경계
					var event_3 = 0; // 경계 -> 심각
					var event_4 = 0; // 심각 -> x

			    	$.each(response.data, function(i, v){
			    		var area_code = v.area_code;
			    		var rtu_rs = v.rtu_rs;
			    		var rtu_log = v.rtu_log;
			    		var event_rs = v.event_rs;
			    		var event_hist = v.event_hist;

			    		if(arr_rtu[area_code]['rtu_type'] == "B00" || arr_rtu[area_code]['rtu_type'] == "BA0" || arr_rtu[area_code]['rtu_type'] == "BR0" || arr_rtu[area_code]['rtu_type'] == "BF0"){ // 방송 장비만
				    		if(rtu_rs){
	    						if(rtu_log.TRANS_FLAG == 0){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 0;
	    						}else if(rtu_log.TRANS_FLAG == 10){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 1;
	    						}else if(rtu_log.TRANS_FLAG == 20){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 2;
	    						}else if(rtu_log.TRANS_FLAG == 30){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 3;
	    						}else if(rtu_log.TRANS_FLAG == 40){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 4;
	    						}else if(rtu_log.TRANS_FLAG == 50){
	    							arr_rtu[area_code]['alert_state'] = true;
	    							arr_rtu[area_code]['alert_step'] = 5;
	    						}else if(rtu_log.TRANS_FLAG == 99){
	    							arr_rtu[area_code]['alert_state'] = false;
	    							arr_rtu[area_code]['alert_step'] = 6;
	    						}else{
	    							arr_rtu[area_code]['alert_state'] = false;
	    						}
	    						
								var now_y = now_date.substr(0, 4);
								var now_m = now_date.substr(5, 2) - 1;
								var now_d = now_date.substr(8, 2);
								var now_h = now_date.substr(11, 2);
								var now_i = now_date.substr(14, 2);
								var now_s = now_date.substr(17, 2);
								var now_time = new Date(now_y, now_m, now_d, now_h, now_i, now_s).getTime();
								
								var tmp_date = rtu_log.TRANS_CHECK;
								var tmp_y = tmp_date.substr(0, 4);
								var tmp_m = tmp_date.substr(5, 2) - 1;
								var tmp_d = tmp_date.substr(8, 2);
								var tmp_h = tmp_date.substr(11, 2);
								var tmp_i = tmp_date.substr(14, 2);
								var tmp_s = tmp_date.substr(17, 2);
								var tmp_time = new Date(tmp_y, tmp_m, tmp_d, tmp_h, tmp_i, tmp_s).getTime();
								
								var tmp_diff = now_time - tmp_time;
	
	
								if(rtu_log.TRANS_ERROR != 0){
									arr_rtu[area_code]['alert_error'][0] = true;
									arr_rtu[area_code]['alert_error'][1] = rtu_log.TRANS_ERROR;
								}else{
									arr_rtu[area_code]['alert_error'][0] = false;
									arr_rtu[area_code]['alert_error'][1] = rtu_log.TRANS_ERROR;
									
									// 에러 코드를 뱉지 않은 상태에서 2분 경과 시
									if( tmp_diff > 2 * 60 * 1000 ){
										if( arr_rtu[area_code]['alert_state'] ){ // 방송이 진행중일 경우
											arr_rtu[area_code]['alert_error'][0] = true; // 에러 처리
										}
									}
								}
								
								// VHF 방송 종료 시
								if(rtu_log.VHF_CALL == 7){
									arr_rtu[area_code]['alert_error'][0] = false;
									if( tmp_diff > 15 * 1000 ){ // 15초 경과 시
		    							arr_rtu[area_code]['alert_step'] = 4;
									}
									if( tmp_diff > 35 * 1000 ){ // 35초 경과 시
										arr_rtu[area_code]['alert_state'] = false;
									}
								}
								// 크로샷 송신 시
								if(rtu_log.TRANS_FLAG == 20 && rtu_log.TRANS_ERROR == 88){
									arr_rtu[area_code]['alert_error'][0] = false;
									if( tmp_diff > 15 * 1000 ){ // 15초 경과 시
		    							arr_rtu[area_code]['alert_step'] = 4;
									}
									if( tmp_diff > 35 * 1000 ){ // 35초 경과 시
										arr_rtu[area_code]['alert_state'] = false;
									}	
								}
								// 패킷 에러 처리
								if( (rtu_log.TRANS_FLAG == 20 || rtu_log.TRANS_FLAG == 30 || rtu_log.TRANS_FLAG == 40) && 
									(rtu_log.TRANS_ERROR == 13 || rtu_log.TRANS_ERROR == 14 || rtu_log.TRANS_ERROR == 15) ){
									arr_rtu[area_code]['alert_error'][0] = false;
									arr_rtu[area_code]['alert_state'] = false;
								}
							}
			    		}
						if(event_rs){
							$.each(event_hist, function(i, v){
								// console.log(i , v);
    	    					if(v['event_code'] == 19 || v['event_code'] == 23 || v['event_code'] == 101){ // 관심 - 주의보
    	    						event_1++;
    	    					}else if(v['event_code'] == 20 || v['event_code'] == 25 || v['event_code'] == 102){ // 주의 - 경보
    	    						event_2++;
	    						}else if(v['event_code'] == 21 || v['event_code'] == 27 || v['event_code'] == 103){ // 경계 - 대피
    	    						event_3++;  	
	    						}else if(v['event_code'] == 37 || v['event_code'] == 33 || v['event_code'] == 104){ // 심각 - x
    	    						event_4++;
	    						}
							});
						}	
			    	}); // $.each(response.data, function(i, v) end

		    		// 금일발령상황 변경
		    		$("#danger_1").text(event_1 + "건");
		    		$("#danger_2").text(event_2 + "건");
		    		$("#danger_3").text(event_3 + "건");
		    		// $("#danger_4").text(event_4 + "건");
		    		
		    		// 금일발령상황 슬라이드 업데이트
	      			if(slide_state[3]){
		    			event_slide();
		    		}
			    },
			    error : function(xhr, status, error) {
					console.log("event_update() error");
				}
			}); // ajax end
    	} // event_update() end

    	// 시간 업데이트
    	time_update = function(){
			var now_server_time = new Date();
			var now_date = now_server_time;
			var now_y = now_date.getFullYear();
			var now_m = now_date.getMonth() + 1;
			var now_d = now_date.getDate();
			var now_h = now_date.getHours();
			var now_i = now_date.getMinutes();
			var now_s = now_date.getSeconds();
			if(String(now_s).length == 1) now_s = '0'+now_s;
			$("#now_date").html(now_y+'년 '+now_m+'월 '+now_d+'일 '+now_h+'시'+now_i+'분 '+now_s+'초 현재');
			$("#event_date").html(now_y+'년 '+now_m+'월 '+now_d+'일');
    	} // time_update() end
    	
    } // map_api() end

    function tutor_reset(){
		clearInterval(setInt_data1); // 상황판 호출 중지
		clearInterval(setInt_data2); // 장비상태 호출 중지
		clearInterval(setInt_data3); // 예보 호출 중지
		clearInterval(setInt_data4); // 시간 호출 중지
		clearInterval(setInt_slide); // 슬라이드 호출 중지
    	$("#map").remove();
    	tutor();
    }
		
	// map_data 요소 더블클릭 시 -> 버튼 클릭 시 전체 화면으로
	function onfullscreen(el){
		// console.log($(el));
		var elClass = $(el).parent().parent().children("span:eq(1)").attr("class");
		var tmpArr = elClass.split(" ");
		// console.log(tmpArr);
		var mapDataArr = ["radar", "heroes"]; // 우측 요소 - 레이더, 위성
		if($.inArray(tmpArr[1], mapDataArr) != -1){
			$("#popupType").val(tmpArr[1]);
		}
		// 새창 열기
		var newOpenWin = window.open("index_popup.php",
		"popup_data_" + tmpArr[1], "width=900, height=980, resizable = no, scrollbars = no"); 
	}

//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//====================================DOCUMENT READY==========================================
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


    $(document).ready(function(){
		document.cookie = "safeCookie1=foo; SameSite=Lax";
		document.cookie = "safeCookie2=foo";
		document.cookie = "crossCookie=bar; SameSite=None; Secure";

    	// 이미지 오버
    	$("img.rollover").hover(function(){
    		this.src = this.src.replace("_off", "_on");
    	}, function(){
    		this.src = this.src.replace("_on", "_off");
    	}); // $("img.rollover").hover end
    	
    	// 로그아웃
    	$("#btn_logout").click(function(){
    		$.post("controll/login.php", { "mode" : "logout" }, function(response){
				location.href = "../divas/monitoring/login.php";
    		}, "json");
    	});
    	
    	// 상단 로고 및 텍스트 변경
    	$("#view_top_img").click(function(){
    		$("#sel_top_img").trigger("click");
    	});
    	$("#sel_top_img").change(function(){
    		$("#view_top_img").val(this.value);
    	});
    	$("#btn_top_img").click(function(){
    		var tmp_val = $("#sel_top_img").val();
    		if( !tmp_val ){
				swal("체크", "이미지를 선택해 주세요.", "warning"); return false;
    		}
    		$("#tutor_form").submit();
    	});
    	$('#tutor_form').submit(function(){
    		var tmp_data = new FormData($(this)[0]); 
    		$.ajax({
    			url: "controll/tutor.php",
    			type: "POST",
    			data: tmp_data,
    			dataType: "json",
    			async: false,
    			cache: false,
    			contentType: false,
    			processData: false,
    			success: function(response){
    				if(response['check'][0] == 1){
    					tutor_reset();
    				}else{	
    					swal("오류", response['check'][1], "warning"); return false;
    				}
    			}
    		});
    		tmp_data = null;
    		return false;
    	});
    	$("#btn_top_text").click(function(){
    		var tmp_val = $("#sel_top_text").val();
    		if( !tmp_val ){
    			swal("체크", "제목을 입력해 주세요.", "warning"); return false;
    		}else if( tmp_val.length > 20 ){
    			swal("체크", "제목은 20자까지 입력할 수 있습니다.", "warning"); return false;
    		}
    		$.post("controll/tutor.php", { "mode" : "top_change", "kind" : "text", "data" : tmp_val }, function(response){
    			if(response['check'][0] == 1) tutor_reset();
    		}, "json");
    		tmp_val = null;
    	});
    	
    	// 오버레이 줌레벨 막대
    	var sel_over = $("#sel_over_level select");
		var slider = $("#slider_over").slider({
			min: 0,
			max: 22,
			range: "min",
			value: sel_over[ 0 ].selectedIndex,
			slide: function( event, ui ) {
				sel_over[ 0 ].selectedIndex = ui.value;
			},
			stop: function( event, ui ) {
				if(Number(ui.value) < clus_level){
					swal("체크", "라벨 표시 줌레벨은 장비 그룹 줌레벨보다 커야 합니다.", "warning");
					sel_over[ 0 ].selectedIndex = over_level;
					$("#slider_over").slider("value", over_level);
					return false;
				}
	    		swal({
	    			title: "<div class='alpop_top_b'>줌레벨 변경 확인</div><div class='alpop_mes_b'>라벨 표시 줌레벨을 변경하실 겁니까?</div>",
	    			text: "확인 시 화면에 바로 적용 됩니다.",
	    			showCancelButton: true,
	    			confirmButtonColor: "#5b7fda",
	    			confirmButtonText: "확인",
	    			cancelButtonText: "취소",
	    			closeOnConfirm: false,
	    			html: true
	    		}, function(isConfirm){
					if(isConfirm){
			    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "over_level", "data" : ui.value }, function(){ 
			    			over_level = ui.value;
	    	        		box_update();
			    		});
			    		swal("성공", "라벨 표시 줌레벨 변경이 완료 됐습니다.", "success");
					}else{
						sel_over[ 0 ].selectedIndex = over_level;
						$("#slider_over").slider("value", over_level);
					}
	    		});
			}
		});
    	// // 클러스터 줌레벨 막대
    	// var sel_clus = $("#sel_clus_level select");
		// var slider = $("#slider_clus").slider({
		// 	min: 0,
		// 	max: 22,
		// 	range: "min",
		// 	value: sel_clus[ 0 ].selectedIndex,
		// 	slide: function( event, ui ) {
		// 		sel_clus[ 0 ].selectedIndex = ui.value;
		// 	},
		// 	stop: function( event, ui ) {
		// 		if(Number(ui.value) > over_level){
		// 			swal("체크", "장비 그룹 줌레벨은 라벨 표시 줌레벨보다 작아야 합니다.", "warning");
		// 			sel_clus[ 0 ].selectedIndex = clus_level;
		// 			$("#slider_clus").slider("value", clus_level);
		// 			return false;
		// 		}
	    // 		swal({
	    // 			title: "<div class='alpop_top_b'>줌레벨 변경 확인</div><div class='alpop_mes_b'>장비 그룹 줌레벨을 변경하실 겁니까?</div>",
	    // 			text: "확인 시 화면에 바로 적용 됩니다.",
	    // 			showCancelButton: true,
	    // 			confirmButtonColor: "#5b7fda",
	    // 			confirmButtonText: "확인",
	    // 			cancelButtonText: "취소",
	    // 			closeOnConfirm: false,
	    // 			html: true
	    // 		}, function(isConfirm){
	    // 			if(isConfirm){
	    // 				$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "clus_level", "data" : ui.value }, function(){ 
	    // 					clus_level = ui.value;
	    // 					cluster.setMaxZoom(clus_level);
		// 	    		});
	    // 				swal("성공", "장비 그룹 줌레벨 변경이 완료 됐습니다.", "success");
	    // 			}else{
	    // 				sel_clus[ 0 ].selectedIndex = clus_level;
		// 				$("#slider_clus").slider("value", clus_level);
	    // 			}
	    // 		});
		// 	}
		// });
		// 오버레이 줌레벨 셀렉트 변경 이벤트
		$(document).on("change","#sel_over_level select",function(){
			if(Number(this.value) < clus_level){
				swal("체크", "라벨 표시 줌레벨은 장비 그룹 줌레벨보다 커야 합니다.", "warning");
				$("#sel_over_level select").val(over_level);
				return false;
			}
    		swal({
    			title: "<div class='alpop_top_b'>줌레벨 변경 확인</div><div class='alpop_mes_b'>라벨 표시 줌레벨을 변경하실 겁니까?</div>",
    			text: "확인 시 화면에 바로 적용 됩니다.",
    			showCancelButton: true,
    			confirmButtonColor: "#5b7fda",
    			confirmButtonText: "확인",
    			cancelButtonText: "취소",
    			closeOnConfirm: false,
    			html: true
    		}, function(isConfirm){
				if(isConfirm){
					var tmp_value = $("#sel_over_level select").val();
					$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "over_level", "data" : tmp_value }, function(){ 
						over_level = tmp_value;
    	        		box_update();
		    		});
		    		swal("성공", "라벨 표시 줌레벨 변경이 완료 됐습니다.", "success");
				}else{
					$("#sel_over_level select").val(over_level);
				}
    		});
    	});
		// 클러스터 줌레벨 셀렉트 변경 이벤트
		$(document).on("change","#sel_clus_level select",function(){
			if(Number(this.value) > over_level){
				swal("체크", "장비 그룹 줌레벨은 라벨 표시 줌레벨보다 작아야 합니다.", "warning");
				$("#sel_clus_level select").val(clus_level);
				return false;
			}
    		swal({
    			title: "<div class='alpop_top_b'>줌레벨 변경 확인</div><div class='alpop_mes_b'>장비 그룹 줌레벨을 변경하실 겁니까?</div>",
    			text: "확인 시 화면에 바로 적용 됩니다.",
    			showCancelButton: true,
    			confirmButtonColor: "#5b7fda",
    			confirmButtonText: "확인",
    			cancelButtonText: "취소",
    			closeOnConfirm: false,
    			html: true
    		}, function(isConfirm){
    			if(isConfirm){
					var tmp_value = $("#sel_clus_level select").val();
    	    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "clus_level", "data" : tmp_value }, function(){ 
    	    			clus_level = tmp_value;
    					cluster.setMaxZoom(clus_level);
    	    		});
    				swal("성공", "장비 그룹 줌레벨 변경이 완료 됐습니다.", "success");
    			}else{
    				$("#sel_clus_level select").val(clus_level);
    			}
    		});
    	});
		
		// 현재 중심 좌표 및 줌레벨 저장
		$("#btn_setting").click(function(){
			var change_ajax = [];
			
			var tmp_cent = map.getView().getCenter();
			console.log(tmp_cent);

      		map_cent = ol.proj.transform([tmp_cent[0], tmp_cent[1]], 'EPSG:900913', 'EPSG:4326'),
			
			console.log(map_cent);
      		change_ajax[0] = $.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_cent", "data" : map_cent }, function(){ });
      		
      		change_ajax[1] = $.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_level", "data" : map_level }, function(){ });
      		
      		// change_ajax 결과 리턴
        	$.when.apply(null, change_ajax).done(function(){
        		swal("성공", "현재 중심 좌표와 줌레벨이 저장 됐습니다.", "success");
        	});
        	tmp_cent = null;
    	});
    	// 장비 위치 이동 가능 여부 토글 버튼
    	$("#sel_move").lc_switch();
		$("#overlay_move").lc_switch();

		// 오버레이 위치 이동 가능 여부
		$("body").delegate("#overlay_move", "lcs-on", function(){
			$("#overlay_move input").prop('checked', true);
			swal({
				title : "오버레이 이동", 
				text : "\n \n이동 할 오버레이를 클릭하여 선택해주세요.",
				type : "success",
				timer : 2000,
				showConfirmButton : false
			});
		});
		$("body").delegate("#overlay_move", "lcs-off", function(){
				$("#overlay_move input").prop('checked', false);
				
		});
		// 장비 위치 이동 가능 여부
    	$("body").delegate("#sel_move", "lcs-on", function(){
			for(var i in arr_rtu){
    			// if(arr_rtu[i]['marker']) arr_rtu[i]['marker'].setDraggable(true);
    		}
			for(var i in arr_sub_rtu){
				// if(arr_sub_rtu[i]['marker']) arr_sub_rtu[i]['marker'].setDraggable(true);
    		}
			
			map_move = 2;
			$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_move", "data" : map_move }, function(){ });
    	});
    	$("body").delegate("#sel_move", "lcs-off", function(){

			for(var i in arr_rtu){
    			// if(arr_rtu[i]['marker']) arr_rtu[i]['marker'].setDraggable(false);
    		}

			for(var i in arr_sub_rtu){
				// if(arr_sub_rtu[i]['marker']) arr_sub_rtu[i]['marker'].setDraggable(false);
    		}
			
			map_move = 1;
			$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_move", "data" : map_move }, function(){ });
    	});

    	$(document).on("change","#sel_box input",function(){
    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_box", "data" : this.value }, function(){ });
    		location.reload();
    	});
    	$(document).on("change","#sel_size input",function(){
    		map_size = this.value;
    		box_update();

    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_size", "data" : this.value }, function(){ });
    	});
    	$(document).on("change","#sel_setting input:checkbox[name='sel_reset']",function(){
    		var now_sel_reset = $("#sel_setting input:checkbox[name='sel_reset']").is(":checked");

			if(now_sel_reset){
	    		swal({
	    			title: "<div class='alpop_top_b'>환경 설정 확인</div><div class='alpop_mes_b'>정말로 환경 설정을 리셋하실 겁니까?</div>",
	    			text: "초기 화면과 장비 좌표가 리셋 됩니다.",
	    			showCancelButton: true,
	    			confirmButtonColor: "#5b7fda",
	    			confirmButtonText: "확인",
	    			cancelButtonText: "취소",
	    			closeOnConfirm: false,
	    			html: true
	    		}, function(isConfirm){
	    			if(isConfirm){
	    				$.post("controll/tutor.php", { "mode" : "map_reset" }, function(response){
							if(response.result){
								if(response.data[0] && response.data[1] && response.data[2]){
				    				swal("성공", "환경 설정 리셋이 완료 됐습니다.", "success");
									location.reload();
								}else{
									swal("실패", "환경 설정 리셋 중 오류가 발생 했습니다.", "warning");
									console.log("map_reset update error");
								}
							}else{
								console.log("map_reset error");
							}
						}, "json");
	    			}else{
	    				$("#sel_setting input:checkbox[name='sel_reset']").prop("checked", false);
	    			}
	    		});
			}
			now_sel_reset = null;
    	});
    	$(document).on("change","#sel_type input",function(){
    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_type", "data" : this.value }, function(){ 
    			tutor_reset();
    		});
    	});
    	$(document).on("change","#sel_sub input",function(){
    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_sub", "data" : this.value }, function(){ 
    			tutor_reset();
    		});
    	});

    	$(document).on("change","#sel_kind input",function(){
			$("#sel_kind input").closest("li").attr("class", "");
			$("#sel_kind input:radio[value='"+this.value+"']").closest("li").attr("class", "bg_act");
			map_kind = this.value;

			$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_kind", "data" : this.value }, function(){
				tutor_reset();
			});
    	});

    	$(document).on("change","#sel_data input",function(){
    		var obj = $("#sel_data input:checkbox[name=sel_data]");
//    		var obj = $("#sel_data input:radio[name=sel_data]"); //AA
    		
    		map_data = [];
    		for(var i = 0; i < obj.length; i ++){
				if(obj[i].checked == true){
        			$(obj[i]).closest("li").attr("class", "bg_act");
    				map_data.push(obj[i].value);
    			}else{
    				$(obj[i]).closest("li").attr("class", "");
    			}
			}
    		box_update();
     		// cluster._redraw(); //BB

    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_data", "data" : map_data }, function(){ });
    		obj = null;
		});

		//시설구분
		$(document).on("click","#legend2",function(){
			$("#legend2 #img_tag").toggle(500);
		});
		//범례
		$(document).on("click","#legend",function(){
			$("#legend #img_tag").toggle(500);
		});

    	$(document).on("click","#sel_data2",function(){
//    		return false; //AA
    		var obj = $("#sel_data input:checkbox[name=sel_data]");
    		var obj_checked = $("#sel_data input:checkbox[name=sel_data]:checked");

    		map_data = [];
     		if(obj_checked.length == obj.length){
	    		for(var i = 0; i < obj.length; i ++){
	    			obj[i].checked = false;
	    			$(obj[i]).closest("li").attr("class", "");
	    		}
     		}else{
	    		for(var i = 0; i < obj.length; i ++){
	    			obj[i].checked = true;
	    			$(obj[i]).closest("li").attr("class", "bg_act");
	    			map_data.push(obj[i].value);
	    		}
    		}
    		box_update();
     		// cluster._redraw(); //BB

    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_data", "data" : map_data }, function(){ });
    		obj = null; obj_checked = null;
		});
    	$(document).on("change","#sel_skin input",function(){

			var Tile = new ol.layer.Group({
				layers: [
					new ol.layer.Tile({
						source: new ol.source.XYZ({
							url: 'http://api.vworld.kr/req/wmts/1.0.0/'+api_key+'/'+(this.value == 1 ? 'Base' : (this.value == 2 ? 'Satellite' : (this.value == 3 ? 'Hybrid' : (this.value == 4 ? 'gray' : (this.value == 5 ? 'midnight' : 'base')))))+'/{z}/{y}/{x}.'+(this.value == 1 ? 'png' :(this.value == 2 ? 'jpeg' : 'png'))
						})
					})
				]
			});
			$(".ol-overviewmap").remove();
    		if(this.value == 1){
        		// if(this.value == 1) tmp_map_type = "NORMAL";
    			$("#sel_skin input:radio[value='1']").closest("li").attr("class", "bg_act");
    			$("#sel_skin input:radio[value='2']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='3']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='4']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='5']").closest("li").attr("class", "");

				map.addControl(new ol.control.OverviewMap({
					layers: [
						new ol.layer.Tile({
							source: new ol.source.XYZ({
								url: 'http://api.vworld.kr/req/wmts/1.0.0/'+api_key+'/Satellite/{z}/{y}/{x}.jpeg'
							})
						})
					],
					collapsed: false
				}));

    		}else if(this.value == 2){
    			// tmp_map_type = "SATELLITE";
    			$("#sel_skin input:radio[value='1']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='2']").closest("li").attr("class", "bg_act");
				$("#sel_skin input:radio[value='3']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='4']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='5']").closest("li").attr("class", "");

				map.addControl(new ol.control.OverviewMap({
					layers: [
						new ol.layer.Tile({
							source: new ol.source.XYZ({
								url: 'http://api.vworld.kr/req/wmts/1.0.0/'+api_key+'/Base/{z}/{y}/{x}.png'
							})
						})
					],
					collapsed: false
				}));
			}else if(this.value == 3){
    			// tmp_map_type = "Hybrid";
    			$("#sel_skin input:radio[value='1']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='2']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='3']").closest("li").attr("class", "bg_act");
    			$("#sel_skin input:radio[value='4']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='5']").closest("li").attr("class", "");
			}else if(this.value == 4){
    			// tmp_map_type = "Gray";
    			$("#sel_skin input:radio[value='1']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='2']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='3']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='4']").closest("li").attr("class", "bg_act");
				$("#sel_skin input:radio[value='5']").closest("li").attr("class", "");
			}else if(this.value == 5){
    			// tmp_map_type = "Midnight";
    			$("#sel_skin input:radio[value='1']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='2']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='3']").closest("li").attr("class", "");
    			$("#sel_skin input:radio[value='4']").closest("li").attr("class", "");
				$("#sel_skin input:radio[value='5']").closest("li").attr("class", "bg_act");
    		}
			map.setLayerGroup(Tile);

			box_polygon(); // 박스 폴리곤 호출

			box_update();

    		$.post("controll/tutor.php", { "mode" : "map_setting", "sub_mode" : "map_skin", "data" : this.value }, function(){ });
    		tmp_map_type = null;
    	});
    	$(document).on("click","#btn_event",function(){
			slide_on("event", null);
			
    	});
    	$(window).resize(function(){
    		if(map_type == 2){
		    	$(".menu_map").css("right", $("#map_data").width() + 10);
				$(".menu_now").css("right", $("#map_data").width() + 10);
		    	$(".m_menu").css("right", $("#map_data").width() + 120);
    		}
    	});
    	// 슬라이드 플러그인
        $('#slider_forec').sidr({
        	name: 'con_forec',
        	source: '#con_forec',
        	onOpen: function onOpenEnd(){
				$(".menu_left").attr("style", "left: 460px;");
				$(".layer_top").css("left", "530px");
				if(map_control_type == 1){
					$("#con_forec").css("top",'0px');
				}else{
					$("#con_forec").css("top",'42px');
				}
				
        	},
        	onClose: function onCloseEnd(){
				$(".menu_left").attr("style", "right: 460px;");
				$(".layer_top").css("left", "80px");
        	}
        });

    }); // $(document).ready end
    

    // 서버 시간
	function srvTime(){
		if(window.XMLHttpRequest){
			xmlHttp = new XMLHttpRequest(); // IE 7.0 이상, 크롬, 파이어폭스 등
			xmlHttp.open('HEAD',window.location.href.toString(),false);
			xmlHttp.setRequestHeader("Content-Type", "text/html");
			xmlHttp.send('');
			return xmlHttp.getResponseHeader("Date");
		}else if(window.ActiveXObject){
			xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
			xmlHttp.open('HEAD',window.location.href.toString(),false);
			xmlHttp.setRequestHeader("Content-Type", "text/html");
			xmlHttp.send('');
			return xmlHttp.getResponseHeader("Date");
		}
	}

    // 쿠키 체크
    function cookie_check(){
    	$.post("controll/tutor.php", { "mode" : "cookie_check" }, function(response){ 
    		console.log(response.cookie);
        }, "json");
    }
    
    // 강우량에 따른 색상값
	function get_color(rain){

		var poly_style = "";
		var color = "";
		if(rain > 0 && rain <= 2) color = [231,232,156,0.6]; //"#e7e89c";
		else if(rain > 2 && rain <= 4) color = [220,220,106,0.6]; //"#dcdc6a";
		else if(rain > 4 && rain <= 6) color = [209,210,57,0.6]; //"#d1d239";
		else if(rain > 6 && rain <= 8) color = [169,169,39,0.6]; //"#a9a927";
		else if(rain > 8 && rain <= 10) color = [121,120,28,0.6]; //"#79781c";
		else if(rain > 10 && rain <= 14) color = [154,214,150,0.6]; //"#9ad696";
		else if(rain > 14 && rain <= 18) color = [104,189,96,0.6]; //"#68bd60";
		else if(rain > 18 && rain <= 22) color = [52,161,52,0.6]; //"#34a134";
		else if(rain > 22 && rain <= 26) color = [38,154,47,0.6]; //"#269a2f";
		else if(rain > 26 && rain <= 30) color = [30,124,40,0.6]; //"#1e7c28";
		else if(rain > 30 && rain <= 36) color = [153,217,217,0.6]; //"#99d9d9";
		else if(rain > 36 && rain <= 42) color = [106,199,207,0.6]; //"#6ac7cf";
		else if(rain > 42 && rain <= 48) color = [51,177,192,0.6]; //"#33b1c0";
		else if(rain > 48 && rain <= 54) color = [41,163,164,0.6]; //"#29a3a4";
		else if(rain > 54 && rain <= 60) color = [25,119,119,0.6]; //"#197777";
		else if(rain > 60 && rain <= 68) color = [157,154,201,0.6]; //"#9d9ac9";
		else if(rain > 68 && rain <= 76) color = [105,103,176,0.6]; //"#6967b0";
		else if(rain > 76 && rain <= 84) color = [54,54,150,0.6]; //"#363696";
		else if(rain > 84 && rain <= 92) color = [36,38,141,0.6]; //"#24268d";
		else if(rain > 92 && rain <= 100) color = [33,28,120,0.6]; //"#211c78";
		else if(rain > 100 && rain <= 110) color = [231,155,202,0.6]; //"#e79bca";
		else if(rain > 110 && rain <= 120) color = [221,105,178,0.6]; //"#dd69b2";
		else if(rain > 120 && rain <= 130) color = [212,53,153,0.6]; //"#d43599";
		else if(rain > 130 && rain <= 140) color = [169,38,142,0.6]; //"#a9268e";
		else if(rain > 140 && rain <= 150) color = [120,26,120,0.6]; //"#781a78";
		else if(rain > 150 && rain <= 170) color = [230,154,156,0.6]; //"#e69a9c";
		else if(rain > 170 && rain <= 190) color = [221,105,106,0.6]; //"#dd696a";
		else if(rain > 190 && rain <= 210) color = [209,56,58,0.6]; //"#d1383a";
		else if(rain > 210 && rain <= 230) color = [169,34,38,0.6]; //"#a92226";
		else if(rain > 230) color = [120,26,27,0.6]; //"#781a1b";
		else color = [255,255,255,0.1];

		poly_style = new ol.style.Style({
			stroke: new ol.style.Stroke({
				color: '#004c80',//[20, 0, 5, .7],
				opacity: 0.8,
				width: 2
			}),
			fill: new ol.style.Fill({
				color: color,//[20, 0, 5, .7],
				opacity: 0.8,
			})
		});

		return poly_style;
	}

	function elastic(t) {
		return Math.pow(2, -10 * t) * Math.sin((t - 0.075) * (2 * Math.PI) / 0.3) + 1;
	}

    // 슬라이드 오픈
    function slide_on(kind, data){
        //console.log(kind+": "+data);
    	slide_state[0] = false; // state
    	slide_state[1] = false; // graph
    	slide_state[2] = false; // spot
    	slide_state[3] = false; // event
    	slide_state[4] = false; // stillcut
        slide_value = [];
        
        var add_url = "";
        if( jQuery.inArray(kind, ["rain", "flow", "snow", "disp", "wind", "damp", "temp", "pres"]) != "-1" ){
            add_url = "graph";
        }else{
            add_url = kind;
        }

        $("#con_forec").load("sr_"+add_url+".php", function(response, status, xhr){
        	if(status == "success"){
 				// 슬라이드 플러그인
 		        $('#slider_forec').sidr({
 		        	name: 'con_forec',
 		        	source: '#con_forec',
 		        	onOpen: function onOpenEnd(){
						
						if(map_control_type == 1){
							$("#con_forec").css("top",'0px');
						}else{
							$("#con_forec").css("top",'42px');
						}
						$(".menu_left").attr("style", "left: 460px;");
						$(".layer_top").css("left", "530px");
						 
 		        	},
 		        	onClose: function onCloseEnd(){
 		        		if(add_url == "state"){
 		        			slide_state[0] = false;
 		        		}else if(add_url == "graph"){
 		        			slide_state[1] = false;
 		        		}else if(add_url == "spot"){
 		        			slide_state[2] = false;
 		        		}else if(add_url == "event"){
 		        			slide_state[3] = false;
 		        		} else if(add_url == "stillcut"){
 		        			slide_state[4] = false;
						 }else if(add_url == "farm"){
							slide_state[5] = false;
						}
						 $(".menu_left").attr("style", "right: 460px;");
						 if(add_url== "farm"){
							$(".menu_left").hide();
						 }
						 
						 	$(".layer_top").css("left", "80px");
						 
 		        	}
 		        });
 		    	// 슬라이드 닫기 버튼
 		    	$(".sidr-class-btn_close").click(function(){
 		    		$.sidr("close", "con_forec");
 		    	});

 				// js 소스 적용
 		    	if(add_url == "state"){
 		    		slide_state[0] = true;
        			slide_value[0] = data[0];
        			slide_value[1] = data[1];
        			
					 state_slide(data[0], data[1]);
 		    	}else if(add_url == "alarm"){
 		    		alarm_slide(data);
 		    	}else if(add_url == "sign"){
 		    		sign_slide(data);
 		    	}else if(add_url == "spot"){
 		    		slide_state[2] = true;
 		    		spot_slide();
 		    	}else if(add_url == "graph"){
 		    		slide_state[1] = true;
        			slide_value[0] = kind;
        			slide_value[1] = data;
 	 		    	graph_slide(kind, data);
 		    	}else if(add_url == "event"){
 		    		slide_state[3] = true;
 		    		event_slide();
 		    	}else if(add_url == "stillcut"){
 		    		slide_state[4] = true;
        			slide_value[0] = data;
 		    		stillcut_slide(data);
 		    	}else if(add_url == "farm"){
				   slide_state[5] = true;
				   slide_value[0] = data;
					farm_slide(data);
				}
            }else if(status == "error"){
                console.log("#con_forec load() error");
            }
        });
        $.sidr("open", "con_forec");
    }
    
    
