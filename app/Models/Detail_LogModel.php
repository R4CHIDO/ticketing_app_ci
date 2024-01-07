<?php

namespace App\Models;

use CodeIgniter\Model;

class Detail_LogModel extends Model
{
    protected $table = "detail_log";
    protected $useTimestamps = true;
    protected $returnType    = \App\Entities\Detail_Log::class;
    protected $allowedFields = ['id_log','action','detail','created_at'];
    protected $validationRules    = [
        'action'     => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'action'        => [
            'required' => 'action required',
        ]        
    ];
}