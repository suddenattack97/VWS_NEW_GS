function danger(){
	$.post( "controll/event.php", { "mode" : "danger_check" }, function(response) {
		if(response.RAIN_CANCEL){
			$.each(response.RAIN_CANCEL, function(index, item){
				rain_event(item,0,0);
			});
		}
		if(response.RAIN_WARNING){
			$.each(response.RAIN_WARNING, function(index, item){
				rain_event(item,1,1);
			});
		}
		if(response.RAIN_DANGER){
			$.each(response.RAIN_DANGER, function(index, item){
				rain_event(item,1,2);
			});
		}


		if(response.FLOW_CANCEL){
			$.each(response.FLOW_CANCEL, function(index, item){
				flow_event(item,0,0);
			});
		}
		if(response.FLOW_WARNING){
			$.each(response.FLOW_WARNING, function(index, item){
				flow_event(item,1,1);
			});
		}
		if(response.FLOW_DANGER){
			$.each(response.FLOW_DANGER, function(index, item){
				flow_event(item,1,2);
			});
		}


		if(response.SNOW_CANCEL){
			$.each(response.SNOW_CANCEL, function(index, item){
				snow_event(item,0,0);
			});
		}
		if(response.SNOW_WARNING){
			$.each(response.SNOW_WARNING, function(index, item){
				snow_event(item,1,1);
			});
		}
		if(response.SNOW_DANGER){
			$.each(response.SNOW_DANGER, function(index, item){
				snow_event(item,1,2);
			});
		}


		if(response.AWS_CANCEL){
			$.each(response.AWS_CANCEL, function(index, item){
				aws_event(item,0,0);
			});
		}
		if(response.AWS_WARNING){
			$.each(response.AWS_WARNING, function(index, item){
				aws_event(item,1,1);
			});
		}
		if(response.AWS_DANGER){
			$.each(response.AWS_DANGER, function(index, item){
				aws_event(item,1,2);
			});
		}
	}, "json");
}