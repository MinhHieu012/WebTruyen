<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Permission\PermissionRepositoryInterface;
use App\Services\PermissionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionRepositoryInterface $repository,
        protected PermissionService             $service
    )
    {
        $this->middleware('can:xem_danh_sach_quyen')->only('index');
        $this->middleware('can:them_quyen')->only('store');
        $this->middleware('can:sua_quyen')->only('edit', 'update');
        $this->middleware('can:xoa_quyen')->only('destroy');
        $this->middleware('can:reset_cache_permission')->only('resetCache');
    }

    public function index(Request $request)
    {
        $search      = $request->get('search', []);
        $permissions = $this->service->getResult(['roles'], $search);
        $roles       = Role::all();

        return view('Admin.pages.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'perm_name'  => ['required'],
//            'perm_group' => ['required'],
//            'perm_roles' => ['required'],
//        ]);
//        $perm_name  = $request->input('perm_name');
//        $perm_group = $request->input('perm_group');
//        $perm_roles = $request->input('perm_roles');
//        $roles      = Role::query()->whereIn('id', $perm_roles)->get();
//
//        $permission = $this->repository->create([
//            'name'       => Str::snake($perm_name),
//            'name_2'     => $perm_name,
//            'group'      => $perm_group,
//            'guard_name' => 'web'
//        ]);
//        $permission->syncRoles($roles);
//
//        return redirect(route('admin.permissions.index'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(int $id)
    {
        $roles            = Role::query()->get();
        $permission       = Permission::query()->with('roles')->where('id', $id)->first();
        $permission_roles = $permission->roles->pluck('id')->toArray();

        return view('Admin.pages.permissions.add-edit', compact('permission', 'roles', 'permission_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'group' => ['required'],
        ]);

        $attributes = [
            'group' => $request->get('group', ''),
            'roles' => $request->get('roles', []),
        ];
        $this->service->update($id, $attributes);

        return redirect(route('admin.permissions.index'));
    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     */
//    public function destroy($id)
//    {
//        $permission = Permission::query()->where('id', $id)->first();
//        $permission->delete();
//
//        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
//
//        return redirect(route('admin.permissions.index'));
//    }

    public function resetCache()
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back()->with(
            'successMessage', 'Xóa cache thành công.'
        );
    }
}
