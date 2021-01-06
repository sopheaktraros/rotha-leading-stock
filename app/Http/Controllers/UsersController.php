<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserDatatableResource;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
    {
        onlyAllowReadPermission('user');
		return view('user.index');
	}

	public function getData(Request $request) {

		$users = User::with('role')->where(function($q){
		    if (isSuperAdmin() != 1) {
		        $q->where('branch_id',Auth::user()->branch_id);
            }
        })->exceptRoot()->notDelete();

        $perPage = $request->length > 0 ? $request->length : 100000;
        $users = $users->paginate($perPage,'*','page',($request->start / $perPage) + 1);
        $count = $users->total();

		$users = UserDatatableResource::collection($users);

        return Datatables::of($users)
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
        allowOnlyWritePermission('user');
		return view('user.create')->with([
			'branches' => Branch::allFromCache(),
			'roles' => Role::notDelete()->exceptRoot()->orderBy('id')->get()
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
        $validate = [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'retype_password' => 'required|same:password|min:6',
            'role_id' => 'required'
        ];

        if (isSuperAdmin() == 1) {
            $validate['branch'] = 'required';
        }

		$this->validate($request, $validate);

		$data = $request->all();

		$data['password'] = bcrypt($request->password);
        $data['active'] = $request->active ? $request->active : 0;

		User::create($data);

		toast('success', 'User has been created.');

		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
	    onlyAllowReadPermission('user');
		return view('user.show')->with([
		    'user' => User::findOrFail(base64_decode($id))
        ]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
	    allowOnlyWritePermission('user');
		$user = User::findOrFail($id);

		return view('user.edit')->with([
            'branches' => Branch::allFromCache(),
			'roles' => Role::notDelete()->exceptRoot()->active()->get(),
			'user' => $user
		]);
	}

    public function updatePassword(Request $request,$id)
    {
        $validate = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password|min:6',
        ];

        $this->validate($request, $validate);

        $user = User::find(base64_decode($id));

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        toast('success', 'Your password has been updated.');

        return redirect()->back();
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
	public function update(Request $request, $id) {
		$user = User::findOrFail(base64_decode($id));

		$validate = [
			'name' => 'required',
			'username' => 'required',
		];

        if (isSuperAdmin() == 1) {
            $validate['branch'] = 'required';
        }

		$data = $request->except('password');
		if ($request->password) {
			$validate['password'] = 'required|min:6';
			$validate['retype_password'] = 'required|same:password|min:6';

			$data = $request->all();
		}

		$this->validate($request, $validate);

		if ($request->password) {
			$data['password'] = bcrypt($request->password);
		}

        $data['active'] = $request->active ? $request->active : 0;

		$user->update($data);

		toast('success', 'User has been updated.');

		return redirect()->back();
	}

	/**
	 * Remove a user or move a user to trash
	 *
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id) {
	    allowOnlyDeletePermission('user');
		$user = User::findOrFail(base64_decode($id));

		$user->update([ 'delete' => 1 ]);
		toast('success', 'User has been deleted');

		return redirect()->back();
	}


	/**
	 * View removed users
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function trash() {
		return view('users.trash')->with([
			'users' => User::with('role')->Trash()->where('id', '!=', 1)->get()
		]);
	}

	/**
	 * Restore users from trash
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restore($id) {
		if ( ! $id) {
			return redirect()->back()->with([
				'message' => 'ID Error',
				'message_type' => 'error'
			]);
		}

		User::findOrFail($id)->update([
			'deleted' => 0
		]);

		return redirect()->back()->with([
			'message' => 'User has been restored'
		]);
	}

	/**
	 * Clear all trash
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function emptyTrash() {
		User::where('deleted', 1)->delete();

		return redirect()->back()->with([
			'message' => 'Trash has been emptied'
		]);
	}

}
