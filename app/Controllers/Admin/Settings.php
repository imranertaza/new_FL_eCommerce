<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Settings extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Settings';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
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
                echo view('Admin/Settings/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides settings update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $data['store_name'] = $this->request->getPost('store_name');
        $data['store_owner'] = $this->request->getPost('store_owner');
        $data['address'] = $this->request->getPost('address');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');
        $data['Theme'] = $this->request->getPost('Theme');
        $data['category_product_limit'] = $this->request->getPost('category_product_limit');

        $data['country'] = $this->request->getPost('country');
        $data['state'] = $this->request->getPost('state');
        $data['length_class'] = $this->request->getPost('length_class');
        $data['weight_class'] = $this->request->getPost('weight_class');
        $data['currency'] = $this->request->getPost('currency');
        $data['currency_symbol'] = $this->request->getPost('currency_symbol');
        $data['invoice_prefix'] = $this->request->getPost('invoice_prefix');

        $data['new_account_alert_mail'] = $this->request->getPost('new_account_alert_mail');
        $data['new_order_alert_mail'] = $this->request->getPost('new_order_alert_mail');

        $data['mail_protocol'] = $this->request->getPost('mail_protocol');
        $data['mail_address'] = $this->request->getPost('mail_address');
        $data['smtp_host'] = $this->request->getPost('smtp_host');
        $data['smtp_port'] = $this->request->getPost('smtp_port');
        $data['smtp_timeout'] = $this->request->getPost('smtp_timeout');
        $data['smtp_username'] = $this->request->getPost('smtp_username');
        $data['smtp_password'] = $this->request->getPost('smtp_password');
        $data['smtp_crypto'] = $this->request->getPost('smtp_crypto');

        $data['fb_url'] = $this->request->getPost('fb_url');
        $data['twitter_url'] = $this->request->getPost('twitter_url');
        $data['tiktok_url'] = $this->request->getPost('tiktok_url');
        $data['instagram_url'] = $this->request->getPost('instagram_url');
        $data['pinterest_url'] = $this->request->getPost('pinterest_url');
        $data['telegram_url'] = $this->request->getPost('telegram_url');


        $data['meta_title'] = $this->request->getPost('meta_title');
        $data['meta_keyword'] = $this->request->getPost('meta_keyword');
        $data['meta_description'] = $this->request->getPost('meta_description');

//        if (!empty($_FILES['store_logo']['name'])) {
//            $target_dir = FCPATH . '/uploads/store/';
//            if (!file_exists($target_dir)) {
//                mkdir($target_dir, 0777);
//            }
//
//            //new image upload
//            $pic = $this->request->getFile('store_logo');
//            $namePic = $pic->getRandomName();
//            $pic->move($target_dir, $namePic);
//            $news_img = 'logo_' . $pic->getName();
//            $this->crop->withFile($target_dir . '' . $namePic)->fit(200, 100, 'center')->save($target_dir . $news_img);
//            unlink($target_dir . '' . $namePic);
//            $data['store_logo'] = $news_img;
//        }

        foreach($data as $key=>$val){
            $table = DB()->table('cc_settings');
            $table->set('value', $val)->where('label', $key)->update();
        }


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Settings Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('settings');


    }
    public function cacheImageRemove(){
        $directory = FCPATH . 'cache/uploads';
        $days = 30;
        $now = time();

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isFile()) {
                $lastModified = $file->getMTime();
                if ($lastModified < ($now - ($days * 86400))) {
                    unlink($file->getRealPath());
                }
            } elseif ($file->isDir()) {
                if (iterator_count(new FilesystemIterator($file->getRealPath())) === 0) {
                    rmdir($file->getRealPath());
                }
            }
        }

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Cache Image Remove Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('settings');
    }



}
