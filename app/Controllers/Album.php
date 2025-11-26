<?php

namespace App\Controllers;

use App\Libraries\Image_processing;
use App\Models\AlbumModel;

class Album extends BaseController {

    protected $validation;
    protected $session;
    protected $encrypter;
    protected $albumModel;
    protected $image_processing;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
        $this->albumModel = new AlbumModel();
        $this->image_processing = new Image_processing();
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
        if(email_send($email, $subject, $message) == true){
            $check = is_exists('cc_enquiry_emails', 'email', $emailCus);
            if($check == true){
                $data['email'] = $emailCus;
                $table = DB()->table('cc_enquiry_emails');
                $table->insert($data);
            }
            $message = 'In query successfully submitted';
        }else{
            $message = 'Something went wrong! Please try again.';
        }

        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash())
            ->setBody($message);
    }
    /**
     * @description This method provides album image download
     * @return false|string
     */
    public function albumImageDownload(){
        $album_id = $this->request->getPost('album_id');
        $image_id = $this->request->getPost('image_id');
        $condition = $this->request->getPost('condition');
        $downloadUrl = '';
        $unlinkUrl = '';
        if (empty($image_id)) {
            $target_dir = FCPATH . '/uploads/album/' . $album_id . '/';
            $image = get_data_by_id('thumb', 'cc_album', 'album_id', $album_id);
            $mainImage = str_replace("pro_", "", $image);
            $downloadUrl = base_url('/uploads/album/' . $album_id . '/'. $mainImage) ;
            if ($condition == 'watermark') {
                $this->image_processing->watermark_main_image($target_dir, $mainImage);
                $downloadUrl = base_url('/uploads/album/' . $album_id . '/'.'wm_' . $mainImage) ;
                $unlinkUrl = $target_dir.'wm_'.$mainImage;
            }

        }else {
            $target_dir = FCPATH . '/uploads/album/' . $album_id . '/' . $image_id . '/';
            $image = get_data_by_id('image', 'cc_album_details', 'album_details_id', $image_id);
            $subImage = str_replace("pro_", "", $image);
            $downloadUrl = base_url('/uploads/album/' . $album_id . '/'. $image_id . '/'. $subImage) ;
            if ($condition == 'watermark') {
                $this->image_processing->watermark_main_image($target_dir, $subImage);
                $downloadUrl = base_url('/uploads/album/' . $album_id . '/'. $image_id . '/'. 'wm_' .$subImage);
                $unlinkUrl = $target_dir.'wm_'.$subImage;
            }

        }

        $data['downloadUrl'] = $downloadUrl;
        $data['unlinkUrl'] = $unlinkUrl;
        $data['csrfToken'] = csrf_hash();
        return json_encode($data);
    }
    /**
     * @description This method provides album image unlink
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function albumImageUnlink(){
        $url = $this->request->getPost('url');
        $this->image_processing->image_unlink($url);
        return $this->response
            ->setHeader('X-CSRF-TOKEN', csrf_hash());
    }

}
