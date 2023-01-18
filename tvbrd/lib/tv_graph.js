//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 graph.js
//# content : 기상상황판 js
//################################################################################################################################
    function graph_slide(get_kind, get_area_code){
		$.ajax({
            type: "POST",
            url: "controll/graph.php",
            cache: false,
            data: { "mode" : "graph_slide", "kind" : get_kind, "option" : get_option, "area_code" : get_area_code },
            dataType: "json",
            beforeSend: function(data){
                $("#con_forec").css("background-image","url('./img/loddingbar.gif')");
				$("#con_forec").css("background-size","150px");
				$("#con_forec").css("background-repeat","no-repeat");
				$("#con_forec").css("background-position","center");
            },
            complete: function(data){
				$("#con_forec").css("background-image","");
				$("#con_forec").css("background-size","");
				$("#con_forec").css("background-repeat","");
				$("#con_forec").css("background-position","");
				$("#changeOption").click(function(){
					get_option = get_option == "M" ? "H" : "M" ;
					graph_slide(get_kind, get_area_code);
				});
            },
            success : function(response) {
				//console.log(response);
				var list = response.data;
				var hour = list.hour; // 시간 데이터
				var hour_cnt = list.hour/length; // 시간 데이터 개수
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
				var data1 = []; 
				var data2 = [];
				var data3 = [];
				var data4 = [];
				var data5 = [];


				tmp_name = decodeURIComponent(list.rtuname);
				tmp_name = (tmp_name.length > 10) ? tmp_name.substring(0, 10)+".." : tmp_name;
				$("#sidr-id-chart_name").html(tmp_name);

				if(get_kind == "rain"){
					tmp_title = "강우"; tmp_unit = "(mm)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_rain.php&num=1");
				}else if(get_kind == "flow"){
					tmp_title = "수위"; tmp_unit = "(m)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_flow.php&num=1");
				}else if(get_kind == "snow"){
					tmp_title = "적설"; tmp_unit = "(cm)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_snow.php&num=1");
				}else if(get_kind == "disp"){
					tmp_title = "변위"; tmp_unit = "( ˚ )";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_displace.php&num=1");
				}else if(get_kind == "wind"){
					tmp_title = "풍속"; tmp_unit = "(m/s)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_aws.php&num=1");
				}else if(get_kind == "damp"){
					tmp_title = "습도"; tmp_unit = "(%)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_aws.php&num=1");
				}else if(get_kind == "temp"){
					tmp_title = "온도"; tmp_unit = "(°C)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_aws.php&num=1");
				}else if(get_kind == "pres"){
					tmp_title = "기압"; tmp_unit = "(hPa)";
					$("#sidr-id-btn_graph_detail").attr("href", "../divas/monitoring/main.php?url=tms_aws.php&num=1");
				}
				$("#sidr-id-chart_title").html(tmp_title);

				if(get_option == "M"){
					$("#sidr-id-chart_title").append('<button id="changeOption">1시간</button>');
				}else{
					$("#sidr-id-chart_title").append('<button id="changeOption">10분</button>');
				}

				tmp_html += '<tr>';
				tmp_html += '	<th>시간</th>';
				tmp_html += '	<th>'+tmp_title + tmp_unit+'</th>';
				tmp_html += '</tr>';

				$.each(hour, function(index, item){
					// console.log(hour.length);
					var tmp_num = Number(hour.length - index); // 그래프 인덱스 거꾸로
					var tmp_date = item['date'];
					// tmp_date = (tmp_num < 10) ? "0"+item['num'] : item['num'];
					var tmp_data = item['data'] == "-" ? "-" : Number(item['data']);

					data1[tmp_num] = item['data1'] == "-" ? "-" : Number(item['data1']);
					data2[tmp_num] = item['data2'] == "-" ? "-" : Number(item['data2']);

					graph_leg[tmp_num] =  item['num'];
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
					tmp_html += '</tr>';
				});
				time_avg = (time_cnt == 0) ? "-" : (time_sum / time_cnt).toFixedOf(2);
				
				tmp_html += '<tr>';
				tmp_html += '	<td class="gbg name Lh63">최고</td>';
				tmp_html += '	<td>'+time_max+'</td>';
				tmp_html += '</tr>';
				tmp_html += '<tr>';
				tmp_html += '	<td class="gbg name Lh63">최저</td>';
				tmp_html += '	<td>'+time_min+'</td>';
				tmp_html += '</tr>';
				tmp_html += '<tr>';
				tmp_html += '	<td class="gbg name Lh63">평균</td>';
				tmp_html += '	<td>'+time_avg+'</td>';
				tmp_html += '</tr>';
				$("#sidr-id-graph_tbody").html(tmp_html);
				
				// 그래프 호출
				var CTYPE = (get_kind == "rain" || get_kind == "snow" ) ? "bar" : "line";
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
				MIN = MIN < 0 ? 0 : MIN;
				//console.log("MAX:"+MAX, "MIN:"+MIN, "INC:"+INCRE);
		
				if(get_kind == "flow"){
					chart = new Chart($("#sidr-id-graph"), {
						type: CTYPE,
						data: {
							labels: LEG,
							datasets: [{
									label: '경계치',
									data: data1,
									backgroundColor: '#008000',
									borderColor: '#008000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '위험치',
									data: data2,
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
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
										beginAtZero: true,
										suggestedMin: MIN,
										suggestedMax: MAX,
										//stepSize: INCRE,
										maxTicksLimit: 10
									}
								}]
							}
						}
					});	
				}else if(get_kind == "rain" || get_kind == "snow"){
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
										beginAtZero: true,
										suggestedMin: MIN,
										suggestedMax: MAX,
										//stepSize: INCRE,
										maxTicksLimit: 10
									}
								}]
							}
						}
					});	
				}else{
					chart = new Chart($("#sidr-id-graph"), {
						type: CTYPE,
						data: {
							labels: LEG,
							datasets: [{
								label: tmp_title,
								data: DATA,
								backgroundColor: 'rgb(54, 162, 235)',
								borderColor: 'rgb(54, 162, 235)',
								fill: false,
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										suggestedMin: MIN,
										suggestedMax: MAX,
										//stepSize: INCRE,
										maxTicksLimit: 10
									}
								}]
							}
						}
					});	
				}	
        }
	});
    	
        // 소수점 자르기
        Number.prototype.toFixedOf = function(n){
        	if(!n || typeof n != "number" || n > 12) return NaN;
        	var reck = 1;
        	for (var i=0; i<n; i++) reck *= 10;
        	return parseInt(this * reck) / reck;
        }
    }
    

    