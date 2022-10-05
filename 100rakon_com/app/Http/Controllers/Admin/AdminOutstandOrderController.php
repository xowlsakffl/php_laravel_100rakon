<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OutstandHistory;
use App\OutstandOrder;
use App\SmsSend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOutstandOrderController extends Controller
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
            $orderData = OutstandOrder::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $orderData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $orderData = OutstandOrder::where('state', $state)->latest()->paginate(10);
            $orderData->appends(['state' => $state]);
        }

        if(!$searchText && !$state && $state !== "0"){
            $orderData = OutstandOrder::latest()->paginate(10);
        }

        return view('admin.outstand-orders.order_list', compact('orderData'))->with('i', (request()->input('page', 1) - 1) * 5);

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
    public function show($osodx)
    {
        $orderData = OutstandOrder::where('osodx', $osodx)->first();
        $orderHistories = OutstandHistory::where('osodx', $osodx);

        return view('admin.outstand-orders.order_show', compact(['orderData', 'orderHistories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($osodx)
    {
        $orderData = OutstandOrder::where('osodx', $osodx)->first();

        return view('admin.outstand-orders.order_edit', compact('orderData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $osodx)
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
        OutstandOrder::where('osodx', $osodx)->update($credentials);

        //상태변화 시 히스토리 입력
        if($request['state'] != $request['old_state'])
        {
            $history['osodx'] = $request['osodx'];
            $history['kind'] = '상태';
            $history['content'] = "[".Auth::user()->name."]님이 [".OutstandOrder::getStateText($request['state'])."]로 상태변경";
            OutstandHistory::create($history);

            if($request['state'] == 9){
                $params =   [
                        'user_id' => '100rakon',
                        'key' => '5vfdzjv49p6auyo8tt4p04umiuf9cdk0',
                        'msg' => '백락온 입금완료알림 - 주문확인방법 https://100rakon.com/myorder-outstand',
                        'receiver' => $data['pay_tel'].",010-7182-7669",
                        'sender' => '02-6288-6350',
                        // 'sender' => '010-7182-7669',
                        'rdate' => '',
                        'rtime' => '',
                        'testmode_yn' => 'N',
                        'subject' => '',
                        'image' => '',
                        'msg_type' => 'SMS',
                    ];
                $ch = curl_init('https://apis.aligo.in/send/');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = json_decode(curl_exec($ch), true);
                curl_close($ch);

                // DB 저장
                $user = Auth::user();
                $params['udx'] = $user->udx;
                $smsRecord = array_merge($params, $result);
                SmsSend::create($smsRecord);
            }
        }

        flash('주문이 수정되었습니다.')->success();
        return redirect()->route('admin.outstand-orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($osodx)
    {
        $order = OutstandOrder::where('osodx' ,$osodx);
        $order->update(['state' => 0]);
        $order->delete();

        //히스토리 입력
        $history['osodx'] = $osodx;
        $history['kind'] = '상태';
        $history['content'] = "[".Auth::user()->name."]님이 [".OutstandOrder::getStateText(0)."]로 상태변경";
        OutstandHistory::create($history);

        flash('주문이 삭제되었습니다.')->success();
        return redirect()->route('admin.outstand-orders.index');
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

        $history['osodx'] = $request['osodx'];
        $history['kind'] = '메모';
        $history['content'] = "[".Auth::user()->name."]님의 메모 : ".$request['content'];
        OutstandHistory::create($history);

        flash('변동 내역이 입력되었습니다.')->success();
        return redirect('/admin/outstand-orders/'.$request['osodx']);
    }
}
