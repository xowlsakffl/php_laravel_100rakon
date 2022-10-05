<nav class="sidebar">
  <ul class="menu_dep_1">
    <li class="menu_dep_1_li {{ (request()->is('admin/home')) ? 'active' : '' }}">
      <a href="{{route('admin.home')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-grid-alt'></i></span>
        <span class="menu_title">대쉬보드</span>
      </a>
    </li>
    <li class="menu_dep_1_li {{ (request()->is('admin/users*')) ? 'active' : '' }}">
      <a href="{{route('admin.users.index')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-user-circle'></i></span>
        <span class="menu_title">회원 관리</span>
      </a>
    </li>
    <li class="menu_dep_1_li {{ (request()->is(['admin/categories*', 'admin/products*'])) ? 'active' : '' }}">
      <a href="javascript:void(0)" class="slideDownMenu menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-package'></i></span>
        <span class="menu_title">제품 관리</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="{{route('admin.products.index')}}" class="blank">제품 목록</a>
        </li>
        <li>
          <a href="{{route('admin.categories.index')}}" class="blank">제품 분류</a>
        </li>
      </ul>
    </li>
    <li class="menu_dep_1_li {{ (request()->is(['admin/subscrib-categories*', 'admin/subscrib-goods*'])) ? 'active' : '' }}">
      <a href="javascript:void(0)" class="slideDownMenu menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-package'></i></span>
        <span class="menu_title">정기배송 관리</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="{{route('admin.subscrib-goods.index')}}" class="blank">상품 목록</a>
        </li>
        <li>
          <a href="{{route('admin.subscrib-categories.index')}}" class="blank">상품 분류</a>
        </li>
      </ul>
    </li>
    <li class="menu_dep_1_li {{ (request()->is('admin/orders*')) ? 'active' : '' }}">
      <a href="{{route('admin.orders.index')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-basket'></i></span>
        <span class="menu_title">주문 관리</span>
      </a>
    </li>
    <li class="menu_dep_1_li {{ (request()->is('admin/subscrib-orders*')) ? 'active' : '' }}">
      <a href="{{route('admin.subscrib-orders.index')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-basket'></i></span>
        <span class="menu_title">정기배송 주문 관리</span>
      </a>
    </li>

    <li class="menu_dep_1_li {{ (request()->is(['admin/outstands*', 'admin/outstand-categories*'])) ? 'active' : '' }}">
      <a href="javascript:void(0)" class="slideDownMenu menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-basket'></i></span>
        <span class="menu_title">특별상품 관리</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="{{route('admin.outstands.index')}}" class="blank">상품 목록</a>
        </li>
        <li>
          <a href="{{route('admin.outstand-categories.index')}}" class="blank">상품 분류</a>
        </li>
      </ul>
    </li>

    <li class="menu_dep_1_li {{ (request()->is('admin/outstand-orders*')) ? 'active' : '' }}">
      <a href="{{route('admin.outstand-orders.index')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-basket'></i></span>
        <span class="menu_title">특별상품 주문 관리</span>
      </a>
    </li>

    <li class="menu_dep_1_li {{ (request()->is('admin/qnas*')) ? 'active' : '' }}">
      <a href="{{route('admin.qnas.index')}}" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-message-rounded-dots' ></i></span>
        <span class="menu_title">고객문의</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="" class="blank">고객문의</a>
        </li>
      </ul>
    </li>

    <li class="menu_dep_1_li">
      <a href="" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-credit-card'></i></span>
        <span class="menu_title">결제</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="" class="blank">결제</a>
        </li>
      </ul>
    </li>
    
    <li class="menu_dep_1_li">
      <a href="" class="menu_dep_1_li_a">
        <span class="menu_icon"><i class='bx bx-message-rounded-dots' ></i></span>
        <span class="menu_title">기타</span>
      </a>
      <ul class="menu_dep_2">
        <li>
          <a href="" class="blank">기타</a>
        </li>
      </ul>
    </li>
  </ul>
</nav>
