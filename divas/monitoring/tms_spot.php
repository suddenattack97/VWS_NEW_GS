<?
require_once "../_conf/_common.php";
require_once "../_info/_tms_spot.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<div class="main_contitle">
			<img src="../images/title_01_11.png" alt="현장 중계">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh bB0">
			<form id="form_search" action="tms_spot.php" method="get">
			<li class="tb_sms_gry">
				검색 구분 : 
				<select name="spot_group" class="f333_12">
					<option value="">그룹선택</option>
				<? 
				if($data_group){
					foreach($data_group as $key => $val){ 
				?>
					<option value="<?=$val['spot_group']?>" <?if($_REQUEST['spot_group'] == $val['spot_group']){echo "selected";}?>>
						<?=$val['group_name']?>
					</option>
				<? 
					}
				}
				?>
				</select> 
				&nbsp;&nbsp;
				검색 기간 : 
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
							<th class="bL0" width="15%">현장사진</th>
							<th width="5%">그룹</th>
							<th width="5%">제목</th>
							<th width="60%">내용</th>
							<th width="5%">담당자</th>
							<th width="10%">일시</th>
						</tr>
						<? 
						if($data_spotlog){
							foreach($data_spotlog as $key => $val){ 
						?>
						<tr class="hh">
							<td class="bL0 p8"><?=$val['spot_img']?></td>
							<td><?=$val['group_name']?></td>
							<td><?=$val['spot_title']?></td>
							<td class="p8"><?=$val['spot_content']?></td>
							<td><?=$val['spot_name']?></td>
							<td><?=$val['spot_idate']?></td>
						</tr>
						<? 
							} 
						}else{
						?>
						<tr class="hh">
							<td colspan="6">데이터가 없습니다.</td>
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

	// 이미지 확대
	magnific_popup(".magnific-popup");

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


