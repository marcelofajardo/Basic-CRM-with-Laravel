@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if(session()->get('success'))
                <div class="col-md-12 mb-2">
                    <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Companies') }}</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-auto">{{ __('Logo') }}</th>
                                    <th class="w-auto">{{ __('Company') }}</th>
                                    <th class="w-auto">{{ __('Website') }}</th>
                                    <th class="w-auto">{{ __('Email') }}</th>
                                    <th class="text-center" colspan="2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($companies as $company)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $company->logo) }}" style="width: 60px; height: 60px;">
                                        </td>
                                        <td style="vertical-align: middle">{{ $company->name }}</td>
                                        <td style="vertical-align: middle">{{ $company->website }}</td>
                                        <td style="vertical-align: middle">{{ $company->email }}</td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <a href="{{ route('company.edit', $company->id) }}">
                                                <button class="btn btn-sm btn-warning text-nowrap"><i class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                            </a>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <form action="{{ route('company.destroy', $company->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger text-nowrap" type="submit"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        <div class="float-left">{{ $companies->links() }}</div>
                        <div class="float-right" style="line-height: 2rem">{{ __('Total Records') }}: {{ $companies->total() }}</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
