<div class="story-item">
    <a href="{{ route('story', ['slug' => $story->slug]) }}" class="d-block text-decoration-none">
        <div class="story-item__image">
            <img src="{{ asset($story->image) }}" alt="{{ $story->name }}" class="img-fluid" width="150" height="230"
                loading='lazy'>
        </div>
        <h3 class="story-item__name text-one-row story-name">{{ $story->name }}</h3>

        <div class="list-badge">
            @if ($story->is_full)
                <span class="story-item__badge badge text-bg-success">Full</span>
            @endif

            @if ($story->is_hot)
                <span class="story-item__badge story-item__badge-hot badge text-bg-danger">Hot</span>
            @endif

            @if ($story->is_new)
                <span class="story-item__badge story-item__badge-new badge text-bg-info text-light">New</span>
            @endif

            @if (isset($showChaptersCount) && $showChaptersCount)
                <span class="story-item__badge story-item__badge-count-chapter  badge text-bg-warning">{{ $story->chapters_count }}
                    chương</span>
            @endif
        </div>
    </a>
</div>
