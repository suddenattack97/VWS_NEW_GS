<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<ul id="li_1" class="main_twrap">	
			<div class="main_contitle">
				<img src="../images/title_09_01.png" alt="수질 현황">
			</div>
			<table id="list_table" class="main_table_1">
				<thead>
					<tr>
						<th rowspan="2">지역</th>
						<th colspan="5">UV(%)</th>
						<th colspan="2">온도(℃)</th>
						<th rowspan="2">통신상태</th>
					</tr>
					<tr class="bB0">
						<td class="gry_f">전시간</td>
						<td class="gry">현시간</td>
						<td class="gry">살균위치</td>
						<td class="gry">작동상태</td>
						<td class="gry">작동방식</td>
						<td class="gry">전시간</td>
						<td class="gry">현시간</td>
					</tr>
				</thead>	
				<tbody>
				</tbody>
			</table>	
			<div id="spin" class="tmp-spin-size"></div>
		</ul>
	
		<ul id="li_2" class="main_twrap">	
			<div class="main_contitle">
				<img src="../images/title_09_02.png" alt="메세지 현황">
			</div>
			<table id="list_table2" class="main_table">
				<thead>
					<tr>
						<th>지역</th>
						<th>종류</th>
						<th>효과</th>
						<th>속도</th>
						<th>시간</th>
						<th>횟수</th>
						<th>밝기</th>
						<th>순서</th>
						<th>상단문안</th>
						<th>하단문안</th>
						<th>전송상태</th>
						<th>전송시간</th>
					</tr>
				</thead>	
				<tbody>
				</tbody>
			</table>	
			<div id="spin" class="tmp-spin-size"></div>
		</ul>

		<ul id="li_3" class="main_twrap">	
			<div class="main_contitle">
				<img src="../images/title_01_09.png" alt="장비 상태">
			</div>
			<table id="list_table3" class="main_table">
				<thead>
					<tr>
						<th>지역</th>
						<th>CDMA MAKER</th>
						<th>CDMA 수신율</th>
						<th>도어상태</th>
						<th>AC상태</th>
						<th>태양전지(충전전압)</th>
						<th>밧데리전압</th>
						<th>UV상균기전류</th>
						<th>최종호출시간</th>
					</tr>
				</thead>	
				<tbody>
				</tbody>
			</table>
			<div id="spin" class="tmp-spin-size"></div>	
		</ul>
		
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	now_load(1, "#li_1"); // 수질현황 조회
	msg_load(1, "#li_2"); // 메세지현황 조회
	state_load(1, "#li_3"); // 장비상태 조회
	
	// 10초마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		now_load(2, "#li_1");
		msg_load(2, "#li_2");
		state_load(2, "#li_3");
	}, 10000);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}
	
	// 수질현황 조회
	function now_load(type, li_id){
		var tmp_spin = null;
		var param = "mode=wa_now";
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	var tmp_html = '';
				if(data.list){
		            $.each(data.list, function(i, v){
		            	tmp_html += ' <tr> ';
		            	tmp_html += ' <td>'+v.RTU_NAME+'</td> ';
		            	tmp_html += ' <td>'+v.UV_BH+'</td> ';
						tmp_html += ' <td>'+v.UV_H+'</td> ';
						tmp_html += ' <td>'+v.CSELECTUV+'</td> ';
						tmp_html += ' <td>'+v.CUVSTATUS+'</td> ';
						tmp_html += ' <td>'+v.CUVMODE+'</td> ';
						tmp_html += ' <td>'+v.TEMP_BH+'</td> ';
						tmp_html += ' <td>'+v.TEMP_H+'</td> ';
						tmp_html += ' <td>'+v.CALL_LAST+'</td> ';
						tmp_html += ' </tr>';
		            });
				}else{
					tmp_html += ' <tr> ';
					tmp_html += ' <td colspan="9">데이터가 없습니다.</td> ';
					tmp_html += ' </tr>';
				}
				$("#list_table tbody").html(tmp_html);
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		    		tmp_spin = spin_start(li_id+" #spin", "50px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, li_id+" #spin");
		        		$(li_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}
	
	// 메세지현황 조회
	function msg_load(type, li_id){
		var tmp_spin = null;
		var param = "mode=wa_msg";
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	var tmp_html = '';
				if(data.list){
		            $.each(data.list, function(i, v){
		            	tmp_html += ' <tr> ';
		            	tmp_html += ' <td>'+v.RTU_NAME+'</td> ';
		            	tmp_html += ' <td>'+v.PANELCOMMAND+'</td> ';
		            	tmp_html += ' <td>'+v.PANELVIEWTYPE+'</td> ';
						tmp_html += ' <td>'+v.PANELVIEWSPEED+'</td> ';
						tmp_html += ' <td>'+v.PANELVIEWTIME+'</td> ';
						tmp_html += ' <td>'+v.PANELVIEWREPEATCNT+'</td> ';
						tmp_html += ' <td>'+v.PANELLUMIN+'</td> ';
						tmp_html += ' <td>'+v.MSGNO+'</td> ';
						tmp_html += ' <td>'+v.TEXTA+'</td> ';
						tmp_html += ' <td>'+v.TEXTB+'</td> ';
						tmp_html += ' <td>'+v.CALL_STATE+'</td> ';
						tmp_html += ' <td>'+v.TRANS_START+'</td> ';
						tmp_html += ' </tr>';
		            });
				}else{
					tmp_html += ' <tr> ';
					tmp_html += ' <td colspan="12">데이터가 없습니다.</td> ';
					tmp_html += ' </tr>';
				}
				$("#list_table2 tbody").html(tmp_html);
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		    		tmp_spin = spin_start(li_id+" #spin", "50px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, li_id+" #spin");
		        		$(li_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}
	
	// 장비상태 조회
	function state_load(type, li_id){
		var tmp_spin = null;
		var param = "mode=wa_state";
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
	        	var tmp_html = '';
				if(data.list){
		            $.each(data.list, function(i, v){
		            	tmp_html += ' <tr> ';
		            	tmp_html += ' <td>'+v.RTU_NAME+'</td> ';
		            	tmp_html += ' <td>'+v.M_CCDMAMODEL+'</td> ';
		            	tmp_html += ' <td>'+v.M_SCDMALEVEL+'</td> ';
						tmp_html += ' <td>'+v.CDOORSTAT+'</td> ';
						tmp_html += ' <td>'+v.CACSTAT+'</td> ';
						tmp_html += ' <td>'+v.SSOLARVOLTAGE+'</td> ';
						tmp_html += ' <td>'+v.SBATTERYVOLTAGE+'</td> ';
						tmp_html += ' <td>'+v.SLOAD1CURRENT+'</td> ';
						tmp_html += ' <td>'+v.LOG_DATE+'</td> ';
						tmp_html += ' </tr>';
		            });
				}else{
					tmp_html += ' <tr> ';
					tmp_html += ' <td colspan="10">데이터가 없습니다.</td> ';
					tmp_html += ' </tr>';
				}
				$("#list_table3 tbody").html(tmp_html);
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		    		tmp_spin = spin_start(li_id+" #spin", "50px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, li_id+" #spin");
		        		$(li_id+" #spin").removeClass("tmp-spin-size");
		        	}
	        	}
	        }
        });
	}
});
</script>

</body>
</html>


