function aws(kind, arr_area_code){ // 강우 - 강우만 있는 장비
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
				if(!document.getElementById("aws_"+item)){
					var box_content= document.createElement("div"); // 오버레이 팝업설정 
					box_content.innerHTML+="<div id='aws_"+item+"_process' class='process'></div>\n\
					<div id='aws_"+item+"' class='label aws'>\n\
						<ul>\n\
							<li class='label_top'>"+tmp_name+"</li>';";

					for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
						var tmp_class = ""; 
						if(arr_rtu[item]['sensor_kind'][i] == "alarm"){
							tmp_class = "alert";
						}else if(arr_rtu[item]['sensor_kind'][i] == "flow"){
							tmp_class = "water";
						}else{
							tmp_class = arr_rtu[item]['sensor_kind'][i];
						}
						var bb = (i == (arr_rtu[item]['sensor_cnt'] - 1)) ? "" : "bb";
						if(arr_rtu[item]['sensor_kind'][i]){
							box_content.innerHTML += '\n\
								<li id="'+arr_rtu[item]['sensor_kind'][i]+'_'+item+'" class="'+tmp_class+' '+bb+'">\n\
									<span class="dat_left">&nbsp;</span>\n\
									<span class="dat_right">&nbsp;</span>\n\
								</li>';
						}
					}			
					box_content.innerHTML += '\n\
						</ul>\n\
					</div>\n\
					<div id="label_bot_'+item+'" class="label_bot"><img src="img/label_bot.png"></div>';
				}
				

				
				if(!document.getElementById("aws_"+item+"_marker")){
					var marker_content= document.createElement("div"); // 오버레이 팝업설정 
					marker_content.innerHTML+="<div id='aws_"+item+"_marker' style='margin-top:-38px; margin-left: -10px;' class=''><img style='cursor:pointer; -webkit-user-drag: none;' src='img/icon_s_03.png'/></div>";
				}
				arr_rtu[item]['marker'] = new ol.Overlay({
					id:item,
					element:marker_content,
					// offset: [-10, -38],
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857'),
					dragging: true
				});

				arr_rtu[item]['overlay'] = new ol.Overlay({
						id:item,
						element:box_content,
						offset: [-55, -110],
						position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857')
				});

				//////////////////////////////////////////////// 오버레이 생성 끝
				
				// map.addLayer(arr_rtu[item]['marker']);
				map.addOverlay(arr_rtu[item]['marker']);
				map.addOverlay(arr_rtu[item]['overlay']);
				
				arr_rtu[item]['overlay_on'] = false;
				arr_rtu[item]['state'] = true;
				arr_rtu[item]['line'] = true;
				arr_rtu[item]['alert_state'] = false;
				arr_rtu[item]['alert_step'] = 0;
				arr_rtu[item]['alert_error'] = [];
				arr_rtu[item]['alert_error'][0] = false;
				arr_rtu[item]['alert_error'][1] = 0;
				arr_rtu[item]['node_id'] = [];

				var dragPan;

				map.getInteractions().forEach(function(interaction){
					if (interaction instanceof ol.interaction.DragPan) {
						dragPan = interaction;  
				}
				});

				var marker_el = document.getElementById('aws_'+item+'_marker');


				//줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_rtu[item]['overlay_on']){
						$("#aws_"+item).show();
						$("#label_bot_"+item).show();
    	    		}else{
						$("#aws_"+item).hide();
						$("#label_bot_"+item).hide();
						// $("#aws_"+item).next().hide();
    	    		}
		    		if( Number(map_level) < Number(clus_level) ){
						$("#aws_"+item).hide();
						$("#label_bot_"+item).hide();
						// $("#aws_"+item).next().hide();
		    		}
				}
				
				var tmp_cnt = 0;
				var tmp_last = "";
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

				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
					tmp_cnt = 0;
					// 상황판이나 장비상태 선택, AWS 버튼 선택
					$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
						$("#"+item2+"_"+item).show(); 
						tmp_cnt++;
						tmp_last = item2;
					});
				}else{
					$("#wind_"+item).hide();
					$("#damp_"+item).hide();
					$("#temp_"+item).hide();
					$("#pres_"+item).hide();
    			}
				
				if(tmp_cnt == 1){
					$("#"+tmp_last+"_"+item).removeClass("bb");
				}
				
				var tmp_yAnchor = 0;
				if(tmp_cnt == 1) tmp_yAnchor = -111;
				else if(tmp_cnt == 2) tmp_yAnchor = -146;
				else if(tmp_cnt == 3) tmp_yAnchor = -181;
				else if(tmp_cnt == 4) tmp_yAnchor = -216;
				else if(tmp_cnt == 5) tmp_yAnchor = -251;
				else if(tmp_cnt == 6) tmp_yAnchor = -286;
				else if(tmp_cnt == 7) tmp_yAnchor = -321;
				else if(tmp_cnt == 8) tmp_yAnchor = -356;
				// arr_rtu[item]['overlay'].setYAnchor(tmp_yAnchor);
				arr_rtu[item]['overlay'].setOffset([-55,tmp_yAnchor]);
				
				if(map_kind == 2){
					arr_rtu[item]['overlay'].setOffset([-55,110]);
					if( jQuery.inArray("5", map_data) == "-1" ) $("#alarm_"+item).hide();
					if( jQuery.inArray("1", map_data) == "-1" ) $("#rain_"+item).hide();
					if( jQuery.inArray("2", map_data) == "-1" ) $("#flow_"+item).hide();
					if( jQuery.inArray("3", map_data) == "-1" ) $("#snow_"+item).hide();
					$("#wind_"+item).hide();
					$("#damp_"+item).hide();
					$("#temp_"+item).hide();
					$("#pres_"+item).hide();
					$("#aws_"+item).css("height", "28px");
				}else{
					$("#aws_"+item).css("height", "");
				}

				if(tmp_cnt != 0){
					// arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				// arr_rtu[item]['marker'].setVisible(false);
    				// arr_rtu[item]['overlay'].setVisible(false);
					// if(map_kind == 2) arr_rtu[item]['polyline'].setVisible(false);
					$("#aws_"+item).hide();
					// $("#aws_"+item).next().hide();
					$("#label_bot_"+item).hide();
					$("#aws_"+item+"_marker").hide();
				}

				// 이벤트
				$("#aws_"+item).on("click" , function(){
					if(map_kind == 1){
						slide_on("aws", item);
					}else if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});	


				// 이벤트
				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					$(document).on("click", "#"+arr_rtu[item]['sensor_kind'][i]+"_"+item, function(){
						var tmp_param = (this.id.split("_")[0] == "alarm") ? arr_rtu[item]['rtu_id'] : item;
						slide_on(this.id.split("_")[0], tmp_param);
					});
					$(document).on("mouseover", "#"+arr_rtu[item]['sensor_kind'][i]+"_"+item, function(){
						// arr_rtu[item]['overlay'].setZIndex(3 + add_zindex);
						// add_zindex++;
						$("#aws_"+item).parent().parent().removeClass('index_down');
						$("#aws_"+item).parent().parent().addClass('index_up');
					});
				}

				$(document).on("mouseover", "#aws_"+item, function(e){
					$("#aws_"+item).parent().parent().removeClass('index_down');
					$("#aws_"+item).parent().parent().addClass('index_up');
					$("#aws_"+item+"_marker").parent().parent().removeClass('index_down');
					$("#aws_"+item+"_marker").parent().parent().addClass('index_up');
				});
				$(document).on("mouseout", "#aws_"+item, function(e){
					$("#aws_"+item).parent().parent().removeClass('index_up');
					$("#aws_"+item).parent().parent().addClass('index_down');
					$("#aws_"+item+"_marker").parent().parent().removeClass('index_up');
					$("#aws_"+item+"_marker").parent().parent().addClass('index_down');
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
									url: "http://api.vworld.kr/req/address?service=address&request=getAddress&version=2.0&crs=epsg:4326&point="+point[0][0]+","+point[0][1]+"&format=json&type=both&zipcode=true&simple=false&key=1EDCB9E6-2E12-3E90-A64E-F363C69E25B3",
									cache: false,
									dataType: "jsonp",
									success : function(data) {
										var emd;
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
									}
								});
						}
					}
				}); // 마커 드래그 이벤트 끝 

				map.on('pointermove', function(evt) {
					if (arr_rtu[item]['marker'].get('dragging') === true) {
						arr_rtu[item]['marker'].setPosition(evt.coordinate);
						arr_rtu[item]['overlay'].setPosition(evt.coordinate);
						$("#aws_"+item).css('margin-top','20px');
						$("#aws_"+item+"_marker").css('margin-top','-20px');
						$("#aws_"+item+"_marker").css('margin-left','-10px');
					}
				});

				marker_el.addEventListener('click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != "" && over_last != item){
								arr_rtu[over_last]['overlay_on'] = false;
								$("#aws_"+item).hide();
								// $("#aws_"+item).next().hide();
								$("#label_bot_"+item).hide();
							}
							if(over_sub_last != ""){
								arr_sub_rtu[over_sub_last]['overlay_on'] = false;
								$("#aws_"+item).hide();
								// $("#aws_"+item).next().hide();
								$("#label_bot_"+item).hide();
							}
							over_last = item;
							over_sub_last = "";

							slide_on("state", new Array(0, item));
						}
						if(arr_rtu[item]['overlay_on']){
							// arr_rtu[item]['overlay'].setZIndex(1);
							$("#aws_"+item).parent().parent().removeClass('index_up');
							$("#aws_"+item).parent().parent().addClass('index_down');
							$("#aws_"+item).hide();
							// $("#aws_"+item).next().hide();
							$("#label_bot_"+item).hide();
							arr_rtu[item]['overlay_on'] = false;
						}else{
							$("#aws_"+item).parent().parent().removeClass('index_down');
							$("#aws_"+item).parent().parent().addClass('index_up');
							$("#aws_"+item).show();
							// $("#aws_"+item).next().show();
							$("#label_bot_"+item).show();
							arr_rtu[item]['overlay_on'] = true;
						}
					}
				});


				marker_el.addEventListener('mouseover', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$("#aws_"+item).parent().parent().removeClass('index_down');
							$("#aws_"+item).parent().parent().addClass('index_up');
							$("#aws_"+item).show();
							// $("#aws_"+item).next().show();
							$("#label_bot_"+item).show();
						}
					}
				});
				marker_el.addEventListener('mouseout', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$("#aws_"+item).parent().parent().removeClass('index_up');
							$("#aws_"+item).parent().parent().addClass('index_down');
							$("#aws_"+item).hide();
							// $("#aws_"+item).next().hide();
							$("#label_bot_"+item).hide();
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

				var tmp_arr_area_code = [];
			var tmp_arr_rtu_id = [];
			tmp_arr_area_code['alarm'] = [];
			tmp_arr_area_code['rain'] = [];
			tmp_arr_area_code['flow'] = [];
			tmp_arr_area_code['snow'] = [];
			tmp_arr_area_code['wind'] = [];
			tmp_arr_area_code['damp'] = [];
			tmp_arr_area_code['temp'] = [];
			tmp_arr_area_code['pres'] = [];

				$.each(arr_area_code, function(index, item){

					var tmp_cnt = 0;
					var tmp_last = "";
					// arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
					if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
						tmp_cnt = 0;
						// 상황판이나 장비상태 선택, AWS 버튼 선택
						$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
							$("#"+item2+"_"+item).show(); 
							tmp_arr_area_code[item2].push(item); 
							tmp_cnt++;
							tmp_last = item2;
						});
					}else{

						$("#aws_"+item).hide();
						// $("#aws_"+item).next().show();
						$("#label_bot_"+item).hide();

						$("#wind_"+item).hide();
						$("#damp_"+item).hide();
						$("#temp_"+item).hide();
						$("#pres_"+item).hide();
						
						if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
							// 상황판이나 장비상태 선택, 강우 버튼 선택
							$("#rain_"+item).show();
							$("#aws_"+item+"_marker").hide();
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
							$("#aws_"+item+"_marker").hide();
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
							$("#aws_"+item+"_marker").hide();
							if( $("#snow_"+item).length != 0 ){
								tmp_arr_area_code['snow'].push(item); 
								tmp_cnt++;
								tmp_last = "snow";
							}
						}else{
							$("#snow_"+item).hide();
						}
					}

					if(tmp_cnt == 1){
						$("#"+tmp_last+"_"+item).removeClass("bb");
					}else{
						$("#aws_"+item+" li").not(":first").addClass("bb");
						$("#"+tmp_last+"_"+item).removeClass("bb");
					}
					
					var tmp_yAnchor = 0;
					if(tmp_cnt == 1) tmp_yAnchor = -111;
					else if(tmp_cnt == 2) tmp_yAnchor = -146;
					else if(tmp_cnt == 3) tmp_yAnchor = -181;
					else if(tmp_cnt == 4) tmp_yAnchor = -216;
					else if(tmp_cnt == 5) tmp_yAnchor = -251;
					else if(tmp_cnt == 6) tmp_yAnchor = -286;
					else if(tmp_cnt == 7) tmp_yAnchor = -321;
					else if(tmp_cnt == 8) tmp_yAnchor = -356;
					
					arr_rtu[item]['overlay'].setOffset([-55,tmp_yAnchor]);
					
					
					if(map_kind == 2){
						arr_rtu[item]['overlay'].setYAnchor(76);
						if( jQuery.inArray("5", map_data) == "-1" ) $("#alarm_"+item).hide();
						if( jQuery.inArray("1", map_data) == "-1" ) $("#rain_"+item).hide();
						if( jQuery.inArray("2", map_data) == "-1" ) $("#flow_"+item).hide();
						if( jQuery.inArray("3", map_data) == "-1" ) $("#snow_"+item).hide();
						$("#wind_"+item).hide();
						$("#damp_"+item).hide();
						$("#temp_"+item).hide();
						$("#pres_"+item).hide();
						$("#aws_"+item).css("height", "28px");
					}else{
						$("#aws_"+item).css("height", "");
					}
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_rtu[item]['overlay_on']){
							$("#aws_"+item).show();
							// $("#aws_"+item).next().show();
							$("#label_bot_"+item).show();
	    	    		}else{
							$("#aws_"+item).hide();
							// $("#aws_"+item).next().hide();
							$("#label_bot_"+item).hide();
	    	    		}
			    		if( Number(map_level) < Number(clus_level) ){
							$("#aws_"+item).hide();
							// $("#aws_"+item).next().hide();
							$("#label_bot_"+item).hide();
			    		}
					}else{
						// arr_rtu[item]['overlay'].setZIndex(add_zindex);
						$("#aws_"+item).parent().parent().removeClass('index_down');
						$("#aws_"+item).parent().parent().addClass('index_up');
		    		}
				}); // $.each(arr_area_code, function(index, item) end
				
				if(map_kind != 2){
					for(var i in tmp_arr_area_code){
						if(tmp_arr_area_code[i].length != 0){
							//console.log(i, tmp_arr_area_code[i]);
							if(i == "rain"){
								rain_ajax[1] = $.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										$("#rain_"+item.area_code+" .dat_right").html(item.day);
										
										var tmp_emd_cd = arr_rtu[item.area_code]['emd_cd'];
										arr_rtu[item.area_code]['rain'] = item.day;
									});
								}, "json");
							}else if(i == "flow"){
								$.post( "controll/flow.php", { "mode" : "flow", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										$("#flow_"+item.area_code+" .dat_right").html(item.day);
									});
								}, "json");
							}else if(i == "snow"){
								$.post( "controll/snow.php", { "mode" : "snow", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										$("#snow_"+item.area_code+" .dat_right").html(item.day);
									});
								}, "json");
							}else if(i == "wind"){
								$.post( "controll/wind.php", { "mode" : "wind", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										if(item.day == "-"){
											$("#wind_"+item.area_code+" .dat_right").html('<span style="font-size: 25px; letter-spacing: 0; font-weight: 600 !important;">-</span>');
										}else{
	//										$("#wind_"+item.area_code+" .dat_right").html(item.deg+", "+item.day);
											$("#wind_"+item.area_code+" .dat_right").html(item.day);
										}
									});
								}, "json");
							}else if(i == "damp"){
								$.post( "controll/damp.php", { "mode" : "damp", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										$("#damp_"+item.area_code+" .dat_right").html(item.day);
									});
								}, "json");
							}else if(i == "temp"){
								$.post( "controll/temp.php", { "mode" : "temp", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										$("#temp_"+item.area_code+" .dat_right").html(item.day);
									});
								}, "json");
							}else if(i == "pres"){
								$.post( "controll/pres.php", { "mode" : "pres", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
									$.each(response.list, function(index, item){
										if(item.day == "-"){
											$("#pres_"+item.area_code+" .dat_right").html('<span style="font-size: 25px; letter-spacing: 0; font-weight: 600 !important;">-</span>');
										}else{
											$("#pres_"+item.area_code+" .dat_right").html(item.day);
										}
									});
								}, "json");
							}
						}
					} // for(var i in tmp_arr_area_code) end
				}
			
			}
		}else{

		}
	}
	
} // aws() end


