@extends('Admin.layouts.main')
@section('page_title', $role_id ? 'Sửa vai trò' : 'Thêm mới vai trò')
@section('content')
    <div class="row">
        <!-- Add role form -->
        <form id="addRoleForm" class="row"
              method="post"
              action="{{ $role_id ? route('admin.roles.update', $role_id) : route('admin.roles.store') }}">
            @csrf
            @if($role_id)
                @method('PUT')
            @endif

            <div class="col-12">
                <label class="form-label" for="role_name">Role Name</label>
                <input
                    type="text"
                    id="role_name"
                    name="name"
                    class="form-control"
                    placeholder="Enter role name"
                    tabindex="-1"
                    data-msg="Please enter role name"
                    value="{{ $role ? $role->name : old('name') }}"
                    required
                />
            </div>
            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-success me-1">{{ $role_id ? 'Cập nhật' : 'Tạo mới' }}</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-1">
                    <i data-feather='rotate-ccw'></i>
                    Quay lại
                </a>
            </div>
        </form>
        <!--/ Add role form -->
    </div>
@endsection

@push('scripts-custom')
    <script>
        $(window).on('load', function () {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
@endpush
