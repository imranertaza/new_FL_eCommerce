<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Image_processing;
use App\Libraries\Permission;
use CodeIgniter\HTTP\RedirectResponse;

class BlogSchedule extends BaseController
{
    protected $validation;
    protected $session;
    protected $crop;
    protected $permission;
    protected $imageProcessing;
    private $module_name = 'Blog';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->crop = \Config\Services::image();
        $this->permission = new Permission();
        $this->imageProcessing = new Image_processing();
    }

    /**
     * @description This method provides album page view
     * @return RedirectResponse|void
     */
    public function index()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_blog_schedule');
            $data['blogSchedule'] = $table->orderBy('blog_schedule_id', 'DESC')->get()->getResult();


            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['mod_access']) and $data['mod_access'] == 1) {
                echo view('Admin/BlogSchedule/index', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album create page view
     * @return RedirectResponse|void
     */
    public function create()
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_blog');
            $data['blog'] = $table->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['create']) and $data['create'] == 1) {
                echo view('Admin/BlogSchedule/create', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides album create action
     * @return RedirectResponse
     */
    public function createAction()
    {
        $data['schedule_name'] = $this->request->getPost('schedule_name');
        $data['start_date'] = $this->request->getPost('start_date');
        $data['end_date'] = $this->request->getPost('end_date');
        $blog_id = $this->request->getPost('blog_id[]');

        $this->validation->setRules([
            'schedule_name' => ['label' => 'Schedule Name', 'rules' => 'required'],
            'start_date' => ['label' => 'Start Date', 'rules' => 'required'],
            'end_date' => ['label' => 'End Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog-schedule-create');
        } else {
            $db = DB();
            $db->transStart();

            $table = $db->table('cc_blog_schedule');
            $table->insert($data);
            $blog_schedule_id = $db->insertID();

            $scheduleList = [];
            if (!empty($blog_id)) {
                foreach ($blog_id as $id) {
                    $scheduleList[] = [
                        'blog_schedule_id' => $blog_schedule_id,
                        'blog_id'          => $id,
                    ];
                }

                $tableSchedule = $db->table('cc_blog_schedule_details');
                $tableSchedule->insertBatch($scheduleList);
            }
            $db->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Create Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('blog-schedule-create');
        }
    }

    /**
     * @description This method provides album update page view
     * @param int $blog_id
     * @return RedirectResponse|void
     */
    public function update($blog_schedule_id)
    {
        $isLoggedInEcAdmin = $this->session->isLoggedInEcAdmin;
        $adRoleId = $this->session->adRoleId;

        if (!isset($isLoggedInEcAdmin) || $isLoggedInEcAdmin != true) {
            return redirect()->to(site_url('admin'));
        } else {
            $table = DB()->table('cc_blog');
            $data['blog'] = $table->get()->getResult();


            $table = DB()->table('cc_blog_schedule');
            $data['blogSchedule'] = $table->where('blog_schedule_id', $blog_schedule_id)->get()->getRow();

            $tableScheduleList = DB()->table('cc_blog_schedule_details');
            $data['blogScheduleList'] = $tableScheduleList->where('blog_schedule_id', $blog_schedule_id)->get()->getResult();

            //$perm = array('create','read','update','delete','mod_access');
            $perm = $this->permission->module_permission_list($adRoleId, $this->module_name);

            foreach ($perm as $key => $val) {
                $data[$key] = $this->permission->have_access($adRoleId, $this->module_name, $key);
            }

            if (isset($data['update']) and $data['update'] == 1) {
                echo view('Admin/BlogSchedule/update', $data);
            } else {
                echo view('Admin/no_permission');
            }
        }
    }

    /**
     * @description This method provides color family update action
     * @return RedirectResponse
     */
    public function updateAction()
    {
        $blog_schedule_id = $this->request->getPost('blog_schedule_id');
        $data['schedule_name'] = $this->request->getPost('schedule_name');
        $data['start_date'] = $this->request->getPost('start_date');
        $data['end_date'] = $this->request->getPost('end_date');
        $blog_id = $this->request->getPost('blog_id[]');

        $this->validation->setRules([
            'schedule_name' => ['label' => 'Schedule Name', 'rules' => 'required'],
            'start_date' => ['label' => 'Start Date', 'rules' => 'required'],
            'end_date' => ['label' => 'End Date', 'rules' => 'required'],
        ]);

        if ($this->validation->run($data) == false) {
            $this->session->setFlashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">' . $this->validation->listErrors() . ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

            return redirect()->to('blog-schedule-update/'.$blog_schedule_id);
        } else {
            $db = DB();
            $db->transStart();

            $table = $db->table('cc_blog_schedule');
            $table->where('blog_schedule_id',$blog_schedule_id)->update($data);

            $scheduleList = [];
            if (!empty($blog_id)) {
                $tableScheduleList = DB()->table('cc_blog_schedule_details');
                $tableScheduleList->where('blog_schedule_id', $blog_schedule_id)->delete();

                foreach ($blog_id as $id) {
                    $scheduleList[] = [
                        'blog_schedule_id' => $blog_schedule_id,
                        'blog_id'          => $id,
                    ];
                }

                $tableSchedule = $db->table('cc_blog_schedule_details');
                $tableSchedule->insertBatch($scheduleList);
            }
            $db->transComplete();

            $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Update Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return redirect()->to('blog-schedule-update/'.$blog_schedule_id);

        }
    }

    /**
     * @description This method provides blog delete
     * @param int $blog_schedule_id
     * @return RedirectResponse
     */
    public function delete($blog_schedule_id)
    {
        DB()->transStart();
        $table = DB()->table('cc_blog_schedule');
        $table->where('blog_schedule_id', $blog_schedule_id)->delete();

        $tableScheduleList = DB()->table('cc_blog_schedule_details');
        $tableScheduleList->where('blog_schedule_id', $blog_schedule_id)->delete();
        DB()->transComplete();

        $this->session->setFlashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">Delete Record Success <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        return redirect()->to('blog-schedule');
    }
}
