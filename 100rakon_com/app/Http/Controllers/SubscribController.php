<?php

namespace App\Http\Controllers;

use App\OutstandHistory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\SmsSend;
use App\UserAddress;
use App\SubscribGood;
use App\SubscribGoodProduct;
use App\SubscribOrder;
use App\SubscribOrderItem;
use App\SubscribOrderHistory;

class SubscribController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $subscribs = SubscribGood::with('thumbnail')->paginate(10);
        return view('mall.subscribList', compact('subscribs'));
    }

    public function view($sgdx)
    {
        //상품 가져오기
        $subscrib = SubscribGood::find($sgdx);
        return view('mall.subscribView', ['sgdx' => $sgdx, 'subscrib' => $subscrib]);
    }

    // 구독 주문하기 페이지
    public function order(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();
        $items = [];
        foreach($data['items'] AS $key => $value)
        {
            $item = json_decode($value);
            $subscribGood = SubscribGood::find($data['sgdx']);
            $item->subscribProduct = SubscribGoodProduct::find($item->sgpdx);
            $item->product = $item->subscribProduct->product;
            array_push($items, $item);
        }

        // 상품 가져오기
        return view('mall.subscribOrder', ['user' => $user, 'subscribGood' => $subscribGood, 'term' => $data['term'], 'items' => $items]);
    }

    // 구독 주문 저장
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
        if(sizeof($data['sgpdx']) == 0)
        {
            return ['condition' => false, 'msg' => "구성제품이 필요합니다."];
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
            return ['condition' => false, 'msg' => "입금자 연락처드폰 번호가 필요합니다."];
        }
        if(empty($data['total_amount']))
        {
            return ['condition' => false, 'msg' => "최종 결제금액이 필요합니다."];
        }
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

        // 주문번호 생성
        $todayOrderCount = DB::table('subscrib_orders')->select('sodx')->whereRaw('DATEDIFF(created_at, NOW()) = 0')->get();
        $data['order_number'] = date('Y-m-d-H-').(sizeof($todayOrderCount) +1)."S";

        // 핸드폰 번호 없는 사람 점검
        if($data['save_cell'] == 'Y')
        {
            $user->cell = $data['order_tel'];
            $user->save();
        }
        unset($data['save_cell']);

        // 데이터정리
        $data['udx'] = $user->udx;
        $data['delivery_times'] = $data['term'] * 1;
        $data['pay_amount'] = $data['total_amount'];
        $data['pay_term'] = "월간";
        $data['pay_total_times'] = 1;
        if($data['pay_term'] == "월간")
        {
            $data['pay_total_times'] = $data['term'];
        }
        $data['start_date'] = date("2000-01-01");   // 구독시작일과 구독종료일을 임의로 생성
        $data['end_date'] = date("2000-01-01");
        if(empty($data['delivery_msg']))    //배송메모
        {
            $data['delivery_msg'] = "";
        }

        // 주문 구성정보 분리
        $itemData = [];
        $itemData['sgpdx'] = $data['sgpdx'];        unset($data['sgpdx']);
        $itemData['price'] = $data['price'];        unset($data['price']);
        $itemData['quantity'] = $data['quantity'];  unset($data['quantity']);
        $itemData['amount'] = $data['amount'];      unset($data['amount']);

        foreach($data AS $key => $value)
        {
            if(empty($value))
            {
                unset($data[$key]);
            }
        }

        //주문정보 입력
        $order = SubscribOrder::create($data);

/*         //주문에 따른 자식주문들 정보
        for($i = 0; $i < sizeof($itemData['sgpdx']); $i++)
        {
            $item['sodx'] = $order->sodx;
            $item['sgpdx'] = $itemData['sgpdx'][$i];
            $item['price'] = $itemData['price'][$i];
            $item['quantity'] = $itemData['quantity'][$i];
            $item['amount'] = $itemData['amount'][$i];

            SubscribOrderItem::create($item);
        } */

        // 히스토리 저장
        $history['osodx'] = $order->osodx;
        $history['kind'] = "상태";
        $history['content'] = "주문생성 및 입금대기 처리";
        OutstandHistory::create($history);

        //배송지 정보 입력
        $addr =[];
        $addr['udx'] = $data['udx'];
        $addr['name'] = $data['delivery_name'];
        $addr['tel'] = $data['delivery_tel'];
        $addr['zipcode'] = $data['delivery_zipcode'];
        $addr['address1'] = $data['delivery_address1'];
        $addr['address2'] = $data['delivery_address2'];
        (!empty($data['delivery_msg']))? $addr['msg'] = $data['delivery_msg'] : $addr['msg'] = '';

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
                // 'sender' => '010-7182-7669',
                'sender' => '02-6288-6350',
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
            $params['udx'] = $user->udx;
            $params['odx'] = $order->sodx;
            $params['msg'] = 'S'.$params['msg'];
            $smsRecord = array_merge($params, $result);
            SmsSend::create($smsRecord);
        }

        return ['condition' => true, 'msg' => "주문이 입력되었습니다.", 'order_info' => $data];
    }
}
