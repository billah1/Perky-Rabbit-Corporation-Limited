<?php

use App\Http\Controllers\Backend\AchievementController;
use App\Http\Controllers\Backend\AchievementEmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('checkAuth', [AuthController::class, 'checkAuth'])->middleware('auth:sanctum');
Route::post('login', [AuthController::class, 'login']);
Route::post('register-step-1', [AuthController::class, 'registerStep1']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);


    //department
    Route::get('/department', [DepartmentController::class, 'getAllDepartment']);
    Route::get('/department/{department}', [DepartmentController::class, 'getDepartment']);
    Route::post('/department', [DepartmentController::class, 'storeDepartment']);
    Route::put('/department/{department}', [DepartmentController::class, 'updateDepartment']);
    Route::delete('/department/{department}', [DepartmentController::class, 'deleteDepartment']);

    //Employee
      Route::get('/employee', [EmployeeController::class, 'getAllEmployee']);
      Route::get('/employee/{employee}', [EmployeeController::class, 'getEmployee']);
      Route::post('/employee', [EmployeeController::class, 'storeEmployee']);
      Route::put('/employee/{employee}', [EmployeeController::class, 'updateEmployee']);
      Route::delete('/employee/{employee}', [EmployeeController::class, 'deleteEmployee']);


      //Achievement
      Route::get('/achievement', [AchievementController::class, 'getAllAchievement']);
      Route::get('/achievement/{achievement}', [AchievementController::class, 'getAchievement']);
      Route::post('/achievement', [AchievementController::class, 'storeAchievement']);
      Route::put('/achievement/{achievement}', [AchievementController::class, 'updateAchievement']);
      Route::delete('/achievement/{achievement}', [AchievementController::class, 'deleteAchievement']);

});
