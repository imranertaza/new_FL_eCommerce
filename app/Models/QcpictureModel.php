<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class QcpictureModel extends Model {

    protected $table = 'cc_album';
    protected $primaryKey = 'album_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['album_id','name', 'thumb','sort_order','createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}