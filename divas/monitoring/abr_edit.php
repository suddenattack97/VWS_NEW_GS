<?
require_once "../_conf/_common.php";
require_once "../_info/_abr.php";
require_once "./head.php";
?>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
	<div id="content">
	
		<div class="main_contitle">
			<img src="../images/title_02_02.png" alt="방송 문안">
		</div>
		<div class="right_bg">
		<ul class="tb_edit">
		<form id="alarm_frm" name="alarm_frm" method="get">
			<input type="hidden" id="ORGAN_ID" name="ORGAN_ID">
			<input type="hidden" id="USER_ID" name="USER_ID">
			<input type="hidden" id="SCRIPT_NO" name="SCRIPT_NO">
			<input type="hidden" id="SCRIPT_TYPE" name="SCRIPT_TYPE" value="1"><!-- 방송문안 유형 0:모바일, 1:피씨 -->
			<input type="hidden" id="SCRIPT_UNIT" name="SCRIPT_UNIT" value="T"><!-- 방송문안 구분 T:문자(문자변환), R:음성(음성녹음), M:녹음(장비저장) -->
			<input type="hidden" id="SCRIPT_RECORD_FILE" name="SCRIPT_RECORD_FILE"><!-- 음성녹음 원본 파일 정보 -->
			<input type="hidden" id="SCRIPT_TIMESTAMP" name="SCRIPT_TIMESTAMP">
			<input type="hidden" id="SCRIPT_PLAY_SECONDS" name="SCRIPT_PLAY_SECONDS"><!-- 저장방송 재생 시간(초단위) -->
			<input type="hidden" id="LOG_TYPE" name="LOG_TYPE" value="0"><!-- 로그유형 0:방송, 1:범위호출, 2:원격장비설정 -->
			<input type="hidden" id="MOBILE_SEND_USER" name="MOBILE_SEND_USER"><!-- 모바일 전송 확인용 -->
			<input type="hidden" id="VHF_MSG_GRP" name="VHF_MSG_GRP"><!-- VHF 그룹번호(VHF 사용 시 이용) -->
			<input type="hidden" id="SCRIPT_BODY_COUNT"><!-- 글자수 -->
			<li class="tb_edit_lm">
				<div class="conte_sel">
					<select id="SECTION_NO_SEARCH" name="SECTION_NO_SEARCH" class="select_conte_l">
						<option value="0" data-sort="0">전체</option>
					<?
					if($data_gubun){
						foreach($data_gubun as $key => $val){
					?>
						<option value="<?=$val['SECTION_NO']?>" data-sort="<?=$val['SORT_FLAG']?>"><?=$val['SECTION_NAME']?></option>
					<?
						}
					}
					?>
					</select>
                    <button type="button" id="btn_search" class="btn_bs60">조회</button>
                    <input type="text" id="search_text" name="search_text" class="input_conte">
                    <select id="search_sel" name="search_sel" class="select_conte_r">  
                     	<option value="SCRIPT_TITLE">방송제목</option>
						<option value="SCRIPT_BODY">방송문구</option>
						<option value="USER_ID">작성자ID</option>
						<option value="SECTION_NO">방송구분번호</option>
					</select>   
				</div>
				
				<div class="conte">
						<ul class="pB45p">
	                        <li class="conte_gry">
	                        	<ul>
	                            <li class="li15">방송구분</li>
	                            <li class="li15">유형</li>
	                            <li class="li60">제목</li>
	                      		<li class="li10">작성자</li>
	                            </ul>
	                        </li>
	                        <li id="list_table" class="h100">
            					<div id="spin"></div>	
							<?
							if($data_script){
								foreach($data_script as $key => $val){
							?>
	                        	<ul id="list_<?=$val['SCRIPT_NO']?>">
	                            <li id="li_SECTION_NAME" class="li15"><?=$val['SECTION_NAME']?></li>
	                            <li id="li_SCRIPT_UNIT_NAME" class="li15"><?=$val['SCRIPT_UNIT_NAME']?></li>
	                            <li id="li_SCRIPT_TITLE" class="li60"><?=$val['SCRIPT_TITLE']?></li>
	                      		<li id="li_USER_ID" class="li10"><?=$val['USER_ID']?></li>
	                      		
								<li id="li_SCRIPT_NO" style="display:none"><?=$val['SCRIPT_NO']?></li>
								<li id="li_OWN_TYPE" style="display:none"><?=$val['OWN_TYPE']?></li>
								<li id="li_ORGAN_ID" style="display:none"><?=$val['ORGAN_ID']?></li>
								<li id="li_SCRIPT_UNIT" style="display:none"><?=$val['SCRIPT_UNIT']?></li>
								<li id="li_SECTION_NO" style="display:none"><?=$val['SECTION_NO']?></li>
								<li id="li_CHIME_START_NO" style="display:none"><?=$val['CHIME_START_NO']?></li>
								<li id="li_CHIME_START_CNT" style="display:none"><?=$val['CHIME_START_CNT']?></li>
								<li id="li_CHIME_END_NO" style="display:none"><?=$val['CHIME_END_NO']?></li>
								<li id="li_CHIME_END_CNT" style="display:none"><?=$val['CHIME_END_CNT']?></li>
								<li id="li_SCRIPT_BODY" style="display:none"><?=$val['SCRIPT_BODY']?></li>
								<li id="li_SCRIPT_BODY_CNT" style="display:none"><?=$val['SCRIPT_BODY_CNT']?></li>
								<li id="li_SCRIPT_RECORD_FILE" style="display:none"><?=$val['SCRIPT_RECORD_FILE']?></li>
								<li id="li_SCRIPT_TIMESTAMP" style="display:none"><?=$val['SCRIPT_TIMESTAMP']?></li>
								<li id="li_TRANS_VOLUME" style="display:none"><?=$val['TRANS_VOLUME']?></li>
								<li id="li_SCRIPT_PLAY_SECONDS" style="display:none"><?=$val['SCRIPT_PLAY_SECONDS']?></li>
								<li id="li_VHF_MSG_GRP" style="display:none"><?=$val['VHF_MSG_GRP']?></li>
								<li id="li_SCRIPT_SORT" style="display:none"><?=$val['SCRIPT_SORT']?></li>
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
				
                <li class="tb_edit_r">
				    <div class="contb">
						<ul>
	                        <li>방송구분 :
								<select id="SECTION_NO" name="SECTION_NO">
								<?
								if($data_gubun){
									foreach($data_gubun as $key => $val){
								?>
									<option value="<?=$val['SECTION_NO']?>" data-sort="<?=$val['SORT_FLAG']?>"><?=$val['SECTION_NAME']?></option>
								<?
									}
								}
								?>
								</select>
                        	 	<button type="button" id="btn_section" class="btn_wgb110">방송구분설정</button>
                        	</li>
	                        <li>방송유형 :
								<input type="radio" id="SCRIPT_UNIT_T" name="SCRIPT_UNIT_VIEW" value="T" checked="checked">문자음성변환방송
								<!-- <input type="radio" id="SCRIPT_UNIT_R" name="SCRIPT_UNIT_VIEW" value="R">음성녹음방송 -->
								<input type="radio" id="SCRIPT_UNIT_M" name="SCRIPT_UNIT_VIEW" value="M">장비저장방송
                        	</li>
							<li>방송제목 : 
								<input type="text" id="SCRIPT_TITLE" name="SCRIPT_TITLE" size="60" class="f333_12">
							</li>
							<li>
								<span class="sel_left">시작효과음 : 
									<select id="CHIME_START_NO" name="CHIME_START_NO" size="1" class="select_b">
										<option value="">시작음선택</option>
								<?
								if($data_chime){
									foreach($data_chime as $key => $val){
								?>
										<option value="<?=$val['CHIME_NO']?>" <?if($val['CHIME_NO']==19) echo "selected"?>>
											<?=$val['CHIME_NAME']?>
										</option>
								<?
									}
								}
								?>
									</select>
								</span> 
								<span class="sel_right"> 시작효과반복횟수 : 
									<select id="CHIME_START_CNT" name="CHIME_START_CNT" size="1" class="select_s">
											<option value="0">0</option>
											<option value="1" selected="">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<span class="sel_left"> 종료효과음 : 
									<select id="CHIME_END_NO" name="CHIME_END_NO" size="1" class="select_b">
										<option value="">종료음선택</option>
								<?
								if($data_chime){
									foreach($data_chime as $key => $val){
								?>
										<option value="<?=$val['CHIME_NO']?>" <?if($val['CHIME_NO']==19) echo "selected"?>>
											<?=$val['CHIME_NAME']?>
										</option>
								<?
									}
								}
								?>
									</select>
								</span> 
								<span class="sel_right"> 종료효과반복횟수 : 
									<select id="CHIME_END_CNT" name="CHIME_END_CNT" size="1" class="select_s">
										<option value="0">0</option>
										<option value="1" selected="">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<span class="sel_left"> 방송종류 : 
									<span id="SCRIPT_UNIT_TEXT" class="fbb_12">문자음성변환방송</span>
								</span> 
								<span class="sel_right"> 방송내용반복횟수 : 
									<select id="SCRIPT_BODY_CNT" name="SCRIPT_BODY_CNT" size="1" class="select_s">
											<option value="0">0</option>
											<option value="1" selected="">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
									</select>
								</span>
							</li>
							<li>
								<button type="button" id="btn_alarm_test" class="btn_lbb80">미리듣기</button>
								<div class="vcontrol">
									<span class="vcon_span">볼륨</span> 
									<span class="volnum">
										<select id="TRANS_VOLUME" name="TRANS_VOLUME">
											<? for($i=0; $i<=16; $i++){ ?>
			                                <option value="<?=$i?>" <?if($i==16) echo "selected"?>><?=$i?></option>
			                                <? } ?>
										</select>
									</span>
								</div>
							</li>
							<li class="alarm_100">
								<textarea id="SCRIPT_BODY" name="SCRIPT_BODY" class="f333_12 textarea3"></textarea>
							</li>
							<li class="alarm_gry_b">
								<span id="counter" style="font-size:16px; float:right;">/ 300&nbsp;</span>
							</li>
							<li class="pT_15" style="text-align: right;">
								<button type="button" id="btn_insert" class="btn_bb80">등록</button>
								<button type="button" id="btn_update" class="btn_wbb80">수정</button>
								<button type="button" id="btn_delete" class="btn_wbb80">삭제</button>
							</li>
						</ul>
                    </div>
                </li>
			</form>	
			</ul>
			</div>
	</div>
	</div>
	<!--본문내용섹션 끝-->
</div>
<!--우측문섹션 끝-->

<!--팝업창-->
<div id="popup_overlay" class="popup_overlay"></div>
<div id="popup_layout" class="popup_layout_b">
	<div class="popup_top">방송구분 설정
		<button id="popup_close" class="btn_lbs fR bold">X</button>
	</div>
	<div class="popup_con_1">
		<dl>
			<dd id="section_table" class="bB_1gry">
            	<div id="spin"></div>	
			<?
			if($data_gubun){
				foreach($data_gubun as $key => $val){
			?>
				<ul id="section_<?=$val['SECTION_NO']?>">
					<li id="li_SECTION_NAME"><?=$val['SECTION_NAME']?></li>
					<li id="li_SECTION_NO" style="display:none"><?=$val['SECTION_NO']?></li>
					<li id="li_SORT_FLAG" style="display:none"><?=$val['SORT_FLAG']?></li>				
				</ul>
			<?
				}
			}
			?>						
			</dd>
			<dd>
				<ul> 
					<li class="b0 w100 p0 bold">
						<form id="section_frm" name="section_frm" method="post">
							방송구분명: <input type="text" id="S_SECTION_NAME" name="SECTION_NAME" style="width:236px;" class="f333_12">
							<input type="hidden" id="S_SECTION_NO" name="SECTION_NO">
						</form>
					</li>
					<li class="b0 al_C w100">
						<button type="button" id="btn_s_insert" class="btn_bb80">등록</button>
						<button type="button" id="btn_s_update" class="btn_wbb80">수정</button>
						<button type="button" id="btn_s_delete" class="btn_wbb80">삭제</button>
					</li>
				</ul>
			</dd>				
		</dl>
	</div>
</div>
<!--팝업창 끝-->

<form id="alarm_test" name="alarm_test" method="post">
	<input type="hidden" id="SCRIPT_CONTENT" name="SCRIPT_CONTENT"><!-- 미리듣기 내용 -->
	<input type="hidden" id="SCRIPT_FILENAME" name="SCRIPT_FILENAME"><!-- 파일 이름 -->
	<iframe id="alarm_iframe" name="alarm_iframe" width="0" height="0" style="display: none;"></iframe>
</form>

<script type="text/javascript">
$(document).ready(function(){
	// 방송구분 셀렉트
	$("#SECTION_NO_SEARCH").change(function(){
		$("#search_text").val("");
		
		$.each($("#list_table ul #li_SECTION_NO"), function(i, v){
			if( $("#SECTION_NO_SEARCH").val() == 0 ){
				$(this).closest("ul").show();
			}else if( $("#SECTION_NO_SEARCH").val() != $(this).text() ){
				$(this).closest("ul").hide();
			}else if( $("#SECTION_NO_SEARCH").val() == $(this).text() ){
				$(this).closest("ul").show();
			}
		});
	});
	
	// 상단 조회
	$("#btn_search").click(function(){
		$("#SECTION_NO_SEARCH").val(0);
		
		var sel = $("#search_sel").val();
		var text = $("#search_text").val();
		
		$.each($("#list_table ul #li_"+sel), function(i, v){
			//console.log($(this).text());
			if( $(this).text().indexOf(text) == -1 ){
				$(this).closest("ul").hide();
			}else{
				$(this).closest("ul").show();
			}
		});
	});
	
	// 방송목록 드래그 앤 드롭
	$("#list_table").sortable({
		cursor: "move",
        update: function(event, ui){
			if( $("#SECTION_NO_SEARCH").val() != "0" ){
				swal("체크", "방송구분이 전체일 때만 정렬 상태를 변경할 수 있습니다.", "warning");
			    $(this).sortable("cancel");
			}else{
				var tmp_sort = '';
	            $.each($("#list_table ul"), function(i, v){ 
	        		var tmp_id = "#"+v.id;
	        		var tmp_script_no = $(tmp_id+" #li_SCRIPT_NO").text();
	        		if(i != 0) tmp_sort += '-';
	        		tmp_sort += tmp_script_no;
	            });  
	            //console.log(tmp_sort);
	
	    		var tmp_spin = null;
	    		var param = "mode=script_sort&str_script_no="+tmp_sort;
	    		$.ajax({
	    	        type: "POST",
	    	        url: "../_info/json/_abr_json.php",
	    		    data: param,
	    	        cache: false,
	    	        dataType: "json",
	    	        success : function(data){
	    		        if(data.result){
	    		        }else{
	    				    swal("체크", "방송목록 정렬중 오류가 발생 했습니다.", "warning");
	    		        }
	    	        },
	    	        beforeSend : function(data){ 
	    		    	tmp_spin = spin_start("#list_table #spin", "60px");
	    	        },
	    	        complete : function(data){ 
	    	        	if(tmp_spin){
	    	        		spin_stop(tmp_spin, "#list_table #spin");
	    	        	}
	    	        }
	    	    });	
			}
        }
	});

	// 방송목록 선택
	$("#list_table ul").click(function(){
		var tmp_id = "#"+this.id;
		var SCRIPT_UNIT = $(tmp_id+" #li_SCRIPT_UNIT").text();
		var SCRIPT_UNIT_TEXT = "";
		var TRANS_VOLUME = $(tmp_id+" #li_TRANS_VOLUME").text();

		bg_color("selected", "#list_table ul", this); // 리스트 선택 시 배경색
		
		$("#SCRIPT_NO").val( $(tmp_id+" #li_SCRIPT_NO").text() );
		$("#ORGAN_ID").val( $(tmp_id+" #li_ORGAN_ID").text() );
		$("#USER_ID").val( $(tmp_id+" #li_USER_ID").text() );
		$("#SCRIPT_UNIT").val(SCRIPT_UNIT);
		if(SCRIPT_UNIT == "T"){
			$("#SCRIPT_UNIT_T").prop("checked", true);
			SCRIPT_UNIT_TEXT = "문자음성변환방송";
		}else if(SCRIPT_UNIT == "R"){
			$("#SCRIPT_UNIT_R").prop("checked", true);
			SCRIPT_UNIT_TEXT = "음성녹음방송";
		}else{ // M
			$("#SCRIPT_UNIT_M").prop("checked", true);
			SCRIPT_UNIT_TEXT = "장비저장방송";
		}
		$("#SCRIPT_UNIT_TEXT").text(SCRIPT_UNIT_TEXT);
		$("#SECTION_NO").val( $(tmp_id+" #li_SECTION_NO").text() );
		$("#SCRIPT_TITLE").val( $(tmp_id+" #li_SCRIPT_TITLE").text() );
		$("#CHIME_START_NO").val( $(tmp_id+" #li_CHIME_START_NO").text() );
		$("#CHIME_START_CNT").val( $(tmp_id+" #li_CHIME_START_CNT").text() );
		$("#CHIME_END_NO").val( $(tmp_id+" #li_CHIME_END_NO").text() );
		$("#CHIME_END_CNT").val( $(tmp_id+" #li_CHIME_END_CNT").text() );
		$("#SCRIPT_BODY").val( $(tmp_id+" #li_SCRIPT_BODY").text() );
		$("#SCRIPT_BODY_CNT").val( $(tmp_id+" #li_SCRIPT_BODY_CNT").text() );
		$("#SCRIPT_RECORD_FILE").val( $(tmp_id+" #li_SCRIPT_RECORD_FILE").text() );
		$("#SCRIPT_TIMESTAMP").val( $(tmp_id+" #li_SCRIPT_TIMESTAMP").text() );
		$("#TRANS_VOLUME").val(TRANS_VOLUME);
		$("#slider").slider("value", TRANS_VOLUME);
	});

	$("#SCRIPT_BODY").keyup(function(){
		var text_length = this.value.length;
		checkWord();
	});

	var tmp_script = "";

	// 방송문구 300자 이상, 특수문자 체크
	function checkWord(){
		var script = $("#SCRIPT_BODY").val(); 
		var tmp_length = $("#SCRIPT_BODY").val().length;
		if(tmp_length > 300){
			alert('300자 이상일경우 방송이 제한됩니다.');
			$("#SCRIPT_BODY").val(tmp_script);
			return false;
		}
		// var regex = /^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|]*$/;
		// if(!regex.test($("#SCRIPT_BODY").val())){
		//     alert('특수문자는 사용할 수 없습니다.');
		//     $("#SCRIPT_BODY").val(tmp_script);
		//     return false;
		// }
		$('#SCRIPT_BODY_COUNT').val(tmp_length);
		$('#counter').html(tmp_length + " / 300&nbsp;");
		tmp_script = script;
	}

	// 방송구분설정 버튼
	$("#btn_section").click(function(){
		popup_open(); // 레이어 팝업 열기
	});
	
	// 방송구분 드래그 앤 드롭
	$("#section_table").sortable({ 
		cursor: "move",
        update: function(event, ui){
			var tmp_sort = '';
            $.each($("#section_table ul"), function(i, v){ 
        		var tmp_id = "#"+v.id;
        		var tmp_selction_id = $(tmp_id+" #li_SECTION_NO").text();
        		if(i != 0) tmp_sort += '-';
        		tmp_sort += tmp_selction_id;

        		$("#SECTION_NO_SEARCH option[value="+tmp_selction_id+"]").data("sort", (i+1));
        		$("#SECTION_NO option[value="+tmp_selction_id+"]").data("sort", (i+1));
            });  
            //console.log(tmp_sort);

	    	var tmp_spin = null;
    		var param = "mode=section_sort&str_section_no="+tmp_sort;
    		$.ajax({
    	        type: "POST",
    	        url: "../_info/json/_abr_json.php",
    		    data: param,
    	        cache: false,
    	        dataType: "json",
    	        success : function(data){
    		        if(data.result){
    					sort_option("#SECTION_NO_SEARCH"); // 셀렉트박스 재정렬
            			sort_option("#SECTION_NO"); // 셀렉트박스 재정렬
    		        }else{
    				    swal("체크", "방송구분 정렬중 오류가 발생 했습니다.", "warning");
    		        }
    	        },
    	        beforeSend : function(data){ 
    		    	tmp_spin = spin_start("#section_table #spin", "49px");
    	        },
    	        complete : function(data){ 
    	        	if(tmp_spin){
    	        		spin_stop(tmp_spin, "#section_table #spin");
    	        	}
    	        }
    	    });	
        }
	});

	// 방송구분 선택
	$(document).on("click", "#section_table ul", function(){
		bg_color("bg_sel", "#section_table ul", this); // 리스트 선택 시 배경색
		
		var tmp_id = "#"+this.id;
		$("#S_SECTION_NAME").val( $(tmp_id+" #li_SECTION_NAME").text() );
		$("#S_SECTION_NO").val( $(tmp_id+" #li_SECTION_NO").text() );
	});
	
	// 방송구분 등록
	$("#btn_s_insert").click(function(){
		bg_color("bg_sel", "#section_table ul", null); // 리스트 선택 시 배경색

		if( !$("#S_SECTION_NAME").val() ){
			swal("체크", "방송구분명을 입력해 주세요.", "warning");
			$("#S_SECTION_NAME").focus(); return false;
		}else{
			var param = "mode=section_insert&"+$("#section_frm").serialize();
			$.ajax({
		        type: "POST",
		        url: "../_info/json/_abr_json.php",
			    data: param,
		        cache: false,
		        dataType: "json",
		        success : function(data){
			        if(data.result[0]){
						var SECTION_NAME = $("#S_SECTION_NAME").val();
						$("#SECTION_NO_SEARCH").append('<option value="'+data.result[1]+'" data-sort="'+data.result[2]+'">'+SECTION_NAME+'</option>');
						$("#SECTION_NO").append('<option value="'+data.result[1]+'" data-sort="'+data.result[2]+'">'+SECTION_NAME+'</option>');
						var tmp_ul = '<ul id="section_'+data.result[1]+'">';
						tmp_ul += '<li id="li_SECTION_NAME">'+SECTION_NAME+'</li>';
						tmp_ul += '<li id="li_SECTION_NO" style="display:none">'+data.result[1]+'</li>';
						tmp_ul += '<li id="li_SORT_FLAG" style="display:none">'+data.result[2]+'</li>';
						tmp_ul += '</ul>';
						$("#section_table").append(tmp_ul);
			        }else{
					    swal("체크", "방송구분 등록중 오류가 발생 했습니다.", "warning");
			        }
		        }
		    });	
		}
	});
	
	// 방송구분 수정
	$("#btn_s_update").click(function(){
		if( !bg_color_check("bg_sel", "#section_table ul") ){ // 리스트 선택 체크
			swal("체크", "방송구분을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">방송구분 수정 확인</div>\
						<div class="alpop_mes_b">방송구분명을 ['+$("#S_SECTION_NAME").val()+']로 수정하실 겁니까?</div>',
				text: '확인 시 바로 수정 됩니다.',
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
					var param = "mode=section_update&"+$("#section_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
								var SECTION_NO = $("#S_SECTION_NO").val();
								var SECTION_NAME = $("#S_SECTION_NAME").val();
								$("#SECTION_NO_SEARCH option[value="+SECTION_NO+"]").text(SECTION_NAME);
								$("#SECTION_NO option[value="+SECTION_NO+"]").text(SECTION_NAME);
								$.each($("#list_table ul"), function(i, v){
					        		var tmp_id = "#"+v.id;
									if( $(tmp_id+" #li_SECTION_NO").text() == SECTION_NO ){
					        			$(tmp_id+" #li_SECTION_NAME").text(SECTION_NAME);
									}
					            });
								$("#section_"+SECTION_NO+" #li_SECTION_NAME").text(SECTION_NAME);
								swal.close();
					        }else{
							    swal("체크", "방송구분 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송구분 삭제
	$("#btn_s_delete").click(function(){
		if( !bg_color_check("bg_sel", "#section_table ul") ){ // 리스트 선택 체크
			swal("체크", "방송구분을 선택해 주세요.", "warning");
			return false;
		}else{
			swal({
				title: '<div class="alpop_top_b">방송구분 삭제 확인</div>\
						<div class="alpop_mes_b">['+$("#section_"+$("#S_SECTION_NO").val()+" #li_SECTION_NAME").text()+']를 삭제하실 겁니까?</div>',
				text: '확인 시 바로 삭제 됩니다.',
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
					var param = "mode=section_delete&"+$("#section_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result == 0){
							    swal("체크", "방송구분 삭제중 오류가 발생 했습니다.", "warning");
					        }else if(data.result == 1){
							    swal("체크", "방송문안에서 사용중인 방송구분은 삭제할 수 없습니다.", "warning");
					        }else if(data.result == 2){
								var SECTION_NO = $("#S_SECTION_NO").val();
								$("#SECTION_NO_SEARCH option[value="+SECTION_NO+"]").remove();
								$("#SECTION_NO option[value="+SECTION_NO+"]").remove();
								$("#section_"+SECTION_NO).remove();
								$("#S_SECTION_NO").val("");
								$("#S_SECTION_NAME").val("");
								swal.close();
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
		
	// 방송유형 선택
	$("#SCRIPT_UNIT_T").click(function(){
		$("#SCRIPT_UNIT").val("T");
		$("#SCRIPT_UNIT_TEXT").text("문자음성변환방송");
	});
	$("#SCRIPT_UNIT_R").click(function(){
		$("#SCRIPT_UNIT").val("R");
		$("#SCRIPT_UNIT_TEXT").text("음성녹음방송");
	});
	$("#SCRIPT_UNIT_M").click(function(){
		var SCRIPT_UNIT = $("#SCRIPT_UNIT").val();
		
		// 장비저장방송 직접 선택 막기
		if( $("#SCRIPT_UNIT_M").prop("checked") ){
			$("#SCRIPT_UNIT_M").prop("checked", false);
			$("#SCRIPT_UNIT_"+SCRIPT_UNIT).prop("checked", true);
		} 
		if(SCRIPT_UNIT != "M") swal("체크", "장비저장방송은 등록할 수 없습니다.", "warning");
	});
	
	// 미리듣기
	$("#btn_alarm_test").click(function(){
		if( $("#SCRIPT_BODY").val() ){
			var CONTENT = $("#SCRIPT_BODY").val().replace(/[\r|\n]/g, " ");
			CONTENT = encodeURI(CONTENT);
			$("#SCRIPT_CONTENT").val(CONTENT);
			var FILENAME = $("#SCRIPT_TIMESTAMP").val();
			$("#SCRIPT_FILENAME").val(FILENAME);
			
			$("#alarm_test").attr("action", "../func/audioGenerator/toTTS2.php");
			$("#alarm_test").attr("target", "alarm_iframe");
			$("#alarm_test").submit();
		}else{
			swal("체크", "방송 내용을 입력해 주세요.", "warning");
		}
	});
	
	// 볼륨 슬라이더
	var select = $("#TRANS_VOLUME");
	if( $("#slider").length == 0 ){
		var slider = $( "<div id='slider'></div>" ).insertAfter(select).slider({
			min: 0,
			max: 16,
			range: "min",
			value: select[0].selectedIndex,
			slide: function(event, ui) {
				select[0].selectedIndex = ui.value;
			}
		});
	}
	$("#TRANS_VOLUME").change(function(){
		$("#slider").slider("value", this.value);
	});
	
	// 방송문안 등록
	$("#btn_insert").click(function(){
		if( abr_check("I") ){
			swal({
				title: '<div class="alpop_top_b">방송문구 등록 확인</div><div class="alpop_mes_b">방송문구를 등록하실 겁니까?</div>',
				text: '확인 시 문구가 등록 됩니다.',
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
					$("#IS_PLAN").val(0); // 전송유형 즉시
					
					var param = "mode=script_insert&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "방송문안 등록중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송문안 수정
	$("#btn_update").click(function(){
		if( abr_check("U") ){
			swal({
				title: '<div class="alpop_top_b">방송문구 수정 확인</div><div class="alpop_mes_b">방송문구를 수정하실 겁니까?</div>',
				text: '확인 시 문구가 수정 됩니다.',
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
					var param = "mode=script_update&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "방송문안 수정중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송문안 삭제
	$("#btn_delete").click(function(){
		if( abr_check("D") ){
			swal({
				title: '<div class="alpop_top_b">방송문구 삭제 확인</div><div class="alpop_mes_b">방송문구를 삭제하실 겁니까?</div>',
				text: '확인 시 문구가 삭제 됩니다.',
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
					var param = "mode=script_delete&"+$("#alarm_frm").serialize();
					$.ajax({
				        type: "POST",
				        url: "../_info/json/_abr_json.php",
					    data: param,
				        cache: false,
				        dataType: "json",
				        success : function(data){
					        if(data.result){
			                	popup_main_close(); // 레이어 좌측 및 상단 닫기
					    		location.reload(); return false;
					        }else{
							    swal("체크", "방송문안 삭제중 오류가 발생 했습니다.", "warning");
					        }
				        }
				    });	
				}
			}); // swal end
		}
	});
	
	// 방송 폼 체크
	function abr_check(kind){
		if(kind == "I" || kind == "U"){
			var SCRIPT_BODY = $("#SCRIPT_BODY").val().replace(/[\r|\n]/g, " ");
			$("#SCRIPT_BODY").val(SCRIPT_BODY);

			if(kind == "U"){
				if( !$("#SCRIPT_NO").val() ){
					 swal("체크", "방송문구를 선택해 주세요.", "warning"); return false;
				}
			}
			if( !$("#SCRIPT_TITLE").val() ){
				swal("체크", "방송 제목을 입력해 주세요.", "warning");
				$("#SCRIPT_TITLE").focus(); return false;
			}else if( !$("#CHIME_START_NO").val() ){
			    swal("체크", "시작 효과음을 선택해 주세요.", "warning");
			    $("#CHIME_START_NO").focus(); return false;	
			}else if( !$("#CHIME_END_NO").val() ){
			    swal("체크", "종료 효과음을 선택해 주세요.", "warning");
			    $("#CHIME_END_NO").focus(); return false;
			}else if( $("#SCRIPT_UNIT").val() == 'T' && !$("#SCRIPT_BODY").val() ){
			    swal("체크", "방송 내용을 입력해 주세요.", "warning");
				$("#SCRIPT_BODY").focus(); return false;
			}else if( $("#SCRIPT_BODY_COUNT").val() > 300 ){
			    swal("체크", "300자 이상일경우 방송이 제한됩니다.", "warning");
				$("#SCRIPT_BODY").focus(); return false;
			}else{
				 return true;
			}
		}else if(kind == "D"){
			if( !$("#SCRIPT_NO").val() ){
				swal("체크", "방송문구를 선택해 주세요.", "warning"); return false;
			}else{
				 return true;
			}
		}
	}

	// 뒤로가기 관련 처리
	$("#ORGAN_ID").val("");
	$("#USER_ID").val("");
	$("#SCRIPT_NO").val("");
	$("#SCRIPT_TYPE").val("1");
	$("#SCRIPT_UNIT").val("T");
	$("#SCRIPT_RECORD_FILE").val("");
	$("#SCRIPT_TIMESTAMP").val("");
	$("#SCRIPT_PLAY_SECONDS").val("");
	$("#LOG_TYPE").val(0);
	$("#MOBILE_SEND_USER").val("");
	$("#VHF_MSG_GRP").val("");
	$("#SECTION_NO_SEARCH").val(0);
	$("#search_sel option:eq(0)").prop("selected", true);
	$("#search_text").val("");
	$("#SECTION_NO").val(1);
	$("#S_SECTION_NAME").val("");
	$("#S_SECTION_NO").val("");
	$("#SCRIPT_UNIT_T").prop("selected", true);
	$("#SCRIPT_TITLE").val("");
	$("#CHIME_START_NO").val("19");
	$("#CHIME_END_NO").val("19");
	$("#CHIME_START_CNT").val(1);
	$("#CHIME_END_CNT").val(1);
	$("#SCRIPT_BODY_CNT").val(1);
	$("#TRANS_VOLUME").val("16");
	$("#slider").slider("value", 16);
	$("#SCRIPT_BODY").val("");
});
</script>

</body>
</html>


