<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Order extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Order';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides order page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_order');
            $data['order'] = $table->orderBy('order_id', 'DESC')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Order/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides order view
     * @param int $order_id
     * @return RedirectResponse|void
     */
    public function order_view($order_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_order');
            $data['order'] = $table->where('order_id', $order_id)->get()->getRow();

            $tableItem = DB()->table('cc_order_item');
            $data['orderItem'] = $tableItem->where('order_id', $order_id)->get()->getResult();

            $tablehistory = DB()->table('cc_order_history');
            $data['orderhistoryLast'] = $tablehistory->where('order_id', $order_id)->get()->getLastRow();
            $data['orderhistory'] = $tablehistory->where('order_id', $order_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Order/order_view', $data);
            } else {
                echo view('Admin/no_permission');
            }

        }
    }

    /**
     * @description This method provides history action
     * @return RedirectResponse
     */
    public function history_action()
    {
        $data['order_id'] = $this->request->getPost('order_id');
        $data['order_status_id'] = $this->request->getPost('order_status_id');
        $data['comment'] = $this->request->getPost('comment');

        $this->validation->setRules([
            'order_status_id' => ['label' => 'Status', 'rules' => 'required'],
            'comment' => ['label' => 'Comments', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('order_view/' . $data['order_id'] . '?selTab=history');
        } else {
            $table = DB()->table('cc_order_history');
            $table->insert($data);

            $dataOrder['status'] = $data['order_status_id'];
            $tableOrder = DB()->table('cc_order');
            $tableOrder->where('order_id',$data['order_id'])->update($dataOrder);

            if($data['order_status_id'] == '7'){
                $tabOrder = DB()->table('cc_order');
                $ord = $tabOrder->where('order_id',$data['order_id'])->get()->getRow();

                if (!empty($ord->customer_id)) {
                    $tableModule = DB()->table('cc_modules');
                    $query = $tableModule->join('cc_module_settings', 'cc_module_settings.module_id = cc_modules.module_id')->where('cc_modules.module_key','point')->get()->getRow();
                    if($query->status == '1') {
                        DB()->transStart();
                        $oldPoint = get_data_by_id('point', 'cc_customer', 'customer_id', $ord->customer_id);
                        $point = $ord->total_point;
                        $restPoint = $oldPoint - $point;

                        //customer point update
                        $cusPointData['point'] = $restPoint;
                        $tableCus = DB()->table('cc_customer');
                        $tableCus->where('customer_id', $ord->customer_id)->update($cusPointData);


                        //point history add
                        $cusPointHistory['customer_id'] = $ord->customer_id;
                        $cusPointHistory['order_id'] = $data['order_id'];
                        $cusPointHistory['particulars'] = 'product purchase point return';
                        $cusPointHistory['trangaction_type'] = 'Dr.';
                        $cusPointHistory['point'] = $point;
                        $cusPointHistory['rest_point'] = $restPoint;
                        $tablePoint = DB()->table('cc_customer_point_history');
                        $tablePoint->insert($cusPointHistory);

                        //order point update
                        $orPointData['total_point'] = 0;
                        $tabOrder = DB()->table('cc_order');
                        $tabOrder->where('order_id',$data['order_id'])->update($orPointData);
                        DB()->transComplete();
                    }
                }

            }

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"> History Add Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('order_view/' . $data['order_id'] . '?selTab=history');
        }
    }

    public function payment_status_action() {
        $order_id = $this->request->getPost('order_id');
        $data['payment_status'] = $this->request->getPost('status');

        $tableOrder = DB()->table('cc_order');
        $tableOrder->where('order_id',$order_id)->update($data);

        if($data['payment_status'] == 'Paid'){
            $tabOrder = DB()->table('cc_order');
            $ord = $tabOrder->where('order_id',$order_id)->get()->getRow();

            if (!empty($ord->customer_id)) {

                $tableModule = DB()->table('cc_modules');
                $query = $tableModule->join('cc_module_settings', 'cc_module_settings.module_id = cc_modules.module_id')->where('cc_modules.module_key','point')->get()->getRow();
                if($query->status == '1') {
                    DB()->transStart();
                    $oldPoint = get_data_by_id('point', 'cc_customer', 'customer_id', $ord->customer_id);
                    $point = $ord->total * $query->value;
                    $restPoint = $oldPoint + $point;

                    //customer point update
                    $cusPointData['point'] = $restPoint;
                    $tableCus = DB()->table('cc_customer');
                    $tableCus->where('customer_id', $ord->customer_id)->update($cusPointData);


                    //point history add
                    $cusPointHistory['customer_id'] = $ord->customer_id;
                    $cusPointHistory['order_id'] = $order_id;
                    $cusPointHistory['particulars'] = 'product purchase point';
                    $cusPointHistory['trangaction_type'] = 'Cr.';
                    $cusPointHistory['point'] = $point;
                    $cusPointHistory['rest_point'] = $restPoint;
                    $tablePoint = DB()->table('cc_customer_point_history');
                    $tablePoint->insert($cusPointHistory);

                    //order point update
                    $orPointData['total_point'] = $point;
                    $tabOrder = DB()->table('cc_order');
                    $tabOrder->where('order_id',$order_id)->update($orPointData);
                    DB()->transComplete();
                }
            }

        }

        print '<div class="alert alert-success alert-dismissible" role="alert"> Payment status update success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

    }

    public function point_action(){
        $data['order_id'] = $this->request->getPost('order_id');
        $data['status'] = $this->request->getPost('status');
        $data['amount'] = $this->request->getPost('amount');

        $this->validation->setRules([
            'status' => ['label' => 'Status', 'rules' => 'required'],
            'amount' => ['label' => 'Amount', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('order_view/' . $data['order_id'] . '?selTab=point');
        } else {

            $tabOrder = DB()->table('cc_order');
            $ord = $tabOrder->where('order_id',$data['order_id'])->get()->getRow();

            if ($data['status'] == 'add') {

                $tableModule = DB()->table('cc_modules');
                $query = $tableModule->join('cc_module_settings', 'cc_module_settings.module_id = cc_modules.module_id')->where('cc_modules.module_key','point')->get()->getRow();
                if($query->status == '1') {
                    $oldPoint = get_data_by_id('point', 'cc_customer', 'customer_id', $ord->customer_id);
                    $point = $data['amount'] ;
                    $restPoint = $oldPoint + $point;

                    //customer point update
                    $cusPointData['point'] = $restPoint;
                    $tableCus = DB()->table('cc_customer');
                    $tableCus->where('customer_id', $ord->customer_id)->update($cusPointData);


                    //point history add
                    $cusPointHistory['customer_id'] = $ord->customer_id;
                    $cusPointHistory['order_id'] = $data['order_id'];
                    $cusPointHistory['particulars'] = 'Point add by admin';
                    $cusPointHistory['trangaction_type'] = 'Cr.';
                    $cusPointHistory['point'] = $point;
                    $cusPointHistory['rest_point'] = $restPoint;
                    $tablePoint = DB()->table('cc_customer_point_history');
                    $tablePoint->insert($cusPointHistory);

                    //order point update
                    $orPointData['total_point'] = $ord->total_point + $point;
                    $tabOrder = DB()->table('cc_order');
                    $tabOrder->where('order_id',$data['order_id'])->update($orPointData);
                }
            }else{
                $tabOrder = DB()->table('cc_order');
                $ord = $tabOrder->where('order_id',$data['order_id'])->get()->getRow();

                if (!empty($ord->customer_id)) {
                    $tableModule = DB()->table('cc_modules');
                    $query = $tableModule->join('cc_module_settings', 'cc_module_settings.module_id = cc_modules.module_id')->where('cc_modules.module_key','point')->get()->getRow();
                    if($query->status == '1') {
                        $oldPoint = get_data_by_id('point', 'cc_customer', 'customer_id', $ord->customer_id);
                        $point = $data['amount'];
                        $restPoint = $oldPoint - $point;

                        //customer point update
                        $cusPointData['point'] = $restPoint;
                        $tableCus = DB()->table('cc_customer');
                        $tableCus->where('customer_id', $ord->customer_id)->update($cusPointData);


                        //point history add
                        $cusPointHistory['customer_id'] = $ord->customer_id;
                        $cusPointHistory['order_id'] = $data['order_id'];
                        $cusPointHistory['particulars'] = 'Point deducted by admin';
                        $cusPointHistory['trangaction_type'] = 'Dr.';
                        $cusPointHistory['point'] = $point;
                        $cusPointHistory['rest_point'] = $restPoint;
                        $tablePoint = DB()->table('cc_customer_point_history');
                        $tablePoint->insert($cusPointHistory);

                        //order point update
                        $orPointData['total_point'] = $ord->total_point - $point;
                        $tabOrder = DB()->table('cc_order');
                        $tabOrder->where('order_id',$data['order_id'])->update($orPointData);
                    }
                }
            }


            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"> Point Add Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('order_view/' . $data['order_id'] . '?selTab=point');
        }
    }



}
