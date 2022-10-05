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
    <div class="search_warp clearfix">
        <h3>제품 분류</h3>
        <div class="search_box">
            <form action="{{route('admin.categories.index')}}" method="get" class="form-inline">
                <div class="search_select">
                    <select name="search_option">                       
                        <option value="cname">분류명</option>
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
                <li><a href="{{route('admin.categories.index')}}" class="{{ (\Request::input('state'))==null ? 'active' : '' }}">전체</a></li>
                <li><a href="{{route('admin.categories.index', ['state' => '10'])}}" class="{{ (\Request::input('state'))=='10' ? 'active' : '' }}">정상</a></li>
                <li><a href="{{route('admin.categories.index', ['state' => '9'])}}" class="{{ (\Request::input('state'))=='9' ? 'active' : '' }}">대기</a></li>
                <li><a href="{{route('admin.categories.index', ['state' => '0'])}}" class="{{ (\Request::input('state'))=='0' ? 'active' : '' }}">삭제</a></li>
            </ul>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>분류명</th>
                    <th>상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryData as $category)
                    <tr onclick="location.href='{{route('admin.categories.show', ['pcdx' => $category['pcdx']])}}'">
                        <td class="item_num">{{$categoryData->firstItem()+$loop->index}}</td>
                        <td><span>분류명</span>{{$category['cname']}}</td>
                        <td>
                            <span>상태</span>
                            @if ($category['state'] == 10)
                                정상
                            @elseif($category['state'] == 9)
                                대기
                            @elseif($category['state'] == 0)
                                삭제
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation">
            {{$categoryData->links()}}
        </div>
        <div class="form_btn clearfix">
            <a href="{{route('admin.categories.create')}}">분류 생성</button>
        </div>
        @else
            <p>없음</p>
        @endif
    </div>
</div>
@endsection