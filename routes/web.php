<?php

use Illuminate\Support\Facades\Route;
use App\ImgRender\BaseClasses\DoubleTextToImg;
use App\ImgRender\BaseClasses\SingleTextToImg;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('img/', function () {
$img = new DoubleTextToImg;
 return $img->render('Сначала потестить на мелкой сумме','вьебать сразу все бабки');
});
