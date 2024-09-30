<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Libraries\Permission;
use App\Models\FavoriteModel;
use CodeIgniter\HTTP\RedirectResponse;

class Order extends BaseController
{

    protected $validation;
    protected $session;
    protected $favoriteModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->favoriteModel = new FavoriteModel();
    }

    /**
     * @description This method provides order page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_order');
            $data['order'] = $table->where('customer_id',$this->session->cusUserId)->get()->getResult();

            $data['menu_active'] = 'order';
            $data['page_title'] = 'My Order';

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Order List';
            echo view('Theme/'.$settings['Theme'].'/header',$data);
            echo view('Theme/'.$settings['Theme'].'/Customer/menu');
            echo view('Theme/'.$settings['Theme'].'/Customer/order',$data);
            echo view('Theme/'.$settings['Theme'].'/footer');
        }
    }

    /**
     * @description This method provides invoice view
     * @param int $order_id
     * @return RedirectResponse|void
     */
    public function invoice($order_id){
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_order');
            $data['order'] = $table->where('order_id',$order_id)->get()->getRow();

            $tableItem = DB()->table('cc_order_item');
            $data['orderItem'] = $tableItem->where('order_id',$order_id)->get()->getResult();

            $data['menu_active'] = 'order';
            $data['page_title'] = 'Invoice';

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Invoice';

            echo view('Theme/'.$settings['Theme'].'/header',$data);
            echo view('Theme/'.$settings['Theme'].'/Customer/menu');
            echo view('Theme/'.$settings['Theme'].'/Customer/invoice',$data);
            echo view('Theme/'.$settings['Theme'].'/footer');
        }
    }

}
