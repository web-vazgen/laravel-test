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

Route::get('/add-employee', 'EmployeeController@index');
Route::post('/add-employee', 'EmployeeController@saveEmployee')->name('save-employee');

Route::get('/get-departments', 'ApiController@getDepartments');
Route::get('/get-titles', 'ApiController@getTitles');
Route::get('/get-employees', 'ApiController@getEmployees');


