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
            @if(session()->get('error'))
                <div class="col-md-12 mb-2">
                    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Employees') }}</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-auto">{{ __('First Name') }}</th>
                                    <th class="w-auto">{{ __('Last Name') }}</th>
                                    <th class="w-auto">{{ __('Email') }}</th>
                                    <th class="w-auto">{{ __('Phone') }}</th>
                                    <th class="w-auto">{{ __('Company') }}</th>
                                    <th class="text-center" colspan="2">{{ __('Actions') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($employees as $k => $employee)
                                    <tr>
                                        <td style="vertical-align: middle">{{ $employee->first_name }}</td>
                                        <td style="vertical-align: middle">{{ $employee->last_name }}</td>
                                        <td style="vertical-align: middle">{{ $employee->email }}</td>
                                        <td style="vertical-align: middle">{{ $employee->phone }}</td>
                                        <td style="vertical-align: middle">{{ $employee->company->name }}</td>
                                        <td class="text-nowrap text-center" style="vertical-align: middle;">
                                            <a href="{{ route('employee.edit', $employee->id) }}">
                                                <button class="btn btn-sm btn-warning text-nowrap"><i class="fas fa-edit"></i> {{ __('Edit') }}</button>
                                            </a>
                                        </td>
                                        <td class="text-nowrap text-center" style="vertical-align: middle;">
                                            <form action="{{ route('employee.destroy', $employee->id)}}" method="post">
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
                        <div class="float-left">{{ $employees->links() }}</div>
                        <div class="float-right" style="line-height: 2rem">{{ __('Total Records') }}: {{ $employees->total() }}</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
