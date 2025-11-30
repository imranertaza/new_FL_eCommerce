<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Theme_3;
use CodeIgniter\HTTP\RedirectResponse;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class SliderRightSection extends BaseController
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

            $table = DB()->table('cc_banner_side_schedule');
            $data['schedule'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/SliderRightSection/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    public function create()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $theme = get_lebel_by_value_in_settings('Theme');
            $data['theme_libraries'] = '';
            if ($theme == 'Theme_3') {
                $data['theme_libraries'] = $this->theme_3;
            }

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/SliderRightSection/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    public function sliderRightSectionCreateAction()
    {
        // Basic fields
        $schedule_title = $this->request->getPost('schedule_title');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Prepare common directory
        $targetDir = FCPATH . 'uploads/top_side_baner/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $db = DB();
        $db->transStart();   // START TRANSACTION

        // MAIN SCHEDULE INSERT
        $db->table('cc_banner_side_schedule')->insert([
            'schedule_title' => $schedule_title,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $banner_side_schedule_id = $db->insertID();

        // PROCESS TOP & BOTTOM USING SAME FUNCTION
        $this->sectionInsert('top', $banner_side_schedule_id, $targetDir);
        $this->sectionInsert('bottom', $banner_side_schedule_id, $targetDir);

        // END TRANSACTION
        $db->transComplete();

        // FLASH MESSAGE
        if ($db->transStatus() === false) {

            $this->session->setFlashdata('message', '
        <div class="alert alert-danger alert-dismissible" role="alert">
            Something went wrong! Please try again.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');

        } else {

            $this->session->setFlashdata('message', '
        <div class="alert alert-success alert-dismissible" role="alert">
            Banner saved successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        }

        return redirect()->to('slider_right_section_create');
    }

    private function sectionInsert($section, $banner_side_schedule_id, $targetDir)
    {

        $title = $this->request->getPost("title_$section");
        $alt_name = $this->request->getPost("alt_name_$section");
        $type = $this->request->getPost("type_$section");
        $url = $this->request->getPost("url_$section");
        $cat_id = $this->request->getPost("prod_cat_id_$section");
        $file = $this->request->getFile("banner_$section");

        $data = [
            'banner_side_schedule_id' => $banner_side_schedule_id,
            'title' => $title,
            'alt_name' => $alt_name,
        ];

        // URL / Category Logic
        if ($type === 'url') {
            $data['url'] = $url;
        } else {
            $data['prod_cat_id'] = $cat_id;
        }

        // =====================
        // IMAGE UPLOAD + CROP
        // =====================
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);

            $croppedName = "head_side_banner_" . $newName;

            // Crop
            $this->crop->withFile($targetDir . $newName)
                ->fit(228, 199, 'center')
                ->save($targetDir . $croppedName, 100);

            // Delete original
            unlink($targetDir . $newName);

            // Save final name
            $data['image'] = $croppedName;
        }

        // Save into DB
        DB()->table('cc_banner_side_schedule_image')->insert($data);
    }


    public function sliderRightSectionView($id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_banner_side_schedule');
            $data['schedule'] = $table->where('banner_side_schedule_id', $id)->get()->getRow();

            $tableImage = DB()->table('cc_banner_side_schedule_image');
            $data['schedule_image_top'] = $tableImage->where('banner_side_schedule_id', $id)->get()->getFirstRow();
            $data['schedule_image_bottom'] = $tableImage->where('banner_side_schedule_id', $id)->get()->getLastRow();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/SliderRightSection/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }


    public function sliderRightSectionUpdateAction()
    {
        // Basic fields
        $banner_side_schedule_id = $this->request->getPost('banner_side_schedule_id');
        $schedule_title = $this->request->getPost('schedule_title');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Prepare common directory
        $targetDir = FCPATH . 'uploads/top_side_baner/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $db = DB();
        $db->transStart();   // START TRANSACTION

        // MAIN SCHEDULE UPDATE
        $db->table('cc_banner_side_schedule')->where('banner_side_schedule_id', $banner_side_schedule_id)->update([
            'schedule_title' => $schedule_title,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);


        // PROCESS TOP & BOTTOM USING SAME FUNCTION
        $this->sectionUpdate('top', $targetDir);
        $this->sectionUpdate('bottom', $targetDir);

        // END TRANSACTION
        $db->transComplete();

        // FLASH MESSAGE
        if ($db->transStatus() === false) {

            $this->session->setFlashdata('message', '
        <div class="alert alert-danger alert-dismissible" role="alert">
            Something went wrong! Please try again.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');

        } else {

            $this->session->setFlashdata('message', '
        <div class="alert alert-success alert-dismissible" role="alert">
            Banner saved successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        }

        return redirect()->to('slider_right_section_view/'.$banner_side_schedule_id);
    }

    private function sectionUpdate($section, $targetDir)
    {

        $banner_side_schedule_id = $this->request->getPost("banner_side_schedule_id_$section");
        $title = $this->request->getPost("title_$section");
        $alt_name = $this->request->getPost("alt_name_$section");
        $type = $this->request->getPost("type_$section");
        $url = $this->request->getPost("url_$section");
        $cat_id = $this->request->getPost("prod_cat_id_$section");
        $file = $this->request->getFile("banner_$section");

        $data = [
            'title' => $title,
            'alt_name' => $alt_name,
        ];

        // URL / Category Logic
        if ($type === 'url') {
            $data['url'] = $url;
            $data['prod_cat_id'] = null;
        } else {
            $data['prod_cat_id'] = $cat_id;
            $data['url'] = null;
        }

        // =====================
        // IMAGE UPLOAD + CROP
        // =====================
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $oldImage = get_data_by_id('image','cc_banner_side_schedule_image','banner_side_schedule_id',$banner_side_schedule_id);
            if (!empty($oldImage)){
                if (file_exists($targetDir . $oldImage)) {
                    unlink($targetDir . $oldImage);
                }
            }

            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);

            $croppedName = "head_side_banner_" . $newName;

            // Crop
            $this->crop->withFile($targetDir . $newName)
                ->fit(228, 199, 'center')
                ->save($targetDir . $croppedName, 100);

            // Delete original
            unlink($targetDir . $newName);

            // Save final name
            $data['image'] = $croppedName;
        }

        // Save into DB
        DB()->table('cc_banner_side_schedule_image')->where('banner_side_schedule_image_id', $banner_side_schedule_id)->update($data);
    }


    public function delete($id)
    {
        // Start DB transaction
        $db = DB();
        $db->transStart();

        // Fetch all related images
        $oldImages = $db->table('cc_banner_side_schedule_image')
            ->where('banner_side_schedule_id', $id)
            ->get()
            ->getResult();

        // Image directory
        $targetDir = FCPATH . 'uploads/top_side_baner/';

        // Delete image files
        if (!empty($oldImages)) {
            foreach ($oldImages as $item) {
                $filePath = $targetDir . $item->image;

                if (is_file($filePath) && file_exists($filePath)) {
                    @unlink($filePath);  // @ prevents warning if file doesn't exist
                }
            }
        }

        // Delete image DB rows
        $db->table('cc_banner_side_schedule_image')
            ->where('banner_side_schedule_id', $id)
            ->delete();

        // Delete main schedule
        $db->table('cc_banner_side_schedule')
            ->where('banner_side_schedule_id', $id)
            ->delete();

        // Complete transaction
        $db->transComplete();

        // Check for errors
        if ($db->transStatus() === false) {
            $this->session->setFlashdata('message', '
            <div class="alert alert-danger alert-dismissible" role="alert">
                Something went wrong! Unable to delete record.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        } else {
            $this->session->setFlashdata('message', '
            <div class="alert alert-success alert-dismissible" role="alert">
                Record deleted successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('slider_right_section');
    }


}
