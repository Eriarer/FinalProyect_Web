<?php
session_start();
$FONTPATH = __DIR__ . '/../../media/fonts/COMICATE.TTF';
$TARGETDIR = __DIR__ . '/../../media/images/captcha/captcha.jpg';
$WIDTH = 200;
$HEIGHT = 50;
$LINES = rand(5, 7);
$ANGLE = 25;
$FREQUENCY_X = 20;
$AMPLITUDE_X = 1;
$FREQUENCY_Y = 5;
$AMPLITUDE_Y = 1;

$text = captchaText(6);
// guardar el texto en la sesión
$_SESSION['captcha'] = implode('', $text);
// guardar la sesión para que se actualice el valor de $_SESSION['captcha']
session_write_close();

$image = imagecreatetruecolor($WIDTH, $HEIGHT);
// asignar un color de fondo
$color_component = getColorForImage($image, 210, 255);
// dibujar un rectángulo relleno
imagefilledrectangle($image, 0, 0, $WIDTH, $HEIGHT, $color_component);
//agregarle el texto
for ($i = 0; $i < count($text); $i++) {
  $color_component = getColorForImage($image, 0, 100);
  imagettftext($image, 30, getRandomAngle($ANGLE), 15 + ($i * 30), 40, $color_component, $FONTPATH, $text[$i]);
}

// agregar lineas a la imagen
for ($i = 0; $i < $LINES; $i++) {
  $color_component = getColorForImage($image, 0, 100);
  imagearc($image, mt_rand(0, $WIDTH), mt_rand(0, $HEIGHT), mt_rand(0, $WIDTH), mt_rand(0, $HEIGHT), mt_rand(0, 360), mt_rand(0, 360), $color_component);
}

// agregar warped image
for ($x = 0; $x < $WIDTH; $x++) {
  for ($y = 0; $y < $HEIGHT; $y++) {
    $index = imagecolorat($image, $x, $y);
    $color_component = imagecolorsforindex($image, $index);

    $color = imagecolorallocate($image, $color_component['red'], $color_component['green'], $color_component['blue']);

    $imageX = $x + sin($y / $FREQUENCY_X) * $AMPLITUDE_X;
    $imageY = $y + sin($x / $FREQUENCY_Y) * $AMPLITUDE_Y;
    imagesetpixel($image, $imageX, $imageY, $color);
  }
}


// Agregarle blur
imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);

// guardar la imagen
imagejpeg($image, $TARGETDIR, 100);
imagejpeg($image);
imagedestroy($image);


function captchaText($length) {
  $pattern = '123456789abcdefghijklmnopqrstuvwxzABCDEFGHIJKLMNOPQRSTUVWXZ';
  $max = strlen($pattern) - 1;
  $captcha = [];
  for ($i = 0; $i < $length; $i++) {
    $captcha[] = $pattern[mt_rand(0, $max)];
  }
  return $captcha;
}

function getColorForImage($image, $min, $max) {
  // crear el objeto de color
  return imagecolorallocate($image, mt_rand($min, $max), mt_rand($min, $max), mt_rand($min, $max));
}

function getRandomAngle($angle) {
  return mt_rand(-$angle, $angle);
}
