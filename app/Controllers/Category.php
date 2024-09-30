<?php

namespace App\Controllers;

use App\Libraries\Filter;
use App\Models\CategoryproductsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Category extends BaseController {

    protected $validation;
    protected $session;
    protected $filter;
    protected $categoryproductsModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->categoryproductsModel = new CategoryproductsModel();
        $this->filter = new Filter();
    }

    /**
     * @description This method provides category page view
     * @param int $cat_id
     * @return void
     */
    public function index($cat_id){
        $settings = get_settings();

        $categoryWhere = !empty($this->request->getGetPost('category'))? 'category_id = '.$this->request->getGetPost('category'): 'category_id = '.$cat_id;

        $data['optionval'] = array();
        $data['brandval'] = array();
        $data['ratingval'] = array();
        $data['keywordSearch'] = '';

        $limit = $settings['category_product_limit'];

        $where = "$categoryWhere ";
        $data['products'] = $this->categoryproductsModel->where($where)->orderBy('cc_products.product_id','DESC')->query()->paginate($limit);
        $data['pager'] = $this->categoryproductsModel->pager;
        $data['links'] = $data['pager']->links('default','custome_link');

        $table = DB()->table('cc_product_category');
        $data['parent_Cat'] = $table->where('parent_id',$cat_id)->get()->getResult();
        $data['main_Cat'] = $table->where('parent_id',null)->get()->getResult();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = get_data_by_id('category_name','cc_product_category','prod_cat_id',$cat_id);

        $productsArr = $this->categoryproductsModel->where($where)->orderBy('cc_products.product_id','DESC')->query()->findAll();

        $filter = $this->filter->getSettings($productsArr);
        $data['price'] = $filter->product_array_by_price_range();
        $data['optionView'] = $filter->product_array_by_options($data['optionval']);
        $data['brandView'] = $filter->product_array_by_brand($data['brandval']);
        $data['ratingView'] = $filter->product_array_by_rating_view($data['ratingval']);
        $data['productsArr'] = $productsArr;

//        print $data['optionView'];
//        die();
        setcookie('category_cookie',$cat_id,time()+86400, "/");

        $data['prod_cat_id'] = $cat_id;
        $data['page_title'] = 'Category products';
        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Category/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer', $data);
    }

    /**
     * @description This method provides url generate
     * @return RedirectResponse
     */
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
        $global_search = $this->request->getPost('global_search');

        $category_cookie = isset($_COOKIE['category_cookie']) ? $_COOKIE['category_cookie'] : '';

        $selCategory = !empty($category)?$category:$cat;

        $vars = array();

        if (($category_cookie == $selCategory) || (!empty($global_search))){

            if (!empty($brand)) {
                $menu = '';
                foreach ($brand as $key => $brVal) {
                    $menu .= $brVal . ',';
                }
                $vars ['manufacturer'] = rtrim($menu, ',');
            }

            if (!empty($options)) {
                $option = '';
                foreach ($options as $key => $optVal) {
                    $option .= $optVal . ',';
                }
                $vars ['option'] = rtrim($option, ',');
            }

            if (!empty($price)) {
                $vars ['price'] = $price;
            }

            if (!empty($rating)) {
                $rat = '';
                foreach ($rating as $key => $ratVal) {
                    $rat .= $ratVal . ',';
                }
                $vars ['rating'] = rtrim($rat, ',');
            }
        }else{
            setcookie('category_cookie',$category,time()+86400, "/");
        }

        if (!empty($global_search)) {
            $vars ['keywordTop'] = $global_search;
        }

        if (!empty($category)) {
            $vars ['category'] = $category;
        }

        if (!empty($shortBy)) {
            $vars ['shortBy'] = $shortBy;
        }
        if (!empty($show)) {
            $vars ['show'] = $show;
        }


        $querystring = http_build_query($vars);
        return redirect()->to('products/search?cat='.$cat.'&'.$querystring);

    }


}
