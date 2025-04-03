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

    // Function to merge images and save
    public function image_merger_and_save($imageArray,$dir,$image_name){
        // Define target size for resizing (for example, 200x150)
        $targetWidth = 200;
        $targetHeight = 150;

        // Load your images dynamically (for example, you can use an array of image paths)
        $filePath = $dir.$image_name;
        $imagePaths = $imageArray;
        $this->directory_create($dir);

        $images = [];
        foreach ($imagePaths as $path) {
            $images[] = imagecreatefromjpeg($path);
        }

        // Resize images to target size
        foreach ($images as &$image) {
            $image = imagescale($image, $targetWidth, $targetHeight);
        }

        // Padding and border settings for the images
        $padding = 10;
        $borderColor = imagecolorallocate($images[0], 0, 0, 0); // Black border (RGB)

        // Calculate grid dimensions based on the number of images
        $numImages = count($images);
        $maxColumns = 3; // Set maximum images per row
        $numColumns = min($maxColumns, $numImages); // Ensure no more than maxColumns per row
        $numRows = ceil($numImages / $numColumns); // Calculate number of rows

        // Calculate the final width and height of the combined image with padding
        $finalWidth = $targetWidth * $numColumns + $padding * ($numColumns + 1); // Account for padding
        $finalHeight = $targetHeight * $numRows + $padding * ($numRows + 1); // Account for padding

        // Create a blank image for the final result
        $finalImage = imagecreatetruecolor($finalWidth, $finalHeight);

        // Set background color for final image (optional, here we set it as white)
        $white = imagecolorallocate($finalImage, 255, 255, 255); // RGB white color
        imagefill($finalImage, 0, 0, $white);

        // Copy each image into the final image with padding
        $x = $padding;
        $y = $padding;

        foreach ($images as $index => $image) {
            // Copy each resized image to the final image
            imagecopy($finalImage, $image, $x, $y, 0, 0, $targetWidth, $targetHeight);

            // Calculate the next x and y coordinates
            $x += $targetWidth + $padding;

            // If we've reached the maximum number of columns, move to the next row
            if (($index + 1) % $numColumns == 0) {
                $x = $padding; // Reset x to start from the left
                $y += $targetHeight + $padding; // Move down to the next row
            }
        }

        // Add a border around the entire final image
        imagerectangle($finalImage, 0, 0, $finalWidth - 1, $finalHeight - 1, $borderColor); // Border around the whole combined image


        if(!file_exists($filePath)){
            // Save the final image as a JPEG
            imagejpeg($finalImage, $filePath,100);
        }

        // Output the final image to the browser
        //header('Content-Type: image/jpeg');
        //imagejpeg($finalImage);


        // Free up memory
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

}