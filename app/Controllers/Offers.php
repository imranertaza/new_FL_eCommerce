<?php

namespace App\Controllers;


use CodeIgniter\I18n\Time;

class Offers extends BaseController {

    protected $validation;
    protected $session;
    protected $encrypter;
    protected $currentDate;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
        $this->currentDate = Time::now();
    }

    /**
     * @description This method provides Qc picture page view
     * @return void
     */
    public function index(){
        $settings = get_settings();

        $table = DB()->table('cc_offer');
        $data['offers'] = $table->where('expire_date >=', $this->currentDate->toDateString() )->get()->getResult();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Offers/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides Qc picture detail page view
     * @param int $slug
     * @return void
     */
    public function view($slug){
        $settings = get_settings();

        $check = is_exists('cc_offer', 'slug', $slug);
        if ($check == true){
            return redirect()->to('qc-picture-not-found');
        }

        $table = DB()->table('cc_offer');
        $data['offer'] = $table->where('slug',$slug)->get()->getRow();

        $tableAll = DB()->table('cc_offer_on_product');
        $data['products'] = $tableAll->where('offer_id',$data['offer']->offer_id)->get()->getResult();


        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Offers/view',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }




}
