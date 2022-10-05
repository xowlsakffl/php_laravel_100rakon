@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>회원 관리</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>회원 관리</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.users.update' ,['udx' => $userData->udx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">이메일</label>
                    <p class="form_readonly">{{$userData->email}}</p>
                </div>

                <div class="form_add">
                    <label for="">비밀번호</label>
                    <input type="password" name="password" class="form_text @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">비밀번호 확인</label>
                    <input type="password" name="password_confirmation" class="form_text @error('password_confirmation') is-invalid @enderror">
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">이름</label>
                    <input type="text" name="name" class="form_text @error('name') is-invalid @enderror" value="{{$userData->name}}" >
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">이메일 인증여부</label>
                    <select name="email_auth" class="form_text">
                        <option value="Y" @if($userData->email_auth === "Y") selected @endif>인증</option>
                        <option value="N" @if($userData->email_auth === "N") selected @endif>미인증</option>
                    </select>
                    @error('email_auth')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">휴대폰번호</label>
                    <input type="text" name="cell" class="form_text @error('cell') is-invalid @enderror" value="{{$userData->cell}}" >
                    @error('cell')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">휴대폰 인증여부</label>
                    <select name="cell_auth" class="form_text">
                        <option value="Y" @if($userData->cell_auth === "Y") selected @endif>인증</option>
                        <option value="N" @if($userData->cell_auth === "N") selected @endif>미인증</option>
                    </select>
                    @error('cell_auth')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">전화번호</label>
                    <input type="text" name="tel" class="form_text @error('tel') is-invalid @enderror" value="{{$userData->tel}}"  autocomplete="off">
                    @error('tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">가입경로</label>
                    <p class="form_readonly">{{$userData->join_from}}</p>
                </div>
                
                <div class="form_add">
                    <label for="">시스템관리자 여부</label>
                    <select name="super" class="form_text">
                        <option value="Y" @if($userData->super === "Y") selected @endif>관리자</option>
                        <option value="N" @if($userData->super === "N") selected @endif>비관리자</option>
                    </select>
                    @error('super')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="10" @if($userData->state === 10) selected @endif>정상</option>
                        <option value="9" @if($userData->state === 9) selected @endif>대기</option>
                        <option value="8" @if($userData->state === 8) selected @endif>정지</option>
                        <option value="1" @if($userData->state === 1) selected @endif>탈퇴</option>
                        <option value="0" @if($userData->state === 0) selected @endif>삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">사용자 수정</button>
                </div>
            </form>
@endsection