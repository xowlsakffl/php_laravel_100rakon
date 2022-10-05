<?php

namespace App\Http\Controllers;

use App\SmsSend;
use App\Outstand;
use App\UserAddress;
use App\OutstandItem;
use App\OutstandOrder;
use App\OutstandHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OutstandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outstands = Outstand::with('thumbnail')->paginate(10);

        return view('mall.outstandList', compact('outstands'));
    }

    public function view($osdx)
    {
        $outstand = Outstand::find($osdx);

        return view('mall.outstandView', ['osdx' => $osdx, 'outstand' => $outstand]);
    }

    public function direct($osdx, $quantity)
    {
        $outstand = Outstand::find($osdx);

        return view('mall.outstandDirect', ['outstand' => $outstand, 'quantity' => $quantity]);
    }

    public function order(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();
        
        //제품 없으면 되돌림
        if(sizeof($data['osdx']) == 0)
        {
            return "제품이 필요합니다.";
        }
        
        //주문정보 재설정
        $items = [];
        $toal_amount = 0;
        for($i = 0; $i < sizeof($data['osdx']); $i++)
        {
            $items[$i]['osdx'] = $data['osdx'][$i];
            $items[$i]['price'] = $data['price'][$i];
            $items[$i]['quantity'] = $data['quantity'][$i];
            $items[$i]['delivery_selected_policy'] = $data['delivery_selected_policy'][$i];
            $items[$i]['delivery_origin_cost'] = $data['delivery_origin_cost'][$i];
            $items[$i]['delivery_pay'] = $data['delivery_pay'][$i];
            $items[$i]['item_amount'] = $data['item_amount'][$i];
            $items[$i]['outstand'] = Outstand::find($data['osdx'][$i]);
            $items[$i]['need_delivery_info'] = $data['need_delivery_info'][$i];

            $toal_amount = $toal_amount + $data['item_amount'][$i];
        }

        return view('mall.outstandOrder', ['items' => $items, 'total_amount' => $toal_amount, 'user' => $user]);
    }

    //주문저장
    public function save(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //필요정보 확인
        if(empty($data['order_name']))
        {
            return ['condition' => false, 'msg' => "주문자명이 필요합니다."];
        }
        if(empty($data['order_tel']))
        {
            return ['condition' => false, 'msg' => "주문자 연락처가 필요합니다."];
        }
        if(sizeof($data['osdx']) == 0)
        {
            return ['condition' => false, 'msg' => "제품이 필요합니다."];
        }
        if(empty($data['pay_name']))
        {
            return ['condition' => false, 'msg' => "입급자명이 필요합니다."];
        }
        if(empty($data['pay_kind']))
        {
            return ['condition' => false, 'msg' => "결제방식이 필요합니다."];
        }
        if(empty($data['pay_tel']))
        {
            return ['condition' => false, 'msg' => "입금자 연락처가 필요합니다."];
        }
        if(empty($data['total_amount']))
        {
            return ['condition' => false, 'msg' => "최종 결제금액이 필요합니다."];
        }
        if($data['need_delivery_info'][0] == true){
            if(empty($data['delivery_zipcode']))
            {
                return ['condition' => false, 'msg' => "배송지 우편번호가 필요합니다."];
            }
            if(empty($data['delivery_address1']))
            {
                return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
            }
            if(empty($data['delivery_address2']))
            {
                return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
            }
            if(empty($data['delivery_name']))
            {
                return ['condition' => false, 'msg' => "배송지 수령자 이름이 필요합니다."];
            }
            if(empty($data['delivery_tel']))
            {
                return ['condition' => false, 'msg' => "배송지 연락처가 필요합니다."];
            }
        }
        if(empty($data['receipt_kind']))
        {
            return ['condition' => false, 'msg' => "영수증 종류가 필요합니다."];
        }

        //무통장 입금일 경우
        if($data['pay_kind'] == '무통장')
        {
            //영수증 종류에 따른 필요정보
            if($data['receipt_kind'] == "세금계산서")
            {
                if(empty($data['company_regist_number']))
                {
                    return ['condition' => false, 'msg' => "사업자번호가 필요합니다."];
                }
                if(empty($data['company_name']))
                {
                    return ['condition' => false, 'msg' => "상호가 필요합니다."];
                }
                if(empty($data['company_president_name']))
                {
                    return ['condition' => false, 'msg' => "대표명이 필요합니다."];
                }
                if(empty($data['company_kind1']))
                {
                    return ['condition' => false, 'msg' => "업태가 필요합니다."];
                }
                if(empty($data['company_kind2']))
                {
                    return ['condition' => false, 'msg' => "종목이 필요합니다."];
                }
                if(empty($data['company_charge_email']))
                {
                    return ['condition' => false, 'msg' => "담당자 이메일이 필요합니다."];
                }
                if(empty($data['company_address']))
                {
                    return ['condition' => false, 'msg' => "회사 주소가 필요합니다."];
                }
                $data['person_name'] = "";
                $data['person_unique_number'] = "";
            }
            if($data['receipt_kind'] == "현금영수증")
            {
                if(empty($data['person_name']))
                {
                    return ['condition' => false, 'msg' => "대상자명이 필요합니다."];
                }
                if(empty($data['person_unique_number']))
                {
                    return ['condition' => false, 'msg' => "고유번호가 필요합니다.(사업자번호, 핸드폰번호, 주민번호)"];
                }
                $data['company_regist_number'] = "";
                $data['company_name'] = "";
                $data['company_president_name'] = "";
                $data['company_kind1'] = "";
                $data['company_kind2'] = "";
                $data['company_charge_email'] = "";
                $data['company_address'] = "";
            }
        }else{
            //무통장이 아닌경우 영수증 종류 없음
            $data['receipt_kind'] = "";
        }

        // 핸드폰 번호 없는 사람 점검
        if($data['save_cell'] == 'Y')
        {
            $user->cell = $data['order_tel'];
            $user->save();
        }
        unset($data['save_cell']);

        //데이터정리
        if($user){
            $data['udx'] = $user->udx;
        }
        
        $data['pay_amount'] = $data['total_amount'];
        if(empty($data['delivery_msg']))    //배송메모
        {
            $data['delivery_msg'] = "";
        }
        
        //주문번호 생성
        $todayOrderCount = DB::table('outstand_orders')->select('osodx')->whereRaw('DATEDIFF(created_at, NOW()) = 0')->get();
        $data['order_number'] = date('Y-m-d-H-').(sizeof($todayOrderCount) +1)."OS";
        
        foreach($data AS $key => $value)
        {
            if(empty($value))
            {
                unset($data[$key]);
            }
        }
        //주문정보 입력
        $order = OutstandOrder::create($data);
        
        //주문에 따른 자식주문들 정보
        for($i = 0; $i < sizeof($data['osdx']); $i++)
        {
            $item['osodx'] = $order->osodx;
            $item['osdx'] = $data['osdx'][$i];
            $item['price'] = $data['price'][$i];
            $item['quantity'] = $data['quantity'][$i];
            $item['amount'] = $data['item_amount'][$i];
            $item['delivery_origin_cost'] = $data['delivery_origin_cost'][$i];
            $item['delivery_kind'] = $data['delivery_selected_policy'][$i];
            $item['delivery_pay'] = $data['delivery_pay'][$i];

            OutstandItem::create($item);
        }

        // 히스토리 저장
        $history['osodx'] = $order->osodx;
        $history['kind'] = "상태";
        $history['content'] = "주문생성 및 입금대기 처리";
        OutstandHistory::create($history);

        if($user && $data['need_delivery_info'] == 1){       
            //배송지 정보 입력
            $addr =[];
            $addr['udx'] = $data['udx'];
            $addr['name'] = $data['delivery_name'];
            $addr['tel'] = $data['delivery_tel'];
            $addr['zipcode'] = $data['delivery_zipcode'];
            $addr['address1'] = $data['delivery_address1'];
            $addr['address2'] = $data['delivery_address2'];
            $addr['msg'] = $data['delivery_msg'];

            //기존에 같은 주소 있는지 검색 후 업으면 입력
            $existAddress = UserAddress::where([
                ['udx', '=', $addr['udx']],
                ['name', '=', $addr['name']],
                ['tel', '=', $addr['tel']],
                ['zipcode', '=', $addr['zipcode']],
                ['address1', '=', $addr['address1']],
                ['address2', '=', $addr['address2']],
            ])->first();
            if(empty($existAddress))
            {
                UserAddress::create($addr);
            }
        }

        //무통장의 경우 문자메세지 전송
        if($data['pay_kind'] == '무통장')
        {
            //문자메세지 전송
            $params =
            [
                'user_id' => '100rakon',
                'key' => '5vfdzjv49p6auyo8tt4p04umiuf9cdk0',
                'msg' => $data['pay_name'].'님 하나은행 176-910036-83704 ㈜백락온으로 '.number_format($data['total_amount']).'원 입금바랍니다.',
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
            if($user){
                $params['udx'] = $user->udx;
            }
            
            $params['osdx'] = $order->osdx;
            $smsRecord = array_merge($params, $result);
            SmsSend::create($smsRecord);
        }

        return ['condition' => true, 'msg' => "주문이 입력되었습니다."];
    }

    //토스결제 웹훅
    public function payTossWebHook(Request $request)
    {
        //초기 데이터 설정
        $reqDatas = $request->all();

        return $reqDatas;
    }
}
