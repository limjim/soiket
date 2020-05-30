@php
    $currentURL = Request::route()->getName();
@endphp
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{ ($currentURL == 'friend') ? 'active' : '' }}">
                <a href="{{ route('friend') }} ">
                    <i class="fa fa-address-card"></i>
                    <span>Danh sách bạn</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">New</small>
                    </span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>