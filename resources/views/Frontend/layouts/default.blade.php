<!doctype html>
<html lang="en">

<head>
    {{-- <title>Title</title> --}}
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="canonical" href="{{ url()->current() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Mooli&family=Patrick+Hand&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">


    <!-- Bootstrap CSS v5.2.1 -->
    {{-- <link href="./dist/libs/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('assets/frontend/libs/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/frontend/libs/css/swiper-bundle.min.css') }}" rel="stylesheet"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/frontend/images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset(mix('assets/frontend/css/app.css')) }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset(mix('assets/frontend/libs/css/font-awesome.min.css')) }}"> --}}

    <script>
        window.SuuTruyen = {
            baseUrl: '{{ config('app.url') }}',
            urlCurrent: '{{ url()->current() }}',
            csrfToken: '{{ csrf_token() }}'
        }
    </script>

    @routes()

    {{-- <style>
        :root {
            --font-family: {!! $fontFamily ?? 'sans-serif' !!};
            --color-custom-primary: {{ $themeValue['color_primary'] ?? '' }};
            --color-custom-primary-hover: {{ $themeValue['color_hover_primary'] ?? '' }};
            --color-custom-secondary: {{ $themeValue['color_secondary'] ?? '' }};
            --color-custom-secondary-hover: {{ $themeValue['color_hover_secondary'] ?? '' }};
        }
    </style> --}}
    @stack('custom_schema')

    @if (isset($setting) && $setting)
        {!! $setting->header_script !!}
    @endif
</head>

<body @if ($bgColorCookie == 'dark') class="dark-theme" @endif>
    @if (isset($setting) && $setting)
        {!! $setting->body_script !!}
    @endif

    @stack('before_content')
    @include('Frontend.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('Frontend.layouts.footer')

    @include('Frontend.layouts.script_default')

    @stack('scripts')

    @if (isset($setting) && $setting)
        {!! $setting->footer_script !!}
    @endif

    @include('Frontend.snippets.loading_full')
</body>

</html>
