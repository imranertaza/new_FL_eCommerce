<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\FavoriteModel;
use CodeIgniter\HTTP\RedirectResponse;

class Profile extends BaseController
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
     * @description This method provides profile page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInCustomer = $this->session->isLoggedInCustomer;
        if (!isset($isLoggedInCustomer) || $isLoggedInCustomer != TRUE) {
            return redirect()->to(site_url('Login'));
        } else {
            $settings = get_settings();
            $table = DB()->table('cc_customer');
            $data['customer'] = $table->where('customer_id',$this->session->cusUserId)->get()->getRow();

            $table = DB()->table('cc_address');
            $data['address'] = $table->where('customer_id',$this->session->cusUserId)->get()->getRow();

            $data['menu_active'] = 'profile';
            $data['page_title'] = 'Profile';

            $data['keywords'] = $settings['meta_keyword'];
            $data['description'] = $settings['meta_description'];
            $data['title'] = 'Profile';

            echo view('Theme/'.$settings['Theme'].'/header',$data);
            echo view('Theme/'.$settings['Theme'].'/Customer/menu');
            echo view('Theme/'.$settings['Theme'].'/Customer/profile',$data);
            echo view('Theme/'.$settings['Theme'].'/footer');
        }
    }

    /**
     * @description This method provides update action
     * @return RedirectResponse
     */
    public function update_action(){
        $data['firstname'] = $this->request->getPost('firstname');
        $data['lastname'] = $this->request->getPost('lastname');
        $data['email'] = $this->request->getPost('email');
        $data['phone'] = $this->request->getPost('phone');

        $data['address_1'] = $this->request->getPost('address_1');
        $data['address_2'] = $this->request->getPost('address_2');
        $data['country_id'] = $this->request->getPost('country_id');
        $data['zone_id'] = $this->request->getPost('zone_id');
        $data['postcode'] = $this->request->getPost('postcode');


        $data['current_password'] = $this->request->getPost('current_password');
        $data['new_password'] = $this->request->getPost('new_password');
        $data['confirm_password'] = $this->request->getPost('confirm_password');

        $data['subscription'] = $this->request->getPost('subscription');

        $this->validation->setRules([
            'firstname' => ['label' => 'First name', 'rules' => 'required'],
            'lastname' => ['label' => 'Last name', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required'],
            'phone' => ['label' => 'Phone', 'rules' => 'required'],
            'postcode' => ['label' => 'Post code', 'rules' => 'required'],
            'country_id' => ['label' => 'Country', 'rules' => 'required'],
            'address_1' => ['label' => 'Address line 1', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert text-white alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('profile');
        } else {

            if (!empty($this->request->getPost('subscription'))){
                $newData['customer_id'] = $this->session->cusUserId;
                $newData['email'] = $data['email'];
                $newAd = DB()->table('cc_newsletter');
                $newAd->insert($newData);

                $cusData['newsletter'] = '1';

                $subject = 'Subscription';
                $message = "Thank you.Your subscription has been successfully completed";
                email_send($data['email'],$subject,$message);
            }


            $cusData['firstname'] = $data['firstname'];
            $cusData['lastname'] = $data['lastname'];
            $cusData['email'] = $data['email'];
            $cusData['phone'] = $data['phone'];

            if (!empty($data['current_password'])){
                $check = is_exists_double_condition('cc_customer','customer_id',$this->session->cusUserId,'password',SHA1($data['current_password']));
                if ($check == false){
                    if ($data['new_password'] == $data['confirm_password']){
                        $cusData['password'] =  SHA1($data['new_password']);
                    }else{
                        $this->session->setFlashdata('message', '<div class="alert alert-danger text-white alert-dismissible" role="alert">New password and confirm password not match </div>');
                        return redirect()->to('profile');
                    }
                }else{
                    $this->session->setFlashdata('message', '<div class="alert alert-danger text-white alert-dismissible" role="alert">Current password not match </div>');
                    return redirect()->to('profile');
                }
            }

            $table = DB()->table('cc_customer');
            $table->where('customer_id',$this->session->cusUserId)->update($cusData);

            //address
            $addData['customer_id'] = $this->session->cusUserId;
            $addData['firstname'] = $data['firstname'];
            $addData['lastname'] = $data['lastname'];
            $addData['address_1'] = $data['address_1'];
            $addData['address_2'] = $data['address_2'];
            $addData['country_id'] = $data['country_id'];
            $addData['zone_id'] = $data['zone_id'];
            $addData['postcode'] = $data['postcode'];

            $check_address = is_exists('cc_address','customer_id',$this->session->cusUserId);
            if ($check_address == true){
                $tabAd = DB()->table('cc_address');
                $tabAd->insert($addData);
            }else{
                $tabAd = DB()->table('cc_address');
                $tabAd->where('customer_id',$this->session->cusUserId)->update($addData);
            }




            $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Update successfully </div>');
            return redirect()->to('profile');

        }
    }

    /**
     * @description This method provides password action
     * @return RedirectResponse
     */
    public function password_action(){


        $data['current_password'] = $this->request->getPost('current_password');
        $data['new_password'] = $this->request->getPost('new_password');
        $data['confirm_password'] = $this->request->getPost('confirm_password');

        $this->validation->setRules([
            'current_password' => ['label' => 'Current Password', 'rules' => 'required'],
            'new_password' => ['label' => 'New Password', 'rules' => 'required'],
            'confirm_password' => ['label' => 'Confirm Password', 'rules' => 'required|matches[new_password]'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            $this->session->setFlashdata('message', '<div class="alert text-white  alert-dismissible" role="alert">' . $this->validation->listErrors() . '</div>');
            return redirect()->to('dashboard');
        } else {

            if (!empty($data['current_password'])){
                $check = is_exists_double_condition('cc_customer','customer_id',$this->session->cusUserId,'password',SHA1($data['current_password']));
                if ($check == false){
                    $cusData['password'] =  SHA1($data['new_password']);
                }else{
                    $this->session->setFlashdata('message', '<div class="alert  alert-dismissible" role="alert">Current password not match </div>');
                    return redirect()->to('dashboard');
                }
            }

            $table = DB()->table('cc_customer');
            $table->where('customer_id',$this->session->cusUserId)->update($cusData);


            $this->session->setFlashdata('message', '<div class="alert-success-m alert-success alert-dismissible" role="alert">Update successfully </div>');
            return redirect()->to('dashboard');

        }
    }

    /**
     * @description This method provides newsletter action
     * @return void
     */
    public function newsletter_action(){
        $checked = $this->request->getPost('value');
        if ($checked == 'checked') {
            $check = get_data_by_id('newsletter', 'cc_customer', 'customer_id', $this->session->cusUserId);
            if ($check == '0') {
                $email = get_data_by_id('email', 'cc_customer', 'customer_id', $this->session->cusUserId);
                $newData['customer_id'] = $this->session->cusUserId;
                $newData['email'] = $email;
                $newAd = DB()->table('cc_newsletter');
                $newAd->insert($newData);


                $cusData['newsletter'] = '1';
                $table = DB()->table('cc_customer');
                $table->where('customer_id', $this->session->cusUserId)->update($cusData);

                $subject = 'Subscription';
                $message = "Thank you.Your subscription has been successfully completed";
                email_send($email, $subject, $message);

                print '<div class="alert-success-m alert-success alert-dismissible" role="alert">Your subscription has been successfully completed </div>';
            } else {
                print '<div class="alert alert-danger alert-dismissible text-white " role="alert">Your email already exists</div>';
            }
        }else{
            $newAd = DB()->table('cc_newsletter');
            $newAd->where('customer_id',$this->session->cusUserId)->delete();


            $cusData['newsletter'] = '0';
            $table = DB()->table('cc_customer');
            $table->where('customer_id', $this->session->cusUserId)->update($cusData);
            print '<div class="alert-success-m alert-success alert-dismissible" role="alert">Your subscription has been successfully removed </div>';
        }


    }

}
