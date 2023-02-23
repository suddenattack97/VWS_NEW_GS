<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측섹션 끝-->

<div id="popup_total_overlay" class="popup_total_overlay"></div>
<div id="popup_total_layout" class="popup_total_layout">
	<div class="popup_top">방송전송 이력<span id="title"></span>

		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
		<button id="popup_move" class="btn_pop_blue fR bold" style="position:relative;left:-50px;">방송 상세 페이지</button>
	</div>
	<div class="popup_con">
	    <div id="list_view" class="alarm popup_big">
            <div id="spin"></div>
	    	<table class="tb_data_p">
	    		<tr>
	    			<th class="bg_lgr">사용자 정보</th>
	    			<td><span id="USER_ID_POP"></span></td>
	    			<th class="bg_lgr">전송 유형</th>
	    			<td><span id="IS_PLAN_GUBUN_POP"></span></td>
	    			<th class="bg_lgr">전송 시작 시각</th>
	    			<td><span id="LOG_DATE"></span></td>
	    		</tr>
	    		<tr>
	    			<th class="bg_lgr">방송문안</th>
	    			<td colspan="5" class="al_L"><span id="SCRIPT_BODY"></span></td>
	    		</tr>
	    	</table>
			<div class="w100 yauto" style="height:456px;">
				<table class="tb_data">
					<thead>
						<tr class="tb_data_tbg">
							<th>장비 ID</th>
							<th>장비명</th>
							<th>방송전송여부</th>
							<!-- <th>2차망 전송결과</th> -->
							<th>에러 정보</th>
							<th>최종 로깅시각</th>
							<th>녹음파일</th>
						</tr>
					</thead>
					<tbody id="list_state">
					</tbody>
				</table>
	    	</div>
	    </div>    
	</div>
</div>
<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div id="spin"></div>
	<div class="popup_top">메인화면 레이아웃 설정 
		<button id="popup_close" class="btn_pop_blue fR bold  mT-5">X</button>
		<button id="lay_submit" class="btn_pop_blue fR bold mR5 w60p  mT-5">저장</button>
	</div>
	<div class="popup_con">
		<li class="tb_alarm mB8" style="height: 142px;">
			<div class="alarm bB_1gry">
				<ul class="bg_w">
					<li class="alarm_gry bg_blue02">화면구성 선택</li>
					<li id="lay_sel">
						<div id="lay_1_sel" class="main_popup_sel">
							<img src="../images/main_layout_01.png"/>
						</div>
						<div id="lay_2_sel" class="main_popup_sel">
							<img src="../images/main_layout_02.png"/>
						</div>
						<div id="lay_3_sel" class="main_popup_sel">
							<img src="../images/main_layout_03.png"/>
						</div>
						<div id="lay_4_sel" class="main_popup_sel">
							<img src="../images/main_layout_04.png"/>
						</div>
						<div id="lay_5_sel" class="main_popup_sel">
							<img src="../images/main_layout_05.png"/>
						</div>
						<div id="lay_6_sel" class="main_popup_sel mR0">
							<img src="../images/main_layout_06.png"/>
						</div>
					</li>
				</ul>
			</div>
		</li>
		<li class="tb_alarm" style="height: 452px; margin-bottom: 8px;">
			<div class="alarm bB_1gry">
				<ul>
					<li class="alarm_gry bg_blue02">구성 항목별 설정</li>
					<li id="lay_view">
						<div id="lay_1" class="lay_1">
							<ul   class="bg_w">
								<li data-length="10">영역 내 표시 항목 선택<br/>
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="lay_2" class="lay_2">
							<ul>
								<li data-length="10"  class="bg_w">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="10" class="mR0 bg_w">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="lay_3" class="lay_3">
							<ul>
								<li data-length="4"  class="bg_w">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="4" class="mB0 bg_w">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="lay_4" class="lay_4">
							<ul>
								<li data-length="2" class="mB8 mR0 h125p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="6" class="w328p h260p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="6" class="w328p h260p mR0">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="lay_5" class="lay_5">
							<ul>
								<li data-length="6" class="mB8 w328p h260p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="6" class="mB8 w328p h260p mR0">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="2" class="mB0 mR0 h125p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="lay_6" class="lay_6">
							<ul>
								<li data-length="2" class="mB8 mR0 h125p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="2" class="mB8 w328p h125p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="2" class="mB8 w328p h125p mR0">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
								<li data-length="2" class="mB0 mR0 h125p">영역 내 표시 항목 선택<br/> 
									<div class="w100 fL">
										<select name="ival[]" class="mL0 fL">
										</select>
										<div class="fL mL5">
											<i style="cursor: pointer;"><img src="../images/plus.gif" /></i>
										</div>
										<div class="fL mL5">
											<d style="cursor: pointer;"><img src="../images/minus.gif" /></d>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</li>
	</div>

<!--레이아웃 끝-->

<script type="text/javascript">
$(document).ready(function(){
	localStorage.setItem("layout","tms_main.php");
    var lay_option = ''; // 영역 내 표시 항목 옵션

    layout_option(); // 레이아웃 옵션 호출
	layout_load(); // 레이아웃 및 데이터 호출

	// load_time마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		table_update();
	}, common_load_time);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}

	history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
	};

	// 레이아웃 옵션 호출
	function layout_option(){
	    lay_option += '<option value="0">선택</option>';
	    
	    $.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "layout_ival" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
				if(data.layout_ival){
			        $.each(data.layout_ival, function(i, v){
			        	lay_option += '<option value="'+v.lay_ival+'">'+v.lay_text+'</option>';
			        });
				}   
				$.each( $("#lay_sel div"), function(index, value){
					$("#lay_"+(index+1)+" select").html(lay_option);
				});
	        }
	    });
	}
	var ajax_var = "";
	// 레이아웃 호출
	function layout_load(){
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "layout" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.layout){
		        	var lay_case = data.layout[0]['lay_case'];
					var lay_html = '';		

			        $("#lay_"+lay_case+"_sel").trigger("click");
			        
			        if(data.layout_item){
			            $.each(data.layout_item, function(i, v){
							if( $("#lay_"+lay_case+" li").eq(v.lay_area - 1).find("select").eq(v.lay_item - 1)[0] == null ){
								var lay_html = '';
								lay_html += ' <div class="w100 fL"> ';
								lay_html += ' 	<select name="ival[]" class="mL0 fL"> ';
								lay_html += lay_option;
								lay_html += ' 	</select> ';
								lay_html += ' 	<div class="fL mL5"> ';
								lay_html += ' 	<i style="cursor: pointer;"><img src="../images/plus.gif" /></i> ';
								lay_html += ' 	</div> ';
								lay_html += ' 	<div class="fL mL5"> ';
								lay_html += ' 	<d style="cursor: pointer;"><img src="../images/minus.gif" /></d> ';
								lay_html += ' 	</div> ';
								lay_html += ' </div> ';
								$("#lay_"+lay_case+" li").eq(v.lay_area - 1).append(lay_html);
							}
				            
							$("#lay_"+lay_case+" li").eq(v.lay_area - 1)
							.find("select").eq(v.lay_item - 1)
							.find("option[value="+v.lay_ival+"]").attr("selected", "selected");
			            });
		        	} 
			        
					if(lay_case == 1){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb_w"></li> ';
						lay_html += ' </ul> ';
					}else if(lay_case == 2){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb"></li> ';
						lay_html += '	<li class="mi"></li> ';
						lay_html += ' 	<li id="area_2" class="tb"></li> ';
						lay_html += ' </ul> ';
					}else if(lay_case == 3){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb_w"></li> ';
						lay_html += ' </ul> ';
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_2" class="tb_w"></li> ';
						lay_html += ' </ul> ';
					}else if(lay_case == 4){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb_w"></li> ';
						lay_html += ' </ul> ';
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_2" class="tb"></li> ';
						lay_html += '	<li class="mi"></li> ';
						lay_html += ' 	<li id="area_3" class="tb"></li> ';
						lay_html += ' </ul> ';
					}else if(lay_case == 5){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb"></li> ';
						lay_html += '	<li class="mi"></li> ';
						lay_html += ' 	<li id="area_2" class="tb"></li> ';
						lay_html += ' </ul> ';
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_3" class="tb_w"></li> ';
						lay_html += ' </ul> ';
					}else if(lay_case == 6){
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_1" class="tb_w"></li> ';
						lay_html += ' </ul> ';
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_2" class="tb"></li> ';
						lay_html += '	<li class="mi"></li> ';
						lay_html += ' 	<li id="area_3" class="tb"></li> ';
						lay_html += ' </ul> ';
						lay_html += ' <ul class="main_twrap"> ';
						lay_html += ' 	<li id="area_4" class="tb_w"></li> ';
						lay_html += ' </ul> ';
					}
		        	$("#content").html(lay_html);
		        	if(data.layout_item){
			            $.each(data.layout_item, function(i, v){
			                var lay_id = "#item_"+v.lay_item;
							var lay_html = '';	

				            if(v.lay_item > 1){
					    		lay_html += ' <div style="width:100%; height:20px"></div> ';
				            }
				            lay_html += ' <div id="item_'+v.lay_item+'"></div> ';
				            $("#area_"+v.lay_area).append(lay_html);
			            });
			            $.each(data.layout_item, function(i, v){
			                var lay_id = "#area_"+v.lay_area+" #item_"+v.lay_item;
							if(v.lay_ival == 1){ // 강우현황
								rain_table(1, lay_id);
								// rain_emd_table(1, lay_id);
								ajax_var += "rain_t,";
							}else if(v.lay_ival == 2){ // 수위현황
								flow_table(1, lay_id);
								// flow_main_table(1, lay_id);
								ajax_var += "flow_t,";
							}else if(v.lay_ival == 3){ // aws현황
								aws_table(1, lay_id);
								// aws_main_table(1, lay_id);
								ajax_var += "aws_t,";
							}else if(v.lay_ival == 4){ // 적설현황
								snow_table(1, lay_id);
								ajax_var += "snow_t,";
							}else if(v.lay_ival == 5){ // 지도현황
								if(lay_case == 1 || lay_case == 2){
									map_table_full(1, lay_id);
								}else{
									map_table(1, lay_id);
								}
								ajax_var += "displace_t,";
							// }else if(v.lay_ival == 6){ // 지진현황
							// 	eqk_table(1, lay_id);
							// 	ajax_var += "eqk_t,";
							// }else if(v.lay_ival == 6){ // 방송현황
							// 	alarm_table(1, lay_id);
							// 	ajax_var += "alt_t,";
							}else if(v.lay_ival == 7){ // 경보현황
								alert_table(1, lay_id);
								ajax_var += "alarm_t,";
							}else if(v.lay_ival == 8){ // 장비상태
								equip_table(1, lay_id);
								ajax_var += "state_t,";
							}
			            });
		        	}
		        }
				
				var tmp_split = ajax_var.split(",");
				var tmp_data = tmp_split.filter(isNotEmpty);
				var ajax_data = "";


				$.each(tmp_data, function(i, v){
					//console.log(i ,v);
					if(i == (tmp_data.length - 1)){
						ajax_data += v; 
					}else{
						ajax_data += v+",";
					}
					//ajax_data += 
				});
			
				$.when(tmp_data).done(function(i, v) {
					table_cnt(i); // 모든 테이블이 완료되면, 카운트를 시작한드아
				});
	        }
		});
		function isNotEmpty(value){
			return value != "";
		}
	}
	
	function table_cnt(cnt){
		return cnt;
	}

	// 테이블 업데이트
	function table_update(){
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "layout" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	if(data.layout_item){
		            $.each(data.layout_item, function(i, v){
		                var lay_id = "#area_"+v.lay_area+" #item_"+v.lay_item;

						if(v.lay_ival == 1){ // 강우현황
							rain_table(2, lay_id);
							// rain_emd_table(2, lay_id);
						}else if(v.lay_ival == 2){ // 수위현황
							flow_table(2, lay_id);
							// flow_main_table(2, lay_id);
						}else if(v.lay_ival == 3){ // aws현황
							aws_table(2, lay_id);
							// aws_main_table(2, lay_id);
						}else if(v.lay_ival == 4){ // 적설현황
							snow_table(2, lay_id);
						}else if(v.lay_ival == 5){ // 지도현황
							map_table(2, lay_id);
						// }else if(v.lay_ival == 6){ // 지진현황
						// 	eqk_table(2, lay_id);
						// }else if(v.lay_ival == 6){ // 방송현황
						// 	alarm_table(2, lay_id);
						}else if(v.lay_ival == 7){ // 경보현황
							alert_table(2, lay_id);
						}else if(v.lay_ival == 8){ // 장비상태
							equip_table(2, lay_id);
						}
		            });
	        	}
	        }
     	});
	}

	// 레이아웃 스위치
	function layout_switch(num){
		for(var i = 0; i < 6; i ++){
			if(i == num){
				$("#lay_"+(i+1)).show();
				$("#lay_"+(i+1)+"_sel").addClass("sel_on");
			}else{
				$("#lay_"+(i+1)).hide();
				$("#lay_"+(i+1)+"_sel").removeClass("sel_on");
			}
		}
	}
	
	// 레이아웃 화면구성 선택
	$.each( $("#lay_sel div"), function(index, value){
		$("#"+value.id).click(function(){
			layout_switch(index);
		});
	});
	
	// 레이아웃 영역 내 표시 항목 추가
	$(document).on("click","#lay_view i",function(e){
		var el_li = $(e.target).closest("li")[0];
		var el_length = $(el_li).children("div").length;
		var el_max = $(el_li).data("length");

		if( el_length < el_max ){
			var lay_html = '';
			lay_html += ' <div class="w100 fL"> ';
			lay_html += ' 	<select name="ival[]" class="mL0 fL"> ';
			lay_html += lay_option;
			lay_html += ' 	</select> ';
			lay_html += ' 	<div class="fL mL5"> ';
			lay_html += ' 	<i style="cursor: pointer;"><img src="../images/plus.gif" /></i> ';
			lay_html += ' 	</div> ';
			lay_html += ' 	<div class="fL mL5"> ';
			lay_html += ' 	<d style="cursor: pointer;"><img src="../images/minus.gif" /></d> ';
			lay_html += ' 	</div> ';
			lay_html += ' </div> ';
			$(e.target).closest("li").append(lay_html);
		}else{
		    swal("체크", "해당 영역의 최대 항목 개수는 "+el_max+"개 입니다.", "warning");
		}
	});
	
	// 레이아웃 영역 내 표시 항목 삭제
	$(document).on("click","#lay_view d",function(e){
		var el_li = $(e.target).closest("li")[0];
		var el_length = $(el_li).children("div").length;
		
		if( el_length > 1 ){
			$(e.target).parents("div")[1].remove();
		}else{
		    swal("체크", "영역마다 최소 1개 이상의 항목이 있어야 합니다.", "warning");
		}
	});
	
	// 레이아웃 저장 버튼
	$("#lay_submit").click(function(){
		var lay_data = []; // param
		var lay_zero = false; // check
		
		var lay_idx = null;
		$.each( $("#lay_sel div"), function(i, v){
			if( $(v).hasClass("sel_on") ) lay_idx = i;
		});

		var lay_li = $("#lay_"+(lay_idx + 1)+" li");
        $.each(lay_li, function(i, v){ // i = area, v = array selectbox
			lay_data[i] = [];
			$.each($(v).find("select"), function(i2, v2){
				if(v2.value == "0") lay_zero = true;
				lay_data[i].push(v2.value);
			});
		});
		
		if(lay_idx == null){
		    swal("체크", "화면구성을 선택해 주세요.", "warning");
			return false;
		}else if(lay_zero){
		    swal("체크", "모든 영역의 항목을 선택해 주세요.", "warning");
			return false;
		}

		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: { "mode" : "layout_save", "lay_case": (lay_idx + 1), "data" : lay_data },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		    	if(data){
                	popup_main_close(); // 레이어 좌측 및 상단 닫기
		    		location.reload(); return false;
		    	}else{
				    swal("체크", "레이아웃 저장중 오류가 발생 했습니다.", "warning");
		    	}
	        },
	        beforeSend : function(data){ 
	   			tmp_spin = spin_start("#popup_layout #spin", "300px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#popup_layout #spin");
	        	}
	        }
		});
	});
});
</script>

</body>
</html>


