<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Blog_category extends BaseController
{
    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    private $module_name = 'Blog_category';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
    }

    /**
     * @description This method provides Product category page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_category');
            $data['category'] = $table->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Blog_category/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides create page view
     * @return RedirectResponse|void
     */
    public function create()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_category');
            $data['category'] = $table->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Blog_category/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method store product category
     * @return RedirectResponse
     */
    public function createAction()
    {
        $data['category_name'] = $this->request->getPost('category_name');
        $data['alt_name'] = $this->request->getPost('category_name');
        $data['icon_id'] = !empty($this->request->getPost('icon_id')) ? $this->request->getPost('icon_id') : null;
        $data['parent_id'] = !empty($this->request->getPost('parent_id')) ? $this->request->getPost('parent_id') : null;
        $data['createdBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'category_name' => ['label' => 'Category Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_create');
        } else {
            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/blog_category/';

                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777);
                }

                //new image uplode
                $pic = $this->request->getFile('image');
                $namePic = $pic->getRandomName();
                $pic->move($target_dir, $namePic);
                $news_img = 'category_' . $pic->getName();
                $this->crop->withFile($target_dir . $namePic)->fit(166, 208, 'center')->save($target_dir . $news_img);
                unlink($target_dir . $namePic);
                $data['image'] = $news_img;
            }

            $table = DB()->table('cc_category');
            $table->insert($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_create');
        }
    }

    /**
     * @description This method provides update page view
     * @param int $cat_id
     * @return RedirectResponse|void
     */
    public function update($catId)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_category');
            $data['category'] = $table->where('cat_id', $catId)->get()->getRow();

            $table2 = DB()->table('cc_category');
            $data['allcategory'] = $table2->where('cat_id !=', $catId)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Blog_category/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method update product category
     * @return RedirectResponse
     */
    public function updateAction()
    {
        $catId = $this->request->getPost('cat_id');
        $data['category_name'] = $this->request->getPost('category_name');
        $data['icon_id'] = !empty($this->request->getPost('icon_id')) ? $this->request->getPost('icon_id') : null;
        $data['parent_id'] = !empty($this->request->getPost('parent_id')) ? $this->request->getPost('parent_id') : null;
        $data['description'] = $this->request->getPost('description');
        $data['alt_name'] = $this->request->getPost('alt_name');
        $data['updatedBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'category_name' => ['label' => 'Category Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_update/' . $catId);
        } else {
            if (!empty($_FILES['image']['name'])) {
                $targetDir = FCPATH . '/uploads/blog_category/';

                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777);
                }

                //old image unlink
                $oldImg = get_data_by_id('image', 'cc_category', 'cat_id', $catId);

                if (!empty($oldImg)) {
                    $imgPath = $targetDir . $oldImg;

                    if (file_exists($imgPath)) {
                        unlink($targetDir . $oldImg);
                    }
                }

                //new image uplode
                $pic = $this->request->getFile('image');
                $namePic = $pic->getRandomName();
                $pic->move($targetDir, $namePic);
                $newsImg = 'category_' . $pic->getName();
                $this->crop->withFile($targetDir . $namePic)->fit(166, 208, 'center')->save($targetDir . $newsImg);
                unlink($targetDir . $namePic);
                $data['image'] = $newsImg;
            }

            $table = DB()->table('cc_category');
            $table->where('cat_id', $catId)->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_update/' . $catId);
        }
    }

    /**
     * @description This method update product category
     * @return RedirectResponse
     */
    public function updateActionOthers()
    {
        $catId = $this->request->getPost('cat_id');
        $data['meta_title'] = $this->request->getPost('meta_title');
        $data['meta_keyword'] = $this->request->getPost('meta_keyword');
        $data['meta_description'] = $this->request->getPost('meta_description');
        $data['sort_order'] = $this->request->getPost('sort_order');
        $data['header_menu'] = $this->request->getPost('header_menu');
        $data['side_menu'] = $this->request->getPost('side_menu');


        $data['updatedBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'header_menu' => ['label' => 'Header Menu', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_update/' . $catId);
        } else {
            $table = DB()->table('cc_category');
            $table->where('cat_id', $catId)->update($data);

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_category_update/' . $catId);
        }
    }

    /**
     * @description This method delete product category
     * @param int $cat_id
     * @return RedirectResponse
     */
    public function delete($catId)
    {
        $targetDir = FCPATH . '/uploads/blog_category/';
        //old image unlink
        $oldImg = get_data_by_id('image', 'cc_category', 'cat_id', $catId);

        if (!empty($oldImg)) {
            $imgPath = $targetDir . $oldImg;

            if (file_exists($imgPath)) {
                unlink($targetDir . $oldImg);
            }
        }

        DB()->transStart();
        //delete child category
        $tableCheck = DB()->table('cc_category');
        $checkParent = $tableCheck->where('parent_id', $catId)->countAllResults();

        if (!empty($checkParent)) {
            $categoryUpdateData['parent_id'] = null;
            $tableUpdate = DB()->table('cc_category');
            $tableUpdate->where('parent_id', $catId)->update($categoryUpdateData);
        }

        //delete blog category
        $tableCheckBlog = DB()->table('cc_blog');
        $checkBlog = $tableCheckBlog->where('cat_id', $catId)->countAllResults();

        if (!empty($checkBlog)) {
            $blogUpdateData['cat_id'] = 0;
            $tableUpdateBlog = DB()->table('cc_blog');
            $tableUpdateBlog->where('cat_id', $catId)->update($blogUpdateData);
        }

        //delete category
        $table = DB()->table('cc_category');
        $table->where('cat_id', $catId)->delete();
        DB()->transComplete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        return redirect()->to('blog_category');
    }

    /**
     * @description This method update product category
     * @return void
     */
    public function sortUpdateAction()
    {
        $catId = $this->request->getPost('cat_id');
        $value = $this->request->getPost('value');

        $data['sort_order'] = $value;

        $table = DB()->table('cc_category');
        $table->where('cat_id', $catId)->update($data);
        print '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
}
