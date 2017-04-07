<?php

namespace JP\Sistema\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile as File;

class ArquivoService
{
    public static function carregarImagem(File $arquivo)
    {
/*
  private 'originalName' => string 'IMG-20150702-WA0003.jpg' (length=23)
  private 'mimeType' => string 'image/jpeg' (length=10)
  private 'size' => int 97098
  private 'error' => int 0
  private 'pathName' (SplFileInfo) => string '/tmp/phpAoWe9U' (length=14)
  private 'fileName' (SplFileInfo) => string 'phpAoWe9U' (length=9)
*/
        $fileName = $arquivo->getClientOriginalName();
        $fileType = $arquivo->getClientOriginalExtension();
        $fileMime = $arquivo->getClientMimeType();
        // Check if image file is a actual image or fake image
        $check = explode("/", $fileMime);
        if ($check[0] == 'image') {
            //echo "File is an image {$fileType} - ";
            $uploadOk = 1;
            // Allow certain file formats
            $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp");
            if (in_array($check[1], $allowedExts)) {
                echo "Sorry, only BMP, JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check file size
        if ($arquivo->getClientSize() > $arquivo->getMaxFilesize()) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
        // if everything is ok, try to upload file
        } else {
            $arquivo->move(__DIR__.'/../../../../../data/img/', $arquivo->getClientOriginalName());
            if ($arquivo->isValid()) {
                return __DIR__."/../../../../../data/img/{$arquivo->getClientOriginalName()}.{$fileType}";
            } else {
                echo "Erro ao carregar o arquivo - {$arquivo->getError()}";
            }
            
        }

    }
}
