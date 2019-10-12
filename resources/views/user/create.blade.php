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
                    <div class="card-header">{{ __('Create User') }}</div>
                    <form action="{{ route('user.store') }}" method="post">
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                       placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Email') }}</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                       placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                       placeholder="{{ __('Password') }}" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label>{{ __('Role') }}</label>
                                <select class="form-control" name="role">
                                    <option value="User">User</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Administrator">Administrator</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Companies to manage') }}</label>
                                <select name="companies[]" class="form-control" multiple style="height: 250px">
                                    @foreach($companies as $k => $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
