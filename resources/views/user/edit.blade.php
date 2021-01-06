@extends('layouts.app')

@section('title')
    User
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></div>
                <div class="breadcrumb-item active"><a>Edit</a></div>
            </div>
        </div>

        <div class="section-body">
            {{ Form::open(['url' => route('users.update',base64_encode($user->id)),'class' => 'need-validation','autocomplete' => 'off','method' => 'put']) }}
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            @if(isSuperAdmin() == 1)
                                <div class="form-group">
                                    <label>Branch<span class="note">*</span></label>
                                    <select name="branch" class="form-control select2 @error('branch') is-invalid @enderror" >
                                        <option value="">-- Select Branch --</option>
                                        @foreach($branches as $branch)
                                            <option {{ $user->branch_id == $branch->id ? 'selected' : '' }} value="{{ base64_encode($branch->id) }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Name<span class="note">*</span></label>
                                <input name="name" value="{{ $user->name }}" type="text"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Username<span class="note">*</span></label>
                                <input name="username" value="{{ $user->username }}" type="text"
                                       class="form-control @error('username') is-invalid @enderror" required>
                                @error('username')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" value="{{ $user->email }}" type="email"
                                       class="form-control">
                            </div>

                            <h6 class="text-danger mb-3">Reset Password</h6>
                            <div class="form-group">
                                <label>New Password</label>
                                <input name="password" value="{{ old('password') }}" type="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Retype Password</label>
                                <input name="retype_password" value="{{ old('retype_password') }}" type="password"
                                       class="form-control @error('retype_password') is-invalid @enderror">
                                @error('retype_password')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="control-label">Status(Inactive/Active)</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="active" value="1" class="custom-switch-input" {{ $user->active ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Active</span>
                                </label>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-pen"></i> Update</button>
                            <a href="{{ route('users.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>

                    </div>

                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>User Role<span class="note">*</span></label>
                                @foreach($roles as $i => $role)
                                    <div class="form-check">
                                        <input class="form-check-input" {{ $role->id == $user->role_id ? 'checked' : '' }} type="radio" name="role_id" value="{{ $role->id }}"
                                               id="role-{{ $i }}">
                                        <label class="form-check-label" for="role-{{ $i }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach

                                @error('role')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection
