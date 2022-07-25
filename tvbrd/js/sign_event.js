//################################################################################################################################
//# date : 20161111
//# title : 기상상황판 tv_sign_event.js
//# content : 기상상황판 js 문자전광판 효과
//################################################################################################################################

var stop_dup = [];
function sign_event(kind, sub_id, select, arr_event){
	//console.log("sign_event()");
	clearTimeout(stop_dup[sub_id]);
	if(typeof arr_event == "undefined") return false;
	
	function sign_event_view(i){
		//console.log(arr_sub_rtu[sub_id]['sub_name'], kind, i);
		
		var num = Number(arr_event[sub_id][i]['msgAction']);
		if(kind == 0){
			if(arr_event[sub_id][i]['success'] != 3) num = 0;
			
			var add_class = "t"+arr_event[sub_id][i]['modX']; // t10, t12
			$("#sign_"+sub_id).removeClass("t10");
			$("#sign_"+sub_id).removeClass("t12");
			$("#sign_"+sub_id).addClass(add_class);
			if(arr_event[sub_id][i]['modX'] == 10) arr_sub_rtu[sub_id]['overlay'].setXAnchor(85);
			else if(arr_event[sub_id][i]['modX'] == 12) arr_sub_rtu[sub_id]['overlay'].setXAnchor(99);
			
			if(arr_event[sub_id][i]['modY'] == 1){
				$("#sign_"+sub_id+" .label_dat").css("height", "23px");
			}else if(arr_event[sub_id][i]['modY'] == 2){
				$("#sign_"+sub_id+" .label_dat").css("height", "40px");
			}
			
			var tmp_height = Number( arr_sub_rtu[sub_id]['overlay'].getHeight().replace(/[^0-9]/g,'') ) + 37;
			arr_sub_rtu[sub_id]['overlay'].setYAnchor(tmp_height);
			
			//console.log(i + ": " + arr_event[sub_id][i]['box_content']);
			$("#sign_"+sub_id+" .rwrap").html(arr_event[sub_id][i]['box_content']);
		}
		switch(num){
			case 0: stop_stream(select); break;
			case 1: left_stream(select); break;
			case 2: right_stream(select); break;
			case 3: up_left_stream(select); break;
			case 4: down_left_stream(select); break;
			case 5: flash_left_stream(select); break;
			case 6: flash_right_stream(select); break;
			case 7: red_green_stream(select); break;
			case 8: curtain_in_stream(select); break;
			case 9: curtain_out_stream(select); break;
			case 10: curtain_heigh_stream(select); break;
			case 11: width_mod_stream(select); break;
			case 12: sparay_stream(select); break;
			case 13: blind_stream(select); break;
			case 14: laser_stream(select); break;
			case 15: right_view_stream(select); break;
		}
	} // sign_event_view(i) end
	
	var max_i = arr_event[sub_id].length;
	
	var i = 0;
	sign_event_view(i);
	
	/* 정지 흐름 */
	function stop_stream(select){
		stop_dup[sub_id] = setTimeout(function(){
			i++;
			if(i < max_i){
				sign_event_view(i);
			}else{
				i = 0;
				sign_event_view(i);
			}
		}, 5000);
	}
	
	/*좌 흐름*/
	function left_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*우 흐름*/
	function right_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}
	}
	
	/*상좌 흐름*/
	function up_left_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 1800,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'up',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 1800,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'up',
			    duplicated: false
			});
		}
	}
	
	/*하좌 흐름*/
	function down_left_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 1800,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'down',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 1800,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'down',
			    duplicated: false
			});
		}
	}
	
	/*깜박 왼쪽흐름*/
	function flash_left_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
			//$(select+" .js-marquee").addClass("sign_effect_blink");
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
			//$(select+" .js-marquee span").addClass("sign_effect_blink");
		}
	}
	
	/*깜박오른쪽 흐름*/
	function flash_right_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}
	}
	
	/*적녹반전 흐름*/
	function red_green_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*커튼인 흐름*/
	function curtain_in_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*커튼아웃 흐름*/
	function curtain_out_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*세로커튼인 흐름*/
	function curtain_heigh_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*가로모듈 흐름*/
	function width_mod_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*스프레이 흐름*/
	function sparay_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*블라인드 흐름*/
	function blind_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*레이져 흐름*/
	function laser_stream(select){  
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'left',
			    duplicated: false
			});	
		}
	}
	
	/*오른쪽으로 흐름*/
	function right_view_stream(select){
		if(kind == 0){
			$(select).bind('finished', function(){
				i++;
				if(i < max_i){
					sign_event_view(i);
				}else{
					i = 0;
					sign_event_view(i);
				}
			})
			.marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}else{
			$(select).marquee({
			    duration: 4000,
			    gap: 50,
			    delayBeforeStart: 0,
			    direction: 'right',
			    duplicated: false
			});	
		}
	}
	
}