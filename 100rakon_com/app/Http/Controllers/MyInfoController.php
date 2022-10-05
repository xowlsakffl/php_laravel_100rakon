<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyInfoController extends BaseController
{
    //나의 정보 페이지
    public function index(Request $request)
    {
        //초기 데이터 설정
        $user = Auth::user();

        return view('mall.myinfo', compact(['user']));
    }

    //수정
    public function edit(Request $request)
    {
        //초기 데이터 설정
        $user = Auth::user();
        $data = $request->all();

        //필요정보 확인
        if(empty($data['name']))
        {
            return ['condition' => false, 'msg' => "사용자명을 입력해 주세요.", 'target' => 'name'];
        }
        if(empty($data['cell']))
        {
            return ['condition' => false, 'msg' => "핸드폰 번호를 입력해 주세요.", 'target' => 'cell'];
        }

        //홈페이지 가입자인 경우 본인이 맞는지 비밀번호 확인
        if($user->join_from == 'home')
        {
            if(empty($data['passwd0']))
            {
                return ['condition' => false, 'msg' => "현재 비밀번호를 입력해 주세요.", 'target' => 'passwd0'];
            }
            if( !Auth::attempt(['email' => $user->email, 'password' => $data['passwd0']]) )
            {
                return ['condition' => false, 'msg' => "현재 비밀번호가 틀렸습니다. 다시 입력해 주세요.", 'target' => 'passwd0'];
            }
        }

        //비밀번호도 변경할지 여부 점검
        if( (!empty($data['passwd1'])) || (!empty($data['passwd2'])) )
        {
            if(empty($data['passwd1']))
            {
                return ['condition' => false, 'msg' => "새 비밀번호를 입력해 주세요.", 'target' => 'passwd1'];
            }
            if(empty($data['passwd2']))
            {
                return ['condition' => false, 'msg' => "새 비밀번호를 확인해 주세요.", 'target' => 'passwd2'];
            }
            if( $data['passwd1'] != $data['passwd2'] )
            {
                return ['condition' => false, 'msg' => "새 비밀번호가 서로 틀립니다.", 'target' => 'passwd2'];
            }
            $user->password = Hash::make($data['passwd1']);
        }

        //수정
        $user->name = $data['name'];
        $user->cell = $data['cell'];
        $user->save();

        return ['condition' => true, 'msg' => "수정되었습니다."];
    }

    //탈퇴
    public function secession(Request $request)
    {
        //초기 데이터 설정
        $user = Auth::user();
        $data = $request->all();

        //필요정보 확인
        if(empty($data['passwd0']))
        {
            return ['condition' => false, 'msg' => "비밀번호를 입력해 주세요.", 'target' => 'passwd0'];
        }

        //본인이 맞는지 비밀번호 확인
        if( !Auth::attempt(['email' => $user->email, 'password' => $data['passwd0']]) )
        {
            return ['condition' => false, 'msg' => "현재 비밀번호가 틀렸습니다. 다시 입력해 주세요.", 'target' => 'passwd0'];
        }

        //탈퇴수행 : 아이디(이메일 'XXX@XXX.XX.XX')의 뒷쪽에 _secession 삽입 및 컨디션 1로 진행
        $user->email = $user->email."_secession";
        $user->state = 1;
        $user->save();
        $user->delete();
        Auth::logout();

        return ['condition' => true, 'msg' => "탈퇴되셨습니다. 이용에 감사드립니다."];
    }

    //주소목록 페이지
    // public function store(Request $request)
    // {
    //     //초기 데이터 설정
    //     $data = $request->all();
    //     $user = Auth::user();

    //     //필요정보 확인
    //     if(empty($data['zipcode']))
    //     {
    //         return ['condition' => false, 'msg' => "배송지 우편번호가 필요합니다."];
    //     }
    //     if(empty($data['address1']))
    //     {
    //         return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
    //     }
    //     if(empty($data['address2']))
    //     {
    //         return ['condition' => false, 'msg' => "배송지 주소가 필요합니다."];
    //     }
    //     if(empty($data['name']))
    //     {
    //         return ['condition' => false, 'msg' => "배송지 수령자 이름이 필요합니다."];
    //     }
    //     if(empty($data['tel']))
    //     {
    //         return ['condition' => false, 'msg' => "배송지 연락처가 필요합니다."];
    //     }
    //     if(empty($data['msg']))
    //     {
    //         unset($data['msg']);
    //     }

    //     //데이터정리
    //     $data['udx'] = $user->udx;

    //     //주문정보 입력
    //     $data = UserAddress::create($data);

    //     return ['condition' => true, 'msg' => "생성되었습니다."];
    // }

    // public function destroy(Request $request)
    // {
    //     //초기 데이터 설정
    //     $data = $request->all();
    //     $user = Auth::user();

    //     $targetAddress = $user->userAddresses->where('uadx', $data['uadx'])->first();
    //     $targetAddress->delete();

    //     return ['condition' => true, 'msg' => "삭제되었습니다."];
    // }

}
