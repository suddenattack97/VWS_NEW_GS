<?
require_once "../_conf/_common.php";
require_once "../_info/_tms_aslog.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_01_10.png" alt="장비 로그">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh bB0">
			<form id="form_search" action="tms_aslog.php" method="get">
			<li class="tb_sms_gry">검색 기간 : 
				<input type="text" name="sdate" value="<?=$sdate?>" id="datepicker1" class="f333_12" size="12" readonly>
				<span class="mL3">-</span>							
				<input type="text" name="edate" value="<?=$edate?>" id="datepicker2" class="f333_12" size="12" readonly>
				&nbsp;&nbsp;
				<button type="button" id="btn_search" class="btn_bs60_sms mL5">검색</button>
			</li>
			</form>
			<li class="li100_nor">
				<div class="tb_data">
					<table class="tb_data_left hi100 w100">
						<tr>
							<th class="bL0">장비명</th>
							<th>내용</th>
							<th>신청자</th>
							<!-- <th>접수자</th> -->
							<th>일시</th>
							<!-- <th>확인</th> -->
						</tr>
						<? 
						if($data_aslog){
							foreach($data_aslog as $key => $val){ 
						?>
						<tr class="hh">
							<td class="bL0"><?=$val['rtu_name']?></td>
							<td><?=$val['as_content']?></td>
							<td><?=$val['as_iname']?></td>
							<!-- <td><?=$val['as_uname']?></td> -->
							<td><?=$val['as_idate']?></td>
							<!-- <td><button class="btn_table">접수</button></td> -->
						</tr>
						<? 
							} 
						}else{
						?>
						<tr class="hh">
							<td colspan="4">데이터가 없습니다.</td>
						</tr>
						<?
						}
						?>
					</table>
				</div>
			</li>
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
	datepicker(1, "#datepicker1", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#datepicker2", "../images/icon_cal_r.png", "yy-mm-dd");

	$("#btn_search").click(function(){
		$("#form_search").submit();
	});

	// 뒤로가기 관련 처리
	$("#sdate").val("<?=$sdate?>");
	$("#edate").val("<?=$edate?>");
});
</script>

</body>
</html>


