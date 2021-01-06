<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Http\Resources\BranchDatatableResource;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        onlyAllowReadPermission('branch');
		return view('branch.index'); 
    }

    public function getData(Request $request) {

		$branchs = Branch::notDelete()->exceptRoot();

        $perPage = $request->length > 0 ? $request->length : 100000;
        $branchs = $branchs->paginate($perPage,'*','page',($request->start / $perPage) + 1);
        $count = $branchs->total();

		$branchs = BranchDatatableResource::collection($branchs);

        return Datatables::of($branchs)
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
        allowOnlyWritePermission('branch');
        return view('branch.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = [
            'name' => 'required',
            'address' => 'required',
        ];
        $this->validate($request, $validate);
        $data = $request->all();
        $data['active'] = $request->active ? $request->active : 0;
		Branch::create($data);
		toast('success', 'Branch has been created.');
		return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        allowOnlyWritePermission('branch');
        $branch = Branch::findOrFail($id);
        return view('branch.edit')->with([
            'branch'=> $branch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail(base64_decode($id));

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);
        $data['active'] = $request->active ? $request->active : 0;
		$branch->update($data);
        toast('success', 'Branch has been updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        allowOnlyDeletePermission('branch');
		$branch = Branch::findOrFail(base64_decode($id));

		$branch->update(['delete' => 1 ]);
		toast('success', 'Branch has been deleted.');

		return redirect()->back();
    }
}
