function farm(kind, arr_sub_id){ // 스틸컷
	// 객체 생성
	if(kind == 1){
		if(arr_sub_id){
			$.each(arr_sub_id, function(index, item){
				// 객체
				var tmp_name = "";  
				if(arr_sub_rtu[item]['BUSINESS_NAME'].length > 15){
					tmp_name = arr_sub_rtu[item]['BUSINESS_NAME'].substring(0, 15);
				}else{
					tmp_name = arr_sub_rtu[item]['BUSINESS_NAME'];
				}
				var box_content = '\n\
				<div id="stillcut_'+item+'_process" class="process"></div>\n\
				<div id="stillcut_'+item+'" class="label stillcut">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'<button type="button" class="btn_shot"></button></li>\n\
						<li class="label_dat" style="height: 225px;">\n\
							<span id="stillcut_lb_img"><img style="width: 362px; height: 202px;"></span>\n\
							<span id="stillcut_lb_text"></span>\n\
						</li>\n\
					</ul>\n\
				</div>\n\
				<div class="label_bot"><img src="img/label_bot.png"></div>';
				
				var box_content = '\n\
				<div id="stillcut_'+item+'_process" class="process"></div>\n\
				<div id="stillcut_'+item+'" class="label stillcut">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat">\n\
							<span id="stillcut_lb_img"></span>\n\
						</li>\n\
					</ul>\n\
				</div>\n\
				<div class="label_bot"><img src="img/label_bot.png"></div>';
				
				arr_sub_rtu[item]['marker'] = new naver.maps.Marker({
					position: new naver.maps.LatLng(arr_sub_rtu[item]['WR_X_POINT'], arr_sub_rtu[item]['WR_Y_POINT']),
					zIndex: 2,
					draggable: false
				});
				arr_sub_rtu[item]['overlay'] = new CustomOverlay({
					position: new naver.maps.LatLng(arr_sub_rtu[item]['WR_X_POINT'], arr_sub_rtu[item]['sub_Y_point']),
					zIndex: 1,
					content: box_content,
					//xAnchor: 181,
					//yAnchor: 302
					xAnchor: 55,
					yAnchor: 111
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
						url: "img/icon_s_07.png",
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
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("8", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 스틸컷 버튼 선택
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
    			}else{
    				arr_sub_rtu[item]['marker'].setVisible(false);
    				arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					arr_sub_rtu[item]['overlay'].setYAnchor(76);
					$("#stillcut_"+item).css("height", "28px");
					$("#stillcut_"+item+" .btn_shot").hide();
				}else{
					//arr_sub_rtu[item]['overlay'].setYAnchor(302);
					arr_sub_rtu[item]['overlay'].setYAnchor(132);
					$("#stillcut_"+item).css("height", "");
					$("#stillcut_"+item+" .btn_shot").show();
				}
				
				// 이벤트
				$(document).on("click", "#stillcut_"+item, function(e){
					if( $(e.target).attr("class") == "btn_shot" ) return false; // 촬영 버튼 클릭 시
					if(map_kind == 1){
						slide_on("stillcut", arr_sub_rtu[item]['area_code']);
					}else if(map_kind == 2){
						slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
					}
				});
				$(document).on("mouseover", "#stillcut_"+item, function(){
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
				
				// 촬영 버튼 > 슬라이드로 이동
				$(document).on("click", "#stillcut_"+item+" .btn_shot", function(){
					if(map_kind == 1){
					    $.post( "controll/stillcut.php", { "mode" : "playstart", "area_code" : arr_sub_rtu[item]['area_code'] }, function(response){
					    	console.log(response);
						}, "json");      
					}
				});
			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("8", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, 방송 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_sub_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_07.png"){
							arr_sub_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_07.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_sub_rtu[item]['state']){
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_07_g.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_07_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_07_o.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_07_o.png",
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
						$("#stillcut_"+item).css("height", "28px");
						$("#stillcut_"+item+" .btn_shot").hide();
					}else{
						//arr_sub_rtu[item]['overlay'].setYAnchor(302);
						$("#stillcut_"+item).css("height", "");
						$("#stillcut_"+item+" .btn_shot").show();
					}
				}); // $.each(arr_sub_id, function(index, item) end
				
				if(map_kind == 1){
					$.post( "controll/stillcut.php", { "mode" : "stillcut", "arr_rtu_id" : arr_sub_id }, function(response){
						$.each(response.list, function(index, item){
							if(item.stat_check == 1){
								arr_sub_rtu[item.rtu_id]['state'] = true;
							}else if(item.stat_check == 2){
								arr_sub_rtu[item.rtu_id]['state'] = false;
							}
							
							if(item.camstate == null || item.camstate == 4){
								$("#stillcut_"+item.rtu_id+"_process").empty();
								$("#stillcut_"+item.rtu_id+" #stillcut_lb_img").html(item.stillcut);
								$("#stillcut_"+item.rtu_id+" #stillcut_lb_text").html(item.stillcut_date);
								
								//arr_sub_rtu[item.rtu_id]['overlay'].setYAnchor(302);
								arr_sub_rtu[item.rtu_id]['overlay'].setYAnchor(132);
							}else{
								var tmp_process = '';
								for(var i = 1; i <= 4; i++){
									if(i <= item.camstate){
										tmp_process += '<img src="img/ok.png">';
									}else{
										tmp_process += '<img src="img/ok_n.png">';
									}
								}
								$("#stillcut_"+item.rtu_id+"_process").html(tmp_process);
								$("#stillcut_"+item.rtu_id+" #stillcut_lb_img").html(item.stillcut);
								$("#stillcut_"+item.rtu_id+" #stillcut_lb_text").html(item.stillcut_date);
								
								//arr_sub_rtu[item.rtu_id]['overlay'].setYAnchor(319);
								arr_sub_rtu[item.rtu_id]['overlay'].setYAnchor(149);
							}
						});
					}, "json");
				}else if(map_kind == 2){
					$.post( "controll/stillcut.php", { "mode" : "stillcut", "arr_rtu_id" : arr_sub_id }, function(response){
						$.each(response.list, function(index, item){
							if(item.stat_check == 1){
								arr_sub_rtu[item.rtu_id]['state'] = true;
							}else if(item.stat_check == 2){
								arr_sub_rtu[item.rtu_id]['state'] = false;
							}
						});
					}, "json");
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
	
} // stillcut() end

function stillcut_slide(get_area_code){
	$.post( "controll/stillcut.php", { "mode" : "stillcut_slide", "area_code" : get_area_code }, function(response){
    	//console.log(response);
        var list = response.data;
        var still = list.still; // 스틸컷 데이터
        var still_cnt = list.still.length; // 스틸컷 데이터 개수
        var ltype = list.ltype; // 스틸컷 타입(0:수위, 1:적설, 2:방송)
        var btype = list.btype; // 스틸컷 방송 타입(0:기본, 1:모션인식 포함)
        var graph_leg = []; // 그래프 라벨 배열
        var graph_data = []; // 그래프 데이터 배열
        var time_cnt = 0; // 개수
        var time_sum = 0; // 합계
        var time_max = "-"; // 최고
        var time_min = "-"; // 최저
        var time_avg = "-"; // 평균
        var tmp_name = "";
        var tmp_title = "";
        var tmp_unit = "";
        var tmp_html = "";
        
        tmp_name = decodeURIComponent(list.rtu_name);
        if(ltype){
            tmp_name = (tmp_name.length > 7) ? tmp_name.substring(0, 7)+".." : tmp_name;
        }else{
        	$("#sidr-id-btn_graph_detail").remove();
        	$("#sidr-id-btn_shot").remove();
        	//$("#sidr-id-graph").remove();
            tmp_name = (tmp_name.length > 10) ? tmp_name.substring(0, 10)+".." : tmp_name;
        }
        $("#sidr-id-chart_name").html(tmp_name);
        
    	if(ltype == 0){
    		tmp_title = "수위"; tmp_unit = "(m)";
        	$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=../../rainsv/stc_list.php&num=8");
        }else if(ltype == 1){
        	tmp_title = "적설"; tmp_unit = "(cm)";
        	$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=../../rainsv/stc_list.php&num=8");
        }else if(ltype == 2){
        	tmp_title = "방송"; tmp_unit = "";
        	$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=../../rainsv/stc_list.php&num=8");
        }else{
        	tmp_title = "방송"; tmp_unit = "";
        }
        $("#sidr-id-chart_title").html(tmp_title);
        
    	if(ltype == 0 || ltype == 1 || ltype == 2){
        	tmp_html += '<tr>';
        	tmp_html += '	<th>시간</th>';
        	tmp_html += '	<th>'+tmp_title + tmp_unit+'</th>';
        	tmp_html += '	<th>사진</th>';
        	tmp_html += '</tr>';
    	}else{
        	tmp_html += '<tr>';
        	tmp_html += '	<th>시간</th>';
        	tmp_html += '	<th>방송</th>';
        	tmp_html += '</tr>';
    	}

    	if(still_cnt == 0){
            tmp_html += '<tr>';
            tmp_html += '	<td colspan="3">데이터가 없습니다.</td>';
            tmp_html += '</tr>';
    	}else{
	        $.each(still, function(index, item){
	        	//console.log(item['num'], item['date']);
	            
	        	var tmp_num = Number(item['num']);
	        	var tmp_date = item['date'];
	        	if( ltype == 0 || ltype == 1 ){ 
	        		tmp_date = (tmp_num < 10) ? "0"+item['num'] : item['num'];
	        	}
	        	var tmp_data = item['data'];
	        	if( ltype == 0 || ltype == 1 ) tmp_data = item['data'] == "-" ? "-" : Number(item['data']);
	        	var tmp_img = item['img'];
	        	if( tmp_img.indexOf('\\') != "-1" ) tmp_img = tmp_img.replace(/\\/gi, '/');
	        	
	            graph_leg[tmp_num] = (tmp_num < 10) ? "0"+item['num'] : item['num'];
	            graph_data[tmp_num] = (tmp_data == "-") ? null : tmp_data;
	            
	            if(tmp_data != "-"){
	            	time_cnt += 1;
	            	time_sum += tmp_data;
	            	if(time_max == "-"){
	            		time_max = tmp_data;
	            	}else{
	                    time_max = (time_max < tmp_data) ? tmp_data : time_max;
	            	}
	            	if(time_min == "-"){
	            		time_min = tmp_data;
	            	}else{
	            		time_min = (time_min > tmp_data) ? tmp_data : time_min;
	            	}
	            }
	            
	        	tmp_html += '<tr>';
	        	tmp_html += '	<td class="gbg name Lh63">'+tmp_date+'</td>';
	        	tmp_html += '	<td>'+tmp_data+'</td>';
	        	if(ltype == 0 || ltype == 1 || ltype == 2){
		        	tmp_html += '<td>';
		            if(tmp_img != "-"){
		            	tmp_html += '<a href="'+tmp_img+'" class="magnific-popup">';
	        			if(ltype == 2 && btype == 1){
		            		tmp_html += '<img src="img/icon_sview_g.png">';
		            	}else{
		            		tmp_html += '<img src="img/icon_sview.png">';
		            	}
		            	tmp_html += '</a>';
		            }
		            tmp_html += '</td>';
	        	}
	            tmp_html += '</tr>';
	        });
	    	if(ltype == 0 || ltype == 1){
	            time_avg = (time_cnt == 0) ? "-" : (time_sum / time_cnt).toFixedOf(2);
	            
	            tmp_html += '<tr>';
	            tmp_html += '	<td class="gbg name Lh63">최고</td>';
	            tmp_html += '	<td>'+time_max+'</td>';
	            tmp_html += '	<td></td>';
	            tmp_html += '</tr>';
	            tmp_html += '<tr>';
	            tmp_html += '	<td class="gbg name Lh63">최저</td>';
	            tmp_html += '	<td>'+time_min+'</td>';
	            tmp_html += '	<td></td>';
	            tmp_html += '</tr>';
	            tmp_html += '<tr>';
	            tmp_html += '	<td class="gbg name Lh63">평균</td>';
	            tmp_html += '	<td>'+time_avg+'</td>';
	            tmp_html += '	<td></td>';
	            tmp_html += '</tr>';
	    	}
    	}
        $("#sidr-id-graph_tbody").html(tmp_html);
        
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
		
        // 촬영 버튼
        $("#sidr-id-btn_shot").unbind("click").bind("click",function(){
        	console.log(1);
			if(map_kind == 1){
			    $.post( "controll/stillcut.php", { "mode" : "playstart", "area_code" : get_area_code }, function(response){
			    	//console.log(response);
				}, "json");      
			}
        });

        // 그래프 호출
    	if(ltype == 0 || ltype == 1){
    		var CTYPE = (ltype == 0) ? "line" : "bar";
	    	var LEG, DATA = [];		
	        var MAX, MIN, INCRE = null;
	    	
	        LEG = graph_leg;
	        DATA = graph_data;
	        MAX = time_max;
	        MIN = time_min;
	        	
			if( isNaN(MAX) || MAX == 0 ){
	   		 	MAX = 1;
			     MIN = 0;
			     INCRE = 0.2;
	   		}else if(MAX == MIN){
			    INCRE = ((Math.abs(MAX)) / 5).toFixed(2);
			    MAX = Number(MAX) + Number(INCRE);
	        	MIN = Number(MIN) - Number(INCRE);
	   		}else{
			    INCRE = ((Math.abs(MAX) - Math.abs(MIN)) / 5).toFixed(2);
			    MAX = Number(MAX) + Number(INCRE);
	        	MIN = Number(MIN) - Number(INCRE);
	   		}
	   		//console.log("MAX:"+MAX, "MIN:"+MIN, "INC:"+INCRE);
	
			chart = new Chart($("#sidr-id-graph"), {
			    type: CTYPE,
			    data: {
			        labels: LEG,
			        datasets: [{
			            label: tmp_title,
			            data: DATA,
			            backgroundColor: 'rgb(54, 162, 235)',
			            borderColor: 'rgb(54, 162, 235)',
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
	                        ticks: {
	                            //beginAtZero:true,
	                            //suggestedMin: MIN,
	                            suggestedMax: MAX,
	                            stepSize: INCRE
	                        }
			            }]
			        }
			    }
			});
    	}else{
    		$("#sidr-id-graph").remove();
    	}
    }, "json");
	
    // 소수점 자르기
    Number.prototype.toFixedOf = function(n){
    	if(!n || typeof n != "number" || n > 12) return NaN;
    	var reck = 1;
    	for (var i=0; i<n; i++) reck *= 10;
    	return parseInt(this * reck) / reck;
    }
}



