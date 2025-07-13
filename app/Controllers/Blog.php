<?php

namespace App\Controllers;

use App\Models\BlogModel;

class Blog extends BaseController
{
    protected $validation;
    protected $session;
    protected $blogModel;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->blogModel = new BlogModel();
    }

    /**
     * @description This method provides Qc picture page view
     * @return void
     */
    public function index()
    {
        $settings = get_settings();

        $data['blog'] = $this->blogModel->where('status', '1')->orderBy('blog_id', 'ASC')->paginate(12);
        $data['pager'] = $this->blogModel->pager;
        $data['links'] = $data['pager']->links('default', 'custome_link');

        $table = DB()->table('cc_category');
        $data['category'] = $table->get()->getResult();

        $data['catBtn'] = 'All';
        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title']) ? $settings['meta_title'] : $settings['store_name'];

        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Blog/index', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }
    public function category($cat_id)
    {
        $settings = get_settings();

        $data['blog']  = $this->blogModel->where('status', '1')->where('cat_id', $cat_id)->orderBy('blog_id', 'ASC')->paginate(12);
        $data['pager'] = $this->blogModel->pager;
        $data['links'] = $data['pager']->links('default', 'custome_link');

        $table            = DB()->table('cc_category');
        $data['category'] = $table->get()->getResult();

        $data['catBtn']      = $cat_id;
        $data['keywords']    = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title']       = !empty($settings['meta_title']) ? $settings['meta_title'] : $settings['store_name'];

        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Blog/index', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }
    /**
     * @description This method provides Qc picture detail page view
     * @param int $album_id
     * @return void
     */
    public function view($blog_id)
    {
        $settings = get_settings();

        $table = DB()->table('cc_blog');
        $data['blog'] = $table->where('blog_id', $blog_id)->get()->getRow();

        $tableImage = DB()->table('cc_blog_carousel_image');
        $data['image'] = $tableImage->where('blog_id', $blog_id)->get()->getResult();

        $tableComments = DB()->table('cc_blog_comments');
        $data['comments'] = $tableComments->where('blog_id', $blog_id)->where('comment_parent_id',null)->get()->getResult();

        $data['keywords'] = $settings['meta_keyword'];
        $data['description'] = $settings['meta_description'];
        $data['title'] = !empty($settings['meta_title']) ? $settings['meta_title'] : $settings['store_name'];

        echo view('Theme/' . $settings['Theme'] . '/header', $data);
        echo view('Theme/' . $settings['Theme'] . '/Blog/view', $data);
        echo view('Theme/' . $settings['Theme'] . '/footer');
    }

    /**
     * @description This method provides Comment action
     * @return void
     */
    public function commentAction(){
        $data['blog_id'] = $this->request->getPost('blog_id');
        $data['comment'] = $this->request->getPost('comment');
        $data['email'] = $this->request->getPost('email');
        $data['name'] = $this->request->getPost('name');

        $this->validation->setRules([
            'comment' => ['label' => 'Comment', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required'],
            'name' => ['label' => 'Name', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            print  $this->validation->listErrors() ;
        } else {
            $dataComment['blog_id'] = $data['blog_id'];
            $dataComment['comment_author'] = $data['name'];
            $dataComment['comment_author_email'] = $data['email'];
            $dataComment['comment_content'] = $data['comment'];
            $dataComment['comment_author_IP'] = $this->getClientIp();
            $dataComment['comment_date'] = date('Y-m-d H:i:s');;
            $table = DB()->table('cc_blog_comments');
            $table->insert($dataComment);

            print 'Comment Save successfully';
        }
    }

    /**
     * @description This method provides Client Ip
     * @return array|false|string
     */
    public function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function commentReplyAction(){
        $data['comment_id'] = $this->request->getPost('comment_id');
        $data['com_name'] = $this->request->getPost('com_name');
        $data['com_email'] = $this->request->getPost('com_email');
        $data['com_text'] = $this->request->getPost('com_text');

        $this->validation->setRules([
            'com_email' => ['label' => 'Email', 'rules' => 'required'],
            'com_name' => ['label' => 'Name', 'rules' => 'required'],
            'com_text' => ['label' => 'Text', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            print  $this->validation->listErrors() ;
        } else {
            $blog_id = get_data_by_id('blog_id','cc_blog_comments','comment_id',$data['comment_id']);
            $dataComment['blog_id'] = $blog_id;
            $dataComment['comment_author'] = $data['com_name'];
            $dataComment['comment_author_email'] = $data['com_email'];
            $dataComment['comment_content'] = $data['com_text'];
            $dataComment['comment_author_IP'] = $this->getClientIp();
            $dataComment['comment_parent_id'] = $data['comment_id'];
            $dataComment['comment_date'] = date('Y-m-d H:i:s');;
            $table = DB()->table('cc_blog_comments');
            $table->insert($dataComment);

            print 'Comment Save successfully';
        }
    }



}
