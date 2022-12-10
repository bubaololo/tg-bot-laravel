<?php
namespace App\Telegram;
use Illuminate\Support\Facades\Http;

class TelegramResponce
{
    protected $http;
    protected $bot;
    public const url = 'https://api.telegram.org/bot';
    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->bot = env('BOT_TOKEN');
    }
}
