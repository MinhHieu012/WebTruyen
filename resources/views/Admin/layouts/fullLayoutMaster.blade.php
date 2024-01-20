<!DOCTYPE html>
<html class="loading" lang="vi" data-textdirection="ltr">

<head>
    @include('Admin.snippets.head')
</head>


<body
    class="vertical-layout vertical-menu-modern navbar-floating blank-page footer-static menu-{{ $_COOKIE['menu_status'] ?? 'collapsed not-cookie' }}"
    data-menu="vertical-menu-modern" data-col="blank-page" data-framework="laravel" data-asset-path="{{ asset('/')}}">

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    <div class="content-wrapper">
        <div class="content-body">

            {{-- Include Startkit Content --}}
            @yield('content')

        </div>
    </div>
</div>
<!-- End: Content-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-start d-block d-md-inline-block mt-25">

        </span>
        <span class="float-md-end d-none d-md-block">
            COPYRIGHT &copy; 2023 Dev Dark, All rights Reserved
        </span>
    </p>
</footer>
{{-- include default scripts --}}
@include('Admin.panels/scripts')

<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>

</body>

</html>
