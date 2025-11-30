<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Theme_3;
use CodeIgniter\HTTP\RedirectResponse;

class SliderSection extends BaseController
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

            $table = DB()->table('cc_slider_schedule');
            $data['schedule'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/SliderSection/index', $data);
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
                echo view('Admin/SliderSection/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function sliderSectionCreateAction()
    {
        $theme = get_lebel_by_value_in_settings('Theme');
        $theme_libraries = '';
        if($theme == 'Theme_3'){
            $theme_libraries = $this->theme_3;
        }
        $schedule_title = $this->request->getPost('schedule_title');
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');


        $alt_names = $this->request->getPost('alt_name');
        $images = $this->request->getFiles()['slider_image'];

        $target_dir = FCPATH . 'uploads/slider/';
        // Ensure upload directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }


        DB()->transStart();

        $data = [
            'schedule_title' => $schedule_title,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        $table = DB()->table('cc_slider_schedule');
        $table->insert($data);
        $slider_schedule_id = DB()->insertID();

        $imageDataBatch = [];
        if ($images) {
            foreach ($images as $index => $img) {
                if ($img->isValid() && !$img->hasMoved()) {

                    $newName = $img->getRandomName();
                    $img->move($target_dir, $newName);

                    $news_img = 'slider_' . $img->getName();

                    // Crop & Save
                    $this->crop->withFile($target_dir . $newName)
                        ->fit($theme_libraries->slider_width, $theme_libraries->slider_height, 'center')
                        ->save($target_dir . $news_img);

                    // Remove original uploaded file
                    unlink($target_dir . $newName);

                    // Push into batch array
                    $imageDataBatch[] = [
                        'slider_schedule_id' => $slider_schedule_id,
                        'image'              => $news_img,
                        'alt_name'           => $alt_names[$index] ?? null
                    ];
                }
            }

            // Insert all images in one query
            if (!empty($imageDataBatch)) {
                DB()->table('cc_slider_schedule_image')->insertBatch($imageDataBatch);
            }
        }

        DB()->transComplete();

        if (DB()->transStatus() === false) {
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
                Banner updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('slider_section_create');

    }
    public function sliderSectionUpdateAction()
    {
        $theme = get_lebel_by_value_in_settings('Theme');
        $theme_libraries = ($theme == 'Theme_3') ? $this->theme_3 : '';

        $slider_schedule_id      = $this->request->getPost('slider_schedule_id');
        $schedule_title          = $this->request->getPost('schedule_title');
        $start_date              = $this->request->getPost('start_date');
        $end_date                = $this->request->getPost('end_date');

        $slider_schedule_image_id= $this->request->getPost('slider_schedule_image_id');
        $alt_names               = $this->request->getPost('alt_name');
        $images                  = $this->request->getFiles()['slider_image'];

        $target_dir = FCPATH . 'uploads/slider/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        DB()->transStart();

        $data = [
            'schedule_title' => $schedule_title,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
        ];

        DB()->table('cc_slider_schedule')
            ->where('slider_schedule_id', $slider_schedule_id)
            ->update($data);


        // ---- UPDATE IMAGES ----
        $updateBatch = [];
        if ($images) {
            foreach ($images as $index => $img) {

                if ($img->isValid() && !$img->hasMoved()) {

                    // get old image
                    $oldImage = get_data_by_id(
                        'image',
                        'cc_slider_schedule_image',
                        'slider_schedule_image_id',
                        $slider_schedule_image_id[$index]
                    );

                    // delete old image
                    if (!empty($oldImage)) {
                        if (file_exists($target_dir . $oldImage)) {
                            unlink($target_dir . $oldImage);
                        }
                    }

                    // upload new image
                    $tempName = $img->getRandomName();
                    $img->move($target_dir, $tempName);

                    $finalName = 'slider_' . $img->getName();

                    // crop
                    $this->crop->withFile($target_dir . $tempName)
                        ->fit($theme_libraries->slider_width, $theme_libraries->slider_height, 'center')
                        ->save($target_dir . $finalName);

                    unlink($target_dir . $tempName);

                    // Add row to batch array
                    $updateBatch[] = [
                        'slider_schedule_image_id' => $slider_schedule_image_id[$index], // REQUIRED
                        'image'                    => $finalName,
                        'alt_name'                 => $alt_names[$index] ?? null,
                    ];
                }
            }

            // ---- UPDATE WITH ONE QUERY ----
            if (!empty($updateBatch)) {
                DB()->table('cc_slider_schedule_image')
                    ->updateBatch($updateBatch, 'slider_schedule_image_id');
            }
        }

        DB()->transComplete();

        if (!DB()->transStatus()) {
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
            Banner updated successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        }

        return redirect()->to('slider_section_view/' . $slider_schedule_id);
    }
    public function sliderSectionView($id){
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

            $table = DB()->table('cc_slider_schedule');
            $data['schedule'] = $table->where('slider_schedule_id',$id)->get()->getRow();

            $tableImage = DB()->table('cc_slider_schedule_image');
            $data['scheduleImage'] = $tableImage->where('slider_schedule_id',$id)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/SliderSection/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function delete($id)
    {
        $db = DB();

        // --- Delete images from folder ---
        $tableImage = $db->table('cc_slider_schedule_image');
        $scheduleImages = $tableImage->where('slider_schedule_id', $id)->get()->getResult();

        $targetDir = FCPATH . 'uploads/slider/';

        foreach ($scheduleImages as $item) {
            if (!empty($item->image)) {
                $imagePath = $targetDir . $item->image;
                if (is_file($imagePath)) {
                    @unlink($imagePath);
                }
            }
        }

        // --- Delete image records ---
        $tableImage->where('slider_schedule_id', $id)->delete();

        // --- Delete schedule record ---
        $db->table('cc_slider_schedule')->where('slider_schedule_id', $id)->delete();

        // --- Flash success message ---
        $this->session->setFlashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Banner deleted successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        ');

        return redirect()->to('slider_section');
    }



}
