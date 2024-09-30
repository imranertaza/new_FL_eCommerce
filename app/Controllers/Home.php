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

    /**
     * @description This method provides home page view
     * @return void
     */
    public function index(){
        $settings = get_settings();
        $theme = $settings['Theme'];
        $data = $this->$theme();

        $tableBrand = DB()->table('cc_brand');
        $data['brand'] = $tableBrand->limit(20)->get()->getResult();

        $tabPopuler = DB()->table('cc_product_category_popular');
        $tabPopuler->join('cc_product_category','cc_product_category.prod_cat_id = cc_product_category_popular.prod_cat_id')->join('cc_icons','cc_icons.icon_id = cc_product_category.icon_id');
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

    /**
     * @description This method provides Default theme function
     * @return array
     */
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

    /**
     * @description This method provides Theme_2 theme function
     * @return array
     */
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

    /**
     * @description This method provides Theme_3 theme function
     * @return array
     */
    private function Theme_3(){
        $tabShopBy = DB()->table('cc_product_category_shop_by');
        $tabShopBy->join('cc_product_category','cc_product_category.prod_cat_id = cc_product_category_shop_by.prod_cat_id')->join('cc_icons','cc_icons.icon_id = cc_product_category.icon_id');
        $data['shop_by'] = $tabShopBy->limit(10)->get()->getResult();
        return $data;
    }

    /**
     * @description This method provides user subscribe
     * @return void
     */
    public function user_subscribe(){
        $email = $this->request->getPost('email');

        if (!empty($email)){
            if(is_exists('cc_newsletter','email',$email) == true) {

                $encrypt_method = "AES-256-CBC";
                $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
                $secret_iv = '5fgf5HJ5g27'; // user define secret key
                $key = hash('sha256', $secret_key);
                $iv = substr(hash('sha256', $secret_iv), 0, 16);


                $name = get_lebel_by_value_in_settings('store_name');
                $otp = rand(100000,999999);
                $url = base_url('user_subscribe_verify?email='.openssl_encrypt($email,$encrypt_method, $key, 0, $iv).'&code='.openssl_encrypt($otp,$encrypt_method, $key, 0, $iv));
                $subject = 'Please Verify Your Email Address to Complete Your Subscription!';
                $message = "Thank you for subscribing to ".$name."! Before we can start sending you our updates, we just need to confirm your email address.<br>                    
                    Please verify your email by clicking the link below: <a href='".$url."'>Verify My Email Address</a><br>                    
                    If you did not sign up for this subscription, please disregard this email.<br>                    
                    Thank you for choosing ".$name."!";

                $sessionArray = [
                  'otp' => $otp,
                  'email' => $email,
                ];
                $this->session->set($sessionArray);
                
                email_send($email,$subject,$message);

                print "Please Verify Your Email Address to Complete Your Subscription!";
            }else{
                print 'Your email already exists';
            }
        }else{
            print 'Email required';
        }
    }
    public function verify(){

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
        $secret_iv = '5fgf5HJ5g27'; // user define secret key
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);


        $email = $this->request->getGetPost('email');
        $code = $this->request->getGetPost('code');

        $email_d =  openssl_decrypt($email,$encrypt_method, $key, 0, $iv);
        $otp_d = openssl_decrypt($code,$encrypt_method, $key, 0, $iv);

        if (($email_d == $this->session->email) && ($otp_d == $this->session->otp)){
            $newData['email'] = $email_d;
            $newAd = DB()->table('cc_newsletter');
            $newAd->insert($newData);

            setcookie('down_image',$email_d,time()+ (86400 * 365), "/");
            $this->session->setFlashdata('message', '<div class="alert-success_web py-2 px-3 border-0 text-white fs-5 text-capitalize" role="alert">Subscribe successfully completed </div>');
            return redirect()->to('/');
        }else{
            return redirect()->to('/');
        }

    }


}
