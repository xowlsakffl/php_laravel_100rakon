@extends('layouts.mall')
@section('content')
    <script>
        // 쿠키 가져오기
        var getCookie = function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
            }
            return "";
        }

            // 24시간 기준 쿠키 설정하기
        var setCookie = function (cname, cvalue, exdays) {
            var todayDate = new Date();
            todayDate.setTime(todayDate.getTime() + (exdays*24*60*60*1000));
            var expires = "expires=" + todayDate.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        var couponClose1 = function(){
            if($("input[name='chkbox1']").is(":checked") == true){
                setCookie("close1", "Y", 9999);
            }
            $(".pop1").hide();

            
        }
        var couponClose2 = function(){
            if($("input[name='chkbox2']").is(":checked") == true){
                setCookie("close2", "Y", 9999);
            }
            $(".pop2").hide();

            
        }
        
        $(document).ready(function(){
            cookiedata = document.cookie;
            if(cookiedata.indexOf("close1=Y") < 0){
                $(".pop1").show();
            }else{
                $(".pop1").hide();
            }
            if(cookiedata.indexOf("close2=Y") < 0){
                $(".pop2").show();
            }else{
                $(".pop2").hide();
            }
            $(".close1").click(function(){
                couponClose1();
            });
            $(".close2").click(function(){
                couponClose2();
            });
        });
    </script>
    
    {{-- <div id="pop" class="pop2">
        <div class="cont">
            <p>
                <img src="/images/feb_popup.png" style="width: 100%" alt="">
            </p>
        </div>
        <div class="close">
            <form method="post" action="" name="pop_form">
                <span id="check"><input type="checkbox" value="checkbox" name="chkbox2" id="chkday2"/><label for="chkday2">다시 보지 않기</label></span>
                <span id="close" class="close2">닫기</span>
            </form>
        </div>
    </div> --}}
    <div id="pop" class="pop1">
        <div class="cont">
            <p class="title">2L 제품구성 변경안내</p>
            <div class="txt1">
                <p class="txt1_1">※2L박스 구성에 변경이 있어 안내드립니다.</p>
            </div>
            {{-- <p class="txt2">택배접수 마감일시 : <span>1월 25일 12시</span></p> --}}
            <p class="txt3">
                2월 21일부터 2L 1박스 12개입 판매가 중단되고 6개입 2박스로 바뀌어 판매될  
                예정입니다.<br/>
                <b>2L(12개) *1박스 → 2L(6개) * 2박스</b><br/>
                택배기사님의 안전문제가 지속적으로 대두되어 부득이하게 변경하게 되었습니다.
                이러한 변경으로 인하여 2월14일 ~ 2월19일까지 2L제품 배송이 잠시 중단됨을
                알려드립니다.
                이 기간 중 주문은 가능하나 배송은 2월 21일부터 순차적으로 이루어지는 점 널리 양해 부탁드립니다.
                불편을 끼쳐드려 죄송합니다.
                감사합니다.
            </p>
        </div>
        <div class="close">
            <form method="post" action="" name="pop_form">
                <span id="check"><input type="checkbox" value="checkbox" name="chkbox1" id="chkday1"/><label for="chkday1">다시 보지 않기</label></span>
                <span id="close" class="close1">닫기</span>
            </form>
        </div>
    </div>
    <div id="mall_home">

        <div class="home_slide1">
            <div class="content_panel">
                <div class="bg"><video src="images/movie1.mp4" loop muted autoplay playsinline type='video/mp4'></video></div>
                <div class="cover"></div>
                <div class="description">
                    <div class="text1">百 樂<br/>伯 樂</div>
                    <div class="bar"><div></div></div>
                    <div class="text2">
                        백락(百樂)온(ON)은 ‘백락(伯樂)’을 시작으로 그 의미를 하나씩 담아갑니다.<br/>
                        백락이 명마를 고르듯, 뛰어난 제품을 먼저 알아보고 선보입니다.<br/>
                        伯은 百(100)으로, 즐거움은 그대로, 고객들의 100가지 행복(樂)이 시작되는 곳(ON)이 백락온입니다.
                    </div>
                    <div class="text3"><div onClick="gen.redirect('/intro');">View More</div></div>
                </div>
            </div>
        </div>
        <div class="scroll_guide">
            <div><img src="/images/home_scroll.png" /></div>
            <div><img src="/images/home_vertical_bar.png" /></div>
            <div><img src="/images/home_text_brand.png" /></div>
        </div>
        <div class="home_slide4">
            <div class="content_panel">
                <div class="img2"><img src="/images/home_p4_img2.png" /></div>
                <div class="text">
                    <div class="txt1"><img src="/images/home_p4_txt1.png" /></div>
                    <div class="txt2"><img src="/images/home_p4_txt2.png" /></div>
                    <div class="txt3"><div onClick="gen.redirect('/saranghae');">View More</div></div>
                    <div class="txt4">| 먹는 해양심층수 사랑해 골드</div>
                    <div class="txt5">
                        대한민국 동해안에서 7.3km 떨어진 먼 바다에 햇빛이 통과되지 않는 수심 500m 이하의
                        ‘해양심층수 벨트’에서 취수합니다. 인공 미네랄 성분을 첨가하지 않고 천연 미네랄 함량을
                        조절하는 기술로 프리미엄 미네랄 300의 물을 생산하고 있습니다.
                        인체에 꼭 필요한 60여종의 주요∙미량의 천연 미네랄이 아주 풍부하며,
                        특히 마그네슘의 함량이 칼슘보다도 많고 다른 생수보다 월등히 높다는 것과 미네랄 조성이
                        혈액이나 양수 등의  체액과 거의 유사한 밸런스를 가진다는 것이 사랑해 골드의 특징입니다.
                    </div>
                </div>
            </div>
            <div class="panel_bg"></div>
        </div>

        {{-- <div class="home_slide2">
            <div class="content_panel">
                <div class="images">
                    <div class="sea"><img src="/images/home_sea.png" /></div>
                    <div class="text1"><img src="/images/home_text1.png" /></div>
                    <div class="text2"><img src="/images/home_text2.png" /></div>
                </div>
                <div class="text">
                    <div class="txt1">| 해양심층수 생수</div>
                    <div class="txt2">
                        대한민국 동해안에서 7.3km 떨어진 먼 바다에 햇빛이 통과되지 않는 수심
                        500m 이하의 ‘해양심층수 벨트’에서 취수합니다. 인공 미네랄 성분을 첨가
                        하지 않고 천연 미네랄 함량을 조절하는 기술로 프리미엄 미네랄 300의 물을
                        생산하고 있습니다. 인체에 꼭 필요한 60여종의 주요∙미량의 천연 미네랄이
                        아주 풍부하며, 특히 마그네슘의 함량이 칼슘보다도 많고 다른 생수보다 월등히
                        높다는 것과 미네랄 조성이 혈액이나 양수 등의  체액과 거의 유사한 밸런스를
                        가진다는 것이 특징입니다.
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="home_slide3">
            <div class="bg_green"></div>
            <div class="content_panel">
                <div class="explain">
                    <div class="txt1">베스트셀러</div>
                    <div class="txt2">백락이 명마를 고르듯 MD가 엄선한 인기 제품들을 만나보세요!</div>
                </div>

                <div class="item_panel">
                    <div class="arrow"><!--img src="images/home_arrow_left.png"/--></div>

                    <!-- 아이템1 -->
                    <div class="item">
                        <div class="thumbnail cPointer" onClick="gen.redirect('/product/1');"><img src="/images/home_item1_new.jpg"/></div>
                        <div class="name_line">사랑해 500ml x 40개</div>
                        {{-- <div style="display: block;text-align: center;color:#8f8f8f;text-decoration: line-through">48,000 원</div> --}}
                        <div class="price_line">
                            
                            <div class="discount">48,000</div>
                            <div class="won">원</div>
                        </div>
                        <div class="delivery_line"><img src="images/btn_free_delivery.png"/></div>
                    </div>

                    <!-- 아이템2 -->
                    <div class="item">
                        <div class="thumbnail cPointer" onClick="gen.redirect('/product/2');"><img src="/images/home_item2_new.jpg"/></div>
                        <div class="name_line">사랑해 2L x 12개</div>
                        <div class="price_line">
                            <div class="discount">31,200</div>
                            <div class="won">원</div>
                        </div>
                        <div class="delivery_line"><img src="images/btn_free_delivery.png"/></div>
                    </div>

                    <!-- 아이템3 -->
                    <div class="item">
                        <!--div class="thumbnail cPointer" onClick="gen.redirect('/subscrib/7');"><img src="<?=Storage::url('public/products/2112281333331640666013072hPW6A3llT3JMElwsoReO.png')?>"/></div-->
                        <div class="thumbnail cPointer" onClick="gen.redirect('/subscrib');"><img src="/images/home_item3.png"/></div>
                        <div class="name_line">할인 정기배송</div>
                    </div>

                    <!-- 아이템3 -->
                    {{-- <div class="item">
                        <div class="coming_soon"><img src="images/cover_text_coming_soon.png"/></div>
                    </div> --}}

                    <div class="arrow"><!--img src="images/home_arrow_right.png"/--></div>
                </div>
            </div>
        </div>

    </div>
<script>


//ie에서 거절하고 엣지를 열도록
if((navigator.userAgent.indexOf("MSIE") > 0)||(navigator.userAgent.indexOf("rv:11") > 0))
{
    console.log(navigator.userAgent);
    if(confirm('홈페이지가 인터넷 익스플로어를 지원하지 않습니다.\n\n엣지브라우저로 홈페이지를 접속하시겠습니까?'))
    {
        window.location = 'microsoft-edge:https://100rakon.com';
    }
}

// 가로 너비에 따라서 크기를 바꿈
let winWidth = $('body').width();
let winHeight = $(window).height();

//화면 가로가 1920 보다 작아지면 높이를 기준으로 비디오 전환
if(winWidth >= 1920)
{
    $('.home_slide1 video').css('width', '110%');
}else{
    $('.home_slide1 video').css('height', '110%');
}
//모바일일 때
if(winWidth < 769)
{
    $('#mall_header_mobile_back_block').css('display', 'none');
}
$(document).ready(function()
{
    //태블릿 모드일 때
    if( (winWidth > 768) && (winWidth < 1280) )
    {
        //세로가 가로보다 길 때
        if( winWidth > winHeight )
        {
            let showRate = (winHeight/1080);
            $('body .home_slide1').css('zoom', showRate);
            $('body .home_slide2').css('zoom', showRate);
            $('body .home_slide3').css('zoom', showRate);
            $('body .home_slide4').css('zoom', showRate);
        }else{
            let showRate = (winWidth/1920)*1.4;
            $('body .home_slide1').css('zoom', showRate);
            $('body .home_slide2').css('zoom', showRate);
            $('body .home_slide3').css('zoom', showRate);
            $('body .home_slide4').css('zoom', showRate);
        }
    }

    //로딩 후 애니메이션
    $("#mall_home").animate({'opacity': 1}, 1200, function()
    {
        $('.home_slide1 .description .text1').addClass('animate');
        $('.home_slide1 .description .bar').addClass('animate');
        $('.home_slide1 .description .text2').addClass('animate');
        $('.home_slide1 .description .text3').addClass('animate');
    })
});



</script>
@endsection
