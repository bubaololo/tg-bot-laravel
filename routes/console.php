<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('img', function () {
   $img = app()->make('App\Services\Carl');

   info(app()->call([$img, 'renderImage'], ['text' => 'восимь лет!']));
})->purpose('generate an image');

Artisan::command('d_img', function () {
    $d_img = app()->makeWith(\App\Services\DoubleTextToImg::class, ['text1'=>'текст1', 'text2'=>'второй текст']);
   info(app()->call([$d_img, 'render']));
})->purpose('generate an image');




