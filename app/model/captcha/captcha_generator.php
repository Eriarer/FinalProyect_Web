<?php
session_start();
$FONTPATH = __DIR__ . '/../../media/fonts/COMICATE.TTF';
$WIDT = 200;
$HEIGHT = 50;
$LINES = 3;

$text = captchaText(6);
// guardar el texto en la sesión
$_SESSION['captcha'] = implode('', $text);
// guardar la sesión para que se actualice el valor de $_SESSION['captcha']
session_write_close();

$image = imagecreatetruecolor($WIDT, $HEIGHT);
// asignar un color de fondo
$color = getRandColor($image, 210, 255);
// dibujar un rectángulo relleno
imagefilledrectangle($image, 0, 0, $WIDT, $HEIGHT, $color);
//agregarle el texto
for ($i = 0; $i < count($text); $i++) {
  $color = getRandColor($image, 0, 100);
  imagettftext($image, 30, getRandomAngle(), 15 + ($i * 30), 40, $color, $FONTPATH, $text[$i]);
}
// agregarle líneas de izquierda a derecha de la imagen
for ($i = 0; $i < $LINES; $i++) {
  $color = getRandColor($image, 0, 100);
  imageline($image, 0, mt_rand(0, $HEIGHT), $WIDT, mt_rand(0, $HEIGHT), $color);
}

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
  return mt_rand(-30, 30);
}
