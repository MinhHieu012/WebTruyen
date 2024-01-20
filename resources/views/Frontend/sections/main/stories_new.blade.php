<div class="section-stories-new mb-3">
    <div class="row" style="margin-top: 20px;">
        @include('Frontend.snippets.head_title_global', [
            'title' => 'Truyện mới cập nhật',
            'showIcon' => false,
            'showSelect' => false,
            'selectOptions' => []
        ])
    </div>

    <div class="row">
        <div class="col-12">
            <div class="section-stories-new__list">
                @foreach ($storiesNew as $story)
                    @include('Frontend.snippets.story_item_no_image', ['story' => $story])
                @endforeach  
            </div>
        </div>
    </div>
</div>