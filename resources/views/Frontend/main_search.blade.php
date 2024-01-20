@extends('Frontend.layouts.default')

@section('content')
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-12 col-md-12 col-lg-12 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span href="#" class="d-block text-decoration-none text-dark fs-4 category-name" title="Tìm truyện vời từ khóa {{ $keyWord }}">Tìm truyện vời từ khóa {{ $keyWord }}</span>
                        </h2>
                    </div>
                </div>

                <div class="list-story-in-category">
                    @foreach ($stories as $story)
                        @include('Frontend.snippets.story_item_list', ['story' => $story])
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-5 col-lg-4 sticky-md-top">
                <div class="category-description bg-light p-2 rounded mb-3 card-custom">
                    <p class="mb-0 text-secondary">Danh sách truyện có liên quan tới từ khoá '{{ $keyWord }}'</p>
                </div>
                @include('Frontend.sections.main.list_category')
            </div>
        </div>
    </div>
@endsection
