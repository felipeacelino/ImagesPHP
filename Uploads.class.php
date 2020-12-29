<?php

use Intervention\Image\ImageManager;

class Uploads {
  // Limite de tamanho do arquivo (MB)
  private $maxFileSize = 10;
  // Extensões permitidas
  private $allowedExtensions = [];
  // Arquivo enviado
  private $uploadedFile;
  // Mantém o nome original do arquivo
  private $keepFileName = false;
  // Mensagem de erro
  private $error;

  // Construtor
  public function __construct() {
  }

  // Seta o limite de tamanho do arquivo
  public function setMaxFileSize($maxFileSize) {
    $this->maxFileSize = $maxFileSize;
  }

  // Seta as extensões permitidas
  public function setAllowedExtensions($allowedExtensions) {
    $this->allowedExtensions = $allowedExtensions;
  }

  // Obtém a extensão do arquivo
  public function getFileExtension($fileName) {
    return pathinfo($fileName, PATHINFO_EXTENSION);
  }

  // Obtém o nome do arquivo (Sem a extensão)
  public function getFileName($fileName) {
    return pathinfo($fileName, PATHINFO_FILENAME);
  }

  // Gera um nome aleatório para o arquivo
  public function generateFileName($fileName) {
    return md5($fileName . time());
  }

  // Obtém o arquivo enviado (Sucesso)
  public function getUploadedFile() {
    return $this->uploadedFile;
  }

  // Converte o tamanho do arquivo para MB
  public function getSizeMB($fileSize) {
    return ceil($fileSize / 1048576);
  }

  // Remove um arquivo
  public function removeFile($file) {
    if (file_exists($file)) {
      return unlink($file);
    }

    return false;
  }

  // Limpa o nome do arquivo
  public function slugFileName($fileName) {
    $fileName = preg_replace('~[^\pL\d]+~u', '-', $fileName);
    $fileName = iconv('utf-8', 'us-ascii//TRANSLIT', $fileName);
    $fileName = preg_replace('~[^-\w]+~', '', $fileName);
    $fileName = trim($fileName, '-');
    $fileName = preg_replace('~-+~', '-', $fileName);
    $fileName = strtolower($fileName);
    if (empty($fileName)) {
      return 'n-a';
    }

    return $fileName;
  }

  // Padroniza o array de arquivos para uma forma mais simples
  public function normalizeArray() {
    $out = [];
    foreach ($_FILES as $key => $file) {
      if (isset($file['name']) && is_array($file['name'])) {
        $new = [];
        foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $k) {
          array_walk_recursive($file[$k], function (&$data, $key, $k) {
            $data = [$k => $data];
          }, $k);
          $new = array_replace_recursive($new, $file[$k]);
        }
        $out[$key] = $new;
      } else {
        $out[$key] = $file;
      }
    }

    return $out;
  }

  // Retorna a mensagem de erro
  public function getError() {
    return 'Erro: ' . $this->error;
  }

  // Retorna a mensagem de erro com base no código
  public function getErrorMessage($errorCode) {
    $errorsList = [
      0 => 'Não houve erro, o upload foi bem sucedido.',
      1 => 'O arquivo enviado excede o limite definido na diretiva UPLOAD_MAX_FILESIZE.',
      2 => 'O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.',
      3 => 'O upload do arquivo foi feito parcialmente.',
      4 => 'Nenhum arquivo foi enviado.',
      6 => 'Pasta temporária ausênte.',
      7 => 'Falha em escrever o arquivo em disco.',
      8 => 'Uma extensão do PHP interrompeu o upload do arquivo.',
    ];

    return $errorsList[$errorCode];
  }

  // Verifica se o arquivo é válido
  public function isFileValid($file) {
    // Verifica se o arquivo possui algum erro
    if ($file['error'] != 0) {
      $this->error = $this->getErrorMessage($file['error']);

      return false;
    }

    // Verifica se tamanho excede o limite
    if ($this->getSizeMB($file['size']) > $this->maxFileSize) {
      $this->error = 'O arquivo excede o limite de ' . $this->maxFileSize . ' MB';

      return false;
    }

    // Verifica se a extensão é permitida
    if (count($this->allowedExtensions) > 0 && !in_array($this->getFileExtension($file['name']), $this->allowedExtensions)) {
      $this->error = 'O tipo do arquivo é inválido.';

      return false;
    }

    return true;
  }

  // Realiza o upload de um arquivo
  public function uploadFile($file, $destPath) {
    $fileExtension = $this->getFileExtension($file['name']);
    $fileName = $this->getFileName($file['name']);
    $fileName = $this->keepFileName ? $this->slugFileName($fileName) : $this->generateFileName($fileName);
    $fileName = $fileName . '.' . $fileExtension;
    // Verifica se o arquivo é válido
    if (!$this->isFileValid($file)) {
      return false;
    }
    // Cria o diretório caso o mesmo não exista
    if (!file_exists($destPath)) {
      mkdir($destPath, 0755, true);
    }
    // Verifica se o diretório foi criado e se é válido
    if (!is_dir($destPath)) {
      $this->error = 'Não foi possível criar o diretório ou o mesmo é inválido.';

      return false;
    }
    // Verifica se o diretório possui permissão de escrita
    if (!is_writable($destPath)) {
      $this->error = 'O diretório não possui permissão de escrita.';

      return false;
    }
    if (move_uploaded_file($file['tmp_name'], $destPath . '/' . $fileName)) {
      $this->uploadedFile = $fileName;

      return true;
    }
    $this->error = 'Não foi possível realizar o upload do arquivo.';

    return false;
  }

  // Cria uma thumb
  public function createThumb($image) {
    $manager = new ImageManager();
  }
}
