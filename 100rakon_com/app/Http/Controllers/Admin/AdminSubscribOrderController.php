<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubscribOrder;
use App\SubscribOrderItem;
use App\SubscribOrderHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminSubscribOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state = $request->state;
        $searchOption = $request->search_option;
        $searchText = $request->search_text;

        if($searchText){
            $orderData = SubscribOrder::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $orderData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $orderData = SubscribOrder::where('state', $state)->latest()->paginate(10);
            $orderData->appends(['state' => $state]);
        }

        if(!$searchText && !$state && $state !== "0"){
            $orderData = SubscribOrder::latest()->paginate(10);
        }

        return view('admin.subscrib-orders.order_list', compact('orderData'))->with('i', (request()->input('page', 1) - 1) * 5);

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
    public function show($sodx)
    {
        $orderData = SubscribOrder::where('sodx', $sodx)->first();
        $orderItems = SubscribOrderItem::where('sodx', $sodx)->paginate(10);
        $orderHistories = SubscribOrderHistory::where('sodx', $sodx);

        return view('admin.subscrib-orders.order_show', compact(['orderData', 'orderItems', 'orderHistories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sodx)
    {
        $orderData = SubscribOrder::where('sodx', $sodx)->first();

        return view('admin.subscrib-orders.order_edit', compact('orderData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sodx)
    {
        $request->validate([
            'order_number' => 'required',
            'total_amount' => 'numeric',
            'use_point' => 'numeric',
            'pay_amount' => 'numeric',
        ],
        [
            'order_number.required' => '판매 제목을 입력해주세요.',
            'total_amount.numeric' => '숫자만 입력해주세요.',
            'use_point.numeric' => '숫자만 입력해주세요.',
            'pay_amount.numeric' => '숫자만 입력해주세요.',
        ]);

        $data = request()->except(['_token', '_method', 'old_state']);
        $credentials = array_filter($data);
        SubscribOrder::where('sodx', $sodx)->update($credentials);

        //상태변화 시 히스토리 입력
        if($request['state'] != $request['old_state'])
        {
            $history['sodx'] = $request['sodx'];
            $history['kind'] = '상태';
            $history['content'] = "[".Auth::user()->name."]님이 [".SubscribOrder::getStateText($request['state'])."]로 상태변경";
            SubscribOrderHistory::create($history);
        }

        flash('주문이 수정되었습니다.')->success();
        return redirect()->route('admin.subscrib-orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sodx)
    {
        $order = SubscribOrder::where('sodx' ,$sodx);
        $order->update(['state' => 0]);
        $order->delete();

        //히스토리 입력
        $history['sodx'] = $sodx;
        $history['kind'] = '상태';
        $history['content'] = "[".Auth::user()->name."]님이 [".SubscribOrder::getStateText(0)."]로 상태변경";
        SubscribOrderHistory::create($history);

        flash('주문이 삭제되었습니다.')->success();
        return redirect()->route('admin.subscrib-orders.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function historyCreate(Request $request)
    {
        $request = request()->all();

        $history['sodx'] = $request['sodx'];
        $history['kind'] = '메모';
        $history['content'] = "[".Auth::user()->name."]님의 메모 : ".$request['content'];
        SubscribOrderHistory::create($history);

        flash('변동 내역이 입력되었습니다.')->success();
        return redirect('/admin/subscrib-orders/'.$request['sodx']);
    }
}
