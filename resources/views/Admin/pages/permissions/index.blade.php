@extends('Admin.layouts.main')
@push('content-header')
    @can('reset_cache_permission')
        <div class="col-auto ms-auto">
            <a class="btn btn-icon btn-warning" href="{{ route('admin.permissions.reset') }}">
                <i data-feather='refresh-cw'></i> Reset cache
            </a>
        </div>
    @endcan
@endpush
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row flex-row-reverse">
                <div class="col">
                    {!! \App\Helpers\SearchFormHelper::getForm(route('admin.permissions.index'), 'GET', [
                        [
                            'type' => 'text',
                            'name' => 'search[keyword]',
                            'placeholder' => 'Tìm tên',
                            'defaultValue' => request('search.keyword'),
                        ],
                        [
                            'type' => 'selection',
                            'name' => 'search[role_id]',
                            'defaultValue' => request('search.role_id', null),
                            'options' => ['' => '- Vai trò -'] + $roles->pluck('name', 'id')->toArray(),
                        ],
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Menu</th>
                        <th>Tên</th>
                        <th>Vai trò</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $permission->group }}</td>
                            <td>
                                {{ $permission->name }}
                                <span class="text-warning" data-bs-toggle="popover"
                                    data-bs-content="{{ \Illuminate\Support\Str::headline($permission->name) }}"
                                    data-bs-trigger="hover" data-bs-placement="top">
                                    <i data-feather='info'></i>
                                </span>
                            </td>
                            <td>
                                @foreach ($permission->roles as $_role)
                                    <span class="badge rounded-pill badge-light-primary">{{ $_role->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">{{ $permission->created_at->format('d-m-Y H:i:s') }}</td>
                            <td class="text-center">
                                @can('sua_quyen')
                                    <a class="btn btn-sm btn-icon btn-edit"
                                        href="{{ route('admin.permissions.edit', $permission->id) }}">
                                        <i data-feather="edit" class="font-medium-2 text-body"></i>
                                    </a>
                                @endcan
                                @can('xoa_quyen')
                                    <button class="btn btn-sm btn-icon delete-record" type="button"
                                        data-action="{{ route('admin.permissions.destroy', $permission->id) }}">
                                        <i data-feather="trash-2" class="font-medium-2 text-body"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-center">
                    {{ $permissions->appends(request()->query())->links() }}
                </div>
            </div>
        </div> --}}
    </div>
    @can('xoa_quyen')
        @include('Admin.component.model-delete')
    @endcan
@endsection
