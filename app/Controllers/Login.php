<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\UserModel;
use App\Entities\User;
use App\Models\LogModel;
use App\Entities\log;

class Login extends BaseController
{
    private $model;
    private $log;
    public function __construct()
    {

        $this->log = new LogModel();
        $this->model = new UserModel();
        if(session()->has('logged')){
            return redirect()->to('/home/index');
        }else{
            return redirect()->to('login/signinForm');
        }

    }
    public function signinForm()
    {

        return view('login/login');
    }
    
    public function signupForm()
    {
        
        return view('login/register');
    }
    public function signin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user =$this->model->where('email' , $email)->first();
        if($user != null){
            if($password === $user->password){
                $session = session();
                $session->regenerate();
                $session->set('logged', true);
                $session->set('fullname' , $user->fullname);
                $session->set('user_id' , $user->id_user);
                $session->set('id_tech_cat' , $user->id_tech_cat);
                $session->set('id_cat' , $user->id_cat);
                // create new log                
                $log = new log();
                $debut = new Time('now');
                $log->id_user = session('user_id');
                $log->date_debut = $debut ; 
                $this->log->insert($log);
                $current_log = $this->log->where('id_user' , session('user_id'))->orderBy('date_debut' , 'DESC')->first();
                $session->set('id_log' , $current_log->id_log);
                // end log
                if($user->id_cat == 1)
                    return redirect()->to('/tickets/displayTicketsByStatus/0');
                elseif($user->id_cat == 3)
                    return redirect()->to('/tickets/TicketsByTechs/');
                elseif($user->id_cat == 2)
                    return redirect()->to('/admin/clients/' );
            }else
                return redirect()->back()->with('errors' ,  'the password you entered is incorrect!!');
        }else{
            return redirect()->back()->with('errors' ,  'Email ou password is incorrect!!');
        }
    } 

    public function sendEmail(){
        $email = \Config\Services::email();
            $email->setTo('oussama-rachid@outlook.com');
            $email->setFrom('oussama0408m@gmail.com' , 'Oussama rachid');
            $email->setSubject('new account');
            $email->setMessage('welcome');
            if($email->send()){
                echo 'sent' ;
                die();
            }else{
                echo 'not sent';
                die();
            }
    }
    public function signup()
    {
        $user = new User();
        $user->fullname = $this->request->getPost('fullname');
        $user->email    = $this->request->getPost('email');
        $user->password = $this->request->getPost('password');
        $user->id_cat = 4 ;
        if($this->model->insert($user)){

            $email = \Config\Services::email();
            $email->setTo($user->email);
            $email->setFrom('oussama0408m@gmail.com' , 'Oussama rachid');
            $email->setSubject('new account');
            $email->setMessage('welcome');
            $email->send();

            return redirect()->to("/login/signinForm")->with("success" , "account created successfuly!!");
        }
        else
            return redirect()->back()->withInput();
    } 
    public function logout(){
            session()->destroy();
            return redirect()->to('/login/signinForm')->with('success' ,  'deconnecter!!');
        
    }
    public function profile(){
        return view('home/profile');
    }
}
