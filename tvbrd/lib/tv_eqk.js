function eqk(kind, arr_sub_id){ // 지진계
	// 객체 생성
	if(kind == 1){
		if(arr_sub_id){
			$.each(arr_sub_id, function(index, item){
				
				// 객체
				var tmp_name = "";  
				if(arr_rtu[item]['rtu_name'].length > 15){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 15);
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}

				var box_content = '\n\
				<div id="eqk_'+item+'" class="label eqk">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat">&nbsp;</li>\n\
					</ul>\n\
				</div>\n\
				<div class="label_bot"><img src="img/label_bot.png"></div>';



				// circle[item] = new naver.maps.Circle({
				// 	class: "waves",
				// 	strokeColor: '#0000ff',
				// 	strokeOpacity: 0.8,
				// 	strokeWeight: 2,
				// 	fillColor: '#0000ff',
				// 	fillOpacity: 0.35,
				// 	center: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
				// 	radius: 3000,
				// 	zIndex: 100,
				// 	clickable: true,
				// 	map: map
				// });

				circle[item] = new CustomOverlay({
				    position: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
					content: "<div class='waves2 chameleon'></div>"
				});
				circle[item].setVisible(false);
				
				arr_rtu[item]['marker'] = new naver.maps.Marker({
					title: item,
					position: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
					zIndex: 2,
					draggable: false
					// animation: naver.maps.Animation.BOUNCE
				});


				arr_rtu[item]['overlay'] = new CustomOverlay({
				    position: new naver.maps.LatLng(arr_rtu[item]['x_point'], arr_rtu[item]['y_point']),
				    zIndex: 1,
					content: box_content,
					xAnchor: 55
				});
				arr_rtu[item]['polyline'] = new naver.maps.Polyline({
					path: new Array( sig_marker.getPosition(), arr_rtu[item]['marker'].getPosition() ),
					zIndex: 1,
				    strokeWeight: 2,
				    strokeColor: "#4C4C4C",
				    strokeOpacity: 1,
				    strokeStyle: 'dashed'
				});
				arr_rtu[item]['overlay_on'] = false;
				arr_rtu[item]['state'] = true;
				
				arr_rtu[item]['marker'].setIcon(
					{
						url: "img/icon_s_20.png",
						size: new naver.maps.Size(21, 36)
					}
				);	
				arr_rtu[item]['marker'].setMap(map);

				// arr_rtu[item]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
				// arr_rtu[item]['marker'].setAnimation();

				if(isMobile() == false){
					arr_rtu[item]['overlay'].setMap(map);
					circle[item].setMap(map);
				}
				var tmp_height = Number( arr_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
				arr_rtu[item]['overlay'].setYAnchor(tmp_height);
				arr_rtu[item]['polyline'].setMap(map);
				if(map_kind != 2) arr_rtu[item]['polyline'].setVisible(false);
				
				// 줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_rtu[item]['overlay_on']){
						arr_rtu[item]['overlay'].setVisible(true);
    	    		}else{
    	    			arr_rtu[item]['overlay'].setVisible(false);
    	    		}
		    		if( Number(map_level) < Number(clus_level) ){
		    			arr_rtu[item]['overlay'].setVisible(false);
		    		}
				}
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("12", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, eqk 버튼 선택
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					// arr_rtu[item]['overlay'].setYAnchor(76);
					arr_rtu[item]['overlay'].setYAnchor(76);
					$("#eqk_"+item).css("height", "28px");
					$("#eqk_"+item+" ul .label_top").css("height", "30px");
				}else{
					// arr_rtu[item]['overlay'].setYAnchor(249);
					arr_rtu[item]['overlay'].setYAnchor(111);
					$("#eqk_"+item).css("height", "");
					$("#eqk_"+item+" ul .label_top").css("height", "30px");
				}


				$(document).on("click", "#eqk_"+item, function(){
					if(map_kind == 1){
						slide_on("rain", item);
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});

			
				$(document).on("mouseover", "#eqk_"+item, function(){
					arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
				});
				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != ""){
								arr_rtu[over_last]['overlay_on'] = false;
								arr_rtu[over_last]['overlay'].setVisible(false);
							}
							if(over_sub_last != "" && over_sub_last != item){
								arr_rtu[over_sub_last]['overlay_on'] = false;
								arr_rtu[over_sub_last]['overlay'].setVisible(false);
							}
							over_last = "";
							over_sub_last = item;

							slide_on( "state", new Array(arr_rtu[item]['sub_type'], arr_rtu[item]['area_code']) );
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
    				var sub_type = arr_rtu[item]['sub_type'];
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
									console.log(rtu_id);
									$.post( "controll/tutor.php", { "mode" : "rtu_move", "rtu_id" : rtu_id, "point" : point, "name" : tmp_name }, function(response2){
										arr_rtu[item]['overlay'].setPosition(end_point);
										circle[item].setPosition(end_point);
										arr_rtu[item]['polyline'].setPath( new Array( sig_marker.getPosition(), end_point ) );
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
												arr_rtu[item]['overlay'].setPosition(end_point);
												circle[item].setPosition(end_point);
												arr_rtu[item]['polyline'].setPath( new Array( sig_marker.getPosition(), end_point ) );
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
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("12", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, eqk 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_20.png"){
							arr_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_20.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_rtu[item]['state']){
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_20.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_20.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_20.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_20.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#F10000" });
						}
					}
					arr_rtu[item]['marker'].setVisible(true);
					arr_rtu[item]['overlay'].setVisible(true);
					if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(true);
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_rtu[item]['overlay_on']){
							arr_rtu[item]['overlay'].setVisible(true);
	    	    		}else{
	    	    			arr_rtu[item]['overlay'].setVisible(false);
	    	    		}
			    		if( Number(map_level) < Number(clus_level) ){
			    			arr_rtu[item]['overlay'].setVisible(false);
			    		}
					}else{
						arr_rtu[item]['overlay'].setZIndex(add_zindex);
		    		}
					
					if(map_kind == 2){
						// arr_rtu[item]['overlay'].setYAnchor(76);
						arr_rtu[item]['overlay'].setYAnchor(76);
						$("#eqk_"+item).css("height", "28px");
						$("#eqk_"+item+" ul .label_top").css("height", "30px");
					}else{
						// arr_rtu[item]['overlay'].setYAnchor(249);
						// arr_rtu[item]['overlay'].setYAnchor(111);
						$("#eqk_"+item).css("height", "");
						$("#eqk_"+item+" ul .label_top").css("height", "30px");
					}
					
					if(map_kind != 2){
						// console.log(arr_sub_id);
						 $.post( "controll/eqk.php", { "mode" : "eqk", "arr_area_code" : arr_sub_id }, function(response){
							$.each(response.list, function(index, item){
								// console.log(arr_rtu[item.area_code]);
								$("#eqk_"+item.area_code+" .label_dat").html(item.day);

								// if(item.state){
								// 	$("#eqk_"+item.area_code+" .label_dat").html(item.day);
								// 	arr_rtu[item.area_code]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
								// 	circle[item.area_code].setVisible(true);
								// 	doBounce($("#eqk_"+item.area_code), 3.2, '20px', 345);
								// 	// console.log($("#eqk_"+item.area_code).parent('div').css('top'));
								// 	// console.log($("div[title|='"+item.area_code+"'").css('top'));

								// }else{
								// 	$("#eqk_"+item.area_code+" .label_dat").html(item.day);
								// 	arr_rtu[item.area_code]['marker'].setAnimation();
								// 	circle[item.area_code].setVisible(false);
								// 	$("#eqk_"+item.area_code).stop(true);
								// 	// var tmp_height = Number( arr_rtu[item.area_code]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
								// 	// arr_rtu[item.area_code]['overlay'].setYAnchor(tmp_height);
								// 	arr_rtu[item.area_code]['overlay'].setYAnchor(111);
								// 	// arr_rtu[item]['overlay'].setYAnchor(111);

								// 	var tmp_top = Number($("div[title|='"+item.area_code+"'").css('top').replace(/[^0-9]/g,''))+36;
								// 	$("#eqk_"+item.area_code).parent('div').css('top',tmp_top+"px");
								// 	//doBounce($("#eqk_"+item.area_code), 3.2, '20px', 345,0);
								// }

								// var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
								// arr_rtu[item.area_code]['rain'] = item.day;


							});
						}, "json");
					}

				}); // $.each(arr_sub_id, function(index, item) end
			}
		}else{
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					arr_rtu[item]['marker'].setVisible(false);
					arr_rtu[item]['overlay'].setVisible(false);
					circle[item].setVisible(false);
					if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
				});
			}
		}
	}
} // eqk() end

function eqk_event(area_code,state) {
			if(state == 1){
				arr_rtu[area_code]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
				circle[area_code].setVisible(true);
				arr_rtu[area_code]['overlay'].setYAnchor(130);
				// doBounce($("#eqk_"+area_code), 3.5, '20px', 345);
				// console.log($("#eqk_"+area_code).parent('div').css('top'));
				// console.log($("div[title|='"+area_code+"'").css('top'));
			}else{
				arr_rtu[area_code]['marker'].setAnimation();
				circle[area_code].setVisible(false);
				$("#eqk_"+area_code).stop(true);
				arr_rtu[area_code]['overlay'].setYAnchor(111);
				// var tmp_height = Number( arr_rtu[area_code]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
				// arr_rtu[area_code]['overlay'].setYAnchor(tmp_height);
				// arr_rtu[area_code]['overlay'].setYAnchor(111);
				// arr_rtu[item]['overlay'].setYAnchor(111);

				// var tmp_top = Number($("div[title|='"+area_code+"'").css('top').replace(/[^0-9]/g,''))+36;
				// $("#eqk_"+area_code).parent('div').css('top',tmp_top+"px");
			}
}


function doBounce(element, times, distance, speed) {
		for(i = 0; i < times; i++) {
			element.animate({marginTop: '-='+distance},speed)
				.animate({marginTop: '+='+distance},speed);
		}

   
}

