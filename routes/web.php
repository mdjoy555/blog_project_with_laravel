<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('frontend.layouts.master');
// });
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/',[SiteController::class,'home'])->name('homepage');
Route::get('/post_detail/{id}',[SiteController::class,'post_detail'])->name('posts.detail');
Route::get('/about',[SiteController::class,'about'])->name('about');
Route::middleware('admin')->group(function()
{
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/category_index',[CategoryController::class,'index'])->name('categories.index');
    Route::post('/category_store',[CategoryController::class,'store'])->name('categories.store');
    Route::post('/category_update',[CategoryController::class,'update'])->name('categories.update');
    Route::get('/category_delete/{id}',[CategoryController::class,'delete'])->name('categories.delete');
    Route::get('/post_index',[PostController::class,'index'])->name('posts.index');
    Route::get('/post_create',[PostController::class,'create'])->name('posts.create');
    Route::post('/post_store',[PostController::class,'store'])->name('posts.store');
    Route::get('post_edit/{id}',[PostController::class,'edit'])->name('posts.edit');
    Route::post('post_update/{id}',[PostController::class,'update'])->name('posts.update');
    Route::get('/post_delete/{id}',[PostController::class,'delete'])->name('posts.delete');
});
