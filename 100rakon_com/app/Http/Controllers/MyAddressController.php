<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserAddress;

class MyAddressController extends BaseController
{
    //주소목록 페이지
    public function index(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //주소정보 가져오기
        $items = $user->userAddresses ?? [];

        return view('mall.myaddress', ['items' => $items]);
    }

    //주소목록 페이지
    public function store(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        //필요정보 확인
        if(empty($data['zipcode']))
        {
            return ['condition' => false, 'msg' => "배송지 우편번호가 필요합니다."];
        }
        if(empty($data['address1']))
        {
            return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
        }
        if(empty($data['address2']))
        {
            return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
        }
        if(empty($data['name']))
        {
            return ['condition' => false, 'msg' => "배송지 수령자 이름이 필요합니다."];
        }
        if(empty($data['tel']))
        {
            return ['condition' => false, 'msg' => "배송지 연락처가 필요합니다."];
        }
        if(empty($data['msg']))
        {
            unset($data['msg']);
        }

        //데이터정리
        $data['udx'] = $user->udx;

        //주문정보 입력
        $data = UserAddress::create($data);

        return ['condition' => true, 'msg' => "생성되었습니다."];
    }

    public function destroy(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        $targetAddress = $user->userAddresses->where('uadx', $data['uadx'])->first();
        $targetAddress->delete();

        return ['condition' => true, 'msg' => "삭제되었습니다."];
    }

}
