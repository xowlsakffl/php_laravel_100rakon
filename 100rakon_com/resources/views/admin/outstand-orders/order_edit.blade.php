@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>특별상품 주문 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>주문 목록</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>특별상품 주문 수정</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.outstand-orders.update' ,['osodx' => $orderData->osodx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">주문번호</label>
                    <input type="text" name="order_number" class="form_text @error('order_number') is-invalid @enderror" value="{{$orderData->order_number}}">
                    @error('order_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                {{-- <div class="form_add">
                    <label for="">합계금액</label>
                    <input type="text" name="total_amount" class="form_text @error('total_amount') is-invalid @enderror" value="{{$orderData->total_amount}}">
                    @error('total_amount')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">사용 포인트</label>
                    <input type="text" name="use_point" class="form_text @error('use_point') is-invalid @enderror" value="{{$orderData->use_point}}">
                    @error('use_point')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div> --}}

                <div class="form_add">
                    <label for="">최종결제금액(포인트 제외)</label>
                    <input type="text" name="pay_amount" class="form_text @error('pay_amount') is-invalid @enderror" value="{{$orderData->pay_amount}}">
                    @error('pay_amount')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">지불방법</label>
                    <select name="pay_kind" class="form_text">
                        <option value="무통장" @if($orderData->pay_kind === "무통장") selected @endif>무통장</option>
                        <option value="카드" @if($orderData->pay_kind === "카드") selected @endif>카드</option>
                        <option value="핸드폰" @if($orderData->pay_kind === "핸드폰") selected @endif>핸드폰</option>
                        <option value="가상계좌" @if($orderData->pay_kind === "가상계좌") selected @endif>가상계좌</option>
                    </select>
                    @error('pay_kind')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">주문자명</label>
                    <input type="text" name="order_name" class="form_text @error('order_name') is-invalid @enderror" value="{{$orderData->order_name}}">
                    @error('order_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">주문자 연락처</label>
                    <input type="text" name="order_tel" class="form_text @error('order_tel') is-invalid @enderror" value="{{$orderData->order_tel}}">
                    @error('order_tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">입금(결제)자명</label>
                    <input type="text" name="pay_name" class="form_text @error('pay_name') is-invalid @enderror" value="{{$orderData->pay_name}}">
                    @error('pay_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">입금자 연락처</label>
                    <input type="text" name="pay_tel" class="form_text @error('pay_tel') is-invalid @enderror" value="{{$orderData->pay_tel}}">
                    @error('pay_tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">우편번호</label>
                    <input type="text" name="delivery_zipcode" class="form_text @error('delivery_zipcode') is-invalid @enderror" value="{{$orderData->delivery_zipcode}}">
                    @error('delivery_zipcode')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">기본주소</label>
                    <input type="text" name="delivery_address1" class="form_text @error('delivery_address1') is-invalid @enderror" value="{{$orderData->delivery_address1}}">
                    @error('delivery_address1')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상세주소</label>
                    <input type="text" name="delivery_address2" class="form_text @error('delivery_address2') is-invalid @enderror" value="{{$orderData->delivery_address2}}">
                    @error('delivery_address2')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">수령자명</label>
                    <input type="text" name="delivery_name" class="form_text @error('delivery_name') is-invalid @enderror" value="{{$orderData->delivery_name}}">
                    @error('delivery_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">수령자 연락처</label>
                    <input type="text" name="delivery_tel" class="form_text @error('delivery_tel') is-invalid @enderror" value="{{$orderData->delivery_tel}}">
                    @error('delivery_tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">배송메세지</label>
                    <textarea name="delivery_msg" class="form_text @error('delivery_msg') is-invalid @enderror">{{$orderData->delivery_msg}}</textarea>
                    @error('delivery_msg')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">영수증 종류</label>
                    <select name="receipt_kind" class="form_text">
                        <option value="세금계산서" @if($orderData->receipt_kind === "세금계산서") selected @endif>세금계산서</option>
                        <option value="현금영수증" @if($orderData->receipt_kind === "현금영수증") selected @endif>현금영수증</option>
                    </select>
                    @error('receipt_kind')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">사업자 번호</label>
                    <input type="text" name="company_regist_number" class="form_text @error('company_regist_number') is-invalid @enderror" value="{{$orderData->company_regist_number}}">
                    @error('company_regist_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상호</label>
                    <input type="text" name="company_name" class="form_text @error('company_name') is-invalid @enderror" value="{{$orderData->company_name}}">
                    @error('company_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">대표</label>
                    <input type="text" name="company_president_name" class="form_text @error('company_president_name') is-invalid @enderror" value="{{$orderData->company_president_name}}">
                    @error('company_president_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">업태</label>
                    <input type="text" name="company_kind1" class="form_text @error('company_kind1') is-invalid @enderror" value="{{$orderData->company_kind1}}">
                    @error('company_kind1')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">종목</label>
                    <input type="text" name="company_kind2" class="form_text @error('company_kind2') is-invalid @enderror" value="{{$orderData->company_kind2}}">
                    @error('company_kind2')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">담당자 이메일</label>
                    <input type="text" name="company_charge_email" class="form_text @error('company_charge_email') is-invalid @enderror" value="{{$orderData->company_charge_email}}">
                    @error('company_charge_email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">현금영수증 발급대상자명</label>
                    <input type="text" name="person_name" class="form_text @error('person_name') is-invalid @enderror" value="{{$orderData->person_name}}">
                    @error('person_name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">현금영수증 발급대상자 고유번호</label>
                    <input type="text" name="person_unique_number" class="form_text @error('person_unique_number') is-invalid @enderror" value="{{$orderData->person_unique_number}}">
                    @error('person_unique_number')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="10" @if($orderData->state === 10) selected @endif>입금대기</option>
                        <option value="9" @if($orderData->state === 9) selected @endif>입금완료</option>
                        <option value="1" @if($orderData->state === 1) selected @endif>주문취소</option>
                        <option value="0" @if($orderData->state === 0) selected @endif>삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <input type="hidden" name="old_state" value="{{ $orderData->state }}">

                <div class="form_btn clearfix">
                    <button type="submit">주문 수정</button>
                </div>
            </form>
@endsection
