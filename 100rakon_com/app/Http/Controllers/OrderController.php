<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\OrderBasket;
use App\File;
use App\Order;
use App\OrderItem;
use App\OrderHistory;
use App\Product;
use App\SmsSend;
use App\UserAddress;
use App\PayTossTransaction;
use App\SubscribOrder;
use App\SubscribOrderHistory;

class OrderController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //주문하기 페이지
    public function order(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //제품 없으면 되돌림
        if(sizeof($data['pdx']) == 0)
        {
            return "제품이 필요합니다.";
        }

        //주문정보 재설정
        $items = [];
        $toal_amount = 0;
        for($i = 0; $i < sizeof($data['pdx']); $i++)
        {
            $items[$i]['pdx'] = $data['pdx'][$i];
            $items[$i]['price'] = $data['price'][$i];
            $items[$i]['quantity'] = $data['quantity'][$i];
            $items[$i]['delivery_selected_policy'] = $data['delivery_selected_policy'][$i];
            $items[$i]['delivery_origin_cost'] = $data['delivery_origin_cost'][$i];
            $items[$i]['delivery_pay'] = $data['delivery_pay'][$i];
            $items[$i]['item_amount'] = $data['item_amount'][$i];
            $items[$i]['product'] = Product::find($data['pdx'][$i]);

            $toal_amount = $toal_amount + $data['item_amount'][$i];
        }

        return view('mall.order', ['items' => $items, 'total_amount' => $toal_amount, 'user' => $user]);
    }

    //주문저장
    public function orderSave(Request $request)
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
        if(sizeof($data['pdx']) == 0)
        {
            return ['condition' => false, 'msg' => "제품이 필요합니다."];
        }
        if(empty($data['pay_kind']))
        {
            return ['condition' => false, 'msg' => "결제방식이 필요합니다."];
        }
        if(empty($data['pay_name']))
        {
            return ['condition' => false, 'msg' => "입급(결제)자명이 필요합니다."];
        }
        if(empty($data['pay_tel']))
        {
            return ['condition' => false, 'msg' => "입금자 연락처가 필요합니다."];
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

        // 핸드폰 번호 없는 사람 점검
        if($data['save_cell'] == 'Y')
        {
            $user->cell = $data['order_tel'];
            $user->save();
        }
        unset($data['save_cell']);

        //데이터정리
        $data['udx'] = $user->udx;
        $data['pay_amount'] = $data['total_amount'];
        if(empty($data['delivery_msg']))    //배송메모
        {
            $data['delivery_msg'] = "";
        }

        //주문번호 생성
        $todayOrderCount = DB::table('orders')->select('odx')->whereRaw('DATEDIFF(created_at, NOW()) = 0')->get();
        $data['order_number'] = date('Y-m-d-H-').(sizeof($todayOrderCount) +1);

        foreach($data AS $key => $value)
        {
            if(empty($value))
            {
                unset($data[$key]);
            }
        }

        //주문정보 입력
        $order = Order::create($data);

        //주문에 따른 자식주문들 정보
        for($i = 0; $i < sizeof($data['pdx']); $i++)
        {
            $item['odx'] = $order->odx;
            $item['pdx'] = $data['pdx'][$i];
            $item['price'] = $data['price'][$i];
            $item['quantity'] = $data['quantity'][$i];
            $item['amount'] = $data['item_amount'][$i];
            $item['delivery_origin_cost'] = $data['delivery_origin_cost'][$i];
            $item['delivery_kind'] = $data['delivery_selected_policy'][$i];
            $item['delivery_pay'] = $data['delivery_pay'][$i];

            OrderItem::create($item);
        }

        // 히스토리 저장
        $history['odx'] = $order->odx;
        $history['kind'] = "상태";
        $history['content'] = "주문생성 및 입금대기 처리";
        OrderHistory::create($history);

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
            $params['udx'] = $user->udx;
            $params['odx'] = $order->odx;
            $smsRecord = array_merge($params, $result);
            SmsSend::create($smsRecord);
        }

        return ['condition' => true, 'msg' => "주문이 입력되었습니다.", 'order_info' => $data];
    }

    // //토스결제 성공 또는 가상계좌 발급성공 시 콜백 ( TossController 로 이전 )
    // public function payTossSuccess(Request $request)
    // {
    //     //초기 데이터 설정
    //     $reqDatas = $request->all();
    //     $user = Auth::user();

    //     $paymentKey = $reqDatas['paymentKey'];
    //     $orderId = $reqDatas['orderId'];
    //     $amount = $reqDatas['amount'];

    //     $secretKey = env("TOSS_SECRET_KEY");
    //     $url = 'https://api.tosspayments.com/v1/payments/' . $paymentKey;

    //     $data = ['orderId' => $orderId, 'amount' => $amount];
    //     $credential = base64_encode($secretKey . ':');
    //     $curlHandle = curl_init($url);
    //     curl_setopt_array($curlHandle, [
    //         CURLOPT_POST => TRUE,
    //         CURLOPT_RETURNTRANSFER => TRUE,
    //         CURLOPT_HTTPHEADER => [
    //             'Authorization: Basic ' . $credential,
    //             'Content-Type: application/json'
    //         ],
    //         CURLOPT_POSTFIELDS => json_encode($data)
    //     ]);
    //     $response = curl_exec($curlHandle);
    //     $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
    //     $isSuccess = $httpCode == 200;
    //     $responseArray = json_decode($response, true);
    //     if($isSuccess)
    //     {
    //         //null 항목 제거
    //         foreach($responseArray AS $key => $value)
    //         {
    //             if(empty($value))
    //             {
    //                 unset($responseArray[$key]);
    //             }
    //         }

    //         //카드 전용 내용
    //         if(!empty($responseArray['card']))
    //         {
    //             if(!empty($responseArray['card']['company'])){                  $responseArray['card_company'] = $responseArray['card']['company'];    }
    //             if(!empty($responseArray['card']['number'])){                   $responseArray['card_number'] = $responseArray['card']['number'];    }
    //             if(!empty($responseArray['card']['installmentPlanMonths'])){    $responseArray['card_installmentPlanMonths'] = $responseArray['card']['installmentPlanMonths'];    }
    //             if(!empty($responseArray['card']['isInterestFree'])){           $responseArray['card_isInterestFree'] = $responseArray['card']['isInterestFree'];    }
    //             if(!empty($responseArray['card']['approveNo'])){                $responseArray['card_approveNo'] = $responseArray['card']['approveNo'];    }
    //             if(!empty($responseArray['card']['useCardPoint'])){             $responseArray['card_useCardPoint'] = $responseArray['card']['useCardPoint'];    }
    //             if(!empty($responseArray['card']['cardType'])){                 $responseArray['card_cardType'] = $responseArray['card']['cardType'];    }
    //             if(!empty($responseArray['card']['ownerType'])){                $responseArray['card_ownerType'] = $responseArray['card']['ownerType'];    }
    //             if(!empty($responseArray['card']['acquireStatus'])){            $responseArray['card_acquireStatus'] = $responseArray['card']['acquireStatus'];    }
    //             if(!empty($responseArray['card']['receiptUrl'])){               $responseArray['card_receiptUrl'] = $responseArray['card']['receiptUrl'];    }
    //         }
    //         //가상계좌 전용 내용
    //         if(!empty($responseArray['virtualAccount']))
    //         {
    //             if(!empty($responseArray['virtualAccount']['accountType'])){        $responseArray['virtual_accountType'] = $responseArray['virtualAccount']['accountType'];    }
    //             if(!empty($responseArray['virtualAccount']['accountNumber'])){      $responseArray['virtual_accountNumber'] = $responseArray['virtualAccount']['accountNumber'];    }
    //             if(!empty($responseArray['virtualAccount']['bank'])){               $responseArray['virtual_bank'] = $responseArray['virtualAccount']['bank'];    }
    //             if(!empty($responseArray['virtualAccount']['customerName'])){       $responseArray['virtual_customerName'] = $responseArray['virtualAccount']['customerName'];    }
    //             if(!empty($responseArray['virtualAccount']['dueDate'])){            $responseArray['virtual_dueDate'] = $responseArray['virtualAccount']['dueDate'];    }
    //             if(!empty($responseArray['virtualAccount']['refundStatus'])){       $responseArray['virtual_refundStatus'] = $responseArray['virtualAccount']['refundStatus'];    }
    //             if(!empty($responseArray['virtualAccount']['expired'])){            $responseArray['virtual_expired'] = $responseArray['virtualAccount']['expired'];    }
    //             if(!empty($responseArray['virtualAccount']['settlementStatus'])){   $responseArray['virtual_settlementStatus'] = $responseArray['virtualAccount']['settlementStatus'];    }
    //         }
    //         //실시간이체 전용 내용
    //         if(!empty($responseArray['transfer']))
    //         {
    //             if(!empty($responseArray['transfer']['bank'])){               $responseArray['transfer_bank'] = $responseArray['transfer']['bank'];    }
    //             if(!empty($responseArray['transfer']['settlementStatus'])){   $responseArray['transfer_settlementStatus'] = $responseArray['transfer']['settlementStatus'];    }
    //         }
    //         //핸드폰 결제 전용 내용
    //         if(!empty($responseArray['mobilePhone']))
    //         {
    //             if(!empty($responseArray['mobilePhone']['carrier'])){               $responseArray['mobile_bank'] = $responseArray['mobilePhone']['carrier'];    }
    //             if(!empty($responseArray['mobilePhone']['customerMobilePhone'])){   $responseArray['mobile_customerMobilePhone'] = $responseArray['mobilePhone']['customerMobilePhone'];    }
    //             if(!empty($responseArray['mobilePhone']['settlementStatus'])){   $responseArray['mobile_settlementStatus'] = $responseArray['mobilePhone']['settlementStatus'];    }
    //         }
    //         //상품권 전용 내용
    //         if(!empty($responseArray['giftCertificate']))
    //         {
    //             if(!empty($responseArray['giftCertificate']['approveNo'])){               $responseArray['gift_approveNo'] = $responseArray['giftCertificate']['approveNo'];    }
    //             if(!empty($responseArray['giftCertificate']['settlementStatus'])){   $responseArray['gift_settlementStatus'] = $responseArray['giftCertificate']['settlementStatus'];    }
    //         }
    //         //현금영수증 전용 내용
    //         if(!empty($responseArray['cashReceipt']))
    //         {
    //             if(!empty($responseArray['cashReceipt']['type'])){           $responseArray['cashRct_type'] = $responseArray['cashReceipt']['type'];    }
    //             if(!empty($responseArray['cashReceipt']['amount'])){         $responseArray['cashRct_amount'] = $responseArray['cashReceipt']['amount'];    }
    //             if(!empty($responseArray['cashReceipt']['taxFreeAmount'])){  $responseArray['cashRct_taxFreeAmount'] = $responseArray['cashReceipt']['taxFreeAmount'];    }
    //             if(!empty($responseArray['cashReceipt']['issueNumber'])){    $responseArray['cashRct_issueNumber'] = $responseArray['cashReceipt']['issueNumber'];    }
    //             if(!empty($responseArray['cashReceipt']['receiptUrl'])){     $responseArray['cashRct_receiptUrl'] = $responseArray['cashReceipt']['receiptUrl'];    }
    //         }
    //         //취소관련 내용
    //         if(!empty($responseArray['cancels']))
    //         {
    //             if(!empty($responseArray['cancels']['amount'])){            $responseArray['cancel_amount'] = $responseArray['cancels']['amount'];    }
    //             if(!empty($responseArray['cancels']['reason'])){            $responseArray['cancel_reason'] = $responseArray['cancels']['reason'];    }
    //             if(!empty($responseArray['cancels']['taxFreeAmount'])){     $responseArray['cancel_taxFreeAmount'] = $responseArray['cancels']['taxFreeAmount'];    }
    //             if(!empty($responseArray['cancels']['taxAmount'])){         $responseArray['cancel_taxAmount'] = $responseArray['cancels']['taxAmount'];    }
    //             if(!empty($responseArray['cancels']['refundableAmount'])){  $responseArray['cancel_refundableAmount'] = $responseArray['cancels']['refundableAmount'];    }
    //             if(!empty($responseArray['cancels']['canceledAt']))
    //             {
    //                 $responseArray['cancel_canceledAt'] = date('Y-m-d H:i:s', strtotime($responseArray['cancels']['canceledAt']));
    //             }
    //         }

    //         //날짜 형식 변환
    //         if(!empty($responseArray['requestedAt']))
    //         {
    //             $responseArray['requestedAt'] = date('Y-m-d H:i:s', strtotime($responseArray['requestedAt']));
    //         }
    //         if(!empty($responseArray['approvedAt']))
    //         {
    //             $responseArray['approvedAt'] = date('Y-m-d H:i:s', strtotime($responseArray['approvedAt']));
    //         }

    //         //사용자 정보 저장
    //         $responseArray['udx'] = $user->udx;

    //         //토스내역 DB에 저장
    //         PayTossTransaction::create($responseArray);

    //         //결제방법 및 영수증 종류
    //         switch($responseArray['method'])
    //         {
    //             case "카드":
    //                 $state = 9;
    //                 $receipt_kind = "매출전표";
    //                 break;
    //             case "가상계좌":
    //                 $state = 10;
    //                 $receipt_kind = $responseArray['cashRct_type'];
    //                 break;
    //             case "휴대폰":
    //                 $state = 9;
    //                 $receipt_kind = $responseArray['cashRct_type'];
    //                 break;
    //             case "계좌이체":
    //                 $state = 9;
    //                 $receipt_kind = $responseArray['cashRct_type'];
    //                 break;
    //         }

    //         //일반구매와 정기배송구매 구분
    //         if(strpos($responseArray['orderId'], 'S') === false)
    //         {
    //             //주문상태 변경
    //             $order = Order::where('order_number', $responseArray['orderId'])->first();
    //             $order->update(['state' => $state, 'receipt_kind' => $receipt_kind]);
    //             foreach($order->items AS $item)
    //             {
    //                 $item->update(['state' => $state]);
    //             }

    //             //히스토리 입력
    //             $history['odx'] = $order['odx'];
    //             $history['kind'] = '상태';
    //             $history['content'] = "[".$user->name."]님이 Toss의 [".$responseArray['method']."]결제를 통해 [".Order::getStateText($state)."]로 상태변경";
    //             $history['state'] = $state;
    //             OrderHistory::create($history);
    //         }else{
    //             //주문상태 변경
    //             $order = SubscribOrder::where('order_number', $responseArray['orderId'])->first();
    //             $order->update(['state' => $state, 'receipt_kind' => $receipt_kind]);
    //             foreach($order->items AS $item)
    //             {
    //                 $item->update(['state' => $state]);
    //             }

    //             //히스토리 입력
    //             $history['sodx'] = $order['sodx'];
    //             $history['kind'] = '상태';
    //             $history['content'] = "[".$user->name."]님이 Toss의 [".$responseArray['method']."]결제를 통해 [".SubscribOrder::getStateText($state)."]로 상태변경";
    //             $history['state'] = $state;
    //             SubscribOrderHistory::create($history);
    //         }

    //         //결제완료의 경우 문자메세지 전송
    //         if($state == 9)
    //         {
    //             //운영자 한테 알림문자 전송
    //             $params =
    //             [
    //                 'user_id' => '100rakon',
    //                 'key' => '5vfdzjv49p6auyo8tt4p04umiuf9cdk0',
    //                 'msg' => $responseArray['orderName'].'님 ['.$responseArray['method'].']'.number_format($responseArray['totalAmount']).'원 결제완료',
    //                 'receiver' => "010-7182-7669",
    //                 'sender' => '02-6288-6350',
    //                 // 'sender' => '010-7182-7669',
    //                 'rdate' => '',
    //                 'rtime' => '',
    //                 'testmode_yn' => 'N',
    //                 'subject' => '',
    //                 'image' => '',
    //                 'msg_type' => 'SMS',
    //             ];
    //             $ch = curl_init('https://apis.aligo.in/send/');
    //             curl_setopt($ch, CURLOPT_POST, 1);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             $result = json_decode(curl_exec($ch), true);
    //             curl_close($ch);

    //             // DB 저장
    //             if(strpos($responseArray['orderId'], 'S') === false)
    //             {
    //                 $params['udx'] = $user->udx;
    //                 $params['odx'] = $order->odx;
    //                 $params['msg'] = '[일반구매]'.$params['msg'];
    //                 $smsRecord = array_merge($params, $result);
    //                 SmsSend::create($smsRecord);
    //             }else{
    //                 $params['udx'] = $user->udx;
    //                 $params['odx'] = $order->sodx;
    //                 $params['msg'] = '[정기배송]'.$params['msg'];
    //                 $smsRecord = array_merge($params, $result);
    //                 SmsSend::create($smsRecord);
    //             }
    //         }

    //         // 주문상태 페이지로 이동
    //         if(strpos($responseArray['orderId'], 'S') === false)
    //         {
    //            return redirect('/myorder');
    //         }else{
    //            return redirect('/myorder-subscrib');
    //         }

    //         // print_r($responseArray);
    //         //return json_encode($responseArray, JSON_UNESCAPED_UNICODE);
    //     }else{
    //         return $responseArray;
    //     }
    // }

    // //토스결제 실패
    // public function payTossFail(Request $request)
    // {
    //     //초기 데이터 설정
    //     $reqDatas = $request->all();

    //     return $reqDatas;
    // }

    // //토스결제 가상계좌 입금
    // public function payTossVirtual(Request $request)
    // {
    //     //초기 데이터 설정
    //     $reqDatas = $request->all();
    //     $secret = $reqDatas['secret'];
    //     $status = $reqDatas['status'];
    //     $orderId = $reqDatas['orderId'];

    //     //토스내역 DB에 저장
    //     PayTossTransaction::create($reqDatas);

    //     //결제 결과 두 가지 설정
    //     if($status == 'DONE')
    //     {
    //         $state = 9;
    //     }
    //     else if($status == 'CANCELED')
    //     {
    //         $state = 10;
    //     }else{
    //         return 'false';
    //     }

    //     //일반구매와 정기배송구매 구분
    //     if(strpos($reqDatas['orderId'], 'S') === false)
    //     {
    //         //주문상태 변경
    //         $order = Order::where('order_number', $reqDatas['orderId'])->first();
    //         $order->update(['state' => $state]);
    //         foreach($order->items AS $item)
    //         {
    //             $item->update(['state' => $state]);
    //         }

    //         //히스토리 입력
    //         $history['odx'] = $order['odx'];
    //         $history['kind'] = '상태';
    //         $history['content'] = "[".$order['order_name']."]님이 Toss의 [가상계좌]결제를 통해 [".Order::getStateText($state)."]로 상태변경";
    //         $history['state'] = $state;
    //         OrderHistory::create($history);
    //     }else{
    //         //주문상태 변경
    //         $order = SubscribOrder::where('order_number', $reqDatas['orderId'])->first();
    //         $order->update(['state' => $state]);
    //         foreach($order->items AS $item)
    //         {
    //             $item->update(['state' => $state]);
    //         }

    //         //히스토리 입력
    //         $history['sodx'] = $order['sodx'];
    //         $history['kind'] = '상태';
    //         $history['content'] = "[".$order['order_name']."]님이 Toss의 [가상계좌]결제를 통해 [".SubscribOrder::getStateText($state)."]로 상태변경";
    //         $history['state'] = $state;
    //         SubscribOrderHistory::create($history);
    //     }

    //     //운영자와 주문자 한테 알림문자 전송
    //     if($state == 9)
    //     {
    //         $msg = $order['order_name'].'님 [가상계좌]'.number_format($order['pay_amount']).'원 결제완료';
    //     }
    //     if($state == 10)
    //     {
    //         $msg = $order['order_name'].'님 [가상계좌]'.number_format($order['pay_amount']).'원 결제완료 취소';
    //     }
    //     $params =
    //     [
    //         'user_id' => '100rakon',
    //         'key' => '5vfdzjv49p6auyo8tt4p04umiuf9cdk0',
    //         'msg' => $msg,
    //         'receiver' => "010-7182-7669",
    //         // 'receiver' => "010-9190-5924",
    //         'sender' => '02-6288-6350',
    //         'rdate' => '',
    //         'rtime' => '',
    //         'testmode_yn' => 'N',
    //         'subject' => '',
    //         'image' => '',
    //         'msg_type' => 'SMS',
    //     ];
    //     $ch = curl_init('https://apis.aligo.in/send/');
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result = json_decode(curl_exec($ch), true);
    //     curl_close($ch);

    //     // 문자내역 DB 저장
    //     if(strpos($reqDatas['orderId'], 'S') === false)
    //     {
    //         $params['udx'] = $order->user->udx;
    //         $params['odx'] = $order->odx;
    //         $params['msg'] = '[일반구매]'.$params['msg'];
    //         $smsRecord = array_merge($params, $result);
    //         SmsSend::create($smsRecord);
    //     }else{
    //         $params['udx'] = $order->user->udx;
    //         $params['odx'] = $order->sodx;
    //         $params['msg'] = '[정기배송]'.$params['msg'];
    //         $smsRecord = array_merge($params, $result);
    //         SmsSend::create($smsRecord);
    //     }

    //     return 'true';
    // }

    //토스결제 웹훅
    public function payTossWebHook(Request $request)
    {
        //초기 데이터 설정
        $reqDatas = $request->all();

        return $reqDatas;
    }

    //장바구니 추가
    public function basketAdd(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        // 기존에 저장된 목록이 있는지 확인
        $exist = $user->orderBaskets->where('pdx', '=', $data['pdx'])->all();
        if(count($exist) > 0)
        {
            return 0;   // 이미 존재하여 추가실패
        }

        // 새롭게 저장
        $data['udx'] = $user->udx;
        OrderBasket::create($data);
        // $user->orderBaskets->create($data);
        return 1;   // 추가 성공
    }

    //장바구니 삭제
    public function basketRemove(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();
        // 삭제처리
        $item = $user->orderBaskets->find($data['obdx']);
        $item->delete();

        return 1;   // 삭제 성공
    }

    //장바구니
    public function basket()
    {
        //초기 데이터 설정
        $user = Auth::user();

        // 기존에 저장된 목록이 있는지 확인
        // $exist = $user->orderBaskets[0]->product->toArray();
        $exist = $user->orderBaskets ?? [];

        return view('mall.basket', ['items' => $exist]);
    }

    //장바구니 - 주문하기
    public function basketDirect(Request $request)
    {
        //초기 데이터 설정
        $user = Auth::user();
        $data = $request->all();

        $exist[0] = new OrderBasket;
        $exist[0]->udx = $user->udx;
        $exist[0]->pdx = $data['pdx'];
        $exist[0]->quantity = $data['quantity'];
        $exist[0]->product = Product::find($data['pdx']);

        return view('mall.basket', ['items' => $exist]);
    }
}
