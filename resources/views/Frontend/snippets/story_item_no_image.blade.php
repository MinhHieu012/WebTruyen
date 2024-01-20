<div class="story-item-no-image">
    <div class="story-item-no-image__name d-flex align-items-center">
        <h3 class="me-1 mb-0 d-flex align-items-center">
            {{-- <i class="fa-solid fa-angle-right me-1"></i> --}}
            <svg style="width: 10px; margin-right: 5px;" xmlns="http://www.w3.org/2000/svg" height="1em"
                viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
            </svg>
            <a href="{{ route('story', ['slug' => $story->slug]) }}"
                class="text-decoration-none text-dark fs-6 hover-title text-one-row story-name">{{ $story->name }}</a>
        </h3>
        @if ($story->is_new)
            <span class="badge text-bg-info text-light me-1">New</span>
        @endif

        @if ($story->is_full)
            <span class="badge text-bg-success text-light me-1">Full</span>
        @endif

        @if ($story->is_hot)
            <span class="badge text-bg-danger text-light">Hot</span>
        @endif
    </div>

    <div class="story-item-no-image__categories ms-2 d-none d-lg-block">
        <p class="mb-0">
            @foreach ($story->categories as $category)
                <a href="{{ route('category', ['slug' => $category->slug]) }}"
                    class="hover-title text-decoration-none text-dark category-name">{{ $category->name }}@if (!$loop->last)
                        ,
                    @endif </a>
            @endforeach
        </p>
    </div>


    <div class="story-item-no-image__chapters ms-2">
        @if ($story->chapter_last)
            <a href="{{ url($story->slug . '/' . $story->chapter_last->slug) }}"
                class="hover-title text-decoration-none text-info">Chương {{ $story->chapter_last->chapter }}</a>
        @endif
    </div>



    {{-- <div class="story-item-no-image__updated-at ms-2 d-none d-lg-block">
        <p class="text-secondary mb-0">
            @if ($story->updated_at->diffInMinutes(\Carbon\Carbon::now()) > 60)
            {{ $story->updated_at->diffInHours(\Carbon\Carbon::now()) }} giờ trước
            @else
            {{ $story->updated_at->diffInMinutes(\Carbon\Carbon::now()) }} phút trước
            @endif
        </p>
    </div> --}}
</div>
