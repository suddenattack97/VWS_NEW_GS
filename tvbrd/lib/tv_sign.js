function sign(kind, arr_sub_id){ // 문자전광판
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
					<div id="sign_'+item+'" class="label t10 board" style="white-space: nowrap;">\n\
						<ul>\n\
							<li class="label_top">'+tmp_name+'</li>\n\
							<li class="label_dat" style="height: 23px;">\n\
								<div class="rwrap">\n\
								<span class="r1">&nbsp</span>\n\
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
						url: "img/icon_s_06.png",
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
				
				if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("7", map_data) != "-1" ){
					// 상황판이나 장비상태 선택, 문자전광판 버튼 선택
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
				}else{
    				arr_sub_rtu[item]['marker'].setVisible(false);
    				arr_sub_rtu[item]['overlay'].setVisible(false);
					if(map_kind == 2) arr_sub_rtu[item]['polyline'].setVisible(false);
    			}
				
				if(map_kind == 2){
					arr_sub_rtu[item]['overlay'].setYAnchor(76);
					$("#sign_"+item).css("height", "28px");
				}else{
					var tmp_height = Number( arr_sub_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
					arr_sub_rtu[item]['overlay'].setYAnchor(tmp_height);
					$("#sign_"+item).css("height", "");
				}
				
				// 이벤트
	            $("#sign_"+item).unbind("click").bind("click",function(){
					if(map_kind == 1){
						slide_on("sign", item);
					}else if(map_kind == 2){
						slide_on( "state", new Array(arr_sub_rtu[item]['sub_type'], arr_sub_rtu[item]['area_code']) );
					}
				});
				$(document).on("mouseover", "#sign_"+item, function(){
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
		if( (map_kind == 1 || map_kind == 2) && jQuery.inArray("7", map_data) != "-1" ){
			// 상황판이나 장비상태 선택, sign 버튼 선택
			if(arr_sub_id){
				$.each(arr_sub_id, function(index, item){
					//console.log( arr_sub_rtu[item]['marker'].getIcon().url );
					arr_clus_marker.push( arr_sub_rtu[item]['marker'] ); // 클러스터 추가
					
					if(map_kind == 1){
						if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_06.png"){
							arr_sub_rtu[item]['marker'].setIcon(
								{
									url: "img/icon_s_06.png",
									size: new naver.maps.Size(21, 36)
								}
							);
						}
					}else if(map_kind == 2){
						if(arr_sub_rtu[item]['state']){
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_06_g.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_06_g.png",
										size: new naver.maps.Size(21, 36)
									}
								);
							}
							arr_sub_rtu[item]['polyline'].setOptions({ "strokeColor" : "#4C4C4C" });
						}else{
							if(arr_sub_rtu[item]['marker'].getIcon().url != "img/icon_s_06_o.png"){
								arr_sub_rtu[item]['marker'].setIcon(
									{
										url: "img/icon_s_06_o.png",
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
						$("#sign_"+item).css("height", "28px");
					}else{
						/*
						var tmp_height = Number( arr_sub_rtu[item]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
						arr_sub_rtu[item]['overlay'].setYAnchor(tmp_height);
						$("#sign_"+item).css("height", "");
						*/
					}
				}); // $.each(arr_sub_id, function(index, item) end
				
				if(map_kind == 1){
					$.post( "controll/sign.php", { "mode" : "sign", "arr_siteID" : arr_sub_id }, function(response){
						var arr_check = [];
						var arr_event = [];
						
						$.each(response.list, function(index, item){
							var select = '#sign_'+item[0].sub_id+' .rwrap span';
							arr_check[index] = item[0].sub_id;
							arr_event[ item[0].sub_id ] = [];
							
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
	
								arr_sub_rtu[item2.sub_id]['state'] = true;
								if(item2.success == 1){ // 송신중
									box_content += '<span class="r1 green">전송중..</span>';
									item2.modY = 1;
								}else if(item2.success == 2){ // 송신 실패
									box_content += '<span class="r1 red">전송 실패</span>';
									arr_sub_rtu[item2.sub_id]['state'] = false;
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
								
								var tmp_height = Number( arr_sub_rtu[item2.sub_id]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
								arr_sub_rtu[item2.sub_id]['overlay'].setYAnchor(tmp_height);
								
								arr_event[ item2.sub_id ][index2] = [];
								arr_event[ item2.sub_id ][index2]['success'] = item2.success;
								arr_event[ item2.sub_id ][index2]['IDX'] = item2.IDX;
								arr_event[ item2.sub_id ][index2]['msgAction'] = item2.msgAction;
								arr_event[ item2.sub_id ][index2]['modX'] = item2.modX;
								arr_event[ item2.sub_id ][index2]['modY'] = item2.modY;
								arr_event[ item2.sub_id ][index2]['box_content'] = box_content;
							});
							
							// 변화할 때만 업데이트
							var tmp_sum = "";
							$.each(arr_event[ item[0].sub_id ], function(i, v){
								if(tmp_sum != "") tmp_sum += "/";
								tmp_sum += v['success']+"-"+v['IDX']+"-"+v['modX']+"-"+v['modY']+"-"+v['msgAction'];
							});
							//console.log("change: "+arr_sub_rtu[ item[0].sub_id ]['change']);
							//console.log("tmp_sum: "+tmp_sum);
							
							if(arr_sub_rtu[ item[0].sub_id ]['change'] == tmp_sum){
								return true;
							}else{
								arr_sub_rtu[ item[0].sub_id ]['change'] = tmp_sum;
							}	
							sign_event(0, item[0].sub_id, select, arr_event); // 전광판 효과 적용
						});

						// 문자 비송출 중인 전광판 오버레이
						$.each(arr_sub_id, function(index, item){
							if( jQuery.inArray(item, arr_check) == "-1" ){
								$("#sign_"+item+" .label_dat").css("height", "23px");
								$("#sign_"+item+" .rwrap").html('<span class="r1">&nbsp</span>');
							}
						});
					}, "json");
				}else if(map_kind == 2){
					$.post( "controll/sign.php", { "mode" : "sign", "arr_siteID" : arr_sub_id }, function(response){
						$.each(response.list, function(index, item){
							$.each(item, function(index2, item2){
								arr_sub_rtu[item2.sub_id]['state'] = true;
								if(item2.success == 2){ // 송신 실패
									arr_sub_rtu[item2.sub_id]['state'] = false;
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
	
} // sign() end

function sign_slide(get_rtu_id){
	$("#sidr-id-sign_detail").attr("href", "../divas/monitoring/main.php?url=sbd_send.php&num=6");
	$("#sidr-id-sign").attr("style", "padding:8px 0 0 0; height: 355px; overflow-y: scroll; overflow-x: hidden;");
	$("#sidr-id-sign2").attr("style", "height: 351px; overflow-y: scroll; overflow-x: hidden;");
	
    $.post( "controll/sign.php", { "mode" : "sign_slide" }, function(response) {
    	//console.log(response);
        var list = response.data;
        var list2 = response.data2;
        var list3 = response.data3;
        
        // 전광판 선택
        var txt = '';
        txt += '<div id="tree_sign"></div>';
        $("#sidr-id-sign").html(txt);
        
        var tree_data = [];
        if(list){
            for(var i = 0; i < list.length; i++){
            	var is_match = 0;
           	 
        		for(var g = 0; g < list2.length; g++){
        			if(list[i]['areaID'] == list2[g]['areaID']) is_match++;
        		}
				var tmp_attr = {
        				"areaID" : list[i]['areaID'],
	    				"siteID" : 0
				}
    			if(is_match == 0){
    				var tmp_data = {
    						"id" : "tree_"+list[i]['areaID'], 
    						"parent" : "#",
    						"text" : list[i]['areaName'],
							//"icon" : "//jstree.com/tree-icon.png",
    						"state" : { "opened" : true },
    						"attr" : tmp_attr
					}
					tree_data.push(tmp_data);
    			}else{
    				var tmp_data = {
    						"id" : "tree_"+list[i]['areaID'], 
	        				"parent" : "#",
	        				"text" : list[i]['areaName']+"("+is_match+"개소)",
	        				//"icon" : "//jstree.com/tree-icon.png",
	        				"state" : { "opened" : true },
	        				"attr" : tmp_attr
    				}
    				tree_data.push(tmp_data);
    			}	
            } // for(var i = 0; i < list.length; i++) end
        }
        for(var i = 0; i < list2.length; i++){
    		var tmp_select = false;
    		if(get_rtu_id == list2[i]['siteID']) tmp_select = true;
    		
			var tmp_attr = {
    				"areaID" : list2[i]['areaID'],
    				"siteID" : list2[i]['siteID']
			}
			var tmp_data = {
					"id" : "tree_sub_"+i, 
					"parent" : "tree_"+list2[i]['areaID'],
					"text" : list2[i]['siteName'],
					//"icon" : "//jstree.com/tree-icon.png",
					"state" : { "selected" : tmp_select },
					"attr" : tmp_attr
			}
			tree_data.push(tmp_data);
        } // for(var i = 0; i < list2.length; i++) end
        
        if( $('#tree_sign').length == 0 ) return false;

        if(ie_version == "N/A"){ // ie가 아닐 경우
			$('#tree_sign').jstree({
				'plugins':["wholerow", "checkbox"], 
				'core' : {
				    'data' : tree_data
				}
			});
        }else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
			$('#tree_sign').jstree({
				'plugins':["checkbox"], 
				'core' : {
				    'data' : tree_data
				}
			});
        }
		$('#tree_sign').on("loaded.jstree", function(){
			$("#sidr-id-sign li").addClass("p0");
		});
		$('#tree_sign').on("changed.jstree", function(e, data){
			$("#sidr-id-str_rtu_id").val("");
			var check_cnt = 0;
			
			var i, j, r = [];
		    for(i = 0, j = data.selected.length; i < j; i++) {
		    	var obj = data.instance.get_node(data.selected[i]);
		    	var id = obj.id;
		    	var text = obj.text;
		    	var areaID = obj.original.attr.areaID;
		    	var siteID = obj.original.attr.siteID;
		    	
		    	var out = text+"/"+areaID+"/"+siteID;
		    	//console.log(out);
		    	
		    	if(siteID != 0){
			    	var str_rtu_id = $("#sidr-id-str_rtu_id").val();
			    	if(str_rtu_id == ""){
			    		$("#sidr-id-str_rtu_id").val(siteID);
			    	}else{
			    		$("#sidr-id-str_rtu_id").val(str_rtu_id + "-" + siteID);
			    	}
		    		check_cnt++;
		    	}
		    }
		    $("#sidr-id-rtu_cnt").val(check_cnt);
		    $("#sidr-id-rtu_cnt_text").text(check_cnt);
		}).jstree();
        
    	// 문자 내용 선택
		var txt = '';
        txt += '<table id="sign_script" width="178" border="0" cellpadding="0" cellspacing="0">';
        if(list3){
            for(var i = 0; i < list3.length; i++){ 
            	var add_id = list3[i]['IDX'];
            	var tmp_msg = (list3[i]['MSG'].length > 14) ? list3[i]['MSG'].substring(0, 14)+".." : list3[i]['MSG'];
            	txt += '<tr id="listTr_'+add_id+'" data-no="'+add_id+'" style="padding: 2px;">';
            	txt += '<td id="listTd_tmpMsg" width="30">'+tmp_msg+'</td>';
            	txt += '<!-- ----------------------------------------- -->';
            	txt += '<td id="listTd_check" style="display:none"><input type="checkbox" name="idx[]" value="'+add_id+'"></td>';
            	txt += '<td id="listTd_type" style="display:none">'+list3[i]['TYPE']+'</td>';
            	txt += '<td id="listTd_msgAction" style="display:none">'+list3[i]['MSGACTION']+'</td>';
            	txt += '<td id="listTd_msgColor" style="display:none">'+list3[i]['MSGCOLOR']+'</td>';
            	txt += '<td id="listTd_msgSpd" style="display:none">'+list3[i]['MSGSPD']+'</td>';
            	txt += '<td id="listTd_msgDelay" style="display:none">'+list3[i]['MSGDELAY']+'</td>';
            	txt += '<td id="listTd_msg" style="display:none">'+list3[i]['MSG']+'</td>';
            	txt += '<td id="listTd_viewAction" style="display:none">'+list3[i]['ACTIONNAME']+'</td>';
            	txt += '<td id="listTd_viewColor" style="display:none">'+list3[i]['COLORNAME']+'</td>';
            	txt += '<td id="listTd_viewMsg" style="display:none">'+list3[i]['MSG'].replace(/"/gi, '@')+'</td>';
            	txt += '</tr>';    	
            } // for end
        }
        txt += '</table>';
        $("#sidr-id-sign2").html(txt);
        txt = null;
        
        $.each($("#sign_script tr"), function(index, item){
        	/*
        	var id = this.id; 
    		var tmp_element = "#"+id+" #listTd_check input:checkbox[name='idx[]']";
    		var tmp_success = "#"+id+" #listTd_success";
    		
    		if( $(tmp_success).text() == 3 ){
    			$(tmp_element).prop("checked", true);
    			$(this).attr("class", "sidr-class-ybg");
    		}
    		id = null; tmp_element = null; tmp_success = null;
    		*/
        });
        
        // 테이블 드래그 앤 드롭
    	$("#sign_script").tableDnD({
    		onDrop: function(table, row){ // 드래그 종료
    			if( $("#sidr-id-formselect option:selected").val() != "" ){
    				swal("체크", "순서 변경은 문자구분이 전체일 때만 가능합니다.", "warning");
    				sign_slide(get_rtu_id);
    				$("#sidr-id-formselect").val("");
    				return false;
    			}
    			var arr_sort = new Object();
        		$.each($("#sign_script tr"), function(index, item){
        			var tmp_id = "#"+item.id;
        			arr_sort[index] = $(tmp_id).data("no");
        		});
				$.post("controll/sign.php", { "mode" : "sign_script_sort", "arr_sort" : arr_sort }, function(response){
					sign_slide(get_rtu_id);
				}, "json");
        		arr_sort = null;
    		}
    	});
    }, "json");
} // sign_slide(get_rtu_id) end

$(document).ready(function(){
	$(document).on("click","#sidr-id-all_sel",function(){
		var max_cnt = 0;
		$.each($('#tree_sign').jstree('get_json'), function(index, item){
			max_cnt += Number(item['children'].length);
		});
		var now_sel = $('#tree_sign').jstree('get_bottom_selected');
		if(now_sel.length == max_cnt){
			$('#tree_sign').jstree('deselect_all');
		}else{
			$('#tree_sign').jstree('select_all');
		}
	}); 

	$(document).on("change","#sidr-id-formselect",function(){
		$.each($("#sign_script tr #listTd_type"), function(index, item){
			if( $("#sidr-id-formselect").val() == "" ){
				$(this).closest("tr").show();
			}else if( $("#sidr-id-formselect").val() != $(this).text() ){
				$(this).closest("tr").hide();
			}else if( $("#sidr-id-formselect").val() == $(this).text() ){
				$(this).closest("tr").show();
			}
		});
	});
	
	$(document).on("mouseover","#sign_script tr",function(){
		this.style.backgroundColor = "#BFD2EB";
	});
	$(document).on("mouseout","#sign_script tr",function(){
		this.style.backgroundColor = "";
	});
	$(document).on("click","#sign_script tr",function(){
		if( $("#sidr-id-sign_view .sidr-class-board_textarea .js-marquee").hasClass("black") ){
			$("#sidr-id-sign_view .sidr-class-board_textarea .js-marquee").removeClass("black");
		}
		
		var id = this.id;
		var type = $("#"+id+" #listTd_type").text();
		var msgAction = $("#"+id+" #listTd_msgAction").text();
		var msgColor = $("#"+id+" #listTd_msgColor").text();
		var msgSpd = $("#"+id+" #listTd_msgSpd").text();
		var msgDelay = $("#"+id+" #listTd_msgDelay").text();
		var msg = $("#"+id+" #listTd_msg").text();
		var viewAction = $("#"+id+" #listTd_viewAction").text();
		var viewColor = $("#"+id+" #listTd_viewColor").text();
		var viewMsg = $("#"+id+" #listTd_viewMsg").text();
		
		var text_type = "";
		if(type == "0"){
			text_type = "텍스트";
		}else if(type == "1"){
			text_type = "이미지";
		}
		var text_msg = "";
		if( String(viewMsg).indexOf('@') != "-1" ) viewMsg = viewMsg.replace(/@/gi, '"');
		if( String(viewMsg).indexOf('\n') != "-1" ){
			text_msg = viewMsg.replace(/\n/gi, '<br>');
		}else{
			text_msg = viewMsg;
		}
		$("#sidr-id-msgAction").html(viewAction);
		$("#sidr-id-msgColor").html(viewColor);
		$("#sidr-id-msgSpd").html(msgSpd);
		$("#sidr-id-msgDelay").html(msgDelay);
		$("#sidr-id-type").html(text_type);
		$("#sidr-id-msg").html(text_msg);

		var tmp_element = "#"+id+" #listTd_check input:checkbox[name='idx[]']";
		if( $(tmp_element).is(":checked") ){
			$(tmp_element).prop("checked", false);
			$(this).attr("class", "");
		}else{
			$(tmp_element).prop("checked", true);
			$(this).attr("class", "sidr-class-ybg");
		}
		
		// 전광판 미리보기
		var add_class = "";
		var add_class2 = "";
//    	add_class = "sidr-class-textw_"+modX;
    	add_class = "sidr-class-textw_10";
		if(msgColor == 1) add_class2 = "red";
		else if(msgColor == 2) add_class2 = "green";
		else if(msgColor == 3) add_class2 = "yellow";
		if( String(viewMsg).indexOf('@') != "-1" ) viewMsg = viewMsg.replace(/@/gi, '"');
		
		$("#sidr-id-sign_view").attr("class", add_class+" sidr-class-al_C");
		
		var txt = '';
//    	if(modY == 1){
//    		txt += '<div class="sidr-class-board_textarea sidr-class-text_sign sidr-class-'+add_class2+'">';
//    		txt += '<span>'+viewMsg+'</span>';
//    		txt += '</div>';
//    	}else{
    		var arr_msg = [];
    		if( String(viewMsg).indexOf('\n') != "-1" ){
    			arr_msg = viewMsg.split("\n");
    		}else{
    			arr_msg[0] = viewMsg;
    			arr_msg[1] = "";
    		}

//        	for(var i = 0; i < modY; i++){
            for(var i = 0; i < 2; i++){
        		txt += '<div class="sidr-class-board_textarea sidr-class-text_sign sidr-class-'+add_class2+'">';
        		txt += '<span>'+arr_msg[i]+'</span>';
        		txt += '</div>';
        	}
//    	}
    	$("#sidr-id-sign_view").html(txt); // 미리보기 화면 변경
		
    	var arr_event = [];
    	arr_event['test'] = [];
    	arr_event['test'][0] = [];
		arr_event['test'][0]['msgAction'] = msgAction;
    	var select = "#sidr-id-sign_view .sidr-class-board_textarea";
    	sign_event(1, "test", select, arr_event);
	});
	
	$(document).on("click","#sidr-id-btn_board",function(){
		// 전송 파라미터 입력
		var str_msg_idx = "";
		$.each($("#sign_script tr"), function(index, item){
			var tmp_id = this.id;
    		
			var tmp_check = "#"+tmp_id+" #listTd_check input:checkbox[name='idx[]']";
			var tmp_val = $(tmp_check).val();
			if( $(tmp_check).is(":checked") ){
		    	if(str_msg_idx == ""){
		    		str_msg_idx = tmp_val;
		    	}else{
		    		str_msg_idx = str_msg_idx + "@" + tmp_val;
		    	}
			}
		});
		$("#sidr-id-str_msg_idx").val(str_msg_idx);
		
		var sel_check = false;
		$.each($("#sign_script tr #listTd_check input:checkbox[name='idx[]']"), function(index, item){
			if( $(this).is(":checked") ) sel_check = true;
		});
		if( $("#sidr-id-rtu_cnt").val() == 0 || !$("#sidr-id-rtu_cnt").val() ){
			swal("체크", "전광판을 선택해 주세요.", "warning");
	    }else if( !sel_check ){
			swal("체크", "문자를 선택해 주세요.", "warning");
		}else{
			var data = $("#sidr-id-sign_frm").serialize();
			$.ajax({
			    type: "POST",
			    url: "controll/sign.php",
			    data: data,
			    //data: { "mode" : "sign_in", "data" : data },
			    cache: false, 
			    dataType: "json",
			    success : function(response) {
			    	if(response.result){
						swal("체크", "전광판 전송이 완료 됐습니다.", "success");
			    	}else{
						swal("체크", "전광판 전송중 오류가 발생 했습니다.", "warning");
			    	}
			    },
			    error : function(xhr, status, error) {
			        console.log("sign_error");
			    }
			}); // ajax end
		}
	}); // $(document).on("click","#sidr-id-btn_board",function() end
});	
    
    
