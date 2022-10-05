@extends('layouts.mall')
@section('content')
<div id="mall_myinfo">

    <div class="title">
        <div class="square"></div>
        <div class="text">나의 정보</div>
    </div>
    <div class="order_info">
        <div>
            <div class="label rect">아이디(이메일)</div>
            <div class="content">{{ $user['join_from'] }}</div>
        </div>
        <div>
            <div class="label rect">이름</div>
            <div class="content">
                <input type="text" name="name" value="" />
            </div>
        </div>
        <div>
            <div class="label rect">비밀1번호</div>
            <div class="content"><input type="password" name="passwd1" value="" /></div>
        </div>
        <div>
            <div class="label rect">비밀번호 확인</div>
            <div class="content"><input type="password" name="passwd2" value="" /></div>
        </div>
        <div>
            <div class="label rect">핸드폰</div>
            <div class="content">
                <input type="text" name="cell" value="" />
            </div>
        </div>
    </div>

    <div class="decesion">
        <div class="total_amount">최종 결제 금액 : <span id="id_total_amount">0</span>원</div>
        <button type="button" class="cPointer" onClick="check_submit()">주문완료 및 결제하기</button>
    </div>

    <br/><br/><br/>

<script>
$(document).ready(function()
{
});
</script>
@endsection
