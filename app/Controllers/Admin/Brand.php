<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Brand extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Brand';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides brand page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_brand');
            $data['brand'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Brand/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides brand create page view
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
                echo view('Admin/Brand/create');
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides brand create action
     * @return RedirectResponse
     */
    public function create_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['createdBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('brand_create');
        } else {
            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/brand/';
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777);
                }

                //new image uplode
                $pic = $this->request->getFile('image');
                $namePic = $pic->getRandomName();
                $pic->move($target_dir, $namePic);
                $news_img = 'brand_' . $pic->getName();
                $this->crop->withFile($target_dir .  $namePic)->fit(250, 150, 'center')->save($target_dir . $news_img);
                unlink($target_dir . $namePic);
                $data['image'] = $news_img;
            }

            $table = DB()->table('cc_brand');
            $table->insert($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Brand Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('brand_create');
        }
    }

    /**
     * @description This method provides brand update page view
     * @param int $brand_id
     * @return RedirectResponse|void
     */
    public function update($brand_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_brand');
            $data['brand'] = $table->where('brand_id', $brand_id)->get()->getRow();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Brand/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides brand update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $brand_id = $this->request->getPost('brand_id');
        $data['name'] = $this->request->getPost('name');
        $data['status'] = $this->request->getPost('status');
        $data['sort_order'] = $this->request->getPost('sort_order');
        $data['updatedBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('brand_update/' . $brand_id);
        } else {
            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/brand/';
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777);
                }

                //old image unlink
                $old_img = get_data_by_id('image', 'cc_brand', 'brand_id', $brand_id);
                if (!empty($old_img)) {
                    $imgPath = $target_dir .  $old_img;
                    if (file_exists($imgPath)) {
                        unlink($target_dir . $old_img);
                    }

                    $targetDirCash = FCPATH . '/cache/uploads/brand/';
                    $imgPathCache = $targetDirCash .  $old_img;
                    if (file_exists($imgPathCache)) {
                        unlink($targetDirCash . $old_img);
                    }
                }

                //new image uplode
                $pic = $this->request->getFile('image');
                $namePic = $pic->getRandomName();
                $pic->move($target_dir, $namePic);
                $news_img = 'brand_' . $pic->getName();
                $this->crop->withFile($target_dir . $namePic)->fit(250, 150, 'center')->save($target_dir . $news_img);
                unlink($target_dir . $namePic);
                $data['image'] = $news_img;
            }

            $table = DB()->table('cc_brand');
            $table->where('brand_id', $brand_id)->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Brand Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('brand_update/' . $brand_id);

        }
    }

    /**
     * @description This method provides brand delete
     * @param int $brand_id
     * @return RedirectResponse
     */
    public function delete($brand_id){

        $target_dir = FCPATH . '/uploads/brand/';
        //old image unlink
        $old_img = get_data_by_id('image', 'cc_brand', 'brand_id', $brand_id);
        if (!empty($old_img)) {
            $imgPath = $target_dir . $old_img;
            if (file_exists($imgPath)) {
                unlink($target_dir . $old_img);
            }

            $targetDirCash = FCPATH . '/cache/uploads/brand/';
            $imgPathCash = $targetDirCash . $old_img;
            if (file_exists($imgPathCash)) {
                unlink($targetDirCash . $old_img);
            }
        }

        $upBrand['brand_id'] = null;
        $tablePro = DB()->table('cc_products');
        $tablePro->where('brand_id', $brand_id)->update($upBrand);

        $table = DB()->table('cc_brand');
        $table->where('brand_id', $brand_id)->delete();


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Brand Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('brand');
    }

}
