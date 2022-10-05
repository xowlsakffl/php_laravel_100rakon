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
    <div class="content_wrap content_view">
        <div class="search_warp clearfix">
            <h3>고객문의</h3>
        </div>
        <div class="main_wrap clearfix">
            <div class="main_wrap_title clearfix">
                <h4>고객문의</h4>
                <div class="right_btn">
                    <a href="{{route('admin.qnas.edit', ['idx' => $qnaData->idx])}}">문의 수정</a>
                    <form action="{{route('admin.qnas.destroy', ['idx' => $qnaData->idx])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="문의 삭제">
                    </form>
                </div>
            </div>

            <div class="info_box clearfix" style="border-bottom:none">

                <dl>
                    <dt>이름</dt>
                    <dd>{{$qnaData->name}}</dd>
                </dl>

                <dl>
                    <dt>이메일</dt>
                    <dd>{{$qnaData->email}}</dd>
                </dl>

                <dl>
                    <dt>연락처</dt>
                    <dd>{{$qnaData->tel}}</dd>
                </dl>

                <dl>
                    <dt>문의내용</dt>
                    <dd>{{$qnaData->content}}</dd>
                </dl>

                <dl>
                    <dt>조회수</dt>
                    <dd>{{$qnaData->hit}}</dd>
                </dl>
                
                <dl>
                    <dt>상태</dt>
                    <dd>
                        @if ($qnaData->state == "10")
                            정상
                        @elseif ($qnaData->state == "0")
                            삭제
                        @endif   
                    </dd>
                </dl>

                <dl>
                    <dt>문의일자</dt>
                    <dd>{{$qnaData->created_at}}</dd>
                </dl>

                <dl>
                    <dt>최근 수정일</dt>
                    <dd>{{$qnaData->updated_at}}</dd>
                </dl>

                <dl>
                    <dt>삭제일자</dt>
                    <dd>{{$qnaData->deleted_at}}</dd>
                </dl>            
            </div>      
        </div>

        @endif
        
    </div>
</div>
@endsection