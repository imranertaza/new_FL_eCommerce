<?php

namespace App\Controllers;

use App\Models\AlbumModel;

class Album extends BaseController {

    protected $validation;
    protected $session;
    protected $encrypter;
    protected $albumModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
        $this->albumModel = new AlbumModel();
    }

    /**
     * @description This method provides Qc picture page view
     * @return void
     */
    public function index(){
        $settings = get_settings();

        $data['qcpicture'] = $this->albumModel->where('parent_album_id', '0')->orderBy('name','ASC')->paginate(20);
        $data['pager'] = $this->albumModel->pager;
        $data['links'] = $data['pager']->links('default','custome_link');



        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Album/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    public function qc_picture_view_category($album_id){
        $settings = get_settings();

        $data['qcpicture'] = $this->albumModel->where('parent_album_id', $album_id)->orderBy('name','ASC')->paginate(20);
        $data['pager'] = $this->albumModel->pager;
        $data['links'] = $data['pager']->links('default','custome_link');

        $data['page_title'] = get_data_by_id('name','cc_album','album_id',$album_id);

        $checkParent = get_data_by_id('parent_album_id','cc_album','album_id',$album_id);
        $data['back_url'] = !empty($checkParent)?base_url('qc-picture-view-category/'.$checkParent):base_url('page/qc-pictures');


        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Album/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides Qc picture detail page view
     * @param int $album_id
     * @return void
     */
    public function view($album_id){
        $settings = get_settings();

        $check = is_exists('cc_album', 'album_id', $album_id);
        if ($check == true){
            return redirect()->to('qc-picture-not-found');
        }

        $table = DB()->table('cc_album');
        $data['album'] = $table->where('album_id',$album_id)->get()->getRow();

        $tableAll = DB()->table('cc_album_details');
        $data['albumAll'] = $tableAll->where('album_id',$album_id)->orderBy('album_details_id','ASC')->get()->getResult();

        $checkParent = get_data_by_id('parent_album_id','cc_album','album_id',$album_id);
        $data['back_url'] = base_url('qc-picture-view-category/'.$checkParent);

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Album/view',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }
    public function picture_not_found(){
        $settings = get_settings();


        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Album/not_found',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    public function qc_picture_query(){
        $emailCus = $this->request->getPost('email');
        $albumId = $this->request->getPost('album_id');
        $url = base_url('qc-picture-view/'.$albumId);

        //email send admin
        $email = get_lebel_by_value_in_settings('email');
        $subject = 'Enquiry Request!';
        $message = 'Please provide me the details of this product. <br>URL:'.$url.' <br>Email:'.$emailCus;
        email_send($email, $subject, $message);

//        print 'In query successfully submitted';
    }



}
