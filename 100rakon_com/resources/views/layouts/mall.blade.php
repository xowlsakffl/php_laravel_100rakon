<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')백락온(百樂ON)</title>
    <meta charset="utf-8">
    <link rel="shortcut" href="favicon.ico" />
    <meta http-equiv="CACHE-CONTROL" content="no-store" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
    <meta name="naver-site-verification" content="58a5f69d8d1cc4f79e4db44e44c56481eb212aa4" />
    <!-- CSRF Token --><meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts --><script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Scripts --><script src="{{ asset('js/gen.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false"></script>
    <script src="https://js.tosspayments.com/v1"></script>
    <!-- Styles --><link href="{{ asset('css/mall.css') }}" rel="stylesheet">
    <style>
        body { padding: 0px; margin: 0px; }
    </style>

    <meta property="og:title" content="백락온(百樂ON) :: 100rakon.com" />
    <meta property="og:url" content="{{ config('app.url').$_SERVER['REQUEST_URI'] }}" />
    <meta property="og:image" content="{{ config('app.url') }}/images/home_og_image2.jpg" />
</head>
<body id="app">
    @section('header')
        <!-- 모바일 전용 -->
        <div id="mall_header_mobile_back_block" class="showMobile"></div><!-- 상단 뒷 배경용 -->
        <header id="mall_header_mobile" class="showMobile">
            <div>
                <button class="mbtn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="logo">
                <a href="/"><img src="/images/logo_header.png"/></a>
            </div>
            <div class="slide_menu">
                <div class="mymenu">
                    <ul>
                    @guest
                        <li>
                            <a href="{{ route('login') }}">
                                <div class="imgbox">
                                    <img src="/images/right_menu_login2.png" alt="">
                                </div>
                                <span>로그인</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">
                                <div class="imgbox">
                                    <img src="/images/right_menu_regist.png" alt="">
                                </div>
                                <span>회원가입</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void();" onClick="alert('로그인이 필요합니다.');">
                                <div class="imgbox">
                                    <img src="/images/right_menu_cart.png" alt="">
                                </div>
                                <span>장바구니</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void();" onClick="alert('로그인이 필요합니다.');">
                                <div class="imgbox">
                                    <img src="/images/right_menu_order.png" alt="">
                                </div>
                                <span>주문조회</span>
                            </a>
                        </li>
                    @else
                    <li>
                        <a href="/myinfo">
                            <div class="imgbox">
                                <img src="/images/right_menu_myinfo.png" alt="">
                            </div>
                            <span>나의정보</span>
                        </a>
                    </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_logout.png" alt="">
                                    </div>
                                    <span>로그아웃</span>
                                </button>
                            </form>
                        </li>
                        <li>
                            <a href="/order/basket">
                                <div class="imgbox">
                                    <img src="/images/right_menu_cart.png" alt="">
                                </div>
                                <span>장바구니</span>
                            </a>
                        </li>
                        <li>
                            <a href="/myorder">
                                <div class="imgbox">
                                    <img src="/images/right_menu_order.png" alt="">
                                </div>
                                <span>주문조회</span>
                            </a>
                        </li>
                    @endguest
                    </ul>
                </div>
                <ul class="sub_mbtn">
                    <li onClick="gen.redirect('/intro')">백락온소개</li>
                    {{-- <li onClick="gen.redirect('/saranghae')">사랑해골드</li> --}}
                    <li onClick="gen.redirect('/product')">제품구매</li>
                    <li onClick="gen.redirect('/subscrib')">정기배송</li>
                    <li onClick="gen.redirect('/qna')">고객센터</li>
                    @auth
                    @if(Auth::user()->super == 'Y')
                        <li><a href="/admin/home">운영자</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
        </header>
<script>
//서브메뉴 보기
$(".mbtn").on('click', function()
{
    if($(".slide_menu").css('display') == 'none')
    {
        $(".mbtn").addClass('active');
        $(".slide_menu").animate({'opacity': 1}, 150).slideDown(150);
        if($(window).scrollTop() > 0)
        {
            $("#mall_header_mobile").css('opacity', 1);
        }
    }else{
        $(".mbtn").removeClass('active');
        $(".slide_menu").animate({'opacity': 0}, 150).slideUp(150);
        if($(window).scrollTop() > 0)
        {
            $("#mall_header_mobile").css('opacity', 0.7);
        }
    }
});
//스크롤 시 상단메뉴 투명해짐
$(window).scroll(function(){
    if($(".slide_menu").css('display') == 'none')
    {
        if($(this).scrollTop() > 0)
        {
            $("#mall_header_mobile").css('opacity', 0.7);
        }else{
            $("#mall_header_mobile").css('opacity', 1);
        }
    }
});
</script>

        <!-- PC/태블릿 전용 -->
        <header id="mall_header" class="showPCTablet">
            <div class="bg"></div>
            <div class="panel">
                <div class="left_menu">
                    <ul>
                        <li><a href="/intro">백락온소개</a></li>
                        {{-- <li><a href="/saranghae">사랑해골드</a></li> --}}
                        <li><a href="/product">제품구매</a></li>
                        <li><a href="/subscrib">정기배송</a></li>
                        <li><a href="/qna">고객센터</a></li>
                        @auth
                        @if(Auth::user()->super == 'Y')
                            <li><a href="/admin/home">운영자</a></li>
                        @endif
                        @endauth
                    </ul>
                </div>
                <div class="logo">
                <a href="/"><img src="/images/logo_header.png"/></a>
                </div>
                <div class="right_menu">
                    <ul>
                        @guest
                            <li>
                                <a href="{{ route('login') }}">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_login2.png" alt="">
                                    </div>
                                    <span>로그인</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_regist.png" alt="">
                                    </div>
                                    <span>회원가입</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void();" onClick="alert('로그인이 필요합니다.');">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_cart.png" alt="">
                                    </div>
                                    <span>장바구니</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void();" onClick="alert('로그인이 필요합니다.');">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_order.png" alt="">
                                    </div>
                                    <span>주문조회</span>
                                </a>
                            </li>
                        @else
                            {{-- <li>
                                <a href="#">{{ Auth::user()->name }}님 접속</a>
                            </li> --}}
                            <li>
                                <a href="/myinfo">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_myinfo.png" alt="">
                                    </div>
                                    <span>나의정보</span>
                                </a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit">
                                        <div class="imgbox">
                                            <img src="/images/right_menu_logout.png" alt="">
                                        </div>
                                        <span>로그아웃</span>
                                    </button>
                                </form>
                            </li>
                            <li>
                                <a href="/order/basket">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_cart.png" alt="">
                                    </div>
                                    <span>장바구니</span>
                                </a>
                            </li>
                            <li>
                                <a href="/myorder">
                                    <div class="imgbox">
                                        <img src="/images/right_menu_order.png" alt="">
                                    </div>
                                    <span>주문조회</span>
                                </a>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </header>
    @show

    <div class="content">
        @yield('content')
    </div>

    @section('footer')
        <div id="mall_footer">
            <div class="footer_left">
                <div class="logo"><img src="/images/logo_header.png"/></div>
                <div class="copyright">Copyright ⓒ 2021 <b>100rakON</b>. All Rights Reserved.</div>
                <div class="cs">고객센터 <a href="tel:02-6288-6350">02-6288-6350</a></div>
                <div class="open showPCTablet">
                    운영시간 : 10:00 ~ 18:00  /  점심 : 11:30 ~ 12:30<br/>
                    (토, 일, 공휴일 휴무)
                </div>
                <div class="open showMobile">
                    운영 : 10:00 ~ 18:00<br/>
                    점심 : 11:30 ~ 12:30<br/>
                    (토, 일, 공휴일 휴무)
                </div>
            </div>
            <div class="footer_right showPCTablet">
                <div>
                    <a href="/terms-use" target="_blank">이용약관</a>
                    <span>|</span>
                    <a href="/terms-privacy" target="_blank">개인정보 취급방침</a>
                </div>
                <div>06572 서울특별시 서초구 방배로 183, 동주빌딩 3층</div>
                <div>팩스 02.6288.6399<span>|</span>이메일 cs@100rakon.com</div>
                <div>사업자번호 216-81-43374<span>|</span>통신판매업 2022-서울서초-0235</div>
                <div>(주)백락온 대표 김분희</div>
            </div>
            <div class="footer_right showMobile">
                <div>
                    <a href="/terms-use" target="_blank">이용약관</a>
                    <span>|</span>
                    <a href="/terms-privacy" target="_blank">개인정보 취급방침</a>
                </div>
                <div>대표 김분희<span>|</span>사업자번호 216-81-43374</div>
                <div>06572 서울특별시 서초구 방배로 183, 동주빌딩 3층</div>
                <div>팩스 02.6288.6399<span>|</span>이메일 cs@100rakon.com</div>
                <div>통신판매업 2022-서울서초-0235</div>
            </div>
        </div>
    @show

    <!-- 퀙메뉴 S -->
    <div class="quickmenu showPC">
        <div onClick="gen.redirect('/product');">제품<br/>구매</div>
        <div onClick="gen.redirect('/subscrib');">정기<br/>배송</div>
    </div>
    <script>
    $(document).ready(function()
    {
        var currentPosition = parseInt($(".quickmenu").css("top"));
        $(window).scroll(function()
        {
            var position = $(window).scrollTop();
            $(".quickmenu").stop().animate({"top":position+currentPosition+"px"},1000);
        });
    });
    </script>
    <!-- 퀙메뉴 E -->

</body>
</html>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FMBB71KHM7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-FMBB71KHM7');
</script>
