@extends('layouts.mall')
@section('content')
<div id="mall_myinfo">

    <div class="title">
        <div class="square"></div>
        <div class="text">나의 정보</div>
    </div>
<form name="edit">
    <div class="form_info">
        <div>
            <div class="label rect">부가정보</div>
            <div class="content2">
                <p>가입일시 <span>{{ $user['created_at'] }}</span></p>
                <span class="bar">|</span>
                <p>가입경로 <span>{{ $user->getJoinFromText() }}</span></p>
                <span class="bar">|</span>
                <p>상태 <span>{{ $user->getStateText() }}</span></p>
            </div>
        </div>
        <div>
            <div class="label rect">아이디(이메일)</div>
            <div class="content2">{{ $user['email'] }}</div>
        </div>
        <div>
            <div class="label rect">사용자명</div>
            <div class="content">
                <input type="text" name="name" value="{{ $user['name'] }}" />
                <div class="exp">가급적 본명을 사용해 주십시오.</div>
            </div>
        </div>
        <div>
            <div class="label rect">핸드폰</div>
            <div class="content">
                <input type="text" name="cell" value="{{ $user['cell'] }}" />
                <div class="exp">핸드폰이 없으시면 일반전화로 입력해 주세요.</div>
            </div>
        </div>
@if($user->join_from == "home")
        <div>
            <div class="label rect">현재 비밀번호</div>
            <div class="content"><input type="password" name="passwd0" onKeyUp="copy_to_secession_form(this.value)" value="" /></div>
        </div>
        <div>
            <div class="label rect">새 비밀번호</div>
            <div class="content">
                <input type="password" name="passwd1" value="" />
                <div class="exp">비밀번호를 변경하고 싶으시면 입력하세요.</div>
            </div>
        </div>
        <div>
            <div class="label rect">새 비밀번호 확인</div>
            <div class="content"><input type="password" name="passwd2" value="" /></div>
        </div>
@endif
    </div>
    @csrf
</form>
<form name="secession">
    <input type="hidden" name="passwd0" value="" />
    @csrf
</form>
    <div class="buttons">
        <button type="button" class="edit" onClick="exec_update();">수정완료</button>
        <button type="button" class="secession" onClick="confirm_secession();">탈퇴하기</button>
    </div>

    <br/><br/><br/>

<script>
let editForm = $("form[name='edit']");
let secessionForm = $("form[name='secession']");

//수정
function exec_update()
{
    $.ajax({
        type: "POST", //요청 메소드 방식
        url:"/myinfo/edit",
        dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: editForm.serialize(),
        success : function(result){
        console.log(result);
        alert(result.msg);
        if(result.condition == false)
        {
            editForm.find("input[name=" + result.target + "]").focus();
        }
        },
        error : function(a, b, c){
                console.log(a);
                console.log(a + b + c);
        }
    });
}

//탈퇴부분
function confirm_secession()
{
    if(confirm("거래정보를 제외한 모든 정보는 삭제됩니다. 탈퇴하시겠습니까?"))
    {
        secession();
    }
}
//수정폼에서 입력한 현재 비밀번호를 탈퇴폼에도 입력
function copy_to_secession_form(value)
{
    secessionForm.find("input[name=passwd0]").val(value);
}
//탈퇴수행
function secession()
{
    $.ajax({
        type: "POST", //요청 메소드 방식
        url:"/myinfo/secession",
        dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: secessionForm.serialize(),
        success : function(result){
        console.log(result);
        alert(result.msg);

        if(result.condition == false)
        {
            editForm.find("input[name=" + result.target + "]").focus();
        }
        if(result.condition == true)
        {
            location.href = '/';
        }
        },
        error : function(a, b, c){
                console.log(a);
                console.log(a + b + c);
        }
    });

}
</script>
@endsection
