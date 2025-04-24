<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use App\Libraries\Theme_2;
use App\Libraries\Theme_3;
use App\Libraries\Theme_default;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{

    protected $validation;
    protected $session;
    protected $permission;
    protected $theme_3;
    protected $theme_2;
    protected $theme_default;
    protected $imageProcessing;
    protected $crop;
    protected $productsModel;
    private $module_name = 'Products';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
        $this->crop = \Config\Services::image();
        $this->theme_3 = new Theme_3();
        $this->theme_2 = new Theme_2();
        $this->theme_default = new Theme_default();
        $this->productsModel = new ProductsModel();
        $this->imageProcessing = new Image_processing();
    }

    public function old_index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_products');
            $data['product'] = $table->orderBy('product_id','desc')->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Products/index',$data);
            } else {
                echo view('Admin/no_permission');
            }

            if (isset(newSession()->resetDatatable)){unset($_SESSION['resetDatatable']);}
        }
    }

    /**
     * @description This method provides product create page view
     * @return RedirectResponse|void
     */
    public function create(){
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $protable = DB()->table('cc_products');
            $data['products'] = $protable->get()->getResult();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/Products/create',$data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides product create action
     * @return RedirectResponse
     */
    public function create_action() {

        $adUserId = $this->session->adUserId;

        $data['pro_name'] = $this->request->getPost('pro_name');
        $data['model'] = $this->request->getPost('model');
        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['price'] = $this->request->getPost('price');
        $data['quantity'] = $this->request->getPost('quantity');

        $this->validation->setRules([
            'pro_name' => ['label' => 'Name', 'rules' => 'required'],
            'model' => ['label' => 'Model', 'rules' => 'required'],
            'categorys' => ['label' => 'Category', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_create');
        } else {
            DB()->transStart();

            //product table data insert(start)
            $storeId = get_data_by_id('store_id','cc_stores','is_default','1');
            $proData['store_id'] = $storeId;
            $proData['name'] = $data['pro_name'];
            $proData['model'] = $data['model'];
            $proData['brand_id'] = !empty($this->request->getPost('brand_id'))?$this->request->getPost('brand_id'):null;
            $proData['price'] = $data['price'];
            $proData['weight'] = $this->request->getPost('weight');
            $proData['length'] = $this->request->getPost('length');
            $proData['width'] = $this->request->getPost('width');
            $proData['height'] = $this->request->getPost('height');
            $proData['sort_order'] = $this->request->getPost('sort_order');
            $proData['status'] = $this->request->getPost('status');
            $proData['quantity'] = $this->request->getPost('quantity');
            $proData['createdBy'] = $adUserId;

            $product_featured = $this->request->getPost('product_featured');
            if ($product_featured == 'on'){
                $proData['featured'] = '1';
            }

            $proTable = DB()->table('cc_products');
            $proTable->insert($proData);
            $productId = DB()->insertID();


            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $pic = $this->request->getFile('image');
                $news_img = $this->imageProcessing->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['image'] = $news_img;

                $proUpTable = DB()->table('cc_products');
                $proUpTable->where('product_id',$productId)->update($dataImg);
            }
            //product table data insert(end)


            //multi image upload(start)
            if($this->request->getFileMultiple('multiImage')){

                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $file) {

                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dataMultiImg['product_id'] = $productId;
                        $proImgTable = DB()->table('cc_product_image');
                        $proImgTable->insert($dataMultiImg);
                        $proImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/products/'.$productId.'/'.$proImgId.'/';
                        $this->imageProcessing->directory_create($target_dir2);

                        $news_img2 = $this->imageProcessing->product_image_upload_and_crop_all_size($file,$target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_product_image');
                        $proImgUpTable->where('product_image_id',$proImgId)->update($dataMultiImg2);
                    }

                }

            }
            //multi image upload(start)





            //product category insert(start)
            $catData = [];
            foreach ($data['categorys'] as $key => $cat){
                $catData[$key] = [
                    'product_id' => $productId,
                    'category_id' => $cat,
                ];
            }
            $catTable = DB()->table('cc_product_to_category');
            $catTable->insertBatch($catData);
            //product category insert(end)





            //product_free_delivery data insert(start)
            $free_delivery = $this->request->getPost('product_free_delivery');
            if ($free_delivery == 'on'){
                $proFreeData['product_id'] = $productId;
                $proFreetable = DB()->table('cc_product_free_delivery');
                $proFreetable->insert($proFreeData);
            }
            //product_free_delivery data insert(end)



            //product description table data insert(start)
            $proDescData['product_id'] = $productId;
            $proDescData['description'] = !empty($this->request->getPost('description'))?$this->request->getPost('description'):null;
            $proDescData['tag'] = !empty($this->request->getPost('tag'))?$this->request->getPost('tag'):null;
            $proDescData['meta_title'] = !empty($this->request->getPost('meta_title'))?$this->request->getPost('meta_title'):null;
            $proDescData['meta_description'] = !empty($this->request->getPost('meta_description'))?$this->request->getPost('meta_description'):null;
            $proDescData['meta_keyword'] = !empty($this->request->getPost('meta_keyword'))?$this->request->getPost('meta_keyword'):null;
            $proDescData['video'] = !empty($this->request->getPost('video'))?$this->request->getPost('video'):null;
            $proDescData['createdBy'] = $adUserId;



            if (!empty($_FILES['description_image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $despic = $this->request->getFile('description_image');
                $namePic = 'des_' .$despic->getRandomName();
                $despic->move($target_dir, $namePic);

                $proDescData['description_image'] = $namePic;
            }

            if (!empty($_FILES['documentation_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $docPdf = $this->request->getFile('documentation_pdf');
                $nameDoc = 'doc_' .$docPdf->getRandomName();
                $docPdf->move($target_dir, $nameDoc);

                $proDescData['documentation_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['safety_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $safPdf = $this->request->getFile('safety_pdf');
                $nameDoc = 'saf_' .$safPdf->getRandomName();
                $safPdf->move($target_dir, $nameDoc);

                $proDescData['safety_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['instructions_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$productId.'/';
                $this->imageProcessing->directory_create($target_dir);

                //new image upload
                $insPdf = $this->request->getFile('instructions_pdf');
                $nameDoc = 'ins_' .$insPdf->getRandomName();
                $insPdf->move($target_dir, $nameDoc);

                $proDescData['instructions_pdf'] = $nameDoc;
            }

            $proDescTable = DB()->table('cc_product_description');
            $proDescTable->insert($proDescData);
            //product description table data insert(end)
            

            $option = $this->request->getPost('option[]');
            $opValue = $this->request->getPost('opValue[]');
            $qty = $this->request->getPost('qty[]');
            $subtract = $this->request->getPost('subtract[]');
            $price_op = $this->request->getPost('price_op[]');
            if (!empty($qty)){
                $optionData = [];
                foreach ($qty as $key => $val){
                    $optionData[$key] = [
                        'product_id' => $productId,
                        'option_id' => $option[$key],
                        'option_value_id' => $opValue[$key],
                        'quantity' => $qty[$key],
                        'subtract' => ($subtract[$key] == 'plus')?null:1,
                        'price' => $price_op[$key],
                    ];
                }
                $optionTable = DB()->table('cc_product_option');
                $optionTable->insertBatch($optionData);
            }
            //product options table data insert(end)



            //product Attribute table data insert(start)
            $attribute_group_id = $this->request->getPost('attribute_group_id[]');
            $name = $this->request->getPost('name[]');
            $details = $this->request->getPost('details[]');

            if (!empty($attribute_group_id)){
                $attributeData = [];
                foreach ($attribute_group_id as $key => $val){
                    $attributeData[$key] = [
                        'product_id' => $productId,
                        'attribute_group_id' => $attribute_group_id[$key],
                        'name' => $name[$key],
                        'details' => $details[$key],
                    ];
                }
                $attributeTable = DB()->table('cc_product_attribute');
                $attributeTable->insertBatch($attributeData);
            }

            //product Attribute table data insert(end)


            //product product_special table data insert(start)
            $special_price = $this->request->getPost('special_price');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');

            if (!empty($special_price)){
                $specialData['product_id'] = $productId;
                $specialData['special_price'] = $special_price;
                $specialData['start_date'] = $start_date;
                $specialData['end_date'] = $end_date;

                $specialTable = DB()->table('cc_product_special');
                $specialTable->insert($specialData);
            }
            //product product_special table data insert(end)



            //product_related table data insert(start)
            $product_related = $this->request->getPost('product_related[]');
            if (!empty($product_related)){
                $proRelData = [];
                foreach ($product_related as $key => $relp) {
                    $proRelData[$key] = [
                        'product_id' => $productId,
                        'related_id' => $relp,
                    ];
                }
                $proReltable = DB()->table('cc_product_related');
                $proReltable->insertBatch($proRelData);
            }
            //product_related table data insert(end)




            // product_bought_together table data insert(start)
            $bought_together = $this->request->getPost('bought_together[]');
            if (!empty($bought_together)){
                $proBothData = [];
                foreach ($bought_together as $key => $bothp) {
                    $proBothData[$key] = [
                        'product_id' => $productId,
                        'related_id' => $bothp,
                    ];
                }
                $proBothtable = DB()->table('cc_product_bought_together');
                $proBothtable->insertBatch($proBothData);
            }
            //product_bought_together table data insert(end)



            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Create Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_create');
        }
    }

    /**
     * @description This method provides product copy action
     * @return RedirectResponse
     */
    public function copy_action() {
        $allProductId =  $this->request->getPost('productId[]');


        $adUserId = $this->session->adUserId;

        if(!empty($allProductId)) {

            DB()->transStart();
            foreach ($allProductId as $p) {
                $tablePro = DB()->table('cc_products');
                $pro = $tablePro->where('product_id', $p)->get()->getRow();

                //product table data insert(start)
                $storeId = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');
                $proData['store_id'] = $storeId;
                $proData['name'] = 'Copy of '.$pro->name;
                $proData['model'] = $pro->model;
                $proData['brand_id'] = !empty($pro->brand_id) ? $pro->brand_id : null;
                $proData['price'] = $pro->price;
                $proData['weight'] = $pro->weight;
                $proData['length'] = $pro->length;
                $proData['width'] = $pro->width;
                $proData['height'] = $pro->height;
                $proData['sort_order'] = $pro->sort_order;
                $proData['status'] = 'Inactive';
                $proData['quantity'] = $pro->quantity;
                $proData['featured'] = $pro->featured;
                $proData['createdBy'] = $adUserId;

                $proTable = DB()->table('cc_products');
                $proTable->insert($proData);
                $productId = DB()->insertID();


                //product category insert(start)
                $cTable = DB()->table('cc_product_to_category');
                $categ = $cTable->where('product_id', $p)->get()->getResult();
                $catData = [];
                foreach ($categ as $key => $cat) {
                    $catData[$key] = [
                        'product_id' => $productId,
                        'category_id' => $cat->category_id,
                    ];
                }
                $catTable = DB()->table('cc_product_to_category');
                $catTable->insertBatch($catData);
                //product category insert(end)


                //product_free_delivery data insert(start)
                $proFrDetable = DB()->table('cc_product_free_delivery');
                $free_delivery = $proFrDetable->where('product_id', $p)->countAllResults();
                if (!empty($free_delivery)) {
                    $proFreeData['product_id'] = $productId;
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->insert($proFreeData);
                }
                //product_free_delivery data insert(end)


                //product description table data insert(start)
                $proDescTableget = DB()->table('cc_product_description');
                $des = $proDescTableget->where('product_id', $p)->get()->getRow();

                $proDescData['product_id'] = $productId;
                $proDescData['description'] = !empty($des->description) ? $des->description : null;
                $proDescData['tag'] = !empty($des->tag) ? $des->tag : null;
                $proDescData['meta_title'] = !empty($des->meta_title) ? $des->meta_title : null;
                $proDescData['meta_description'] = !empty($des->meta_description) ? $des->meta_description : null;
                $proDescData['meta_keyword'] = !empty($des->meta_keyword) ? $des->meta_keyword : null;
                $proDescData['video'] = !empty($des->video) ? $des->video : null;
                $proDescData['createdBy'] = $adUserId;


                $proDescTable = DB()->table('cc_product_description');
                $proDescTable->insert($proDescData);
                //product description table data insert(end)


                $optionTableGet = DB()->table('cc_product_option');
                $optData = $optionTableGet->where('product_id', $p)->get()->getResult();
                if (!empty($optData)) {
                    $optionData = [];
                    foreach ($optData as $key => $valOp) {
                        $optionData[$key] = [
                            'product_id' => $productId,
                            'option_id' => $valOp->option_id,
                            'option_value_id' => $valOp->option_value_id,
                            'quantity' => $valOp->quantity,
                            'subtract' => $valOp->subtract,
                            'price' => $valOp->price,
                        ];
                    }
                    $optionTable = DB()->table('cc_product_option');
                    $optionTable->insertBatch($optionData);
                }

                //product options table data insert(end)


                //product Attribute table data insert(start)
                $attributeTableget = DB()->table('cc_product_attribute');
                $attData = $attributeTableget->where('product_id', $p)->get()->getResult();
                if (!empty($attData)) {
                    $attributeData = [];
                    foreach ($attData as $key => $valAtt) {
                        $attributeData[$key] = [
                            'product_id' => $productId,
                            'attribute_group_id' => $valAtt->attribute_group_id,
                            'name' => $valAtt->name,
                            'details' => $valAtt->details,
                        ];
                    }
                    $attributeTable = DB()->table('cc_product_attribute');
                    $attributeTable->insertBatch($attributeData);
                }

                //product Attribute table data insert(end)


                //product product_special table data insert(start)
                $specialTableGet = DB()->table('cc_product_special');
                $spec = $specialTableGet->where('product_id', $p)->get()->getRow();
                if (!empty($spec)) {
                    $specialData['product_id'] = $productId;
                    $specialData['special_price'] = $spec->special_price;
                    $specialData['start_date'] = $spec->start_date;
                    $specialData['end_date'] = $spec->end_date;

                    $specialTable = DB()->table('cc_product_special');
                    $specialTable->insert($specialData);
                }
                //product product_special table data insert(end)


                //product_related table data insert(start)
                $proReltableGet = DB()->table('cc_product_related');
                $proReltableGetData = $proReltableGet->where('product_id', $p)->get()->getResult();
                if (!empty($proReltableGetData)) {
                    $proRelData = [];
                    foreach ($proReltableGetData as $key => $relp) {
                        $proRelData[$key] = [
                             'product_id' => $productId,
                             'related_id' => $relp->related_id,
                        ];
                    }
                    $proReltable = DB()->table('cc_product_related');
                    $proReltable->insertBatch($proRelData);
                }
                //product_related table data insert(end)


                // product_bought_together table data insert(start)
                $proBothtableGet = DB()->table('cc_product_bought_together');
                $proBothtableGetData = $proBothtableGet->where('product_id', $p)->get()->getResult();
                if (!empty($proBothtableGetData)) {
                    $proBothData = [];
                    foreach ($proBothtableGetData as $key => $bothp) {
                        $proBothData[$key] = [
                            'product_id' => $productId,
                            'related_id' => $bothp->related_id,
                        ];
                    }
                    $proBothtable = DB()->table('cc_product_bought_together');
                    $proBothtable->insertBatch($proBothData);
                }
                //product_bought_together table data insert(end)
            }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Copy Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('products?page=1');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }

    }

    /**
     * @description This method provides product update page view
     * @param int $product_id
     * @return RedirectResponse|void
     */
    public function update($product_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $table = DB()->table('cc_products');
            $table->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id ');
            $data['prod'] = $table->where('cc_products.product_id', $product_id)->get()->getRow();

            $table = DB()->table('cc_product_category');
            $data['prodCat'] = $table->get()->getResult();

            $tablecat = DB()->table('cc_product_to_category');
            $data['prodCatSel'] = $tablecat->where('product_id', $product_id)->get()->getResult();

            $tablefreeDel = DB()->table('cc_product_free_delivery');
            $data['free_delivery'] = $tablefreeDel->where('product_id', $product_id)->countAllResults();

            $tableOpti = DB()->table('cc_product_option');
            $data['prodOption'] = $tableOpti->where('product_id', $product_id)->groupBy('option_id')->get()->getResult();

            $tableAttr = DB()->table('cc_product_attribute');
            $data['prodattribute'] = $tableAttr->where('product_id', $product_id)->get()->getResult();

            $tableSpec = DB()->table('cc_product_special');
            $data['prodspecial'] = $tableSpec->where('product_id', $product_id)->get()->getRow();

            $tableimg = DB()->table('cc_product_image');
            $data['prodimage'] = $tableimg->where('product_id', $product_id)->get()->getResult();

            $tableRel = DB()->table('cc_product_related');
            $data['prodrelated'] = $tableRel->where('product_id', $product_id)->get()->getResult();

            $tableBoth = DB()->table('cc_product_bought_together');
            $data['prodBothTog'] = $tableBoth->where('product_id', $product_id)->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/Products/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides product update action
     * @return RedirectResponse
     */
    public function update_action(){

        $adUserId = $this->session->adUserId;

        $product_id = $this->request->getPost('product_id');

        $data['pro_name'] = $this->request->getPost('pro_name');
        $data['model'] = $this->request->getPost('model');
        $data['categorys'] = $this->request->getPost('categorys[]');
        $data['price'] = $this->request->getPost('price');
        $data['quantity'] = $this->request->getPost('quantity');

        $this->validation->setRules([
            'pro_name' => ['label' => 'Name', 'rules' => 'required'],
            'model' => ['label' => 'Model', 'rules' => 'required'],
            'categorys' => ['label' => 'Category', 'rules' => 'required'],
            'price' => ['label' => 'Price', 'rules' => 'required'],
            'quantity' => ['label' => 'Quantity', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_update/'.$product_id);
        } else {
            DB()->transStart();

            //product table data insert(start)
            $proData['name'] = $data['pro_name'];
            $proData['model'] = $data['model'];
            $proData['brand_id'] = !empty($this->request->getPost('brand_id'))?$this->request->getPost('brand_id'):null;
            $proData['price'] = $data['price'];
            $proData['weight'] = $this->request->getPost('weight');
            $proData['length'] = $this->request->getPost('length');
            $proData['width'] = $this->request->getPost('width');
            $proData['height'] = $this->request->getPost('height');
            $proData['sort_order'] = $this->request->getPost('sort_order');
            $proData['status'] = $this->request->getPost('status');
            $proData['quantity'] = $this->request->getPost('quantity');

            $product_featured = $this->request->getPost('product_featured');
            if ($product_featured == 'on'){
                $proData['featured'] = '1';
            }else{
                $proData['featured'] = '0';
            }

            $proTable = DB()->table('cc_products');
            $proTable->where('product_id',$product_id)->update($proData);



            if (!empty($_FILES['image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';

                //unlink
                $oldImg = get_data_by_id('image','cc_products','product_id',$product_id);
                $pic = $this->request->getFile('image');
                $news_img = $this->imageProcessing->single_product_image_unlink($target_dir,$oldImg)->directory_create($target_dir)->product_image_upload_and_crop_all_size($pic,$target_dir);

                $dataImg['image'] = $news_img;

                $proUpTable = DB()->table('cc_products');
                $proUpTable->where('product_id',$product_id)->update($dataImg);
            }
            //product table data insert(end)


            //multi image upload(start)
            if($this->request->getFileMultiple('multiImage')){

                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                $files = $this->request->getFileMultiple('multiImage');
                foreach ($files as $key => $file) {

                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dataMultiImg['product_id'] = $product_id;
                        $proImgTable = DB()->table('cc_product_image');
                        $proImgTable->insert($dataMultiImg);
                        $proImgId = DB()->insertID();

                        $target_dir2 = FCPATH . '/uploads/products/'.$product_id.'/'.$proImgId.'/';
                        $news_img2 = $this->imageProcessing->directory_create($target_dir2)->product_image_upload_and_crop_all_size($file,$target_dir2);

                        $dataMultiImg2['image'] = $news_img2;

                        $proImgUpTable = DB()->table('cc_product_image');
                        $proImgUpTable->where('product_image_id',$proImgId)->update($dataMultiImg2);
                    }

                }

            }
            //multi image upload(start)


            //product category insert(start)
            $catTableDel = DB()->table('cc_product_to_category');
            $catTableDel->where('product_id',$product_id)->delete();
            $catData = [];
            foreach ($data['categorys'] as $key => $cat){
                $catData[$key] = [
                    'product_id' => $product_id,
                    'category_id' => $cat,
                ];
            }
            $catTable = DB()->table('cc_product_to_category');
            $catTable->insertBatch($catData);
            //product category insert(end)





            //product_free_delivery data insert(start)
            $free_delivery = $this->request->getPost('product_free_delivery');
            if ($free_delivery == 'on'){
                if (is_exists('cc_product_free_delivery','product_id',$product_id) == true) {
                    $proFreeData['product_id'] = $product_id;
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->insert($proFreeData);
                }
            }else{
                if (is_exists('cc_product_free_delivery','product_id',$product_id) == false) {
                    $proFreetable = DB()->table('cc_product_free_delivery');
                    $proFreetable->where('product_id', $product_id)->delete();
                }
            }
            //product_free_delivery data insert(end)



            //product description table data insert(start)
            $proDescData['product_id'] = $product_id;
            $proDescData['description'] = !empty($this->request->getPost('description'))?$this->request->getPost('description'):null;
            $proDescData['tag'] = !empty($this->request->getPost('tag'))?$this->request->getPost('tag'):null;
            $proDescData['meta_title'] = !empty($this->request->getPost('meta_title'))?$this->request->getPost('meta_title'):null;
            $proDescData['meta_description'] = !empty($this->request->getPost('meta_description'))?$this->request->getPost('meta_description'):null;
            $proDescData['meta_keyword'] = !empty($this->request->getPost('meta_keyword'))?$this->request->getPost('meta_keyword'):null;
            $proDescData['video'] = !empty($this->request->getPost('video'))?$this->request->getPost('video'):null;


            if (!empty($_FILES['description_image']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('description_image','cc_product_description','product_id',$product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }


                //new image upload
                $despic = $this->request->getFile('description_image');
                $namePic = 'des_' .$despic->getRandomName();
                $despic->move($target_dir, $namePic);

                $proDescData['description_image'] = $namePic;
            }

            if (!empty($_FILES['documentation_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('documentation_pdf','cc_product_description','product_id',$product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $docPdf = $this->request->getFile('documentation_pdf');
                $nameDoc = 'doc_' .$docPdf->getRandomName();
                $docPdf->move($target_dir, $nameDoc);

                $proDescData['documentation_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['safety_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('safety_pdf','cc_product_description','product_id',$product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $safPdf = $this->request->getFile('safety_pdf');
                $nameDoc = 'saf_' .$safPdf->getRandomName();
                $safPdf->move($target_dir, $nameDoc);

                $proDescData['safety_pdf'] = $nameDoc;
            }

            if (!empty($_FILES['instructions_pdf']['name'])) {
                $target_dir = FCPATH . '/uploads/products/'.$product_id.'/';
                $this->imageProcessing->directory_create($target_dir);

                //unlink
                $oldImg = get_data_by_id('instructions_pdf','cc_product_description','product_id',$product_id);
                if ((!empty($oldImg)) && (file_exists($target_dir))) {
                    $this->imageProcessing->image_unlink($target_dir . '/' . $oldImg);
                }

                //new image upload
                $insPdf = $this->request->getFile('instructions_pdf');
                $nameDoc = 'ins_' .$insPdf->getRandomName();
                $insPdf->move($target_dir, $nameDoc);

                $proDescData['instructions_pdf'] = $nameDoc;
            }

            $proDescTable = DB()->table('cc_product_description');
            $proDescTable->where('product_id',$product_id)->update($proDescData);
            //product description table data insert(end)





            $option = $this->request->getPost('option[]');
            $opValue = $this->request->getPost('opValue[]');
            $qty = $this->request->getPost('qty[]');
            $subtract = $this->request->getPost('subtract[]');
            $price_op = $this->request->getPost('price_op[]');

            $optionTableDel = DB()->table('cc_product_option');
            $optionTableDel->where('product_id',$product_id)->delete();

            if (!empty($qty)){
                $optionData = [];
                foreach ($qty as $key => $val){
                    $optionData[$key] = [
                        'product_id' => $product_id,
                        'option_id' => $option[$key],
                        'option_value_id' => $opValue[$key],
                        'quantity' => $qty[$key],
                        'subtract' => ($subtract[$key] == 'plus')?null:1,
                        'price' => $price_op[$key],
                    ];
                }
                $optionTable = DB()->table('cc_product_option');
                $optionTable->insertBatch($optionData);
            }
            //product options table data insert(end)



            //product Attribute table data insert(start)
            $attribute_group_id = $this->request->getPost('attribute_group_id[]');
            $name = $this->request->getPost('name[]');
            $details = $this->request->getPost('details[]');

            $attributeTableDel = DB()->table('cc_product_attribute');
            $attributeTableDel->where('product_id',$product_id)->delete();

            if (!empty($attribute_group_id)){
                $attributeData = [];
                foreach ($attribute_group_id as $key => $val){
                    $attributeData[$key] = [
                        'product_id' => $product_id,
                        'attribute_group_id' => $attribute_group_id[$key],
                        'name' => $name[$key],
                        'details' => $details[$key],
                    ];
                }
                $attributeTable = DB()->table('cc_product_attribute');
                $attributeTable->insertBatch($attributeData);
            }

            //product Attribute table data insert(end)


            //product product_special table data insert(start)
            $special_price = $this->request->getPost('special_price');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');

            if (!empty($special_price)){
                $specialData['product_id'] = $product_id;
                $specialData['special_price'] = $special_price;
                $specialData['start_date'] = $start_date;
                $specialData['end_date'] = $end_date;

                $specialTable = DB()->table('cc_product_special');
                $checkSpec = $specialTable->where('product_id',$product_id)->countAllResults();
                if (empty($checkSpec)) {
                    $specialTable->insert($specialData);
                }else{
                    $specialTable->where('product_id',$product_id)->update($specialData);
                }

            }else{
                $specialTable = DB()->table('cc_product_special');
                $specialTable->where('product_id',$product_id)->delete();
            }
            //product product_special table data insert(end)



            //product_related table data insert(start)
            $product_related = $this->request->getPost('product_related[]');

            $proReltableDel = DB()->table('cc_product_related');
            $proReltableDel->where('product_id',$product_id)->delete();

            if (!empty($product_related)){
                $proRelData = [];
                foreach ($product_related as $key => $relp) {
                    $proRelData[$key] = [
                        'product_id' => $product_id,
                        'related_id' => $relp,
                    ];
                }
                $proReltable = DB()->table('cc_product_related');
                $proReltable->insertBatch($proRelData);
            }
            //product_related table data insert(end)


            // product_bought_together table data insert(start)
            $bought_together = $this->request->getPost('bought_together[]');

            $boughtTogetherDel = DB()->table('cc_product_bought_together');
            $boughtTogetherDel->where('product_id',$product_id)->delete();

            if (!empty($bought_together)){

                $proBothData = [];
                foreach ($bought_together as $key => $bothp) {
                    $proBothData[$key] = [
                        'product_id' => $product_id,
                        'related_id' => $bothp,
                    ];
                }
                $proBothtable = DB()->table('cc_product_bought_together');
                $proBothtable->insertBatch($proBothData);
            }
            //product_bought_together table data insert(end)



            DB()->transComplete();
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Update Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('product_update/'.$product_id);

        }
    }

    /**
     * @description This method provides product delete
     * @return void
     */
    public function delete(){
        $product_id = $this->request->getPost('product_id');

        helper('filesystem');

        DB()->transStart();

        $target_dir = FCPATH . '/uploads/products/'.$product_id;
        if (file_exists($target_dir)) {
            delete_files($target_dir, TRUE);
            rmdir($target_dir);
        }

        $proTable = DB()->table('cc_products');
        $proTable->where('product_id',$product_id)->delete();

        $proImgTable = DB()->table('cc_product_image');
        $proImgTable->where('product_id',$product_id)->delete();

        $catTableDel = DB()->table('cc_product_to_category');
        $catTableDel->where('product_id',$product_id)->delete();

        $proFreetable = DB()->table('cc_product_free_delivery');
        $proFreetable->where('product_id', $product_id)->delete();

        $proDescTable = DB()->table('cc_product_description');
        $proDescTable->where('product_id',$product_id)->delete();

        $optionTableDel = DB()->table('cc_product_option');
        $optionTableDel->where('product_id',$product_id)->delete();

        $attributeTableDel = DB()->table('cc_product_attribute');
        $attributeTableDel->where('product_id',$product_id)->delete();

        $specialTable = DB()->table('cc_product_special');
        $specialTable->where('product_id',$product_id)->delete();

        $proReltableDel = DB()->table('cc_product_related');
        $proReltableDel->where('product_id',$product_id)->delete();

        $relProTableDel = DB()->table('cc_product_related');
        $relProTableDel->where('related_id', $product_id)->delete();

        $proBotTableDel = DB()->table('cc_product_bought_together');
        $proBotTableDel->where('product_id',$product_id)->delete();

        $bothTableDel = DB()->table('cc_product_bought_together');
        $bothTableDel->where('related_id', $product_id)->delete();

        DB()->transComplete();

        print '<div class="alert alert-success alert-dismissible" role="alert">Products Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    /**
     * @description This method provides get subCategory
     * @return void
     */
    public function get_subCategory(){
        $categoryID = $this->request->getPost('cat_id');
        $table = DB()->table('cc_product_category');
        $data = $table->where('parent_id',$categoryID)->get()->getResult();
        $view ='';
        if (!empty($data)) {
            $view .= '<label>Sub Category</label><select name="sub_category" class="form-control" ><option value="">Please select</option>';
            foreach ($data as $val) {
                $view .= '<option value="' . $val->prod_cat_id . '" >' . $val->category_name . '</option>';
            }
            $view .= '</select>';
        }

        print $view;
    }

    /**
     * @description This method provides related product
     * @return ResponseInterface
     */
    public function related_product(){
        $product = [];
        $keyword = $this->request->getGet('q');
        $table = DB()->table('cc_products');
        $product = $table->like('name', $keyword)->get()->getResult();

        return $this->response->setJSON($product);
    }

    /**
     * @description This method provides image delete
     * @return void
     */
    public function image_delete(){
        helper('filesystem');

        $product_image_id = $this->request->getPost('product_image_id');
        $table = DB()->table('cc_product_image');
        $data = $table->where('product_image_id', $product_image_id)->get()->getRow();

        $target_dir = FCPATH . '/uploads/products/'.$data->product_id.'/'.$product_image_id;
        if (file_exists($target_dir)) {
            delete_files($target_dir, TRUE);
            rmdir($target_dir);
        }

        $table->where('product_image_id', $product_image_id)->delete();
        print '<div class="alert alert-success alert-dismissible" role="alert">Image Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }

    /**
     * @description This method provides product option search
     * @return void
     */
    public function product_option_search(){
        $keyword = $this->request->getPost('key');
        $table = DB()->table('cc_option');
        $option = $table->like('name', $keyword)->get()->getResult();

        $view = '<ul class="list-unstyled list-op-aj" >';
        foreach ($option as $op){
            $optionname = "'$op->name'";
            $optionname2 = "'".strtolower(str_replace(' ','',$op->name))."'";
            $view .= '<li><a href="javascript:void(0)" onclick="optionViewPro('.$op->option_id.','.$optionname2.','.$optionname.')" >'.$op->name.'</a></li>';
        }
        $view .= '</ul>';

        print $view;
    }

    /**
     * @description This method provides product option value search
     * @return void
     */
    public function product_option_value_search(){
        $option_id = $this->request->getPost('option_id');
        $table = DB()->table('cc_option_value');
        $data = $table->where('option_id',$option_id)->get()->getResult();
        $view = '';
        foreach ($data as $item) {
            $view .= '<option value="'.$item->option_value_id.'">'.$item->name.'</option>';
        }
        print $view;
    }

    /**
     * @description This method provides product image crop
     * @return RedirectResponse|void
     */
    public function image_crop(){
        $allProductId =  $this->request->getPost('productId[]');

        if (!empty($allProductId)) {
            $modules = modules_access();

            //old image query
            $oldProArr = $this->old_image($allProductId);

            //multi image
            $allImage = $this->multi_image($allProductId);


            foreach ($allProductId as $k => $productId) {
                $single = $oldProArr[$k];

                //product main image crop
                $target_dir = FCPATH . '/uploads/products/' . $single->product_id . '/';
                if ((!empty($single->image)) && (file_exists($target_dir))) {
                    $mainImg = str_replace('pro_', '', $single->image);
                    if (file_exists($target_dir . '/' . $mainImg)) {

                        $this->imageProcessing->image_crop($target_dir,$mainImg,$single->image);
                        if ($modules['watermark'] == '1') {
                            $this->imageProcessing->watermark_main_image($target_dir, $mainImg);

                            $this->imageProcessing->watermark_on_resized_image($target_dir, $mainImg);
                            $this->imageProcessing->image_crop($target_dir, '600_wm_' . $mainImg, 'wm_' . $single->image);
                        }

                    }
                }
                //product main image crop end


                // Disable output buffering
                if (ob_get_level() > 0) {
                    ob_end_flush();
                }
                ob_implicit_flush(true);


                // ob_start();

                echo "Starting process...<br>";
                flush(); // Send the output to the browser


                //multi image crop
                if (!empty($allImage)) {
                    $i=0;
                    foreach ($allImage as $key => $val) {
                        if ($val->product_id == $single->product_id) {
                            $target_dir_mult = FCPATH . '/uploads/products/' . $val->product_id . '/' . $val->product_image_id . "/";
                            $oldImgMul = $val->image;
                            if ((!empty($oldImgMul)) && (file_exists($target_dir_mult))) {
                                $mainImgMul = str_replace('pro_', '', $oldImgMul);
                                if (file_exists($target_dir_mult . '/' . $mainImgMul)) {
                                    $this->imageProcessing->image_crop($target_dir_mult, $mainImgMul, $oldImgMul);
                                    if ($modules['watermark'] == '1') {
                                        $this->imageProcessing->watermark_main_image($target_dir_mult, $mainImgMul);

                                        $this->imageProcessing->watermark_on_resized_image($target_dir_mult, $mainImgMul);
                                        $this->imageProcessing->image_crop($target_dir_mult, '600_wm_' . $mainImgMul, 'wm_' . $oldImgMul);
                                    }
                                }
                            }

                            echo "Processing step ".$i++." ...<br>";
                            // ob_flush();
                            flush(); // Send the output to the browser
                            // sleep(1); // Simulate delay
                        }


                    }
                }
            }


            echo "Process completed!<br>";
            flush(); // Send the final output

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'products';
            echo "<script>
                    window.location.href = '" . site_url($redirect_url) . "';
              </script>";
            flush(); // Ensure the redirect script is sent


        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->back();
        }

    }

    /**
     * @description This method provides product old image
     * @param array $productarray
     * @return array
     */
    private function old_image($productarray){
        $table = DB()->table('cc_products');
        $table->select('product_id, image');
        foreach ($productarray as $productId) {
            $table->orWhere('product_id', $productId);
        }
        return $table->get()->getResult();
    }

    /**
     * @description This method provides multi image
     * @param array $productarray
     * @return array
     */
    private function multi_image($productarray){
        $table = DB()->table('cc_product_image');
        $table->select('product_image_id,product_id, image');
        foreach ($productarray as $productId) {
            $table->orWhere('product_id', $productId);
        }
        return $table->get()->getResult();
    }

    /**
     * @description This method provides multi delete action
     * @return RedirectResponse
     */
    public function multi_delete_action(){
        $allProductId =  $this->request->getPost('productId[]');
        if (!empty($allProductId)) {
            helper('filesystem');

            DB()->transStart();
            foreach ($allProductId as $product_id) {


                $target_dir = FCPATH . '/uploads/products/' . $product_id;
                if (file_exists($target_dir)) {
                    delete_files($target_dir, TRUE);
                    rmdir($target_dir);
                }

                $proTable = DB()->table('cc_products');
                $proTable->where('product_id', $product_id)->delete();

                $proImgTable = DB()->table('cc_product_image');
                $proImgTable->where('product_id', $product_id)->delete();

                $catTableDel = DB()->table('cc_product_to_category');
                $catTableDel->where('product_id', $product_id)->delete();

                $proFreetable = DB()->table('cc_product_free_delivery');
                $proFreetable->where('product_id', $product_id)->delete();

                $proDescTable = DB()->table('cc_product_description');
                $proDescTable->where('product_id', $product_id)->delete();

                $optionTableDel = DB()->table('cc_product_option');
                $optionTableDel->where('product_id', $product_id)->delete();

                $attributeTableDel = DB()->table('cc_product_attribute');
                $attributeTableDel->where('product_id', $product_id)->delete();

                $specialTable = DB()->table('cc_product_special');
                $specialTable->where('product_id', $product_id)->delete();

                $proReltableDel = DB()->table('cc_product_related');
                $proReltableDel->where('product_id', $product_id)->delete();

                $relProTableDel = DB()->table('cc_product_related');
                $relProTableDel->where('related_id', $product_id)->delete();

                $proBotTableDel = DB()->table('cc_product_bought_together');
                $proBotTableDel->where('product_id',$product_id)->delete();

                $bothTableDel = DB()->table('cc_product_bought_together');
                $bothTableDel->where('related_id', $product_id)->delete();

            }
            DB()->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Products Delete Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
//            return redirect()->to('products');
            return redirect()->back();
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
//            return redirect()->to('products');
            return redirect()->back();
        }
    }

    /**
     * @description This method provides product image sort action
     * @return void
     */
    public function product_image_sort_action(){
        $product_image_id =  $this->request->getPost('product_image_id');

        $data['sort_order'] = $this->request->getPost('value');
        $table = DB()->table('cc_product_image');
        $table->where('product_image_id',$product_image_id)->update($data);
    }

    /**
     * @description This method provides product index page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $uri = service('uri');
            $urlString = $uri->getPath() . '?' . $this->request->getServer('QUERY_STRING');
            setcookie('product_url_path',$urlString,time()+86400, "/");

            $length = $this->request->getGet('length');
            $keyWord = $this->request->getGet('keyWord');
            $pageNum = $this->request->getGet('page');

            $perPage = !empty($length)?$length:10;
            if (empty($keyWord)) {
                $data['product'] = $this->productsModel->orderBy('product_id', 'desc')->paginate($perPage);
            }else{
                $data['product'] = $this->productsModel->search_data($keyWord)->orderBy('product_id', 'desc')->paginate($perPage);
            }


            $data['pager'] = $this->productsModel->pager;
            $data['links'] = $data['pager']->links('default','custom_pagination');



            $data['keyWord'] = $keyWord;
            $data['length'] = $length;

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Products/list',$data);
            } else {
                echo view('Admin/no_permission');
            }

            if (isset(newSession()->resetDatatable)){unset($_SESSION['resetDatatable']);}
        }
    }

    /**
     * @description This method provides product list view
     * @return void
     */
    public function products_list(){

        $theme = get_lebel_by_value_in_settings('Theme');
        if ($theme == 'Theme_3') {
            $theme_libraries = $this->theme_3;
        }
        if ($theme == 'Default') {
            $theme_libraries = $this->theme_default;
        }
        if ($theme == 'Theme_2') {
            $theme_libraries = $this->theme_2;
        }

//        print 'ok w.png';
        $target_dir = FCPATH . '/uploads/';

//        $this->crop->withFile($target_dir . 'img.jpg')->fit('600', '600', 'center')->save($target_dir . 'new_crop2.jpg','100');
        $bg = imagecreatefromjpeg($target_dir.'new_crop2.jpg');
        $wm = imagecreatefrompng($target_dir.'wt.png');

//        $wm_size = getimagesize($target_dir.'wt.png');
//        imagecopy($bg, $wm, 160, 320, 0, 0, $wm_size[0], $wm_size[1]);
//        imagecopy($bg, $wm, 160, 320, 0, 0, $wm_size[0], $wm_size[1]);


        $marge_right = 50;
        $marge_bottom = 60;
        $sx = imagesx($wm);
        $sy = imagesy($wm);
//
        imagecopy($bg, $wm, imagesx($bg) - $sx - $marge_right, imagesy($bg) - $sy - $marge_bottom, 0, 0, imagesx($wm), imagesy($wm));

//        $w = 200;
//        $h = $w * $size[1] / $size[0];

//        $imf = imagecreatetruecolor($w, $h);
//        imagecopyresampled($bg, $wm, 230, 330,0,0, $w,$h,$size[0],$size[1]);

        ob_start();
        imagejpeg($bg, null, 100);
        $data = ob_get_clean();

        echo '<img src="data:image/jpeg;base64,' . base64_encode( $data ) . '" />';
//        imagePng($bg, $target_dir.'image4.jpg');
//
//        foreach ($theme_libraries->product_image as $pro_img) {
//                $this->crop->withFile($target_dir . 'image4.jpg')->fit($pro_img['width'], $pro_img['height'], 'center')->save($target_dir . $pro_img['width'] . 'image4.jpg','100');
//
//        }


    }

    public function status_update(){

        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {
            $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';

            $allProductId =  $this->request->getPost('productId[]');
            if (!empty($allProductId)) {

                $data['all_product'] = $allProductId;

                //$perm = array('create','read','update','delete','mod_access');
                $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
                foreach ($perm as $key => $val) {
                    $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
                }
                if (isset($data['update']) and $data['update'] == 1) {
                    echo view('Admin/Products/status_update', $data);
                } else {
                    echo view('Admin/no_permission');
                }
            }else{
                $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                return redirect()->to($redirect_url);
            }
        }
    }

    public function status_update_action(){
        $redirect_url = isset($_COOKIE['product_url_path']) ? $_COOKIE['product_url_path'] : 'admin/products';
        $all_product = $this->request->getPost('productId[]');
        $status = $this->request->getPost('status');

        $data['status'] = $status;

        foreach ($all_product as $product_id) {
            $table = DB()->table('cc_products');
            $table->where('product_id',$product_id);
            $table->update($data);
        }

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Product status update successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to($redirect_url);
    }





}
