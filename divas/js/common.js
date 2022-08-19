	// 공용 변수 호출
	$.ajax({
		type: "POST",
		url: "../_info/json/_tms_json.php",
		data: { "mode" : "common" },
		async: false, // 동기
		cache: false,
		dataType: "json",
		success : function(data){
			if(data.common){
				$.each(data.common, function(i, v){
					window['common_'+i] = v;
				});
				window.onkeydown = function() {
					var kcode = event.keyCode;
					if(kcode == 116) {
					history.replaceState({}, null, location.pathname);
					}
				}
			}
		}
	}); 
	
	// 강우 테이블 호출
	function rain_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "rain" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(type == 1){
		    		var lay_html = '';	
					var rowCnt = 20;
					var columCnt = 6;
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>강우현황</span> ';
					lay_html += ' <span class="quick"> ';
					lay_html += ' <img src="../images/quick_link.png" onclick="quick_button(1);"></span>';
					lay_html += ' </div>';
					lay_html += ' </div> <div class="right_bg2">';
					lay_html += ' <table class="main_table m20"> ';
					lay_html += ' 	<thead><tr> ';
					lay_html += ' 	<th width="20%">지역</th> ';
					lay_html += ' 	<th width="14%">전시간</th> ';
					lay_html += ' 	<th width="14%">시간</th> ';
					lay_html += ' 	<th width="14%" style="background:#F2FFFF;">금일</th> ';
					lay_html += ' 	<th width="14%">전일</th> ';
					lay_html += ' 	<th width="14%">월간</th> ';
					// lay_html += ' 	<th width="10%">통신상태</th> ';
					lay_html += ' 	</tr></thead>';
	
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr class="hh" id="rain_'+v.AREA_CODE+'"> ';
							lay_html += ' <td class="hh" id="RTU_NAME">'+v.RTU_NAME+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_BH">'+toFixedOfNum(v.RAIN_BH, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_H">'+toFixedOfNum(v.RAIN_H, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_D" style="background:#F2FFFF;">'+toFixedOfNum(v.RAIN_D, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_BD">'+toFixedOfNum(v.RAIN_BD, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_N">'+toFixedOfNum(v.RAIN_N, 1, 0.01)+'</td> ';
							// lay_html += ' <td id="CALL_LAST">'+v.CALL_LAST+'</td> ';
							lay_html += ' </tr>';
			            });
					}else{
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="7" style="height:560px;">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';

						// for( var i=0; i<rowCnt; i++){
						// 	lay_html += ' <tr> ';
						// 	for(var j=0; j<columCnt; j++){
						// 		lay_html += ' <td></td>';
						// 	}
						// 	lay_html += '</tr>';
						// }
					}
					lay_html += ' </table>';
					lay_html += ' <div class="guide_txt"> ';
					lay_html += '<ul><li class="icon"><i class="fa fa-paperclip"></i></li>';
					lay_html += '<li class="txt02">단위 [mm]</li></ul>';
					lay_html += '</div>';
					lay_html += '</div>';
              
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){					
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#rain_"+v.AREA_CODE;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #RAIN_BH").html(toFixedOfNum(v.RAIN_BH, 1, 0.01));
							$(tmp_id+" #RAIN_H").html(toFixedOfNum(v.RAIN_H, 1, 0.01));
							$(tmp_id+" #RAIN_D").html(toFixedOfNum(v.RAIN_D, 1, 0.01));
							$(tmp_id+" #RAIN_BD").html(toFixedOfNum(v.RAIN_BD, 1, 0.01));
							$(tmp_id+" #RAIN_N").html(toFixedOfNum(v.RAIN_N, 1, 0.01));
							$(tmp_id+" #CALL_LAST").html(v.CALL_LAST);
			            });
			        }
		        }
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		        	if( $(lay_id+" #spin").length == 0 ){
		        		$(lay_id).append('<div id="spin" class="tmp-spin-size"></div>');
		        	}
		        	tmp_spin = spin_start(lay_id+" #spin", "135px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, lay_id+" #spin"); 
		        		$(lay_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}
	
	// 변위 그래프 호출
	var chart = new Array();
	
	function graph_on(area_code, num, type){
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_rpt_json.php",
		    data: { "mode" : "disp", "area_code" : area_code, "type" : "D", "sdate" : "graph" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        // console.log(data);
		        var LEGD, DATAD = new Array();
		        var MAX, MIN, INCRE = null;
				var tmpMax = 0;
				var tmpMin = 0;
				var maxIndex = null;
				
				if(data.area){
					if(data.area.MAX !=null && tmpMax < data.area.MAX) tmpMax = data.area.MAX;
					if(data.area.MIN !=null && tmpMin > data.area.MIN) tmpMin = data.area.MIN;
				}

		        if(data.list){
					LEGD = Object.keys(data.list);
					var idx = 0;
					var uniqeArr = [];
					$.each(data.list, function(i, v){
						if(v.hasOwnProperty('LEG')){
							if(v.LEG == LEGD[idx]){
								DATAD[idx] = v.DATA;
								if(tmpMax == DATAD[idx]){
									maxIndex = idx;
								}
								LEGD[idx] = LEGD[idx].substr(0,10);
								// console.log(LEGD[idx]); 
							}
						}
						idx++;
					});

					MAX = tmpMax;
					MIN = tmpMin;
		        }
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
        		MIN = MIN < 0 ? 0 : MIN;

				if( type == 1 ){
					
					if(chart[num]) chart[num].destroy();

					// if(common_level_cnt == 3 || common_level_cnt == 4){
					// 	chart[num] = new Chart($("#graph"+num), {
					// 		type: 'line',
					// 		data: {
					// 			labels: LEGD,
					// 			datasets: [{
					// 				label: '변위',
					// 				data: DATAD,
					// 				yAxisID: 'y_disp',
					// 				backgroundColor: '#c3dcf5',
					// 				borderColor: '#c3dcf5',
					// 				borderWidth: 1
									
					// 			}]
					// 		},
					// 		options: {
					// 			responsive: false,
					// 			elements: {
					// 				point : {
					// 					radius: 0
					// 				},
					// 				line: {
					// 					tension: 0
					// 				}
					// 			},
					// 			legend: {
					// 				display: false 
					// 			},
					// 			tooltips: {
					// 				bodyFontSize: 11,
					// 				position: 'average',
					// 				mode: 'index',
					// 				intersect: false,
					// 				filter: function(item, data){
					// 					if(data.labels[0] == 1){
					// 						data.labels.forEach(function(v,i) {
					// 							// data.labels[i] = v + "일";
					// 						});
					// 					}
					// 					data = data.datasets[item.datasetIndex].data[item.index];
					// 					return !isNaN(data) && data !== null;
					// 				},
					// 				custom: function(tooltip) {
					// 					if (!tooltip) return;
					// 					// disable displaying the color box;
					// 					tooltip.displayColors = false;
					// 				},
					// 				callbacks: {
					// 					// use label callback to return the desired label
					// 					label: function(tooltipItem, data) {
					// 						// return tooltipItem.xLabel + " :" + tooltipItem.yLabel;
					// 						return data['labels'][tooltipItem['index']] + " : " +data['datasets'][0]['data'][tooltipItem['index']];
					// 					},
					// 					// remove title
					// 					title: function(tooltipItem, data) {
					// 						return;
					// 					}
					// 				}
					// 			},
					// 			scales: {
					// 				xAxes:[{
					// 					gridLines: {
					// 						display: false
					// 					},
					// 					ticks:{
					// 						display: false
					// 					/* },
					// 					// 첫번째, 마지막 날짜만 출력
					// 					afterTickToLabelConversion: function(data){
					// 						let xLabels = data.ticks;
					// 						for(let i = 0; i<xLabels.length;i++){
					// 							if ( (i >= 1) && (i <= xLabels.length-2) ) xLabels[i] = '';
					// 						} */
					// 					} 
					// 				}],
					// 				yAxes: [{
					// 					id: 'y_left', // 좌측 여백 + 눈금
					// 					ticks: {
					// 						display: false
					// 					}, 
					// 					gridLines: {
					// 						display: false,
					// 					},
					// 					afterFit: function(scale){
					// 						scale.width = 1;
					// 					}
					// 				}, {
					// 					id: 'y_disp', // 변위
					// 					ticks: {
					// 						min : -180,
					// 						max : 180,
					// 						callback: function(value, index, values){
					// 							return value;
					// 						},
					// 						suggestedMin: MIN,
					// 						suggestedMax: MAX,
					// 						 stepSize: 180,
					// 						beginAtZero: true,
					// 						maxTicksLimit: 1
					// 					}, 
					// 					gridLines: {
					// 						display: true,
					// 						zeroLineColor: '#ddd'
					// 					},
					// 					afterFit: function(scale){
					// 						scale.width = 1;
					// 					}
					// 				}]
					// 			}
					// 		}
					// 	});
					// 	//객체 비움
					// 	// chart[chartIdx] = null;
					// }
				}else{
					chart[num].data.labels = LEGD;
					chart[num].data.datasets[0].data = DATAD;
					chart[num].update();
				}
	        } // ajax success end
        }); // ajax end
	}
	
	// 지도 테이블 호출
	function map_table_full(type, lay_id){
		var tmp_spin = null;

		        if(type == 1){
		    		var lay_html = '';
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>관제상황판</span> ';
					lay_html += ' <span class="quick"> ';
					// lay_html += ' <img src="../images/quick_link.png" onclick=";"></span>';
					lay_html += ' </div>';
					lay_html += '  <div class="right_bg2">';
					lay_html += ' <table class="main_table"> ';
					lay_html += ' <iframe src="../../tvbrd/index.php?type=1" style="width:100%; height:800px; border-radius: 10px;"/> ';
					lay_html += ' </table> </div> ';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){					
		        }
	}
	
	// 지도 테이블 호출
	function map_table(type, lay_id){
		var tmp_spin = null;

		        if(type == 1){
		    		var lay_html = '';	
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>관제상황판</span> ';
					lay_html += ' <span class="quick"> ';
					// lay_html += ' <img src="../images/quick_link.png" onclick=";"></span>';
					lay_html += ' </div>';
					lay_html += '  <div class="right_bg2">';
					lay_html += ' <table class="main_table"> ';
					lay_html += ' <iframe src="../../tvbrd/index.php?type=1" style="width:100%; height:495px; border-radius: 10px;"/> ';
					lay_html += ' </table> </div> ';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){					
		        }
	}

	

	// 수위 테이블 호출
	function flow_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "flow" },
			async: true,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(type == 1){
		    		var lay_html = '';	
					var rowCnt = 20;
					var columCnt = 5;
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>수위현황</span> ';
					lay_html += ' <span class="quick"> ';
					lay_html += ' <img src="../images/quick_link.png" onclick="quick_button(2);"></span>';
					lay_html += ' </div>';
					lay_html += ' </div> <div class="right_bg2">';
					lay_html += ' <table class="main_table m20"> ';
					lay_html += ' 	<thead><tr> ';
						lay_html += ' 	<th width="20%">지역</th> ';
						lay_html += ' 	<th width="17.5%">전시간</th> ';
						lay_html += ' 	<th width="17.5%">시간</th> ';
						lay_html += ' 	<th width="17.5%">경계치</th> ';
						lay_html += ' 	<th width="17.5%">위험치</th> ';
	
					lay_html += ' 	</tr></thead>';
					
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr class="hh" id="flow_'+v.AREA_CODE+'"> ';
								lay_html += ' <td class="hh" id="RTU_NAME">'+v.RTU_NAME+'</td> ';
								lay_html += ' <td class="hh" id="FLOW_BN">'+toFixedOfNum(v.FLOW_BN, 2, 0.01)+'</td> ';
								lay_html += ' <td class="hh" id="FLOW_N">'+toFixedOfNum(v.FLOW_N, 2, 0.01)+'</td> ';
								lay_html += ' <td class="hh" id="FLOW_LEVEL1">'+v.FLOW_WARNING+'</td> ';
								lay_html += ' <td class="hh" id="FLOW_LEVEL2">'+v.FLOW_DANGER+'</td> ';
							lay_html += ' </tr>';
			            });
					}else{
						var tmp_colspan = 5;
						// if(common_level_cnt == 3) tmp_colspan = 7;
						// else if(common_level_cnt == 4) tmp_colspan = 7;
						// else if(common_level_cnt == 5) tmp_colspan = 9;
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="'+tmp_colspan+'" style="height:560px;">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';

						// for( var i=0; i<rowCnt; i++){
						// 	lay_html += ' <tr> ';
						// 	for(var j=0; j<columCnt; j++){
						// 		lay_html += ' <td></td>';
						// 	}
						// 	lay_html += '</tr>';
						// }
					}
					lay_html += ' </table>';
					lay_html += ' <div class="guide_txt"> ';
					lay_html += '<ul><li class="icon"><i class="fa fa-paperclip"></i></li>';
					lay_html += '<li class="txt02">단위 [m]</li></ul>';
					lay_html += '</div>';
					lay_html += '</div>';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){				
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#flow_"+v.AREA_CODE;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #FLOW_BN").html(toFixedOfNum(v.FLOW_BN, 2, 0.01));
							$(tmp_id+" #FLOW_N").html(toFixedOfNum(v.FLOW_N, 2, 0.01));
							$(tmp_id+" #FLOW_LEVEL1").html(v.FLOW_WARNING);
							$(tmp_id+" #FLOW_LEVEL2").html(v.FLOW_DANGER);
							
			            });
			        }
		        }
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		        	if( $(lay_id+" #spin").length == 0 ){
		        		$(lay_id).append('<div id="spin" class="tmp-spin-size"></div>');
		        	}
		        	tmp_spin = spin_start(lay_id+" #spin", "135px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, lay_id+" #spin"); 
		        		$(lay_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}

	// aws 테이블 호출
	function aws_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "aws" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
				// console.log(data.sensor);
		        if(type == 1){
		    		var lay_html = '';
					var rowCnt = 20;
					var columCnt = 11;	
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>AWS현황</span> ';
					lay_html += ' <span class="quick"> ';
					lay_html += ' <img src="../images/quick_link.png" onclick="quick_button(3);"></span>';
					lay_html += ' </div>';
					lay_html += ' </div> <div class="right_bg2">';
					lay_html += ' <table class="main_table_1 m20"> ';
					lay_html += ' 	<tr> ';
					lay_html += ' 	<th rowspan="2" width="15%">지역</th> ';
					lay_html += ' 	<th colspan="2" width="15%">우량(㎜)</th> ';
					lay_html += ' 	<th colspan="3" width="20%">온도(℃)</th> ';
					lay_html += ' 	<th colspan="2" width="15%">풍향/풍속(㎧)</th>';
					// if(data.sensor.ATMO){
						// if(data.sensor.ATMO >= 1){
						// 	lay_html += ' 	<th colspan="3" width="20%">기압(hPa)</th> ';
						// }
					// }
					lay_html += ' 	<th colspan="3" width="20%">습도(%)</th> ';
					// if(data.sensor.RADI){
						// if(data.sensor.RADI >= 1){
						// 	lay_html += ' 	<th colspan="3" width="20%">일사(W/m2)</th> ';
						// }
					// }
					// if(data.sensor.SUNS){
						// if(data.sensor.SUNS >= 1){
						// 	lay_html += ' 	<th colspan="3" width="20%">일조()</th> ';
						// }
					// }
					// lay_html += ' 	<th rowspan="2" width="15%">통신상태</th> ';
					lay_html += ' 	</tr>';
					lay_html += ' 	<tr> ';

					//강우량
					lay_html += ' 	<td class="gry_f">시간</td> ';
					lay_html += ' 	<td class="gry">금일</td> ';
					//온도
					lay_html += ' 	<td class="gry">현재</td> ';
					lay_html += ' 	<td class="gry">최고</td> ';
					lay_html += ' 	<td class="gry">최저</td> ';
					//풍향풍속
					lay_html += ' 	<td class="gry">현재</td> ';
					lay_html += ' 	<td class="gry">최대</td> ';

					// if(data.sensor.ATMO >= 1){
					// 	lay_html += ' 	<td class="gry">현재 <br> 최고 <br> 최저</td> ';
					// 	// lay_html += ' 	<td class="gry">최고</td> ';
					// 	// lay_html += ' 	<td class="gry">최저</td> ';
					// }

					//습도
					lay_html += ' 	<td class="gry">현재</td> ';
					lay_html += ' 	<td class="gry">최고</td> ';
					lay_html += ' 	<td class="gry">최저</td> ';

					// if(data.sensor.RADI >= 1){
					// 	lay_html += ' 	<td class="gry">현재</td> ';
					// 	lay_html += ' 	<td class="gry">최고</td> ';
					// 	lay_html += ' 	<td class="gry">최저</td> ';
					// }

					// if(data.sensor.SUNS >= 1){
					// 	lay_html += ' 	<td class="gry">현재</td> ';
					// 	lay_html += ' 	<td class="gry">최고</td> ';
					// 	lay_html += ' 	<td class="gry">최저</td> ';
					// }

					lay_html += ' 	</tr>';
	
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr class="hh" id="aws_'+v.AREA_CODE+'"> ';
							lay_html += ' <td class="hh" id="RTU_NAME">'+v.RTU_NAME+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_H">'+toFixedOfNum(v.RAIN_H, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="RAIN_D">'+toFixedOfNum(v.RAIN_D, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="TEMP_N">'+toFixedOfNum(v.TEMP_N, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="TEMP_MAX">'+toFixedOfNum(v.TEMP_MAX, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="TEMP_MIN">'+toFixedOfNum(v.TEMP_MIN, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="WIND">'+v.WIND_DEG+' / '+toFixedOfNum(v.WIND_VEL, 1, 0.01)+'</td> ';
							lay_html += ' <td class="hh" id="WIND_MAX">'+v.WIND_MAX_DEG+' / '+toFixedOfNum(v.WIND_MAX_VEL, 1, 0.01)+'</td> ';
							// if(data.sensor.ATMO >= 1 && v.ATMO_N){
							// 	lay_html += ' <td id="ATMO_N">'+toFixedOfNum(v.ATMO_N, 1, 0.01)+'</td> ';
							// }

							// if(data.sensor.ATMO >= 1 && v.ATMO_MAX){
							// 	lay_html += ' <td id="ATMO_MAX">'+toFixedOfNum(v.ATMO_MAX, 1, 0.01)+'</td> ';
							// }

							// if(data.sensor.ATMO >= 1 && v.ATMO_MIN){
							// 	lay_html += ' <td id="ATMO_MIN">'+toFixedOfNum(v.ATMO_MIN, 1, 0.01)+'</td> ';
							// }
						
							lay_html += ' <td id="HUMI_N">'+toFixedOfNum(v.HUMI_N, 1, 0.01)+'</td> ';
							lay_html += ' <td id="HUMI_MAX">'+toFixedOfNum(v.HUMI_MAX, 1, 0.01)+'</td> ';
							lay_html += ' <td id="HUMI_MIN">'+toFixedOfNum(v.HUMI_MIN, 1, 0.01)+'</td> ';
							// lay_html += ' <td id="CALL_LAST">'+v.CALL_LAST+'</td> ';
							// if(data.sensor.RADI >= 1 && v.RADI_N && v.RADI_MAX && v.RADI_MIN){
							// 	lay_html += ' <td id="RADI_N">'+toFixedOfNum(v.RADI_N, 1, 0.01)+'</td> ';
							// 	lay_html += ' <td id="RADI_MAX">'+toFixedOfNum(v.RADI_MAX, 1, 0.01)+'</td> ';
							// 	lay_html += ' <td id="RADI_MIN">'+toFixedOfNum(v.RADI_MIN, 1, 0.01)+'</td> ';
							// }
							// if(data.sensor.SUNS >= 1 && v.SUNS_N && v.SUNS_MAX && v.SUNS_MIN){
							// 	lay_html += ' <td id="SUNS_N">'+toFixedOfNum(v.SUNS_N, 1, 0.01)+'</td> ';
							// 	lay_html += ' <td id="SUNS_MAX">'+toFixedOfNum(v.SUNS_MAX, 1, 0.01)+'</td> ';
							// 	lay_html += ' <td id="SUNS_MIN">'+toFixedOfNum(v.SUNS_MIN, 1, 0.01)+'</td> ';
							// }
							lay_html += ' </tr>';
			            });
					}else{
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="12" style="height:560px;">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';

						// for( var i=0; i<rowCnt; i++){
						// 	lay_html += ' <tr> ';
						// 	for(var j=0; j<columCnt; j++){
						// 		lay_html += ' <td></td>';
						// 	}
						// 	lay_html += '</tr>';
						// }
					}
					lay_html += ' </table></div>';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#aws_"+v.AREA_CODE;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #RAIN_H").html(toFixedOfNum(v.RAIN_H,1, 0.01));
							$(tmp_id+" #RAIN_D").html(toFixedOfNum(v.RAIN_D,1, 0.01));
							$(tmp_id+" #TEMP_N").html(toFixedOfNum(v.TEMP_N,1, 0.01));
							$(tmp_id+" #TEMP_MAX").html(toFixedOfNum(v.TEMP_MAX,1, 0.01));
							$(tmp_id+" #TEMP_MIN").html(toFixedOfNum(v.TEMP_MIN,1, 0.01));
							$(tmp_id+" #WIND").html(v.WIND_DEG+' / '+toFixedOfNum(v.WIND_VEL, 1, 0.01));
							$(tmp_id+" #WIND_MAX").html(v.WIND_MAX_DEG+' / '+toFixedOfNum(v.WIND_MAX_VEL, 1, 0.01));
							// $(tmp_id+" #CALL_LAST").html(v.CALL_LAST);
			            });
			        }
		        }
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		        	if( $(lay_id+" #spin").length == 0 ){
		        		$(lay_id).append('<div id="spin" class="tmp-spin-size"></div>');
		        	}
		        	tmp_spin = spin_start(lay_id+" #spin", "135px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, lay_id+" #spin"); 
		        		$(lay_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}

	// 적설 테이블 호출
	function snow_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "snow" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(type == 1){
		    		var lay_html = '';	
					var rowCnt = 20;
					var columCnt = 6;
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <div class="tit"> ';
					lay_html += ' <img src="../images/board_icon_aws.png">  <span>적설현황</span> ';
					lay_html += ' <span class="quick"> ';
					lay_html += ' <img src="../images/quick_link.png" onclick="quick_button(4);"></span>';
					lay_html += ' </div>';
					lay_html += ' </div> <div class="right_bg2">';
					lay_html += ' <table class="main_table m20"> ';
					lay_html += ' 	<thead><tr> ';
					lay_html += ' 	<th width="20%">지역</th> ';
					lay_html += ' 	<th width="14%">전일신적설</th> ';
					lay_html += ' 	<th width="14%">전일적설</th> ';
					lay_html += ' 	<th width="14%">금일신적설</th> ';
					lay_html += ' 	<th width="14%">현재적설</th> ';
					lay_html += ' 	<th width="14%">금일적설</th> ';
					// lay_html += ' 	<th width="10%">통신상태</th> ';
					lay_html += ' 	</tr></thead>';
	
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr class="hh" id="snow_'+v.AREA_CODE+'"> ';
							lay_html += ' <td class="hh" id="RTU_NAME">'+v.RTU_NAME+'</td> ';
							lay_html += ' <td class="hh" id="SNOW_SBM">'+toFixedOfNum(v.SNOW_SBM, 1, 0.001)+'</td> ';
							lay_html += ' <td class="hh" id="SNOW_BM">'+toFixedOfNum(v.SNOW_BM, 1, 0.001)+'</td> ';
							lay_html += ' <td class="hh" id="SNOW_SM">'+toFixedOfNum(v.SNOW_SM, 1, 0.001)+'</td> ';
							lay_html += ' <td class="hh" id="SNOW_M">'+toFixedOfNum(v.SNOW_M, 1, 0.001)+'</td> ';
							lay_html += ' <td class="hh" id="SNOW_D">'+toFixedOfNum(v.SNOW_D, 1, 0.001)+'</td> ';
							// lay_html += ' <td id="CALL_LAST">'+v.CALL_LAST+'</td> ';
							lay_html += ' </tr>';
			            });
					}else{
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="12" style="height:560px;">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';

						// for( var i=0; i<rowCnt; i++){
						// 	lay_html += ' <tr> ';
						// 	for(var j=0; j<columCnt; j++){
						// 		lay_html += ' <td></td>';
						// 	}
						// 	lay_html += '</tr>';
						// }
						
					}
					lay_html += ' </table>';
					lay_html += ' <div class="guide_txt"> ';
					lay_html += '<ul><li class="icon"><i class="fa fa-paperclip"></i></li>';
					lay_html += '<li class="txt02">단위 [cm]</li></ul>';
					lay_html += '</div>';
					lay_html += '</div>';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#snow_"+v.AREA_CODE;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #SNOW_SBM").html(toFixedOfNum(v.SNOW_SBM, 1, 0.001));
							$(tmp_id+" #SNOW_BM").html(toFixedOfNum(v.SNOW_BM, 1, 0.001));
							$(tmp_id+" #SNOW_SM").html(toFixedOfNum(v.SNOW_SM, 1, 0.001));
							$(tmp_id+" #SNOW_M").html(toFixedOfNum(v.SNOW_M, 1, 0.001));
							$(tmp_id+" #SNOW_D").html(toFixedOfNum(v.SNOW_D, 1, 0.001));
							// $(tmp_id+" #CALL_LAST").html(v.CALL_LAST);
			            });
			        }
		        }
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		        	if( $(lay_id+" #spin").length == 0 ){
		        		$(lay_id).append('<div id="spin" class="tmp-spin-size"></div>');
		        	}
		        	tmp_spin = spin_start(lay_id+" #spin", "135px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, lay_id+" #spin"); 
		        		$(lay_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}



	function quick_button(mode){
		if(mode == 1) location.href = "../monitoring/rpt_rain.php"; //강우현황
		if(mode == 2) location.href = "../monitoring/rpt_wl.php"; //수위현황
		if(mode == 3) location.href = "../monitoring/rpt_aws.php"; //AWS현황
		if(mode == 4) location.href = "../monitoring/rpt_snow.php"; // 적설현황
		if(mode == 5) location.href = "../monitoring/rpt_brhist.php"; // 방송현황
		if(mode == 6) location.href = "../monitoring/rpt_alarmlog.php"; // 경보현황
		if(mode == 7) location.href = "../monitoring/tms_equip.php"; // 장비상태
		if(mode == 8) location.href = "../monitoring/rpt_displace.php"; // 변위현황
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
	 
	/**
     * 보고서 페이지 캡쳐 인쇄 함수 
	 * [targetDiv] : $("#content")
     */
	 function makeDivToImageFile(targetDiv) {
		var captureDiv = targetDiv[0];
		var imageURL;
		html2canvas(captureDiv, {
		  allowTaint: true,
		  useCORS: true,
		  /* 아래 3 속성이 canvas의 크기를 정해준다. */
		  width: captureDiv.offsetWidth,
		  height: captureDiv.offsetHeight,
		  scale: 1
		}).then(function (canvas) {
			imageURL = canvas.toDataURL('image/png');
			imageURL = imageURL.replace(/^data[:]image\/(png|jpg|jpeg)[;]base64,/i, "");
			imageURL = encodeURIComponent(imageURL);
			var param = "img="+imageURL;
			$.ajax({
				type: "POST",
				url: "../monitoring/img_make.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					// console.log("@");
				},complete : function(data){
					printJS('print.png', 'image');
					$("#list_table .tr_rtu").show();
					$("#search_dt").hide();
					$(".print_hd").show();
				}
			});	
		}).catch(function (err) {
		  console.log("makeDivToImageFile() error : ",err);
		});
	}

	/**
     * 중복서브밋 방지
     * 
     * @returns {Boolean}
     */
    var doubleSubmitFlag = false;
    function doubleSubmitCheck(){
        if(doubleSubmitFlag){
            return doubleSubmitFlag;
        }else{
            doubleSubmitFlag = true;
            return false;
        }
	}
	
	 /**
     *  [arg..]일 이상 조회 방지
     *  20210819 서정명
     * @returns {Boolean}
     */
	  function termCheck(arg) {
		var sdate = $("#sdate").val();
		var edate = $("#edate").val();

		var sdt = new Date(sdate);
		var edt = new Date(edate);
		var dateDiff = Math.ceil((edt.getTime()-sdt.getTime())/(1000*3600*24));

		if( dateDiff >= arg){
			alert( arg + "일 이상 조회할 수 없습니다." );
			return false;
		}else{
			return true;
		}
	}
		
	 /**
     *  oninput 입력시 유효성 체크
	 * 	oninput : type == 'onlyNumber', 'onlyPort'
	 *  onblur : type == 'text', 'onlyIp', 'onlyEmail'
     *  20220819 서정명
     */
	function inputCheck(obj, type, range) {
		if(type == 'onlyNumber'){ // 숫자값만, 범위(range) 체크
			if(range.length > 1) {
				range = range.split('~');
				if(range.length == 2){
					range[0] = parseInt(range[0]);
					range[1] = parseInt(range[1]);
				}else{
					console.log("범위 설정오류! function inputCheck()의 세번째 argument");
				}
			}
			obj.value = obj.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
			if(range.length > 1) {
				if(range[0] > obj.value || range[1] < obj.value) {
					obj.value = obj.value.slice(0, obj.value.length-1);
				}
			}
		}else if(type == 'text'){ // 문자열 길이 체크
			if(obj.value.length > 0){
				if(range.length > 1) {
					range = range.split('~');
					if(range.length == 2){
						range[0] = parseInt(range[0]);
						range[1] = parseInt(range[1]);
					}else{
						console.log("범위 설정오류! function inputCheck()의 세번째 argument");
					}
				}
				if(range.length > 1) {
					if(range[0] > obj.value.length || range[1] < obj.value.length) {
						swal({
							title: '<div class="alpop_top_r">문자열 입력</div><div class="alpop_mes_r">유효한 범위의 값이 아닙니다.</div>',
							text: range[0] + '자 이상, '+range[1]+ '자 이하로 입력해주세요.',
							confirmButtonColor: '#ca4726',
							confirmButtonText: '확인',
							html: true
						});
						obj.focus();
					}
				}
			}else{
				$(obj).unbind('blur');
			}
		}else if(type == 'onlyIp'){ // ip 체크 : 숫자값만, ip 정규식 체크
			obj.value = obj.value.replace(/[^0-9.]/g, '');
			// let ipformat = /^(?!.*\.$)((?!0\d)(1?\d?\d|25[0-5]|2[0-4]\d)(\.|$)){4}$/;
			let ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
			if(obj.value.length > 0){
				if (!ipformat.test(obj.value)) {
					swal({
						title: '<div class="alpop_top_r">IP 입력</div><div class="alpop_mes_r">유효한 범위의 값이 아닙니다.</div>',
						text: '정상적인 값을 입력해주세요.',
						confirmButtonColor: '#ca4726',
						confirmButtonText: '확인',
						html: true
					});
					obj.focus();
				}
			}else{
				$(obj).unbind('blur');
			}
		}else if(type == 'onlyEmail'){ // 이메일 체크 : 정규식 체크
			let regex = /[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
			if(obj.value.length > 0){
				console.log(regex.test(obj.value));
				if (!regex.test(obj.value)) {
					swal({
						title: '<div class="alpop_top_r">도메인 입력</div><div class="alpop_mes_r">유효한 범위의 값이 아닙니다.</div>',
						text: '정상적인 값을 입력해주세요.',
						confirmButtonColor: '#ca4726',
						confirmButtonText: '확인',
						html: true
					});
					obj.focus();
				}
			}else{
				$(obj).unbind('blur');
			}
		}else if(type == 'onlyPort'){ // port값 범위 체크(0~65535)
			let range1 = 0;
			let range2 = 65535;
			obj.value = obj.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
			if(range1 > obj.value || range2 < obj.value) {
				obj.value = obj.value.slice(0, obj.value.length-1);
			}
		}
	}
			
	// 10보다 작으면 0 붙어줌
	function makeDateForm(time){
		return time < 10 ? "0"+time : time;
	}

	// 현재 클라이언트 년,월,일,시,분,초 값 반환
	function makeTimestamp(){
		var now_date = new Date();
		var now_y = now_date.getFullYear();
		var now_m = now_date.getMonth() + 1;
		var now_d = now_date.getDate();
		var now_h = now_date.getHours();
		var now_i = now_date.getMinutes();
		var now_s = now_date.getSeconds();
		var timestamp = ""+ now_y + makeDateForm(now_m) + makeDateForm(now_d) + makeDateForm(now_h) + makeDateForm(now_i) + makeDateForm(now_s);
		return timestamp;
	}
	
	// magnific-popup.js
	function magnific_popup(target){
		$(target).magnificPopup({
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
	}
	
	// spin.js
	function spin_start(target, top){
		var option = { 
			lines : 13, // The number of lines to draw
			length : 20, // The length of each line
			width : 8, // The line thickness
			radius : 20, // The radius of the inner circle
			corners : 1, // Corner roundness (0..1)
			rotate : 0, // The rotation offset
			direction : 1, // 1: clockwise, -1: counterclockwise
			color : '#000', // #rgb or #rrggbb or array of colors
			speed : 1, // Rounds per second
			trail : 60, // Afterglow percentage
			shadow : false, // Whether to render a shadow
			hwaccel : false, // Whether to use hardware acceleration
			className : 'spinner', // The CSS class to assign to the spinner
			zIndex : 2e9, // The z-index (defaults to 2000000000)
			top : top ? top : '200px', // Top position relative to parent
			left : '50%', // Left position relative to parent
			position: 'relative' // Element positioning
		}; 
		return new Spinner(option).spin( $(target)[0] );
	}
	function spin_stop(spinner, target){
		spinner.stop( $(target)[0] );
	}
	
	// n자리수 이하까지 표현
	function toFixedOf(txt, n){
		if(typeof n != "number" || n > 12) return NaN;
		var reck = 1;
		for (var i=0; i<n; i++) reck *= 10;
		var result = parseInt(txt * reck) / reck;
		return result.toFixed(n);
	}
	
	// m값 만큼 곱한 후 n자리수까지 표현
	function toFixedOfNum(txt, n, m){
		if(txt == "-") return txt;
		if(typeof n != "number" || n > 12) return NaN;
		if(typeof m != "number") return NaN;
		// 첫번째 값만
		var textVal = txt.trim();
		var tmpVal = textVal.split(" ");
		textVal = Number(tmpVal[0]);
		if(typeof textVal != "number") return textVal;

		var reck = 1;
		for (var i=0; i<n; i++) reck *= 10;
		var result = Math.round((textVal*m) * reck) / reck;
		return result.toFixed(n);
	}
	
	// 원인자료 - 이벤트코드에 따라 단위 변경
	function toFixedOfEventValue(EVENT_CODE, EVENT_VALUE){
		var fixNum = 0;
		var unitNum = 1;
		var unitText = "";

		if(EVENT_CODE >= 19 && EVENT_CODE <= 22){
			fixNum = 1;
			// 강우 *0.01 빠짐 21/06/28 서정명
			unitText = "mm";
		}else if(EVENT_CODE >= 23 && EVENT_CODE <= 29){
			fixNum = 2;
			unitNum = 0.01;
			unitText = "m";
		}else if(EVENT_CODE >= 101 && EVENT_CODE <= 108){
			fixNum = 2;
			unitNum = 0.0001;
			unitText = "˚";
		}else{
			fixNum = 0;
			unitNum = 1;
			unitText = "";
		}
		
		return toFixedOfNum(EVENT_VALUE, fixNum, unitNum)+unitText;
	}

	//종합현황 > 방송팝업에서 바로가기 버튼 > 방송 전송이력으로 이동
	$(document).on("click", "#popup_move", function(){
		$("#popup_over_main1", parent.document).hide();
		$("#popup_over_main2", parent.document).hide();
		$("#popup_overlay").hide();
		$("#popup_layout").hide();
		$("#popup_total_overlay").hide();
		$("#popup_total_layout").hide();
		location.href = "../monitoring/rpt_brhist.php";
	});

	// 레이어 팝업 열기
	function popup_open(){
		$("#popup_over_main1", parent.document).show();
		$("#popup_over_main2", parent.document).show();
		$("#popup_overlay").show();
		$("#popup_layout").show();
	}
	// 종합현황에서 방송현황 가기 레이어 팝업 열기
	function popup_total_open(){
		$("#popup_over_main1", parent.document).show();
		$("#popup_over_main2", parent.document).show();
		$("#popup_total_overlay").show();
		$("#popup_total_layout").show();
	}
	// 레이어 팝업 닫기
	function popup_close(){
		// audio.pause();
		$("#popup_over_main1", parent.document).hide();
		$("#popup_over_main2", parent.document).hide();
		$("#popup_overlay").hide();
		$("#popup_layout").hide();
	}
	// 레이어 좌측 및 상단 열기
	function popup_main_open(){
		$("#popup_over_main1", parent.document).show();
		$("#popup_over_main2", parent.document).show();
	}
	// 레이어 좌측 및 상단 닫기
	function popup_main_close(){
		$("#popup_over_main1", parent.document).hide();
		$("#popup_over_main2", parent.document).hide();
	}

	// 로그인 닫기창
	function login_popup_close(){
		parent.swal.close();
	}

	// 자식 창에서 레이어 클릭 시 팝업 닫기
	$(document).on("click", "#popup_overlay, #popup_close", function(){
		// audio.pause();
		$("#popup_over_main1", parent.document).hide();
		$("#popup_over_main2", parent.document).hide();
		$("#popup_overlay").hide();
		$("#popup_layout").hide();
		$("#popup_total_overlay").hide();
		$("#popup_total_layout").hide();
	});

	// 자식 창에서 레이어 클릭 시 팝업 닫기
	$(document).on("click", "#popup_total_overlay, #popup_close", function(){
		$("#popup_over_main1", parent.document).hide();
		$("#popup_over_main2", parent.document).hide();
		$("#popup_overlay").hide();
		$("#popup_layout").hide();
		$("#popup_total_overlay").hide();
		$("#popup_total_layout").hide();
	});
	// 부모 창에서 호출 받아 레이어 팝업 닫기
	function parent_main_close(){
		if( swal.getState() ){
			if( swal.getOutsideClick() ){
				audio.pause();
				$("#popup_over_main1", parent.document).hide();
				$("#popup_over_main2", parent.document).hide();
				$("#popup_overlay").hide();
				$("#popup_layout").hide();
				$("#popup_total_overlay").hide();
				$("#popup_total_layout").hide();
				swal.close();
			}
		}else{
			$("#popup_over_main1", parent.document).hide();
			$("#popup_over_main2", parent.document).hide();
			$("#popup_overlay").hide();
			$("#popup_layout").hide();
			$("#popup_total_overlay").hide();
			$("#popup_total_layout").hide();
		}
		var tmp_mfp = $(".mfp-close");
		if(tmp_mfp.length){
			tmp_mfp.trigger("click");
		}
	}
	
	// 리스트 선택 시 배경색
	function bg_color(class_name, r_target, a_target){
		$.each($(r_target), function(i, v){
			$(v).removeClass(class_name);
		});
		$(a_target).addClass(class_name);
	}
	// 리스트 선택 체크 (체크된 것이 없을 경우 false)
	function bg_color_check(class_name, h_target){
		var check = false;
		$.each($(h_target), function(i, v){
			if( $(v).hasClass(class_name) ) check = true;
		});
		return check;
	}

	// 셀렉트박스 재정렬
	function sort_option(target){
	    $(target).each(function(){
	        var op = $(target).children("option");
	        op.sort(function(a, b){
	            return $(a).data("sort") > $(b).data("sort") ? 1 : -1;
	        });
	        return $(target).empty().append(op);
	    });
	    $(target+" option:eq(0)").prop("selected", true);
	}
	
	// 로그인 팝업 호출
	function login(target){
		swal({ 
			title: '',
			text: '<div><iframe width="451px" height="530px" scrolling="no" src="./login.php?target='+target+'" style="border: 0;margin-top:-30px;margin-left: -5px;"></iframe></div>',
			showConfirmButton: false,
			html: true,
			customClass: 'swal-wide'
			});
	}
	
	
	// 쿠키 생성 arg(이름, 값, 시간)
	function createCookie(name, value, hours) {
		var expires;
		if (hours) {
			var date = new Date();
			date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		} else {
		expires = "";
		}
		document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/;";
	}