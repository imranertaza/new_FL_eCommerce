<?php

namespace App\Controllers;

use App\Models\QcpictureModel;

class Qc_picture extends BaseController {

    protected $validation;
    protected $session;
    protected $encrypter;
    protected $qcpicture;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->encrypter = \Config\Services::encrypter();
        $this->qcpicture = new QcpictureModel();
    }

    /**
     * @description This method provides Qc picture page view
     * @return void
     */
    public function index(){
        $settings = get_settings();

        $data['qcpicture'] = $this->qcpicture->orderBy('sort_order','ASC')->paginate(20);
        $data['pager'] = $this->qcpicture->pager;
        $data['links'] = $data['pager']->links('default','custome_link');



        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Qc_picture/index',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }

    /**
     * @description This method provides Qc picture detail page view
     * @param int $album_id
     * @return void
     */
    public function view($album_id){
        $settings = get_settings();

        $table = DB()->table('cc_album');
        $data['album'] = $table->where('album_id',$album_id)->get()->getRow();

        $tableAll = DB()->table('cc_album_details');
        $data['albumAll'] = $tableAll->where('album_id',$album_id)->orderBy('sort_order','ASC')->get()->getResult();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title'])?$settings['meta_title']:$settings['store_name'];

        echo view('Theme/'.$settings['Theme'].'/header',$data);
        echo view('Theme/'.$settings['Theme'].'/Qc_picture/view',$data);
        echo view('Theme/'.$settings['Theme'].'/footer');
    }



}
