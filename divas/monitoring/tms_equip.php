<?
require_once "../_conf/_common.php";
require_once "../_info/_set_groupst.php";
require_once "./head.php";
?>
<style>
ul.tabs {
    margin: 0 0 20px 0;
    padding: 0;
    float: left;
    list-style: none;
    width: 100%;
    font-family: "dotum";
    font-size: 12px;
    border-bottom: 2px solid;
}
ul.tabs li {
    float: left;
    text-align: center;
    cursor: pointer;
    width: 10%;
    height: 31px;
    line-height: 31px;
    font-weight: bold;
    background: linear-gradient(0deg, #191b1d, #24272b);
    overflow: hidden;
    position: relative;
    border-radius: 5px 5px 0 0;
    margin-right: 3px;
    color: #fff;
    width: 10%;
}

ul.tabs li.active {
    background: linear-gradient(0deg, rgb(79, 112, 196), rgb(107, 145, 241));
}


ul.tabs li:hover{
   cursor:pointer;
   background:#49609a !important;
}


.tab_container {
    clear: both;
    float: left;
    width: 100%;
    height: 100%;
}

.tab_content {
}
.tab_container .tab_content ul {
    width:100%;
    margin:0px;
    padding:0px;
}
.tab_container .tab_content ul li {
    padding:5px;
    list-style:none
}
ul.tabs li.active:hover{
    background: #49609a;
}

</style>

<!--우측섹션-->
<div id="right">
	<!--본문내용섹션-->
	<div class="product_state">
    <div id="content">
	<div class="main_contitle">  
		<img src="../images/title_01_09.png" alt="장비 상태">  
        <!-- <img src="../images/quick_link.png" style="padding-top: 3px; position:relative; left:20px; cursor:pointer;" onclick="quick_button(7);">  -->
    </div>
		<div class="right_bg">  
		<div>  
            <form id="frm" action="tms_equip.php" method="get">
                <input type="hidden" id="group_id" name="group_id"><!-- 그룹아이디-->
            </form>
            <div id="container">
                <ul class="tabs">
                    <? 
                $cnt=1;
                if($data_list){
                    foreach($data_list as $key => $val){
                        if($val['GROUP_ID'] == '001'){ 
                            $class='active';
                        }else{
                            $class='';
                        }
                        ?>
                    <li id="list_<?=$val['GROUP_ID']?>" class="<?=$class?>" rel="tab<?=$cnt?>"><?=$val['GROUP_NAME']?></li>
                    <?
                    $cnt++;
                }
            }
            ?>
                    <img src="../images/icon_comment.png" style="float: right; right:40px;">
                </ul>
                <input type="hidden" id="select_area_code" value="1">
                <div class="tab_container">
                    <? 
                    $cnt2=1;
                    if($data_list){
                        foreach($data_list as $key => $val){
                    ?>
                    <div id="tab<?=$cnt2?>" class="tab_content">
                        <table id="list_table1" class="floating-thead main_table_1"> 
                            <thead>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> 
                    </div>
                    <?
                        $cnt2++;
                        }
                    }
                    ?>
                </div>
            </div>
        <!-- 장비상태 끝 -->
		</div></div>
    </div>
    <div id="slideToggle"><img src="../images/slide_close_btn.png" alt=""></div>
    <!--추가-->

    <div class="slide">
        <div class="s_box01">
    <div class="s_box_in w55 mR20">
        <ul>
            <li>지역명</li>
            <li id="rtu_name">마장교</li>
        </ul>
    </div>


    <div class="s_box_in w45">
        <ul>
            <li>최종로깅 시각</li>
            <li id="call_last">2021.01.20 / 09:25</li>
        </ul>
    </div>
</div>


<div class="s_box02 b_smart">
    <div class="s_box_title">
        <ul id="powerType">
            <li class="w10"><div class="icon_box"><img src="../images/icon_slide_01.png" alt=""></div></li>
            <li class="w80">태양전지</li>
            <li class="smart_use"><div class="smart_label">SMART</div></li>
        </ul>
    </div>
    
    <div class="s_box_content">
    

<div class="s_box_group mR10">
        
<div class="box_detail w50">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box"><img src="../images/icon_v.png" alt=""></div></li>
        <li>전압 01</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_sv01">
            <canvas id="sv1" width="170" height="110"></canvas>
        </div>
    </div>
            
<div class="box_detail w50">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box2"><img src="../images/icon_a.png" alt=""></div></li>
        <li>소비전류 01</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_sa01">
            <canvas id="sa1" width="170" height="110"></canvas>
        </div>
    </div>
</div><div class="s_box_group">
        
<div class="box_detail w50 background_dark">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box"><img src="../images/icon_v.png" alt=""></div></li>
        <li>전압 02</li>
    </ul>
    </div>
        <div class="s_box_graph"  id="graph_sv02">
            <canvas id="sv2" width="170" height="110"></canvas>
        </div>
    </div>
            
<div class="box_detail w50 background_dark">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box2"><img src="../images/icon_a.png" alt=""></div></li>
        <li>소비전류 02</li>
    </ul>
    </div>
        <div class="s_box_graph"  id="graph_sa02">
            <canvas id="sa2" width="170" height="110"></canvas>
        </div>
    </div>
</div>
    
          
    </div>    
    </div>


<div class="s_box03">
    <div class="s_box_title">
        <ul>
            <li class="w10"><div class="icon_box"><img src="../images/icon_slide_04.png" alt=""></div></li>
            <li class="w80">배터리</li>
                <li class="smart_use"><div class="smart_label">SMART</div></li>
      </ul>
        </div>
    
    <div class="s_box_content">
    

<div class="s_box_group mR10">
        
<div class="box_detail w100">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box"><img src="../images/icon_v.png" alt=""></div></li>
        <li>배터리전압 01</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_bv01">
            <canvas id="bv1" width="210" height="60"></canvas>
        </div>
    </div>
            

</div><div class="s_box_group">
        
<div class="box_detail w100 background_dark">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box"><img src="../images/icon_v.png" alt=""></div></li>
        <li>배터리전압 02</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_bv02">
            <canvas id="bv2" width="210" height="60"></canvas>
        </div>
    </div>
            

</div>
    
          
    </div>    
    </div>

<div class="s_box02">
    <div class="s_box_title">
        <ul>
            <li class="w10"><div class="icon_box"><img src="../images/icon_slide_03.png" alt=""></div></li>
            <li class="w80">소비전류</li>
                <li class="smart_use"><div class="smart_label">SMART</div></li>
      </ul>
        </div>
    
    <div class="s_box_content">
    

<div class="s_box_group w33 mR10">
        
<div class="box_detail w100">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box2"><img src="../images/icon_a.png" alt=""></div></li>
        <li>소비전류 01</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_ba01">
            <canvas id="ba1"  width="180" height="80"></canvas>
        </div>
    </div>
            

</div><div class="s_box_group w33 mR10">
        
<div class="box_detail w100">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box2"><img alt="" src="../images/icon_a.png"></div></li>
        <li>소비전류 02</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_ba02">
            <canvas id="ba2"  width="180" height="80"></canvas>
        </div>
    </div>
   </div>

<div class="s_box_group w33">
        
<div class="box_detail w100 background_dark">
<div class="s_box_title_01">
    <ul>
        <li><div class="s_icon_box2"><img src="../images/icon_a.png" alt=""></div></li>
        <li>소비전류 03</li>
    </ul>
    </div>
        <div class="s_box_graph" id="graph_ba03">
            <canvas id="ba3"  width="180" height="80"></canvas>
        </div>
    </div>
            

</div>
    
          
    </div>    
    </div>


<div class="s_box_group">
<div class="s_box04 w60">
    
    
<div class="s_box_content mB10">
<div class="w33">
<div id="mainamp" class="box_detail_02 mR10">

<div class="s_box_title_02">
    메인엠프
</div>
<div class="s_box_con">
    <ul class="eq_state">
        <li>이상</li>
        <li><div class="state_icon_02"><img src="../images/icon_amp.png" alt="엠프"></div></li>
    </ul>
</div>
</div>
</div>        
<div class="w33">
<div id="door" class="box_detail_02 mR10">

<div class="s_box_title_02">
    도어
    </div>
<div class="s_box_con">
    <ul class="eq_state">
        <li>정상</li>
        <li><div class="state_icon_01"><img src="../images/icon_door.png" alt="도어"></div></li>
</ul>
</div>
        </div>
</div>
<div class="w33">
<div class="box_detail">

<div class="s_box_title_02">온도</div>
<div class="s_box_con02">
    <ul class="eq_state">
        <li id="room_temp">-</li>
        <li>℃</li>
</ul>
</div>
        </div>
</div>

          </div>


<div class="s_box_content">
        <div class="w33">
<div id="rain_sensor" class="box_detail_02 mR10">

<div class="s_box_title_02">강우센서</div>
<div class="s_box_con">
    <ul class="eq_state">
        <li>이상</li>
        <li><div class="state_icon_02"><img src="../images/icon_sensor.png" alt="센서"></div></li>
</ul>
</div>
        </div>
</div>        
<div class="w33 mR10">
<div id="flow_sensor" class="box_detail">

<div class="s_box_title_02">수위센서</div>
<div class="s_box_con">
    <ul class="eq_state">
        <li>정상</li>
        <li><div class="state_icon_01"><img src="../images/icon_sensor.png" alt="센서"></div></li>
</ul>
</div>
        </div>
</div>
<div class="w33">
<div class="box_detail">

<div class="s_box_title_02">습도</div>
<div class="s_box_con02">
    <ul class="eq_state">
        <li id="room_humi">-</li>
        <li>%</li>
</ul>
</div>
        </div>
</div>

          </div>    
           </div>
           <div class="s_box05 w40">
    <div class="title">스피커</div>
    <div class="speaker_state">
        <ul>
            <li id="speaker1"><img src="../images/speaker_img01.png" alt=""></li>
            <li id="speaker3"><img src="../images/speaker_img03.png" alt=""></li>
            <li id="speaker5"><img src="../images/speaker_img05.png" alt=""></li>
            <li id="speaker7"><img src="../images/speaker_img07.png" alt=""></li>
        </ul>
        <ul>
            <li id="speaker2"><img src="../images/speaker_img02.png" alt=""></li>
            <li id="speaker4"><img src="../images/speaker_img04.png" alt=""></li>
            <li id="speaker6"><img src="../images/speaker_img06.png" alt=""></li>
            <li id="speaker8"><img src="../images/speaker_img08.png" alt=""></li>
        </ul>
    </div>
</div>
        
        </div>


    </div>
    </div> <!--컨텐츠 슬라이트 포함 끝-->

    <!--본문내용섹션 끝-->
</div>
</div>
<!--우측섹션 끝-->

<script type="text/javascript">
$(function () {

    function isEmptyArr(arr)  {
        if(Array.isArray(arr) && arr.length === 0)  {
            return true;
        }
            return false;
    }
   
    var myChart1 = null;
    var myChart2 = null;
    var myChart3 = null;
    var myChart4 = null;
    var myChart5 = null;
    var myChart6 = null;
    var myChart7 = null;
    var myChart8 = null;
    var myChart9 = null;

    var sv1 = document.getElementById('sv1').getContext('2d');
    var sa1 = document.getElementById('sv2').getContext('2d');
    var sv2 = document.getElementById('sa1').getContext('2d');
    var sa2 = document.getElementById('sa2').getContext('2d');
    var bv1 = document.getElementById('bv1').getContext('2d');
    var bv2 = document.getElementById('bv2').getContext('2d');
    var ba1 = document.getElementById('ba1').getContext('2d');
    var ba2 = document.getElementById('ba2').getContext('2d');
    var ba3 = document.getElementById('ba3').getContext('2d');
        
    graph_update(sv1);
    graph_update(sv2);
    graph_update(sa1);
    graph_update(sa2);
    graph_update(bv1);
    graph_update(bv2);
    graph_update(ba1);
    graph_update(ba2);
    graph_update(ba3);

    function graph_update(object,data1,data2){
        
        var config = {
            type: 'line',
            data: {
                labels: (isEmptyArr(data1)) ? [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23] : data1 ,
                datasets: [{
                    label: '',
                    data: data2 ,
                    backgroundColor: '#81b0df',
                    borderColor: '#c3dcf5',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(162, 162, 162, 0.4)",
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        fontColor: '#707070'
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgba(162, 162, 162, 0.4)",
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        fontColor: '#707070'
                    }]
                }
            }
        };

        if(object == sv1){
            if(myChart1 == null) {
                myChart1 = new Chart(sv1, config);
            } else{
                myChart1.config = config;
                myChart1.update();   
            }
        }else if(object == sv2){
            if(myChart2 == null) {
                myChart2 = new Chart(sv2, config);
            } else{
                myChart2.config = config;
                myChart2.update();   
            }
        }else if(object == sa1){
            if(myChart3 == null) {
                myChart3 = new Chart(sa1, config);
            } else{
                myChart3.config = config;
                myChart3.update();   
            }
        }else if(object == sa2){
            if(myChart4 == null) {
                myChart4 = new Chart(sa2, config);
            } else{
                myChart4.config = config;
                myChart4.update();   
            }
        }else if(object == bv1){
            if(myChart5 == null) {
                myChart5 = new Chart(bv1, config);
            } else{
                myChart5.config = config;
                myChart5.update();   
            }
        }else if(object == bv2){
            if(myChart6 == null) {
                myChart6 = new Chart(bv2, config);
            } else{
                myChart6.config = config;
                myChart6.update();   
            }
        }else if(object == ba1){
            if(myChart7 == null) {
                myChart7 = new Chart(ba1, config);
            } else{
                myChart7.config = config;
                myChart7.update();   
            }
        }else if(object == ba2){
            if(myChart8 == null) {
                myChart8 = new Chart(ba2, config);
            } else{
                myChart8.config = config;
                myChart8.update();   
            }
        }else if(object == ba3){
            if(myChart9 == null) {
                myChart9 = new Chart(ba3, config);
            } else{
                myChart9.config = config;
                myChart9.update();   
            }
        }
    }

    //smartpower_hist 데이터 조회
    function selectSmartPowerHist() { 
        var el = $("#select_area_code").val();
            var param = "mode=smart_equip_monitoring&AREA_CODE="+el;
            var labels = new Array();
            var sola_volt1 = new Array();
            var sola_curr1 = new Array();
            var sola_volt2 = new Array();
            var sola_curr2 = new Array();
            var batt_volt1 = new Array();
            var batt_volt2 = new Array();
            var load_curr1 = new Array();
            var load_curr2 = new Array();
            var load_curr3 = new Array();
            var room_temp = "";
            var room_humi = "";

            $.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					// console.log(data.list);
					$.each(data.list, function(i, v){
                        labels[i] = v.LOG_DATE.substr(11,2);
                        sola_volt1[i] = v.SOLA_VOLT1;
                        sola_curr1[i] = v.SOLA_CURR1;
                        sola_volt2[i] = v.SOLA_VOLT2;
                        sola_curr2[i] = v.SOLA_CURR2;
                        batt_volt1[i] = v.BATT_VOLT1;
                        batt_volt2[i] = v.BATT_VOLT2;
                        load_curr1[i] = v.LOAD_CURR1;
                        load_curr2[i] = v.LOAD_CURR2;
                        load_curr3[i] = v.LOAD_CURR3;
                        room_temp = v.ROOM_TEMP;
                        room_humi = v.ROOM_HUMI;
					});		
		        }
	        },
	        beforeSend : function(data){ 
				
	        },
	        complete : function(data){ 
                graph_update(sv1, labels, sola_volt1);
                graph_update(sv2, labels, sola_curr1);
                graph_update(sa1, labels, sola_volt2);
                graph_update(sa2, labels, sola_curr2);
                graph_update(bv1, labels, batt_volt1);
                graph_update(bv2, labels, batt_volt2);
                graph_update(ba1, labels, load_curr1);
                graph_update(ba2, labels, load_curr2);
                graph_update(ba3, labels, load_curr3);
                $("#room_temp").html(room_temp);
                $("#room_humi").html(room_humi);
							
	        }
	    }); 
    }

    //state_hist_new 데이터 조회
    function selectStateHist() { 
        var el = $("#select_area_code").val();
            var param = "mode=equip_monitoring&AREA_CODE="+el;
            var labels = new Array();
            var sola_volt1 = new Array();
            var sola_curr1 = new Array();
            var sola_volt2 = new Array();
            var sola_curr2 = new Array();
            var batt_volt1 = new Array();
            var batt_volt2 = new Array();
            var load_curr1 = new Array();
            var load_curr2 = new Array();
            var load_curr3 = new Array();
            var room_temp = "-";
            var room_humi = "-";

            $.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){
		        if(data.list){
					// console.log(data.list);
					$.each(data.list, function(i, v){
                        labels[i] = v.LOG_DATE.substr(11,2);
                        sola_volt1[i] = v.SOLA_VOLT1;
                        sola_curr1[i] = v.SOLA_CURR1;
                        batt_volt1[i] = v.BATT_VOLT1;
                        load_curr1[i] = v.LOAD_CURR1;
                        load_curr2[i] = v.LOAD_CURR2;
                        room_temp = "-";
                        room_humi = "-";
					});		
		        } 
	        },
	        error : function(data){ 
                $("#room_temp").html(room_temp);
                $("#room_humi").html(room_humi);
	        },
	        complete : function(data){ 
                graph_update(sv1, labels, sola_volt1);
                graph_update(sv2, labels, sola_curr1);
                graph_update(sa1, labels, sola_volt2);
                graph_update(sa2, labels, sola_curr2);
                graph_update(bv1, labels, batt_volt1);
                graph_update(bv2, labels, batt_volt2);
                graph_update(ba1, labels, load_curr1);
                graph_update(ba2, labels, load_curr2);
                graph_update(ba3, labels, load_curr3);
                $("#room_temp").html(room_temp);
                $("#room_humi").html(room_humi);
						
	        }
	    }); 
    }

    //speakerState 데이터 조회
    function speakerState() {
        var area_code = $("#select_area_code").val();
        var param = "mode=speaker&AREA_CODE="+area_code;
        var speaker_cnt = "";
        var speaker_use_num = new Array();
        var speaker_error_cnt = "";
        var speaker_error = new Array();

        $.ajax({
	    type: "POST",
	    url: "../_info/json/_tms_json.php",
	    data: param,
	    cache: false,
	    dataType: "json",
            success : function(data){
                if(data.list){
                    var tmpData = data.list[0];
                    // console.log(tmpData);
                    speaker_error_cnt = tmpData.SPEAKER_ERROR_CNT;
                    speaker_cnt = tmpData.SPEAKER_CNT;
                    if(speaker_cnt > 0){
                        if(speaker_error_cnt >0){
                            var tmpString = tmpData.SPEAKER_ERROR;
                            speaker_error = tmpString.split("||");
                            speaker_error.sort();
                            // 빈 배열 filter로 제거
                            speaker_error = speaker_error.filter(function(item){
                                return item !== null && item !== undefined && item !== '';
                            });
                        }
                        speaker_use_num = tmpData.SPEAKER_USE_NUM.split("||");
                        // console.log(speaker_use_num);
                        speaker_use_num.sort();
                        // 빈 배열 filter로 제거
                        speaker_use_num = speaker_use_num.filter(function(item){
                            return item !== null && item !== undefined && item !== '';
                        });
                        
                        for(var i=1; i<=8; i++){
                            if(speaker_cnt == 8){
                                var tempSrc = "<img src='../images/speaker_img0"+i+".png' alt=''>";
                                $("#speaker"+i).html(tempSrc);
                            }else{
                                // console.log(speaker_use_num);
                                if(i == speaker_use_num[0]){
                                    var tempSrc = "<img src='../images/speaker_img0"+i+".png' alt=''>";
                                    $("#speaker"+i).html(tempSrc);
                                    speaker_use_num.shift();
                                }else{
                                    $("#speaker"+i).html("");
                                }
                            }
                            if(i == speaker_error[0]){
                                // console.log(speaker_error);
                                var tempSrc = "<img src='../images/speaker_img0"+i+"_error.png' alt=''>";
                                $("#speaker"+i).html(tempSrc);
                                speaker_error.shift();
                            }
                        }
                    }else{
                        for(var i=1; i<=8; i++){
                            $("#speaker"+i).html("");
                        }
                    }
                } 
            }
	    }); 
    }

    $('#content').scroll(function(){
        var scrollT = $(this).scrollTop(); //스크롤바의 상단위치
        var scrollH = $(this).height(); //스크롤바를 갖는 div의 높이
        var contentH = $('#content').height(); //문서 전체 내용을 갖는 div의 높이
        // console.log(scrollT);
        // console.log(scrollH);
        // console.log(contentH);

    });


    // 우측 슬라이드
    $(".slide").show();
    var slider = true;

    // 오픈 클로즈 버튼 토글
	$("#slideToggle").click(function(){
        if(slider){
            $(".slide").slideUp("fast");
            $("#slideToggle img").attr("src", "../images/slide_open_btn.png");
        }else{
            selectEquip();
            // 오픈 토글
            $(".slide").slideDown("fast");
            $("#slideToggle img").attr("src", "../images/slide_close_btn.png");
        }
        slider = !(slider);
	});

    // 장비 선택
    function selectEquip(){
        var tmp_code = $("#select_area_code").val();
        var tmp_select = "#list_table1 tbody #equip_"+ tmp_code;
        $("#rtu_name").html($(tmp_select + " #RTU_NAME").html());
        $("#call_last").html($(tmp_select + " #LOG_DATE").html());
        var tmp_power = $(tmp_select + " #input").html();
        tmp_power = tmp_power.substr(25, 2);
        if(tmp_power == "ac"){
            $("#powerType img").attr("src", "../images/icon_slide_02.png");
            $("#powerType li:nth-child(2)").text("전원");
        }else{
            $("#powerType img").attr("src", "../images/icon_slide_01.png");
            $("#powerType li:nth-child(2)").text("태양전지");
        }

        if($(tmp_select + " #MAINAMP_STAT").html() == '<img src="../images/icon_ok.png" alt="정상">'){
            $("#mainamp .eq_state li:first-child").html("정상");
            $("#mainamp .eq_state li div").attr('class', 'state_icon_01');
        } else {
            $("#mainamp .eq_state li:first-child").html("이상");
            $("#mainamp .eq_state li div").attr('class', 'state_icon_02');
            //이미지 변경?
            // $("#mainamp .eq_state li div img").html();
        }
        if($(tmp_select + " #DOOR_STAT").html() == '<img src="../images/icon_ok.png" alt="정상">'){
            $("#door .eq_state li:first-child").html("정상");
            $("#door .eq_state li div").attr('class', 'state_icon_01');
        } else {
            $("#door .eq_state li:first-child").html("이상");
            $("#door .eq_state li div").attr('class', 'state_icon_02');
        }
        if($(tmp_select + " #SENSOR_STAT").html() == '<img src="../images/icon_ok.png" alt="정상">'){
            $("#rain_sensor .eq_state li:first-child").html("정상");
            $("#rain_sensor .eq_state li div").attr('class', 'state_icon_01');
            $("#flow_sensor .eq_state li:first-child").html("정상");
            $("#flow_sensor .eq_state li div").attr('class', 'state_icon_01');
        } else {
            $("#rain_sensor .eq_state li:first-child").html("이상");
            $("#rain_sensor .eq_state li div").attr('class', 'state_icon_02');
            $("#flow_sensor .eq_state li:first-child").html("이상");
            $("#flow_sensor .eq_state li div").attr('class', 'state_icon_02');
        }

        // 스마트베터리 사용유무
        var tmp_use = $(tmp_select + " input").val();
        if(tmp_use != "-"){
            $(".smart_use").html('<div class="smart_label">SMART</div>');
            $(".smart_use").parent().parent().parent().addClass('b_smart');
            $(".slide .background_dark").attr('class', 'background_none');
            selectSmartPowerHist();
        } else {
            $(".smart_use").html("");
            $(".smart_use").parent().parent().parent().removeClass('b_smart');
            $(".slide .background_none").attr('class', 'background_dark');
            selectStateHist();
        }

        // 스피커 상태
        speakerState();

    }

    $(".tab_content").hide();
    $(".tab_content:first").show();
	$(".tab_container").hide();	//tab content 숨기기
	firstSelect();
	var activeTab = "";
    $("ul.tabs li").click(function () {
        $("ul.tabs li").removeClass("active").css("background", "linear-gradient(0deg, #191b1d, #24272b)");
		$(this).addClass("active").css("background", "linear-gradient(0, #4f70c4, #6b91f1)");
        $(".tab_content").hide()
        activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn()

    });

	if(activeTab == "") activeTab = "tab1";

	function firstSelect(){
		//초기값 선택되게
		$(".active").css('background','linear-gradient(0, #4f70c4, #6b91f1)');
		$('#group_id').val('001'); 
		data_load($('#group_id').val(), 1); 
	}

	// 그룹 선택
	$("#container .tabs li").click(function(){
		var group_id = this.id.split('_');
		$('#group_id').val(group_id[1]); 

		if($("#list_table1 tr").length > 0){
			$("#list_table1 tr").remove(); //테이블 삭제 
			$(".tab_container").hide();	//tab content 숨기기
		}
		data_load(group_id[1], 1);
	});

	// load_time마다 한번 데이터 업데이트
	setInt_data = setInterval(function(){
		data_load($('#group_id').val(), 2);
        selectEquip();
	}, common_load_time*18); // 3분 마다
	// }, common_load_time);

	// setInt_date 정지
	stop_data = function(){
		clearInterval(setInt_data);
	}

//	console.log($('#group_id').val());
	function data_load(id, type){
		var tmp_spin = null;
		//console.log(id);
		var param = "mode=group_equip&GROUP_ID="+id;
		$.ajax({
	        type: "POST",
	        url: "../_info/json/_tms_json.php",
		    data: param,
	        cache: false,
	        dataType: "json",
	        success : function(data){

                var lay_html = '';
                var lay_html2 = '';
                    lay_html += ' <tr> ';
                    lay_html += ' <th rowspan="2">지역</th>  ';
                    lay_html += ' <th colspan="5">전원</th>  ';
                    lay_html += ' <th colspan="2">배터리</th>  ';
                    lay_html += ' <th colspan="3">소비전류</th> ';
                    lay_html += ' <th rowspan="2">도어</th>  ';
                    lay_html += ' <th rowspan="2">센서</th> ';
                    lay_html += ' <th rowspan="2">메인앰프</th> ';
                    lay_html += ' <th rowspan="2">스피커</th>  ';
                    lay_html += ' <th rowspan="2">최종로깅시각</th>  ';
                    lay_html += ' </tr> ';
                    lay_html += ' <tr> ';
                    lay_html += ' <td class="gry">입력</td>  ';
                    lay_html += ' <td class="gry">전압1(V)</td>  ';
                    lay_html += ' <td class="gry">전압2(V)</td>  ';
                    lay_html += ' <td class="gry">전류1(A)</td>  ';
                    lay_html += ' <td class="gry">전류2(A)</td>  ';
                    lay_html += ' <td class="gry">전압1(V)</td>  ';
                    lay_html += ' <td class="gry">전압2(V)</td>  ';
                    lay_html += ' <td class="gry">전류1(A)</td>  ';
                    lay_html += ' <td class="gry">전류2(A)</td>  ';
                    lay_html += ' <td class="gry">전류3(A)</td>  ';
                    lay_html += ' </tr>  ';
		        if(data.list){
					if(type == 1){
							
                        $(".main_table_1 thead").html(lay_html);
						 $.each(data.list, function(i, v){

                            if(v.SPEAKER_ERROR_CNT == 0){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 1){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error01.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 2){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error02.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 3){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error03.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 4){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error04.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 5){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error05.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 6){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error06.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 7){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error07.png" alt="스피커 상태"> ';
                            }else if(v.SPEAKER_ERROR_CNT == 8){
                                v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error08.png" alt="스피커 상태"> ';
                            }	

							if(v.SPEAKER_CNT == 0){
								v.SPEAKER_ERROR_CNT = '<img src="../images/speaker/speaker_img_no.png" alt="스피커 상태">';
							}
                            
							lay_html2 += ' <tr id="equip_'+v.AREA_CODE+'"> ';
							lay_html2 += ' <td id="RTU_NAME">'+v.RTU_NAME+'</td> ';
                            if(v.SOLA_VOLT == 0){ lay_html2 += ' <td id="input"><img src="../images/icon_ac.png" alt="상전"></td> '; }
                            else{ lay_html2 += ' <td id="input"><img src="../images/icon_dc.png" alt="태양전지"></td> '; }

                            if(v.SMART_USE == "-"){
							    lay_html2 += ' <td id="SOLA_VOLT1">'+v.SOLA_VOLT+'</td> ';
							    lay_html2 += ' <td id="SOLA_VOLT2">-</td> ';
                                lay_html2 += ' <td id="SOLA_CURR1">'+v.SOLA_AMPERE+'</td> ';
							    lay_html2 += ' <td id="SOLA_CURR2">-</td> ';
							    lay_html2 += ' <td id="BATT_VOLT1">'+v.BATT_VOLT+'</td> ';
							    lay_html2 += ' <td id="BATT_VOLT2">-</td> ';
                                lay_html2 += ' <td id="LOAD_CURR1">'+v.LOAD1_AMPERE+'</td> ';
                                lay_html2 += ' <td id="LOAD_CURR2">'+v.LOAD2_AMPERE+'</td> ';
							    lay_html2 += ' <td id="LOAD_CURR3">-</td> ';
                            }else{
							    lay_html2 += ' <td id="SOLA_VOLT1">'+v.SOLA_VOLT1+'</td> ';
							    lay_html2 += ' <td id="SOLA_VOLT2">'+v.SOLA_VOLT2+'</td> ';
                                lay_html2 += ' <td id="SOLA_CURR1">'+v.SOLA_CURR1+'</td> ';
							    lay_html2 += ' <td id="SOLA_CURR2">'+v.SOLA_CURR2+'</td> ';
							    lay_html2 += ' <td id="BATT_VOLT1">'+v.BATT_VOLT1+'</td> ';
							    lay_html2 += ' <td id="BATT_VOLT2">'+v.BATT_VOLT2+'</td> ';
                                lay_html2 += ' <td id="LOAD_CURR1">'+v.LOAD_CURR1+'</td> ';
                                lay_html2 += ' <td id="LOAD_CURR2">'+v.LOAD_CURR2+'</td> ';
							    lay_html2 += ' <td id="LOAD_CURR3">'+v.LOAD_CURR3+'</td> ';
                            }
							lay_html2 += ' <td id="DOOR_STAT">'+v.DOOR_STAT+'</td> ';
							lay_html2 += ' <td id="SENSOR_STAT">'+v.SENSOR_STAT+'</td> ';
							lay_html2 += ' <td id="MAINAMP_STAT">'+v.MAINAMP_STAT+'</td> ';
							lay_html2 += ' <td id="SPEAKER_SELECT">'+v.SPEAKER_ERROR_CNT+'</td> ';
							lay_html2 += ' <td id="LOG_DATE">'+v.LOG_DATE+'<input type="hidden" value="'+v.SMART_USE+'"></td> ';
                            lay_html2 += ' </tr>';

                            if(i == 0){
                                $("#select_area_code").val(v.AREA_CODE);
                            }
						});
						// 내용
                        $("#list_table1 tbody").html(lay_html2);     

                        $("#list_table1 tbody tr").click(function(){
                            $("#select_area_code").val(this.id.substr(6));
                            
                            //슬라이더가 열려 있을때만 호출
                            if(slider == true) selectEquip();
                            //클릭하면 자동 열림x
                            // selectEquip();
                        });
                        
                        // if(smart_use){
                        //     $("#list_table1 tbody tr").click({param: this},test);
                        // }
                        // $('#somebtn').click({param: someword}, test);
					}else if(type == 2){
						if(data.list){
							$.each(data.list, function(i, v){
                                //console.log(data.list);
                                
                                if(v.SPEAKER_ERROR_CNT == 0){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 1){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error01.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 2){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error02.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 3){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error03.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 4){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error04.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 5){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error05.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 6){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error06.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 7){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error07.png" alt="스피커 상태"> ';
                                }else if(v.SPEAKER_ERROR_CNT == 8){
                                    v.SPEAKER_ERROR_CNT = ' <img src="../images/icon_speaker_error08.png" alt="스피커 상태"> ';
                                }	
                                
                                if(v.SPEAKER_CNT == 0){
								v.SPEAKER_ERROR_CNT = '<img src="../images/speaker/speaker_img_no.png" alt="스피커 상태">';
							    }

								var tmp_id = "#equip_"+v.AREA_CODE;
								if(v.SMART_USE == "-"){
							    $(tmp_id+" #SOLA_VOLT1").html(v.SOLA_VOLT);
                                $(tmp_id+" #SOLA_CURR1").html(v.SOLA_AMPERE);
							    $(tmp_id+" #BATT_VOLT1").html(v.BATT_VOLT);
                                $(tmp_id+" #LOAD_CURR1").html(v.LOAD1_AMPERE);
                                $(tmp_id+" #LOAD_CURR2").html(v.LOAD2_AMPERE);
                            }else{
							    $(tmp_id+" #SOLA_VOLT1").html(v.SOLA_VOLT1);
							    $(tmp_id+" #SOLA_VOLT2").html(v.SOLA_VOLT2);
                                $(tmp_id+" #SOLA_CURR1").html(v.SOLA_CURR1);
							    $(tmp_id+" #SOLA_CURR2").html(v.SOLA_CURR2);
							    $(tmp_id+" #BATT_VOLT1").html(v.BATT_VOLT1);
							    $(tmp_id+" #BATT_VOLT2").html(v.BATT_VOLT2);
                                $(tmp_id+" #LOAD_CURR1").html(v.LOAD_CURR1);
                                $(tmp_id+" #LOAD_CURR2").html(v.LOAD_CURR2);
							    $(tmp_id+" #LOAD_CURR3").html(v.LOAD_CURR3);
                            }
								$(tmp_id+" #DOOR_STAT").html(v.DOOR_STAT);
								$(tmp_id+" #SENSOR_STAT").html(v.SENSOR_STAT);
								$(tmp_id+" #MAINAMP_STAT").html(v.MAINAMP_STAT);
								$(tmp_id+" #SPEAKER_SELECT").html(v.SPEAKER_ERROR_CNT);
								$(tmp_id+" #LOG_DATE").html(v.LOG_DATE + '<input type="hidden" value="'+v.SMART_USE+'">');
							});
						}
                    }
                }else{
					lay_html += ' <tr> ';
					lay_html += ' <td colspan="22">데이터가 없습니다.</td> ';
					lay_html += ' </tr>';
                    
					$("#list_table1 tbody").html(lay_html);
				}
	        },
	        beforeSend : function(data){ 
				if(type == 1){
					if( $("#content #spin").length == 0 ){
						$("#content").append('<div id="spin" class="tmp-spin-size"></div>');
					}
					tmp_spin = spin_start("#spin", "135px");
				}
	        },
	        complete : function(data){ 
                if(slider == true) selectEquip();
				$(".tab_container").show(); //tab content 보여주기
				if(type == 1){
			      	if(tmp_spin){
						spin_stop(tmp_spin, "#content #spin"); 
						$("#spin").removeClass("tmp-spin-size");
			       	}
				}			
	        }
        });
    }
    
	//console.log(activeTab);
	//console.log($("#"+activeTab+"").find('table.floating-thead thead'));
	//console.log($("#"+activeTab+" table"));
	//$("#"+activeTab+" thead").each(function() {
	//console.log(activeTab);
	$('#list_table1>thead').each(function() {
		$(this).after( $(this).clone().hide().css('top',42).css('position','fixed') );
	});

  //$(window).scroll(function() {
	         


	$("#right").on("scroll",function(event){
		//console.log($(this));
    //$('#list_table1').each(function(i) {
		$("#"+activeTab+" table").each(function(i) {
			//console.log($(this));
			
		  var table = $(this),
			thead = table.find('thead:first'),
			clone = table.find('thead:last'),
			top = table.offset().top,
			bottom = top + table.height() - thead.height(),
			left = table.position().left+73,
			//left = table.position().left+52,
			//margin = table.position().marign,
			border = parseInt(thead.find('th:first').css('border-width')),
			scroll = $(window).scrollTop();
		  //console.log(table.offset().top,scroll);
		  //console.log(table.position().marign);
		  if( scroll < top || scroll > bottom ) {
			clone.hide();
			return true;
		  }
		  if( clone.is('visible') ) return true;
		  //clone.css('margin-left',100);
		  //clone.css('margin-left',75); //크롬
		  //clone.css('margin-right',15); //크롬
		  clone.css('left',left).show().find('th').each(function(i) {
			  //console.log($(this));
			//$(this).width( thead.find('th').eq(i).width() + border );
			$(this).width( thead.find('th').eq(i).width());
			//$(this).width( thead.find('th').eq(i).width() ); //크롬
			//console.log(thead.find('th').eq(i).width());
		  });     
		});
  });

});
/*
$(function () {
  $('#list_table1>thead').each(function() {
	//console.log($(this));
    $(this).after( $(this).clone().hide().css('top',42).css('position','fixed') );
  });
  
  //$(window).scroll(function() {
	$("#right").on("scroll",function(event){
    //$('#list_table1').each(function(i) {
	$("#"+activeTab+" table").each(function(i) {
		//console.log($(this));
		
      var table = $(this),
        thead = table.find('thead:first'),
        clone = table.find('thead:last'),
        top = table.offset().top,
        bottom = top + table.height() - thead.height(),
		left = table.position().left+73,
		//left = table.position().left+52,
		//margin = table.position().marign,
		border = parseInt(thead.find('th:first').css('border-width')),
        scroll = $(window).scrollTop();
      //console.log(table.offset().top,scroll);
	  //console.log(table.position().marign);
      if( scroll < top || scroll > bottom ) {
        clone.hide();
        return true;
      }
      if( clone.is('visible') ) return true;
	  //clone.css('margin-left',100);
	  //clone.css('margin-left',75); //크롬
	  //clone.css('margin-right',15); //크롬
      clone.css('left',left).show().find('th').each(function(i) {
        //$(this).width( thead.find('th').eq(i).width() + border );
		$(this).width( thead.find('th').eq(i).width());
		//$(this).width( thead.find('th').eq(i).width() ); //크롬
		console.log(thead.find('th').eq(i).width());
      });     
    });
  });
});
*/
//function 


</script>




</body>
</html>