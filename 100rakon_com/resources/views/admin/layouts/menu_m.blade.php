<nav class="sidebar_m">
    <div class="id_box">
        <h5>{{Auth::user()->name}} 님</h5>
        <div class="logout_btn">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                {{ __('로그아웃') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <ul class="menu_dep_1">
      {{-- <li class="menu_dep_1_li {{ (request()->is('admin/works*')) ? 'active' : '' }}">
        <a href="{{route('admin.works.index')}}" class="menu_dep_1_li_a">
          <i class="fas fa-tasks"></i>
          프로젝트
        </a>
      </li>
      <li class="menu_dep_1_li {{ (request()->is(['admin/layout*', 'admin/pack*'])) ? 'active' : '' }}">
        <a href="javascript:void(0)" class="slideDownMenu menu_dep_1_li_a">
          <i class="far fa-file-alt"></i>
          템플릿
          <i class="fas fa-angle-right"></i>
        </a>
        <ul class="menu_dep_2">
          <li>
            <a href="javascript:void(0)" class="slideDownMenu">
              레이아웃
              <i class="fas fa-angle-right"></i>
            </a>
            <ul class="menu_dep_3">
              <li>
                <a href="{{route('admin.layouts.index')}}">
                  <span class="sidebar-text">레이아웃 목록</span>
                </a>
              </li>
              <li>
                <a href="{{route('admin.layout-navigations.index')}}">
                  <span class="sidebar-text">메인메뉴</span>
                </a>
              </li>
              <li>
                  <a href="{{route('admin.layout-tops.index')}}">
                    <span class="sidebar-text">상단 레이아웃</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('admin.layout-middles.index')}}">
                    <span class="sidebar-text">중단 레이아웃</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('admin.layout-bottoms.index')}}">
                    <span class="sidebar-text">하단 레이아웃</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('admin.layout-etcs.index')}}">
                    <span class="sidebar-text">기타 레이아웃</span>
                  </a>
                </li>
            </ul>
          </li>
          <li>
            <a href="javascript:void(0)" class="slideDownMenu">
              기능모듈
              <i class="fas fa-angle-right"></i>
            </a>
            <ul class="menu_dep_3">
              <li>
                <a href="{{route('admin.packs.index')}}">
                  <span class="sidebar-text">기능모듈</span>
                </a>
              </li>
              <li>
                <a class="nav-link" href="{{route('admin.packs.index')}}">
                  <span class="sidebar-text">기능 목록</span>
                </a>
              </li>
              <li>
                  <a class="nav-link" href="{{route('admin.layout-tops.index')}}">
                    <span class="sidebar-text">웹페이지</span>
                  </a>
              </li>
                <li>
                  <a class="nav-link" href="{{route('admin.layout-middles.index')}}">
                    <span class="sidebar-text">게시판</span>
                  </a>
                </li>
                <li>
                  <a class="nav-link" href="{{route('admin.layout-bottoms.index')}}">
                    <span class="sidebar-text">걸제</span>
                  </a>
                </li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="menu_dep_1_li {{ (request()->is('admin/users*')) ? 'active' : '' }}">
        <a href="{{route('admin.users.index')}}" class="menu_dep_1_li_a">
          <i class="far fa-user"></i>
          사용자
        </a>
      </li>
      <li class="menu_dep_1_li">
        <a href="" class="menu_dep_1_li_a">
          <i class="fas fa-shopping-cart"></i>
          결제
        </a>
      </li>
      <li class="menu_dep_1_li">
        <a href="" class="menu_dep_1_li_a">
          <i class="fas fa-chart-line"></i>
          통계
        </a>
      </li>
      <li class="menu_dep_1_li">
        <a href="" class="menu_dep_1_li_a">
          <i class="far fa-file"></i>
          기타
        </a>
      </li> --}}
    </ul>
  </nav>