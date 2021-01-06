<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleDatatableResource;
use App\Models\Role;
use App\Models\UserPermission;
use App\Models\UserPermissionRole;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; 

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        onlyAllowReadPermission('role');
        return view('role.index');
    }

    public function getData(Request $request) {

        $roles = Role::notDelete()->exceptRoot();

        $perPage = $request->length > 0 ? $request->length : 100000;
        $roles = $roles->paginate($perPage,'*','page',($request->start / $perPage) + 1);
        $count = $roles->total();

        $roles = RoleDatatableResource::collection($roles);

        return Datatables::of($roles)
            ->setTotalRecords($count)
            ->setFilteredRecords($count)
            ->skipPaging()
            ->addIndexColumn()
            ->rawColumns(['status','action'])
            ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        allowOnlyWritePermission('role');
    	$userPermissions = UserPermission::parent()->with('children')->get();

        return view('role.create')->with([
	        'userPermissions' => $userPermissions
        ]);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Validation\ValidationException
	 */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $role = Role::create($request->all());

	    $permissionReads = (array) $request->permission_read;
	    $permissionWrites = (array) $request->permission_write;
	    $permissionDeletes = (array) $request->permission_delete;

	    if ($request->permission_id) {
	        foreach ($request->permission_id as $permissionId) {
		        $canRead = in_array($permissionId, $permissionReads);
		        $canWrite = in_array($permissionId, $permissionWrites);
		        $canDelete = in_array($permissionId, $permissionDeletes);

		        UserPermissionRole::create([
			        'permission_id' => $permissionId,
			        'role_id' => $role->id,
			        'read' => $canRead,
			        'write' => $canWrite,
			        'delete' => $canDelete,
		        ]);
	        }
        }

        toast('success', 'Role has been created');

	    return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        allowOnlyWritePermission('role');
    	$role = Role::with('permission', 'permission.children')->findOrFail($id);
	    $userPermissions = UserPermission::parent()->with('children')->get();

        return view('role.edit')->with([
            'role' => $role,
            'userPermissions' => $userPermissions
        ]);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Validation\ValidationException
	 */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail(base64_decode($id));

        $this->validate($request, [
            'name' => 'required'
        ]);

	    $role->update($request->all());

        UserPermissionRole::where('role_id' , $role->id)->delete();

	    $permissionReads = (array) $request->permission_read;
	    $permissionWrites = (array) $request->permission_write;
	    $permissionDeletes = (array) $request->permission_delete;

	    foreach ($request->permission_id as $i => $permissionId) {
		    $canRead = in_array($permissionId, $permissionReads);
		    $canWrite = in_array($permissionId, $permissionWrites);
		    $canDelete = in_array($permissionId, $permissionDeletes);

            UserPermissionRole::create([
                'permission_id' => $permissionId,
	            'role_id' => $role->id,
	            'read' => $canRead,
	            'write' => $canWrite,
	            'delete' => $canDelete,
            ]);
        }

        toast('success', 'Role has been updated');

        return redirect()->back();
    }

	/**
	 * Remove a role
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
	    allowOnlyDeletePermission('role');
		$role = Role::findOrFail(base64_decode($id));

		$role->update(['delete' => 1 ]);
		toast('success', 'Role has been deleted.');

		return redirect()->back();
	}
}
