
@extends('layouts.app')

@section('title')
    Role
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Role</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Role</a></div>
                <div class="breadcrumb-item active"><a>Edit</a></div>
            </div>
        </div>

        <div class="section-body">
            {{ Form::open(['url' => route('roles.update',base64_encode($role->id)),'class' => 'need-validation','autocomplete' => 'off','method' => 'put']) }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name<span class="note">*</span></label>
                                <input name="name" value="{{ $role->name }}" type="text"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" cols="30" class="form-control" rows="3">{{ $role->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="control-label">Status(Inactive/Active)</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="active" value="1" class="custom-switch-input" {{ $role->active ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Active</span>
                                </label>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-pen"></i> Update</button>
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
                                @foreach($userPermissions as $i => $permission)
                                    @php
                                        $arrPermissionsChoose = $role->permission->toArray();
                                        $isChecked = array_filter($arrPermissionsChoose, function ($permissionChoose) use($permission) {
                                            return $permissionChoose['id'] == $permission->id ;
                                        });

                                        $isCheckedRead = false;
                                        if($isChecked) {
                                            $isCheckedRead = array_values($isChecked)[0]['pivot']['read'] == 1;
                                        }
                                    @endphp

                                    <tr class="bg-blue">
                                        <th style="width: 300px">
                                            <i class="fa fa-angle-right"
                                               data-id="{{ $permission->id }}"></i>
                                            {{ $permission->label }}
                                        </th>
                                        <td class="text-center">
                                            <input type="hidden" name="permission_id[]" value="{{ $permission->id }}">
                                            @if($permission->read)
                                                <div class="checkbox-custom padding-left-0">
                                                    <label for="check{{ $permission->id }}">
                                                        <input {{ $isCheckedRead ? 'checked' : '' }} id="check{{ $permission->id }}"
                                                               type="checkbox" name="permission_read[]"
                                                               value="{{ $permission->id }}" class="parent"/>
                                                        <span class="position-relative"></span>
                                                    </label>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    @foreach($permission->children as $subPermission)
                                        @php
                                            $isCheckedChild = array_filter($arrPermissionsChoose, function ($permissionChoose) use($subPermission) {
                                                return $permissionChoose['id'] == $subPermission->id;
                                            });

                                            $isCheckedChildRead = false;
                                            if($isCheckedChild) {
                                                $isCheckedChildRead = array_values($isCheckedChild)[0]['pivot']['read'] == 1;
                                            }
                                        @endphp

                                        <tr data-parent="{{ $permission->id }}">
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subPermission->label }}</td>
                                            <td class="text-center">
                                                <input type="hidden" name="permission_id[]"
                                                       value="{{ $subPermission->id }}">
                                                @if($subPermission->read)
                                                    <div class="checkbox-custom padding-left-0">
                                                        <label for="check{{ $subPermission->id }}">
                                                            <input {{ $isCheckedChildRead ? 'checked' : '' }} id="check{{ $subPermission->id }}"
                                                                   type="checkbox" name="permission_read[]"
                                                                   value="{{ $subPermission->id }}"/>
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
