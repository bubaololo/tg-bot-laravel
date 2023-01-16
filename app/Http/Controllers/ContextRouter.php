<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContextRouter extends Controller
{
    public static function index($context)
    {
        
        switch ($context) {
            case 'img1':
                switch (Cache::tags([session('chat_id')])->get('step')) {
                    case 1:
                        RenderController::img1(1);
                        break;
                    case 2:
                        RenderController::img1(2);
                }
                break;
            case 'img2':
                switch (Cache::tags([session('chat_id')])->get('step')) {
                    case 1:
                        RenderController::img2(1);
                        break;
                    case 2:
                        RenderController::img2(2);
                }
                break;
            case 'img3':
                switch (Cache::tags([session('chat_id')])->get('step')) {
                    case 1:
                        RenderController::img3(1);
                        break;
                    case 2:
                        RenderController::img3(2);
                }
                break;
            case 'img4':
                switch (Cache::tags([session('chat_id')])->get('step')) {
                    case 1:
                        RenderController::img4(1);
                        break;
                    case 2:
                        RenderController::img4(2);
                        break;
                    case 3:
                        RenderController::img4(3);
                }
            
        }
        
        
    }
}
