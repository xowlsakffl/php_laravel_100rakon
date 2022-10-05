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
                <div class="tail">
                    <div class="tail_cont">
                        <span>무료</span>
                        <button class="question_pop"><img src="/images/question_icon.png" alt=""></button>
                        <div class="question_cont">
                            <p class="txt01">알려드립니다!</p>
                            <p class="txt02">VAT포함 가격입니다.</p>
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
            <div class="exp_line">
                <div class="head">기본구성</div>
                <div class="tail">
                    <span class="Green">
                    @foreach($subscrib->products as $product)
                        @if($product->is_basic == 'Y')
                            {{ $product->product->name }} x {{ $product->quantity_per_delivery }}<br/>
                        @endif
                    @endforeach
                    </span>
                </div>
            </div>
            <div class="exp_line">
                <div class="head">기간</div>
                <div class="tail tail_duration">
                    <label class="term" onClick="change_term(6);"><input type="radio" name="term" value="6"><span>6개월</span></label>
                    <label class="term" onClick="change_term(12);"><input type="radio" name="term" value="12"> <span>12개월</span></label>
                </div>
            </div>
            <div class="exp_line">
                <div class="head">추가구성</div>
                <div class="tail">
                    <select class="add_box" name="sel_add">
                        <option value="">상품 선택</option>
                        @foreach($subscrib->products as $product)
                            @if($product->is_basic == 'N')
                            <option value="{{ $product->sgpdx }}">
                                {{ $product->product->name }} x {{ $product->quantity_per_delivery }}
                            @endif
                            </option>
                        @endforeach
                        <script>
                            $(function(){
                                $('.add_box').change(function () {
                                    $('#add_'+this.value).show();
                                });
                            })
                        </script>
                    </select>
                </div>

            </div>
            @foreach($subscrib->products as $product)
                @if($product->is_basic == 'N')
                <div class="add_product" id="add_{{ $product->sgpdx }}">
                    <img src="/images/close_btn.png" alt="" class="close_btn close{{ $product->sgpdx }}" onClick="quantity_reset({{ $product->sgpdx }})">
                    <p class="first">{{ $product->product->name }}</p>
                    <span>
                        <div class="basic_count_panel">
                            <button onClick="quantity_minus({{ $product->sgpdx }})">-</button>
                            <input type="text" name="quantity" value="0" id="id_quantity{{ $product->sgpdx }}" readonly>
                            <button onClick="quantity_plus({{ $product->sgpdx }})">+</button>
                        </div>
                    </span>
                </div>
                @endif
            @endforeach
            <div class="info">
                <div class="total_price">
                    <span class="txt01 Montserrat">TOTAL PRICE</span>
                    <span id="id_monthly_cost" class="txt02 Montserrat">0</span>
                    <span class="txt03">원</span>
                    {{-- <button type="button" onClick="toggle_detail()">상세보기</button> --}}
                    <div class="formula" id="id_formula_detail">상세계산내역</div>
                </div>
                <div class="buttons">
                    @guest

                        <button onClick="gen.redirect('/subscrib');" class="whitebtn">정기배송 목록보기</button>
                        <button class="darkbtn" onClick="alert('로그인이 필요합니다.')">주문하기</button>
                    @else

                        <button onClick="gen.redirect('/subscrib');" class="whitebtn">정기배송 목록보기</button>
                        <button class="darkbtn" onClick="goto_order()">주문하기</button>
                    @endguest
                </div>
            </div>

        </div>

    </div>
    <!-- 단가표 PC/Tablet -->
    <div class="explain_subscrib showPCTablet">
        <div class="img"><img src="/images/subscribe_img2.png" alt=""></div>
        <table width="100%" cellpadding="0" cellspacing="0" class="compare">
            <tr>
                <th rowspan="2">상품</th>
                <th rowspan="2">단품가격</th>
                <th colspan="2">6개월 정기배송 혜택</th>
                <th colspan="2">12개월 정기배송 혜택</th>
            </tr>
            <tr>
                <th>혜택 단품가</th>
                <th>6개월 혜택가</th>
                <th>혜택 단품가</th>
                <th>12개월 혜택가</th>
            </tr>
            <tr>
                <td>500ml</td>
                <td>48,000원</td>
                <td class="green"><span>48,000</span>44,000원</td>
                <td>264,000원</td>
                <td class="green"><span>48,000</span>40,000원</td>
                <td>480,000원</td>
            </tr>
            <tr>
                <td>2L</td>
                <td>31,200원</td>
                <td class="green"><span>31,200</span>29,000원</td>
                <td>174,000원</td>
                <td class="green"><span>31,200</span>28,000원</td>
                <td>336,000원</td>
            </tr>
        </table>
    </div>
    <!-- 단가표 Mobile -->
    <div class="explain_subscrib showMobile">
        <div class="img"><img src="/images/subscribe_img3.png" alt=""></div>
        <table width="100%" cellpadding="0" cellspacing="0" class="compare">
            <tr>
                <th>상품</th>
                <td colspan="2">500ml</td>
            </tr>
            <tr>
                <th>단품가</th>
                <td colspan="2">48,000원</td>
            </tr>
            <tr>
                <th rowspan="2">6개월</th>
                <th>혜택 단품가</th>
                <td class="green">44,000원</td>
            </tr>
            <tr>
                <th>6개월 혜택가</th>
                <td>264,000원</td>
            </tr>
            <tr>
                <th rowspan="2">12개월</th>
                <th>혜택 단품가</th>
                <td class="green">40,000원</td>
            </tr>
            <tr>
                <th>12개월 혜택가</th>
                <td>480,000원</td>
            </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0" class="compare">
            <tr>
                <th>상품</th>
                <td colspan="2">2L</td>
            </tr>
            <tr>
                <th>단품가</th>
                <td colspan="2">31,200원</td>
            </tr>
            <tr>
                <th rowspan="2">6개월</th>
                <th>혜택 단품가</th>
                <td class="green">29,000원</td>
            </tr>
            <tr>
                <th>6개월 혜택가</th>
                <td>174,000원</td>
            </tr>
            <tr>
                <th rowspan="2">12개월</th>
                <th>혜택 단품가</th>
                <td class="green">28,000원</td>
            </tr>
            <tr>
                <th>12개월 혜택가</th>
                <td>336,000원</td>
            </tr>
        </table>
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
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
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
    /* console.log("calculate_total"); */

    orderItems = [];    //주문제품들 초기화
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

    /* console.log('selected_term', selected_term);
    console.log('orderItems', orderItems);
    console.log("calculate_total END"); */

    $("#id_formula_detail").html(detail_formula);
    $("#id_monthly_cost").html(gen.addComma(selected_term * monthly_amount));
}

// 바로주문
function goto_order()
{
    calculate_total(selected_term);
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
// 추가물품 삭제
function quantity_reset(sgpdx)
{
    $('#id_quantity' + sgpdx).val(0);
    $('#add_'+sgpdx).hide();
    $(".add_box").val("");
    calculate_total(selected_term);
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
// 페이지 초기화
function init_page()
{
    $("input[name=term]:eq(1)").prop("checked", true);
    $("select[name=sel_add] option:eq(0)").prop("selected", true);
    calculate_total(selected_term);
}
$(document).ready(function()
{
    // console.log('selected_term', selected_term);
    // console.log('load', orderItems);
    // //12개월이 우선 자동선택
    // calculate_total(selected_term);

    // 12개월이 우선 자동선택된 초기화
    init_page();
});
</script>
</div>
@endsection
