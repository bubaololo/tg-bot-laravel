<?php

namespace App\Http\Controllers;

use App\Facades\Telegram;
use App\ImgRender\Carl;
use Illuminate\Http\Request;

class RenderController extends Controller
{
    public static function img2($step)
    {
        switch ($step) {
            case 1:
                Telegram::sendMessage('Введите текст');
                session(['step' => 2]);
                break;
            case 2:
                $img = Carl::render('техт из сообщения');
                Telegram::sendPhoto($img);
                session()->forget('step');
                session()->forget('context');
                StartController::start();
        }
        
    }
    
}
