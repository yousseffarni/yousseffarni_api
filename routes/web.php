<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SkillController;
use App\Http\Controllers\api\CertificationController;
use App\Http\Controllers\api\ExperienceController;
use App\Http\Controllers\api\ProfileInfoController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FetchDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/api/all_Projects',[ProjectController::class,'findAll']);

// Certification
Route::get('/api/all_Certifications',[CertificationController::class,'findAll']);

// Skill
Route::get('/api/all_Skills',[SkillController::class,'findAll']);

// Experience
Route::get('/api/all_Experiences',[ExperienceController::class,'findAll']);

// ProfileInfo
Route::get('/api/all_ProfileInfos',[ProfileInfoController::class,'findAll']);

// HTTP Requests Handler:
Route::get('/api/send_get_request',[FetchDataController::class,'Send_GET_Request']);

//Auth:
Route::post('/api/Login',[AuthController::class,'Login']);
Route::post('/api/Logout',[AuthController::class,'Logout']);
Route::post('/api/SignUp',[AuthController::class,'SignUp']);
Route::post('/api/ChangePassword',[AuthController::class,'ChangePassword']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
