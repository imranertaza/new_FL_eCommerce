<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class AlbumModel extends Model {

    protected $table = 'cc_album';
    protected $primaryKey = 'album_id';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['album_id','name','parent_album_id','is_parent','is_album_uploadable','thumb','sort_order','createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'];
    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}