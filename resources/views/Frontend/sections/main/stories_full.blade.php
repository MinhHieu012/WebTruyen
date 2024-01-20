<div class="section-stories-full mb-3 mt-3">
    <div class="container">
        <div class="row">
            <div class="head-title-global d-flex justify-content-between mb-2">
                <div class="col-12 col-md-4 head-title-global__left d-flex">
                    <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                        <span class="d-block text-decoration-none text-dark fs-4 title-head-name" title="Truyện đã hoàn thành">Truyện đã hoàn thành</span>
                    </h2>
                    <!-- <i class="fa-solid fa-fire-flame-curved"></i> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="section-stories-full__list">
                    @foreach ($stories as $story)
                        @include('Frontend.snippets.story_item_full', ['story' => $story])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>