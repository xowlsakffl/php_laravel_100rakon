<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Qna;
use App\SmsSend;

class QnaController extends BaseController
{
    public function index(Request $request)
    {
        //초기 데이터 설정
        $data = $request->all();
        $user = Auth::user();

        return view('mall.qna', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();

        //데이터 점검
        if(empty($data['name']))
        {
            return ['condition' => false, 'msg' => "이름을 넣어주세요."];
        }
        if(empty($data['tel']))
        {
            return ['condition' => false, 'msg' => "연락처를 넣어주세요."];
        }
        if(empty($data['email']))
        {
            unset($data['email']);
        }
        if(empty($data['content']))
        {
            return ['condition' => false, 'msg' => "문의내용을 넣어주세요."];
        }

        if(!empty($user))  $data['udx'] = $user->udx;
        Qna::create($data);

        //문자메세지 전송
        $params =
        [
            'user_id' => '100rakon',
            'key' => '5vfdzjv49p6auyo8tt4p04umiuf9cdk0',
            'msg' => $data['name'].'('.$data['tel'].')님 문의사항 입력됨',
            'receiver' => '010-7182-7669',
            'sender' => '010-7182-7669',
            'rdate' => '',
            'rtime' => '',
            'testmode_yn' => 'N',
            'subject' => '',
            'image' => '',
            'msg_type' => 'SMS',
        ];
        $ch = curl_init('https://apis.aligo.in/send/');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        // DB 저장
        if(!empty($user))  $params['udx'] = $user->udx;
        $smsRecord = array_merge($params, $result);
        SmsSend::create($smsRecord);

        return ['condition' => true, 'msg' => "문의사항이 입력되었습니다. 빠른 시간내로 응답드리겠습니다."];
    }
}
