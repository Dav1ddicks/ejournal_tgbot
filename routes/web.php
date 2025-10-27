<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessageController;
use App\Http\Controllers\IndividualMessageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [GroupController::class, 'index']);
Route::post('/webhook', TelegramController::class)->withoutMiddleware([VerifyCsrfToken::class]);;

Route::resource('groups', GroupController::class);
Route::resource('groups.students', StudentController::class)->except(['index'])->shallow();
Route::resource('groups.students.individaul-messages', IndividualMessageController::class)->only(['create', 'store'])->shallow();
Route::resource('groups.group-messages', GroupMessageController::class)->only(['create', 'store'])->shallow();
