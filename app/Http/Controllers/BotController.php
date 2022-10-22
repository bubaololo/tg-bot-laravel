<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Facades\Telegram;

class BotController extends Controller
{
    public function index(Request $request){
        // check if normal request
if (array_key_exists("message", $request->all())) {
    $id = $request->all()['message']['from']['id'];
    $message = $request->all()['message']['text'];
    // info($request->all());
    $sessionId = str_pad($id, 40, "0", STR_PAD_RIGHT);
    Session::setId($sessionId);
    // session(['key' => 'value']);
    // $request->session()->put('step', '1');
    // info(print_r($request->session()->all(), true));
    // info(session('key'));
    // $message = str_replace('а','э', $message);
    // Telegram::sendMessage($id, $message);
    // $buttons = [['text' => 'button 1'], ['text' => 'button 2']];
    // Telegram::sendKeyboard($id, $message, $buttons);
    $file = 'rst.jpg';
    Telegram::sendPhoto($id, $file);
} else {
    info('tg_ping'); // log telegram ping request
    return "ping";
}
    }
}

// [2022-10-19 22:43:26] local.INFO: array (
//     'update_id' => 634261512,
//     'message' => 
//     array (
//       'message_id' => 235,
//       'from' => 
//       array (
//         'id' => 933808533,
//         'is_bot' => false,
//         'first_name' => 'username',
//         'username' => 'bubaololo',
//         'language_code' => 'ru',
//       ),
//       'chat' => 
//       array (
//         'id' => 933808533,
//         'first_name' => 'username',
//         'username' => 'bubaololo',
//         'type' => 'private',
//       ),
//       'date' => 1666219406,
//       'text' => '77',
//     ),
//   )  
