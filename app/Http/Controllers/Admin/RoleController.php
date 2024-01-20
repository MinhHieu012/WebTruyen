<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        protected RoleRepositoryInterface $repository
    )
    {
        $this->middleware('can:xem_danh_sach_vai_tro')->only('index');
//        $this->middleware('can:them_vai_tro')->only('create', 'store');
//        $this->middleware('can:sua_vai_tro')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->repository->lists();

        return view('Admin.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
//    public function create()
//    {
//        $role_id = 0;
//        $role    = null;
//        return view('pages.roles.add-edit', compact('role_id', 'role'));
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'name' => ['required']
//        ]);
//        $role_name = $request->input('name');
//        $this->repository->create(['name' => $role_name, 'guard_name' => 'web']);
//
//        return redirect(route('admin.roles.index'));
//    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $role_id
     */
//    public function edit(int $role_id)
//    {
//        $role = $this->repository->find($role_id);
//        return view('pages.roles.add-edit', compact('role_id', 'role'));
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
//    public function update(Request $request, $role_id)
//    {
//        $request->validate([
//            'name' => ['required']
//        ]);
//
//        $role_name = $request->get('name');
//
//        $this->repository->update($role_id, [
//            'name' => $role_name,
//        ]);
//        return redirect(route('admin.roles.index'));
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
//    public function destroy($id)
//    {
//        //
//    }
}
