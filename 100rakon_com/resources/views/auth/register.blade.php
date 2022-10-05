@extends('layouts.mall')

@section('content')
<div class="content_panel">
    <h3 class="sub_title">회원가입</h3>
    <div class="register_box clearfix">
        <div class="regist_sent rect">파란색 항목은 필수입니다.</div>
        <form method="POST" action="{{ route('register') }}" name="register">
            @csrf

            <div class="form-group" style="border-top: 1px solid #d6d6d6;">
                <label for="email" class="rect">아이디(이메일)</label>
                <div class="input_box">
                    <input type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="border-bottom: none">
                <label for="password" class="rect">비밀번호</label>
                <div class="input_box">
                    <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    <span class="input_not"><b><i class='bx bx-question-mark' style='color:#ffffff'></i></b>4자리 이상의 영문, 숫자, 특수문자</span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="rect">비밀번호 확인</label>
                <div class="input_box">
                    <input type="password" class="form-text" name="password_confirmation" autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="rect">이름</label>
                <div class="input_box">
                    <input type="text" class="form-text @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">
                    <span class="input_not"><b><i class='bx bx-question-mark' style='color:#ffffff'  ></i></b>비밀번호 찾기에 필요합니다. 가급적 본명을 사용해주세요.</span>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="cell" class="rect">핸드폰</label>
                <div class="input_box">
                    <input type="text" class="form-text @error('cell') is-invalid @enderror" name="cell" value="{{ old('cell') }}" max="20">
                    @error('cell')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="personal_agree" class="rect">정보정책 동의</label>
                <div class="check_box">
                    <p class="personal_sent"><span class="cPointer" onClick="open_terms('/terms-use');">서비스 이용약관</span>과 <span class="cPointer" onClick="open_terms('/terms-privacy');">개인정보 취급방침</span>에 동의합니다.</p>
                    <input id="personal_agree" type="checkbox" class="form-control @error('personal_agree') is-invalid @enderror" name="personal_agree">
                </div>
                @error('personal_agree')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-btn">
                {{-- <button type="submit" class="regist_btn">
                    가입하기
                </button> --}}
                <button type="button" class="regist_btn" onClick="check_email();">
                    가입하기
                </button>
                {{-- <a href="#" class="regist_btn regist_cancel">
                    취소
                </a> --}}
                <button type="button" class="regist_btn_kakao" onClick="gen.redirect('{{url('/social/kakao')}}');">
                    카카오
                </button>
                <button type="button" class="regist_btn_naver" onClick="gen.redirect('{{url('/social/naver')}}');">
                    네이버
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function open_terms(target)
{
    window.open(target, 'TERM', width=800, height=1000);
}
function check_email()
{
    $.ajax({
	type: "GET", //요청 메소드 방식
	url:"/exist-email-check",
	dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: "email=" + $('input[name=email]').val(),
	success : function(result){
        console.log(result);
        if(result.condition == true)
        {
            document.forms['register'].submit();
        }
        if(result.condition == false)
        {
            alert(result.msg);
        }
	},
	error : function(a, b, c){
		console.log(a);
		console.log(a + b + c);
	}
    });
}
</script>
@endsection
