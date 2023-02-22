<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_wl.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="form_search" action="rpt_wl.php" method="post">
			

		<div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>수위 보고서</span>
					<span id="rtu_name" class="sub_tit mL20"></span>
					<select id="area_code" name="area_code" class="fL mL10 mT3 print_hd">
					<? 
					if($data_sel){
						foreach($data_sel as $key => $val){ 
					?>
						<option value="<?=$val['AREA_CODE']?>" <?if($area_code == $val['AREA_CODE']){echo "selected";}?>><?=$val['RTU_NAME']?></li>
					<? 
						}
					}else{
					?>
						<option value="">장비 없음</option>
					<?
					}
					?>
					</select> 
						<span id="search_dt" class="sub_tit mL20 dp0"></span>
					</div>
				</div>

				<div class="right_bg2">
				<canvas id="graph" class="pT_10"></canvas><!-- 그래프 -->
		<div class="guide_txt"> <ul><li class="icon"><i class="fa fa-paperclip"></i></li><li class="txt02">단위 [m]</li></ul></div>
				</div>
		<div class="right_bg2 mT_15">
		<ul id="search_box">
			<form id="form_mcall" method="post">
			<li>
					<input type="hidden" name="mode" value="mcall">
				<input type="hidden" id="RTU_CNT" name="RTU_CNT">
				<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID">
				<span class="tit">검색 기간  : </span>
				<input type="radio" class="btn_radio" name="sel_date" value="N" <?if($sel_date=="N"){echo "checked";}?>><span class="tit">연간  </span>
				<input type="radio" class="btn_radio" name="sel_date" value="D" <?if($sel_date=="D"){echo "checked";}?>><span class="tit">월간  </span> 
				<input type="radio" class="btn_radio" name="sel_date" value="H" <?if($sel_date==""||$sel_date=="H"){echo "checked";}?>><span class="tit">일간  </span> 
				<input type="radio" class="btn_radio" name="sel_date" value="A" <?if($sel_date=="A"){echo "checked";}?>><span class="tit mR15">일별  </span> 
				
				<button type="button" id="btn_left" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
				<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
				<button type="button"  id="btn_right"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
				<img src="../images/icon_cal.png" alt="달력보기" id="btn_img1" style="margin-bottom: -8px !important;">
				&nbsp;
				<span class="mL3">-</span>
				&nbsp;
				<button type="button" id="btn_left2" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
				<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
				<button type="button"  id="btn_right2"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
				<img src="../images/icon_cal_r.png" alt="달력보기" id="btn_img2" style="margin-bottom: -8px !important;">
			</li>
			<li class="btn_area">
				<span id="button" class="tit">
					<!--
					<button type="button" id="btn_search" class="btn_bb80">검색</button>
 					<button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button> 
 					-->
				</span>
			</li>
			</form>
		</ul>
		<ul class="stitle_box">
		     <!-- <li><?=$sdate?></li> -->
		     <li>[단위 : m]</li>
		</ul>

		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table id="list_table" class="tb_data  pB0">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li10 bR_1gry">구분</th>
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
						</tr>	
					</thead>
			        <tbody>
					<? 
					if($data_list){
						$rowCnt = rpt_cnt;
						$rowNum = 0;
						foreach($data_list as $key => $val){ 
					?>
					<tr id="<?=$val['AREA_CODE']?>" class="hh tr_rtu">
						<td class="li10 bR_1gry"><?=$val['RTU_NAME']?></td>
						<? if($val['LIST']){ ?>
							<? foreach($val['LIST'] as $key2 => $val2){ ?>
							<td class="li3_75"><?=$val2?></td>
							<? } ?>
						<? } else {
							$inhtml = "";
							for($i=$scnt; $i<=$ecnt; $i++){
								$inhtml .= "<td>-</td>";
							}
							echo $inhtml;
						} ?>
					</tr>
					<? 
							$rowNum++;
						}
						if($type == "A"){
							$inhtml = "<tr><td></td>";
							foreach($data_nums['NUM'] as $key => $val){ 		
								$inhtml .= "<td></td>";
							}
							$inhtml .= "</tr>";
							for($i=0; $i<($rowCnt-$rowNum); $i++){
								echo $inhtml;
							}
						}else{
							$inhtml = "<tr><td></td>";
							for($i=$scnt; $i<=$ecnt; $i++){
								$inhtml .= "<td></td>";
							}
							$inhtml .= "</tr>";
							for($i=0; $i<($rowCnt-$rowNum); $i++){
								echo $inhtml;
							}
						}
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
	var area_code = $("#area_code").val();
	
	// 그래프 호출
	if(area_code != "") graph_on();

	$("#area_code").change(function(){
		area_code = $("#area_code").val();
		graph_on();
	});
	
	// tr 클릭시 그래프 변경
	$(".tr_rtu").click(function(){
		var rtu_n = $(this).attr('id');
		$("#area_code").val(rtu_n).attr("selected", true);
		area_code = $("#area_code").val();
		graph_on();
	});

	// 달력 호출
	datepicker(2, "#sdate", "", "yy-mm-dd");
	datepicker(2, "#edate", "", "yy-mm-dd");

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

	var timestamp = makeTimestamp();
	
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
	            title: "수위 보고서",
                customize: function(win){
                    $(win.document.body).find("body").css("overflow", "visible");
                    $(win.document.body).find("h1").css("text-align", "center").css("font-size", "18px");
                    $(win.document.body).find("table").css("font-size", "12px");
                    $(win.document.body).find("tr").css("text-align", "center");
					$(win.document.body).find("div").css("height", "50px").css("border-bottom",'1px solid #000');
					
					//검색 기간별 인쇄 날짜
					$(win.document.body).append("<h2>"+seText+"</h2>");

					$(win.document.body).find("h2").addClass("rpt_sdate");
					$(win.document.body).find("h4").addClass("rpt_sdate_term");
					$(win.document.body).find("h3").addClass("rpt_edate");
				},  action: function(dt){

					// 테이블에 현재 선택된 장비만 남기고 나머지는 숨김
					$.each($("#list_table .tr_rtu"), function(i, v){
						if(v.id != area_code){
							$("#"+v.id).hide();
						}
					});

					$("#search_dt").html(seText);
					$("#search_dt").show();
					$(".print_hd").hide();

					makeDivToImageFile($("#content")); // 보고서 캡쳐인쇄 함수호출
                }
	        },
	   		{
	        	extend: "excel",
	            text: "엑셀변환",
		        className: "btn_lbb80_s",
				filename: '수위보고서_' + timestamp, 
				messageTop: seText,
	            title: "수위보고서",
	            customize: function(xlsx){
	                var sheet = xlsx.xl.worksheets["sheet1.xml"];
	                $("row c", sheet).attr("s", "25");
	                $("row:first c", sheet).attr("s", "51");
	                $("row:first", sheet).attr("ht", 30);
	                $("row:first", sheet).attr('customHeight', 1);
	                $("row:eq(1)", sheet).attr("ht", 25);
	                $("row:eq(1)", sheet).attr('customHeight', 1);
					$("row:eq(1) c", sheet).attr("s", "52");
					// $("row:eq(2) c", sheet).attr("t", "n");
	                var col = $("col", sheet);
	                col.each(function(i, v){
						if(i == 0){
							$(col[i]).attr("width", 15);
						}else{
							$(col[i]).attr("width", 4);
						}
					});
	            }
	        }
	    ]
	}).container().appendTo($("#button"));

	var elData = "";
	var dataLen = "";
	// 그래프 호출
	var chart = null;
	function graph_on(){
    	if(chart) chart.destroy();

		if($('input[name="sel_date"]:checked').val() == "A"){
			$.ajax({
				type: "POST",
				url: "../_info/json/_rpt_json.php",
				data: { "mode" : "flow_10m", "area_code" : $("#area_code").val(), "type" : "D", "sdate" : "<?=$sdate?>", "edate" : "<?=$edate?>" },
				cache: false,
				dataType: "json",
				success : function(data){
					var LEGD, DATAD = new Array();
					var DATA1 = new Array();
					var DATA2 = new Array();
					var DATA3 = new Array();
					var DATA4 = new Array();
					var DATA5 = new Array();
					var MAX, MIN, INCRE = null;
					var tmpMax = 0;
					var tmpMin = 0;
					var MONTH = new Array();

					// console.log(data.list);
					if(data.area){
						if(data.area.MAX !=null && tmpMax < data.area.MAX) tmpMax = data.area.MAX;
						if(data.area.MIN !=null && tmpMin > data.area.MIN) tmpMin = data.area.MIN;
						$("#rtu_name").text(data.area.RTU_NAME);
					}

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
						// console.log(DATAD);
						// console.log(LEGD);

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
	
					if(common_level_cnt == 2){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEGD,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#008000',
									borderColor: '#008000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATAD,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
									}}],
									yAxes: [{
										id: 'y_left', // 좌측 여백 + 눈금
										ticks: {
											display: false
										}, 
										gridLines: {
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 20;
										}
									}, {
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												value = toFixedOf(value, 2);
												if(elData < value){
													elData = "" + value;
													dataLen = elData.length - 3;
												}
												return value;
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: true,
											color: '#aaa',
											drawOnChartArea: true,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 55 + (dataLen*6);
										}
									}]
								}
							}
						});
					}else if(common_level_cnt == 3 || common_level_cnt == 4){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEGD,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#FFEB33',
									borderColor: '#FFEB33',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_3?>',
									data: DATA3,
									yAxisID: 'y_flow',
									backgroundColor: '#ff0000',
									borderColor: '#ff0000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATAD,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
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
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												return toFixedOf(value, 2);
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: false,
											color: '#aaa',
											lineWidth: 1,
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 40;
										}
									}]
								}
							}
						});
					}else if(common_level_cnt == 5){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEGD,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#008000',
									borderColor: '#008000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_3?>',
									data: DATA3,
									yAxisID: 'y_flow',
									backgroundColor: '#ff0000',
									borderColor: '#ff0000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_4?>',
									data: DATA4,
									yAxisID: 'y_flow',
									backgroundColor: '#8b17ff',
									borderColor: '#8b17ff',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_5?>',
									data: DATA5,
									yAxisID: 'y_flow',
									backgroundColor: '#260030',
									borderColor: '#260030',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATAD,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
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
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												return toFixedOf(value, 2);
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: false,
											color: '#aaa',
											lineWidth: 1,
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 40;
										}
									}]
								}
							}
						});
					}
				} // ajax success end
			}); // ajax end
		}else{
			$.ajax({
				type: "POST",
				url: "../_info/json/_rpt_json.php",
				data: { "mode" : "flow", "area_code" : $("#area_code").val(), "type" : "<?=$type?>", "sdate" : "<?=$sdate?>" },
				cache: false,
				dataType: "json",
				success : function(data){
					//console.log(data);
					var LEG, DATA, DATA1, DATA2, DATA3, DATA4, DATA5 = [];		
					var MAX, MIN, INCRE = null;

					if(data.list){
						LEG = data.list.LEG;
						DATA = data.list.DATA;
						DATA1 = data.list.DATA1;
						DATA2 = data.list.DATA2;
						DATA3 = data.list.DATA3;
						DATA4 = data.list.DATA4;
						DATA5 = data.list.DATA5;
						MAX = data.list.MAX;
						MIN = data.list.MIN;
						$("#rtu_name").text(data.list.RTU_NAME);
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
					//console.log("MAX:"+MAX, "MIN:"+MIN, "INC:"+INCRE);

					if(common_level_cnt == 2){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEG,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#008000',
									borderColor: '#008000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATA,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
									}}],
									yAxes: [{
										id: 'y_left', // 좌측 여백 + 눈금
										ticks: {
											display: false
										}, 
										gridLines: {
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 20;
										}
									}, {
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												value = toFixedOf(value, 2);
												if(elData < value){
													elData = "" + value;
													dataLen = elData.length - 3;
												}
												return value;
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: true,
											color: '#aaa',
											drawOnChartArea: true,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 55 + (dataLen*6);
										}
									}]
								}
							}
						});
					}else if(common_level_cnt == 3 || common_level_cnt == 4){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEG,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#FFEB33',
									borderColor: '#FFEB33',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_3?>',
									data: DATA3,
									yAxisID: 'y_flow',
									backgroundColor: '#ff0000',
									borderColor: '#ff0000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATA,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
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
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												return toFixedOf(value, 2);
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: false,
											color: '#aaa',
											lineWidth: 1,
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 40;
										}
									}]
								}
							}
						});
					}else if(common_level_cnt == 5){
						chart = new Chart($("#graph"), {
							type: 'line',
							data: {
								labels: LEG,
								datasets: [{
									label: '<?=level_1?>',
									data: DATA1,
									yAxisID: 'y_flow',
									backgroundColor: '#008000',
									borderColor: '#008000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_2?>',
									data: DATA2,
									yAxisID: 'y_flow',
									backgroundColor: '#ff8017',
									borderColor: '#ff8017',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_3?>',
									data: DATA3,
									yAxisID: 'y_flow',
									backgroundColor: '#ff0000',
									borderColor: '#ff0000',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_4?>',
									data: DATA4,
									yAxisID: 'y_flow',
									backgroundColor: '#8b17ff',
									borderColor: '#8b17ff',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '<?=level_5?>',
									data: DATA5,
									yAxisID: 'y_flow',
									backgroundColor: '#260030',
									borderColor: '#260030',
									borderWidth: 2,
									fill: false,
									pointRadius: 0
								}, {
									label: '수위',
									data: DATA,
									yAxisID: 'y_flow',
									backgroundColor: '#b7d5f4',
									borderColor: '#69F',
									borderWidth: 2,
									fill: 'start'
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
											$.each(labels, function(i, v){
												if(v.text == "수위"){
													labels[i].fillStyle = '#69F';
													labels[i].strokeStyle = '#69F';
												}
											});
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
											if(dataset.label == "수위"){
												return {
													borderColor: '#69F',
													backgroundColor : '#69F'
												}
											}else{
												return {
													borderColor: dataset.borderColor,
													backgroundColor : dataset.backgroundColor
												}
											}
										}
									}
								},
								scales: {
									xAxes:[{
										ticks:{
											fontColor: '#222'
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
										id: 'y_flow', // 수위
										ticks: {
											fontColor: '#222',
											padding: 5,
											callback: function(value, index, values){
												return toFixedOf(value, 2);
											},
											beginAtZero: true,
											suggestedMin: MIN,
											suggestedMax: MAX,
											//stepSize: INCRE,
											maxTicksLimit: 10
										}, 
										gridLines: {
											display: false,
											color: '#aaa',
											lineWidth: 1,
											drawOnChartArea: false,
											drawTicks: false
										},
										afterFit: function(scale){
											scale.width = 40;
										}
									}]
								}
							}
						});
					}
				} // ajax success end
			}); // ajax end
		}
	}

	// 좌측 버튼
	$("#btn_left").click(function(){
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() - 1);

		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        $("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
	});
	
	// 우측 버튼
	$("#btn_right").click(function(){
		var sdate = $("#sdate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() + 1);

		// 내일로 넘어가지 않도록 제한
		var today = new Date();
		if(today.getTime() >= now.getTime()){
			var sel_y = now.getFullYear();
			var sel_m = now.getMonth() + 1;
			var sel_d = now.getDate();
			$("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
			
		}else{
			swal("체크", "미래는 검색할 수 없습니다!", "warning");
		}
	});
	
	// 좌측 버튼
	$("#btn_left2").click(function(){
		var sdate = $("#edate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() - 1);

		var sel_y = now.getFullYear();
		var sel_m = now.getMonth() + 1;
		var sel_d = now.getDate();
        
		var s_sdate = $("#sdate").val();
		var s_now_y = s_sdate.substring(0, 4);
		var s_now_m = s_sdate.substring(5, 7) - 1;
		var s_now_d = s_sdate.substring(8, 10);
        var s_now = new Date(s_now_y, s_now_m, s_now_d);

		if(s_now.getTime() <= now.getTime()){
			$("#edate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
		}else{
			swal("체크", "이전 날짜는 검색할 수 없습니다!", "warning");
		}
	});
	
	// 우측 버튼
	$("#btn_right2").click(function(){
		var sdate = $("#edate").val();
		var now_y = sdate.substring(0, 4);
		var now_m = sdate.substring(5, 7) - 1;
		var now_d = sdate.substring(8, 10);
        var now = new Date(now_y, now_m, now_d);
        now.setDate(now.getDate() + 1);

		// 내일로 넘어가지 않도록 제한
		var today = new Date();
		if(today.getTime() >= now.getTime()){
			var sel_y = now.getFullYear();
			var sel_m = now.getMonth() + 1;
			var sel_d = now.getDate();
			$("#edate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
			
		}else{
			swal("체크", "미래는 검색할 수 없습니다!", "warning");
		}
	});
	
	// 달력 버튼
	$("#btn_img1").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	});

	$("#btn_img2").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#edate").datepicker("hide");
		}else{
			$("#edate").datepicker("show");
		}
	});

	var select_obj = '';

	$('.btn_radio:checked').each(function (index) {
		select_obj += $(this).val();
	});
	if(select_obj == 'A'){
		$(".mL3").show();
		$(".mL3").nextAll().show();
	}else{
		$(".mL3").nextAll().hide();
		$(".mL3").hide();
	}

	$(".btn_radio").click(function(e){
		if(e.target.value == 'A'){
			// 기간 선택시 시작일, 종료일 비교해서 7일 이상 차이 나지 않으면 시작일 변경
			var sdate = $("#sdate").val();
			var s_now_y = sdate.substring(0, 4);
			var s_now_m = sdate.substring(5, 7) - 1;
			var s_now_d = sdate.substring(8, 10);
			var sdt = new Date(s_now_y, s_now_m, s_now_d);

			var edate = $("#edate").val();
			var now_y = edate.substring(0, 4);
			var now_m = edate.substring(5, 7) - 1;
			var now_d = edate.substring(8, 10);
			var edt = new Date(now_y, now_m, now_d);

			edt.setDate(edt.getDate() - 7);
			if(sdt.getDate() > edt.getDate()){
				// 7일전으로 변경
				sdt.setDate(edt.getDate());
				var sel_y = sdt.getFullYear();
				var sel_m = sdt.getMonth() + 1;
				var sel_d = sdt.getDate();
				$("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
			}
			
			$(".mL3").show();
			$(".mL3").nextAll().show();
		}else{
			$(".mL3").nextAll().hide();
			$(".mL3").hide();
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


