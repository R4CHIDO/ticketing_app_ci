<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table = "technicien_cat";
    protected $useTimestamps = false;  
    protected $returnType    = \App\Entities\Categorie::class;
    protected $allowedFields = ['label_tech_cat'];
    protected $validationRules    = [
        'label_tech_cat'     => 'required',
    ];

    protected $validationMessages = [
        'action'        => [
            'required' => 'Entrer un nom pour la categorie',
        ]        
    ];
}