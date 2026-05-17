<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontobewegungController;
use App\Http\Controllers\KontoController;
use App\Http\Controllers\KategorieController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SparzielController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn() => response()->json(['status' => 'ok']));

//Öffentlich
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Geschützt (Token erforderlich)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/kontobewegung/index', [KontobewegungController::class, 'index']);
    Route::get('/kontobewegung/{id}/show', [KontobewegungController::class, 'show']);
    Route::post('/kontobewegung/store', [KontobewegungController::class, 'store']);
    Route::get('/kontobewegung/create', [KontobewegungController::class, 'create']);
    Route::put('/kontobewegung/{id}/update', [KontobewegungController::class, 'update']);
    Route::delete('/kontobewegung/{id}/destroy', [KontobewegungController::class, 'destroy']);
    Route::get('/kontobewegung/fixCosts', [KontobewegungController::class,'fixCosts']);
    Route::delete('/kontobewegung/{id}/fixCostsDestroy', [KontobewegungController::class, 'fixCostsDestroy']);
    Route::post('/kontobewegung/fixCostsStore', [KontobewegungController::class, 'fixCostsStore']);

    Route::get('/konto/index', [KontoController::class, 'index']);
    Route::get('/konto/{id}/show', [KontoController::class, 'show']);
    Route::post('/konto/store', [KontoController::class, 'store']);
    Route::get('/konto/create', [KontoController::class, 'create']);
    Route::put('/konto/{id}/update', [KontoController::class, 'update']);
    Route::delete('/konto/{id}/destroy', [KontoController::class, 'destroy']);

    Route::get('/kategorie/index', [KategorieController::class, 'index']);
    Route::get('/kategorie/{id}/show', [KategorieController::class, 'show']);
    Route::post('/kategorie/store', [KategorieController::class, 'store']);
    Route::get('/kategorie/create', [KategorieController::class, 'create']);
    Route::put('/kategorie/{id}/update', [KategorieController::class, 'update']);
    Route::delete('/kategorie/{id}/destroy', [KategorieController::class, 'destroy']);

    Route::post('/sparziel/store', [SparzielController::class, 'store']);
    Route::get('/sparziel/index', [SparzielController::class, 'index']);
    Route::get('/sparziel/{id}/show', [SparzielController::class, 'show']);
    Route::get('/sparziel/preview', [SparzielController::class, 'preview']);

    Route::get('/PieChart', [KontobewegungController::class, 'pieChartData']);
    Route::get('/kontobewegung/history', [KontobewegungController::class, 'history']);
    Route::get('/kontobewegung/historyPreview', [KontobewegungController::class, 'historyPreview']);
    Route::get('/progress', [ProgressController::class, 'progress']);
});
