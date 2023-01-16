<?php

namespace App\ImgRender;

use App\ImgRender\BaseClasses\SingleTextToImg;


class Carl extends SingleTextToImg
{
    public static int $initialFontSize = 120;
    public static string $image = 'carl.jpg';
    public static string $font = 'arial.ttf';
    public static int $marginLeft = 50;
    public static int $marginTop = 200;
    public static int $textWidth = 400;

}
