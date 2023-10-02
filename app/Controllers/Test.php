<?php

namespace App\Controllers;

class Test extends BaseController {

    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index(){
        $builder = DB()->table('cc_theme_settings');
        $rows = $builder->get()->getResult();

        $output = '';
        foreach ($rows as $row){
            $output .= '[<br/>';
            $output .= "'theme_settings_id' => "."'".$row->theme_settings_id."'".',<br/>';
            $output .= "'label' => "."'".$row->label."'".',<br/>';
            $output .= "'title' => "."'".$row->title."'".',<br/>';
            $output .= "'value' => "."'".$row->value."'".',<br/>';
            $output .= "'theme' => "."'".$row->theme."'".',<br/>';
//            $output .= "'image' => '".str_replace("'", "\'", $row->image)."',<br/>";
//            $output .= "'start_date' => '".$row->start_date."',<br/>";
//            $output .= "'end_date' => '".$row->end_date."',<br/>";
//            $output .= "'createdDtm' => '".$row->createdDtm."',<br/>";
//            $output .= "'createdBy' => '".$row->createdBy."',<br/>";
//            $output .= "'updatedBy' => '".$row->updatedBy."',<br/>";
//            $output .= "'updatedDtm' => '".$row->updatedDtm."',<br/>";
            $output .= '],<br/>';
        }
        print $output;
    }


}
