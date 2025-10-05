<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")
    ->name("auth.")
    ->group(function () {
        Route::post("/user", [AuthController::class, "register"])->name("user");
        Route::post("/login", [AuthController::class, "login"])->name("login");
        Route::post("/logout", [AuthController::class, "logout"])->name(
            "logout",
        );
    });

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", fn() => auth()->user())->name("user");
});
