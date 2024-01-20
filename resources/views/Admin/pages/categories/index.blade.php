@extends('Admin.layouts.main')
@push('content-header')
    @can('them_category')
        <div class="col ms-auto">
            @include('Admin.component.btn-add', [
                'title' => 'Thêm',
                'href' => route('admin.category.create'),
            ])
        </div>
    @endcan
@endpush
@section('content')
    <section class="app-user-list">
        <div class="row" id="table-striped">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success p-1">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <div class="row flex-row-reverse">
                            <div class="col">
                                {!! \App\Helpers\SearchFormHelper::getForm(route('admin.category.index'), 'GET', [
                                    [
                                        'type' => 'text',
                                        'name' => 'search[keyword]',
                                        'placeholder' => 'Tìm danh mục',
                                        'defaultValue' => request('search.keyword'),
                                    ],
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableProducts" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>Số truyện</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ $category->name }}
                                        </td>
                                        <td>
                                            {!! Str::limit($category->desc, 50)  !!}
                                        </td>
                                        <td>{{ $category->stories()->count() }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @can('sua_category')
                                                    <a class="btn btn-sm btn-icon"
                                                        href="{{ route('admin.category.edit', $category->id) }}">
                                                        <i data-feather="edit" class="font-medium-2 text-body"></i>
                                                    </a>
                                                @endcan
                                                @can('xoa_category')
                                                    <form method="post"
                                                        action="{{ route('admin.category.destroy', $category->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm">
                                                            <i data-feather="trash" class="font-medium-2 text-body"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1 d-flex justify-content-center">
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
