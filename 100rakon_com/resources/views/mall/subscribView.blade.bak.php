<?php
$thumbnail = $subscrib->thumbnail;
?>
@extends('layouts.mall')
@section('title')
    {{ $subscrib->title }} ::
@endsection

@section('content')
<div id="mall_subscrib_view">

    <div class="explain">
        <div class="thumbnail"><img src="<?=Storage::url('public/'.$thumbnail->real_name)?>"/></div>
        <div class="spec">
            <div class="title">{{ $subscrib->title }}</div>
            <div class="exp_line">
                <div class="head">제조원</div>
                <div class="tail">{{ $subscrib->products[0]->product->supply }}</div>
            </div>
            <div class="exp_line">
                <div class="head">배송비</div>
                <div class="tail">무료배송(도서산간 추가될 수 있음)</div>
            </div>
            <div class="exp_line">
                <div class="head">상품구성</div>
                <div class="tail">
                    @foreach($subscrib->products as $product)
                        @if($product->is_basic == 'Y')
                            &middot {{ $product->product->name }} x {{ $product->quantity_per_delivery }}<br/>
                        @endif
                    @endforeach
                    &middot 매 월 1일 배송<br/>
                    &middot VAT포함 가격
                </div>
            </div>
            <div class="exp_line">
                <div class="head">추가구성</div>
                <div class="tail">
                    <table width="100%" cellspacing="0" cellpadding="0" class="add_table">
                        @foreach($subscrib->products as $product)
                            @if($product->is_basic == 'N')
                            <tr>
                                <td class="first">{{ $product->product->name }} x {{ $product->quantity_per_delivery }} </td>
                                <td>
                                    <div class="basic_count_panel">
                                        <button onClick="quantity_minus({{ $product->sgpdx }})">-</button>
                                        <input type="text" name="quantity" value="0" id="id_quantity{{ $product->sgpdx }}" readonly>
                                        <button onClick="quantity_plus({{ $product->sgpdx }})">+</button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="exp_line">
                <div class="head">배송기간</div>
                <div class="tail">
                    <label class="term" onClick=""><input type="radio" name="term" value="6" onClick="change_term(6);" autocomplete="off"> 6개월</label>
                    <label class="term" onClick=""><input type="radio" name="term" value="12" onClick="change_term(12);" checked autocomplete="off"> 12개월</label>
                </div>
            </div>
        </div>
    </div>
    <div class="explain_subscrib">
        <h3>■ 정기배송 할인가격표 </h3>
        <div class="compare">
            <div class="price_table">
                <div class="th">상품 (단품가격)</div>
                <div class="td first">500ml 1박스 (48,000원)</div>
                <div class="td first">2L 1박스 (31,200원)</div>
            </div>
            <div class="price_table">
                <div class="th">6개월 정기배송</div>
                <div class="td">500ml 1박스(44,000원) x 6개월 = 264,000원</div>
                <div class="td">2L 1박스(29,000원) x 6개월 = 174,000원</div>
            </div>
            <div class="price_table">
                <div class="th">12개월 정기배송</div>
                <div class="td">500ml 1박스(40,000원) x 12개월 = 480,000원</div>
                <div class="td">2L 1박스(28,000원) x 12개월 = 336,000원</div>
            </div>
        </div>
        <div class="info">
            <div class="total_price">
                <div class="result">&middot; 총 비용<span id="id_monthly_cost">0원</span><button type="button" onClick="toggle_detail()">상세보기</button></div>
                <div class="formula" id="id_formula_detail">상세계산내역</div>
            </div>
            <div class="buttons">
                @guest
                    <button class="bgNavy White" onClick="alert('로그인이 필요합니다.')">주문하기</button>
                    <button onClick="gen.redirect('/subscrib');">정기배송 목록보기</button>
                @else
                    <button class="bgNavy White" onClick="goto_order()">주문하기</button>
                    <button onClick="gen.redirect('/subscrib');">정기배송 목록보기</button>
                @endguest
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
    
<form name="frm" method="post" action="/subscrib/order">
    @csrf
    <input type="hidden" name="sgdx" value="{{ $sgdx }}" />
    <input type="hidden" name="term" value="12" />
</form>

<!-- 쉐어용 설정 -->
<head>
<meta property="og:title" content="100rakon.com :: {{ $subscrib->title }}" />
<meta property="og:description" content="{{ $subscrib->title }}" />
<meta property="og:url" content="{{ config('app.url').$_SERVER['REQUEST_URI'] }}" />
<meta property="og:image" content="{{ config('app.url') }}{{ Storage::url('public/'.$thumbnail->real_name) }}" />
</head>

<script>
let price_terms = [];
    price_terms[1] = 'unit_price_normal';  //기간별 가격대1
    price_terms[6] = 'unit_price_half';  //기간별 가격대2
    price_terms[12] = 'unit_price_year';  //기간별 가격대3
let sgdx = {{ $sgdx }}; //상품번호
let selected_term = 12; //배송기간(기본 12개월)
let orderItems = [];    //주문제품들
let productItems = [];  //관련제품들
@foreach($subscrib->products as $product)
    productItems[{{ $product->sgpdx }}] = <?=json_encode( array_merge($product->toArray(), ['product' => $product->product]) )?>;
@endforeach

// 종합 계산
function calculate_total(selectedTerm)
{
    selected_term = selectedTerm;
    let detail_formula = "";     //상세 계산식 출력문구
    let monthly_amount = 0;      //월별 배송비

    //제품 순차별로 주문확인
    detail_formula += "[기본구성]<br/>";
    for(i = 0; i < productItems.length; i++)
    {
        if(productItems[i] !== undefined)
        {
            if(productItems[i]['is_basic'] == 'Y')
            {
                orderItems[i] = new Object;
                orderItems[i]['pdx'] = productItems[i]['pdx'];
                orderItems[i]['sgpdx'] = i;
                orderItems[i]['price'] = productItems[i][price_terms[selected_term]];
                orderItems[i]['quantity'] = productItems[i]['quantity_per_delivery'];
                orderItems[i]['amount'] = orderItems[i]['price'] * orderItems[i]['quantity'];
                monthly_amount += orderItems[i]['amount'];

                detail_formula += "&nbsp; · " + productItems[i]['product']['name'] + " " + selected_term + "개월 배송적용가 ";
                detail_formula += gen.addComma(orderItems[i]['price']) + "원 x " + orderItems[i]['quantity'] + " = " + gen.addComma(orderItems[i]['amount']) + "원<br/>";
            }
        }
    }

    // 추가구성 부분
    let addtional_product = "";
    for(i = 0; i < productItems.length; i++)
    {
        if(productItems[i] !== undefined)
        {
            if(productItems[i]['is_basic'] == 'N')
            {
                // 수량이 있을 때 추가
                if(parseInt($("#id_quantity" + productItems[i]['sgpdx']).val()) > 0)
                {
                    orderItems[i] = new Object;
                    orderItems[i]['sgpdx'] = i;
                    orderItems[i]['pdx'] = productItems[i]['pdx'];
                    orderItems[i]['price'] = productItems[i][price_terms[selected_term]];
                    orderItems[i]['quantity'] = parseInt($("#id_quantity" + productItems[i]['sgpdx']).val());
                    orderItems[i]['amount'] = orderItems[i]['price'] * orderItems[i]['quantity'];
                    monthly_amount += orderItems[i]['amount'];

                    addtional_product += "&nbsp; · " + productItems[i]['product']['name'] + " " + selected_term + "개월 배송적용가 ";
                    addtional_product += gen.addComma(orderItems[i]['price']) + "원 x " + orderItems[i]['quantity'] + " = " + gen.addComma(orderItems[i]['amount']) + "원<br/>";
                }
            }
        }
    }
    if(addtional_product != "")
    {
        detail_formula += "[추가구성]<br/>" + addtional_product;
    }

    // 종합
    detail_formula += "[종합]<br/>";
    detail_formula += "&nbsp; · 구성비용 : " + gen.addComma(monthly_amount) + "원<br/>";
    detail_formula += "&nbsp; · 배송기간 " + selected_term + "개월<br/>";
    detail_formula += "&nbsp; · 총 주문비용 : " + gen.addComma(selected_term * monthly_amount) + "원";

    $("#id_formula_detail").html(detail_formula);
    $("#id_monthly_cost").html(gen.addComma(selected_term * monthly_amount) + "원");
}
// 바로주문
function goto_order()
{
    if(confirm('정기배송을 주문하시겠습니까?'))
    {
        let form = document.frm;
        form.term.value = selected_term;      // 배송기간
        // 배송제품목록
        for(i = 0; i < orderItems.length; i++)
        {
            if(orderItems[i] !== undefined)
            {
                hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "items[]");
                hiddenField.setAttribute("value", JSON.stringify(orderItems[i]));
                form.appendChild(hiddenField);
            }
        }
        form.submit();
    }
}
// 추가물품 수량 더하기
function quantity_plus(sgpdx)
{
    let nowQA = parseInt($('#id_quantity' + sgpdx).val());
    $('#id_quantity' + sgpdx).val(nowQA + 1);
    calculate_total(selected_term);
}
// 추가물품 수량 빼기
function quantity_minus(sgpdx)
{
    let nowQA = parseInt($('#id_quantity' + sgpdx).val());
    if(nowQA > 0)
    {
        $('#id_quantity' + sgpdx).val(nowQA - 1);
        calculate_total(selected_term);
    }
}
// 배송기간 조정
function change_term(value)
{
    selected_term = value;
    calculate_total(selected_term);
}
// 상세계산내역 보기 토글
function toggle_detail()
{
    if($("#id_formula_detail").css('display') == 'none')
    {
        $("#id_formula_detail").css('display', 'block');
    }else{
        $("#id_formula_detail").css('display', 'none');
    }
}
$(document).ready(function()
{
    //12개월이 우선 자동선택
    calculate_total(selected_term);
});
</script>
</div>
@endsection
