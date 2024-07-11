<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Models\ItemAccountGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/dashboard");
});

Route::get("/login", [AuthenticationController::class, "index"]);
Route::get("/logout", [AuthenticationController::class, "destroy"]);
Route::post('/login', [AuthenticationController::class, 'post']);

// Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::prefix("items")->group(function () {
    Route::get("", [ItemController::class, "index"]);
    Route::get("/id/{id}", [ItemController::class, "findById"]);
    Route::get("list", [ItemController::class, "findAll"]);
    Route::post("", [ItemController::class, "store"]);
    Route::put("/{id}", [ItemController::class, "update"]);
    Route::delete("/{id}", [ItemController::class, "softDelete"]);
});

Route::prefix("transactions")->group(function () {
    Route::get("", [TransactionController::class, "index"]);
    Route::get("/list", [TransactionController::class, "findAll"]);
    Route::get("/id/{id}", [TransactionController::class, "findById"]);
    Route::post("", [TransactionController::class, "store"]);
    Route::put('/{id}', [TransactionController::class, 'update']);
    Route::delete('/{id}', [TransactionController::class, 'softDelete']);
    Route::get('/detail/id/{id}', [TransactionController::class, 'findAllDetailById']);
});

Route::get('/item-account-groups/{id}', function ($id) {
    $itemAccountGroup = ItemAccountGroup::where('item_groups_id', $id)->first();
    if (!$itemAccountGroup) {
        return response()->json([
            'error' => 'Item Account Group not found',
            'status' => 404
        ], 404);
    }

    return response()->json([
        'item_account_group' => $itemAccountGroup,
        'status' => 200
    ]);
});
// });
