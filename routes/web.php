<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//add 2020-11-12, past the following from api.php, and modify into 'auth' middleware, for sanctum
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//說明: 1.將api.php移入web.php, 省去在/api的prefix(/api/user), 直接使用/user
//     2./user 這個router url, 會使用到'auth'這個middleware
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/home', 'HomeController@index')->name('home');

//add 2020-11-12
Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.-]*');

Route::middleware('auth')->group(function () {
    Route::resource('/api/admin/users', 'Admin\UsersController', ['except' => ['show', 'create', 'store']]);
    Route::resource('/api/roles', 'Role\RolesController');
    Route::get('/api/customer/roles/{id}/{roleId?}', [
        'as' => 'roles.show',
        'uses' => 'Role\CustomerRolesController@show',
    ]);
    Route::get('/api/customer/admin/users', 'Admin\CustomerUsersController@getAllUsersAndUserRoles');
    Route::post('/api/customer/rolesList', 'Admin\CustomerUsersController@rolesList');

	//Route::get('/api/admin/lang/{locale}', 'LocalizationController@index');
});
