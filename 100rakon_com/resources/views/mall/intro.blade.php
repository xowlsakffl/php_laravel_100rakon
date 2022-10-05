@extends('layouts.mall')
@section('title')
    백락온 소개 ::
@endsection

@section('content')
<div id="mall_intro">
    <div class="panel">
        <div class="left">
            <img src="/images/intro_left_img1.png" />
        </div>
        <div class="right">
            백락(伯樂)은 천마별자리 이름으로 중국 주나라 때 명마를 알아봤던 양수의 별칭에서 영감을 얻었습니다.<br/>
            남들은 알아보지 못 한 뛰어난 제품을 먼저 알아보고 선보인다는 의미의 伯樂에 고객분들께 즐거움을 선사하자는 경영철학을 담아, 伯은 百(100)으로, 즐거움은 그대로, 고객들의 100가지 행복(樂)이 시작(ON) 되는 곳이 즉 백락온입니다.<br/>
            <br/>
            철저한 검증 및 평가 과정을 통해 백락온은 만드는 사람과 제품을 엄선하여 소비자에게 공급합니다. 소비자의 즐거움(樂)을 먼저 생각하는 마음이야말로 백락온의 정신입니다.
        </div>
    </div>

</div>
<script>
$(document).ready(function()
{
    $('.panel').addClass('show');
});
</script>
@endsection
