<?php
$base = '';
$CONFIG = array(
  'base_url' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/',
  'P_app' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/',
  'P_model' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/model/',
  'P_view' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] .  $base . '/app/view/',
  'P_media' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/media/',
  'P_fonts' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] .  $base . '/app/media/fonts/',
  'P_images' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/media/images/',
  'P_products' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/media/images/productos/',
  'P_multimedia' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/media/multimedia/',
  'P_css' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/view/css/',
  'P_php' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/view/html_php/',
  'P_js' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/view/js/',
  'P_lib' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $base . '/app/view/lib/'
);
