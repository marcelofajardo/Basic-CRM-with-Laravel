<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show employees list
     *
     * @return Renderable
     */
    public function index()
    {
        $employees = Employee::with(['company' => function($query){
            $query->select(['id', 'name']);
        }])->paginate(10);

        return view('employee.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show employee create form
     * @return View
     */
    public function create()
    {
        //get companies for create form
        $companies = DB::table('companies')->get();

        //show the view
        return view('employee.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store employee
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, User $user)
    {
        //user companies
        $userCompanies = Auth::user()->companies()->pluck('companies.id');

        if(Auth::user()->hasRole('Manager') && !$userCompanies->contains($request->get('company_id'))) {
            return redirect('employees')
                ->with('error', trans('You do not have permission to create an employee for this company!'));
        }

        //basic validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'email' => 'email'
        ], [
            'first_name.required' => trans('First name is required!'),
            'last_name.required' => trans('Last name is required!'),
            'company_id.required' => trans('You should select a company for the employee'),
            'email.email' => trans('E-mail address is not a valid one!')
        ]);

        //get all data from the request
        $data = $request->all();

        //set update data
        $insertData = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company_id' => $data['company_id']
        );

        //insert
        $create = DB::table('employees')->insert($insertData);

        if($create) {
            //return with success
            return redirect('employees')
                ->with('success', trans('Employee has been successfully created!'));
        } else {
            //return with error
            return redirect('employees')
                ->with('error', trans('Employee could not be created!'));
        }
    }

    /**
     * Show the form for editing the employee
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        //get companies for create form
        $companies = DB::table('companies')->get();

        //get the employee info
        $employee = DB::table('employees')->where('id', $id)->get()->first();

        return view('employee.edit', [
            'employee' => $employee,
            'companies' => $companies
        ]);
    }

    /**
     * Update the specified employee
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        //check if authorized
        $this->authorize('update', Employee::find($id));

        //basic validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email'
        ], [
            'first_name.required' => trans('First name is required!'),
            'last_name.required' => trans('Last name is required!'),
            'email.email' => trans('E-mail address is not a valid one!')
        ]);

        //get all data from the request
        $data = $request->all();

        //set update data
        $updateData = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'company_id' => $data['company_id']
        );

        //update
        $update = DB::table('employees')->where('id', $id)->update($updateData);

        if($update) {
            //return with success
            return redirect('employees')
                ->with('success', trans('Employee has been successfully updated!'));
        } else {
            //return with error
            return redirect('employees')
                ->with('error', trans('Employee could not be updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        //check if authorized
        $this->authorize('delete', Employee::find($id));

        //delete the employee from db
        $delete = DB::table('employees')->where('id', $id)->delete();

        if($delete) {
            //return with success
            return redirect()->route('employees')
                ->with('success', 'Employee deleted successfully!');
        }  else  {
            //return with error
            return redirect()->route('employees')
                ->with('error', 'Employee could not be deleted!');
        }
    }
}
