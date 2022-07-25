function cctv(kind, arr_sub_id){ // CCTV
	// 객체 생성
	if(kind == 1){
		if(arr_sub_id){
			$.each(arr_sub_id, function(index, item){
				// 객체
				var tmp_name = "";  
				if(arr_sub_rtu[item]['sub_name'].length > 15){
					tmp_name = arr_sub_rtu[item]['sub_name'].substring(0, 15);
				}else{
					tmp_name = arr_sub_rtu[item]['sub_name'];
				}
				var box_content = '\n\
				<div id="cctv_'+item+'" class="label cctv">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat" style="height: 172px;">\n\
							<video id="video" style="height: 150px; opacity: 0.7;">\n\
								<source src="" type="video/mp4">\n\
							</video>\n\
		                   	<span id="v_time"></span>\n\
						</li>\n\
						<span id="v_text" class="v_text dp0" style="position: absolute; left: 17px; top: 119px; font-size: 15px; font-weight: 700;">0:00／0:00</span>\n\
						<img id="v_play" class="v_play dp0" src="img/v-i-play.png" style="position: absolute; left: 72px; top: 63px; width: 60px; height: 60px;">\n\
						<img id="v_volume" class="v_volume dp0" src="img/v-i-volume-on.png" style="position: absolute; left: 102px; top: 126px; width: 18px; height: 18px;">\n\
						<img id="v_full" class="v_full dp0" src="img/v-i-full.png" style="position: absolute; left: 136px; top: 128px; width: 14px; height: 14px;">\n\
						<li id="v_slide" class="v_slide dp0" style="position: absolute; left: 0; top: 146px; height: 24px; cursor: default;">\n\
							<span id="v_slide_bar" style="width: 169px; height: 6px; margin-left: 16px; margin-top: 10px; background-color: #ffffff;"></span>\n\
						</li>\n\
					</ul>\n\
				</div>\n\
				<div class="label_bot"><img src="img/label_bot.png"></div>';
				
				arr_sub_rtu[item]['marker'] = new naver.maps.Marker({
					position: new naver.maps.LatLng(arr_sub_rtu[item]['sub_x_point'], arr_sub_rtu[item]['sub_y_point']),
					zIndex: 2,
					draggable: false
				});
				arr_sub_rtu[item]['overlay'] = new CustomOverlay({
				    position: new naver.maps.LatLng(arr_sub_rtu[item]['sub_x_point'], arr_sub_rtu[item]['sub_y_point']),
				    zIndex: 1,
					content: box_content,
					xAnchor: 100
				});
				arr_sub_rtu[item]['polyline'] = new naver.maps.Polyline({
					path: new Array( sig_marker.getPosition(), arr_sub_rtu[item]['marker'].getPosition() ),
					zIndex: 1,
				    strokeWeight: 2,
				    strokeColor: "#4C4C4C",
				    strokeOpacity: 1,
				    strokeStyle: 'dashed'
				});
				arr_sub_rtu[item]['overlay_on'] = false;
				arr_sub_rtu[item]['state'] = true;
				
				arr_sub_rtu[item]['marker'].setIcon(
					{
						url: "img/icon_s_08.png",
						size: new naver.maps.Size(21, 36)
					}
				);	
				arr_sub_rtu[item]['marker'].setMap(map);
				if(isMobile() == false){
					arr_sub_rtu[item]['overlay'].setMap(map);
				}
				var tmp_height = Number( arr_sub_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
				arr_sub_rtu[item]['overlay'].setYAnchor(tmp_height);
				arr_sub_rtu[item]['polyline'].setMap(map);
				if(map_kind != 2) arr_sub_rtu[item]['polyline'].setVisible(false);
				
				// 줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_sub_rtu[item]['overlay_on']){
						arr_sub_rtu[item]['overlay'].setVisible(true);
    	    		}else{
    	    			arr_sub_rtu[item]['overlay'].setVisible(false);
    	    		}
		    		if( Number(map_level) < Number(clus_level) ){
		    			arr_sub_rtu[item]['overlay'].setVisible(false);
		    		}
				}
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("6", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, CCTV 버튼 선택
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_sub_rtu[item]['marker'].setVisible(false);
    				arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					arr_sub_rtu[item]['overlay'].setYAnchor(76);
					$("#cctv_"+item).css("height", "28px");
				}else{
					arr_sub_rtu[item]['overlay'].setYAnchor(249);
					$("#cctv_"+item).css("height", "");
				}

				// cctv api 호출
				if(map_kind != 2){
					$.post( "controll/cctv.php", { "mode" : "cctv", "sub_id" : item }, function(response){
						var list = response.list;
						$("#cctv_"+list.sub_id+" #video source").attr("src", list.url);
						$("#cctv_"+list.sub_id+" #video").get(0).load();
						$("#cctv_"+list.sub_id+" #v_time").html(list.time);
					}, "json");
				}
				
				// 이벤트
				function time_update(item){
					s_time = parseInt( $("#cctv_"+item+" #video").get(0).currentTime );
					s_min = toFixedOf(s_time / 60, 0);
					s_sec = toFixedOf(s_time % 60, 0); 
					s_sec = s_sec < 10 ? "0"+s_sec : s_sec;
					
					e_time = parseInt( $("#cctv_"+item+" #video").get(0).duration );
					e_min = toFixedOf(e_time / 60, 0);
					e_sec = toFixedOf(e_time % 60, 0); 
					e_sec = e_sec < 10 ? "0"+e_sec : e_sec;
					
					return s_min+":"+s_sec+"／"+e_min+":"+e_sec;
				}
				$("#cctv_"+item+" #video").on("error", function(){
					//console.log("cctv 시간 만료: "+item);
					if( $("#cctv_"+item+" #video").get(0).error.code == 3 ){
						$("#cctv_"+item+" #video source").attr("src", "");
						$("#cctv_"+item+" #video").get(0).load();
						
						$.post( "controll/cctv.php", { "mode" : "cctv", "sub_id" : item }, function(response){
							var list = response.list;
							$("#cctv_"+list.sub_id+" #video source").attr("src", list.url);
							$("#cctv_"+list.sub_id+" #video").get(0).load();
						}, "json");	
					}
				});
				$("#cctv_"+item+" #video").on("play", function(){
					$("#cctv_"+item+" #v_play").attr("src", "img/v-i-stop.png");
					$("#cctv_"+item+" #video").css("opacity", 1);
				});
				$("#cctv_"+item+" #video").on("pause", function(){
					$("#cctv_"+item+" #v_play").attr("src", "img/v-i-play.png");
					$("#cctv_"+item+" #video").css("opacity", 0.7);
				});
				$("#cctv_"+item+" #video").on("timeupdate", function(){
					$("#cctv_"+item+" #v_text").html( time_update(item) );
					$("#cctv_"+item+" #v_slide_bar").slider("value", parseInt( $("#cctv_"+item+" #video").get(0).currentTime ));
				});
				$(document).on("click", "#cctv_"+item+" #v_full", function(e){
					if( !$("#cctv_"+item+" #video").get(0).error ){
						if( $("#cctv_"+item+" #video").get(0).readyState == 4 ){
							e.stopPropagation();
							$("#cctv_"+item+" #video").fullscreen();
							if( $("#cctv_"+item+" #video").get(0).paused == true ){
								$("#cctv_"+item+" #video").get(0).play();
							}
						}
					}
				});
				$(document).on("click", "#cctv_"+item+" #v_slide", function(e){
					e.stopPropagation();
				});
				$(document).on("click", "#cctv_"+item+" #v_slide_bar", function(e){
					e.stopPropagation();
				});
				$(document).on("mouseover", "#cctv_"+item+" #video", function(){
					if( !$("#cctv_"+item+" #video").get(0).error ){
						if( $("#cctv_"+item+" #video").get(0).readyState == 4 ){
							$("#cctv_"+item+" #v_text").removeClass("dp0");
							$("#cctv_"+item+" #v_play").removeClass("dp0");
							$("#cctv_"+item+" #v_volume").removeClass("dp0");
							$("#cctv_"+item+" #v_full").removeClass("dp0");
							$("#cctv_"+item+" #v_slide").removeClass("dp0");
						}
					}
				});
				$(document).on("mouseout", "#cctv_"+item+" #video", function(e){
					if( !$("#cctv_"+item+" #video").get(0).error ){
						if( $("#cctv_"+item+" #video").get(0).readyState == 4 ){
							if(e.relatedTarget){
								if( e.relatedTarget.id == "v_text" || e.relatedTarget.id == "v_play" || 
								    e.relatedTarget.id == "v_volume" || e.relatedTarget.id == "v_full" || 
								    e.relatedTarget.id == "v_slide" || e.relatedTarget.id == "v_slide_bar" ){
									
								}else{
									$("#cctv_"+item+" #v_text").addClass("dp0");
									$("#cctv_"+item+" #v_play").addClass("dp0");
									$("#cctv_"+item+" #v_volume").addClass("dp0");
									$("#cctv_"+item+" #v_full").addClass("dp0");
									$("#cctv_"+item+" #v_slide").addClass("dp0");
								}
							}
						}
					}
				});
				$("#v_slide_bar").slider({
					min: 0,
					max: parseInt( $("#cctv_"+item+" #video").get(0).duration ),
					value: 0,
					create: function(event, ui){
						$("#cctv_"+item+" #v_slide_bar span").css("top", "-4px");
						$("#cctv_"+item+" #v_slide_bar span").css("margin-left", "-.3em");
						$("#cctv_"+item+" #v_slide_bar span").css("width", "12px");
						$("#cctv_"+item+" #v_slide_bar span").css("height", "12px"); 
						$("#cctv_"+item+" #v_slide_bar span").css("background-color", "#ffffff"); 
					},
					slide: function(event, ui){
						$("#cctv_"+item+" #video").get(0).currentTime = ui.value;
					},
					start: function(event, ui){
						map.setOptions("draggable", false); // 지도가 움직이지 않도록
					},
					stop: function(event, ui){
						map.setOptions("draggable", true); // 다시 지도가 움직이도록
					}
				});
				$("#cctv_"+item+" #video").on("loadeddata", function(){
					$("#cctv_"+item+" #video").css("opacity", 0.7);
					$("#cctv_"+item+" #v_text").html( time_update(item) );
					
					$("#v_slide_bar").slider({
						min: 0,
						max: parseInt( $("#cctv_"+item+" #video").get(0).duration ),
						value: 0,
						create: function(event, ui){
							$("#cctv_"+item+" #v_slide_bar span").css("top", "-4px");
							$("#cctv_"+item+" #v_slide_bar span").css("margin-left", "-.3em");
							$("#cctv_"+item+" #v_slide_bar span").css("width", "12px");
							$("#cctv_"+item+" #v_slide_bar span").css("height", "12px"); 
							$("#cctv_"+item+" #v_slide_bar span").css("background-color", "#ffffff"); 
						},
						slide: function(event, ui){
							$("#cctv_"+item+" #video").get(0).currentTime = ui.value;
						},
						start: function(event, ui){
							map.setOptions("draggable", false); // 지도가 움직이지 않도록
						},
						stop: function(event, ui){
							map.setOptions("draggable", true); // 다시 지도가 움직이도록
						}
					});
				});
				$(document).on("click", "#cctv_"+item, function(){
					if(map_kind == 1){
						if( !$("#cctv_"+item+" #video").get(0).error ){
							if( $("#cctv_"+item+" #video").get(0).readyState == 4 ){
								if( $("#cctv_"+item+" #video").get(0).paused == true ){
									$("#cctv_"+item+" #video").get(0).play();
								}else{
									$("#cctv_"+item+" #video").get(0).pause();
								}
							}
						}
					}else if(map_kind == 2){
						slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
					}
				});
				$(document).on("mouseover", "#cctv_"+item, function(){
					arr_sub_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
				});
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != ""){
								arr_rtu[over_last]['overlay_on'] = false;
								arr_rtu[over_last]['overlay'].setVisible(false);
							}
							if(over_sub_last != "" && over_sub_last != item){
								arr_sub_rtu[over_sub_last]['overlay_on'] = false;
								arr_sub_rtu[over_sub_last]['overlay'].setVisible(false);
							}
							over_last = "";
							over_sub_last = item;

							slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
						}
						if(arr_sub_rtu[item]['overlay_on']){
							arr_sub_rtu[item]['overlay'].setZIndex(1);
							arr_sub_rtu[item]['overlay'].setVisible(false);
							arr_sub_rtu[item]['overlay_on'] = false;
						}else{
							arr_sub_rtu[item]['overlay'].setZIndex(3 + add_zindex);
							add_zindex++;
							arr_sub_rtu[item]['overlay'].setVisible(true);
							arr_sub_rtu[item]['overlay_on'] = true;
						}
					}
				});
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'mouseover', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_sub_rtu[item]['overlay_on']){
							arr_sub_rtu[item]['overlay'].setZIndex(4 + add_zindex);
							add_zindex++;
							arr_sub_rtu[item]['overlay'].setVisible(true);
						}
					}
				});
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'mouseout', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_sub_rtu[item]['overlay_on']){
							arr_sub_rtu[item]['overlay'].setZIndex(1);
							arr_sub_rtu[item]['overlay'].setVisible(false);
						}
					}
				});
				// 장비 좌표 이동 기능 - START
				var start_point = "";
				var end_point = "";
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'mousedown', function(){
					start_point = arr_sub_rtu[item]['marker'].getPosition();
					move_state = true;
				});
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'mouseup', function(){
					move_state = false;
				});
				naver.maps.Event.addListener(arr_sub_rtu[item]['marker'], 'dragend', function(){
					end_point = arr_sub_rtu[item]['marker'].getPosition();

    				var sub_id = arr_sub_rtu[item]['sub_id'];
    				var sub_type = arr_sub_rtu[item]['sub_type'];
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
							$.post( "controll/tutor.php", { "mode" : "rtu_move_check", "name" : tmp_name }, function(response2){
								if(response2.check){
									$.post( "controll/tutor.php", { "mode" : "rtu_sub_move", "sub_id" : sub_id, "sub_type" : sub_type, "point" : point }, function(response3){
										arr_sub_rtu[item]['overlay'].setPosition(end_point);
										arr_sub_rtu[item]['polyline'].setPath( new Array( sig_marker.getPosition(), end_point ) );

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
											$.post( "controll/tutor.php", { "mode" : "rtu_sub_move", "sub_id" : sub_id, "sub_type" : sub_type, "point" : point }, function(response3){
												arr_sub_rtu[item]['overlay'].setPosition(end_point);
												arr_sub_rtu[item]['polyline'].setPath( new Array( sig_marker.getPosition(), end_point ) );

												box_update();
												
												swal.close();
											}, "json");
										}else{
											arr_sub_rtu[item]['marker'].setPosition(start_point);
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
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("6", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, CCTV 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_sub_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_08.png"){
							arr_sub_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_08.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_sub_rtu[item]['state']){
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_08_g.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_08_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_08_o.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_08_o.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#F10000" });
						}
					}
					arr_sub_rtu[item]['marker'].setVisible(true);
					arr_sub_rtu[item]['overlay'].setVisible(true);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(true);
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_sub_rtu[item]['overlay_on']){
							arr_sub_rtu[item]['overlay'].setVisible(true);
	    	    		}else{
	    	    			arr_sub_rtu[item]['overlay'].setVisible(false);
	    	    		}
			    		if( Number(map_level) < Number(clus_level) ){
			    			arr_sub_rtu[item]['overlay'].setVisible(false);
			    		}
					}else{
						arr_sub_rtu[item]['overlay'].setZIndex(add_zindex);
		    		}
					
					if(map_kind == 2){
						arr_sub_rtu[item]['overlay'].setYAnchor(76);
						$("#cctv_"+item).css("height", "28px");
					}else{
						arr_sub_rtu[item]['overlay'].setYAnchor(249);
						$("#cctv_"+item).css("height", "");
					}
				}); // $.each(arr_sub_id, function(index, item) end
			}
		}else{
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					arr_sub_rtu[item]['marker'].setVisible(false);
					arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
				});
			}
		}
	}
} // cctv() end


