<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Blog extends BaseController
{
    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $imageProcessing;
    private $module_name = 'Blog';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
        $this->imageProcessing = new Image_processing();
    }

    /**
     * @description This method provides album page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_blog');
            $data['blog'] = $table->orderBy('blog_id', 'DESC')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Blog/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album create page view
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
                echo view('Admin/Blog/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album create action
     * @return RedirectResponse
     */
    public function createAction()
    {
        $data['blog_title'] = $this->request->getPost('blog_title');
        $data['alt_name'] = $this->request->getPost('blog_title');
        $data['slug'] = $this->request->getPost('slug');
        $data['cat_id'] = $this->request->getPost('cat_id');
        $data['video_id'] = $this->request->getPost('video_id');
        $data['short_des'] = $this->request->getPost('short_des');
        $data['description'] = $this->request->getPost('description');
        $data['meta_title'] = $this->request->getPost('meta_title');
        $data['meta_keyword'] = $this->request->getPost('meta_keyword');
        $data['meta_description'] = $this->request->getPost('meta_description');
        $data['createdBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'blog_title' => ['label' => 'Title', 'rules' => 'required'],
            'slug' => ['label' => 'Slug', 'rules' => 'required'],
            'cat_id' => ['label' => 'Category', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_create');
        } else {
            DB()->transStart();
            $table = DB()->table('cc_blog');
            $table->insert($data);
            $blogId = DB()->insertID();

            //image size array
            $this->imageProcessing->sizeArray = [];

            if (!empty($_FILES['image']['name'])) {
                $targetDir = FCPATH . '/uploads/blog/' . $blogId . '/';
                $this->imageProcessing->directory_create($targetDir);

                //new image upload
                $pic = $this->request->getFile('image');

                $newsImg = $this->imageProcessing->image_upload_and_crop_all_size($pic, $targetDir);

                $dataImg['image'] = $newsImg;

                $albumTable = DB()->table('cc_blog');
                $albumTable->where('blog_id', $blogId)->update($dataImg);
            }
            //album table data insert(end)

            //multi image upload(start)
            if ($this->request->getFileMultiple('multiImage')) {

                $targetDir = FCPATH . '/uploads/blog/' . $blogId . '/';
                $this->imageProcessing->directory_create($targetDir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $file) {

                    if ($file->isValid() && !$file->hasMoved()) {
                        $dataMultiImg['blog_id'] = $blogId;
                        $dataMultiImg['alt_name'] = $data['alt_name'];
                        $blogImgTable = DB()->table('cc_blog_carousel_image');
                        $blogImgTable->insert($dataMultiImg);
                        $blogCrassulaImageId = DB()->insertID();

                        $targetDirMulti = FCPATH . '/uploads/blog/' . $blogId . '/' . $blogCrassulaImageId . '/';
                        $this->imageProcessing->directory_create($targetDirMulti);

                        $newsImgName = $this->imageProcessing->product_image_upload_and_crop_all_size($file, $targetDirMulti);
                        $dataMultiImgUpdate['image'] = $newsImgName;

                        $blogImgUpTable = DB()->table('cc_blog_carousel_image');
                        $blogImgUpTable->where('blog_crassula_image_id', $blogCrassulaImageId)->update($dataMultiImgUpdate);
                    }
                }
            }
            //multi image upload(start)
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_create');
        }
    }

    /**
     * @description This method provides album update page view
     * @param int $blog_id
     * @return RedirectResponse|void
     */
    public function update($blogId)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $tableCat = DB()->table('cc_category');
            $data['category'] = $tableCat->get()->getResult();


            $table = DB()->table('cc_blog');
            $data['blog'] = $table->where('blog_id', $blogId)->get()->getRow();

            $tableImg = DB()->table('cc_blog_carousel_image');
            $data['crassulaImage'] = $tableImg->where('blog_id', $blogId)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Blog/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides color family update action
     * @return RedirectResponse
     */
    public function updateAction()
    {
        $blogId = $this->request->getPost('blog_id');
        $data['blog_title'] = $this->request->getPost('blog_title');
        $data['alt_name'] = $this->request->getPost('alt_name');
        $data['slug'] = $this->request->getPost('slug');
        $data['cat_id'] = $this->request->getPost('cat_id');
        $data['video_id'] = $this->request->getPost('video_id');
        $data['short_des'] = $this->request->getPost('short_des');
        $data['description'] = $this->request->getPost('description');
        $data['meta_title'] = $this->request->getPost('meta_title');
        $data['meta_keyword'] = $this->request->getPost('meta_keyword');
        $data['meta_description'] = $this->request->getPost('meta_description');
        $data['status'] = $this->request->getPost('status');

        $this->validation->setRules([
            'blog_title' => ['label' => 'Title', 'rules' => 'required'],
            'slug' => ['label' => 'Slug', 'rules' => 'required'],
            'cat_id' => ['label' => 'Category', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_update/' . $blogId);
        } else {
            DB()->transStart();
            $table = DB()->table('cc_blog');
            $table->where('blog_id', $blogId)->update($data);

            //image size array
            $this->imageProcessing->sizeArray = [];

            if (!empty($_FILES['image']['name'])) {
                $targetDir = FCPATH . '/uploads/blog/' . $blogId . '/';
                //unlink
                $oldImg = get_data_by_id('image', 'cc_blog', 'blog_id', $blogId);
                $pic = $this->request->getFile('image');
                $newsImg = $this->imageProcessing->single_product_image_unlink($targetDir, $oldImg)->directory_create($targetDir)->image_upload_and_crop_all_size($pic, $targetDir);

                $dataImg['image'] = $newsImg;

                $proUpTable = DB()->table('cc_blog');
                $proUpTable->where('blog_id', $blogId)->update($dataImg);
            }
            //product table data insert(end)

            //multi image upload(start)
            if ($this->request->getFileMultiple('multiImage')) {

                $targetDir = FCPATH . '/uploads/blog/' . $blogId . '/';
                $this->imageProcessing->directory_create($targetDir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $file) {

                    if ($file->isValid() && !$file->hasMoved()) {
                        $dataMultiImg['blog_id'] = $blogId;
                        $dataMultiImg['alt_name'] = $data['alt_name'];
                        $blogImgTable = DB()->table('cc_blog_carousel_image');
                        $blogImgTable->insert($dataMultiImg);
                        $blogCrassulaImageId = DB()->insertID();

                        $targetDirMulti = FCPATH . '/uploads/blog/' . $blogId . '/' . $blogCrassulaImageId . '/';
                        $this->imageProcessing->directory_create($targetDirMulti);

                        $newsImgName = $this->imageProcessing->product_image_upload_and_crop_all_size($file, $targetDirMulti);
                        $dataMultiImgUpdate['image'] = $newsImgName;

                        $blogImgUpTable = DB()->table('cc_blog_carousel_image');
                        $blogImgUpTable->where('blog_crassula_image_id', $blogCrassulaImageId)->update($dataMultiImgUpdate);
                    }
                }
            }
            //multi image upload(start)
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog_update/' . $blogId);
        }
    }

    /**
     * @description This method provides blog delete
     * @param int $blog_id
     * @return RedirectResponse
     */
    public function delete($blogId)
    {
        helper('filesystem');

        DB()->transStart();

        $targetDir = FCPATH . '/uploads/blog/' . $blogId;

        if (file_exists($targetDir)) {
            delete_files($targetDir, true);
            rmdir($targetDir);
        }
        //cache delete
        $targetDirCash = FCPATH . '/cache/uploads/blog/' . $blogId;
        if (file_exists($targetDirCash)) {
            delete_files($targetDirCash, true);
            rmdir($targetDirCash);
        }

        $table = DB()->table('cc_blog');
        $table->where('blog_id', $blogId)->delete();

        $tableImage = DB()->table('cc_blog_carousel_image');
        $tableImage->where('blog_id', $blogId)->delete();

        DB()->transComplete();


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

        return redirect()->to('admin-blog');
    }

    /**
     * @description This method provides blog image remove
     * @return void
     */
    public function imageRemoveAction(){
        helper('filesystem');
        $id = $this->request->getPost('id');
        $blogId = $this->request->getPost('blogId');

        $targetDir = FCPATH . '/uploads/blog/'.$blogId.'/'.$id;
        if (file_exists($targetDir)) {
            delete_files($targetDir, true);
            rmdir($targetDir);
        }
        //cache delete
        $targetDirCash = FCPATH . '/cache/uploads/blog/'.$blogId.'/'.$id;
        if (file_exists($targetDirCash)) {
            delete_files($targetDirCash, true);
            rmdir($targetDirCash);
        }

        $tableImage = DB()->table('cc_blog_carousel_image');
        $tableImage->where('blog_crassula_image_id', $id)->delete();

        print '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

    }
    /**
     * @description This method provides album alt name action
     * @return void
     */
    public function imageAltNameAction()
    {
        $blog_crassula_image_id = $this->request->getPost('blog_crassula_image_id');

        $data['alt_name'] = $this->request->getPost('value');
        $table = DB()->table('cc_blog_carousel_image');
        $table->where('blog_crassula_image_id', $blog_crassula_image_id)->update($data);
    }
}
