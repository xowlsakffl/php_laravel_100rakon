<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\File;
use App\User;
use App\Product;
use App\SubscribGood;
use App\SubscribGoodCategory;
use App\SubscribGoodProduct;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSubscribGoodController extends Controller
{
    use UploadTrait;
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
        $category = $request->category;

        if($searchText){
            $subscribGoodData = SubscribGood::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $subscribGoodData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $subscribGoodData = SubscribGood::where('state', $state)->latest()->paginate(10);
            $subscribGoodData->appends(['state' => $state]);
        }

        if($category){
            $subscribGoodData = SubscribGood::where('sgcdx', $category)->latest()->paginate(10);
            $subscribGoodData->appends(['category' => $category]);
        }

        if(!$searchText && !$state && $state !== "0" && !$category){
            $subscribGoodData = SubscribGood::latest()->paginate(10);
        }

        $categories = SubscribGoodCategory::all();

        return view('admin.subscrib-goods.good_list', compact(['subscribGoodData', 'categories']))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $categories = SubscribGoodCategory::all();
        return view('admin.subscrib-goods.good_create', compact(['categories', 'products']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //구독 상품 저장
        $data = $request->all();
        $sgData['sgcdx'] = $data['sgcdx'];
        if(!empty($data['main_sequence'])) $sgData['sequence'] = $data['main_sequence'];
        if(!empty($data['title'])) $sgData['title'] = $data['title'];
        if(!empty($data['content'])) $sgData['content'] = $data['content'];
        if(!empty($data['hit'])) $sgData['hit'] = $data['hit'];
        $subscribGood = SubscribGood::create($sgData);

        //관련 제품 저장
        for($i = 0; $i < sizeof($data['pdx']); $i++)
        {
            $SubscribGoodProduct['sgdx'] = $subscribGood->sgdx;
            $SubscribGoodProduct['pdx'] = $data['pdx'][$i];
            $SubscribGoodProduct['sequence'] = $data['sequence'][$i];
            $SubscribGoodProduct['quantity_per_delivery'] = $data['quantity_per_delivery'][$i];
            $SubscribGoodProduct['delivery_per_month'] = $data['delivery_per_month'][$i];
            $SubscribGoodProduct['is_basic'] = $data['is_basic'][$i];
            $SubscribGoodProduct['unit_price_normal'] = $data['unit_price_normal'][$i];
            $SubscribGoodProduct['unit_price_half'] = $data['unit_price_half'][$i];
            $SubscribGoodProduct['unit_price_year'] = $data['unit_price_year'][$i];

            if(empty($data['sequence'][$i])) unset($SubscribGoodProduct['sequence']);
            if(empty($data['quantity_per_delivery'][$i])) unset($SubscribGoodProduct['quantity_per_delivery']);
            if(empty($data['delivery_per_month'][$i])) unset($SubscribGoodProduct['delivery_per_month']);
            if(empty($data['is_basic'][$i])) unset($SubscribGoodProduct['is_basic']);
            if(empty($data['unit_price_normal'][$i])) unset($SubscribGoodProduct['unit_price_normal']);
            if(empty($data['unit_price_half'][$i])) unset($SubscribGoodProduct['unit_price_half']);
            if(empty($data['unit_price_year'][$i])) unset($SubscribGoodProduct['unit_price_year']);
            SubscribGoodProduct::create($SubscribGoodProduct);
        }

        //파일업로드
        if($request->hasFile('image')){
            $image = $this->imageUpload($request->file('image'), null, $subscribGood->sgdx);
            $subscribGood->thumbnail()->create($image);
        }

        flash('상품이 생성되었습니다.')->success();
        return redirect()->route('admin.subscrib-goods.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sgdx)
    {
        $subscribGood = SubscribGood::find($sgdx);
        $products = Product::all();
        $categories = SubscribGoodCategory::all();

        return view('admin.subscrib-goods.good_edit', compact(['categories', 'subscribGood', 'products']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sgdx)
    {
        //구독 상품 저장
        $data = $request->all();

        $subscribGood = SubscribGood::find($sgdx);
        $sgData['sgcdx'] = $data['sgcdx'];
        if(!empty($data['main_sequence'])) $sgData['sequence'] = $data['main_sequence'];
        if(!empty($data['title'])) $sgData['title'] = $data['title'];
        if(!empty($data['content'])) $sgData['content'] = $data['content'];
        if(!empty($data['hit'])) $sgData['hit'] = $data['hit'];
        if(!empty($data['state'])) $sgData['state'] = $data['state'];
        $subscribGood->update($sgData);

        //기존에 관련되어 있다가 삭제된 제품 삭제
        $deletedItems = SubscribGoodProduct::where('sgdx', $sgdx)->whereNotIn('sgpdx',$data['sgpdx'])->get();
        foreach($deletedItems AS $key => $deletedItem)
        {
            $deletedItem->state = 0;
            $deletedItem->update();
            $deletedItem->delete();
        }

        //관련 제품 저장 : 기존제품은 업뎃, 추가제품은 생성
        for($i = 0; $i < sizeof($data['pdx']); $i++)
        {
            $SubscribGoodProduct['sgdx'] = $sgdx;
            $SubscribGoodProduct['pdx'] = $data['pdx'][$i];
            $SubscribGoodProduct['sequence'] = $data['sequence'][$i];
            $SubscribGoodProduct['quantity_per_delivery'] = $data['quantity_per_delivery'][$i];
            $SubscribGoodProduct['delivery_per_month'] = $data['delivery_per_month'][$i];
            $SubscribGoodProduct['is_basic'] = $data['is_basic'][$i];
            $SubscribGoodProduct['unit_price_normal'] = $data['unit_price_normal'][$i];
            $SubscribGoodProduct['unit_price_half'] = $data['unit_price_half'][$i];
            $SubscribGoodProduct['unit_price_year'] = $data['unit_price_year'][$i];

            if($data['sgpdx'][$i] == 0) unset($SubscribGoodProduct['sgpdx']);
            if(empty($data['sequence'][$i])) unset($SubscribGoodProduct['sequence']);
            if(empty($data['quantity_per_delivery'][$i])) unset($SubscribGoodProduct['quantity_per_delivery']);
            if(empty($data['delivery_per_month'][$i])) unset($SubscribGoodProduct['delivery_per_month']);
            if(empty($data['is_basic'][$i])) unset($SubscribGoodProduct['is_basic']);
            if(empty($data['unit_price_normal'][$i])) unset($SubscribGoodProduct['unit_price_normal']);
            if(empty($data['unit_price_half'][$i])) unset($SubscribGoodProduct['unit_price_half']);
            if(empty($data['unit_price_year'][$i])) unset($SubscribGoodProduct['unit_price_year']);

            //있으면 업데이트 없으면 생성
            $mSubscribGoodProduct = SubscribGoodProduct::find($data['sgpdx'][$i]);
            if(empty($mSubscribGoodProduct))
            {
                SubscribGoodProduct::create($SubscribGoodProduct);
            }else{
                $mSubscribGoodProduct->update($SubscribGoodProduct);
            }
        }

        //파일업로드
        if($request->hasFile('image'))
        {
            //기존파일 있으면 삭제
            if(!empty($subscribGood->thumbnail))
            {
                $this->removeImage($subscribGood->thumbnail->fdx);
            }
            $image = $this->imageUpload($request->file('image'), null, $subscribGood->sgdx);
            $subscribGood->thumbnail()->create($image);
        }

        flash('상품이 수정되었습니다.')->success();
        return redirect()->route('admin.subscrib-goods.show', ['sgdx' => $sgdx]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sgdx)
    {
        $subscribGood = SubscribGood::where('sgdx' ,$sgdx)->first();
        $subscribGood->state = 0;
        $subscribGood->save($subscribGood->toArray());
        $subscribGood->delete();
        SubscribGood::where('sgdx' ,$sgdx)->delete();

        flash('삭제되었습니다.')->success();
        return redirect()->route('admin.subscrib-goods.index');
    }

    public function removeImage($fdx)
    {
        $image = File::where('fdx', $fdx)->first();

        if(Storage::disk('public')->exists($image->real_name))
        {
            Storage::disk('public')->delete($image->real_name);
        }

        $goodId = $image->subscribGood->sgdx;

        $image->delete();

        flash('이미지가 삭제되었습니다.')->success();
        return redirect()->route('admin.subscrib-goods.show', ['sgdx' => $goodId]);
    }
}
