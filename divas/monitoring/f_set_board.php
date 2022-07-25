<?
	require_once "../_conf/_common.php";
	require_once "./head.php";
	//echo $GRP_HEIGHT."<br>";
	//exit;
?>
<!--탑메뉴 시작-->
<?php include "topmenu.php" ?>
<!--탑메뉴 끝-->

<!--좌측사이드바-설정-->
<?php include "left.php" ?>
<!--좌측사이드바-설정 끝-->

<!--우측섹션-->
	<div id="right">
<!--본문내용섹션-->
	  <div id="content">
<!--오브젝트 타이틀-->
					<div class="main_contitle">
						<img src="../images/title_06_04.png" alt="상황판설정">
                    </div>
<!--오브젝트 타이틀 끝-->
<!--테이블 정렬-->

<!--우-방송내용-->
				    <ul class="set_ulwrap_nh">
                        
                        <li class="tb_sms_gry">
							<span class="sel_left_n">
                            상황판 목록조회 : 
                             <select size="1" id="select7" name="search_col" class="f333_12">
                            <option value="RTU_NAME">장비명</option>
                            <option value="AREA_CODE">행망번호</option>
                            </select>&nbsp;
                            <input name="search_word" type="text" class="f333_12" size="60">&nbsp;&nbsp;
                            <button class="btn_bs">조회</button>
                            <button class="btn_lbs">전체목록</button>
                            <button class="btn_lbs">좌표찾기</button>
                          </span>
                          <span class="sel_right_n top5px">
                          ※장비를 클릭하면 설정값을 확인 및 수정할 수 있습니다.
                          </span>
                          
                        </li>
                        <li class="li100_nor">
                         <div class="tb_data">
                          <ul class="tb_data_tbg">
                           <table class="set_tb al_C">
                            <tr>
                              <td rowspan="2" class="w5 bL0">No.</td>
                              <td rowspan="2" class="w5">장비ID</td>
                              <td rowspan="2" class="w10">장비명</td>
                              <td colspan="4">상황판</td>
                              <td colspan="5">장비현황</td>
                              </tr>
                            <tr>
                              <td class="w5">아이콘X</td>
                              <td class="w5">아이콘Y</td>
                              <td class="w5">자료X</td>
                              <td class="w5">자료Y</td>
                              <td class="w10">아이콘X</td>
                              <td class="w10">아이콘Y</td>
                              <td class="w10">스마트X</td>
                              <td class="w10">스마트Y</td>
                              <td class="w20">주소</td>
                            </tr>
                          </table>
                         </ul>
                         <ul>
                         <table class="set_tb al_C">
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                          <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            <tr class="hh">
                              <td class="w5 bL0">1</td>
                              <td class="w5">1</td>
                              <td class="w10">광원경보국</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w5">-100</td>
                              <td class="w10">37683129</td>
                              <td class="w10">127858225</td>
                              <td class="w10">37683232</td>
                              <td class="w10">127863849</td>
                              <td class="w20">강원도 홍천군 북방면</td>
                            </tr>
                            </table>

                           </ul>
                         
                         </div>
                        </li>
                        </ul>
                        <ul class="set_ulwrap_nh">
                        <li class="tb_sms_gry">
                        <span class="top6px">설정값입력</span> 
                        <span class="sel_right_n">
                          <!--<button class="btn_bb80">등록</button>-->
                          <button class="btn_lbb80_s">초기화</button>
                          <button class="btn_lbb80_s">수정</button>
                          <!--<button class="btn_lbb80_s">삭제</button>-->
                          </span>
                        </li>
                        <li class="li100_nor">
                         <table class="set_tb">
                          <tr>
                            <td colspan="2" class="bg_lb bold al_C bL0">구분</td>
                            <td colspan="4" class="bg_lb bold al_C">상황판</td>
                            <td colspan="6" class="bg_lb bold al_C">장비현황</td>
                            </tr>
                          <tr>
                            <td class="bg_lb bold al_C bL0 w7">장비ID</td>
                            <td class="w7">&nbsp;</td>
                            <td class="bg_lb bold al_C w7">아이콘 X</td>
                            <td class="w7">
                            <input name="MAP_ICON_X" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C w7">자료 X</td>
                            <td class="w7">
                            <input name="MAP_DATA_X" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C w7">아이콘 X</td>
                            <td class="w7">
                            <input name="RTU_REAL_X" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C w7">스마트 X</td>
                            <td class="w7">
                            <input name="POINTX" type="text" class="f333_12" size="8"></td>
                            <td rowspan="2" class="bg_lb bold al_C w7">주소</td>
                            <td rowspan="2">
                            <input name="RTU_ADDRESS" type="text" class="f333_12" size="30"></td>
                          </tr>
                          <tr>
                            <td class="bg_lb bold al_C bL0">장비명</td>
                            <td>&nbsp;</td>
                            <td class="bg_lb bold al_C">아이콘 Y</td>
                            <td>
                            <input name="MAP_ICON_Y" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C">자료 Y</td>
                            <td>
                            <input name="MAP_DATA_Y" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C">아이콘 Y</td>
                            <td>
                            <input name="RTU_REAL_Y" type="text" class="f333_12" size="6"></td>
                            <td class="bg_lb bold al_C">스마트 Y</td>
                            <td>
                            <input name="POINTY" type="text" class="f333_12" size="8"></td>
                            </tr>
                        </table>

                        </li>
                        </ul>

<!--우-방송내용 끝-->


<!--테이블 정렬 끝-->
		</div>
<!--본문내용섹션 끝-->
</div>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;  </p>
<!--우측문섹션 끝-->
</body>
<form name="chartFrm">
<input type="hidden" name="chartGubun" value="0">

</html>