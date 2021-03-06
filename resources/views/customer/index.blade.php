
@extends('layouts.app')
@section('content')
    <div id="customer">
        <section class="section">
            <div class="section-header">
                <h1>Customers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Home</a></div>
                    <div class="breadcrumb-item"><a href="#">Customers</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                @authorize('customer', 'write')
                                   <a href="{{ route('customers.create') }}" class="btn btn-warning mr-1">Create</a>
                                @endauthorize
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customer-table" data-route="{{ route('customer.table') }}" class="table table-md w-100 table-md">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Date</th>
                                            <th>Address</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/customer.js') }}"></script>
@endpush