<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" href="{{ asset(mix('assets/admin/vendors/css/vendors.min.css')) }}"/>

@yield('vendor-style')
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="{{ asset(mix('assets/admin/css/core.css')) }}"/>

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" href="{{ asset(mix('assets/admin/css/base/core/menu/menu-types/vertical-menu.css')) }}"/>

{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style -->
<link rel="stylesheet" href="{{ asset(mix('assets/admin/css/overrides.css')) }}"/>

<!-- BEGIN: Custom CSS-->

{{-- user custom styles --}}
<link rel="stylesheet" href="{{ asset(mix('assets/admin/css/style.css')) }}"/>
