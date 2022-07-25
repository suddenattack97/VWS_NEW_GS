//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 radar.js
//# content : 기상상황판 js 레이더 js
//################################################################################################################################
    function radar(){
        $.ajax({
            type: "POST",
            url: "controll/radar.php",
            cache: false,
            data: { "mode" : "radar"},
            dataType: "json",
            beforeSend: function(data){
                // $(".radar img").attr("src","./img/loddingbar.gif");
                // $(".radar").css("background","./img/loddingbar.gif");
                $(".radar img").css("background-image","url('./img/loddingbar.gif')");
				$(".radar img").css("background-size","150px");
				$(".radar img").css("background-repeat","no-repeat");
				$(".radar img").css("background-position","center");
            },
            complete: function(data){
            },
            success : function(response) {
                var list = response.data;
                    var radar =new Array;
                        $.each(list, function(index, current) {
                            radar.push(current.rader);
                    });

                    $(".ra_tab_color_0").css("background","red");//첫번재 인자값 셋팅
                    //  if(type == 1){
                    //      $(".radar").append("<img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'>");//첫번재 인자값 셋팅
                    //  }

                    // $(".radar").append("<img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'>");//첫번재 인자값 셋팅
                            $(".radar .radar_time").contents().css("background","#fff");
                            // $(".ra_tab_color_"+j).css("background","red");
                            $(".radar img").attr("src",radar[0]);

                            $(".radar img").each(function(n){
                                $(this).error(function(){
                                $(this).attr('src', 'http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0');
                                });
                            });
            }
        });

        setInterval(function() {
            $.ajax({
                type: "POST",
                url: "controll/radar.php",
                cache: false,
                data: { "mode" : "radar"},
                dataType: "json",
                beforeSend: function(data){
                    // $(".radar img").attr("src","./img/loddingbar.gif");
                    $(".radar").css("background-image","url('./img/loddingbar.gif')");
                    $(".radar").css("background-size","150px");
                    $(".radar").css("background-repeat","no-repeat");
                    $(".radar").css("background-position","center");
                },
                complete: function(data){
                },
                success : function(response) {
                var list = response.data;
                    var radar =new Array;
                        $.each(list, function(index, current) {
                            radar.push(current.rader);
                    });

                    $(".ra_tab_color_0").css("background","red");//첫번재 인자값 셋팅
                    //  if(type == 1){
                    //  $(".radar").append("<img class='raderloading' src='http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0' width='100%' height='100%'>");//첫번재 인자값 셋팅
                    //  }
                            $(".radar .radar_time").contents().css("background","#fff");
                            // $(".ra_tab_color_"+j).css("background","red");
                            $(".radar img").attr("src",radar[0]);

                            $(".radar img").each(function(n){
                                $(this).error(function(){
                                $(this).attr('src', 'http://www.weather.go.kr/cgi-bin/rdr_new/nph-rdr_sfc_pty_img?&cmp=SFC&obs=HSR&qcd=PTY&acc=&aws=1&map=HR&color=C4&legend=1&size=640&zoom_level=0&zoom_x=0000000&zoom_y=0000000&ZRa=200&ZRb=1.6&rand=12160&gis=&rnexdisp=0&griddisp=0');
                                });
                            });
                 }
            });
        }, 120000);
    }