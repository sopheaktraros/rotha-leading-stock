<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\CustomerDatatableResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        onlyAllowReadPermission('customer');
		return view('customer.index'); 
    }

    public function getData(Request $request) {

		$customers = Customer::notDelete();

        $perPage = $request->length > 0 ? $request->length : 100000;
        $customers = $customers->paginate($perPage,'*','page',($request->start / $perPage) + 1);
        $count = $customers->total();

		$customers = CustomerDatatableResource::collection($customers);

        return Datatables::of($customers)
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
        onlyAllowReadPermission('customer');
		return view('customer.create'); 
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
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'address' => 'required',
        ];
        $this->validate($request, $validate);
        $data = $request->all();
        $data['active'] = $request->active ? $request->active : 0;
		Customer::create($data);
		toast('success', 'Customer has been created.');
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
        allowOnlyWritePermission('customer');
        $customer = Customer::findOrFail($id);
        return view('customer.edit')->with([
            'customer'=> $customer
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
        $customer = Customer::findOrFail(base64_decode($id));

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);
        $data['active'] = $request->active ? $request->active : 0;
		$customer->update($data);
        toast('success', 'Customer has been updated');
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
        allowOnlyDeletePermission('customer');
		$customer = Customer::findOrFail(base64_decode($id));

		$customer->update(['delete' => 1 ]);
		toast('success', 'Customer has been deleted.');

		return redirect()->back();
    }
}
