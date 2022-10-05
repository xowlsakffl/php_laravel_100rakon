<header class="header">
    <div class="left_area">
      <a href="{{url('/admin/home')}}" class="logo">관리</a>
    </div>
    <button class="menu-btn">
      <box-icon name='menu' color='#ffffff' style="width: 30px;height:30px" ></box-icon>
    </button>
    <div class="right_area">
      <button class="auth_btn">
        <a href="/" target="_blank"><span>홈페이지</span></a>
        <i class="fas fa-caret-down"></i>
      </button>
      <button class="auth_btn">
        <span>{{Auth::user()->name}}</span>
        <i class="fas fa-caret-down"></i>
      </button>
      <ul class="auth_box">
        <!-- Authentication Links -->
        @auth
            <li>
              <a href="">
                <box-icon type='solid' name='user-circle' color="#262b40" class="logout_icon"></box-icon>
                관리자
              </a>
            </li>
            <li class="logout_li">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <box-icon name='log-out' type='solid' flip='vertical' color='#d81616' class="logout_icon"></box-icon>
                    {{ __('로그아웃') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endauth
      </ul>
    </div>
</header>
{{-- <header class="header_m">
<div class="left_area">
    <a href="{{url('/admin')}}" class="logo">
        EVENTS <span>PACK</span>
    </a>
</div>
<div class="right_area">
    <button class="menu-btn_m">
    <i class="fas fa-bars"></i>
    </button>
</div>
</header> --}}
