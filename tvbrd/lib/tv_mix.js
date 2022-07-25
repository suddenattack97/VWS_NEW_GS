function mix(kind, arr_area_code){ // 믹스 - 센서가 2개 이상 있는 장비
	// 객체 생성
	if(kind == 1){
		if(arr_area_code){
			$.each(arr_area_code, function(index, item){
				//console.log( arr_rtu[item]['sensor_cnt'], arr_rtu[item]['sensor_type'], arr_rtu[item]['rtu_type'] );	
				//console.log( arr_rtu[item]['sensor_kind'] );
				
				// 객체
				var tmp_name = "";  
				if(arr_rtu[item]['rtu_name'].length > 5){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 5)+"..";
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}
				var box_content = '\n\
				<div id="mix_'+item+'_process" class="process"></div>\n\
				<div id="mix_'+item+'" class="label mix">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>';
				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					var tmp_class = ""; 
					if(arr_rtu[item]['sensor_kind'][i] == "alarm"){
						if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
							tmp_class = "motion";
						}else{
							tmp_class = "alert";
						}
					}else if(arr_rtu[item]['sensor_kind'][i] == "flow"){
						tmp_class = "water";
					}else{
						tmp_class = arr_rtu[item]['sensor_kind'][i];
					}
					var bb = (i == (arr_rtu[item]['sensor_cnt'] - 1)) ? "" : "bb";
					box_content += '\n\
						<li id="'+arr_rtu[item]['sensor_kind'][i]+'_'+item+'" class="'+tmp_class+' '+bb+'">\n\
							<span class="dat_left">&nbsp;</span>\n\
							<span class="dat_right">&nbsp;</span>\n\
						</li>';
					if(arr_rtu[item]['sensor_kind'][i] == "alarm"){
						box_content += '\n\
						<li class="label_dat_on dp0">\n\
							<button type="button" id="b_alarm_send" class="mR15 mL10">전송</button>\n\
							<button type="button" id="b_alarm_hist">현황</button>\n\
						</li>';
					}
				}
				box_content += '\n\
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
				    strokeColor: "#464646",
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
					if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
						tmp_icon = "img/icon_s_13.png";
					}else{
						tmp_icon = "img/icon_s_09.png";
					}
				}else if(map_kind == 2){
					if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
						tmp_icon = "img/icon_s_13_g.png";
					}else{
						tmp_icon = "img/icon_s_09_g.png";
					}
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
				
				var tmp_cnt = 0;
				var tmp_last = "";
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("5", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 방송 버튼 선택
					//$("#alarm_"+item).show(); 
					if( $("#alarm_"+item).length != 0 ){
						tmp_cnt++;
						tmp_last = "alarm";
					}
    			}else{
					$("#alarm_"+item).hide();
    			}
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 강우 버튼 선택
					//$("#rain_"+item).show(); 
					if( $("#rain_"+item).length != 0 ){
						tmp_cnt++;
						tmp_last = "rain";
					}
    			}else{
					$("#rain_"+item).hide();
    			}
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 수위 버튼 선택
					//$("#flow_"+item).show(); 
					if( $("#flow_"+item).length != 0 ){
						tmp_cnt++;
						tmp_last = "flow";
					}
    			}else{
					$("#flow_"+item).hide();
    			}
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 적설 버튼 선택
					//$("#snow_"+item).show(); 
					if( $("#snow_"+item).length != 0 ){
						tmp_cnt++;
						tmp_last = "snow";
					}
    			}else{
					$("#snow_"+item).hide();
    			}
				
				if(tmp_cnt == 1){
					$("#"+tmp_last+"_"+item).removeClass("bb");
				}

				var tmp_yAnchor = 0;
				if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
					if(tmp_cnt == 1) tmp_yAnchor = 111;
					else if(tmp_cnt == 2) tmp_yAnchor = 146;
					else if(tmp_cnt == 3) tmp_yAnchor = 181;
					else if(tmp_cnt == 4) tmp_yAnchor = 216;
					else if(tmp_cnt == 5) tmp_yAnchor = 251;
					else if(tmp_cnt == 6) tmp_yAnchor = 286;
					else if(tmp_cnt == 7) tmp_yAnchor = 321;
					else if(tmp_cnt == 8) tmp_yAnchor = 356;
				}else{
					if(tmp_cnt == 1) tmp_yAnchor = 0;
					else if(tmp_cnt == 2) tmp_yAnchor = 40;
					else if(tmp_cnt == 3) tmp_yAnchor = 70;
				}
				
				if(map_kind == 2){
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['overlay'].setYAnchor(76);
					}
					$("#alarm_"+item).hide();
					$("#rain_"+item).hide();
					$("#flow_"+item).hide();
					$("#snow_"+item).hide();
					$("#mix_"+item).css("height", "28px");
				}else{
					$("#mix_"+item).css("height", "");
				}
				
				if(tmp_cnt != 0){
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
				}
				
				// 이벤트
				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					$(document).on("click", "#"+arr_rtu[item]['sensor_kind'][i]+"_"+item, function(){
						var tmp_param = (this.id.split("_")[0] == "alarm") ? arr_rtu[item]['rtu_id'] : item;
						if($("input:checkbox[id='overlay_move']").is(":checked")){
						}else{
							slide_on(this.id.split("_")[0], tmp_param);
						}
					});
				}


				$(document).on("click", "#mix_"+item, function(){
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

							$("#mix_"+item).css('box-shadow','rgb(255 0 0 / 70%) 0px 0px 10px 3px');
							arr_rtu[item]['polyline'].setStyles('strokeColor','#FF0000');
							arr_rtu[item]['polyline'].setStyles('strokeOpacity','0.5');
							arr_rtu[item]['polyline'].setStyles('strokeWeight','10');
							arr_rtu[item]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
							arr_rtu[item]['marker'].setZIndex(3 + add_zindex);
							arr_rtu[item]['polyline'].setZIndex(1);
							add_zindex++;
							
							var overlay_start_point = arr_rtu[item]['overlay'].getPosition();
							var zoom_lat;
							var data_cnt = 0;

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
													if($("#alarm_"+item)){
														if($("#alarm_"+item).css('display') == "block"){
															data_cnt++;
														}
													}
													if($("#rain_"+item)){
														if($("#rain_"+item).css('display') == "block"){
															data_cnt++;
														}
													}
													if($("#flow_"+item)){
														if($("#flow_"+item).css('display') == "block"){
															data_cnt++;
														}
													}
													
													if(data_cnt == 1) tmp_yAnchor = 0;
													else if(data_cnt == 2) tmp_yAnchor = 40;
													else if(data_cnt == 3) tmp_yAnchor = 70;

													arr_rtu[item]['overlay'].setYAnchor(tmp_yAnchor);
													arr_rtu[item]['overlay'].setPosition(new naver.maps.LatLng(e.coord.lat()+zoom_lat, e.coord.lng()));
													arr_rtu[item]['polyline'].setVisible(true);
													arr_rtu[item]['polyline'].setPath( new Array( arr_rtu[item]['marker'].getPosition(), new naver.maps.LatLng(e.coord.lat()+zoom_lat , e.coord.lng()) ) );
													arr_rtu[item]['overlay_x'] = e.coord.lat()+zoom_lat;
													arr_rtu[item]['overlay_y'] = e.coord.lng();
													arr_rtu[item]['marker'].setAnimation();

												box_update();
												
												swal.close();
											}, "json");

											$("#mix_"+item).css('box-shadow','');
											arr_rtu[item]['polyline'].setStyles('strokeColor','#464646');
											arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
											arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
											arr_rtu[item]['marker'].setAnimation();
											map.setCursor('grab');
										}else{
											arr_rtu[item]['overlay'].setPosition(overlay_start_point);
											$("#mix_"+item).css('box-shadow','');
											arr_rtu[item]['polyline'].setStyles('strokeColor','#464646');
											arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
											arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
											arr_rtu[item]['marker'].setAnimation();
											map.setCursor('grab');
										}
									});
								}else{
									$("#mix_"+item).css('box-shadow','');
									arr_rtu[item]['polyline'].setStyles('strokeColor','#464646');
									arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
									arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
									arr_rtu[item]['marker'].setAnimation();
									map.setCursor('grab');
								}
							});
							
						}else{
							// slide_on("state", item);
						}
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}

				});
				$(document).on("click", "#mix_"+item+" #b_alarm_send", function(e){
					e.stopPropagation();
					if(map_kind == 1){
						slide_on("alarm", arr_rtu[item]['rtu_id']);
					}
				});
				$(document).on("click", "#mix_"+item+" #b_alarm_hist", function(e){
					e.stopPropagation();
					if(map_kind == 1){
						slide_on("stillcut", arr_rtu[item]['area_code']);
					}
				});
				$(document).on("mouseover", "#mix_"+item, function(){
					arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
				});
				$(document).on("mouseover", "#alarm_"+item, function(){
					if( $("#mix_"+item+" .label_dat_on").hasClass("dp0") ){
						$("#alarm_"+item).addClass("dp0");
						$("#mix_"+item+" .label_dat_on").removeClass("dp0");
					}
				});
				$(document).on("mouseleave", "#mix_"+item+" .label_dat_on", function(){
					$("#alarm_"+item).removeClass("dp0");
					$("#mix_"+item+" .label_dat_on").addClass("dp0");
				});
				$(document).on("mouseleave", "#mix_"+item, function(){
					$("#alarm_"+item).removeClass("dp0");
					$("#mix_"+item+" .label_dat_on").addClass("dp0");
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
		if(arr_area_code){
			var tmp_arr_area_code = [];
			var tmp_arr_rtu_id = [];
			tmp_arr_area_code['alarm'] = [];
			tmp_arr_area_code['rain'] = [];
			tmp_arr_area_code['flow'] = [];
			tmp_arr_area_code['snow'] = [];
			$.each(arr_area_code, function(index, item){
				var tmp_cnt = 0;
				var tmp_last = "";
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("5", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 방송 버튼 선택
					$("#mix_"+item+"_process").show();
					$("#alarm_"+item).show(); 
					if( $("#alarm_"+item).length != 0 ){
						tmp_arr_area_code['alarm'].push(item); 
						tmp_arr_rtu_id.push(arr_rtu[item]['rtu_id']);
						tmp_cnt++;
						tmp_last = "alarm";
					}
    			}else{
					$("#mix_"+item+"_process").hide();
					$("#alarm_"+item).hide();
    			}
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 강우 버튼 선택
					$("#rain_"+item).show(); 
					if( $("#rain_"+item).length != 0 ){
						tmp_arr_area_code['rain'].push(item); 
						tmp_cnt++;
						tmp_last = "rain";
					}
    			}else{
					tmp_arr_area_code['rain'].push(item); // 폴리곤 컬러 변경을 위해
					$("#rain_"+item).hide();
    			}
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 수위 버튼 선택
					$("#flow_"+item).show(); 
					if( $("#flow_"+item).length != 0 ){
						tmp_arr_area_code['flow'].push(item); 
						tmp_cnt++;
						tmp_last = "flow";
					}
    			}else{
					$("#flow_"+item).hide();
    			}
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 적설 버튼 선택
					$("#snow_"+item).show(); 
					if( $("#snow_"+item).length != 0 ){
						tmp_arr_area_code['snow'].push(item); 
						tmp_cnt++;
						tmp_last = "snow";
					}
    			}else{
					$("#snow_"+item).hide();
    			}
				
				if(tmp_cnt == 1){
					$("#"+tmp_last+"_"+item).removeClass("bb");
				}else{
					$("#mix_"+item+" li").not(":first").addClass("bb");
					$("#"+tmp_last+"_"+item).removeClass("bb");
				}
				var tmp_yAnchor = 0;
				if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
					if(tmp_cnt == 1) tmp_yAnchor = 111;
					else if(tmp_cnt == 2) tmp_yAnchor = 146;
					else if(tmp_cnt == 3) tmp_yAnchor = 181;
					else if(tmp_cnt == 4) tmp_yAnchor = 216;
					else if(tmp_cnt == 5) tmp_yAnchor = 251;
					else if(tmp_cnt == 6) tmp_yAnchor = 286;
					else if(tmp_cnt == 7) tmp_yAnchor = 321;
					else if(tmp_cnt == 8) tmp_yAnchor = 356;
				}else{
					if(tmp_cnt == 1) tmp_yAnchor = 0;
					else if(tmp_cnt == 2) tmp_yAnchor = 40;
					else if(tmp_cnt == 3) tmp_yAnchor = 70;
				}
				if(map_kind == 1){
					if( jQuery.inArray("5", map_data) != "-1" ){
						if( arr_rtu[item]['alert_state'] || arr_rtu[item]['alert_error'][0] ){
							tmp_yAnchor = tmp_yAnchor + 17;
							if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
								arr_rtu[item]['overlay'].setYAnchor(tmp_yAnchor);
							}
						}else if( !arr_rtu[item]['alert_state'] && !arr_rtu[item]['alert_error'][0] ){
							if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
								arr_rtu[item]['overlay'].setYAnchor(tmp_yAnchor);
							}
						}
					}else{
						if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
							arr_rtu[item]['overlay'].setYAnchor(tmp_yAnchor);
						}
					}
				}
				if(map_kind == 2){
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['overlay'].setYAnchor(76);
					}
					$("#alarm_"+item).hide();
					$("#rain_"+item).hide();
					$("#flow_"+item).hide();
					$("#snow_"+item).hide();
					$("#mix_"+item).css("height", "28px");
				}else{
					$("#mix_"+item).css("height", "");
				}
				
				if(tmp_cnt != 0){
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가

					var tmp_icon = "";
					if(map_kind == 1){
						// 방송 시 마커 gif 이미지로 변경
						if( arr_rtu[item]['alert_state'] && !arr_rtu[item]['alert_error'][0] ){
							if(arr_rtu[item]['alert_step'] >= 4){
								if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
									if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_13_a.gif"){
										tmp_icon = "img/icon_s_13_a.gif";
									}		
								}else{
									if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_09_a.gif"){
										tmp_icon = "img/icon_s_09_a.gif";
									}
								}
							}else{
								if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
									if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_13_b.gif"){
										tmp_icon = "img/icon_s_13_b.gif";
									}		
								}else{
									if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_09_b.gif"){
										tmp_icon = "img/icon_s_09_b.gif";
									}	
								}
							}
						}else{
							if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_13.png"){
									tmp_icon = "img/icon_s_13.png";
								}
							}else{
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_09.png"){
									tmp_icon = "img/icon_s_09.png";
								}
							}
						}
						arr_rtu[item]['marker'].setIcon(
							{
								url: tmp_icon,
								size: new naver.maps.Size(21, 36)
							}
						);
					}if(map_kind == 2){
						// 장비상태 이상 시 마커 gif 이미지로 변경
						if(arr_rtu[item]['state']){
							if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_13_g.png"){
									tmp_icon = "img/icon_s_13_g.png";
								}
							}else{
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_09_g.png"){
									tmp_icon = "img/icon_s_09_g.png";
								}
							}
						}else{
							if(arr_rtu[item]['ltype'] == "2" && arr_rtu[item]['btype'] == "1"){
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_13_o.png"){
									tmp_icon = "img/icon_s_13_o.png";
								}
							}else{
								if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_09_o.png"){
									tmp_icon = "img/icon_s_09_o.png";
								}
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
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
				}
			}); // $.each(arr_area_code, function(index, item) end

			if(map_kind != 2){
				for(var i in tmp_arr_area_code){
					if(tmp_arr_area_code[i].length != 0){
						//console.log(i, tmp_arr_area_code[i]);
						if(i == "alarm"){
							$.post( "controll/alarm.php", { "mode" : "alarm", "arr_area_code" : tmp_arr_area_code[i], "arr_rtu_id" : tmp_arr_rtu_id, "check" : "mix" }, function(response){
								$.each(response.list, function(index, item){
									if(arr_rtu[item.area_code]['alert_state'] || arr_rtu[item.area_code]['alert_error'][0]){
										var tmp_process = '';
										for(var i = 0; i <= 5; i++){
											if(i <= arr_rtu[item.area_code]['alert_step']){
												tmp_process += '<img src="img/ok.png">';
											}else{
												tmp_process += '<img src="img/ok_n.png">';
											}
										}
										$("#mix_"+item.area_code+"_process").html(tmp_process);
										
										if(arr_rtu[item.area_code]['alert_error'][0]){
											$("#alarm_"+item.area_code+" .dat_right").html('방송 에러<br/>'+arr_rtu[item.area_code]['alert_error'][1]);
										}else{
											if(arr_rtu[item.area_code]['alert_step'] >= 5){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/d1.gif"><br/>방송 완료');
											}else if(arr_rtu[item.area_code]['alert_step'] == 4){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/d1.gif"><br/>방송중(경보)');
											}else if(arr_rtu[item.area_code]['alert_step'] == 3){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/spinner.gif"><br/>정보 전송중');
											}else if(arr_rtu[item.area_code]['alert_step'] == 2){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/spinner.gif"><br/>장비 접속중');
											}else if(arr_rtu[item.area_code]['alert_step'] == 1){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/spinner.gif"><br/>SMS 전송중');
											}else if(arr_rtu[item.area_code]['alert_step'] == 0){
												$("#alarm_"+item.area_code+" .dat_right").html('<img src="img/spinner.gif"><br/>전송 대기중');
											}
										}
									}else{
										$("#mix_"+item.area_code+"_process").empty();
										
										if(item.date == "-"){
											$("#alarm_"+item.area_code+" .dat_right").html("&nbsp;<br>&nbsp;");
										}else{
											if(item.call == 7){ // VHF 방송 종료 시
												var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">VHF</span>';
												$("#alarm_"+item.area_code+" .dat_right").html(tmp_str);
											}else{
												var tmp_str = item.date.substr(0, 10).replace(/-/gi, ".")+'<br>'+item.date.substr(10, 6)+' <sapn style="font-size:11px;">CDMA</span>';
												$("#alarm_"+item.area_code+" .dat_right").html(tmp_str);
											}
										}
									}
								});
							}, "json");	
						}else if(i == "rain"){
							rain_ajax[2] = $.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : tmp_arr_area_code[i], "check" : "mix" }, function(response){
								$.each(response.list, function(index, item){
									$("#rain_"+item.area_code+" .dat_right").html(item.day);
									
									var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
									arr_rtu[item.area_code]['rain'] = item.day;
								});
							}, "json");
						}else if(i == "flow"){
							$.post( "controll/flow.php", { "mode" : "flow", "arr_area_code" : tmp_arr_area_code[i], "check" : "mix" }, function(response){
								$.each(response.list, function(index, item){
									$("#flow_"+item.area_code+" .dat_right").html(item.day);
								});
							}, "json");
						}else if(i == "snow"){
							$.post( "controll/snow.php", { "mode" : "snow", "arr_area_code" : tmp_arr_area_code[i], "check" : "mix" }, function(response){
								$.each(response.list, function(index, item){
									$("#snow_"+item.area_code+" .dat_right").html(item.day);
								});
							}, "json");
						}
					}
				} // for(var i in tmp_arr_area_code) end
			}
		}
	}
} // mix() end

	
	