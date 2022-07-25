var ie_version = 0;

function get_version_of_IE(){ 
	 var word; 
	 var version = "N/A"; 

	 var agent = navigator.userAgent.toLowerCase(); 

	 // IE old version ( IE 10 or Lower ) 
	 if ( navigator.appName == "Microsoft Internet Explorer" ) word = "msie "; 

	 else { 
		 // IE 11 
		 if ( agent.search( "trident" ) > -1 ) word = "trident/.*rv:"; 

		 // Microsoft Edge  
		 else if ( agent.search( "edge/" ) > -1 ) word = "edge/"; 

		 // 그외, IE가 아니라면 ( If it's not IE or Edge )  
		 else return version; 
	 } 

	 var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" ); 

	 if (  reg.exec( agent ) != null  ) version = RegExp.$1 + RegExp.$2; 

	 return version; 
}
ie_version = get_version_of_IE();

if(ie_version == "N/A"){
	// IE가 아닐 경우
}else if(ie_version <= 8){
	location.href = "ie_check.php";
}


