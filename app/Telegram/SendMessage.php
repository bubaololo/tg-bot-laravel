<?php

namespace App\Telegram;

class SendMessage extends TelegramResponce
{
    public function index($message)
    {
        $this->http::post(
            self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => session('id'),
                'text' => $message,
                'parse_mode' => 'html',
            ]
        );
    }
}
