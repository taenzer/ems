<?php

use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiProductImageController;
use App\Http\Controllers\Api\ApiTicketController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

/*  
/   IMPORTANT NOTICE: I added a middleware globaly to the app/Http/Kernel.php to
/   respond with JSON to all API request, ignoring their "Accept" header. 
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/test', function () {
    return "ok";
});

Route::middleware('auth:sanctum')->post('/orders', [ApiOrderController::class, 'store']);

Route::middleware('auth:sanctum')->get('/product-images', [ApiProductImageController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('events', ApiEventController::class);
    Route::get('events/{event}/products/tickets', [ApiEventController::class, 'getTicketProducts']);

    Route::post('tickets', [ApiTicketController::class, 'createOrder']);
    Route::post('tickets/pdf', [ApiTicketController::class, 'getTicketPdf']);


    /*     Route::put("events/{event}/status", [ApiEventController::class, 'toggleStatus'])->name("events.status.toggle");
    Route::resource('products', ProductController::class);

    Route::get('events/{event}/products/add', [EventProductLinkController::class, 'create'])->name("events.products.add");
    Route::post('events/{event}/products/add', [EventProductLinkController::class, 'store'])->name("events.products.store");
    Route::patch('events/{event}/products/', [EventProductLinkController::class, 'update'])->name("events.products.update");
    Route::delete('events/{event}/products/', [EventProductLinkController::class, 'destroy'])->name("events.products.destroy"); */
});




/* TODO: Refactor to own Controller? */
Route::post(
    '/token',
    function (Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);



        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }
);