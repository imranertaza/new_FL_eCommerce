<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Section extends BaseController
{

    protected $validation;
    protected $session;
    protected $encrypter;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
    }

    /**
     * @description This method provides home page view
     * @return void
     */
    public function view($id)
    {
        $settings = get_settings();
        $theme = $settings['Theme'];

        $db = DB();
        $now = date('Y-m-d H:i:s');

        $data['schedule'] = $db->table('cc_featured_schedule')
            ->where('start_date <=',$now)
            ->where('end_date >=',$now)
            ->where('featured_schedule_id',$id)
            ->get()
            ->getRow();
        $result = [];
         if (!empty($data['schedule'])) {
             $featured = $db->table('cc_featured_product')
                 ->where('featured_schedule_id', $id)
                 ->get()
                 ->getResult();

             // Detect type from first row
             $type = null;
             $first = $featured[0];

             if (!empty($first->product_id)) {
                 $type = 'product';
             } elseif (!empty($first->brand_id)) {
                 $type = 'brand';
             } elseif (!empty($first->prod_cat_id)) {
                 $type = 'category';
             }

             // Handle by type
             if ($type === 'product') {

                 foreach ($featured as $item) {
                     $product = $db->table('cc_products')
                         ->where('product_id', $item->product_id)
                         ->where('status', 'Active')
                         ->where('featured', '1')
                         ->get()
                         ->getRow();

                     if ($product) {
                         $result[] = $product;
                     }
                 }

             } elseif ($type === 'brand') {

                 foreach ($featured as $item) {
                     $product = $db->table('cc_products')
                         ->where('brand_id', $item->brand_id)
                         ->where('status', 'Active')
                         ->where('featured', '1')
                         ->get()
                         ->getRow();

                     if ($product) {
                         $result[] = $product;
                     }
                 }

             } elseif ($type === 'category') {

                 foreach ($featured as $item) {
                     $product = $db->table('cc_products p')
                         ->join('cc_product_to_category ptc', 'ptc.product_id = p.product_id')
                         ->where('ptc.category_id', $item->prod_cat_id)
                         ->where('p.status', 'Active')
                         ->where('p.featured', '1')
                         ->get()
                         ->getRow();

                     if ($product) {
                         $result[] = $product;
                     }
                 }

             }
         }

        $data['result'] = $result;
        $data['home_menu'] = true;
        $data['theme'] = $theme;

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title']) ? $settings['meta_title'] : $settings['store_name'];


        echo view('Theme/' . $settings['Theme'] . '/Section/view', $data);
    }

}
