@extends('Admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-edit-user" class="form-validate" method="post" autocomplete="off"
                  action="{{ $formOptions['action'] }}"
                  enctype="multipart/form-data">
                @csrf
                @if($user_id)
                    @method('put')
                @endif
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="basic-icon-default-name-{{ $user_id }}">Họ và tên</label>
                        <input type="text" id="basic-icon-default-name-{{ $user_id }}"
                               class="form-control"
                               name="name"
                               value="{{ $default_values['name'] }}" required/>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="user-email">Email</label>
                        <input type="text" id="user-email"
                               class="form-control"
                               name="email"
                               value="{{ $default_values['email'] }}"/>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="username-{{ $user_id }}">Tài khoản</label>
                        <input type="text" id="username-{{ $user_id }}"
                               class="form-control"
                               name="username"
                               value="{{ $default_values['username'] }}" autocomplete="off"
                        />
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="password-{{ $user_id }}">Mật khẩu</label>
                        <input type="password"
                               id="password-{{ $user_id }}"
                               class="form-control"
                               name="password"
                               value=""/>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label" for="user-role_id">Vai trò</label>
                        <select id="user-role_id" class="form-select" name="role_id" required>
                            <option value="">- Lựa chọn -</option>
                            @foreach( $formOptions['roles'] as $role )
                                <option
                                    value="{{ $role->id }}"
                                    {{ $role->id == $default_values['role_id'] ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="user-status">Trạng thái</label>
                        <select id="user-status" class="form-select" name="status">
                            <option value="">- Lựa chọn -</option>
                            @foreach( $formOptions['status'] as $v => $n )
                                <option
                                    value="{{ $v }}" {{ $v === $default_values['status'] ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success me-1">
                        {{ $user_id ? 'Cập nhật' : 'Tạo mới' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-1">
                        <i data-feather='rotate-ccw'></i>
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
