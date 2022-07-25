<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_mix.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="form_search" action="rpt_mix.php" method="get">
	
		<div class="main_contitle">
            <img src="../images/title_an_01.png" alt="비교 분석">&nbsp;&nbsp;
			<span id="rain_name" class="title_locate mL20">강우 선택 :</span>
            <select id="rain_area_code" name="rain_area_code" class="fL mL10 mT3">
			<? 
			if($rain_sel){
				foreach($rain_sel as $key => $val){ 
			?>
				<option value="<?=$val['AREA_CODE']?>" <?if($rain_area_code == $val['AREA_CODE']){echo "selected";}?>><?=$val['RTU_NAME']?></li>
			<? 
				}
			}else{
			?>
				<option value="">장비 없음</option>
			<?
			}
			?>
			</select> 
			&nbsp;&nbsp;
			<span id="flow_name" class="title_locate mL20">수위 선택 :</span>
            <select id="flow_area_code" name="flow_area_code" class="fL mL10 mT3">
			<? 
			if($flow_sel){
				foreach($flow_sel as $key => $val){ 
			?>
				<option value="<?=$val['AREA_CODE']?>" <?if($flow_area_code == $val['AREA_CODE']){echo "selected";}?>><?=$val['RTU_NAME']?></li>
			<? 
				}
			}else{
			?>
				<option value="">장비 없음</option>
			<?
			}
			?>
			</select> 
            <div class="unit"></div>
		</div>
		
		<div class="right_bg">
		<canvas id="graph"></canvas><!-- 그래프 -->
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left80_rpt"> 
					검색 기간 :&nbsp;&nbsp;
					<input type="radio" class="btn_radio" name="sel_date" value="N" <?if($sel_date=="N"){echo "checked";}?>>연간 
					<input type="radio" class="btn_radio" name="sel_date" value="D" <?if($sel_date=="D"){echo "checked";}?>>월간 
					<input type="radio" class="btn_radio" name="sel_date" value="H" <?if($sel_date==""||$sel_date=="H"){echo "checked";}?>>일간 
					<input type="radio" class="btn_radio" name="sel_date" value="A" <?if($sel_date=="A"){echo "checked";}?>>기간 
					
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<span class="mL3">-</span>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					&nbsp;&nbsp;&nbsp;&nbsp;
				</span>
				<span id="button" class="sel_right_n">
					<!--
					<button type="button" id="btn_search" class="btn_bb80">검색</button>
 					<button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button> 
 					-->
				</span>
			</li>
			<li class="li100_nor">
				<table id="list_table" class="tb_data pB0">
					<thead class="tb_data_tbg">
						<tr>
						<th class="li10 bR_1gry" colspan="2">구분</th>
							<? 
							if($type == "A"){
								foreach($data_nums['NUM'] as $key => $val){ 	
									if($key == 0 || $val == "01"){
									?>
										<th class="li3"><?echo $data_nums['MON'][$key] ." / ". $val?></th>
									<?
									}else{
								?>
								<th class="li3"><?=$val?></th>
								<? }
								} 
							}else{
								for($i=$scnt; $i<=$ecnt; $i++){ 		
							?>
							<th class="li3"><?=($i < 10) ? "0".$i : $i?></th>
							<? } } ?>
							<th class="li3 bL_1gry">누계</th>
						</tr>	
					</thead>
			        <tbody>
					<? 
					if($rain_list){
					?>
					<tr class="hh">
						<td class="li5 bR_1gry">강우</td>
						<td class="li10 bR_1gry"><?=$rain_list['RTU_NAME']?></td>
						<? if($rain_list['LIST']){ ?>
							<? foreach($rain_list['LIST'] as $key2 => $val2){ ?>
							<td class="li3"><?=$val2?></td>
							<? } ?>
						<? } ?>
						<td class="li3 bL_1gry"><?=$rain_list['SUM']?></td>
					</tr>
					<? 
					}
					?>	
					<? 
					if($flow_list){
					?>
					<tr class="hh">
						<td class="li5 bR_1gry">수위</td>
						<td class="li10 bR_1gry"><?=$flow_list['RTU_NAME']?></td>
						<? if($flow_list['LIST']){ ?>
							<? foreach($flow_list['LIST'] as $key2 => $val2){ ?>
							<td class="li3"><?=$val2?></td>
							<? } ?>
						<? } ?>
						<td class="li3 bL_1gry"><?=$flow_list['SUM']?></td>
					</tr>
					<? 
					}
					?>
			        </tbody>
				</table>
			</li>
		</ul>

		</div>
		</form>
		
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	var rain_area_code = $("#rain_area_code").val();
	var flow_area_code = $("#flow_area_code").val();
	
	// 그래프 호출
	if(rain_area_code != "" && flow_area_code != "") graph_on();

	$("#rain_area_code").change(function(){
		$("#form_search").submit();
	});
	$("#flow_area_code").change(function(){
		$("#form_search").submit();
	});
	
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd", null);
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd", null);
	

	// 엑셀 검색기간 추가 
	var seText = "";
	if($('input[name="sel_date"]:checked').val() == "A"){
		seText = "검색기간 : " + $("#sdate").val() +" ~ "+ $("#edate").val();
	}else if($('input[name="sel_date"]:checked').val() == "D"){
		seText = "검색월 : " + $("#sdate").val().substr(0,7);
	}else if($('input[name="sel_date"]:checked').val() == "N"){
		seText = "검색연도 : " + $("#sdate").val().substr(0,4) + "년";
	}else{
		seText = "검색일 : " + $("#sdate").val();
	}

	// 테이블 호출
	var table = $("#list_table").DataTable({
        processing: true,
        paging: false,
        ordering: false,
        searching: false,
        info: false,
		autoWidth: false,
        columnDefs: [
        	{className: "dt-center", targets: "_all"}
    	],
	    language: {
	    	"emptyTable": "데이터가 없습니다.",       
	      	"loadingRecords": "로딩중...", 
	      	"processing": "처리중...",
	        "search" : "검색 : ",
	      	"paginate": {
	      		"previous": "<",
	      		"next": ">",
	      	},
	      	"zeroRecords": "검색 결과 데이터가 없습니다."
	    }
	});
	var button = new $.fn.dataTable.Buttons(table, {
	    buttons: [
	   		{
	            text: "검색",
	            className: "btn_bb80",
                action: function(dt){
            		// 기간 검색시 30일 이상 선택 금지
					var type = $("input[name='sel_date']:checked").val();
					if(type == "A"){
						if(termCheck(30)) $("#form_search").submit();
					}else{
						$("#form_search").submit()
					}
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_s",
	            autoPrint: true,
	            title: "비교분석 보고서",
                customize: function(win){
                    $(win.document.body).find("body").css("overflow", "visible");
                    $(win.document.body).find("h1").css("text-align", "center").css("font-size", "18px");
                    $(win.document.body).find("table").css("font-size", "12px");
                    $(win.document.body).find("tr").css("text-align", "center");
                }
	        },
	   		{
	        	extend: "excel",
	            text: "엑셀변환",
		        className: "btn_lbb80_s",
				messageTop: seText,
	            title: "",
	            customize: function(xlsx){
	                var sheet = xlsx.xl.worksheets["sheet1.xml"];
	                //$("row:first c", sheet).attr("s", "42");
	                $("row c", sheet).attr("s", "51");
	                var col = $("col", sheet);
	                col.each(function(){
	                      $(col[0]).attr("width", 30);
	               	});
	            }
	        }
	    ]
	}).container().appendTo($("#button"));
	
	/* // 좌측 버튼
	$("#btn_left").click(function(){
		var type = $("input[name=type]:checked").val();
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        if(type == "H"){
        	now.setDate(now.getDate() - 1);
        }else if(type == "D"){
        	now.setMonth(now.getMonth() - 1);
        }else if(type == "N"){
        	now.setFullYear(now.getFullYear() - 1);
        }
        
		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        $("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
	});
	
	// 우측 버튼
	$("#btn_right").click(function(){
		var type = $("input[name=type]:checked").val();
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        if(type == "H"){
            now.setDate(now.getDate() + 1);
        }else if(type == "D"){
        	now.setMonth(now.getMonth() + 1);
        }else if(type == "N"){
        	now.setFullYear(now.getFullYear() + 1);
        }
        
		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        $("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
	});
	
	// 달력 버튼
	$("#btn_img").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	}); */

	// 그래프 호출
	var chart = null;
	function graph_on(){
    	if(chart) chart.destroy();
    	
		if($('input[name="sel_date"]:checked').val() == "A"){
			$.ajax({
				type: "POST",
				url: "../_info/json/_rpt_json.php",
				data: { "mode" : "mix_term", "rain_area_code" : $("#rain_area_code").val(), "flow_area_code" : $("#flow_area_code").val(), "type" : "D", "sdate" : "<?=$sdate?>", "edate" : "<?=$edate?>" },
				cache: false,
				dataType: "json",
				success : function(data){
					var LEGD, DATAD = new Array();
					var LEGD2, DATAD2 = new Array();
					var DATA1 = new Array();
					var DATA2 = new Array();
					var DATA3 = new Array();
					var DATA4 = new Array();
					var DATA5 = new Array();
					var MAX, MIN, INCRE = null;
					var MAX2, MIN2, INCRE2 = null;
					var tmpMax = 0;
					var tmpMin = 0;
					var MONTH, MONTH2 = new Array();
					
					console.log(data.list);
					console.log(data.list2);
					//강우
					if(data.area){
						if(data.area.MAX !=null && tmpMax < data.area.MAX) tmpMax = data.area.MAX;
						if(data.area.MIN !=null && tmpMin > data.area.MIN) tmpMin = data.area.MIN;
					}

					MAX = tmpMax;
					MIN = tmpMin;
					
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

					if(data.list){
						// LEGD = Object.keys(data.list);
						// 객체 -> 배열로 변환 map 함수
						DATAD = data.list.map(function(a){ return a.DATA });
						LEGD = data.list.map(function(a){ return a.LEG });
						// 월 표출
						MONTH = data.list.map(function(a){ return a.MON });
						LEGD[0] = MONTH[0];
						var midx = LEGD.indexOf("01");
						if(midx > 0){
							LEGD[midx] = MONTH[midx];
						}
					}

					//수위
					if(data.area2){
						if(data.area2.MAX !=null && tmpMax < data.area2.MAX) tmpMax = data.area2.MAX;
						if(data.area2.MIN !=null && tmpMin > data.area2.MIN) tmpMin = data.area2.MIN;
					}

					MAX2 = tmpMax;
					MIN2 = tmpMin;

					if( isNaN(MAX2) || MAX2 == 0 ){
						MAX2 = 1;
						MIN2 = 0;
						INCRE2 = 0.2;
					}else if(MAX2 == MIN2){
						INCRE2 = ((Math.abs(MAX2)) / 5).toFixed(2);
						MAX2 = Number(MAX2) + Number(INCRE2);
						MIN2 = Number(MIN2) - Number(INCRE2);
					}else{
						INCRE2 = ((Math.abs(MAX2) - Math.abs(MIN2)) / 5).toFixed(2);
						MAX2 = Number(MAX2) + Number(INCRE2);
						MIN2 = Number(MIN2) - Number(INCRE2);
					}
					MIN2 = MIN2 < 0 ? 0 : MIN2;

					if(data.list2){
						// LEGD = Object.keys(data.list);
						// 객체 -> 배열로 변환 map 함수
						DATAD2 = data.list2.map(function(a){ return a.DATA });
						LEGD2 = data.list2.map(function(a){ return a.LEG });
						// 월 표출
						MONTH2 = data.list2.map(function(a){ return a.MON });
						LEGD2[0] = MONTH2[0];
						var midx = LEGD2.indexOf("01");
						if(midx > 0){
							LEGD2[midx] = MONTH2[midx];
						}
					}
					
	
					chart = new Chart($("#graph"), {
						type: 'bar',
						data: {
							labels: LEGD,
							datasets: [{
								type: 'bar',
								label: '강우',
								data: DATAD,
								yAxisID: 'y_rain',
								backgroundColor: '#c3dcf5',
								borderColor: '#c3dcf5',
								borderWidth: 1
							}, {
								type: 'line',
								label: '수위',
								data: DATAD2,
								yAxisID: 'y_flow',
								backgroundColor: '#69F',
								borderColor: '#69F',
								borderWidth: 2,
								fill: false
							}]
						},
						options: {
							elements: {
								line: {
									tension: 0
								}
							},
							legend: {
								labels: {
									generateLabels: function(chart){
										labels = Chart.defaults.global.legend.labels.generateLabels(chart);
										labels[0].fillStyle = '#96c6f7';
										labels[0].strokeStyle = '#96c6f7';
										labels[1].fillStyle = '#69F';
										labels[1].strokeStyle = '#69F';
										return labels;
									}
								}
							},
							tooltips: {
								position: 'nearest',
								mode: 'index',
								intersect: false,
								filter: function(item, data){
									data = data.datasets[item.datasetIndex].data[item.index];
									return !isNaN(data) && data !== null;
								},
								callbacks: {
									labelColor: function(tooltipItem, chart){
										dataset = chart.config.data.datasets[tooltipItem.datasetIndex];
										if(dataset.yAxisID == "y_flow"){
											return {
												borderColor: '#69F',
												backgroundColor : '#69F'
											}
										}else if(dataset.yAxisID == "y_rain"){
											return {
												borderColor: '#9bc9f7',
												backgroundColor : '#9bc9f7'
											}
										}
									}
								}
							},
							scales: {
								xAxes:[{
									ticks:{
										fontColor: '#aaa'
								}}],
								yAxes: [{
									id: 'y_left', // 좌측 여백 + 눈금
									ticks: {
										display: false
									}, 
									gridLines: {
										drawOnChartArea: true,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 20;
									}
								}, {
									id: 'y_rain', // 강우
									ticks: {
										fontColor: '#aaa',
										padding: 5,
										callback: function(value, index, values){
											return toFixedOf(value, 1);
										},
										beginAtZero: true,
										suggestedMin: MIN,
										suggestedMax: MAX,
										//stepSize: RAIN_INCRE,
										maxTicksLimit: 10
									}, 
									gridLines: {
										display: false,
										color: '#777',
										lineWidth: 3,
										drawOnChartArea: false,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 30;
									}
								}, {
									id: 'y_flow', // 수위
									ticks: {
										fontColor: '#3679eb',
										padding: 5,
										callback: function(value, index, values){
											return toFixedOf(value, 2);
										},
										beginAtZero: true,
										suggestedMin: MIN2,
										suggestedMax: MAX2,
										//stepSize: FLOW_INCRE,
										maxTicksLimit: 10
									}, 
									gridLines: {
										display: false,
										color: '#3679eb',
										lineWidth: 3,
										drawOnChartArea: false,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 30;
									}
								}]
							}
						}
					});
				} // ajax success end
			}); // ajax end
		}else{
			$.ajax({
				type: "POST",
				url: "../_info/json/_rpt_json.php",
				data: { "mode" : "mix", "rain_area_code" : $("#rain_area_code").val(), "flow_area_code" : $("#flow_area_code").val(), "type" : "<?=$type?>", "sdate" : "<?=$sdate?>" },
				cache: false,
				dataType: "json",
				success : function(data){
					var LEG, DATA = [];		
					var RAIN_MAX, RAIN_MIN, RAIN_INCRE, FLOW_MAX, FLOW_MIN, FLOW_INCRE = null;
			
					LEG = data.list.LEG;
					DATA = data.list.DATA;
					RAIN_MAX = data.list.RAIN_MAX;
					RAIN_MIN = data.list.RAIN_MIN;
					FLOW_MAX = data.list.FLOW_MAX;
					FLOW_MIN = data.list.FLOW_MIN;
						
					if( isNaN(RAIN_MAX) || RAIN_MAX == 0 ){
						RAIN_MAX = 1;
						RAIN_MIN = 0;
						RAIN_INCRE = 0.2;
					}else if(RAIN_MAX == RAIN_MIN){
						RAIN_INCRE = ((Math.abs(RAIN_MAX)) / 5).toFixed(2);
						RAIN_MAX = Number(RAIN_MAX) + Number(RAIN_INCRE);
						RAIN_MIN = Number(RAIN_MIN) - Number(RAIN_INCRE);
					}else{
						RAIN_INCRE = ((Math.abs(RAIN_MAX) - Math.abs(RAIN_MIN)) / 5).toFixed(2);
						RAIN_MAX = Number(RAIN_MAX) + Number(RAIN_INCRE);
						RAIN_MIN = Number(RAIN_MIN) - Number(RAIN_INCRE);
					}
					RAIN_MIN = RAIN_MIN < 0 ? 0 : RAIN_MIN;
					//console.log("RAIN_MAX:"+RAIN_MAX, "RAIN_MIN:"+RAIN_MIN, "RAIN_INC:"+RAIN_INCRE);
						
					if( isNaN(FLOW_MAX) || FLOW_MAX == 0 ){
						FLOW_MAX = 1;
						FLOW_MIN = 0;
						FLOW_INCRE = 0.2;
					}else if(FLOW_MAX == FLOW_MIN){
						FLOW_INCRE = ((Math.abs(FLOW_MAX)) / 5).toFixed(2);
						FLOW_MAX = Number(FLOW_MAX) + Number(FLOW_INCRE);
						FLOW_MIN = Number(FLOW_MIN) - Number(FLOW_INCRE);
					}else{
						FLOW_INCRE = ((Math.abs(FLOW_MAX) - Math.abs(FLOW_MIN)) / 5).toFixed(2);
						FLOW_MAX = Number(FLOW_MAX) + Number(FLOW_INCRE);
						FLOW_MIN = Number(FLOW_MIN) - Number(FLOW_INCRE);
					}
					FLOW_MIN = FLOW_MIN < 0 ? 0 : RAIN_MIN;
					//console.log("FLOW_MAX:"+FLOW_MAX, "FLOW_MIN:"+FLOW_MIN, "FLOW_INC:"+FLOW_INCRE);
			
					chart = new Chart($("#graph"), {
						type: 'bar',
						data: {
							labels: LEG,
							datasets: [{
								type: 'bar',
								label: '강우',
								data: DATA['RAIN'],
								yAxisID: 'y_rain',
								backgroundColor: '#c3dcf5',
								borderColor: '#c3dcf5',
								borderWidth: 1
								
							}, {
								type: 'line',
								label: '수위',
								data: DATA['FLOW'],
								yAxisID: 'y_flow',
								backgroundColor: '#c3dcf5',
								borderColor: '#69F',
								borderWidth: 2,
								fill: false
							}]
						},
						options: {
							elements: {
								line: {
									tension: 0
								}
							},
							legend: {
								labels: {
									generateLabels: function(chart){
										labels = Chart.defaults.global.legend.labels.generateLabels(chart);
										labels[0].fillStyle = '#96c6f7';
										labels[0].strokeStyle = '#96c6f7';
										labels[1].fillStyle = '#69F';
										labels[1].strokeStyle = '#69F';
										return labels;
									}
								}
							},
							tooltips: {
								position: 'nearest',
								mode: 'index',
								intersect: false,
								filter: function(item, data){
									data = data.datasets[item.datasetIndex].data[item.index];
									return !isNaN(data) && data !== null;
								},
								callbacks: {
									labelColor: function(tooltipItem, chart){
										dataset = chart.config.data.datasets[tooltipItem.datasetIndex];
										if(dataset.yAxisID == "y_flow"){
											return {
												borderColor: '#69F',
												backgroundColor : '#69F'
											}
										}else if(dataset.yAxisID == "y_rain"){
											return {
												borderColor: '#9bc9f7',
												backgroundColor : '#9bc9f7'
											}
										}
									}
								}
							},
							scales: {
								xAxes:[{
									ticks:{
										fontColor: '#aaa'
								}}],
								yAxes: [{
									id: 'y_left', // 좌측 여백 + 눈금
									ticks: {
										display: false
									}, 
									gridLines: {
										drawOnChartArea: true,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 20;
									}
								}, {
									id: 'y_rain', // 강우
									ticks: {
										fontColor: '#aaa',
										padding: 5,
										callback: function(value, index, values){
											return toFixedOf(value, 1);
										},
										beginAtZero: true,
										suggestedMin: RAIN_MIN,
										suggestedMax: RAIN_MAX,
										//stepSize: RAIN_INCRE,
										maxTicksLimit: 10
									}, 
									gridLines: {
										display: false,
										color: '#777',
										lineWidth: 3,
										drawOnChartArea: false,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 30;
									}
								}, {
									id: 'y_flow', // 수위
									ticks: {
										fontColor: '#3679eb',
										padding: 5,
										callback: function(value, index, values){
											return toFixedOf(value, 2);
										},
										beginAtZero: true,
										suggestedMin: FLOW_MIN,
										suggestedMax: FLOW_MAX,
										//stepSize: FLOW_INCRE,
										maxTicksLimit: 10
									}, 
									gridLines: {
										display: false,
										color: '#3679eb',
										lineWidth: 3,
										drawOnChartArea: false,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 30;
									}
								}]
							}
						}
					});
				} // success end
			}); // ajax end
		}
	}
	
	var select_obj = '';

	$('.btn_radio:checked').each(function (index) {
		select_obj += $(this).val();
	});
	if(select_obj ==  'N' ){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(select_obj == 'D'){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(select_obj == 'H'){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(select_obj == 'A'){
		$("#edate").prev().show();
		$("#edate").next().show();
		$("#edate").show();
	}


	$(".btn_radio").click(function(e){
		if(e.target.value == 'N'){
			$("#edate").prev().hide();
			$("#edate").next().hide();
			$("#edate").hide();
		}else if(e.target.value == 'D'){
			$("#edate").prev().hide();
			$("#edate").next().hide();
			$("#edate").hide();
		}else if(e.target.value == 'H'){
			$("#edate").prev().hide();
			$("#edate").next().hide();
			$("#edate").hide();
		}else if(e.target.value == 'A'){
			$("#edate").prev().show();
			$("#edate").next().show();
			$("#edate").show();
		}
	});

	// 그래프 너비 조정 > githup #2127 오류로 인한 반응형 옵션 제거 후 너비 조정
	var tmp_width = $("#content").width();
	$("#graph").attr("width", tmp_width);
	$("#graph").attr("height", 450);
	
	// 윈도우 사이즈 변경 시
	$(window).resize(function(){
		chart.resize();
	});
	
	// 뒤로가기 관련 처리
	$("select").each(function(){
		var select = $(this);
		var selectedValue = select.find("option[selected]").val();

		if(selectedValue){
			select.val(selectedValue);
		}
	});
	$('input:radio[name="type"][value="<?=$type?>"]').prop("checked", true);
	$("#sdate").val("<?=$sdate?>");
});
</script>

</body>
</html>


