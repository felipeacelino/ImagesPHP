<?php

/* error_reporting(0);
ini_set('display_errors', 0); */

require 'vendor/autoload.php';
require 'Uploads.class.php';

use Intervention\Image\ImageManager;

$path = dirname(__FILE__);
$upPath = $path . '/uploads';
$image = $path . '/image.jpg';
$imageLg = $path . '/image_lg.jpg';
$manager = new ImageManager();
//$manager->make($image)->resize(300, 300)->save($upPath . '/thumb.jpg');

$uploads = new Uploads();
$uploads->setMaxFileSize(2);
$uploads->setAllowedExtensions(['jpg', 'png']);
if ($uploads->uploadFile($_FILES['foto'], $upPath)) {
  echo 'Success: ' . $uploads->getUploadedFile();
} else {
  echo $uploads->getError();
}

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
