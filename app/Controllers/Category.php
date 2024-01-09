<?php

namespace App\Controllers;

use App\Models\CategoryproductsModel;

class Category extends BaseController {

    protected $validation;
    protected $session;
    protected $categoryproductsModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->categoryproductsModel = new CategoryproductsModel();
    }

    public function index($cat_id){
        $categoryWhere = !empty($this->request->getGetPost('category'))? 'category_id = '.$this->request->getGetPost('category'): 'category_id = '.$cat_id;

        $data['optionval'] = array();
        $data['brandval'] = array();
        $data['ratingval'] = array();

        $limit = get_lebel_by_value_in_settings('category_product_limit');

        $where = "$categoryWhere ";
        $data['products'] = $this->categoryproductsModel->where($where)->orderBy('cc_products.product_id','DESC')->query()->paginate($limit);
        $data['pager'] = $this->categoryproductsModel->pager;
        $data['links'] = $data['pager']->links('default','custome_link');

        $table = DB()->table('cc_product_category');
        $data['parent_Cat'] = $table->where('parent_id',$cat_id)->get()->getResult();

        $data['keywords'] = get_lebel_by_value_in_settings('meta_keyword');
        $data['description'] = get_lebel_by_value_in_settings('meta_description');
        $data['title'] = get_data_by_id('category_name','cc_product_category','prod_cat_id',$cat_id);

        $data['prod_cat_id'] = $cat_id;
        $data['page_title'] = 'Category products';
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/header',$data);
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/Category/index',$data);
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/footer', $data);
    }

    public function url_generate(){

        $prod_cat_id = $this->request->getPost('prod_cat_id');
        $cat = $this->request->getPost('cat');
        $shortBy = $this->request->getPost('shortBy');
        $category = $this->request->getPost('category');
        $options = $this->request->getPost('options[]');
        $brand = $this->request->getPost('manufacturer[]');
        $rating = $this->request->getPost('rating[]');
        $price = $this->request->getPost('price');
        $show = $this->request->getPost('show');



        $vars = array();
        if (!empty($brand)) {
            $menu = '';
            foreach ($brand as $key => $brVal) {
                $menu .= $brVal . ',';
            }
            $vars ['manufacturer'] = rtrim($menu,',');
        }

        if (!empty($options)) {
            $option = '';
            foreach ($options as $key => $optVal) {
                $option .= $optVal.',' ;
            }
            $vars ['option'] = rtrim($option, ',');
        }

        if (!empty($category)){
            $vars ['category'] = $category;
        }

        if (!empty($shortBy)){
            $vars ['shortBy'] = $shortBy;
        }

        if (!empty($price)){
            $vars ['price'] = $price;
        }

        if (!empty($show)){
            $vars ['show'] = $show;
        }

        if (!empty($rating)) {
            $rat = '';
            foreach ($rating as $key => $ratVal) {
                $rat .= $ratVal . ',';
            }
            $vars ['rating'] = rtrim($rat,',');
        }

        $querystring = http_build_query($vars);
//        print $querystring;
//        die();
//        return redirect()->to('category/'.$prod_cat_id.'?'.$querystring);
        return redirect()->to('products/search?cat='.$cat.'&'.$querystring);

    }


}
