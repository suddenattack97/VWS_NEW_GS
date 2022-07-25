function alarm(kind, arr_area_code){ // 방송 - 방송만 있는 장비
	// 객체 생성
	var overlay_mode = "";

	if(kind == 1){
		if(arr_area_code){
			$.each(arr_area_code, function(index, item){
				//console.log(item);
				// 객체
				var tmp_name = ""; 

				if(arr_rtu[item]['rtu_name'].length > 5){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 5)+"..";
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}

				var box_content = '\n\
				<div id="alarm_'+item+'_process" class="process"></div>\n\
				<div id="alarm_'+item+'" class="label alert">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat">\n\
							&nbsp;<br>&nbsp;\n\
						</li>\n\
						<li class="label_dat_on dp0">\n\
							<button type="button" id="b_alarm_send" class="mR15 mL10">전송</button>\n\
							<button type="button" id="b_alarm_hist">현황</button>\n\
						</li>\n\
					</ul>\n\
					</div>';
					// <div class="label_bot"><img src="img/label_bot.png"></div>';

				arr_rtu[item]['marker'] = new naver.maps.Marker({
					position: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
					zIndex: 2,
					draggable: false
				});
				if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
					box_content += '<div class="label_bot"><img src="img/label_bot.png"></div>';
					arr_rtu[item]['overlay'] = new CustomOverlay({
						position: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
						zIndex: 1,
						content: box_content,
						xAnchor: 55
						// yAnchor: 111
					});
				}else{
					arr_rtu[item]['overlay'] = new CustomOverlay({
						position: new naver.maps.LatLng(arr_rtu[item]['overlay_x'], arr_rtu[item]['overlay_y']),
						zIndex: 1,
						content: box_content,
						xAnchor: 55
						// yAnchor: 111
					});
				}
				arr_rtu[item]['polyline'] = new naver.maps.Polyline({
					path: new Array( arr_rtu[item]['overlay'].getPosition(), arr_rtu[item]['marker'].getPosition() ),
					zIndex: 1,
				    strokeWeight: 5,
				    strokeColor: "#9a4cd3",
				    strokeOpacity: 1,
				    strokeStyle: 'dashed'
				});
				arr_rtu[item]['overlay_on'] = false;
				arr_rtu[item]['state'] = true;
				arr_rtu[item]['line'] = true;
				arr_rtu[item]['alert_state'] = false;
				arr_rtu[item]['alert_step'] = 0;
				arr_rtu[item]['alert_error'] = [];
				arr_rtu[item]['alert_error'][0] = false;
				arr_rtu[item]['alert_error'][1] = 0;
				arr_rtu[item]['node_id'] = [];
				
				var tmp_icon = "";
				if(map_kind == 1){
					tmp_icon = "img/icon_s_05.png";
				}else if(map_kind == 2){
					tmp_icon = "img/icon_s_05_g.png";
				}	
				arr_rtu[item]['marker'].setIcon(
					{
						url: tmp_icon,
						size: new naver.maps.Size(21, 36)
					}
				);	
				arr_rtu[item]['marker'].setMap(map);
				if(isMobile() == false){
					arr_rtu[item]['overlay'].setMap(map);
				}
				arr_rtu[item]['polyline'].setMap(map);
				arr_rtu[item]['polyline'].setVisible(false);
			
				// 줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_rtu[item]['overlay_on']){
						arr_rtu[item]['overlay'].setVisible(true);
						arr_rtu[item]['polyline'].setVisible(true);
    	    		}else{
    	    			arr_rtu[item]['overlay'].setVisible(false);
						arr_rtu[item]['polyline'].setVisible(false);
    	    		}
		    		if( Number(map_level) < Number(clus_level) ){
		    			arr_rtu[item]['overlay'].setVisible(false);
						arr_rtu[item]['polyline'].setVisible(false);
		    		}
				}
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("5", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 방송 버튼 선택
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
    			}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['overlay'].setYAnchor(76);
					}
						$("#alarm_"+item).css("height", "28px");
				}else{
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['overlay'].setYAnchor(111);
					}
						$("#alarm_"+item).css("height", "");
				}
				
// 이벤트
								$(document).on("click", "#alarm_"+item, function(){
									if(map_kind == 1){
										if($("input:checkbox[id='overlay_move']").is(":checked")){
											
				
											if(map.getZoom() == 11){
												zoom_lat = 0.04;
											}else if(map.getZoom() == 12){
												zoom_lat = 0.02;
											}else if(map.getZoom() == 13){
												zoom_lat = 0.01;
											}else if(map.getZoom() == 14){
												zoom_lat = 0.006;
											}else if(map.getZoom() == 15){
												zoom_lat = 0.0027;
											}else if(map.getZoom() == 16){
												zoom_lat = 0.0014;
											}else if(map.getZoom() == 17){
												zoom_lat = 0.0007;
											}else if(map.getZoom() == 18){
												zoom_lat = 0.0003;
											}else if(map.getZoom() == 19){
												zoom_lat = 0.00018;
											}else if(map.getZoom() == 20){
												zoom_lat = 0.000091;
											}else if(map.getZoom() == 21){
												zoom_lat = 0.000060;
											}
				
											if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
												swal({
													title : "\n \n해당 장비에 오버레이 좌표가 등록되어 있지 않습니다. \n \n <span style='color:red; font-weight:bold;'> 오버레이를 이동하면 좌표가 등록됩니다.</span>",
													type : "warning",
													timer : 2000,
													showConfirmButton : false,
													html: true
												});
											}
											map.setCursor('crosshair');
				
											$("#alarm_"+item).css('box-shadow','rgb(255 0 0 / 70%) 0px 0px 10px 3px');
											arr_rtu[item]['polyline'].setStyles('strokeColor','#FF0000');
											arr_rtu[item]['polyline'].setStyles('strokeOpacity','0.5');
											arr_rtu[item]['polyline'].setStyles('strokeWeight','10');
											arr_rtu[item]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
											arr_rtu[item]['marker'].setZIndex(3 + add_zindex);
											arr_rtu[item]['polyline'].setZIndex(1);
											add_zindex++;
											
											var overlay_start_point = arr_rtu[item]['overlay'].getPosition();
											var zoom_lat;
											naver.maps.Event.once(map, 'click', function(e){
												var temp_str = ""+e.pointerEvent.target;
												if((temp_str.substr(8,3) == "SVG" || map.getZoom() == 21) && $("input:checkbox[id='overlay_move']").is(":checked")){
												var point = new Array(e.coord.lat()+zoom_lat , e.coord.lng());
													swal({
														title: "<div class='alpop_top_b'>오버레이 이동 확인</div><div class='alpop_mes_b'>해당 위치로 <span style='color:red;'> "+arr_rtu[item]['rtu_name']+" </span> 장비를 이동시킬 겁니까?</div>",
														text: "확인 시 화면에 바로 적용 됩니다.",
														showCancelButton: true,
														confirmButtonColor: "#5b7fda",
														confirmButtonText: "확인",
														cancelButtonText: "취소",
														closeOnConfirm: false,
														html: true
													}, function(isConfirm){
														if(isConfirm){
															$.post( "controll/tutor.php", { "mode" : "overlay_move", "rtu_id" : item, "point" : point }, function(response2){
				
															
																	arr_rtu[item]['overlay'].setPosition(new naver.maps.LatLng(e.coord.lat()+zoom_lat, e.coord.lng()));
																	arr_rtu[item]['overlay'].setYAnchor(0);
																	arr_rtu[item]['polyline'].setVisible(true);
																	arr_rtu[item]['polyline'].setPath( new Array( arr_rtu[item]['marker'].getPosition(), new naver.maps.LatLng(e.coord.lat()+zoom_lat , e.coord.lng()) ) );
																	arr_rtu[item]['overlay_x'] = e.coord.lat()+zoom_lat;
																	arr_rtu[item]['overlay_y'] = e.coord.lng();
																	arr_rtu[item]['marker'].setAnimation();
				
																box_update();
																
																swal.close();
															}, "json");
				
															$("#alarm_"+item).css('box-shadow','');
															arr_rtu[item]['polyline'].setStyles('strokeColor','#9a4cd3');
															arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
															arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
															arr_rtu[item]['marker'].setAnimation();
															map.setCursor('grab');
														}else{
															arr_rtu[item]['overlay'].setPosition(overlay_start_point);
															$("#alarm_"+item).css('box-shadow','');
															arr_rtu[item]['polyline'].setStyles('strokeColor','#9a4cd3');
															arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
															arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
															arr_rtu[item]['marker'].setAnimation();
															map.setCursor('grab');
														}
													});
												}else{
													$("#alarm_"+item).css('box-shadow','');
													arr_rtu[item]['polyline'].setStyles('strokeColor','#9a4cd3');
													arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
													arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
													arr_rtu[item]['marker'].setAnimation();
													map.setCursor('grab');
												}
											});
											
										}else{
											slide_on("alarm", item);
										}
									}else if(map_kind == 2){
										slide_on("state", new Array(0, item));
									}
								});	
				$(document).on("click", "#alarm_"+item+" #b_alarm_send", function(e){
					e.stopPropagation();
					if(map_kind == 1){
						slide_on("alarm", arr_rtu[item]['rtu_id']);
					}
				});
				$(document).on("click", "#alarm_"+item+" #b_alarm_hist", function(e){
					e.stopPropagation();
					if(map_kind == 1){
						slide_on("stillcut", arr_rtu[item]['area_code']);
					}
				});
				$(document).on("mouseover", "#alarm_"+item, function(){
					if( $("#alarm_"+item+" .label_dat_on").hasClass("dp0") ){
						$("#alarm_"+item+" .label_dat").addClass("dp0");
						$("#alarm_"+item+" .label_dat_on").removeClass("dp0");
					}
					arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
				});
				$(document).on("mouseout", "#alarm_"+item, function(){
					$("#alarm_"+item+" .label_dat").removeClass("dp0");
					$("#alarm_"+item+" .label_dat_on").addClass("dp0");
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != "" && over_last != item){
								arr_rtu[over_last]['overlay_on'] = false;
								arr_rtu[over_last]['overlay'].setVisible(false);
							}
							if(over_sub_last != ""){
								arr_sub_rtu[over_sub_last]['overlay_on'] = false;
								arr_sub_rtu[over_sub_last]['overlay'].setVisible(false);
							}
							over_last = item;
							over_sub_last = "";

							slide_on("state", new Array(0, item));
						}
						if(arr_rtu[item]['overlay_on']){
							arr_rtu[item]['overlay'].setZIndex(1);
							arr_rtu[item]['overlay'].setVisible(false);
							arr_rtu[item]['overlay_on'] = false;
						}else{
							arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
							add_zindex++;
							arr_rtu[item]['overlay'].setVisible(true);
							arr_rtu[item]['overlay_on'] = true;
						}
					}
					// 방송 슬라이드 체크박스 선택
					if(arr_rtu[item]['node_id'].length != 0){
						//console.log( arr_rtu[item]['node_id'] );
						$.each(arr_rtu[item]['node_id'], function(i, v){
							$('#tree').jstree('select_node', v);
						});
					}
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'mouseover', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							arr_rtu[item]['overlay'].setZIndex(4 + add_zindex);
							add_zindex++;
							arr_rtu[item]['overlay'].setVisible(true);
						}
					}
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'mouseout', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							arr_rtu[item]['overlay'].setZIndex(1);
								arr_rtu[item]['overlay'].setVisible(false);
						}
					}
				});
				// 장비 좌표 이동 기능 - START
				var start_point = "";
				var end_point = "";
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'mousedown', function(){
					start_point = arr_rtu[item]['marker'].getPosition();
					move_state = true;
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'mouseup', function(){
					move_state = false;
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'dragend', function(){
					end_point = arr_rtu[item]['marker'].getPosition();

					var rtu_id = arr_rtu[item]['rtu_id'];
					var point = new Array( end_point.lat(), end_point.lng() );

					naver.maps.Service.reverseGeocode({
						location: end_point,
					}, function(status, response){
						if(status == naver.maps.Service.Status.OK){
							if(response.result.total == 0){
								var tmp_name = new Array("", "");
							}else{
								//console.log(response.result.items[0].addrdetail);
								var tmp_sig = response.result.items[0].addrdetail.sigugun;
								var tmp_emd = response.result.items[0].addrdetail.dongmyun;
								var tmp_name = new Array(tmp_sig, tmp_emd);
							}
							$.post( "controll/tutor.php", { "mode" : "rtu_move_check", "name" : tmp_name }, function(response){
								if(response.check){
									$.post( "controll/tutor.php", { "mode" : "rtu_move", "rtu_id" : rtu_id, "point" : point, "name" : tmp_name }, function(response2){
										if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
											arr_rtu[item]['overlay'].setPosition(end_point);
										}
										arr_rtu[item]['polyline'].setPath( new Array( arr_rtu[item]['overlay'].getPosition(), end_point ) );
										arr_rtu[item]['emd_cd'] = arr_emdnm[tmp_emd];
									
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
											$.post( "controll/tutor.php", { "mode" : "rtu_move", "rtu_id" : rtu_id, "point" : point, "name" : tmp_name }, function(response2){
												if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
													arr_rtu[item]['overlay'].setPosition(end_point);
												}
												arr_rtu[item]['polyline'].setPath( new Array( arr_rtu[item]['overlay'].getPosition(), end_point ) );
												arr_rtu[item]['emd_cd'] = arr_emdnm[tmp_emd];
											
												box_update();
												
												swal.close();
											}, "json");
										}else{
											arr_rtu[item]['marker'].setPosition(start_point);
										}
						    		});
								}
								move_state = false;
							}, "json");
						}
					});
				});
				// 장비 좌표 이동 기능 - END
			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("5", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, 방송 버튼 선택
			if(arr_area_code){
				var tmp_arr_rtu_id = [];
				$.each(arr_area_code, function(index, item){
					tmp_arr_rtu_id.push( arr_rtu[item]['rtu_id'] );
					
					//console.log( arr_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가

					var tmp_icon = "";
					if(map_kind == 1){
						// 방송 시 마커 gif 이미지로 변경
						if( arr_rtu[item]['alert_state'] && !arr_rtu[item]['alert_error'][0] ){
							if(arr_rtu[item]['alert_step'] >= 4){
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_05_a.gif"){
									tmp_icon = "img/icon_s_05_a.gif";
								}	
							}else{
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_05_b.gif"){
									tmp_icon = "img/icon_s_05_b.gif";
								}		
							}
						}else{
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_05.png"){
								tmp_icon = "img/icon_s_05.png";
							}
						}
						arr_rtu[item]['marker'].setIcon(
							{
								url: tmp_icon,
								size: new naver.maps.Size(21, 36)
							}
						);
					}else if(map_kind == 2){
						// 장비상태 이상 시 마커 gif 이미지로 변경
						if(arr_rtu[item]['state']){
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_05_g.png"){
								tmp_icon = "img/icon_s_05_g.png";
							}
						}else{
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_05_o.png"){
								tmp_icon = "img/icon_s_05_o.png";
							}
						}	
						arr_rtu[item]['marker'].setIcon(
							{
								url: tmp_icon,
								size: new naver.maps.Size(21, 36)
							}
						);
						// 장비 통신상태 이상 시 polyline 색깔 변경
						if(arr_rtu[item]['line']){
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#F10000" });
						}
					}
					arr_rtu[item]['marker'].setVisible(true);
					arr_rtu[item]['overlay'].setVisible(true);
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['polyline'].setVisible(false);
					}else{
						arr_rtu[item]['polyline'].setVisible(true);
					}
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_rtu[item]['overlay_on']){
							arr_rtu[item]['overlay'].setVisible(true);
							arr_rtu[item]['polyline'].setVisible(true);
	    	    		}else{
	    	    			arr_rtu[item]['overlay'].setVisible(false);
							arr_rtu[item]['polyline'].setVisible(false);
	    	    		}
			    		if( Number(map_level) < Number(clus_level) ){
			    			arr_rtu[item]['overlay'].setVisible(false);
							arr_rtu[item]['polyline'].setVisible(false);
			    		}
					}else{
						arr_rtu[item]['overlay'].setZIndex(add_zindex);
		    		}
					
					if(map_kind == 2){
						if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
							arr_rtu[item]['overlay'].setYAnchor(76);
						}
						$("#alarm_"+item).css("height", "28px");
					}else{
						//arr_rtu[item]['overlay'].setYAnchor(111);
						if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						}
						$("#alarm_"+item).css("height", "");
					}
				}); // $.each(arr_area_code, function(index, item) end
				
				if(map_kind != 2){
					$.post( "controll/alarm.php", { "mode" : "alarm", "arr_area_code" : arr_area_code, "arr_rtu_id" : tmp_arr_rtu_id }, function(response){
						$.each(response.list, function(index, item){
							if(arr_rtu[item.area_code]['alert_state']){
								var tmp_process = '';
								for(var i = 0; i <= 5; i++){
									if(i <= arr_rtu[item.area_code]['alert_step']){
										tmp_process += '<img src="img/ok.png">';
									}else{
										tmp_process += '<img src="img/ok_n.png">';
									}
								}
								$("#alarm_"+item.area_code+"_process").html(tmp_process);
								
								if(arr_rtu[item.area_code]['alert_error'][0]){
									$("#alarm_"+item.area_code+" .label_dat").html('방송 에러<br/>'+arr_rtu[item.area_code]['alert_error'][1]);
								}else{
									if(arr_rtu[item.area_code]['alert_step'] == 5){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/d1.gif"><br/>방송 완료');
									}else if(arr_rtu[item.area_code]['alert_step'] == 4){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/d1.gif"><br/>방송중(경보)');
									}else if(arr_rtu[item.area_code]['alert_step'] == 3){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/spinner.gif"><br/>정보 전송중');
									}else if(arr_rtu[item.area_code]['alert_step'] == 2){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/spinner.gif"><br/>장비 접속중');
									}else if(arr_rtu[item.area_code]['alert_step'] == 1){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/spinner.gif"><br/>SMS 전송중');
									}else if(arr_rtu[item.area_code]['alert_step'] == 0){
										$("#alarm_"+item.area_code+" .label_dat").html('<img src="img/spinner.gif"><br/>전송 대기중');
									}
								}
									// arr_rtu[item.area_code]['overlay'].setYAnchor(127);
							}else{
								$("#alarm_"+item.area_code+"_process").empty();
	
								if(item.date == "-"){
									$("#alarm_"+item.area_code+" .label_dat").html("&nbsp;<br>&nbsp;");
								}else{
									if(item.call == 7){ // VHF 방송 종료 시
										var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">VHF</span>';
										$("#alarm_"+item.area_code+" .dat_right").html(tmp_str);
									}else{
										var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">CDMA</span>';
										$("#alarm_"+item.area_code+" .dat_right").html(tmp_str);
									}
									
									if(item.call == 7){ // VHF 방송 종료 시
										var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">VHF</span>';
										$("#alarm_"+item.area_code+" .label_dat").html(tmp_str);
									}else{
										var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">CDMA</span>';
										$("#alarm_"+item.area_code+" .label_dat").html(tmp_str);
									}
								}
									// arr_rtu[item.area_code]['overlay'].setYAnchor(111);
								// arr_rtu[item.area_code]['overlay'].setYAnchor(111); // 업데이트 문에서 Yanchor 조절되는 부분
							}
						});
					}, "json");
				}
			}
		}else{
			if(arr_area_code){
				$.each(arr_area_code, function(index, item){
					arr_rtu[item]['marker'].setVisible(false);
					arr_rtu[item]['overlay'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
				});
			}
		}
	}
	
} // alarm() end

function alarm_slide(get_rtu_id){
	$("#sidr-id-alarm_detail").attr("href", "../divas/monitoring/main.php?url=abr_common.php&num=2");
	
    var tmp_rtu_name = arr_rtu[ arr_id[get_rtu_id] ]['rtu_name'];
    tmp_rtu_name = (tmp_rtu_name.length > 10) ? tmp_rtu_name.substring(0, 10)+".." : tmp_rtu_name;
    $("#sidr-id-title_name").text(tmp_rtu_name);
	
	$.post( "controll/alarm.php", { "mode" : "alarm_slide" }, function(response) {
		//console.log(response);

		// 방송 관련 마커 클릭시 체크박스 선택을 위한 node_id 배열 초기화
		$.each(arr_data['aws']['area_code'], function(index, item){
			arr_rtu[item]['node_id'] = [];
		});
		$.each(arr_data['alarm']['area_code'], function(index, item){
			arr_rtu[item]['node_id'] = [];
		});
		$.each(arr_data['mix']['area_code'], function(index, item){
			arr_rtu[item]['node_id'] = [];
		});
		
        var list = response.data;
        var list2 = response.data2;
        var list3 = response.data3;
        var sel = response.sel;
        var emer = response.emer;

        var txt = '';
        txt += '<div id="tree"></div>';
        $("#sidr-id-alarm").html(txt);

        var tree_data = new Array();
        if(list.GROUP_ID){
        	for(var i = 0; i < list.GROUP_ID.length; i++){
        		if(list.RTU_ID[i] == '0'){
	        		var is_match = 0;
	 
	        		for(var g = 0; g < list2.RTU_CNT.length; g++){
	        			if(list2.GROUP_ID[g] == list.GROUP_ID[i]){
	        				var tmp_attr = {
			        			"group_id" : list.GROUP_ID[i],
			        			"rtu_id" : list.RTU_ID[i]
	        				}
	        				var tmp_data = {
	        					"id" : "tree_"+list.GROUP_ID[i], 
			        			"parent" : "#",
			        			//"text" : list.GROUP_NAME[i]+"("+list2.RTU_CNT[g]+"개소)",
			        			"text" : list.GROUP_NAME[i], //잘려서 개수 표시 제거
			        			//"icon" : "//jstree.com/tree-icon.png",
			        			//"state" : { "opened" : true },
			        			"attr" : tmp_attr
	        				}
	        				tree_data.push(tmp_data);
	        				
	        				var is_match = 1;
	        				break;
	        			}
	        		}
	    			if(is_match == 0){
	       				var tmp_attr = {
			        		"group_id" : list.GROUP_ID[i],
			        		"rtu_id" : list.RTU_ID[i]
	       				}
	       				var tmp_data = {
	       					"id" : "tree_"+list.GROUP_ID[i], 
	       					"parent" : "#",
	       					"text" : list.GROUP_NAME[i],
							//"icon" : "//jstree.com/tree-icon.png",
	       					//"state" : { "opened" : true },
	       					"attr" : tmp_attr
						}
						tree_data.push(tmp_data);
	    			}
        		}else{ // if(list.RTU_ID[i] == '0') end
        			var tmp_select = false;
        			if(get_rtu_id == list.RTU_ID[i]) tmp_select = true;
           		
        			var tmp_attr = {
	        			"group_id" : list.GROUP_ID[i],
	        			"rtu_id" : list.RTU_ID[i],
	        			"area_code" : list.AREA_CODE[i]
        			}
        			var tmp_data = {
   						"id" : "tree_sub_"+i, 
   						"parent" : "tree_"+list.GROUP_ID[i],
   						//"text" : list.RTU_NAME[i],
   						"text" : (list.RTU_NAME[i].length > 10) ? list.RTU_NAME[i].substr(0, 10)+".." : list.RTU_NAME[i],
							//"icon" : "//jstree.com/tree-icon.png",
   						"state" : { "selected" : tmp_select },
   						"attr" : tmp_attr
					}
        			tree_data.push(tmp_data);
        			
        			// 방송 관련 마커 클릭시 체크박스 선택을 위한 node_id 배열 저장
        			arr_rtu[ list.AREA_CODE[i] ]['node_id'].push("tree_sub_"+i);
        		}
        	} // for end
        }
       
        if( $('#tree').length == 0 ) return false;
       
        if(ie_version == "N/A"){ // ie가 아닐 경우
			$('#tree').jstree({
				'plugins':["wholerow", "checkbox"], 
				'core' : {
				    'data' : tree_data
				}
			});
        }else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
			$('#tree').jstree({
				'plugins':["checkbox"], 
				'core' : {
				    'data' : tree_data
				}
			});
        }
		$('#tree').on("loaded.jstree", function(){
			$("#sidr-id-alarm li").addClass("p0");
		});
		$('#tree').on("select_node.jstree", function(e, data){
			// 동일한 장비 모두 체크
			if( data.node.id.indexOf('sub') != "-1" ){
				var tmp_area_code = data.node.original.attr.area_code;
				if( Number(map_level) < Number(over_level) ){
					// 오버레이 오픈
					arr_rtu[tmp_area_code]['overlay_on'] = true;
					arr_rtu[tmp_area_code]['overlay'].setZIndex(4 + add_zindex);
					add_zindex++;
					arr_rtu[tmp_area_code]['overlay'].setVisible(true);	
				}
				$.each(arr_rtu[tmp_area_code]['node_id'], function(i, v){
					$('#tree').jstree('select_node', v);
				});
				
			// 그룹 단위 동일한 장비 모두 체크
			}else{
				$.each(data.node.children, function(index, item){
					var tmp_area_code = $('#tree').jstree('get_node', item).original.attr.area_code;
					if( Number(map_level) < Number(over_level) ){
						// 오버레이 오픈
						arr_rtu[tmp_area_code]['overlay_on'] = true;
						arr_rtu[tmp_area_code]['overlay'].setZIndex(4 + add_zindex);
						add_zindex++;
						arr_rtu[tmp_area_code]['overlay'].setVisible(true);
					}
					$.each(arr_rtu[tmp_area_code]['node_id'], function(i, v){
						$('#tree').jstree('select_node', v);
					});
				});
			}
		});
		$('#tree').on("deselect_node.jstree", function(e, data){
			// 동일한 장비 모두 체크 해제
			if( data.node.id.indexOf('sub') != "-1" ){
				var tmp_area_code = data.node.original.attr.area_code;
				if( Number(map_level) < Number(over_level) ){
					// 오버레이 닫기
					arr_rtu[tmp_area_code]['overlay_on'] = false;
					arr_rtu[tmp_area_code]['overlay'].setZIndex(1);
					arr_rtu[tmp_area_code]['overlay'].setVisible(false);
				}
				$.each(arr_rtu[tmp_area_code]['node_id'], function(i, v){
					$('#tree').jstree('deselect_node', v);
				});
				
			// 그룹 단위 동일한 장비 모두 체크 해제
			}else{
				$.each(data.node.children, function(index, item){
					var tmp_area_code = $('#tree').jstree('get_node', item).original.attr.area_code;
					if( Number(map_level) < Number(over_level) ){
						// 오버레이 닫기
						arr_rtu[tmp_area_code]['overlay_on'] = false;
						arr_rtu[tmp_area_code]['overlay'].setZIndex(1);
						arr_rtu[tmp_area_code]['overlay'].setVisible(false);
					}
					$.each(arr_rtu[tmp_area_code]['node_id'], function(i, v){
						$('#tree').jstree('deselect_node', v);
					});
				});
			}
		});
		$('#tree').on("changed.jstree", function(e, data){
			$("#sidr-id-STR_RTU_ID").val("");
			var check_cnt = 0;
			
			var i, j, r = [];
		    for(i = 0, j = data.selected.length; i < j; i++) {
		    	var obj = data.instance.get_node(data.selected[i]);
		    	var id = obj.id;
		    	var text = obj.text;
		    	var group_id = obj.original.attr.group_id;
		    	var rtu_id = obj.original.attr.rtu_id;
		    	
		    	var out = text+"/"+group_id+"/"+rtu_id;
		    	//console.log(out);
		    	
		    	if(rtu_id != 0){
			    	var STR_RTU_ID = $("#sidr-id-STR_RTU_ID").val();
			    	if(STR_RTU_ID == ""){
			    		$("#sidr-id-STR_RTU_ID").val(rtu_id);
			    	}else{
			    		$("#sidr-id-STR_RTU_ID").val(STR_RTU_ID + "-" + rtu_id);
			    	}
		    	}
		    }
		    var tmp_arr_split = $("#sidr-id-STR_RTU_ID").val().split("-");
		    var tmp_arr_new = [];
		    $.each(tmp_arr_split, function(i, el){
		    	if($.inArray(el, tmp_arr_new) === -1 && el !== ""){
		    		tmp_arr_new.push(el);
		    	}
		    });
		    check_cnt = tmp_arr_new.length;
		    tmp_arr_new = tmp_arr_new.join("-");
		    //console.log(check_cnt);
		    $("#sidr-id-STR_RTU_ID").val(tmp_arr_new);
		    
		    $("#sidr-id-RTU_CNT").val(check_cnt);
		    $("#sidr-id-rtu_cnt_text").text(check_cnt);
		}).jstree();
		
		
		var txt = '';
        txt += '<table id="alarm_script" width="178" border="0" cellpadding="0" cellspacing="0">';
        for(var i = 0; i < list3.SCRIPT_NO.length; i++){ 
       	var add_id = list3.SCRIPT_NO[i];
       	var tmp_text = (list3.SCRIPT_TITLE[i].length > 10) ? list3.SCRIPT_TITLE[i].substring(0, 10)+".." : list3.SCRIPT_TITLE[i];
       	txt += '<tr id="listTr_'+add_id+'"\n\
       			data-no="'+add_id+'"\n\
       			onMouseOver="this.style.backgroundColor=\'#BFD2EB\'"\n\
       			onMouseOut="this.style.backgroundColor=\'\'"\n\
       			style="cursor:hand; padding:2px">';
       	txt += '<td id="listTd_SCRIPT_UNIT_NAME" width="30">'+list3.SCRIPT_UNIT_NAME[i]+'</td>';
       	if( jQuery.inArray(list3.SCRIPT_NO[i], emer.SCRIPT_NO) != "-1" ){
       	txt += '<td id="star_img"><img src="img/star.png"></td>';
       	}else{
       	txt += '<td></td>';
       	}
       	txt += '<td id="listTd_SCRIPT_TITLE_text">'+tmp_text+'</td>';
       	txt += '<!-- ----------------------------------------- -->';
       	txt += '<td id="listTd_SCRIPT_TITLE" style="display:none">'+list3.SCRIPT_TITLE[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_NO" style="display:none">'+list3.SCRIPT_NO[i]+'</td>';
       	txt += '<td id="listTd_SECTION_NAME" style="display:none">'+list3.SECTION_NAME[i]+'</td>';
       	txt += '<td id="listTd_NUM" style="display:none">'+i+'</td>';
       	txt += '<td id="listTd_USER_ID" style="display:none">'+list3.USER_ID[i]+'</td>';
       	txt += '<td id="listTd_CHIME_START_NO" style="display:none">'+list3.CHIME_START_NO[i]+'</td>';
       	txt += '<td id="listTd_CHIME_START_CNT" style="display:none">'+list3.CHIME_START_CNT[i]+'</td>';
       	txt += '<td id="listTd_CHIME_END_NO" style="display:none">'+list3.CHIME_END_NO[i]+'</td>';
       	txt += '<td id="listTd_CHIME_END_CNT" style="display:none">'+list3.CHIME_END_CNT[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_BODY" style="display:none">'+list3.SCRIPT_BODY[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_BODY_CNT" style="display:none">'+list3.SCRIPT_BODY_CNT[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_RECORD_FILE" style="display:none">'+list3.SCRIPT_RECORD_FILE[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_TIMESTAMP" style="display:none">'+list3.SCRIPT_TIMESTAMP[i]+'</td>';
       	txt += '<td id="listTd_TRANS_VOLUME" style="display:none">'+list3.TRANS_VOLUME[i]+'</td>';
       	txt += '<td id="listTd_SECTION_NO" style="display:none">'+list3.SECTION_NO[i]+'</td>';
       	txt += '<td id="listTd_SCRIPT_UNIT" style="display:none">'+list3.SCRIPT_UNIT[i]+'</td>';
       	txt += '</tr>';
        } // for end
        txt += '</table>';
        $("#sidr-id-alarm2").html(txt);
       
        // 테이블 드래그 앤 드롭
        $("#alarm_script").tableDnD({
        	onDrop: function(table, row){ // 드래그 종료
	   			if( $("#sidr-id-formselect option:selected").val() != 0 ){
	   				swal("체크", "순서 변경은 방송구분이 전체일 때만 가능합니다.", "warning");
	   				alarm_slide(get_rtu_id);
	   				return false;
	   			}
	   			var arr_sort = new Object();
	       		$.each($("#alarm_script tr"), function(index, item){
	       			var tmp_id = "#alarm_script #"+item.id;
	       			arr_sort[index] = $(tmp_id).data("no");
	       		});
				$.post("controll/alarm.php", { "mode" : "alarm_script_sort", "arr_sort" : arr_sort }, function(response){
					alarm_slide(get_rtu_id);
				}, "json");
        	}
        });
       
        var txt = '';
		txt += '<option value="0">방송종류</option>';
		if(sel.ID){
			for(var i = 0; i < sel.ID.length; i++) { 
	           	if(sel.STATE[i] == 0){
	           		txt += '<option value="'+sel.ID[i]+'" data-no="'+sel.SCRIPT_NO[i]+'">'+sel.NAME[i]+'</option>';
	           	}
			}
		}
        $("#sidr-id-star_sel").html(txt);
       
        var txt = '';
        txt += '<option value="0">방송구분(전체)</option>';
        for(var i = 0; i < sel.SECTION_NO.length; i++) { 
        	txt += '<option value="'+sel.SECTION_NO[i]+'">'+sel.SECTION_NAME[i]+'</option>';
        }
        $("#sidr-id-formselect").html(txt);

        var txt = '';
        txt += '<option value="">시작음선택</option>';
        for (var i = 0; i < sel.CHIME_NO.length; i++) { 
        	txt += '<option value="'+sel.CHIME_NO[i]+'">'+sel.CHIME_NAME[i]+'</option>';
        }
        $("#sidr-id-CHIME_START_NO").html(txt);

        var txt = '';
        txt += '<option value="">시작음선택</option>';
        for (var i = 0; i < sel.CHIME_NO.length; i++) { 
        	txt += '<option value="'+sel.CHIME_NO[i]+'">'+sel.CHIME_NAME[i]+'</option>';
        }
        $("#sidr-id-CHIME_END_NO").html(txt);
		
	}, "json");
    
	$("#sidr-id-alarm").attr("style", "padding:8px 0 0 0; height: 355px; overflow-y: scroll; overflow-x: hidden;");
	$("#sidr-id-alarm2").attr("style", "height: 316px; overflow-y: scroll; overflow-x: hidden;");
	
	var select = $( "#sidr-id-TRANS_VOLUME" );
	if( $("#slider").length == 0 ){
		var slider = $( "<div id='slider'></div>" ).insertAfter( select ).slider({
			min: 1,
			max: 16,
			range: "min",
			value: select[ 0 ].selectedIndex + 1,
			slide: function( event, ui ) {
				select[ 0 ].selectedIndex = ui.value - 1;
			}
		});
	}
}

$(document).on("click","#sidr-id-all_sel",function(){
	var now_sel = $('#tree').jstree('get_selected');
	var max_cnt = 0;
	$.each($('#tree').jstree('get_json'), function(index, item){
		max_cnt += Number(item['children'].length + 1);
	});
	//console.log(max_cnt, now_sel.length);
	
	if(now_sel.length == max_cnt){
		$('#tree').jstree('deselect_all');
	}else{
		$('#tree').jstree('select_all');
	}
}); 

$(document).on("change","#sidr-id-formselect",function(){
	$.each($("#sidr-id-alarm2 tr #listTd_SECTION_NO"), function(index, item){
		if( $("#sidr-id-formselect").val() == 0 ){
			$(this).closest("tr").show();
		}else if( $("#sidr-id-formselect").val() != $(this).text() ){
			$(this).closest("tr").hide();
		}else if( $("#sidr-id-formselect").val() == $(this).text() ){
			$(this).closest("tr").show();
		}
	});
});

$(document).on("click","#sidr-id-alarm2 tr",function(e){
	$("#sidr-id-alarm2 tr").attr("class", "");
	$(this).attr("class", "sidr-class-ybg");
	
	var id = "#sidr-id-alarm2 #"+this.id;
	// broadcast_script 테이블에 있는 user_id는 방송 보내는 사람이 아님
	//var USER_ID = $(id+" #listTd_USER_ID").text();
	var USER_ID = $.cookie('keyUserID').split("").join("");
	var SCRIPT_UNIT = $(id+" #listTd_SCRIPT_UNIT").text();
	var SCRIPT_UNIT_STR = "";
	if(SCRIPT_UNIT == "T"){
		SCRIPT_UNIT_STR = "문자음성변환방송";
	}else if(SCRIPT_UNIT == "R"){
		SCRIPT_UNIT_STR = "음성녹음방송";
	}else{ // M
		SCRIPT_UNIT_STR = "장비저장방송";
	}
	var SECTION_NO = $(id+" #listTd_SECTION_NO").text();
	var SCRIPT_TITLE = $(id+" #listTd_SCRIPT_TITLE").text();
	var CHIME_START_NO = $(id+" #listTd_CHIME_START_NO").text();
	var CHIME_START_CNT = $(id+" #listTd_CHIME_START_CNT").text();
	var CHIME_END_NO = $(id+" #listTd_CHIME_END_NO").text();
	var CHIME_END_CNT = $(id+" #listTd_CHIME_END_CNT").text();
	var SCRIPT_BODY = $(id+" #listTd_SCRIPT_BODY").text();
	var SCRIPT_BODY_CNT = $(id+" #listTd_SCRIPT_BODY_CNT").text();
	var SCRIPT_RECORD_FILE = $(id+" #listTd_SCRIPT_RECORD_FILE").text();
	var SCRIPT_TIMESTAMP = $(id+" #listTd_SCRIPT_TIMESTAMP").text();
	var TRANS_VOLUME = $(id+" #listTd_TRANS_VOLUME").text();
	$("#slider").slider("value", TRANS_VOLUME);
	var SCRIPT_NO = $(id+" #listTd_SCRIPT_NO").text();

	$("#sidr-id-USER_ID").val(USER_ID);
	$("#sidr-id-SCRIPT_UNIT").val(SCRIPT_UNIT);
	$("#sidr-id-SCRIPT_UNIT_STRING").text(SCRIPT_UNIT_STR);
	$("#sidr-id-SECTION_NO").val(SECTION_NO);
	$("#sidr-id-SCRIPT_TITLE").val(SCRIPT_TITLE);
	$("#sidr-id-CHIME_START_NO").val(CHIME_START_NO);
	$("#sidr-id-CHIME_START_CNT").val(CHIME_START_CNT);
	$("#sidr-id-CHIME_END_NO").val(CHIME_END_NO);
	$("#sidr-id-CHIME_END_CNT").val(CHIME_END_CNT);
	$("#sidr-id-SCRIPT_BODY").val(SCRIPT_BODY);
	$("#sidr-id-SCRIPT_BODY_CNT").val(SCRIPT_BODY_CNT);
	$("#sidr-id-SCRIPT_RECORD_FILE").val(SCRIPT_RECORD_FILE);
	$("#sidr-id-SCRIPT_TIMESTAMP").val(SCRIPT_TIMESTAMP);
	$("#sidr-id-TRANS_VOLUME").val(TRANS_VOLUME);
	$("#sidr-id-SCRIPT_NO").val(SCRIPT_NO);
}); 

$(document).on("change","#sidr-id-TRANS_VOLUME",function(){
	$("#slider").slider("value", this.value);
});

$(document).on("click","#sidr-id-btn_broadcast",function(){
	var check = /[\r|\n]/g;
	var txt = $("#sidr-id-SCRIPT_BODY").val().replace(check, "");
	$("#sidr-id-SCRIPT_BODY").val(txt);
	
	if( $("#sidr-id-RTU_CNT").val() == '0' || !$("#sidr-id-RTU_CNT").val() ){
       swal("체크", "방송 지역을 선택해 주세요.", "warning");
   }else if( !$("#sidr-id-SCRIPT_TITLE").val() ){
       swal("체크", "방송 제목을 입력해 주세요.", "warning");
       $("#sidr-id-SCRIPT_TITLE").focus();
   }else if( !$("#sidr-id-CHIME_START_NO").val() ){
       swal("체크", "시작 효과음을 선택해 주세요.", "warning");
       $("#sidr-id-CHIME_START_NO").focus();	
   }else if( !$("#sidr-id-CHIME_END_NO").val() ){
       swal("체크", "종료 효과음을 선택해 주세요.", "warning");
       $("#sidr-id-CHIME_END_NO").focus();
	}else if( $("#sidr-id-SCRIPT_UNIT").val() == 'T' && !$("#sidr-id-SCRIPT_BODY").val() ){
       swal("체크", "방송 내용을 입력해 주세요.", "warning");
		$("#sidr-id-SCRIPT_BODY").focus();
	}else if( $("#sidr-id-SCRIPT_UNIT").val() != 'T' && !$("#sidr-id-SCRIPT_NO").val() ){
       swal("체크", "방송 문안를 선택해 주세요.", "warning");
	}else{
		var data = $("#sidr-id-alarm_frm").serialize();
		$.ajax({
		    type: "POST",
		    url: "controll/alarm.php",
		    data: data,
		    //data: { "mode" : "alarm_in", "data" : data },
		    cache: false, 
		    dataType: "json",
		    success : function(response) {
		    	if(response.result.broadcast && response.result.rtu){
		    		swal("성공", "방송 전송이 완료 됐습니다.", "success");
		    	}else{
		    		swal("체크", "방송 전송중 오류가 발생 했습니다.", "warning");
		    	}
		    },
		    error : function(xhr, status, error) {
		        console.log("alarm_error");
		    }
		}); // ajax end
	}
}); // $("#sidr-id-btn_broadcast").click(function() end

$(document).on("click","#sidr-id-btn_alert_test",function(){
	var tmp_url = "./func/audioGenerator/toTTS2.php";
	if( $("#sidr-id-SCRIPT_TIMESTAMP").val() ){
		$("#sidr-id-alarm_frm").attr("action", tmp_url);
		$("#sidr-id-alarm_frm").attr("target", "alert_iframe");
		$("#sidr-id-alarm_frm").submit();
	}
});

// 긴급방송 등록 및 삭제
$(document).on("click","#sidr-id-btn_emer_ins",function(){
	var SCRIPT_NO = $("#sidr-id-SCRIPT_NO").val();
	if(SCRIPT_NO == ""){
		swal("실패", "방송문구를 먼저 선택해 주세요.", "warning");
		return false;
	}
	swal({
		title: "<div class='alpop_top_b'>긴급방송 버튼 등록</div><div class='alpop_mes'>등록하실 긴급방송 버튼의 이름을<br>입력해 주세요.</div>",
		text: "확인 시 화면에 바로 적용 됩니다.",
		type: 'input',
		showCancelButton: true,
		confirmButtonColor: "#5b7fda",
		confirmButtonText: "확인",
		cancelButtonText: "취소",
		closeOnConfirm: false,
		html: true,
		inputPlaceholder: "버튼 이름 입력"
	}, function(inputValue){
		
		if(inputValue === ""){
			swal.showInputError("버튼 이름를 입력해 주세요.");
			return false;
		}else if(inputValue == false){
			// 취소 시 아무것도 안 함
		}else{
			
			//중복 submit 방지
			if(doubleSubmitCheck()) return;
			$.post("controll/alarm.php", { "mode" : "alarm_emer_insert", 
										   "text" : inputValue,
										   "no" : SCRIPT_NO }, function(response){ 
				if(response.result == 1){
					swal("성공", "긴급방송 버튼 등록이 완료 됐습니다.", "success");
					alarm_slide();
					tutor_reset();
				}else if(response.result == 2){
					swal("실패", "긴급방송 버튼 등록 중 오류가 발생 했습니다.", "warning");
				}else if(response.result == 3){
					swal("실패", "해당 방송문구는 이미 사용중 입니다.", "warning");
				}
			}, "json");
		}
	});
});
	
	
