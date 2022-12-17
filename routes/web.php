<?php

use App\Controllers\HomeController;
use Shield\Http\Route;

Route::get('/test', [HomeController::class, 'index']);
