<?php

namespace App\Models;

use CodeIgniter\Model;


class TicketModel extends Model
{
    protected $table = "ticket";
    protected $useTimestamps = true;  
    protected $returnType    = \App\Entities\Ticket::class;
    protected $allowedFields = ["subject" , "title","id_user",'comment', "tech_id","id_status" , "id_tech_cat"];
    protected $validationRules    = [
        'subject'     => 'required|min_length[10]',
        'id_tech_cat'     => 'required',
    ];

    protected $validationMessages = [
        'subject'        => [
            'required' => 'please fill the subject field',
            'min_length' => 'the subject must contain at least 10 caracters ',
        ],
        'id_tech_cat'        => [
            'required' => "selectionner une designation s'il vous plait",
        ]
    ];
}
