@extends('layouts.app')

@section('title')
    Branch
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>New Branch</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('branches.index') }}">Branch</a></div>
                <div class="breadcrumb-item active"><a href="#">Create</a></div>
            </div>
        </div>

        <div class="section-body">
            {{ Form::open(['url' => route('branches.store'),'class' => 'need-validation','autocomplete' => 'off']) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name<span class="note">*</span></label>
                                <input name="name" value="{{ old('name') }}" type="text" placeholder="Enter your name"
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Address<span class="note">*</span></label>
                                <input name="address" value="{{ old('address') }}" type="text" placeholder="Enter your address"
                                       class="form-control @error('address') is-invalid @enderror" required>
                                @error('address')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" cols="30" placeholder="Enter description" class="form-control" rows="3">{{ old('description') }}</textarea>
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
                            <a href="{{ route('branches.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Back</a>
                        </div>

                    </div>

                </div>

            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection
