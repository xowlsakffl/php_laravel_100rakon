<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductCategory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
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
        $category = $request->category;

        if($searchText){
            $categoryData = ProductCategory::where([
                [function($query) use ($searchOption, $searchText){
                    $query->orWhere($searchOption, 'LIKE', '%'.$searchText.'%')->get();
                }]
            ])->paginate(10);
            $categoryData->appends(['search_option' => $searchOption, 'search_text'=>$searchText]);
        }

        if($state || $state === "0"){
            $categoryData = ProductCategory::where('state', $state)->latest()->paginate(10);
            $categoryData->appends(['state' => $state]);
        }

        if($category){
            $categoryData = ProductCategory::where('pcdx', $category)->latest()->paginate(10);
            $categoryData->appends(['category' => $category]);
        }

        if(!$searchText && !$state && $state !== "0" && !$category){
            $categoryData = ProductCategory::latest()->paginate(10);
        }
        
        return view('admin.categories.category_list', compact('categoryData'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();

        return view('admin.categories.category_create', compact('categories'));
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
            'cname' => $request->cname,
            'parent' => $request->category,
            'state' => $request->state
        ];

        $request->validate([
            'cname' => 'required|string',      
            'category' => 'required',
        ],
        [
            'cname.required' => '분류명을 입력해주세요.',
            'cname.string' => '특수문자, 공백은 입력할 수 없습니다.',
            'category.required' => '카테고리를 선택해주세요.',
        ]);

        ProductCategory::create($data);

        flash('분류가 생성되었습니다.')->success();
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pcdx)
    {
        $categoryData = ProductCategory::where('pcdx', $pcdx)->first();
        $categoryParent = ProductCategory::where('pcdx', $categoryData->parent)->first();

        return view('admin.categories.category_show', compact(['categoryData', 'categoryParent']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pcdx)
    {
        $categoryData = ProductCategory::where('pcdx', $pcdx)->first();
        $categories = ProductCategory::all();

        return view('admin.categories.category_edit', compact(['categoryData', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pcdx)
    {
        $data = [
            'cname' => $request->cname,
            'parent' => $request->category,
            'state' => $request->state
        ];

        $request->validate([
            'cname' => 'required|string',      
            'category' => 'numeric',
        ],
        [
            'cname.required' => '분류명을 입력해주세요.',
            'cname.string' => '특수문자, 공백은 입력할 수 없습니다.',
        ]);

        ProductCategory::where('pcdx', $pcdx)->update($data);

        flash('분류가 수정되었습니다.')->success();
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pcdx)
    {
        ProductCategory::where('pcdx' ,$pcdx)->delete();
        
        flash('분류가 삭제되었습니다.')->success();
        return redirect()->route('admin.categories.index');
    }
}
