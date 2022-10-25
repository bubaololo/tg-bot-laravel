<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TelegramService
{
    protected $http;
    protected $bot;
    public const url = 'https://api.telegram.org/bot';
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->bot = env('BOT_TOKEN');
    }

    public function sendMessage($message)
    {
        $this->http::post(
            self::url.$this->bot.'/sendMessage',
            [
                'chat_id' => session('id'),
               'text' => $message,
               'parse_mode' => 'html',
                        ]
        );
    }
    public function editMessage($chat_id, $message, $message_id)
    {
        return   $this->http::post(
            self::url.$this->bot.'/editMessageText',
            [
                'chat_id' => $chat_id,
               'text' => $message,
               'parse_mode' => 'html',
               'message_id' => $message_id
                        ]
        );
    }

    public function sendDocument($chat_id, $file, $reply_id = null)
    {
        return  $this->http::attach('document', Storage::get('/public/'.$file), 'document.png')
              ->post(self::url.$this->bot.'/sendDocument', [
              'chat_id' => $chat_id,
              'reply_to_message_id' => $reply_id
          ]);
    }

    public function sendPhoto($chat_id, $file, $reply_id = null)
    {
        $fileUrl = asset("storage/$file");
        info($fileUrl);
        return   $this->http::post(
            self::url.$this->bot.'/sendPhoto',
            [
               'chat_id' => $chat_id,
               'photo' => $fileUrl,
            ]
        );
    }

    public function answerCallback($text) {
     
        $response = $this->http::post(
            self::url.$this->bot.'/answerCallbackQuery',
            [
               'callback_query_id' => session('callback'),
               'text' => $text,
               'show_alert' => 1,
            ]
        );


    }

    public function sendKeyboard($buttons, $message = '')
    {
        info('keyboard');
        return   $this->http::post(
            self::url.$this->bot.'/sendMessage',
            [
                'chat_id' => session('id'),
               'text' => $message,
               'parse_mode' => 'html',
               'reply_markup'  => [
                'resize_keyboard' => true,
                'keyboard' => [
                        $buttons
                   ]
                ],
            ]
        );
    }
    public function sendInlineKeyboard($buttons, $message = '')
    {
        return   $this->http::post(
            self::url.$this->bot.'/sendMessage',
            [
                'chat_id' => session('id'),
               'text' => $message,
               'parse_mode' => 'html',
               'reply_markup' => [
                "inline_keyboard" => [

                        $buttons

                ]
                ],
            ]
        );
    }

    public function editButtons($chat_id, $message, $button, $message_id)
    {
        return   $this->http::post(
            self::url.$this->bot.'/editMessageText',
            [
                'chat_id' => $chat_id,
               'text' => $message,
               'parse_mode' => 'html',
               'reply_markup'  => $button,
               'message_id' => $message_id
                        ]
        );
    }
}
