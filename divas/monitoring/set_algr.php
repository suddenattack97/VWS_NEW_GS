<?
require_once "../_conf/_common.php";
require_once "../_info/_set_algr.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<form id="set_frm" action="set_algr.php" method="get">
		<input type="hidden" id="ALARM_GRP_NO" name="ALARM_GRP_NO"><!-- 선택한 경보그룹 번호 -->
		<input type="hidden" id="select_x" value="<?=$rsXY[1]?>" name="CENTER_X"><!-- 좌표 -->
		<input type="hidden" id="select_y" value="<?=$rsXY[0]?>" name="CENTER_Y">
		<input type="hidden" id="zoom_level" value="10" name="ZOOM_LEVEL">
		
		<div class="main_contitle">
			<img src="../images/title_06_08.png" alt="경보그룹 설정">
		</div>
		<div class="right_bg">
		<ul class="set_ulwrap_nh">
			<li class="tb_sms_gry">
				<span class="fL"> 
					소속 기관 :
					<select id="ORGAN_ID" name="ORGAN_ID" class="f333_12">
					<? 
					if($data_organ){
						foreach($data_organ as $key => $val){ 
					?>
						<option value="<?=$val['ORGAN_ID']?>"><?=$val['ORGAN_NAME']?></option>
					<? 
						}
					}
					?>
					</select>
					<br>
					경보 그룹명 : <input type="text" id="ALARM_GRP_NAME" name="ALARM_GRP_NAME" class="f333_12_bm" size="30">
					<button type="button" id="btn_lo" class="btn_lbs">위치 선택</button>
				</span> 
				<span class="fR">
					<button type="button" id="btn_in" class="btn_bb80_l">등 록</button>
					<button type="button" id="btn_re" class="btn_lbb80_l">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_l">수 정</button>
					<button type="button" id="btn_de" class="btn_lbb80_l">삭제</button>
				</span>
			</li>
			<li class="li100_nor">
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th class="li20">경보그룹 번호</th>
							<th class="li80 bL_1gry">경보 그룹명</th>
						</tr>
					</thead>
					<tbody>
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['ALARM_GRP_NO']?>">
							<td id="l_ALARM_GRP_NO" class="li20"><?=$val['ALARM_GRP_NO']?></td>
							<td id="l_ALARM_GRP_NAME" class="li80 bL_1gry"><?=$val['ALARM_GRP_NAME']?></td>
						</tr>
				<? 
					}
				}else{
				?>
						<tr id="data_not">
							<td colspan="2">데이터가 없습니다.</td>
						</tr>
				<? 
				}
				?>
					</tbody>
				</table>
			</li>
		</ul>
		</div>
		</form>

		<!--지도 팝업-->
		<div id="popup_overlay" class="popup_overlay"></div>
		<div id="popup_layout" style="display: none;">
			<div id="pop_1" class="popup_layout">
				<div class="popup_top"><span id="alarm_name"></span>중심점 위치, 줌레벨 선택
					<button id="popup_close" class="btn_pop_blue fR bold">X</button>
				</div>
				<div class="popup_con">
					<div id="map">
					</div>
					<div class="btn_lo_in">
						<ul>
							<li id="map_in">선 택</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--지도 팝업 끝-->
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->
	
<script type="text/javascript">
$(document).ready(function(){

	function map_open(){
		var x_organ = "";
		var y_organ = "";

		x_organ = $("#select_x").val();
		y_organ = $("#select_y").val();
		
		var map_level = $("#zoom_level").val();
		
		// 지도 정의
		var mapContainer = document.getElementById('map'), // 지도를 표시할 div
          	mapOption = {
			useStyleMap:true,
        	center: new naver.maps.LatLng(y_organ, x_organ), // 지도의 중심 좌표
        	zoom: Number(map_level),
        	zoomControl: true,
            zoomControlOptions: {
                position: naver.maps.Position.TOP_RIGHT
            }
        };
        map = new naver.maps.Map(mapContainer, mapOption); mapContainer = null; mapOption = null;
		naver.maps.Event.once(map, 'init_stylemap', function () {
			$( map.zoomControl.getElement() ).css("top", "150px");
		});
		
        naver.maps.Event.addListener(map, 'zoom_changed', function(){
			map_level = map.getZoom();

			$("#zoom_level").val(map_level);
		});

		// 마커 정의
		var marker = new naver.maps.Marker({
    		map: map,
    		position: new naver.maps.LatLng(y_organ, x_organ),
    		zIndex: 4
		});

		naver.maps.Event.addListener(map, 'click', function(e) {
			marker.setPosition(e.latlng);
			
			$("#select_x").val(e.latlng.x);
			$("#select_y").val(e.latlng.y);

			// 중심점 이동
			map.setCenter(new naver.maps.LatLng(e.latlng.y, e.latlng.x));
		});

	}

	// 위치선택 버튼 클릭시 지도 팝업
	$("#btn_lo").click(function(){
		$("#pop_1").show();
		map_open();
		popup_open();
	});

	// 위치선택 선택버튼 클릭시
	$("#map_in").click(function(){
		$("#pop_1").hide();
		popup_close();
	});

	// 목록 선택
	$("#list_table tbody tr").click(function(){
		if(this.id == "data_not") return false;
		
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색
		var l_ALARM_GRP_NO = $("#"+this.id+" #l_ALARM_GRP_NO").text();
		
		var param = "mode=algr&ALARM_GRP_NO="+l_ALARM_GRP_NO;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#ALARM_GRP_NO").val(data.list.ALARM_GRP_NO);
					$("#ALARM_GRP_NAME").val(data.list.ALARM_GRP_NAME);
					$("#ORGAN_ID").val(data.list.ORGAN_ID);
					if(data.mapData.CENTER_X){
						$("#select_x").val(data.mapData.CENTER_X);
						$("#select_y").val(data.mapData.CENTER_Y);
						$("#zoom_level").val(data.mapData.ZOOM_LEVEL);
					}
		        }else{
				    swal("체크", "경보그룹 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">경보그룹 등록 확인</div><div class="alpop_mes_b">경보그룹을 등록하실 겁니까?</div>',
				text: '확인 시 경보그룹이 등록 됩니다.',
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
					var param = "mode=algr_in&"+$("#set_frm").serialize();
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
								swal("체크", "경보그룹 등록중 오류가 발생 했습니다.", "warning");
							}
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 초기화
	$("#btn_re").click(function(){
		var ALARM_GRP_NO = $("#ALARM_GRP_NO").val();
		if(ALARM_GRP_NO == ""){
			$("#ALARM_GRP_NO").val("");
			$("#ALARM_GRP_NAME").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
		}else{
			var param = "mode=algr&ALARM_GRP_NO="+ALARM_GRP_NO;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
						$("#ALARM_GRP_NO").val(data.list.ALARM_GRP_NO);
						$("#ALARM_GRP_NAME").val(data.list.ALARM_GRP_NAME);
						$("#ORGAN_ID").val(data.list.ORGAN_ID);
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
			var l_ALARM_GRP_NAME = $("#list_"+$("#ALARM_GRP_NO").val()+" #l_ALARM_GRP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">경보그룹 수정 확인</div><div class="alpop_mes_b">['+l_ALARM_GRP_NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 경보그룹이 수정 됩니다.',
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
					var param = "mode=algr_up&"+$("#set_frm").serialize();
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
								swal("체크", "경보그룹 수정중 오류가 발생 했습니다.", "warning");
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
			var l_ALARM_GRP_NAME = $("#list_"+$("#ALARM_GRP_NO").val()+" #l_ALARM_GRP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">경보그룹 삭제 확인</div><div class="alpop_mes_b">['+l_ALARM_GRP_NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 경보그룹이 삭제 됩니다.',
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
					var param = "mode=algr_de&"+$("#set_frm").serialize();
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
							    swal("체크", "경보그룹 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
    
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#ALARM_GRP_NAME").val() ){
			    swal("체크", "경보그룹명을 입력해 주세요.", "warning");
			    $("#ALARM_GRP_NAME").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#ALARM_GRP_NO").val() ){
			    swal("체크", "경보그룹을 선택해 주세요.", "warning"); return false;
			}else if( !$("#ALARM_GRP_NAME").val() ){
			    swal("체크", "경보그룹명을 입력해 주세요.", "warning");
			    $("#ALARM_GRP_NAME").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#ALARM_GRP_NO").val() ){
			    swal("체크", "경보그룹을 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#ALARM_GRP_NO").val("");
	$("#ALARM_GRP_NAME").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
});
</script>

</body>
</html>


