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
            <form action="{{route('admin.user-addresses.update' ,['uadx' => $userAddress->uadx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">회원 이메일</label>
                    <p class="form_readonly">{{$userAddress->user->email}}</p>
                </div>

                <div class="form_add">
                    <label for="">배송지 제목</label>
                    <input type="text" name="title" class="form_text @error('title') is-invalid @enderror" value="{{$userAddress->title}}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">우편번호</label>
                    <input type="text" name="zipcode" class="form_text @error('zipcode') is-invalid @enderror" value="{{$userAddress->zipcode}}">
                    @error('zipcode')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">기본주소</label>
                    <input type="text" name="address1" class="form_text @error('address1') is-invalid @enderror" value="{{$userAddress->address1}}" >
                    @error('address1')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상세주소</label>
                    <input type="text" name="address2" class="form_text @error('address2') is-invalid @enderror" value="{{$userAddress->address2}}" >
                    @error('address2')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">수령자명</label>
                    <input type="text" name="name" class="form_text @error('name') is-invalid @enderror" value="{{$userAddress->name}}" >
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">수령자 연락처</label>
                    <input type="text" name="tel" class="form_text @error('tel') is-invalid @enderror" value="{{$userAddress->tel}}" >
                    @error('tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">배송메세지</label>
                    <textarea name="msg" class="form_text @error('msg') is-invalid @enderror">{{$userAddress->msg}}</textarea>
                    @error('msg')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">회원 배송지 수정</button>
                </div>
            </form>
@endsection