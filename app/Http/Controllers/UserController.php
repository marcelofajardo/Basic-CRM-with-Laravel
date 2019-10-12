<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    /**
     * Show users list
     *
     * @return Renderable
     */
    public function index()
    {
        //get users with companies
        $users = User::with(['companies' => function($query){
            $query->select(['companies.name']);
        }])->paginate(5);

        //return view
        return view('user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show user create form
     * @return View
     */
    public function create()
    {
        //get companies for create form
        $companies = DB::table('companies')->get();

        //show the view
        return view('user.create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store user
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //basic validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ], [
            'name.required' => trans('Name is required!'),
            'email.required' => trans('E-mail address is required!'),
            'email.email' => trans('E-mail address is not a valid one!'),
            'password.required' => trans('Password is required!')
        ]);

        //get all data from the request
        $data = $request->all();

        //set update data
        $updateData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
            'role' => $data['role']
        );

        //create user with companies
        if(empty($data['companies'])) {
            $create = User::create($updateData);
        } else {
            $create = User::create($updateData)->companies()->attach($data['companies']);
        }

        if($create) {
            //return with success
            return redirect('users')
                ->with('success', trans('User has been successfully created!'));
        } else {
            //return with error
            return redirect('users')
                ->with('error', trans('User could not be created!'));
        }
    }

    /**
     * Show the form for editing the user
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        //get users with companies
        $user = User::where('id', $id)->with(['companies' => function($query){
            $query->select(['companies.id', 'companies.name']);
        }])->get()->first();

        //get companies
        $companies = DB::table('companies')->get();

        //view edit form
        return view('user.edit', [
            'user' => $user,
            'companies' => $companies
        ]);
    }

    /**
     * Update the specified user
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,',id'
        ], [
            'name.required' => trans('Name is required!'),
            'email.required' => trans('E-mail address is required!'),
            'email.email' => trans('E-mail address is not a valid one!')
        ]);

        //get all data from the request
        $data = $request->all();

        //validate password if not empty
        if(!empty($data['password'])) {
            $request->validate([
                'password' => 'string|min:8|confirmed'
            ], [
                'password.required' => trans('Password is required!')
            ]);
        }

        //set update data
        $updateData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role']
        );

        //check password
        if(!empty($data['password'])) $updateData['password'] = Hash::make($data['password']);

        $user = User::find($id)->companies()->detach();

        $update = User::find($id)->update($updateData);

        if($update) {

            //update companies
            if(!empty($data['companies'])) {
                User::find($id)->companies()->sync($data['companies']);
            }

            //return with success
            return redirect('users')
                ->with('success', trans('User has been successfully updated!'));
        } else {
            //return with error
            return redirect('users')
                ->with('error', trans('User could not be updated!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        //delete the user from db
        $delete = DB::table('users')->where('id', $id)->delete();

        if($delete) {
            //return
            return redirect()->route('users')
                ->with('success', 'User deleted successfully!');

        }  else  {

            //return
            return redirect()->route('users')
                ->with('error', 'User could not be deleted!');
        }
    }
}
