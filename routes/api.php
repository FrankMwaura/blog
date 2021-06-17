<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'=>'api'], function(){
    Route::post('/login', 'AuthController@login');
    Route::post('/checkToken', 'AuthController@checkToken');
    Route::post('logout', 'AuthController@logout');
    Route::post('admin', 'AdminController@index');

    //Category routes
    Route::resource('/category', 'CategoryController');
    Route::post('/multiple-category-delete', 'CategoryController@multipleDelete')->name('admin.category.multipledelete');
    Route::get('/all-category', 'CategoryController@getAllCategory')->name('admin.allcategory');

    //Blog routes
    
    Route::resource('/blog', 'BlogController');
    Route::post('/blog-update/{id}', 'BlogController@updateBlog')->name('admin.blog.update');
    Route::post('/multiple-blog-delete', 'BlogController@multipleDelete')->name('admin.blog.multipledelete');
    
});
