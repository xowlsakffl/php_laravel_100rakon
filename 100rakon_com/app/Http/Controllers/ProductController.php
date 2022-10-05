<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\File;
use App\Product;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $products = Product::with('thumbnail')->paginate(10);

        return view('mall.list', compact('products'));
    }

    public function view($pdx)
    {
        //프로덕트 가져오기
        $product = Product::find($pdx);

        //파일가져오기
        // $thumbnail = File::find($product->thumbnail_fdx);

        // return view('mall.view', ['pdx' => $pdx, 'product' => $product, 'thumbnail' => $thumbnail]);
        return view('mall.view', ['pdx' => $pdx, 'product' => $product]);
    }
}


// "pdx": 2,
// "pcdx": 1,
// "sequence": 2,
// "title": "마시는 해양심층수 - 사랑해 2000ml (12본)",
// "name": "사랑해 2000ml (12본)",
// "price": 25000,
// "quantity": 9999,
// "content": "<img src=\"/storage/product1_detail.jpg\" />",
// "state": 10,
// "hit": 0,
// "created_at": "2021-12-05 23:07:33",
// "updated_at": "2021-12-05 23:07:33",
// "deleted_at": null,
// "price_normal": 30000,
// "delivery_origin_cost": 0,
// "supply": "(주) 깊은바다",
// "thumbnail_fdx": 2
// }

// "fdx": 2,
// "udx": null,
// "up_name": "사랑해2.jpg",
// "real_name": "product2.png",
// "size": 1024,
// "extension": "png",
// "download": 0,
// "width": 315,
// "height": 315,
// "state": 10,
// "created_at": "2021-12-06 15:25:47",
// "updated_at": "2021-12-06 15:25:47"
// }
