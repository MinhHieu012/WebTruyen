{{-- @dd($menu) --}}

<header class="header d-none d-lg-block">
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-lg navbar-dark header__navbar p-md-0">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/frontend/images/logo_text.png') }}" alt="Logo Suu Truyen" srcset=""
                    class="img-fluid" style="width: 200px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Thể loại
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            @foreach ($menu['the_loai'] as $menuItem)
                                <li><a class="dropdown-item"
                                        href="{{ route('category', ['slug' => $menuItem->slug]) }}">{{ $menuItem->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Theo số chương
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item" href="{{ route('get.list.story.with.chapters.count', ['value' => [0, 100]]) }}">Dưới 100</a>
                            <li><a class="dropdown-item" href="{{ route('get.list.story.with.chapters.count', ['value' => [100, 500]]) }}">100 - 500</a>
                            <li><a class="dropdown-item" href="{{ route('get.list.story.with.chapters.count', ['value' => [500, 1000]]) }}">500 - 1000</a>
                            <li><a class="dropdown-item" href="{{ route('get.list.story.with.chapters.count', ['value' => [1000, 999999999]]) }}">Trên 1000</a>
                        </li>
                        </ul>
                    </li>
                    @if (Route::currentRouteName() == 'chapter')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Tùy chỉnh
                            </a>
                            <div class="dropdown-menu dropdown-menu-right settings-theme">
                                <form class="form-horizontal">
                                    <div class="form-group form-group-sm d-flex align-items-center px-2 mb-2">
                                        <label class="w-25 control-label me-1" for="setting_font">Font chữ</label>
                                        <div class="w-75">
                                            <select class="form-control setting-font">
                                                <option value="roboto"
                                                    @if ($chapterFont == 'roboto') selected @endif>Roboto</option>
                                                <option value="mooli"
                                                    @if ($chapterFont == 'mooli') selected @endif>Mooli</option>
                                                <option value="patrick_hand"
                                                    @if ($chapterFont == 'patrick_hand') selected @endif>Patrick Hand
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-sm d-flex align-items-center px-2 mb-2">
                                        <label class="w-25 control-label me-1" for="setting_font_size">Size chữ</label>
                                        <div class="w-75">
                                            <select class="form-control setting-font-size">
                                                @for ($i = 16; $i <= 48; $i += 2)
                                                    <option value="{{ $i }}"
                                                        @if ($chapterFontSize == $i) selected @endif>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-sm d-flex align-items-center px-2">
                                        <label class="w-25 control-label me-1" for="setting_line_height">Chiều cao
                                            dòng</label>
                                        <div class="w-75">
                                            <select class="form-control setting-line-height">
                                                @for ($i = 100; $i <= 200; $i += 20)
                                                    <option value="{{ $i }}"
                                                        @if ($chapterLineHeight == $i) selected @endif>
                                                        {{ $i }}%</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>

                <div class="form-check form-switch me-3 d-flex align-items-center">
                    <label class="form-check-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-brightness-high" viewBox="0 0 16 16" style="fill: #fff;">
                            <path
                                d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                            </path>
                        </svg>
                    </label>
                    <input class="form-check-input theme_mode" type="checkbox"
                        @if ($bgColorCookie == 'dark') checked @endif
                        style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">

                    <label class="form-check-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 384 512"
                            style="fill: #fff;">
                            <path
                                d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z" />
                        </svg>
                    </label>
                </div>

                <form class="d-flex header__form-search" action="{{ route('main.search.story') }}" method="GET">
                    @php
                        $valueDefault = '';
                        if (request()->input('key_word')) {
                            $valueDefault = request()->input('key_word');
                        }
                    @endphp
                    <input class="form-control search-story" type="text" placeholder="Tìm kiếm" name="key_word"
                        value="{{ $valueDefault }}">
                    <div class="col-12 search-result shadow no-result d-none">
                        <div class="card text-white bg-light">
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush d-none">
                                    <li class="list-group-item">
                                        <a href="#" class="text-dark hover-title">Tự cẩm</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button class="btn" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                        {{-- <i class="fa-solid fa-magnifying-glass"></i> --}}
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>

<div class="header-mobile d-sm-block d-lg-none">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets/frontend/images/logo_text.png') }}" alt="Logo Suu Truyen" srcset=""
                    class="img-fluid" style="width: 200px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark w-75" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <img src="{{ asset('assets/frontend/images/logo_text.png') }}" alt="Logo Suu Truyen"
                        srcset="" class="img-fluid" style="width: 200px;">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Thể loại
                            </a>
                            <ul class="dropdown-menu dropdown-menu-custom">
                                @foreach ($menu['the_loai'] as $menuItem)
                                    <li><a class="dropdown-item"
                                            href="{{ route('category', ['slug' => $menuItem->slug]) }}">{{ $menuItem->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        @if (Route::currentRouteName() == 'chapter')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Tùy chỉnh
                                </a>
                                <div class="dropdown-menu dropdown-menu-right settings-theme">
                                    <form class="form-horizontal">
                                        <div class="form-group form-group-sm d-flex align-items-center px-2 mb-2">
                                            <label class="w-25 control-label me-1" for="setting_font">Font chữ</label>
                                            <div class="w-75">
                                                <select class="form-control setting-font">
                                                    <option value="roboto"
                                                        @if ($chapterFont == 'roboto') selected @endif>Roboto
                                                    </option>
                                                    <option value="mooli"
                                                        @if ($chapterFont == 'mooli') selected @endif>Mooli</option>
                                                    <option value="patrick_hand"
                                                        @if ($chapterFont == 'patrick_hand') selected @endif>Patrick Hand
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-sm d-flex align-items-center px-2 mb-2">
                                            <label class="w-25 control-label me-1" for="setting_font_size">Size
                                                chữ</label>
                                            <div class="w-75">
                                                <select class="form-control setting-font-size">
                                                    @for ($i = 16; $i <= 48; $i += 2)
                                                        <option value="{{ $i }}"
                                                            @if ($chapterFontSize == $i) selected @endif>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-sm d-flex align-items-center px-2">
                                            <label class="w-25 control-label me-1" for="setting_line_height">Chiều cao
                                                dòng</label>
                                            <div class="w-75">
                                                <select class="form-control setting-line-height">
                                                    @for ($i = 100; $i <= 200; $i += 20)
                                                        <option value="{{ $i }}"
                                                            @if ($chapterLineHeight == $i) selected @endif>
                                                            {{ $i }}%</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>

                    <div class="form-check form-switch d-flex align-items-center mb-3 p-0">
                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16"
                                style="fill: #fff;">
                                <path
                                    d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z">
                                </path>
                            </svg>
                        </label>
                        <input class="form-check-input theme_mode" type="checkbox"
                            @if ($bgColorCookie == 'dark') checked @endif
                            style="transform: scale(1.3); margin-left: 12px; margin-right: 12px;">

                        <label class="form-check-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                viewBox="0 0 384 512" style="fill: #fff;">
                                <path
                                    d="M144.7 98.7c-21 34.1-33.1 74.3-33.1 117.3c0 98 62.8 181.4 150.4 211.7c-12.4 2.8-25.3 4.3-38.6 4.3C126.6 432 48 353.3 48 256c0-68.9 39.4-128.4 96.8-157.3zm62.1-66C91.1 41.2 0 137.9 0 256C0 379.7 100 480 223.5 480c47.8 0 92-15 128.4-40.6c1.9-1.3 3.7-2.7 5.5-4c4.8-3.6 9.4-7.4 13.9-11.4c2.7-2.4 5.3-4.8 7.9-7.3c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-3.7 .6-7.4 1.2-11.1 1.6c-5 .5-10.1 .9-15.3 1c-1.2 0-2.5 0-3.7 0c-.1 0-.2 0-.3 0c-96.8-.2-175.2-78.9-175.2-176c0-54.8 24.9-103.7 64.1-136c1-.9 2.1-1.7 3.2-2.6c4-3.2 8.2-6.2 12.5-9c3.1-2 6.3-4 9.6-5.8c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-3.6-.3-7.1-.5-10.7-.6c-2.7-.1-5.5-.1-8.2-.1c-3.3 0-6.5 .1-9.8 .2c-2.3 .1-4.6 .2-6.9 .4z" />
                            </svg>
                        </label>
                    </div>

                    <form class="d-flex header__form-search" action="{{ route('main.search.story') }}"
                        method="GET">
                        @php
                            $valueDefault = '';
                            if (request()->input('key_word')) {
                                $valueDefault = request()->input('key_word');
                            }
                        @endphp
                        <input class="form-control search-story" type="text" placeholder="Tìm kiếm"
                            name="key_word" value="{{ $valueDefault }}">
                        <div class="col-12 search-result shadow no-result d-none">
                            <div class="card text-white bg-light">
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush d-none">
                                        <li class="list-group-item">
                                            <a href="#" class="text-dark hover-title">Tự cẩm</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <button class="btn" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                            {{-- <i class="fa-solid fa-magnifying-glass"></i> --}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>

<div class="bg-light header-bottom">
    <div class="container py-1">
        <p class="mb-0">Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên
            tục.</p>
    </div>
</div>

@push('scripts')
    <script src="{{ asset(mix('assets/frontend/js/common.js')) }}"></script>
@endpush
