function farm(kind, arr_farm, ani_kind){ // 축산
	// 객체 생성
	console.log(ani_kind);
	var map_kind = 1;
	var arr_sub_id = arr_farm['sub_id'];

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
				<div id="farm_'+item+'_process" class="process"></div>\n\
				<div id="farm_'+item+'" class="label farm">\n\
					<ul>\n\
						<li class="label_top">'+tmp_name+'</li>\n\
						<li class="label_dat">\n\
							<span id="farm_lb_img"></span>\n\
						</li>\n\
					</ul>\n\
				</div>\n\
				<div class="label_bot"><img src="img/label_bot.png"></div>';
				
				arr_sub_rtu[item]['marker'] = new naver.maps.Marker({
					position: new naver.maps.LatLng(arr_sub_rtu[item]['sub_x_point'], arr_sub_rtu[item]['sub_y_point']),
					zIndex: 2,
					draggable: false
				});

				arr_sub_rtu[item]['marker'].setVisible(false);
						
				arr_sub_rtu[item]['overlay'] = new CustomOverlay({
					position: new naver.maps.LatLng(arr_sub_rtu[item]['sub_x_point'], arr_sub_rtu[item]['sub_y_point']),
					zIndex: 1,
					content: box_content,
					//xAnchor: 181,
					//yAnchor: 302
					xAnchor: 55,
					yAnchor: 111
				});

				arr_sub_rtu[item]['overlay'].setVisible(false);
				
				arr_sub_rtu[item]['polyline'] = new naver.maps.Polyline({
					path: new Array( sig_marker.getPosition(), arr_sub_rtu[item]['marker'].getPosition() ),
					zIndex: 1,
				    strokeWeight: 2,
				    strokeColor: "#4C4C4C",
				    strokeOpacity: 1,
				    strokeStyle: 'dashed'
				});
				//arr_sub_rtu[item]['overlay_on'] = false;
				arr_sub_rtu[item]['state'] = true;

				arr_sub_rtu[item]['marker'].setIcon(
					{
						url: "img/icon_s_17.png",
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
				
				if( (map_kind == 1 || map_kind == 2) ){
					// 상황판이나 장비상태 선택, 스틸컷 버튼 선택
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					$(".popuplayer").css("top",'-880px');
    			}else{
    				arr_sub_rtu[item]['marker'].setVisible(false);
    				arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					arr_sub_rtu[item]['overlay'].setYAnchor(76);
					$("#farm_"+item).css("height", "28px");
					$("#farm_"+item+" .btn_shot").hide();
				}else{
					//arr_sub_rtu[item]['overlay'].setYAnchor(302);
					arr_sub_rtu[item]['overlay'].setYAnchor(112);
					$("#farm_"+item).css("height", "");
					$("#farm_"+item+" .btn_shot").show();
				}
				
				
				// 이벤트
				$(document).on("click", "#farm_"+item, function(e){
					if(map_kind == 1){
						slide_on("farm", arr_sub_rtu[item]['license_num']);
					}else if(map_kind == 2){
						slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
					}
				});


				/*******마커위에 마우스를 올렸을때 인덱스 상승 ***********/
				$(document).on("mouseover", "#farm_"+item, function(){
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
								var tmp_sig = response.result.items[0].addrdetail.sigugun;
								var tmp_emd = response.result.items[0].addrdetail.dongmyun;
								var tmp_name = new Array(tmp_sig, tmp_emd);
							}
							$.post( "controll/tutor.php", { "mode" : "rtu_move_check", "name" : tmp_name }, function(response2){
								if(response2.check){
									$.post( "controll/tutor.php", { "mode" : "farm_rtu_move", "sub_id" : sub_id, "point" : point }, function(response3){
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
											$.post( "controll/tutor.php", { "mode" : "farm_rtu_move", "sub_id" : sub_id, "point" : point }, function(response3){
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
		if( (map_kind == 1 || map_kind == 2) ){
			$(".popup").css("top",'-880px');
			// 상황판이나 장비상태 선택, 방송 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){

					if(arr_sub_rtu[item]['animal_kind'] == ani_kind){

					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_17.png"){

						}
					}else if(map_kind == 2){
						if(arr_sub_rtu[item]['state']){
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_17.png"){

							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_17.png"){

							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#F10000" });
						}
					}
					
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
						$("#farm_"+item).css("height", "28px");
						$("#farm_"+item+" .btn_shot").hide();
					}else{

						$("#farm_"+item).css("height", "");
						$("#farm_"+item+" .btn_shot").show();
					}

					arr_sub_rtu[item]['marker'].setVisible(true);
					arr_sub_rtu[item]['overlay'].setVisible(true);

					} else {
						arr_sub_rtu[item]['marker'].setVisible(false);
						arr_sub_rtu[item]['overlay'].setVisible(false);

					}//animal_kind end

				}); // $.each(arr_sub_id, function(index, item) end
				
				if(map_kind == 1){
					farm_ajax[0] = $.post( "controll/farm.php", { "mode" : "farm", "arr_sub_id" : arr_sub_id }, function(response){
						$.each(response.total, function(index, item){
							$("#total").text(item.farmtotal);
							$("#count").text(item.farmcount);
						});

						$.each(response.list, function(index, item){

							var kind2 ="";
							$("#farm_"+item.sub_id+" .label_dat").html(item.day);


							
							arr_sub_rtu[item.sub_id]['marker'].setIcon(
								{
									url: "img/icon_s_17.png",
									size: new naver.maps.Size(21, 36)
								}
							);


							if(arr_sub_rtu[item.sub_id]['BUSINESS_STATE'] == "1"){
								arr_sub_rtu[item.sub_id]['marker'].setIcon(
									{
										url: "img/icon_s_06_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}

							if(item.state == "1"){
								arr_sub_rtu[item.sub_id]['marker'].setIcon(
									{
										url: "img/icon_s_18.png",
										size: new naver.maps.Size(21, 36)
									}
								);

								arr_sub_rtu[item.sub_id]['marker'].setZIndex(10);
								(item.kind == 0 ? kind = "#cow_" : (item.kind == 1 ? kind = "#pig_" : (item.kind == 2 ? kind = "#chicken_" : "")));  //동물 종류
								(item.kind == 0 ? kind2 = "01" : (item.kind == 1 ? kind2 = "03" : (item.kind == 2 ? kind2 = "02" : "")));   // 이미지 KIND 종류
								$(kind+item.sub_id).attr("src", "img/icon_farm_"+kind2+".png");
							}
							
						});
						


						
					}, "json");
					
				}else if(map_kind == 2){
					$.post( "controll/farm.php", { "mode" : "farm", "arr_sub_id" : arr_sub_id }, function(response){
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



function farm_slide(arr_sub_id){
	$.post( "controll/farm.php", { "mode" : "farm_slide", "arr_sub_id" : arr_sub_id }, function(response){
		//console.log(response);
		var list = response.data;
		var farm = list.farm;
		var disease = list.disease;
		var sdate = getTimeStamp();

		var day = new Date();
		var dd = day.getDate();
		//var afterdd = day.getDate()+7;
		var afterdd = '2099-12-31';
		var mm = day.getMonth()+1; //January is 0!
		var yyyy = day.getFullYear();
		var H = day.getHours();
		var M = day.getMinutes();
		var S = day.getSeconds();
		var today = yyyy+"-"+mm+"-"+dd;
		var afterday = afterdd;

		$("#sidr-id-btn_farm_detail").attr("href", "../divas/monitoring/main.php?url=farm_hist.php&num=8");

		datepicker(3, "#sidr-id-starttime", "../divas/images/icon_cal_r.png", "yy-mm-dd");
		datepicker(3, "#sidr-id-endtime", "../divas/images/icon_cal.png", "yy-mm-dd");

		/**** 캘린더 함수 호출 ****/
		$("#sidr-id-starttime_sub").timepicker({
			step: 5,            //시간간격 : 5분
			timeFormat: "H:i:s"    //시간:분 으로표시
			});
		$("#sidr-id-endtime_sub").timepicker({
			step: 5,            //시간간격 : 5분
			timeFormat: "H:i:s"    //시간:분 으로표시
			});	

		// /**** 종료일 없음 선택시 비활성화 ****/
		// $("#sidr-id-empty").click(function(){
		// if($("#sidr-id-empty").is(":checked") == true){
		// 	$("#sidr-id-endtime").attr("readonly",true).attr("disabled",true);
		// 	$("#sidr-id-endtime_sub").attr("readonly",true).attr("disabled",true);
		// 	$("#sidr-id-endtime").val("9999-01-01");
		// 	$("#sidr-id-endtime_sub").val("00:00:00");
		// }else{
		// 	$("#sidr-id-endtime").attr("readonly",false).attr("disabled",false);
		// 	$("#sidr-id-endtime_sub").attr("readonly",false).attr("disabled",false);
		// 	$("#sidr-id-endtime").val("0000-00-00");
		// 	$("#sidr-id-endtime_sub").val("00:00:00");
		// 	}
		// });


		/**** 체크박스 선택시 오늘 날짜로 변경 ****/
		$("#sidr-id-ANIMAL_TYPE").change(function(){
			if($("#sidr-id-ANIMAL_TYPE").val() !== 0){
				var sdate = getTimeStamp();
				$("#sidr-id-starttime").val(sdate.substr(0,10));
			}
		});



		$.each(farm, function (index, v) {
			if(v['LICENSE_NUM'] == arr_sub_id){
				
				$("#sidr-id-FARM_ID").val(v['NUM']);

				$(".sidr-class-slider_type").text(v['BUSINESS_NAME']+" 농가");
				$("#sidr-id-BUSINESS_NAME").text(v['BUSINESS_NAME']);
				$("#sidr-id-ANIMAL_KIND").text( 
				(v['ANIMAL_KIND1'] == 0 ? "소" : (v['ANIMAL_KIND1'] == 1 ? "돼지" : (v['ANIMAL_KIND1'] == 2 ? "닭" : 
				(v['ANIMAL_KIND1'] == 3 ? "돼지,닭" : (v['ANIMAL_KIND1'] == 4 ? "소,닭" : (v['ANIMAL_KIND1'] == 5 ? "소,돼지" : (v['ANIMAL_KIND1'] == 6 ? "소,돼지,닭" : "" )))))))
				);
				$("#sidr-id-COPR_NAME").text(v['COPR_NAME']);
				$("#sidr-id-COPR_NUM").text(v['COPR_NUM']);
				$("#sidr-id-COPR_ADDRESS").text("("+v['COPR_ADDRESS1']+")  "+v['COPR_ADDRESS2']);
				$("#sidr-id-BUSINESS_ADDRESS1").text("("+v['BUSINESS_ADDRESS1']+")  "+v['BUSINESS_ADDRESS2']);
				$("#sidr-id-ANIMAL_COUNT").text(v['ANIMAL_COUNT']+"마리");
				$("#sidr-id-AREA_CODE").text(v['AREA_CODE']);
				$("#sidr-id-BUSINESS_STATE").text((v['BUSINESS_STATE'] == 0 ? "정상" : (v['BUSINESS_STATE'] == 1 ? "폐업" :"")));
				$("#sidr-id-SMART_MOBILE").text(v['SMART_MOBILE']);
				//$("#sidr-id-DISEASE_STATE").text(v['SUB']);

				if(v['SUB'] == "X"){
				$("#sidr-id-DISEASE_STATE").text("미발생");
				}else{
				$("#sidr-id-DISEASE_STATE").text("발생");
				}

				$(".sidr-class-popup_img").empty();
				$(".sidr-class-popup_img").append(
				(v['ANIMAL_KIND1'] == 0 ? "<img class='farm_img' id='slide_cow_"+ v['NUM'] +"' src='./img/icon_farm_04.png'>" : 
				(v['ANIMAL_KIND1'] == 1 ? "<img class='farm_img' id='slide_pig_"+ v['NUM'] +"' src='./img/icon_farm_06.png'>" : 
				(v['ANIMAL_KIND1'] == 2 ? "<img class='farm_img' id='slide_chicken_"+ v['NUM'] +"' src='./img/icon_farm_05.png'>" : 
				(v['ANIMAL_KIND1'] == 3 ? "<img class='farm_img' id='slide_pig_"+ v['NUM'] +"' src='./img/icon_farm_06.png'><img class='farm_img' id='slide_chicken_"+ v['NUM'] +"' src='./img/icon_farm_05.png'>" : 
				(v['ANIMAL_KIND1'] == 4 ? "<img class='farm_img' id='slide_cow_"+ v['NUM'] +"' src='./img/icon_farm_04.png'><img class='farm_img' id='slide_chicken_"+ v['NUM'] +"' src='./img/icon_farm_05.png'>" : 
				(v['ANIMAL_KIND1'] == 5 ? "<img class='farm_img' id='slide_cow_"+ v['NUM'] +"' src='./img/icon_farm_04.png'><img class='farm_img' id='slide_pig_"+ v['NUM'] +"' src='./img/icon_farm_06.png'>" : 
				(v['ANIMAL_KIND1'] == 6 ? "<img class='farm_img' id='slide_cow_"+ v['NUM'] +"' src='./img/icon_farm_04.png'><img class='farm_img' id='slide_pig_"+ v['NUM'] +"' src='./img/icon_farm_06.png'><img class='farm_img' id='slide_chicken_"+ v['NUM'] +"' src='./img/icon_farm_05.png'>" : "" )))))))
				);



				


			}  // if end
		  // farm each


		//$.each(farm, function (index, v) {
			$.each(disease, function (index, e) {
				if(v['ANIMAL_KIND1'] == 0){kind = "0";}
				if(v['ANIMAL_KIND1'] == 1){kind = "1";}
				if(v['ANIMAL_KIND1'] == 2){kind = "2";}		
				if(v['ANIMAL_KIND1'] == 3){kind = "1,2";}
				if(v['ANIMAL_KIND1'] == 4){kind = "0,2";}
				if(v['ANIMAL_KIND1'] == 5){kind = "0,1";}
				if(v['ANIMAL_KIND1'] == 6){kind = "0,1,2";}

				if(kind.indexOf(e['KIND']) == false){
					//console.log(2);
					if(e['END_TIME'] > sdate){
						//console.log(1);
						
						(e['KIND'] == 0 ? kind="slide_cow_" : (e['KIND'] == 1 ?  kind="slide_pig_" : (e['KIND'] == 2 ? kind="slide_chicken_" : ""))); // 선택한 농가 동물종류
						(e['KIND'] == 0 ? kind2="04" : (e['KIND'] == 1 ?  kind2="06" : (e['KIND'] == 2 ? kind2="05" : ""))); // 선택한 농가에 변경할 이미지 구분
						$("#"+kind+e['FARM_ID']).attr('src','./img/icon_farm_'+kind2+'_1.png'); // 이미지 변경
						
					}else{
						
					}
				}

				});  // disease each

			});
		//});


		/*********************************************************************************************
									    	슬라이드 동물 아이콘 선택
		*********************************************************************************************/
		$(".farm_img").click(function(){
			var SELECT = $('#sidr-id-FARM_ID').val();

			$(".farm_img").css('border','0px solid red');
			$(".farm_img").css('border-radius','0%');
			$("#sidr-id-ANIMAL_TYPE").css('width','300px');
			$(this).css('border','2px solid red');
			$(this).css('border-radius','5%');

			var gubun = $(this).attr('src');

			/****************셀렉트박스 선택 시 선택한 값이 등록된 질병일 경우 시간데이터 *****************/
			$("#sidr-id-ANIMAL_TYPE").change(function(){
				var ANIMAL_TYPE = $("#sidr-id-ANIMAL_TYPE").val();
				var param = "mode=change_check&DISEASE_ID="+ANIMAL_TYPE+"&FARM_ID="+SELECT;
				$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.list){
							$.each(data.list, function (index, v) {
									if(SELECT == v['FARM_ID']){
										if(ANIMAL_TYPE == v['DISEASE_IDX']){
											//console.log(1);
											$("#sidr-id-starttime").val(v['START_TIME'].substring(0,10));
											$("#sidr-id-starttime_sub").val(v['START_TIME'].substring(11,19));
											$("#sidr-id-endtime").val(v['END_TIME'].substring(0,10));
											$("#sidr-id-endtime_sub").val(v['END_TIME'].substring(11,19));
										
											}
										}
								});
							}
						}});
				});		
			/************************************************************************* *****************/

			if(gubun.match("1")){
				var select = $(this).attr('id');
				var farm_kind = "";
				if(select.match("cow")){farm_kind = 0;}
				if(select.match("pig")){farm_kind = 1;}
				if(select.match("chicken")){farm_kind = 2;}
				
				var param2 = "mode=farm_disease_group";
				$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param2,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.list !== null){
					$.each(data.list, function (index, x) {
						var tmp = "";
						if(x['FARM_ID'] == SELECT){
							if(x['KIND'] == farm_kind){
								if(x['END_TIME'] > sdate){
									
									var param3 = "mode=Diseasekind&kind="+farm_kind;
									$.ajax({
										type: "POST",
										url: "../../divas/_info/json/_set_json.php",
										data: param3,
										cache: false,
										dataType: "json",
										success : function(data){
										$.each(data.list, function (index, e) {	
											
											if(e['KIND'] == farm_kind){
													if(e['END_TIME'] > sdate){
															$("#sidr-id-ANIMAL_TYPE").empty();
															tmp += '<option id="sidr-id-ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
															//$("#ANIMAL_TYPE").html(tmp);
													}
												}
									
									$("#sidr-id-ANIMAL_TYPE").html(tmp);

									//$("#sidr-id-ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
									$("#sidr-id-ANIMAL_TYPE").val(x['DISEASE_IDX']).prop("selected", true);
									$("#sidr-id-FARM_ID").val(SELECT);
									$("#sidr-id-KIND").val(x['KIND']);
									$("#sidr-id-IDX").val(x['IDX']);
									$("#sidr-id-DISEASE_ID").val(e['DISEASE_IDX']);
									$("#sidr-id-starttime").val(x['START_TIME'].substring(0,10));
									$("#sidr-id-starttime_sub").val(x['START_TIME'].substring(11,19));
									$("#sidr-id-endtime").val(x['END_TIME'].substring(0,10));
									$("#sidr-id-endtime_sub").val(x['END_TIME'].substring(11,19));
									$('#sidr-id-POSTTYPE').val("1");

									if($("#sidr-id-endtime").val() == "9999-01-01"){
										$("input:checkbox[id='sidr-id-empty']").prop("checked", true);
										$("#sidr-id-endtime").attr("readonly",true).attr("disabled",true);
										$("#sidr-id-endtime_sub").attr("readonly",true).attr("disabled",true);
									}else{
										$("input:checkbox[id='sidr-id-empty']").prop("checked", false);
										$("#sidr-id-endtime").attr("readonly",false).attr("disabled",false);
										$("#sidr-id-endtime_sub").attr("readonly",false).attr("disabled",false);
									}

											});  // disease each
										}});

									
								}
							}
						}
						});  // disease each

					}else{
						var tmp = "";
						var param3 = "mode=Diseasekind&kind="+farm_kind;
									$.ajax({
										type: "POST",
										url: "../../divas/_info/json/_set_json.php",
										data: param3,
										cache: false,
										dataType: "json",
										success : function(data){
										$.each(data.list, function (index, e) {	
											
											if(e['KIND'] == farm_kind){
													if(e['END_TIME'] > sdate){
															$("#sidr-id-ANIMAL_TYPE").empty();
															tmp += '<option id="sidr-id-ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
															//$("#ANIMAL_TYPE").html(tmp);
													}
												}
									
									$("#sidr-id-ANIMAL_TYPE").html(tmp);

									//$("#sidr-id-ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
									$("#sidr-id-FARM_ID").val(SELECT);
									$("#sidr-id-DISEASE_ID").val(e['DISEASE_IDX']);

									$('#sidr-id-POSTTYPE').val("1");

									if($("#sidr-id-endtime").val() == "9999-01-01"){
										$("input:checkbox[id='sidr-id-empty']").prop("checked", true);
										$("#sidr-id-endtime").attr("readonly",true).attr("disabled",true);
										$("#sidr-id-endtime_sub").attr("readonly",true).attr("disabled",true);
									}else{
										$("input:checkbox[id='sidr-id-empty']").prop("checked", false);
										$("#sidr-id-endtime").attr("readonly",false).attr("disabled",false);
										$("#sidr-id-endtime_sub").attr("readonly",false).attr("disabled",false);
									}

											});  // disease each
										}});
					}
					}});

			}else{
				var select = $(this).attr('id');
				var farm_kind = "";
				if(select.match("cow")){farm_kind = 0;}
				if(select.match("pig")){farm_kind = 1;}
				if(select.match("chicken")){farm_kind = 2;}
				//console.log("미발병");

				var param2 = "mode=farm_disease_group";
				$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param2,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.list !== null){
					$.each(data.list, function (index, x) {
						var tmp = "";
									var param3 = "mode=Diseasekind&kind="+farm_kind;
									$.ajax({
										type: "POST",
										url: "../../divas/_info/json/_set_json.php",
										data: param3,
										cache: false,
										dataType: "json",
										success : function(data){
										$.each(data.list, function (index, e) {	
											
											if(e['KIND'] == farm_kind){
													if(e['END_TIME'] > sdate){
															$("#sidr-id-ANIMAL_TYPE").empty();
															tmp += '<option id="sidr-id-ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
															//$("#ANIMAL_TYPE").html(tmp);
													}
												}
									
									$("#sidr-id-ANIMAL_TYPE").html(tmp);

									//$("#sidr-id-ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
									//$("#sidr-id-ANIMAL_TYPE").val(0).prop("selected", true);
									$("#sidr-id-FARM_ID").val(SELECT);
									$("#sidr-id-KIND").val(x['KIND']);
									$("#sidr-id-IDX").val(x['IDX']);
									$("#sidr-id-DISEASE_ID").val(e['DISEASE_IDX']);
									$("#sidr-id-starttime").val(today);
									$("#sidr-id-starttime_sub").val("00:00:00");
									$("#sidr-id-endtime").val(afterday);
									$("#sidr-id-endtime_sub").val("23:59:59");
									$('#sidr-id-POSTTYPE').val("1");

									if($("#sidr-id-endtime").val() == "9999-01-01"){
										$("input:checkbox[id='sidr-id-empty']").prop("checked", true);
										$("#sidr-id-endtime").attr("readonly",true).attr("disabled",true);
										$("#sidr-id-endtime_sub").attr("readonly",true).attr("disabled",true);
									}else{
										$("input:checkbox[id='sidr-id-empty']").prop("checked", false);
										$("#sidr-id-endtime").attr("readonly",false).attr("disabled",false);
										$("#sidr-id-endtime_sub").attr("readonly",false).attr("disabled",false);
									}

											});  // disease each
										}});
						
						});  // disease each

					}else{
						var tmp = "";
						var param3 = "mode=Diseasekind&kind="+farm_kind;
						$.ajax({
							type: "POST",
							url: "../../divas/_info/json/_set_json.php",
							data: param3,
							cache: false,
							dataType: "json",
							success : function(data){
							$.each(data.list, function (index, e) {	
								
								if(e['KIND'] == farm_kind){
										if(e['END_TIME'] > sdate){
												$("#sidr-id-ANIMAL_TYPE").empty();
												tmp += '<option id="sidr-id-ANIMAL_TYPE" value="'+e['DISEASE_IDX']+'">'+e['DISEASE_NAME']+'</option>';
												//$("#ANIMAL_TYPE").html(tmp);
										}
									}
						
						$("#sidr-id-ANIMAL_TYPE").html(tmp);

						//$("#sidr-id-ANIMAL_TYPE").prepend('<option id="ANIMAL_TYPE" value="0">미발생</option>');
						//$("#sidr-id-ANIMAL_TYPE").val(0).prop("selected", true);
						$("#sidr-id-FARM_ID").val(SELECT);
						$("#sidr-id-DISEASE_ID").val(e['DISEASE_IDX']);
						$("#sidr-id-KIND").val(e['KIND']);
						$("#sidr-id-starttime").val(today);
						$("#sidr-id-starttime_sub").val("00:00:00");
						$("#sidr-id-endtime").val(afterday);
						$("#sidr-id-endtime_sub").val("23:59:59");
						$('#sidr-id-POSTTYPE').val("1");

						if($("#sidr-id-endtime").val() == "9999-01-01"){
							$("input:checkbox[id='sidr-id-empty']").prop("checked", true);
							$("#sidr-id-endtime").attr("readonly",true).attr("disabled",true);
							$("#sidr-id-endtime_sub").attr("readonly",true).attr("disabled",true);
						}else{
							$("input:checkbox[id='sidr-id-empty']").prop("checked", false);
							$("#sidr-id-endtime").attr("readonly",false).attr("disabled",false);
							$("#sidr-id-endtime_sub").attr("readonly",false).attr("disabled",false);
						}

								});  // disease each
							}});
					}
					}});
			}
		}); //farm_img 클릭 이벤트 END




		/*********************************************************************************************
											슬라이드 삭제 버튼
		*********************************************************************************************/
		$("#sidr-id-btn_re").click(function(){
			//popup_close();
			var FARM_ID = $('#sidr-id-FARM_ID').val();
			var DISEASE_ID = $('#sidr-id-ANIMAL_TYPE').val();
			var KIND_CHECK = $('#sidr-id-KIND').val();
			var CHECK_DISEASE = $('#sidr-id-DISEASE_ID').val();
			var POSTTYPE = $('#sidr-id-POSTTYPE').val();
			var starttime = $('#sidr-id-starttime').val();
			var starttime_sub = $('#sidr-id-starttime_sub').val();
			var endtime = $('#sidr-id-endtime').val();
			var endtime_sub = $('#sidr-id-endtime_sub').val();
			var IDX = $("#IDX").val();

			swal({
				title: '<div class="alpop_top_b">발생 질병 해제</div><div class="alpop_mes_b">정말로 질병을 해제하실 겁니까?</div>',
				text: '확인 시 질병이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=hist_empty_up&IDX="+IDX+"&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID;
					$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
					        if(data.result){
			                	//popup_main_close(); // 레이어 좌측 및 상단 닫기
								//location.reload(); return false;
								swal("체크", " 삭제를 완료 했습니다.", "success");
								box_update();
								farm_slide();
							
								arr_sub_rtu[FARM_ID]['marker'].setIcon(
									{
										url: "img/icon_s_17.png",
										size: new naver.maps.Size(21, 36)
									});
									if(KIND_CHECK == 0){KIND_NAME = "cow"; KIND_CHECK="04";}
									if(KIND_CHECK == 1){KIND_NAME = "pig"; KIND_CHECK="06";}
									if(KIND_CHECK == 2){KIND_NAME = "chicken"; KIND_CHECK="05";}
									
									$("#slide_"+KIND_NAME+"_"+FARM_ID).attr('src','./img/icon_farm_'+KIND_CHECK+'.png'); // 이미지 변경

					        }else{
							    swal("체크", "질병 해제 중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		});							


		/*********************************************************************************************
												슬라이드 저장 버튼
		*********************************************************************************************/
		$("#sidr-id-btn_in").click(function(){
			var FARM_ID = $('#sidr-id-FARM_ID').val();
			var DISEASE_ID = $('#sidr-id-ANIMAL_TYPE').val();
			var CHECK_DISEASE = $('#sidr-id-DISEASE_ID').val();
			var POSTTYPE = $('#sidr-id-POSTTYPE').val();
			var starttime = $('#sidr-id-starttime').val();
			var starttime_sub = $('#sidr-id-starttime_sub').val();
			var endtime = $('#sidr-id-endtime').val();
			var endtime_sub = $('#sidr-id-endtime_sub').val();
			var IDX = $("#IDX").val();
			//console.log(DISEASE_ID);
						
			if(DISEASE_ID == 0){                        // ( ★ 삭제 ★ ) 미발생 체크후 저장 했을 경우
				swal({
				title: '<div class="alpop_top_b">발생 질병 삭제</div><div class="alpop_mes_b">정말로 질병을 삭제하실 겁니까?</div>',
				text: '확인 시 질병이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=hist_empty_up&IDX="+IDX+"&FARM_ID="+FARM_ID+"&DISEASE_ID="+CHECK_DISEASE+"&POSTTYPE="+POSTTYPE+"&starttime="+starttime+"&starttime_sub="+
					starttime_sub+"&endtime="+endtime+"&endtime_sub="+endtime_sub;
					$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
					        if(data.result){
			                	//popup_main_close(); // 레이어 좌측 및 상단 닫기
								//location.reload(); return false;
								swal("체크", " 삭제를 완료 했습니다.", "success");
								box_update();
								farm_slide();
							
								arr_sub_rtu[FARM_ID]['marker'].setIcon(
									{
										url: "img/icon_s_17.png",
										size: new naver.maps.Size(21, 36)
									});
								
								
								//console.log(1);
					        }else{
							    swal("체크", "질병 삭제 중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}else{
			var FARM_ID = $('#sidr-id-FARM_ID').val();
			var DISEASE_ID = $('#sidr-id-ANIMAL_TYPE').val();
			var CHECK_DISEASE = $('#sidr-id-DISEASE_ID').val();
			var POSTTYPE = $('#sidr-id-POSTTYPE').val();
			var starttime = $('#sidr-id-starttime').val();
			var starttime_sub = $('#sidr-id-starttime_sub').val();
			var endtime = $('#sidr-id-endtime').val();
			var endtime_sub = $('#sidr-id-endtime_sub').val();

			var param = "mode=data_check&IDX="+IDX+"&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&CHECK_DISEASE="+CHECK_DISEASE+"&POSTTYPE="+POSTTYPE+
			"&starttime="+starttime+"&starttime_sub="+starttime_sub+"&endtime="+endtime+"&endtime_sub="+endtime_sub;
			//console.log($("#set_frm2").serialize());
					$.ajax({
					type: "POST",
					url: "../../divas/_info/json/_set_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
							if(data.list['SUCCESS'] == 1){   // ( ★ 수정 ★ ) 이미 농가에 질병이 등록 되어 있을 경우
								swal({
									title: '<div class="alpop_top_b">발생 질병 수정</div><div class="alpop_mes_b">질병이 등록되어 있습니다.<br>수정 하시겠습니까?</div>',
									text: '확인 시 질병이 수정 됩니다.',
									showCancelButton: true,
									confirmButtonColor: '#5b7fda',
									confirmButtonText: '확인',
									cancelButtonText: '취소',
									closeOnConfirm: false,
									html: true
								}, function(isConfirm){
									if(isConfirm){					
										var param = "mode=hist_up&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&CHECK_DISEASE="+CHECK_DISEASE+"&POSTTYPE="+POSTTYPE+"&starttime="+starttime+"&starttime_sub="+
										starttime_sub+"&endtime="+endtime+"&endtime_sub="+endtime_sub;
										$.ajax({
										type: "POST",
										url: "../../divas/_info/json/_set_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
												if(data.result){
													//popup_main_close(); // 레이어 좌측 및 상단 닫기
													//location.reload(); return false;
													swal("체크", " 수정을 완료 했습니다.", "success");
													box_update();
													farm_slide();
													
													
												}else{
													swal("체크", " 수정 중 오류가 발생 했습니다.", "warning");
												}
											}
										});	
									}
								}); // swal end
							}   // SUCCESS 1 체크 END
						
						 if(data.list['SUCCESS'] == 0){                           // ( ★ 등록 ★ ) 농가에 질병이 등록 되어 있지 않을 경우 

								swal({
									title: '<div class="alpop_top_b">발생 질병 등록</div><div class="alpop_mes_b">정말로 질병을 등록 하시겠습니까?</div>',
									text: '확인 시 질병이 등록 됩니다.',
									showCancelButton: true,
									confirmButtonColor: '#5b7fda',
									confirmButtonText: '확인',
									cancelButtonText: '취소',
									closeOnConfirm: false,
									html: true
								}, function(isConfirm){
									if(isConfirm){

										var param = "mode=hist_in&IDX="+IDX+"&FARM_ID="+FARM_ID+"&DISEASE_ID="+DISEASE_ID+"&CHECK_DISEASE="+CHECK_DISEASE+"&POSTTYPE="+POSTTYPE+"&starttime="+starttime+"&starttime_sub="+
										starttime_sub+"&endtime="+endtime+"&endtime_sub="+endtime_sub;
										
										$.ajax({
										type: "POST",
										url: "../../divas/_info/json/_set_json.php",
										data: param,
										cache: false,
										dataType: "json",
										success : function(data){
												if(data.result){
													//popup_main_close(); // 레이어 좌측 및 상단 닫기
													//location.reload(); return false;
													swal("체크", " 등록을 완료 했습니다.", "success");
													box_update();
													farm_slide();
													
												}else{
													swal("체크", " 등록 중 오류가 발생 했습니다.", "warning");
												}
											}
										});	
									}
								}); // swal end
							} 	// SUCCESS 0 체크 END

							}});
			
		}   // 미발생 체크 else 문 end 

		});




	}, "json");
	}

	
	






	function getTimeStamp() {
		var d = new Date();
	  
		var s =
		  leadingZeros(d.getFullYear(), 4) + '-' +
		  leadingZeros(d.getMonth() + 1, 2) + '-' +
		  leadingZeros(d.getDate(), 2) + ' ' +
	  
		  leadingZeros(d.getHours(), 2) + ':' +
		  leadingZeros(d.getMinutes(), 2) + ':' +
		  leadingZeros(d.getSeconds(), 2);
	  
		return s;
	  }
	
	  function leadingZeros(n, digits) {
		var zero = '';
		n = n.toString();
	  
		if (n.length < digits) {
		  for (i = 0; i < digits - n.length; i++)
			zero += '0';
		}
		return zero + n;
	  }
	
	  function isEmpty(str){
			 
		if(typeof str == "undefined" || str == null || str == "")
			return true;
		else
			return false ;
	}


	function datepicker(type, target, image, format, submit){
		if(type == 1){
			$(target).datepicker({
				showOn: "both",
				buttonImage: image,
				buttonImageOnly: true,
			    changeYear: true,
				changeMonth: true,
				dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], 
				monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
				monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				dateFormat: format, // 'yymmdd'
				//firstDay: '6', 
				//yearRange: 'c-0:c+1',
				minDate: new Date('2010-01-01'),
				maxDate: '0',
				showButtonPanel: true, 
			    nextText: '다음 달',
			    prevText: '이전 달',
				currentText: '처음', 
			    closeText: '닫기',
			    beforeShow: function(input, inst){
			    },
			    onSelect: function(dateText, inst){
		        }
			});
		}else if(type == 2){
			$(target).datepicker({
				showOn: "text",
			    changeYear: true,
				changeMonth: true,
				dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], 
				monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
				monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				dateFormat: format, // 'yymmdd'
				//firstDay: '6', 
				//yearRange: 'c-0:c+1',
				minDate: new Date('2010-01-01'),
				maxDate: '0',
				showButtonPanel: true, 
			    nextText: '다음 달',
			    prevText: '이전 달',
				currentText: '처음', 
			    closeText: '닫기',
			    beforeShow: function(input, inst){
			    },
			    onSelect: function(dateText, inst){
			    	$(submit).submit();
		        }
			});
		}else if(type == 3){
			$(target).datepicker({
				showOn: "both",
				buttonImage: image,
				buttonImageOnly: true,
			    changeYear: true,
				changeMonth: true,
				dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'], 
				monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
				monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				dateFormat: format, // 'yymmdd'
				//firstDay: '6', 
				//yearRange: 'c-0:c+1',
				minDate: new Date('2010-01-01'),
				maxDate: '+1Y',
				showButtonPanel: true, 
			    nextText: '다음 달',
			    prevText: '이전 달',
				currentText: '처음', 
			    closeText: '닫기',
			    beforeShow: function(input, inst){
			    },
			    onSelect: function(dateText, inst){
		        }
			});
		}
	}
