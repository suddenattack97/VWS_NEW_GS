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
            // $(".heroes img").attr("src","./img/loddingbar.gif");
            $(".heroes").css("background-image","url('./img/loddingbar.gif')");
            $(".heroes").css("background-size","150px");
            $(".heroes").css("background-repeat","no-repeat");
            $(".heroes").css("background-position","center");
        },
        complete: function(data){
        },
        success : function(response) {
          var list = response.data;
              var heroes =new Array;
                  $.each(list, function(index, current) {
                        heroes.push(current);
                });
              $(".he_tab_color_0").css("background","red");//첫번재 인자값 셋팅
              // $(".heroes").append("<img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'>");//첫번재 인자값 셋팅
              $(".heroes .heroes_time").contents().css("background","#fff");
              $(".heroes img").attr("src",heroes[0]);

                        $(".heroes img").each(function(n){
                            $(this).error(function(){
                                $(".heroes img").attr("src",response.data[response.data.length-1]);
                             });
                          });
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
                // $(".heroes img").attr("src","./img/loddingbar.gif");
                $(".heroes").css("background-image","url('./img/loddingbar.gif')");
                $(".heroes").css("background-size","150px");
                $(".heroes").css("background-repeat","no-repeat");
                $(".heroes").css("background-position","center");
              },
            complete: function(data){
            },
            success : function(response) {
              var list = response.data;
                  var heroes =new Array;
                    $.each(list, function(index, current) {
                        heroes.push(current);
                    });
                  $(".he_tab_color_0").css("background","red");//첫번재 인자값 셋팅

                          $(".heroes .heroes_time").contents().css("background","#fff");
                          $(".heroes img").attr("src",heroes[0]);

                            $(".heroes img").each(function(n){
                                $(this).error(function(){
                                  $(".heroes img").attr("src",response.data[response.data.length-1]);
                                });
                            });
               }
            });
        }, 120000);

    }


