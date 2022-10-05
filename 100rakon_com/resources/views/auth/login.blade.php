@extends('layouts.mall')

@section('content')

<div class="content_panel">
    <h3 class="sub_title">로그인</h3>
    <div class="login_box clearfix">
        {{-- <h4>LOGIN</h4> --}}
        <div class="login_left">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <span class="icon_box"><i class='bx bx-user' style='color:#707070' ></i></span>
                    <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="이메일">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <span class="icon_box"><i class='bx bx-lock-alt' style='color:#707070' ></i></span>
                    <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="비밀번호">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        자동로그인
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="login_btn">
                        로그인
                    </button>
                </div>
                <a href="{{route('register')}}" class="login_link">백락온 회원가입</a>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="login_link">
                    비밀번호 찾기
                </a>
                @endif
            </form>
        </div>
        <div class="login_right">
            <h5><span>SNS</span> 로그인으로 간편하게</h5>
            <div class="row">
                <a href="{{url('/social/kakao')}}" class="sns_btn sns_btn1">카카오 아이디로 로그인</a>
                <a href="{{url('/social/naver')}}" class="sns_btn sns_btn2">네이버 아이디로 로그인</a>
            </div>
        </div>
    </div>
</div>
@endsection
