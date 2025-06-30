<?php

namespace App\Controllers;

use App\Libraries\Offer_calculate;
use App\Libraries\Paypalexpress;
use App\Libraries\Mycart;
use App\Libraries\Weight_shipping;
use App\Libraries\Zone_rate_shipping;
use App\Libraries\Zone_shipping;
use App\Libraries\Flat_shipping;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Paypal extends BaseController
{

    protected $validation;
    protected $session;
    protected $productsModel;
    protected $zone_shipping;
    protected $flat_shipping;
    protected $weight_shipping;
    protected $cart;
    protected $paypalexpress;
    protected $offer_calculate;
    protected $zone_rate_shipping;


    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->productsModel = new ProductsModel();
        $this->zone_shipping = new Zone_shipping();
        $this->flat_shipping = new Flat_shipping();
        $this->weight_shipping = new Weight_shipping();
        $this->zone_rate_shipping = new Zone_rate_shipping();
        $this->cart = new Mycart();
        $this->offer_calculate = new Offer_calculate();
    }

    /**
     * @description This method provides paypal page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $amount = $this->request->getGet('amount');
        $array = $this->session_data();
        $this->session->set($array);

        $settings = paypal_settings();
        $paypalexpress = new Paypalexpress($settings);

        if (!isset($_GET['token'])) {
            // Setting up your intial variable to send payment process.
            $url = dirname('http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI']);
            $personName  = 'test';
            $L_NAME0   = 'test';
            $L_AMT0  = $amount;
            $L_QTY0  =    '1';
            $returnURL =  base_url('payment_paypal_checkout_action');
            $cancelURL =  base_url('checkout_canceled');
            $itemamt = 0.00;
            $itemamt = $L_QTY0 * $L_AMT0;
            $amt = $amount;
            $nvpstr = "&L_NAME0=" . $L_NAME0 . "&L_AMT0=" . $L_AMT0 . "&L_QTY0=" . $L_QTY0 . "&AMT=" . (string)$amt . "&ITEMAMT=" . (string)$itemamt . "&L_NUMBER0=1000&L_DESC0=Size: 8.8-oz&ReturnUrl=" . $returnURL . "&CANCELURL=" . $cancelURL . "&CURRENCYCODE=" . $settings['currency'] . "&PAYMENTACTION=" . $settings['payment_type'];
            // calling initial api.
            $initresult = $paypalexpress->process_payment($nvpstr);

            $ack = strtoupper($initresult["ACK"]);
            if ($ack == "SUCCESS") {
                $token = trim($initresult["TOKEN"]);
                $payurl = $settings['api_url'] . $token;

                return redirect()->to($payurl);
            } else {
                if (isset($initresult) && $initresult['ACK'] == 'Failure') {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please check your details and try again </div>');
                    return redirect()->to('checkout_failed');
                }
            }
        }
    }

    /**
     * @description This method provides session data
     * @return array
     */
    private function session_data()
    {
        $data['payment_firstname'] = $this->request->getGet('payment_firstname');
        $data['payment_lastname'] = $this->request->getGet('payment_lastname');
        $data['payment_phone'] = $this->request->getGet('payment_phone');
        $data['payment_email'] = $this->request->getGet('payment_email');
        $data['payment_country_id'] = $this->request->getGet('payment_country_id');
        $data['payment_city'] = $this->request->getGet('payment_city');
        $data['payment_postcode'] = $this->request->getGet('payment_postcode');
        $data['payment_address_1'] = $this->request->getGet('payment_address_1');
        $data['payment_address_2'] = $this->request->getGet('payment_address_2');

        $data['shipping_method'] = $this->request->getGet('shipping_method');
        $data['shipping_charge'] = $this->request->getGet('shipping_charge');
        $data['shipping_discount_charge'] = $this->request->getPost('shipping_discount_charge');
        $data['payment_method'] = $this->request->getGet('payment_method');



        $data['store_id'] = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');

        $data['new_acc_create'] = $this->request->getGet('new_acc_create');

        $data['shipping_else'] = $this->request->getGet('shipping_else');


        $data['shipping_firstname'] = $this->request->getGet('shipping_firstname');
        $data['shipping_lastname'] = $this->request->getGet('shipping_lastname');
        $data['shipping_phone'] = $this->request->getGet('shipping_phone');
        $data['shipping_country_id'] = $this->request->getGet('shipping_country_id');
        $data['shipping_city'] = $this->request->getGet('shipping_city');
        $data['shipping_postcode'] = $this->request->getGet('shipping_postcode');
        $data['shipping_address_1'] = $this->request->getGet('shipping_address_1');
        $data['shipping_address_2'] = $this->request->getGet('shipping_address_2');

        return $data;
    }

    /**
     * @description This method provides paypal checkout action
     * @return RedirectResponse
     */
    public function paypal_checkout_action()
    {

        $paypalexpress = new Paypalexpress(paypal_settings());
        $token = urlencode($_GET['token']);
        $result = $paypalexpress->make_payment($token);

        if (isset($result) && $result['ACK'] == 'Failure') {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">Please check your details and try again </div>');
            return redirect()->to('checkout_failed');
        } else {

            $data['payment_firstname'] = $this->session->payment_firstname;
            $data['payment_lastname'] = $this->session->payment_lastname;
            $data['payment_phone'] = $this->session->payment_phone;
            $data['payment_email'] = $this->session->payment_email;
            $data['payment_country_id'] = $this->session->payment_country_id;
            $data['payment_city'] = $this->session->payment_city;
            $data['payment_postcode'] = $this->session->payment_postcode;
            $data['payment_address_1'] = $this->session->payment_address_1;
            $data['payment_address_2'] = $this->session->payment_address_2;

            $data['shipping_method'] = $this->session->shipping_method;
            $data['shipping_charge'] = $this->session->shipping_charge;
            $data['payment_method'] = $this->session->payment_method;

            $data['store_id'] = $this->session->store_id;

            $new_acc_create = $this->session->new_acc_create;

            $shipping_else = $this->session->shipping_else;


            DB()->transStart();
            if ($shipping_else == 'on') {
                $data['shipping_firstname'] = $this->session->shipping_firstname;
                $data['shipping_lastname'] = $this->session->shipping_lastname;
                $data['shipping_phone'] = $this->session->shipping_phone;
                $data['shipping_country_id'] = $this->session->shipping_country_id;
                $data['shipping_city'] = $this->session->shipping_city;
                $data['shipping_postcode'] = $this->session->shipping_postcode;
                $data['shipping_address_1'] = $this->session->shipping_address_1;
                $data['shipping_address_2'] = $this->session->shipping_address_2;
            } else {
                $data['shipping_firstname'] = $data['payment_firstname'];
                $data['shipping_lastname'] = $data['payment_lastname'];
                $data['shipping_phone'] = $data['payment_phone'];
                $data['shipping_country_id'] = $data['payment_country_id'];
                $data['shipping_city'] = $data['payment_city'];
                $data['shipping_postcode'] = $this->session->payment_postcode;
                $data['shipping_address_1'] = $data['payment_address_1'];
                $data['shipping_address_2'] = $data['payment_address_2'];
            }

            if (isset($this->session->cusUserId)) {
                $data['customer_id'] = $this->session->cusUserId;
            }
            $disc = null;
            if (isset($this->session->coupon_discount)) {
                if ($this->session->discount_type == 'Percentage') {
                    $disc = ($this->cart->total() * $this->session->coupon_discount) / 100;
                }else{
                    if ($this->cart->total() > $this->session->coupon_discount) {
                        $disc = $this->session->coupon_discount;
                    }else{
                        $disc = $this->cart->total();
                    }
                }
            }

            if (!empty($data['shipping_charge'])) {
                if (isset($this->session->coupon_discount_shipping)) {
                    $disc = $this->shipping_discount_calculate($data['shipping_charge'],$data['shipping_method']);
                }
            }

            if (!empty($disc)){
                $oldQtyCup = get_data_by_id('total_used','cc_coupon','coupon_id',$this->session->coupon_id);
                $newQtyCupUsed['total_used'] = $oldQtyCup + 1;
                $table = DB()->table('cc_coupon');
                $table->where('coupon_id',$this->session->coupon_id)->update($newQtyCupUsed);
            }

            $geo_zone_id = $this->zone_rate_shipping->zone_id($data['payment_country_id'], $data['payment_city']);
            $offer = $this->offer_calculate->offer_discount($this->cart,$data['shipping_charge'],$geo_zone_id);
            $offerDiscount = $offer['discount_amount'] + $offer['discount_shipping_amount'];

            $finalAmo = number_format($this->cart->total() - $disc - $offerDiscount,2);
            if (!empty($data['shipping_charge'])) {
                $finalAmo = number_format(($this->cart->total() + $data['shipping_charge']) - $disc - $offerDiscount,2);
            }

            $data['payment_status'] = 'Paid';
            $data['total'] = $this->cart->total();
            $data['discount'] = $disc + $offerDiscount;
            $data['final_amount'] = $finalAmo;


            $table = DB()->table('cc_order');
            $table->insert($data);
            $order_id = DB()->insertID();






            //order cc_order_history
            $order_status_id = get_data_by_id('order_status_id', 'cc_order_status', 'name', 'Pending');
            $dataOrderHistory['order_id'] = $order_id;
            $dataOrderHistory['order_status_id'] = $order_status_id;
            $tabHistOr = DB()->table('cc_order_history');
            $tabHistOr->insert($dataOrderHistory);




            foreach ($this->cart->contents() as $val) {
                $oldQty = get_data_by_id('quantity', 'cc_products', 'product_id', $val['id']);
                $dataOrder['order_id'] = $order_id;
                $dataOrder['product_id'] = $val['id'];
                $dataOrder['price'] = $val['price'];
                $dataOrder['quantity'] = $val['qty'];
                $dataOrder['total_price'] = $val['subtotal'];
                $dataOrder['final_price'] = $val['subtotal'];
                $tableOrder = DB()->table('cc_order_item');
                $tableOrder->insert($dataOrder);
                $order_item_id = DB()->insertID();

                $newqty['quantity'] = $oldQty - $val['qty'];
                $tablePro = DB()->table('cc_products');
                $tablePro->where('product_id', $val['id'])->update($newqty);

                foreach (get_all_data_array('cc_option') as $vl) {
                    if (!empty($val['op_' . strtolower($vl->name)])) {
                        $data[strtolower($vl->name)] = $val['op_' . strtolower($vl->name)];

                        $table = DB()->table('cc_product_option');
                        $option = $table->where('option_value_id', $data[strtolower($vl->name)])->where('product_id', $val['id'])->get()->getRow();

                        if (!empty($option)) {
                            $dataOptino['order_id'] = $order_id;
                            $dataOptino['order_item_id'] = $order_item_id;
                            $dataOptino['product_id'] = $option->product_id;
                            $dataOptino['option_id'] = $option->option_id;
                            $dataOptino['option_value_id'] = $option->option_value_id;
                            $dataOptino['name'] = strtolower($vl->name);
                            $dataOptino['value'] = get_data_by_id('name', 'cc_option_value', 'option_value_id', $option->option_value_id);
                            $tableOption = DB()->table('cc_order_option');
                            $tableOption->insert($dataOptino);
                        }
                    }
                }
            }


            if (isset($this->session->cusUserId)) {
                $tableModule = DB()->table('cc_modules');
                $query = $tableModule->join('cc_module_settings', 'cc_module_settings.module_id = cc_modules.module_id')->where('cc_modules.module_key','point')->get()->getRow();
                if($query->status == '1') {
                    $oldPoint = get_data_by_id('point', 'cc_customer', 'customer_id', $this->session->cusUserId);
                    $point = $this->cart->total() * $query->value;
                    $restPoint = $oldPoint + $point;

                    //customer point update
                    $cusPointData['point'] = $restPoint;
                    $tableCus = DB()->table('cc_customer');
                    $tableCus->where('customer_id', $this->session->cusUserId)->update($cusPointData);


                    //point history add
                    $cusPointHistory['customer_id'] = $this->session->cusUserId;
                    $cusPointHistory['order_id'] = $order_id;
                    $cusPointHistory['particulars'] = 'product purchase point';
                    $cusPointHistory['trangaction_type'] = 'Cr.';
                    $cusPointHistory['point'] = $point;
                    $cusPointHistory['rest_point'] = $restPoint;
                    $tablePoint = DB()->table('cc_customer_point_history');
                    $tablePoint->insert($cusPointHistory);

                    //order point update
                    $orPointData['total_point'] = $point;
                    $tabOrder = DB()->table('cc_order');
                    $tabOrder->where('order_id',$order_id)->update($orPointData);
                }
            }


            DB()->transComplete();

            //email send customer
            $temMes = order_email_template($order_id);
            $subject = 'Product order';
            $message = $temMes;
            email_send($data['payment_email'], $subject, $message);


            //email send admin
            $email = get_lebel_by_value_in_settings('email');
            $subjectAd = 'Product order';
            $messageAd = $temMes;
            email_send($email, $subjectAd, $messageAd);

            unset($_SESSION['coupon_discount']);
            $this->cart->destroy();

            $this->sessionDestry();


            $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Your order has been successfully placed </div>');
            return redirect()->to('checkout_success');
        }
    }
    private function shipping_discount_calculate($charge,$shippingCode){
        $shipping_method_id = get_data_by_id('shipping_method_id','cc_shipping_method','code',$shippingCode);

        $table = DB()->table('cc_coupon_shipping');
        $check = $table->where('coupon_id',newSession()->coupon_id)->countAllResults();

        if (!empty($check)){
            $table2 = DB()->table('cc_coupon_shipping');
            $checkShipping = $table2->where('coupon_id',newSession()->coupon_id)->where('shipping_method_id',$shipping_method_id)->countAllResults();
            if (!empty($checkShipping)) {
                if (newSession()->discount_type == 'Percentage') {
                    $dis = ($charge * newSession()->coupon_discount_shipping) / 100;
                }else{
                    if ($charge > newSession()->coupon_discount_shipping) {
                        $dis = newSession()->coupon_discount_shipping;
                    }else{
                        $dis = $charge;
                    }
                }
            }else{
                $dis =  0;
            }
        }else{
            if (newSession()->discount_type == 'Percentage') {
                $dis = ($charge * newSession()->coupon_discount_shipping) / 100;
            }else{
                if ($charge > newSession()->coupon_discount_shipping) {
                    $dis = newSession()->coupon_discount_shipping;
                }else{
                    $dis = $charge;
                }
            }
        }

        return $dis;
    }

    /**
     * @description This method provides session destroy
     * @return void
     */
    private function sessionDestry()
    {
        unset($_SESSION['payment_firstname']);
        unset($_SESSION['payment_lastname']);
        unset($_SESSION['payment_phone']);
        unset($_SESSION['payment_email']);
        unset($_SESSION['payment_country_id']);
        unset($_SESSION['payment_city']);
        unset($_SESSION['payment_postcode']);
        unset($_SESSION['payment_address_1']);
        unset($_SESSION['payment_address_2']);

        unset($_SESSION['shipping_method']);
        unset($_SESSION['shipping_charge']);
        unset($_SESSION['shipping_discount_charge']);
        unset($_SESSION['payment_method']);

        unset($_SESSION['store_id']);
        unset($_SESSION['new_acc_create']);
        unset($_SESSION['shipping_else']);


        unset($_SESSION['shipping_firstname']);
        unset($_SESSION['shipping_lastname']);
        unset($_SESSION['shipping_phone']);
        unset($_SESSION['shipping_country_id']);
        unset($_SESSION['shipping_city']);
        unset($_SESSION['shipping_postcode']);
        unset($_SESSION['shipping_address_1']);
        unset($_SESSION['shipping_address_2']);

        unset($_SESSION['coupon_discount_shipping']);
        unset($_SESSION['coupon_discount']);
        unset($_SESSION['coupon_id']);
    }
}
