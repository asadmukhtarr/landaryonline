<?php

use Illuminate\Support\Facades\Route;
use Auth as Auth;

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
// working ..
Route::get('/', function () {
    return view('welcome');
})->name('main');
// After Login ..
Route::namespace('App\Http\Controllers')->middleware('auth')->group(function(){
    // Dashboard ..
    Route::get('/dashboard','pagesController@dashboard')->name('admin.dashboard');
    Route::prefix('customers')->group(function(){
        Route::get('/','pagesController@customer')->name('admin.customer');
        Route::post('/save','pagesController@save_customer')->name('save.customer');
        Route::get('/delete/{id}','pagesController@delete_customer')->name('delete.customer');
        Route::post('/customer/update/{id}','pagesController@update_customer')->name('update.customer');
    });
    // department ..
    Route::prefix('department')->group(function(){
        Route::get('/','pagesController@department')->name('admin.department');
        Route::get('/orders/{id}','pagesController@order_department')->name('order.department');
        Route::post('/save','pagesController@department_save')->name('save.department');
        Route::get('/status/{id}','pagesController@department_status')->name('status.department');
    });
    Route::get('/staff','pagesController@staff')->name('admin.staff');
    Route::prefix('orders')->group(function(){
        Route::get('/new','pagesController@new_order')->name('new.orders');
        Route::post('save','pagesController@save_order')->name('save.order');
        Route::get('/details/{id}','pagesController@order_detail')->name('order.details');
        Route::post('/details/save/{id}','pagesController@order_detail_save')->name('orderdetails.save');
        Route::get('/item/delete/{id}','pagesController@orderdetail')->name('item.delete');
        Route::get('/','pagesController@orders')->name('all.orders');
        Route::post('/place/{id}','pagesController@place_order')->name('place.order');
        Route::get('/delete/{id}','pagesController@delete_order')->name('delete.order');
        Route::get('/update/{id}','pagesController@update_order')->name('update.order');
    });
    Route::prefix('users')->group(function(){
        Route::get('/create','pagesController@users')->name('add.user');
        Route::get('/roles','pagesController@roles')->name('role.user');
        Route::post('/roles/save','pagesController@role_save')->name('role.save');
        Route::get('/roles/delete/{id}','pagesController@del_role')->name('role.delete');
        Route::prefix('permissions')->group(function(){
            Route::get('/','pagesController@permissions')->name('permission.user');
            Route::post('/save','pagesController@permission_save')->name('permission.save');
            Route::get('/delete/{id}','pagesController@permission_delete')->name('permission.delete');
            Route::get('/grant/{id}','pagesController@grantpermission')->name('permission.grant');
            Route::post('/granted/{id}','pagesController@grantedpermission')->name('permission.granted');
        });

    });
});


// Authentication ..
Auth::routes();
// home ..
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout',function(){
    Auth::logout();
    return redirect(route('main'));
})->name('admin.logout');
