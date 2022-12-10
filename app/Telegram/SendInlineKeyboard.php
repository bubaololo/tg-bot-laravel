<?php

namespace App\Telegram;

class SendInlineKeyboard extends TelegramResponce
{
    public string $message = 'k';
    public function index(...$buttons): object
    {
        $buttonsArray = [];
        foreach ($buttons as $button) {
            $buttonsArray[] = ['text' => $button, "callback_data" => $button];
        }
        return $this->http::post(
            self::url . $this->bot . '/sendMessage',
            [
                'chat_id' => session('id'),
                'text' => $this->message,
                'parse_mode' => 'html',
                'reply_markup' => [
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        $buttonsArray
                    ]
                ],
            ]
        );
    }
}
