<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload de imagens</title>
</head>

<body>
  <form action="./upload.php" method="post" enctype="multipart/form-data">
    <p><input type="file" name="fotos[foto1]"></p>
    <p><input type="file" name="fotos[foto2]"></p>
    <!-- <p><input type="file" name="galeria[]" multiple></p> -->
    <button type="submit">Upload</button>
  </form>
</body>

</html>