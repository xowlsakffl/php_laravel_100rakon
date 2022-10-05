<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;

class IntroductionController extends BaseController
{
    // 백락온 소개
    public function intro()
    {
        return view('mall.intro');
    }
    // 백락온 소개
    public function saranghae()
    {
        return view('mall.saranghae');
    }
    // 존재하는 이메일 여부 점검
    public function existEmailCheck(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $existUser = User::where('email', $data['email'])->where('state', '>', 0)->first();

        //이미 존재한다면
        if(!empty($existUser))
        {
            return ['condition' => false, 'msg' => "이미 [".$existUser->getJoinFromText()."]로 가입하여 사용중입니다."];
        }
        return ['condition' => true, 'msg' => "이메일이 점검되었습니다."];
    }
}
