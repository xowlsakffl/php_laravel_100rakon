@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>상품 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>특별상품 관리</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>특별상품 생성</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.outstands.store')}}" method="post" class="add_form" enctype="multipart/form-data">
                @csrf

                <div class="form_add">
                    <label for="">카테고리</label>
                    <select name="category" class="form_text">
                        @foreach ($categories as $category)
                            <option value="{{$category->oscdx}}">{{$category->cname}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">정렬순서</label>
                    <select name="sequence" class="form_text">
                        <option value="0">0</option>
                    </select>
                    @error('sequence')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">판매 제목</label>
                    <input type="text" name="title" class="form_text @error('title') is-invalid @enderror" value="{{old('title')}}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">제품명</label>
                    <input type="text" name="name" class="form_text @error('name') is-invalid @enderror" value="{{old('name')}}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">가격</label>
                    <input type="text" name="price" class="form_text @error('price') is-invalid @enderror" value="{{old('price')}}">
                    @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">정상가(프로모션 적용전 가격)</label>
                    <input type="text" name="price_normal" class="form_text @error('price_normal') is-invalid @enderror" value="{{old('price_normal')}}">
                    @error('price_normal')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">재고 수량</label>
                    <input type="text" name="quantity" class="form_text @error('quantity') is-invalid @enderror" value="{{old('quantity')}}">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">소개내용</label>
                    <textarea name="content" class="form_text @error('content') is-invalid @enderror">
                       {{old('content')}}
                    </textarea>
                    @error('content')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">조회수</label>
                    <input type="text" name="hit" class="form_text @error('hit') is-invalid @enderror" value="{{old('hit')}}">
                    @error('hit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">제품제공처</label>
                    <input type="text" name="supply" class="form_text @error('supply') is-invalid @enderror" value="{{old('supply')}}">
                    @error('supply')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">단위당 기본 배송비</label>
                    <input type="text" name="delivery_origin_cost" class="form_text @error('delivery_origin_cost') is-invalid @enderror" value="{{old('delivery_origin_cost')}}">
                    @error('delivery_origin_cost')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">배송정보 필요 여부</label>
                    <select name="need_delivery_info" class="form_text">
                        <option value="1">필요</option>
                        <option value="0">불필요</option>
                    </select>
                    @error('need_delivery_info')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">상태</label>
                    <select name="state" class="form_text">
                        <option value="10">정상</option>
                        <option value="9">대기</option>
                        <option value="0">삭제</option>
                    </select>
                    @error('state')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_add">
                    <label for="">메인이미지 ( 가로 375 X 세로 375 )</label>
                    <input type="file" name="image" class="form_text @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form_btn clearfix">
                    <button type="submit">특별상품 생성</button>
                </div>
            </form>
@endsection
