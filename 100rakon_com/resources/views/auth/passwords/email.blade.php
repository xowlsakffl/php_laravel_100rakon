@extends('layouts.mall')

@section('content')
<div class="content_panel">
    <h3 class="sub_title">비밀번호 재설정</h3>
    <div class="reset_box">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">이메일</label>

                <div class="input_box">
                    <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-btn">
                <button type="submit" class="regist_btn">
                    전송하기
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
