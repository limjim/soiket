<header class="main-header" ng-controller="HeaderController" ng-cloak>
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">SOIKET</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">SOIKET</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" ng-if="countUnseem > 0">@{{ countUnseem }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Bạn có @{{ countUnseem }} thông báo chưa đọc</li>
              <li style="cursor: pointer" ng-click="seenNotification(item)">
                <ul class="menu">
                  <li ng-repeat="item in notifications track by $index" class="active" ng-class="item.is_send ? '' : 'unseen-notification'">
                    <a href="" ng-click="seenNotification(item)">
                      <i class="fa fa-shopping-basket text-aqua"></i> <span ng-bind-html="item.content"></span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="" ng-click="seenAll()">Đánh dấu tất cả đã đọc</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/shop-avatar.jpg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= \Auth::user()->email ? \Auth::user()->email : ''?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('img/shop-avatar.jpg') }}" class="img-circle" alt="User Image">
                <p>
                <?= \Auth::user()->name ? \Auth::user()->name : ''?>
                </p>
              <!-- Menu Footer-->
              <li class="user-footer text-center">
                <div class="pull-left">
                  <a href="{{ route('profile') }}" class="btn btn-default btn-flat"><i class="fa fa-info"></i> Xem hồ sơ</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('password') }}" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Mật khẩu</a>
                </div>
              </li>
            </ul>
          </li>

          <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
        </ul>
      </div>
    </nav>
</header>