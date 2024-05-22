<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Permission;

class Advanced_products extends BaseController
{

    protected $validation;
    protected $session;
    protected $permission;
    protected $crop;
    private $module_name = 'Advanced_products';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->permission = new Permission();
        $this->crop = \Config\Services::image();
    }

    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;
        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != TRUE) {
            return redirect()->to(site_url('admin'));
        } else {

            $module_id = get_data_by_id('module_id', 'cc_modules', 'module_key', 'bulk_edit_products');
            $data['moduleSettings'] = get_array_data_by_id('cc_module_settings', 'module_id', $module_id);
            $data['module_id'] = $module_id;


            $table = DB()->table('cc_products');
            $table->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id');
            $data['product'] = $table->orderBy('cc_products.product_id','desc')->get()->getResult();

//            $table = DB()->table('cc_products');
//            $data['product'] = $table->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);
            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }
            echo view('Admin/header');
            echo view('Admin/sidebar');
            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/Advanced_products/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
            echo view('Admin/footer');
        }
    }
    public function bulk_status_update()
    {
        $module_settings_id = $this->request->getPost('module_settings_id');
        $oldStutas = get_data_by_id('value', 'cc_module_settings', 'module_settings_id', $module_settings_id);
        if ($oldStutas == '1') {
            $data['value'] = '0';
        } else {
            $data['value'] = '1';
        }

        $table = DB()->table('cc_module_settings');
        $table->where('module_settings_id', $module_settings_id)->update($data);

        print '<div class="alert alert-success alert-dismissible" role="alert">Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
    }
    public function bulk_data_update()
    {

        $product_id = $this->request->getPost('product_id');
        $name = $this->request->getPost('name');
        $model = $this->request->getPost('model');
        $price = $this->request->getPost('price');
        $quantity = $this->request->getPost('quantity');

        if (!empty($name)) {
            $dataSearch['name'] = $name;
        }
        if (!empty($model)) {
            $dataSearch['model'] = $model;
        }
        if (!empty($price)) {
            $dataSearch['price'] = $price;
        }
        if (!empty($quantity)) {
            $dataSearch['quantity'] = $quantity;
        }

        $table = DB()->table('cc_products');
        $table->where('product_id', $product_id)->update($dataSearch);

        $table2 = DB()->table('cc_products');
        $data['val'] = $table2->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->where('cc_products.product_id', $product_id)->get()->getRow();

        echo view('Admin/Advanced_products/row', $data);


    }
    public function description_data_update(){
        $product_desc_id = $this->request->getPost('product_desc_id');
        $meta_title = $this->request->getPost('meta_title');
        $meta_description = $this->request->getPost('meta_description');
        $meta_keyword = $this->request->getPost('meta_keyword');

        if (isset($meta_title)) {
            $data2['meta_title'] = !empty($meta_title)?$meta_title:null;
        }

        if (isset($meta_description)) {
            $data2['meta_description'] = !empty($meta_description)?$meta_description:null;
        }

        if (isset($meta_keyword)) {
            $data2['meta_keyword'] = !empty($meta_keyword)?$meta_keyword:null;
        }


        $table = DB()->table('cc_product_description');
        $table->where('product_desc_id', $product_desc_id)->update($data2);

        $product_id = get_data_by_id('product_id','cc_product_description','product_desc_id',$product_desc_id);
        $table2 = DB()->table('cc_products');
        $data['val'] = $table2->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->where('cc_products.product_id', $product_id)->get()->getRow();

        echo view('Admin/Advanced_products/row', $data);
    }
    public function bulk_all_status_update()
    {
        $product_id = $this->request->getPost('product_id');
        $field = $this->request->getPost('fieldName');
        $value = $this->request->getPost('value');

        $data[$field] = $value;

        $table = DB()->table('cc_products');
        $table->where('product_id', $product_id)->update($data);

        $table2 = DB()->table('cc_products');
        $data['val'] = $table2->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->where('cc_products.product_id', $product_id)->get()->getRow();

        echo view('Admin/Advanced_products/row', $data);
    }
    public function bulk_category_view()
    {
        $product_id = $this->request->getPost('product_id');
        $table = DB()->table('cc_product_category');
        $data['prodCat'] = $table->get()->getResult();

        $tablecat = DB()->table('cc_product_to_category');
        $data['prodCatSel'] = $tablecat->where('product_id', $product_id)->get()->getResult();

        $data['product_id'] = $product_id;

        echo view('Admin/Advanced_products/category', $data);
    }
    public function bulk_category_update()
    {
        $product_id = $this->request->getPost('product_id');
        $category = $this->request->getPost('categorys[]');


        $catTableDel = DB()->table('cc_product_to_category');
        $catTableDel->where('product_id', $product_id)->delete();

        foreach ($category as $cat) {
            $catData['product_id'] = $product_id;
            $catData['category_id'] = $cat;

            $catTable = DB()->table('cc_product_to_category');
            $catTable->insert($catData);
        }


        $table2 = DB()->table('cc_products');
        $data['val'] = $table2->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->where('cc_products.product_id', $product_id)->get()->getRow();

        echo view('Admin/Advanced_products/row', $data);

    }
    public function bulk_option_view(){
        $product_id = $this->request->getPost('product_id');
        $data['product_id'] = $product_id;

        $table = DB()->table('cc_product_option');
        $data['prodOption'] = $table->where('product_id', $product_id)->groupBy('option_id')->get()->getResult();
        echo view('Admin/Advanced_products/option', $data);
    }
    public function bulk_option_update(){
        $product_id = $this->request->getPost('product_id');

        $option = $this->request->getPost('option[]');
        $opValue = $this->request->getPost('opValue[]');
        $qty = $this->request->getPost('qty[]');
        $subtract = $this->request->getPost('subtract[]');
        $price_op = $this->request->getPost('price_op[]');

        $optionTableDel = DB()->table('cc_product_option');
        $optionTableDel->where('product_id',$product_id)->delete();

        if (!empty($qty)){
            foreach ($qty as $key => $val){
                $optionData['product_id'] = $product_id;
                $optionData['option_id'] = $option[$key];
                $optionData['option_value_id'] = $opValue[$key];
                $optionData['quantity'] = $qty[$key];
                $optionData['subtract'] = ($subtract[$key] == 'plus')?null:1;
                $optionData['price'] = $price_op[$key];

                $optionTable = DB()->table('cc_product_option');
                $optionTable->insert($optionData);
            }
        }



        $table2 = DB()->table('cc_products');
        $data['val'] = $table2->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->where('cc_products.product_id', $product_id)->get()->getRow();

        echo view('Admin/Advanced_products/row', $data);
    }
    public function bulk_product_cpoy(){


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
                foreach ($categ as $cat) {
                    $catData['product_id'] = $productId;
                    $catData['category_id'] = $cat->category_id;

                    $catTable = DB()->table('cc_product_to_category');
                    $catTable->insert($catData);
                }
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
                    foreach ($optData as $valOp) {
                        $optionData['product_id'] = $productId;
                        $optionData['option_id'] = $valOp->option_id;
                        $optionData['option_value_id'] = $valOp->option_value_id;
                        $optionData['quantity'] = $valOp->quantity;
                        $optionData['subtract'] = $valOp->subtract;
                        $optionData['price'] = $valOp->price;

                        $optionTable = DB()->table('cc_product_option');
                        $optionTable->insert($optionData);
                    }
                }

                //product options table data insert(end)


                //product Attribute table data insert(start)
                $attributeTableget = DB()->table('cc_product_attribute');
                $attData = $attributeTableget->where('product_id', $p)->get()->getResult();
                if (!empty($attData)) {
                    foreach ($attData as $valAtt) {
                        $attributeData['product_id'] = $productId;
                        $attributeData['attribute_group_id'] = $valAtt->attribute_group_id;
                        $attributeData['name'] = $valAtt->name;
                        $attributeData['details'] = $valAtt->details;

                        $attributeTable = DB()->table('cc_product_attribute');
                        $attributeTable->insert($attributeData);
                    }
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
                    foreach ($proReltableGetData as $relp) {
                        $proRelData['product_id'] = $productId;
                        $proRelData['related_id'] = $relp->related_id;
                        $proReltable = DB()->table('cc_product_related');
                        $proReltable->insert($proRelData);
                    }
                }
                //product_related table data insert(end)


                // product_bought_together table data insert(start)
                $proBothtableGet = DB()->table('cc_product_bought_together');
                $proBothtableGetData = $proBothtableGet->where('product_id', $p)->get()->getResult();
                if (!empty($proBothtableGetData)) {
                    foreach ($proBothtableGetData as $bothp) {
                        $proBothData['product_id'] = $productId;
                        $proBothData['related_id'] = $bothp->related_id;
                        $proBothtable = DB()->table('cc_product_bought_together');
                        $proBothtable->insert($proBothData);
                    }
                }
                //product_bought_together table data insert(end)
            }
            DB()->transComplete();

            print'<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

        }else{
            print '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

        }
    }
    public function product_multi_delete(){
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

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }
    }
    public function multi_option_edit(){
        $allProductId =  $this->request->getPost('productId[]');
        if (!empty($allProductId)){

            $data['all_product'] = $allProductId;

            $table = DB()->table('cc_product_option');
            $data['prodOption'] = $table->groupBy('option_id')->get()->getResult();



            echo view('Admin/header');
            echo view('Admin/sidebar');
            echo view('Admin/Advanced_products/multi_option', $data);
            echo view('Admin/footer');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }
    }
    public function multi_option_action(){
        $all_product = $this->request->getPost('productId[]');

        $option = $this->request->getPost('option[]');
        $opValue = $this->request->getPost('opValue[]');
        $qty = $this->request->getPost('qty[]');
        $subtract = $this->request->getPost('subtract[]');
        $price_op = $this->request->getPost('price_op[]');



        if (!empty($qty)){
            foreach ($all_product as $p) {
                $optionTableDel = DB()->table('cc_product_option');
                $optionTableDel->where('product_id',$p)->delete();

                foreach ($qty as $key => $val) {
                    $optionData['product_id'] = $p;
                    $optionData['option_id'] = $option[$key];
                    $optionData['option_value_id'] = $opValue[$key];
                    $optionData['quantity'] = $qty[$key];
                    $optionData['subtract'] = ($subtract[$key] == 'plus') ? null : 1;
                    $optionData['price'] = $price_op[$key];

                    $optionTable = DB()->table('cc_product_option');
                    $optionTable->insert($optionData);
                }
            }
            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');

        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid input! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }


    }
    public function multi_attribute_edit(){
        $allProductId =  $this->request->getPost('productId[]');
        if (!empty($allProductId)){

            $data['all_product'] = $allProductId;

            $table = DB()->table('cc_product_option');
            $data['prodOption'] = $table->groupBy('option_id')->get()->getResult();



            echo view('Admin/header');
            echo view('Admin/sidebar');
            echo view('Admin/Advanced_products/multi_attribute', $data);
            echo view('Admin/footer');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please select any product <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }
    }
    public function multi_attribute_action(){
        $all_product = $this->request->getPost('productId[]');

        $attribute_group_id = $this->request->getPost('attribute_group_id[]');
        $name = $this->request->getPost('name[]');
        $details = $this->request->getPost('details[]');

        if (!empty($attribute_group_id)){
            foreach ($all_product as $p) {
                $optionTableDel = DB()->table('cc_product_attribute');
                $optionTableDel->where('product_id', $p)->delete();

                foreach ($attribute_group_id as $key => $val) {
                    $attributeData['product_id'] = $p;
                    $attributeData['attribute_group_id'] = $attribute_group_id[$key];
                    $attributeData['name'] = $name[$key];
                    $attributeData['details'] = $details[$key];

                    $attributeTable = DB()->table('cc_product_attribute');
                    $attributeTable->insert($attributeData);
                }
            }

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Successfully <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }else{
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Invalid input! <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('bulk_edit_products');
        }

    }


}
