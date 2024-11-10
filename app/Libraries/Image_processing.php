<?php
namespace App\Libraries;

use Config\Services;

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
     * @return Theme_2|Theme_3|Theme_default
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
            imagecopy($mainImg, $this->wm, imagesx($mainImg) - $this->sx - $this->marge_right, imagesy($mainImg) - $this->sy - $this->marge_bottom, 0, 0, imagesx($this->wm), imagesy($this->wm));
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
                $this->crop->withFile($dir . '' . $image)->fit($pro_img['width'], $pro_img['height'], 'center')->save($dir . $pro_img['width'] . '_' . $image_name,$this->quality);
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

}