<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_alarmlog.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	

		<div class="main_contitle">
			<img src="../images/title_05_07.png" alt="이벤트 로그">
		</div>
		<div class="right_bg">
		<form id="form_search" action="rpt_alarmlog.php" method="get">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left80_rpt"> 
					&nbsp;
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
				<table id="list_table" class="tb_data bb_3blue">
					<thead class="tb_data_tbg">
						<tr>
							<th class="bR_1gry">순번</th>
							<th class="bR_1gry">단계</th>
							<th class="bR_1gry">종류</th>
							<th class="bR_1gry">원인지역</th>
							<th class="bR_1gry">원인자료</th>
							<th class="bR_1gry">발생시각</th>
							<!-- <th class="bR_1gry">방송송출여부</th> -->
						</tr>
					</thead>
			        <tbody>
					<? 
					if($data_alert){
						foreach($data_alert as $key => $val){ 
					?>
						<tr id="lb<?=$key + 1?>" class="pointer">
							<td class="bR_1gry"><?=$key + 1?></td>
							<td class="bR_1gry">
							<?
							if($val['EVENT_CODE'] == "19" || $val['EVENT_CODE'] == "23" || $val['EVENT_CODE'] == "101"){ echo "주의보"; }
							else if($val['EVENT_CODE'] == "20" || $val['EVENT_CODE'] == "25" || $val['EVENT_CODE'] == "102"){ echo "경보"; }
							else if($val['EVENT_CODE'] == "21" || $val['EVENT_CODE'] == "27" || $val['EVENT_CODE'] == "103"){ echo "대피"; }
							else if($val['EVENT_CODE'] == "37" || $val['EVENT_CODE'] == "33" || $val['EVENT_CODE'] == "104"){ echo "4단계"; }
							else if($val['EVENT_CODE'] == "38" || $val['EVENT_CODE'] == "35" || $val['EVENT_CODE'] == "104"){ echo "5단계"; }
							?>
							</td>
							<td class="bR_1gry"><? $tmpBr = explode(" ", $val['EVENT_BRANCH']);	echo $tmpBr[0]; ?></td>
							<td class="bR_1gry"><?=$val['RTU_NAME']?><input type="hidden" value="<?=$val['AREA_CODE']?>"></td>
							<td class="bR_1gry">
							<?
							if($val['EVENT_CODE'] >= "19" && $val['EVENT_CODE'] <= "22") {
								$fixNum = 10;
								$unitNum = 1;
								$unitText = "mm";
							}else if($val['EVENT_CODE'] >= "23" && $val['EVENT_CODE'] <= "29") {
								$fixNum = 100;
								$unitNum = 0.01;
								$unitText = "m";
							}else if($val['EVENT_CODE'] >= "101" && $val['EVENT_CODE'] <= "108") {
								$fixNum = 100;
								$unitNum = 0.0001;
								$unitText = " ˚ ";
							}else{
								$fixNum = 0;
								$unitNum = 1;
								$unitText = "";
							}
								echo round_data($val['EVENT_VALUE'], $unitNum, $fixNum).$unitText;	
							?>
							</td>
							<td class="bR_1gry"><?=$val['EVENT_DATE']?></td>
							<!-- <td id="rtu_<?=$val['RTU_ID']?>" class="bR_1gry"></td> -->
						</tr>
					<? 
						}
					}
					?>
					</tbody>
				</table>
			</li>
		</ul>

		</form>
		
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){

	$("#list_table tbody tr").click(function(){
		var tr_id = this.id;
		var mode = $("#"+tr_id+" td:nth-child(3)").html();
		var date = $("#"+tr_id+" td:nth-child(6)").html();
		var area_code = $("#"+tr_id+" input").val();
		
		if(mode == '강우'){ mode = 'rain'; }
		else if(mode == '수위'){ mode = 'wl'; }
		else if(mode == '변위'){ mode = 'displace'; }
		goReport(mode,area_code,date);
	});

	function goReport(mode,area_code,date){
		var tmpDt = date.substr(0,10);
		// if(tmpMd == 'flow') tmpMd = 'wl';
		location.href = "./rpt_"+mode+".php?area_code="+area_code+"&type=H&sdate="+tmpDt;
	}

	$("#rpt_type").change(function(){
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
        	{className: "al_C", targets: "_all"}
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
	            title: "경보 로그",
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
	                      $(col[1]).attr("width", 10);
	                      $(col[2]).attr("width", 10);
	                      $(col[3]).attr("width", 10);
	                      $(col[4]).attr("width", 10);
	                      $(col[5]).attr("width", 10);
	                      $(col[6]).attr("width", 20);
	                      $(col[7]).attr("width", 20);
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


