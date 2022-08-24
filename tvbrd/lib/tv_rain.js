var global_rain_area_code; // 이벤트가 등록된 강우 장비 
function rain(kind, arr_area_code){ // 강우 - 강우만 있는 장비
	// 객체 생성
	// console.log(arr_area_code);
	if(kind == 1){
		global_rain_area_code = arr_area_code;
		if(arr_area_code){
			$.each(arr_area_code, function(index, item){
				
				// 객체
				var tmp_name = "";  
				if(arr_rtu[item]['rtu_name'].length > 5){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 5)+"..";
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}
				if(!document.getElementById("rain_"+item)){
					var box_content= document.createElement("div"); // 오버레이 팝업설정 
					box_content.innerHTML+="<div id='rain_"+item+"' class='label rain'><ul>\n\
					<li class='label_top'>"+tmp_name+"</li><li class='label_dat'>&nbsp;</li></ul></div>\n\
					<div class='label_bot'><img src='img/label_bot.png'></div>";
				}
				if(!document.getElementById("rain_"+item+"_marker")){
					var marker_content= document.createElement("div"); // 오버레이 팝업설정 
					marker_content.innerHTML+="<div id='rain_"+item+"_marker' style='margin-top:-38px; margin-left: -10px;' class=''>\n\
					<img style='cursor:"+(map_control_type == 1 ? 'not-allowed' : 'pointer')+"; -webkit-user-drag: none;' src='img/icon_s_01.png'/></div>";
				}
				var circle_content = document.createElement("div"); // 오버레이 팝업설정 
				circle_content.innerHTML+="<div id='wave_"+item+"' class='chameleon'></div>";

				arr_rtu[item]['marker'] = new ol.Overlay({
					id:item,
					element:marker_content,
					// offset: [-10, -38],
					stopEvent : false,
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857'),
					dragging: true
				});

				arr_rtu[item]['overlay'] = new ol.Overlay({
						id:item,
						element:box_content,
						offset: [-55, -110],
						stopEvent : false,
						position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857')
				});

				circle[item] = new ol.Overlay({
					id:item,
					element: circle_content,
					stopEvent : false,
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857')
				});
				
				//////////////////////////////////////////////// 오버레이 생성 끝
				// map.addLayer(arr_rtu[item]['marker']);
				map.addOverlay(arr_rtu[item]['marker']);
				map.addOverlay(arr_rtu[item]['overlay']);
				map.addOverlay(circle[item]);

				$("#rain_"+item).parent().parent().addClass('overlay');
				$("#rain_"+item+"_marker").parent().parent().addClass('marker');
				$(".ol-overlaycontainer .overlay").css('z-index', "110");
				$(".ol-overlaycontainer .marker").css('z-index', "105");
				$("#wave_"+item).hide();

				arr_rtu[item]['overlay_on'] = false;
				arr_rtu[item]['state'] = true;
				arr_rtu[item]['line'] = true;
				
				var dragPan;
				

				map.getInteractions().forEach(function(interaction){
					if (interaction instanceof ol.interaction.DragPan) {
						dragPan = interaction;  
					}
				});

				var marker_el = document.getElementById('rain_'+item+'_marker');


				//줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_rtu[item]['overlay_on']){
						$("#rain_"+item).show();
						$("#rain_"+item).next().show();
    	    		}else{
						$("#rain_"+item).hide();
						$("#rain_"+item).next().hide();
    	    		}
				}
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 강우 버튼 선택
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
					$("#rain_"+item).hide();
					$("#rain_"+item).next().hide();
					$("#rain_"+item+"_marker").hide();
    			}
				
				if(map_kind == 2){
					$("#rain_"+item).css("height", "28px");
				}else{
					$("#rain_"+item).css("height", "");
				}

				// 이벤트
				$("#rain_"+item).on("click" , function(){
					if(map_kind == 1){
						slide_on("rain", item);
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});	

				$(document).on("mouseover", "#rain_"+item, function(e){
					$(".ol-overlaycontainer .overlay").css('z-index', "110");
					$(".ol-overlaycontainer .marker").css('z-index', "105");
					$("#rain_"+item).parent().parent().css('z-index', 120);
					$("#rain_"+item+"_marker").parent().parent().css('z-index', 111);
				});

				$(document).on("mouseout", "#rain_"+item, function(e){
					
				});



				marker_el.addEventListener('mousedown', function(evt) {
					if($(".lcs_cursor").parent().hasClass('lcs_on')){
						dragPan.setActive(false);
						arr_rtu[item]['marker'].set('dragging', true);
						move_state = true;
						start_point = arr_rtu[item]['marker'].getPosition();
					}
				});
				

				marker_el.addEventListener('mouseup', function(evt) {
					if (arr_rtu[item]['marker'].get('dragging') === true) {
						if($(".lcs_cursor").parent().hasClass('lcs_on')){
							dragPan.setActive(true);
							arr_rtu[item]['marker'].set('dragging', false);

							move_state = false;
							end_point = arr_rtu[item]['marker'].getPosition();

							var rtu_id = arr_rtu[item]['rtu_id'];
							var point = new Array( ol.proj.transform([end_point[0],end_point[1]], 'EPSG:900913', 'EPSG:4326') );

								$.ajax({
									type: "POST",
									url: "http://api.vworld.kr/req/address?service=address&request=getAddress&version=2.0&crs=epsg:4326&point="+point[0][0]+","+point[0][1]+"&format=json&type=both&zipcode=true&simple=false&key="+sessionStorage.getItem('API_KEY'),
									cache: false,
									dataType: "jsonp",
									success : function(data) {
										var emd;
										if(data.response.result){
											if(data.response.result[0].structure.level4A){
												if(data.response.result[0].text.indexOf(data.response.result[0].structure.level4A) != -1){
													emd = data.response.result[0].structure.level4A;
												}else{
													if(data.response.result[0].structure.level4L){
														emd = data.response.result[0].structure.level4L;
													}
												}
											}else{
												if(data.response.result[0].structure.level4L){
													emd = data.response.result[0].structure.level4L;
												}
											}
										

											emd = emd.replace(/\d/,"");

											var tmp_name = [data.response.result[0].structure.level2, emd];

											$.post( "controll/tutor.php", { "mode" : "rtu_move_check", "name" : tmp_name }, function(response){
												if(response.check){
													$.post( "controll/tutor.php", { "mode" : "rtu_move", "rtu_id" : rtu_id, "point" : [point[0][0],point[0][1]], "name" : tmp_name }, function(response3){
														arr_rtu[item]['overlay'].setPosition(end_point);
														arr_rtu[item]['emd_cd'] = arr_emdnm[emd];
													
														box_update();
													}, "json");
												}else{
													swal({
														title: "<div class='alpop_top_b'>장비 위치 이동 확인</div><div class='alpop_mes_b'>이동 위치가 시군 바깥 입니다. 이동시킬 겁니까?</div>",
														text: "확인 시 화면에 바로 적용 됩니다.",
														showCancelButton: true,
														confirmButtonColor: "#5b7fda",
														confirmButtonText: "확인",
														cancelButtonText: "취소",
														closeOnConfirm: false,
														html: true
													}, function(isConfirm){
														if(isConfirm){
															$.post( "controll/tutor.php", { "mode" : "rtu_move", "rtu_id" : rtu_id, "point" : [point[0][0],point[0][1]], "name" : tmp_name }, function(response2){
																arr_rtu[item]['overlay'].setPosition(end_point);
																arr_rtu[item]['emd_cd'] = arr_emdnm[emd];
															
																box_update();
																
																swal.close();
															}, "json");
														}else{
															arr_rtu[item]['marker'].setPosition(start_point);
															arr_rtu[item]['overlay'].setPosition(start_point);
														}
													});
												}
												move_state = false;
											}, "json");
											
										}else{
											console.log("Not Area");
											arr_rtu[item]['overlay'].setPosition(start_point);
											arr_rtu[item]['marker'].setPosition(start_point);
											circle[item].setPosition(start_point);
											swal({
												title : "좌표 저장 오류", 
												text : "\n \n해당 좌표는 행정코드가 존재하지 않습니다 \n 다른 좌표를 선택해주세요.",
												type : "warning",
												timer : 2000,
												showConfirmButton : false
											});
										}
								
									}
								});
						}
					}
				}); // 마커 드래그 이벤트 끝 

				map.on('pointermove', function(evt) {
					if (arr_rtu[item]['marker'].get('dragging') === true) {
						arr_rtu[item]['marker'].setPosition(evt.coordinate);
						arr_rtu[item]['overlay'].setPosition(evt.coordinate);
						circle[item].setPosition(evt.coordinate);
						$("#rain_"+item).css('margin-top','20px');
						$("#rain_"+item+"_marker").css('margin-top','-20px');
						$("#rain_"+item+"_marker").css('margin-left','-10px');
					}
				});

				marker_el.addEventListener('click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != "" && over_last != item){
								arr_rtu[over_last]['overlay_on'] = false;
								$("#rain_"+item).hide();
								$("#rain_"+item).next().hide();
							}
							if(over_sub_last != ""){
								arr_sub_rtu[over_sub_last]['overlay_on'] = false;
								$("#rain_"+item).hide();
								$("#rain_"+item).next().hide();
							}
							over_last = item;
							over_sub_last = "";

							slide_on("state", new Array(0, item));
						}
						if(arr_rtu[item]['overlay_on']){
							$("#rain_"+item).hide();
							$("#rain_"+item).next().hide();
							arr_rtu[item]['overlay_on'] = false;
						}else{
							$("#rain_"+item).show();
							$("#rain_"+item).next().show();
							arr_rtu[item]['overlay_on'] = true;
						}
					}
				});


				marker_el.addEventListener('mouseover', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$(".ol-overlaycontainer .overlay").css('z-index', "110");
							$(".ol-overlaycontainer .marker").css('z-index', "105");
							$("#rain_"+item).parent().parent().css('z-index', 120);
							$("#rain_"+item+"_marker").parent().parent().css('z-index', 111);
							$("#rain_"+item).show();
							$("#rain_"+item).next().show();
						}
					}
				});
				marker_el.addEventListener('mouseout', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$("#rain_"+item).hide();
							$("#rain_"+item).next().hide();
						}
					}
				});

			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1"){
			// 상황판이나 장비상태 선택, 강우 버튼 선택
			if(arr_area_code){
				$.each(arr_area_code, function(index, item){
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				
					$("#rain_"+item).show();
					$("#rain_"+item).next().show();
					$("#rain_"+item+"_marker").show();
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_rtu[item]['overlay_on']){
							$("#rain_"+item).show();
							$("#rain_"+item).next().show();
	    	    		}else{
							$("#rain_"+item).hide();
							$("#rain_"+item).next().hide();
	    	    		}
					}else{
		    		}
				}); // $.each(arr_area_code, function(index, item) end
				
				if(map_kind != 2){
					rain_ajax[0] = $.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : arr_area_code }, function(response){
						$.each(response.list, function(index, item){
							$("#rain_"+item.area_code+" .label_dat").text(item.day);
							var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
							arr_rtu[item.area_code]['rain'] = item.day;
						});
					}, "json");
				}
			}
		}else{
			if(arr_area_code){
				if(map_kind != 2){
					// 폴리곤 컬러 변경을 위해
					rain_ajax[0] = $.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : arr_area_code }, function(response){
						$.each(response.list, function(index, item){
							var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
							arr_rtu[item.area_code]['rain'] = item.day;
						});
					}, "json");
				}
				
				$.each(arr_area_code, function(index, item){
					if($("#wave_"+item).css('display') == 'none'){
						arr_rtu[item]['marker'].setVisible(false);
						$("#rain_"+item).hide();
						$("#rain_"+item).next().hide();
						$("#rain_"+item+"_marker").hide();
					}
				});
			}
		}
	}
} // rain() end

function rain_event(area_code,state,level) {
	if(state == 1){
		// circle[area_code].setVisible(true);
		if(level == 1){
			if(!$("#wave_"+area_code).hasClass('waves')){
				$("#rain_"+area_code).parent().parent().css('z-index','121');
				$("#rain_"+area_code).show();
				$("#rain_"+area_code).next().show();
				$("#rain_"+area_code+"_marker").show();
				$("#rain_"+area_code+"_marker").parent().parent().css('z-index','112');
				
				if($("#rain_"+area_code).css('display') == 'block'){
					$("#wave_"+area_code).removeClass('waves2');
					$("#wave_"+area_code).addClass('waves');
					$("#wave_"+area_code).show();
					$("#wave_"+area_code).css('z-index','101');
				}
			}
		}else if (level == 2){
			if(!$("#wave_"+area_code).hasClass('waves2')){
				$("#rain_"+area_code).parent().parent().css('z-index','122');
				$("#rain_"+area_code).show();
				$("#rain_"+area_code).next().show();
				$("#rain_"+area_code+"_marker").show();
				$("#rain_"+area_code+"_marker").parent().parent().css('z-index','113');

				if($("#rain_"+area_code).css('display') == 'block'){
					$("#wave_"+area_code).removeClass('waves');
					$("#wave_"+area_code).addClass('waves2');
					$("#wave_"+area_code).show();
					$("#wave_"+area_code).css('z-index','101');
				}
			}
		}

		$.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : global_rain_area_code }, function(response){
			$.each(response.list, function(index, item){
				// console.log($("#rain_"+item.area_code));
				// console.log(item.area_code);
				$("#rain_"+item.area_code+" .label_dat").text(item.day);
				var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
				arr_rtu[item.area_code]['rain'] = item.day;
			});
		}, "json");

	}else if(state == 0){

		if($("#rain_"+area_code).css('display') != 'none'){
			$("#wave_"+area_code).removeClass('waves');
			$("#wave_"+area_code).removeClass('waves2');
			$("#wave_"+area_code).hide();
			$("#rain_"+area_code).parent().parent().css('z-index', 110);
			$("#rain_"+area_code+"_marker").parent().parent().css('z-index', 105);
			// $("#rain_"+area_code).hide();
			// $("#rain_"+area_code).next().hide();
			// $("#rain_"+area_code+"_marker").hide();
		}
	}
}


