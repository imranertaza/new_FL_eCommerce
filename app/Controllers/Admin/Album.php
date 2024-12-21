<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class Album extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $imageProcessing;
    private $module_name = 'Album';

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
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_album');
            $data['album'] = $table->where('parent_album_id', '0')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Album/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album create page view
     * @return RedirectResponse|void
     */
    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_album');
            $data['albumParent'] = $table->where('is_parent', '1')->where('is_album_uploadable', '1')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Album/create',$data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @return RedirectResponse|void
     */
    public function folder_create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_album');
            $data['albumParent'] = $table->where('is_parent', '1')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Album/folder_create',$data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @return RedirectResponse
     */
    public function folder_create_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['parent_album_id'] = $this->request->getPost('parent_album_id');
        $data['is_parent'] = '1';
        $data['createdBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_folder_create');
        } else {

            $table = DB()->table('cc_album');
            $table->insert($data);
            $albumId = DB()->insertID();

            if (!empty($data['parent_album_id'])){
                $dataChild['is_album_uploadable'] = '0';
                $albumTable = DB()->table('cc_album');
                $albumTable->where('album_id',$data['parent_album_id'])->update($dataChild);
            }

            //image size array
            $this->imageProcessing->sizeArray = [['width'=>'261', 'height'=>'261',],[ 'width'=>'198', 'height'=>'198', ],['width'=>'50', 'height'=>'50', ],];

            //album table data insert(end)
            if (!empty($_FILES['thumb']['name'])) {
                $target_dir = FCPATH . '/uploads/album/'.$albumId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $pic = $this->request->getFile('thumb');

                $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['thumb'] = $news_img;

                $albumTable = DB()->table('cc_album');
                $albumTable->where('album_id',$albumId)->update($dataImg);
            }
            //album table data insert(end)



            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_folder_create');
        }
    }

    /**
     * @param $album_id
     * @return RedirectResponse|void
     */
    public function folder_update($album_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_album');
            $data['album'] = $table->where('album_id', $album_id)->get()->getRow();

            $tablePar = DB()->table('cc_album');
            $data['albumParent'] = $tablePar->where('is_parent', '1')->where('album_id !=', $album_id)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Album/update_folder', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    public function folder_update_action(){
        $album_id = $this->request->getPost('album_id');
        $data['name'] = $this->request->getPost('name');
        $data['parent_album_id'] = $this->request->getPost('parent_album_id');
        $data['sort_order'] = $this->request->getPost('sort_order_al');

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_folder_update/' . $album_id);
        } else {
            //old parent search
            $oldPar = get_data_by_id('parent_album_id','cc_album','album_id',$album_id);


            $table = DB()->table('cc_album');
            $table->where('album_id', $album_id)->update($data);

            //parent has child update
            if (!empty($data['parent_album_id'])){
                $dataChild['is_album_uploadable'] = '0';
                $albumTable = DB()->table('cc_album');
                $albumTable->where('album_id',$data['parent_album_id'])->update($dataChild);
            }

            //old parent has child update
            if($oldPar != $data['parent_album_id']){
                $exist = is_exists('cc_album', 'parent_album_id', $oldPar);
                if ($exist == true){
                    $dataChild['is_album_uploadable'] = '1';
                    $albumTable = DB()->table('cc_album');
                    $albumTable->where('album_id',$oldPar)->update($dataChild);
                }
            }
            //image size array
            $this->imageProcessing->sizeArray = [ ['width'=>'261', 'height'=>'261',],[ 'width'=>'198', 'height'=>'198', ],['width'=>'50', 'height'=>'50', ],];

            //album table data insert(end)
            if (!empty($_FILES['thumb']['name'])) {
                $target_dir = FCPATH . '/uploads/album/'.$album_id.'/';
                //unlink
                $oldImg = get_data_by_id('thumb','cc_album','album_id',$album_id);
                $pic = $this->request->getFile('thumb');
                $news_img = $this->imageProcessing->single_product_image_unlink($target_dir,$oldImg)->directory_create($target_dir)->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['thumb'] = $news_img;

                $proUpTable = DB()->table('cc_album');
                $proUpTable->where('album_id',$album_id)->update($dataImg);
            }
            //album table data insert(end)


            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_folder_update/' . $album_id);

        }
    }

    public function child_list($album_id){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_album');
            $data['album'] = $table->where('parent_album_id', $album_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Album/child_list', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    public function album_list($album_id){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_album');
            $data['album'] = $table->where('parent_album_id', $album_id)->where('is_parent', '0')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Album/album_list', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }
    /**
     * @description This method provides album create action
     * @return RedirectResponse
     */
    public function create_action()
    {
        $data['name'] = $this->request->getPost('name');
        $data['parent_album_id'] = $this->request->getPost('parent_album_id');
        $data['createdBy'] = $this->session->adUserId;

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'parent_album_id' => ['label' => 'Parent album', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_create');
        } else {

            $table = DB()->table('cc_album');
            $table->insert($data);
            $albumId = DB()->insertID();

            //image size array
            $this->imageProcessing->sizeArray = [['width'=>'261', 'height'=>'261',],[ 'width'=>'198', 'height'=>'198', ],['width'=>'50', 'height'=>'50', ],];

            //album table data insert(end)
            if (!empty($_FILES['thumb']['name'])) {
                $target_dir = FCPATH . '/uploads/album/'.$albumId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $pic = $this->request->getFile('thumb');

                $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['thumb'] = $news_img;

                $albumTable = DB()->table('cc_album');
                $albumTable->where('album_id',$albumId)->update($dataImg);
            }
            //album table data insert(end)

            //multi image upload(start)
            if($this->request->getFileMultiple('multiImage')){

                $target_dir = FCPATH . '/uploads/album/'.$albumId.'/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $file) {

                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dataMultiImg['album_id'] = $albumId;
                        $albumImgTable = DB()->table('cc_album_details');
                        $albumImgTable->insert($dataMultiImg);
                        $albumImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/album/'.$albumId.'/'.$albumImgId.'/';
                        $this->imageProcessing->directory_create($target_dir2);

                        $news_img2 = $this->imageProcessing->product_image_upload_and_crop_all_size($file,$target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_album_details');
                        $proImgUpTable->where('album_details_id',$albumImgId)->update($dataMultiImg2);
                    }

                }

            }
            //multi image upload(start)




            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_create');
        }
    }

    /**
     * @description This method provides album update page view
     * @param int $album_id
     * @return RedirectResponse|void
     */
    public function update($album_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_album');
            $data['album'] = $table->where('album_id', $album_id)->get()->getRow();

            $tableAl = DB()->table('cc_album_details');
            $data['albumAll'] = $tableAl->where('album_id', $album_id)->get()->getResult();

            $tablePar = DB()->table('cc_album');
            $data['albumParent'] = $tablePar->where('is_parent', '1')->where('is_album_uploadable', '1')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Album/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $album_id = $this->request->getPost('album_id');
        $data['name'] = $this->request->getPost('name');
        $data['parent_album_id'] = $this->request->getPost('parent_album_id');
        $data['sort_order'] = $this->request->getPost('sort_order_al');

        $this->validation->setRules([
            'name' => ['label' => 'Name', 'rules' => 'required'],
            'parent_album_id' => ['label' => 'Parent album', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_update/' . $album_id);
        } else {

            $table = DB()->table('cc_album');
            $table->where('album_id', $album_id)->update($data);

            //image size array
            $this->imageProcessing->sizeArray = [ ['width'=>'261', 'height'=>'261',],[ 'width'=>'198', 'height'=>'198', ],['width'=>'50', 'height'=>'50', ],];

            //album table data insert(end)
            if (!empty($_FILES['thumb']['name'])) {
                $target_dir = FCPATH . '/uploads/album/'.$album_id.'/';
                //unlink
                $oldImg = get_data_by_id('thumb','cc_album','album_id',$album_id);
                $pic = $this->request->getFile('thumb');
                $news_img = $this->imageProcessing->single_product_image_unlink($target_dir,$oldImg)->directory_create($target_dir)->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['thumb'] = $news_img;

                $proUpTable = DB()->table('cc_album');
                $proUpTable->where('album_id',$album_id)->update($dataImg);
            }
            //album table data insert(end)

            //multi image upload(start)
            if($this->request->getFileMultiple('multiImage')){

                $target_dir = FCPATH . '/uploads/album/'.$album_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as  $file) {

                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dataMultiImg['album_id'] = $album_id;
                        $proImgTable = DB()->table('cc_album_details');
                        $proImgTable->insert($dataMultiImg);
                        $albumImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/album/'.$album_id.'/'.$albumImgId.'/';
                        $news_img2 = $this->imageProcessing->directory_create($target_dir2)->product_image_upload_and_crop_all_size($file,$target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_album_details');
                        $proImgUpTable->where('album_details_id',$albumImgId)->update($dataMultiImg2);
                    }

                }

            }
            //multi image upload(start)

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('album_update/' . $album_id);

        }
    }

    /**
     * @description This method provides album delete
     * @param int $album_id
     * @return RedirectResponse
     */
    public function delete($album_id){

        helper('filesystem');

        DB()->transStart();

        $target_dir = FCPATH . '/uploads/album/'.$album_id;
        if (file_exists($target_dir)) {
            delete_files($target_dir, TRUE);
            rmdir($target_dir);
        }
        $table = DB()->table('cc_album');
        $table->where('album_id', $album_id)->delete();

        $tableDetail = DB()->table('cc_album_details');
        $tableDetail->where('album_id', $album_id)->delete();

        DB()->transComplete();


        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('album');
    }

    /**
     * @description This method provides album sort action
     * @return void
     */
    public function album_image_sort_action(){
        $album_details_id =  $this->request->getPost('album_details_id');

        $data['sort_order'] = $this->request->getPost('value');
        $table = DB()->table('cc_album_details');
        $table->where('album_details_id',$album_details_id)->update($data);
    }

    /**
     * @description This method provides album image delete
     * @return void
     */
    public function image_delete(){
        helper('filesystem');

        $album_details_id = $this->request->getPost('album_details_id');
        $table = DB()->table('cc_album_details');
        $data = $table->where('album_details_id', $album_details_id)->get()->getRow();

        $target_dir = FCPATH . '/uploads/album/'.$data->album_id.'/'.$album_details_id;
        if (file_exists($target_dir)) {
            delete_files($target_dir, TRUE);
            rmdir($target_dir);
        }

        $table->where('album_details_id', $album_details_id)->delete();
        print '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    public function category_delete($album_id){
        helper('filesystem');
        $table = DB()->table('cc_album');
        $count = $table->where('parent_album_id', $album_id)->countAllResults();
        if (empty($count)) {
            DB()->transStart();

            $target_dir = FCPATH . '/uploads/album/' . $album_id;
            if (file_exists($target_dir)) {
                delete_files($target_dir, TRUE);
                rmdir($target_dir);
            }
            $oldPar = get_data_by_id('parent_album_id','cc_album','album_id',$album_id);

            $table = DB()->table('cc_album');
            $table->where('album_id', $album_id)->delete();

            if(!empty($oldPar)){
                $exist = is_exists('cc_album', 'parent_album_id', $oldPar);
                if ($exist == true){
                    $dataChild['is_album_uploadable'] = '1';
                    $albumTable = DB()->table('cc_album');
                    $albumTable->where('album_id',$oldPar)->update($dataChild);
                }
            }

            $tableDetail = DB()->table('cc_album_details');
            $tableDetail->where('album_id', $album_id)->delete();

            DB()->transComplete();


            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please delete child <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }
    }
}
