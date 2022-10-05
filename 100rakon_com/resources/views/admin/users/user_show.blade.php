@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>회원 관리</span>
        </div>
    </div>
    @if ($userData)
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>회원 관리</h3>
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <h4>회원</h4>
                <div class="right_btn">
                    <a href="{{route('admin.users.edit', ['udx' => $userData->udx])}}">회원 수정</a>
                    <form action="{{route('admin.users.destroy', ['udx' => $userData->udx])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="회원 삭제">
                    </form>
                </div>
            </div>

            <div class="info_box clearfix" style="border-bottom:none">

                <dl>
                    <dt>이름</dt>
                    <dd>{{$userData->name}}</dd>
                </dl>

                <dl>
                    <dt>이메일</dt>
                    <dd>{{$userData->email}}</dd>
                </dl>

                <dl>
                    <dt>이메일 인증 여부</dt>
                    <dd>
                        @if ($userData->email_auth == "Y")
                            인증
                        @elseif ($userData->email_auth == "N")
                            미인증
                        @endif
                    </dd>
                </dl>

                <dl>
                    <dt>휴대폰번호</dt>
                    <dd>{{$userData->cell}}</dd>
                </dl>

                <dl>
                    <dt>휴대폰 인증여부</dt>
                    <dd>
                        @if ($userData->cell_auth == "Y")
                            인증
                        @elseif ($userData->cell_auth == "N")
                            미인증
                        @endif
                    </dd>
                </dl>

                <dl>
                    <dt>휴대폰 인증일시</dt>
                    <dd>{{$userData->cell_authed_at}}</dd>
                </dl>

                <dl>
                    <dt>전화번호</dt>
                    <dd>{{$userData->tel}}</dd>
                </dl>

                <dl>
                    <dt>가입경로</dt>
                    <dd>{{$userData->join_from}}</dd>
                </dl>

                <dl>
                    <dt>시스템관리자 여부</dt>
                    <dd>
                        @if ($userData->super == "Y")
                            관리자
                        @elseif ($userData->super == "N")
                            비관리자
                        @endif
                    </dd>
                </dl>

                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($userData->state == "10")
                            정상
                        @elseif ($userData->state == "9")
                            대기
                        @elseif ($userData->state == "8")
                            정지
                        @elseif ($userData->state == "1")
                            탈퇴
                        @elseif ($userData->state == "0")
                            삭제
                        @endif   
                    </dd>
                </dl>

                <dl>
                    <dt>생성일</dt>
                    <dd>{{$userData->created_at}}</dd>
                </dl>

                <dl>
                    <dt>최근 수정일</dt>
                    <dd>{{$userData->updated_at}}</dd>
                </dl>

                <dl>
                    <dt>삭제일</dt>
                    <dd>{{$userData->deleted_at}}</dd>
                </dl>            
            </div>      
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <h4>회원 배송지</h4>
            </div>
            @if ($userAddresses)
                @foreach ($userAddresses as $userAddress)
                <div class="main_wrap_title clearfix">
                    <div class="right_btn">
                        <a href="{{route('admin.user-addresses.edit', ['uadx' => $userAddress->uadx])}}">회원 배송지 수정</a>
                        <form action="{{route('admin.user-addresses.destroy', ['uadx' => $userAddress->uadx])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="회원 배송지 삭제">
                        </form>
                    </div>
                </div>
                    <div class="info_box clearfix" style="border-bottom:none">
                        <dl>
                            <dt>배송지 제목</dt>
                            <dd>{{$userAddress->title}}</dd>
                        </dl>

                        <dl>
                            <dt>우편번호</dt>
                            <dd>{{$userAddress->zipcode}}</dd>
                        </dl>

                        <dl>
                            <dt>기본주소</dt>
                            <dd>{{$userAddress->address1}}</dd>
                        </dl>

                        <dl>
                            <dt>상세주소</dt>
                            <dd>{{$userAddress->address2}}</dd>
                        </dl>

                        <dl>
                            <dt>수령자 이름</dt>
                            <dd>{{$userAddress->name}}</dd>
                        </dl>

                        <dl>
                            <dt>수령자 연락처</dt>
                            <dd>{{$userAddress->tel}}</dd>
                        </dl>

                        <dl>
                            <dt>배송메세지</dt>
                            <dd>{{$userAddress->msg}}</dd>
                        </dl>            
                    </div>  
                    <hr>
                @endforeach   
            @endif    
        </div>

        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <h4>장바구니</h4>
            </div>
            @if ($userBaskets)
                @foreach ($userBaskets as $userBasket)
                    <div class="main_wrap_title clearfix">
                        <div class="right_btn">
                            <a href="{{route('admin.user-baskets.edit', ['obdx' => $userBasket->obdx])}}">회원 장바구니 수정</a>
                            <form action="{{route('admin.user-baskets.destroy', ['obdx' => $userBasket->obdx])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="회원 장바구니 삭제">
                            </form>
                        </div>
                    </div>
                    <div class="info_box clearfix" style="border-bottom:none">
                        <dl>
                            <dt>제품명 / 제품아이디</dt>
                            <dd>{{$userBasket->product->name}} / {{$userBasket->product->pdx}}</dd>
                        </dl>

                        <dl>
                            <dt>적용 가격</dt>
                            <dd>{{$userBasket->price}}</dd>
                        </dl>

                        <dl>
                            <dt>주문 수량</dt>
                            <dd>{{$userBasket->quantity}}</dd>
                        </dl>          
                    </div>  
                    <hr>
                @endforeach   
            @endif    
        </div>

        @endif
        
    </div>
</div>
@endsection