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
            <form action="{{route('admin.user-baskets.update' ,['obdx' => $userBasket->obdx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">회원 이메일</label>
                    <p class="form_readonly">{{$userBasket->user->email}}</p>
                </div>

                <div class="form_add">
                    <label for="">제품명</label>
                    <p class="form_readonly">{{$userBasket->product->name}}</p>
                </div>

                <div class="form_add">
                    <label for="">주문 수량</label>
                    <input type="text" name="quantity" class="form_text @error('quantity') is-invalid @enderror" value="{{$userBasket->quantity}}" >
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">회원 장바구니 수정</button>
                </div>
            </form>
@endsection