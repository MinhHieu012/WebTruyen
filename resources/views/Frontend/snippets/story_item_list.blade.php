<div class="story-item-list d-flex align-items-center position-relative mb-2">
    <a href="{{ route('story', ['slug' => $story->slug]) }}" class="d-block story-item-list__image mb-1 me-3">
        <img src="{{ asset($story->image) }}" alt="{{ $story->name }}" class="img-fluid w-100" width="100" height="150" loading='lazy'>
    </a>

    <div class="story-info d-flex justify-content-between align-items-start flex-wrap">
        <div class="d-flex flex-column">
            <div class="d-flex align-items-center mb-2 flex-wrap">
                <h3 class="fs-6 story-item-list__name fw-bold text-center mb-0 me-3 d-flex align-items-center">
                    <i class="fa-solid fa-book me-1" style="color: #999999;"></i>
                    <a href="{{ route('story', ['slug' => $story->slug]) }}" class="d-block text-decoration-none text-dark mb-0 story-name">
                        {{ $story->name }}
                    </a>
                </h3>
                @if ($story->is_full)
                <span class="badge rounded-pill text-bg-success me-1">Full</span>
                @endif
                <span class="badge rounded-pill text-bg-danger">hot</span>
            </div>
            <span class="text-secondary">
                <i class="fa-solid fa-pencil" style="color: #8891a0;"></i>
                <a href="#" class="hover-title text-decoration-none text-dark author-name">{{ $story->author->name }}</a>    
            </span>
        </div>
        <a href="{{ url($story->slug .'/'.$story->chapter_last->slug) }}" class="story-item-list__chapter text-decoration-none text-info hover-title">Chương {{ $story->chapter_last->chapter }}</a>
    </div>
</div>