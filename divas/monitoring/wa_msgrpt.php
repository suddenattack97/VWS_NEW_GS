<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_msgrpt.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="wa_frm" action="wa_msgrpt.php" method="get">

		<div class="main_contitle">
			<img src="../images/title_09_06.png" alt="메세지 보고서">
		</div>

		<ul class="set_ulwrap_nh bB0">
			<li class="tb_sms_gry">
				검색 기간 : 
				<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
				<span class="mL3">-</span>
				<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
				
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
							<th class="li5 bL0">번호</th>
							<th class="li5 bL_1gry">종류</th>
							<th class="li10 bL_1gry">지역</th>
							<th class="li10 bL_1gry">담당자</th>
							<th class="li5 bL_1gry">순서</th>
							<th class="li15 bL_1gry">제목</th>
							<th class="li15 bL_1gry">상단문구</th>
							<th class="li15 bL_1gry">하단문구</th>
							<th class="li10 bL_1gry">전송결과</th>
							<th class="li10 bL_1gry">전송일시</th>
						</tr>
					</thead>
			        <tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr class="hh">
							<td class="bL0"><?=$val['NUM']?></td>
							<td class="bL_1gry"><?=$val['PANELCOMMANDTEXT']?></td>
							<td class="bL_1gry"><?=$val['RTU_NAME']?></td>
							<td class="bL_1gry"><?=$val['USERID']?></td>
							<td class="bL_1gry"><?=$val['MSGNO']?></td>
							<td class="bL_1gry"><?=$val['TEXTNAME']?></td>
							<td class="bL_1gry"><?=$val['TEXTA']?></td>
							<td class="bL_1gry"><?=$val['TEXTB']?></td>
							<td class="bL_1gry"><?=$val['CALL_STATE']?></td>
							<td class="bL_1gry"><?=$val['TRANS_START']?></td>
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
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");
	
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
            		$("#wa_frm").submit();
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_s",
	            autoPrint: true,
	            title: "메세지 보고서",
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
	                      $(col[0]).attr("width", 5);
	                      $(col[1]).attr("width", 10);
	                      $(col[2]).attr("width", 25);
	                      $(col[3]).attr("width", 15);
	                      $(col[4]).attr("width", 5);
	                      $(col[5]).attr("width", 25);
	                      $(col[6]).attr("width", 30);
	                      $(col[7]).attr("width", 30);
	                      $(col[8]).attr("width", 25);
	                      $(col[9]).attr("width", 25);
	               	});
	            }
	        }
	    ]
	}).container().appendTo($("#button"));

	// 뒤로가기 관련 처리
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");
});
</script>

</body>
</html>


