<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/get-cardnumber', function (Request $request) {

    $cardNumber = $request->input('card_number');

    // Log the card number for now, you can process it as needed
    Log::info('Received card number: ' . $cardNumber);

    return response()->json(['success' => true, 'card_number' => $cardNumber]);
});
