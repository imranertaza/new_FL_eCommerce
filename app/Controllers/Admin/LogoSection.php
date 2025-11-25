<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Theme_3;
use CodeIgniter\HTTP\RedirectResponse;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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

            $table = DB()->table('cc_settings');
            $data['settings'] = $table->get()->getResult();


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
                echo view('Admin/SliderSection/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    public function sectionView($id){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_featured_schedule');
            $data['schedule'] = $table->where('featured_section_id',$id)->get()->getResult();

            $data['sectionId'] = $id;

                //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/FeaturedSection/view', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    public function sliderSectionCreateAction(){
        $featured_section_id = $this->request->getPost('featured_section_id');
        $featured_schedule_id = $this->request->getPost('featured_schedule_id');
        $section_name        = $this->request->getPost('section_name');
        $product             = $this->request->getPost('product_id');
        $brand_id            = $this->request->getPost('brand_id');
        $prod_cat_id         = $this->request->getPost('prod_cat_id');
        $start_date          = $this->request->getPost('start_date');
        $end_date            = $this->request->getPost('end_date');
        $alt_name            = $this->request->getPost('alt_name');
        $url                 = $this->request->getPost('url');
        $images              = $this->request->getFile('image');

        $radio               = $this->request->getPost('radio');
        $type                = $this->request->getPost($radio);

        $target_dir = FCPATH . 'uploads/sections/';

        // Ensure upload directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $db = DB();
        $db->transStart(); // Start transaction

        $data = [
            'section_name'        => $section_name,
            'start_date'          => $start_date,
            'end_date'            => $end_date,
            'alt_name'            => $alt_name,
            'url'                 => $url,
        ];

        // Handle image upload and crop
        if (!empty($images) && $images->isValid() && !$images->hasMoved()) {
            //old image unlink
            $oldImage = get_data_by_id('image','cc_featured_schedule','featured_schedule_id',$featured_schedule_id);
            if (file_exists($target_dir.$oldImage)) {
                unlink($target_dir . $oldImage);
            }

            $newName = $images->getRandomName();
            $images->move($target_dir, $newName);

            $croppedName = 'category_' . $newName;

            // Crop and save new image
            $this->crop->withFile($target_dir . $newName)
                ->fit(271, 590, 'center')
                ->save($target_dir . $croppedName, 100);

            // Remove the temporary original
            unlink($target_dir . $newName);

            $data['image'] = $croppedName;
        }
        // Update into featured_schedule
        $db->table('cc_featured_schedule')->where('featured_schedule_id',$featured_schedule_id)->update($data);


        // previous data delete
        $db->table('cc_featured_product')->where('featured_schedule_id',$featured_schedule_id)->delete();

        // Insert brand if available
        if (!empty($type == 'option2')) {
            foreach ($brand_id as $bra_id) {
                if (!empty($bra_id)) {
                    $db->table('cc_featured_product')->insert([
                        'featured_schedule_id' => $featured_schedule_id,
                        'brand_id' => $bra_id,
                    ]);
                }
            }
        }

        // Insert category if available
        if (!empty($type == 'option3')) {
            foreach ($prod_cat_id as $cat_id) {
                if (!empty($cat_id)) {
                    $db->table('cc_featured_product')->insert([
                        'featured_schedule_id' => $featured_schedule_id,
                        'prod_cat_id' => $cat_id,
                    ]);
                }
            }
        }

        // Insert multiple products if available
        if (!empty($type == 'option1') && is_array($product)) {
            foreach ($product as $prod_id) {
                if (!empty($prod_id)) {
                    $db->table('cc_featured_product')->insert([
                        'featured_schedule_id' => $featured_schedule_id,
                        'product_id'           => $prod_id,
                    ]);
                }
            }
        }


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
                Section updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('section_view/' . $featured_section_id);

    }

    public function sectionViewAction()
    {
        $featured_section_id = $this->request->getPost('featured_section_id');
        $section_name        = $this->request->getPost('section_name');
        $product             = $this->request->getPost('product_id'); // 2D array if multiple
        $brand_id            = $this->request->getPost('brand_id');
        $prod_cat_id         = $this->request->getPost('prod_cat_id');
        $start_date          = $this->request->getPost('start_date');
        $end_date            = $this->request->getPost('end_date');
        $alt_name            = $this->request->getPost('alt_name');
        $url                 = $this->request->getPost('url');
        $images              = $this->request->getFileMultiple('image');

        // Validate: must have section_name and at least one of product, brand, or category
        foreach ($section_name as $key => $val) {

            $rules = [
                'section_name' => [
                    'label' => 'Section Name',
                    'rules' => 'required|min_length[2]|max_length[255]',
                ],
            ];

            $dataToValidate = ['section_name' => $val];

            if (!$this->validation->setRules($rules)->run($dataToValidate)) {
                $errors = $this->validation->getErrors();
                $this->session->setFlashdata('message', '
                <div class="alert alert-danger alert-dismissible" role="alert">
                    Section ' . ($key + 1) . ' Error: ' . implode(', ', $errors) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                return redirect()->back()->withInput();
            }

            // Must have at least one: product / brand / category
            $hasProduct  = !empty($product[$key]) && is_array($product[$key]) && count(array_filter($product[$key])) > 0;
            $hasBrand    = !empty($brand_id[$key]);
            $hasCategory = !empty($prod_cat_id[$key]);

            if (!$hasProduct && !$hasBrand && !$hasCategory) {
                $this->session->setFlashdata('message', '
                <div class="alert alert-danger alert-dismissible" role="alert">
                    Section ' . ($key + 1) . ' must include at least one Product, Brand, or Category.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                return redirect()->back()->withInput();
            }
        }


        $target_dir = FCPATH . 'uploads/sections/';

        // Ensure upload directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $db = DB();
        $db->transStart(); // Start transaction

        foreach ($section_name as $key => $val) {
            $data = [
                'featured_section_id' => $featured_section_id,
                'section_name'        => $val,
                'start_date'          => $start_date[$key] ?? null,
                'end_date'            => $end_date[$key] ?? null,
                'alt_name'            => $alt_name[$key] ?? null,
                'url'                 => $url[$key] ?? null,
            ];

            // Handle image upload and crop
            if (!empty($images[$key]) && $images[$key]->isValid() && !$images[$key]->hasMoved()) {
                $newName = $images[$key]->getRandomName();
                $images[$key]->move($target_dir, $newName);

                $croppedName = 'category_' . $newName;

                // Crop and save new image
                $this->crop->withFile($target_dir . $newName)
                    ->fit(271, 590, 'center')
                    ->save($target_dir . $croppedName, 100);

                // Remove the temporary original
                unlink($target_dir . $newName);

                $data['image'] = $croppedName;
            }

            // Insert into featured_schedule
            $db->table('cc_featured_schedule')->insert($data);
            $featured_schedule_id = $db->insertID();


            // Insert multiple brand if available
            if (!empty($brand_id[$key])) {
                foreach ($brand_id[$key] as $bra_id) {
                    if (!empty($bra_id)) {
                        $db->table('cc_featured_product')->insert([
                            'featured_schedule_id' => $featured_schedule_id,
                            'brand_id' => $bra_id,
                        ]);
                    }
                }
            }

            // Insert multiple category if available
            if (!empty($prod_cat_id[$key])) {
                foreach ($prod_cat_id[$key] as $cat_id) {
                    if (!empty($cat_id)) {
                        $db->table('cc_featured_product')->insert([
                            'featured_schedule_id' => $featured_schedule_id,
                            'prod_cat_id' => $cat_id,
                        ]);
                    }
                }
            }

            // Insert multiple products if available
            if (!empty($product[$key]) && is_array($product[$key])) {
                foreach ($product[$key] as $prod_id) {
                    if (!empty($prod_id)) {
                        $db->table('cc_featured_product')->insert([
                            'featured_schedule_id' => $featured_schedule_id,
                            'product_id'           => $prod_id,
                        ]);
                    }
                }
            }
        }

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
                Section updated successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
        }

        return redirect()->to('section_view/' . $featured_section_id);
    }


    public  function delete($id){

        $featured_section_id = get_data_by_id('featured_section_id','cc_featured_schedule','featured_schedule_id',$id);
        $db = DB();
        //image delete
        $target_dir = FCPATH . 'uploads/sections/';
        $oldImage = get_data_by_id('image','cc_featured_schedule','featured_schedule_id',$id);
        if (file_exists($target_dir.$oldImage)) {
            unlink($target_dir . $oldImage);
        }
        //data delete in cc_featured_product
        $db->table('cc_featured_product')->where('featured_schedule_id',$id)->delete();

        //data delete in cc_featured_schedule
        $db->table('cc_featured_schedule')->where('featured_schedule_id',$id)->delete();


        $this->session->setFlashdata('message', '
        <div class="alert alert-success alert-dismissible" role="alert">
            Settings updated successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>');

        return redirect()->to('section_view/' . $featured_section_id);

    }





}
