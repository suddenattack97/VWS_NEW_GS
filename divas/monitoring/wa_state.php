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

	// 메세지 전송상태 테이블 호출
	function state_table(type, lay_id){
		var tmp_spin = null;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_wa_json.php",
		    data: { "mode" : "wa_msg_state", "sno" : "<?=$_REQUEST['sno']?>", "cnt" : "<?=$_REQUEST['cnt']?>" },
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(type == 1){
		    		var lay_html = '';	
		    		
					lay_html += ' <div class="main_contitle"> ';
					lay_html += ' <img src="../images/title_09_07.png" alt="메세지 진행상태 타이틀"> ';
					lay_html += ' </div> ';
					lay_html += ' <table class="main_table tb_data_left state_table"> ';
					lay_html += ' 	<tr> ';
					lay_html += ' 	<th width="20%">지역</th> ';
					lay_html += ' 	<th width="5%">순서</th> ';
					lay_html += ' 	<th width="15%">상단문안</th> ';
					lay_html += ' 	<th width="15%">하단문안</th> ';
					lay_html += ' 	<th width="15%">전송상태</th> ';
					lay_html += ' 	<th width="15%">전송결과</th> ';
					lay_html += ' 	<th width="15%">전송시간</th> ';
					lay_html += ' 	</tr>';
					
					if(data.list){
			            $.each(data.list, function(i, v){
							lay_html += ' <tr id="state_'+v.RTU_ID+'_'+v.MSGNO+'"> ';
							lay_html += ' <td id="RTU_NAME">'+v.RTU_NAME+'</td> ';
							lay_html += ' <td id="MSGNO">'+v.MSGNO+'</td> ';
							lay_html += ' <td id="TEXTA">'+v.TEXTA+'</td> ';
							lay_html += ' <td id="TEXTB">'+v.TEXTB+'</td> ';
							lay_html += ' <td id="IMG">'+v.IMG+'</td> ';
							lay_html += ' <td id="CALL_STATE">'+v.CALL_STATE+'</td> ';
							lay_html += ' <td id="TRANS_START">'+v.TRANS_START+'</td> ';
							lay_html += ' </tr>';
			            });
					}else{
						lay_html += ' <tr> ';
						lay_html += ' <td colspan="7">데이터가 없습니다.</td> ';
						lay_html += ' </tr>';
					}
					lay_html += ' </table> ';
					$(lay_id).append(lay_html);
					
		        }else if(type == 2){
			        if(data.list){
			            $.each(data.list, function(i, v){
				            var tmp_id = "#state_"+v.RTU_ID+"_"+v.MSGNO;
							$(tmp_id+" #RTU_NAME").html(v.RTU_NAME);
							$(tmp_id+" #MSGNO").html(v.MSGNO);
							$(tmp_id+" #TEXTA").html(v.TEXTA);
							$(tmp_id+" #TEXTB").html(v.TEXTB);
							$(tmp_id+" #IMG").html(v.IMG);
							$(tmp_id+" #CALL_STATE").html(v.CALL_STATE);
							$(tmp_id+" #TRANS_START").html(v.TRANS_START);
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


