@extends('layouts.mall')

@section('content')
<div class="content_panel">
    <h3 class="sub_title">비밀번호 변경</h3>
    <div class="reset_box">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">이메일</label>

                <div class="input_box">
                    <p>{{ $email ?? old('email') }}</p>

                </div>
            </div>

            <div class="form-group row">
                <label for="password">비밀번호</label>

                <div class="input_box">
                    <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm">비밀번호 확인</label>

                <div class="input_box">
                    <input id="password-confirm" type="password" class="form-text" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-btn">
                <button type="submit" class="regist_btn">
                    변경하기
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
