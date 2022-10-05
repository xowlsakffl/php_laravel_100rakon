<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\File;
use App\Product;
use App\ProductCategory;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
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
            $productData = Product::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $productData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $productData = Product::where('state', $state)->latest()->paginate(10);
            $productData->appends(['state' => $state]);
        }

        if($category){
            $productData = Product::where('pcdx', $category)->latest()->paginate(10);
            $productData->appends(['category' => $category]);
        }

        if(!$searchText && !$state && $state !== "0" && !$category){
            $productData = Product::latest()->paginate(10);
        }

        $categories = ProductCategory::all();

        return view('admin.products.product_list', compact(['productData', 'categories']))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('admin.products.product_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'pcdx' => $request->category,
            'sequence' => $request->sequence,
            'title' => $request->title,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'content' => $request->content,
            'hit' => $request->hit,
            'state' => $request->state,
            'price_normal' => $request->price_normal,
            'delivery_origin_cost' => $request->delivery_origin_cost,
            'supply' => $request->supply,
        ];

        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'content' => 'required|string',
            'hit' => 'numeric',
        ],
        [
            'title.required' => '판매 제목을 입력해주세요.',
            'title.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'name.required' => '제품명을 입력해주세요.',
            'name.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'price.required' => '가격을 입력해주세요.',
            'price.numeric' => '숫자만 입력해주세요.',
            'quantity.required' => '재고수량을 입력해주세요.',
            'quantity.numeric' => '숫자만 입력해주세요.',
            'content.required' => '소개내용을 입력해주세요.',
            'content.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'hit.numeric' => '숫자만 입력해주세요.',
        ]);

        $product = Product::create($data);

        if($request->hasFile('image')){
            $image = $this->imageUpload($request->file('image'), $product->pdx);
            $product->thumbnail()->create($image);
        }

        flash('제품이 생성되었습니다.')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pdx)
    {
        $productData = Product::where('pdx', $pdx)->first();

        return view('admin.products.product_show', compact('productData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pdx)
    {
        $productData = Product::where('pdx', $pdx)->first();
        $categories = ProductCategory::all();

        return view('admin.products.product_edit', compact(['productData', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pdx)
    {
        $data = [
            'pcdx' => $request->category,
            'sequence' => $request->sequence,
            'title' => $request->title,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'content' => $request->content,
            'hit' => $request->hit,
            'state' => $request->state,
            'price_normal' => $request->price_normal,
            'delivery_origin_cost' => $request->delivery_origin_cost,
            'supply' => $request->supply,
        ];

        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'content' => 'required|string',
            'hit' => 'numeric',
        ],
        [
            'title.required' => '판매 제목을 입력해주세요.',
            'title.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'name.required' => '제품명을 입력해주세요.',
            'name.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'price.required' => '가격을 입력해주세요.',
            'price.numeric' => '숫자만 입력해주세요.',
            'quantity.required' => '재고수량을 입력해주세요.',
            'quantity.numeric' => '숫자만 입력해주세요.',
            'content.required' => '소개내용을 입력해주세요.',
            'content.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'hit.numeric' => '숫자만 입력해주세요.',
        ]);

        $product = Product::where('pdx', $pdx)->first();

        if($request->hasFile('image')){
            $image = $this->imageUpload($request->file('image'), $product->pdx);
            if(!$product->thumbnail){
                $product->thumbnail()->create($image);
            }else{
                if(Storage::disk('public')->exists($product->thumbnail->real_name)){
                    Storage::disk('public')->delete($product->thumbnail->real_name);
                }
                $product->thumbnail()->update($image);
            };
        }

        $product->update($data);

        flash('제품이 수정되었습니다.')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pdx)
    {
        $product = Product::where('pdx' ,$pdx)->first();

        if($product->thumbnail){
            if(Storage::disk('public')->exists($product->thumbnail->real_name)){
                Storage::disk('public')->delete($product->thumbnail->real_name);
            }
            $product->thumbnail->delete();
        };

        $product->delete();

        flash('제품이 삭제되었습니다.')->success();
        return redirect()->route('admin.products.index');
    }

    public function removeImage($fdx)
    {
        $image = File::where('fdx', $fdx)->first();

        if(Storage::disk('public')->exists($image->real_name)){
            Storage::disk('public')->delete($image->real_name);
        }

        $productId = $image->product->pdx;

        $image->delete();

        flash('이미지가 삭제되었습니다.')->success();
        return redirect()->route('admin.products.edit', ['pdx' => $productId]);
    }
}
