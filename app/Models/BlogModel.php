<?php

// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table              = 'cc_blog';
    protected $primaryKey         = 'blog_id';
    protected $returnType         = 'object';
    protected $useSoftDeletes     = false;
    protected $allowedFields      = ['blog_id', 'blog_title', 'slug', 'short_des', 'description', 'meta_title', 'meta_keyword', 'meta_description', 'cat_id', 'image', 'publish_date', 'status', 'createdBy', 'createdDtm', 'updatedBy', 'updatedDtm'];
    protected $useTimestamps      = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
