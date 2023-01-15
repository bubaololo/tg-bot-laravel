<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContextRouter extends Controller
{
    public static function index()
    {
        
        switch (session('context')) {
            case 'img2':
                switch (session('step')) {
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
