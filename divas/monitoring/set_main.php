<?
require_once "../_conf/_common.php";
require_once "../_info/_set_main.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="set_frm" action="set_main.php" method="get">
		<input type="hidden" id="GROUP_ID" name="GROUP_ID"><!-- 선택한 그룹 아이디 -->
		<input type="hidden" id="select_x" value="<?=$rsXY[1]?>" name="CENTER_X"><!-- 좌표 -->
		<input type="hidden" id="select_y" value="<?=$rsXY[0]?>" name="CENTER_Y">
		<input type="hidden" id="zoom_level" value="10" name="ZOOM_LEVEL">
		
		<div class="main_contitle">
			<img src="../images/title_point_01.png" alt="주요지점 설정">
            <div class="unit">※ 그룹을 드래그 하면 순서를 변경할 수 있습니다.</div>
		</div>

		<ul class="ulwrap_nh">
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
					그룹명 : <input type="text" id="GROUP_NAME" name="GROUP_NAME" class="f333_12_bm" size="30">
					<button type="button" id="btn_lo" class="btn_lbs">위치 선택</button>
				</span> 
				<span class="fR">
					<button type="button" id="btn_in" class="btn_bb80_l">등 록</button>
					<button type="button" id="btn_re" class="btn_lbb80_l">초기화</button>
					<button type="button" id="btn_up" class="btn_lbb80_l">수 정</button>
					<button type="button" id="btn_de" class="btn_lbb80_l">삭제</button>
				</span>
			</li>
			<li id="list_spin" class="li100_nor">		
            	<div id="spin"></div>
				<table id="list_table" class="tb_data">
					<thead class="tb_data_tbg">
						<tr>
							<th>그룹 ID</th>
							<th class="bL_1gry">그룹명</th>
						</tr>
					</thead>
					<tbody id="list_table2">
				<? 
				if($data_list){
					foreach($data_list as $key => $val){ 
				?>
						<tr id="list_<?=$val['GROUP_ID']?>" data-id="<?=$val['GROUP_ID']?>" >
							<td id="l_GROUP_ID"><?=$val['GROUP_ID']?></td>
							<td id="l_GROUP_NAME" class="bL_1gry"><?=$val['GROUP_NAME']?></td>
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
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--레이아웃-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" style="display: none;">
	<!--지도 팝업-->
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
	<!--지도 팝업 끝-->
</div>

<script type="text/javascript">
$(document).ready(function(){

	function map_open(){
		var x_organ = "";
		var y_organ = "";

		x_organ = $("#select_x").val();
		y_organ = $("#select_y").val();
		console.log(x_organ, y_organ);
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
		$("#pop_2").hide();
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
		var l_GROUP_ID = $("#"+this.id+" #l_GROUP_ID").text();
		
		var param = "mode=main&GROUP_ID="+l_GROUP_ID;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					$("#GROUP_ID").val(data.list.GROUP_ID);
					$("#GROUP_NAME").val(data.list.GROUP_NAME);
					$("#ORGAN_ID").val(data.list.ORGAN_ID);
					if(data.mapData.CENTER_X){
						$("#select_x").val(data.mapData.CENTER_X);
						$("#select_y").val(data.mapData.CENTER_Y);
						$("#zoom_level").val(data.mapData.ZOOM_LEVEL);
					}
		        }else{
				    swal("체크", "주요지점 상세 조회중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	});

	// 등록
	$("#btn_in").click(function(){
		if( form_check("I") ){
			swal({
				title: '<div class="alpop_top_b">주요지점 등록 확인</div><div class="alpop_mes_b">주요지점을 등록하실 겁니까?</div>',
				text: '확인 시 주요지점이 등록 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=main_in&"+$("#set_frm").serialize();
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
									swal("체크", "주요지점 등록중 오류가 발생 했습니다.", "warning");
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
		var GROUP_ID = $("#GROUP_ID").val();
		if(GROUP_ID == ""){
			$("#GROUP_ID").val("");
			$("#GROUP_NAME").val("");
			$("#ORGAN_ID option:eq(0)").prop("selected", true);
		}else{
			var param = "mode=main&GROUP_ID="+GROUP_ID;
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_set_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.list){
						$("#GROUP_ID").val(data.list.GROUP_ID);
						$("#GROUP_NAME").val(data.list.GROUP_NAME);
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
			var l_GROUP_NAME = $("#list_"+$("#GROUP_ID").val()+" #l_GROUP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">주요지점 수정 확인</div><div class="alpop_mes_b">['+l_GROUP_NAME+']을 수정하실 겁니까?</div>',
				text: '확인 시 경보그룹이 수정 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=main_up&"+$("#set_frm").serialize();
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
									swal("체크", "주요지점 수정중 오류가 발생 했습니다.", "warning");
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
			var l_GROUP_NAME = $("#list_"+$("#GROUP_ID").val()+" #l_GROUP_NAME").text();
			swal({
				title: '<div class="alpop_top_b">주요지점 삭제 확인</div><div class="alpop_mes_b">['+l_GROUP_NAME+']을 삭제하실 겁니까?</div>',
				text: '확인 시 주요지점이 삭제 됩니다.',
				showCancelButton: true,
				confirmButtonColor: '#5b7fda',
				confirmButtonText: '확인',
				cancelButtonText: '취소',
				closeOnConfirm: false,
				html: true
			}, function(isConfirm){
				if(isConfirm){					
					var param = "mode=main_de&"+$("#set_frm").serialize();
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
							    swal("체크", "주요지점 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});

	// 주요지점 드래그 앤 드롭
	$("#list_table2").sortable({ 
		cursor: "move",
        update: function(event, ui){
        	var str_sort = "";
			$.each($("#list_table2 tr"), function(i, v){
				var IDX = $(this).data("id");
				
				if(str_sort == ""){
					str_sort = IDX;
				}else{
					str_sort = str_sort + "-" + IDX;
				}
			});
			//console.log(str_sort);
			
    		var tmp_spin = null;
    		var param = "mode=main_sort&str_sort="+str_sort;
    		$.ajax({
    	        type: "POST",
    	        url: "../_info/json/_set_json.php",
    		    data: param,
    	        cache: false,
    	        dataType: "json",
    	        success : function(data){
    		        if(data.result){
    		        }else{
    				    swal("체크", "주요지점 정렬중 오류가 발생 했습니다.", "warning");
    		        }
    	        },
    	        beforeSend : function(data){ 
    	   			tmp_spin = spin_start("#list_spin #spin", "80px");
    	        },
    	        complete : function(data){ 
    	        	if(tmp_spin){
    	        		spin_stop(tmp_spin, "#list_spin #spin");
    	        	}
    	        }
    	    });
        }
	});
            
	// 폼 체크
	function form_check(kind){
		if(kind == "I"){
			if( !$("#GROUP_NAME").val() ){
			    swal("체크", "그룹명을 입력해 주세요.", "warning");
			    $("#GROUP_NAME").focus(); return false;	
			}
		}else if(kind == "U"){
			if( !$("#GROUP_ID").val() ){
			    swal("체크", "그룹을 선택해 주세요.", "warning"); return false;
			}else if( !$("#GROUP_NAME").val() ){
			    swal("체크", "그룹명을 입력해 주세요.", "warning");
			    $("#GROUP_NAME").focus(); return false;	
			}
		}else if(kind == "D"){
			if( !$("#GROUP_ID").val() ){
			    swal("체크", "그룹을 선택해 주세요.", "warning"); return false;
			}
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#GROUP_ID").val("");
	$("#GROUP_NAME").val("");
	$("#ORGAN_ID option:eq(0)").prop("selected", true);
});
</script>

</body>
</html>


