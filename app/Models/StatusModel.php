<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = "status";
    protected $useTimestamps = false;  
    protected $returnType    = \App\Entities\Categorie::class;
    protected $allowedFields = ['label_status'];
}