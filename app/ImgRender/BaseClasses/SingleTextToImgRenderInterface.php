<?php

namespace App\ImgRender\BaseClasses;

interface SingleTextToImgRenderInterface
{
    public static function render(string $text): string;
}
