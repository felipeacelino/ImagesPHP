<?php

error_reporting(0);
ini_set('display_errors', 0);

require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$path = dirname(__FILE__);
$upPath = $path . '/uploads';
$image = $path . '/image.jpg';
$imageLg = $path . '/image_lg.jpg';
$manager = new ImageManager();

$thumbs = [
  [
    'width' => 1200,
    'height' => 0,
    'mode' => 'auto',
    'quality' => 100,
  ],
  [
    'width' => 500,
    'height' => 500,
    'mode' => 'crop',
  ],
  [
    'width' => 150,
    'height' => 150,
    'mode' => 'crop',
    'quality' => 80,
  ],
];

function createThumb($image, $upPath, $mode = 'crop', $width, $height, $quality = 90) {
  $manager = new ImageManager();
  $thumb = $manager->make($image);
  if ($mode == 'crop') {
    if (!$width || !$height) {
      return false;
    }
    $thumb->fit($width, $height);
  }
  if ($mode == 'auto') {
    if (!$width) {
      return false;
    }
    $height = 0;
    $thumb->widen($width);
  }
  $thumbName = 'thumb-' . $width . 'x' . $height . '.jpg';
  $thumbFile = $upPath . '/' . $thumbName;
  $quality = !$quality ? 90 : $quality;
  $thumb->save($thumbFile, $quality);

  return true;
}
//createThumb($image, $upPath, 'crop', 250, 250, 80);

function createThumbs($image, $upPath, $thumbs) {
  foreach ($thumbs as $thumb) {
    //$quality = $thumb['quality'] ? $thumb['quality'] : $thumb['quality'];
    createThumb($image, $upPath, $thumb['mode'], $thumb['width'], $thumb['height'], $thumb['quality']);
  }
}

createThumbs($image, $upPath, $thumbs);

/* function foo($foo = 50) {
  echo $foo;
}

foo(null); */
