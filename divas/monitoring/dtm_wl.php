<?
require_once "../_conf/_common.php";
require_once "../_info/_dtm_wl.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	<div class="main_contitle">
	<div class="tit"><img src="../images/board_icon_aws.png"> <span>수위자료</span></div>
			<!-- <img src="../images/title_04_01.png" alt="강우 자료"> -->
		</div>

		<div class="right_bg2">
		<ul id="search_box">
			<form id="form_search" action="dtm_wl.php" method="post">
			<li>
				<span class="tit">검색날짜</span>
                                <button type="button" id="btn_left" class="tb_btn_s w25p"><i class="fa fa-angle-left"></i></button>
                                <input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="w100p" readonly>
                                <button type="button"  id="btn_right"  class="tb_btn_s w25p"><i class="fa fa-angle-right"></i></button>
                                <button type="button" id="btn_img" alt="달력보기" class="tb_btn_blue w45p"><i class="fa fa-calendar"></i></button>
			</li>
			</form>
			</ul>
			<ul class="stitle_box">
                 <!-- <li><?=$sdate?></li> -->
                 <li>[ 단위 : m ]</li>
             </ul>
		<ul class="set_ulwrap_nh">
			<li class="li100_nor">
				<table id="view_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<td class="w10i">구분</td>
							<td>00</td>
							<td>01</td>
							<td>02</td>
							<td>03</td>
							<td>04</td>
							<td>05</td>
							<td>06</td>
							<td>07</td>
							<td>08</td>
							<td>09</td>
							<td>10</td>
							<td>11</td>
							<td>12</td>
							<td>13</td>
							<td>14</td>
							<td>15</td>
							<td>16</td>
							<td>17</td>
							<td>18</td>
							<td>19</td>
							<td>20</td>
							<td>21</td>
							<td>22</td>
							<td>23</td>
						</tr>
					</thead>
					<tbody>
					<? 
					if($data_list){
						$rowCnt = dtm_cnt;
						$columCnt = 26;
						$rowNum = 0;
						foreach($data_list as $key => $val){ 
					?>
					<tr class="hh">
						<td class="blue_L_1"><?=$val['RTU_NAME']?></td>
						<? if($val['LIST']){ ?>
							<? foreach($val['LIST'] as $key2 => $val2){ ?>
							<td id="data" data-area_code="<?=$val['AREA_CODE']?>" data-hour="<?=$key2?>" data-name="<?=$val['RTU_NAME']?>"><?=$val2?></td>
							<? } ?>
						<? } else {
							$inhtml = "";
							for($i=$scnt; $i<=$ecnt; $i++){
								$inhtml .= '<td id="data" data-area_code="'.$val['AREA_CODE'].'" data-hour="'.$i.'" data-name="'.$val['RTU_NAME'].'">-</td>';
							}
							echo $inhtml;
						} ?>
					</tr>
					<? 
							$rowNum++;
						}
						for($i=0; $i<($rowCnt-$rowNum); $i++){
							echo "<tr>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td>
							</tr>";
						}
					}else{
					?>
					<tr>
						<td colspan="26" style="height:256px">데이터가 없습니다.</td>
					</tr>

					<? for($i=0; $i<$rowCnt; $i++){?>
							<tr>
					<? for($j=0; $j<$columCnt; $j++){?>	
							<td class="blue_L_1"></td>	
					<?}?>
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
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout_e">
	<div class="popup_top"><span id="rtu_name"></span>수위 자료 수정
		<button id="popup_close" class="btn_pop_blue fR bold">X</button>
	</div>
	<div class="popup_con_2">
		<form id="dtm_frm" name="dtm_frm" method="post">
			<input type="hidden" id="mode" name="mode" value="flow_save">
			<input type="hidden" id="p_area_code" name="area_code">
			<input type="hidden" id="p_sdate" name="sdate">
			<input type="hidden" id="p_hour" name="hour">
			<input type="hidden" name="OTT" value="<? echo $ott; ?>">
			<div class="pop_stitle">
				수정 일시 : <span id="sel_date"></span>
			</div>
            <table class="tb_data_p2 bL_1gry bg_gry3">
              <tr class="tb_data_tbg bT_1blue2">
                <th>00-09분</th>
                <th class="bL_1blue2">10-19분</th>
                <th class="bL_1blue2">20-29분</th>
                <th class="bL_1blue2">30-39분</th>
                <th class="bL_1blue2">40-49분</th>
                <th class="bL_1blue2">50-59분</th>
              </tr>
              <tr>
                <td><input type="text" id="min_1" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_2" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_3" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_4" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_5" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
                <td class="bL_1black"><input type="text" id="min_6" name="min[]" class="f333_12 al_c" maxlength="6" oninput="inputCheck(this,'onlyNumber','0.01~9999')"></td>
              </tr>
            </table>
			<div class="w100 fL al_C">
				<button type="button" id="btn_save" class="btn_bb80">저장</button>
            </div>
            <div id="spin"></div>
		</form>	
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	// 달력 호출
	datepicker(2, "#sdate", null, "yy-mm-dd", "#form_search");

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
        $("#form_search").submit();
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
		if(today.getDate() >= now.getDate()){
			var sel_y = now.getFullYear();
			var sel_m = now.getMonth() + 1;
			var sel_d = now.getDate();
			$("#sdate").datepicker("setDate", sel_y+"-"+sel_m+"-"+sel_d);
			
			$("#form_search").submit();
		}else{
			swal("체크", "미래는 검색할 수 없습니다!", "warning");
		}
	});

	// 텍스트
	$("#sdate").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	});
	
	// 달력 버튼
	$("#btn_img").click(function(){
		if( $("#ui-datepicker-div").css("display") != "none" ) {
			$("#sdate").datepicker("hide");
		}else{
			$("#sdate").datepicker("show");
		}
	});
	
	// 검색 버튼
	$("#btn_search").click(function(){
		$("#form_search").submit();
	});

	// 자료 보기
	$("#view_table #data").click(function(){
		bg_color("selected", "#view_table tbody tr", $(this).closest("tr"));
		popup_open(); // 레이어 팝업 열기
		
		var area_code = $(this).data("area_code");
		var hour = $(this).data("hour");
		var name = $(this).data("name");

		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_dtm_json.php",
		    data: { "mode" : "flow", "area_code" : area_code, "sdate" : "<?=$sdate?>", "hour" : hour, "OTT" : "<?=$ott?>" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
			        $("#rtu_name").html(name + " - ");
			        $("#p_area_code").val(area_code);
			        $("#p_sdate").val("<?=$sdate?>");
			        $("#p_hour").val(hour);
					$("#sel_date").text(data.list['DATE']+" "+data.list['HOUR']+"시");
					$("#min_1").val(data.list['MIN'][0]);
					$("#min_2").val(data.list['MIN'][1]);
					$("#min_3").val(data.list['MIN'][2]);
					$("#min_4").val(data.list['MIN'][3]);
					$("#min_5").val(data.list['MIN'][4]);
					$("#min_6").val(data.list['MIN'][5]);
		        }
	        },
	        beforeSend : function(data){ 
	   			tmp_spin = spin_start("#dtm_frm #spin", "-40px");
	        },
	        complete : function(data){ 
	        	if(tmp_spin){
	        		spin_stop(tmp_spin, "#dtm_frm #spin");
	        	}
	        }
        });
	});

	// 자료 수정
	$("#btn_save").click(function(){
		var tmp_spin = null;
		
		var param = $("#dtm_frm").serialize();
		$.ajax({
		    type: "POST",
		    url: "../_info/json/_dtm_json.php",
		    data: param,
		    cache: false,
		    dataType: "json",
		    success : function(data){
		        if(data.result){
		        	popup_main_close(); // 레이어 좌측 및 상단 닫기
		    		location.reload(); return false;
		        }else{
					swal("체크", "자료 수정중 오류가 발생 했습니다.", "warning");
		        }
		    },
		    beforeSend : function(data){ 
		   		tmp_spin = spin_start("#dtm_frm #spin", "-40px");
		    },
		    complete : function(data){ 
		    	if(tmp_spin){
		    		spin_stop(tmp_spin, "#dtm_frm #spin");
		    	}
		    }
		});
	});
	
	// 뒤로가기 관련 처리
	$("#sdate").val("<?=$sdate?>");
});
</script>

</body>
</html>


