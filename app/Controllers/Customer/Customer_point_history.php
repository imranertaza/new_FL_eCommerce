<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class Customer_point_history extends BaseController
{

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    /**
     * @description This method provides customer ledger page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_customer_point_history');
            $data['point_history'] = $table->where('customer_id',$this->session->cusUserId)->orderBy('ledg_id','ASC')->limit(20)->get()->getResult();

            $tableBal = DB()->table('cc_customer');
            $data['cust'] = $tableBal->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Point History';
            $data['page_title'] = 'Point History';
            $data['menu_active'] = 'point_history';
            echo view('Theme/'.$settings['Theme'].'/header',$data);
            echo view('Theme/'.$settings['Theme'].'/Customer/menu');
            echo view('Theme/'.$settings['Theme'].'/Customer/customer_point_history');
            echo view('Theme/'.$settings['Theme'].'/footer');
        }
    }

   

}
