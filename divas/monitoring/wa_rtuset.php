<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_rtuset.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
			
		<form id="wa_frm" action="wa_rtuset.php" method="get">
	
		<div class="main_contitle">
			<img src="../images/title_09_03.png" alt="시스템 제어">
            <div class="unit">※ 항목을 클릭하면 설정값을 확인할 수 있습니다.</div>
		</div>

		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="sel_left_n"> 
					기관 목록 조회 : 
					<select id="search_col" name="search_col" class="f333_12" size="1">
						<option value="0">장비명</option>
						<option value="1">행정코드</option>
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
			<li class="li100_nor">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li5">번호</th>
							<th class="li15 bL_1gry">장비 ID</th>
							<th class="li20 bL_1gry">장비명</th>
							<th class="li20 bL_1gry">행정코드</th>
							<th class="li40 bL_1gry">최종호출시간</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['NUM']?>" data-id="<?=$val['RTU_ID']?>">
							<td class="li5"><?=$val['NUM']?></td>
							<td class="li15 bL_1gry"><?=$val['RTU_ID']?></td>
							<td id="l_RTU_NAME" class="li20 bL_1gry"><?=$val['RTU_NAME']?></td>
							<td id="l_AREA_CODE" class="li20 bL_1gry"><?=$val['AREA_CODE']?></td>
							<td class="li40 bL_1gry"><?=$val['CALL_LAST']?></td>
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
				<span class="sel_right_n">
					<!-- 
					<button type="button" id="btn_in" class="btn_bb80">등록</button>
					<button type="button" id="btn_re" class="btn_lbb80_s">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_s">수정</button>
					<button type="button" id="btn_de" class="btn_lbb80_s">삭제</button>
					-->
				</span>
			</li>
			<li class="li100_nor">
				<table class="set_tb">
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">장비 ID</td>
						<td class="w15"><span id="SRTUID"></span></td>
						<td class="bg_lb w10 bold al_C">장비명</td>
						<td class="w15"><span id="RTU_NAME"></span></td>
						<td class="bg_lb w10 bold al_C">VerSion</td>
						<td class="w15"><span id="SZVERSIONSTRING"></span></td>
						<td class="bg_lb w10 bold al_C">Protocol</td>
						<td class="w15"><span id="SZPROTOCOLVERSION"></span></td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">비밀번호</td>
						<td>
							<input type="text" id="SZPASSWORD" name="SZPASSWORD" class="f333_12" size="20">
						</td>
						<td class="bg_lb w10 bold al_C">AC 이벤트</td>
						<td>
							<select id="ACEVENTUSE" name="ACEVENTUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">도어 이벤트</td>
						<td>
							<select id="CDOOREVUSE" name="CDOOREVUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">수질 검사 결과</td>
						<td>
							<select id="CWATERQUALITY" name="CWATERQUALITY" class="f333_12">
								<option value="0">정상</option>
								<option value="1">불량</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">IP</td>
						<td>
							<input type="text" id="SZCDMAIP" name="SZCDMAIP" class="f333_12" size="20">
						</td>
						<td class="bg_lb w10 bold al_C">PORT</td>
						<td>
							<input type="text" id="NCDMAPORT" name="NCDMAPORT" class="f333_12" size="10">
						</td>
						<td class="bg_lb w10 bold al_C">호출간격</td>
						<td>
							<select id="USCDMACONNECTBETWEENTIME" name="USCDMACONNECTBETWEENTIME" class="f333_12">
								<option value="0">10분</option>
								<option value="1">30분</option>
								<option value="2">1시간</option>
								<option value="3">3시간</option>
								<option value="4">6시간</option>
								<option value="5">12시간</option>
							</select>
						</td>
						<td class="bg_lb w10 bold al_C">기준시각</td>
						<td>
							<select id="SZCDMACONNECTSTDTIMEHOUR" name="SZCDMACONNECTSTDTIMEHOUR" class="f333_12" size="1">
							<?	
							for($i = 0; $i < 24; $i ++){
							?>
								<option value="<?=$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>시 
							<select id="SZCDMACONNECTSTDTIMEMIN" name="SZCDMACONNECTSTDTIMEMIN" class="gaigi12" size="1">
							<?	
							for($i = 0; $i < 60; $i ++){
							?>
								<option value="<?=$i?>"><?=$i?></option>
							<? 
							}
							?>
							</select>분
						</td>
					</tr>
					<tr>
						<td class="bg_lb w10 bold al_C bL_1gry_n">UV 살균기 성능</td>
						<td>
							<select id="CLUMINEVUSE" name="CLUMINEVUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
							<input type="text" id="NLUMINEVVAL" name="NLUMINEVVAL" class="f333_12" size="6">
						</td>
						<td class="bg_lb w10 bold al_C">UV 제어 수온</td>
						<td>
							<select id="CTEMPEVUSE" name="CTEMPEVUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
							<input type="text" id="NTEMPEVVAL" name="NTEMPEVVAL" class="f333_12" size="6">
						</td>
						<td class="bg_lb w10 bold al_C bL_1gry_n">전광판 밝기</td>
						<td>
							<select id="CPANELUSE" name="CPANELUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
							<input type="text" id="CPANELLUMIN" name="CPANELLUMIN" class="f333_12" size="6">
						</td>
						<td class="bg_lb w10 bold al_C">재가동 수온(차)</td>
						<td>
							<select id="CUVPURGEEVUSE" name="CUVPURGEEVUSE" class="f333_12">
								<option value="0">미사용</option>
								<option value="1">사용</option>
							</select>
							<input type="text" id="CTEMPGAPVAL" name="CTEMPGAPVAL" class="f333_12" size="6">
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

<script type="text/javascript">
$(document).ready(function(){
	// 조회
	$("#btn_search").click(function(){
		var search_col = $("#search_col").val();
		var search_word = $("#search_word").val();
		var search_col_id = "";
		if(search_col == "0"){ // 장비명
			search_col_id = "l_RTU_NAME";
		}if(search_col == "1"){ // 행정코드
			search_col_id = "l_AREA_CODE";
		}
		
		$.each( $("#list_table #"+search_col_id), function(i, v){
			if( $(v).text().indexOf(search_word) == -1 ){
				$(v).closest("tr").hide();
			}else{
				$(v).closest("tr").show();
			}
		});
	});
	
	// 전체목록
	$("#btn_search_all").click(function(){
		$("#list_table tr").show();
	});
	
	// 목록 선택
	$("#list_table tbody tr").click(function(){
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색

		var IDX = $(this).data("id");
		var param = "mode=wa_rtuset&RTU_ID="+IDX;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#SRTUID").text(data.list.SRTUID);
					$("#RTU_NAME").text(data.list.RTU_NAME);
					$("#SZVERSIONSTRING").text(data.list.SZVERSIONSTRING);
					$("#SZPROTOCOLVERSION").text(data.list.SZPROTOCOLVERSION);
					$("#SZPASSWORD").val(data.list.SZPASSWORD);
					$("#ACEVENTUSE").val(data.list.ACEVENTUSE);
					$("#CDOOREVUSE").val(data.list.CDOOREVUSE);
					$("#CWATERQUALITY").val(data.list.CWATERQUALITY);
					$("#SZCDMAIP").val(data.list.SZCDMAIP);
					$("#NCDMAPORT").val(data.list.NCDMAPORT);
					$("#USCDMACONNECTBETWEENTIME").val(data.list.USCDMACONNECTBETWEENTIME);
					$("#SZCDMACONNECTSTDTIMEHOUR").val(data.list.SZCDMACONNECTSTDTIMEHOUR);
					$("#SZCDMACONNECTSTDTIMEMIN").val(data.list.SZCDMACONNECTSTDTIMEMIN);
					$("#CLUMINEVUSE").val(data.list.CLUMINEVUSE);
					$("#NLUMINEVVAL").val(data.list.NLUMINEVVAL);
					$("#CTEMPEVUSE").val(data.list.CTEMPEVUSE);
					$("#NTEMPEVVAL").val(data.list.NTEMPEVVAL);
					$("#CPANELUSE").val(data.list.CPANELUSE);
					$("#CPANELLUMIN").val(data.list.CPANELLUMIN);
					$("#CUVPURGEEVUSE").val(data.list.CUVPURGEEVUSE);
					$("#CTEMPGAPVAL").val(data.list.CTEMPGAPVAL);
		        }else{
				    swal("체크", "시스템 제어 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 뒤로가기 관련 처리
	$("#search_col").val(0);
	$("#search_word").val("");
	$("#SRTUID").text("");
	$("#RTU_NAME").text("");
	$("#SZVERSIONSTRING").text("");
	$("#SZPROTOCOLVERSION").text("");
	$("#SZPASSWORD").val("");
	$("#ACEVENTUSE").val(0);
	$("#CDOOREVUSE").val(0);
	$("#CWATERQUALITY").val(0);
	$("#SZCDMAIP").val("");
	$("#NCDMAPORT").val("");
	$("#USCDMACONNECTBETWEENTIME").val(0);
	$("#SZCDMACONNECTSTDTIMEHOUR").val(0);
	$("#SZCDMACONNECTSTDTIMEMIN").val(0);
	$("#CLUMINEVUSE").val(0);
	$("#NLUMINEVVAL").val("");
	$("#CTEMPEVUSE").val(0);
	$("#NTEMPEVVAL").val("");
	$("#CPANELUSE").val(0);
	$("#CPANELLUMIN").val("");
	$("#CUVPURGEEVUSE").val(0);
	$("#CTEMPGAPVAL").val("");
});
</script>

</body>
</html>


