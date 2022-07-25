<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_stat.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<div class="main_contitle">
			<img src="../images/title_05_02.png" alt="방송 통계">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<form id="form_search" action="rpt_stat.php" method="get">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					검색 기간 : 
					<input type="radio" class="btn_radio" name="STAT_TERM" value="N" <?if($STAT_TERM=="N"){echo "checked";}?>>연간 
					<input type="radio" class="btn_radio" name="STAT_TERM" value="D" <?if($STAT_TERM=="D"){echo "checked";}?>>월간 
					<input type="text" name="STAT_DATE" value="<?=$STAT_DATE?>" id="STAT_DATE" class="f333_12" size="12" readonly>
					&nbsp;&nbsp;&nbsp;
					통계 유형 : 
					<select name="STAT_TYPE" class="f333_12" size="1">
						<option value="0" <?if($STAT_TYPE=="0"){echo "selected";}?>>방송장비별 통계</option>
						<option value="1" <?if($STAT_TYPE=="1"){echo "selected";}?>>전송유형별 통계</option>
					</select>
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
				<div class="tb_data">
				<table id="list_table" class="pB0">
					<thead class="tb_data_tbg">
						<tr>
						 	<? if($STAT_TYPE=="1"){ ?>
							<th class="li5 bR_1gry">유형</th>
							<th class="li5 bR_1gry">구분</th>
							<? }else{ ?>
							<th class="li5 bR_1gry">구분</th>
							<? } ?>
							<? for($i=$scnt; $i<=$ecnt; $i++){ ?>
							<th class=""><?=($i < 10) ? "0".$i : $i?></th>
							<? } ?>
							<th class="li5 bL_1gry">누계</th>
						</tr>
					</thead>
			        <tbody>
				<? 
				if($STAT_TYPE=="0"){
					if($data_list){
						foreach($data_list as $key => $val){ 
				?>
						<tr class="hh">
							<td class="li10 bR_1gry"><?=$val['RTU_NAME']?></td>
							<? foreach($val['CNT'] as $key2 => $val2){ ?>
							<td class="li6_92"><?=$val2?></td>
							<? } ?>
							<td class="li6_92 bL_1gry"><?=$val['SUM']?></td>
						</tr>
				<? 
						}
					}
				}else if($STAT_TYPE=="1"){
					if($data_list){
				?>
						<!-- 즉시 -->
						<tr class="hh">
							<td class="li5 bR_1gry" rowspan="3">즉시</td>
							<td class="li5 bR_1gry">성공</td>
						<?
						foreach($data_list['NOW'] as $key => $val){ 
						?>
							<td id="m1_<?=$key + 1?>" class="li6_92 manu_num"><?=$val['T']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['NOW_TS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">즉시</td>
							<td class="li5 bR_1gry">실패</td>
						<?
						foreach($data_list['NOW'] as $key => $val){ 
						?>
							<td class="li6_92"><?=$val['F']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['NOW_FS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">즉시</td>
							<td class="li5 bR_1gry">전체</td>
						<?
						foreach($data_list['NOW'] as $key => $val){ 
						?>
							<td id="m2_<?=$key + 1?>" class="li6_92 manu_num"><?=$val['C']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['NOW_CS']?></td>
						</tr>
						
						<!-- 예약 -->
						<tr class="hh">
							<td class="li5 bR_1gry" rowspan="3">예약</td>
							<td class="li5 bR_1gry">성공</td>
						<?
						foreach($data_list['PLAN'] as $key => $val){ 
						?>
							<td id="m3_<?=$key + 1?>" class="li6_92 manu_num"><?=$val['T']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['PLAN_TS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">예약</td>
							<td class="li5 bR_1gry">실패</td>
						<?
						foreach($data_list['PLAN'] as $key => $val){ 
						?>
							<td class="li6_92"><?=$val['F']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['PLAN_FS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">예약</td>
							<td class="li5 bR_1gry">전체</td>
						<?
						foreach($data_list['PLAN'] as $key => $val){ 
						?>
							<td id="m4_<?=$key + 1?>" class="li6_92 manu_num"><?=$val['C']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['PLAN_CS']?></td>
						</tr>
						
						<!-- 자동 -->
						<tr class="hh">
							<td class="li5 bR_1gry" rowspan="3">자동</td>
							<td class="li5 bR_1gry">성공</td>
						<?
						foreach($data_list['AUTO'] as $key => $val){ 
						?>
							<td id="a1_<?=$key + 1?>" class="li6_92 auto_num"><?=$val['T']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['AUTO_TS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">자동</td>
							<td class="li5 bR_1gry">실패</td>
						<?
						foreach($data_list['AUTO'] as $key => $val){ 
						?>
							<td class="li6_92"><?=$val['F']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['AUTO_FS']?></td>
						</tr>
						<tr class="hh">
							<td style="display: none;">자동</td>
							<td class="li5 bR_1gry">전체</td>
						<?
						foreach($data_list['AUTO'] as $key => $val){ 
						?>
							<td id="a2_<?=$key + 1?>" class="li6_92 auto_num"><?=$val['C']?></td>
						<? 
						}
						?>
							<td class="li6_92 bL_1gry"><?=$data_list['AUTO_CS']?></td>
						</tr>
				<?
					}
				}
				?>
			        </tbody>
				</table> 
				</div>
			</li>
			</form>
		</ul>

		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#STAT_DATE", "../images/icon_cal.png", "yy-mm-dd");
	
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
	            title: "방송 통계",
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

	// 전송유형별 통계 - 즉시 클릭 -> 방송전송이력
	$(".manu_num").click(function(){
		var tmpDt = this.id;
		tmpDt = tmpDt.substring(3);
		tmpDt = (tmpDt.length < 2) ? "0" + tmpDt : tmpDt;
		var sdate = $("#STAT_DATE").val();
		var type = $('input[name="STAT_TERM"]:checked').val();
		if(type == "N"){
			type = "m";
			var yy = sdate.substr(0,4);
			var dd = sdate.substr(8,2);
			sdate = yy+"-"+tmpDt+"-"+dd;
		}else{
			type = "d";
			var yy = sdate.substr(0,4);
			var mm = sdate.substr(5,2);
			sdate = yy+"-"+mm+"-"+tmpDt;
		}
		location.href = "./rpt_brhist.php?sel_date="+type+"&sdate="+sdate;
	});

	// 전송유형별 통계 - 자동 클릭 -> 이벤트로그
	$(".auto_num").click(function(){
		var tmpDt = this.id;
		tmpDt = tmpDt.substring(3);
		tmpDt = (tmpDt.length < 2) ? "0" + tmpDt : tmpDt;
		var sdate = $("#STAT_DATE").val();
		var type = $('input[name="STAT_TERM"]:checked').val();
		if(type == "N"){
			type = "D";
			var yy = sdate.substr(0,4);
			var dd = sdate.substr(8,2);
			sdate = yy+"-"+tmpDt+"-"+dd;
		}else{
			type = "H";
			var yy = sdate.substr(0,4);
			var mm = sdate.substr(5,2);
			sdate = yy+"-"+mm+"-"+tmpDt;
		}
		location.href = "./rpt_alarmlog.php?type="+type+"&sdate="+sdate;
	});
	
	// 뒤로가기 관련 처리
	$('input:radio[name="STAT_TERM"][value="<?=$STAT_TERM?>"]').prop("checked", true);
	$("#STAT_DATE").val("<?=$STAT_DATE?>");
	$("select").each(function(){
		var select = $(this);
		var selectedValue = select.find("option[selected]").val();

		if(selectedValue){
			select.val(selectedValue);
		}
	});
});
</script>

</body>
</html>


