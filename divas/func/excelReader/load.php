<?
header("Content-Type: text/html; charset=UTF-8");

error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader.php';

$type = ($_REQUEST['type']) ? $_REQUEST['type'] : 1;
if($type == 1){
	$file = "../../_files/sms/".$_REQUEST['file'];
}else if($type == 2){
	$file = "../../_files/sample/".$_REQUEST['file'];
}
$data = new Spreadsheet_Excel_Reader($file);
?>
<html>
<head>

<script type="text/javascript" src="../../js/jquery-1.11.1.min.js"></script>
<style>
.w100{width:100%;}
.w15{width:15%;}
.w20{width:20%;}
.w40{width:40%;}
.w50{width:50%;}

.w10{width:10% !important;}
.w60{width:60% !important;}
.fL{float:left;}
.fR{float:right;}

.sheets{padding-right:5px;}

.hh{}/*ul 마우스오버 컬러 처리용*/
.hh:hover{background:#f4f6f9 !important; }

.excel_top{width:100%; padding:5px 0; background:#666; text-align:right; }

table.excel {
	border: 0;
	border-collapse: collapse;
	font-family: sans-serif;
	font-size: 12px;
	width:100%;
}
table.excel thead th, table.excel tbody th {
	background: #eee;
	border: 1px inset #ccc;
	vertical-align: bottom;
	text-align: center;
	
}
table.excel thead th{
	border-bottom:1px solid #999;
}
table.excel tbody tr:hover{
	background:#f4f6f9;
}
	
table.excel tbody th {
	vertical-align: middle;
	text-align: center;
	width: 20px;
	height:22px;
}
table.excel tbody td {
	vertical-align: middle;
	border: 1px solid #eee;
	color: #969696;
}
table.excel tbody td.center {
	text-align: center;
}
table.excel tbody td.red input {
	color: #f00;
	
}
table.excel input {
	font-family: sans-serif;
	font-size: 12px;
	border:0;
	width:100%;
	background:none;
}
table.bg_yellow thead th, table.bg_yellow tbody th {
	background-color: #d0e1f1 !important;
}
.btn_lbs {
    display: inline-block;
    background-color: #e1eef5;
    border: 1px solid #b8d9f0;
    padding: 0px 3px 0px 3px;
    color: #2466e0;
    font-size: 12px;
    height: 20px;
    line-height: 20px;
}
.btn_lbs:hover {
    cursor: pointer;
    background-color: #b8d9f0;
    border: 1px solid #9cc5e2;
}
table .dp0 {
	display: none;
}
</style>

</head>
<body>

<form id="excel_frm" name="excel_frm">
	<div class="w100">
		<div class="excel_top">
		    <div class="sheets">
		    <?
			for($i = 0; $i < count($data->sheets); $i ++){
				$tmp_num = $i+1;
			?>
				<span id="btn_<?=$i?>" class="btn_lbs">Sheet<?=$tmp_num?></span>
			<? 
			}
			?>
		    </div>
	    </div>
		<div id="send_table" class="w50 fL">
			<table class="excel bg_yellow" cellspacing="0">
				<thead>
					<tr>
						<th style="width:20px;"></th>
						<th class="w15">회신번호</th>
						<th class="w15">수신번호</th>
						<th class="w40">메세지</th>
						<th style="width:40px;">길이</th>
						<th class="w20">오류</th>
					</tr>
				</thead>
				<tbody>
			<? for($i = 0; $i < 10; $i ++){ 
					$tmp_num = $i+1;
			?>
					<tr>
						<th><?=$tmp_num?></th>
						<td class="center" style="height:22px;">
							<input type="text" id="NUM_FROM_<?=$tmp_num?>" name="NUM_FROM[]" readonly>
						</td>
						<td class="center">
							<input type="text" id="NUM_TO_<?=$tmp_num?>" name="NUM_TO[]" readonly>
						</td>
						<td class="center">
							<input type="text" id="MSG_STR_<?=$tmp_num?>" name="MSG_STR[]" readonly>
						</td>
						<td class="center">
							<input type="text" id="MSG_LEN_<?=$tmp_num?>" name="MSG_LEN[]" readonly>
						</td>
						<td class="center red">
							<input type="text" id="ERR_STR_<?=$tmp_num?>" name="ERR_STR[]" readonly>
						</td>
					</tr>
			<? } ?>
				</tbody>
			</table>    
	    </div>
	    <div id="view_table" class="w50 fR">
	    	<?=$data->dump(true,true,0)?>
	    </div>
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	<?
	for($i = 0; $i < count($data->sheets); $i ++){
	?>
	$("#btn_<?=$i?>").click(function(){
		var dump = '<?=str_replace("\n", "", $data->dump(true,true,$i))?>';
		$("#view_table").empty();
		$("#view_table").append(dump);
	});
	<?
	}
	?>
});
</script>

</body>
</html>


