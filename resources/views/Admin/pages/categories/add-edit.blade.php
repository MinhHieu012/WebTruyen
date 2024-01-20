@extends('Admin.layouts.main')
@section('page_title')
    {{ $item->name ?? 'Thêm danh mục' }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6">
                    <form id="add-edit-category" class="form-validate" method="post" autocomplete="off"
                        action="{{ $action }}" enctype="multipart/form-data">
                        @csrf
                        @if ($item->id)
                            @method('put')
                        @endif
                        <div class="row mb-1">
                            <div class="col-7">
                                <label class="form-label" for="basic-icon-default-name-{{ $item->id }}">Tên tác
                                    giả</label>
                                <input type="text" id="basic-icon-default-name-{{ $item->id }}" class="form-control"
                                    name="name" value="{{ $item->name ?? '' }}" required />
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                {!! FormUi::wysiwyg('desc', 'Mô tả', $errors, $item, []) !!}
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success me-1">
                                {{ $item->id ? 'Cập nhật' : 'Tạo mới' }}
                            </button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary me-1">
                                <i data-feather='rotate-ccw'></i>
                                Quay lại
                            </a>
                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <div class="table-responsive">
                        <table id="tableProducts" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên truyện</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->stories as $story)
                                    <tr>
                                        <td>
                                            {{ $story->name }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
