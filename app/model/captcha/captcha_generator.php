<?php
session_start();
$FONTPATH = __DIR__ . '/../../media/fonts/COMICATE.TTF';
$WIDT = 200;
$HEIGHT = 50;

$text = captchaText(6);

$image = imagecreatetruecolor($WIDT, $HEIGHT);
// asignar un color de fondo
$color = getRandColor($image, 200, 255);
// dibujar un rectángulo relleno
imagefilledrectangle($image, 0, 0, $WIDT, $HEIGHT, $color);
//agregarle el texto
imagettftext($image, 20, getRandomAngle(), 50, 40, getRandColor($image, 0, 100), $FONTPATH, implode('', $text));

header('Content-type: image/jpeg');
imagejpeg($image);
imagedestroy($image);


function captchaText($length) {
  $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $max = strlen($pattern) - 1;
  $captcha = [];
  for ($i = 0; $i < $length; $i++) {
    $captcha[] = $pattern[mt_rand(0, $max)];
  }
  return $captcha;
}

function getRandColor($image, $min, $max) {
  // crear el objeto de color
  return imagecolorallocate($image, mt_rand($min, $max), mt_rand($min, $max), mt_rand($min, $max));
}

function getRandomAngle() {
  return mt_rand(-20, 20);
}
