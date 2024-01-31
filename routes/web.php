<?php

use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Candidate\CandidateContactController;
use App\Http\Controllers\Candidate\CandidateHireController;
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

Route::inertia('/', 'app')->name('home');

Route::get('candidates-list', CandidateController::class)->name('candidates.index');

Route::post('/candidates/{candidate}/contact', CandidateContactController::class)->name('candidates.contact');
Route::post('/candidates/{candidate}/hire', CandidateHireController::class)->name('candidates.hire');