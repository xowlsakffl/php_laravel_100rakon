@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>특별상품 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>상품 분류</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>상품 분류</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.outstand-categories.update' ,['oscdx' => $categoryData->oscdx])}}" method="post" class="add_form">
                @csrf
                @method('PUT')

                <div class="form_add">
                    <label for="">분류명</label>
                    <input type="text" name="cname" class="form_text @error('cname') is-invalid @enderror" value="{{$categoryData->cname}}">
                    @error('cname')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상위 분류</label>
                    <select name="category" class="form_text">
                        @foreach ($categories as $category)
                            <option value="{{$category->oscdx}}" @if($category->cname === $categoryData->cname) selected @endif>{{$category->cname}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="10" @if($categoryData->state === 10) selected @endif>정상</option>
                        <option value="9" @if($categoryData->state === 9) selected @endif>대기</option>
                        <option value="0" @if($categoryData->state === 0) selected @endif>삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">분류 수정</button>
                </div>
            </form>
@endsection
