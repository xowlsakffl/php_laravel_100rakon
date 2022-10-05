@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>제품 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>제품 목록</span>
        </div>
    </div>
    @if ($outstandData)
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>제품 목록</h3>
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <div class="right_btn">
                    <a href="{{route('admin.outstands.edit', ['osdx' => $outstandData->osdx])}}">제품 수정</a>
                    <form action="{{route('admin.outstands.destroy', ['osdx' => $outstandData->osdx])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="제품 삭제">
                    </form>
                </div>
            </div>

            <div class="info_box clearfix" style="border-bottom:none">
                <dl style="width: 100%">
                    <dt>썸네일 이미지</dt>
                    <dd>
                        @if ($outstandData->thumbnail)
                            <img src="{{asset('storage/'.$outstandData->thumbnail->real_name)}}" alt="">
                        @endif
                    </dd>
                </dl>
                <dl>
                    <dt>카테고리</dt>
                    <dd>
                        @if ($outstandData->outstandCategory)
                            {{$outstandData->outstandCategory->cname}}
                        @else
                            카테고리 없음
                        @endif
                        
                    </dd>
                </dl>

                <dl>
                    <dt>정렬 순서</dt>
                    <dd>{{$outstandData->sequence}}</dd>
                </dl>

                <dl>
                    <dt>판매 제목</dt>
                    <dd>{{$outstandData->title}}</dd>
                </dl>

                <dl>
                    <dt>제품명</dt>
                    <dd>{{$outstandData->name}}</dd>
                </dl>

                <dl>
                    <dt>가격</dt>
                    <dd>{{$outstandData->price}}</dd>
                </dl>

                <dl>
                    <dt>재고 수량</dt>
                    <dd>{{$outstandData->quantity}}</dd>
                </dl>

                <dl>
                    <dt>조회수</dt>
                    <dd>{{$outstandData->hit}}</dd>
                </dl>

                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($outstandData->state == "10")
                            정상
                        @elseif ($outstandData->state == "9")
                            대기
                        @elseif ($outstandData->state == "0")
                            삭제
                        @endif   
                    </dd>
                </dl>
                <dl>
                    <dt>정상가(프로모션 적용전 가격)</dt>
                    <dd>{{$outstandData->price_normal}}</dd>
                </dl>
                <dl>
                    <dt>제품제공처</dt>
                    <dd>{{$outstandData->supply}}</dd>
                </dl>
                <dl>
                    <dt>단위당 기본 배송비</dt>
                    <dd>{{$outstandData->delivery_origin_cost}}</dd>
                </dl>
                <dl>
                    <dt>배송정보 필요 여부</dt>
                    <dd>@if ($outstandData->need_delivery_info == "1")
                            필요
                        @else
                            불필요
                        @endif
                    </dd>
                </dl>
                <dl style="width: 100%">
                    <dt>소개 내용</dt>
                    <dd>
                        {{$outstandData->content}}
                    </dd>
                </dl>
            </div>      
        </div>
        @endif 
    </div>
</div>
@endsection