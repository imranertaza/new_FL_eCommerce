<?php namespace App\Libraries;

class Weight_shipping{

    private $shippingData;

    /**
     * @description This function provides get settings
     * @return $this
     */
    public function getSettings(){
        $shipping_method_id = get_data_by_id('shipping_method_id','cc_shipping_method','code','weight');

        $table = DB()->table('cc_weight_shipping_settings');
        $this->shippingData = $table->where('shipping_method_id',$shipping_method_id)->orderBy('label','ASC')->get()->getResult();

        return $this;
    }

    /**
     * @description This function provides calculate shipping
     * @return int|string
     */
    public function calculateShipping() {
        $weight = 0;
        $value = 0;
        $eligible_product_array = $this->get_shipping_eligible_product();
        foreach ($eligible_product_array as $val){
            $weight += get_data_by_id('weight','cc_products','product_id',$val);
        }

        foreach ($this->shippingData as $ship){
            if($ship->label <  $weight ) {
                $value = $ship->value;
            }else{
                if ($ship->label == 0){
                    if (empty($eligible_product_array)) {
                        $value = '0';
                    }else{
                        $value = $ship->value;
                    }
                }
            }
        }
        return $value;
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