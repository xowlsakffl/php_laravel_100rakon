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
    @if ($productData)
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>제품 목록</h3>
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <div class="right_btn">
                    <a href="{{route('admin.products.edit', ['pdx' => $productData->pdx])}}">제품 수정</a>
                    <form action="{{route('admin.products.destroy', ['pdx' => $productData->pdx])}}" method="post">
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
                        @if ($productData->thumbnail)
                            <img src="{{asset('storage/'.$productData->thumbnail->real_name)}}" alt="">
                        @endif
                    </dd>
                </dl>
                <dl>
                    <dt>카테고리</dt>
                    <dd>
                        @if ($productData->productCategory)
                            {{$productData->productCategory->cname}}
                        @else
                            카테고리 없음
                        @endif
                        
                    </dd>
                </dl>

                <dl>
                    <dt>정렬 순서</dt>
                    <dd>{{$productData->sequence}}</dd>
                </dl>

                <dl>
                    <dt>판매 제목</dt>
                    <dd>{{$productData->title}}</dd>
                </dl>

                <dl>
                    <dt>제품명</dt>
                    <dd>{{$productData->name}}</dd>
                </dl>

                <dl>
                    <dt>가격</dt>
                    <dd>{{$productData->price}}</dd>
                </dl>

                <dl>
                    <dt>재고 수량</dt>
                    <dd>{{$productData->quantity}}</dd>
                </dl>

                <dl>
                    <dt>조회수</dt>
                    <dd>{{$productData->hit}}</dd>
                </dl>

                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($productData->state == "10")
                            정상
                        @elseif ($productData->state == "9")
                            대기
                        @elseif ($productData->state == "0")
                            삭제
                        @endif   
                    </dd>
                </dl>
                <dl>
                    <dt>정상가(프로모션 적용전 가격)</dt>
                    <dd>{{$productData->price_normal}}</dd>
                </dl>
                <dl>
                    <dt>제품제공처</dt>
                    <dd>{{$productData->supply}}</dd>
                </dl>
                <dl>
                    <dt>단위당 기본 배송비</dt>
                    <dd>{{$productData->delivery_origin_cost}}</dd>
                </dl>
            </div>      
        </div>
        @endif 
    </div>
</div>
@endsection