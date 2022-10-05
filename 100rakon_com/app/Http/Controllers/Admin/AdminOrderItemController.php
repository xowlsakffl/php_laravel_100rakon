<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OrderItem;
use Illuminate\Http\Request;

class AdminOrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($oidx)
    {
        $orderItemData = OrderItem::where('oidx', $oidx)->first();
        
        return view('admin.orderitems.orderitem_edit', compact('orderItemData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $oidx)
    {
        
        
        $request->validate([
            'price' => 'numeric',      
            'quantity' => 'numeric',
            'amount' => 'numeric',
            'delivery_origin_cost' => 'numeric|max:9999',
            'delivery_pay' => 'numeric|max:9999',
        ],
        [
            'price.numeric' => '숫자만 입력해주세요.',
            'quantity.numeric' => '숫자만 입력해주세요.',
            'amount.numeric' => '숫자만 입력해주세요.',
            'delivery_origin_cost.numeric' => '숫자만 입력해주세요.',
            'delivery_origin_cost.max' => '5자 까지 입력가능합니다.',
            'delivery_pay.numeric' => '숫자만 입력해주세요.',
            'delivery_pay.max' => '5자 까지 입력가능합니다.',
        ]);

        $data = request()->except(['_token', '_method']);
        $credentials = array_filter($data);

        $orderItem = OrderItem::where('oidx', $oidx)->first();
        $orderItem->update($credentials);

        flash('주문 제품이 수정되었습니다.')->success();
        return redirect()->route('admin.orders.show', $orderItem->odx);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($oidx)
    {
        $orderItem = OrderItem::where('oidx' ,$oidx)->first();
        $orderItem->delete();
        
        flash('주문 제품이 삭제되었습니다.')->success();
        return redirect()->route('admin.orders.show', $orderItem->odx);
    }
}
