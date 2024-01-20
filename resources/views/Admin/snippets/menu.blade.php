<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content bg-logo">

        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle is-active" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-menu ficon">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <a class="logo_header" href="{{ route('admin.dashboard.index') }}">
            {{-- <img src="{{ asset('images/logo-2023.png') }}" alt=""> --}}
        </a>
    </div>
</nav>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark" data-scroll-to-active="true">
    <div class="navbar-header">

        {{-- <img src="{{ asset('app-assets/images/logo/logo.png') }}" alt="{{ config('app.company') }}"/>
            <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x d-block d-xl-none text-primary toggle-icon font-medium-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-disc d-none d-xl-block collapse-toggle-icon primary font-medium-4"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="3"></circle></svg></a> --}}

        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ route('admin.dashboard.index') }}">
                    <span class="brand-logo">
                        {{-- <img src="{{ asset('assets/admin/images/logo/logo-icon-2023.png') }}" height="36" alt="logo-thai-minh-admin"
                             class="logo-icon"/>
                        <img src="{{ asset('assets/admin/images/logo/logo-menu-2023.png') }}" height="36" alt="logo-thai-minh-admin"
                             class="logo-full"/> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50"
                            height="50" viewBox="0 0 50 50" style="fill: #fff;">
                            <path
                                d="M 11.984375 4 A 1.0001 1.0001 0 0 0 11.292969 4.2929688 L 3.2929688 12.292969 A 1.0001 1.0001 0 0 0 3 13 L 3 36 A 1.0001 1.0001 0 0 0 3.2929688 36.707031 L 13.292969 46.707031 A 1.0001 1.0001 0 0 0 15 46 L 15 25.414062 L 24.292969 34.707031 A 1.0001 1.0001 0 0 0 25.707031 34.707031 L 35 25.414062 L 35 46 A 1.0001 1.0001 0 0 0 36.707031 46.707031 L 46.707031 36.707031 A 1.0001 1.0001 0 0 0 47 36 L 47 13 A 1.0001 1.0001 0 0 0 46.707031 12.292969 L 38.707031 4.2929688 A 1.0001 1.0001 0 0 0 37.292969 4.2929688 L 25 16.585938 L 12.707031 4.2929688 A 1.0001 1.0001 0 0 0 11.984375 4 z M 12 6.4140625 L 24 18.414062 L 24 31.585938 L 5.4140625 13 L 12 6.4140625 z M 38 6.4140625 L 44.585938 13 L 26 31.585938 L 26 18.414062 L 38 6.4140625 z M 5 15.414062 L 13 23.414062 L 13 43.585938 L 5 35.585938 L 5 15.414062 z M 45 15.414062 L 45 35.585938 L 37 43.585938 L 37 23.414062 L 45 15.414062 z">
                            </path>
                        </svg>
                    </span>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-x d-block d-xl-none text-primary toggle-icon font-medium-4">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-disc d-none d-xl-block collapse-toggle-icon primary font-medium-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>
            </li>
        </ul>

    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <!-- ===== START: DATA MENU ===== -->
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php
            $menu_data = \App\Helpers\Helper::menuData();
            ?>
            @if (!empty($menu_data))
                @foreach ($menu_data as $menu)
                    @if (isset($menu['group']) && !empty($menu['name']))
                        <li class="navigation-header">
                            <span>{{ $menu['name'] }}</span>
                            <i data-feather="more-horizontal"></i>
                        </li>
                    @endif
                    @if (!empty($menu['child']))
                        @include('Admin.snippets.menu-items', ['items' => $menu['child']])
                    @endif
                @endforeach
            @endif
            @if ($switch_back = session()->get('switch_back'))
                <li class="navigation-header">
                    <span>Chuyển tài khoản</span>
                </li>
                <li class="item-switch-user">
                    <a href="{{ route('admin.users.switch.back', [$switch_back]) }}">
                        <i data-feather='refresh-cw'></i>
                        <span class="menu-title text-truncate">Quay lại</span>
                    </a>
                </li>
            @elseif(\App\Helpers\Helper::userCan('switch_user'))
                <li class="navigation-header">
                    <span>Chuyển tài khoản</span>
                </li>
                <li class="item-switch-user">
                    <form method="post" action="{{ route('admin.users.switch.change') }}"
                        style="margin: 0 10px;padding: 0 10px">
                        @csrf
                        <div class="input-group">
                            <input id="su-email" type="text" name="email" placeholder="  email"
                                class="form-control">
                            <button type="submit" class="input-group-text cursor-pointer">
                                <i data-feather='refresh-cw'></i>
                            </button>
                        </div>
                    </form>
                </li>
            @endif
        </ul>
        <!-- ===== END: DATA MENU ===== -->
    </div>
</div>
