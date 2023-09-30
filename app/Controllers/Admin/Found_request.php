<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Found_request extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Found_request';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_found_request');
            $data['found_request'] = $table->get()->getResult();
            
            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Found_request/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function found_action() {
        $found_request_id = $this->request->getPost('found_request_id');
        $data['status'] = $this->request->getPost('status');

        $table = DB()->table('cc_found_request');
        $table->where('found_request_id',$found_request_id)->update($data);

        if($data['status'] == 'Complete'){
            $tabledata = DB()->table('cc_found_request');
            $row = $tabledata->where('found_request_id',$found_request_id)->get()->getRow();

            $oldBalance = get_data_by_id('balance','cc_customer','customer_id',$row->customer_id);
            $newBalance = $oldBalance + $row->amount;
            
            $cusData['balance'] = $newBalance;
            $tableCus = DB()->table('cc_customer');
            $tableCus->where('customer_id',$row->customer_id)->update($cusData);

            $cusLedg['customer_id'] = $row->customer_id;
            $cusLedg['found_request_id'] = $found_request_id;
            $cusLedg['payment_method_id'] = $row->payment_method_id;
            $cusLedg['particulars'] = 'Deposit balance';
            $cusLedg['trangaction_type'] = 'Cr.';
            $cusLedg['amount'] = $row->amount;
            $cusLedg['rest_balance'] = $newBalance;

            $tableCusLedg = DB()->table('cc_customer_ledger');
            $tableCusLedg->insert($cusLedg);

        }

        

        print  '<div class="alert alert-success alert-dismissible" role="alert">Update Record Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                
    }

    

}
