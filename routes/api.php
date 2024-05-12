<?php

use App\Http\Controllers\plantacionController;
use Illuminate\Support\Facades\Route;

Route::get('/plantacion/{id}', [plantacionController::class, 'showAll']);

Route::get('/plantacion/{id_usuario}/{id_plantacion}', [plantacionController::class, 'show']);

Route::get('/tipos', [plantacionController::class, 'showTypes']);

Route::post('/plantacion', [plantacionController::class, 'create']);

Route::put('/plantacion/{id}', [plantacionController::class, 'update']);

Route::delete('/plantacion/{id}', [plantacionController::class, 'delete']);