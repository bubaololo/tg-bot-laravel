<?php

namespace App\Telegram;

class SendKeyboard extends TelegramResponce
{
    public string $message = '';
    public function index(...$buttons): object
    {
        $buttonsArray = [];
        foreach ($buttons as $button) {
            $buttonsArray[] = ['text' => $button];
        }
        return $this->http::post(
            self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => session('id'),
                'text' => $this->message,
                'parse_mode' => 'html',
                'reply_markup' => [
                    'resize_keyboard' => true,
                    'keyboard' => [
                        $buttonsArray
                    ]
                ],
            ]
        );
    }
}
