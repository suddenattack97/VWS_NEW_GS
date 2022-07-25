<?
require_once "../_conf/_common.php";
require_once "../_info/_rpt_brhist.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_05_01.png" alt="방송전송 이력">
            <div class="unit">※ 항목을 클릭하면 상세 내용을 확인 할 수 있습니다.</div>
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<form id="form_search" action="rpt_brhist.php" method="get">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					검색 기간 : 
					<input type="radio" class="btn_radio" name="sel_date" value="y" <?if($sel_date=="y"){echo "checked";}?>>연간 
					<input type="radio" class="btn_radio" name="sel_date" value="m" <?if($sel_date=="m"){echo "checked";}?>>월간 
					<input type="radio" class="btn_radio" name="sel_date" value="d" <?if($sel_date=="d"){echo "checked";}?>>일간 
					<input type="radio" class="btn_radio" name="sel_date" value="a" <?if($sel_date=="" || $sel_date=="a"){echo "checked";}?>>기간 
					
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<span class="mL3">-</span>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					&nbsp;&nbsp;&nbsp;&nbsp;
					전송 유형 : 
					<input type="radio" name="IS_PLAN" value="" class="btn_radio" <?if($IS_PLAN==""){echo "checked";}?>>전체
					<input type="radio" name="IS_PLAN" value="0" class="btn_radio" <?if($IS_PLAN=="0"){echo "checked";}?>>즉시
					<input type="radio" name="IS_PLAN" value="1" class="btn_radio" <?if($IS_PLAN=="1"){echo "checked";}?>>예약
					<br> 
					조회 구분 : 
					<select id="search_sel" name="search_sel" class="f333_12">
						<option value="SCRIPT_TITLE" <?if($search_sel=="SCRIPT_TITLE"){echo "selected";}?>>방송제목</option>
						<option value="SCRIPT_BODY" <?if($search_sel=="SCRIPT_BODY"){echo "selected";}?>>방송문구</option>
					</select> 
					<input type="text" id="search_text" name="search_text" class="f333_12_bm" size="38" value="<?=$search_text?>"> 
					&nbsp;사용자 ID : <input type="text" name="USER_ID" class="f333_12" size="12" value="<?=$USER_ID?>">
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
							<th class="li5">전송유형</th>
							<th class="li5 bL_1gry">문안유형</th>
							<th class="li55 bL_1gry">방송제목</th>
							<th class="li5 bL_1gry">사용자</th>
							<th class="li10 bL_1gry">전송시작시각</th>
							<th class="li10 bL_1gry">최종로깅시각</th>
							<th class="li10 bL_1gry">전송건수</th>
						</tr>	
					</thead>
			        <tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['LOG_NO']?>" class="hh hh_c" data-log_no="<?=$val['LOG_NO']?>">
							<td class="li5"><?=$val['IS_PLAN_GUBUN'] ? $val['IS_PLAN_GUBUN'] : '-'?></td>
							<td class="li5 bL_1gry"><?=$val['SCRIPT_UNIT_NAME'] ? $val['SCRIPT_UNIT_NAME'] : '-'?></td>
							<td class="li55 bL_1gry"><?=$val['SCRIPT_TITLE'] ? $val['SCRIPT_TITLE'] : '-'?></td>
							<td class="li5 bL_1gry"><?=$val['USER_ID'] ? $val['USER_ID'] : '-'?></td>
							<td class="li10 bL_1gry"><?=$val['TRANS_START'] ? $val['TRANS_START'] : '-'?></td>
							<td class="li10 bL_1gry"><?=$val['TRANS_CHECK'] ? $val['TRANS_CHECK'] : '-'?></td>
							<td class="li15 bL_1gry">
								<span id="t_success_<?=$key?>" title="">완료 : <?=$val['RTU_CNT_OK']?>건</span>
								<input type="hidden" id="total_names_<?=$key?>" value="">
								/ <span id="t_total_<?=$key?>" title="">전체 : <?=$val['RTU_CNT']?>건</span>
							</td>
						</tr>
				<? 
					}
				}
				?>
			        </tbody>
				</table> 
			</li>
			</form>
		</ul>

		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<div class="popup_top">방송전송 이력<span id="title"></span>
		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
	</div>
	<div class="popup_con">
	    <div id="list_view" class="alarm popup_big">
            <div id="spin"></div>
	    	<table class="tb_data_p">
	    		<tr>
	    			<th class="bg_lgr">사용자 정보</th>
	    			<td><span id="USER_ID"></span></td>
	    			<th class="bg_lgr">전송 유형</th>
	    			<td><span id="IS_PLAN_GUBUN"></span></td>
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
							<th>방송성공여부</th>
							<!-- <th>2차망 전송결과</th> -->
							<th>에러 정보</th>
							<th>최종 로깅시각</th>
							<th>녹음파일</th>
							<!--
							<th>
							<script type="text/javascript">
							var audio = new Audio();
							audio.src = "./_recordfiles/01.wav"
							</script>
							<button type="button" onClick="audio.play()" class="btn_lgs">재생</button>
							</th>
							-->
						</tr>
					</thead>
					<tbody id="list_state">
					</tbody>
				</table>
	    	</div>
	    </div>    
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd", null);
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd", null);

	// title에 rtu_name 채우기
	$.each($("#list_table tbody tr"), function(i, v){
		// v.id 가져와서 id값 index 구하기
		var idx = $("#" + v.id + " span").attr("id");
		idx = idx.replace("t_success_", "");
		var tr_id = v.id.replace("list_", "");

		// tr_num = i;
		$.ajax({
			type: "POST",
			url: "../_info/json/_rpt_json.php",
			data: { "mode" : "alarm", "log_no" : tr_id },
			cache: false,
			dataType: "json",
			success : function(data){
				// console.log(data);
				var succ_title = "";
				var tot_title = "";
				if(data.state){
					$.each(data.state, function(i, v){
						if(v.TXT1 == "방송완료"){
							// console.log(tr_id, v.RTU_NAME);
							if(succ_title == ""){succ_title = v.RTU_NAME;}
							else{succ_title += (", " + v.RTU_NAME);}
						}
						if(tot_title == ""){tot_title = v.RTU_NAME;}
						else{tot_title += (", " + v.RTU_NAME);}
					});
					$("#t_success_" + idx).attr("title", succ_title);
					$("#t_total_" + idx).attr("title", tot_title);
	
					if(succ_title != ""){ succ_title = " - " + succ_title; } 
					if(tot_title != ""){ tot_title = " - " + tot_title; } 
				}
				var text_input = $("#t_success_" + idx).text() + succ_title + " / " + $("#t_total_" + idx).text() + tot_title;
				// console.log(text_input);
				$("#total_names_" + idx).val(text_input);
			// },complete : function(data){
			// 	idx++;
			}
		});
	});

	// 엑셀 검색기간 추가 
	var seText = "";
	if($('input[name="sel_date"]:checked').val() == "a"){
		seText = "검색기간 : " + $("#sdate").val() +" ~ "+ $("#edate").val();
	}else if($('input[name="sel_date"]:checked').val() == "m"){
		seText = "검색월 : " + $("#sdate").val().substr(0,7);
	}else if($('input[name="sel_date"]:checked').val() == "y"){
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
	            className: "btn_bb80_l",
                action: function(dt){
            		$("#form_search").submit();
                }
	        },
	   		{
	        	extend: "print",
	            text: "인쇄",
	            className: "btn_lbb80_l",
	            autoPrint: true,
	            title: "방송전송 이력",
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
		        className: "btn_lbb80_l",
	            title: "",
				messageTop: seText,
				exportOptions: {
					format: {
						body: function (data, row, column, node) {
							return $(node).find('input').val() ? $(node).find('input').val() : data;
						}
					}
				},
	            customize: function(xlsx){
	                var sheet = xlsx.xl.worksheets["sheet1.xml"];
	                //$("row:first c", sheet).attr("s", "42");
	                $("row c", sheet).attr("s", "51");
					$("row:first c", sheet).attr("s", "52");
	                var col = $("col", sheet);
	                col.each(function(){
	                      $(col[0]).attr("width", 10);
	                      $(col[1]).attr("width", 10);
	                      $(col[2]).attr("width", 30);
	                      $(col[3]).attr("width", 10);
	                      $(col[4]).attr("width", 22);
	                      $(col[5]).attr("width", 22);
	                      $(col[6]).attr("width", 20);
	               	});
	            }, customizeData: function(data) {
                }
	        }
	    ]
	}).container().appendTo($("#button"));
	
	// 상세 조회
	$("#list_table tbody tr").click(function(){
		var log_no = $(this).data("log_no");
		if(!log_no) return false;
		
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		popup_open(); // 레이어 팝업 열기

		var tmp_spin = null;
		var fileindex = 0;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_rpt_json.php",
		    data: { "mode" : "alarm", "log_no" : log_no },
	        cache: false,
	        dataType: "json",
	        success : function(data){
	    		var tmp_html = '';	
	    		
		        if(data.detail){
			        $("#title").html(" - " + data.detail[0]['SCRIPT_TITLE']);
		        	$("#USER_ID").html(data.detail[0]['USER_ID']);
		        	$("#IS_PLAN_GUBUN").html(data.detail[0]['IS_PLAN_GUBUN']);
		        	$("#SCRIPT_BODY").html(data.detail[0]['SCRIPT_BODY']);
		        	$("#LOG_DATE").html(data.detail[0]['LOG_DATE']);

			        if(data.state){
			            $.each(data.state, function(i, v){
			            	tmp_html += ' <tr> ';
			            	tmp_html += ' <td>'+v.RTU_ID+'</td> ';
			            	tmp_html += ' <td>'+v.RTU_NAME+'</td> ';
			            	tmp_html += ' <td>'+v.TXT1+'</td> ';
			            	// tmp_html += ' <td>'+v.TXT2+'</td> ';
							tmp_html += ' <td>'+v.TXT3+'</td> ';
							tmp_html += ' <td>'+v.TRANS_CHECK+'</td> ';
							// tmp_html += ' <td><button id="btn_recordplay" class="btn_lgs" onclick="recplay(\'' + v.REC_FILEPATH + '\')">재생</button></td> ';
							if(v.MODEL_NO == 8){
								if(v.RECORD_FILEPATH !== null){
									tmp_html += ' <td><img src="../images/v-i-play.png" style="top:0px; cursor:pointer;" id="btn_recordplay_'+fileindex+'" onclick="recplay(\'' + v.RECORD_FILEPATH + '\', this.id)" title="\n 녹음 파일은 저음질 입니다. \n원본을 들으시려면 모바일 어플로 \n사용해 주시기 바랍니다."></td> ';
								}else{
									tmp_html += ' <td></td> ';
								}
							}else{
								tmp_html += ' <td></td> ';
							}
							tmp_html += ' </tr>';

							fileindex++;
			            });
			        }
		        }
				$("#list_state").html(tmp_html);
	        },
	        beforeSend : function(data){ 
	   			tmp_spin = spin_start("#list_view #spin", "100px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#list_view #spin");
	        	}
	        }
	    });	
   	});
	
//	$("#btn_recordplay").click(function(){
//		//swal("", "버튼 클릭 됨", "success");
//		var audio = new Audio();
//		audio.src = './_recordfiles/09_20200617172031.wav';
//		audio.volume = 1;
//		audio.currentTime = 0;

//		audio.play();
//	});
	// 뒤로가기 관련 처리
	$("select").each(function(){
		var select = $(this);
		var selectedValue = select.find("option[selected]").val();

		if(selectedValue){
			select.val(selectedValue);
		}
	});
	$('input:radio[name="sel_date"][value="<?=$sel_date?>"]').prop("checked", true);
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");
	$('input:radio[name="IS_PLAN"][value="<?=$IS_PLAN?>"]').prop("checked", true);
	$("#search_sel").val("<?=$search_sel?>");
	$("#search_text").val("<?=$search_text?>");


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


$(".btn_radio").click(function(e){
	if(e.target.value == 'y'){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(e.target.value == 'm'){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(e.target.value == 'd'){
		$("#edate").prev().hide();
		$("#edate").next().hide();
		$("#edate").hide();
	}else if(e.target.value == 'a'){
		$("#edate").prev().show();
		$("#edate").next().show();
		$("#edate").show();
	}
});

var timer = 0;
var fileuse = 0;

var audio = new Audio();
// 집음 파일 재생 
function recplay($recfilename,id) {
	audio.src = "../../_recordfiles/" + $recfilename;
	audio.addEventListener('ended', (event) => {
		$("#"+id).attr('src','../images/v-i-play.png');
	});
	function stop_action(){
		fileuse = true;
		audio.onerror=function(){ 
			swal("오류", "파일이 존재하지 않습니다.", "warning");
			$("#"+id).attr('src','../images/v-i-stop.gif');
			fileuse = false;
		}
		if(fileuse){
			$("#"+id).attr('src','../images/v-i-play.png');
			audio.pause(id);
			audio.currentTime = 0;
		}
	}

	function start_action(){
		fileuse = true;
		audio.onerror=function(){ 
			swal("오류", "파일이 존재하지 않습니다.", "warning");
			$("#"+id).attr('src','../images/v-i-play.png');
			fileuse = false;
		}
		if(fileuse){
			$("#"+id).attr('src','../images/v-i-stop.gif');
			audio.play(id);
		}
	}

	// ###### 실행 부분
		if($("#"+id).attr('src') == '../images/v-i-stop.gif'){
				stop_action();
		}else{
				start_action();
		}
		
}
</script>
</body>
</html>


