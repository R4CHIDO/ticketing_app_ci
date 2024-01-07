<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user";
    protected $useTimestamps = true;  
    protected $returnType    = \App\Entities\User::class;
    protected $allowedFields = ["fullname" , "id_user","email","password","id_cat","id_tech_cat"];

    protected $validationRules    = [
        'fullname'     => 'required|min_length[6]',
        'email'        => 'required|valid_email|is_unique[user.email]',
        'password'        => 'required|min_length[4]',
    ];

    protected $validationMessages = [
        'fullname'        => [
            'required' => 'Enter your fullname please!!',
            'min_length' => 'your name must contain at least 8 caracters ',
        ],
        'email'  => [
            'required' => 'Enter your email',
            'valid_email' => 'please enter a valid email',
            'is_unique' => 'this email is already used',
        ],
        'password'  => [
            'required' => 'Enter your password',
            'min_length' => 'your password must contain at least 4 caracters ',
        ],
        
    ];
    public function login($email , $password)
    {
        $array =[
            'email' => $email ,
            'password' => $password
        ];
        $db      = \Config\Database::connect();
        return $db->table('user')->where($array)->get()->getFirstRow() ;
    }
}
