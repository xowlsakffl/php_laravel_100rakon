@extends('layouts.mall')
@section('content')
<script>
    var clientKey = '{{ env("TOSS_CLIENT_KEY") }}';
    var tossPayments = TossPayments(clientKey) // 클라이언트 키로 초기화하기
</script>
<div id="mall_subscrib_order">

<form name="order" action="/subscrib/order-save" method="post">
    <div class="title"><div class="square"></div><div class="text">정기배송 주문하기</div></div>
    <div class="order_info">
        <div>
            <div class="label rect">상품</div>
            <div class="content">{{ $subscribGood->title }}</div>
        </div>
        <div>
            <div class="label rect">배송기간</div>
            <div class="content">{{ $term }}개월</div>
        </div>
        <div>
            <div class="label rect">배송정책</div>
            <div class="content">매 월 1일 무료배송 (도서산간 요금추가)</div>
        </div>
<?
$total_amount = 0;
// 필수구성와 추가구성을 구분
$count_is_basic = 0;
$count_not_basic = 0;
foreach($items as $key => $item)
{
    if($item->subscribProduct->is_basic == "Y")
    {
        $count_is_basic++;
    }else{
        $count_not_basic++;
    }
}
?>
        @if($count_is_basic > 0)
        <div>
            <div class="label rect">필수구성</div>
            <div class="content2">
                @foreach($items as $key => $item)
                    @if($item->subscribProduct->is_basic == "Y")
                    <? $total_amount += $item->amount ?>
                    <div class="item">
                        <div class="item_thumb"><img src="<?=Storage::url('public/'.$item->product->thumbnail->real_name)?>" /></div>
                        <div class="item_title">{{ $item->product->name }}</div>
                        <div class="item_price">{{ number_format($item->price) }}원</div>
                        <div class="item_quantity">수량 {{ number_format($item->quantity) }}</div>
                        <div class="item_amount">지불액 {{ number_format($item->amount) }}원</div>
                    </div>
                    <input type="hidden" name="sgpdx[]" value="<?=$item->sgpdx?>" />
                    <input type="hidden" name="price[]" value="<?=$item->price?>" />
                    <input type="hidden" name="quantity[]" value="<?=$item->quantity?>" />
                    <input type="hidden" name="amount[]" value="<?=$item->amount?>" />
                    @endif
                @endforeach
            </div>
        </div>
        @endif
        @if($count_not_basic > 0)
        <div>
            <div class="label rect">추가구성</div>
            <div class="content2">
                @foreach($items as $key => $item)
                    @if($item->subscribProduct->is_basic == "N")
                    <? $total_amount += $item->amount ?>
                    <div class="item">
                        <div class="item_thumb"><img src="<?=Storage::url('public/'.$item->product->thumbnail->real_name)?>" /></div>
                        <div class="item_title">{{ $item->product->name }}</div>
                        <div class="item_price">{{ number_format($item->price) }}원</div>
                        <div class="item_quantity">수량 {{ number_format($item->quantity) }}</div>
                        <div class="item_amount">지불액 {{ number_format($item->amount) }}원</div>
                    </div>
                    <input type="hidden" name="sgpdx[]" value="<?=$item->sgpdx?>" />
                    <input type="hidden" name="price[]" value="<?=$item->price?>" />
                    <input type="hidden" name="quantity[]" value="<?=$item->quantity?>" />
                    <input type="hidden" name="amount[]" value="<?=$item->amount?>" />
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="title title_se"><div class="square"></div><div class="text">주문자 정보</div></div>
    <div class="order_info">
        <div>
            <div class="label rect">주문자 이름</div>
            <div class="content">
                <input type="text" name="order_name" value="" />
                <input type="button" class="inline_btn" value="접속자 정보 입력" onClick="apply_user_info();"/>
            </div>
        </div>
        <div>
            <div class="label rect">주문자 연락처</div>
            <div class="content">
                <input type="text" name="order_tel" value="" />
                @if(empty($user->cell))
                <input type="button" class="inline_btn cell_button save_cell_off" value="입력한 연락처 저장" onClick="save_cell_check()" title="입력편의를 위해 고객님의 최신 연락처로 저장해 둡니다."/>
                @endif
            </div>
        </div>
    </div>

    <div class="title title_se"><div class="square"></div><div class="text">배송지 정보</div></div>
    <div class="order_info">
        <div>
            <div class="label rect">수령자 이름</div>
            <div class="content">
                <input type="text" name="delivery_name" value="" />
            </div>
        </div>
        <div>
            <div class="label rect">수령자 연락처</div>
            <div class="content">
                <input type="text" name="delivery_tel" value="" />
            </div>
        </div>
        <div>
            <div class="label rect">배송지 주소</div>
            <div class="address">
                <div>
                    <input type="text" name="delivery_zipcode" value="" />
                    <input type="button" class="inline_btn" value="주소찾기" onClick="gen.StartDaumAddress('delivery_zipcode', 'delivery_address1', 'delivery_address2');" />
                    <input type="button" class="inline_btn" value="주소록" onClick="window.open('/myaddress', '주소록', width=800, height=550);" />
                </div>
                <div>
                    <input type="text" name="delivery_address1" value="" />
                </div>
                <div>
                    <input type="text" name="delivery_address2" value="" />
                </div>
            </div>
        </div>
        <div>
            <div class="label rect">배송 메모</div>
            <div class="content">
                <input type="text" name="delivery_msg" value="" onFocus="memo_select_show();" autocomplete="off" />
                <div class="memo_select">
                    <label onClick="memo_select_hide();">&middot; 직접 입력</label><br/>
                    <label onClick="memo_select('부재 시 문 앞에 두세요.');">&middot; 부재 시 문 앞에 두세요.</label><br/>
                    <label onClick="memo_select('경비실에 맡겨주세요.');">&middot; 경비실에 맡겨주세요.</label><br/>
                    <label onClick="memo_select('택배함에 넣어두세요.');">&middot; 택배함에 넣어두세요.</label><br/>
                    <label onClick="memo_select('배송전에 연락주세요.');">&middot; 배송전에 연락주세요.</label>
                </div>
            </div>
        </div>
    </div>

    <div class="title title_se"><div class="square"></div><div class="text">결제 정보</div></div>
    <div class="order_info">
        <div>
            <div class="label rect">결제방법</div>
            <div class="content">
                <label onClick="change_pay_kind('무통장');"><input type="radio" name="pay_kind" value="무통장" checked> &nbsp;무통장입금</label>
                <label onClick="change_pay_kind('카드');"><input type="radio" name="pay_kind" value="카드"> &nbsp;카드결제</label>
@if(($user->email == "tongs@meci.co.kr")||($user->email == "cto@meci.co.kr"))
                <label onClick="change_pay_kind('휴대폰');"><input type="radio" name="pay_kind" value="휴대폰"> &nbsp;핸드폰결제</label>
@endif
                <label onClick="change_pay_kind('가상계좌');"><input type="radio" name="pay_kind" value="가상계좌"> &nbsp;가상계좌</label>
                <label onClick="change_pay_kind('계좌이체');"><input type="radio" name="pay_kind" value="계좌이체"> &nbsp;실시간이체</label>
                {{-- <label><input type="radio" name="pay_kind" value="무통장" checked> &nbsp;무통장입금</label>
                <label onClick="alert('준비중입니다.');"><input type="radio" name="pay_kind" value="카드" disabled> &nbsp;카드결제</label>
                <label onClick="alert('준비중입니다.');"><input type="radio" name="pay_kind" value="핸드폰" disabled> &nbsp;핸드폰결제</label> --}}
            </div>
        </div>
        <div>
            <div class="label rect">입금(결제)자명</div>
            <div class="content">
                <input type="text" name="pay_name" value="" />
            </div>
        </div>
        <div>
            <div class="label rect">연락처</div>
            <div class="content">
                <input type="text" name="pay_tel" value="" />
            </div>
        </div>
        <div class="show_pay_kind_cash">
            <div class="label rect">영수증</div>
            <div class="content">
                <label><input type="radio" name="receipt_kind" value="세금계산서" onClick="change_receipt(0)" checked> &nbsp;세금계산서</label>
                <label><input type="radio" name="receipt_kind" value="현금영수증" onClick="change_receipt(1)"> &nbsp;현금영수증</label>
            </div>
        </div>
        <div class="show_pay_kind_cash">
            <div class="label rect">발행정보</div>
            <div class="address2">
                <div>
                    <input type="text" name="company_name" value="" placeholder="상호" />
                    <input type="text" name="company_regist_number" value="" placeholder="사업자번호" />
                    <input type="text" name="company_president_name" value="" placeholder="대표자" />
                    <input type="text" name="company_charge_email" value="" placeholder="담당자 이메일" />
                    <input type="text" name="company_address" value="" placeholder="주소" />
                    <input type="text" name="company_kind1" value="" placeholder="업태" />
                    <input type="text" name="company_kind2" value="" placeholder="종목" />
                </div>
                <div>
                    <input type="text" name="person_name" value="" placeholder="이름" />
                    <input type="text" name="person_unique_number" value="" placeholder="주민번호 또는 핸드폰 번호" />
                </div>
            </div>
        </div>
        <div class="show_pay_kind_cash">
            <div class="label rect">입금처</div>
            <div class="content">
                하나은행 &nbsp;176-910036-83704 &nbsp;(예금주 : ㈜백락온)
            </div>
        </div>
    </div>

    <div class="decesion">
        <div class="total_amount">결제 금액 : <span id="id_total_amount">{{ number_format($term * $total_amount) }}</span>원 ({{ number_format($total_amount) }}원 x {{ $term }}개월)</div>
        <button type="button" class="cPointer" onClick="check_submit()">주문완료 및 결제하기</button>
    </div>

    <input type="hidden" name="total_amount" value="{{ $term * $total_amount }}" />
    <input type="hidden" name="total_pay" value="{{ $term * $total_amount }}" />
    <input type="hidden" name="sgdx" value="{{ $subscribGood->sgdx }}" />
    <input type="hidden" name="term" value="{{ $term }}" />
    <input type="hidden" name="save_cell" value="N" />

    @csrf
    </form>

<script>
var orderForm = $("form[name=order]");
$(document).ready(function()
{
})

//결제방법 변경 시 조치
function change_pay_kind(kind)
{
    if(kind == '무통장')
    {
        $(".show_pay_kind_cash").css("display", "flex");
    }else{
        $(".show_pay_kind_cash").css("display", "none");
    }
}

// 입력폼 변경
function change_receipt(index)
{
    $(".address2 > div").css('display', 'none');
    $(".address2 > div").eq(index).css('display', 'block');
    $(".address2 > div").eq(index).children().first().focus();
}

// 로그인한 사람의 연락처가 없을 때 이번 전화번호를 저장해 둠
function save_cell_check()
{
    console.log($('input[name=save_cell]').val());

    if($('.cell_button').hasClass('save_cell_on') == false)
    {
        $('.cell_button').addClass('save_cell_on');
        $('input[name=save_cell]').val('Y');
    }else{
        $('.cell_button').removeClass('save_cell_on');
        $('input[name=save_cell]').val('N');
    }

    console.log($('input[name=save_cell]').val());
}

// 폼 서브밋
function check_submit()
{
    // console.log(orderForm.serialize());
    // orderForm.submit();
    $.ajax({
	type: "POST", //요청 메소드 방식
	url:"/subscrib/order-save",
	dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: orderForm.serialize(),
	success : function(result){
        if(result.condition == true)
        {
            if(result.order_info.pay_kind == "무통장")
            {
                alert(result.msg);
                if(result.condition == true)
                {
                    location.href = '/myorder-subscrib';
                }
            }else{
                //토스 결제 호출
                tossPayments.requestPayment(result.order_info.pay_kind, { // 결제 수단 파라미터
                    // 결제 정보 파라미터
                    amount: result.order_info.pay_amount,
                    orderId: result.order_info.order_number,
                    orderName: result.order_info.pay_name + ' ' + result.order_info.pay_tel,
                    customerName: result.order_info.order_name,
                    successUrl: '{{ env('APP_URL') }}/toss/pay-toss-success',
                    failUrl: '{{ env('APP_URL') }}/toss/pay-toss-fail',
                })
            }
        }else{
            alert(result.msg);
        }

        // alert(result.msg);
        // if(result.condition == true)
        // {
        //     location.href = '/myorder-subscrib';
        // }
	},
	error : function(a, b, c){
		console.log(a);
		console.log(a + b + c);
	}
    });
}
// 사용자 정보 입력
function apply_user_info()
{
    $("input[name=order_name]").val("{{ $user->name }}");
    $("input[name=order_tel]").val("{{ $user->cell }}");
    $("input[name=delivery_name]").val("{{ $user->name }}");
    $("input[name=delivery_tel]").val("{{ $user->cell }}");
    $("input[name=pay_name]").val("{{ $user->name }}");
    $("input[name=pay_tel]").val("{{ $user->cell }}");
}

//배송메모
function memo_select(memo)
{
    $("input[name=delivery_msg]").val(memo);
    memo_select_hide();
}
function memo_select_show(e)
{
    if($("input[name=delivery_msg]").val() == "")
    {
        $(".memo_select").css('display', 'block');
    }
}
function memo_select_hide()
{
    $(".memo_select").css('display', 'none');
}
</script>
</div>
@endsection
