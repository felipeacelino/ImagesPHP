<?php

/* error_reporting(0);
ini_set('display_errors', 0); */

require 'vendor/autoload.php';
require 'Uploads.class.php';

$path = dirname(__FILE__);
$upPath = $path . '/uploads';
$image = $path . '/image.jpg';

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
    'quality' => 80,
  ],
  [
    'width' => 150,
    'height' => 150,
    'mode' => 'crop',
    'quality' => 80,
  ],
];

$uploads = new Uploads();
$uploads->setMaxFileSize(2);
$uploads->setAllowedExtensions(['jpg', 'png']);

echo '<pre>';
//print_r($uploads->createThumb($image, $upPath, 'auto', 1200, 0, 100));
print_r($uploads->createThumbs($image, $upPath, $thumbs));
//print_r($uploads->getError());
/* print_r($uploads->createThumb($image, $upPath, 'crop', 500, 500, 80));
print_r($uploads->createThumb($image, $upPath, 'crop', 150, 150, 80)); */
echo '</pre>';

/* if ($uploads->uploadFile($_FILES['foto'], $upPath)) {
  echo 'Success: ' . $uploads->getUploadedFile();
} else {
  echo $uploads->getError();
} */

//echo $uploads->removeFile($upPath . '/file.jpg');

/* echo '<pre>';
print_r($_FILES);
echo '</pre>'; */

/* echo '<pre>';
print_r($uploads->normalizeArray());
echo '</pre>'; */

/* echo '<pre>';
print_r(pathinfo($_FILES['fotos']['tmp_name'][0]));
echo '</pre>'; */

/* echo '<pre>';
print_r($uploads->generateFileName('foto'));
echo '</pre>'; */
