<?
require_once "../_conf/_common.php";
require_once "../_info/_wa_send.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">

		<form id="wa_frm" action="wa_send.php" method="get">
		<input type="hidden" id="STR_IDX" name="STR_IDX"><!-- 전송할 장비 아이디 -->
		<input type="hidden" id="MSG_IDX" name="MSG_IDX"><!-- 전송할 메세지 IDX -->
		
		<div class="main_contitle">
			<img src="../images/title_08_03.png" alt="메세지 전송">
            <div class="unit">※ 메세지를 드래그 하면 순서를 변경할 수 있습니다.</div>
		</div>

		<ul class="tb_alarm h550p">
		
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry">장비 목록</li>
						<li id="list_table" class="h100">		
						<?
						if($data_rtu){
							foreach($data_rtu as $key => $val){
						?>			
							<ul id="list_<?=$val['RTU_ID']?>" data-id="<?=$val['RTU_ID']?>">
								<li><?=$val['RTU_NAME']?></li>
							</ul>
						<?
							}
						}
						?>	
						</li>
					</ul>
				</div>
			</li>
			<li class="mi"></li>
			
			<li class="tb_alarm_r2">
				<ul class="set_ulwrap_nh">
					<li class="tb_sms_gry">메세지 구분
						<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" size="1" class="f333_12">
							<option value="">전체</option>
							<option value="0">일반</option>
							<option value="1">긴급</option>
						</select>
						<button type="button" id="btn_send" class="btn_bs60 mL5">전송하기</button>
						<button type="button" id="btn_edit" class="btn_wgb120_s">메세지 등록/편집</button>
					</li>
					<li id="list_spin" class="li100_nor">		
            			<div id="spin"></div>
						<table class="tb_data">
							<thead class="tb_data_tbg">
								<tr>
									<td class="bR_1gry">순서</td>
									<td class="bR_1gry">종류</td>
									<td class="bL_1gry">제목</td>
									<td class="bL_1gry">효과</td>
									<td class="bL_1gry">상단문안</td>
									<td class="bL_1gry">하단문안</td>
									<td class="bL_1gry">횟수</td>
								</tr>
							</thead>
							<tbody id="list_table2">
							<? 
							if($data_list){
								foreach($data_list as $key => $val){ 
							?>
							<tr id="list_<?=$val['IDX']?>" data-id="<?=$val['IDX']?>" data-comm="<?=$val['PANELCOMMAND']?>">
								<td id="NUM" class="bR_1gry"><?=$val['NUM']?></td>
								<td class="bR_1gry"><?=$val['PANELCOMMANDTEXT']?></td>
								<td class="bL_1gry"><?=$val['TEXTNAME']?></td>
								<td class="bL_1gry"><?=$val['PANELVIEWTYPETEXT']?></td>
								<td class="bL_1gry"><?=$val['TEXTA']?></td>
								<td class="bL_1gry"><?=$val['TEXTB']?></td>
								<td class="bL_1gry"><?=$val['PANELVIEWREPEATCNT']?></td>
							</tr>
							<? 
								}
							}
							?>
							</tbody>
						</table>
					</li>
				</ul>
			</li>
		</ul>
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	// 장비 선택
	$("#list_table ul").click(function(){
		bg_color("selected", "#list_table ul", this); // 리스트 선택 시 배경색

		var IDX = $(this).data("id");
		$("#STR_IDX").val(IDX);
	}); 

	// 메세지 구분 셀렉트
	$("#SECTION_NO_SEARCH").change(function(){
		$.each($("#list_table2 tr"), function(i, v){
			if( $("#SECTION_NO_SEARCH").val() == "" ){
				$(this).closest("tr").show();
			}else if( $("#SECTION_NO_SEARCH").val() != $(v).data("comm") ){
				$(this).closest("tr").hide();
			}else if( $("#SECTION_NO_SEARCH").val() == $(v).data("comm") ){
				$(this).closest("tr").show();
			}
		});
	});

	// 메세지 선택
	$("#list_table2 tr").click(function(){
		var tmp_cnt = $("#list_table2 tr.selected").length;
		if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
        	if(tmp_cnt == 5){
    	    	swal("체크", "장비별 메세지는 최대 5개까지 전송할 수 있습니다.", "warning");
    	    }else{
				$(this).addClass("selected");
    	    }
        }
	});

	// 메세지 드래그 앤 드롭
	$("#list_table2").sortable({
		cursor: "move",
        update: function(event, ui){
            $(this).children().each(function(index){
    			$("#"+this.id+" #NUM").html(index + 1)
        	});
            
			if( $("#SECTION_NO_SEARCH").val() != "" ){
				swal("체크", "메세지 구분이 전체일 때만 순서를 변경할 수 있습니다.", "warning");
			    $(this).sortable("cancel");
			}else{
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
	    		var param = "mode=wa_msg_sort&str_sort="+str_sort;
	    		$.ajax({
	    	        type: "POST",
	    	        url: "../_info/json/_wa_json.php",
	    		    data: param,
	    	        cache: false,
	    	        dataType: "json",
	    	        success : function(data){
	    		        if(data.result){
	    		        }else{
	    				    swal("체크", "메세지 정렬중 오류가 발생 했습니다.", "warning");
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
        }
	});

	// 메세지 등록편집
	$("#btn_edit").click(function(){
		location.href = "wa_msg.php"; return false;
	});
            
	// 전송
	$("#btn_send").click(function(){
		if( form_check() ){
			swal({
				title: '<div class="alpop_top_b">메세지 전송 확인</div><div class="alpop_mes_b">메세지를 전송하실 겁니까?</div>',
				text: '확인 시 메세지가 전송 됩니다.',
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
					$("#MSG_IDX").val("");
					$.each($("#list_table2 tr"), function(i, v){
				        if( $(v).hasClass("selected") ){
							var MSG_IDX = $("#MSG_IDX").val();
							var IDX = $(this).data("id");
							
							if(MSG_IDX == ""){
								$("#MSG_IDX").val(IDX);
							}else{
								$("#MSG_IDX").val(MSG_IDX + "-" + IDX);
							}
				        }
					});
					//console.log( $("#MSG_IDX").val() );
					
					var param = "mode=wa_msg_send&"+$("#wa_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_wa_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result[0]){
					        	if(data.result[3]){
				                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    			location.href = "wa_state.php?sno="+data.result[1]+"&cnt="+data.result[2]; return false;
					        	}else{
				                	swal({
				                		title: "수질 검사 조회",
				                		text: "수질 검사 결과 불량 입니다. 불량 메세지가 표시 됩니다.", 
				                        type: "warning",
				                		timer: 1300,
				                	    showConfirmButton: false,
										closeOnClickOutside: false
				                	}, function(){
					                	popup_main_close(); // 레이어 좌측 및 상단 닫기
				                		location.href = "wa_state.php?sno="+data.result[1]+"&cnt="+data.result[2]; return false;
				                	}); 
					        	}
					        }else{
							    swal("체크", "메세지 전송중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
			
	// 폼 체크
	function form_check(){
		if( !$("#STR_IDX").val() ){
		    swal("체크", "장비를 선택해 주세요.", "warning"); return false;	
		}else if( !bg_color_check("selected", "#list_table2 tr") ){ // 리스트 선택 체크
			swal("체크", "메세지를 선택해 주세요.", "warning"); return false;	
		}
		return true;
	}

	// 뒤로가기 관련 처리
	$("#SECTION_NO_SEARCH").val("");
	$("#STR_IDX").val("");
	$("#MSG_IDX").val("");
});
</script>

</body>
</html>


