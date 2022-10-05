var gen = {};

// ==========================================================================
// 일반 조작 함수
// ==========================================================================

// 리다이렉트
gen.redirect = function(target)
{
    document.location.href = target;
}

// 숫자에 콤마 붙이기
gen.addComma = function(value)
{
	let nums = gen.getNumber(value);
	let parts = nums.toString().split(".");
	return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts.length > 1 ? "." + parts[1] : "");
}

// 숫자만 추출
gen.getNumber = function(value)
{
   return value.toString().replace(/[^0-9.]/g,'');
}

// 파일 용량 출력 포맷
gen.getSizeFormat = (size) =>
{
    let strSize = size;
    if(size > 1000000000)
    {
        strSize = (size/(1024*1024*1024)).toFixed(1) + " GB";
    }
    else if(size > 1000000)
    {
        strSize = (size/(1024*1024)).toFixed(1) + " MB";
    }
    else if(size > 1000)
    {
        strSize = (size/(1024)).toFixed(1) + " KB";
    }
    else
    {
        strSize = size + " B";
    }
    return strSize;
}

// 임의의 문자열 생성 : length(문자열길이)
gen.getRandomString = (length = 20) =>
{
    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result1= ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ )
    {
        result1 += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result1;
}

// 바이트 측정
gen.byteLength = (value) =>
{
    let len = 0;
    for(var idx=0; idx < value.length; idx++)
	{
        var c = escape(value.charAt(idx));
        if( c.length===1 ) len ++;
        else if( c.indexOf("%u")!==-1 ) len += 2;
        else if( c.indexOf("%")!==-1 ) len += c.length/3;
    }
    return len;
}

// 화면사이즈에 따른 모드
gen.screenMode = () =>
{
    if(window.innerWidth < 768)
    {
        return 'mobile';
    }
    else if(window.innerWidth > 1279)
    {
        return 'pc';
    }else{
        return 'tablet';
    }
}

//전화번호 변환 (미완성중)
gen.makePhoneNumber = (value) =>
{
	return value;
}

//클립보드 복사
gen.copyToClipBoard = (value) =>
{
    var dummy   = document.createElement("input");
    var text    = value;

    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
    alert('복사되었습니다.');
}

//쿠키생성
gen.setCookie = (name, value, exp = false) =>
{
    var date = new Date();
    if(exp === false)
    {
        document.cookie = name + '=' + value + ';path=/';
    }else{
        date.setTime(date.getTime() + exp*24*60*60*1000);
        document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
    }
}
//쿠키취득
gen.getCookie = (name) =>
{
    var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return value? value[2] : null;
}
//쿠키삭제
gen.removeCookie = (name) =>
{
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

//다음 주소 검색
gen.StartDaumAddress = (zipName, add1Name, add2Name) =>
{
	daum.postcode.load(function(){
        new daum.Postcode({
            oncomplete: function(data) {
				var fullAddr = '';
				var extraAddr = '';

				if(data.userSelectedType === 'R')
				{
					fullAddr = data.roadAddress;
				}else{
					fullAddr = data.jibunAddress;
				}


				if(data.userSelectedType === 'R')
                {
                    if(data.bname !== '')
                    {
                        extraAddr += data.bname;
                    }
                    if(data.buildingName !== '')
                    {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
	    			fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
				}

				$("input[name=" + zipName + "]").val(data.zonecode);
				$("input[name=" + add1Name + "]").val(data.roadAddress);
				$("input[name=" + add2Name + "]").focus();
            }
        }).open();
    });
}
