<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', fn() => response()->json([
    'up' => true,
    'time' => now()->toIso8601String(),
]));
