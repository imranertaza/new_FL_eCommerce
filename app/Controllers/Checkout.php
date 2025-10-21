<?php

namespace App\Controllers;

use App\Libraries\Mycart;
use App\Libraries\Offer_calculate;
use App\Libraries\Weight_shipping;
use App\Libraries\Zone_rate_shipping;
use App\Libraries\Zone_shipping;
use App\Libraries\Flat_shipping;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;


class Checkout extends BaseController
{

    protected $validation;
    protected $session;
    protected $productsModel;
    protected $zone_shipping;
    protected $flat_shipping;
    protected $weight_shipping;
    protected $zone_rate_shipping;
    protected $cart;
    protected $offer_calculate;

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
     * @description This method provides checkout page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $settings = get_settings();
        if (!empty($this->cart->contents())) {
            $table = DB()->table('cc_customer');
            $data['customer'] = $table->where('customer_id', $this->session->cusUserId)->get()->getRow();

            $tableSet = DB()->table('cc_payment_settings');
            $data['paypalEmail'] = $tableSet->where('payment_method_id', '3')->where('label', 'email')->get()->getRow();

            $data['offer'] = $this->offer_calculate->offer_discount($this->cart);
            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Checkout';

            $data['page_title'] = 'Checkout';
            echo view('Theme/' . $settings['Theme'] . '/header', $data);
            echo view('Theme/' . $settings['Theme'] . '/Checkout/index', $data);
            echo view('Theme/' . $settings['Theme'] . '/footer');
        } else {
            return redirect()->to('cart');
        }
    }

    /**
     * @description This method provides coupon action
     * @return RedirectResponse|void
     */
    public function coupon_action()
    {
        $coupon_code = $this->request->getPost('coupon');

        $table = DB()->table('cc_coupon');
        $query = $table->where('code', $coupon_code)->where('status', 'Active')->where('total_useable >', 'total_used')->where('date_start <=', date('Y-m-d'))->where('date_end >=', date('Y-m-d'))->get()->getRow();

        if (!empty($query)) {
            if (isset(newSession()->coupon_id)){
                unset($_SESSION['coupon_id']);
                unset($_SESSION['coupon_discount']);
                unset($_SESSION['coupon_discount_shipping']);
                unset($_SESSION['discount_type']);
            }


            if ($query->discount_on == 'Product') {
                if ($query->for_registered_user == '1') {
                    $isLoggedInCustomer = $this->session->isLoggedInCustomer;
                    if (isset($isLoggedInCustomer) || $isLoggedInCustomer == TRUE) {
                        if (!empty($this->cart->contents())) {
                            $couponArray = array(
                                'coupon_id' => $query->coupon_id,
                                'coupon_discount' => $query->discount,
                                'discount_type' => $query->discount_type
                            );
                            $this->session->set($couponArray);
                            $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                            return redirect()->to('cart');
                        } else {
                            $this->session->setFlashdata('message', 'your cart is currently empty ');
                            return redirect()->to('cart');
                        }
                    } else {
                        $this->session->setFlashdata('message', 'Coupon code not working ');
                        return redirect()->to('cart');
                    }
                }

                if ($query->for_subscribed_user == '1') {
                    $isLoggedInCustomer = $this->session->isLoggedInCustomer;
                    if (isset($isLoggedInCustomer) || $isLoggedInCustomer == TRUE) {
                        $checkSub = is_exists('cc_newsletter', 'customer_id', $this->session->cusUserId);
                        if ($checkSub == false) {
                            if (!empty($this->cart->contents())) {
                                $couponArray = array(
                                    'coupon_id' => $query->coupon_id,
                                    'coupon_discount' => $query->discount,
                                    'discount_type' => $query->discount_type
                                );
                                $this->session->set($couponArray);
                                $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                                return redirect()->to('cart');
                            } else {
                                $this->session->setFlashdata('message', 'your cart is currently empty ');
                                return redirect()->to('cart');
                            }
                        } else {
                            $this->session->setFlashdata('message', 'Coupon code not working ');
                            return redirect()->to('cart');
                        }
                    } else {
                        $this->session->setFlashdata('message', 'Coupon code not working ');
                        return redirect()->to('cart');
                    }
                }

                if (($query->for_registered_user == '0') && ($query->for_subscribed_user == '0')) {
                    if (!empty($this->cart->contents())) {
                        $couponArray = array(
                            'coupon_id' => $query->coupon_id,
                            'coupon_discount' => $query->discount,
                            'discount_type' => $query->discount_type
                        );
                        $this->session->set($couponArray);
                        $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                        return redirect()->to('cart');
                    } else {
                        $this->session->setFlashdata('message', 'your cart is currently empty ');
                        return redirect()->to('cart');
                    }
                }
            }else{

                if ($query->for_registered_user == '1') {
                    $isLoggedInCustomer = $this->session->isLoggedInCustomer;
                    if (isset($isLoggedInCustomer) || $isLoggedInCustomer == TRUE) {
                        if (!empty($this->cart->contents())) {
                            $couponArray = array(
                                'coupon_id' => $query->coupon_id,
                                'coupon_discount_shipping' => $query->discount,
                                'discount_type' => $query->discount_type
                            );
                            $this->session->set($couponArray);
                            $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                            return redirect()->to('cart');
                        } else {
                            $this->session->setFlashdata('message', 'your cart is currently empty ');
                            return redirect()->to('cart');
                        }
                    } else {
                        $this->session->setFlashdata('message', 'Coupon code not working ');
                        return redirect()->to('cart');
                    }
                }

                if ($query->for_subscribed_user == '1') {
                    $isLoggedInCustomer = $this->session->isLoggedInCustomer;
                    if (isset($isLoggedInCustomer) || $isLoggedInCustomer == TRUE) {
                        $checkSub = is_exists('cc_newsletter', 'customer_id', $this->session->cusUserId);
                        if ($checkSub == false) {
                            if (!empty($this->cart->contents())) {
                                $couponArray = array(
                                    'coupon_id' => $query->coupon_id,
                                    'coupon_discount_shipping' => $query->discount,
                                    'discount_type' => $query->discount_type
                                );
                                $this->session->set($couponArray);
                                $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                                return redirect()->to('cart');
                            } else {
                                $this->session->setFlashdata('message', 'your cart is currently empty ');
                                return redirect()->to('cart');
                            }
                        } else {
                            $this->session->setFlashdata('message', 'Coupon code not working ');
                            return redirect()->to('cart');
                        }
                    } else {
                        $this->session->setFlashdata('message', 'Coupon code not working ');
                        return redirect()->to('cart');
                    }
                }

                if (($query->for_registered_user == '0') && ($query->for_subscribed_user == '0')) {
                    if (!empty($this->cart->contents())) {
                        $couponArray = array(
                            'coupon_id' => $query->coupon_id,
                            'coupon_discount_shipping' => $query->discount,
                            'discount_type' => $query->discount_type
                        );
                        $this->session->set($couponArray);
                        $this->session->setFlashdata('message', 'Coupon code applied successfully ');
                        return redirect()->to('cart');
                    } else {
                        $this->session->setFlashdata('message', 'your cart is currently empty ');
                        return redirect()->to('cart');
                    }
                }
            }

        } else {
            $this->session->setFlashdata('message', 'Coupon code not working');
            return redirect()->to('cart');
        }
    }

    /**
     * @description This method provides country zone
     * @return void
     */
    public function country_zoon()
    {
        $country_id = $this->request->getPost('country_id');

        $table = DB()->table('cc_zone');
        $data = $table->where('country_id', $country_id)->get()->getResult();
        $options = '<option value="" >Please select</option>';
        foreach ($data as $value) {
            $options .= '<option value="' . $value->zone_id . '" ';
            $options .= '>' . $value->name . '</option>';
        }
        print $options;
    }

    /**
     * @description This method provides checkout action
     * @return RedirectResponse
     */
    public function checkout_action()
    {
        if (!empty($this->cart->contents())) {
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
            $data['payment_method'] = $this->request->getPost('payment_method');

            $data['store_id'] = get_data_by_id('store_id', 'cc_stores', 'is_default', '1');

            $new_acc_create = $this->request->getPost('new_acc_create');

            $shipping_else = $this->request->getPost('shipping_else');

            $this->validation->setRules([
                'payment_firstname' => ['label' => 'First name', 'rules' => 'required'],
                'payment_lastname' => ['label' => 'Last name', 'rules' => 'required'],
                'payment_phone' => ['label' => 'Phone', 'rules' => 'required'],
                'payment_email' => ['label' => 'Email', 'rules' => 'required'],
                'payment_country_id' => ['label' => 'Country', 'rules' => 'required'],
                'payment_city' => ['label' => 'City', 'rules' => 'required'],
                'payment_method' => ['label' => 'Payment Method', 'rules' => 'required'],
            ]);

            if ($this->validation->run($data) == FALSE) {
                $this->session->setFlashdata('message', '' . $this->validation->listErrors() . '');
                return redirect()->to('checkout');
            } else {

                $shipping_charge = $this->shipping_charge($data['payment_city'], $this->request->getPost('shipping_city'), $data['shipping_method']);

                if (isset($this->session->cusUserId)) {
                    $data['customer_id'] = $this->session->cusUserId;
                }

                //Coupon product amount all discount calculate
                $discCouponProduct = null;
                if (isset($this->session->coupon_discount)) {
                    if (newSession()->discount_type == 'Percentage') {
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
                if (!empty($shipping_charge)) {
                    if (isset($this->session->coupon_discount_shipping)) {
                        $discCouponShipping = $this->shipping_discount_calculate($shipping_charge,$data['shipping_method']);
                    }
                }

                if (!empty($disc)){
                    $oldQtyCup = get_data_by_id('total_used','cc_coupon','coupon_id',$this->session->coupon_id);
                    $newQtyCupUsed['total_used'] = $oldQtyCup + 1;
                    $table = DB()->table('cc_coupon');
                    $table->where('coupon_id',$this->session->coupon_id)->update($newQtyCupUsed);
                }

                //offer discount calculate
                $geo_zone_id = $this->zone_rate_shipping->zone_id($data['payment_country_id'], $data['payment_city']);
                $offer = $this->offer_calculate->offer_discount($this->cart,$shipping_charge,$geo_zone_id);

                //offer all product amount discount calculate
                $offerDiscountProduct = $offer['discount_amount'];
                //offer all shipping amount discount calculate
                $offerDiscountShipping = $offer['discount_shipping_amount'];

                //total coupon or offer product amount discount calculate
                $totalProductDiscount = $discCouponProduct + $offerDiscountProduct;

                //total coupon or offer product shipping discount calculate
                $totalShippingDiscount = $discCouponShipping + $offerDiscountShipping;

                //maximum discount calculate
                $finalProductDiscount = round(($this->cart->total() > $totalProductDiscount)?$totalProductDiscount:$this->cart->total(),2);

                //final product amount calculate
                $finalAmo = $this->cart->total() - $finalProductDiscount;

                $finalShippingDiscount = null;
                if (!empty($shipping_charge)) {
                    //maximum discount calculate
                    $finalShippingDiscount = ($shipping_charge > $totalShippingDiscount)?$totalShippingDiscount:$shipping_charge;
                    //final product and shipping amount calculate
                    $finalAmo = round(($this->cart->total() + $shipping_charge) - $finalShippingDiscount - $finalProductDiscount,2);
                }

                if ($data['payment_method'] == '8') {
                    $balCus = get_data_by_id('balance', 'cc_customer', 'customer_id', $this->session->cusUserId);
                    if ($balCus < $finalAmo) {
                        $this->session->setFlashdata('message', 'Not enough balance ');
                        return redirect()->to('checkout');
                    }
                }


                DB()->transStart();
                $order_status_id = get_data_by_id('order_status_id', 'cc_order_status', 'name', 'Pending');

                if ($shipping_else == 'on') {
                    $data['shipping_firstname'] = $this->request->getPost('shipping_firstname');
                    $data['shipping_lastname'] = $this->request->getPost('shipping_lastname');
                    $data['shipping_phone'] = $this->request->getPost('shipping_phone');
                    $data['shipping_country_id'] = $this->request->getPost('shipping_country_id');
                    $data['shipping_city'] = $this->request->getPost('shipping_city');
                    $data['shipping_postcode'] = $this->request->getPost('shipping_postcode');
                    $data['shipping_address_1'] = $this->request->getPost('shipping_address_1');
                    $data['shipping_address_2'] = $this->request->getPost('shipping_address_2');
                } else {
                    $data['shipping_firstname'] = $data['payment_firstname'];
                    $data['shipping_lastname'] = $data['payment_lastname'];
                    $data['shipping_phone'] = $data['payment_phone'];
                    $data['shipping_country_id'] = $data['payment_country_id'];
                    $data['shipping_city'] = $data['payment_city'];
                    $data['shipping_postcode'] = $this->request->getPost('payment_postcode');
                    $data['shipping_address_1'] = $data['payment_address_1'];
                    $data['shipping_address_2'] = $data['payment_address_2'];
                }


                $data['total'] = $this->cart->total();
                $data['discount'] = $finalProductDiscount + $finalShippingDiscount;
                $data['final_amount'] = $finalAmo;

                $data['status'] = $order_status_id;
                $table = DB()->table('cc_order');
                $table->insert($data);
                $order_id = DB()->insertID();


                //u-wallet
                if ($data['payment_method'] == '8') {
                    $newBal = $balCus - $finalAmo;
                    $cusData['balance'] = $newBal;
                    $tableCus = DB()->table('cc_customer');
                    $tableCus->where('customer_id', $this->session->cusUserId)->update($cusData);


                    $cusLedg['customer_id'] = $this->session->cusUserId;
                    $cusLedg['order_id'] = $order_id;
                    $cusLedg['payment_method_id'] = $data['payment_method'];
                    $cusLedg['particulars'] = 'Product purchase';
                    $cusLedg['trangaction_type'] = 'Dr.';
                    $cusLedg['amount'] = $finalAmo;
                    $cusLedg['rest_balance'] = $newBal;

                    $tableCusLedg = DB()->table('cc_customer_ledger');
                    $tableCusLedg->insert($cusLedg);
                }


                //card detail add
                if ($data['payment_method'] == '7') {
                    $dataCard['payment_method_id'] = $data['payment_method'];
                    $dataCard['order_id'] = $order_id;
                    $dataCard['card_name'] = $this->request->getPost('card_name');
                    $dataCard['card_number'] = $this->request->getPost('card_number');
                    $dataCard['card_expiration'] = $this->request->getPost('card_expiration');
                    $dataCard['card_cvc'] = $this->request->getPost('card_cvc');

                    $tableCard = DB()->table('cc_order_card_details');
                    $tableCard->insert($dataCard);
                }
                //card detail add


                //order cc_order_history

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



                DB()->transComplete();

                //email send customer
                $temMes = order_email_template($order_id);
                $subject = 'Product order - Order ID ' . $order_id;
                $message = $temMes;
                email_send($data['payment_email'], $subject, $message);


                //email send admin
                $email = get_lebel_by_value_in_settings('email');
                $subjectAd = 'Product order - Order ID ' . $order_id;
                $messageAd = $temMes;
                email_send($email, $subjectAd, $messageAd);

                
                //email send admin card detail
                if ($data['payment_method'] == '7') {
                    $messageAdCard = order_email_template_card($order_id);
                    $subjectAdCard = 'Product order - Order ID ' . $order_id;
                    email_send($email, $subjectAdCard, $messageAdCard);
                }

                unset($_SESSION['coupon_id']);
                unset($_SESSION['coupon_discount']);
                unset($_SESSION['coupon_discount_shipping']);
                unset($_SESSION['discount_type']);
                $this->cart->destroy();

                $this->session->setFlashdata('message', 'Your order has been successfully placed ');
                return redirect()->to('checkout_success');
            }
        }else{
            $this->session->setFlashdata('message', 'Your cart is empty!');
            return redirect()->to('checkout');
        }
    }

    /**
     * @description This method provides shipping rate
     * @return ResponseInterface
     */
    public function shipping_rate()
    {

        $city_id = $this->request->getPost('city_id');
        $shipCityId = $this->request->getPost('shipCityId');
        $paymethod = $this->request->getPost('paymethod');
        if (!empty($shipCityId)) {
            $city_id = $shipCityId;
        }
        $data['charge'] = 0;
        $geo_zone_id = 0;
        if ($paymethod == 'flat') {
            $data['charge'] = $this->flat_shipping->getSettings()->calculateShipping();
        }
        if ($paymethod == 'zone') {
            $data['charge'] = $this->zone_shipping->getSettings()->calculateShipping($city_id);
        }
        if ($paymethod == 'weight') {
            $data['charge'] = $this->weight_shipping->getSettings()->calculateShipping();
        }
        if ($paymethod == 'zone_rate') {
            $data['charge'] = $this->zone_rate_shipping->getSettings($city_id)->calculateShipping();
        }
        if(!empty($city_id)) {
            $country_id = get_data_by_id('country_id', 'cc_zone', 'zone_id', $city_id);
            $geo_zone_id = $this->zone_rate_shipping->zone_id($country_id, $city_id);
        }

        $data['discount'] = 0;
        if (isset(newSession()->coupon_discount_shipping)) {
            $data['discount'] += $this->shipping_discount_calculate($data['charge'], $paymethod);
        }
        $offer = $this->offer_calculate->offer_discount($this->cart,$data['charge'],$geo_zone_id);
        if (!empty($offer['discount_shipping_amount']) && !empty($data['charge'])){
            $data['discount'] += $offer['discount_shipping_amount'];
        }

        if ($data['charge'] > $data['discount']){
            $data['discount'] = $data['discount'];
        }else{
            $data['discount'] = $data['charge'];
        }

        return $this->response->setJSON($data);
    }

    public function shipping_discount_calculate($charge,$shippingCode){
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
     * @description This method provides success page view
     * @return void
     */
    public function success()
    {
        $settings = get_settings();
        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Order Success';

        $data['page_title'] = 'Checkout Success';
        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Checkout/success', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }

    /**
     * @description This method provides failed page view
     * @return void
     */
    public function failed()
    {
        $settings = get_settings();
        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Order Failed';

        $data['page_title'] = 'Checkout Failed';
        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Checkout/failed', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }

    /**
     * @description This method provides canceled page view
     * @return void
     */
    public function canceled()
    {
        $settings = get_settings();
        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = 'Order Canceled';

        $data['page_title'] = 'Checkout Canceled';
        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Checkout/canceled', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }

    /**
     * @description This method provides payment instruction view
     * @return void
     */
    public function payment_instruction()
    {
        $payment_method_id = $this->request->getPost('id');

        $table = DB()->table('cc_payment_settings');
        $query = $table->where('payment_method_id', $payment_method_id)->where('label', 'instruction')->get()->getRow();
        $view = '';
        if (!empty($query)) {
            $view .= '<div class="title-checkout">
                           <label class="btn bg-custom-color text-white w-100 rounded-0"><span class="text-label">' . $query->title . '</span></label>
                       </div>';
            $view .= '<div class="payment-method group-check mb-4 pb-4">
                           <p>' . $query->value . '</p>
                     </div>';
        }
        print $view;
    }

    /**
     * @description This method provides shipping charge
     * @param int $city_id
     * @param int $shipCityId
     * @param string $shipping_method
     * @return int|string
     */
    private function shipping_charge($city_id,$shipCityId,$shipping_method)
    {
        if (!empty($shipCityId)) {
            $city_id = $shipCityId;
        }
        $charge = 0;
        if ($shipping_method == 'flat') {
            $charge = $this->flat_shipping->getSettings()->calculateShipping();
        }
        if ($shipping_method == 'zone') {
            $charge = $this->zone_shipping->getSettings()->calculateShipping($city_id);
        }
        if ($shipping_method == 'weight') {
            $charge = $this->weight_shipping->getSettings()->calculateShipping();
        }
        if ($shipping_method == 'zone_rate') {
            $charge = $this->zone_rate_shipping->getSettings($city_id)->calculateShipping();
        }

        return $charge;
    }

}
