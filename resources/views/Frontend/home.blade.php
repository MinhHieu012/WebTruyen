@extends('Frontend.layouts.default')


@push('custom_schema')
{{-- {!! SEOMeta::generate() !!} --}}
{{-- {!! JsonLd::generate() !!} --}}
{!! SEO::generate() !!}
@endpush

@section('content')
    @include('Frontend.sections.main.stories_hot', ['categoryIdSelected' => 0])

    <div class="container">
        <div class="row align-items-start">
            <div class="col-12 col-md-8 col-lg-9">
                @include('Frontend.sections.main.stories_new')
            </div>

            <div class="col-12 col-md-4 col-lg-3 sticky-md-top">
                <div class="row">
                    {{-- <div class="col-12 mb-3">
                        @include('Frontend.sections.main.stories_reading')
                    </div> --}}
                    <div class="col-12" style="margin-top: 20px;">
                        @include('Frontend.sections.main.list_category')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Frontend.sections.main.stories_full', ['stories' => $storiesFull])
@endsection
