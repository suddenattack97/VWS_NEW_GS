<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_10m.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right" style="overflow-y: hidden;">
	<!--본문내용섹션-->
	<div class="product_state" style="overflow-y: hidden;">
	<div id="content">
		
		<form id="form_search" action="rpt_10m.php" method="post">
		
		<div class="main_contitle">
			<div class="tit"><img src="../images/board_icon_aws.png"> <span>상세 보고서</span></div>
            <!-- <div class="unit">[강우 : mm] [수위 : m] [적설 : cm]</div>
			<div class="unit2" style="float:right; margin-right: 10px;">※ 데이터 클릭시 해당 보고서로 이동합니다.</div> -->
		</div>
		<div class="right_bg2">
		<ul id="search_box">
			<li>
				<span class="tit"> 
					구분 :
					<select id="option" name="option">
						<option value="0" <?if($option == "0"){echo "selected";}?>>강우</option>
						<option value="1" <?if($option == "1"){echo "selected";}?>>수위</option>
						<option value="2" <?if($option == "2"){echo "selected";}?>>적설</option>
						<option value="3" <?if($option == "3"){echo "selected";}?>>온도</option>
						<option value="4" <?if($option == "4"){echo "selected";}?>>풍속</option>
						<option value="5" <?if($option == "5"){echo "selected";}?>>습도</option>
					</select>
					&nbsp;&nbsp;
					지역 :
					<select id="area_code" name="area_code">
						<? 
						if($data_sel){
							foreach($data_sel as $key => $val){ 
						?>
							<option value="<?=$val['AREA_CODE']?>" <?if($area_code == $val['AREA_CODE']){echo "selected";}?>><?=$val['RTU_NAME']?></option>
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
					검색 기간 :
					<button type="button" id="btn_left" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<button type="button"  id="btn_right"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
					<img src="../images/icon_cal.png" alt="달력보기" id="btn_img1" style="margin-bottom: -9px !important;">
					&nbsp;
					<span class="mL3">-</span>
					&nbsp;
					<button type="button" id="btn_left2" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					<button type="button"  id="btn_right2"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
					<img src="../images/icon_cal_r.png" alt="달력보기" id="btn_img2" style="margin-bottom: -9px !important;">

				</span>
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
		</ul>
		<ul class="stitle_box">
		    <!-- <li><?=$sdate?></li> -->
		    <li>[단위 : <span id="uni">mm</span>]</li>
		</ul>
		<ul class="set_ulwrap_nh">
			<li class="bg_dk_gry1d" style="width:100%;">
				<table class="tb_data pB0">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li69">그래프</th>
							<th class="li13 bL_1gry">시간</th>
							<?if($option == "4"){ ?>
								<th class="li14 bL_1gry">풍향/풍속(m/s)</th>
								<? }else{ ?>
								<th class="li14 bL_1gry">자료</th>
							<? } ?>
						</tr>
					</thead>
				</table>
			</li>
			<li class="li100_nor_left bg_dk_gry1d">
				<canvas id="graph10m"></canvas><!-- 그래프 -->
			</li>
			<li class="li100_nor_rignt">
				<table id="list_table" class="tb_data pB0 lbdg">
					<thead>
						<tr>
							<th class="dp0"></th>
							<th class="dp0"></th>
						</tr>
					</thead>
			        <tbody>
						<?
						if($data_list){
							foreach($data_list as $key => $val){ 
						?>
						<tr class="hh" id="<?=$val['DATE']?>">
							<td id="date" class="li50"><?=$val['DATE']?></td>
							<? if($val['DATA'] > 0 && ($option == "0" || $option == "2")){ ?>
								<td class="li50 bL_1gry txtcolor_r">
							<? } else { ?>
								<td class="li50 bL_1gry">
							<? } ?>
								<span class="effect">
									<?if($option == "4"){ ?>
										<img src="<?=$val['DEG']?>"/>
									<? } ?>
									<?=$val['DATA']?>
								</span>
							</td>
						</tr>
						<? 
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

	// 초기값 - 강우
	var mode = $("#option").val();

	// mode 값 변경
	if(mode == '1'){ mode = 'flow'; $('#uni').html('m'); }
	else if(mode == '2'){ mode = 'snow'; $('#uni').html('cm'); }
	else if(mode == '3'){ mode = 'temp'; $('#uni').html('℃'); }
	else if(mode == '4'){ mode = 'wind'; $('#uni').html('㎧'); }
	else if(mode == '5'){ mode = 'humi'; $('#uni').html('%'); }
	else{ mode = 'rain'; $('#uni').html('mm'); }

	//클릭 시 레포트 이동
	// $(".hh").click(function(){
	// 	var date = this.id;
	// 	goReport(date);
	// });

	function goReport(date){
		var tmpMd = mode;
		var tmpDt = date.substr(0,10);
		if(tmpMd == 'flow') tmpMd = 'wl';
		location.href = "./rpt_"+tmpMd+".php?area_code="+area_code+"&type=H&sdate="+tmpDt;
	}

	//클릭 시 스크롤 이동
	function goTarget(idx){
		var firstOffset = $("#list_table tr").eq(0).offset();
		var offset = $("#list_table tr").eq(idx+1).offset();
		// console.log($("#list_table tr").eq(idx+1).html());
		$('.li100_nor_rignt').animate({scrollTop : offset.top - firstOffset.top}, 400);
		
		// 전체 blink 클래스 삭제 후 blink 클래스 추가
		$("#list_table tr .effect").removeClass('blink');
		$("#list_table tr").eq(idx+1).find('.effect').addClass('blink');
	}

	// 그래프 호출
	if(area_code != "") graph_on();

	// 그래프 호출
	var chart = null;
	function graph_on(){
		
    	if(chart) chart.destroy();

		var tempMode = $("#option option:selected").text();
		var tempArea = $("#area_code").val();

		$.ajax({
	        type: "POST",
	        url: "../_info/json/_rpt_json.php",
		    data: { "mode" : mode+"_10m", "area_code" : $("#area_code").val(), "type" : "M", "sdate" : "<?=$sdate?>", "edate" : "<?=$edate?>" },
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
				
				// console.log(data.list);
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
								// if(LEGD[idx].substr(11, 5) == '00:00'){
								// 	var tmpLeg = LEGD[idx].substr(5, 11);
								// }else{
								// 	tmpLeg = LEGD[idx].substr(11, 5); 
								// }
								// x축 중복제거
								// if($.inArray(tmpLeg, uniqeArr) === -1) uniqeArr.push(tmpLeg);
								// 기준치 부분
								// if(mode == 'flow'){
								// 	DATA1[idx] = v.DATA1;
								// 	DATA2[idx] = v.DATA2;
								// 	DATA3[idx] = v.DATA3;
								// 	DATA4[idx] = v.DATA4;
								// 	DATA5[idx] = v.DATA5;
								// }
								DATAD[idx] = v.DATA;
								// LEGD[idx] = tmpLeg;
							}
						}
						idx++;
					});
					// 중복제거
					// LEGD = uniqeArr;
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
	       		//console.log("MAX:"+MAX, "MIN:"+MIN, "INC:"+INCRE);
				// if(mode == 'flow'){
					
				// 	chart = new Chart($("#graph10m"), {
				// 		type: 'line',
				// 		data: {
				// 			labels: LEGD,
				// 			datasets: [{
				// 	            label: '<?=level_1?>',
				// 	            data: DATA1,
				// 				yAxisID: 'y_flow',
				// 	            backgroundColor: '#008000',
				// 	            borderColor: '#008000',
				// 	            borderWidth: 2,
				// 				fill: false,
				// 	            pointRadius: 0
				// 	        }, {
				// 	            label: '<?=level_2?>',
				// 	            data: DATA2,
				// 				yAxisID: 'y_flow',
				// 	            backgroundColor: '#ff8017',
				// 	            borderColor: '#ff8017',
				// 	            borderWidth: 2,
				// 				fill: false,
				// 	            pointRadius: 0
				// 	        }, {
				// 	            label: '<?=level_3?>',
				// 	            data: DATA3,
				// 				yAxisID: 'y_flow',
				// 	            backgroundColor: '#ff0000',
				// 	            borderColor: '#ff0000',
				// 	            borderWidth: 2,
				// 				fill: false,
				// 	            pointRadius: 0
				// 	        }, {
				// 	            label: '<?=level_4?>',
				// 	            data: DATA4,
				// 				yAxisID: 'y_flow',
				// 	            backgroundColor: '#8b17ff',
				// 	            borderColor: '#8b17ff',
				// 	            borderWidth: 2,
				// 				fill: false,
				// 	            pointRadius: 0
				// 	        }, {
				// 	            label: '<?=level_5?>',
				// 	            data: DATA5,
				// 				yAxisID: 'y_flow',
				// 	            backgroundColor: '#260030',
				// 	            borderColor: '#260030',
				// 	            borderWidth: 2,
				// 				fill: false,
				// 	            pointRadius: 0
				// 	        }, {
				// 				label: tempMode,
				// 				data: DATAD,
				// 				yAxisID: 'y_rain',
				// 				backgroundColor: '#c3dcf5',
				// 				borderColor: '#c3dcf5',
				// 				borderWidth: 1
				// 			}]
				// 		},
				// 		options: {
				// 			onClick: function(evt, activeElements) {
				// 				var elementIndex = activeElements[0]._index;
				// 				// console.log(this.data.labels[elementIndex]);
				// 				goReport(this.data.labels[elementIndex]);
				// 			// this.data.datasets[0].backgroundColor[elementIndex] = 'red';
				// 			// this.update();
				// 			},
				// 			elements: {
				// 				line: {
				// 					tension: 0
				// 				}
				// 			},
				// 			legend: {
				// 	            labels: {
				// 	                generateLabels: function(chart){
				// 	                    labels = Chart.defaults.global.legend.labels.generateLabels(chart);
				// 	                    $.each(labels, function(i, v){
				// 		                    // if(v.text == "수위"){
				// 			                    labels[i].fillStyle = '#69F';
				// 			                    labels[i].strokeStyle = '#69F';
				// 		                    // }
				// 	                    });
				// 	                    return labels;
				// 	                }
				// 	            }
				// 	        },
				// 			tooltips: {
				// 				position: 'nearest',
				// 				mode: 'index',
				// 				intersect: false,
				// 				filter: function(item, data){
				// 					data = data.datasets[item.datasetIndex].data[item.index];
				// 					return !isNaN(data) && data !== null;
				// 				},
				// 				callbacks: {
				// 					labelColor: function(tooltipItem, chart){
				// 				        dataset = chart.config.data.datasets[tooltipItem.datasetIndex];
				// 				        if(dataset.label == "수위"){
				// 					        return {
				// 			                    borderColor: '#69F',
				// 					            backgroundColor : '#69F'
				// 					        }
				// 			        	}else{
				// 					        return {
				// 		                    	borderColor: dataset.borderColor,
				// 				            	backgroundColor : dataset.backgroundColor
				// 				        	}
				// 				        }
				// 					}
				// 				}
				// 			},
				// 			scales: {
								
				// 				yAxes: [{
				// 					id: 'y_left', // 좌측 여백 + 눈금
				// 					ticks: {
				// 						display: false
				// 					}, 
				// 					gridLines: {
				// 						display: false,
				// 						drawOnChartArea: false,
				// 						drawTicks: false
				// 					},
				// 					afterFit: function(scale){
				// 						scale.width = 20;
				// 					}
				// 					}, {
				// 					id: 'y_flow', // 강우
				// 					ticks: {
				// 						fontColor: '#666',
				// 						padding: 5,
				// 						callback: function(value, index, values){
				// 							return toFixedOf(value, 2);
				// 						},
				// 						beginAtZero: true,
				// 						suggestedMin: MIN,
				// 						suggestedMax: MAX,
				// 						//stepSize: INCRE,
				// 						maxTicksLimit: 10
				// 					}, 
				// 					gridLines: {
				// 						display: false,
				// 						color: '#666',
				// 						lineWidth: 3,
				// 						drawOnChartArea: false,
				// 						drawTicks: false
				// 					},
				// 					afterFit: function(scale){
				// 						scale.width = 30;
				// 					}
				// 				}]
				// 			}
				// 		}
				// 	});
				// }else{
					chart = new Chart($("#graph10m"), {
						type: (mode == 'rain' || mode == 'snow') ? 'bar' : 'line',
						data: {
							labels: LEGD,
							datasets: [{
								label: tempMode,
								data: DATAD,
								yAxisID: 'y_rain',
								backgroundColor: '#c3dcf5',
								borderColor: '#c3dcf5',
								borderWidth: (mode == 'flow') ? 1 : 2,
								fill: (mode == 'flow') ? true : false
							}]
						},
						options: {
							onClick: function(evt, activeElements) {
								// console.log(this.data.labels[elementIndex]);
								if(activeElements.length > 0){
									var elementIndex = activeElements[0]._index;
									goTarget(elementIndex);
								}
							// this.data.datasets[0].backgroundColor[elementIndex] = 'red';
							// this.update();
							},
							elements: {
								line: {
									tension: 0
								}
							},
							legend: {
								labels: {
									fontColor: '#222',
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
								xAxes:[{
									ticks:{
									autoSkip : false,
									maxRotation :0,
									minRotation :0,
									fontColor: '#222'
									},

									display: true,
									scaleLabel: {
									display: true,
									labelString: ''
									},

									gridLines: {
										display: false
									},

									afterTickToLabelConversion: function(data){
										let xLabels = data.ticks;
										for(let i = 0; i<xLabels.length;i++){
										if ( (i >= 1) && (i <= xLabels.length-2) )
											xLabels[i] = '';
										else{
											// console.log(xLabels[i]);
										}
											// console.log(xLabels.length);
										}
									} 
								}],
								yAxes: [{
									id: 'y_left', // 좌측 여백 + 눈금
									ticks: {
										display: false
									}, 
									gridLines: {
										display: false,
										drawOnChartArea: false,
										drawTicks: false
									},
									afterFit: function(scale){
										scale.width = 20;
									}
									}, {
									id: 'y_rain', // 강우
									ticks: {
										fontColor: '#222',
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
										display: true,
										color: '#ccc',
										// lineWidth: 3,
										// drawOnChartArea: false,
										drawTicks: false,
										zeroLineColor :"#ccc",
          								zeroLineWidth : 2
									},
									afterFit: function(scale){
										scale.width = 30;
									}
								}]
							}
						}
					});
				// }// 기준치 분기 
	        } // ajax success end
		}); // ajax end
	}

	$("#graph10m").attr('height', '290');

	// 구분에 따른 지역 호출
	$("#option").change(function(){

		mode = $("#option").val();

		var param = "mode=option&option="+mode;

		$.ajax({
	        type: "POST",
	        url: "../_info/json/_rpt_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
                if(data.list){
					var opt_html = '';
                    $.each(data.list, function(i, v){
                    	opt_html += '<option value="'+v.AREA_CODE+'">'+v.RTU_NAME+'</option>';
                    });
                    $("#area_code").html(opt_html);
                }else{
                	$("#area_code").html('<option value="">장비 없음</option>');
                }
	        }
	    });

	});
	
	// 달력 호출
	datepicker(2, "#sdate", "", "yy-mm-dd");
	datepicker(2, "#edate", "", "yy-mm-dd");

	// 엑셀 검색기간 추가 
	var seText = "";
	seText = "검색기간 : " + $("#sdate").val() +" ~ "+ $("#edate").val();

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
					var sd = new Date($("#sdate").val());
					var ed = new Date($("#edate").val());
					if((ed - sd)/(1000*60*60*24) > 30){
						alert("한달 이상 검색할 수 없습니다.");
						return false;
					}else{
						$("#form_search").submit();
					}
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_s",
	            autoPrint: true,
	            title: "상세 보고서",
                customize: function(win){
                    $(win.document.body).find("body").css("overflow", "visible");
                    $(win.document.body).find("h1").css("text-align", "center").css("font-size", "18px");
                    $(win.document.body).find("table").css("font-size", "12px");
                    $(win.document.body).find("tr").css("text-align", "center");
				},  action: function(dt){
					$(".print_hd").hide();
					makeDivToImageFile($("#content")); // 보고서 캡쳐인쇄 함수호출
                }
	        },
	   		{
	        	extend: "excel",
	            text: "엑셀변환",
		        className: "btn_lbb80_s",
				filename: '상세 보고서_' + timestamp, 
	            title: "",
				messageTop: seText,
	            customize: function(xlsx){
	                var sheet = xlsx.xl.worksheets["sheet1.xml"];
	                //$("row:first c", sheet).attr("s", "42");
	                $("row c", sheet).attr("s", "51");
	                var col = $("col", sheet);
	                col.each(function(){
	                      $(col[0]).attr("width", 30);
	                      $(col[1]).attr("width", 20);
	               	});
	            }
	        }
	    ]
	}).container().appendTo($("#button"));

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
        $("#edate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
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
	
	// 뒤로가기 관련 처리
	$("select").each(function(){
		var select = $(this);
		var selectedValue = select.find("option[selected]").val();

		if(selectedValue){
			select.val(selectedValue);
		}
	});
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");
});
</script>

</body>
</html>