@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Edit Employee') }}</div>
                    <form action="{{ route('employee.update', $employee->id) }}" method="post">
                        <div class="card-body">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>{{ __('First Name') }}</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="{{ __('First Name') }}" value="{{ $employee->first_name }}" />
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Last Name') }}</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="{{ __('Last Name') }}" value="{{ $employee->last_name }}" />
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Email') }}</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email') }}" value="{{ $employee->email }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Phone') }}</label>
                                <input type="text" class="form-control" name="phone" placeholder="{{ __('Phone') }}" value="{{ $employee->phone }}" />
                            </div>

                            <div class="form-group">
                                <label>{{ __('Company') }}</label>
                                <select name="company_id" class="form-control">
                                    @foreach($companies as $k => $company)
                                        @if ($company->id == $employee->company_id)
                                            <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                        @else
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('employees') }}"><button type="button" class="btn btn-danger"><i class="fas fa-step-backward"></i> {{ __('Cancel') }}</button></a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
