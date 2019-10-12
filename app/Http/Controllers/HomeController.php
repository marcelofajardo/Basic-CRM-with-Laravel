<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $nofCompanies = DB::table('companies')->count('id');
        $nofEmployees = DB::table('employees')->count('id');
        return view('home', ['nofCompanies' => $nofCompanies, 'nofEmployees' => $nofEmployees]);
    }

    public function locale($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
