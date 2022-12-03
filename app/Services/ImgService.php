<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImgService
{
//    public function __constructor()
//    {
//
//    }


    public function textToImg($str = 'восимь лет!') :void
    {
        $wrap = 40;
        $chars = mb_strlen($str);

        if ($chars > 60) {
            $wrap = 50;
        }

        if ($chars > 150) {
            $wrap = 69;
        }
        if ($chars > 200) {
            $wrap = 78;
        }
        if ($chars > 250) {
            $wrap = 80;
        }
        if ($chars > 350) {
            $wrap = 85;
        }
        if ($chars > 400) {
            $wrap = 90;
        }
        if ($chars > 500) {
            $wrap = 95;
        }
        if ($chars > 650) {
            $wrap = 105;
        }
        if ($chars > 1000) {
            $wrap = 120;
        }
        $text = wordwrap($str, $wrap);
        $fz = 80;
        $draw = new \ImagickDraw();
        $draw->setFillColor('#FFF');
        $draw->setStrokeColor('black');
        $draw->setStrokeWidth(1);
        $draw->setTextKerning(-1);
        $draw->setFont(Storage::path('fonts/arial.ttf'));
//    $draw->setGravity(Imagick::GRAVITY_CENTER);
        $draw->setFontSize($fz);
        $img = new \Imagick(Storage::path('reference_imgs/monkey.jpg'));
        $img->annotateImage($draw, 50, 60, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];

        if ($textWidth > 500) {
            $minFz = 0;
            $maxFz = 80;
            while ($minFz <= $maxFz) {
                $mid = ($minFz + $maxFz) / 2;
                $mid = round($mid, 0, PHP_ROUND_HALF_UP);
                $status = isOk($mid);
                if ($status) {
                    $maxFz = $mid - 1;
                } else {
                    $minFz = $mid + 1;
                }
            }

            $draw->setFontSize($minFz);
            unset($img);
            $img = new \Imagick(Storage::path('reference_imgs/monkey.jpg'));
            $img->annotateImage($draw, 50, 60, 0, $text);
        }
        $img->setImageDepth(6);
// $img->setOption('png:compression-level', 1);
// $img->setOption('png:format', 'png16');
// $img->setOption('png:bit-depth', '4');
//    $img->setOption('png:color-type', 2);
// $img->setOption('png:bit-depth', 8);
// $img->setOption('png:color-type', 2);
        $fileName = uniqid();
        $img->writeImage(Storage::path("ready_imgs/" . $fileName . ".jpg"));
        unset($draw);
        unset($img);
        gc_collect_cycles();


//        $method = 'sendPhoto';
//        $send_data = [
//            'photo' => "https://cybercopy.ru/my-apps/bots/monkeybot/img/" . $fileName . ".jpg",
//        ];
    }

    function isOk($mid)
    {
        global $draw, $text, $img;
        $draw->setFontSize($mid);
        unset($img);
        $img = new \Imagick(Storage::path('reference_imgs/monkey.jpg'));
        $img->annotateImage($draw, 50, 60, 0, $text);
        $textWidth = $img->queryFontMetrics($draw, $text)['textWidth'];
        if (($textWidth) < 500) {
            return false;
        } else return true;
    }

}
