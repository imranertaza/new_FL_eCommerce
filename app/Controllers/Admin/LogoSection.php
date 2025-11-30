<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Theme_3;
use CodeIgniter\HTTP\RedirectResponse;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LogoSection extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $theme_3;
    private $module_name = 'Theme_settings';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
        $this->theme_3 = new Theme_3();
    }

    /**
     * @description This method provides settings page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_logo_schedule');
            $data['schedule'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/LogoSection/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $theme = get_lebel_by_value_in_settings('Theme');
            $data['theme_libraries'] = '';
            if($theme == 'Theme_3'){
                $data['theme_libraries'] = $this->theme_3;
            }

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/LogoSection/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function logoSectionView($id){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_logo_schedule');
            $data['schedule'] = $table->where('logo_schedule_id',$id)->get()->getRow();


            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/LogoSection/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function logoSectionCreateAction(){
        $schedule_title      = $this->request->getPost('schedule_title');
        $start_date          = $this->request->getPost('start_date');
        $end_date            = $this->request->getPost('end_date');
        $alt_name            = $this->request->getPost('alt_name');

        $images              = $this->request->getFile('image');
        $targetDir = FCPATH . 'uploads/logo/';

        // Ensure upload directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $db = DB();
        $db->transStart(); // Start transaction

            $data = [
                'schedule_title'      => $schedule_title,
                'start_date'          => $start_date,
                'end_date'            => $end_date,
                'alt_name'            => $alt_name,
            ];

            // Handle image upload
            if (!empty($images) && $images->isValid() && !$images->hasMoved()) {
                $namePic = 'logo_' . $images->getRandomName();
                $images->move($targetDir, $namePic);
                $data['image'] = $namePic;
            }
            // Update into featured_schedule
            $db->table('cc_logo_schedule')->insert($data);

        $db->transComplete(); // Commit transaction

        if ($db->transStatus() === false) {
            $this->session->setFlashdata('message', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                Something went wrong while saving. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        } else {
            $this->session->setFlashdata('message', '
            <div class="alert alert-success alert-dismissible" role="alert">
                Logo updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('logo_section');

    }
    public function logoSectionUpdateAction(){
        $logo_schedule_id    = $this->request->getPost('logo_schedule_id');
        $schedule_title      = $this->request->getPost('schedule_title');
        $start_date          = $this->request->getPost('start_date');
        $end_date            = $this->request->getPost('end_date');
        $alt_name            = $this->request->getPost('alt_name');

        $images              = $this->request->getFile('image');
        $targetDir = FCPATH . 'uploads/logo/';

        // Ensure upload directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $db = DB();
        $db->transStart(); // Start transaction

        $data = [
            'schedule_title'      => $schedule_title,
            'start_date'          => $start_date,
            'end_date'            => $end_date,
            'alt_name'            => $alt_name,
        ];

        // Handle image upload
        if (!empty($images) && $images->isValid() && !$images->hasMoved()) {

            $oldImage = get_data_by_id('image','cc_logo_schedule','logo_schedule_id',$logo_schedule_id);
            // delete old image if exists
            if (!empty($oldImage)) {
                if (file_exists($targetDir . $oldImage)) {
                    unlink($targetDir . $oldImage);
                }
            }

            $namePic = 'logo_' . $images->getRandomName();
            $images->move($targetDir, $namePic);
            $data['image'] = $namePic;
        }
        // Update into featured_schedule
        $db->table('cc_logo_schedule')->where('logo_schedule_id',$logo_schedule_id)->update($data);

        $db->transComplete(); // Commit transaction

        if ($db->transStatus() === false) {
            $this->session->setFlashdata('message', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                Something went wrong while saving. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        } else {
            $this->session->setFlashdata('message', '
            <div class="alert alert-success alert-dismissible" role="alert">
                Logo updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('logo_section_view/'.$logo_schedule_id);

    }
    public  function delete($id){

        $db = DB();
        //image delete
        $targetDir = FCPATH . 'uploads/logo/';
        $oldImage = get_data_by_id('image','cc_logo_schedule','logo_schedule_id',$id);
        if (file_exists($targetDir.$oldImage)) {
            unlink($targetDir . $oldImage);
        }
        //data delete
        $db->table('cc_logo_schedule')->where('logo_schedule_id',$id)->delete();


        $this->session->setFlashdata('message', '
        <div class="alert alert-success alert-dismissible" role="alert">
            Logo Delete successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');

        return redirect()->to('logo_section');

    }





}
