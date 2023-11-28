<?php
session_start();
$FONTPATH = __DIR__ . '/../../media/fonts/leadcoat.TTF';
$TARGETDIR = __DIR__ . '/../../media/images/captcha/';
//contar cuantos archivos hay en el directorio que no sean empty
$files = array_diff(scandir($TARGETDIR), ['.', '..', 'empty']);
//destruir lo archivos con una antiguedad mayor a 2 minutos
foreach ($files as $file) {
  $file = $TARGETDIR . $file;
  if (filemtime($file) < time() - 30) {
    unlink($file);
  }
}
// conseguir el numero mas pequeño que no este en uso
$files = array_diff(scandir($TARGETDIR), ['.', '..', 'empty']);
foreach ($files as $file) {
  $fileParts = explode('.', $file);
  $fileNumber = (int)$fileParts[0];
  $usedNumbers[$fileNumber] = true;
}

$fileNumber = 1;
while (isset($usedNumbers[$fileNumber])) {
  $fileNumber++;
}
$TARGETFILE = $TARGETDIR . $fileNumber . '.jpg';
// variables para el captcha
$TEXTLENGTH = 6;
$WIDTH = 200;
$HEIGHT = 100;
$LINES = rand(6, 10);
$ANGLE = 10;
$FREQUENCY_X = 70;
$AMPLITUDE_X = 20;
$FREQUENCY_Y = 15;
$AMPLITUDE_Y = 10;

// generar cadena de texto
$text = captchaText($TEXTLENGTH);

//inicializar la imagen
$image = imagecreatetruecolor($WIDTH, $HEIGHT);
$backgroundColor = getRandomRGB_Color(210, 255);
// asignar un color de fondo
$color_component = getColorForImage($image, $backgroundColor);
// dibujar un rectángulo relleno
imagefilledrectangle($image, 0, 0, $WIDTH, $HEIGHT, $color_component);
//agregarle el texto
for ($i = 0; $i < count($text); $i++) {
  $textColor = getRandomRGB_Color(0, 100);
  $textImageColor = getColorForImage($image, $textColor);
  imagettftext($image, 30, getRandomAngle($ANGLE), ($i * 30), 70, $textImageColor, $FONTPATH, $text[$i]);
}


// agregar lineas a la imagen
for ($i = 0; $i < $LINES; $i++) {
  $lineColor = getRandomRGB_Color(0, 100);
  $lineColorImg = getColorForImage($image, $lineColor);
  imagearc($image, mt_rand(0, $WIDTH), mt_rand(0, $HEIGHT), mt_rand(0, $WIDTH), mt_rand(0, $HEIGHT), mt_rand(0, 360), mt_rand(0, 360), $lineColorImg);
}

// distorsionar la imagen Y
//clonar la imagen
$wrapped_image = imagecreatetruecolor($WIDTH, $HEIGHT);
//ponerle el color de fondo
imagefill($wrapped_image, 0, 0, getColorForImage($wrapped_image, $backgroundColor));
for ($x = 0; $x < $WIDTH; $x++) {
  for ($y = 0; $y < $HEIGHT; $y++) {
    $index = imagecolorat($image, $x, $y);
    $rgb = imagecolorsforindex($image, $index);
    $newX = $x;
    $newY = $y + (sin($x / $FREQUENCY_Y) * $AMPLITUDE_Y);
    imagesetpixel($wrapped_image, $newX, $newY, getColorForImage($wrapped_image, [$rgb['red'], $rgb['green'], $rgb['blue']]));
  }
}
// distorsionar la imagen X
//clonar la imagen
$wrapped_image2 = imagecreatetruecolor($WIDTH, $HEIGHT);
//ponerle el color de fondo
imagefill($wrapped_image2, 0, 0, getColorForImage($wrapped_image2, $backgroundColor));
for ($x = 0; $x < $WIDTH; $x++) {
  for ($y = 0; $y < $HEIGHT; $y++) {
    $index = imagecolorat($wrapped_image, $x, $y);
    $rgb = imagecolorsforindex($wrapped_image, $index);
    $newX = $x + (sin($y / $FREQUENCY_X) * $AMPLITUDE_X);
    $newY = $y;
    imagesetpixel($wrapped_image2, $newX, $newY, getColorForImage($wrapped_image2, [$rgb['red'], $rgb['green'], $rgb['blue']]));
  }
}

// Agregarle blur
imagefilter($wrapped_image2, IMG_FILTER_GAUSSIAN_BLUR);

// Guardar la imagen
imagejpeg($wrapped_image2, $TARGETFILE, 100);
// Destruir las imágenes
imagedestroy($image);
imagedestroy($wrapped_image);
imagedestroy($wrapped_image2);

//crear un vector con el texto del captcha y la ruta de la imagen
$captcha = [
  'text' => implode('', $text),
  'image' => $fileNumber . '.jpg'
];
$captcha = json_encode($captcha);
echo $captcha;




// funciones
function captchaText($length) {
  $pattern = '123456789ABCDEFGHIJKLMNOPQRSTUVWXZ';
  $max = strlen($pattern) - 1;
  $captcha = [];
  for ($i = 0; $i < $length; $i++) {
    $captcha[] = $pattern[mt_rand(0, $max)];
  }
  return $captcha;
}

function getRandomRGB_Color($min, $max) {
  $red = mt_rand($min, $max);
  $green = mt_rand($min, $max);
  $blue = mt_rand($min, $max);
  return $color = [$red, $green, $blue];
}
function getColorForImage($image, $color) {
  // crear el objeto de color
  return imagecolorallocate($image, $color[0], $color[1], $color[2]);
}

function getRandomAngle($angle) {
  return mt_rand(-$angle, $angle);
}
