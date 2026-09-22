<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Option extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Option';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides option page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_option');
            $data['option'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Option/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides option create page view
     * @return RedirectResponse|void
     */
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
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Option/create');
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides option create action
     * @return RedirectResponse
     */
    public function create_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['type'] = $this->request->getPost('type');
        $value = $this->request->getPost('value[]');

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'type' => ['label' => 'Type', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('option');
        } else {

            $table = DB()->table('cc_option');
            $table->insert($data);
            $optionID = DB()->insertID();

            $dataval = [];
            foreach ($value as $key => $val){
                $dataval[$key] = [
                    'option_id' => $optionID,
                    'name' => $val,
                ];
            }
            $tableVal = DB()->table('cc_option_value');
            $tableVal->insertBatch($dataval);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Option Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('option');
        }
    }

    /**
     * @description This method provides option update page view
     * @param int $option_id
     * @return RedirectResponse|void
     */
    public function update($option_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_option');
            $data['option'] = $table->where('option_id', $option_id)->get()->getRow();

            $tableVal = DB()->table('cc_option_value');
            $data['optionVal'] = $tableVal->where('option_id', $option_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Option/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides option update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $option_id    = $this->request->getPost('option_id');
        $data['name'] = $this->request->getPost('name');
        $data['type'] = $this->request->getPost('type');
        $value        = $this->request->getPost('value');   // ← fixed (no [])

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'type' => ['label' => 'Type', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('option_update/' . $option_id);
        }

        // Remove empty values
        $value = array_filter(array_map('trim', $value ?? []));

        if (empty($value)) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please Add Value !<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('option_update/' . $option_id);
        }

        // Update main option
        DB()->table('cc_option')->where('option_id', $option_id)->update($data);

        // Delete old values
        DB()->table('cc_option_value')->where('option_id', $option_id)->delete();

        // Insert all values (old + new)
        $batchData = [];
        foreach ($value as $val) {
            $batchData[] = [
                'option_id' => $option_id,
                'name'      => $val,
            ];
        }
        // Insert all at once
        DB()->table('cc_option_value')->insertBatch($batchData);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Option Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('option_update/' . $option_id);
    }

    /**
     * @description This method provides option delete
     * @param int $option_id
     * @return RedirectResponse
     */
    public function delete($option_id){

        $tabOp = DB()->table('cc_product_option');
        $tabOp->where('option_id', $option_id)->delete();

        $tableVal = DB()->table('cc_option_value');
        $tableVal->where('option_id', $option_id)->delete();

        $table = DB()->table('cc_option');
        $table->where('option_id', $option_id)->delete();


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Option Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('option');
    }

    /**
     * @description This method provides option remove action
     * @return void
     */
    public function option_remove_action(){
        $option_value_id = $this->request->getPost('id');

        $tabOp = DB()->table('cc_product_option');
        $tabOp->where('option_value_id', $option_value_id)->delete();

        $tableValDel = DB()->table('cc_option_value');
        $tableValDel->where('option_value_id', $option_value_id)->delete();
    }

    public function optionAddAction()
    {
        $option_id = $this->request->getPost('option_id');
        $name      = trim($this->request->getPost('value'));

        // ✅ Validation
        if (empty($name)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Value is required',
                'csrfHash' => csrf_hash()
            ]);
        }


        // ✅ Insert
        $data = [
            'option_id' => $option_id,
            'name'      => $name
        ];

        $table = DB()->table('cc_option_value');
        $table->insert($data);
        $insert_id = DB()->insertID();

        // ✅ Success response
        return $this->response->setJSON([
            'status'   => 'success',
            'id'       => $insert_id,
            'value'    => $name,
            'csrfHash' => csrf_hash()
        ]);
    }

}
