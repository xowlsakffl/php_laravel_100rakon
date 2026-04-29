<?php

use App\File;
use App\Product;
use App\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File as FileFacade;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = ProductCategory::query()->firstOrCreate(
            ['pcdx' => 1],
            [
                'sequence' => 1,
                'cname' => '해양심층수',
                'parent' => 0,
                'state' => 10,
            ]
        );

        $products = [
            [
                'title' => '백락온 프리미엄 해양심층수 500ml x 40병',
                'name' => '백락온 500ml x 40병',
                'price' => 48000,
                'price_normal' => 52000,
                'quantity' => 9999,
                'delivery_origin_cost' => 0,
                'supply' => '(주) 깊은바다',
                'image' => 'home_item1_new.jpg',
            ],
            [
                'title' => '백락온 프리미엄 해양심층수 2L x 12병',
                'name' => '백락온 2L x 12병',
                'price' => 31200,
                'price_normal' => 36000,
                'quantity' => 9999,
                'delivery_origin_cost' => 0,
                'supply' => '(주) 깊은바다',
                'image' => 'home_item2_new.jpg',
            ],
            [
                'title' => '백락온 데일리 미네랄 워터 330ml x 24병',
                'name' => '데일리 미네랄 워터 330ml x 24병',
                'price' => 19800,
                'price_normal' => 23000,
                'quantity' => 320,
                'delivery_origin_cost' => 3000,
                'supply' => '(주) 백락온',
                'image' => 'home_item1.png',
            ],
            [
                'title' => '백락온 키즈 워터 200ml x 30병',
                'name' => '키즈 워터 200ml x 30병',
                'price' => 21600,
                'price_normal' => 25000,
                'quantity' => 240,
                'delivery_origin_cost' => 3000,
                'supply' => '(주) 백락온',
                'image' => 'home_item2.png',
            ],
            [
                'title' => '백락온 오피스 패키지 500ml x 20병',
                'name' => '오피스 패키지 500ml x 20병',
                'price' => 26900,
                'price_normal' => 30000,
                'quantity' => 180,
                'delivery_origin_cost' => 0,
                'supply' => '(주) 깊은바다',
                'image' => 'subscribe_img1.png',
            ],
            [
                'title' => '백락온 패밀리 패키지 1L x 12병',
                'name' => '패밀리 패키지 1L x 12병',
                'price' => 28900,
                'price_normal' => 33000,
                'quantity' => 210,
                'delivery_origin_cost' => 0,
                'supply' => '(주) 깊은바다',
                'image' => 'subscribe_img2.png',
            ],
            [
                'title' => '백락온 밸런스 워터 500ml x 60병',
                'name' => '밸런스 워터 500ml x 60병',
                'price' => 69000,
                'price_normal' => 76000,
                'quantity' => 95,
                'delivery_origin_cost' => 0,
                'supply' => '(주) 백락온',
                'image' => 'subscribe_img3.png',
            ],
            [
                'title' => '백락온 스타터 세트 500ml x 12병',
                'name' => '스타터 세트 500ml x 12병',
                'price' => 12800,
                'price_normal' => 15000,
                'quantity' => 540,
                'delivery_origin_cost' => 3000,
                'supply' => '(주) 백락온',
                'image' => 'home_og_image2.jpg',
            ],
        ];

        foreach ($products as $index => $productData) {
            $product = Product::query()->updateOrCreate(
                ['pdx' => $index + 1],
                [
                    'pcdx' => $category->pcdx,
                    'sequence' => $index + 1,
                    'title' => $productData['title'],
                    'name' => $productData['name'],
                    'price' => $productData['price'],
                    'price_normal' => $productData['price_normal'],
                    'quantity' => $productData['quantity'],
                    'content' => '<p>백락온 쇼핑몰 데모용 상품 설명입니다.</p>',
                    'delivery_origin_cost' => $productData['delivery_origin_cost'],
                    'supply' => $productData['supply'],
                    'state' => 10,
                    'hit' => 100 - ($index * 7),
                ]
            );

            $sourcePath = public_path('images/' . $productData['image']);
            $relativeTarget = 'demo-products/product-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . '.' . pathinfo($productData['image'], PATHINFO_EXTENSION);
            $targetPath = storage_path('app/public/' . $relativeTarget);

            if (!FileFacade::exists(dirname($targetPath))) {
                FileFacade::makeDirectory(dirname($targetPath), 0755, true);
            }

            if (FileFacade::exists($sourcePath)) {
                FileFacade::copy($sourcePath, $targetPath);
                $imageInfo = @getimagesize($targetPath) ?: [0, 0];
                $size = @filesize($targetPath) ?: 0;

                File::query()->updateOrCreate(
                    ['pdx' => $product->pdx],
                    [
                        'udx' => null,
                        'up_name' => basename($sourcePath),
                        'real_name' => $relativeTarget,
                        'size' => $size,
                        'extension' => pathinfo($targetPath, PATHINFO_EXTENSION),
                        'download' => 0,
                        'width' => $imageInfo[0] ?? 0,
                        'height' => $imageInfo[1] ?? 0,
                        'state' => 10,
                    ]
                );
            }
        }
    }
}
