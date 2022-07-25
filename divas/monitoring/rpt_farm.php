<?
require_once "../_conf/_common.php";
require_once "../_info/_set_farm.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="form_search" method="POST">

		<div class="main_contitle">
			<img src="../images/title_05_09.png" alt="축산 보고서">
            <div class="unit"></div>
		</div>

		<input type="hidden" id="SELECT" name="SELECT">
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<form id="form_search" action="rpt_brhist.php" method="get">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					검색 기간 : 
					<!-- <input type="radio" class="btn_radio" name="sel_date" value="y" <?if($sel_date=="y"){echo "checked";}?>>연간 
					<input type="radio" class="btn_radio" name="sel_date" value="m" <?if($sel_date=="m"){echo "checked";}?>>월간 
					<input type="radio" class="btn_radio" name="sel_date" value="d" <?if($sel_date=="d"){echo "checked";}?>>일간 
					<input type="radio" class="btn_radio" name="sel_date" value="a" <?if($sel_date==""){echo "checked";}?>>기간  -->
					
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<span class="mL3">-</span>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<!-- 전송 유형 : 
					<input type="radio" name="IS_PLAN" value="" class="btn_radio" <?if($IS_PLAN==""){echo "checked";}?>>전체
					<input type="radio" name="IS_PLAN" value="0" class="btn_radio" <?if($IS_PLAN=="0"){echo "checked";}?>>즉시
					<input type="radio" name="IS_PLAN" value="1" class="btn_radio" <?if($IS_PLAN=="1"){echo "checked";}?>>예약 -->
					<br> 
					조회 구분 : 
					<select id="search_sel" name="search_sel" class="f333_12">
						<option value="SCRIPT_TITLE" <?if($search_sel=="SCRIPT_TITLE"){echo "selected";}?>>사업장명칭</option>
						<option value="SCRIPT_BODY" <?if($search_sel=="SCRIPT_BODY"){echo "selected";}?>>질병명</option>
					</select> 
					<input type="text" id="search_text" name="search_text" class="f333_12_bm" size="38" value="<?=$search_text?>"> 
					
				</span> 
				<span id="button" class="sel_right_n">
					<!--
					<button type="button" id="btn_search" class="btn_bb80">검색</button>
 					<button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button> 
 					-->
				</span>

					
				<span id="button" class="sel_right_n">
					<button type="button" id="btn_search" class="btn_bb80" style="position:relative;">검색</button>
					<button type="button" id="btn_print" class="btn_lbb80_s" style="position:relative;">인쇄</button>
					<button type="button" id="btn_excell" class="btn_lbb80_s" style="position:relative;">엑셀변환</button>
 					<!-- <button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button>  -->
 					
				</span>
			</li>
			<li class="li100_nor">
				<table id="list_table" class="tb_data pB0">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li15 bL_1gry">농가명</th>
							<!-- <th class="li15 bL_1gry">질병여부</th> -->
							<th class="li15 bL_1gry">질병명</th>
							<th class="li15 bL_1gry">사육업종</th>
							<th class="li15 bL_1gry">발생 시각</th>
							<th class="li15 bL_1gry">종료 시각</th>
						</tr>
					</thead>
			        <tbody>
						<?
						/*
						if($data_rptlist){
							foreach($data_rptlist as $key => $val){ 
						?>
						<tr id="list_<?=$val['IDX']?>" class="hh">
						<td id="BUSINESS_NAME_<?=$val['IDX']?>" class="li15 bL_1gry"><?=$val['BUSINESS_NAME']?></td>
						<!-- <td id="DISEASE_STATE_<?=$val['IDX']?>" class="li15 bL_1gry"><?=($val['STATE'] !== "-" ? "<img src='../images/red.png' width='20px' height='20px' value='1'>" : "<img src='../images/green.png' width='20px' height='20px' value='0'>")?></td> -->
						<td id="DISEASE_NAME_<?=$val['IDX']?>" class="li15 bL_1gry"><?=$val['DISEASE_NAME']?></td>
						<td id="ANIMAL_KIND_<?=$val['IDX']?>" class="li5 bL_1gry" value="<?$val['ANIMAL_KIND']?>"><?=($val['ANIMAL_KIND'] == 0 ? "소" : ($val['ANIMAL_KIND'] == 1 ? "돼지" : ($val['ANIMAL_KIND'] == 2 ? "닭" :
							($val['ANIMAL_KIND'] == 3 ? "돼지,닭" : ($val['ANIMAL_KIND'] == 4 ? "소,닭" : ($val['ANIMAL_KIND'] == 5 ? "소,돼지" : 
							($val['ANIMAL_KIND'] == 6 ? "소,돼지,닭" : "없음") ) ) ) ) ) ) 
							?></td>
						<td id="START_TIME_<?=$val['IDX']?>" class="li15 bL_1gry"><?=$val['START_TIME']?></td>
						<td id="END_TIME_<?=$val['IDX']?>" class="li15 bL_1gry"><?=$val['END_TIME']?></td>
						</tr>
						<? 
							}
						}
						*/
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
	// 구분에 따른 지역 호출

	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd", null);
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd", null);
	
    /***********************************************
	 *											   *
	 * 											   *
	 * 		       동물종류에 맞는 질병			     *
	 * 											   *
	 * 											   *
	 ***********************************************/

	function rpt_kind(){
			var tmp = "";
			var KIND = $('#KIND').val();
			var DISEASE_ID = $('#DISEASE_IDX').val();

			var param = "mode=Diseasekind&&kind="+KIND;
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					$.each(data.list, function (index, v) {
							tmp += '<option id="ANIMAL_TYPE" NAME="'+v['DISEASE_NAME']+'" value="'+v['DISEASE_IDX']+'">'+v['DISEASE_NAME']+'</option>';
						});
					$("#DISEASE_IDX").html(tmp);
					
				}});
	}


    /***********************************************
	 *											   *
	 * 											   *
	 * 					검색클릭				    *
	 * 											   *
	 * 											   *
	 ***********************************************/

	function rpt_disease(){
			var BUSINESS_NAME = "";
			var DISEASE_NAME = "";
			var ANIMAL_KIND = "";
			var START_TIME = "";
			var END_TIME = "";

			var KIND = $('#KIND').val();
			var DISEASE_ID = $('#DISEASE_IDX').val();
			var REAL_NAME = $('#DISEASE_IDX').attr('name');
			var CHECK_MODE ="";

			var tmp = "";

			$("#list_table tbody").empty();
			/*
			if($('input:radio[id=all]').is(':checked')){
				CHECK_MODE = 1;
			}
			if($('input:radio[id=noall]').is(':checked')){
				CHECK_MODE = 0;
			}
			*/

			var param = "mode=rpt_all&"+$("#form_search").serialize();
			//$("#list_table").empty();
			$.ajax({
				type: "POST",
				url: "../_info/json/_set_json.php",
				data: param,
				cache: false,
				dataType: "json",
				success : function(data){
					$.each(data.list, function (index, v) {
					var search_word = $("#SELECT").val();
					var search_col_id = "DISEASE_NAME_"+v['IDX'];
						
						tmp += '\n\
						<tr id="list_'+v['idx']+'" class="hh"> \n\
					   <td id="BUSINESS_NAME_'+v.idx+'" class="li15 bL_1gry">'+v['BUSINESS_NAME']+'</td>\n\
						<td id="DISEASE_NAME_'+v.idx+'" class="li15 bL_1gry">'+v.DISEASE_NAME+'</td>\n\
						<td id="ANIMAL_KIND_'+v.idx+'" class="li5 bL_1gry" value="'+v.ANIMAL_KIND1+'"> \n\
						'+ (v.ANIMAL_KIND1 == 0 ? "소" : (v.ANIMAL_KIND1 == 1 ? "돼지" : (v.ANIMAL_KIND1 == 2 ? "닭" :
						(v.ANIMAL_KIND1 == 3 ? "돼지,닭" : (v.ANIMAL_KIND1 == 4 ? "소,닭" : (v.ANIMAL_KIND1 == 5 ? "소,돼지" : 
						(v.ANIMAL_KIND1 == 6 ? "소,돼지,닭" : "없음") ) ) ) ) ) ) +'</td> \n\
						<td id="START_TIME_'+v.idx+'" class="li15 bL_1gry">'+v.START_TIME+'</td> \n\
						<td id="END_TIME_'+v.idx+'" class="li15 bL_1gry">'+v.END_TIME+'</td>\n\
						</tr>';
					});

					$("#list_table tbody").append(tmp);
				}});
	}

	//rpt_kind();
	//rpt_disease();
	
	$("#KIND").change(function(){
		rpt_kind();
	});

	$("#DISEASE_IDX").change(function(){
		$("#SELECT").val($("#DISEASE_IDX option:selected").attr('name'));
	});

	$("#btn_search").click(function(){
		rpt_disease();
	});
    
	$("#btn_excell").click(function(){
		//ReportToExcelConverter();
		fnExcelReport('list_table','축산 보고서');
	});
	// 달력 호출
	datepicker(2, "#sdate", "", "yy-mm-dd");


    /***********************************************
	 *											   *
	 * 											   *
	 * 					프린트 인쇄				    *
	 * 											   *
	 * 											   *
	 ***********************************************/

//var g_oBeforeBody = document.getElementById('content').innerHTML;
 jQuery('#btn_print').click( function() {
	 // 프린트를 보이는 그대로 나오기위한 셋팅
	 var g_oBeforeBody = document.getElementById('list_table_wrapper').innerHTML;
	 window.onbeforeprint = function (ev) {
		 document.body.innerHTML = g_oBeforeBody;
	 };
	 // window.onafterprint 로 다시 화면원복을 해주는게 맞으나,
	 // 문제가 있기에 reload로 처리
	//  var initBody = document.body.innerHTML;
	//  window.onafterprint = function(){
	// 	 document.body.innerHTML = initBody;
	//  }
	 //window.header("22");
	 window.print();
	 location.reload();
	 // reload를 해주는 이유는 onbeforeprint 이벤트로
	 // 화면을 다시 그렸기때문에 스크립트나 여러가지 이벤트가 해지되는 현상이 있음
	 // 그래서 임시조치로 reload를 해줌
 });



    /***********************************************
	 *											   *
	 * 											   *
	 * 					엑셀변환				    *
	 * 											   *
	 * 											   *
	 ***********************************************/
	function fnExcelReport(id, title) {
			var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
			tab_text = tab_text + '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
			tab_text = tab_text + '<xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'
			tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
			tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
			tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
			tab_text = tab_text + "<table border='1px'>";
			var exportTable = $('#' + id).clone();
			var exportTablelist = $('#' + id + 'tbody tr td').clone();
			
			//alert(exportTablelist);

			exportTable.find('input').each(function (index, elem) { $(elem).remove(); });  // 혹시 table 안에 input 박스 있을시 모두 제거
			exportTable.find('tbody tr').each(function (index, elem) { if($(elem).css('display') == 'none'){ $(elem).remove(); }});  // 숨김처리된 list들은 제거 처리
			exportTable.find('tbody tr td').each(function (index, elem) { if( $(elem).children('img').length == 1){ if($(elem).children('img').attr('value')){ console.log($(elem).children('img').attr('value')); }  }  });  // 숨김처리된 list들은 제거 처리

			tab_text = tab_text + exportTable.html();
			tab_text = tab_text + '</table></body></html>';
			var data_type = 'data:application/vnd.ms-excel';
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");
			var fileName = title + '.xls';
			//Explorer 환경에서 다운로드
			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
			if (window.navigator.msSaveBlob) {
			var blob = new Blob([tab_text], {
			type: "application/csv;charset=utf-8;"
			});
			navigator.msSaveBlob(blob, fileName);
			}
			} else {
			var blob2 = new Blob([tab_text], {
			type: "application/csv;charset=utf-8;"
			});
			var filename = fileName;
			var elem = window.document.createElement('a');
			elem.href = window.URL.createObjectURL(blob2);
			elem.download = filename;
			document.body.appendChild(elem);
			elem.click();
			document.body.removeChild(elem);
		}
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
	    	"emptyTable": "기간을 지정해주세요.",       
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
	    ]
	}).container().appendTo($("#button"));
	

	
	// 뒤로가기 관련 처리
	$("select").each(function(){
		var select = $(this);
		var selectedValue = select.find("option[selected]").val();

		if(selectedValue){
			select.val(selectedValue);
		}
	});
	
	$("#sdate").val("<?=$sdate?>");
});
</script>

</body>
</html>


	