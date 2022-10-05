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
    <div class="search_warp clearfix">
        <h3>회원 관리</h3>
        <div class="search_box">
            <form action="{{route('admin.users.index')}}" method="get" class="form-inline">
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
                <li><a href="{{route('admin.users.index')}}" class="{{ (\Request::input('state'))==null ? 'active' : '' }}">전체</a></li>
                <li><a href="{{route('admin.users.index', ['state' => '10'])}}" class="{{ (\Request::input('state'))=='10' ? 'active' : '' }}">정상</a></li>
                <li><a href="{{route('admin.users.index', ['state' => '9'])}}" class="{{ (\Request::input('state'))=='9' ? 'active' : '' }}">대기</a></li>
                <li><a href="{{route('admin.users.index', ['state' => '8'])}}" class="{{ (\Request::input('state'))=='8' ? 'active' : '' }}">정지</a></li>
                <li><a href="{{route('admin.users.index', ['state' => '1'])}}" class="{{ (\Request::input('state'))=='1' ? 'active' : '' }}">탈퇴</a></li>
                <li><a href="{{route('admin.users.index', ['state' => '0'])}}" class="{{ (\Request::input('state'))=='0' ? 'active' : '' }}">삭제</a></li>
            </ul>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>휴대폰 번호</th>
                    <th>가입경로</th>
                    <th>상태</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userData as $u)
                    <tr onclick="location.href='{{route('admin.users.show', ['udx' => $u['udx']])}}'">
                        <td class="item_num">{{$userData->firstItem()+$loop->index}}</td>
                        <td><span>이름</span>{{$u['name']}}</td>
                        <td><span>이메일</span>{{$u['email']}}</td>
                        <td><span>휴대폰 번호</span>{{$u['cell']}}</td>
                        <td><span>가입경로</span>{{$u['join_from']}}</td>
                        <td>
                            <span>상태</span>
                            @if ($u['state'] == 10)
                                정상
                            @elseif($u['state'] == 9)
                                대기
                            @elseif($u['state'] == 8)
                                정지
                            @elseif($u['state'] == 1)
                                탈퇴
                            @elseif($u['state'] == 0)
                                삭제
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagenation">
            {{$userData->links()}}
        </div>
        @else
            <p>없음</p>
        @endif
    </div>
</div>
@endsection