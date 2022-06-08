<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends BackendController
{
    public $notDeleteArray = [1, 2, 3, 4];

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle']      = 'Roles';
        $this->data['notDeleteArray'] = $this->notDeleteArray;

        $this->middleware(['permission:role'])->only('index');
        $this->middleware(['permission:role_create'])->only('create', 'store');
        $this->middleware(['permission:role_edit'])->only('edit', 'update');
        $this->middleware(['permission:role_delete'])->only('destroy');
        $this->middleware(['permission:role_show'])->only('show', 'savePermission');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['roles'] = Role::all();
        return view('admin.role.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role       = new Role;
        $role->name = strip_tags($request->name);
        $role->save();

        return redirect(route('admin.role.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $listPermissionsArray = [];
        $permissions          = Permission::get();
        if (count($permissions)) {
            foreach ($permissions as $permission) {
                if ((strpos($permission->name, '_create') == false) && (strpos($permission->name, '_edit') == false) && (strpos($permission->name, '_show') == false) && (strpos($permission->name, '_delete') == false)) {
                    $listPermissionsArray[$permission->id] = $permission;
                }
                $permissionArray[$permission->name] = $permission->id;
            }
        }

        $this->data['role']            = $role;
        $this->data['permissions']     = $role->permissions->pluck('id', 'id');
        $this->data['permissionArray'] = $permissionArray;
        $this->data['permissionList']  = $listPermissionsArray;
        return view('admin.role.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['role'] = Role::findOrFail($id);
        return view('admin.role.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role       = Role::findOrFail($id);
        $role->name = strip_tags($request->name);
        $role->save();
        return redirect(route('admin.role.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (in_array($id, $this->notDeleteArray)) {
            return redirect(route('admin.role.index'))->withError('The Data Not Deleted Successfully');
        } else {
            Role::findOrFail($id)->delete();
            return redirect(route('admin.role.index'))->withSuccess('The Data Deleted Successfully');
        }
    }

    public function savePermission(Request $request, $id)
    {
        if ($_POST) {
            $permissions = $request->all();
            unset($permissions['_token']);
            $permissions = array_values($permissions);

            $role       = Role::find($id);
            $permission = Permission::whereIn('id', $permissions)->get();
            $role->syncPermissions($permission);

            return redirect(route('admin.role.show', $role))->withSuccess('The Permission Updated Successfully');
        }
        return redirect(route('admin.role.index'));
    }
}
