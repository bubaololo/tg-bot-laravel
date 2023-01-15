<?php

use App\Http\Controllers\ContextRouter;
use App\Http\Controllers\RenderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\StartController;
use App\Facades\Telegram;

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
    
    if (array_key_exists("message", $request->all())) { //normal request
        session()->forget('_token');
        $id = $request->all()['message']['from']['id'];
        $sessionId = str_pad($id, 40, "0", STR_PAD_RIGHT);
        Session::setId($sessionId);
        session(['chat_id' => $id]);
        info('первая проверка в запросе'.session('context'));
//        session(['azaza' => 'vururu']);
        session()->get('key');
        info(session()->all());
        info(session()->getId());
        if (!session('context')) { // regular command processing, if new user or user finish previous action and back to start
            $command = $request->all()['message']['text'];
            switch ($command) {
                case '/start':
                    StartController::start();
                    break;
                case '2':
                    session(['context' => 'img2']);
                    session(['step' => 1]);
                    ContextRouter::index();
                    break;
                case '/keyboard':
                    app('App\Telegram\SendInlineKeyboard')->index('one', 'two');
                    break;
                case '/router':
                    app('App\Http\Controllers\StartController')->router($command);
                    break;
                default:
                    app('App\Http\Controllers\StartController')->index($id, $command);
            }
        } else { //stateful
        ContextRouter::index();
        info('попал в контекст');
        }
    } elseif (array_key_exists("callback_query", $request->all())) { //callback request
        $id = $request->all()['callback_query']['from']['id'];
        $sessionId = str_pad($id, 40, "0", STR_PAD_RIGHT);
        Session::setId($sessionId);
        $callbackId = $request->all()['callback_query']['id'];
        session(['callback' => $callbackId]);
        app('App\Http\Controllers\StartController')->callback();
        
    } else {
        info('error'); // log telegram ping request
        Telegram::sendMessage('ошибка');
    }
    
});
