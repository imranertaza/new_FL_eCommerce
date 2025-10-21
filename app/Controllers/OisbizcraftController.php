<?php

namespace App\Controllers;

use App\Libraries\Flat_shipping;
use App\Libraries\Mycart;
use App\Libraries\Offer_calculate;
use App\Libraries\Weight_shipping;
use App\Libraries\Zone_rate_shipping;
use App\Libraries\Zone_shipping;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\RedirectResponse;

class OisbizcraftController extends BaseController {

    protected $validation;
    protected $session;

    protected $weight_shipping;
    protected $flat_shipping;
    protected $zone_shipping;
    protected $productsModel;
    protected $cart;
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
     * @description This method provides oisbizcraft page view
     * @return void
     */
    public function payment_oisbizcraft(){

        $array = $this->session_data();
        $this->session->set($array);

        $this->oisbizcraft_action();



        $api_u = get_all_row_data_by_id('cc_payment_settings', 'label', 'ois_bizcraft_api_url');
        // OIS Bizcraft API endpoint
        $api_url = $api_u->value; // Example URL, replace with actual API URL
        $api_k = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_key');
        $api_key = $api_k->value;

        $amount = $this->request->getPost('amount');
        $firstname = $this->request->getPost('payment_firstname');
        $lastname = $this->request->getPost('payment_lastname');
        $payment_email = $this->request->getPost('payment_email');


        //convert sgd
        $sgdRates = $this->usdToSgdRates();
        $totalAm = $sgdRates * $amount;
        $total = $totalAm * 100;
        //convert sgd

        $merchant_outlet_id = get_all_row_data_by_id('cc_payment_settings', 'label', 'merchant_outlet_id');
        $terminal_id = get_all_row_data_by_id('cc_payment_settings', 'label', 'terminal_id');
        $cust_code = get_all_row_data_by_id('cc_payment_settings', 'label', 'cust_code');
        // Payment request data
        $data = array(
            'amount' => $total,
            'merchant_outlet_id' => $merchant_outlet_id->value,
            'terminal_id' => $terminal_id->value,
            'cust_code' => $cust_code->value,
            'user_fullname' => $firstname.' '.$lastname,
            'user_email' => $payment_email,
            'description' => 'Sale',
            'currency' => 'SGD',
            'optional_currency' => 'USD',
            'merchant_return_url' => base_url('oisbizcraft-return-url'), // Callback URL after payment
            'order_id' => $this->session->order_id, // Generate a unique transaction ID
        );


        // Set API key and other required headers
        $string = $data['cust_code'].$data['merchant_outlet_id'].$data['terminal_id'].$data['merchant_return_url'].$data['description'].$data['currency'].$data['amount'].$data['order_id'].$data['user_fullname'];
        $data['hash'] = strtoupper(hash_hmac('SHA256', $string, $api_key));

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        );



        // Initialize cURL session
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request
        $response = curl_exec($ch);
        curl_close($ch);
        $response_data = json_decode($response);

//        echo $response;
//        die();
        // Check if the request was successful
        if (isset($response_data->status) && ($response_data->status === 200)) {
            return redirect()->to($response_data->data->url);
        }else{
//            $error = curl_error($ch);
//            curl_close($ch);
            $dataPay['payment_status'] = 'Failed';
            $table = DB()->table('cc_order');
            $table->where('order_id',$this->session->order_id)->update($dataPay);
            unset($_SESSION['order_id']);

            return redirect()->to('checkout_failed');
        }
    }

    public function usdToSgdRates(){
        $exchange_rates_api = get_all_row_data_by_id('cc_payment_settings', 'label', 'exchange_rates_api');
        $apiKey = $exchange_rates_api->value;
        $url = "https://openexchangerates.org/api/latest.json?app_id=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            // Decode the JSON response into a PHP array
            $data = json_decode($response, true);

            // Check if the request was successful
            if (isset($data['rates']['SGD'])) {
                $usdToSgd = $data['rates']['SGD']; // Extract USD to SGD exchange rate
                //echo "1 USD is equal to " . $usdToSgd . " SGD";
            } else {
                $usdToSgd = 0;
                //echo "Error: Unable to fetch the exchange rate.";
            }
        }

        curl_close($ch);

        return $usdToSgd;
    }

    public function notification_webhook(){

        $api_k = get_all_row_data_by_id('cc_payment_settings', 'label', 'api_key');
        $secret_key = $api_k->value;  // Replace with your actual secret key

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        var_dump($data);



        $hash_string = $data['order_id'] . $data['status'] . $data['amount_cent'] . $data['currency'];
        $generated_hash = strtoupper(hash_hmac('SHA1', $hash_string, $secret_key));

        if ($generated_hash === $data['hash'] && $data['status'] == "A") {
            $dataOrder['payment_status'] = 'Paid';
            $table = DB()->table('cc_order');
            $table->where('order_id',$data['order_id'])->update($dataOrder);

            http_response_code(200);
        } else {
            $dataOrder['payment_status'] = 'Failed';
            $table = DB()->table('cc_order');
            $table->where('order_id',$data['order_id'])->update($dataOrder);

            http_response_code(400);  // Respond with 400 Bad Request
        }
    }

    public function return_url() {
        $message = $this->request->getGet('message');
        $order_id = $this->request->getGet('order_id');
        $return_code = $this->request->getGet('return_code');
        $ref_order_id = $this->request->getGet('ref_order_id');

        if ($message === 'success') {
            $data['payment_status'] = 'Paid';
            $data['PM_transaction_id'] = $ref_order_id;
            $table = DB()->table('cc_order');
            $table->where('order_id',$order_id)->update($data);

            unset($_SESSION['order_id']);

            $this->session->setFlashdata('message', 'Your order has been successfully placed');
            return redirect()->to('checkout_success');
        } else {
            // Handle failed payment (e.g., update database, show failure message)

            $data['payment_status'] = 'Failed';
            $table = DB()->table('cc_order');
            $table->where('order_id',$this->session->order_id)->update($data);
            unset($_SESSION['order_id']);
            return redirect()->to('checkout_failed');
        }
    }


    /**
     * @description This method provides oisbizcraft checkout action execute
     * @return RedirectResponse
     */
    public function oisbizcraft_action(){

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
        $discCouponProduct = null;
        if (isset($this->session->coupon_discount)) {
            if ($this->session->discount_type == 'Percentage') {
                $discCouponProduct = ($this->cart->total() * $this->session->coupon_discount) / 100;
            }else{
                if ($this->cart->total() > $this->session->coupon_discount) {
                    $discCouponProduct = $this->session->coupon_discount;
                }else{
                    $discCouponProduct = $this->cart->total();
                }
            }
        }

        //Coupon shipping amount all discount calculate
        $discCouponShipping = null;
        if (!empty($data['shipping_charge'])) {
            if (isset($this->session->coupon_discount_shipping)) {
                $discCouponShipping = $this->shipping_discount_calculate($data['shipping_charge'],$data['shipping_method']);
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
        //offer all product amount discount calculate
        $offerDiscountProduct = $offer['discount_amount'];
        //offer all shipping amount discount calculate
        $offerDiscountShipping = $offer['discount_shipping_amount'];

        //total coupon or offer product amount discount calculate
        $totalProductDiscount = $discCouponProduct + $offerDiscountProduct;

        //total coupon or offer product shipping discount calculate
        $totalShippingDiscount = $discCouponShipping + $offerDiscountShipping;

        //maximum discount calculate
        $finalProductDiscount =  round(($this->cart->total() > $totalProductDiscount)?$totalProductDiscount:$this->cart->total(),2);
        //final product amount calculate
        $finalAmo = $this->cart->total() - $finalProductDiscount;

        $finalShippingDiscount = null;
        if (!empty($data['shipping_charge'])) {
            //maximum discount calculate
            $finalShippingDiscount = ($data['shipping_charge'] > $totalShippingDiscount)?$totalShippingDiscount:$data['shipping_charge'];
            //final product and shipping amount calculate
            $finalAmo =  round(($this->cart->total() + $data['shipping_charge']) - $finalShippingDiscount - $finalProductDiscount,2);
        }

        $data['payment_status'] = 'Paid';
        $data['total'] = $this->cart->total();
        $data['discount'] = $finalProductDiscount + $finalShippingDiscount;
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

        $dataOrder['order_id'] = $order_id;
        $this->session->set($dataOrder);

//        $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Your order has been successfully placed </div>');
//        return redirect()->to('checkout_success');
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
     * @description This method provides all data store session array.
     * @return array
     */
    private function session_data()
    {
        $data['payment_firstname'] = $this->request->getPost('payment_firstname');
        $data['payment_lastname'] = $this->request->getPost('payment_lastname');
        $data['payment_phone'] = $this->request->getPost('payment_phone');
        $data['payment_email'] = $this->request->getPost('payment_email');
        $data['payment_country_id'] = $this->request->getPost('payment_country_id');
        $data['payment_city'] = $this->request->getPost('payment_city');
        $data['payment_postcode'] = $this->request->getPost('payment_postcode');
        $data['payment_address_1'] = $this->request->getPost('payment_address_1');
        $data['payment_address_2'] = $this->request->getPost('payment_address_2');

        $data['shipping_method'] = $this->request->getPost('shipping_method');
        $data['shipping_charge'] = $this->request->getPost('shipping_charge');
        $data['shipping_discount_charge'] = $this->request->getPost('shipping_discount_charge');
        $data['payment_method'] = $this->request->getPost('payment_method');



        $data['store_id'] = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');

        $data['new_acc_create'] = $this->request->getPost('new_acc_create');

        $data['shipping_else'] = $this->request->getPost('shipping_else');


        $data['shipping_firstname'] = $this->request->getPost('shipping_firstname');
        $data['shipping_lastname'] = $this->request->getPost('shipping_lastname');
        $data['shipping_phone'] = $this->request->getPost('shipping_phone');
        $data['shipping_country_id'] = $this->request->getPost('shipping_country_id');
        $data['shipping_city'] = $this->request->getPost('shipping_city');
        $data['shipping_postcode'] = $this->request->getPost('shipping_postcode');
        $data['shipping_address_1'] = $this->request->getPost('shipping_address_1');
        $data['shipping_address_2'] = $this->request->getPost('shipping_address_2');

        $data['t_amount'] = $this->request->getPost('amount');

        return $data;
    }

    /**
     * @description This method provides all data remove session array.
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

        unset($_SESSION['coupon_discount']);
        unset($_SESSION['coupon_discount_shipping']);
        unset($_SESSION['coupon_id']);

        unset($_SESSION['t_amount']);
    }


}
