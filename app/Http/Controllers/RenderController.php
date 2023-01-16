<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use App\ImgRender\Carl;
use App\ImgRender\Monkey;
use App\ImgRender\YouCant;
use Illuminate\Support\Facades\Cache;

class RenderController extends Controller
{
    public static function img1($step)
    {
        switch ($step) {
            case 1:
                Telegram::sendMessage('Введите текст');
                Cache::tags([session('chat_id')])->put('step', 2);
                break;
            case 2:
                $img = YouCant::render(session('message'));
                Telegram::sendPhoto($img);
                Cache::tags([session('chat_id')])->flush();
                StartController::start();
        }
        
    }
    
    public static function img2($step)
    {
        switch ($step) {
            case 1:
                Telegram::sendMessage('Введите текст');
                Cache::tags([session('chat_id')])->put('step', 2);
                break;
            case 2:
                $img = Carl::render(session('message'));
                Telegram::sendPhoto($img);
                Cache::tags([session('chat_id')])->flush();
                StartController::start();
        }
        
    }
    
    public static function img3($step)
    {
        switch ($step) {
            case 1:
                Telegram::sendMessage('Введите текст');
                Cache::tags([session('chat_id')])->put('step', 2);
                break;
            case 2:
                $img = Monkey::render(session('message'));
                Telegram::sendPhoto($img);
                Cache::tags([session('chat_id')])->flush();
                StartController::start();
        }
        
    }
    
}
