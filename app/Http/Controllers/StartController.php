<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;
use App\Facades\Telegram;
use Illuminate\Support\Facades\Storage;

class StartController extends Controller
{
    public function index($id, $message)
    {
        
        // info($request->all());
        // session(['key' => 'value']);
        // $request->session()->put('step', '1');
        // info(print_r($request->session()->all(), true));
        // info(session('key'));
        // $message = str_replace('а','э', $message);
        Telegram::sendMessage($message);
        // $buttons = [['text' => 'button 1'], ['text' => 'button 2']];
        // Telegram::sendKeyboard($id, $message, $buttons);
        // $inlineButtons = [["text" => "Yes", "callback_data" => "ололол"],
        // ["text" =>"No", "callback_data" => "ыываыва"]];
        // Telegram::sendInlineKeyboard($id, $inlineButtons, $message);
        // $file = 'rst.jpg';
        // Telegram::sendPhoto($id, $file);
        
    }
    
    public function start()
    {
//            $inlineButtons = [["text" => "Купить", "callback_data" => "купить"],
//            ["text" =>"Продать", "callback_data" => "продать"]];
//            Telegram::sendInlineKeyboard( $inlineButtons, 'выберите картинку');
        Telegram::sendMessage('выберите картинку');
        Telegram::sendPhoto(env('APP_URL') . Storage::url("public/ready_imgs/" . "menu.jpg"));
        $bot = new TelegramService;
        $bot->message = 'выберите картинку';
//        $bot->sendInlineKeyboard(1, 2, 3, 4);
        $bot->sendKeyboard(1, 2, 3, 4);
    

    }
    
            public function callback()
        {
            Telegram::answerCallback('сообщуха');
        }

        public function router($command)
        {
            info($command);
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
}