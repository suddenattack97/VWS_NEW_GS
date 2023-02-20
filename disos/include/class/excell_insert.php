<script type="text/javascript">
function excell_insert(excell_address){
	naver.maps.Service.geocode({
        address: excell_address
    }, function(status, response) {
        if (status !== naver.maps.Service.Status.OK) {
            return alert('Something wrong!');
        }
        var result = response.result, // 검색 결과의 컨테이너
            items = result.items; // 검색 결과의 배열
    });
}
</script>