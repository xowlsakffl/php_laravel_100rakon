@extends('layouts.mall')
@section('content')
<div id="mall_myinfo">

    <div class="title">
        <div class="square"></div>
        <div class="text">특별상품 비회원 주문내역 조회</div>
    </div>
    <form action="/myorder-outstand-guest" method="get">
    <div class="order_info" style="margin-bottom: 15px;width: 300px;margin:0 auto;margin-bottom: 15px">
        <div>
            <div class="label rect">주문자명</div>
            <div class="content">
                <input type="text" name="order_name" value="" style="width: 100%" required>
            </div>
        </div>
        <div>
            <div class="label rect">휴대폰 번호</div>
            <div class="content">
                <input type="text" name="order_tel" value="" style="width: 100%" required>
            </div>
        </div>
    </div>

    <div class="decesion" style="width: 300px;margin:0 auto;">
        <button type="submit" class="cPointer" style="width: 100%">조회하기</button>
    </div>

    <div style="margin-top: 15px;text-align: center">
        ※ 회원이신 경우 로그인 후 접속하시면 특별상품 주문내역을 보실 수 있습니다.
    </div>
    </form>
    <br/><br/><br/>

@endsection
