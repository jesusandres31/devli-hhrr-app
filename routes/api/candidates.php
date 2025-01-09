<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CandidateController;

Route::prefix('candidates')->group(function () {
    Route::get('/', [CandidateController::class, 'index']);
    Route::get('/{id}', [CandidateController::class, 'show']);
    Route::post('/', [CandidateController::class, 'store']);
    Route::put('/{id}', [CandidateController::class, 'update']);
    Route::patch('/{id}', [CandidateController::class, 'updatePartial']);
    Route::delete('/{id}', [CandidateController::class, 'destroy']);
});
