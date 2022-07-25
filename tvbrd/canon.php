<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>태풍 테스트</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #floating-panel {
      	display: none;
	  	position: absolute;
		top: 70px;
	  	left: 25%;
	  	z-index: 5;
	  	background-color: #fff;
	  	padding: 2px;
	  	border: 1px solid #999;
	  	text-align: center;
	  	font-family: 'Roboto','sans-serif';
	  }
	  .gmnoprint{
	  	left: 60px !important;
	  }
    </style>
	<script src="js/jquery-1.12.1.min.js"></script>
    <script src="js/excanvas.min.js"></script>
	<script src="js/select2.min.js"></script>
    <link href="css/select2.min.css" rel="stylesheet" type="text/css">
	<script src="lib/tv_canon.js"></script>
  </head>
  <body>
  	
  	<!--  
  	<form name="frm" method="post">
  		<div id="floating-panel">
	  		태풍 선택 <select id="sel_typ" name="sel_typ[]" multiple="multiple" style="width: 200px;">
	  		<?/* foreach($arr_sel_typ as $key => $val){ */?>
	  		<option value="<?/*=$val['year']."/".$val['typSeq']*/?>" <?/*if(in_array($val['year']."/".$val['typSeq'], $sel_typ)) echo "selected" */?> ><?/*=$val['typName']*/?></option>
	  		<?/* } */?>
	  		</select>
	  		<button type="button" id="sel_btn">검색</button>
	  		
	  		<?/* if(count($sel_typ) > 1){ */?>
		    <input onclick="view_all_typhoon();" type=button value="전체">
		    <?/* } */?>
		    <?/* for($i = 0; $i < count($sel_typ); $i ++){ */?>
	      	<input onclick="view_typhoon(<?/*=$i*/?>);" type=button value="<?/*=$i+1*/?>번">
	      	<?/* } */?>
		</div>
    </form>
    -->
    
    <div id="map"></div>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxj7vZss24mUCykYlbVLA7Bkmx88zJ9CU&callback=initMap"></script>
    
  </body>
</html>