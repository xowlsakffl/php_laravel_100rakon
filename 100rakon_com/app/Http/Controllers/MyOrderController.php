<?php

namespace App\Http\Controllers;

use App\Outstand;
use App\OutstandOrder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SubscribOrder;
use App\SubscribOrderHistory;
use App\SubscribOrderItem;
use App\SubscribGoodProduct;
use App\Product;

class MyOrderController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //주문내역 페이지
    public function index(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //주문내역 가져오기
        $orders = $user->orders ?? [];

        return view('mall.myorder', ['orders' => $orders]);
    }

    //구독 주문내역 페이지
    public function subscribIndex(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //주문내역 가져오기
        $orders = $user->subscribOrders ?? [];

        //제품내역 가져오기
        $sgProducts = [];
        $products = [];

        foreach($orders AS $key => $order)
        {
            foreach($order->items AS $key2 => $item)
            {
                $sgProducts[$item['soidx']] = SubscribGoodProduct::where('sgpdx', $item['sgpdx'])->first();
                $products[$item['soidx']] = Product::where('pdx', $sgProducts[$item['soidx']]['pdx'])->with('thumbnail')->first();
            }
        }

        return view('mall.myorderSubscrib', ['orders' => $orders, 'sgProducts' => $sgProducts, 'products' => $products]);
    }

    //특별상품 주문내역 페이지 회원
    public function outstandIndex(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        if(!$user){
            return redirect('/myorder-outstand-guest-input');
        }

        //주문내역 가져오기
        $orders = $user->outstandOrders ?? [];

        return view('mall.myorderOutstand', ['orders' => $orders]);
    }

    //특별상품 주문내역 페이지 비회원
    public function outstandGuest(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();

        $orderTel = str_replace('-','',$data['order_tel']);

        $orders = OutstandOrder::where([
            ['udx', '=', NULL],
            ['order_name', '=' , $data['order_name']],
            ['order_tel', '=' , $orderTel],
        ])->get();

        return view('mall.myorderOutstandGuest', ['orders' => $orders]);
    }
    
    //특별상품 주문내역 페이지 비회원
    public function outstandGuestInput()
    {
        return view('mall.myorderOutstandGuestInput');
    }
}
