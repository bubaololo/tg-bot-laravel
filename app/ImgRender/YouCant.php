<?php

namespace App\ImgRender;

use App\ImgRender\BaseClasses\SingleTextToImg;


class YouCant extends SingleTextToImg
{
    public static int $initialFontSize = 100;
    public static string $image = 'cant.jpg';
    public static string $font = 'impact.ttf';
    public static int $marginLeft = 100;
    public static int $marginTop = 600;
    public static int $textWidth = 800;

}
