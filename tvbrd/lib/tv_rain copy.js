function rain(kind, arr_area_code){ // 강우 - 강우만 있는 장비
	// 객체 생성
	if(kind == 1){
		if(arr_area_code){
			$.each(arr_area_code, function(index, item){
				
				// 객체
				var tmp_name = "";  
				if(arr_rtu[item]['rtu_name'].length > 5){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 5)+"..";
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}
				var box_content = '\n\
					<div id="rain_'+item+'" class="label rain">\n\
						<ul>\n\
							<li class="label_top">'+tmp_name+'</li>\n\
							<li class="label_dat">&nbsp;</li>\n\
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
				var get_overlay_position = arr_rtu[item]['overlay'].getPosition();
				arr_rtu[item]['polyline'] = new naver.maps.Polyline({
					path: new Array( arr_rtu[item]['overlay'].getPosition(), arr_rtu[item]['marker'].getPosition() ),
					zIndex: 1,
				    strokeWeight: 5,
					strokeColor: "#4B89DC",
				    strokeOpacity: 1,
				    strokeStyle: 'dashed'
				});

				arr_rtu[item]['overlay_on'] = false;
				arr_rtu[item]['state'] = true;
				arr_rtu[item]['line'] = true;
				
				if(map_kind == 1){
					arr_rtu[item]['marker'].setIcon(
						{
							url: "img/icon_s_01.png",
							size: new naver.maps.Size(21, 36)
						}
					);	
				}else if(map_kind == 2){
					arr_rtu[item]['marker'].setIcon(
						{
							url: "img/icon_s_01_g.png",
							size: new naver.maps.Size(21, 36)
						}
					);	
				}
				arr_rtu[item]['marker'].setMap(map);
				if(isMobile() == false){
					arr_rtu[item]['overlay'].setMap(map);
				}
				arr_rtu[item]['polyline'].setMap(map);
				// if(map_kind != 2) arr_rtu[item]['polyline'].setVisible(false);
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
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 강우 버튼 선택
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					// if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					// arr_rtu[item]['overlay'].setYAnchor(76);
					$("#rain_"+item).css("height", "28px");
				}else{
					if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
						arr_rtu[item]['overlay'].setYAnchor(100);
					}
					// arr_rtu[item]['overlay'].setYAnchor(76);
					$("#rain_"+item).css("height", "");
				}

				// 이벤트
				$(document).on("click", "#rain_"+item, function(){
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

							$("#rain_"+item).css('box-shadow','rgb(255 0 0 / 70%) 0px 0px 10px 3px');
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

											$("#rain_"+item).css('box-shadow','');
											arr_rtu[item]['polyline'].setStyles('strokeColor','#4B89DC');
											arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
											arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
											arr_rtu[item]['marker'].setAnimation();
											map.setCursor('grab');
										}else{
											arr_rtu[item]['overlay'].setPosition(overlay_start_point);
											$("#rain_"+item).css('box-shadow','');
											arr_rtu[item]['polyline'].setStyles('strokeColor','#4B89DC');
											arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
											arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
											arr_rtu[item]['marker'].setAnimation();
											map.setCursor('grab');
										}
									});
								}else{
									$("#rain_"+item).css('box-shadow','');
									arr_rtu[item]['polyline'].setStyles('strokeColor','#4B89DC');
									arr_rtu[item]['polyline'].setStyles('strokeOpacity','1');
									arr_rtu[item]['polyline'].setStyles('strokeWeight','5');
									arr_rtu[item]['marker'].setAnimation();
									map.setCursor('grab');
								}
							});
							
						}else{
							slide_on("rain", item);
						}
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});	
				$(document).on("mouseover", "#rain_"+item, function(){
					arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
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

			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, 강우 버튼 선택
			if(arr_area_code){
				$.each(arr_area_code, function(index, item){
					//console.log( arr_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_01.png"){
							arr_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_01.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						// 장비상태 이상 시 마커 gif 이미지로 변경
						if(arr_rtu[item]['state']){
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_01_g.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_01_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
						}else{
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_01_o.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_01_o.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
						}	
						// 장비 통신상태 이상 시 polyline 색깔 변경
						if(arr_rtu[item]['line']){
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#F10000" });
						}
					}
					arr_rtu[item]['marker'].setVisible(true);
					arr_rtu[item]['overlay'].setVisible(true);
					// if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(true);
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
						// arr_rtu[item]['overlay'].setYAnchor(60);
						$("#rain_"+item).css("height", "28px");
					}else{
						if(arr_rtu[item]['overlay_x'] == null && arr_rtu[item]['overlay_y'] == null){
							arr_rtu[item]['overlay'].setYAnchor(100);
							// arr_rtu[item]['overlay'].setYAnchor(60);
						}
						$("#rain_"+item).css("height", "");
						
					}
				}); // $.each(arr_area_code, function(index, item) end
				
				if(map_kind != 2){
					rain_ajax[0] = $.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : arr_area_code }, function(response){
						$.each(response.list, function(index, item){
							$("#rain_"+item.area_code+" .label_dat").html(item.day);
							
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
					arr_rtu[item]['marker'].setVisible(false);
					arr_rtu[item]['overlay'].setVisible(false);
					// if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
					arr_rtu[item]['polyline'].setVisible(false);
				});
			}
		}
	}
	
} // rain() end


