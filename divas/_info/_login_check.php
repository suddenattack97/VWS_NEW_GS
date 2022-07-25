<? 
if(!$_SESSION['is_login'] == 1){ 
?>
<script>
	//login();
</script>

<div id="right">
	<div id="content">
		로그인이 필요한 페이지 입니다. 우측 상단에 로그인 버튼이 있습니다.
	</div>
</div>
<? 
	exit;
} 
?>