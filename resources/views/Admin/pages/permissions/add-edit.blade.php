@extends('Admin.layouts.main')
@section('page_title', 'Sửa quyền')
@section('content')
    <div class="row">
        <!-- Add role form -->
        <form id="addPermissionForm" class="row" method="post"
              action="{{ route('admin.permissions.update', $permission->id) }}">
            @csrf
            @method('PUT')
            <div class="col-12">
                <label class="form-label" for="modalPermissionKey">Name</label>
                <input
                    type="text"
                    id="modalPermissionKey"
                    class="form-control"
                    value="{{ $permission->name }}"
                    readonly
                />
            </div>
            <div class="col-12">
                <label class="form-label" for="modalPermissionGroup">Menu</label>
                <input
                    type="text"
                    id="modalPermissionGroup"
                    name="group"
                    class="form-control"
                    placeholder="Permission Menu"
                    autofocus
                    value="{{ old('group') ?: $permission->group }}"
                />
            </div>
            <div class="col-12 mt-75">
                <label class="form-label">Roles</label>
                @foreach( $roles as $role )
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox"
                               id="inlineCheckbox{{ $role->id }}"
                               name="roles[]"
                               value="{{ $role->id }}"
                            {{ in_array( $role->id, $permission_roles ) ? 'checked' : '' }}
                        />
                        <label class="form-check-label"
                               for="inlineCheckbox{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success mt-2 me-1">Cập nhật</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary mt-2 me-1">
                    <i data-feather='rotate-ccw'></i>
                    Quay lại
                </a>
            </div>
        </form>
    </div>
@endsection
