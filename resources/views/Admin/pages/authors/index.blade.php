@extends('Admin.layouts.main')
@push('content-header')
    @can('them_author')
        <div class="col ms-auto">
            @include('Admin.component.btn-add', [
                'title' => 'Thêm',
                'href' => route('admin.author.create'),
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
                        <div class="row flex-row-reverse">
                            <div class="col">
                                {!! \App\Helpers\SearchFormHelper::getForm(route('admin.author.index'), 'GET', [
                                    [
                                        'type' => 'text',
                                        'name' => 'search[keyword]',
                                        'placeholder' => 'Tìm tác giả',
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
                                    <th>Số truyện</th>
                                    <th>Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($authors as $author)
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ $author->name }}
                                        </td>
                                        <td>
                                            {{ $author->stories()->count() }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @can('sua_author')
                                                    <a class="btn btn-sm btn-icon"
                                                        href="{{ route('admin.author.edit', $author->id) }}">
                                                        <i data-feather="edit" class="font-medium-2 text-body"></i>
                                                    </a>
                                                @endcan
                                                @can('xoa_author')
                                                    <form method="post"
                                                        action="{{ route('admin.author.destroy', $author->id) }}">
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
                            {{ $authors->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
