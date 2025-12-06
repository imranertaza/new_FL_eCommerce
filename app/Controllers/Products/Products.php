<?php namespace App\Controllers\Products;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use CodeIgniter\HTTP\RedirectResponse;

class Products extends BaseController {

    protected $validation;
    protected $session;
    protected $cart;
    protected $image_processing;

    public function __construct()
    {
        $this->image_processing = new Image_processing();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->cart = \Config\Services::cart();
    }

    /**
     * @description This method provides product detail page view
     * @param int $product_id
     * @return void
     */
    public function detail($product_id)
    {
        $check = is_exists('cc_products', 'product_id', $product_id);
        if ($check == true){
            return redirect()->to('product-not-found');
        }

        $settings = get_settings();
        $table = DB()->table('cc_products');
        $table->select('cc_products.*, cc_product_description.*,cc_product_description.alt_name AS altDes ,cc_products.alt_name AS altPro');
        $table->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id ');
        $data['products'] = $table->where('cc_products.product_id',$product_id)->where('cc_products.status','Active')->get()->getRow();

        if (empty($data['products'])){
            return redirect()->to('product-not-found');
        }

        //image
        $imgTable = DB()->table('cc_product_image');
        $data['proImg'] = $imgTable->where('product_id',$product_id)->where('Product_option_id',null)->orderBy('sort_order','ASC')->get()->getResult();

        //related product
        $relatedProduct = array();
        $relTable = DB()->table('cc_product_related');
        $relPro = $relTable->where('product_id',$product_id)->limit(5)->get()->getResult();
        foreach ($relPro as $rVal){
            $tableSear = DB()->table('cc_products');
            $rowPro = $tableSear->where('product_id',$rVal->related_id)->where('status','Active')->get()->getRow();
            if(!empty($rowPro)) {
                array_push($relatedProduct, $rowPro);
            }
        }
        $data['relProd'] = $relatedProduct;


        //related product  2 products view
        $relatedProduct2 = array();
        $relTable = DB()->table('cc_product_related');
        $relPro2 = $relTable->where('product_id',$product_id)->orderBy('product_id','DESC')->limit(2)->get()->getResult();
        foreach ($relPro2 as $rVal2){
            $tableSear2 = DB()->table('cc_products');
            $rowPro2 = $tableSear2->where('product_id',$rVal2->related_id)->where('status','Active')->get()->getRow();
            if(!empty($rowPro2)) {
                array_push($relatedProduct2, $rowPro2);
            }
        }
        $data['relProdSide'] = $relatedProduct2;

        //reviews
        $reviewTable = DB()->table('cc_product_feedback');
        $data['review'] = $reviewTable->where('product_id',$product_id)->where('status','Active')->get()->getResult();



        //bought together products view
        $boughtProduct = array();
        $bothTable = DB()->table('cc_product_bought_together');
        $bothPro = $bothTable->where('product_id',$product_id)->orderBy('product_id','DESC')->get()->getResult();
        foreach ($bothPro as $bVal){
            $tableboth = DB()->table('cc_products');
            $rowPro = $tableboth->where('product_id',$bVal->related_id)->where('status','Active')->get()->getRow();
            if(!empty($rowPro)) {
                array_push($boughtProduct, $rowPro);
            }
        }
        $data['boughtProducts'] = $boughtProduct;


        $data['option'] = $this->optionView($product_id);

        $data['keywords'] = $data['products']->meta_keyword;
        $data['description'] = $data['products']->meta_description;
        $data['title'] = $data['products']->meta_title;

        $data['page_title'] = 'Product Detail';
        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Product/detail');
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides option price calculate
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function optionPriceCalculate(){

        $product_id = $this->request->getPost('product_id');

        $totalOptionPrice = 0;
        foreach(get_all_data_array('cc_option') as $vl) {
            $fildName = str_replace(' ','',$vl->name);
            $data[strtolower($fildName)] = $this->request->getPost(strtolower($fildName));

            $table = DB()->table('cc_product_option');
            $option = $table->where('option_value_id',$data[strtolower($fildName)])->where('product_id',$product_id)->get()->getRow();

            if (!empty($option)) {
                if (empty($option->subtract)){
                    $totalOptionPrice = $totalOptionPrice + $option->price;
                }else{
                    $totalOptionPrice = $totalOptionPrice - $option->price;
                }
            }
        }

        $proPrice = get_data_by_id('price','cc_products','product_id',$product_id);
        $specialprice = get_data_by_id('special_price','cc_product_special','product_id',$product_id);
        if (!empty($specialprice)){
            $proPrice = $specialprice;
        }

        $total = currency_symbol($proPrice + $totalOptionPrice);

        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($total);
    }

    /**
     * @description This method provides product review update
     * @return RedirectResponse
     */
    public function review(){
        $data['product_id'] = $this->request->getPost('product_id');
        $data['customer_id'] = $this->session->cusUserId;
        $data['feedback_star'] = $this->request->getPost('rating');
        $data['feedback_text'] = $this->request->getPost('feedback_text');

        $this->validation->setRules([
            'product_id' => ['label' => 'Product', 'rules' => 'required'],
            'feedback_star' => ['label' => 'Rating', 'rules' => 'required'],
            'feedback_text' => ['label' => 'Message', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', $this->validation->listErrors());
            return redirect()->to('detail/'. $data['product_id']);
        } else {

            $table = DB()->table('cc_product_feedback');
            $table->insert($data);

            $dataRet['average_feedback'] = product_id_by_average_rating($data['product_id']);
            $tablePro = DB()->table('cc_products');
            $tablePro->where('product_id',$data['product_id'])->update($dataRet);

            $this->session->setFlashdata('message', 'Successfully submitted review');
            return redirect()->to('detail/'. $data['product_id']);
        }
    }

    /**
     * @description This method provides both product price
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function both_product_price(){
        $productId = $this->request->getPost('both_product[]');
        $total = 0;
        if (!empty($productId)) {
            foreach ($productId as $id) {
                $regPric = get_data_by_id('price', 'cc_products', 'product_id', $id);
                $spPric = get_data_by_id('special_price', 'cc_product_special', 'product_id', $id);
                $total += !empty($spPric) ? $spPric : $regPric;
            }
        }
        $message = currency_symbol($total);
        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($message);
    }


    /**
     * @description This method provides option view
     * @param int $product_id
     * @return string
     */
    private function optionView($product_id){
        $productOption = DB()->table('cc_product_option');
        $allOptionsGroup = $productOption->where('product_id',$product_id)->groupBy('option_id')->get()->getResult();

        $view ='';
        foreach ($allOptionsGroup as $gro) {
            $type = get_data_by_id('type', 'cc_option', 'option_id', $gro->option_id);
            $name = get_data_by_id('name', 'cc_option', 'option_id', $gro->option_id);
            $view .= '<p class="tit-op " >' . $name . ' <span class="mess-alert  ' . strtolower($name) . '"></span></p>';
            $view .= $this->optionType($type,$gro->option_id,$product_id,$name);
        }

        return $view;
    }

    /**
     * @description This method provides option type
     * @param string $type
     * @param int $option_id
     * @param int $product_id
     * @param string $name
     * @return string|void
     */
    private function optionType($type,$option_id,$product_id,$name){
        if ($type == 'radio'){
            return $this->typeRadio($option_id,$product_id,$name);
        }
        if ($type == 'select'){
            return $this->typeSelect($option_id,$product_id,$name);
        }

    }

    /**
     * @description This method provides type radio
     * @param int $option_id
     * @param int $product_id
     * @param string $name
     * @return string
     */
    private function typeRadio($option_id,$product_id,$name){
        $table = DB()->table('cc_product_option');
        $data = $table->where('option_id',$option_id)->where('product_id',$product_id)->get()->getResult();
        $view = '<ul class="list-unstyled filter-items mb-3">';
        foreach($data as $key=> $opVal){
            $fildName = str_replace(' ','',$name);
            $view .='<li class="mt-2"><input type="radio" class="btn-check" oninput="optionPriceCalculate('.$product_id.')"  name="'.strtolower($fildName).'" id="option_'.$opVal->option_value_id.'" value="'.$opVal->option_value_id.'"  autocomplete="off" required>';

                $nameVal = get_data_by_id('name','cc_option_value','option_value_id',$opVal->option_value_id);
                $firstCar =  mb_substr($nameVal, 0, 1); $length = strlen($nameVal);
                $isColor = (($firstCar == '#') && ($length == 7))?'':$nameVal;
                $nameOp = !empty($isColor)?$isColor:'';
                $style = empty($isColor)?"background-color: $nameVal;padding: 15px 18px; border: unset;":"";

            $view .='<label class="btn btn-outline-secondary pd-new"  style="'.$style.' border-radius: unset; margin-left:8px;"  for="option_'.$opVal->option_value_id.'">
                '.$nameOp.'</label></li>';
        }
        $view .='</ul>';
        return $view;
    }

    /**
     * @description This method provides type Select
     * @param int $option_id
     * @param int $product_id
     * @param string $name
     * @return string
     */
    private function typeSelect($option_id,$product_id,$name){
        $table = DB()->table('cc_product_option');
        $data = $table->where('option_id',$option_id)->where('product_id',$product_id)->get()->getResult();
        $fildName = str_replace(' ','',$name);
        $view = '<select name="'.strtolower($fildName).'"  onchange="optionPriceCalculate('.$product_id.')" class="form-control detail-select my-2" required><option value="" >Please select</option>';
        foreach($data as $key=> $opVal){
            $nameVal = get_data_by_id('name','cc_option_value','option_value_id',$opVal->option_value_id);
            $firstCar =  mb_substr($nameVal, 0, 1); $length = strlen($nameVal);
            $isColor = (($firstCar == '#') && ($length == 7))?'':$nameVal;
            $nameOp = !empty($isColor)?$isColor:'';
            $style = empty($isColor)?"background-color: $nameVal;padding: 15px 18px; border: unset;":"";
            $view .='<option value="'.$opVal->option_value_id.'" style="'.$style.'" >'.$nameVal.'</option>';
        }
        $view .='</select>';
        return $view;
    }

    /**
     * @description This method provides product not found page view
     * @return void
     */
    public function product_not_found(){
        $settings = get_settings();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        $data['page_title'] = 'Product Not Found';
        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Product/not_found');
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides product image download
     * @return false|string
     */
    public function productImageDownload(){
        $product_id = $this->request->getPost('product_id');
        $image_id = $this->request->getPost('image_id');
        $condition = $this->request->getPost('condition');
        $downloadUrl = '';
        $unlinkUrl = '';
        if (empty($image_id)) {
            $target_dir = FCPATH . '/uploads/products/' . $product_id . '/';
            $image = get_data_by_id('image', 'cc_products', 'product_id', $product_id);
            $mainImage = str_replace("pro_", "", $image);
            $downloadUrl = base_url('/uploads/products/' . $product_id . '/'. $mainImage) ;
            if ($condition == 'watermark') {
                $this->image_processing->watermark_main_image($target_dir, $mainImage);
                $downloadUrl = base_url('/uploads/products/' . $product_id . '/'.'wm_' . $mainImage) ;
                $unlinkUrl = $target_dir.'wm_'.$mainImage;
            }

        }else {
            $target_dir = FCPATH . '/uploads/products/' . $product_id . '/'. $image_id . '/';
            $image = get_data_by_id('image', 'cc_product_image', 'product_image_id', $image_id);
            $subImage = str_replace("pro_", "", $image);
            $downloadUrl = base_url('/uploads/products/' . $product_id . '/'. $image_id . '/'. $subImage) ;
            if ($condition == 'watermark') {
                $this->image_processing->watermark_main_image($target_dir, $subImage);
                $downloadUrl = base_url('/uploads/products/' . $product_id . '/'. $image_id . '/'. 'wm_' .$subImage);
                $unlinkUrl = $target_dir.'wm_'.$subImage;
            }

        }

        $data['downloadUrl'] = $downloadUrl;
        $data['unlinkUrl'] = $unlinkUrl;
        $data['csrfToken'] = csrf_hash();

        return json_encode($data);
    }

    /**
     * @description This method provides product image unlink
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function productImageUnlink(){
        $url = $this->request->getPost('url');
        $this->image_processing->image_unlink($url);

        return $this->response->setHeader('X-CSRF-TOKEN', csrf_hash());
    }

}
