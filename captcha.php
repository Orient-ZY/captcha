<?php
/**
 * Created by PhpStorm.
 * User: zhouyang
 * Date: 16/11/26
 * Time: 下午5:04
 */

namespace captcha;


class captcha
{
    private $str = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $num;
    private $width;
    private $height;
    private $img;
    private $code;

    function __construct()
    {
        $this->num = 4;
        $this->width = 80;
        $this->height = 30;
    }

    private function createCode()
    {
        $length = strlen($this->str);
        for ($i=0; $i<$this->num; $i++)
        {
            $this->code .= $this->str[mt_rand(0, $length - 1)];
        }
    }

    private function createBG()
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(150,255), mt_rand(150,255), mt_rand(150,255));
        imagefill($this->img, 0, 0, $color);
    }

    private function createCaptcha()
    {
        $this->createCode();
        for ($i=0; $i<$this->num; $i++)
        {
            $font = mt_rand(3,5);
            $color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imagechar($this->img, $font, ($this->width / $this->num) * $i, mt_rand(10,$this->height-30), $this->code[$i], $color);

        }
    }

    private function createDisturb()
    {
        for ($i=0; $i<100; $i++)
        {
            $color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imagesetpixel($this->img, mt_rand(1,$this->width-2), mt_rand(1,$this->height-2), $color);
        }
        for ($i=0; $i<mt_rand(3,5); $i++)
        {
            $color = imagecolorallocate($this->img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imageline($this->img, 0, mt_rand(0, $this->height), $this->width, mt_rand(0,$this->height), $color);
        }
    }

    private function outputImg()
    {
        if (imagetypes() & IMG_JPG)
        {
            header('Content-type:image/jpeg');
            imagejpeg($this->img);
        } elseif (imagetypes() & IMG_PNG)
        {
            header('Content-type:image/png');
            imagepng($this->img);
        } elseif (imagetypes() & IMG_GIF)
        {
            header('Content-type:image/gif');
            imagegif($this->img);
        } else
        {
            die("Don't support this image type!");
        }
    }

    public function showCaptcha()
    {
        $this->createBG();
        $this->createCaptcha();
        $this->createDisturb();
        $this->outputImg();
    }

    public function getCode()
    {
        return strtoupper($this->code);
    }

    function __destruct()
    {
        imagedestroy($this->img);
    }
}