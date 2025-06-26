<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Coupon extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Coupon';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides coupon page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_coupon');
            $data['coupon'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Coupon/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon create page view
     * @return RedirectResponse|void
     */
    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_shipping_method');
            $data['shipping_method'] = $table->where('status',1)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Coupon/create',$data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon create action
     * @return RedirectResponse
     */
    public function create_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['code'] = $this->request->getPost('code');
        $data['discount'] = $this->request->getPost('discount');
        $data['total_useable'] = $this->request->getPost('total_useable');
        $data['date_start'] = $this->request->getPost('date_start');
        $data['date_end'] = $this->request->getPost('date_end');

        $data['discount_type'] = $this->request->getPost('discount_type');
        $data['discount_on'] = $this->request->getPost('discount_on');
        $data['for_subscribed_user'] = $this->request->getPost('for_subscribed_user');
        $data['for_registered_user'] = $this->request->getPost('for_registered_user');

        $shipping_method = $this->request->getPost('shipping_method[]');

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'code' => ['label' => 'Code', 'rules' => 'required'],
            'discount' => ['label' => 'Discount', 'rules' => 'required'],
            'total_useable' => ['label' => 'Total Useable', 'rules' => 'required'],
            'date_start' => ['label' => 'Start Date', 'rules' => 'required'],
            'date_end' => ['label' => 'End Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('coupon_create');
        } else {


            DB()->transStart();
                $table = DB()->table('cc_coupon');
                $table->insert($data);
                $coupon_id = DB()->insertID();


                //multi shipping charge discount
                if (!empty($shipping_method)){
                    $shipData = array();
                    foreach ($shipping_method as $v) {
                        $shData['shipping_method_id'] = $v;
                        $shData['coupon_id'] = $coupon_id;
                        array_push($shipData,$shData);
                    }
                    $tableShip = DB()->table('cc_coupon_shipping');
                    $tableShip->insertBatch($shipData);
                }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Coupon Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('coupon_create');
        }
    }

    /**
     * @description This method provides coupon update page view
     * @param int $coupon_id
     * @return RedirectResponse|void
     */
    public function update($coupon_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_coupon');
            $data['coupon'] = $table->where('coupon_id', $coupon_id)->get()->getRow();

            $table = DB()->table('cc_shipping_method');
            $data['shipping_method'] = $table->where('status',1)->get()->getResult();

            $tableCoup = DB()->table('cc_coupon_shipping');
            $data['coupon_ship'] = $tableCoup->where('coupon_id', $coupon_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Coupon/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $coupon_id = $this->request->getPost('coupon_id');
        $data['name'] = $this->request->getPost('name');
        $data['code'] = $this->request->getPost('code');
        $data['discount'] = $this->request->getPost('discount');
        $data['total_useable'] = $this->request->getPost('total_useable');
        $data['date_start'] = $this->request->getPost('date_start');
        $data['date_end'] = $this->request->getPost('date_end');

        $data['discount_on'] = $this->request->getPost('discount_on');
        $data['discount_type'] = $this->request->getPost('discount_type');
        $data['for_subscribed_user'] = $this->request->getPost('for_subscribed_user');
        $data['for_registered_user'] = $this->request->getPost('for_registered_user');

        $shipping_method = $this->request->getPost('shipping_method[]');

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'code' => ['label' => 'Code', 'rules' => 'required'],
            'discount' => ['label' => 'Discount', 'rules' => 'required'],
            'total_useable' => ['label' => 'Total Useable', 'rules' => 'required'],
            'date_start' => ['label' => 'Start Date', 'rules' => 'required'],
            'date_end' => ['label' => 'End Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('coupon_update/' . $coupon_id);
        } else {

            DB()->transStart();
                $table = DB()->table('cc_coupon');
                $table->where('coupon_id', $coupon_id)->update($data);

                //multi shipping charge discount delete
                $table = DB()->table('cc_coupon_shipping');
                $table->where('coupon_id', $coupon_id)->delete();

                //multi shipping charge discount
                if (!empty($shipping_method)){
                    $shipData = array();
                    foreach ($shipping_method as $v) {
                        $shData['shipping_method_id'] = $v;
                        $shData['coupon_id'] = $coupon_id;
                        array_push($shipData,$shData);
                    }
                    $tableShip = DB()->table('cc_coupon_shipping');
                    $tableShip->insertBatch($shipData);
                }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Coupon Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('coupon_update/' . $coupon_id);

        }
    }

    /**
     * @description This method provides coupon delete
     * @param $coupon_id
     * @return RedirectResponse
     */
    public function delete($coupon_id){

        $table = DB()->table('cc_coupon_shipping');
        $table->where('coupon_id', $coupon_id)->delete();

        $table = DB()->table('cc_coupon');
        $table->where('coupon_id', $coupon_id)->delete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Coupon Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('coupon');
    }

}
