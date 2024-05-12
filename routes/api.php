<?php

use App\Http\Controllers\plantacionControlador;
use Illuminate\Support\Facades\Route;

Route::get('/plantacion/{id}', [plantacionControlador::class, 'showAll']);

Route::get('/plantacion/{id_usuario}/{id_plantacion}', [plantacionControlador::class, 'show']);

Route::get('/tipos', [plantacionControlador::class, 'showTypes']);

Route::post('/plantacion', [plantacionControlador::class, 'create']);

Route::put('/plantacion/{id}', [plantacionControlador::class, 'update']);

Route::delete('/plantacion/{id}', [plantacionControlador::class, 'delete']);