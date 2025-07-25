<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class General_offer extends BaseController
{

    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $imageProcessing;
    private $module_name = 'General_offer';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
        $this->imageProcessing = new Image_processing();
    }

    /**
     * @description This method provides coupon page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_offer');
            $data['offer'] = $table->where('key','general_offer')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/General_offer/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon create page view
     * @return RedirectResponse|void
     */
    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_shipping_method');
            $data['shipping_method'] = $table->where('status',1)->get()->getResult();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->get()->getResult();

            $tableBrand = DB()->table('cc_brand');
            $data['brand'] = $tableBrand->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/General_offer/create',$data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon create action
     * @return RedirectResponse
     */
    public function create_action()
    {
        $data['offer'] = $this->request->getPost('offer');
        $data['slug'] = $this->request->getPost('slug');
        $data['description'] = $this->request->getPost('description');
        $data['products'] = $this->request->getPost('products[]');
        $data['start_date'] = $this->request->getPost('start_date');
        $data['expire_date'] = $this->request->getPost('expire_date');
        $data['offer_type'] = $this->request->getPost('offer_type');

        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['brand'] = $this->request->getPost('brand[]');
        $data['allProduct'] = $this->request->getPost('allProduct');

        $data['offer_on'] = $this->request->getPost('offer_on');
        $data['qty'] = $this->request->getPost('qty');
        $data['on_amount'] = $this->request->getPost('on_amount');
        $data['amount'] = $this->request->getPost('amount');

        $data['discount_on'] = $this->request->getPost('discount_on');
        $data['discount_type'] = $this->request->getPost('discount_type');


        $this->validation->setRules([
            'offer' => ['label' => 'Offer Name', 'rules' => 'required'],
            'slug' => ['label' => 'Slug', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
            'start_date' => ['label' => 'Start Date', 'rules' => 'required'],
            'expire_date' => ['label' => 'Expire Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('general_offer_create');
        } else {



            DB()->transStart();

                $dataOff['name'] = $data['offer'];
                $dataOff['qty'] = $data['qty'];
                $dataOff['slug'] = $data['slug'];
                $dataOff['description'] = $data['description'];
                $dataOff['discount_on'] = $data['discount_on'];
                $dataOff['start_date'] = $data['start_date'];
                $dataOff['expire_date'] = $data['expire_date'];
                $dataOff['offer_type'] = $data['offer_type'];

                $dataOff['offer_on'] = $data['offer_on'];
                $dataOff['on_amount'] = $data['on_amount'];
                $dataOff['key'] = 'general_offer';

                $table = DB()->table('cc_offer');
                $table->insert($dataOff);
                $offer_id = DB()->insertID();

                //discount on
                $dataDis['offer_id'] = $offer_id;
                $dataDis['discount_amount'] = $data['amount'];
                if ($data['discount_type'] == 'discount_percent') {
                    $dataDis['discount_calculate_on'] = 'percentage';
                }else {
                    $dataDis['discount_calculate_on'] = 'fixed';
                }
                $tableDisc = DB()->table('cc_offer_discount');
                $tableDisc->insert($dataDis);

                //offer discount
                if (!empty($data['products'])) {
                    $dataDiscount = array();
                    foreach ($data['products'] as $v) {
                        $dataPro['offer_id'] = $offer_id;
                        $dataPro['product_id'] = $v;
                        array_push($dataDiscount, $dataPro);
                    }
                    $tablePro = DB()->table('cc_offer_on_product');
                    $tablePro->insertBatch($dataDiscount);
                }

                //offer discount category
                if (!empty($data['categorys'])) {
                    $dataDiscountCat = array();
                    foreach ($data['categorys'] as $cat) {
                        $dataCat['offer_id'] = $offer_id;
                        $dataCat['prod_cat_id'] = $cat;
                        array_push($dataDiscountCat, $dataCat);
                    }
                    $tableProCat = DB()->table('cc_offer_on_product');
                    $tableProCat->insertBatch($dataDiscountCat);
                }

                //offer discount brand
                if (!empty($data['brand'])) {
                    $dataBrandArray = array();
                    foreach ($data['brand'] as $brand) {
                        $dataBrand['offer_id'] = $offer_id;
                        $dataBrand['brand_id'] = $brand;
                        array_push($dataBrandArray, $dataBrand);
                    }
                    $tableBra = DB()->table('cc_offer_on_product');
                    $tableBra->insertBatch($dataBrandArray);
                }

                //offer discount all product
                if ($data['allProduct'] == 1){
                    $dataAll['offer_id'] = $offer_id;
                    $tableAll = DB()->table('cc_offer_on_product');
                    $tableAll->insert($dataAll);
                }



                //Offer table data insert(end)
                if (!empty($_FILES['banner']['name'])) {
                    //image size array
                    $this->imageProcessing->sizeArray = [['width'=>'880', 'height'=>'400', ],['width'=>'50', 'height'=>'50', ],];

                    $target_dir = FCPATH . '/uploads/offer/'.$offer_id.'/';
                    $this->imageProcessing->directory_create($target_dir);

                    //new image upload
                    $pic = $this->request->getFile('banner');
                    $news_img = $this->imageProcessing->image_upload_and_crop_all_size($pic,$target_dir);

                    $dataImg['banner'] = $news_img;

                    $albumTable = DB()->table('cc_offer');
                    $albumTable->where('offer_id',$offer_id)->update($dataImg);
                }
                //Offer table data insert(end)

            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Offer Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('general_offer_create');
        }
    }

    /**
     * @description This method provides coupon update page view
     * @param int $offer_id
     * @return RedirectResponse|void
     */
    public function update($offer_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_offer');
            $data['offer'] = $table->where('offer_id', $offer_id)->get()->getRow();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->get()->getResult();

            $tableBrand = DB()->table('cc_brand');
            $data['brand'] = $tableBrand->get()->getResult();

            $tableCoup = DB()->table('cc_offer_on_product');
            $data['offer_product'] = $tableCoup->where('offer_id', $offer_id)->get()->getResult();

            $tableDis = DB()->table('cc_offer_discount');
            $data['discount'] = $tableDis->where('offer_id', $offer_id)->get()->getRow();



            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/General_offer/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides coupon update action
     * @return RedirectResponse
     */
    public function update_action()
    {
        $offer_id = $this->request->getPost('offer_id');
        $data['offer'] = $this->request->getPost('offer');
        $data['qty'] = $this->request->getPost('qty');
        $data['slug'] = $this->request->getPost('slug');
        $data['description'] = $this->request->getPost('description');
        $data['products'] = $this->request->getPost('products[]');
        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['start_date'] = $this->request->getPost('start_date');
        $data['expire_date'] = $this->request->getPost('expire_date');
        $data['offer_type'] = $this->request->getPost('offer_type');

        $data['brand'] = $this->request->getPost('brand[]');
        $data['allProduct'] = $this->request->getPost('allProduct');

        $data['offer_on'] = $this->request->getPost('offer_on');
        $data['on_amount'] = $this->request->getPost('on_amount');
        $data['amount'] = $this->request->getPost('amount');
        $data['discount_on'] = $this->request->getPost('discount_on');
        $data['discount_type'] = $this->request->getPost('discount_type');


        $this->validation->setRules([
            'offer' => ['label' => 'Offer Name', 'rules' => 'required'],
            'slug' => ['label' => 'Slug', 'rules' => 'required'],
            'description' => ['label' => 'Description', 'rules' => 'required'],
            'start_date' => ['label' => 'Start Date', 'rules' => 'required'],
            'expire_date' => ['label' => 'Expire Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('general_offer_update/'.$offer_id);
        } else {

            DB()->transStart();
                $dataOff['name'] = $data['offer'];
                $dataOff['qty'] = $data['qty'];
                $dataOff['slug'] = $data['slug'];
                $dataOff['description'] = $data['description'];
                $dataOff['discount_on'] = $data['discount_on'];
                $dataOff['start_date'] = $data['start_date'];
                $dataOff['expire_date'] = $data['expire_date'];
                $dataOff['offer_type'] = $data['offer_type'];

                $dataOff['offer_on'] = $data['offer_on'];
                $dataOff['on_amount'] = $data['on_amount'];


                $table = DB()->table('cc_offer');
                $table->where('offer_id',$offer_id)->update($dataOff);


                //discount on
                $tableProDis = DB()->table('cc_offer_discount');
                $tableProDis->where('offer_id', $offer_id)->delete();

                $dataDis['offer_id'] = $offer_id;
                $dataDis['discount_amount'] = $data['amount'];
                if ($data['discount_type'] == 'discount_percent') {
                    $dataDis['discount_calculate_on'] = 'percentage';
                }else {
                    $dataDis['discount_calculate_on'] = 'fixed';
                }
                $tableDisc = DB()->table('cc_offer_discount');
                $tableDisc->insert($dataDis);


                //offer discount product delete
                $tableProD = DB()->table('cc_offer_on_product');
                $tableProD->where('offer_id', $offer_id)->delete();

                if (!empty($data['products'])) {
                    //offer discount products insert
                    $dataDiscount = array();
                    foreach ($data['products'] as $v) {
                        $dataPro['offer_id'] = $offer_id;
                        $dataPro['product_id'] = $v;
                        array_push($dataDiscount, $dataPro);
                    }
                    $tablePro = DB()->table('cc_offer_on_product');
                    $tablePro->insertBatch($dataDiscount);
                }

                //offer discount brand
                if (!empty($data['brand'])) {
                    $dataBrandArray = array();
                    foreach ($data['brand'] as $brand) {
                        $dataBrand['offer_id'] = $offer_id;
                        $dataBrand['brand_id'] = $brand;
                        array_push($dataBrandArray, $dataBrand);
                    }
                    $tableBra = DB()->table('cc_offer_on_product');
                    $tableBra->insertBatch($dataBrandArray);
                }

                //offer discount all product
                if ($data['allProduct'] == 1){
                    $dataAll['offer_id'] = $offer_id;
                    $tableAll = DB()->table('cc_offer_on_product');
                    $tableAll->insert($dataAll);
                }



                //offer discount
                if (!empty($data['categorys'])) {
                    $dataDiscountCat = array();
                    foreach ($data['categorys'] as $cat) {
                        $dataCat['offer_id'] = $offer_id;
                        $dataCat['prod_cat_id'] = $cat;
                        array_push($dataDiscountCat, $dataCat);
                    }
                    $tableProCat = DB()->table('cc_offer_on_product');
                    $tableProCat->insertBatch($dataDiscountCat);
                }



                //Offer table data insert(end)
                if (!empty($_FILES['banner']['name'])) {
                    //image size array
                    $this->imageProcessing->sizeArray = [['width'=>'880', 'height'=>'400', ],['width'=>'50', 'height'=>'50', ],];
                    $oldImg = get_data_by_id('banner','cc_offer','offer_id',$offer_id);

                    $target_dir = FCPATH . '/uploads/offer/'.$offer_id.'/';
                    $targetDirCache = FCPATH . '/cache/uploads/offer/'.$offer_id.'/';
                    $this->imageProcessing->directory_create($target_dir);

                    //new image upload
                    $pic = $this->request->getFile('banner');

                    $news_img = $this->imageProcessing->single_product_image_unlink($target_dir,$oldImg)->single_product_image_unlink($targetDirCache,$oldImg)->image_upload_and_crop_all_size($pic,$target_dir);

                    $dataImg['banner'] = $news_img;

                    $albumTable = DB()->table('cc_offer');
                    $albumTable->where('offer_id',$offer_id)->update($dataImg);
                }
                //Offer table data insert(end)

            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Offer Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('general_offer_update/'.$offer_id);
        }
    }

    /**
     * @description This method provides coupon delete
     * @param $offer_id
     * @return RedirectResponse
     */
    public function delete($offer_id){
        helper('filesystem');
        DB()->transStart();
            $target_dir = FCPATH . '/uploads/offer/'.$offer_id;
            if (file_exists($target_dir)) {
                delete_files($target_dir, TRUE);
                rmdir($target_dir);
            }

            $targetDirCache = FCPATH . '/cache/uploads/offer/'.$offer_id;
            if (file_exists($targetDirCache)) {
                delete_files($targetDirCache, TRUE);
                rmdir($targetDirCache);
            }

            $table = DB()->table('cc_offer_on_product');
            $table->where('offer_id', $offer_id)->delete();

            $tableDisc = DB()->table('cc_offer_discount');
            $tableDisc->where('offer_id', $offer_id)->delete();

            $table = DB()->table('cc_offer');
            $table->where('offer_id', $offer_id)->delete();
        DB()->transComplete();
        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Offer Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('general_offer');
    }

}
