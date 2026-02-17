<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class ThemeOthersSettings extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Theme_settings';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides header section one update
     * @return RedirectResponse
     */
    public function bannerTopContact(){
        $file = $this->request->getFile('banner_top_contact');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $target_dir = FCPATH . 'uploads/banner_contact/';

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Generate random temp name
            $tempName = $file->getRandomName();
            $file->move($target_dir, $tempName);

            // Final cropped image name
            $finalName = 'contact_' . time() . '.jpg';

            // Crop & resize
            $this->crop
                ->withFile($target_dir . $tempName)
                ->fit(1351, 255, 'center')
                ->save($target_dir . $finalName);

            // Remove temp file
            unlink($target_dir . $tempName);

            $data = [
                'value'    => $finalName,
                'alt_name' => $this->request->getPost('alt_name')
            ];

        } else {
            // Only update alt name if no image uploaded
            $data = [
                'alt_name' => $this->request->getPost('alt_name')
            ];
        }

        DB()->table('cc_theme_settings')
            ->where('label', 'banner_top_contact')
            ->update($data);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Banner Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('theme_settings?sel=others_settings');
    }
    public function bannerRightContact(){
        $file = $this->request->getFile('banner_right_contact');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $target_dir = FCPATH . 'uploads/banner_contact/';

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Generate random temp name
            $tempName = $file->getRandomName();
            $file->move($target_dir, $tempName);

            // Final cropped image name
            $finalName = 'contact_' . time() . '.jpg';

            // Crop & resize
            $this->crop
                ->withFile($target_dir . $tempName)
                ->fit(570, 410, 'center')
                ->save($target_dir . $finalName);

            // Remove temp file
            unlink($target_dir . $tempName);

            $data = [
                'value'    => $finalName,
                'alt_name' => $this->request->getPost('alt_name')
            ];

        } else {
            // Only update alt name if no image uploaded
            $data = [
                'alt_name' => $this->request->getPost('alt_name')
            ];
        }

        DB()->table('cc_theme_settings')
            ->where('label', 'banner_right_contact')
            ->update($data);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Banner Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('theme_settings?sel=others_settings');
    }
    public function bannerBottomContact(){
        $file = $this->request->getFile('banner_bottom_contact');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $target_dir = FCPATH . 'uploads/banner_contact/';

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Generate random temp name
            $tempName = $file->getRandomName();
            $file->move($target_dir, $tempName);

            // Final cropped image name
            $finalName = 'contact_' . time() . '.jpg';

            // Crop & resize
            $this->crop
                ->withFile($target_dir . $tempName)
                ->fit(1116, 311, 'center')
                ->save($target_dir . $finalName);

            // Remove temp file
            unlink($target_dir . $tempName);

            $data = [
                'value'    => $finalName,
                'alt_name' => $this->request->getPost('alt_name')
            ];

        } else {
            // Only update alt name if no image uploaded
            $data = [
                'alt_name' => $this->request->getPost('alt_name')
            ];
        }

        DB()->table('cc_theme_settings')
            ->where('label', 'banner_bottom_contact')
            ->update($data);

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Banner Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('theme_settings?sel=others_settings');
    }



}

