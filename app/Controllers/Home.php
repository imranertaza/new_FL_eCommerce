<?php

namespace App\Controllers;

class Home extends BaseController {

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){
        $settings = get_settings();
        $theme = $settings['Theme'];
        $data = $this->$theme();

        $tableBrand = DB()->table('cc_brand');
        $data['brand'] = $tableBrand->limit(20)->get()->getResult();

        $tabPopuler = DB()->table('cc_product_category_popular');
        $data['populerCat'] = $tabPopuler->limit(12)->get()->getResult();

        $data['home_menu'] = true;
        $data['theme'] = $theme;

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Home/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }
    private function Default(){
        $settings = get_settings();
        $category = $settings['home_category'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['products'] = $table->where('cc_product_to_category.category_id', $category)->limit(4)->get()->getResult();

        $featLimit = $settings['featured_products_limit'];
        $data['prodFeat'] = $table->where('status', 'Active')->where('featured', '1')->orderBy('product_id', 'DESC')->limit($featLimit)->get()->getResult();

        return $data;
    }
    private function Theme_2(){
        $settings = get_settings();
        $hot_deals_category = $settings['hot_deals_category'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['hotProSide'] = $table->where('cc_product_to_category.category_id', $hot_deals_category)->get()->getResult();

        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['hotProlimit'] = $table->where('cc_product_to_category.category_id', $hot_deals_category)->limit(3)->get()->getResult();

        //trending_collection_category
        $tr_col_category = $settings['trending_collection_category'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['tranPro'] = $table->where('cc_product_to_category.category_id', $tr_col_category)->get()->getResult();

        // product special
        $table = DB()->table('cc_products');
        $table->join('cc_product_special', 'cc_product_special.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['specialPro'] = $table->limit(7)->get()->getResult();

        $spc_category = $settings['special_category_one'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['special_category_onePro'] = $table->where('cc_product_to_category.category_id', $spc_category)->get()->getResult();
        $data['special_category_one_name'] = get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $spc_category);

        $spc_category = $settings['special_category_two'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['special_category_twoPro'] = $table->where('cc_product_to_category.category_id', $spc_category)->get()->getResult();
        $data['special_category_two_name'] = get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $spc_category);

        $spc_category = $settings['special_category_three'];
        $table = DB()->table('cc_products');
        $table->join('cc_product_to_category', 'cc_product_to_category.product_id = cc_products.product_id')->where('cc_products.status', 'Active');
        $data['special_category_threePro'] = $table->where('cc_product_to_category.category_id', $spc_category)->get()->getResult();
        $data['special_category_three_name'] = get_data_by_id('category_name', 'cc_product_category', 'prod_cat_id', $spc_category);

        $data['productsetc'] = $table->where('status', 'Active')->limit(3)->get()->getResult();

        return $data;
    }
    private function Theme_3(){
        $tabShopBy = DB()->table('cc_product_category_shop_by');
        $data['shop_by'] = $tabShopBy->limit(10)->get()->getResult();
        return $data;
    }

    public function user_subscribe(){
        $email = $this->request->getPost('email');

        if (!empty($email)){
            if(is_exists('cc_newsletter','email',$email) == true) {
                $newData['email'] = $email;
                $newAd = DB()->table('cc_newsletter');
                $newAd->insert($newData);

                print "Thank you.Your subscription has been successfully completed";

                $subject = 'Subscription';
                $message = "Thank you.Your subscription has been successfully completed";
//            email_send($email,$subject,$message);
            }else{
                print 'Your email already exists';
            }
        }else{
            print 'Email required';
        }
    }


}
