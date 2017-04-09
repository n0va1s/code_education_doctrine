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
        $filePath = __DIR__.'/../../../../data/img/';
        $fileName = $arquivo->getClientOriginalName();
        $fileType = $arquivo->getClientOriginalExtension();
        $fileMime = $arquivo->getClientMimeType();
        // Verifica se e uma imagem
        $check = explode("/", $fileMime);
        if ($check[0] == 'image') {
            $uploadOk = 1;
            // Verifica se a extensao da imagem e valida
            $ext = array("gif", "jpeg", "jpg", "png", "bmp");
            if (!in_array($check[1], $ext)) {
                echo "Erro. São permitidos somente imagens: BMP, JPG, JPEG, PNG e GIF.";
                $uploadOk = 0;
            }
        } else {
            echo "Erro. O arquivo não é uma imagem.";
            $uploadOk = 0;
        }
        // Verifica tamanho da imagem
        if ($arquivo->getClientSize() > $arquivo->getMaxFilesize()) {
            echo "Erro. O arquivo é grande demais.";
            $uploadOk = 0;
        }

        // Se nao houver erro fara o upload
        if ($uploadOk) {
            $arquivo->move($filePath, $fileName);
            return substr_replace('/..', $filePath, 0)."".$fileName;
        } else {
            echo "Erro. O arquivo não gravou.";
            return false;
        }
    }
}
