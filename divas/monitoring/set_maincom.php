<?
require_once "../_conf/_common.php";
require_once "../_info/_set_main.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">
	
		<form id="set_frm" action="set_maincom.php" method="get">
		<input type="hidden" id="GROUP_ID" name="GROUP_ID"><!-- 선택한 주요지점 아이디 -->
		<input type="hidden" id="IN_RTU_ID" name="IN_RTU_ID"><!-- 추가할 장비 아이디 -->
		<input type="hidden" id="DE_RTU_ID" name="DE_RTU_ID"><!-- 삭제할 장비 아이디 -->
		
		<div class="main_contitle">
			<img src="../images/title_point_02.png" alt="주요지점 구성">
		</div>
		
		<ul class="ulwrap_nh_nb">
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry">주요지점</li>
						<li class="li100_nor p0 min500 d_scroll">
							<table id="list_table" class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<th class="li30 hi25">그룹 ID</th>
										<th class="li70 hi25">그룹명</th>
									</tr>
								</thead>
								<tbody>
							<? 
							if($data_list){
								foreach($data_list as $key => $val){ 
							?>
									<tr id="list_<?=$val['GROUP_ID']?>">
										<td id="l_GROUP_ID" class="li30 hi25"><?=$val['GROUP_ID']?></td>
										<td class="li70 hi25"><?=$val['GROUP_NAME']?></td>
									</tr>
							<? 
								}
							}
							?>
								</tbody>
							</table>
						</li>
					</ul>
				</div>
			</li>
			
			<li class="mi"></li>
			
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry">
							소속 장비
							<button type="button" id="btn_in_all" class="btn_bs60">전체선택</button>
						</li>
						<li class="li100_nor p0 min500 d_scroll">
							<table id="list_table2" class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<th class="li30 hi25">구분</th>
										<th class="li20 hi25">장비 ID</th>
										<th class="li50 hi25">장비명</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</li>
					</ul>
				</div>
			</li>
			
			<li class="min500">
				<div class="sms_btn">
					<button type="button" id="btn_in" class="btn_smsgry">
						<img src="../images/sms_btn_add_r.png">
					</button>
					<button type="button" id="btn_de" class="btn_smsgry">
						<img src="../images/sms_btn_del_r.png">
					</button>
				</div>
			</li>
			
			<li class="tb_alarm_lm">
				<div class="alarm">
					<ul>
						<li class="alarm_gry">
							등록 가능 장비
							<button type="button" id="btn_de_all" class="btn_bs60">전체선택</button>
						</li>
						<li class="li100_nor p0 min500 d_scroll">
							<table id="list_table3" class="tb_data">
								<thead class="tb_data_tbg">
									<tr>
										<th class="li30 hi25">구분</th>
										<th class="li20 hi25">장비 ID</th>
										<th class="li50 hi25">장비명</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		
		</form>

	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->
	
<script type="text/javascript">
$(document).ready(function(){
	// 그룹 선택
	$("#list_table tbody tr").click(function(){
		bg_color("selected", "#list_table tbody tr", this); // 리스트 선택 시 배경색

		group_load(this.id); // 그룹 구성 호출
	});
	
	// 소속 장비 전체선택
	$("#btn_in_all").click(function(){
		var all_cnt = $("#list_table2 tbody tr").length;
		var sel_cnt = $("#list_table2 tbody tr.selected").length;
		if(all_cnt == sel_cnt){
			$("#list_table2 tbody tr").removeClass("selected");
		}else{
			$("#list_table2 tbody tr").addClass("selected");
		}
	});
	
	// 소속 장비 선택
    $(document).on("click","#list_table2 tbody tr", function(){
        if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
			$(this).addClass("selected");
        }
	});
	
	// 추가 버튼
	$("#btn_in").click(function(){
		if( !bg_color_check("selected", "#list_table3 tbody tr") ){ // 리스트 선택 체크
			swal("체크", "추가할 장비를 선택해 주세요.", "warning");
			return false;
		}else{
			$("#IN_RTU_ID").val("");
			$.each($("#list_table3 tbody tr"), function(i, v){
		        if( $(v).hasClass("selected") ){
					var IN_RTU_ID = $("#IN_RTU_ID").val();
					var RTU_ID = $("#"+v.id+" #l3_RTU_ID").text();
					
					if(IN_RTU_ID == ""){
						$("#IN_RTU_ID").val(RTU_ID);
					}else{
						$("#IN_RTU_ID").val(IN_RTU_ID + "-" + RTU_ID);
					}
		        }
			});
			//console.log( $("#IN_RTU_ID").val() );
			
			group_in(); // 그룹 구성 추가
		}
	});
	
	// 등록 가능 장비 전체선택
	$("#btn_de_all").click(function(){
		var all_cnt = $("#list_table3 tbody tr").length;
		var sel_cnt = $("#list_table3 tbody tr.selected").length;
		if(all_cnt == sel_cnt){
			$("#list_table3 tbody tr").removeClass("selected");
		}else{
			$("#list_table3 tbody tr").addClass("selected");
		}
	});
	
	// 등록 가능 장비 선택
    $(document).on("click","#list_table3 tbody tr", function(){
        if( $(this).hasClass("selected") ){
			$(this).removeClass("selected");
        }else{
			$(this).addClass("selected");
        }
	});

	// 삭제 버튼
	$("#btn_de").click(function(){
		if( !bg_color_check("selected", "#list_table2 tbody tr") ){ // 리스트 선택 체크
			swal("체크", "삭제할 장비를 선택해 주세요.", "warning");
			return false;
		}else{
			$("#DE_RTU_ID").val("");
			$.each($("#list_table2 tbody tr"), function(i, v){
		        if( $(v).hasClass("selected") ){
					var DE_RTU_ID = $("#DE_RTU_ID").val();
					var RTU_ID = $("#"+v.id+" #l2_RTU_ID").text();
					
					if(DE_RTU_ID == ""){
						$("#DE_RTU_ID").val(RTU_ID);
					}else{
						$("#DE_RTU_ID").val(DE_RTU_ID + "-" + RTU_ID);
					}
		        }
			});
			//console.log( $("#DE_RTU_ID").val() );
			
			group_de(); // 그룹 구성 삭제
		}
	});

	// 그룹 구성 추가
	function group_in(){
		var param = "mode=main_com_in&"+$("#set_frm").serialize();
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.result){
					group_load( "list_"+$("#GROUP_ID").val() ); // 그룹 구성 호출
		        }else{
				    swal("체크", "그룹 구성 추가중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	}

	// 그룹 구성 삭제
	function group_de(){
		var param = "mode=main_com_de&"+$("#set_frm").serialize();
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.result){
					group_load( "list_"+$("#GROUP_ID").val() ); // 그룹 구성 호출
		        }else{
				    swal("체크", "그룹 구성 삭제중 오류가 발생 했습니다.", "warning");
		        }
	        }
	    });
	}
	
	// 그룹 구성 호출
	function group_load(id){
		var l_GROUP_ID = $("#"+id+" #l_GROUP_ID").text();
		$("#GROUP_ID").val(l_GROUP_ID);
		
        $("#list_table2 tbody").empty(); // 소속 장비 리스트 초기화
		var param = "mode=main_comin_view&GROUP_ID="+l_GROUP_ID;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
		    		var tmp_html = '';	
		    		$.each(data.list, function(i, v){
			    		tmp_html += '<tr id="rtu_'+v.RTU_ID+'">';
			    		tmp_html += '<td class="li30 hi25">'+v.RTU_TYPE_NAME+'</td>';
			    		tmp_html += '<td id="l2_RTU_ID" class="li20 hi25">'+v.RTU_ID+'</td>';
			    		tmp_html += '<td class="li50 hi25">'+v.RTU_NAME+'</td>';
			    		tmp_html += '</tr>';
		    		});
			        $("#list_table2 tbody").html(tmp_html);
		        }
	        }
	    });

        $("#list_table3 tbody").empty(); // 등록 가능 장비 리스트 초기화
		var param = "mode=main_comde_view&GROUP_ID="+l_GROUP_ID;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_set_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
		    		var tmp_html = '';	
		    		$.each(data.list, function(i, v){
			    		tmp_html += '<tr id="rtu_'+v.RTU_ID+'">';
			    		tmp_html += '<td class="li30 hi25">'+v.RTU_TYPE_NAME+'</td>';
			    		tmp_html += '<td id="l3_RTU_ID" class="li20 hi25">'+v.RTU_ID+'</td>';
			    		tmp_html += '<td class="li50 hi25">'+v.RTU_NAME+'</td>';
			    		tmp_html += '</tr>';
		    		});
			        $("#list_table3 tbody").html(tmp_html);
		        }
	        }
	    });
	}
});
</script>

</body>
</html>


