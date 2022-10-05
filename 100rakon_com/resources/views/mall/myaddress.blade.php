@extends('layouts.blank')
@section('content')
<div id="mall_address">
    <div class="title_line">
        <h3 class="sub_title">배송 주소록 관리</h3>
        <button type="button" class="d_btn" onClick="show_input();">새 주소 입력</button>
    </div>

    <div class="input_line">
<form name="address">
        <div class="order_info">
            <div>
                <div class="label rect">수령자 이름</div>
                <div class="content">
                    <input type="text" name="name" value="" />
                </div>
            </div>
            <div>
                <div class="label rect">수령자 연락처</div>
                <div class="content">
                    <input type="text" name="tel" value="" placeholder="010-0000-0000" />
                </div>
            </div>
            <div>
                <div class="label rect">배송지 주소</div>
                <div class="address">
                    <div>
                        <input type="text" name="zipcode" value="" />
                        <input type="button" class="d_btn" value="주소찾기" onClick="gen.StartDaumAddress('zipcode', 'address1', 'address2');" />
                    </div>
                    <div>
                        <input type="text" name="address1" value="" />
                    </div>
                    <div>
                        <input type="text" name="address2" value="" />
                    </div>
                </div>
            </div>
            <div>
                <div class="label rect">배송 메모</div>
                <div class="content">
                    <input type="text" name="msg" value="" />
                </div>
            </div>
            <div class="decesion">
                <button type="button" class="cPointer" onClick="check_submit()">확인</button>
                <button type="button" class="cPointer" onClick="hide_input()">취소</button>
            </div>
        </div>
@csrf
</form>
    </div>

<form name="delete">
    @csrf
    @method('DELETE')
    <input type="hidden" name="uadx" value="0" />

</form>

    @foreach($items as $key => $item)
    <div class="item @if($key == 0) item_top @endif">
        <div class="line">
            <div class="name">{{ $item->name }}</div>
            <div class="tel">{{ $item->tel }}</div>
        </div>
        <div class="line">
            <div class="zip">{{ $item->zipcode }}</div>
            <div class="add1">{{ $item->address1 }}</div>
            <div class="add2">{{ $item->address2 }}</div>
        </div>
        <div class="line">
            배송메모 : {{ $item->msg }}
        </div>
        <div class="menu">
            <button type="button" class="d_btn apply_btn" onClick="apply_address('{{ $item->name }}', '{{ $item->tel }}', '{{ $item->zipcode }}', '{{ $item->address1 }}', '{{ $item->address2 }}', '{{ $item->msg }}');">적용하기</button>
            {{-- <button type="button" class="d_btn">수정</button> --}}
            <button type="button" class="d_btn" onClick="delete_item({{ $item->uadx }})">삭제</button>
        </div>
    </div>
    @endforeach

</div>
<script>
function apply_address(name, tel, zip, add1, add2, msg)
{
    opener.document.forms['order'].delivery_name.value = name;
    opener.document.forms['order'].delivery_tel.value = tel;
    opener.document.forms['order'].delivery_zipcode.value = zip;
    opener.document.forms['order'].delivery_address1.value = add1;
    opener.document.forms['order'].delivery_address2.value = add2;
    opener.document.forms['order'].delivery_msg.value = msg;
    window.close();
}

var addressForm = $("form[name=address]");
var deleteForm = $("form[name=delete]");
function show_input()
{
    $(".input_line").css('display', 'block');
    $("input[name=delivery_name]").focus();
}
function hide_input()
{
    $(".input_line").css('display', 'none');
}
function delete_item(uadx)
{
    document.delete.uadx.value = uadx;

    $.ajax({
	type: "POST", //요청 메소드 방식
	url:"/myaddress/" + uadx,
	dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: deleteForm.serialize(),
	success : function(result){
        console.log(result);
        alert(result.msg);
        if(result.condition == true)
        {
            // location.reload();
        }
	},
	error : function(a, b, c){
		console.log(a);
		console.log(a + b + c);
	}
    });
}

// 폼 서브밋
function check_submit()
{
    $.ajax({
	type: "POST", //요청 메소드 방식
	url:"/myaddress",
	dataType:"json", //서버가 요청 URL을 통해서 응답하는 내용의 타입
    data: addressForm.serialize(),
	success : function(result){
        console.log(result);
        alert(result.msg);
        if(result.condition == true)
        {
            location.reload();
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

