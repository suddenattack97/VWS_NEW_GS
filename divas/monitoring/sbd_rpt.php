<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_rpt.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<form id="sbd_frm" action="sbd_rpt.php" method="get">

		<div class="main_contitle">
			<img src="../images/title_08_06.png" alt="전광판 보고서">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh bB0">
			<li class="tb_sms_gry">
				설치 지역 : 
				<select id="AREABESTID" name="AREABESTID" size="1">
					<option value="">상위 지역 선택</option>
			<? 
			if($data_areab){
				foreach($data_areab as $key => $val){ 
			?>
					<option value="<?=$val['AREABESTID']?>" <?if($_REQUEST['AREABESTID'] == $val['AREABESTID']){echo "selected";}?>><?=$val['AREABESTNAME']?></option>
			<? 
				}
			}
			?>
				</select>
				/
				<select id="AREAID" name="AREAID" size="1">
					<option value="">지역 선택</option>
			<? 
			if($data_area){
				foreach($data_area as $key => $val){ 
			?>
					<option value="<?=$val['AREAID']?>" <?if($_REQUEST['AREAID'] == $val['AREAID']){echo "selected";}?>><?=$val['AREANAME']?></option>
			<? 
				}
			}
			?>
				</select>
				/
				<select id="SITEID" name="SITEID" size="1">
					<option value="">설치 장소 선택</option>
			<? 
			if($data_sign){
				foreach($data_sign as $key => $val){ 
			?>
					<option value="<?=$val['SITEID']?>" <?if($_REQUEST['SITEID'] == $val['SITEID']){echo "selected";}?>><?=$val['SITENAME']?></option>
			<? 
				}
			}
			?>
				</select> 
				
				&nbsp;&nbsp;&nbsp;&nbsp;
				
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
							<th class="li7 bL_1gry">발송구분</th>
							<th class="li10 bL_1gry">상위지역</th>
							<th class="li10 bL_1gry">지역</th>
							<th class="li15 bL_1gry">설치장소</th>
							<th class="li10 bL_1gry">담당자명</th>
							<th class="li20 bL_1gry">내용</th>
							<th class="li8 bL_1gry">전송결과</th>
							<th class="li15 bL_1gry">전송일시</th>
						</tr>
					</thead>
			        <tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr class="hh">
							<td class="bL0"><?=$val['NUM']?></td>
							<td class="bL_1gry"><?=$val['DIVISION_NAME']?></td>
							<td class="bL_1gry"><?=$val['AREABESTNAME']?></td>
							<td class="bL_1gry"><?=$val['AREANAME']?></td>
							<td class="bL_1gry"><?=$val['SITENAME']?></td>
							<td class="bL_1gry"><?=$val['USERID']?></td>
							<? if($val['TYPE'] == "0"){ ?>
							<td class="bL_1gry"><?=$val['MSG']?></td>
							<? }else if($val['TYPE'] == "1"){ ?>
								<? if($val['IMGPATH'] == ""){ ?>
									<td class="bL_1gry">
										<div style="width: 100%; height: 25px; background-color: #BFD2EB; text-align: center;">
										<span style="position: relative;">이미지가 없습니다.</span>
										</div>
									</td>
								<? }else{ ?>
									<td class="bL_1gry">
										<img id="img_area" class="w60 sbd_overX" src="<?=$val['IMGPATH']?>">
										<button type="button" class="btn_lbs mL3 sbd_overX">원본보기</button>	
									</td>
								<? } ?>
							<? } ?>
							<td class="bL_1gry"><?=$val['SUCCESS_NAME']?></td>
							<td class="bL_1gry"><?=$val['SENDDATE']?></td>
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
		<div id="popup_overlay" class="popup_overlay"></div>
		<div id="popup_layout" style="display: none;">
			<div id="pop_1" class="popup_layout_c">
				<div class="popup_top">이미지 원본
					<button id="popup_close" class="btn_lbs fR bold">X</button>
				</div>
				<div class="popup_con_1">	
					<div class="alarm">			
						<form method="get" class="sbd_scroll">
							<table class="tb_data w100">
								<tbody>
									<tr>
										<td><img id="img_area2" class="sbd_scroll" src=""></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 상위 지역 조회
	$("#AREABESTID").change(function(){
		$("#sbd_frm").submit();
	});
	
	// 지역 조회
	$("#AREAID").change(function(){
		$("#sbd_frm").submit();
	});
	
	// 설치 장소 조회
	$("#SITEID").change(function(){
		$("#sbd_frm").submit();
	});
	
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");
	
	// 원본보기 클릭시
	$(".sbd_overX").click(function(){
		$("#pop_1").show();
		$("#img_area2").attr("src", $("#img_area").attr('src'));
		popup_open(); // 레이어 팝업 열기
	});

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
            		$("#sbd_frm").submit();
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_s",
	            autoPrint: true,
	            title: "전광판 보고서",
	            exportOptions: { stripHtml: false },
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
	            exportOptions: { stripHtml: false },
	            customize: function(xlsx){
	                var sheet = xlsx.xl.worksheets["sheet1.xml"];
	                //$("row:first c", sheet).attr("s", "42");
	                $("row c", sheet).attr("s", "51");
	                var col = $("col", sheet);
	                col.each(function(){
	                      $(col[0]).attr("width", 5);
	                      $(col[1]).attr("width", 10);
	                      $(col[2]).attr("width", 15);
	                      $(col[3]).attr("width", 15);
	                      $(col[4]).attr("width", 25);
	                      $(col[5]).attr("width", 10);
	                      $(col[6]).attr("width", 40);
	                      $(col[7]).attr("width", 10);
	                      $(col[8]).attr("width", 25);
	               	});
	            }
	        }
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
	$("#edate").val("<?=$edate?>");
});
</script>

</body>
</html>


