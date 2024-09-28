<?php
namespace App\Libraries;

class Filter{

    private $productArray;

    public function getSettings($products){
        $this->productArray = $products;
        return $this;
    }

    /**
     * @description This function provides product array by price range
     * @return array
     */
    public function product_array_by_price_range(){
        $priceArray = array_column($this->productArray, 'price');
        $data['minPrice'] = empty($priceArray) ? '0' : floor(min($priceArray));
        $data['maxPrice'] = empty($priceArray) ? '0' : floor(max($priceArray));
        return $data;
    }

//    public function product_array_by_options($optionSel){
//        $view = '';
//        if (!empty($this->productArray)) {
//            $table = DB()->table('cc_product_option');
//            $table->join('cc_option','cc_option.option_id = cc_product_option.option_id');
//            foreach ($this->productArray as $val){
//                $table->orWhere('cc_product_option.product_id', $val->product_id);
//            }
//            $table->groupBy('cc_option.option_id');
//            $option = $table->get()->getResult();
//
//            if (!empty($option)) {
//                $allOptVal = $this->product_option_value($option);
//
//                foreach ($option as $valOption) {
//                    $view .= '<div class="product-filter">
//                <p class="mb-2">' . $valOption->name . '</p>
//                <ul class="list-unstyled filter-items">';
////                    foreach ($this->option_value_return($valOption->option_id) as $value) {
//                    foreach ($allOptVal as $value) {
//                        if ($valOption->option_id == $value->option_id) {
//                            $nameVal = $value->name;
//                            $firstCar = mb_substr($nameVal, 0, 1);
//                            $length = strlen($nameVal);
//                            $isColor = (($firstCar == '#') && ($length == 7)) ? '' : $nameVal;
//                            $nameOp = !empty($isColor) ? $isColor : '';
//                            $style = empty($isColor) ? "background-color: $nameVal !important;padding: 15px; border: unset;" : "";
//
//                            $view .= '<li class="mt-2"><input type="checkbox" form="searchForm" onclick="formSubmit()"';
//                            $view .= (in_array($value->option_value_id, $optionSel)) ? 'checked ' : '';
//                            $view .= 'class="btn-check" name="options[]" id="option_' . $value->option_value_id . '" value="' . $value->option_value_id . '"  autocomplete="off"><label class="btn btn-outline-secondary rounded-0"  style="' . $style . '" for="option_' . $value->option_value_id . '">' . $nameOp . '</label></li>';
//                        }
//                    }
//                    $view .= '</ul></div>';
//                }
//            }
//        }
//        return $view;
//    }
    /**
     * @description This function provides product array by options
     * @param int $optionSel
     * @return string
     */
    public function product_array_by_options($optionSel){
        $view = '';
        if (!empty($this->productArray)) {
            $productIds = array_column($this->productArray, 'product_id');

            if (!empty($productIds)) {
                $table = DB()->table('cc_product_option');
                $table->join('cc_option', 'cc_option.option_id = cc_product_option.option_id')
                    ->whereIn('cc_product_option.product_id', $productIds)
                    ->groupBy('cc_option.option_id');

                $option = $table->get()->getResult();

                if (!empty($option)) {
                    $allOptVal = $this->product_option_value($option);

                    foreach ($option as $valOption) {
                        $view .= '<div class="product-filter">
                        <p class="mb-2">' . $valOption->name . '</p>
                        <select name="options[]" class="form-control select2bs4" multiple="multiple" form="searchForm" onchange="formSubmit()" >';

                        foreach ($allOptVal as $value) {
                            if ($valOption->option_id == $value->option_id) {
                                $nameVal = $value->name;
                                $firstCar = mb_substr($nameVal, 0, 1);
                                $length = strlen($nameVal);
                                $isColor = (($firstCar == '#') && ($length == 7)) ? '' : $nameVal;
                                $nameOp = !empty($isColor) ? $isColor : '';
                                $style = empty($isColor) ? "background-color: $nameVal !important;padding: 15px; border: unset;" : "";
                                $sel = (in_array($value->option_value_id, $optionSel)) ? 'selected' : '';

                                $view .= '<option value="'.$value->option_value_id .'"  '.$sel.'  style="' . $style . '" >' . $nameOp . '</option>' ;

                            }
                        }
                        $view .= '</select></div>';
                    }
                }
            }
        }
        return $view;
    }

//    private function product_option_value($opt){
//
//        $table = DB()->table('cc_product_option');
//        $table->join('cc_option_value','cc_option_value.option_value_id = cc_product_option.option_value_id');
//        foreach ($opt as $row) {
//            foreach ($this->productArray as $val) {
//                $table->orGroupStart();
//                $table->where('cc_product_option.product_id', $val->product_id);
//                $table->where('cc_product_option.option_id', $row->option_id);
//                $table->groupEnd();
//            }
//        }
//        $table->groupBy('cc_option_value.option_value_id');
//        $option = $table->get()->getResult();
//        return $option;
//    }
    /**
     * @description This function provides product option value
     * @param array $opt
     * @return array
     */
    private function product_option_value($opt){
        $productIds = array_column($this->productArray, 'product_id');
        $optionIds = array_column($opt, 'option_id');

        if (!empty($productIds) && !empty($optionIds)) {
            $table = DB()->table('cc_product_option');
            $table->join('cc_option_value', 'cc_option_value.option_value_id = cc_product_option.option_value_id')
                ->whereIn('cc_product_option.product_id', $productIds)
                ->whereIn('cc_product_option.option_id', $optionIds)
                ->groupBy('cc_option_value.option_value_id');

            $option = $table->get()->getResult();
            return $option;
        }

        return [];
    }


//    public function product_array_by_brand($brandSel){
//        $brandArray = array_column($this->productArray, 'brand_id');
//        $view = '';
//        if ($this->allValuesNotEmpty($brandArray)) {
//            $view .='<div class="product-filter"><p class="mb-2">Brands</p>';
//
//            $table = DB()->table('cc_brand');
//            foreach (array_unique($brandArray) as $val){
//                $table->orWhere('brand_id',$val);
//            }
//            $result = $table->orderBy('name')->get()->getResult();
//
//            foreach ($result as $brand){
//                if (!empty($brand->brand_id)){
//                    $name = $brand->name;
//                    $view .= '<label class="w-100 mb-2"><input type="checkbox" form="searchForm" onclick="formSubmit()" name="manufacturer[]"';
//                    $view .= (in_array($brand->brand_id, $brandSel)) ? 'checked ' : '';
//                    $view .= 'value="' . $brand->brand_id . '"> ' . $name . ' <span class="count">'.product_count_by_brand_id($brand->brand_id,$this->productArray).'</span></label>';
//                }
//            }
//            $view .='</div>';
//        }
//        return $view;
//    }
    /**
     * @description This function provides product array by brand
     * @param int $brandSel
     * @return string
     */
    public function product_array_by_brand($brandSel){
        $brandArray = array_unique(array_column($this->productArray, 'brand_id'));
        $view = '';

        if ($this->allValuesNotEmpty($brandArray)) {
            $view .= '<div class="product-filter"><p class="mb-2">Brands</p>';

            $table = DB()->table('cc_brand');
            if (!empty($brandArray)) {
                $table->whereIn('brand_id', $brandArray)
                    ->orderBy('name');

                $result = $table->get()->getResult();

                foreach ($result as $brand) {
                    if (!empty($brand->brand_id)) {
                        $name = $brand->name;
                        $view .= '<label class="w-100 mb-2"><input type="checkbox" form="searchForm" onclick="formSubmit()" name="manufacturer[]"';
                        $view .= (in_array($brand->brand_id, $brandSel)) ? 'checked ' : '';
                        $view .= 'value="' . $brand->brand_id . '"> ' . $name . ' <span class="count">' . product_count_by_brand_id($brand->brand_id, $this->productArray) . '</span></label>';
                    }
                }
            }
            $view .= '</div>';
        }
        return $view;
    }


//    public function product_array_by_rating_view($ratingSel){
//        $ratingArray = array_column($this->productArray, 'average_feedback');
//        $view = '';
//        if ($this->allValuesNotEmpty($ratingArray)) {
//            $view .= '<div class="product-filter"><p class="mb-2">Rating</p>';
//            foreach (array_unique($ratingArray) as $val) {
//                if ($val == '1') {
//                    $view .= $this->rating_1($ratingSel);
//                } elseif ($val == '2') {
//                    $view .= $this->rating_2($ratingSel);
//                } elseif ($val == '3') {
//                    $view .= $this->rating_3($ratingSel);
//                } elseif ($val == '4') {
//                    $view .= $this->rating_4($ratingSel);
//                } elseif ($val == '5') {
//                    $view .= $this->rating_5($ratingSel);
//                }
//            }
//            $view .= '</div>';
//        }
//        return $view;
//    }
    /**
     * @description This function provides product array by rating view
     * @param int $ratingSel
     * @return string
     */
    public function product_array_by_rating_view($ratingSel){
        $ratingArray = array_unique(array_column($this->productArray, 'average_feedback'));
        $view = '';

        if ($this->allValuesNotEmpty($ratingArray)) {
            $view .= '<div class="product-filter"><p class="mb-2">Rating</p>';

            foreach ($ratingArray as $val) {
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

    /**
     * @description This function provides rating view
     * @param int $ratingSel
     * @return string
     */
    private function rating_1($ratingSel){
        $sel = (in_array('1', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" form="searchForm" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="1">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">1 Rating</span>
            </label>';
        return $view;
    }

    /**
     * @description This function provides rating view
     * @param int $ratingSel
     * @return string
     */
    private function rating_2($ratingSel){
        $sel = (in_array('2', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" form="searchForm" onclick="formSubmit()" '.$sel.'  name="rating[]" id="" value="2">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">2 Rating</span>
            </label>';
        return $view;
    }

    /**
     * @description This function provides rating view
     * @param int $ratingSel
     * @return string
     */
    private function rating_3($ratingSel){
        $sel = (in_array('3', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" form="searchForm" onclick="formSubmit()" '.$sel.'  name="rating[]" id="" value="3">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">3 Rating</span>
            </label>';
        return $view;
    }

    /**
     * @description This function provides rating view
     * @param int $ratingSel
     * @return string
     */
    private function rating_4($ratingSel){
        $sel = (in_array('4', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" form="searchForm" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="4">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <span class="count">4 Rating</span>
            </label>';
        return $view;
    }

    /**
     * @description This function provides rating view
     * @param int $ratingSel
     * @return string
     */
    private function rating_5($ratingSel){
        $sel = (in_array('5', $ratingSel))?'checked ':'';
        $view ='<label class="w-100 mb-2">
                <input type="checkbox" form="searchForm" onclick="formSubmit()" '.$sel.' name="rating[]" id="" value="5">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <span class="count">5 Rating</span>
            </label>';
        return $view;
    }

    /**
     * @description This function provides all values not empty
     * @param $array
     * @return bool
     */
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