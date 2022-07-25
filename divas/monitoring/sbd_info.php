<?
require_once "../_conf/_common.php";
require_once "../_info/_sbd_info.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="sbd_frm" action="sbd_info.php" method="get">
		
		<div class="main_contitle">
			<img src="../images/title_08_07.png" alt="긴급 전광판">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh bL0 bR0 bB0">
			<!-- 
			<li class="tb_sms_gry">
				설치 지역 : 
				<select id="AREABESTID" name="AREABESTID" size="1">
					<option value="">상위 지역 선택</option>
			<? 
			if($data_areab){
				foreach($data_areab as $key => $val){ 
			?>
					<option value="<?=$val['AREABESTID']?>" <?if($_REQUEST['AREABESTID'] == $val['AREABESTID']){echo "selected";}?>><?=$val['AREABESTNAME']?></option>
			<? 
				}
			}
			?>
				</select>
				/
				<select id="AREAID" name="AREAID" size="1">
					<option value="">지역 선택</option>
			<? 
			if($data_area){
				foreach($data_area as $key => $val){ 
			?>
					<option value="<?=$val['AREAID']?>" <?if($_REQUEST['AREAID'] == $val['AREAID']){echo "selected";}?>><?=$val['AREANAME']?></option>
			<? 
				}
			}
			?>
				</select>
				/
				<select id="SITEID" name="SITEID" size="1">
					<option value="">설치 장소 선택</option>
			<? 
			if($data_sign){
				foreach($data_sign as $key => $val){ 
			?>
					<option value="<?=$val['SITEID']?>" <?if($_REQUEST['SITEID'] == $val['SITEID']){echo "selected";}?>><?=$val['SITENAME']?></option>
			<? 
				}
			}
			?>
				</select>
			</li>
			-->
			<li id="li_1" class="li100_nor">
				<table id="list_table" class="main_table hi100 w100">
					<tbody>
					</tbody>
				</table>
				<div id="spin" class="tmp-spin-size"></div>
			</li>
		</ul>
		</div>
		<div class="main_contitle">
			<img src="../images/title_08_01.png" alt="전광판 현황">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh bL0 bR0 bB0">
			<li id="li_2" class="li100_nor">
				<table id="list_table2" class="main_table hi100 w100">
					<tbody>
					</tbody>
				</table>
				<div id="spin" class="tmp-spin-size"></div>
			</li>
		</ul>
		</div>
		
		</form>
		<div id="popup_overlay" class="popup_overlay"></div>
		<div id="popup_layout" style="display: none;">
			<div id="pop_1" class="popup_layout_c">
				<div class="popup_top">이미지 원본
					<button id="popup_close" class="btn_lbs fR bold">X</button>
				</div>
				<div class="popup_con_1">	
					<div class="alarm">			
						<form method="get" class="sbd_scroll">
							<table class="tb_data w100">
								<tbody>
									<tr>
										<td><img id="img_area2" class="sbd_scroll" src=""></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 상위 지역 조회
	$("#AREABESTID").change(function(){
		$("#sbd_frm").submit();
	});
	
	// 지역 조회
	$("#AREAID").change(function(){
		$("#sbd_frm").submit();
	});
	
	// 설치 장소 조회
	$("#SITEID").change(function(){
		$("#sbd_frm").submit();
	});

	urg_load(1, "#li_1"); // 긴급 전광판 조회
	msg_load(1, "#li_2"); // 전광판 현황 조회
	
	// 10초마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		urg_load(2, "#li_1");
		msg_load(2, "#li_2");
	}, 10000);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}

	// 긴급 메세지 중지
    $(document).on("click", "#list_table tr #btn_stop", function(){
        var tmp_tr = $(this).closest("tr");
        var tmp_id = $(tmp_tr).data("id");

		swal({
				title: '<div class="alpop_top_b">메세지 중지 확인</div><div class="alpop_mes_b">전광판 메세지를 중지 하시겠습니까?</div>',
				text: '확인 시 메세지가 중지 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				
				if(isConfirm){
					
				//중복 submit 방지
				if(doubleSubmitCheck()) return;
				var param = "mode=sbd_urg_stop&IDX="+tmp_id;
				$.ajax({
					type: "POST",
					url: "../_info/json/_sbd_json.php",
					data: param,
					cache: false,
					dataType: "json",
					success : function(data){
						if(data.result){
							popup_main_close(); // 레이어 좌측 및 상단 닫기
							location.href = "sbd_info.php";
						}else{
							swal("체크", "긴급 메세지 중지중 오류가 발생 했습니다.", "warning");
						}
					}
				});
			}
		}); // swal end
	});

	// 일반 메세지 중지 >> 일반 메세지 중지 기능 없으므로 주석 처리
    $(document).on("click", "#list_table2 tr #btn_stop", function(){
        var tmp_tr = $(this).closest("tr");
        var tmp_id = $(tmp_tr).data("id");

		var param = "mode=sbd_msg_stop&IDX="+tmp_id;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sbd_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
				if(data.result){
                	popup_main_close(); // 레이어 좌측 및 상단 닫기
		    		location.href = "sbd_info.php";
		        }else{
				    swal("체크", "일반 메세지 중지중 오류가 발생 했습니다.", "warning");
		        }
	        }
        });
	});
	
	// 긴급 전광판 조회
	function urg_load(type, li_id){
		var tmp_spin = null;
		var param = "mode=sbd_urg&"+$("#sbd_frm").serialize();
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sbd_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
				var tmp_html = '';
				tmp_html += '<tr> ';
				tmp_html += '<th class="bL0">상위지역</th> ';
				tmp_html += '<th>지역</th> ';
				tmp_html += '<th>설치장소</th> ';
				tmp_html += '<th>효과</th> ';
				tmp_html += '<th>속도</th> ';
				tmp_html += '<th>정지시간</th> ';
				tmp_html += '<th>가로크기</th> ';
				tmp_html += '<th>세로크기</th> ';
				tmp_html += '<th>색깔</th> ';
				tmp_html += '<th>내용</th> ';
				tmp_html += '<th>상태</th> ';
				tmp_html += '<th>전송시간</th> ';
				tmp_html += '<th>종료시간</th> ';
				tmp_html += '<th>중지</th> ';
				tmp_html += '</tr> ';

				if(data.list){
		            $.each(data.list, function(i, v){
		            	tmp_html += ' <tr id="urg_'+v.IDX+'" class="hh" data-id="'+v.IDX+'"> ';
		            	tmp_html += ' <td id="AREABESTNAME">'+v.AREABESTNAME+'</td> ';
		            	tmp_html += ' <td id="AREANAME">'+v.AREANAME+'</td> ';
						tmp_html += ' <td id="SITENAME">'+v.SITENAME+'</td> ';
						tmp_html += ' <td id="ACTIONNAME">'+v.ACTIONNAME+'</td> ';
						tmp_html += ' <td id="MSGSPD">'+v.MSGSPD+'</td> ';
						tmp_html += ' <td id="MSGDELAY">'+v.MSGDELAY+'</td> ';
						tmp_html += ' <td id="MODX">'+v.MODX+'</td> ';
						tmp_html += ' <td id="MODY">'+v.MODY+'</td> ';
						tmp_html += ' <td id="COLORNAME">'+v.COLORNAME+'</td> ';
						if(v.TYPE == "0"){
							tmp_html += ' <td id="MSG">'+v.MSG+'</td> ';
						}else if(v.TYPE == "1"){
							tmp_html += ' <td id="IMGPATH"><img id="img_area" class="w85 sbd_overX" src="'+v.IMGPATH+'"></td> ';
						}
						tmp_html += ' <td id="SUCCESS_NAME">'+v.SUCCESS_NAME+'</td> ';
						tmp_html += ' <td id="SENDDATE">'+v.SENDDATE+'</td> ';
						tmp_html += ' <td id="ENDDATE">'+v.ENDDATE+'</td> ';
						tmp_html += ' <td><button type="button" id="btn_stop" class="btn_lgs">중지</button></td> ';
						tmp_html += ' </tr>';
		            });
				}else{
					tmp_html += ' <tr> ';
					tmp_html += ' <td colspan="14">데이터가 없습니다.</td> ';
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

				// 원본보기 클릭시
				$(".sbd_overX").click(function(){
					$("#pop_1").show();
					$("#img_area2").attr("src", $("#img_area").attr('src'));
					popup_open(); // 레이어 팝업 열기
				});
	        }
        });
	}
	
	// 전광판 현황 조회
	function msg_load(type, li_id){
		var tmp_spin = null;
		var param = "mode=sbd_new&"+$("#sbd_frm").serialize();
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_sbd_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
				var tmp_html = '';
				tmp_html += ' <tr> ';
				tmp_html += ' <th class="bL0">상위지역</th> ';
				tmp_html += ' <th>지역</th> ';
				tmp_html += ' <th>설치장소</th> ';
				tmp_html += ' <th>효과</th> ';
				tmp_html += ' <th>속도</th> ';
				tmp_html += ' <th>정지시간</th> ';
				tmp_html += ' <th>가로크기</th> ';
				tmp_html += ' <th>세로크기</th> ';
				tmp_html += ' <th>색깔</th> ';
				tmp_html += ' <th class="w10">내용</th> ';
				tmp_html += ' <th>상태</th> ';
				tmp_html += ' <th>순서</th> ';
				tmp_html += ' <th>전송시간</th> ';
				tmp_html += ' <!-- <th>중지</th> --> ';
				tmp_html += ' </tr> ';
				if(data.list){
		            $.each(data.list, function(i, v){
		            	tmp_html += ' <tr id="msg_'+v.IDX+'" class="hh" data-id="'+v.IDX+'"> ';
		            	tmp_html += ' <td id="AREABESTNAME">'+v.AREABESTNAME+'</td> ';
		            	tmp_html += ' <td id="AREANAME">'+v.AREANAME+'</td> ';
						tmp_html += ' <td id="SITENAME">'+v.SITENAME+'</td> ';
						tmp_html += ' <td id="ACTIONNAME">'+v.ACTIONNAME+'</td> ';
						tmp_html += ' <td id="MSGSPD">'+v.MSGSPD+'</td> ';
						tmp_html += ' <td id="MSGDELAY">'+v.MSGDELAY+'</td> ';
						tmp_html += ' <td id="MODX">'+v.MODX+'</td> ';
						tmp_html += ' <td id="MODY">'+v.MODY+'</td> ';
						tmp_html += ' <td id="COLORNAME">'+v.COLORNAME+'</td> ';
						if(v.TYPE == "0"){
							tmp_html += ' <td id="MSG">'+v.MSG+'</td> ';
							// tmp_html += ' <td id="MSG"><img src="../images/text_icon01.png" alt="텍스트" class="msgIcon">&nbsp;&nbsp;'+v.MSG+'</td> ';
						}else if(v.TYPE == "1"){
							tmp_html += ' <td id="IMGPATH"><img id="img_area" class="w85 sbd_overX" src="'+v.IMGPATH+'"></td> ';
							// tmp_html += ' <td id="IMGPATH"><img src="../images/img_icon02.png" alt="이미지" class="msgIcon">&nbsp;&nbsp;'+v.IMGPATH+'</td> ';
						}
						tmp_html += ' <td id="SUCCESS_NAME">'+v.SUCCESS_NAME+'</td> ';
						tmp_html += ' <td id="ORDERNUM">'+v.ORDERNUM+'</td> ';
						tmp_html += ' <td id="SENDDATE">'+v.SENDDATE+'</td> ';
						//tmp_html += ' <td><button type="button" id="btn_stop" class="btn_lgs">중지</button></td> ';
						tmp_html += ' </tr>';
		            });
				}else{
					tmp_html += ' <tr> ';
					tmp_html += ' <td colspan="14">데이터가 없습니다.</td> ';
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
					
				// 원본보기 클릭시
				$(".sbd_overX").click(function(){
					$("#pop_1").show();
					$("#img_area2").attr("src", $("#img_area").attr('src'));
					popup_open(); // 레이어 팝업 열기
				});
	        }
        });
	}
});
</script>

</body>
</html>


