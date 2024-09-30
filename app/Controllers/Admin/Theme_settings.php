<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Libraries\Theme_2;
use App\Libraries\Theme_3;
use App\Libraries\Theme_default;
use CodeIgniter\HTTP\RedirectResponse;

class Theme_settings extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $theme_3;
    protected $theme_2;
    protected $theme_default;
    private $module_name = 'Theme_settings';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
        $this->theme_3 = new Theme_3();
        $this->theme_2 = new Theme_2();
        $this->theme_default = new Theme_default();
    }

    /**
     * @description This method provides theme settings page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
           
            $table = DB()->table('cc_theme_settings');
            $data['theme_settings'] = $table->get()->getResult();

            $theme = get_lebel_by_value_in_settings('Theme');
            if($theme == 'Theme_3'){
                $data['theme_libraries'] = $this->theme_3;
                $data['theme_view'] = view('Admin/Theme_settings/theme_3', $data);
            }

            if($theme == 'Default'){
                $data['theme_libraries'] = $this->theme_default;
                $data['theme_view'] = view('Admin/Theme_settings/default', $data);
            }
            if($theme == 'Theme_2'){
                $data['theme_libraries'] = $this->theme_2;
                $data['theme_view'] = view('Admin/Theme_settings/theme_2', $data);
            }


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Theme_settings/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }

    /**
     * @description This method provides theme settings slider update
     * @return RedirectResponse
     */
    public function slider_update()
    {
        $nameslider = $this->request->getPost('nameslider');

        $theme = get_lebel_by_value_in_settings('Theme');
        if($theme == 'Theme_3'){
            $theme_libraries = $this->theme_3;
        }
        if($theme == 'Default'){
            $theme_libraries = $this->theme_default;
        }
        if($theme == 'Theme_2'){
            $theme_libraries = $this->theme_2;
        }


        if (!empty($_FILES['slider']['name'])) {
            $target_dir = FCPATH . '/uploads/slider/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('slider');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'slider_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit($theme_libraries->slider_width, $theme_libraries->slider_height, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);
            $data['value'] = $news_img;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', $nameslider)->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Image required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        }


    }

    /**
     * @description This method provides theme settings logo update
     * @return RedirectResponse
     */
    public function logo_update()
    {
        $theme = get_lebel_by_value_in_settings('Theme');
        if($theme == 'Theme_3'){
            $theme_libraries = $this->theme_3;
        }
        if($theme == 'Default'){
            $theme_libraries = $this->theme_default;
        }
        if($theme == 'Theme_2'){
            $theme_libraries = $this->theme_2;
        }

        if (!empty($_FILES['side_logo']['name'])) {
            $target_dir = FCPATH . '/uploads/logo/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('side_logo');
            $namePic = 'logo_' . $pic->getRandomName();
            $pic->move($target_dir, $namePic);
//            $news_img = 'logo_' . $pic->getName();
//            $this->crop->withFile($target_dir . '' . $namePic)->fit(150, 90, 'center')->save($target_dir . '' . $news_img);
//            unlink($target_dir . '' . $namePic);
//            $data['value'] = $news_img;
            $data['value'] = $namePic;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', 'side_logo')->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Logo required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        }


    }

    /**
     * @description This method provides theme settings favicon update
     * @return RedirectResponse
     */
    public function favicon_update()
    {


        if (!empty($_FILES['favicon']['name'])) {
            $target_dir = FCPATH . '/uploads/logo/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('favicon');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'favicon_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(80, 80, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);

            $data['value'] = $news_img;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', 'favicon')->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Logo required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        }


    }

    /**
     * @description This method provides theme settings home category banner
     * @return RedirectResponse
     */
    public function home_category_banner()
    {

        if (!empty($_FILES['home_category_banner']['name'])) {
            $target_dir = FCPATH . '/uploads/category_banner/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('home_category_banner');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'banner_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(280, 440, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);
            $data['value'] = $news_img;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', 'home_category_banner')->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Logo required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings');
        }


    }

    /**
     * @description This method provides theme settings home category
     * @return RedirectResponse
     */
    public function home_category()
    {

        $data['value'] = $this->request->getPost('home_category');

        $this->validation->setRules([
            'value' => ['label' => 'Category', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        } else {


            $table = DB()->table('cc_theme_settings');
            $table->where('label', 'home_category')->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        }


    }

    /**
     * @description This method provides theme settings settings update
     * @return RedirectResponse
     */
    public function settings_update()
    {

        $data['value'] = $this->request->getPost('value');
        $label = $this->request->getPost('label');

        $table = DB()->table('cc_theme_settings');
        $table->where('label', $label)->update($data);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('theme_settings?sel=home_settings');

        //new image uplode
        $pic = $this->request->getFile('special_banner');
        $namePic = $pic->getRandomName();
        $pic->move($target_dir, $namePic);
        $news_img = 'sp_banner_' . $pic->getName();
        $this->crop->withFile($target_dir . '' . $namePic)->fit(837, 190, 'center')->save($target_dir . '' . $news_img);
        unlink($target_dir . '' . $namePic);
        $data['value'] = $news_img;

    }

    /**
     * @description This method provides theme settings home special banner
     * @return RedirectResponse
     */
    public function home_special_banner()
    {
        if (!empty($_FILES['special_banner']['name'])) {
            $target_dir = FCPATH . '/uploads/special_banner/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('special_banner');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'sp_banner_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(837, 190, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);
            $data['value'] = $news_img;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', 'special_banner')->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Logo required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        }
    }

    /**
     * @description This method provides theme settings home left side banner
     * @return RedirectResponse
     */
    public function home_left_side_banner()
    {
        $label = $this->request->getPost('label');
        if (!empty($_FILES['left_side_banner']['name'])) {
            $target_dir = FCPATH . '/uploads/left_side_banner/';
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777);
            }

            //new image uplode
            $pic = $this->request->getFile('left_side_banner');
            $namePic = $pic->getRandomName();
            $pic->move($target_dir, $namePic);
            $news_img = 'left_banner_' . $pic->getName();
            $this->crop->withFile($target_dir . '' . $namePic)->fit(262, 420, 'center')->save($target_dir . '' . $news_img);
            unlink($target_dir . '' . $namePic);
            $data['value'] = $news_img;

            $table = DB()->table('cc_theme_settings');
            $table->where('label', $label)->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Logo required <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('theme_settings?sel=home_settings');
        }
    }

}

