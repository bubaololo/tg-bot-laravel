<?php

namespace App\ImgRender\BaseClasses;

interface DoubleTextToImgRenderInterface
{
    public function render(string $text1, string $text2): string;
}
