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
    @if ($orderData)
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>주문 상세</h3>
        </div>

        <div class="main_wrap clearfix">
            <h3>&nbsp; 변동 내역</h3>
            <div class="info_box clearfix">
                @foreach($orderData->histories as $history)
                <div class="history">
                    <div class="date">{{ $history->created_at }}</div>
                    <div class="content">{{ $history->content }}</div>
                </div>
                @endforeach
<form action="/admin/orders/history-create" method="post" class="add_form">
        @csrf
                <div class="history_input">
                    <input type="text" name="content" class="form-control text" placeholder="변동 메모" />
                    <button type="submit">입력</button>
                </div>
<input type="hidden" name="odx" value="{{ $orderData->odx }}" />
</form>
            </div>
        </div>

        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <div class="right_btn">
                    <a href="{{route('admin.orders.edit', ['odx' => $orderData->odx])}}">주문 수정</a>
                    <form action="{{route('admin.orders.destroy', ['odx' => $orderData->odx])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="주문 삭제">
                    </form>
                </div>
            </div>

            <div class="info_box clearfix" style="border-bottom:none">

                <dl>
                    <dt>주문번호</dt>
                    <dd>{{$orderData->order_number}}</dd>
                </dl>

                <dl>
                    <dt>접속자 이름</dt>
                    <dd>{{$orderData->user->name}}</dd>
                </dl>

                <dl>
                    <dt>접속자 핸드폰</dt>
                    <dd>{{$orderData->user->cell}}</dd>
                </dl>

                <dl>
                    <dt>접속자 이메일</dt>
                    <dd>{{$orderData->user->email}}</dd>
                </dl>

                <dl>
                    <dt>주문자 이름</dt>
                    <dd>{{$orderData->order_name}}</dd>
                </dl>

                <dl>
                    <dt>주문자 연락처</dt>
                    <dd>{{$orderData->order_tel}}</dd>
                </dl>

                {{-- <dl>
                    <dt>합계금액</dt>
                    <dd>{{ number_format($orderData->total_amount) }}</dd>
                </dl>

                <dl>
                    <dt>사용 포인트</dt>
                    <dd>{{$orderData->use_point}}</dd>
                </dl> --}}

                <dl>
                    <dt>최종결제금액(포인트 제외)</dt>
                    <dd>{{ number_format($orderData->pay_amount) }}</dd>
                </dl>

                <dl>
                    <dt>지불방법</dt>
                    <dd>{{$orderData->pay_kind}}</dd>
                </dl>

                <dl>
                    <dt>입금(결제)자명</dt>
                    <dd>{{$orderData->pay_name}}</dd>
                </dl>

                <dl>
                    <dt>입금자 연락처</dt>
                    <dd>{{$orderData->pay_tel}}</dd>
                </dl>

                <dl>
                    <dt>우편번호</dt>
                    <dd>{{$orderData->delivery_zipcode}}</dd>
                </dl>

                <dl>
                    <dt>기본주소</dt>
                    <dd>{{$orderData->delivery_address1}}</dd>
                </dl>

                <dl>
                    <dt>상세주소</dt>
                    <dd>{{$orderData->delivery_address2}}</dd>
                </dl>

                <dl>
                    <dt>수령자명</dt>
                    <dd>{{$orderData->delivery_name}}</dd>
                </dl>

                <dl>
                    <dt>수령자 연락처</dt>
                    <dd>{{$orderData->delivery_tel}}</dd>
                </dl>

                <dl>
                    <dt>배송메세지</dt>
                    <dd>{{$orderData->delivery_msg}}</dd>
                </dl>

                <dl>
                    <dt>영수증 종류</dt>
                    <dd>{{$orderData->receipt_kind}}</dd>
                </dl>

                <dl>
                    <dt>사업자번호</dt>
                    <dd>{{$orderData->company_regist_number}}</dd>
                </dl>

                <dl>
                    <dt>상호</dt>
                    <dd>{{$orderData->company_name}}</dd>
                </dl>

                <dl>
                    <dt>대표</dt>
                    <dd>{{$orderData->company_president_name}}</dd>
                </dl>

                <dl>
                    <dt>업태</dt>
                    <dd>{{$orderData->company_kind1}}</dd>
                </dl>

                <dl>
                    <dt>종목</dt>
                    <dd>{{$orderData->company_kind2}}</dd>
                </dl>

                <dl>
                    <dt>담당자 이메일</dt>
                    <dd>{{$orderData->company_charge_email}}</dd>
                </dl>

                <dl>
                    <dt>현금영수증 발급대상자명</dt>
                    <dd>{{$orderData->person_name}}</dd>
                </dl>

                <dl>
                    <dt>현금영수증 발급대상자 고유번호</dt>
                    <dd>{{$orderData->person_unique_number}}</dd>
                </dl>

                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($orderData->state == "10")
                            입금대기
                        @elseif ($orderData->state == "9")
                            입금완료
                        @elseif ($orderData->state == "1")
                            주문취소
                        @elseif ($orderData->state == "0")
                            삭제
                        @endif
                    </dd>
                </dl>

                <dl>
                    <dt>주문일</dt>
                    <dd>{{$orderData->created_at}}</dd>
                </dl>
            </div>
        </div>

        <div class="main_wrap clearfix">
            <div class="search_warp clearfix">
                <h4>주문 제품</h4>
            </div>
            @foreach ($orderItems as $orderItem)
                <div class="main_wrap_title clearfix">
                    <div class="right_btn">
                        <a href="{{route('admin.orderitems.edit', ['oidx' => $orderItem->oidx])}}">주문 제품 수정</a>
                        <form action="{{route('admin.orderitems.destroy', ['oidx' => $orderItem->oidx])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="주문 제품 삭제">
                        </form>
                    </div>
                </div>
                <div class="info_box clearfix" style="border-bottom:none">
                    <dl>
                        <dt>제품명</dt>
                        <dd>{{$orderItem->product->name}}</dd>
                    </dl>
                    <dl>
                        <dt>적용 가격</dt>
                        <dd>{{$orderItem->price}}</dd>
                    </dl>
                    <dl>
                        <dt>주문 수량</dt>
                        <dd>{{$orderItem->quantity}}</dd>
                    </dl>
                    <dl>
                        <dt>합계 가격</dt>
                        <dd>{{$orderItem->amount}}</dd>
                    </dl>
                    <dl>
                        <dt>원배송비</dt>
                        <dd>{{$orderItem->delivery_origin_cost}}</dd>
                    </dl>
                    <dl>
                        <dt>배송비 지불 방식</dt>
                        <dd>{{$orderItem->delivery_kind}}</dd>
                    </dl>
                    <dl>
                        <dt>실배송비</dt>
                        <dd>{{$orderItem->delivery_pay}}</dd>
                    </dl>
                    <dl>
                        <dt>택배사</dt>
                        <dd>{{$orderItem->delivery_logistics}}</dd>
                    </dl>
                    <dl>
                        <dt>송장번호</dt>
                        <dd>{{$orderItem->delivery_serial}}</dd>
                    </dl>
                    <dl>
                        <dt>상태</dt>
                        <dd>
                            @if ($orderItem->state == 42)
                                환불완료
                            @elseif($orderItem->state == 41)
                                환불중
                            @elseif($orderItem->state == 40)
                                환불요청
                            @elseif($orderItem->state == 32)
                                교환완료
                            @elseif($orderItem->state == 31)
                                교환중
                            @elseif($orderItem->state == 30)
                                교환요청
                            @elseif($orderItem->state == 23)
                                구매확정
                            @elseif($orderItem->state == 22)
                                배송완료
                            @elseif($orderItem->state == 21)
                                배송중
                            @elseif($orderItem->state == 20)
                                배송준비
                            @elseif($orderItem->state == 10)
                                입금대기
                            @elseif($orderItem->state == 9)
                                입금완료
                            @elseif($orderItem->state == 1)
                                주문취소
                            @elseif($orderItem->state == 1)
                                삭제
                            @endif
                        </dd>
                    </dl>
                </div>
                <hr>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
