function water(kind, arr_sub_id){ // 약수 @@ 여기랑 슬라이드쪽 작업 많이 안 되어 있음 임시 작업
	// 객체 생성
	if(kind == 1){
		if(arr_sub_id){
			$.each(arr_sub_id, function(index, item){
				// 객체
				var tmp_name = "";  
				if(arr_sub_rtu[item]['sub_name'].length > 10){
					tmp_name = arr_sub_rtu[item]['sub_name'].substring(0, 10);
				}else{
					tmp_name = arr_sub_rtu[item]['sub_name'];
				}
				
				var box_content = '\n\
					<div id="water_'+item+'" class="label t10 drink" style="white-space: nowrap;">\n\
						<ul>\n\
							<li class="label_top">'+tmp_name+'</li>\n\
                            <li class="label_dat">\n\
						    	<span>100</span>\n\
                            	<span>16.5</span>\n\
                            </li>\n\
							<li class="label_dat">\n\
								<div class="rwrap">\n\
								<span class="r1">&nbsp</span>\n\
								<span class="r2">&nbsp</span>\n\
								</div>\n\
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
					xAnchor: 85
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
						url: "img/icon_s_12.png",
						size: new naver.maps.Size(21, 36)
					}
				);	
				arr_sub_rtu[item]['marker'].setMap(map);
				if(isMobile() == false){
					arr_sub_rtu[item]['overlay'].setMap(map);
				}
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
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("10", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 문자전광판 버튼 선택
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_sub_rtu[item]['marker'].setVisible(false);
    				arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					arr_sub_rtu[item]['overlay'].setYAnchor(76);
					$("#water_"+item).css("height", "28px");
				}else{
					var tmp_height = Number( arr_sub_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
					arr_sub_rtu[item]['overlay'].setYAnchor(tmp_height);
					$("#water_"+item).css("height", "");
				}
				
				// 이벤트
	            $("#water_"+item).unbind("click").bind("click",function(){
					if(map_kind == 1){
						slide_on("water", item);
					}else if(map_kind == 2){
						slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
					}
				});
				$(document).on("mouseover", "#water_"+item, function(){
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
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("10", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, sign 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_sub_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_12.png"){
							arr_sub_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_12.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_sub_rtu[item]['state']){
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_12_g.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_12_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_12_o.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_12_o.png",
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
						$("#water_"+item).css("height", "28px");
					}else{
						/*
						var tmp_height = Number( arr_sub_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
						arr_sub_rtu[item]['overlay'].setYAnchor(tmp_height);
						$("#water_"+item).css("height", "");
						*/
					}
				}); // $.each(arr_sub_id, function(index, item) end
				
				if(map_kind == 1){
					$.post( "controll/sign.php", { "mode" : "sign", "arr_siteID" : arr_sub_id }, function(response){
						var arr_check = [];
						var arr_event = [];
						
						$.each(response.list, function(index, item){
							var select = '#water_'+item[0].siteID+' .rwrap span';
							arr_check[index] = item[0].siteID;
							arr_event[ item[0].siteID ] = [];
							
							$.each(item, function(index2, item2){
								var box_content = '';
								var add_class2 = "";
								if(item2.msgColor == 1) add_class2 = "red";
								else if(item2.msgColor == 2) add_class2 = "green";
								else if(item2.msgColor == 3) add_class2 = "yellow";
								var tmp_msg = '';
				    			if(item2.type == 0){
				    				tmp_msg = item2.msg;
				    			}else if(item2.type == 1){
				    				tmp_msg = '<img src="'+item2.imgpath+'">';
				    			}
	
								arr_sub_rtu[item2.siteID]['state'] = true;
								if(item2.success == 1){ // 송신중
									box_content += '<span class="r1 green">전송중..</span>';
									item2.modY = 1;
								}else if(item2.success == 2){ // 송신 실패
									box_content += '<span class="r1 red">전송 실패</span>';
									arr_sub_rtu[item2.siteID]['state'] = false;
									item2.modY = 1;
								}else if(item2.success == 3){ // 송신 완료
						    		var arr_msg = [];
						    		if( String(tmp_msg).indexOf('\n') != "-1" ){
						    			arr_msg = tmp_msg.split("\n");
						    		}else{
						    			arr_msg[0] = tmp_msg;
						    			arr_msg[1] = "";
						    		}
					
									for(var j = 0; j < item2.modY; j++){
										box_content += '<span class="r'+(j+1)+' '+add_class2+'">';
										box_content += (arr_msg[j] == "") ? "&nbsp;" : arr_msg[j];
										box_content += '</span>';
									}
									//console.log(box_content);
								} // if else if end
								
								var tmp_height = Number( arr_sub_rtu[item2.siteID]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
								arr_sub_rtu[item2.siteID]['overlay'].setYAnchor(tmp_height);
								
								arr_event[ item2.siteID ][index2] = [];
								arr_event[ item2.siteID ][index2]['success'] = item2.success;
								arr_event[ item2.siteID ][index2]['IDX'] = item2.IDX;
								arr_event[ item2.siteID ][index2]['msgAction'] = item2.msgAction;
								arr_event[ item2.siteID ][index2]['modX'] = item2.modX;
								arr_event[ item2.siteID ][index2]['modY'] = item2.modY;
								arr_event[ item2.siteID ][index2]['box_content'] = box_content;
							});
							
							// 변화할 때만 업데이트
							var tmp_sum = "";
							$.each(arr_event[ item[0].siteID ], function(i, v){
								if(tmp_sum != "") tmp_sum += "/";
								tmp_sum += v['success']+"-"+v['IDX']+"-"+v['modX']+"-"+v['modY']+"-"+v['msgAction'];
							});
							//console.log("change: "+arr_sub_rtu[ item[0].siteID ]['change']);
							//console.log("tmp_sum: "+tmp_sum);
							
							if(arr_sub_rtu[ item[0].siteID ]['change'] == tmp_sum){
								return true;
							}else{
								arr_sub_rtu[ item[0].siteID ]['change'] = tmp_sum;
							}	
//							sign_event(0, item[0].siteID, select, arr_event); // 전광판 효과 적용
						});

						// 문자 비송출 중인 전광판 오버레이
						$.each(arr_sub_id, function(index, item){
							if( jQuery.inArray(item, arr_check) == "-1" ){
//								$("#water_"+item+" .label_dat").css("height", "23px");
//								$("#water_"+item+" .rwrap").html('<span class="r1">&nbsp</span>');
								$("#water_"+item+" .rwrap").html('<span class="r1 green">가나다라마바사아</span><span class="r2 red">가나다라마바사아</span>');
							}
						});
					}, "json");
				}else if(map_kind == 2){
					$.post( "controll/sign.php", { "mode" : "sign", "arr_siteID" : arr_sub_id }, function(response){
						$.each(response.list, function(index, item){
							$.each(item, function(index2, item2){
								arr_sub_rtu[item2.siteID]['state'] = true;
								if(item2.success == 2){ // 송신 실패
									arr_sub_rtu[item2.siteID]['state'] = false;
								}
							});
						});
					});
				}
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
	
} // water() end