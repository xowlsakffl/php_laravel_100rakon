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
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>고객문의</h3>
        </div>
        <div class="main_wrap clearfix">

            <form action="{{route('admin.qnas.update' ,['idx' => $qnaData->idx])}}" method="post" class="add_form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">이름</label>
                    <input type="text" name="name" class="form_text @error('name') is-invalid @enderror" value="{{$qnaData->name}}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">이메일</label>
                    <input type="text" name="email" class="form_text @error('email') is-invalid @enderror" value="{{$qnaData->email}}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">연락처</label>
                    <input type="text" name="tel" class="form_text @error('tel') is-invalid @enderror" value="{{$qnaData->tel}}">
                    @error('tel')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">소개내용</label>
                    <textarea name="content" class="form_text @error('content') is-invalid @enderror">
                        {{$qnaData->content}}
                    </textarea>
                    @error('content')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">조회수</label>
                    <input type="text" name="hit" class="form_text @error('hit') is-invalid @enderror" value="{{$qnaData->hit}}">
                    @error('hit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="10" @if($qnaData->state === 10) selected @endif>정상</option>
                        <option value="0" @if($qnaData->state === 0) selected @endif>삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">문의 수정</button>
                </div>
            </form>
@endsection
