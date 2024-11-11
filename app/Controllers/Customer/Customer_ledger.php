<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class Customer_ledger extends BaseController
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
            $table = DB()->table('cc_customer_ledger');
            $data['ledger'] = $table->where('customer_id',$this->session->cusUserId)->get()->getResult();

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Account Ledger';

            $data['page_title'] = 'Ledger';
            $data['menu_active'] = 'ledger';
            echo view('Theme/'.$settings['Theme'].'/header',$data);
            echo view('Theme/'.$settings['Theme'].'/Customer/menu');
            echo view('Theme/'.$settings['Theme'].'/Customer/customer_ledger');
            echo view('Theme/'.$settings['Theme'].'/footer');
        }
    }

   

}
