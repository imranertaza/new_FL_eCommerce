<?php

namespace App\Controllers;

use App\Models\AlbumModel;
use Config\Services;

class Image extends BaseController {

    protected $validation;
    protected $session;
    protected $encrypter;
    protected $albumModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
        $this->albumModel = new AlbumModel();
    }

    /**
     * @description This method provides Qc picture page view
     * @return void
     */
    public function resize($path,$size,$imageName){
        $sizeParts = explode('x', $size);
        $width = (int) $sizeParts[0];
        $height = (int) $sizeParts[1];

//        echo image_cache(base64_decode($path), $imageName, $width, $height);

        $imageUrl = base64_decode($path) . $imageName;

        $dir = 'cache/'.base64_decode($path).'/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777,true);
        }

        $image = explode('.', $imageName);

        // Image is not in cache, so generate it
        $imagePath = 'cache/'.base64_decode($path). $width .'x'. $height.'_'.$image[0] .  '.webp'; // Cache path

        // Load the image library
        $img = \Config\Services::image();

        // Create a simple image (e.g., image with text)
        $img->withFile($imageUrl)
            ->fit($width, $height, 'center')
            ->save($imagePath);

        $this->serveImage($imagePath);

    }

    private function serveImage($path)
    {
        $mime = $this->getMimeTypeByExtension($path);
        header("Content-Type: $mime");
        header("Cache-Control: public, max-age=31536000");
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + 31536000) . " GMT");
        readfile($path);
        exit;
    }

    private function getMimeTypeByExtension($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
            'svg'  => 'image/svg+xml',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'avif' => 'image/avif',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }



}
