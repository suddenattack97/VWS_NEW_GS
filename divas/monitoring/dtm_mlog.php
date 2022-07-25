<?
require_once "../_conf/_common.php";
require_once "../_info/_dtm_mlog.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">

		<div class="main_contitle">
			<img src="../images/title_04_05.png" alt="운영 로그">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<form id="form_search" action="dtm_mlog.php" method="get">
			<li class="tb_sms_gry">
				검색 구분 : 
				<select name="ALARM_GRP_NO" class="f333_12">
					<option value="A">경보그룹선택</option>
				<? 
				if($data_equip){
					foreach($data_equip as $key => $val){ 
				?>
					<option value="<?=$val['ALARM_GRP_NO']?>" <?if($_REQUEST['ALARM_GRP_NO'] == $val['ALARM_GRP_NO']){echo "selected";}?>>
						<?=$val['ALARM_GRP_NAME']?>
					</option>
				<? 
					}
				}
				?>
				</select> 
				<select name="ALARM_RTU_ID" class="f333_12">
					<option value="A">장비선택</option>
				<? 
				if($data_equip2){
					foreach($data_equip2 as $key => $val){ 
				?>
					<option value="<?=$val['RTU_ID']?>" <?if($_REQUEST['ALARM_RTU_ID'] == $val['RTU_ID']){echo "selected";}?>>
						<?=$val['RTU_NAME']?>
					</option>
				<? 
					}
				}
				?>
				</select> 
				<input type="text" name="sdate" value="<?=$sdate?>" id="sdate" class="f333_12" size="12" readonly>
				<span class="mL3">-</span>
				<input type="text" name="edate" value="<?=$edate?>" id="edate" class="f333_12" size="12" readonly>
				<button type="button" id="btn_search" class="btn_bs60_sms mL5">검색</button>
			</li>
			<li class="li150_or">
				<div style="clear: both;"></div>
				<div class="mi fL"></div>
				<div class="datam_con_29">
					<ul>
						<li class="datam_con_gry">이벤트 코드 목록
							<button type="button" id="btn_all" class="btn_lbs fR">전체선택</button>
						</li>
						<li class="p0">
							<div class="datam_list">
								<table id="list_check" class="tb_data">
									<thead class="tb_data_tbg">
										<tr>
											<th class="w15i hi28">선택</th>
											<th class="w85i hi28 bL_1gry">코드 : 이벤트구분</th>
										</tr>
									</thead>
					
									<tbody>
									<? 
									if($data_event){
										foreach($data_event as $key => $val){ 
									?>
										<tr id="list_<?=$val['EVENT_CODE']?>">
											<td class="w15i hi28">
												<input type="checkbox" name="EVENT_CODE[]" class="chkbox" value="<?=$val['EVENT_CODE']?>"
												<?if(in_array($val['EVENT_CODE'], $EVENT_CODE)){echo "checked";}?>>
											</td>
											<td class="w85i hi28 bL_1gry"><?=$val['EVENT_CODE']?> : <?=$val['EVENT_COMMENT']?></td>
										</tr>
									<? 
										}
									}
									?>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
				<div class="mi fL"></div>
				<div class="datam_con_68">
					<ul>
						<li class="datam_con_gry">검색결과</li>
						<li class="p0">
							<div id="list_spin" class="datam_list">
            					<div id="spin"></div>
								<table id="list_table" class="tb_data">
									<thead class="tb_data_tbg">
										<tr>
											<th class="li15 al_C hi28 bL_1gry">장비명</th>
											<th class="li15 al_C hi28 bL_1gry">발생시각</th>
											<th class="li35 al_C hi28 bL_1gry">구분</th>
											<th class="li35 al_C hi28 bL_1gry bR_1gry">로그상세</th>
										</tr>
									</thead>
					
									<tbody>
									<? 
									if($data_list){
										foreach($data_list as $key => $val){
									?>
										<tr>
											<td class="li15 al_C hi28 bL_1gry"><?=$val['RTU_NAME']?></td>
											<td class="li15 al_C hi28 bL_1gry"><?=$val['EVENT_DATE']?></td>
											<td class="li35 al_C hi28 bL_1gry"><?=$val['EVENT_COMMENT']?></td>
											<td class="li35 al_C hi28 bL_1gry bR_1gry"><?=$val['EVENT_VALUE']?></td>
										</tr>
									<? 
										}
									}else{
										for($i = 0; $i < 20; $i ++){ 
									?>
										<tr>
											<td class="li15 al_C hi28 bL_1gry"></td>
											<td class="li15 al_C hi28 bL_1gry"></td>
											<td class="li35 al_C hi28 bL_1gry"></td>
											<td class="li35 al_C hi28 bL_1gry bR_1gry"></td>
										</tr>
									<? 
										}
									}
									?>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
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
	datepicker(1, "#sdate", "../images/icon_cal.png", "yy-mm-dd");
	datepicker(1, "#edate", "../images/icon_cal_r.png", "yy-mm-dd");

	// 장비 선택
	$("#list_check tbody tr").click(function(){
		var tmp_el = $("#"+this.id+" input")[0];
		if( $(tmp_el).prop("checked") ){
			$(tmp_el).prop("checked", false);
		}else{
			$(tmp_el).prop("checked", true);
		}
	});
	
	// 전체 선택
	$("#btn_all").click(function(){
		var tmp_cnt = $("input[name='EVENT_CODE[]']:not(:checked)").length;
		if(tmp_cnt == 0){
			$("input[name='EVENT_CODE[]']").prop("checked", false);
		}else{
			$("input[name='EVENT_CODE[]']").prop("checked", true);
		}
	});
	
	$("#btn_search").click(function(){
		$("#form_search").submit();
	});

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


