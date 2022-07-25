<?
require_once "../_conf/_common.php";
require_once "../_info/_sms_hist.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_03_03.png" alt="전송 이력">
		</div>
		<div class="right_bg">
		<form id="form_search" action="sms_hist.php" method="get">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left80_np"> 
					검색 기간 : 
					<input type="radio" class="btn_radio" name="tran_date" value="y" <?if($DATE=="y"){echo "checked";}?>>연간 
					<input type="radio" class="btn_radio" name="tran_date" value="m" <?if($DATE=="m"){echo "checked";}?>>월간 
					<input type="radio" class="btn_radio" name="tran_date" value="d" <?if($DATE=="d"){echo "checked";}?>>일간 
					<input type="radio" class="btn_radio" name="tran_date" value="" <?if($DATE==""){echo "checked";}?>>기간 
					
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<span class="mL3">-</span>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					<br> 
					수신 번호 : <input type="text" id="tran_phone" name="tran_phone" value="<?=$PHONE?>" class="f333_12_bm" size="15">&nbsp;
					회신 번호 : <input type="text" id="tran_callback" name="tran_callback" value="<?=$CALLBACK?>" class="f333_12_bm" size="15">&nbsp;
					메세지 : <input type="text" id="tran_msg" name="tran_msg" value="<?=$MSG?>" class="f333_12_bm" size="40">
					<br> 
					<? if(sms_type == 1){ ?>
					전송상태 : 
					<input type="radio" class="btn_radio" name="tran_stat" value="" <?if($STAT==""){echo "checked";}?>>전체 
					<input type="radio" class="btn_radio" name="tran_stat" value="1" <?if($STAT=="1"){echo "checked";}?>>요청 
					<input type="radio" class="btn_radio" name="tran_stat" value="2" <?if($STAT=="2"){echo "checked";}?>>대기 
					<input type="radio" class="btn_radio" name="tran_stat" value="3" <?if($STAT=="3"){echo "checked";}?>>완료
					&nbsp;&nbsp;
					<? } ?>
					전송 유형 : 
					<input type="radio" class="btn_radio" name="tran_etc" value="" <?if($ETC==""){echo "checked";}?>>전체 
					<input type="radio" class="btn_radio" name="tran_etc" value="0" <?if($ETC=="0"){echo "checked";}?>>즉시 
					<input type="radio" class="btn_radio" name="tran_etc" value="1" <?if($ETC=="1"){echo "checked";}?>>예약
					&nbsp;&nbsp;
					전송 결과 : 
					<input type="radio" class="btn_radio" name="tran_rslt" value="" <?if($RSLT==""){echo "checked";}?>>전체 
					<input type="radio" class="btn_radio" name="tran_rslt" value="0" <?if($RSLT=="0"){echo "checked";}?>>성공 
					<input type="radio" class="btn_radio" name="tran_rslt" value="1" <?if($RSLT=="1"){echo "checked";}?>>실패
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
					<table id="list_table" class="tb_data_left hi100 w100 bb_3blue">
						<thead class="tb_data_tbg">
							<tr>
								<th class="li15">전송시각</th>
								<th class="li10 bL_1gry">회신번호</th>
								<th class="li65 bL_1gry">메세지</th>
								<th class="li5 bL_1gry">유형</th>
								<th class="li5 bL_1gry">수신인원</th>
							</tr>
						</thead>
						<tbody>
							<? 
							if($data_list){
								foreach($data_list as $key => $val){ 
							?>
							<tr id="list" class="hh" data-id="<?=$val['MSG_ID']?>">
								<td class="li15"><?=$val['SEND_DATE']?></td>
								<td class="li10 bL_1gry"><?=$val['CALLBACK']?></td>
								<td class="li65 bL_1gry al_L pL5"><?=$val['SMS_MSG']?></td>
								<td class="li5 bL_1gry"><?=$val['SCHEDULE_TEXT']?></td>
								<td class="li5 bL_1gry"><?=$val['DEST_COUNT']?></td>
							</tr>
							<? 
								} 
							}else{
							?>
							<tr class="hh">
								<td colspan="5">데이터가 없습니다.</td>
								<td style="display: none"></td>
								<td style="display: none"></td>
								<td style="display: none"></td>
								<td style="display: none"></td>
							</tr>
							<?
							}
							?>
						</tbody>
					</table>
				</div>
			</li>
		</ul>
		</form>
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div class="popup_top">전송 이력 - 상세 조회
		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
	</div>
	<div class="popup_con ">
		<ul class="popup_big alarm">
			<li class="alarm_gry">
				<span>발송인 :</span><span id="USER_ID" class="mL5 mR20"></span>
                <span>전송시각 :</span>
				<span id="SEND_DATE" class="mL5 mR20"></span>
                <span>유형 :</span>
				<span id="SCHEDULE_TEXT" class="mL5"></span>
			</li>

			<li id="sms" class="p0">
            	<div id="spin"></div>
				<table class="tb_data w100">
					<thead>
						<tr class="tb_data_tbg">
							<th>회신번호</th>
							<th>수신번호</th>
							<th>결과</th>
						</tr>
					</thead>
					<tbody id="sms_list"></tbody>
				</table>
			</li>
		</ul>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");

			
		$(".btn_radio").click(function(e){
			if(e.target.value == 'y'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else if(e.target.value == 'm'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else if(e.target.value == 'd'){
				$("#edate").hide();
				$("#edate").prev().hide();
				$("#edate").next().hide();
			}else{
				$("#edate").show();
				$("#edate").prev().show();
				$("#edate").next().show();
			}
		});

	// // 검색 버튼
	// $("#btn_search").click(function(){
	// 	$("#form_search").submit();
	// });


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
	            title: "전송 이력",
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

	// 상세 조회
	$("#list_table #list").click(function(){
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		popup_open(); // 레이어 팝업 열기

		var tmp_spin = null;
		var param = "mode=sms_detail&msg_id="+$(this).data("id");
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sms_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	    		var lay_html = '';	
	    		
		        if(data.list){
		        	$("#USER_ID").html(data.list[0]['USER_ID']);
		        	$("#SEND_DATE").html(data.list[0]['SEND_DATE']);
		        	$("#SCHEDULE_TEXT").html(data.list[0]['SCHEDULE_TEXT']);
			        
		            $.each(data.list, function(i, v){
						lay_html += ' <tr> ';
						lay_html += ' <td>'+v.CALLBACK+'</td> ';
						lay_html += ' <td>'+v.PHONE_NUMBER+'</td> ';
						lay_html += ' <td>'+v.RESULT_TEXT+'</td> ';
						lay_html += ' </tr>';
		            });
		        }else{
					lay_html += ' <tr> ';
					lay_html += ' <td colspan="2">데이터가 없습니다.</td> ';
					lay_html += ' </tr>';
		        }
				$("#sms_list").html(lay_html);
	        },
	        beforeSend : function(data){ 
		        $("#sms_list").empty();
	   			tmp_spin = spin_start("#sms #spin", "80px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#sms #spin");
	        	}
	        }
	    });	
	});

	// 뒤로가기 관련 처리
	$('input:radio[name="tran_date"][value="<?=$DATE?>"]').prop("checked", true);
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");
	$("#tran_phone").val("<?=$PHONE?>");
	$("#tran_callback").val("<?=$CALLBACK?>");
	$("#tran_msg").val("<?=$MSG?>");
	$('input:radio[name="tran_stat"][value="<?=$STAT?>"]').prop("checked", true);
	$('input:radio[name="tran_etc"][value="<?=$ETC?>"]').prop("checked", true);
	$('input:radio[name="tran_rslt"][value="<?=$RSLT?>"]').prop("checked", true);


	var select_obj = '';

$('.btn_radio:checked').each(function (index) {
	select_obj += $(this).val();
});
if(select_obj ==  'y' ){
	$("#edate").prev().hide();
	$("#edate").next().hide();
	$("#edate").hide();
}else if(select_obj == 'm'){
	$("#edate").prev().hide();
	$("#edate").next().hide();
	$("#edate").hide();
}else if(select_obj == 'd'){
  $("#edate").prev().hide();
  $("#edate").next().hide();
  $("#edate").hide();
}else if(select_obj == 'a'){
	$("#edate").prev().show();
	$("#edate").next().show();
	$("#edate").show();
}
});
</script>

</body>
</html>


	