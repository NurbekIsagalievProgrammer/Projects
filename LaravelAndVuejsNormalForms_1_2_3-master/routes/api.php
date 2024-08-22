<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecyclerController;
use App\Http\Controllers\RecyclerThemeController;
use App\Http\Controllers\RecyclerSolutionController;
use App\Http\Controllers\RecyclerRequestController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/getAll', [RecyclerController::class, 'index']);
Route::post('/create', [RecyclerController::class, 'create']);
Route::post('/edit', [RecyclerController::class, 'edit']);
Route::post('/delete', [RecyclerController::class, 'remove']);

Route::get('/getAllTheme', [RecyclerThemeController::class, 'index']);
Route::post('/createTheme', [RecyclerThemeController::class, 'create']);
Route::post('/editTheme', [RecyclerThemeController::class, 'edit']);
Route::post('/deleteTheme', [RecyclerThemeController::class, 'remove']);

Route::get('/getAllSolution', [RecyclerSolutionController::class, 'index']);
Route::post('/createSolution', [RecyclerSolutionController::class, 'create']);
Route::post('/editSolution', [RecyclerSolutionController::class, 'edit']);
Route::post('/deleteSolution', [RecyclerSolutionController::class, 'remove']);

Route::get('/getAllRequest', [RecyclerRequestController::class, 'index']);
Route::post('/createRequest', [RecyclerRequestController::class, 'create']);
Route::post('/updateRequest', [RecyclerRequestController::class, 'updateRequest']);

Route::get('/getAllRecyclerSerialNumber', [RecyclerRequestController::class, 'getAllRecyclerSerialNumbers']);
Route::get('/getAllRecyclerThemeTitle', [RecyclerRequestController::class, 'getAllRecyclerThemeTitles']);
Route::get('/getAllRecyclerSolutionTitle', [RecyclerRequestController::class, 'getAllRecyclerSolutionTitles']);

