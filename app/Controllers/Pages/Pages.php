<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Pages extends BaseController {

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    /**
     * @description This method provides page view
     * @param string $slug
     * @return void
     */
    public function page($slug){
        $settings = get_settings();
        $table = DB()->table('cc_pages');
        $page = $table->where('slug',$slug)->get()->getRow();

        $data['page_title'] = $page->page_title;
        $data['pageData'] = $page;

        $data['keywords'] = !empty($page->meta_keyword)?$page->meta_keyword:$settings['meta_keyword'];
        $data['description'] = !empty($page->meta_description)?$page->meta_description:$settings['meta_description'];
        $data['title'] = !empty($page->meta_title)?$page->meta_title:$page->page_title;

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        if (!empty($page->temp)){
            echo view('Theme/'.$settings['Theme'].'/Page/'.$page->temp);
        }else{
            echo view('Theme/'.$settings['Theme'].'/Page/default',$data);
        }
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides contact action
     * @return void
     */
    public function contact_action(){

        $data['email'] = $this->request->getPost('email');
        $data['message'] = $this->request->getPost('message');
        $subject = 'Contact form';
        $this->validation->setRules([
            'email' => ['label' => 'Email', 'rules' => 'required'],
            'message' => ['label' => 'Message', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == FALSE) {
            print $this->validation->listErrors();
        } else {
            //message get admin
            $email = get_lebel_by_value_in_settings('email');
            email_send($email, $subject, $data['message']);


            //message get customer
            $message = 'Your message was successfully submitted';
            email_send($data['email'], $subject, $message);

//            print 'Your message was successfully submitted';
        }
    }




}
