<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="form_search" action="rpt_basic.php" method="get">
	
		<div class="main_contitle">
			<img src="../images/title_05_05.png" alt="기본 보고서">
		</div>

		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					보고서 선택 : 
					<select name="ALARM_GRP_NO" class="f333_12 mR10">
						<option value="A">강우현황1</option>
						<option value="1">강우현황2</option>
						<option value="2">강우현황3</option>
						<option value="3">강우현황4</option>
					</select> 
					<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
					<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
					<select name="HOUR_END" class="f333_12">
						<option value="0">00</option>
						<option value="1">01</option>
						<option value="2">02</option>
						<option value="3">03</option>
						<option value="4">04</option>
						<option value="5">05</option>
						<option value="6">06</option>
						<option value="7">07</option>
						<option value="8">08</option>
						<option value="9" selected>09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
					</select> 시
				</span> 
				<span class="sel_right_n">
					<button type="button" id="btn_search" class="btn_bb80">검색</button>
 					<button type="button" id="btn_print" class="btn_lbb80_s">인쇄</button>
 					<button type="button" id="btn_excel" class="btn_lbb80_s">엑셀변환</button> 
				</span>
			</li>
			<li class="li150_or">
				<div style="clear: both;"></div>
				<div class="mi fL"></div>
				<div class="fL p8">
					<table width="954" height="476" border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td width="342" valign="top" id="PREVIEW_FRM">
									<img src="../images/report01.gif" width="342" height="478">
								</td>
								<td width="9">&nbsp;</td>
								<td width="603" valign="top">
									<table width="603" border="0" cellpadding="0" cellspacing="1" bgcolor="#607DAB">
										<tbody>
											<tr>
												<td height="474" bgcolor="#FFFFFF">
													<img src="../images/body405img06.gif" width="601" height="474">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
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

	// 검색 버튼
	$("#btn_search").click(function(){
		$("#form_search").submit();
	});
});
</script>

</body>
</html>


