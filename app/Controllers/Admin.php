<?php

namespace App\Controllers;


use App\Models\UserModel;
use App\Entities\User;
use App\Models\CategorieModel;
use App\Entities\Categorie;

use App\Entities\Detail_Log;
use App\Entities\Log;
use App\Models\Detail_LogModel;
use App\Models\LogModel;

use function PHPUnit\Framework\returnSelf;

class Admin extends BaseController
{
  private $model;
  private $log;
  private $detail_log;
  private $cat;
  public function __construct(){
    $this->log = new LogModel();
    $this->detail_log = new Detail_LogModel();
    $this->model = new UserModel();
    $this->cat = new CategorieModel();

  }
  public function technicien(){
    $users=$this->model->join('technicien_cat' , 'technicien_cat.id_tech_cat = user.id_tech_cat')
    ->orderBy('created_at' , 'DESC')
    ->findAll();
    
    $techs=$this->model
                ->where('user.id_cat', 3) 
                ->countAllResults();
    $cats = $this->cat->findAll();

      return view('/admin/techs',[
                        "users" =>  $users,
                        'techs'   =>  $techs,
                        'cats' => $cats
                ]);          
  }
  public function clients(){
    $users= $this->model->orderBy('id_user' , 'DESC')
                        ->findAll();
    $clients=$this->model
                  ->where('user.id_cat', 1) 
                  ->countAllResults();
    $waiting=$this->model
              ->where('user.id_cat', 4) 
              ->countAllResults();
    return view('/admin/users',[
          "users" =>  $users,
          'clients'   =>  $clients,
          'waiting'   =>  $waiting,
    ]);
  }
  public function waiting(){
    $Pusers=$this->model
    ->where('id_cat' , 4)
    ->orderBy('user.id_user' , 'DESC')
    ->findAll();
    echo json_encode($Pusers);
  }
  public function add($id){
    $db = \Config\Database::connect();
    $builder = $db->table('user');
    $data = [
        'id_cat' => 1,
    ];
    
    $builder->where('id_user', $id );
    if($builder->update($data)){
    // send email
      $user = $this->model->where('id_user' , $id)->first();
      $email = \Config\Services::email();
      $email->setTo($user->email);
      $email->setFrom('oussama0408m@gmail.com' , 'Oussama rachid');
      $email->setSubject('Activation de compte!!');
      $email->setMessage('Votre compte été activé .
      Maintenant nous techniciens sont a votre serveice .');
      $email->send();
    // send email

    return redirect()->back();
    }  
  }
  public function remove($id){
    $user = $this->model->where('id_user' , $id)->first();
    $this->model->where('id_user', $id)->delete();

  }
  public function displayLogs(){
    $logs=$this->log->join('user' , 'user.id_user = log.id_user')
    ->orderBy('id_log' , 'DESC')
    ->findAll();
    $online =$this->log->where(['date_fin' => null])
                              ->countAllResults();
    $offline =$this->log->where(['date_fin <>' => null])
                              ->countAllResults();
    $all =$this->log->countAllResults();
    
    return view('/admin/logs',[
    "logs" => $logs,
    "all" => $all,
    "online" => $online,
    "offline" => $offline,
  
    ]);
  }
  public function Logs(){
    $logs=$this->log->join('user' , 'user.id_user = log.id_user')
    ->orderBy('id_log' , 'DESC')
    ->findAll();
  
    echo json_encode($logs);
  }
  public function detail_Logs($id){
    $detail_logs=    $this->detail_log->select('detail_log.id_log , log.date_debut, detail_log.id_detail_log , log.date_fin , detail_log.created_at , user.fullname , action , detail_log.detail')
    ->where('detail_log.id_log' , $id)
                            ->join('log' , 'log.id_log = detail_log.id_log')
                            ->join('user' , 'user.id_user = log.id_user')
                            ->findAll();
    $log = $this->log->where('id_log' , $id)->first();
    $actions =  $this->detail_log->where('detail_log.id_log' , $id)
                      ->join('log' , 'log.id_log = detail_log.id_log')
                      ->countAllResults();



    return view('/admin/detail_logs',[
      "detail_logs" => $detail_logs,
      "actions" => $actions,
      "log" => $log
    ]);
  }
  public function findDetailLog($id){
    $detail_log=    $this->detail_log->where('id_detail_log' , $id)
                            ->join('log' , 'log.id_log = detail_log.id_log')
                            ->join('user' , 'user.id_user = log.id_user')
                            ->first();
    echo json_encode($detail_log);
  }
  public function searchForLogs(){
    $value = $this->request->getPost('name_id');
    $logs=$this->log->where('user.id_user' , $value)
      ->join('user' , 'user.id_user = log.id_user')->orderBy('id_log' , 'DESC')
      ->findAll();
    if(!$logs){
      $logs=$this->log->like('user.fullname' , $value)
      ->join('user' , 'user.id_user = log.id_user')->orderBy('id_log' , 'DESC')
      ->findAll();
    }
      $online =$this->log->where(['date_fin' => null])
            ->countAllResults();
      $offline =$this->log->where(['date_fin <>' => null])
            ->countAllResults();
      $all =$this->log->countAllResults();

    

    return view('/admin/logs',[
    "logs" => $logs,
    "all" => $all,
    "online" => $online,
    "offline" => $offline,
    ]);
  }
  public function searchForUsers(){
    $value = $this->request->getPost('name_id');
    $users=$this->model->where('user.id_user' , $value)
      ->join('categorie' , 'user.id_cat = categorie.id_cat')
      ->findAll();
    if(!$users){
      $users=$this->model->like('user.fullname' , $value)
      ->join('categorie' , 'user.id_cat = categorie.id_cat')
      ->findAll();
    }
    $techs=$this->model
    ->where('user.id_cat', 3) 
    ->countAllResults();
    $clients=$this->model
          ->where('user.id_cat', 1) 
          ->countAllResults();
    $all=$this->model
      ->whereNotIn('user.id_cat', [2]) 
      ->countAllResults();

    return view('/admin/users',[
    "users" => $users,
    "all" => $all,
    "clients" => $clients,
    "techs" => $techs,
    ]);
  }
  public function categories(){
    $categories = $this->cat->select("technicien_cat.id_tech_cat, technicien_cat.label_tech_cat , count(user.id_tech_cat) as techs")
    ->join('user' ,'technicien_cat.id_tech_cat = user.id_tech_cat' ,'left')                        
    ->groupBy('technicien_cat.id_tech_cat')->findAll();
    $count =$this->cat->countAllResults();
    return view('/admin/categories',["categories" => $categories,"count" => $count]);
  }
  public function addCategorie(){
    $categorie = new Categorie();
        $categorie->label_tech_cat = $this->request->getPost('label');
        $added = $this->cat->insert($categorie);
        if($added){
        // add new detail log row
            $detaillog = new Detail_Log();
            $detaillog->id_log = session('id_log');
            $detaillog->action = "nouveau categorie" ; 
            $detail = 'Admin n° : ' . session('user_id') . ' , Nom Categorie :' . $this->request->getPost('label') ;
            $detaillog->detail = $detail ;
            $this->detail_log->insert($detaillog);
        // end
            //$this->sendEmail();
            return redirect()->to("admin/categories")->with("success" , "Categorie ajouté!!");
        }else
            return redirect()->back()->with('errors' ,  $this->cat->errors())->withInput();
  }
  public function addCat(){
      $categorie = new Categorie();
        $categorie->label_tech_cat = $this->request->getPost('label');
        $added = $this->cat->insert($categorie);
        if($added){
        // add new detail log row
            $detaillog = new Detail_Log();
            $detaillog->id_log = session('id_log');
            $detaillog->action = "nouveau categorie" ; 
            $detail = 'Admin n° : ' . session('user_id') . ' , Nom Categorie :' . $this->request->getPost('label') ;
            $detaillog->detail = $detail ;
            $this->detail_log->insert($detaillog);
        // end
            //$this->sendEmail();
            return redirect()->to("admin/categories");
        }else
            return redirect()->back();
  }
  public function addTech(){
    $tech = new User();
      $tech->fullname = $this->request->getPost('fullname');
      $tech->email = $this->request->getPost('email');
      $tech->password = $this->request->getPost('password');
      $tech->id_cat = 3;
      $tech->id_tech_cat = $this->request->getPost('id_tech_cat');
      $added = $this->model->insert($tech);
      if($added){
        // send email
        $email = \Config\Services::email();
        $email->setTo($this->request->getPost('email'));
        $email->setFrom('oussama0408m@gmail.com' , 'Oussama rachid');
        $email->setSubject('new tech!!');
        $email->setMessage('welcome to our techs team!!');
        $email->send();
        // send email
          return redirect()->to("Admin/displayUsers/3");
      }else
          return redirect()->back();
  }
  public function getCat(){
    $cats= $this->cat->findAll();
    echo json_encode($cats);
  }
  public function users(){
    $users= $this->model->findAll();
    echo json_encode($users);
  }
  public function findTech($id){
    $user = $this->model->select('user.id_user ,user.created_at ,fullname ,email ,user.id_cat ,label_tech_cat , count(ticket.id_ticket) as count ')
    ->where('user.id_user' , $id)
    ->join('categorie' , 'user.id_cat = categorie.id_cat')
    ->join('ticket' , 'user.id_user = ticket.tech_id')
    ->join('technicien_cat' , 'user.id_tech_cat = technicien_cat.id_tech_cat')
    ->first();
    echo json_encode($user);
  }
  public function findUser($id){
    $user = $this->model->select('user.id_user , user.created_at ,fullname ,email ,user.id_cat ,label_cat , count(ticket.id_user) as count ')
    ->where('user.id_user' , $id)
    ->join('categorie' , 'user.id_cat = categorie.id_cat')
    ->join('ticket' , 'user.id_user = ticket.id_user')
    ->first();
    echo json_encode($user);
  }
  
}