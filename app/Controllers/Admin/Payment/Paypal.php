<?php

namespace App\Controllers\Admin\Payment;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Paypal extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Bank_transfer';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides paypal settings page view
     * @param $payment_method_id
     * @return RedirectResponse|void
     */
    public function settings($payment_method_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_payment_method');
            $data['payment'] = $table->where('payment_method_id', $payment_method_id)->get()->getFirstRow();

            $table = DB()->table('cc_payment_settings');
            $data['payment_settings'] = $table->where('payment_method_id', $payment_method_id)->where('label !=', 'api_url')->get()->getResult();

            $data['payment_method_id'] = $payment_method_id;

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Payment/paypal', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    /**
     * @description This method provides paypal update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $payment_method_id = $this->request->getPost('payment_method_id');

        //settings update
        $label = $this->request->getPost('label[]');
        $id = $this->request->getPost('id[]');
        foreach ($label as $key => $val) {
            $table = DB()->table('cc_payment_settings');
            $table->set('value', $val)->where('settings_id', $id[$key])->update();
        }


        //bank update

        if (!empty($_FILES['image']['name'])) {
            $target_dir = FCPATH . '/uploads/payment/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('image');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'paypal_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(120, 30, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);
            $data['image'] = $news_img;
        }


        $data['status'] = $this->request->getPost('status');
        $table = DB()->table('cc_payment_method');
        $table->where('payment_method_id', $payment_method_id)->update($data);


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('paypal/' . $payment_method_id);
    }
}
