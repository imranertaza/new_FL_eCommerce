<?php

namespace App\Controllers;

use App\Models\CategoryproductsModel;
use App\Models\ProductsModel;

class Search extends BaseController {

    protected $validation;
    protected $session;
    protected $categoryproductsModel;
    protected $productsModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->categoryproductsModel = new CategoryproductsModel();
        $this->productsModel = new ProductsModel();

    }

    /**
     * @description This method provides product search page view
     * @return void
     */
    public function index(){
        $settings = get_settings();
        $table = DB()->table('products');
        $data['products'] = $table->where('status','Active')->limit(4)->get()->getResult();


        $data['prodFeat'] = $table->where('status','Active')->where('featured','1')->orderBy('product_id','DESC')->limit(8)->get()->getResult();

        $tabPopuler = DB()->table('product_category_popular');
        $data['populerCat'] = $tabPopuler->limit(12)->get()->getResult();


        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Search';

        $data['home_menu'] = true;

        echo view('Theme/'.$settings['Theme'].'/Home/index',$data);
    }

    /**
     * @description This method provides product search action page view
     * @return void
     */
    public function search_action(){
        $settings = get_settings();
        $top_category = $this->request->getPost('top_category');
        $keywordTop = $this->request->getPost('keywordTop');

        if(!empty($top_category)){
            $data['products'] = $this->categoryproductsModel->where('cc_product_to_category.category_id',$top_category)->like('cc_products.name', $keywordTop)->query()->paginate(9);
            $data['pager'] = $this->categoryproductsModel->pager;
        }else{
            $data['products'] = $this->productsModel->like('name', $keywordTop)->paginate(9);
            $data['pager'] = $this->productsModel->pager;
        }


        $data['links'] = $data['pager']->links('default','custome_link');

        $data['keywordTop'] = $keywordTop;
        $data['top_category'] = $top_category;

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Search';

        $data['page_title'] = 'Search';

        echo view('Theme/'.$settings['Theme'].'/Search/index',$data);
    }


}
