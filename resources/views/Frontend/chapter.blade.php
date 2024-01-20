@extends('Frontend.layouts.default')

@push('custom_schema')
{{-- {!! SEOMeta::generate() !!} --}}
{{-- {!! JsonLd::generate() !!} --}}
{!! SEO::generate() !!}
@endpush

@section('content')
    <style>
        .chapter-start {
            background: url(//static.8cache.com/img/spriteimg_new_white_op.png) -200px -27px;
            width: 59px;
            height: 20px;
            border-top: none;
        }

        .chapter-end {
            background: url(//static.8cache.com/img/spriteimg_new_white_op.png) 0 -51px;
            width: 277px;
            height: 35px;
            border-top: none;
        }
    </style>
    <div class="chapter-wrapper container my-5">
        <a href="#" class="text-decoration-none">
            <h1 class="text-center text-success">{{ $story->name }}</h1>
        </a>
        <a href="" class="text-decoration-none">
            <p class="text-center text-dark">{{ $chapter->name }}</p>
        </a>
        <hr class="chapter-start container-fluid">
        <div class="chapter-nav text-center">
            <div class="chapter-actions chapter-actions-origin d-flex align-items-center justify-content-center">
                {{-- @if ($chapter->chapter != 1) --}}
                @if ($chapterBefore)
                <a class="btn btn-success me-1 chapter-prev" href="{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterBefore->slug]) }}" title=""> <span>Chương </span>trước</a>
                @endif
                <button class="btn btn-success chapter_jump me-1" data-story-id="{{ $story->id }}" data-slug-chapter="{{ $slugChapter }}" data-slug-story="{{ $story->slug }}">
                    <span>
                        <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
                        {{-- <i class="fa-solid fa-bars"></i> --}}
                    </span>
                </button>

                <div class="dropdown select-chapter me-1 d-none">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Chọn chương
                    </a>

                    <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink">
                      
                    </ul>
                </div>
                @if ($chapterAfter)
                <a class="btn btn-success chapter-next" href="{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterAfter->slug]) }}" title=""><span>Chương </span>tiếp</a>
                @endif
            </div>
        </div>
        <hr class="chapter-end container-fluid">

        {{-- @dd(config('fonts.roboto'), $chapterFont) --}}
        <div class="chapter-content mb-3">
        <style>
            .chapter-content {
                @if ($chapterFont)
                    font-family: {!! config('fonts.'.$chapterFont) !!}
                @endif
                @if ($chapterFontSize)
                    font-size: {{ $chapterFontSize }}px;
                @endif
                @if ($chapterLineHeight)
                    line-height: {{ $chapterLineHeight }}%;
                @endif
            }
        </style>
            {!! $chapter->content !!}
        </div>

        <div class="text-center px-2 py-2 alert alert-success d-none d-lg-block" role="alert">Bạn có thể dùng phím mũi tên hoặc WASD để
            lùi/sang chương</div>
    </div>

    <div class="chapter-actions chapter-actions-mobile d-flex align-items-center justify-content-center">
        @if ($chapterBefore)
        <a class="btn btn-success me-2 chapter-prev" href="{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterBefore->slug]) }}" title=""> <span>Chương </span>trước</a>
        @endif
        <button class="btn btn-success chapter_jump me-2"  data-story-id="{{ $story->id }}" data-slug-chapter="{{ $slugChapter }}" data-slug-story="{{ $story->slug }}"><span>
                {{-- <i class="fa-solid fa-bars"></i> --}}
                <svg style="fill: #fff;" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
            </span></button>

        <div class="dropup select-chapter me-2 d-none">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                Chọn chương
            </a>

            <ul class="dropdown-menu select-chapter__list" aria-labelledby="dropdownMenuLink">
                {{-- @foreach ($story->chapters as $chapterItem)
                    <li>
                        <a class="dropdown-item @if($slugChapter == 'chuong-'.$chapterItem->chapter ) bg-info text-light @endif" data-chapter-position="chuong-{{ $chapterItem->chapter }}"
                            href="{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterItem->slug]) }}">Chương
                            {{ $chapterItem->chapter }}</a>
                    </li>
                @endforeach --}}
            </ul>
        </div>
        @if ($chapterAfter)
        <a class="btn btn-success chapter-next" href="{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => $chapterAfter->slug]) }}" title=""><span>Chương </span>tiếp</a>
        @endif
    </div>
@endsection

@push('scripts')
<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Đọc Truyện",
        "item": "{{ route('home') }}"
      },{
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $story->name }}",
        "item": "{{ route('story', $story->slug) }}"
      },{
        "@type": "ListItem",
        "position": 3,
        "name": "{{ $chapter->name }}",
        "item": "{{ route('chapter', ['slugStory' => $story->slug, 'slugChapter' => 'chuong-'.($chapter->chapter)]) }}"
      }]
    }
    </script>
    <script src="{{ asset(mix('assets/frontend/js/chapter.js')) }}"></script>
@endpush