<?php

namespace App\Controllers\Admin\Shipping;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Shipping extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Shipping';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides shipping page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_shipping_method');
            $data['shipping'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Shipping/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides shipping settings
     * @param int $shipping_method_id
     * @return RedirectResponse|void
     */
    public function shipping_settings($shipping_method_id) {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_shipping_settings');
            $data['shipping'] = $table->where('shipping_method_id',$shipping_method_id)->get()->getResult();

            $data['shipping_method_id'] = $shipping_method_id;
            $data['shipping_status'] = get_data_by_id('status','cc_shipping_method','shipping_method_id',$shipping_method_id);

            $tableWeight = DB()->table('cc_weight_shipping_settings');
            $data['extra_settingd'] = $tableWeight->where('shipping_method_id',$shipping_method_id)->get()->getResult();


            $code = get_data_by_id('code','cc_shipping_method','shipping_method_id',$shipping_method_id);

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                if ($code == 'flat') {
                    echo view('Admin/Shipping/flat_rate', $data);
                }
                if ($code == 'zone') {
                    echo view('Admin/Shipping/zone', $data);
                }
                if ($code == 'weight') {
                    echo view('Admin/Shipping/weight', $data);
                }
                if ($code == 'zone_rate') {
                    echo view('Admin/Shipping/zone_rate', $data);
                }
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides shipping update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $shipping_method_id = $this->request->getPost('shipping_method_id');

        $label = $this->request->getPost('label[]');
        $id = $this->request->getPost('id[]');

        if (!empty($label)) {
            foreach ($label as $key => $val) {
                $table = DB()->table('cc_shipping_settings');
                $table->set('value', $val)->where('settings_id', $id[$key])->update();
            }
        }

        //Shipping status update
        $data['status'] = $this->request->getPost('status');
        $tableShipping = DB()->table('cc_shipping_method');
        $tableShipping->where('shipping_method_id', $shipping_method_id)->update($data);


        //weight settings
        $weight_label = $this->request->getPost('weight_label[]');
        $weight_value = $this->request->getPost('weight_value[]');
        $weight_id = $this->request->getPost('weight_id[]');
        if (!empty($weight_label)){
            foreach ($weight_label as $key => $val) {
//                $check = is_exists('cc_weight_shipping_settings','settings_id',$weight_id[$key]);
                if (empty($weight_id[$key]) ){
                    $dataWeight['shipping_method_id'] = $shipping_method_id;
                    $dataWeight['label'] = $val;
                    $dataWeight['value'] = $weight_value[$key];
                    $table = DB()->table('cc_weight_shipping_settings');
                    $table->insert($dataWeight);
                }else {
                    $table = DB()->table('cc_weight_shipping_settings');
                    $table->set('label', $val)->set('value', $weight_value[$key])->where('settings_id', $weight_id[$key])->update();
                }

            }
        }


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('shipping_settings/'.$shipping_method_id);


    }

    /**
     * @description This method provides shipping zone rate update action
     * @return RedirectResponse
     */
    public function zone_rate_update_action()
    {
        $shipping_method_id = $this->request->getPost('shipping_method_id');

        //shipping settings update
        $zone_rate_method = $this->request->getPost('zone_rate_method');
        $table = DB()->table('cc_shipping_settings');
        $table->set('value', $zone_rate_method)->where('shipping_method_id', $shipping_method_id)->update();


        //Shipping status update
        $data['status'] = $this->request->getPost('status');
        $tableShipping = DB()->table('cc_shipping_method');
        $tableShipping->where('shipping_method_id', $shipping_method_id)->update($data);



        //shipping rate add
        $up_to_value = $this->request->getPost('up_to_value[]');
        $cost = $this->request->getPost('cost[]');
        $geo_zone_id = $this->request->getPost('geo_zone_id[]');
        $cc_geo_zone_shipping_rate_id = $this->request->getPost('cc_geo_zone_shipping_rate_id[]');

        foreach ($up_to_value as $key => $v){
            if (!empty($cc_geo_zone_shipping_rate_id[$key])){
                $rateData['geo_zone_id'] = $geo_zone_id[$key];
                $rateData['up_to_value'] = $v;
                $rateData['cost'] = $cost[$key];
                $tableRate = DB()->table('cc_geo_zone_shipping_rate');
                $tableRate->where('cc_geo_zone_shipping_rate_id',$cc_geo_zone_shipping_rate_id[$key])->update($rateData);
            }else{
                $rateData['geo_zone_id'] = $geo_zone_id[$key];
                $rateData['up_to_value'] = $v;
                $rateData['cost'] = $cost[$key];
                $tableRate = DB()->table('cc_geo_zone_shipping_rate');
                $tableRate->insert($rateData);
            }
        }
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('shipping_settings/'.$shipping_method_id);


    }

    /**
     * @description This method provides shipping zone rate delete
     * @return void
     */
    function zone_rate_delete(){
        $cc_geo_zone_shipping_rate_id = $this->request->getPost('cc_geo_zone_shipping_rate_id');
        $table = DB()->table('cc_geo_zone_shipping_rate');
        $table->where('cc_geo_zone_shipping_rate_id', $cc_geo_zone_shipping_rate_id)->delete();

        print '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    /**
     * @description This method provides shipping update status
     * @return void
     */
    public function update_status(){
        $shipping_method_id = $this->request->getPost('id');
        $oldStatus = get_data_by_id('status','cc_shipping_method','shipping_method_id',$shipping_method_id);
        if ($oldStatus == '1'){
            $data['status'] = '0';
        }else{
            $data['status'] = '1';
        }
        $table = DB()->table('cc_shipping_method');
        $table->where('shipping_method_id', $shipping_method_id)->update($data);

        print '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    /**
     * @description This method provides shipping remove settings weight
     * @return void
     */

    public function remove_settings_weight(){
        $settings_id = $this->request->getPost('settings_id');
        $table = DB()->table('cc_weight_shipping_settings');
        $table->where('settings_id', $settings_id)->delete();

        print '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

}
