@extends('layouts.app')
@section('content')
    <div id="user">
        <section class="section">
            <div class="section-header">
                <h1>Users</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Home</a></div>
                    <div class="breadcrumb-item"><a href="#">User</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                @authorize('general', 'write')
                                <a href="{{ route('users.create') }}" class="btn btn-warning mr-1">Create</a>
                                @endauthorize
{{--                                <a href="#" data-toggle="quick-sidebar" data-target="#user-filter"--}}
{{--                                   class="btn btn-light">--}}
{{--                                    <i class="fa fa-filter"></i>Filter--}}
{{--                                </a>--}}
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="user-table" data-route="{{ route('user.table') }}" class="table table-md w-100 table-md">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Role</th>
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

@section('quick-sidebar')
    <div id="user-filter" class="quick-sidebar">
        <div class="container">
            <div class="header">
                <div class="title">{{ __('Filters') }}</div>
                <a href="#" data-toggle="close-quick-sidebar"><i class="fas fa-times"></i></a>
            </div>
            <form autocomplete="off">
                <div class="body">


                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control name" id="name" name="name"
                               placeholder="Name" value="{{ request('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="">Status</label>
                        {{
                            Form::select('active', [1 => 'Active', 0 => 'Inactive'], request()->active, [
                                'id' => 'status',
                                'class' => 'form-control active select2',
                                'placeholder' => '-- Select Status --'
                            ])
                        }}
                    </div>

                    <div class="form-group text-right">
                        <a href="#" data-toggle="close-quick-sidebar" class="btn btn-light"><i
                                class="fas fa-sign-out-alt"></i> {{ __('Close') }}</a>
                        <button class="btn btn-warning"><i class="fas fa-filter"></i> {{ __('Filter') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/user.js') }}"></script>
@endpush
