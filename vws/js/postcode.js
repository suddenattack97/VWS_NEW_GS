    // �����ȣ ã�� ã�� ȭ���� ���� element
    var element_wrap = document.getElementById('wrap');

    function foldDaumPostcode() {
        // iframe�� ���� element�� �Ⱥ��̰� �Ѵ�.
        element_wrap.style.display = 'none';
    }

    function postcode(ver) {
        // ���� scroll ��ġ�� �����س��´�.
        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
        new daum.Postcode({
            oncomplete: function(data) {
                // �˻���� �׸��� Ŭ�������� ������ �ڵ带 �ۼ��ϴ� �κ�.

                // �� �ּ��� ���� ��Ģ�� ���� �ּҸ� �����Ѵ�.
                // �������� ������ ���� ���� ��쿣 ����('')���� �����Ƿ�, �̸� �����Ͽ� �б� �Ѵ�.
                var jibunaddr ='';
                var roadaddr = ''; // �ּ� ����
                var extraAddr = ''; // �����׸� ����
				//var ver = '';

                //����ڰ� ������ �ּ� Ÿ�Կ� ���� �ش� �ּ� ���� �����´�.
                if (data.userSelectedType === 'R') { // ����ڰ� ���θ� �ּҸ� �������� ���
                    
                    roadaddr = data.roadAddress;
                } else { // ����ڰ� ���� �ּҸ� �������� ���(J)
                    jibunaddr = data.jibunAddress;
                }

                // ����ڰ� ������ �ּҰ� ���θ� Ÿ���϶� �����׸��� �����Ѵ�.
                if(data.userSelectedType === 'R'){
                    // ���������� ���� ��� �߰��Ѵ�. (�������� ����)
                    // �������� ��� ������ ���ڰ� "��/��/��"�� ������.
                    if(data.bname !== '' && /[��|��|��]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // �ǹ����� �ְ�, ���������� ��� �߰��Ѵ�.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // ǥ���� �����׸��� ���� ���, ��ȣ���� �߰��� ���� ���ڿ��� �����.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // ���յ� �����׸��� �ش� �ʵ忡 �ִ´�.
                    //document.getElementById("sample3_extraAddress").value = extraAddr;
                
                } else {
                    //document.getElementById("sample3_extraAddress").value = '';
                }

                // �����ȣ�� �ּ� ������ �ش� �ʵ忡 �ִ´�.

				if(ver == 1){
                console.log(1);
                document.getElementById('COPR_ADDRESS1').value = jibunaddr;
                document.getElementById("COPR_ADDRESS2").value = roadaddr;
				}
				
				if(ver == 2){
                document.getElementById('BUSINESS_ADDRESS1').value = jibunaddr;
                document.getElementById("BUSINESS_ADDRESS2").value = roadaddr;
				}

                // Ŀ���� ���ּ� �ʵ�� �̵��Ѵ�.
                //document.getElementById("sample3_detailAddress").focus();

                // iframe�� ���� element�� �Ⱥ��̰� �Ѵ�.
                // (autoClose:false ����� �̿��Ѵٸ�, �Ʒ� �ڵ带 �����ؾ� ȭ�鿡�� ������� �ʴ´�.)
                element_wrap.style.display = 'none';

                // �����ȣ ã�� ȭ���� ���̱� �������� scroll ��ġ�� �ǵ�����.
                document.body.scrollTop = currentScroll;
            },
            // �����ȣ ã�� ȭ�� ũ�Ⱑ �����Ǿ����� ������ �ڵ带 �ۼ��ϴ� �κ�. iframe�� ���� element�� ���̰��� �����Ѵ�.
            onresize : function(size) {
                element_wrap.style.height = size.height+'px';
            },
            width : '100%',
            height : '100%'
        }).embed(element_wrap);

        // iframe�� ���� element�� ���̰� �Ѵ�.
        element_wrap.style.display = 'block';
    }