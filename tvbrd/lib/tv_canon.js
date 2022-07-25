//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 canon.js
//# content : 기상상황판 js 태풍 js
//################################################################################################################################
	var setInt_typ = "";
	function initMap(){
		canon();
		
		// 1분에 한번 태풍 업데이트
  		setInt_typ = setInterval(function(){
  			canon();
		}, 60000);
	}
    function canon(){
		$("#map").empty();
    	$.post( "controll/canon.php", { "mode" : "canon" }, function(response) {
            var arr_typ = response.arr_typ;
            
            var map;				// 맵 객체
            var arr_marker = [];	// 마커 객체 집합
        	var arr_circle = [];	// 원 객체 집합 
        	var arr_poly_line = [];	// 선 객체 집합
            
        	// 지도 그리기
    		map = new google.maps.Map(document.getElementById('map'), {
    		    zoom: 5,					 // 지도 확대 정도
    		    center: {lat: 38, lng: 128}, // 처음 화면 중앙 위도, 경도
    		    zoomControl: false,
    		    mapTypeControl: true,
    		    scaleControl: false,
    		    streetViewControl: false,
    		    rotateControl: false,
    		    fullscreenControl: false
    		});

    		$.each(arr_typ, function(key, val){
    			var tmp_arr_data = []; // 기초 데이터: 위도, 경도, 타이틀, 상태(0: 과거, 1: 현재, 2: 예상), 반지름
    			$.each(val, function(key2, val2){
    				tmp_arr = [ val2['typLat'], val2['typLon'], val2['typName'], val2['state'], val2['typ15'], val2['typTm'] ];
    				tmp_arr_data.push(tmp_arr);
    			});
        		add_typhoon(tmp_arr_data);
        		//console.log(tmp_arr_data); // 콘솔 체크용
    		}); 
        	
    		// 태풍 표시 함수
    		function add_typhoon(arr_data){
        	    // 마커 그리기
        		var marker = new Array(arr_data.length);
        	 	for(var i = 0; i < arr_data.length; i++){
        		 	var data = arr_data[i];
        		 	var img;
        		 	if(data[3] == 1){ 		// 현재
        	 			img = new google.maps.MarkerImage(
        		 			"./img/cyclone.gif", 
        		 			null,
        		 			null, // google.maps.Size(0, 0),
        	 				new google.maps.Point(22, 22),
        	 				new google.maps.Size(46, 46)
        		 		);
        	 		}else if(data[3] == 0){ // 과거
        	 			img = new google.maps.MarkerImage(
        	 				"./img/befor_cyclone.png", 
        	 				null,
        	 				null, // google.maps.Size(0, 0),
        	 				new google.maps.Point(6, 8),
        	 				new google.maps.Size(15, 15)
        	 			);
        	 		}else if(data[3] == 2){ // 예상
        	 			img = new google.maps.MarkerImage(
        		 				"./img/after_cyclone.png", 
        		 				null,
        		 				null, // google.maps.Size(0, 0),
        		 				new google.maps.Point(6, 8),
        		 				new google.maps.Size(15, 15)
        		 		);
        	 		}
        		 	marker[i] = new google.maps.Marker({
        	 			map: map,
        	 			//icon: "/img/grn-pushpin.png", // 마커 이미지
        				icon: img,
        	 			animation: google.maps.Animation.DROP, // 드롭 애니메이션
        	 			optimized: false, // (optimized false 없이 false로 하면 gif 작동 안 함)
        	 			draggable: false, // 마커 드래그 이동 여부
        	 		    position: {lat: Number(data[0]), lng: Number(data[1])},
        	 		    //title: data[2] // 마우스오버 텍스트
        			});
        		 	markerListener(marker[i]); // 마커 이벤트 객체 전달
        	 	}
        		// 원 그리기
        		var circle = new Array(arr_data.length);
        	 	for(var i = 0; i < arr_data.length; i++){
        	 		var data = arr_data[i];
        	 		var color = "";		// 테두리, 내부 색깔
        	 		var in_opacity = 0;	// 내부 투명도
        	 		if(data[3] == 1){ 		// 현재
        	 			color = "#FF0000";
        	 			in_opacity = 0.5;
        	 		}else if(data[3] == 0){ // 과거
        	 			color = "#666666";
        	 			in_opacity = 0.3;
        	 		}else if(data[3] == 2){ // 예상
        	 			color = "#FF33FF";
        	 			in_opacity = 0.3;
        	 		}
        			circle[i] = new google.maps.Circle({
        				map: map,
        				strokeColor: color, 					// 테두리 색깔
        			    strokeOpacity: 0.3, 					// 테두리 투명도
        			    strokeWeight: 3, 						// 테두리 굵기
        			    fillColor: color, 						// 내부 색깔
        			    fillOpacity: in_opacity, 				// 내부 투명도
        			    center: {lat: Number(data[0]), lng: Number(data[1])},	// 위도, 경도
        			    radius: Math.sqrt(data[4]) * 100		// 반지름
        			});
        			circleListener(circle[i], data[2]); // 원 이벤트 객체 전달
        	 	}
        	 	// 선 그리기
        	 	var poly_line_path = new Array(arr_data.length);
        	 	for(var i = 0; i < arr_data.length; i++){
        	 		var data = arr_data[i];
        	 		poly_line_path[i] = {lat: Number(data[0]), lng: Number(data[1])};
        	 	}
        		var poly_line = new google.maps.Polyline({
        		    strokeColor: '#FF0000', 	// 선 색깔
        		    strokeOpacity: 0.8, 		// 선 투명도
        		    strokeWeight: 2, 			// 선 굵기
        		    geodesic: false, 			// 포물선 여부
        		    path: poly_line_path		// 위도, 경도
        		});
        		poly_line.setMap(map);
        		// 객체 집합 삽입
        		arr_marker.push(marker);
        		arr_circle.push(circle);
        		arr_poly_line.push(poly_line);
        	}	
        	
        	// 마커 이벤트
        	function markerListener(this_maker){      
        		google.maps.event.addListener(this_maker, 'click', function(){
        			// 마커 애니메이션 
         			if(this_maker.getAnimation() !== null){
         				this_maker.setAnimation(null); // 애니메이션 중지
         			}else{
         				this_maker.setAnimation(google.maps.Animation.BOUNCE); // 바운스 애니메이션
         			}
        		});
        	}
        	// 원 이벤트
        	var infowindow = "";
        	function circleListener(this_circle, txt){      
        		google.maps.event.addListener(this_circle, 'click', function(){
        		});      
        		google.maps.event.addListener(this_circle, 'mouseover', function(){
        			infowindow = new google.maps.InfoWindow({ 
        				content: txt,
        				size: new google.maps.Size(50,50)
        			});
        			infowindow.setPosition(this_circle.getCenter());
        			infowindow.open(map);
        		});   
        		google.maps.event.addListener(this_circle, 'mouseout', function(){
        			infowindow.close(map);
        		});
        	}
        	
        	// 태풍별 show, hide
        	function view_typhoon(idx){
        		var this_marker = arr_marker[idx];
        		var this_circle = arr_circle[idx];
        		var this_poly_line = arr_poly_line[idx];
        		// 마커 숨기기
        		for(var i = 0; i < this_marker.length; i++){
        			if(this_marker[i].getMap() != null){
        				this_marker[i].setMap(null);
        			}else{
        				this_marker[i].setMap(map);
        			}
        		}
        		// 원 숨기기
        		for(var i = 0; i < this_circle.length; i++){
        			if(this_circle[i].getMap() != null){
        				this_circle[i].setMap(null);	
        			}else{
        				this_circle[i].setMap(map);	
        			}
        		}
        		// 선 숨기기
        		if(this_poly_line.getMap() != null){
        			this_poly_line.setMap(null);
        		}else{
        			this_poly_line.setMap(map);
        		}
        	}
        	// 전체 태풍 show, hide
        	function view_all_typhoon(){
        		var this_marker = arr_marker;
        		var this_circle = arr_circle;
        		var this_poly_line = arr_poly_line;
        		var on_marker = false; 
        		var on_circle = false;
        		var on_poly_line = false;
        		// 온 체크
        		for(var i = 0; i < this_marker.length; i++){
        			for(var j = 0; j < this_marker[i].length; j++){
        				if(this_marker[i][j].getMap() != null){
        					on_marker = true;
        				}
        			}
        		}
        		for(var i = 0; i < this_circle.length; i++){
        			for(var j = 0; j < this_circle[i].length; j++){
        				if(this_circle[i][j].getMap() != null){
        					on_circle = true;
        				}
        			}
        		}
        		for(var i = 0; i < this_poly_line.length; i++){
        			if(this_poly_line[i].getMap() != null){
        				on_poly_line = true;
        			}
        		}
        		// 마커 숨기기
        		for(var i = 0; i < this_marker.length; i++){
        			for(var j = 0; j < this_marker[i].length; j++){
        				if(on_marker){
        					this_marker[i][j].setMap(null);
        				}else{
        					this_marker[i][j].setMap(map);
        				}
        			}
        		}
        		// 원 숨기기
        		for(var i = 0; i < this_circle.length; i++){
        			for(var j = 0; j < this_circle[i].length; j++){
        				if(on_circle){
        					this_circle[i][j].setMap(null);	
        				}else{
        					this_circle[i][j].setMap(map);	
        				}
        			}
        		}
        		// 선 숨기기
        		for(var i = 0; i < this_poly_line.length; i++){
        			if(on_poly_line){
        				this_poly_line[i].setMap(null);
        			}else{
        				this_poly_line[i].setMap(map);
        			}
        		}
        	}
        	
        }, "json");
    }

    $(document).ready(function(){
    	//$("#sel_typ").select2();
    });
	$("#sel_btn").click(function(){
		$("form").submit();
	});

