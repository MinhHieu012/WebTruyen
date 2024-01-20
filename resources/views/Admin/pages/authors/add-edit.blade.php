@extends('Admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-body">
            @php
                $author_id = $author_id ?? 0;
                if ($author_id) {
                    $action = route('admin.author.update', $author_id);
                } else {
                    $action = route('admin.author.store');
                }
            @endphp
            <form id="add-edit-author" class="form-validate" method="post" autocomplete="off"
                  action="{{ $action }}"
                  enctype="multipart/form-data">
                @csrf
                @if($author_id)
                    @method('put')
                @endif
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="basic-icon-default-name-{{ $author_id }}">Tên tác giả</label>
                        <input type="text" id="basic-icon-default-name-{{ $author_id }}"
                               class="form-control"
                               name="name"
                               value="{{ $author->name ?? '' }}" required/>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success me-1">
                        {{ $author_id ? 'Cập nhật' : 'Tạo mới' }}
                    </button>
                    <a href="{{ route('admin.author.index') }}" class="btn btn-secondary me-1">
                        <i data-feather='rotate-ccw'></i>
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
