<?php
/**
 * Created by PhpStorm.
 * User: zhouyang
 * Date: 16/11/26
 * Time: 下午5:38
 */

//session_start();
include_once 'captcha.php';

$captcha = new \captcha\captcha();
$captcha->showCaptcha();

//$_SESSION['captcha_session'] = $captcha->getCode();