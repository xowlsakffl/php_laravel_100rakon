@extends('layouts.mall')
@section('content')
<div class="content_panel">
    <h3 class="sub_title">제품구매</h3>
    <div class="product_box clearfix">
        {{-- <div class="tab_container">
            <ul class="tab_box">
                <li><button>깊은바다</button></li>
                <li><button>브랜드 1</button></li>
                <li><button>브랜드 2</button></li>
            </ul>
        </div> --}}
        <ul class="product_list clearfix">
        @foreach ($products as $product)
            <li>
                <a href="{{route('product.show', ['pdx' => $product->pdx])}}">

                    <div class="product_img">
                        <img src="storage/{{$product->thumbnail->real_name}}" alt="" width="100%">
                    </div>
                    <div class="product_name">{{$product->name}}</div>
                    @if ($product->price_normal > 0)
                        <div class="product_price">
                            
                            <span class="price Roboto" style="color: #CCC;text-decoration: line-through;margin-bottom: 5px">
                                {{number_format($product->price_normal)}}
                            </span>
                            
                            <span class="price_unit" style="color: #CCC">원</span>
                        </div>
                        <div class="product_price">
                            
                            <span class="price Roboto">
                                {{number_format($product->price)}}
                            </span>
                            
                            <span class="price_unit">원</span>
                        </div>
                    @else
                        <div class="product_price">
                            
                            <span class="price Roboto">
                                {{number_format($product->price)}}
                            </span>
                            
                            <span class="price_unit">원</span>
                            {{-- <span class="price_normal Roboto">
                                {{number_format($product->price_normal)}}
                            </span> --}}
                        </div>
                    @endif
                    
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection
