<?php namespace App\Libraries;

class Zone_rate_shipping{

    private $zone_rate_method;
    private $geo_zone_id;

    /**
     * @description This function provides get settings
     * @param int $city
     * @return $this
     */
    public function getSettings($city)
    {

        $shipping_method_id = get_data_by_id('shipping_method_id','cc_shipping_method','code','zone_rate');
        $table = DB()->table('cc_shipping_settings');
        $this->zone_rate_method = $table->where('shipping_method_id',$shipping_method_id)->where('label','zone_rate_method')->get()->getRow();
        if (!empty($city)) {
            $country_id = get_data_by_id('country_id','cc_zone','zone_id',$city);

            $this->geo_zone_id = $this->zone_id($country_id,$city);

        }else{
            $this->geo_zone_id = 0;
        }

        return $this;
    }

    /**
     * @description This function provides calculate shipping
     * @return int
     */
    public function calculateShipping() {
        $charge = 0;
        if (!empty($this->geo_zone_id)) {

            if (!empty($this->geo_zone_id)) {
                if ($this->zone_rate_method->value == '1') {
                    $charge = $this->weight_rate_calculation($this->geo_zone_id);
                }
                if ($this->zone_rate_method->value == '2') {
                    $charge = $this->item_rate_calculation($this->geo_zone_id);
                }
                if ($this->zone_rate_method->value == '3') {
                    $charge = $this->price_rate_calculation($this->geo_zone_id);
                }
            }else{
                $charge = $this->others_rate_calculation('0');
            }

        }else{
            $charge = $this->others_rate_calculation('0');
        }

        return $charge;
    }

    /**
     * @description This function provides others rate calculation
     * @param int $geo_zone_id
     * @return int
     */
    private function others_rate_calculation($geo_zone_id){
        $charge = 0;
        $shipping_method_id = get_data_by_id('shipping_method_id','cc_shipping_method','code','zone_rate');
        $table = DB()->table('cc_shipping_settings');
        $zone_rate_method = $table->where('shipping_method_id',$shipping_method_id)->where('label','zone_rate_method')->get()->getRow();

        if ($zone_rate_method->value == '1') {
            $charge = $this->weight_rate_calculation($geo_zone_id);
        }
        if ($zone_rate_method->value == '2') {
            $charge = $this->item_rate_calculation($geo_zone_id);
        }
        if ($zone_rate_method->value == '3') {
            $charge = $this->price_rate_calculation($geo_zone_id);
        }
        return $charge;
    }

    /**
     * @description This function provides weight rate calculation
     * @param int $geo_zone_id
     * @return int
     */
    private function weight_rate_calculation($geo_zone_id){
        $charge = 0;
        $totalWeight = 0;

        $eligible_product_array = $this->get_shipping_eligible_product();

        if (empty($eligible_product_array)) {
            return $charge;
        }else{
            foreach (Cart()->contents() as $pro){
                if (in_array($pro['id'], $eligible_product_array)){
                    $weight = get_data_by_id('weight', 'cc_products', 'product_id', $pro['id']);
                    $totalWeight += $weight * $pro['qty'];
                }
            }


            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >=',$totalWeight)->orderBy('up_to_value','ASC')->get()->getRow();

            if (!empty($allZoneRate)){
                $charge = $allZoneRate->cost;
            }

            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRateAbove = $tableRate->where('geo_zone_id', $geo_zone_id)->where('above <',$totalWeight)->orderBy('above','ASC')->get()->getRow();

            if (!empty($allZoneRateAbove)){
                $charge = $allZoneRateAbove->cost;
            }
        }

        return $charge;
    }

    /**
     * @description This function provides item rate calculation
     * @param int $geo_zone_id
     * @return int
     */
    private function item_rate_calculation($geo_zone_id){
        $charge = 0;
        $totalItem = 0;

        $eligible_product_array = $this->get_shipping_eligible_product();
        if (empty($eligible_product_array)) {
            return $charge;
        }else {
            foreach (Cart()->contents() as $pro) {
                if (in_array($pro['id'], $eligible_product_array)) {
                    $totalItem += $pro['qty'];
                }
            }

            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >=', $totalItem)->orderBy('up_to_value', 'ASC')->get()->getRow();

            if (!empty($allZoneRate)) {
                $charge = $allZoneRate->cost;
            }

            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRateAbove = $tableRate->where('geo_zone_id', $geo_zone_id)->where('above <', $totalItem)->orderBy('above', 'ASC')->get()->getRow();

            if (!empty($allZoneRateAbove)) {
                $charge = $allZoneRateAbove->cost;
            }

        }
        return $charge;

    }

    /**
     * @description This function provides price rate calculation
     * @param int $geo_zone_id
     * @return int
     */
    private function price_rate_calculation($geo_zone_id){
        $charge = 0;

        $eligible_product_array = $this->get_shipping_eligible_product();
        if (empty($eligible_product_array)) {
            return $charge;
        }else {
            $totalPrice = 0;
            foreach (Cart()->contents() as $pro) {
                if (in_array($pro['id'], $eligible_product_array)) {
                    $totalPrice += $pro['subtotal'];
                }
            }

            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >=', $totalPrice)->orderBy('up_to_value', 'ASC')->get()->getRow();

            if (!empty($allZoneRate)) {
                $charge = $allZoneRate->cost;
            }

            $tableRate = DB()->table('cc_geo_zone_shipping_rate');
            $allZoneRateAbove = $tableRate->where('geo_zone_id', $geo_zone_id)->where('above <', $totalPrice)->orderBy('above', 'ASC')->get()->getRow();

            if (!empty($allZoneRateAbove)) {
                $charge = $allZoneRateAbove->cost;
            }

        }
        return $charge;
    }

    /**
     * @description This function provides zone id
     * @param int $country_id
     * @param int $zone_id
     * @return int
     */
    public function zone_id($country_id,$zone_id){
        $table = DB()->table('cc_geo_zone_details');
        $datarow = $table->where('country_id', $country_id)->where('zone_id', $zone_id)->get()->getRow();

        if (!empty($datarow)){
            $result = $datarow->geo_zone_id;
        }else{
            $data = $table->where('country_id', $country_id)->where('zone_id', '0')->get()->getRow();
            if (!empty($data)){
                $result = $data->geo_zone_id;
            }else{
                $result = 0;
            }
        }
        return $result;

    }

    /**
     * @description This function provides get shipping eligible product
     * @return array
     */
    public function get_shipping_eligible_product(): array
    {
        $eligible_product = array();

        foreach (Cart()->contents() as $val){
            $table = DB()->table('cc_product_free_delivery');
            $exist = $table->where('product_id',$val['id'])->countAllResults();
            if (empty($exist)){
                $eligible_product[] = $val['id'];
            }
        }

        return $eligible_product;
    }


}