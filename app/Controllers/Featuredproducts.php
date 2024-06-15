<?php

namespace App\Controllers;

use App\Models\ProductsModel;

class Featuredproducts extends BaseController {

    protected $validation;
    protected $session;
    protected $productsModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->productsModel = new ProductsModel();
    }

    public function index(){
        $settings = get_settings();
        $data['products'] = $this->productsModel->where('status','Active')->where('featured','1')->paginate(10);
        $data['pager'] = $this->productsModel->pager;
        $data['links'] = $data['pager']->links('default','custome_link');

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Featured Products';

        $data['page_title'] = 'Featured Products';
        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Featuredproducts/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }
}
