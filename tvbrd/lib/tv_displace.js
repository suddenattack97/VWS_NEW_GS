function displace(kind, arr_sub_id){ // pmup (1, sub_id) - 파라미터
	// 객체 생성
	if(kind == 1){
		if(arr_sub_id){
			$.each(arr_sub_id, function(index, item){
				
				// 객체
				var overlay_mode = 0;
				var tmp_name = "";  
				if(arr_rtu[item]['rtu_name'].length > 15){
					tmp_name = arr_rtu[item]['rtu_name'].substring(0, 15);
				}else{
					tmp_name = arr_rtu[item]['rtu_name'];
				}

				var box_content = '\n\
				<div id="displace_'+item+'" class="label displace">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat">정상</li>\n\
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
					content: "<div id='wave_"+item+"' class='waves chameleon'></div>"
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
						url: "img/icon_s_19.png",
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
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("11", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, displace 버튼 선택
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_rtu[item]['marker'].setVisible(false);
    				arr_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					// arr_rtu[item]['overlay'].setYAnchor(76);
					arr_rtu[item]['overlay'].setYAnchor(76);
					$("#displace_"+item).css("height", "28px");
					$("#displace_"+item+" ul .label_top").css("height", "30px");
				}else{
					// arr_rtu[item]['overlay'].setYAnchor(249);
					arr_rtu[item]['overlay'].setYAnchor(111);
					$("#displace_"+item).css("height", "");
					$("#displace_"+item+" ul .label_top").css("height", "30px");
				}

				$(document).on("click", "#displace_"+item, function(){
					if(map_kind == 1){
						slide_on("disp", item);
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});
			
				$(document).on("mouseover", "#displace_"+item, function(){
					arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
					add_zindex++;
				});


				naver.maps.Event.addListener(arr_rtu[item]['marker'], 'rightclick', function(e) {
					// console.log(e.overlay);
					// console.log($(e.overlay[0]));
					// console.log(e.overlay.title);
					var item_code = e.overlay.title;
					if($("#overlay_control_"+e.overlay.title)){
						if($("#overlay_control_"+e.overlay.title).css('display') == 'block'){
							$("#overlay_control_"+e.overlay.title).css('display','none');
						}else{
							overlay_control(e.overlay.title);

							$("#overlay_control_"+e.overlay.title).css('left',e.point.x-200);
							$("#overlay_control_"+e.overlay.title).css('top',e.point.y-90);
							$("#overlay_control_"+e.overlay.title).css('display','block');
	
							$("#overlay_fix_on_"+e.overlay.title).click(function(e){
								overlay_mode = "fix_on";
								arr_rtu[item_code]['overlay'].setVisible(true);
								$("#overlay_control_"+item_code).css('display','none');
							});
		
							$("#overlay_fix_off_"+e.overlay.title).click(function(e){
								overlay_mode = "fix_off";
								arr_rtu[item_code]['overlay'].setVisible(false);
								$("#overlay_control_"+item_code).css('display','none');
							});
		
							$("#overlay_left_"+e.overlay.title).click(function(e){
								overlay_mode = "left";
		
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-left','-130px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-top','-60px');

								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('transform' ,'rotate(270deg)');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-top' ,'-30px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-left' ,'59px');
								$("#overlay_control_"+item_code).css('display','none');
							});

							$("#overlay_right_"+e.overlay.title).click(function(e){
								overlay_mode = "right";
								
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-left','20px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-top','-60px');
								
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('transform' ,'rotate(90deg)');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-top' ,'-30px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-left' ,'-59px');
								$("#overlay_control_"+item_code).css('display','none');
							});

							$("#overlay_top_"+e.overlay.title).click(function(e){
								overlay_mode = "top";
		
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-left','-55px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-top','-111px');
		
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('transform' ,'rotate(0deg)');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-top' ,'-4px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-left' ,'0px');
								$("#overlay_control_"+item_code).css('display','none');
							});

							$("#overlay_bottom_"+e.overlay.title).click(function(e){
								overlay_mode = "bottom";
								
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-left','-55px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).parent().css('margin-top','10px');
		
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('transform' ,'rotate(180deg)');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-top' ,'-73px');
								$(arr_rtu[item_code]['overlay']._element[0].children[1]).css('margin-left' ,'0px');
								$("#overlay_control_"+item_code).css('display','none');
							});
						}
					}else{

					}
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
							// if($("#overlay_control_"+item).css('display') == 'none'){
								arr_rtu[item]['overlay'].setZIndex(1);
								arr_rtu[item]['overlay'].setVisible(false);
							// }
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
									// console.log(rtu_id);
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
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("11", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, displace 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_19.png"){
							arr_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_19.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_rtu[item]['state']){
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_19.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_19.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_rtu[item]['marker'].getIcon().url != "img/icon_s_19.png"){
								arr_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_19.png",
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
							// if($("#overlay_control_"+item).css('display') == "none"){
	    	    				arr_rtu[item]['overlay'].setVisible(false);
							// }
	    	    		}
			    		if( Number(map_level) < Number(clus_level) ){
							// if($("#overlay_control_"+item).css('display') == "none"){
								arr_rtu[item]['overlay'].setVisible(false);
							// }
			    		}
					}else{
						arr_rtu[item]['overlay'].setZIndex(add_zindex);
		    		}
					
					if(map_kind == 2){
						// arr_rtu[item]['overlay'].setYAnchor(76);
						arr_rtu[item]['overlay'].setYAnchor(76);
						$("#displace_"+item).css("height", "28px");
						$("#displace_"+item+" ul .label_top").css("height", "30px");
					}else{
						// arr_rtu[item]['overlay'].setYAnchor(249);
						// arr_rtu[item]['overlay'].setYAnchor(111);
						$("#displace_"+item).css("height", "");
						$("#displace_"+item+" ul .label_top").css("height", "30px");
					}
					
					if(map_kind != 2){
						// console.log(arr_sub_id);

						//데이터 표출 
						//  $.post( "controll/displace.php", { "mode" : "displace", "arr_area_code" : arr_sub_id }, function(response){
						// 	$.each(response.list, function(index, item){
						// 		// console.log(arr_rtu[item.area_code]);
						// 		// $("#displace_"+item.area_code+" .label_dat").html(item.day);
						// 	});
						// }, "json");
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
} // displace() end

function overlay_control(itemcode){

				if ($("#overlay_control_"+itemcode).css('display') == 'block'){
					$("#overlay_control_"+itemcode).css('display','none');
				}else{

						var set_left = "";
						var set_top = "";
						var overlay_control = "<div id='overlay_control_"+itemcode+"' style='position: absolute; z-index: 1; width:100px; height:170px; display:none; \n\
						background-color:#ffffff; border-radius : 10px 10px 10px 10px; text-align:center;'> \n\
						<div id='overlay_fix_on_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 고정</div> \n\
						<div id='overlay_fix_off_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 해제</div> \n\
						<div id='overlay_left_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 왼쪽</div> \n\
						<div id='overlay_right_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 오른쪽</div> \n\
						<div id='overlay_top_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 위</div> \n\
						<div id='overlay_bottom_"+itemcode+"' class='pT_10' style='font-weight:bold; cursor:pointer; '>오버레이 아래</div> \n\
						</div>";
									
					var overlay_controler = new CustomOverlay({
						position: new naver.maps.LatLng(arr_rtu[itemcode]['x_point'], arr_rtu[itemcode]['y_point']),
						zIndex: 1,
						content: overlay_control
					});
					overlay_controler.setMap(map);
	
					overlay_controler.setPosition(arr_rtu[itemcode]['marker'].getPosition());					
					
				}

}
function displace_event(area_code,state,level) {
			if(state == 1){
				// arr_rtu[area_code]['marker'].setAnimation(naver.maps.Animation.BOUNCE);
				circle[area_code].setVisible(true);
				// arr_rtu[area_code]['overlay'].setYAnchor(130);
				if(level == 1){
					$("#displace_"+area_code+" .label_dat").css('background','#1000ff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#ffffff');
					$("#displace_"+area_code+" .label_dat").text('주의보');
					$("#wave_"+area_code+" .waves:before").css('background','rgba(255,208,176, 0.6)');
				}else if (level == 2){
					$("#displace_"+area_code+" .label_dat").css('background','#eaff40 right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#ff0000');
					$("#displace_"+area_code+" .label_dat").text('경보');
				}else if (level == 3){
					$("#displace_"+area_code+" .label_dat").css('background','#f7980a right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#ff0000');
					$("#displace_"+area_code+" .label_dat").text('대피');
				// }else if (level == 4){
				// 	$("#displace_"+area_code+" .label_dat").css('background','#ff0000 right bottom no-repeat');
				// 	$("#displace_"+area_code+" .label_dat").css('color','#ffffff');
				// 	$("#displace_"+area_code+" .label_dat").text('심각');
				}else{
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}
				// doBounce($("#displace_"+area_code), 3.5, '20px', 345);
				// console.log($("#displace_"+area_code).parent('div').css('top'));
				// console.log($("div[title|='"+area_code+"'").css('top'));
			}else if(state == 0){
				// arr_rtu[area_code]['marker'].setAnimation();
				circle[area_code].setVisible(false);
				$("#displace_"+area_code).stop(true);
				arr_rtu[area_code]['overlay'].setYAnchor(111);

				if (level == 5){
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}else if (level == 6){
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}else if (level == 7){
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}else if (level == 8){
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}else{
					$("#displace_"+area_code+" .label_dat").css('background','#fff right bottom no-repeat');
					$("#displace_"+area_code+" .label_dat").css('color','#d5870b');
					$("#displace_"+area_code+" .label_dat").text('정상');
				}
				// var tmp_height = Number( arr_rtu[area_code]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
				// arr_rtu[area_code]['overlay'].setYAnchor(tmp_height);
				// arr_rtu[area_code]['overlay'].setYAnchor(111);
				// arr_rtu[item]['overlay'].setYAnchor(111);

				// var tmp_top = Number($("div[title|='"+area_code+"'").css('top').replace(/[^0-9]/g,''))+36;
				// $("#displace_"+area_code).parent('div').css('top',tmp_top+"px");
			}
}

// 오버레이 움직이는 함수
function doBounce(element, times, distance, speed) {
		for(i = 0; i < times; i++) {
			element.animate({marginTop: '-='+distance},speed)
				.animate({marginTop: '+='+distance},speed);
		}

   
}

