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
    @if ($orderData)
    <div class="search_warp clearfix">
        <h3>특별상품 주문 목록</h3>
        <div class="search_box">
            <form action="{{route('admin.outstand-orders.index')}}" method="get" class="form-inline">
                <div class="search_select">
                    <select name="search_option">
                        <option value="order_number">주문번호</option>
                        <option value="pay_name">입금자명</option>
                    </select>
                </div>

                <div class="search_input">
                    <input type="text" name="search_text">
                </div>

                <div class="search_btn">
                    <input type="submit" value="검색">
                </div>
            </form>
        </div>
    </div>

    <div class="main_wrap clearfix">
        <div class="classify">
            <ul class="clearfix">
                <li><a href="{{route('admin.outstand-orders.index')}}" class="{{ (\Request::input('state'))==null ? 'active' : '' }}">전체</a></li>
                <li><a href="{{route('admin.outstand-orders.index', ['state' => '10'])}}" class="{{ (\Request::input('state'))=='10' ? 'active' : '' }}">입금대기</a></li>
                <li><a href="{{route('admin.outstand-orders.index', ['state' => '9'])}}" class="{{ (\Request::input('state'))=='9' ? 'active' : '' }}">입금완료</a></li>
                <li><a href="{{route('admin.outstand-orders.index', ['state' => '1'])}}" class="{{ (\Request::input('state'))=='1' ? 'active' : '' }}">주문취소</a></li>
                <li><a href="{{route('admin.outstand-orders.index', ['state' => '0'])}}" class="{{ (\Request::input('state'))=='0' ? 'active' : '' }}">삭제</a></li>
            </ul>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>주문번호</th>
                    <th>주문자</th>
                    <th>합계금액</th>
                    <th>가격</th>
                    <th>상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderData as $order)
                    <tr onclick="location.href='{{route('admin.outstand-orders.show', ['osodx' => $order['osodx']])}}'">
                        <td class="item_num">{{$orderData->firstItem()+$loop->index}}</td>
                        <td>{{$order['order_number']}}</td>
                        <td>{{$order['order_name']}}</td>
                        <td>{{ number_format($order['total_amount']) }}</td>
                        <td>{{$order['pay_kind']}}</td>
                        <td>
                            <span>상태</span>
                            @if ($order['state'] == 10)
                                입금대기
                            @elseif($order['state'] == 9)
                                입금완료
                            @elseif($order['state'] == 1)
                                주문취소
                            @elseif($order['state'] == 0)
                                삭제
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagenation">
            {{$orderData->links()}}
        </div>
        @else
            <p>없음</p>
        @endif
    </div>
</div>
@endsection
