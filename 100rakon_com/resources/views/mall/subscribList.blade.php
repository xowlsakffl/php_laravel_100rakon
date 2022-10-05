@extends('layouts.mall')
@section('content')
<div class="content_panel">
    <h3 class="sub_title">정기배송</h3>
    <div class="product_box clearfix">
        <ul class="product_list clearfix">
        @foreach ($subscribs as $subscrib)
            <li>
                <a href="{{route('subscrib.show', ['sgdx' => $subscrib->sgdx])}}">
                    <div class="product_img">
                        <img src="storage/{{$subscrib->thumbnail->real_name}}" alt="" width="100%">
                    </div>
                    <div class="product_name">{{$subscrib->title}}</div>
                </a>
            </li>
        @endforeach
        </ul>
    </div>
</div>
@endsection
