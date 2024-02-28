<?php
namespace App\Libraries;

class Filter{

    private $productArray;

    public function getSettings($products){
        $this->productArray = $products;
        return $this;
    }
    public function product_array_by_price_range(){
        $priceArray = array_column($this->productArray, 'price');
        $data['minPrice'] = empty($priceArray) ? '0' : floor(min($priceArray));
        $data['maxPrice'] = empty($priceArray) ? '0' : floor(max($priceArray));
        return $data;
    }
    public function product_array_by_options($optionSel){
        $optionId = array();
        foreach ($this->productArray as $val) {
            $table = DB()->table('cc_product_option');
            $option = $table->where('product_id', $val->product_id)->get()->getResult();
            foreach ($option as $v) {
                $optionId[$v->option_id] = true;
            }
        }
        $view = '';
        if (!empty($optionId)) {
            foreach (array_keys($optionId) as $valOption) {
                $view .= '<div class="product-filter">
                <p class="mb-2">' . get_data_by_id('name', 'cc_option', 'option_id', $valOption) . '</p>
                <ul class="list-unstyled filter-items">';
                    foreach ($this->option_value_return($valOption) as $value) {
                        $nameVal = get_data_by_id('name', 'cc_option_value', 'option_value_id', $value);
                        $firstCar = mb_substr($nameVal, 0, 1);
                        $length = strlen($nameVal);
                        $isColor = (($firstCar == '#') && ($length == 7)) ? '' : $nameVal;
                        $nameOp = !empty($isColor) ? $isColor : '';
                        $style = empty($isColor) ? "background-color: $nameVal !important;padding: 15px; border: unset;" : "";

                        $view .= '<li class="mt-2"><input type="checkbox" onclick="formSubmit()"';
                        $view .= (in_array($value, $optionSel))?'checked ':'';
                        $view .= 'class="btn-check" name="options[]" id="option_' . $value . '" value="' . $value . '"  autocomplete="off"><label class="btn btn-outline-secondary rounded-0"  style="' . $style . '" for="option_' . $value . '">' . $nameOp . '</label></li>';
                    }
                $view .= '</ul></div>';
            }
        }
        return $view;
    }
    private function option_value_return($optionId){
        $optValue = array();
        foreach ($this->productArray as $val) {
            $table = DB()->table('cc_product_option');
            $option = $table->where('product_id', $val->product_id)->where('option_id', $optionId)->get()->getResult();
            foreach ($option as $v) {
                $optValue[$v->option_value_id] = true;
            }
        }
        return array_keys($optValue);
    }
    public function product_array_by_brand($brandSel){
        $brandArray = array_column($this->productArray, 'brand_id');
        $view = '';
        if ($this->allValuesNotEmpty($brandArray)) {
            $view .='<div class="product-filter"><p class="mb-2">Manufacturer</p>';
            foreach (array_unique($brandArray) as $brand){
                if (!empty($brand)){
                    $name = get_data_by_id('name', 'cc_brand', 'brand_id', $brand);
                    $view .= '<label class="w-100 mb-2"><input type="checkbox" onclick="formSubmit()" name="manufacturer[]"';
                    $view .= (in_array($brand, $brandSel)) ? 'checked ' : '';
                    $view .= 'value="' . $brand . '"> ' . $name . '</label>';
                }
            }
            $view .='</div>';
        }
        return $view;
    }

    public function product_array_by_rating_view($ratingSel){
        $ratingArray = array_column($this->productArray, 'average_feedback');
        $view = '';
        if ($this->allValuesNotEmpty($ratingArray)) {
            $view .= '<div class="product-filter"><p class="mb-2">Rating</p>';
            foreach (array_unique($ratingArray) as $val) {
                if ($val == '1') {
                    $view .= $this->rating_1($ratingSel);
                } elseif ($val == '2') {
                    $view .= $this->rating_2($ratingSel);
                } elseif ($val == '3') {
                    $view .= $this->rating_3($ratingSel);
                } elseif ($val == '4') {
                    $view .= $this->rating_4($ratingSel);
                } elseif ($val == '5') {
                    $view .= $this->rating_5($ratingSel);
                }
            }
            $view .= '</div>';
        }
        return $view;
    }
    private function rating_1($ratingSel){
        $sel = (in_array('1', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="1">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">1 Rating</span>
            </label>';
        return $view;
    }
    private function rating_2($ratingSel){
        $sel = (in_array('2', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" onclick="formSubmit()" '.$sel.'  name="rating[]" id="" value="2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">2 Rating</span>
            </label>';
        return $view;
    }
    private function rating_3($ratingSel){
        $sel = (in_array('3', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" onclick="formSubmit()" '.$sel.'  name="rating[]" id="" value="3">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">3 Rating</span>
            </label>';
        return $view;
    }
    private function rating_4($ratingSel){
        $sel = (in_array('4', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="4">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">4 Rating</span>
            </label>';
        return $view;
    }
    private function rating_5($ratingSel){
        $sel = (in_array('5', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="5">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <span class="count">5 Rating</span>
            </label>';
        return $view;
    }

    private  function allValuesNotEmpty($array) {
        $data = false;
        foreach ($array as $value){
            if (!empty($value)) {
                $data = true;
            }
        }
        return $data;
    }



















}