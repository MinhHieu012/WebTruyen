@extends('Frontend.layouts.default')

@push('custom_schema')
{{-- {!! SEOMeta::generate() !!} --}}
{{-- {!! JsonLd::generate() !!} --}}
{!! SEO::generate() !!}
@endpush

@section('content')
    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9 mb-3">
                <div class="head-title-global d-flex justify-content-between mb-2">
                    <div class="col-12 col-md-12 col-lg-12 head-title-global__left d-flex">
                        <h2 class="me-2 mb-0 border-bottom border-secondary pb-1">
                            <span href="#" class="d-block text-decoration-none text-dark fs-4 category-name" title="{{ $category->name }}">{{ $category->name }}</span>
                        </h2>
                    </div>
                </div>

                <div class="list-story-in-category section-stories-hot__list">
                    @foreach ($stories as $story)
                        @include('Frontend.snippets.story_item', ['story' => $story])
                    @endforeach
                    {{-- @foreach ($stories as $story)
                        @include('Frontend.snippets.story_item_list', ['story' => $story])
                    @endforeach --}}
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="category-description bg-light p-2 rounded mb-3 card-custom">
                    <p class="mb-0 text-secondary">{!! $category->desc !!}</p>
                </div>
                @include('Frontend.sections.main.list_category')
            </div>
        </div>
    </div>
@endsection
