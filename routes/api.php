<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EmployersController;
use App\Http\Controllers\Api\JobPostsController;
use App\Http\Controllers\Api\JobSubmissionsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/user')->namespace('User')->group(function() {

    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::group(["middleware" => ["auth:sanctum"]], function() {

        Route::get('profile', [UserController::class, 'profile']);
        Route::get('logout', [UserController::class, 'logout']);


        Route::match(['get', 'post'], 'add-job-submission/{id?}', [JobSubmissionsController::class, 'addJobSubmission']);
    });

});

Route::prefix('/employer')->namespace('Employer')->group(function() {

    Route::post('register', [EmployersController::class, 'register']);
    Route::post('login', [EmployersController::class, 'login']);

    Route::group(["middleware" => ["auth:sanctum"]], function() {

        Route::get('profile', [EmployersController::class, 'profile']);
        Route::get('logout', [EmployersController::class, 'logout']);

        //add edit delete job routes
        Route::match(['get', 'post'], '/add-job', [JobPostsController::class, 'addJobs']);
        Route::match(['get', 'put'], '/edit-job/{id?}', [JobPostsController::class, 'editJobs']);
        Route::delete('delete-job/{id}', [JobPostsController::class, 'deleteJob']);

        //update job submissions status routes
        Route::match(['get', 'put'], '/update-job-submission/{id?}', [JobSubmissionsController::class, 'updateJobSubmission']);

        //get all the job submissions
        Route::get('get-job-submissions', [JobSubmissionsController::class, 'getJobSubmissions']);

        //update job submissions status routes
        Route::match(['get', 'put'], '/update-job-submissions-status/{id?}', [JobSubmissionsController::class, 'updateJobSubmissionStatus']);

    });
});

//search for jobs
Route::post('/search-jobs', [JobPostsController::class, 'searchJobs']);

//get all the jobs
Route::get('/jobs', [JobPostsController::class, 'jobs']);

