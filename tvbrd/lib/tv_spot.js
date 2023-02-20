function spot(kind){ // 현장중계 - 현장중계만 있는 장비
	// 객체 생성
	if(kind == 1){
		$.post( "controll/spot.php", { "mode" : "spot" }, function(response){
			$.each(response.list, function(index, item){
				arr_spot[item.spot_idx] = [];
				
				// 좌표로 주소 추출
				var tmp_addr_emd = "";
				var tmp_addr_detail = "";
				var tmp_content = "";
				
				if(item.spot_content){
					tmp_content = (item.spot_content.length > 85) ? item.spot_content.substr(0, 85)+".."  : item.spot_content;
				}
/*
				naver.maps.Service.reverseGeocode({
					location: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
				}, function(status, response){
					if(status == naver.maps.Service.Status.OK){
						tmp_addr_emd = response.result.items[0].addrdetail.dongmyun;
						tmp_addr_detail = response.result.items[0].address;
						
						var box_content = '\n\
						<div id="spot_'+item.spot_idx+'" class="label spot">\n\
						<ul>\n\
							<li class="label_top">'+tmp_addr_emd+' '+item.spot_title+'<span class="fR">담당자 : '+item.spot_name+'</span></li>\n\
							<li class="label_dat" style="height: auto;">\n\
								<span class="s_text">'+tmp_addr_detail+' '+tmp_content+'</span>\n\
								<span><img src="'+item.spot_img+'"></span>\n\
								<span>'+item.spot_idate.replace(/-/gi, ".")+'</span>\n\
							</li>\n\
						</ul>\n\
						</div>\n\
						<div class="label_bot"><img src="img/label_bot.png"></div>';
*/
						var box_content = '\n\
						<div id="spot_'+item.spot_idx+'" class="label spot">\n\
						<ul>\n\
							<li class="label_top">'+item.spot_title+'</li>\n\
							<li class="label_dat">\n\
								<span><img src="'+item.spot_img+'"></span>\n\
							</li>\n\
						</ul>\n\
						</div>\n\
						<div class="label_bot"><img src="img/label_bot.png"></div>';
						
						arr_spot[item.spot_idx]['marker'] = new naver.maps.Marker({
							position: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
							zIndex: 2,
							//draggable: true
						});
						arr_spot[item.spot_idx]['overlay'] = new CustomOverlay({
						    position: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
						    zIndex: 1,
							content: box_content,
							//xAnchor: 173
							xAnchor: 55
						});
						arr_spot[item.spot_idx]['overlay_on'] = false;
						
						arr_spot[item.spot_idx]['marker'].setIcon(
							{
								url: "img/icon_s_11.png",
								size: new naver.maps.Size(21, 36)
							}
						);	
						arr_spot[item.spot_idx]['marker'].setMap(map);
						if(isMobile() == false){
							arr_spot[item.spot_idx]['overlay'].setMap(map);
						}
						var tmp_height = Number( arr_spot[item.spot_idx]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
						arr_spot[item.spot_idx]['overlay'].setYAnchor(tmp_height);
						
						// 줌레벨에 따른 오버레이 표시
						if( Number(map_level) < Number(over_level) ){
							if(arr_spot[item.spot_idx]['overlay_on']){
								arr_spot[item.spot_idx]['overlay'].setVisible(true);
		    	    		}else{
		    	    			arr_spot[item.spot_idx]['overlay'].setVisible(false);
		    	    		}
				    		if( Number(map_level) < Number(clus_level) ){
				    			arr_spot[item.spot_idx]['overlay'].setVisible(false);
				    		}
						}
						
						if( map_kind == 1 && jQuery.inArray("9", map_data) != "-1" ){
							// 상황판이나 장비상태 선택, 현장중계 버튼 선택
							arr_clus_marker.push( arr_spot[item.spot_idx]['marker'] ); // 클러스터 추가
		    			}else{
		    				arr_spot[item.spot_idx]['marker'].setVisible(false);
		    				arr_spot[item.spot_idx]['overlay'].setVisible(false);
		    			}
						
						// 이벤트
						$(document).on("click", "#spot_"+item.spot_idx, function(){
							slide_on("spot", item.spot_idx);
						});
						$(document).on("mouseover", "#spot_"+item.spot_idx, function(){
							arr_spot[item.spot_idx]['overlay'].setZIndex(3 + add_zindex);
							add_zindex++;
						});
						naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'click', function(){
							if( Number(map_level) < Number(over_level) ){
								if(arr_spot[item.spot_idx]['overlay_on']){
									arr_spot[item.spot_idx]['overlay'].setZIndex(1);
									arr_spot[item.spot_idx]['overlay'].setVisible(false);
									arr_spot[item.spot_idx]['overlay_on'] = false;
								}else{
									arr_spot[item.spot_idx]['overlay'].setZIndex(3 + add_zindex);
									add_zindex++;
									arr_spot[item.spot_idx]['overlay'].setVisible(true);
									arr_spot[item.spot_idx]['overlay_on'] = true;
								}
							}
						});
						naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'mouseover', function(){
							if( Number(map_level) < Number(over_level) ){
								if(!arr_spot[item.spot_idx]['overlay_on']){
									arr_spot[item.spot_idx]['overlay'].setZIndex(4 + add_zindex);
									add_zindex++;
									arr_spot[item.spot_idx]['overlay'].setVisible(true);
								}
							}
						});
						naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'mouseout', function(){
							if( Number(map_level) < Number(over_level) ){
								if(!arr_spot[item.spot_idx]['overlay_on']){
									arr_spot[item.spot_idx]['overlay'].setZIndex(1);
									arr_spot[item.spot_idx]['overlay'].setVisible(false);
								}
							}
						});
/*
					}
				}); // naver.maps.Service.reverseGeocode
*/
			});
		}, "json");
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( map_kind == 1  && jQuery.inArray("9", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, 현장중계 버튼 선택
			for(var i in arr_spot){
				if(!arr_spot[i]['marker']) continue;
				
				arr_clus_marker.push( arr_spot[i]['marker'] ); // 클러스터 추가
				
				arr_spot[i]['marker'].setVisible(true);
				arr_spot[i]['overlay'].setVisible(true);
				
				// 줌레벨에 따른 오버레이 표시
				if( Number(map_level) < Number(over_level) ){
					if(arr_spot[i]['overlay_on']){
						arr_spot[i]['overlay'].setVisible(true);
		    		}else{
		    			arr_spot[i]['overlay'].setVisible(false);
		    		}
		    		if( Number(map_level) < Number(clus_level) ){
		    			if( !arr_spot[i]['marker'].getVisible() ){
		    				arr_spot[i]['overlay'].setVisible(false);
		    			}
		    		}
				}else{
					arr_spot[i]['overlay'].setZIndex(1);
	    		}
			}
			
			$.post( "controll/spot.php", { "mode" : "spot" }, function(response){
				$.each(response.list, function(index, item){
					if( arr_spot[item.spot_idx] ) return true; // continue;
					
					// 좌표로 주소 추출
					var tmp_addr_emd = "";
					var tmp_addr_detail = "";
					var tmp_content = "";
					
					if(item.spot_content){
						tmp_content = (item.spot_content.length > 85) ? item.spot_content.substr(0, 85)+".."  : item.spot_content;
					}
/*
					naver.maps.Service.reverseGeocode({
						location: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
					}, function(status, response){
						if(status == naver.maps.Service.Status.OK){
							tmp_addr_emd = response.result.items[0].addrdetail.sigugun.split(" ")[1];
							tmp_addr_detail = response.result.items[0].address;
							
							var box_content = '\n\
							<div id="spot_'+item.spot_idx+'" class="label spot">\n\
							<ul>\n\
								<li class="label_top">'+tmp_addr_emd+' '+item.spot_title+'<span class="fR">담당자 : '+item.spot_name+'</span></li>\n\
								<li class="label_dat" style="height: auto;">\n\
									<span class="s_text">'+tmp_addr_detail+' '+tmp_content+'</span>\n\
									<span><img src="'+item.spot_img+'"></span>\n\
									<span>'+item.spot_idate.replace(/-/gi, ".")+'</span>\n\
								</li>\n\
							</ul>\n\
							</div>\n\
							<div class="label_bot"><img src="img/label_bot.png"></div>';
*/
							var box_content = '\n\
							<div id="spot_'+item.spot_idx+'" class="label spot">\n\
							<ul>\n\
								<li class="label_top">'+item.spot_title+'</li>\n\
								<li class="label_dat">\n\
									<span><img src="'+item.spot_img+'"></span>\n\
								</li>\n\
							</ul>\n\
							</div>\n\
							<div class="label_bot"><img src="img/label_bot.png"></div>';
							
							arr_spot[item.spot_idx] = [];
							arr_spot[item.spot_idx]['marker'] = new naver.maps.Marker({
								position: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
								zIndex: 2,
								//draggable: true
							});
							arr_spot[item.spot_idx]['overlay'] = new CustomOverlay({
							    position: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
							    zIndex: 1,
								content: box_content,
								//xAnchor: 173
								xAnchor: 55
							});
							arr_spot[item.spot_idx]['overlay_on'] = false;
							
							arr_spot[item.spot_idx]['marker'].setIcon(
								{
									url: "img/icon_s_11.png",
									size: new naver.maps.Size(21, 36)
								}
							);	
							arr_spot[item.spot_idx]['marker'].setMap(map);
							if(isMobile() == false){
								arr_spot[item.spot_idx]['overlay'].setMap(map);
							}
							var tmp_height = Number( arr_spot[item.spot_idx]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
							arr_spot[item.spot_idx]['overlay'].setYAnchor(tmp_height);
							
							// 줌레벨에 따른 오버레이 표시
							if( Number(map_level) < Number(over_level) ){
								if(arr_spot[item.spot_idx]['overlay_on']){
									arr_spot[item.spot_idx]['overlay'].setVisible(true);
			    	    		}else{
			    	    			arr_spot[item.spot_idx]['overlay'].setVisible(false);
			    	    		}
					    		if( Number(map_level) < Number(clus_level) ){
					    			arr_spot[item.spot_idx]['overlay'].setVisible(false);
					    		}
							}
							
							// 이벤트
							$(document).on("click", "#spot_"+item.spot_idx, function(){
								slide_on("spot", item.spot_idx);
							});
							$(document).on("mouseover", "#spot_"+item.spot_idx, function(){
								arr_spot[item.spot_idx]['overlay'].setZIndex(3 + add_zindex);
								add_zindex++;
							});
							naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'click', function(){
								if( Number(map_level) < Number(over_level) ){
									if(arr_spot[item.spot_idx]['overlay_on']){
										arr_spot[item.spot_idx]['overlay'].setZIndex(1);
										arr_spot[item.spot_idx]['overlay'].setVisible(false);
										arr_spot[item.spot_idx]['overlay_on'] = false;
									}else{
										arr_spot[item.spot_idx]['overlay'].setZIndex(3 + add_zindex);
										add_zindex++;
										arr_spot[item.spot_idx]['overlay'].setVisible(true);
										arr_spot[item.spot_idx]['overlay_on'] = true;
									}
								}
							});
							naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'mouseover', function(){
								if( Number(map_level) < Number(over_level) ){
									if(!arr_spot[item.spot_idx]['overlay_on']){
										arr_spot[item.spot_idx]['overlay'].setZIndex(4 + add_zindex);
										add_zindex++;
										arr_spot[item.spot_idx]['overlay'].setVisible(true);
									}
								}
							});
							naver.maps.Event.addListener(arr_spot[item.spot_idx]['marker'], 'mouseout', function(){
								if( Number(map_level) < Number(over_level) ){
									if(!arr_spot[item.spot_idx]['overlay_on']){
										arr_spot[item.spot_idx]['overlay'].setZIndex(1);
										arr_spot[item.spot_idx]['overlay'].setVisible(false);
									}
								}
							});
/*							
						}
					}); // naver.maps.Service.reverseGeocode
*/					
				});
				
				// 없어진 현장 중계 마커 제거
				var tmp_spot = [];
				$.each(response.list, function(index, item){
					tmp_spot[index] = item.spot_idx;
				});
				for(var i in arr_spot){
					if( jQuery.inArray(i, tmp_spot) != "-1" ){
						// 존재
					}else{
						// 미존재
						//console.log("현장중계 제거: "+i);
						arr_spot[i]['marker'].setMap(null);
						arr_spot[i]['overlay'].setMap(null);
						delete arr_spot[i];
					}
				}
			}, "json");

		}else{
			for(var i in arr_spot){
				if(!arr_spot[i]['marker']) continue;
				
				arr_spot[i]['marker'].setVisible(false);
				arr_spot[i]['overlay'].setVisible(false);
			}
		}
	}
	
} // spot() end

function spot_slide(){
	$("#sidr-id-spot_detail").attr("href", "../disos/monitoring/main.php?url=tms_spot.php&num=1");
	
	$.post( "controll/spot.php", { "mode" : "spot_slide" }, function(response){
		var txt = '';
		$.each(response.list, function(index, item){
			// 좌표로 주소 추출
			var tmp_addr_emd = "";
			var tmp_content = "";
			
			if(item.spot_content){
				tmp_content = (item.spot_content.length > 85) ? item.spot_content.substr(0, 85)+".."  : item.spot_content;
			}
			
			txt += '<li>\n\
			    		<div class="sidr-class-real_top">\n\
				  			<span class="sidr-class-real_title">\n\
								<span id="spot_span_'+item.spot_idx+'"></span> '+item.group_name+' - '+item.spot_title+'\n\
							</span>\n\
				  			<span class="sidr-class-real_date">'+item.spot_idate.replace(/-/gi, ".")+'</span>\n\
				  		</div>\n\
				  		<div class="sidr-class-real_con">\n\
				  			<span class="sidr-class-fL sidr-class-w30 sidr-class-mR10">\n\
				  			<a href="'+item.spot_img+'" class="magnific-popup" style="text-decoration:none;border:0;outline:none;">\n\
				  			<img src="'+item.spot_img+'" width="110px" height="80px" />\n\
				  			</a>\n\
				  			</span>\n\
				  			<span class="sidr-class-fL sidr-class-w65">'+tmp_content+'<br /><b>담당자 : '+item.spot_name+'</b></span>\n\
				  		</div>\n\
				  	</li>';
			
			naver.maps.Service.reverseGeocode({
				location: new naver.maps.LatLng(item.spot_x_point, item.spot_y_point),
			}, function(status, response){
				if(status == naver.maps.Service.Status.OK){
					tmp_addr_emd = response.result.items[0].addrdetail.sigugun.split(" ")[1];
					$("#spot_span_"+item.spot_idx).html(tmp_addr_emd);
				}
			}); // naver.maps.Service.reverseGeocode
		});
		$("#sidr-id-spot_wrap").html(txt);

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
	}, "json");
} // spot_slide() end

$(document).on("click", "#sidr-id-btn_spot_refresh", function(){
	slide_on("spot", null);
});


