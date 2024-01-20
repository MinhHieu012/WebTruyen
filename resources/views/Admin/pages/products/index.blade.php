@php
    use \App\Models\Product;
@endphp
@extends('Admin.layouts.main')
@push('content-header')
    <div class="col-auto ms-auto d-flex">
        <div>
            @include('Admin.component.btn-add', ['title' => 'Thêm Nhóm/SP UT', 'href' => route('admin.product-group-priorities.create')])
        </div>
        @can('them_san_pham')
            <div class="ms-1">
                @include('Admin.component.btn-add', ['title' => 'Thêm SP', 'href' => route('admin.products.create')])
            </div>
        @endcan
    </div>
@endpush
@section('content')
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            @php
                                $companies = isset($companies) ? [0 => '--Công ty--'] + $companies : [0 => '--Công ty--'];
                            @endphp
                            {!!
                            \App\Helpers\SearchFormHelper::getForm(
                                route('admin.products.index'),
                                'GET',
                                [
                                    [
                                        "type" => "text",
                                        "id" => "searchInput",
                                        "name" => "search[nameOrCode]",
                                        "defaultValue" => request('search.nameOrCode'),
                                        "placeholder" => 'Tên/Mã sản phẩm',
                                    ],
                                    [
                                        "type" => "selection",
                                        "name" => "search[company_id]",
                                        "defaultValue" => request('search.company_id'),
                                        "options" => $companies,
                                    ],
                                    [
                                        "type" => "selection",
                                        "name" => "search[status]",
                                        "defaultValue" => request('search.status'),
                                        "options" => Product::STATUS_TEXTS,
                                    ],
                                ]
                            )
                        !!}
                        </div>
                    </div>

                    @include('Admin.snippets.messages')
                </div>

                {!! $table->getTable() !!}

            </div>
        </div>
    </div>
@endsection
