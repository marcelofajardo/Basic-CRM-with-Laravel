<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
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
     * Show companies list
     *
     * @return Renderable
     */
    public function index()
    {
        $companies = DB::table('companies')->paginate(10);

        return view('company.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show company create form
     * @return View
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store company
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //basic validation
        $request->validate([
            'name' => 'required',
            'email' => 'email'
        ], [
            'name.required' => trans('Name is required!'),
            'email.email' => trans('E-mail address is not a valid one!')
        ]);

        //get all data from the request
        $data = $request->all();

        //set update data
        $insertData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'website' => $data['website']
        );

        //handle logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            //make it 200x200
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200);
            $img->stream();

            //save the logo to the storage app/public folder
            $path = Storage::disk('local')->put('public/'.$fileName, $img, 'public');

            //set attribute
            if($path) {
                $insertData['logo'] = $fileName;
            }
        }

        //insert
        $create = DB::table('companies')->insert($insertData);

        if($create) {
            //return with success
            return redirect('companies')
                ->with('success', trans('Company has been successfully created!'));
        } else {
            //return with error
            return redirect('companies')
                ->with('error', trans('Company could not be created!'));
        }
    }

    /**
     * Show the form for editing the company
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $company = DB::table('companies')->where('id', $id)->get()->first();

        return view('company.edit', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified company
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        //check if authorized
        $this->authorize('update', Company::find($id));

        //basic validation
        $request->validate([
            'name' => 'required',
            'email' => 'email'
        ], [
            'name.required' => trans('Name is required'),
            'email.email' => trans('E-mail address is not a valid one!'),
        ]);

        //get all data from the request
        $data = $request->all();

        //set update data
        //we are not adding logo here as we will process it
        //and add later if it is changed
        $updateData = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'website' => $data['website']
        );

        //handle logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            //process logo
            $img = Image::make($image->getRealPath());
            $img->resize(200, 200);
            $img->stream();

            //save the logo image to the storage
            $path = Storage::disk('local')->put('public/'.$fileName, $img, 'public');

            //set attribute
            if($path) {
                $updateData['logo'] = $fileName;
            }
        }

        //update
        $update = DB::table('companies')->where('id', $id)->update($updateData);

        if($update) {
            //return with success
            return redirect('companies')
                ->with('success', trans('Company has been successfully updated!'));
        } else {
            //return with error
            return redirect('companies')
                ->with('error', trans('Company could not be updated!'));
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
        $this->authorize('delete', Company::find($id));

        //get logo file first
        $logo = DB::table('companies')->where('id', $id)->get('logo')->first();

        //delete the company from db
        $delete = DB::table('companies')->where('id', $id)->delete();

        if($delete) {
            //if company was deleted then remove the logo file
            Storage::disk('local')->delete('public/' . $logo->logo);

            //return with success
            return redirect()->route('companies')
                ->with('success', 'Company deleted successfully!');

        }  else  {

            //return with error
            return redirect()->route('companies')
                ->with('error', 'Company could not be deleted!');
        }
    }
}
