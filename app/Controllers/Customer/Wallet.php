<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Wallet extends BaseController
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
            $table = DB()->table('cc_found_request');
            $data['found_request'] = $table->where('customer_id', $this->session->cusUserId)->get()->getResult();

            $tableBal = DB()->table('cc_customer');
            $data['cust'] = $tableBal->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $data['page_title'] = 'Walllet';
            $data['menu_active'] = 'walllet';
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/header', $data);
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/Customer/menu');
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/Customer/walllet');
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/footer');
        }
    }

    public function add_founds()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $table = DB()->table('cc_found_request');
            $data['found_request'] = $table->where('customer_id', $this->session->cusUserId)->get()->getResult();

            $tableBal = DB()->table('cc_customer');
            $data['cust'] = $tableBal->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $data['page_title'] = 'Dashboard';
            $data['menu_active'] = 'dashboard';
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/header', $data);
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/Customer/menu');
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/Customer/add_founds');
            echo view('Theme/' . get_lebel_by_value_in_settings('Theme') . '/footer');
        }
    }

    public function found_action(){
        $data['amount'] = $this->request->getPost('amount');
        $data['payment_method_id'] = $this->request->getPost('payment_method_id');
        $data['customer_id'] = $this->session->cusUserId;

        $this->validation->setRules([
            'amount' => ['label' => 'Amount', 'rules' => 'required'],
            'payment_method_id' => ['label' => 'Payment Method', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert text-white alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('add_founds');
        } else {

            if($data['payment_method_id'] == '7'){
                $data['card_name'] = $this->request->getPost('card_name');
                $data['card_number'] = $this->request->getPost('card_number');
                $data['card_expiration'] = $this->request->getPost('card_expiration');
                $data['card_cvc'] = $this->request->getPost('card_cvc');
            }

            $table = DB()->table('cc_found_request');
            $table->insert($data);
            
            $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Update successfully </div>');
            return redirect()->to('my_wallet');
        }
    }
}