<?php

use App\Http\Controllers\MacroTargetController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/macro-targets', [MacroTargetController::class, 'store']);
    Route::get('/macro-targets', [MacroTargetController::class, 'index']);
});
