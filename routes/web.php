<?php

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\ProductController;
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
Route::get('/', function () {return view('welcome');});
Route::prefix('admin')->as('admin.')->middleware('auth')->group(function (){

    Route::get('/dashboard',[IndexController::class,'dashboard'])->name('dashboard');
    custom_route('skills',SkillController::class);
    custom_route('categories',CategoryController::class);
    custom_route('users',UserController::class);
    custom_route('products',ProductController::class);
    custom_route('questions',QuestionController::class);
    custom_route('questions/{question}/answers',AnswerController::class);

    //ajax
//    Route::post('categories/{category_id}/skills/store',[CategoryController::class,'store_skills'])->name('categories.skills.sync');
//    Route::post('users/{user_id}/skills/store',[UserController::class,'store_skills'])->name('users.skills.sync');
    Route::post('users/{user_id}/categories/store',[UserController::class,'store_categories'])->name('users.categories.sync');
//    Route::post('product/{product_id}/skills/store',[ProductController::class,'store_skills'])->name('products.skills.sync');

    //chat
    Route::get('/messages',[IndexController::class,'messages'])->name('messages');

});


Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();
