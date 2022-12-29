//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 heroes.js
//# content : 기상상황판 js 위성 js
//################################################################################################################################
function heroes(){
  $.ajax({
    type: "POST",
    url: "controll/heroes.php",
    cache: false,
    data: { "mode" : "heroes"},
    dataType: "json",
    beforeSend: function(data){
    },
    complete: function(data){
      $(".heroes img").each(function(n){
        $(this).error(function(){
          $(".heroes img").attr("src","./img/heroes/def_sat.png");
        });
      });
    },
    success : function(response) {
      var list = response.data;
      $(".heroes img").attr("src","./img/heroes/def_sat.png");
      var heroes = list.heroes;
          // var heroes =new Array;
          //     $.each(list, function(index, current) {
          //           heroes.push(current);
          //   });
          $(".he_tab_color_0").css("background","red");//첫번재 인자값 셋팅
          // $(".heroes").append("<img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'>");//첫번재 인자값 셋팅
          $(".heroes .heroes_time").contents().css("background","#fff");
          // console.log("heroes : ", heroes);
          if(heroes.length > 15) $(".heroes img").attr("src","./img/heroes/"+heroes);
          // $(".heroes img").attr("src",heroes[0]);

    }
  });

    setInterval(function() {
      $.ajax({
        type: "POST",
        url: "controll/heroes.php",
        cache: false,
        data: { "mode" : "heroes"},
        dataType: "json",
        beforeSend: function(data){
        },
        complete: function(data){
          $(".heroes img").each(function(n){
            $(this).error(function(){
              $(".heroes img").attr("src","./img/heroes/def_sat.png");
            });
          });
        },
        success : function(response) {
          var list = response.data;
          var heroes = list.heroes;
          // var heroes =new Array;
          //   $.each(list, function(index, current) {
          //       heroes.push(current);
          //   });
          $(".he_tab_color_0").css("background","red");//첫번재 인자값 셋팅
          $(".heroes .heroes_time").contents().css("background","#fff");
          var dt = new Date();
          var str1 = dt.getFullYear()+'년 '+(dt.getMonth()+1)+'월 '+dt.getDate()+'일 '+dt.getHours()+'시 '+dt.getMinutes()+'분';
          // console.log(str1+" heroes : ", heroes);
          if(heroes.length > 15) $(".heroes img").attr("src","./img/heroes/"+heroes);
         
       }
    });
}, 60000);

}


