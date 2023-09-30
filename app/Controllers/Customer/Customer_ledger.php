<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Customer_ledger extends BaseController
{

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $table = DB()->table('cc_customer_ledger');
            $data['ledger'] = $table->where('customer_id',$this->session->cusUserId)->get()->getResult();


            $data['page_title'] = 'Ledger';
            $data['menu_active'] = 'ledger';
            echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/header',$data);
            echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/Customer/menu');
            echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/Customer/customer_ledger');
            echo view('Theme/'.get_lebel_by_value_in_settings('Theme').'/footer');
        }
    }

   

}
