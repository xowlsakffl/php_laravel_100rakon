@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>제품 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>제품 분류</span>
        </div>
    </div>
    @if ($categoryData)
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>제품 분류</h3>
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <div class="right_btn">
                    <a href="{{route('admin.categories.edit', ['pcdx' => $categoryData->pcdx])}}">분류 수정</a>
                    <form action="{{route('admin.categories.destroy', ['pcdx' => $categoryData->pcdx])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="분류 삭제">
                    </form>
                </div>
            </div>

            <div class="info_box clearfix" style="border-bottom:none">

                <dl>
                    <dt>상위 분류</dt>
                    <dd>
                        @if ($categoryData->parent == 0)
                            최상위 분류
                        @else
                            {{$categoryParent->cname}}
                        @endif
                    </dd>
                </dl>

                <dl>
                    <dt>정렬 순서</dt>
                    <dd>{{$categoryData->sequence}}</dd>
                </dl>

                <dl>
                    <dt>분류명</dt>
                    <dd>{{$categoryData->cname}}</dd>
                </dl>

                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($categoryData->state == "10")
                            정상
                        @elseif ($categoryData->state == "9")
                            대기
                        @elseif ($categoryData->state == "0")
                            삭제
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
