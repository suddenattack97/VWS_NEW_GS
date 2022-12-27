<?$sel_sub = $_GET['sel_sub'];?>

<!--레이더위성-->
<?if($sel_sub ==1){?>
<div class="rad_sat disblock">
<div class="tv_unit">
      <!--위성-->
      <div class="tv_unit_s mB05p">
        <span class="tv_subtitle tv_blue">레이더
          <button type="button" id="btn_board" class="radar_btn mR5" onclick="onfullscreen(this)"><i class="fa fa-clone"></i></button>
        </span>
        <span class="tv_subcon radar" id="radar"><img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'></span>
      </div>
      <!--레이더-->
      <div class="tv_unit_s">
        <span class="tv_subtitle tv_blue">위성
          <button type="button" id="btn_board" class="radar_btn mR5" onclick="onfullscreen(this)"><i class="fa fa-clone"></i></button>
        </span>
        <span class="tv_subcon heroes">
          <img id='heroesImg' class='raderloading' src='./img/heroes/def_sat.png' width='100%' height='100%'>
        </span>
      </div>
</div>
</div>
<?}?>
<!--레이더위성 끝-->
<!--레이더태풍-->
<?if($sel_sub ==2){?>

<div class="rad_tor disblock">
<div class="tv_unit">
      <!--레이더-->
      <div class="tv_unit_s mB05p">
        <span class="tv_subtitle tv_blue">레이더</span>
        <span class="tv_subcon radar" id="radar"><img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'></span>
      </div>
      <!--태풍-->
      <div class="tv_unit_s">
        <span class="tv_subtitle tv_blue">태풍</span>
        <span class="tv_subcon"><iframe src="canon.php" width="100%" height="100%"></iframe></span>
      </div>
</div>
</div>
<?}?>
<!--레이더태풍 끝-->
<!--위성태풍-->
<?if($sel_sub ==3){?>
<div class="sat_tor disblock">
<div class="tv_unit">
      <!--위성-->
      <div class="tv_unit_s mB05p">
        <span class="tv_subtitle tv_blue">위성</span>
        <span class="tv_subcon heroes"></span>
      </div>
      <!--태풍-->
      <div class="tv_unit_s">
        <span class="tv_subtitle tv_blue">태풍</span>
        <span class="tv_subcon"><iframe src="canon.php" width="100%" height="100%"></iframe></span>
      </div>
</div>
</div>
<?}?>
<!--위성태풍 끝-->
<!--강우테이블-->
<?if($sel_sub ==4){?>

<div class="raint disblock">
<div class="tv_unit">
      <div class="tv_unit_s mB05p h100">
        <span class="tv_subtitle tv_blue h5">지역별 강우량</span>
          <table class="tb">
          <thead>
          <tr>
            <th>관측소</th>
            <th>전시간</th>
            <th>시간</th>
            <th>금일</th>
            <th>전일</th>
            <th>월간</th>
          </tr>
          </thead>
          <tbody id="rains">
          <tr>
            <td>평균</td>
            <td id="prainbeftime">0</td>
            <td id="prainnowtime">0</td>
            <td id="prainday">0</td>
            <td id="prainbefday">0</td>
            <td id="prainmon">0</td>
          </tr>
		  </tbody>

        </table>
    </div>
</div>
</div>
 <!--강우테이블 끝-->
<!--2단지도형 끝-->
<?}?>
