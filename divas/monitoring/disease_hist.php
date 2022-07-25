<?
require_once "../_conf/_common.php";
require_once "../_info/_set_farm.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="set_frm" action="_set_farm.php" method="get">
		<input type="hidden" id="ALARM_GRP_NO" name="ALARM_GRP_NO"><!-- 선택한 경보그룹 번호 -->
		<input type="hidden" id="IN_RTU_ID" name="IN_RTU_ID"><!-- 추가할 장비 아이디 -->
		<input type="hidden" id="DE_RTU_ID" name="DE_RTU_ID"><!-- 삭제할 장비 아이디 -->
		<input type="hidden" id="SET_DISEASE" name="SET_DISEASE">
		<input type="hidden" id="IDX" name="IDX" value="">
		<input type="hidden" id="DISEASE_IDX" name="DISEASE_IDX" value="">
		<input type="hidden" id="REG_TIME" name="REG_TIME" value="">
		<input type="hidden" id="END_TIME" name="END_TIME" value="">

		<div class="main_contitle">
			<img src="../images/title_06_16.png" alt="농가 질병 설정">
		</div>
		
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					농가 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">사업장명칭</option>
						<option value="1">질병명칭</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
				</span> 
				<!--
				<span class="sel_right_n top5px"> 
					※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다. 
				</span>
				-->
			</li>
			<li class="li100_nor d_scroll">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
					<tr>
										<th class="li10 hi25">번호</th>
										<th class="li20 hi25">사업장명칭</th>
										<th class="li10 hi25">사육종류</th>
										<th class="li20 hi25">감염질병</th>
					</tr>
					</thead>
					<tbody>
					<? 		
							$sdate = date("Y-m-d", time())." ".date("H:i:s", time());
							if($data_list2){
								foreach($data_list2 as $key => $val){ 
							?>
									<tr id="list_<?=$val['NUM']?>">
										<td id="l_ALARM_GRP_NO" class="li10 hi25"><?=$val['NUM']?></td>
										<td class="li20 hi25"><?=$val['BUSINESS_NAME']?></td>
										<td class="li10 hi25"><?=($val['ANIMAL_KIND1'] == 0 ? "<img id='cow_".$val['NUM']."' src='cow_1.png' width='20' class='farm_animal'>" : ($val['ANIMAL_KIND1'] == 1 ? "<img id='pig_".$val['NUM']."' src='pig_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 2 ? "<img id='chicken_".$val['NUM']."' src='chicken_1.png' width='20' class='farm_animal'>" : ($val['ANIMAL_KIND1'] == 3 ? "<img id='pig_".$val['NUM']."' src='pig_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='chicken_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 4 ? "<img id='cow_".$val['NUM']."' src='cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='chicken_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 5 ? "<img id='cow_".$val['NUM']."' src='cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='pig_".$val['NUM']."' src='pig_1.png' width='20' class='farm_animal'>" : 
										($val['ANIMAL_KIND1'] == 6 ? "<img id='cow_".$val['NUM']."' src='cow_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='pig_".$val['NUM']."' src='pig_1.png' width='20' class='farm_animal'>&nbsp;&nbsp;<img id='chicken_".$val['NUM']."' src='chicken_1.png' width='20' class='farm_animal'>" : "없음") ) ) ) ) ) ) 
										?></td>
										<td id="DISEASE_CHECK_<?=$val['NUM']?>" class="li10 hi25">
										<span id="xtext_<?=$val['NUM']?>">X</span>
										<?
										if($data_FarmComInView){
											foreach($data_FarmComInView as $key => $val2){
										
										if($val['NUM'] == $val2['IDX']){
											if($sdate < $val2['END_TIME']){
												if($val['ANIMAL_KIND1'] == 0){$kind = "0";}
												if($val['ANIMAL_KIND1'] == 1){$kind = "1";}
												if($val['ANIMAL_KIND1'] == 2){$kind = "2";}		
												if($val['ANIMAL_KIND1'] == 3){$kind = "1,2";}
												if($val['ANIMAL_KIND1'] == 4){$kind = "0,2";}
												if($val['ANIMAL_KIND1'] == 5){$kind = "0,1";}
												if($val['ANIMAL_KIND1'] == 6){$kind = "0,1,2";}

												if(strpos($kind,$val2['KIND']) !== false){
												$check = $check + count($val2['DISEASE_NAME']);
												if($check > 1){
													?>
													<script type="text/javascript">
													$("#xtext_<?=$val['NUM']?>").empty();
													$("#<?=($val2['KIND'] == 0 ? "cow_".$val['NUM'] : ($val2['KIND'] == 1 ? "pig_".$val['NUM'] : ($val2['KIND'] == 2 ? "chicken_".$val['NUM'] : "")));?>").attr("src", "<?=($val2['KIND'] == 0 ? "cow_2" : ($val2['KIND'] == 1 ? "pig_2" : ($val2['KIND'] == 2 ? "chicken_2" : "")));?>.png");
													</script>
													<?
												 echo "<span style='color:red'>, ".$val2['DISEASE_NAME']."</span>";
												}else{
													?>
													<script type="text/javascript">
													$("#xtext_<?=$val['NUM']?>").empty();
													$("#<?=($val2['KIND'] == 0 ? "cow_".$val['NUM'] : ($val2['KIND'] == 1 ? "pig_".$val['NUM'] : ($val2['KIND'] == 2 ? "chicken_".$val['NUM'] : "")));?>").attr("src", "<?=($val2['KIND'] == 0 ? "cow_2" : ($val2['KIND'] == 1 ? "pig_2" : ($val2['KIND'] == 2 ? "chicken_2" : "")));?>.png");
													</script>
													<?
												echo "<span style='color:red'>".$val2['DISEASE_NAME']."</span>";
												}

													}
												}
											}


									}
									$check = 0;
								}
										?>
										</td>
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


<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout">
	<form id="set_frm" action="" method="get">

	<input type="hidden" id="SELECT" name="SELECT"><!-- 선택 _ID -->
	<div class="popup_top">농가 질병 상세설정
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con">
		<div class="alarm">
			<ul>
				<li class="alarm_gry">발생 질병 선택 <span class="unit" style="position:relative; left:290px; color:gray;">※ 항목을 클릭하면 질병상태를 등록/해제 할 수 있습니다.</span> 
					<!-- <button type="button" id="btn_all" class="btn_bs60">수정</button> --> 
				</li>
				<div class="popup_img">	
				</div>
			</ul>
		</div>
	</div>
	</from>
</div>
	
<script type="text/javascript">
$(document).ready(function(){
	$(".popup_top").css("background","#905e4f");
	$(".alarm").css("border-top","3px solid #905e4f");
	$(".alarm").css("border-bottom","3px solid #905e4f");
	

		// 농가 질병 설정 페이지에서 농가 선택 했을 경우
		$("#list_table tbody tr").click(function(){
		var SELECT = $("#"+this.id+" #l_ALARM_GRP_NO").text();
		$("#SELECT").val(SELECT);

		var param = "mode=farm_disease_check";
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
				console.log(data.list);
					
		        }
	        }
		});
		popup_open();
	});







	});

</script>
</body>
</html>


