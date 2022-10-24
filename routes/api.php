<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\StartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/bot', [BotController::class, 'index']);

Route::post('/bot', function (Request $request) {
                info($request->all());

if (array_key_exists("message", $request->all())) { //normal request
        $id = $request->all()['message']['from']['id'];
        $sessionId = str_pad($id, 40, "0", STR_PAD_RIGHT);
        Session::setId($sessionId);
        $message = $request->all()['message']['text'];
switch ($message) {
    case '/start':
        app('App\Http\Controllers\StartController')->greetings($id);
        break;
        default:
        app('App\Http\Controllers\StartController')->index($id, $message);
}
} elseif (array_key_exists("callback_query", $request->all())){
    $id = $request->all()['callback_query']['id'];
    app('App\Http\Controllers\StartController')->callback($id);
    
}  else {
    // app('App\Http\Controllers\BotController')->index($id, 'ошибка');
    info('error'); // log telegram ping request
}
});
