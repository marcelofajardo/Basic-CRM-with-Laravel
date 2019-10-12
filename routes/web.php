<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/**
 * Routes for Home controller
 */
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::get('/home/{locale}', 'HomeController@locale');

/**
 * Routes for User controller
 */
Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/store', 'UserController@store')->name('user.store');
Route::get('/user/{id}', 'UserController@show')->name('user.show');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user.edit');
Route::put('/user/{id}', 'UserController@update')->name('user.update');
Route::delete('/user/{id}', 'UserController@destroy')->name('user.destroy');

/**
 * Routes for Company controller
 */
Route::get('/companies', 'CompanyController@index')->middleware('role:Manager')->name('companies');
Route::get('/company/create', 'CompanyController@create')->middleware('role:Manager')->name('company.create');
Route::post('/company/store', 'CompanyController@store')->middleware('role:Manager')->name('company.store');
Route::get('/company/{id}', 'CompanyController@show')->middleware('role:Manager')->name('company.show');
Route::get('/company/{id}/edit', 'CompanyController@edit')->middleware('role:Manager')->name('company.edit');
Route::put('/company/{id}', 'CompanyController@update')->middleware('role:Manager')->name('company.update');
Route::delete('/company/{id}', 'CompanyController@destroy')->middleware('role:Manager')->name('company.destroy');

/**
 * Routes for Employee controller
 */
Route::get('/employees', 'EmployeeController@index')->middleware('role:Manager')->name('employees');
Route::get('/employee/create', 'EmployeeController@create')->middleware('role:Manager')->name('employee.create');
Route::post('/employee/store', 'EmployeeController@store')->middleware('role:Manager')->name('employee.store');
Route::get('/employee/{id}', 'EmployeeController@show')->middleware('role:Manager')->name('employee.show');
Route::get('/employee/{id}/edit', 'EmployeeController@edit')->middleware('role:Manager')->name('employee.edit');
Route::put('/employee/{id}', 'EmployeeController@update')->middleware('role:Manager')->name('employee.update');
Route::delete('/employee/{id}', 'EmployeeController@destroy')->middleware('role:Manager')->name('employee.destroy');


