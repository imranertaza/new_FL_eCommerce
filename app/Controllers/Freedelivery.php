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

    public function index(){
        $table = DB()->table('products');
        $data['products'] = $table->where('status','Active')->get()->getResult();

        $data['keywords'] = 'Free delivery';
        $data['description'] = 'Free delivery';
        $data['title'] = 'Free delivery';

        $data['page_title'] = 'About Us';
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/header',$data);
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/Home/index',$data);
        echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/footer');
    }
}
