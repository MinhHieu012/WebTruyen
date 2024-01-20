@extends('Admin.layouts.main')
@push('content-header')
    @can('them_nguoi_dung')
        <div class="col ms-auto">
            @include('Admin.component.btn-add', ['title'=>'Thêm', 'href'=>route('admin.users.create')])
        </div>
    @endcan
@endpush
@section('content')
    <section class="app-user-list">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ number_format($users->total()) }}</h3>
                            <span>Tổng số người dùng</span>
                        </div>
                        <div class="avatar bg-light-success p-50">
                            <span class="avatar-content">
                              <i data-feather="user" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ number_format($user_inactive) }}</h3>
                            <span>Số người dùng không hoạt động</span>
                        </div>
                        <div class="avatar bg-light-secondary p-50">
                            <span class="avatar-content">
                              <i data-feather="user" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="table-striped">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row flex-row-reverse">
                            <div class="col">
                                {!!
                                    \App\Helpers\SearchFormHelper::getForm(
                                        route('admin.users.index'),
                                        'GET',
                                        [
                                            [
                                                "type" => "text",
                                                "name" => "search[keyword]",
                                                "placeholder" => "Tìm người dùng",
                                                "defaultValue" => request('search.keyword'),
                                            ],
                                            [
                                                "type" => "selection",
                                                "name" => "search[status]",
                                                "defaultValue" => request('search.status'),
                                                "options" => ['' => '- Trạng thái -',] + \App\Models\User::STATUS_TEXT,
                                            ],
                                            [
                                                "type" => "selection",
                                                "name" => "search[role_id]",
                                                "defaultValue" => request('search.role_id'),
                                                "options" => ['' => '- Vai trò -'] + $roles->pluck("name", "id")->toArray(),
                                            ],
                                        ],
                                    )
                                !!}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tableProducts" class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>IP đăng nhập<br>gần nhất</th>
                                <th>TG đăng nhập<br>gần nhất</th>
                                <th>Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $users as $user )
                                <tr>
                                    <td>
                                        <div class="avatar-wrapper">
                                            @if($user->avatar)
                                                <div class="avatar">
                                                    <img
                                                        src="{{ $user->avatar }}"
                                                        alt="Avatar" width="32" height="32"/>
                                                </div>
                                            @else
                                                <div
                                                    class="avatar bg-light-{{ array_rand(['info'=>'info', 'success'=>'success', 'warning'=>'warning', 'danger'=>'danger']) }}">
                                                    <span class="avatar-content">
                                                        {{ strtoupper(substr( $user->email ?? $user->username, 0, 1 )) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    {{-- <td>
                                        @foreach( $user->domains as $_domain )
                                            <span class="badge rounded-pill badge-light-primary">
                                                {{ $_domain->name }}
                                            </span>
                                        @endforeach
                                    </td> --}}
                                    <td>
                                        @foreach( $user->roles as $_role )
                                            <span
                                                class="badge rounded-pill badge-light-{{ in_array($_role->name, [ \App\Models\User::ROLE_ADMIN ]) ? 'danger' : 'primary' }}">
                                                {{ $_role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill
                                            badge-light-{{ $user->status == \App\Models\User::STATUS_ACTIVE ? 'success' : 'secondary' }}">
                                            {{ \App\Models\User::STATUS_TEXT[$user->status] ?? '' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->last_login_ip }}</td>
                                    <td>{{ $user->last_login_time ? \Carbon\Carbon::create($user->last_login_time)->format('d-m-Y H:i:s') : '' }}</td>
                                    <td>
                                        @can('sua_nguoi_dung')
                                            <a class="btn btn-sm btn-icon"
                                               href="{{ route('admin.users.edit', $user->id) }}">
                                                <i data-feather="edit" class="font-medium-2 text-body"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1 d-flex justify-content-center">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
