@extends('Admin.layouts/fullLayoutMaster')

@section('page_title', 'Đổi mật khẩu')

@push('css-page-vendor')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/base/pages/authentication.css') }}">
@endpush

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Reset Password basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="javascript:void(0);" class="brand-logo">
                        {{-- <img src="{{ asset('assets/admin/images/logo/logo-2023.png') }}" alt="{{ config('app.company') }}"/> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50"
                            viewBox="0 0 50 50" style="fill: #fff;">
                            <path
                                d="M 11.984375 4 A 1.0001 1.0001 0 0 0 11.292969 4.2929688 L 3.2929688 12.292969 A 1.0001 1.0001 0 0 0 3 13 L 3 36 A 1.0001 1.0001 0 0 0 3.2929688 36.707031 L 13.292969 46.707031 A 1.0001 1.0001 0 0 0 15 46 L 15 25.414062 L 24.292969 34.707031 A 1.0001 1.0001 0 0 0 25.707031 34.707031 L 35 25.414062 L 35 46 A 1.0001 1.0001 0 0 0 36.707031 46.707031 L 46.707031 36.707031 A 1.0001 1.0001 0 0 0 47 36 L 47 13 A 1.0001 1.0001 0 0 0 46.707031 12.292969 L 38.707031 4.2929688 A 1.0001 1.0001 0 0 0 37.292969 4.2929688 L 25 16.585938 L 12.707031 4.2929688 A 1.0001 1.0001 0 0 0 11.984375 4 z M 12 6.4140625 L 24 18.414062 L 24 31.585938 L 5.4140625 13 L 12 6.4140625 z M 38 6.4140625 L 44.585938 13 L 26 31.585938 L 26 18.414062 L 38 6.4140625 z M 5 15.414062 L 13 23.414062 L 13 43.585938 L 5 35.585938 L 5 15.414062 z M 45 15.414062 L 45 35.585938 L 37 43.585938 L 37 23.414062 L 45 15.414062 z">
                            </path>
                        </svg>
                    </a>

                    <h4 class="card-title mb-1">Đổi mật khẩu 🔒</h4>
                    <p class="mb-0 fst-italic">Yêu cầu đặt mật khẩu:</p>
                    <ul class="fst-italic">
                        <li>Tối thiểu 8 ký tự</li>
                        <li>Bao gồm chữ hoa, chữ thường và số</li>
                    </ul>

                    <form class="auth-reset-password-form mt-2" method="POST"
                        action="{{ route('admin.password.reset.update') }}">
                        @csrf

                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="reset-password-new">Mật khẩu mới</label>
                            </div>
                            <div
                                class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                                <input type="password"
                                    class="form-control form-control-merge @error('password') is-invalid @enderror"
                                    id="reset-password-new" name="password" aria-describedby="reset-password-new"
                                    tabindex="1" autofocus required />
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="reset-password-confirm">Nhập lại mật khẩu mới</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="reset-password-confirm"
                                    name="password_confirmation" autocomplete="new-password"
                                    aria-describedby="reset-password-confirm" tabindex="2" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="3">Cập nhật</button>
                    </form>
                </div>
            </div>
            <!-- /Reset Password basic -->
        </div>
    </div>
@endsection
