<?php
namespace App\Libraries;

use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use ZipArchive;

class Image_processing {

    private $wm;
    private $marge_right = 30;
    private $marge_bottom = 30;
    private $sx;
    private $sy;
    private $crop;
    public $sizeArray;
    private $quality = 100;

    public function __construct(){
        $this->wm = imagecreatefrompng(FCPATH . '/uploads/products/wm.png');
        $this->sx = imagesx($this->wm);
        $this->sy = imagesy($this->wm);
        $this->crop = Services::image();
        $this->quality = $this->image_quality();
        $this->sizeArray = $this->selected_theme_libraries();
    }

    /**
     * @description This function provides image quality key
     * @return int
     */
    public function image_quality(){
        helper('Global');
        $table = DB()->table('cc_modules');
        $query = $table->where('module_key', 'image_quality')->get();
        $result = $query->getRow();

        return ($result->status == '1')?get_model_settings_value_by_modelId_or_label($result->module_id, 'quality'):'100';
    }

    /**
     * @description This function provides selected theme libraries
     * @return array
     */
    public function selected_theme_libraries(){
        helper('Global');
        $theme = get_lebel_by_value_in_settings('Theme');
        if($theme == 'Theme_3'){
            $libraries = new Theme_3();
        }
        if($theme == 'Default'){
            $libraries = new Theme_default();
        }
        if($theme == 'Theme_2'){
            $libraries = new Theme_2();
        }
        return $libraries->product_image;
    }

    /**
     * @description This function provides image unlink
     * @param string $dir
     * @return $this
     */
    public function image_unlink($dir){
        if (file_exists($dir)) {
            unlink($dir);
        }
        return $this;
    }

    /**
     * @description This function provides product image upload
     * @param string $file
     * @param string $dir
     * @return string
     */
    public function product_image_upload($file,$dir){
        $namePic = $file->getRandomName();
        $file->move($dir, $namePic);
        return 'pro_' . $file->getName();
    }

    /**
     * @description This function provides watermark main image
     * @param string $dir
     * @param string $image
     * @return $this
     */
    public function watermark_main_image($dir,$image){
        if (!file_exists($dir . '/wm_' . $image)) {

            if (pathinfo($image, PATHINFO_EXTENSION) == 'png'){
                $mainImg = imagecreatefrompng($dir . $image);
            }else {
                $mainImg = imagecreatefromjpeg($dir . $image);
            }
            //imagecopy($mainImg, $this->wm, imagesx($mainImg) - $this->sx - $this->marge_right, imagesy($mainImg) - $this->sy - $this->marge_bottom, 0, 0, imagesx($this->wm), imagesy($this->wm));

            // Get the dimensions of the main image
            $mainImageWidth = imagesx($mainImg);
            $mainImageHeight = imagesy($mainImg);

            // Get the dimensions of the watermark image
            $watermarkWidth = imagesx($this->wm);
            $watermarkHeight = imagesy($this->wm);

            // Calculate the new watermark size based on the main image size, keeping the aspect ratio
            $watermarkNewWidth = $mainImageWidth * 0.25;  // Adjust this factor as needed (e.g., 25% of the main image width)
            $watermarkNewHeight = ($watermarkNewWidth / $watermarkWidth) * $watermarkHeight;  // Maintain the aspect ratio

            // Resize the watermark to the new size
            $watermarkResized = imagecreatetruecolor($watermarkNewWidth, $watermarkNewHeight);
            imagealphablending($watermarkResized, false);
            imagesavealpha($watermarkResized, true);
            imagecopyresampled($watermarkResized, $this->wm, 0, 0, 0, 0, $watermarkNewWidth, $watermarkNewHeight, $watermarkWidth, $watermarkHeight);

            // Calculate the position to place the watermark (bottom-right corner)
            $watermarkX = $mainImageWidth - $watermarkNewWidth - $this->marge_right; // 30px padding from the right
            $watermarkY = $mainImageHeight - $watermarkNewHeight - $this->marge_bottom; // 30px padding from the bottom

            // Merge the watermark onto the main image
            imagecopy($mainImg, $watermarkResized, $watermarkX, $watermarkY, 0, 0, $watermarkNewWidth, $watermarkNewHeight);

            imagePng($mainImg, $dir . 'wm_' . $image);
        }
        return $this;
    }

    /**
     * @description This function provides watermark on resized image
     * @param string $dir
     * @param string $image
     * @return $this
     */
    public function watermark_on_resized_image($dir,$image){
        if (!file_exists($dir . '/600_wm_' . $image)) {
            $this->crop->withFile($dir . $image)->fit(600, 600, 'center')->save($dir . '600_' . $image ,$this->quality);

            if (pathinfo($image, PATHINFO_EXTENSION) == 'png'){
                $mImg = imagecreatefrompng($dir . $image);
            }else {
                $mImg = imagecreatefromjpeg($dir . '600_' . $image);
            }
            imagecopy($mImg, $this->wm, imagesx($mImg) - $this->sx - $this->marge_right, imagesy($mImg) - $this->sy - $this->marge_bottom, 0, 0, imagesx($this->wm), imagesy($this->wm));
            imagePng($mImg, $dir . '600_wm_' . $image);

            $this->image_unlink($dir . '600_' . $image);
        }
        return $this;
    }

    /**
     * @description This function provides image crop
     * @param string $dir
     * @param string $image
     * @param string $image_name
     * @return $this
     */
    public function image_crop($dir,$image,$image_name){
        foreach($this->sizeArray as $pro_img){
            if (!file_exists($dir . '/' . $pro_img['width'] .'_' . $image_name)) {
                $this->crop->withFile($dir . $image)->fit($pro_img['width'], $pro_img['height'], 'center')->save($dir . $pro_img['width'] . '_' . $image_name,$this->quality);
            }
        }
        return $this;
    }

    /**
     * @description This function provides single product image unlink
     * @param string $dir
     * @param string $image
     * @return $this
     */
    public function single_product_image_unlink($dir,$image){
        if ((!empty($image)) && (file_exists($dir))) {
            $mainImg = str_replace('pro_', '', $image);

            $this->image_unlink($dir . '/' . $mainImg);
            $this->image_unlink($dir . '/wm_' . $mainImg);
            $this->image_unlink($dir . '/600_wm_' . $mainImg);

            foreach($this->sizeArray as $pro_img){
                $this->image_unlink($dir . '/' . $pro_img['width'] .'_' . $image);
                $this->image_unlink($dir . '/' . $pro_img['width'] .'_wm_' . $image);
            }
        }
        return $this;
    }

    /**
     * @description This function provides directory create
     * @param string $dir
     * @return $this
     */
    public function directory_create($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        return $this;
    }

    /**
     * @description This function provides product image upload and crop all size
     * @param string $img
     * @param string $dir
     * @return string
     */
    public function product_image_upload_and_crop_all_size($img,$dir){
        $modules = modules_access();
        $news_img = $this->product_image_upload($img,$dir);
        //image crop
        $image = str_replace('pro_', '', $news_img);
        $this->image_crop($dir,$image, $news_img);
        if ($modules['watermark'] == '1') {
            //image watermark
            $this->watermark_main_image($dir, $image);
            $this->watermark_on_resized_image($dir, $image);
            //image watermark crop
            $this->image_crop($dir, '600_wm_' . $image, 'wm_' . $news_img);
        }

        return $news_img;
    }

    /**
     * @description This function provides all image upload and crop all size
     * @param $img
     * @param $dir
     * @return string
     */
    public function image_upload_and_crop_all_size($img,$dir){
        $news_img = $this->product_image_upload($img,$dir);
        //image crop
        $image = str_replace('pro_', '', $news_img);
        $this->image_crop($dir,$image, $news_img);

        return $news_img;
    }

    public function image_merger_and_save($imageArray, $dir, $image_name) {
        $targetWidth = 200;
        $targetHeight = 150;
        $padding = 10;
        $maxColumns = 3;

        $filePath = $dir . $image_name;
        $this->directory_create($dir); // Make sure directory exists

        $images = [];

        foreach ($imageArray as $path) {
            if (pathinfo($path, PATHINFO_EXTENSION) == 'png'){
                $srcImage = @imagecreatefrompng($path);
            }else {
                $srcImage = @imagecreatefromjpeg($path);
            }

            $originalWidth = imagesx($srcImage);
            $originalHeight = imagesy($srcImage);

            // Oversample: resize to larger first for better downscaling
            $oversampleFactor = 2;
            $intermediateWidth = $targetWidth * $oversampleFactor;
            $intermediateHeight = $targetHeight * $oversampleFactor;

            $scale = max($intermediateWidth / $originalWidth, $intermediateHeight / $originalHeight);
            $scaledWidth = (int)($originalWidth * $scale);
            $scaledHeight = (int)($originalHeight * $scale);

            $intermediateImage = imagecreatetruecolor($scaledWidth, $scaledHeight);
            imagecopyresampled($intermediateImage, $srcImage, 0, 0, 0, 0, $scaledWidth, $scaledHeight, $originalWidth, $originalHeight);
            imagedestroy($srcImage);

            // Center crop to intermediate size
            $cropX = (int)(($scaledWidth - $intermediateWidth) / 2);
            $cropY = (int)(($scaledHeight - $intermediateHeight) / 2);

            $croppedImage = imagecrop($intermediateImage, [
                'x' => $cropX,
                'y' => $cropY,
                'width' => $intermediateWidth,
                'height' => $intermediateHeight
            ]);
            imagedestroy($intermediateImage);

            if ($croppedImage !== false) {
                // Final downscale to target (produces smoother results)
                $finalImage = imagecreatetruecolor($targetWidth, $targetHeight);
                imagecopyresampled($finalImage, $croppedImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $intermediateWidth, $intermediateHeight);
                imagedestroy($croppedImage);

                // Optional: apply sharpening convolution filter
                $sharpenMatrix = [
                    [-1, -1, -1],
                    [-1, 16, -1],
                    [-1, -1, -1],
                ];
                imageconvolution($finalImage, $sharpenMatrix, 8, 0);

                $images[] = $finalImage;
            }
        }

        $numImages = count($images);
        if ($numImages === 0) return;

        $numColumns = min($maxColumns, $numImages);
        $numRows = ceil($numImages / $numColumns);

        $finalWidth = $targetWidth * $numColumns + $padding * ($numColumns + 1);
        $finalHeight = $targetHeight * $numRows + $padding * ($numRows + 1);

        $finalImage = imagecreatetruecolor($finalWidth, $finalHeight);
        imageantialias($finalImage, true);
        $white = imagecolorallocate($finalImage, 255, 255, 255);
        imagefill($finalImage, 0, 0, $white);

        $borderColor = imagecolorallocate($finalImage, 0, 0, 0);

        $x = $padding;
        $y = $padding;
        foreach ($images as $index => $img) {
            imagecopy($finalImage, $img, $x, $y, 0, 0, $targetWidth, $targetHeight);
            imagedestroy($img);
            $x += $targetWidth + $padding;
            if (($index + 1) % $numColumns == 0) {
                $x = $padding;
                $y += $targetHeight + $padding;
            }
        }

        imagerectangle($finalImage, 0, 0, $finalWidth - 1, $finalHeight - 1, $borderColor);

        imagejpeg($finalImage, $filePath, 100); // max quality
        imagedestroy($finalImage);
    }


    // Function to zip images
    public function zipImages($imagePaths,$dirSave)
    {
        $zip = new ZipArchive();

        $zipName = $dirSave . 'images.zip';

        // Open the ZIP file for writing
        if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {
            foreach ($imagePaths as $imagePath) {
                // Add each image to the ZIP file
                $zip->addFile($imagePath, basename($imagePath)); // Add file with original filename
            }

            // Close the ZIP file after adding all files
            $zip->close();
        } else {
            throw new \RuntimeException('Failed to create ZIP file');
        }

        return $zipName; // Return the path to the created ZIP file
    }
    // Function to download the file
    public function downloadFile($zipName,$image_name){
        if (file_exists($zipName)) {
            $response = service('response')->download($zipName, null)->setFileName($image_name);
            register_shutdown_function(function () use ($zipName) {
                $this->image_unlink($zipName);
            });
            return $response;
        }
    }

    public function resize_image_unlink($imagePaths){
        $this->image_unlink($imagePaths);
    }

}