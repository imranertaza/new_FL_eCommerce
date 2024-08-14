<?php

namespace App\Controllers;

use App\Libraries\Filter;
use App\Models\CategoryproductsModel;
use App\Models\ProductsSearchModel;

class Products extends BaseController {

    protected $validation;
    protected $session;
    protected $categoryproductsModel;
    protected $productsSearchModel;
    protected $filter;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->categoryproductsModel = new CategoryproductsModel();
        $this->productsSearchModel = new ProductsSearchModel();
        $this->filter = new Filter();
    }

    public function search(){
        $cat_id = $this->request->getGetPost('cat');
        $keyword = $this->request->getGetPost('keywordTop');
        $data['top_category'] = $cat_id;
        $data['keywordTop'] = $keyword;
        $data['keywordSearch'] = $keyword;
        $settings = get_settings();

        $lemit = !empty($this->request->getGetPost('show'))?$this->request->getGetPost('show'):$settings['category_product_limit'];

        $shortBy = !empty($this->request->getGetPost('shortBy'))?$this->request->getGetPost('shortBy'):'';

        if ($shortBy == 'price_asc'){
            $shortBy = "`cc_products.price` ASC";
        }elseif($shortBy == 'price_desc'){
            $shortBy = "`cc_products.price` DESC";
        }else{
            $shortBy = "`cc_products.product_id` DESC";
        }

        $categoryId = !empty($this->request->getGetPost('category'))? $this->request->getGetPost('category'): $cat_id;
        $categoryWhere = !empty($this->request->getGetPost('category'))? 'category_id = '.$this->request->getGetPost('category'): 'category_id = '.$cat_id;


        $brand = explode(',', $this->request->getGetPost('manufacturer'));
        $options = explode(',', $this->request->getGetPost('option'));
        $price = explode(',', $this->request->getGetPost('price'));
        $rating = explode(',', $this->request->getGetPost('rating'));

        $data['optionval'] = array();
        if(empty($this->request->getGetPost('option'))) {
            $allOption = '1=1';
        }else {
            $optionWhere ='';
            foreach ($options as $valOp){
                $optionWhere .= 'option_value_id = '.$valOp. ' OR ';
            }
            $countOption = array();
            foreach ($options as  $key => $valOp){
                $optId = get_data_by_id('option_id','cc_product_option','option_value_id',$valOp);
                $arr = $optId;
                array_push($countOption,$arr);
            }

            $allOption = '('.rtrim($optionWhere, ' OR ').')';
            $data['optionval'] = $options;
        }

        $data['brandval'] = array();
        $manufacturer = $this->request->getGetPost('manufacturer');
        if(empty($this->request->getGetPost('manufacturer'))){
            $allbrand ='1=1';
        }else {
            $brandWhere ='';
            foreach ($brand as $valBr){
                $brandWhere .= 'brand_id = '.$valBr. ' OR ';
            }
            $allbrand = '('.rtrim($brandWhere, ' OR ').')';
            $data['brandval'] = $brand;
        }

        if(empty($this->request->getGetPost('price'))) {
            $firstPrice = '1=1';
            $lastPrice = '1=1';
        }else {
            $firstPrice = 'cc_products.price >= '.$price[0];
            $lastPrice = 'cc_products.price <= '.$price[1];
        }


        $data['ratingval'] = array();
        if(empty($this->request->getGetPost('rating'))){
            $allrating ='1=1';
        }else {
            $ratingWhere ='';
            foreach ($rating as $valRati){
                $ratingWhere .= 'average_feedback = '.$valRati. ' OR ';
            }
            $allrating = '('.rtrim($ratingWhere, ' OR ').')';
            $data['ratingval'] = $rating;
        }

        $where = "$categoryWhere AND $allOption AND $allbrand AND $allrating AND $firstPrice AND $lastPrice";

        if (empty($cat_id)){
            $where = "$allOption AND $allbrand AND $allrating AND $firstPrice AND $lastPrice";
        }

        $searchModel = empty($cat_id) ? 'productsSearchModel' : 'categoryproductsModel';


        $productsArr = array();
        $data['products'] = array();

        if (!empty($categoryId)) {
            if (empty($this->request->getGetPost('option'))) {
                $data['products'] = $this->$searchModel->where($where)->query()->orderBy($shortBy)->paginate($lemit);
            } else {
                $data['products'] = $this->$searchModel->where($where)->all_join()->having('COUNT(cc_products.product_id) >=', count(array_unique($countOption)))->orderBy($shortBy)->paginate($lemit);
            }
        }



        if (!empty($keyword)){
            if(empty($this->request->getGetPost('option'))) {
                $data['products'] = $this->$searchModel->where($where)->like('cc_products.name', $keyword)->query()->orderBy($shortBy)->paginate($lemit);
            }else{
                $data['products'] = $this->$searchModel->where($where)->like('cc_products.name', $keyword)->all_join()->orderBy($shortBy)->paginate($lemit);
            }
        }


        if (!empty($data['products'])) {
            $data['pager'] = $this->$searchModel->pager;
            $data['links'] = $data['pager']->links('default', 'custome_link');
        }else {
            $data['pager'] = '';
            $data['links'] = '';
        }


        if (!empty($cat_id)) {
            $productsArr = $this->$searchModel->where($categoryWhere)->query()->findAll();
        }else{
            if (empty($manufacturer)) {
                if(!empty($keyword)) {
                    $productsArr = $this->$searchModel->like('cc_products.name', $keyword)->query()->findAll();
                }
            }else{
                $productsArr = $this->$searchModel->where($allbrand)->like('cc_products.name', $keyword)->query()->findAll();
                //make search base query
                $productsBas = $this->$searchModel->like('cc_products.name', $keyword)->query()->findAll();
            }
        }


        $filter = $this->filter->getSettings($productsArr);
        $data['price'] = $filter->product_array_by_price_range();
        $data['optionView'] = $filter->product_array_by_options($data['optionval']);
        $data['brandView'] = $filter->product_array_by_brand($data['brandval']);
        $data['ratingView'] = $filter->product_array_by_rating_view($data['ratingval']);
        $data['productsArr'] = $productsArr;

        if (!empty($manufacturer) && !empty($keyword)) {
            $data['brandView'] = $filter->getSettings($productsBas)->product_array_by_brand($data['brandval']);
        }

        $data['searchPrice'] = !empty($price[0]) ? $price[0] : '';
        $data['fstprice'] = !empty($price[0]) ? $price[0] : $data['price']['minPrice'];
        $data['lstPrice'] = !empty($price[1]) ? $price[1] : $data['price']['maxPrice'];

        $table = DB()->table('cc_product_category');
        $data['parent_Cat'] = $table->where('parent_id',$cat_id)->get()->getResult();

        $table = DB()->table('cc_product_category');
        $data['main_Cat'] = $table->where('parent_id',null)->get()->getResult();


        $data['prod_cat_id'] = $cat_id;
        $data['page_title'] = 'Category products';

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = (!empty($cat_id))?get_data_by_id('category_name','cc_product_category','prod_cat_id',$cat_id):'Search';



        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Category/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer', $data);
    }


}
