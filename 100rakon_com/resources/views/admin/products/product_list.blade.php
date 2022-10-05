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
    <div class="search_warp clearfix">
        <h3>제품 목록</h3>
        <div class="search_box">
            <form action="{{route('admin.products.index')}}" method="get" class="form-inline">
                <div class="search_select">
                    <select name="search_option">            
                        <option value="title">제목</option>           
                        <option value="name">제품명</option>
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
                <li><a href="{{route('admin.products.index')}}" class="{{ (\Request::input('state'))==null ? 'active' : '' }}">전체</a></li>
                <li><a href="{{route('admin.products.index', ['state' => '10'])}}" class="{{ (\Request::input('state'))=='10' ? 'active' : '' }}">정상</a></li>
                <li><a href="{{route('admin.products.index', ['state' => '9'])}}" class="{{ (\Request::input('state'))=='9' ? 'active' : '' }}">대기</a></li>
                <li><a href="{{route('admin.products.index', ['state' => '0'])}}" class="{{ (\Request::input('state'))=='0' ? 'active' : '' }}">삭제</a></li>
            </ul>
            <hr>
            <ul class="clearfix">
                <li><a href="{{route('admin.products.index')}}" class="{{ (\Request::input('category')) == null ? 'active' : '' }}">전체</a></li>
                @foreach ($categories as $category)
                    <li><a href="{{route('admin.products.index', ['category' => $category->pcdx])}}" class="{{ (\Request::input('category')) == $category->pcdx ? 'active' : '' }}">{{$category->cname}}</a></li>
                @endforeach
                
            </ul>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>썸네일</th>
                    <th>판매 제목</th>                   
                    <th>제품명</th>
                    <th>가격</th>
                    <th>조회수</th>
                    <th>상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productData as $product)
                    <tr onclick="location.href='{{route('admin.products.show', ['pdx' => $product['pdx']])}}'">
                        <td>{{$productData->firstItem()+$loop->index}}</td>
                        <td>
                            @if ($product->thumbnail)
                                <img src="{{asset('storage/'.$product->thumbnail->real_name)}}" width="80px" alt="" class="img-fluid">
                            @else
                                <img src="/images/noimage.jpg" width="80px" alt="" class="img-fluid">
                            @endif
                            
                        </td>
                        <td>{{$product['title']}}</td>
                        <td>{{$product['name']}}</td>
                        <td>{{$product['price']}}</td>
                        <td>{{$product['hit']}}</td>
                        <td>
                            @if ($product['state'] == 10)
                                정상
                            @elseif($product['state'] == 9)
                                대기
                            @elseif($product['state'] == 0)
                                삭제
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="pagenation">
            {{$productData->links()}}
        </div>
        <div class="form_btn clearfix">
            <a href="{{route('admin.products.create')}}">제품 생성</button>
        </div>
        @else
            <p>없음</p>
        @endif
    </div>
</div>
@endsection