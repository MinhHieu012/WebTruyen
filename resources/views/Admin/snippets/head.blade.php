<meta name="robots" content="noindex,nofollow">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
<meta name="description" content="DMS - Thái Minh Group">
<meta name="keywords" content="DMS - Thái Minh Group">
<meta name="author" content="Chuyển Đổi Số - Thái Minh Group">
<title>@yield('page_title', $titlePage ?? 'Trang chủ')</title>

<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/admin/images/ico/icon.ico') }}">

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/vendors.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/css/datepickerV2/daterangepicker.css') }}"/>
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/core.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/base/themes/semi-dark-layout.css') }}">
@stack('css-page-vendor')

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/base/core/menu/menu-types/vertical-menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/base/plugins/forms/form-validation.css') }}">
@stack('css-page-css')
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{ mix('assets/admin/css/style.css') }}">
<!-- END: Custom CSS-->
<script src="https://cdn.tiny.cloud/1/3wq0pcqdh73wjxfqtk7kcr41rvbjs6196573culoiqf56dtm/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>