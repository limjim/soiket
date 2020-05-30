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
              <span class="hidden-xs">guest@soiket.com</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('img/shop-avatar.jpg') }}" class="img-circle" alt="User Image">
                <p>
                  Hello Guest
                </p>
              <!-- Menu Footer-->
             
            </ul>
          </li>
        </ul>
      </div>
    </nav>
</header>