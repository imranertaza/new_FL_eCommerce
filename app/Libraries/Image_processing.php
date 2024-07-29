<?php
namespace App\Libraries;

use Config\Services;

class Image_processing {

    private $wm;
    private $marge_right = 50;
    private $marge_bottom = 60;
    private $sx;
    private $sy;
    private $crop;

    public function __construct(){
        $this->wm = imagecreatefrompng(FCPATH . '/uploads/products/wm.png');
        $this->sx = imagesx($this->wm);
        $this->sy = imagesy($this->wm);
        $this->crop = Services::image();
    }

    public function selected_theme_libraries(){
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
        return $libraries;
    }
    public function image_unlink($dir){
        if (file_exists($dir)) {
            unlink($dir);
        }
        return $this;
    }
    public function product_image_upload($file,$dir){
        $namePic = $file->getRandomName();
        $file->move($dir, $namePic);
        return 'pro_' . $file->getName();
    }

    public function watermark_main_image($dir,$image){
        if (!file_exists($dir . '/wm_' . $image)) {
            $mainImg = imagecreatefromjpeg($dir . $image);
            imagecopy($mainImg, $this->wm, imagesx($mainImg) - $this->sx - $this->marge_right, imagesy($mainImg) - $this->sy - $this->marge_bottom, 0, 0, imagesx($this->wm), imagesy($this->wm));
            imagePng($mainImg, $dir . 'wm_' . $image);
        }
        return $this;
    }
    public function watermark_on_resized_image($dir,$image){
        if (!file_exists($dir . '/600_wm_' . $image)) {
            $this->crop->withFile($dir . '' . $image)->fit(600, 600, 'center')->save($dir . '600_' . $image);

            $mImg = imagecreatefromjpeg($dir . '600_' . $image);
            imagecopy($mImg, $this->wm, imagesx($mImg) - $this->sx - $this->marge_right, imagesy($mImg) - $this->sy - $this->marge_bottom, 0, 0, imagesx($this->wm), imagesy($this->wm));
            imagePng($mImg, $dir . '600_wm_' . $image);

            $this->image_unlink($dir . '600_' . $image);
        }
        return $this;
    }

    public function image_crop($dir,$image,$image_name){
        foreach($this->selected_theme_libraries()->product_image as $pro_img){
            if (!file_exists($dir . '/' . $pro_img['width'] .'_' . $image_name)) {
                $this->crop->withFile($dir . '' . $image)->fit($pro_img['width'], $pro_img['height'], 'center')->save($dir . $pro_img['width'] . '_' . $image_name,'100');
            }
        }
        return $this;
    }

    public function single_product_image_unlink($dir,$image){
        if ((!empty($image)) && (file_exists($dir))) {
            $mainImg = str_replace('pro_', '', $image);

            $this->image_unlink($dir . '/' . $mainImg);
            $this->image_unlink($dir . '/wm_' . $mainImg);
            $this->image_unlink($dir . '/600_wm_' . $mainImg);

            foreach($this->selected_theme_libraries()->product_image as $pro_img){
                $this->image_unlink($dir . '/' . $pro_img['width'] .'_' . $image);
                $this->image_unlink($dir . '/' . $pro_img['width'] .'_wm_' . $image);
            }
        }
        return $this;
    }
    public function directory_create($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        return $this;
    }

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