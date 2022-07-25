<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_ori.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
		<div class="product_state">
			<div id="content">
			<form id="form_search" action="rpt_rain.php" method="get">
				<div class="main_contitle">
					<div class="tit"><img src="../images/board_icon_aws.png"> <span>기본 보고서</span>
					</div>
				</div>
		<div class="right_bg3">
		<ul id="search_box">
					<li>
					<span class="tit">보고서 선택  : </span>
					<select id="option" name="option">
						<? 
						if($data_list){
							foreach($data_list as $key => $val){ 
						?>
							<option value="<?=$val['report_num']?>"><?=$val['report_name']?></option>
						<? 
							}
						}else{
						?>
							<option value="">보고서 없음</option>
						<?
						}
						?>	
						<!-- <option value="1">적설보고서</option>
						<option value="2">AWS보고서</option>
						<option value="3">수위보고서</option> -->
					</select>
					<span class="tit">검색 기간 : </span>
					<input type="radio" class="btn_radio" name="sel_date" value="A" checked><span class="tit">기간 </span>
					
					<input type="text" name="sdate" value="" id="sdate" class="f333_12" size="12" readonly="">
					<span class="mL3" style="display: inline;">-</span>
					<input type="text" name="edate" value="" id="edate" class="f333_12" size="12" readonly="" style="display: inline-block;">
					<i class="fa fa-clock-o i_tit"></i>
					<SELECT ID="HOUR" NAME='HOUR_END' class="gaigi mL_10 w60p">
						<?for($i=0;$i<24;$i++){?>
						<OPTION VALUE='<?=$i?>' <?if(date(G)==$i){echo 'selected';}?>><?=$i?></OPTION>
						<?}?>
					</SELECT>
				<span id="button" class="sel_right_n">
					
					<button type="button" id="btn_search" class="btn_bb80">검색</button>
 					<button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button> 
					 
					</li>
					</ul>

					<iframe class="set_iframe" id="prt_body" style="width:80em; height:125em;" src="http://192.168.1.53:9999/vws/template/common/intro.php?ctrl_mvc=ReportCustom&ctrl_tag=View&branch=searchReport&DATE_START=2021-09-23&DATE_END=2021-09-25&HOUR_END=15&REPORT_TYPE=1&print=p"></iframe>
					
					</div>
					<div id="sub_body"></div>
		</form>
		
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>

<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){

	var report_type = "1";
	$("#option").change(function(){
		report_type = $("#option").val();
	});

	$("#prt_body").attr('src','http://<?=$_SERVER['HTTP_HOST']?>/vws/template/common/intro.php?ctrl_mvc=ReportCustom&ctrl_tag=View&branch=searchReport&DATE_START='+$("#sdate").val()+'&DATE_END='+$("#edate").val()+'&HOUR_END='+$("#HOUR").val()+'&REPORT_TYPE='+report_type+'&print=p');

	$("#btn_search").click(function(){
		$("#prt_body").attr('src','http://<?=$_SERVER['HTTP_HOST']?>/vws/template/common/intro.php?ctrl_mvc=ReportCustom&ctrl_tag=View&branch=searchReport&DATE_START='+$("#sdate").val()+'&DATE_END='+$("#edate").val()+'&HOUR_END='+$("#HOUR").val()+'&REPORT_TYPE='+report_type+'&print=p');
	});

	$("#btn_print").click(function(){
		// window.open($("#prt_body").attr('src'));
		var popupWindow = window.open($('#prt_body').attr('src'), "인쇄", "width=725, height=935 , status=no");
		popupWindow.print();
	});

	$("#btn_excel").click(function(){
		location.href = "http://<?=$_SERVER['HTTP_HOST']?>/vws/template/common/intro.php?ctrl_mvc=ReportCustom&ctrl_tag=View&branch=searchReport&DATE_START="+$("#sdate").val()+"&DATE_END="+$("#edate").val()+"&HOUR_END="+$("#HOUR").val()+"&REPORT_TYPE="+report_type+"&print=e"; return false;
	});

	// 달력  호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd", null);
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd", null);
	$("#sdate").datepicker("setDate", new Date());
	$("#edate").datepicker("setDate", new Date());

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


