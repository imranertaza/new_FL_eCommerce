<?php
namespace App\Libraries;

use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class Offer_calculate {
    private $discount = 0;
    private $shipDiscount = 0;
    private $productProDisc = 0;
    private $productShipDisc = 0;
    private $amountProDisc = 0;
    private $amountShipDisc = 0;
    public function __construct(){

    }

    /**
     * @description This function provides active offers
     * @return array
     */
    public function today_active_offers(){
        $todayDate = date('Y-m-d H:i:s');
        $table = DB()->table('cc_offer');
        $offers = $table->where('expire_date >',$todayDate)->get()->getResult();
        return $offers;
    }

    /**
     * @description This function provides offer discount
     * @param $cart array
     * @param $shipAmount float
     * @return array
     */
    public function offer_discount($cart, $shipAmount = 0,$geo_zone_id = 0)
    {
        $totalAmount = $cart->total();
        $offersData = $this->today_active_offers();

        $isDistinct = false;
        $amountOffId = null;

        foreach ($offersData as $offer) {

            if ($offer->offer_on === 'product') {
                $offerProducts = DB()->table('cc_offer_on_product')->where('offer_id', $offer->offer_id)->get()->getResult();

                foreach ($offerProducts as $pro) {
                    foreach ($cart->contents() as $cartItem) {
                        if ($pro->product_id == $cartItem['id'] && $cartItem['qty'] >= $offer->qty) {
                            $isDistinct = ($offer->offer_type == 'distinct') ? true : false;

                            if ($offer->offer_type == 'distinct') {
                                $amountOffId = $offer->offer_id;
                            }
                            $this->product_discount($offer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                        }
                    }


                    if (!empty($pro->prod_cat_id)) {
                        $tableCat = DB()->table('cc_product_to_category');
                        $catResult = $tableCat->where('category_id', $pro->prod_cat_id)->get()->getResult();
                        foreach ($catResult as $p) {
                            foreach ($cart->contents() as $cartItem) {
                                if ($p->product_id == $cartItem['id'] && $cartItem['qty'] >= $offer->qty) {
                                    $isDistinct = ($offer->offer_type == 'distinct') ? true : false;

                                    if ($offer->offer_type == 'distinct') {
                                        $amountOffId = $offer->offer_id;
                                    }
                                    $this->product_discount($offer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                                }
                            }
                        }
                    }

                    if (!empty($pro->brand_id)) {
                        $tableBrand = DB()->table('cc_products');
                        $brandResult = $tableBrand->where('brand_id', $pro->brand_id)->get()->getResult();
                        foreach ($brandResult as $b) {
                            foreach ($cart->contents() as $cartItem) {
                                if ($b->product_id == $cartItem['id'] && $cartItem['qty'] >= $offer->qty) {
                                    $isDistinct = ($offer->offer_type == 'distinct') ? true : false;

                                    if ($offer->offer_type == 'distinct') {
                                        $amountOffId = $offer->offer_id;
                                    }
                                    $this->product_discount($offer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                                }
                            }
                        }
                    }

                    if (empty($pro->brand_id) && empty($pro->prod_cat_id) && empty($pro->product_id)) {
                        foreach ($cart->contents() as $cartItem) {
                            if ($cartItem['qty'] >= $offer->qty) {
                                $isDistinct = ($offer->offer_type == 'distinct') ? true : false;
                                if ($offer->offer_type == 'distinct') {
                                    $amountOffId = $offer->offer_id;
                                }
                                $this->product_discount($offer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                            }
                        }
                    }




                }
            }

            if ($offer->offer_on === 'amount') {
                if ($totalAmount >= $offer->on_amount) {
                    $isDistinct = ($offer->offer_type == 'distinct') ? true : false;
                    if ($offer->offer_type == 'distinct') {
                        $amountOffId = $offer->offer_id;
                    }
                    $this->amount_discount($offer,$totalAmount,$shipAmount,$geo_zone_id);
                }
            }

        }

        if($isDistinct == true){

            $firstOffer = get_all_row_data_by_id('cc_offer', 'offer_id', $amountOffId);

            $this->discount = 0;
            $this->shipDiscount = 0;
            $this->productProDisc = 0;
            $this->productShipDisc = 0;
            $this->amountProDisc = 0;
            $this->amountShipDisc = 0;

            if (!empty($firstOffer)) {

                if ($firstOffer->offer_on === 'product') {
                    $offerProducts = DB()->table('cc_offer_on_product')->where('offer_id', $firstOffer->offer_id)->get()->getResult();
                    foreach ($offerProducts as $pro) {
                        foreach ($cart->contents() as $cartItem) {
                            if ($pro->product_id == $cartItem['id'] && $cartItem['qty'] >= $firstOffer->qty) {
                                $this->product_discount($firstOffer,$cartItem['price'],$cartItem['qty'],$shipAmount,$geo_zone_id);
                            }
                        }

                        if (!empty($pro->prod_cat_id)) {
                            $tableCat = DB()->table('cc_product_to_category');
                            $catResult = $tableCat->where('category_id', $pro->prod_cat_id)->get()->getResult();
                            foreach ($catResult as $p) {
                                foreach ($cart->contents() as $cartItem) {
                                    if ($p->product_id == $cartItem['id'] && $cartItem['qty'] >= $firstOffer->qty) {
                                        $this->product_discount($firstOffer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                                    }
                                }
                            }
                        }

                        if (!empty($pro->brand_id)) {
                            $tableBrand = DB()->table('cc_products');
                            $brandResult = $tableBrand->where('brand_id', $pro->brand_id)->get()->getResult();
                            foreach ($brandResult as $b) {
                                foreach ($cart->contents() as $cartItem) {
                                    if ($b->product_id == $cartItem['id'] && $cartItem['qty'] >= $firstOffer->qty) {
                                        $this->product_discount($firstOffer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                                    }
                                }
                            }
                        }

                        if (empty($pro->brand_id) && empty($pro->prod_cat_id) && empty($pro->product_id)) {
                            foreach ($cart->contents() as $cartItem) {
                                if ($cartItem['qty'] >= $firstOffer->qty) {
                                    $this->product_discount($offer, $cartItem['price'], $cartItem['qty'], $shipAmount, $geo_zone_id);
                                }
                            }
                        }

                    }
                }

                if ($firstOffer->offer_on === 'amount') {
                    $this->amount_discount($firstOffer,$totalAmount,$shipAmount,$geo_zone_id);
                }
            }
        }

        $this->discount += $this->amountProDisc + $this->productProDisc;
        $this->shipDiscount += $this->amountShipDisc + $this->productShipDisc;

        return [
            'discount_amount' => $this->discount,
            'discount_shipping_amount' => $this->shipDiscount
        ];
    }

    /**
     * @description This function provides product discount
     * @param $offer array
     * @param $qty int
     * @param $productPrice float
     * @param $shipAmount float
     * @return void
     */
    private function product_discount($offer,$productPrice,$qty,$shipAmount,$geo_zone_id)
    {
        if ($offer->discount_on === 'product_amount') {
            $totalPrice = $productPrice * $qty;
            $this->productProDisc += $this->calculate_discount($offer, $totalPrice);
        }
        if (count(Cart()->contents()) == 1) {
            if ($offer->discount_on === 'shipping_amount') {
                $this->productShipDisc = $this->calculate_discount_shipping($offer, $shipAmount,$geo_zone_id);
            }
        }
    }

    /**
     * @description This function provides amount discount
     * @param $offer array
     * @param $totalAmount float
     * @param $shipAmount float
     * @return void
     */
    private function amount_discount($offer,$totalAmount,$shipAmount,$geo_zone_id)
    {
        if ($offer->discount_on === 'product_amount') {
            $this->productProDisc += $this->calculate_discount($offer, $totalAmount);
        }
        if (count(Cart()->contents()) == 1) {
            if ($offer->discount_on === 'shipping_amount') {
                $this->productShipDisc = $this->calculate_discount_shipping($offer, $shipAmount,$geo_zone_id);
            }
        }
    }

    /**
     * @description This function provides discount calculate
     * @param $offer array
     * @param $baseAmount float
     * @return float|int|mixed
     */
    private function calculate_discount($offer, $baseAmount)
    {
        $table = DB()->table('cc_offer_discount');
        $result = $table->where('offer_id',$offer->offer_id)->get()->getRow();

        if ($result->discount_calculate_on == 'percentage') {
            return ($baseAmount * $result->discount_amount) / 100;
        }else{
            return $result->discount_amount;
        }

        return 0;
    }
    private function calculate_discount_shipping($offer, $baseAmount,$geo_zone_id)
    {
        $table = DB()->table('cc_offer_discount');
        $result = $table->where('offer_id',$offer->offer_id)->get()->getRow();
        if (empty($result->shipping_method_id)) {
            if ($result->discount_calculate_on == 'percentage') {
                return ($baseAmount * $result->discount_amount) / 100;
            } else {
                return $result->discount_amount;
            }
        }else{
            if (!empty($geo_zone_id)) {
                $tableDis = DB()->table('cc_offer_discount');
                $query = $tableDis->where('offer_id', $offer->offer_id)->where('geo_zone_id', $geo_zone_id)->get()->getRow();
                if (!empty($query)){
                    if ($query->discount_calculate_on == 'percentage') {
                        return ($baseAmount * $query->discount_amount) / 100;
                    } else {
                        return $query->discount_amount;
                    }
                }
            }
        }

        return 0;
    }









}