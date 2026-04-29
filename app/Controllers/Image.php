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

        if ($image[1] == 'gif'){
            $imagePath = 'cache/' . base64_decode($path) . $width . 'x' . $height . '_' . $imageName; // Cache path
        }else {
            // Image is not in cache, so generate it
            $imagePath = 'cache/' . base64_decode($path) . $width . 'x' . $height . '_' . $image[0] . '.webp'; // Cache path
        }

        // Load the image library
        $img = \Config\Services::image();

        // Create a simple image (e.g., image with text) and save it to cache path
        if ($image[1] == 'gif'){
            $this->processGif($imageUrl, $imagePath,$width,$height);
        }else {
            $img->withFile($imageUrl)
                ->fit($width, $height, 'center')
                ->save($imagePath);
        }

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

//    private function processGif($input, $output,$cropWidth,$cropHeight)
//    {
//        $gif = new \Imagick(FCPATH .$input);
//
//        // Break frames
//        $gif = $gif->coalesceImages();
//
//        foreach ($gif as $frame) {
//
//            $width  = $frame->getImageWidth();
//            $height = $frame->getImageHeight();
//
//            // Center crop (square)
//            $size = min($width, $height);
//
//            $x = ($width - $size) / 2;
//            $y = ($height - $size) / 2;
//
//            // Crop
//            $frame->cropImage($size, $size, $x, $y);
//
//            // Resize (200x200)
//            $frame->resizeImage($cropWidth, $cropHeight, \Imagick::FILTER_LANCZOS, 1);
//
//            // Fix frame offset
//            $frame->setImagePage(0, 0, 0, 0);
//        }
//
//        // Rebuild animation
//        $gif = $gif->deconstructImages();
//
//        // Save
//        $gif->writeImages(FCPATH .$output, true);
//    }

    private function processGif($input, $output, $cropWidth, $cropHeight)
    {
        $gif = new \Imagick(FCPATH.$input);
        // 1. Coalesce is mandatory to rebuild full frames from optimized diffs
        $gif = $gif->coalesceImages();

        foreach ($gif as $frame) {
            // 2. Use Disposal Method 1 (None/Leave)
            // Since we coalesced, every frame is now a full image.
            // Method 1 prevents the "flashing" or "transparency bleed" common with Method 2.
            $frame->setImageDispose(1);

            $width  = $frame->getImageWidth();
            $height = $frame->getImageHeight();

            // Calculate Crop (Center Crop Logic)
            $targetRatio = $cropWidth / $cropHeight;
            $currentRatio = $width / $height;

            if ($currentRatio > $targetRatio) {
                $newWidth = $height * $targetRatio;
                $newHeight = $height;
                $x = ($width - $newWidth) / 2;
                $y = 0;
            } else {
                $newWidth = $width;
                $newHeight = $width / $targetRatio;
                $x = 0;
                $y = ($height - $newHeight) / 2;
            }

            // 3. The Sequence: Crop -> Resize -> Reset Page
            $frame->cropImage($newWidth, $newHeight, $x, $y);
            $frame->thumbnailImage($cropWidth, $cropHeight, true); // thumbnailImage is often faster/cleaner for GIFs

            // 4. CRITICAL: Reset the virtual canvas (GIFs store "offsets" which ruins crops)
            $frame->setImagePage(0, 0, 0, 0);
        }

        // 5. Re-optimize for file size
        // optimizeImageLayers removes redundant pixels between frames
        $gif = $gif->optimizeImageLayers();

        // 6. Final Color Fix
        // This prevents "color shifting" where the bird might change hue mid-animation
        $gif->quantizeImages(256, \Imagick::COLORSPACE_RGB, 0, false, false);

        $gif->writeImages(FCPATH.$output, true);
    }
}
