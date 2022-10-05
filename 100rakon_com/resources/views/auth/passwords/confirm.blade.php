@extends('layouts.mall')

@section('content')
<div class="content_panel">
    <h3 class="sub_title">비밀번호 확인</h3>
    <div class="reset_box">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group">
                <label for="password">비밀번호</label>

                <div class="input_box">
                    <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-btn">
                <button type="submit" class="regist_btn">
                    확인
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
