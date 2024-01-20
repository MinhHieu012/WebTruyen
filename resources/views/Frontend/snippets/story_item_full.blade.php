<div class="story-item-full text-center">
    <a href="{{ route('story', ['slug' => $story->slug]) }}" class="d-block story-item-full__image">
        <img src="{{ asset($story->image) }}" alt="{{ $story->name }}" class="img-fluid w-100" width="150" height="230" loading='lazy'>
    </a>
    <h3 class="fs-6 story-item-full__name fw-bold text-center mb-0">
        <a href="{{ route('story', ['slug' => $story->slug]) }}" class="text-decoration-none text-one-row story-name">
            {{ $story->name }}
        </a>
    </h3>
    <span class="story-item-full__badge badge text-bg-success">Full - {{ $story->chapter_last ? $story->chapter_last->chapter : 0 }} chương</span>
</div>
