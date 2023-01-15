<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContextRouter extends Controller
{
    public static function index($context)
    {
        
        switch ($context) {
            case 'img2':
                switch (Cache::tags([session('chat_id')])->get('step')) {
                    case 1:
                        RenderController::img2(1);
                        break;
                    case 2:
                        RenderController::img2(2);
                }
//                break;
        }
        
        
    }
}
