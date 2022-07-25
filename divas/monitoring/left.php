<?
require_once "../_conf/_common.php";
require_once "../_info/_set_setting.php";
require_once "./head.php";
?>
	<div id="left_sidebar">
		<!--메뉴리스트-->
		<ul>
		<? 
		if($data_top){
			foreach($data_top as $key => $val){ 
				if($val['menu_idx'] < 7){
					$margin = '';
				}else{
               $notMenuPx = 0; 
               if($data_in[ $val['menu_idx'] ]){
                  foreach($data_in[ $val['menu_idx'] ] as $key2 => $val2){ 
                     if($val2['menu_use'] != "1"){
                        $notMenuPx = $notMenuPx + 45;
                     }
                  }
                }
					$px = 45 * count( $data_in[ $val['menu_idx'] ] ) - $notMenuPx;
					$margin = ' style="margin-top: -'.$px.'px" ';
				}
				if($val['menu_use'] == "1"){
					if($val['menu_idx'] != "7"){
				?>
					<li id="left_<?=$val['menu_idx']?>" class="act">
						<i href="<?=$val['menu_url']?>" data-num="<?=$val['menu_idx']?>"><div><img src="../images/<?=$val['menu_icon']?>" /></div><?=$val['menu_name']?></i>
						<div class="left_for" <?=$margin?>>
						<ul>
						
						<? 
						if($data_in[ $val['menu_idx'] ]){
							foreach($data_in[ $val['menu_idx'] ] as $key2 => $val2){ 
								if($val2['menu_use'] == "1"){
						?>
							<li><i href="<?=$val2['menu_url']?>" data-num="<?=$val['menu_idx']?>"><?=$val2['menu_name']?></i></li>
						<? 
								}
							}
						}
						?>	
						</ul>
					</div>
					</li>
				<? 
					}else{
				?>
					<li id="left_<?=$val['menu_idx']?>" class="act">
						<i href="<?=$val['menu_url']?>" data-num="<?=$val['menu_idx']?>" onclick="cookieCheck(0)"><div><img src="../images/<?=$val['menu_icon']?>" /></div><?=$val['menu_name']?></i>
						<div class="left_for" <?=$margin?>>
						<ul>
						
						<? 
						if($data_in[ $val['menu_idx'] ]){
							$tmp_idx = 1; // index
							foreach($data_in[ $val['menu_idx'] ] as $key2 => $val2){ 
								if($val2['menu_use'] == "1"){
						?>
							<li><i href="<?=$val2['menu_url']?>" data-num="<?=$val['menu_idx']?>" onclick="cookieCheck(<?=$tmp_idx?>)"><?=$val2['menu_name']?></i></li>
						<? 
								$tmp_idx++;
								}
							}
						}
						?>	
						</ul>
					</div>
					</li>
				<? 
					}
				}
			}
		}
		?>	
		</ul>
		<!--메뉴리스트끝-->
	</div>
	<script type="text/javascript">

      //쿠키 가져오기 함수
      function getCookie(cName) {
         cName = cName + '=';
         var cookieData = document.cookie;
         var start = cookieData.indexOf(cName);
         var cValue = '';
         if(start != -1){
            start += cName.length;
            var end = cookieData.indexOf(';', start);
            if(end == -1)end = cookieData.length;
            cValue = cookieData.substring(start, end);
         }
         return unescape(cValue);
      }
      //체크 후 주소변경
      function cookieCheck(data){
		  var checkLogin = getCookie("set_login");
		  // 환경설정 li의 id 값 = left_7 다를때 변경해줘야 함.
		  var addr = $("#left_7 i").eq(data).attr("href");
		  
		  if(checkLogin != "1"){
			  if(addr.substr(0,5) != "login"){
               addr = addr.substring(0, addr.length-4);
               $("#left_7 i").eq(data).attr("href", "login.php?target=" + addr);
            }
         }else{
            var idx = addr.indexOf("=");
            if(idx != -1){
               addr = addr.substring(idx+1);
               $("#left_7 i").eq(data).attr("href", addr+".php");    
            }
         }
      }
   </script>