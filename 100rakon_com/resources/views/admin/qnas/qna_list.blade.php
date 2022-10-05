@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">
    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>고객문의</span>
        </div>
    </div>
    @if ($qnaData)
    <div class="search_warp clearfix">
        <h3>고객문의</h3>
        <div class="search_box">
            <form action="{{route('admin.qnas.index')}}" method="get" class="form-inline">
                <div class="search_select">
                    <select name="search_option">                       
                        <option value="name">이름</option>
                        <option value="email">이메일</option>
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
                <li><a href="{{route('admin.qnas.index')}}" class="{{ (\Request::input('state'))==null ? 'active' : '' }}">전체</a></li>
                <li><a href="{{route('admin.qnas.index', ['state' => '10'])}}" class="{{ (\Request::input('state'))=='10' ? 'active' : '' }}">정상</a></li>
                <li><a href="{{route('admin.qnas.index', ['state' => '0'])}}" class="{{ (\Request::input('state'))=='0' ? 'active' : '' }}">삭제</a></li>
            </ul>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>연락처</th>
                    <th>문의내용</th>
                    <th>상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($qnaData as $q)
                    <tr onclick="location.href='{{route('admin.qnas.show', ['idx' => $q['idx']])}}'">
                        <td class="item_num">{{$qnaData->firstItem()+$loop->index}}</td>
                        <td><span>이름</span>{{$q['name']}}</td>
                        <td><span>이메일</span>{{$q['email']}}</td>
                        <td><span>연락처</span>{{$q['tel']}}</td>
                        <td><span>문의내용</span>
                            @php
                             $str = mb_strimwidth($q['content'],0,20,"...", 'utf-8');
                            @endphp
                            {{$str}}
                        </td>
                        <td>
                            <span>상태</span>
                            @if ($q['state'] == 10)
                                정상
                            @elseif($q['state'] == 0)
                                삭제
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation">
            {{$qnaData->links()}}
        </div>
        @else
            <p>없음</p>
        @endif
    </div>
</div>
@endsection