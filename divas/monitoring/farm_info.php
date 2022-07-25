<?
require_once "../_conf/_common.php";
require_once "../_info/_set_farm.php";
require_once "./head.php";

?>
<!-- <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script type="text/javascript" src="../js/PostCode.js"></script> -->
<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="set_frm" action="set_farm.php" method="get">
		<input type="hidden" id="dup_check" name="dup_check" value="0"><!-- 사용자 아이디 중복 체크 0:실패, 1:성공 -->
		<input type="hidden" id="C_USER_ID" name="C_USER_ID"><!-- 선택한 사용자 아이디 -->
		<input type="hidden" id="STR_RTU_ID" name="STR_RTU_ID"><!-- 선택한 방송권한 지역 RTU_ID -->
		
		<div class="main_contitle">
			<img src="../images/title_06_14.png" alt="농가 설정">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인 및 수정할 수 있습니다.</div>
		</div>
		
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					농가 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">사업장명칭</option>
						<option value="1">권리주체명</option>
					</select>
					&nbsp; 
					<input type="text" id="search_word" name="search_word" class="f333_12" size="60">
					&nbsp;&nbsp;
					<button type="button" id="btn_search" class="btn_bs">조회</button>
					<button type="button" id="btn_search_all" class="btn_lbs">전체목록</button>
					<!-- <input type="file" id="excell_load" class="btn_lbs" size="3" style="width:100px; height:20px;">
					<button type="button" id="btn_excell" class="btn_lbs">엑셀등록</button> -->
					<button type="button" id="excellsample" class="btn_lbs">샘플양식</button>
					<div class="fileBox">	
					<form enctype="multipart/form-data" id="ajaxForm" method="post">			
					<input type="text" id="fileName" class="fileName" readonly="readonly">
					<label for="uploadBtn" class="btn_file" style="cursor:pointer;" onclick="">엑셀등록</label>
					<input type="file" id="uploadBtn" class="uploadBtn" name="uploadBtn" onchange="">
				
					</div>
					<button type="button" id="excellxyupdate" class="btn_lbs">좌표변환</button>
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
							<th class="li2">번호</th>
							<th class="li5 bL_1gry">사업장 명칭</th>
							<th class="li7 bL_1gry">축산인허가번호</th>
							<th class="li2 bL_1gry">주사육업종</th>
							<th class="li7 bL_1gry">권리주체등록번호</th>
							<th class="li3 bL_1gry">권리주체명</th>
							<th class="li8 bL_1gry">권리주체소재지(지번)</th>
							<th class="li8 bL_1gry">권리주체소재지(도로명)</th>
							<th class="li8 bL_1gry">사업장소재지(지번)</th>
							<th class="li8 bL_1gry">사업장소재지(도로명)</th>
							<th class="li5 bL_1gry">행정동명</th>
							<th class="li3 bL_1gry">영업상태구분</th>
							<th class="li5 bL_1gry">휴대폰</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['NUM']?>">
							<td id="FARM_ID" class="li2 bL_1gry"><?=$val['NUM']?></td>
							<td id="BUSINESS_NAME1" class="li5 bL_1gry"><?=$val['BUSINESS_NAME']?></td>
							<td id="LICENSE_NUM" class="li7 bL_1gry"><?=$val['LICENSE_NUM']?></td>
							<!--<td id="ANIMAL_KIND" class="li5 bL_1gry" value="<?$val['ANIMAL_KIND1']?>"><?=($val['ANIMAL_KIND1'] == 0 ? "소" : ($val['ANIMAL_KIND1'] == 1 ? "돼지" : ($val['ANIMAL_KIND1'] == 2 ? "닭" :
							($val['ANIMAL_KIND1'] == 3 ? "돼지,닭" : ($val['ANIMAL_KIND1'] == 4 ? "소,닭" : ($val['ANIMAL_KIND1'] == 5 ? "소,돼지" : 
							($val['ANIMAL_KIND1'] == 6 ? "소,돼지,닭" : "없음") ) ) ) ) ) ) 
							?></td>-->

							<td id="ANIMAL_KIND" class="li2 bL_1gry" value="<?$val['ANIMAL_KIND1']?>"><?=$val['SUB_KIND']?></td>
							<td class="li7 bL_1gry"><?=$val['COPR_NUM']?></td>
							<td id="COPR_NAME1" class="li3 bL_1gry"><?=$val['COPR_NAME']?></td>
							<td class="li8 bL_1gry"><?=$val['COPR_ADDRESS1']?></td>
							<td class="li8 bL_1gry"><?=$val['COPR_ADDRESS2']?></td>
							<td class="li8 bL_1gry"><?=$val['BUSINESS_ADDRESS1']?></td>
							<td class="li8 bL_1gry"><?=$val['BUSINESS_ADDRESS2']?></td>
							<td id="AREA_CODE" class="li5 bL_1gry"><?=$val['AREA_CODE']?></td>
							<td class="li3 bL_1gry"><?=($val['BUSINESS_STATE'] == 0) ? "정상" : "폐업" ?></td>
							<td class="li5 bL_1gry"><?=$val['SMART_MOBILE']?></td>
						</tr>
				<? 
					}
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="top6px">설정값 입력</span> 
				<input type="hidden" id="IDX" name="IDX">
				<input type="hidden" id="LICENSE" name="LICENSE">
				<input type="hidden" id="NAME" name="NAME">
				<span class="sel_right_n">
					<? if(ss_user_type == 0 || ss_user_type == 1){ ?>
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<? } ?>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL0">사업자명칭</td>
						<td colspan="1">
							<input id="BUSINESS_NAME_IN" name="BUSINESS_NAME" type="text" class="f333_12" size="13">
						</td>

						<td class="bg_lb w10 bold al_C">사육업종</td>
						<td>
						<!-- <input id="ANIMAL_KIND1_IN" name="ANIMAL_KIND1" type="text" class="f333_12" size="12"> -->
						<!-- <select id="ANIMAL_TYPE" name="ANIMAL_TYPE" class="f333_12"> -->
						<?
						/* 
						if($data_Animallist){
						foreach($data_Animallist as $key => $val){ 
						?>
						<option value="<?=$val['ANIMAL_NO']?>"><?=$val['ANIMAL_NAME']?></option>
						<?
							}
						}
						*/
						?>
						<input type="checkbox" value="0" name="check_cow" id="check_cow"/>소
						<input type="checkbox" value="1" name="check_pig" id="check_pig" />돼지
						<input type="checkbox" value="2" name="check_chicken" id="check_chicken" />닭
						<input type="text" style="display:none;" value="" name="ANIMAL_KIND_CHECK" id="ANIMAL_KIND_CHECK" size="2" />
						<!-- </select> -->
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">권리주체등록번호</td>
						<td colspan="1">
							<input id="COPR_NUM_IN" name="COPR_NUM" type="text" class="f333_12" size="18">
						</td>
						<td class="bg_lb w10 bold al_C">사육두수</td>
						<td colspan="3" id="ANIMAL_COUNT" name="ANIMAL_COUNT">
						
						<p id="COW_ID" style="display:none;">소 : </p>
						<input id="COW_NO" name="COW_NO" type="hidden" class="f333_12" size="3">
						<p id="PIG_ID" style="display:none;">돼지 : </p>
						<input id="PIG_NO" name="PIG_NO" type="hidden" class="f333_12" size="3">
						<p id="CHICKEN_ID" style="display:none;">닭 : </p>
						<input id="CHICKEN_NO" name="CHICKEN_NO" type="hidden" class="f333_12" size="3">
						
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">권리주체명</td>
						<td colspan="1">
							<input id="COPR_NAME_IN" name="COPR_NAME" type="text" class="f333_12" size="13">
						</td>
						<td class="bg_lb w10 bold al_C">행정동명</td>
						<td colspan="5">
						<input id="AREA_CODE_IN" name="AREA_CODE" type="text" class="f333_12" size="12">
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">권리주체소재지(지번)</td>
						<td colspan="1">
<!-- 						<input id="COPR_ADDRESS1" name="COPR_ADDRESS1" type="text" class="f333_12" size="18"> -->
							<input name="COPR_ADDRESS1" type="text" id="COPR_ADDRESS1_IN" placeholder="" class="f333_12" size="25">
<!-- 							<input type="button" onclick="postcode(1)" value="우편번호 검색" class="btn_bb80"> -->
							<button type="button" onclick="postcode(1)" value="우편번호 검색" class="btn_lbb80_s_post">우편번호 검색</button>
						</td>
						<td class="bg_lb w10 bold al_C">영업 상태구분</td>
						<td colspan="5">
							<select id="BUSINESS_STATE_IN" name="BUSINESS_STATE_IN" size="1" class="f333_12">
								<option value="0">승인</option>
								<option value="1">미승인</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">권리주체소재지(도로명)</td>
						<td class="w400p">
<!-- 						<input id="COPR_ADDRESS2" name="COPR_ADDRESS2" type="text" class="f333_12" size="18"> -->
							<input name="COPR_ADDRESS2" type="text" id="COPR_ADDRESS2_IN" placeholder="" class="f333_12" size="25">
							<!-- <input name="COPR_ADDRESS3" type="text" id="COPR_ADDRESS3_IN" placeholder="상세주소" class="f333_12" size="25"> -->
						</td>
						
						<td class="bg_lb w10 bold al_C">축산인허가번호</td>
						<td>
						<input name="LICENSE_NUM_IN" type="text" id="LICENSE_NUM_IN" placeholder="" class="f333_12" size="25">
						</td>
						


					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">사업장소재지(지번)</td>
						<td class="w400p" colspan="5">
<!-- 							<input id="BUSINESS_ADDRESS1" name="BUSINESS_ADDRESS1" type="text" class="f333_12" size="18"> -->
							<input name="BUSINESS_ADDRESS1" type="text" id="BUSINESS_ADDRESS1_IN" placeholder="" class="f333_12" size="25">
							<!-- <button type="button" onclick="postcode(2)" class="btn_lgs"></button> -->
							<button type="button" onclick="postcode(2);" value="" class="btn_lbb80_s_post">우편번호 검색</button>


						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">사업장소재지(도로명)</td>
						<td class="w400p" colspan="5">
							<!-- <input id="BUSINESS_ADDRESS2" name="BUSINESS_ADDRESS2" type="text" class="f333_12" size="18"> -->
							<input name="BUSINESS_ADDRESS2" type="text" id="BUSINESS_ADDRESS2_IN" placeholder="" class="f333_12" size="25">
							<!-- <input name="BUSINESS_ADDRESS3" type="text" id="BUSINESS_ADDRESS3_IN" placeholder="상세주소" class="f333_12" size="25"> -->
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL0">휴대폰 번호 (APP)</td>
						<td>
							<select id="SMART_MOBILE1" name="SMART_MOBILE1" size="1" class="gaigi12">
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="019">019</option>
							</select> 
							- 
							<input id="SMART_MOBILE2" name="SMART_MOBILE2" type="text" class="f333_12" size="6" maxlength="4">
							-
							<input id="SMART_MOBILE3" name="SMART_MOBILE3" type="text" class="f333_12" size="6" maxlength="4">
						</td>
					</tr>
				</table>
			</li>
		</ul>
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->


<script type="text/javascript">
$(document).ready(function(){

	/***************좌표 변환 ***************/
	function excell_xy_update(){
		var row = $("#list_table tbody tr").length;
		var param = "mode=farm_list";
		$.ajax({
		type: "POST",
		url: "../_info/json/_set_json.php",
		data: param,
		cache: false,
		dataType: "json",
		success : function(data){
			if(data.list){

				$.each(data.list, function (index, v) {
				
					var realaddress = v['BUSINESS_ADDRESS1'];
					naver.maps.Service.geocode({
					address: realaddress
					}, function(status, response) {
					if (status !== naver.maps.Service.Status.OK) {
					return alert('Something wrong!');
					}
					var result = response.result, // 검색 결과의 컨테이너
					items = result.items; // 검색 결과의 배열 x= 127 y = 37
					x_point = items[0].point.y;	// 37.3139221 
					y_point = items[0].point.x; // 127.1054065
					//console.log(items);
					//console.log(items[0].point.y);
						var param = "mode=excell_xy_update&x_point="+x_point+"&y_point="+y_point+"&LICENSE_NUM="+v['LICENSE_NUM'];
							$.ajax({
							type: "POST",
							url: "../_info/json/_set_json.php",
							data: param,
							cache: false,
							dataType: "json",
							success : function(data){
							
								}});
							
					});
				});
			}
		}});
	}



	/***************엑셀 등록 ***************/
	var uploadFile = $('.fileBox .uploadBtn');
	uploadFile.on('change', function(){
		swal({
				title: '<div class="alpop_top_b">엑셀 등록 확인</div><div class="alpop_mes_b">엑셀을 정말로 등록하실 겁니까?</div>',
				text: '확인 시 엑셀이 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){
					var form = jQuery("#ajaxFrom")[0];
					var formData = new FormData(form);
					//formData.append("message", "ajax로 파일 전송하기");
					formData.append("file", jQuery("#uploadBtn")[0].files[0]);
					formData.append("mode", "excell_in");

					jQuery.ajax({
						url : "../_info/json/_set_json.php",
						type : "POST",
						processData : false,
						contentType : false,
						data : formData,
						success:function(json) {
							location.reload(); return false;
						}
					});
				}
			}); // swal end

	});

	/***************엑셀 샘플양식 다운로드 ***************/
	$("#excellsample").click(function(){
		window.location.assign('../_files/sample/farm_excell_sample.xls');
	});

	/***************엑셀 좌표변환 클릭 ***************/
	$("#excellxyupdate").click(function(){
		excell_xy_update();
	});



	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 사용자 ID
			search_col_id = "BUSINESS_NAME1";
		}else if(search_col == "1"){ // 사용자명
			search_col_id = "COPR_NAME1";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});



	$("#check_cow").change(function(){
		if($('#check_cow').is(":checked") == true){
			$('#COW_ID').css('display','inline');
			$('#COW_NO').attr("type", "text");
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}
		}else{
			$('#COW_ID').css('display','none');
			$('#COW_NO').attr("type", "hidden");	
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}
		}
	});
	$("#check_pig").change(function(){
		if($('#check_pig').is(":checked") == true){
			$('#PIG_ID').css('display','inline');
			$('#PIG_NO').attr("type", "text");
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}
		}else{
			$('#PIG_ID').css('display','none');
			$('#PIG_NO').attr("type", "hidden");
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}	
		}
	});
	$("#check_chicken").change(function(){
		if($('#check_chicken').is(":checked") == true){
			$('#CHICKEN_ID').css('display','inline');
			$('#CHICKEN_NO').attr("type", "text");
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}
		}else{
			$('#CHICKEN_ID').css('display','none');
			$('#CHICKEN_NO').attr("type", "hidden");
			if($('#check_cow').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(0);
					}
					if($('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(1);
					}
					if($('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(2);
					}
					if($('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(3);
					}
					if($('#check_cow').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(4);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(5);
					}
					if($('#check_cow').is(":checked") == true && $('#check_pig').is(":checked") == true && $('#check_chicken').is(":checked") == true){
						$('#ANIMAL_KIND_CHECK').val(6);
					}
		}
	});


	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		$("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var l_USER_ID = $("#"+this.id+" #AREA_CODE").text();
		var KIND = $("#ANIMAL_KIND").val();
		var LICENSE_NUM = $("#"+this.id+" #LICENSE_NUM").text();
		//console.log(l_USER_ID);
		var param = "mode=farm&LICENSE_NUM="+LICENSE_NUM;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
			        var EMAIL = data.list.EMAIL ? data.list.EMAIL : "";
			        var MOBILE = data.list.MOBILE ? data.list.MOBILE : "";
					var SMART_MOBILE = data.list.SMART_MOBILE ? data.list.SMART_MOBILE : "";
					//console.log(data.list);
					$("#IDX").val(data.list.IDX);
					$("#LICENSE").val(data.list.LICENSE_NUM);
					$("#NAME").val(data.list.BUSINESS_NAME);
					$("#BUSINESS_NAME_IN").val(data.list.BUSINESS_NAME);
					$("#LICENSE_NUM_IN").val(data.list.LICENSE_NUM);
					$("#ANIMAL_TYPE").val(data.list.ANIMAL_KIND1);
					$("#ANIMAL_KIND_CHECK").val(data.list.ANIMAL_KIND1);
					$("#AREA_CODE_IN").val(data.list.AREA_CODE);
					$("#COPR_NUM_IN").val(data.list.COPR_NUM);
					$("#COPR_NAME_IN").val(data.list.COPR_NAME);
					$("#COPR_ADDRESS1_IN").val(data.list.COPR_ADDRESS1);
					$("#COPR_ADDRESS2_IN").val(data.list.COPR_ADDRESS2);
					$("#COPR_ADDRESS3_IN").val(data.list.COPR_ADDRESS3);
					$("#BUSINESS_ADDRESS1_IN").val(data.list.BUSINESS_ADDRESS1);
					$("#BUSINESS_ADDRESS2_IN").val(data.list.BUSINESS_ADDRESS2);
					$("#BUSINESS_ADDRESS3_IN").val(data.list.BUSINESS_ADDRESS3);
					$("#BUSINESS_STATE_IN").val(data.list.BUSINESS_STATE);
					$("#MOBILE1").val(MOBILE.split("-")[0] ? MOBILE.split("-")[0] : "010");
					$("#MOBILE2").val(MOBILE.split("-")[1]);
					$("#MOBILE3").val(MOBILE.split("-")[2]);
					$("#SMART_MOBILE1").val(SMART_MOBILE.split("-")[0] ? SMART_MOBILE.split("-")[0] : "010");
					$("#SMART_MOBILE2").val(SMART_MOBILE.split("-")[1]);
					$("#SMART_MOBILE3").val(SMART_MOBILE.split("-")[2]);
					$("#SMART_USE").val(data.list.SMART_USE);
					$("#ANIMAL_TYPE").change();
					$("#COW_NO").val(data.list.COW_NO);
					$("#CHICKEN_NO").val(data.list.CHICKEN_NO);
					$("#PIG_NO").val(data.list.PIG_NO);
					
				if(data.list.ANIMAL_KIND1 == 0){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_cow']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();

				}if(data.list.ANIMAL_KIND1 == 1){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();

				}if(data.list.ANIMAL_KIND1 == 2){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();

					
				}if(data.list.ANIMAL_KIND1 == 3){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", true);
					$("input:checkbox[id='check_chicken']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();
				}if(data.list.ANIMAL_KIND1 == 4){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_cow']").prop("checked", true);
					$("input:checkbox[id='check_chicken']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();
				}if(data.list.ANIMAL_KIND1 == 5){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_cow']").prop("checked", true);
					$("input:checkbox[id='check_pig']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();
				}if(data.list.ANIMAL_KIND1 == 6){
					$("input:checkbox[id='check_cow']").prop("checked", false);
					$("input:checkbox[id='check_pig']").prop("checked", false);
					$("input:checkbox[id='check_chicken']").prop("checked", false);
					$("input:checkbox[id='check_cow']").prop("checked", true);
					$("input:checkbox[id='check_pig']").prop("checked", true);
					$("input:checkbox[id='check_chicken']").prop("checked", true);
					$("#check_cow").change();
					$("#check_pig").change();
					$("#check_chicken").change();
				}

			        if(data.right){
						$.each(data.right, function(i, v){
							//console.log(i, v);
							var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
							$("#tree").jstree("select_node", tmp_id); // jstree 해당 id 체크
						});
			        }
		        }else{
				    swal("체크", "농가 상세 조회중 오류가 발생 했습니다.", "warning");
				}

	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">농가 등록 확인</div><div class="alpop_mes_b">농가를 등록하실 겁니까?</div>',
				text: '확인 시 농가가 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){
					var param = "mode=farm_in&"+$("#set_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
								    swal("체크", "농가 등록중 오류가 발생 했습니다.", "warning");
						        }
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		$("#tree").jstree("deselect_all"); // jstree 전체 체크 해제
		$("#dup_check").val(0); // 아이디 중복체크 리셋
		var C_USER_ID = $("#C_USER_ID").val();
		if(C_USER_ID == ""){
			$("#C_USER_ID").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
			$("#USER_TYPE").val("");
			$("#MENU_TYPE").val(0);
			$("#USER_ID").val("");
			$("#USER_PWD").val("");
			$("#USER_NAME").val("");
			$("#EMAIL1").val("");
			$("#EMAIL2").val(0);
			$("#EMAIL3").val("");
			$("#MOBILE1").val("010");
			$("#MOBILE2").val("");
			$("#MOBILE3").val("");
			$("#IS_PERMIT").val(0);
			$("#SMART_MOBILE1").val("010");
			$("#SMART_MOBILE2").val("");
			$("#SMART_MOBILE3").val("");
			$("#SMART_USE").val(0);
		}else{
			var param = "mode=farm&AREA_CODE="+C_USER_ID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
				        var EMAIL = data.list.EMAIL ? data.list.EMAIL : "";
				        var MOBILE = data.list.MOBILE ? data.list.MOBILE : "";
				        var SMART_MOBILE = data.list.SMART_MOBILE ? data.list.SMART_MOBILE : "";
						$("#C_USER_ID").val(data.list.USER_ID);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
						$("#USER_TYPE").val(data.list.USER_TYPE);
						$("#MENU_TYPE").val(data.list.MENU_TYPE);
						$("#USER_ID").val(data.list.USER_ID);
						$("#USER_PWD").val(data.list.USER_PWD);
						$("#USER_NAME").val(data.list.USER_NAME);
						$("#EMAIL1").val(EMAIL.split("@")[0]);
						$("#EMAIL2").val(0);
						$("#EMAIL3").val(EMAIL.split("@")[1]);
						$("#MOBILE1").val(MOBILE.split("-")[0]);
						$("#MOBILE2").val(MOBILE.split("-")[1]);
						$("#MOBILE3").val(MOBILE.split("-")[2]);
						$("#IS_PERMIT").val(data.list.IS_PERMIT);
						$("#SMART_MOBILE1").val(SMART_MOBILE.split("-")[0]);
						$("#SMART_MOBILE2").val(SMART_MOBILE.split("-")[1]);
						$("#SMART_MOBILE3").val(SMART_MOBILE.split("-")[2]);
						$("#SMART_USE").val(data.list.SMART_USE);
						
				        if(data.right){
							$.each(data.right, function(i, v){
								//console.log(i, v);
								var tmp_id = "#tree_"+v['GROUP_ID']+"_"+v['RTU_ID'];
								$("#tree").jstree("select_node", tmp_id); // jstree 해당 id 체크
							});
				        }
			        }else{
					    swal("체크", "초기화중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });
		}
	});


	// 수정
	$("#btn_up").click(function(){
		if( form_check("U") ){
			var C_USER_ID = $("#BUSINESS_NAME_IN").val();
			var LICENSE_NUM = $("#LICENSE").val();
			var NAME = $("#NAME").val();
			var IDX = $("#IDX").val();
			//console.log(C_USER_ID);
			swal({
				title: '<div class="alpop_top_b">농가 수정 확인</div><div class="alpop_mes_b">['+NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 농가가 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					//var param = "mode=farm_up&AREA_CODE="+AREA_CODE+""+$("#set_frm").serialize();
					var param = "mode=farm_up&LICENSE_NUM="+LICENSE_NUM+"&"+$("#set_frm").serialize();

					/*
					var param = "mode=farm_up&AREA_CODE="+AREA_CODE+"&BUSINESS_NAME_IN="+BUSINESS_NAME_IN+"&COPR_NUM="+COPR_NUM+
					"&COPR_NAME="+COPR_NAME+"&COPR_ADDRESS1_IN="+COPR_ADDRESS1_IN+"&COPR_ADDRESS2_IN="+COPR_ADDRESS2_IN+
					"&COPR_ADDRESS3_IN="+COPR_ADDRESS3_IN+"&BUSINESS_ADDRESS1_IN="+BUSINESS_ADDRESS1_IN+"&BUSINESS_ADDRESS2_IN="
					+BUSINESS_ADDRESS2_IN+"&BUSINESS_ADDRESS3_IN="+BUSINESS_ADDRESS3_IN+$("#set_frm").serialize();
					*/
					
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
						        if(data.msg){
							    	swal("체크", data.msg, "warning");
						        }else{
								    swal("체크", "농가 수정중 오류가 발생 했습니다.", "warning");
						        }
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 삭제
	$("#btn_de").click(function(){
		if( form_check("D") ){
			var C_USER_ID = $("#BUSINESS_NAME_IN").val();
			var AREA_CODE = $("#AREA_CODE_IN").val();
			var LICENSE_NUM = $("#LICENSE").val();
			var IDX = $("#IDX").val();
			//var AREA_CODE = $("#"+this.id+" #AREA_CODE").text();
			swal({
				title: '<div class="alpop_top_b">농가 삭제 확인</div><div class="alpop_mes_b">['+C_USER_ID+']을 삭제하실 겁니까?</div>',
				text: '확인 시 농가가 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=farm_de&LICENSE_NUM="+LICENSE_NUM;
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_set_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
								location.reload(); return false;
					        }else{
							    swal("체크", "농가 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 방송권한 지역 선택
	$("#btn_right").click(function(){
		
		if( !$("#USER_TYPE").val() ){
	    	swal("체크", "사용자 구분을 선택해 주세요.", "warning");
	    	$("#USER_TYPE").focus(); return false;	
		}else if( $("#USER_TYPE").val() == "0" || $("#USER_TYPE").val() == "1" ){
	    	swal("체크", "관리자의 경우 소속기관의 모든 장비에 방송권한이 있습니다.", "warning");
	    	$("#USER_TYPE").focus(); return false;	
		}else{
			popup_open(); // 레이어 팝업 열기
		}
	});
	
	// 트리메뉴 호출
	if(ie_version == "N/A"){ // ie가 아닐 경우
		$("#tree").jstree({
			"plugins":["wholerow", "checkbox"]
		});
	}else{ // ie일 경우(wholerow 플러그인에 ie 오류 있음)
		$("#tree").jstree({
			"plugins":["checkbox"]
		});
	}

	// 트리메뉴 체크 상태 변경 시
	$("#tree").on("changed.jstree", function(e, data){
		$("#STR_RTU_ID").val("");
		
	    for(i = 0; i < data.selected.length; i ++){
	    	var obj = data.instance.get_node(data.selected[i]);
	    	var type = obj.li_attr.type;
	    	var group_id = obj.li_attr.group_id;
	    	var rtu_id = obj.li_attr.rtu_id;
	    	//console.log(type, group_id, rtu_id);
	    	
	    	if(type == "rtu"){
		    	var STR_RTU_ID = $("#STR_RTU_ID").val();
		    	
		    	if(STR_RTU_ID == ""){
		    		$("#STR_RTU_ID").val(rtu_id);
		    	}else{
		    		$("#STR_RTU_ID").val(STR_RTU_ID + "-" + rtu_id);
		    	}
	    	}
	    }

		var tmp_arr_check = [];
	    var tmp_arr_split = $("#STR_RTU_ID").val().split("-");
	    $.each(tmp_arr_split, function(i, v){
	    	if(jQuery.inArray(v, tmp_arr_check) == "-1" && v != ""){
	 		   tmp_arr_check.push(v);
	    	}
	    });

	    $("#STR_RTU_ID").val( tmp_arr_check.join("-") );
	    $("#rtu_cnt_text").text( tmp_arr_check.length );
	}).jstree();
	
	// 방송권한 지역 전체선택
	$("#btn_all").click(function(){
		var now_sel = $("#tree").jstree("get_selected");
		var max_cnt = 0;
		$.each($("#tree").jstree("get_json"), function(i, v){
			max_cnt += Number(v["children"].length + 1);
		});
		
		if(now_sel.length == max_cnt){
			$("#tree").jstree("deselect_all");
		}else{
			$("#tree").jstree("select_all");
		}
	}); 
		
	// 아이디 입력 시
	$("#USER_ID").change(function(){
		$("#dup_check").val(0); // 아이디 중복체크 리셋
	});

	// 아이디 중복체크
	$("#btn_check").click(function(){
		if( !$("#USER_ID").val() ){
		    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
		    $("#USER_ID").focus(); return false;	
		}else{
			var param = "mode=user_dup&USER_ID="+$("#USER_ID").val()+"&C_USER_ID="+$("#C_USER_ID").val();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result){
					    swal("체크", "사용하실 수 있는 아이디 입니다.", "success");
				  		$("#dup_check").val(1);
			        }else{
					    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
				  		$("#dup_check").val(0);
			        }
		        }
		    });
		}
	});

	// 이메일 직접입력
	$("#EMAIL2").change(function(){
		if( $("#EMAIL2").val() == 0 ){
			$("#EMAIL3").val("");
			$("#EMAIL3").removeClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", false);
		}else{
			$("#EMAIL3").val( $("#EMAIL2").val() );
			$("#EMAIL3").addClass("bg_lgr_d");
			$("#EMAIL3").prop("readonly", true);
		}
	});
    
	// 폼 체크

	function form_check(kind){
		/*
		var id_check = /^[a-zA-Z0-9]{1,15}$/; // 영어 대소문자 또는 숫자이며 15자리 이하
		//var pwd_check = /^(?=.*?[#?!@$%^&*-]).{4,}$/; // 적어도 하나의 특수문자가 들어가며 4자리 이상
		var mobile_check = /^\d{2,3}(-?)\d{3,4}(-?)\d{4}$/; // 전화번호 형식
		
		if(kind == "I"){

			if( !$("#USER_TYPE").val() ){
			    swal("체크", "사용자 구분을 선택해 주세요.", "warning");
			    $("#USER_TYPE").focus(); return false;	
			}else if( !$("#USER_ID").val() ){
			    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "사용자 ID는 영어와 숫자만 사용하여 15자리 이하로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			}else if( $("#USER_ID").val() == $("#C_USER_ID").val() ){
			    swal("체크", "이미 사용중인 아이디 입니다.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			/*    
			}else if( !pwd_check.test( $("#USER_PWD").val() ) ){
			    swal("체크", "비밀번호는 특수문자를 사용해야 하며 4자리 이상으로 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;
			*/ 
				


			/*
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "사용자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "사용자를 선택해 주세요.", "warning"); return false;
			}else if( !$("#USER_TYPE").val() ){
			    swal("체크", "사용자 구분을 선택해 주세요.", "warning");
			    $("#USER_TYPE").focus(); return false;	
			}else if( !$("#USER_ID").val() ){
			    swal("체크", "사용자 ID를 입력해 주세요.", "warning");
			    $("#USER_ID").focus(); return false;	
			}else if( !id_check.test( $("#USER_ID").val() ) ){
			    swal("체크", "사용자 ID는 영어와 숫자만 사용하여 15자리 이하로 입력해 주세요.", "warning"); 
			    $("#USER_ID").focus(); return false;	
			}else if( $("#dup_check").val() == "0" ){
			    swal("체크", "아이디 중복체크를 진행해 주세요.", "warning"); return false;
			}else if( !$("#USER_PWD").val() ){
			    swal("체크", "비밀번호를 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;	
			/*    
			}else if( !pwd_check.test( $("#USER_PWD").val() ) ){
			    swal("체크", "비밀번호는 특수문자를 사용해야 하며 4자리 이상으로 입력해 주세요.", "warning");
			    $("#USER_PWD").focus(); return false;
			*/  
				

			/*
			}else if( !$("#USER_NAME").val() ){
			    swal("체크", "사용자명을 입력해 주세요.", "warning"); 
			    $("#USER_NAME").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#C_USER_ID").val() ){
			    swal("체크", "사용자를 선택해 주세요.", "warning"); return false;
			}
		}
		*/
		return true;
		
	}

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#dup_check").val(0); // 아이디 중복체크 리셋
	$("#C_USER_ID").val("");
	$("#STR_RTU_ID").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
	$("#USER_TYPE").val("");
	$("#MENU_TYPE").val(0);
	$("#USER_ID").val("");
	$("#USER_PWD").val("");
	$("#USER_NAME").val("");
	$("#EMAIL1").val("");
	$("#EMAIL2").val(0);
	$("#EMAIL3").val("");
	$("#MOBILE1").val("010");
	$("#MOBILE2").val("");
	$("#MOBILE3").val("");
	$("#IS_PERMIT").val(0);
	$("#SMART_MOBILE1").val("010");
	$("#SMART_MOBILE2").val("");
	$("#SMART_MOBILE3").val("");
	$("#SMART_USE").val(0);
});
</script>


<!---------------------  주소검색 API 레이어팝업 오버레이------------------------>
<!--
<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:absolute;left:380px;top:380px;">
						<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
						</div>
-->
<div id="layer" style="display:none; position:absolute; left:450px; top:300px; overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
<script type="text/javascript" src="//openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=2mnlt88fmn&submodules=geocoder&callback=naver_api"></script>
						</div>
<!---------------------  주소검색 API호출 ------------------------->
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="../js/postcode_layer.js"></script>


</body>
</html>


