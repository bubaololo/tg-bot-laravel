<?php

namespace App\ImgRender\BaseClasses;

use Illuminate\Support\Facades\Storage;

class SingleTextToImg implements SingleTextToImgRenderInterface
{
    public static int $initialWrap = 40;
    public static int $initialFontSize = 80;
    public static string $image = 'monkey.jpg';
    public static string $font = 'arial.ttf';
    public static string $textFill = '#FFF';
    public static string $textStroke = 'black';
    public static int $marginLeft = 50;
    public static int $marginTop = 80;
    public static int $textWidth = 500;

    public static function render(string $text): string
    {
        $chars = mb_strlen($text);
        $wrap = static::$initialWrap;
        if ($chars > 60) { // 1.2
            $wrap = 50;
        }
        if ($chars > 150) { // 2.2
            $wrap = 69;
        }
        if ($chars > 200) { // 2.6
            $wrap = 78;
        }
        if ($chars > 250) { // 3.1
            $wrap = 80;
        }
        if ($chars > 350) { // 4.1
            $wrap = 85;
        }
        if ($chars > 400) { // 4.4
            $wrap = 90;
        }
        if ($chars > 500) { // 5.3
            $wrap = 95;
        }
        if ($chars > 650) { // 6.2
            $wrap = 105;
        }
        if ($chars > 1000) { // 8.3
            $wrap = 120;
        }

//        $wrap = $this->initialWrap + ($chars / 5);
//        $wrap = $chars/log($chars) + self::$initialWrap; //define where text would be wrapped

        $text = wordwrap($text, $wrap);
        $fz = static::$initialFontSize;
        $draw = new \ImagickDraw();
        $draw->setFillColor(static::$textFill);
        $draw->setStrokeColor(static::$textStroke);
        $draw->setStrokeWidth(1);
        $draw->setTextKerning(-1);
        $draw->setFont(Storage::path('fonts/' . static::$font));
//    $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFontSize($fz);
        $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
        $img->annotateImage($draw, static::$marginLeft, static::$marginTop, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];

        if ($textWidth > static::$textWidth) {
            $minFz = 0;
            $maxFz = static::$initialFontSize;
            while ($minFz <= $maxFz) {
                $mid = ($minFz + $maxFz) / 2;
                $mid = round($mid, 0, PHP_ROUND_HALF_UP);
                $status = static::textWidthMatch($mid, $draw, $text);
                if ($status) {
                    $maxFz = $mid - 1;
                } else {
                    $minFz = $mid + 1;
                }
            }

            $draw->setFontSize($minFz);
            unset($img);
            $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
            $img->annotateImage($draw, static::$marginLeft, static::$marginTop, 0, $text);
        }
        $img->setImageDepth(6);
// $img->setOption('png:compression-level', 1);
// $img->setOption('png:format', 'png16');
// $img->setOption('png:bit-depth', '4');
//    $img->setOption('png:color-type', 2);
// $img->setOption('png:bit-depth', 8);
// $img->setOption('png:color-type', 2);
        $fileName = uniqid();
        $img->writeImage(Storage::path("public/ready_imgs/" . $fileName . ".jpg"));
        unset($draw);
        unset($img);
        gc_collect_cycles();

        return env('APP_URL'). Storage::url("public/ready_imgs/" . $fileName . ".jpg");

    }

    private static function textWidthMatch($mid, $draw, $text): bool
    {
        $draw->setFontSize($mid);
        unset($img);
        $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
        $img->annotateImage($draw, static::$marginLeft, static::$marginTop, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];
        if (($textWidth) < static::$textWidth) {
            return false;
        } else return true;
    }

}
