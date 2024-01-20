<div class="section-stories-hot mb-3">
    <div class="container">
        <div class="row">
            @include('Frontend.snippets.head_title_global', [
                'title' => 'Truyện Hot',
                'showIcon' => true,
                'showSelect' => true,
                'selectOptions' => $categories,
                'classSelect' => 'select-stories-hot',
                'categoryIdSelected' => $categoryIdSelected,
            ])
        </div>

        <div class="row">
            <div class="col-12">
                <div class="section-stories-hot__list">
                    @foreach ($storiesHot as $story)
                        @include('Frontend.snippets.story_item', ['story' => $story])
                    @endforeach
                </div>

                <div class="section-stories-hot__list wrapper-skeleton d-none">
                    @for ($i = 0; $i < $storiesHot->count(); $i++)
                        <div class="skeleton" style="max-width: 150px; width: 100%; height: 230px;"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>