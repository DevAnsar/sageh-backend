<?php

use App\Http\Controllers\Api\v1\AnswerController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\QuestionController;
use App\Http\Controllers\Api\v1\CategoryController;
use \App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('\Api\v1')->prefix('v1')->group(function () {
    Route::get('/getCategories', [CategoryController::class,'getCategories']);
    Route::get('/getUsers/{category_id}', [UserController::class,'getUsers']);
//    Route::get('/getSkills', [SkillController::class,'getSkills']);
    Route::get('/getQuestions', [QuestionController::class,'getQuestions']);
    Route::get('/questions/{question_id}/getAnswers', [AnswerController::class,'getAnswers']);
    Route::get('/user/{user_id}', [UserController::class,'getUser']);
    Route::get('/user/{user_id}/products', [UserController::class,'getProducts']);

    Route::group(['middleware' => 'api','prefix' => 'auth'],function () {
        Route::post('check_mobile', [AuthController::class,'check_mobile']);
        Route::post('login', [AuthController::class,'login']);
        Route::post('logout',  [AuthController::class,'logout']);
        Route::post('refresh',  [AuthController::class,'refresh']);
        Route::post('me',  [AuthController::class,'me']);
        Route::post('send_verification_code', [AuthController::class,'send_verification_code']);
        Route::post('pre_register',  [AuthController::class,'pre_register']);
        Route::post('mobile_register', [AuthController::class,'mobile_register']);
        Route::post('profile_data_register',  [AuthController::class,'register_profile_data']);
        Route::post('password_register',  [AuthController::class,'password_register']);

//        Route::post('register',  [AuthController::class,'register']);
//        Route::post('verification_mobile', [AuthController::class,'verification_mobile']);
    });

    Route::group(['middleware' => 'auth:api'],function () {
        Route::post('/user/setCategory', [UserController::class,'setCategory']);
        Route::post('/sendQuestions', [QuestionController::class,'sendQuestions']);
        Route::post('/questions/{question_id}/sendAnswers', [AnswerController::class,'sendAnswers']);
        Route::post('/questions/toggleToFavorite', [QuestionController::class,'toggleToFavorite']);
    });
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
});

