<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class Wallet extends BaseController
{

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    /**
     * @description This method provides wallet page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_fund_request');
            $data['fund_request'] = $table->where('customer_id', $this->session->cusUserId)->get()->getResult();

            $tableBal = DB()->table('cc_customer');
            $data['cust'] = $tableBal->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $data['page_title'] = 'Wallet';
            $data['menu_active'] = 'wallet';

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Wallet';

            echo view('Theme/' . $settings['Theme'] . '/Customer/walllet', $data);

        }
    }

    /**
     * @description This method provides add funds view
     * @return RedirectResponse|void
     */
    public function add_funds()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_fund_request');
            $data['fund_request'] = $table->where('customer_id', $this->session->cusUserId)->get()->getResult();

            $tableBal = DB()->table('cc_customer');
            $data['cust'] = $tableBal->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $data['page_title'] = 'Dashboard';
            $data['menu_active'] = 'dashboard';

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Account Add Fund';

            echo view('Theme/' . $settings['Theme'] . '/Customer/add_funds');
        }
    }

    /**
     * @description This method provides add funds action
     * @return RedirectResponse
     */
    public function fund_action(){
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

            $table = DB()->table('cc_fund_request');
            $table->insert($data);
            
            $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Update successfully </div>');
            return redirect()->to('my_wallet');
        }
    }
}