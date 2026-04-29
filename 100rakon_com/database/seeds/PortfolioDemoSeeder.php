<?php

use App\Order;
use App\OrderBasket;
use App\OrderHistory;
use App\OrderItem;
use App\Product;
use App\User;
use App\UserAddress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $demoUser = User::query()->updateOrCreate(
            ['email' => 'demo@100rakon.local'],
            [
                'password' => Hash::make('password123!'),
                'name' => '백락온 데모고객',
                'email_auth' => 'Y',
                'email_verified_at' => now(),
                'cell' => '01012345678',
                'cell_auth' => 'Y',
                'cell_authed_at' => now(),
                'tel' => '0212345678',
                'join_from' => 'home',
                'super' => 'N',
                'state' => 10,
                'personal_agree' => 'Y',
            ]
        );

        UserAddress::query()->updateOrCreate(
            [
                'udx' => $demoUser->udx,
                'title' => '기본 배송지',
            ],
            [
                'zipcode' => '06572',
                'address1' => '서울특별시 서초구 방배로 183',
                'address2' => '동주빌딩 3층',
                'name' => '백락온 데모고객',
                'tel' => '01012345678',
                'msg' => '문 앞에 놓아주세요.',
            ]
        );

        $basketProductIds = [1, 2, 5];
        $basketQuantities = [2, 1, 3];

        foreach ($basketProductIds as $index => $productId) {
            OrderBasket::query()->updateOrCreate(
                [
                    'udx' => $demoUser->udx,
                    'pdx' => $productId,
                ],
                [
                    'quantity' => $basketQuantities[$index],
                ]
            );
        }

        $orders = [
            [
                'order_number' => '2026-04-29-ORD-001',
                'pay_kind' => '카드',
                'pay_name' => '백락온 데모고객',
                'pay_tel' => '01012345678',
                'delivery_name' => '백락온 데모고객',
                'delivery_tel' => '01012345678',
                'delivery_msg' => '경비실 보관 요청',
                'receipt_kind' => '매출전표',
                'state' => 9,
                'order_name' => '백락온 데모고객',
                'order_tel' => '01012345678',
                'items' => [
                    ['pdx' => 1, 'quantity' => 1, 'delivery_kind' => '무료', 'delivery_pay' => 0, 'delivery_origin_cost' => 0],
                    ['pdx' => 5, 'quantity' => 2, 'delivery_kind' => '무료', 'delivery_pay' => 0, 'delivery_origin_cost' => 0],
                ],
            ],
            [
                'order_number' => '2026-04-28-ORD-002',
                'pay_kind' => '무통장입금',
                'pay_name' => '백락온 데모고객',
                'pay_tel' => '01012345678',
                'delivery_name' => '백락온 데모고객',
                'delivery_tel' => '01012345678',
                'delivery_msg' => '빠른 배송 부탁드립니다.',
                'receipt_kind' => '현금영수증',
                'state' => 10,
                'order_name' => '백락온 데모고객',
                'order_tel' => '01012345678',
                'items' => [
                    ['pdx' => 2, 'quantity' => 1, 'delivery_kind' => '무료', 'delivery_pay' => 0, 'delivery_origin_cost' => 0],
                    ['pdx' => 8, 'quantity' => 2, 'delivery_kind' => '택배선불', 'delivery_pay' => 3000, 'delivery_origin_cost' => 3000],
                ],
            ],
        ];

        foreach ($orders as $orderIndex => $orderData) {
            $totals = $this->buildOrderTotals($orderData['items']);

            $order = Order::query()->updateOrCreate(
                ['order_number' => $orderData['order_number']],
                [
                    'udx' => $demoUser->udx,
                    'total_amount' => $totals['total_amount'],
                    'use_point' => 0,
                    'pay_amount' => $totals['total_amount'],
                    'pay_kind' => $orderData['pay_kind'],
                    'pay_name' => $orderData['pay_name'],
                    'pay_tel' => $orderData['pay_tel'],
                    'delivery_zipcode' => '06572',
                    'delivery_address1' => '서울특별시 서초구 방배로 183',
                    'delivery_address2' => '동주빌딩 3층',
                    'delivery_name' => $orderData['delivery_name'],
                    'delivery_tel' => $orderData['delivery_tel'],
                    'delivery_msg' => $orderData['delivery_msg'],
                    'receipt_kind' => $orderData['receipt_kind'],
                    'company_regist_number' => '',
                    'company_name' => '',
                    'company_president_name' => '',
                    'company_address' => '',
                    'company_kind1' => '',
                    'company_kind2' => '',
                    'company_charge_email' => '',
                    'person_name' => '백락온 데모고객',
                    'person_unique_number' => '01012345678',
                    'state' => $orderData['state'],
                    'order_name' => $orderData['order_name'],
                    'order_tel' => $orderData['order_tel'],
                    'created_at' => now()->subDays($orderIndex),
                    'updated_at' => now()->subDays($orderIndex),
                ]
            );

            foreach ($orderData['items'] as $itemIndex => $itemData) {
                $product = Product::query()->findOrFail($itemData['pdx']);
                $amount = ($product->price * $itemData['quantity']) + $itemData['delivery_pay'];

                OrderItem::query()->updateOrCreate(
                    [
                        'odx' => $order->odx,
                        'pdx' => $product->pdx,
                    ],
                    [
                        'price' => $product->price,
                        'quantity' => $itemData['quantity'],
                        'amount' => $amount,
                        'delivery_origin_cost' => $itemData['delivery_origin_cost'],
                        'delivery_kind' => $itemData['delivery_kind'],
                        'delivery_pay' => $itemData['delivery_pay'],
                        'delivery_logistics' => '로젠택배',
                        'delivery_serial' => 'DEMO' . $orderIndex . $itemIndex,
                        'state' => $orderData['state'],
                        'created_at' => now()->subDays($orderIndex),
                        'updated_at' => now()->subDays($orderIndex),
                    ]
                );
            }

            OrderHistory::query()->updateOrCreate(
                [
                    'odx' => $order->odx,
                    'kind' => '상태',
                ],
                [
                    'content' => $orderData['state'] === 9 ? '결제 완료 및 배송 준비' : '입금 대기 상태',
                ]
            );
        }
    }

    /**
     * @param array<int, array<string, int|string>> $items
     * @return array<string, int>
     */
    private function buildOrderTotals(array $items)
    {
        $totalAmount = 0;

        foreach ($items as $itemData) {
            $product = Product::query()->findOrFail($itemData['pdx']);
            $totalAmount += ($product->price * $itemData['quantity']) + $itemData['delivery_pay'];
        }

        return ['total_amount' => $totalAmount];
    }
}
