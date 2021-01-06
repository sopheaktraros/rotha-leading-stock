
@extends('layouts.app')

@section('title')
    Role
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>New Role</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Role</a></div>
                <div class="breadcrumb-item active"><a href="#">Create</a></div>
            </div>
        </div>

        <div class="section-body">
            {{ Form::open(['url' => route('roles.store'),'class' => 'need-validation','autocomplete' => 'off']) }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name<span class="note">*</span></label>
                                <input name="name" value="{{ old('name') }}" type="text"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" cols="30" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Status(Inactive/Active)</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="active" value="1" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Active</span>
                                </label>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning"><i class="far fa-save"></i> Create</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-md">
                                <thead>
                                <tr>
                                    <th>Permission</th>
                                    <th class="text-center">Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userPermissions as $permission)

                                    <tr>
                                        <th>
                                            <i class="fas fa-angle-right"
                                               data-id="{{ $permission->id }}"></i>
                                            {{ $permission->label }}
                                        </th>
                                        <td class="text-center">
                                            <input type="hidden" name="permission_id[]" value="{{ $permission->id }}">
                                            @if($permission->read)
                                                <div class="checkbox-custom padding-left-0">
                                                    <label for="check{{ $permission->id }}">
                                                        <input id="check{{ $permission->id }}"
                                                               type="checkbox" name="permission_read[]"
                                                               value="{{ $permission->id }}" class="parent"/>
                                                        <span class="position-relative"></span>
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    @foreach($permission->children as $subPermission)
                                        <tr data-parent="{{ $permission->id }}">
                                            <td>{{ $subPermission->label }}</td>
                                            <td class="text-center">
                                                <input type="hidden" name="permission_id[]" value="{{ $permission->id }}">
                                                @if($permission->read)
                                                    <div class="checkbox-custom padding-left-0">
                                                        <label for="check{{ $permission->id }}">
                                                            <input id="check{{ $permission->id }}"
                                                                   type="checkbox" name="permission_read[]"
                                                                   value="{{ $permission->id }}" class="parent"/>
                                                            <span class="position-relative"></span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection
