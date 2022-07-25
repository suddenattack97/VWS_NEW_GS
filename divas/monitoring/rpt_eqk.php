<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_rain.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="form_search" action="rpt_rain.php" method="get">
	
		<div class="main_contitle">
            <img src="../images/title_05_031.png" alt="지진 보고서">
			<span id="rtu_name" class="title_locate mL20"></span>
            <select id="area_code" name="area_code" class="fL mL10 mT3">
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
            <div class="unit">[단위 : mm]</div>
		</div>
		
		<canvas id="graph"></canvas><!-- 그래프 -->
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left80_np"> 
					검색 기간 :
					&nbsp;
					<input type="radio" name="type" value="N" class="btn_radio" <?if($type == "N"){echo "checked";}?>>연간 
					<input type="radio" name="type" value="D" class="btn_radio" <?if($type == "D"){echo "checked";}?>>월간 
					<input type="radio" name="type" value="H" class="btn_radio" <?if($type == "H"){echo "checked";}?>>일간 
					<button type="button" id="btn_left" class="btn_lbs_arr">
						<img src="../images/arr_b.png" alt="◀">
					</button>
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<button type="button" id="btn_right" class="btn_lbs_arr">
						<img src="../images/arr_f.png" alt="▶">
					</button>
					&nbsp;&nbsp;
					<img src="../images/icon_cal.png" alt="달력보기" id="btn_img">
					&nbsp;&nbsp;
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
							<th class="li10 bR_1gry">구분</th>
							<? for($i=$scnt; $i<=$ecnt; $i++){ ?>
							<th class="li3"><?=($i < 10) ? "0".$i : $i?></th>
							<? } ?>
							<th class="li3 bL_1gry">누계</th>
						</tr>	
					</thead>
			        <tbody>
					<? 
					if($data_list){
						foreach($data_list as $key => $val){ 
					?>
					<tr class="hh">
						<td class="li10 bR_1gry"><?=$val['RTU_NAME']?></td>
						<? if($val['LIST']){ ?>
							<? foreach($val['LIST'] as $key2 => $val2){ ?>
							<td class="li3"><?=$val2?></td>
							<? } ?>
						<? } ?>
						<td class="li3 bL_1gry"><?=$val['SUM']?></td>
					</tr>
					<? 
						}
					}
					?>	
					<tr class="bg_lgr">
						<td class="li10 bg_lb bR_1gry">최고</td>
					<? 
					if($data_row['MAX']){
						foreach($data_row['MAX'] as $key => $val){ 
					?>
						<td class="li3"><?=$val?></td>
					<? 
						}
					}
					?>
						<td class="li3 bL_1gry"><?=$data_row['MAX_SUM']?></td>
					</tr>
					<tr class="bg_lgr">
						<td class="li10 bg_lb bR_1gry">최저</td>
					<? 
					if($data_row['MIN']){
						foreach($data_row['MIN'] as $key => $val){ 
					?>
						<td class="li3"><?=$val?></td>
					<? 
						}
					}
					?>
						<td class="li3 bL_1gry"><?=$data_row['MIN_SUM']?></td>
					</tr>
					<tr class="bg_lgr">
						<td class="li10 bg_lb bR_1gry">평균</td>
					<? 
					if($data_row['AVR']){
						foreach($data_row['AVR'] as $key => $val){ 
					?>
						<td class="li3"><?=$val?></td>
					<? 
						}
					}
					?>	
						<td class="li3 bL_1gry"><?=$data_row['AVR_SUM']?></td>
					</tr>
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
		graph_on();
	});
	
	// 달력 호출
	datepicker(2, "#sdate", "", "yy-mm-dd");

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
            		$("#form_search").submit();
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_s",
	            autoPrint: true,
	            title: "강우 보고서",
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
	
	// 좌측 버튼
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
	});

	// 그래프 호출
	var chart = null;
	function graph_on(){
    	if(chart) chart.destroy();
    	
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_rpt_json.php",
		    data: { "mode" : "rain", "area_code" : $("#area_code").val(), "type" : "<?=$type?>", "sdate" : "<?=$sdate?>" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        //console.log(data);
		        var LEG, DATA = [];		
		        var MAX, MIN, INCRE = null;

		        if(data.list){
		        	LEG = data.list.LEG;
		        	DATA = data.list.DATA;
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

				chart = new Chart($("#graph"), {
				    type: 'bar',
				    data: {
				        labels: LEG,
				        datasets: [{
				            label: '강우',
				            data: DATA,
							yAxisID: 'y_rain',
				            backgroundColor: '#c3dcf5',
				            borderColor: '#c3dcf5',
				            borderWidth: 1
				        }]
				    },
				    options: {
				        legend: {
				            labels: {
				                generateLabels: function(chart){
				                    labels = Chart.defaults.global.legend.labels.generateLabels(chart);
				                    labels[0].fillStyle = '#96c6f7';
				                    labels[0].strokeStyle = '#96c6f7';
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
							        return {
					                    borderColor: '#9bc9f7',
							            backgroundColor : '#9bc9f7'
							        }
								}
							}
						},
				        scales: {
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
				                    fontColor: '#666',
				                    padding: 5,
				                    callback: function(value, index, values){
				                        return toFixedOf(value, 1);
				                    },
		                        	beginAtZero: true,
                                    suggestedMin: MIN,
                                    suggestedMax: MAX,
                                 	//stepSize: INCRE,
		                            maxTicksLimit: 10
				                }, 
				                gridLines: {
				                	display: false,
				                	color: '#666',
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
	}
	
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


