@extends('layouts.mall')
@section('content')
<div id="mall_myorder">

    <div class="title">
        <div class="square"></div>
        <div class="text">특별상품 주문내역</div>
    </div>
    <div class="header">
        <div class="number">주문번호</div>
        <div class="bar"></div>
        <div class="amount">결제금액</div>
        <div class="bar"></div>
        <div class="date">주문일시</div>
        <div class="bar"></div>
        <div class="pay_kind">결제방법</div>
        <div class="bar"></div>
        <div class="condition">상태</div>
        <div class="bar"></div>
        <div class="menu">메뉴</div>
    </div>
    @foreach ($orders as $key => $order)
    <div class="order" id="id_order_{{ $key }}">
        <div class="number">{{ $order->order_number }}</div>
        <div class="amount">{{ number_format($order->pay_amount) }}원</div>
        <div class="date">{{ $order->created_at }}</div>
        <div class="pay_kind">{{ $order->pay_kind }}</div>
        <div class="condition">{{ $order->state_show }}</div>
        <div class="menu">
            <button type="button" class="btn" onClick="toggle_detail({{ $key }});">상세</button>
        </div>
    </div>
    <div class="items" id="id_items_{{ $key }}">
        @foreach ($order->outstandItems as $key2 => $item)
        <div class="item">
            <div class="thumbnail"><img src="<?=Storage::url('public/'.$item->outstand->thumbnail->real_name)?>" /></div>
            <div class="name">{{ $item->outstand->title }}</div>
            <div class="price">{{ number_format($item->price) }}원</div>
            <div class="quantity">수량 {{ $item->quantity }}</div>
            <div class="delivery">
                {{$item->delivery_kind }}배송
                @if($item->delivery_cost > 0)
                    <br/>{{ number_format($item->delivery_origin_cost) }}원
                @endif
            </div>
            <div class="amount">총 {{ number_format($item->amount) }}원</div>
        </div>
        @endforeach
        <div class="details">
            <div class="showMobile">
                <div class="head">주문상세</div>
                <div class="text">
                    &middot 주문번호 : {{ $order->order_number }}<br/>
                    &middot 주문상태 : {{ $order->state_show }}<br/>
                    &middot 주문자명 : {{ $order->order_name }}<br/>
                    &middot 연락처 : {{ $order->order_tel }}
                </div>
            </div>
            <div>
                <div class="head">배송정보</div>
                <div class="text">
                    {{ $order->delivery_name }} &nbsp; {{ $order->delivery_tel }}<br/>
                    {{ $order->delivery_zipcode }} &nbsp; {{ $order->delivery_address1 }} &nbsp; {{ $order->delivery_address2 }}<br/>
                    {{ $order->delivery_msg }}
                </div>
            </div>
            <div>
                <div class="head">결제정보</div>
                <div class="text">
                    &middot 결제방법 : {{ $order->pay_kind }}<br/>
                    &middot 입금(결제)자명 : {{ $order->pay_name }}<br/>
                    &middot 연락처 : {{ $order->pay_tel }}
                </div>
            </div>
            <div>
                <div class="head">영수증</div>
                <div class="text">
                    [{{ $order->receipt_kind }} 발행]<br/>
                    @if($order->receipt_kind == "세금계산서")
                        {{ $order->company_regist_number }} &nbsp; {{ $order->company_name }} &nbsp; {{ $order->company_president_name }}<br/>
                        {{ $order->company_kind1 }} &nbsp; {{ $order->company_kind2 }} &nbsp; {{ $order->charge_email }}<br/>
                        {{ $order->company_address }}
                    @else
                        {{ $order->person_name }} &nbsp; {{ $order->person_unique_number }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <br/><br/><br/>

<script>
$(document).ready(function()
{
})

// 주문상세 토글링
function toggle_detail(targetIdx)
{
    if($("#id_order_" + targetIdx).hasClass("orderOn") == false)
    {
        $("#id_order_" + targetIdx).addClass('orderOn');
        $("#id_items_" + targetIdx).addClass('itemsOn');
    }else{
        $("#id_order_" + targetIdx).removeClass('orderOn');
        $("#id_items_" + targetIdx).removeClass('itemsOn');
    }
}
</script>
@endsection
