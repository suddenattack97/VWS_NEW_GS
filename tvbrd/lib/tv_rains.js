//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 rains.js
//# content : 기상상황판 js 여러지역 rain js
//################################################################################################################################
    function rains(){
        //$.post( "controll/test.php", { "mode" : "locallist" }, function(response) {
         $.post( "controll/rains.php", { "mode" : "rains" }, function(response) {
            var list = response.data;
            var txt;
                var i= 0;
                      $.each(list, function(index, current) {
                          var tmp_name = decodeURIComponent(current.rtuname);
                          tmp_name = (tmp_name.length > 3) ? tmp_name.substring(0, 3) + ".." : tmp_name;
                          txt += "<tr>";
                          //txt += "<td>"+decodeURIComponent(current.rtuname)+"</td>";
                          txt += "<td>"+tmp_name+"</td>";
                          txt += "<td>"+current.rainbeftime+"</td>";
                          txt += "<td>"+current.rainnowtime+"</td>";
                          txt += "<td>"+current.rainday+"</td>";
                          txt += "<td>"+current.rainbefday+"</td>";
                          txt += "<td>"+current.rainmon+"</td>";
                          txt += "</tr>";
                          var prainbeftime = current.prainbeftime;
                          var prainnowtime = current.prainnowtime;
                          var prainbefday = current.prainbefday;
                          var prainday = current.prainday;
                          var prainmon = current.prainmon;
                        i++;
                   });
                 $("#prainbefday").text(response.ddata.prainbefday);
                 $("#prainday").text(response.ddata.prainday);
                 $("#prainmon").text(response.ddata.prainmon);

                 $("#rains").append(txt);
        }, "json");



       // }, "json");
    }

