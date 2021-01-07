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
    'width' => 500,
    'height' => 500,
    'mode' => 'crop',
    'quality' => 90,
  ],
  [
    'width' => 150,
    'height' => 150,
    'mode' => 'crop',
    'quality' => 90,
  ],
];

$uploads = new Uploads();
$uploads->setMaxFileSize(2);
$uploads->setAllowedExtensions(['jpg', 'png']);

if ($uploads->uploadFiles('fotos', $upPath)) {
  //if (1 > 0) {
  /*  echo '<pre>';
   print_r($uploads->removeEmptys($uploads->normalizeArray()['fotos']));
   echo '</pre>'; */
  $arquivoAntigo = $upPath . '/c42ca863807bd718b96d9a25b5dd051e.jpg';
  foreach ($uploads->getUploadedFiles() as $image) {
    if ($uploads->createThumbs($upPath . '/' . $image, $upPath, $thumbs)) {
      $uploads->removeAllFiles($arquivoAntigo);
      echo 'Success: ' . $image . '<br>';
    } else {
      echo $uploads->getError();
    }
  }
  /* if ($uploads->createThumbs($upPath . '/' . $uploads->getUploadedFile(), $upPath, $thumbs)) {
    echo 'Success: ' . $uploads->getUploadedFiles();
  } else {
    echo $uploads->getError();
  }
  echo '<pre>';
  print_r($uploads->getUploadedFiles());
  echo '</pre>'; */
} else {
  echo $uploads->getError();
}

/* echo '<pre>';
print_r($uploads->uploadFiles('fotos', $upPath));
echo '</pre>'; */

//echo $uploads->removeFile($upPath . '/file.jpg');

//$uploads->removeAllFiles($upPath . '/image.jpg');

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
