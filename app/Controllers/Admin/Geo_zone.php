<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Geo_zone extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Geo_zone';

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

            $table = DB()->table('cc_geo_zone');
            $data['geo_zone'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Geo_zone/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Geo_zone/create');
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function create_action()
    {
        $data['geo_zone_name'] = $this->request->getPost('geo_zone_name');
        $data['geo_zone_description'] = $this->request->getPost('geo_zone_description');

        $country_id = $this->request->getPost('country_id[]');
        $zone_id = $this->request->getPost('zone_id[]');

        $this->validation->setRules([
            'geo_zone_name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('geo_zone_create');
        } else {

            $exist = $this->check_exist_to_create($country_id,$zone_id);

            if ($exist == true) {
                $table = DB()->table('cc_geo_zone');
                $table->insert($data);
                $geo_zone_id = DB()->insertID();


                foreach ($country_id as $key => $val) {
                    $zoneData['geo_zone_id'] = $geo_zone_id;
                    $zoneData['country_id'] = $val;
                    $zoneData['zone_id'] = $zone_id[$key];

                    $tableZone = DB()->table('cc_geo_zone_details');
                    $tableZone->insert($zoneData);
                }


                $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to('geo_zone_create');
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"> Zone already exist ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to('geo_zone_create');
            }


        }
    }

    public function update($geo_zone_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_geo_zone');
            $data['geo_zone'] = $table->where('geo_zone_id', $geo_zone_id)->get()->getRow();

            $tableZone = DB()->table('cc_geo_zone_details');
            $data['geo_zone_detail'] = $tableZone->where('geo_zone_id', $geo_zone_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Geo_zone/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    public function update_action()
    {
        $geo_zone_id = $this->request->getPost('geo_zone_id');

        $data['geo_zone_name'] = $this->request->getPost('geo_zone_name');
        $data['geo_zone_description'] = $this->request->getPost('geo_zone_description');

        $country_id = $this->request->getPost('country_id[]');
        $zone_id = $this->request->getPost('zone_id[]');
        $geo_zone_details_id = $this->request->getPost('geo_zone_details_id[]');

        $this->validation->setRules([
            'geo_zone_name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('geo_zone_update/' . $geo_zone_id);
        } else {
            $table = DB()->table('cc_geo_zone');
            $table->where('geo_zone_id',$geo_zone_id)->update($data);

            $exist = $this->check_exist_to_create($country_id,$zone_id);
            foreach ($country_id as $key => $val){
                if (empty($geo_zone_details_id[$key])) {
                    if ($exist == true) {
                        $zoneData['geo_zone_id'] = $geo_zone_id;
                        $zoneData['country_id'] = $val;
                        $zoneData['zone_id'] = $zone_id[$key];

                        $tableZone = DB()->table('cc_geo_zone_details');
                        $tableZone->insert($zoneData);
                    }else{
                        $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"> Zone already exist ! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        return redirect()->to('geo_zone_update/' . $geo_zone_id);
                    }
                }else{
                    $zoneData['country_id'] = $val;
                    $zoneData['zone_id'] = $zone_id[$key];
                    $tableZone = DB()->table('cc_geo_zone_details');
                    $tableZone->where('geo_zone_details_id',$geo_zone_details_id[$key])->update($zoneData);
                }
            }

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('geo_zone_update/' . $geo_zone_id);

        }
    }

    public function delete($geo_zone_id){

        $tableZone = DB()->table('cc_geo_zone_details');
        $tableZone->where('geo_zone_id', $geo_zone_id)->delete();

        $table = DB()->table('cc_geo_zone');
        $table->where('geo_zone_id', $geo_zone_id)->delete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('geo_zone');
    }

    public function geo_zone_detail_delete(){

        $geo_zone_details_id = $this->request->getPost('geo_zone_details_id');

        $table = DB()->table('cc_geo_zone_details');
        $table->where('geo_zone_details_id', $geo_zone_details_id)->delete();

        print '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

    }

    private function check_exist_to_create($country_id_array,$zone_id_array){
        foreach ($country_id_array as $key => $con) {
            if ($zone_id_array[$key] != 0) {
                $table = DB()->table('cc_geo_zone_details');
                $data = $table->where('country_id', $con)->where('zone_id', $zone_id_array[$key])->countAllResults();
                if (empty($data)) {
                    $tableZone = DB()->table('cc_geo_zone_details');
                    $data = $tableZone->where('country_id', $con)->where('zone_id', '0')->countAllResults();
                    if (empty($data)) {
                        $result = true;
                    } else {
                        $result = false;
                    }
                } else {
                    $result = false;
                }
            }else{
                $tableZone = DB()->table('cc_geo_zone_details');
                $data = $tableZone->where('country_id', $con)->countAllResults();
                if (empty($data)) {
                    $result = true;
                } else {
                    $result = false;
                }
            }
        }

        return $result;
    }

}
