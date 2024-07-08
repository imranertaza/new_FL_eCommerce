<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class ProductsModel extends Model {

    protected $table = 'cc_products';
    protected $primaryKey = 'product_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['store_id','name', 'model','product_code','image','brand_id','price','quantity','product_category_id','featured','date_available','weight','length','width','height','sort_order','status','createdBy', 'createdDtm', 'updatedby', 'updatedDtm'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

    public function search_data($keyWord){
        return $this->orLike('product_id',$keyWord)->orLike('name',$keyWord)->orLike('model',$keyWord);
    }

    public function bulk_product_list(){
        return $this->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->orderBy('cc_products.product_id','desc');
    }
    public function search_data_bulk($keyWord){
        return $this->join('cc_product_description', 'cc_product_description.product_id = cc_products.product_id')->orLike('cc_products.product_id',$keyWord)->orLike('cc_products.name',$keyWord)->orLike('cc_products.model',$keyWord)->orderBy('cc_products.product_id','desc');
    }

}