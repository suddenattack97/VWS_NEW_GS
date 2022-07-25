<?
require_once "../_conf/_common.php";
require_once "../_info/_set_setting.php";
// require_once "./head.php";
?>
<div id="top_layout">
  <div id="top"> 
    <div id="logo">
      <span id="top_img">
          <div id="logo_area">
            <a href="/"><img src="../images/top/<?=top_img?>"></a>
          </div>
      </span> 
       <span id="top_title"><?=top_title?> <?=top_text?></span> 
    </div>
<!-- 
    <div id="top_img"></div>
	<div class="ttext">
		<span id="top_title"></span> <span id="top_text" class="txtcolor_lb"></span>
	</div> -->
    <div class="top_r">
        <!--상단_메뉴버튼-->
        <div id="top_menu">
          <ul class="dropdown">
          <? 
          if($data_top){
            foreach($data_top as $key => $val){ 
                if($val['menu_use'] == "1"){
					?>
              <li><i href="<?=$val['menu_url']?>" data-num="<?=$val['menu_idx']?>"><span class="mB_3 mR5"><img src="../img/<?=$val['menu_icon']?>"></span><span class="PL_5"><?=$val['menu_name']?></span></i></li>
          <?
              } 
            }
          }
          ?>
          <div class="dropdown-content">
          <div class="row" id="left_sidebar">
          <ul>
          <?
          foreach($data_top as $key => $val){
            if($val['menu_use'] == "1"){
            ?>
            <div class="column">
            <?
            if($data_in[ $val['menu_idx'] ]){
              foreach($data_in[ $val['menu_idx'] ] as $key2 => $val2){ 
                if($val2['menu_use'] == "1"){
              ?>
                      <li><i href="<?=$val2['menu_url']?>" data-num="<?=$val['menu_idx']?>"><span><i class="fa fa-chevron-right"><span style="vertical-align: top;"><?=$val2['menu_name']?></span></i></span></i></li>
          <?    }  
              }
            }
            ?>
          </div>
          <?
            }
          }
          ?>
          </ul>
          </div>
          </div>
          </ul>
      </div>
  </div>

     <!-- 로그인정보 -->
     <div id="login">
        <span class="aR pB_13 col_mint font_700">현재 시간 </span>
        <i class="fa fa-chevron-right pB_15"></i>
        <span id="now_date" class="pB_13 pL_5 pR_15"><?=date("Y년 n월 j일 H시 i분 s초")?></span>

        <!-- <div id="session" class="pB_13"> -->
        <div id="session" class="">
          <span class="aR col_mint font_700 <? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>">
            <span id="user_id" class="<? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>"> 사용자 : <?=ss_user_id;?></span>
          </span>
            <i class="fa fa-chevron-right pB_15 <? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>"></i>
            <span id="session_time" class="pB_13 pL_5 pR_15 <? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>"></span>
        </div>

        <div class="top_btn">
            <button type="button" class="login_btn <? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>" id="btn_logout">
                <span><img src="../img/top_icon_login.png"></span> <span>로그아웃 </span>
            </button>
            <button type="button" class="login_btn <? if($_COOKIE['set_login'] == 1){ ?>dp0<? } ?>" id="btn_login">
                <span><img src="../img/top_icon_login.png"></span> <span>로그인 </span>
            </button>
            <button type="button" class="layout_btn <? if($_COOKIE['set_login'] != 1){ ?>dp0<? } ?>" id="btn_layout">
                <span><img src="../img/top_icon_layout.png"></span> <span>레이아웃 설정 </span>
            </button>
        </div>
    </div>
  </div>
  <div id="quick_menu" class="mR_20">
    <ul>
        <? 
           if($data_url){
             foreach($data_url as $key => $val){
               if($val['menu_use'] == "1"){
              if($_COOKIE['set_login'] == 1 || $val['login_check'] == 0){ //로그인 돼있을때랑 login_check가 0일때
        ?>
         <li><a href="<?=$val['menu_url']?>" data-num="<?=$val['menu_idx']?>" target='_blank'><span><?=$val['menu_name']?></span></a><span><img src="../img/quick_btn_icon.png"></span></li>
         <? 
                 }else{
        ?>
        <li><a data-num="<?=$val['menu_idx']?>" target='#'><span><?=$val['menu_name']?></span></a><span><img src="../img/quick_btn_icon.png"></span></li>
        <? 
              }
            }
          }
        }
        ?>
    </ul>
  </div>

</div>

<script type="text/javascript">
  // 파라미터 삭제(로그인 target)
  $("i").click(function(){
      history.replaceState({}, null, location.pathname);
  });
</script>