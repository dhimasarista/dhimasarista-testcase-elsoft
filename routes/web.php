<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/dashboard");
});
Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::prefix("items")->group(function(){
    Route::get("", [ItemController::class, "index"]);
    Route::get("/list", [ItemController::class, "findAll"]);
});
