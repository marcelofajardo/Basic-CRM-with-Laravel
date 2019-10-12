@extends('layouts.app')

@section('content')
<div class="container">
    @if(session()->get('success'))
        <div class="row justify-content-center">
            <div class="col-md-8 mb-2">
                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if(session()->get('error'))
        <div class="row justify-content-center">
            <div class="col-md-8 mb-2">
                <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                    {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('messages.Companies') }}</div>
                <div class="card-body">
                    {{ __('messages.nof_companies', ['nof' => $nofCompanies]) }}
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('companies') }}">{{ __('messages.show_all') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('messages.Employees') }}</div>
                <div class="card-body">
                    {{ __('messages.nof_employees', ['nof' => $nofEmployees]) }}
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('employees') }}">{{ __('messages.show_all') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
