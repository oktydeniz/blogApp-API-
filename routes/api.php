<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LikeController;

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

Route::post('register',[AuthController::class,'registerAction']);
Route::post('login',[AuthController::class,'loginAction']);

Route::group(['middleware'=> ['auth:sanctum']],function(){

    //infos
    Route::post('saveUserInfo',[AuthController::class,'saveInfo']);
    //auth
    Route::post('logout',[AuthController::class,'logoutAction']);

    //post
    Route::post('/posts/create', [PostController::class,'create']);
    Route::post('/posts/delete', [PostController::class,'delete']);
    Route::post('/posts/update', [PostController::class,'update']);
    Route::get('posts', [PostController::class,'posts']);

    //comments
    Route::post('comments/create',[CommentController::class,'create']);
    Route::post('comments/delete',[CommentController::class,'delete']);
    Route::post('comments/update',[CommentController::class,'update']);
    Route::get('posts/comments',[CommentController::class,'comments']);

    //likes
    Route::post('posts/likes',[LikeController::class,'like']);
    
});

