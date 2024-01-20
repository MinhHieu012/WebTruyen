@extends('Admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-body">
            <form id="edit-user" class="form-validate" method="post" autocomplete="off"
                  action="{{route('admin.reset.update')}}"
                  enctype="multipart/form-data">
                @csrf
                 <div class="row mb-1">
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="basic-icon-default-name">Họ và tên</label>
                        <input type="text" id="basic-icon-default-name"
                               class="form-control"
                               name="name"
                               value="{{ $default_values['name'] }}" required/>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" id="email"
                               class="form-control"
                               name="email"
                               value="{{ $default_values['email'] }}"/>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="username">Tài khoản</label>
                        <input type="text" id="username"
                               class="form-control"
                               name="username"
                               value="{{ $default_values['username'] }}" autocomplete="off"
                        />
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="password">Mật khẩu mới</label>
                        <input type="password"
                               id="password"
                               class="form-control"
                               name="password"
                               value=""/>
                    </div>
                    <div class="col-12 col-sm-6"></div>
                    <div class="col-12 col-sm-6">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="reset-password-confirm">Nhập lại mật khẩu mới</label>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" class="form-control form-control-merge"
                                   id="reset-password-confirm"
                                   aria-describedby="reset-password-confirm"
                                   name="password_confirmation" tabindex="2"/>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="basic-icon-default-phone">Điện thoại</label>
                        <input type="text" id="basic-icon-default-phone"
                               class="form-control"
                               name="phone"
                               value="{{ $default_values['phone'] }}"/>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label" for="basic-icon-default-position">Chức vụ</label>
                        <input type="text" id="basic-icon-default-position"
                               class="form-control"
                               name="position"
                               value="{{ $default_values['position'] }}"/>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success me-1">
                      Cập nhật
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-1">
                        <i data-feather='rotate-ccw'></i>
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

