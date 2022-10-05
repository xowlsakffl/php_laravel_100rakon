<?php
$thumbnail = $product->thumbnail;
?>
@extends('layouts.mall')
@section('title')
    {{ $product->title }} ::
@endsection

@section('content')
<div id="mall_view">

    <div class="explain">
        <div class="thumbnail"><img src="<?=Storage::url('public/'.$thumbnail->real_name)?>"/></div>
        <div class="spec">
            <div class="title">{{ $product->title }}</div>
            @if ($product->price_normal > 0)
            
            <div class="price">
                <div class="discount_normal Montserrat">{{ number_format($product->price_normal) }}</div>
                <div class="discount Montserrat">{{ number_format($product->price) }}</div>
                <div class="won">원 (VAT포함)</div>
                {{-- <div class="normals">{{ number_format($product->price_normal) }}</div> --}}
            </div>
            @else
            <div class="price">
                <div class="discount Montserrat">{{ number_format($product->price) }}</div>
                <div class="won">원 (VAT포함)</div>
                {{-- <div class="normals">{{ number_format($product->price_normal) }}</div> --}}
            </div>
            @endif
            
            <div class="exp_line">
                <div class="head">제조원</div>
                <div class="tail">{{ $product->supply }}</div>
            </div>
            <div class="exp_line">
                <div class="head">배송비</div>
                <?php
                $delivery_cost = $product->delivery_origin_cost;
                if($delivery_cost == 0)
                {
                    $delivery_cost = '무료';
                }else{
                    $delivery_cost = number_format($delivery_cost).'원';
                }
                ?>
                <div class="tail">
                    <div class="tail_cont">
                        <span>{{ $delivery_cost }} </span>
                        <button class="question_pop"><img src="/images/question_icon.png" alt=""></button>
                        <div class="question_cont">
                            <p class="txt01">알려드립니다!</p>
                            <p class="txt02">도서산간 지역 : <b>추가배송비</b>가 부과됩니다.</p>
                        </div>
                        <script>
                            $(function(){
                                $('.question_pop').click(function(){
                                    $('.question_cont').stop().fadeToggle();
                                })
                            })
                        </script>
                    </div>
                </div>
            </div>
            <div class="exp_line">
                <div class="head">결제</div>
                <div class="tail">하나은행 176-910036-83704 ㈜백락온</div>
            </div>
            <div class="exp_line borderbNone">
                <div class="head">수량</div>
                <div class="tail">
                    <div class="basic_count_panel">
                        <button onClick="quantity_minus()">-</button>
                        <input type="text" name="quantity" value="1" id="id_quantity" readonly>
                        <button onClick="quantity_plus()">+</button>
                    </div>
                </div>
            </div>
            {{-- <div class="exp_line">
                <div class="head">상품 선택</div>
                <div class="tail">
                    <select>
                        <option value="">상품 선택</option>
                        <option value="">{{$product->name}}</option>
                    </select>
                </div>
            </div> --}}
            <div class="total_price">
                <span class="txt01 Montserrat">TOTAL PRICE</span>
                <span class="txt02"><div id="id_total_amount" class="Montserrat">{{ number_format($product->price) }}</div></span>
                <span class="txt03">원</span>
            </div>
            <div class="buttons">
                {{-- <button onClick="gen.copyToClipBoard('{{ config('app.url').$_SERVER['REQUEST_URI'] }}');">공유</button> --}}
                
                @guest
                    <button class="darkbtn" onClick="alert('로그인이 필요합니다.')">
                        <div>
                            <img src="/images/cart_icon.png" alt=""><span>바로주문</span>
                        </div>
                        
                    </button>
                    <button onClick="alert('로그인이 필요합니다.')" class="whitebtn">장바구니</button>
                    
                @else
                    <button class="darkbtn" onClick="goto_order()">
                        <div>
                            <img src="/images/cart_icon.png" alt=""><span>바로주문</span>
                        </div>
                    </button>
                    <button onClick="add_basket()" class="whitebtn">장바구니</button>
                    
                @endguest
                <button onClick="gen.redirect('/subscrib');" class="btR darkbtn">정기배송</button>
                <div class="bubble">지금 이상품을 계속 받고싶다면?</div>
            </div>
        </div>
    </div>
    <div class="detail">
        <div class="detail_box">
            <img src="/images/1-1.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/2-1.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/3.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/4.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/5-3.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/6.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/7.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/8.jpg" alt="">
        </div>
        <div class="detail_box">
            <img src="/images/9.jpg" alt="">
        </div>
    </div>

<!-- 쉐어용 설정 -->
<head>
<meta property="og:title" content="100rakon.com :: {{ $product->title }}" />
<meta property="og:description" content="{{ $product->title }}" />
<meta property="og:url" content="{{ config('app.url').$_SERVER['REQUEST_URI'] }}" />
<meta property="og:image" content="{{ config('app.url') }}{{ Storage::url('public/'.$thumbnail->real_name) }}" />
</head>

<script>
let pdx = {{ $product->pdx }};    //번호
let price = parseInt({{ $product->price }});    //단가
let quantity = 1;    //수량

// 수량 더하기
function quantity_plus()
{
    quantity = parseInt($('#id_quantity').val()) + 1;
    $('#id_quantity').val(quantity);
    print_total_amount();
}
// 수량 빼기
function quantity_minus()
{
    if(quantity > 1)
    {
        quantity = parseInt($('#id_quantity').val()) - 1;
        $('#id_quantity').val(quantity);
        print_total_amount();
    }
}
// 총 금액 출력
function print_total_amount()
{
    let total_amount_text = gen.addComma(quantity * price);
    $('#id_total_amount').html(total_amount_text);
}
// 장바구니 추가
function add_basket()
{
    $.post( "/order/basket-add", {
        pdx: pdx,
        quantity: quantity,
        _token: "{{ csrf_token() }}"
    },
    function(jqXHR)
    {
        // console.log( "success" );
    }, 'json' /* xml, text, script, html */)
    .done(function(jqXHR)
    {
        console.log( "second success" );
        console.log(jqXHR);
        if(jqXHR == 0)  // 추가실패
        {
            if(confirm('이미 추가된 상품입니다..\n장바구니로 이동 하시겠습니까?'))
            {
                document.location.href = "/order/basket";
            }
        }
        if(jqXHR == 1)  // 추가성공
        {
            if(confirm('추가하였습니다.\n장바구니로 이동 하시겠습니까?'))
            {
                document.location.href = "/order/basket";
            }
        }
    });
    // .fail(function(jqXHR)
    // {
    //     alert( "error" );
    //     console.log(jqXHR);
    // })
    // .always(function(jqXHR)
    // {
    //     alert( "finished" );
    // });
}
// 바로주문
function goto_order()
{
    if(confirm('바로 주문하시겠습니까?'))
    {
        document.location.href = "/order/basket-direct?pdx=" + pdx + "&quantity=" + quantity;
    }
}
</script>
</div>
@endsection
