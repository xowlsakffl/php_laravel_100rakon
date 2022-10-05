@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>주문 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>주문 목록</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>주문 목록</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.orderitems.update' ,['oidx' => $orderItemData->oidx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">제품명 / 제품 아이디</label>
                    <p>{{$orderItemData->product->name}} / {{$orderItemData->product->pdx}}</p>
                </div>

                <div class="form_add">
                    <label for="">적용가격</label>
                    <input type="text" name="price" class="form_text @error('price') is-invalid @enderror" value="{{$orderItemData->price}}">
                    @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">주문 수량</label>
                    <input type="number" name="quantity" class="form_text @error('quantity') is-invalid @enderror" value="{{$orderItemData->quantity}}">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">합계 가격</label>
                    <input type="text" name="amount" class="form_text @error('amount') is-invalid @enderror" value="{{$orderItemData->amount}}">
                    @error('amount')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">원배송비</label>
                    <input type="text" name="delivery_origin_cost" class="form_text @error('delivery_origin_cost') is-invalid @enderror" value="{{$orderItemData->delivery_origin_cost}}">
                    @error('delivery_origin_cost')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">배송비 지불 방식</label>
                    <select name="delivery_kind" class="form_text">
                        <option value="선불" @if($orderItemData->delivery_kind === "선불") selected @endif>선불</option>
                        <option value="착불" @if($orderItemData->delivery_kind === "착불") selected @endif>착불</option>
                        <option value="무료" @if($orderItemData->delivery_kind === "무료") selected @endif>무료</option>
                    </select>
                    @error('delivery_kind')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">실배송비</label>
                    <input type="text" name="delivery_pay" class="form_text @error('delivery_pay') is-invalid @enderror" value="{{$orderItemData->delivery_pay}}">
                    @error('delivery_pay')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">택배사</label>
                    <input type="text" name="delivery_logistics" class="form_text @error('delivery_logistics') is-invalid @enderror" value="{{$orderItemData->delivery_logistics}}">
                    @error('delivery_logistics')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">송장번호</label>
                    <input type="text" name="delivery_serial" class="form_text @error('delivery_serial') is-invalid @enderror" value="{{$orderItemData->delivery_serial}}">
                    @error('delivery_serial')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="42" @if($orderItemData->state === 42) selected @endif>환불완료</option>
                        <option value="41" @if($orderItemData->state === 41) selected @endif>환불중</option>
                        <option value="40" @if($orderItemData->state === 40) selected @endif>환불요청</option>
                        <option value="32" @if($orderItemData->state === 32) selected @endif>교환완료</option>
                        <option value="31" @if($orderItemData->state === 31) selected @endif>교환중</option>
                        <option value="30" @if($orderItemData->state === 30) selected @endif>교환요청</option>
                        <option value="23" @if($orderItemData->state === 23) selected @endif>구매확정</option>
                        <option value="22" @if($orderItemData->state === 22) selected @endif>배송완료</option>
                        <option value="21" @if($orderItemData->state === 21) selected @endif>배송중</option>
                        <option value="20" @if($orderItemData->state === 20) selected @endif>배송준비</option>
                        <option value="10" @if($orderItemData->state === 10) selected @endif>입금대기</option>
                        <option value="9" @if($orderItemData->state === 9) selected @endif>입금완료</option>
                        <option value="1" @if($orderItemData->state === 1) selected @endif>주문취소</option>
                        <option value="0" @if($orderItemData->state === 0) selected @endif>삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">주문 제품 수정</button>
                </div>
            </form>
@endsection