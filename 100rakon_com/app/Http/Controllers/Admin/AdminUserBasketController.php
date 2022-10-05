<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OrderBasket;
use Illuminate\Http\Request;

class AdminUserBasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($obdx)
    {
        $userBasket = OrderBasket::where('obdx', $obdx)->first();

        return view('admin.user-baskets.user-basket_edit', compact('userBasket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $obdx)
    {

        $request->validate([
            'quantity' => 'required|numeric', 
        ],
        [
            'quantity.required' => '가격을 입력해주세요.',
            'quantity.numeric' => '숫자만 입력해주세요.',
        ]);

        $data = request()->except(['_token', '_method']);
        $credentials = array_filter($data);

        $userBasket = OrderBasket::where('obdx', $obdx)->first();
        $userBasket->update($credentials);
        $user = $userBasket->user;

        flash('회원 장바구니가 수정되었습니다.')->success();
        return redirect()->route('admin.users.show', $user->udx);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($obdx)
    {
        $userBasket = OrderBasket::where('obdx', $obdx)->first();
        $userBasket->delete();
        $user = $userBasket->user;

        flash('회원 장바구니가 삭제되었습니다.')->success();
        return redirect()->route('admin.users.show', $user->udx);
    }
}
