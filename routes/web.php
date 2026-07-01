<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.dashboard');
// });
Route::get('/', function () {
    return redirect()->route('admin.login');
});


