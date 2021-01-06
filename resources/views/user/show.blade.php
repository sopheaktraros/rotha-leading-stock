@extends('layouts.app')
@section('content')
        <section class="section">
            <div class="section-header">
                <h1>Change Password</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="/">Home</a></div>
                    <div class="breadcrumb-item active"><a href="#">Change Password</a></div>
                </div>
            </div>

            <div class="section-body">
                {{ Form::open(['url' => route('user.update-password',base64_encode($user->id)), 'class' => 'need-validation' ,'autocomplete' => 'off', 'method' => 'post']) }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input name="password" type="password" required class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input name="confirm_password" type="password" required class="form-control @error('confirm_password') is-invalid @enderror">
                                    @error('confirm_password')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-warning"><i class="far fa-save"></i> Save & Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </section>
@endsection




