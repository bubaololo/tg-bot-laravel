<?php

namespace App\ImgRender\BaseClasses;

use Illuminate\Support\Facades\Storage;

class DoubleTextToImg implements DoubleTextToImgRenderInterface
{
    public static int $initialWrap = 20;
    public static int $initialFontSize = 60;
    public static string $image = 'drake.png';
    public static string $font = 'arial.ttf';
    public static string $textFill = 'black';
    public static string $textStroke = 'none';
    public static int $marginLeft1 = 280;
    public static int $marginTop1 = 50;
    public static int $textWidth = 150;
    public static int $marginLeft2 = 280;
    public static int $marginTop2 = 280;
    public string $text1;
    public string $text2;
    public $tempImg;

    public function __constructor($text1, $text2)
    {
        $this->text1 = $text1;
        $this->text2 = $text2;
    }

    public function render( string $text1, string $text2): string
    {
        $this->renderImage1($text1);
        return $this->renderImage2($text2);
    }


    public function renderImage1($text): void
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

        $text = wordwrap($text, $wrap);
        $fz = static::$initialFontSize;
        $draw = new \ImagickDraw();
        $draw->setFillColor(static::$textFill);
        $draw->setStrokeColor(static::$textStroke);
        $draw->setStrokeWidth(1);
        $draw->setTextKerning(-1);
        $draw->setFont(Storage::path('fonts/' . static::$font));
//    $draw->setGravity(\Imagick::GRAVITY_CENTER);
        $draw->setFontSize($fz);
        $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
        $img->annotateImage($draw, static::$marginLeft1, static::$marginTop1, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];

        if ($textWidth > static::$textWidth) {
            $minFz = 0;
            $maxFz = static::$initialFontSize;
            while ($minFz <= $maxFz) {
                $mid = ($minFz + $maxFz) / 2;
                $mid = round($mid, 0, PHP_ROUND_HALF_UP);
                $status = static::textWidthMatch1($mid, $draw, $text);
                if ($status) {
                    $maxFz = $mid - 1;
                } else {
                    $minFz = $mid + 1;
                }
            }

            $draw->setFontSize($minFz);
            unset($img);
            $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
            $img->annotateImage($draw, static::$marginLeft1, static::$marginTop1, 0, $text);
        }
        $img->setImageDepth(6);


        $this->tempImg = $img;

    }

    public function renderImage2($text): string
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
//        $wrap = $chars / log($chars) + self::$initialWrap; //define where text would be wrapped

        $text = wordwrap($text, $wrap);
    
        $fz = static::$initialFontSize;
        $draw = new \ImagickDraw();
        $draw->setFillColor(static::$textFill);
        $draw->setStrokeColor(static::$textStroke);
        $draw->setStrokeWidth(1);
        $draw->setTextKerning(-1);
        $draw->setFont(Storage::path('fonts/' . static::$font));
//    $draw->setGravity(\Imagick::GRAVITY_CENTER);
        $draw->setFontSize($fz);
        $img = $this->tempImg;
//        $img->annotateImage($draw, static::$marginLeft2, static::$marginTop2, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];
        
        if ($textWidth > static::$textWidth) {
            $minFz = 0;
            $maxFz = static::$initialFontSize;
            while ($minFz <= $maxFz) {
                $mid = ($minFz + $maxFz) / 2;
                $mid = round($mid, 0, PHP_ROUND_HALF_UP);
                $status = static::textWidthMatch2($mid, $draw, $text);
        
                if ($status) {
                    $maxFz = $mid - 1;
                } else {
                    $minFz = $mid + 1;
                }
            }
            $fz = $minFz;
        }
            $draw->setFontSize($fz);
            unset($img);
            $img = $this->tempImg;
            $img->annotateImage($draw, static::$marginLeft2, static::$marginTop2, 0, $text);
        
        $img->setImageDepth(6);

        $fileName = uniqid();
        $img->writeImage(Storage::path("public/ready_imgs/" . $fileName . ".jpg"));
        unset($draw);
        unset($img);
        gc_collect_cycles();

        return env('APP_URL') . Storage::url("public/ready_imgs/" . $fileName . ".jpg");
    }

    private static function textWidthMatch1($mid, $draw, $text): bool
    {
        $draw->setFontSize($mid);
        unset($img);
        $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
        $img->annotateImage($draw, static::$marginLeft1, static::$marginTop1, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];
        if (($textWidth) < static::$textWidth) {
            return false;
        } else return true;
    }

    private static function textWidthMatch2($mid, $draw, $text): bool
    {
        $draw->setFontSize($mid);
        unset($img);
        $img = new \Imagick(Storage::path('reference_imgs/' . static::$image));
        $img->annotateImage($draw, static::$marginLeft2, static::$marginTop2, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];
        if (($textWidth) < static::$textWidth) {
            return false;
        } else return true;
    }

}
