<?php

namespace App\Models;

use CodeIgniter\Model;


class TechsModel extends Model
{
    protected $table = "technicien_cat";
    protected $useTimestamps = false;  
    protected $returnType    = \App\Entities\Techs::class;
    protected $allowedFields = ["id_tech_cat" ,"label_tech_cat" , "id_cat"];
    // protected $validationRules    = [
    //     'subject'     => 'required|min_length[10]',
    //     'id_tech_cat'     => 'required',
    // ];

    // protected $validationMessages = [
    //     'subject'        => [
    //         'required' => 'please fill the subject field',
    //         'min_length' => 'the subject must contain at least 10 caracters ',
    //     ],
    //     'id_tech_cat'        => [
    //         'required' => "selectionner une designation s'il vous plait",
    //     ]
    // ];
}
