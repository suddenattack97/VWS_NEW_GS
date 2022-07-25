function yebo(kind, arr_area_code){ // 예보
	// 객체 생성
	if(kind == 1){
		if(arr_poly){
			for(var i in arr_poly){ // i = wr_map_info table emd_cd
				// 객체
				var box_content = '\n\
				<div class="fore">\n\
    				<div id="yebo_'+i+'" class="fore_tt">\n\
	    				<div class="fore_tt_top">\n\
	                    	<div class="fore_tt_white"></div>\n\
	                    	<div class="fore_tt_gray"></div>\n\
	                    </div>\n\
	                    <div class="fore_tt_bot">\n\
	                    <ul>\n\
	                    <li id="yebo_li_1">\n\
	                    	<div class="fore_tt_bot_icon"></div>\n\
	                        <div class="fore_tt_bot_temp"></div>\n\
	                        <div class="fore_tt_bot_gray"></div>\n\
	                        <div class="fore_tt_bot_time"></div>\n\
	                     </li>\n\
	                     <li id="yebo_li_2">\n\
	                         <div class="fore_tt_bot_icon"></div>\n\
	                         <div class="fore_tt_bot_temp"></div>\n\
	                         <div class="fore_tt_bot_gray"></div>\n\
	                         <div class="fore_tt_bot_time"></div>\n\
	                     </li>\n\
	                     <li id="yebo_li_3">\n\
	                         <div class="fore_tt_bot_icon"></div>\n\
	                         <div class="fore_tt_bot_temp"></div>\n\
	                         <div class="fore_tt_bot_gray"></div>\n\
	                         <div class="fore_tt_bot_time"></div>\n\
	                     </li>\n\
	                     </ul>\n\
	                     </div>\n\
                     </div>\n\
			         <div class="label_bot"><img src="img/label_bot.png"></div>\n\
		    	</div>';
				
				arr_poly[i]['yebo_marker'] = new naver.maps.Marker({
			    	position: new naver.maps.LatLng(arr_poly[i]['x_cent'], arr_poly[i]['y_cent']),
		    		zIndex: 2
			    });
				arr_poly[i]['yebo_overlay'] = new CustomOverlay({
			    	position: new naver.maps.LatLng(arr_poly[i]['x_cent'], arr_poly[i]['y_cent']),
		    		zIndex: 1,
		    		content: box_content,
					xAnchor: 173,
					yAnchor: 177
			    });
				
				arr_poly[i]['yebo_marker'].setIcon(
					{
						url: "img/icon_s_10.png",
						size: new naver.maps.Size(21, 36)
					}
    			);
    			arr_poly[i]['yebo_marker'].setMap(map);
    			arr_poly[i]['yebo_overlay'].setMap(map);
				
    			if( map_kind == 4 ){
    				// 예보 선택
    			}else{
    				arr_poly[i]['yebo_marker'].setVisible(false);
        			arr_poly[i]['yebo_overlay'].setVisible(false);
    			}
    			
    			// 이벤트
				naver.maps.Event.addDOMListener(document.getElementById("yebo_"+i), 'mousedown', function(e){
					moveCheck = true;
					map.setOptions("draggable", false); // 지도가 움직이지 않도록

					var emd_cd = this.id.split("_")[1];
					var proj = map.getProjection(); // 화면 픽셀 좌표와 좌표간 변환을 위한 MapProjection 객체
				    var overlayPos = arr_poly[emd_cd]['yebo_overlay'].getPosition();
					
				    startOverlayEmd = emd_cd;
				    startX = e.clientX;
				    startY = e.clientY;
					startOverlayPoint = proj.fromCoordToOffset(overlayPos);
				});
				naver.maps.Event.addDOMListener(document.getElementById("yebo_"+i), 'mousemove', function(e){
					if(moveCheck){
						var emd_cd = startOverlayEmd;
					    var proj = map.getProjection(); // 화면 픽셀 좌표와 좌표간 변환을 위한 MapProjection 객체
						
						var deltaX = startX - e.clientX;
						var deltaY = startY - e.clientY;
						var newPoint = new naver.maps.Point(startOverlayPoint.x - deltaX, startOverlayPoint.y - deltaY);
						var newPos = proj.fromOffsetToCoord(newPoint);
						arr_poly[emd_cd]['yebo_overlay'].setPosition(newPos);
					}
				});
			} // for(var i in arr_poly) end
			
			naver.maps.Event.addDOMListener(document, 'mouseup', function(e){
				moveCheck = false;
				map.setOptions("draggable", true); // 다시 지도가 움직이도록
			});
		} // if end
		
	// 업데이트	
	}else if(kind == 2){
		// 표시 여부
		if( map_kind == 4 ){
			// 예보 선택
			if(arr_poly){
				for(var i in arr_poly){ // i = rtu_info table area_code
					arr_poly[i]['yebo_marker'].setVisible(true);
					arr_poly[i]['yebo_overlay'].setVisible(true);
					//console.log(arr_poly[i]['emd_name']);
					$.ajax({
						type : "POST",
				        url : "controll/yebo.php",
				        data : { "mode" : "yebo", "rtu_name" : arr_poly[i]['emd_name'] },
				        dataType : "json",
				        async : false, // 동기: false, 비동기: ture
				        success : function(aresult){
				           if(aresult.result){
				           		title = aresult.data.to_title[0];
				                day_tempnow = aresult.data[0].day_tempnow[0];
				                day_tempmax = aresult.data[0].day_tempmax[0];
				                day_tempmin = aresult.data[0].day_tempmin[0];
				                day_rain = aresult.data[0].day_rain[0];
				                day_weather = aresult.data[0].day_weather[0];
				                day_tommer_hour = aresult.data[0].day_tommer_hour[0];
				                day_icon = aresult.data[0].day_icon;
				                tommer_tempnow = aresult.data[1].tommer_tempnow[0];
				                tommer_tempmax = aresult.data[1].tommer_tempmax[0];
				                tommer_tempmin = aresult.data[1].tommer_tempmin[0];
				                tommer_rain = aresult.data[1].tommer_rain[0];
				                tommer_weather = aresult.data[1].tommer_weather[0];
				                tommer_tommer_hour = aresult.data[1].tommer_tommer_hour[0];
				                tommer_icon = aresult.data[1].tommer_icon;

				                af_tommer_tempnow = aresult.data[2].af_tommer_tempnow[0];
				                af_tommer_tempmax = aresult.data[2].af_tommer_tempmax[0];
				                af_tommer_tempmin = aresult.data[2].af_tommer_tempmin[0];
				                af_tommer_rain = aresult.data[2].af_tommer_rain[0];
				                af_tommer_weather = aresult.data[2].af_tommer_weather[0];
				                af_tommer_hour = aresult.data[2].af_tommer_hour[0];
				                af_tommer_icon = aresult.data[2].af_tommer_icon;
				                
				                $("#yebo_"+i+" .fore_tt_top .fore_tt_white").html(arr_poly[i]['emd_name']);
				                $("#yebo_"+i+" .fore_tt_top .fore_tt_gray").html(title+' 발표');
				                
				                $("#yebo_"+i+" #yebo_li_1 .fore_tt_bot_icon").html('<img src="img/'+day_icon+'.png" alt="'+tommer_weather+'" />');
				                $("#yebo_"+i+" #yebo_li_1 .fore_tt_bot_temp").html(day_tempnow+'℃');
				                $("#yebo_"+i+" #yebo_li_1 .fore_tt_bot_gray").html(day_weather+'<br/>강수확률 '+day_rain+'%');
				                $("#yebo_"+i+" #yebo_li_1 .fore_tt_bot_time").html(day_tommer_hour+'시');
				                
				                $("#yebo_"+i+" #yebo_li_2 .fore_tt_bot_icon").html('<img src="img/'+tommer_icon+'.png" alt="'+tommer_weather+'" />');
				                $("#yebo_"+i+" #yebo_li_2 .fore_tt_bot_temp").html(tommer_tempnow+'℃');
				                $("#yebo_"+i+" #yebo_li_2 .fore_tt_bot_gray").html(tommer_weather+'<br/>강수확률 '+tommer_rain+'%');
				                $("#yebo_"+i+" #yebo_li_2 .fore_tt_bot_time").html(tommer_tommer_hour+'시');
				                
				                $("#yebo_"+i+" #yebo_li_3 .fore_tt_bot_icon").html('<img src="img/'+af_tommer_icon+'.png" alt="'+tommer_weather+'" />');
				                $("#yebo_"+i+" #yebo_li_3 .fore_tt_bot_temp").html(af_tommer_tempnow+'℃');
				                $("#yebo_"+i+" #yebo_li_3 .fore_tt_bot_gray").html(af_tommer_weather+'<br/>강수확률 '+af_tommer_rain+'%');
				                $("#yebo_"+i+" #yebo_li_3 .fore_tt_bot_time").html(af_tommer_hour+'시');
				           } // if(aresult.result) end
				        } // success : function(aresult) end
				    });
				} // for(var i in arr_poly) end
			}
		}else{
			if(arr_poly){
				for(var i in arr_poly){ // i = rtu_info table area_code
					arr_poly[i]['yebo_marker'].setVisible(false);
					arr_poly[i]['yebo_overlay'].setVisible(false);
				}
			}
		}
	}
	
} // yebo() end


