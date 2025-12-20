<?php

namespace App\Controllers;

class Freedelivery extends BaseController {

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    /**
     * @description This method provides free delivery page view
     * @return void
     */
    public function index(){
        $settings = get_settings();
        $table = DB()->table('products');
        $data['products'] = $table->where('status','Active')->get()->getResult();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Free delivery';

        $data['page_title'] = 'About Us';

        echo view('Theme/'.$settings['Theme'].'/Home/index',$data);
    }
}
