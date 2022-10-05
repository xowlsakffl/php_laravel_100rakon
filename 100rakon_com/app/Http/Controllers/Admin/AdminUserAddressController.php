<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UserAddress;
use Illuminate\Http\Request;

class AdminUserAddressController extends Controller
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
    public function edit($uadx)
    {
        $userAddress = UserAddress::where('uadx', $uadx)->first();

        return view('admin.user-addresses.user-address_edit', compact('userAddress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uadx)
    {
        $data = [
            'title' => $request->title,
            'zipcode' => $request->zipcode,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'name' => $request->name,
            'tel' => $request->tel,
            'msg' => $request->msg,
        ];

        $request->validate([
            'title' => 'required', 
        ],
        [
            'title.required' => '배송지명을 입력해주세요.',
        ]);

        $userAddress = UserAddress::where('uadx', $uadx)->first();
        $userAddress->update($data);
        $user = $userAddress->user;

        flash('회원 배송지가 수정되었습니다.')->success();
        return redirect()->route('admin.users.show', $user->udx);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uadx)
    {
        $userAddress = UserAddress::where('uadx' ,$uadx)->first();
        $userAddress->delete();
        $user = $userAddress->user;

        flash('회원 배송지가 삭제되었습니다.')->success();
        return redirect()->route('admin.users.show', $user->udx);
    }
}
