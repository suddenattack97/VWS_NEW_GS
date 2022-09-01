var global_aws_area_code; //이벤트가 등록된 AWS 장비 
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

function aws(kind, arr_area_code){ // AWS - AWS 장비
	// 객체 생성
	if(kind == 1){
		global_aws_area_code = arr_area_code;
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
					var box_content = document.createElement("div"); // 오버레이 팝업설정
					// var tmp_box_content = document.createElement("div");
					var tmp_box_content = "";
					tmp_box_content += '\n\
					<div id="aws_'+item+'" class="label aws">\n\
						<ul>\n\
							<li class="label_top">'+tmp_name+'</li>';
					
					for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
						var tmp_class = ""; 
						if(arr_rtu[item]['sensor_kind'][i] == "flow"){
							tmp_class = "water";
						}else{
							tmp_class = arr_rtu[item]['sensor_kind'][i];
						}
						// var bb = (i == (arr_rtu[item]['sensor_cnt'] - 1)) ? "" : "bb";

						if(arr_rtu[item]['sensor_kind'][i]){
							// console.log(arr_rtu[item]['sensor_kind'][i]);
							if(arr_rtu[item]['sensor_kind'][i] == "snow" || arr_rtu[item]['sensor_kind'][i] == "pres") {
								continue;
							}
							tmp_box_content += '\n\
								<li id="'+arr_rtu[item]['sensor_kind'][i]+'_'+item+'" class="'+tmp_class+' bb">\n\
									<span class="dat_left">&nbsp;</span>\n\
									<span class="dat_right">&nbsp;</span>\n\
								</li>';
						}
					}			
					tmp_box_content += '\n\
						</ul>\n\
					</div>\n\
					<div id="aws_label_'+item+'" class="label_bot"><img src="img/label_bot.png"></div>';
				}
				box_content.innerHTML = tmp_box_content;

				if(!document.getElementById("aws_"+item+"_marker")){
					var marker_content= document.createElement("div"); // 오버레이 팝업설정 
					marker_content.innerHTML+="<div id='aws_"+item+"_marker' style='margin-top:-38px; margin-left: -10px;' class='aws_marker'>\n\
					<img style='-webkit-user-drag: none;' src='img/icon_s_03.png'/></div>";
				}
				var circle_content = document.createElement("div"); // 오버레이 팝업설정 
				circle_content.innerHTML+="<div id='wave_"+item+"' class='chameleon'></div>";



				arr_rtu[item]['marker'] = new ol.Overlay({
					id:item,
					element:marker_content,
					stopEvent : false,
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857'),
					dragging: true
				});

				arr_rtu[item]['overlay'] = new ol.Overlay({
					id:item,
					element:box_content,
					offset: [-55, 0],
					stopEvent : false,
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857')
				});
				circle[item] = new ol.Overlay({
					id:item,
					element: circle_content,
					stopEvent : false,
					position: ol.proj.transform([Number(arr_rtu[item]['y_point']), Number(arr_rtu[item]['x_point'])], 'EPSG:4326', 'EPSG:3857')
				});

				map.addOverlay(arr_rtu[item]['marker']);
				map.addOverlay(arr_rtu[item]['overlay']);
				map.addOverlay(circle[item]);

				if($("#wind_"+item).css('display') == 'none' &&
				$("#damp_"+item).css('display') == 'none' &&
				$("#temp_"+item).css('display') == 'none' &&
				$("#pres_"+item).css('display') == 'none')
				{
					if($("#snow_"+item).css('display') == 'block'){
						$('#rain_'+item).addClass('bb');
					}
				}

				//초기 zindex 셋팅
				$("#aws_"+item).parent().parent().addClass('overlay');
				$("#aws_"+item+"_marker").parent().parent().addClass('marker');
				$(".ol-overlaycontainer .overlay").css('z-index', "110");
				$(".ol-overlaycontainer .marker").css('z-index', "105");
				$("#wave_"+item).hide();

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
						$("#aws_label_"+item).show();
						
						if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
							$("#rain_"+item).show();
						}
						if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
							$("#flow_"+item).show();
						}
						if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
							$("#snow_"+item).show();
						}
						if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
							$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
								$("#"+item2+"_"+item).show();
							});
						}
						
    	    		}else{
						$("#aws_"+item).hide();
						$("#aws_label_"+item).hide();
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
				
				// if(tmp_cnt == 1){
				// 	$("#"+tmp_last+"_"+item).removeClass("bb");
				// }
				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					if(arr_rtu[item]['sensor_kind'][i] == "snow" || arr_rtu[item]['sensor_kind'][i] == "pres") {
						tmp_cnt--;
					}
				}

				var tmp_yAnchor = 0;
				if(tmp_cnt == 1) $("#aws_"+item).css('margin-top','-110px');//tmp_yAnchor = -111;
				else if(tmp_cnt == 2) $("#aws_"+item).css('margin-top','-145px'); //tmp_yAnchor = -146;
				else if(tmp_cnt == 3) $("#aws_"+item).css('margin-top','-180px'); // tmp_yAnchor = -181;
				else if(tmp_cnt == 4) $("#aws_"+item).css('margin-top','-215px'); //tmp_yAnchor = -216;
				else if(tmp_cnt == 5) $("#aws_"+item).css('margin-top','-250px'); //tmp_yAnchor = -251;
				else if(tmp_cnt == 6) $("#aws_"+item).css('margin-top','-285px'); //tmp_yAnchor = -286;
				else if(tmp_cnt == 7) $("#aws_"+item).css('margin-top','-320px'); //tmp_yAnchor = -321;
				else if(tmp_cnt == 8) $("#aws_"+item).css('margin-top','-355px'); //tmp_yAnchor = -356;
				
				// arr_rtu[item]['overlay'].setOffset(tmp_yAnchor);
				
				if(map_kind == 2){
					// arr_rtu[item]['overlay'].setOffset(-76);
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
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
				}else{
					$("#aws_"+item).hide();
					$("#aws_label_"+item).hide();
					$("#aws_"+item+"_marker").hide();
				}
				
				// 이벤트
				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					// 이벤트
					$("#"+arr_rtu[item]['sensor_kind'][i]+"_"+item).on("click" , function(){
						slide_on(this.id.split("_")[0], item);
					});	
					// $(document).on("mouseover", "#"+arr_rtu[item]['sensor_kind'][i]+"_"+item, function(){
					// 	$("#aws_"+item).parent().parent().css('z-index', 120);
					// 	$("#aws_"+item+"_marker").parent().parent().css('z-index', 111);
					// });
					// $(document).on("mouseleave", "#"+arr_rtu[item]['sensor_kind'][i]+"_"+item, function(){
					// 	$("#aws_"+item).parent().parent().css('z-index', 110);
					// 	$("#aws_"+item+"_marker").parent().parent().css('z-index', 105);
					// });
				}
				$(document).on("click", "#aws_"+item, function(){
					if(map_kind == 2){
						slide_on("state", new Array(0, item));
					}
				});
				$(document).on("mouseover", "#aws_"+item, function(){
					$(".ol-overlaycontainer .overlay").css('z-index', "110");
					$(".ol-overlaycontainer .marker").css('z-index', "105");
					$("#aws_"+item).parent().parent().css('z-index', 120);
					$("#aws_"+item+"_marker").parent().parent().css('z-index', 111);
				});
				$(document).on("mouseout", "#aws_"+item, function(){
				});

				marker_el.addEventListener('click', function(){
					if( Number(map_level) < Number(over_level) ){
						// 하나의 오버레이만 띄우도록
						if(map_kind == 2){
							if(over_last != "" && over_last != item){
								arr_rtu[over_last]['overlay_on'] = false;
								$("#aws_"+item).hide();
								$("#aws_label_"+item).hide();
								
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
									$("#rain_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
									$("#flow_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
									$("#snow_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
									$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
										$("#"+item2+"_"+item).hide();
									});
								}
							}
							if(over_sub_last != ""){
								arr_sub_rtu[over_sub_last]['overlay_on'] = false;
								$("#aws_"+item).hide();
								$("#aws_label_"+item).hide();
								
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
									$("#rain_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
									$("#flow_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
									$("#snow_"+item).hide();
								}
								if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
									$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
										$("#"+item2+"_"+item).hide();
									});
								}
								// arr_sub_rtu[over_sub_last]['overlay'].setVisible(false);

							}
							over_last = item;
							over_sub_last = "";
							
							slide_on("state", new Array(0, item));
						}
						if(arr_rtu[item]['overlay_on']){
							$("#aws_"+item).hide();
							$("#aws_labal_"+item).hide();
							
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
								$("#rain_"+item).hide();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
								$("#flow_"+item).hide();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
								$("#snow_"+item).hide();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
								$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
									$("#"+item2+"_"+item).hide();
								});
							}
							arr_rtu[item]['overlay_on'] = false;
						}else{
							$("#aws_"+item).show();
							$("#aws_labal_"+item).show();
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
								$("#rain_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
								$("#flow_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
								$("#snow_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
								$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
									$("#"+item2+"_"+item).show();
								});
							}
							arr_rtu[item]['overlay_on'] = true;
						}
					}


				});
				marker_el.addEventListener('mouseover', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$(".ol-overlaycontainer .overlay").css('z-index', "110");
							$(".ol-overlaycontainer .marker").css('z-index', "105");
							$("#aws_"+item).parent().parent().css('z-index', 120);
							$("#aws_"+item+"_marker").parent().parent().css('z-index', 111);
							$("#aws_"+item).show();
							$("#aws_"+item).next().show();
						}
					}
				});
				marker_el.addEventListener('mouseout', function(){
					if( Number(map_level) < Number(over_level) ){
						if(!arr_rtu[item]['overlay_on']){
							$("#aws_"+item).hide();
							$("#aws_"+item).next().hide();
						}
					}
				});


				// 장비 좌표 이동 기능 - START
				var start_point = "";
				var end_point = "";
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
									url: "http://api.vworld.kr/req/address?service=address&request=getAddress&version=2.0&crs=epsg:4326&point="+point[0][0]+","+point[0][1]+"&format=json&type=both&zipcode=true&simple=false&key="+localStorage.getItem('API_KEY'),
									cache: false,
									dataType: "jsonp",
									success : function(data) {
										var emd;
										if(data.response.result){
											if(data.response.result[0].structure.level4A !== ""){
												if(data.response.result[0].text.indexOf(data.response.result[0].structure.level4A) != -1){
													emd = data.response.result[0].structure.level4A;
												}else{
													if(data.response.result[0].structure.level4L){
														if(data.response.result[0].text.indexOf(data.response.result[0].structure.level4L) != -1){
															emd = data.response.result[0].structure.level4L;
														}
													}
												}
											}else{
												if(data.response.result[0].text.indexOf(data.response.result[0].structure.level4L) != -1){
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
					// $("#aws_"+item).parent().parent().css('z-index', 110);
					// $("#aws_"+item+"_marker").parent().parent().css('z-index', 105);
					if (arr_rtu[item]['marker'].get('dragging') === true) {
						arr_rtu[item]['marker'].setPosition(evt.coordinate);
						arr_rtu[item]['overlay'].setPosition(evt.coordinate);
						circle[item].setPosition(evt.coordinate);
						arr_rtu[item]['overlay'].setOffset([-55, 17]);
						$("#aws_"+item+"_marker").css('margin-top','-20px');
						$("#aws_"+item+"_marker").css('margin-left','-10px');
					}
				});
			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if(arr_area_code){
			$.each(arr_area_code, function(index, item){
				var tmp_cnt = 0;
				var tmp_last = "";


				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){

					$("#aws_"+item).show();
					$("#aws_label_"+item).show();
					$("#aws_"+item+"_marker").show();
					$("#aws_"+item+"_marker img").attr('src','img/icon_s_03.png');
					$("#aws_"+item+" .label_top").css('background','#0ca629 url(img/icon_label_04.png) left top no-repeat');

					tmp_cnt = 0;
					// 상황판이나 장비상태 선택, AWS 버튼 선택
					$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
						$("#"+item2+"_"+item).show(); 
						tmp_arr_area_code[item2].push(item); 
						tmp_cnt++;
						tmp_last = item2;
					});
				}else{
					if($("#wave_"+item).css('display') == 'none'){

						$("#aws_"+item).hide();
						$("#aws_label_"+item).hide();
						$("#aws_"+item+"_marker").hide();

						$("#wind_"+item).hide();
						$("#damp_"+item).hide();
						$("#temp_"+item).hide();
						$("#pres_"+item).hide();
					}
					if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
						// 상황판이나 장비상태 선택, 강우 버튼 선택
						if($("#wave_"+item).css('display') == 'none'){
							$("#aws_"+item).show();
							$("#aws_label_"+item).show();
							$("#aws_"+item+"_marker").show();
	
							$("#rain_"+item).show();
							$("#aws_"+item+"_marker img").attr('src','img/icon_s_01.png');
							$("#aws_"+item+" .label_top").css('background','#2782ff url(img/icon_label_04.png) left top no-repeat');
							 $("#aws_"+item).css('margin-top','-115px');//tmp_yAnchor = -111;

							if( $("#rain_"+item).length != 0 ){
								tmp_arr_area_code['rain'].push(item); 
								tmp_cnt++;
								tmp_last = "rain";
							}
							// $.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
							// 	$("#"+item2+"_"+item).show();
							// });
						}else{
							$("#aws_"+item).show();
							$("#aws_label_"+item).show();
							$("#aws_"+item+"_marker").show();
							$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
								$("#"+item2+"_"+item).hide(); 
								tmp_cnt = 1;
							});
							$("#rain_"+item).show();
						}
	    			}else{
						tmp_arr_area_code['rain'].push(item); // 폴리곤 컬러 변경을 위해
						if($("#wave_"+item).css('display') == 'none'){
							$("#rain_"+item).hide();
						}
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
						if($("#wave_"+item).css('display') == 'none'){
							$("#flow_"+item).hide();
						}
	    			}
					if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
						// 상황판이나 장비상태 선택, 적설 버튼 선택
						if($("#wave_"+item).css('display') == 'none'){
							// $("#aws_"+item).show();
							// $("#aws_label_"+item).show();
							// $("#aws_"+item+"_marker").show();
							// $("#aws_"+item+"_marker img").attr('src','img/icon_s_03.png');
							// $("#aws_"+item+" .label_top").css('background','#0ca629 url(img/icon_label_04.png) left top no-repeat');

							$("#snow_"+item).show();
							for(var i in tmp_arr_area_code){
								if(tmp_arr_area_code[i].length != 0){
									$.post( "controll/snow.php", { "mode" : "snow", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
										$.each(response.list, function(index, item2){
											$("#snow_"+item2.area_code+" .dat_right").html(item2.day);
										});
									}, "json");
								}
							}
							if( $("#snow_"+item).length != 0 ){
								tmp_arr_area_code['rain'].push(item); 
								tmp_cnt++;
								tmp_last = "rain";
							}
							// $.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
							// 	$("#"+item2+"_"+item).show();
							// });
						}else{
							// $("#aws_"+item).show();
							// $("#aws_label_"+item).show();
							// $("#aws_"+item+"_marker").show();
							// $("#aws_"+item+"_marker img").attr('src','img/icon_s_03.png');
							// $("#aws_"+item+" .label_top").css('background','#0ca629 url(img/icon_label_04.png) left top no-repeat');
	
							$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
								$("#"+item2+"_"+item).hide(); 
								tmp_cnt = 1;
							});
							$("#snow_"+item).show();
						}
	    			}else{
						if($("#wave_"+item).css('display') == 'none'){
							$("#snow_"+item).hide();
						}
	    			}
    			}
				
				if(tmp_cnt == 1){
					// $("#"+tmp_last+"_"+item).removeClass("bb");
				}else{
					$("#aws_"+item+" li").not(":first").addClass("bb");
					// $("#"+tmp_last+"_"+item).removeClass("bb");
				}

				for(var i = 0; i < arr_rtu[item]['sensor_cnt']; i++){
					if(arr_rtu[item]['sensor_kind'][i] == "snow" || arr_rtu[item]['sensor_kind'][i] == "pres") {
						tmp_cnt--;
					}
				}

				var tmp_yAnchor = 0;
				if(tmp_cnt == 1) $("#aws_"+item).css('margin-top','-110px');//tmp_yAnchor = -111;
				else if(tmp_cnt == 2) $("#aws_"+item).css('margin-top','-145px'); //tmp_yAnchor = -146;
				else if(tmp_cnt == 3) $("#aws_"+item).css('margin-top','-180px'); // tmp_yAnchor = -181;
				else if(tmp_cnt == 4) $("#aws_"+item).css('margin-top','-215px'); //tmp_yAnchor = -216;
				else if(tmp_cnt == 5) $("#aws_"+item).css('margin-top','-250px'); //tmp_yAnchor = -251;
				else if(tmp_cnt == 6) $("#aws_"+item).css('margin-top','-285px'); //tmp_yAnchor = -286;
				else if(tmp_cnt == 7) $("#aws_"+item).css('margin-top','-320px'); //tmp_yAnchor = -321;
				else if(tmp_cnt == 8) $("#aws_"+item).css('margin-top','-355px'); //tmp_yAnchor = -356;

				if(map_kind == 1){
					if( jQuery.inArray("5", map_data) != "-1" ){
						if( arr_rtu[item]['alert_state'] || arr_rtu[item]['alert_error'][0] ){
							tmp_yAnchor = tmp_yAnchor + 17;
							// arr_rtu[item]['overlay'].setOffset(tmp_yAnchor);
						}else if( !arr_rtu[item]['alert_state'] && !arr_rtu[item]['alert_error'][0] ){
							// arr_rtu[item]['overlay'].setOffset(tmp_yAnchor);
						}
					}else{
						// arr_rtu[item]['overlay'].setOffset(tmp_yAnchor);
					}
				}
				if(map_kind == 2){
					// arr_rtu[item]['overlay'].setOffset(-76);
					if($("#wave_"+item).css('display') == 'none'){
						if( jQuery.inArray("5", map_data) == "-1" ) $("#alarm_"+item).hide();
						if( jQuery.inArray("1", map_data) == "-1" ) $("#rain_"+item).hide();
						if( jQuery.inArray("2", map_data) == "-1" ) $("#flow_"+item).hide();
						if( jQuery.inArray("3", map_data) == "-1" ) $("#snow_"+item).hide();
						$("#wind_"+item).hide();
						$("#damp_"+item).hide();
						$("#temp_"+item).hide();
						$("#pres_"+item).hide();
						$("#aws_"+item).css("height", "28px");
					}
				}
				
				if(tmp_cnt != 0){
					arr_clus_marker.push( arr_rtu[item]['marker'] ); // 클러스터 추가
					
					// $("#aws_"+item).hide();
					// $("#aws_label_"+item).hide();
					// $("#aws_"+item+"_marker").hide();
					
					
					// 줌레벨에 따른 오버레이 표시
					if( Number(map_level) < Number(over_level) ){
						if(arr_rtu[item]['overlay_on']){
							$("#aws_"+item).show();
							$("#aws_label_"+item).show();

							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
								$("#rain_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("2", map_data) != "-1" ){
								$("#flow_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
								$("#snow_"+item).show();
							}
							if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
								$.each(arr_rtu[item]['sensor_kind'], function(index2, item2){
									$("#"+item2+"_"+item).show();
								});
							}

	    	    		}else{
							$("#aws_"+item).hide();
							$("#aws_label_"+item).hide();
	    	    		}
					}else{
		    		}
				}else{
					if($("#wave_"+item).css('display') == 'none'){
						$("#aws_"+item).hide();
						$("#aws_label_"+item).hide();
						$("#aws_"+item+"_marker").hide();
					}
				}
			}); // $.each(arr_area_code, function(index, item) end
			
			if(map_kind != 2){
				for(var i in tmp_arr_area_code){
					if(tmp_arr_area_code[i].length != 0){
						if(i == "alarm"){
							//$.post( "controll/alarm.php", { "mode" : "alarm", "arr_area_code" : tmp_arr_area_code[i], "check" : "aws" }, function(response){
							$.post( "controll/alarm.php", { "mode" : "alarm", "arr_area_code" : tmp_arr_area_code[i], "arr_rtu_id" : tmp_arr_rtu_id, "check" : "aws" }, function(response){
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
										$("#aws_"+item.area_code+"_process").html(tmp_process);
										
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
										$("#aws_"+item.area_code+"_process").empty();
										
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
	}
} // aws() end

function aws_event(area_code,state,level,type) {
	var sensor_type = (type == 0 ? "rain" : (type == 1 ? "flow" : ( type == 2 ? "snow" : (type == 3 ? "aws" : "aws" ))));
	if(state == 1){
		// circle[area_code].setVisible(true);
		if(level == 1){
			if(!$("#wave_"+area_code).hasClass('waves')){
				$("#aws_"+item).parent().parent().css('z-index', 121);
				$("#aws_"+area_code).show();
				$("#aws_"+area_code).next().show();
				$("#aws_"+area_code+"_marker").show();
				$("#aws_"+area_code+"_marker").parent().parent().css('z-index',112);
				$("#aws_"+area_code+" li").show();

				if($("#aws_"+area_code).css('display') == 'block'){
					$("#wave_"+area_code).removeClass('waves2');
					$("#wave_"+area_code).addClass('waves');
					$("#wave_"+area_code).show();
					$("#wave_"+area_code).css('z-index', 101);
				}
			}
		}else if (level == 2){
			if(!$("#wave_"+area_code).hasClass('waves2')){
				$("#aws_"+area_code).parent().parent().css('z-index',121);
				$("#aws_"+area_code).show();
				$("#aws_"+area_code).next().show();
				$("#aws_"+area_code+"_marker").show();
				$("#aws_"+area_code+"_marker").parent().parent().css('z-index', 112);
				$("#aws_"+area_code+" li").show();

				if($("#aws_"+area_code).css('display') == 'block'){
					$("#wave_"+area_code).removeClass('waves');
					$("#wave_"+area_code).addClass('waves2');
					$("#wave_"+area_code).show();
					$("#wave_"+area_code).css('z-index',101);
				}
			}
		}

					$.post( "controll/rain.php", { "mode" : "rain", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							$("#rain_"+area_code+" .dat_right").text(item.day);
						});
					}, "json");

					$.post( "controll/snow.php", { "mode" : "snow", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							$("#snow_"+area_code+" .dat_right").html(item.day);
						});
					}, "json");
					$.post( "controll/wind.php", { "mode" : "wind", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							if(item.day == "-"){
								$("#wind_"+area_code+" .dat_right").html('<span style="font-size: 25px; letter-spacing: 0; font-weight: 600 !important;">-</span>');
							}else{
								$("#wind_"+area_code+" .dat_right").html(item.day);
							}
						});
					}, "json");
					$.post( "controll/damp.php", { "mode" : "damp", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							$("#damp_"+area_code+" .dat_right").html(item.day);
						});
					}, "json");
					$.post( "controll/temp.php", { "mode" : "temp", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							$("#temp_"+area_code+" .dat_right").html(item.day);
						});
					}, "json");
					$.post( "controll/pres.php", { "mode" : "pres", "arr_area_code" : [area_code], "check" : "aws" }, function(response){
						$.each(response.list, function(index, item){
							if(item.day == "-"){
								$("#pres_"+area_code+" .dat_right").html('<span style="font-size: 25px; letter-spacing: 0; font-weight: 600 !important;">-</span>');
							}else{
								$("#pres_"+area_code+" .dat_right").html(item.day);
							}
						});
					}, "json");

		var tmp_cnt = 0;
		if($("#wave_"+area_code).hasClass('waves1') || $("#wave_"+area_code).hasClass('waves2')){
			if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("1", map_data) != "-1" ){
				tmp_cnt++;
			}
			if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("3", map_data) != "-1" ){
				tmp_cnt++;
			}
			if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("4", map_data) != "-1" ){
				tmp_cnt = tmp_cnt + 5;
			}

			if(tmp_cnt == 0) {
				$("#aws_"+area_code).css('margin-top','-285px'); 
				$("#rain_"+area_code).show();
				$("#snow_"+area_code).show();
				$("#wind_"+area_code).show();
				$("#damp_"+area_code).show();
				$("#temp_"+area_code).show();
				$("#pres_"+area_code).show();
			} // 아무것도 선택 안했을 경우
			else if(tmp_cnt == 1) {$("#aws_"+area_code).css('margin-top','-110px');} //tmp_yAnchor = -146;
			else if(tmp_cnt == 2) {$("#aws_"+area_code).css('margin-top','-180px');} //tmp_yAnchor = -146;
			else if(tmp_cnt == 3) {$("#aws_"+area_code).css('margin-top','-215px');} // tmp_yAnchor = -181;
			else if(tmp_cnt == 4) {$("#aws_"+area_code).css('margin-top','-250px');} //tmp_yAnchor = -216;
			else if(tmp_cnt == 5) {$("#aws_"+area_code).css('margin-top','-285px');} //tmp_yAnchor = -251;
			else if(tmp_cnt == 6) {$("#aws_"+area_code).css('margin-top','-320px');} //tmp_yAnchor = -286;
			else if(tmp_cnt == 7) {$("#aws_"+area_code).css('margin-top','-355px');} //tmp_yAnchor = -321;
		}
	}else if(state == 0){
		if($("#aws_"+area_code).css('display') != 'none'){
			$("#wave_"+area_code).removeClass('waves');
			$("#wave_"+area_code).removeClass('waves2');
			$("#wave_"+area_code).hide();
			$("#aws_"+area_code).parent().parent().css('z-index',110);
			$("#aws_"+area_code+"_marker").parent().parent().css('z-index',105);
			// $("#aws_"+area_code).hide();
			// $("#aws_"+area_code).next().hide();
			// $("#aws_"+area_code+"_marker").hide();
		}
	}
}
	