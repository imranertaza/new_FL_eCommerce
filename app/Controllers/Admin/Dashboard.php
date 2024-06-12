<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Dashboard extends BaseController
{

    protected $validation;
    protected $session;
    protected $permission;
    private $module_name = 'Dashboard';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
    }

    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $tableOrderStatus = DB()->table('cc_order_status');
            $orStatus = $tableOrderStatus->get()->getResult();
            foreach ($orStatus as $val){
                $pending = ($val->name == 'Pending')?$val->order_status_id:'';
                $processing = ($val->name == 'Processing')?$val->order_status_id:'';
                $canceled = ($val->name == 'Canceled')?$val->order_status_id:'';
            }

            $table = DB()->table('cc_order');
            $data['allOrder'] = $table->countAllResults();
            $data['pendingOrder'] = $table->where('status',$pending)->countAllResults();
            $data['processingOrder'] = $table->where('status',$processing)->countAllResults();
            $data['canceledOrder'] = $table->where('status',$canceled)->countAllResults();



            $tableCus = DB()->table('cc_customer');
            $data['totalCustomer'] = $tableCus->countAllResults();

            $data['totalCustomerYears'] = $tableCus->where('createdDtm >',date("Y-01-01"))->countAllResults();

            $tableReview = DB()->table('cc_product_feedback');
            $data['totalReviewPending'] = $tableReview->where('status','Pending')->countAllResults();

            $tableProducts = DB()->table('cc_products');
            $data['totalProductShort'] = $tableProducts->where('quantity <' ,'5')->countAllResults();

            $tableOrder = DB()->table('cc_order');

            $data['order'] = $tableOrder->countAllResults();
            $data['orderYear'] = $tableOrder->where('createdDtm >',date("Y-01-01"))->countAllResults();


            $data['orderAmo'] = $tableOrder->selectSum('final_amount')->get()->getRow()->final_amount;
            $data['orderAmoYear'] = $tableOrder->selectSum('final_amount')->where('createdDtm >',date("Y-01-01"))->get()->getRow()->final_amount;

            $data['orderLast'] = $tableOrder->orderBy('order_id','DESC')->limit(10)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Dashboard/index',$data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

}
