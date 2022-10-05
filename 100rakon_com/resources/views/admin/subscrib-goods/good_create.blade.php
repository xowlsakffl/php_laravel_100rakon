@extends('admin.layouts.app')

@section('content')
<div class="section_wrap clearfix">

    <div class="title_box clearfix">
        <div class="title_right">
            <span><a href="{{route('admin.home')}}"><box-icon name='home' type='solid' color='#262b40' style="width:19px;height:19px"></box-icon></a></span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>상품 관리</span>
            <span><box-icon name='chevron-right' color='#262b40' style="padding-top: 3px"></box-icon></span>
            <span>상품 생성</span>
        </div>
    </div>
    <div class="content_wrap">
        <div class="search_warp clearfix">
            <h3>상품 생성</h3>
        </div>
        <div class="main_wrap clearfix">
            <form action="{{route('admin.subscrib-goods.store')}}" method="post" class="add_form" enctype="multipart/form-data">
                @csrf

                <div class="form_add">
                    <label for="">카테고리</label>
                    <select name="sgcdx" class="form_text">
                        @foreach ($categories as $category)
                            <option value="{{$category->sgcdx}}">{{$category->cname}}</option>
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
                    <select name="main_sequence" class="form_text">
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
                    <label for="">제품 구성</label>
                    <select class="form_text" onChange="add_product(this.value)">
                            <option value="">구성 제품 선택</option>
                        @foreach ($products as $product)
                            <option value="{{$product->pdx}}">{{$product->title}} {{$product->name}}</option>
                        @endforeach
                    </select>

                    <div id="id_products">
                    </div>
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

                <div class="form_btn clearfix">
                    <button type="submit">상품 생성</button>
                </div>
            </form>
@endsection

<script>
var productsInfo = [];
@foreach ($products as $product)
    productsInfo[{{$product->pdx}}] = [];
    productsInfo[{{$product->pdx}}][0] = "{{$product->title}} {{$product->name}}";
    productsInfo[{{$product->pdx}}][1] = "{{$product->price}}";
@endforeach

//관려제품 추가
var item_idx = 0;
function add_product(pdx)
{
    if(pdx == "") return;

    item_idx++;
    var item = "";
    item += '<div class="row" data-idx="' + item_idx + '">';
    item += '    <div class="name">&middot; ' + productsInfo[pdx][0] + '</div>';
    item += '    <div class="button">';
    item += '        <button type="button" class="btn btn-secondary" onClick="delete_product(' + item_idx + ')">삭제</button>';
    item += '    </div>';
    item += '    <div class="sequence">';
    item += '        <input type="text" class="form_text" name="sequence[]" placeholder="순서(내림차순)">';
    item += '    </div>';
    item += '    <div class="qpd">';
    item += '        <input type="text" class="form_text" name="quantity_per_delivery[]" placeholder="배송당 수량(숫자)">';
    item += '    </div>';
    item += '    <div class="dpm">';
    item += '        <input type="text" class="form_text" name="delivery_per_month[]" placeholder="월간 배송 횟수(숫자)">';
    item += '    </div>';
    item += '    <div class="basic">';
    item += '        <select class="form_text" name="is_basic[]">';
    item += '           <option value="Y">필수요소</option>';
    item += '           <option value="N">추가요소</option>';
    item += '        </select>';
    item += '    </div>';
    item += '    <div class="normal">';
    item += '        <input type="text" class="form_text" name="unit_price_normal[]" placeholder="정상 단가(숫자)">';
    item += '    </div>';
    item += '    <div class="half">';
    item += '        <input type="text" class="form_text" name="unit_price_half[]" placeholder="6개월 구독 단가(숫자)">';
    item += '    </div>';
    item += '    <div class="year">';
    item += '        <input type="text" class="form_text" name="unit_price_year[]" placeholder="12개월 구독 단가(숫자)">';
    item += '    </div>';
    item += '    <input type="hidden" name="pdx[]" value="' + pdx + '"/>';
    item += '</div>';
    console.log(item);

    // 기존항목 존재여부 확인
    var notExist = true;
    // if($("input[name='pdx[]']").length > 0)
    // {
    //     $("input[name='pdx[]']").each(function(index, item)
    //     {
    //         if($(this).val() == pdx)
    //         {
    //             notExist = false;
    //         }
    //     });
    // }
    if(notExist)
    {
        $("#id_products").append(item);
    }
}

//관려제품 삭제
function delete_product(item_idx)
{
    $("div[data-idx=" + item_idx + "]").remove();
}
</script>
