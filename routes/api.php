<?php

use Illuminate\Http\Request;
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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Project:
Route::get('/all_Projects',[ProjectController::class,'findAll']);

// Certification
Route::get('/all_Certifications',[CertificationController::class,'findAll']);

// Skill
Route::get('/all_Skills',[SkillController::class,'findAll']);

// Experience
Route::get('/all_Experiences',[ExperienceController::class,'findAll']);

// ProfileInfo
Route::get('/all_ProfileInfos',[ProfileInfoController::class,'findAll']);

// HTTP Requests Handler:
Route::get('/send_get_request',[FetchDataController::class,'Send_GET_Request']);

//Auth:
Route::post('/Login',[AuthController::class,'Login']);
Route::post('/Logout',[AuthController::class,'Logout']);
Route::post('/SignUp',[AuthController::class,'SignUp']);
Route::post('/ChangePassword',[AuthController::class,'ChangePassword']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/checkingAuthenticated',[AuthController::class,'checkingAuthenticated']);
    

});
