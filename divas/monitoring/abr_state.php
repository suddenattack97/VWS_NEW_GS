<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div id="content">	
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측섹션 끝-->

<script type="text/javascript">
$(document).ready(function(){
	table_load(); // 레이아웃 및 데이터 호출

	// 5마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		table_update();
	}, 5000);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}
	
	// 테이블 호출
	function table_load(){
		state_table(1, "#content");
	}

	// 테이블 업데이트
	function table_update(){
		state_table(2, "#content");
	}

	// 방송진행 상태 테이블 호출
	function state_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_abr_json.php",
		    data: { "mode" : "alarm_state", "log_no" : "<?=$_REQUEST['log_no']?>" },
	        cache: false,
	        dataType: "json",
	        success : function(data){

		        if(type == 1){
		    		var lay_html = '';	
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <img src="../images/title_02_04.png" alt="방송진행 상태"> ';
					lay_html += ' </div> ';
					lay_html += ' <table class="main_table tb_data_left state_table"> ';
					lay_html += ' 	<tr> ';
					if(common_vhf_use == 1){
						lay_html += ' 	<th width="15%">방송지역명</th> ';
						lay_html += ' 	<th width="10%">방송전송대기중</th> ';
						lay_html += ' 	<th width="10%">VHF전송중</th> ';
						lay_html += ' 	<th width="10%">SMS전송중</th> ';
						lay_html += ' 	<th width="10%">장비접속중</th> ';
						lay_html += ' 	<th width="10%">방송정보전송중</th> ';
						lay_html += ' 	<th width="10%">방송중</th> ';
						lay_html += ' 	<th width="10%">방송완료</th> ';
						lay_html += ' 	<th width="10%">방송상태</th> ';
					}else{
						lay_html += ' 	<th width="15%">방송지역명</th> ';
						lay_html += ' 	<th width="12%">방송전송대기중</th> ';
						lay_html += ' 	<th width="12%">SMS전송중</th> ';
						lay_html += ' 	<th width="12%">장비접속중</th> ';
						lay_html += ' 	<th width="12%">방송정보전송중</th> ';
						lay_html += ' 	<th width="12%">방송중</th> ';
						lay_html += ' 	<th width="12%">방송완료</th> ';
						lay_html += ' 	<th width="12%">방송상태</th> ';
					}
					lay_html += ' 	</tr>';
					
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr id="state_'+v.RTU_ID+'"> ';
							lay_html += ' <td id="RTU_NAME">'+v.RTU_NAME+'</td> ';
							lay_html += ' <td id="IMG1">'+v.IMG1+'</td> ';
							if(common_vhf_use == 1){
								lay_html += ' <td id="IMG2">'+v.IMG2+'</td> ';
							}
							lay_html += ' <td id="IMG3">'+v.IMG3+'</td> ';
							lay_html += ' <td id="IMG4">'+v.IMG4+'</td> ';
							lay_html += ' <td id="IMG5">'+v.IMG5+'</td> ';
							lay_html += ' <td id="IMG6">'+v.IMG6+'</td> ';
							lay_html += ' <td id="IMG7">'+v.IMG7+'</td> ';
							lay_html += ' <td id="IMG8">'+v.IMG8+'</td> ';
							lay_html += ' </tr>';
			            });
					}else{
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="9">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';
					}
					lay_html += ' </table> ';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#state_"+v.RTU_ID;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #IMG1").html(v.IMG1);
							$(tmp_id+" #IMG2").html(v.IMG2);
							$(tmp_id+" #IMG3").html(v.IMG3);
							$(tmp_id+" #IMG4").html(v.IMG4);
							$(tmp_id+" #IMG5").html(v.IMG5);
							$(tmp_id+" #IMG6").html(v.IMG6);
							$(tmp_id+" #IMG7").html(v.IMG7);
							$(tmp_id+" #IMG8").html(v.IMG8);
			            });
			        }
		        }
	        },
	        beforeSend : function(data){ 
	        	if(type == 1){
		        	if( $(lay_id+" #spin").length == 0 ){
		        		$(lay_id).append('<div id="spin"></div>');
		        	}	
			        tmp_spin = spin_start(lay_id+" #spin", "135px");
	        	}
	        },
	        complete : function(data){ 
	        	if(type == 1){
		        	if(tmp_spin){
		        		spin_stop(tmp_spin, lay_id+" #spin");
		        	}
	        	}
	        }
        });
	}
	
});
</script>
	
</body>
</html>


