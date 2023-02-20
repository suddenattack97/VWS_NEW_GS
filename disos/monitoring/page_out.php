<?
require_once "../_conf/_common.php";
require_once "./head.php";
?>

<script type="text/javascript">
$(document).ready(function(){
	// if(doubleSubmitFlag){
	// }else{
		swal({
			title: "체크",
			text: "권한이 없습니다.",
			type: "warning",
			confirmButtonText: '확인',
			value: true,
		}, function(value){
			if(value){
			location.href="./tms_main.php";
			}
		});

		// alert("권한이 없습니다.");
		// history.go(-2);
	// }
});
</script>
	
</body>
</html>


