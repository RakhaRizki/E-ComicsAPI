<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Crud //

Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/{id}', [PostsController::class, 'show']);
Route::post('/posts', [PostsController::class, 'store']);
Route::patch('/posts/{id}', [PostsController::class, 'update']);
Route::delete('/posts/{id}', [PostsController::class, 'delete']);

// Authentication //

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

// Comments //

Route::post('/comments', [CommentsController::class, 'store']); 
Route::patch('/comments/{id}',[CommentsController::class, 'update']);
Route::delete('/comments/{id}', [CommentsController::class, 'delete']);


