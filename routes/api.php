<?php

use Illuminate\Http\Request;
use App\Company;
use App\Employee;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * API Routes for Companies
 */

//show all companies
Route::middleware('auth:api')->get('companies', function() {
    return Company::all();
});
//show one company
Route::middleware('auth:api')->get('/companies/{id}', function($id) {
    return Company::find($id);
});
//insert a company
Route::middleware('auth:api')->post('/companies', function(Request $request) {
    return Company::create($request->all());
});
//update a company
Route::middleware('auth:api')->put('/companies/{id}', function(Request $request, $id) {
    $article = Company::findOrFail($id);
    $article->update($request->all());
    return $article;
});
//delete a company
Route::middleware('auth:api')->delete('/companies/{id}', function($id) {
    Company::find($id)->delete();
    return 204;
});

/**
 * API Routes for Employees
 */

//show all companies
Route::middleware('auth:api')->get('employees', function() {
    return Employee::all();
});
//show one company
Route::middleware('auth:api')->get('/employees/{id}', function($id) {
    return Employee::find($id);
});
//insert a company
Route::middleware('auth:api')->post('/employees', function(Request $request) {
    return Employee::create($request->all());
});
//update a company
Route::middleware('auth:api')->put('/employees/{id}', function(Request $request, $id) {
    $article = Employee::findOrFail($id);
    $article->update($request->all());
    return $article;
});
//delete a company
Route::middleware('auth:api')->delete('/employees/{id}', function($id) {
    Employee::find($id)->delete();
    return 204;
});
