<?php namespace App\Libraries;

class Zone_rate_shipping{


    public function getSettings($city){
        $charge = 0;
        $shipping_method_id = get_data_by_id('shipping_method_id','cc_shipping_method','code','zone_rate');
        $table = DB()->table('cc_shipping_settings');
        $zone_rate_method = $table->where('shipping_method_id',$shipping_method_id)->where('label','zone_rate_method')->get()->getRow();
        if (!empty($city)) {
            $country_id = get_data_by_id('country_id','cc_zone','zone_id',$city);

            $geo_zone_id = $this->zone_id($country_id,$city);

            if (!empty($geo_zone_id)) {
                if ($zone_rate_method->value == '1') {
                    $charge = $this->weight_rate_calculation($geo_zone_id);
                }
                if ($zone_rate_method->value == '2') {
                    $charge = $this->item_rate_calculation($geo_zone_id);
                }
                if ($zone_rate_method->value == '3') {
                    $charge = $this->price_rate_calculation($geo_zone_id);
                }
            }else{
                $charge = $this->others_rate_calculation('0');
            }

        }else{
            $charge = $this->others_rate_calculation('0');
        }

        return $charge;

    }

    private function others_rate_calculation($geo_zone_id){
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


    private function weight_rate_calculation($geo_zone_id){
        $charge = 0;
        $totalWeight = 0;
        foreach (Cart()->contents() as $pro){
            $weight = get_data_by_id('weight', 'cc_products', 'product_id', $pro['id']);
            $totalWeight += $weight * $pro['qty'];
        }


        $tableRate = DB()->table('cc_geo_zone_shipping_rate');
        $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >',$totalWeight)->orderBy('up_to_value','ASC')->get()->getRow();

        if (!empty($allZoneRate)){
            $charge = $allZoneRate->cost;
        }

        return $charge;
    }

    private function item_rate_calculation($geo_zone_id){
        $charge = 0;
        $totalItem = 0;
        foreach (Cart()->contents() as $pro){
            $totalItem += $pro['qty'];
        }


        $tableRate = DB()->table('cc_geo_zone_shipping_rate');
        $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >',$totalItem)->orderBy('up_to_value','ASC')->get()->getRow();

        if (!empty($allZoneRate)){
            $charge = $allZoneRate->cost;
        }

        return $charge;
    }

    private function price_rate_calculation($geo_zone_id){
        $charge = 0;
        $totalPrice = Cart()->total();

        $tableRate = DB()->table('cc_geo_zone_shipping_rate');
        $allZoneRate = $tableRate->where('geo_zone_id', $geo_zone_id)->where('up_to_value >',$totalPrice)->orderBy('up_to_value','ASC')->get()->getRow();

        if (!empty($allZoneRate)){
            $charge = $allZoneRate->cost;
        }

        return $charge;
    }



    private function zone_id($country_id,$zone_id){
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





}