@extends('Admin.layouts.main')
@section('page_title', '1.2 Vai trò')
@section('content')
    <div class="row">
        @foreach( $roles as $role )
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Tổng số: <b>{{ $role->users_count }}</b> người dùng</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{ $role->name }}</h4>
                                @can('sua_vai_tro')
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="role-edit-modal">
                                        <small class="fw-bolder">Edit Role</small>
                                    </a>
                                @endcan
                            </div>
                            <a href="{{ route('admin.users.index', ['search'=>['role_id'=>$role->id]]) }}"
                               target="_blank" class="text-body">
                                <i data-feather='external-link'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @can('them_vai_tro')
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end justify-content-center h-100">
                                <img
                                    src="{{asset('images/illustration/faq-illustrations.svg')}}"
                                    class="img-fluid mt-2"
                                    alt="Image"
                                    width="85"
                                />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <a
                                    href="{{ route('admin.roles.create') }}"
                                    class="stretched-link text-nowrap add-new-role"
                                >
                                    <span class="btn btn-primary mb-1">Add New Role</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

@endsection
