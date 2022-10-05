@extends('layouts.mall')
@section('content')
<div id="mall_qna">
<?
$name = '';
$tel = '';
$email = '';
if(!empty($user))
{
    $name = $user->name;
    $tel = $user->cell;
    $email = $user->email;
}
?>
    <form name="qna">
    <div class="title"><div class="square"></div><div class="text">고객센터</div></div>
    <div class="order_info">
        <div>
            <div class="label rect">이름</div>
            <div class="content">
                <input type="text" name="name" value="{{ $name }}" placeholder="이름" />
            </div>
        </div>
        <div>
            <div class="label rect">연락처</div>
            <div class="content">
                <input type="text" name="tel" value="{{ $tel }}" placeholder="010-0000-0000" />
            </div>
        </div>
        <div>
            <div class="label rect">이메일</div>
            <div class="content">
                <input type="text" name="email" value="{{ $email }}" placeholder="선택입력"/>
            </div>
        </div>
        <div>
            <div class="label rect">문의내용</div>
            <div class="content">
                <textarea name="content"></textarea>
            </div>
        </div>
    </div>

    <div class="decesion">
        <button type="button" class="cPointer" onClick="check_submit()">문의하기</button>
    </div>
    @csrf
    </form>

<script>
var qnaForm = $("form[name=qna]");
$(document).ready(function()
{
})

// 폼 서브밋
function check_submit()
{
    let form = document.qna;

    //필수정보 확인
    if($.trim(form.name.value) == "")
    {
        alert("이름을 넣어주세요.");
        form.name.focus();
        return;
    }
    if($.trim(form.tel.value) == "")
    {
        alert("연락처를 넣어주세요.");
        form.tel.focus();
        return;
    }
    if($.trim(form.content.value) == "")
    {
        alert("문의내용을 넣어주세요.");
        form.content.focus();
        return;
    }

    $.ajax({
        type: "POST", //요청 메소드 방식
        url:"/qna",
        dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
        data: qnaForm.serialize(),
        success : function(result){
            console.log(result);
            alert(result.msg);
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
</div>
@endsection
