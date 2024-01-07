<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Entities\Ticket;
use App\Entities\Detail_Log;
use App\Models\Detail_LogModel;
use App\Entities\Status;
use App\Models\StatusModel;
use App\Entities\User;
use App\Models\UserModel;


use App\Models\CategorieModel;
use App\Entities\Categorie;
use App\Models\TechsModel;
use App\Entities\Techs;
use CodeIgniter\Database\Query;
use CodeIgniter\Validation\Validation as ValidationValidation;
use Config\Validation;
use Faker\Extension\Helper;
use PHPUnit\Util\Xml\ValidationResult;
use CodeIgniter\I18n\Time;
use App\Config\Email;
use phpDocumentor\Reflection\PseudoTypes\False_;

class Tickets extends BaseController
{
    private $model;
    private $userid;
    private $detaiLog;
    private $cat;
    private $st;
    private $user;
    
    public function __construct()
    {
        $this->detaiLog = new Detail_LogModel();
        $this->userid = session('user_id');
        $this->model = new TicketModel();
        $this->cat = new CategorieModel();
        $this->st = new StatusModel();
        $this->user = new UserModel();
    }

    public function index()
    {
        // to be removed after filering
        if(!session()->has('logged')){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }
        $cats= $this->cat->findAll();

        return view('ticket/create',["cats" => $cats]);
    }

    public function createTicket()
    {
        // to be removed after filering
        if(!session()->has('logged') && session('id_cat') == 1){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }
        $ticket = new Ticket();
        $ticket->title = $this->request->getPost('title');
        $ticket->subject = $this->request->getPost('subject');
        $ticket->id_tech_cat = $this->request->getPost('cat');
        $ticket->id_user = $this->userid;
        $ticket->id_status = 1;
        $added = $this->model->insert($ticket);
        if($added){
        // add new detail log row
            $detaillog = new Detail_Log();
            $detaillog->id_log = session('id_log');
            $detaillog->action = "create ticket" ; 
            $detail = 'Client n° : ' . session('user_id') . 'titre : ' . $ticket->title.' , Sujet :' . $this->request->getPost('subject') ;
            $detaillog->detail = $detail ;
            $this->detaiLog->insert($detaillog);
        // end
        // send email
            $user = $this->user->where('id_user' , $this->userid)->first();
            $email = \Config\Services::email();
            $email->setTo($user->email);
            $email->setFrom('oussama0408m@gmail.com' , 'Oussama rachid');
            $email->setSubject('Nouveau ticket');
            $email->setMessage('Votre ticket a été ajouter');
            $email->send();

        // send email 
            //$this->sendEmail();
            return redirect()->to("tickets/displayTicketsByStatus/0")->with("success" , "votre tickete a été ajouté!!");
        }else
            return redirect()->back()->with('errors' ,  $this->model->errors())->withInput();
    } 
    
    public function displayTicketsByStatus()
    {
        $db = \Config\Database::connect();
        if(session('id_cat') == 1 ){
            $tickets = $this->model->where([
                'ticket.id_user' => session('user_id'),
            ])->join('status' , 'ticket.id_status = status.id_status')
            ->join('technicien_cat' , 'technicien_cat.id_tech_cat = ticket.id_tech_cat')
            ->orderBy('ticket.created_at' , 'DESC')
            ->findAll();
            $all = $db->table('ticket')->where(['ticket.id_user'=> session('user_id'),])->countAllResults();
            $finished = $db->table('ticket')->where([
                'ticket.id_status'=> 2 ,
                'ticket.id_user'=> session('user_id'),
            ])->countAllResults();
            $inprocess = $db->table('ticket')->where([
                'ticket.id_status'=> 1,
                'ticket.id_user'=> session('user_id'),
                ])->countAllResults();
            return  view('dashboard/dashboard',[
                "tickets" =>  $tickets,
                "pager" =>  $this->model->pager,
                "all"    => $all ,
                "finished"    => $finished ,
                "inprocess"    => $inprocess,
            ]);
        }else
            return redirect()->back()->with("errors" , "vous n'avez pas l'access pour cette action!!");
    } 
    public function TicketsByTechs(){
        // to be removed after filering
        if(!session()->has('logged') && session('id_cat') == 3){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }

        $db = \Config\Database::connect();
        if(session()->has('logged') && session('id_cat') == 3){
            $all = $db->table('ticket')->where('ticket.id_tech_cat', session('id_tech_cat'))->countAllResults();
            $finished = $db->table('ticket')->where([
                'ticket.id_tech_cat'=> session('id_tech_cat'),
                'ticket.id_status'=> 2 
            ])->countAllResults();
            $inprocess = $db->table('ticket')->where([
                'ticket.id_tech_cat'=> session('id_tech_cat'),
                'ticket.id_status'=> 1
                ])->countAllResults();
            
            $tickets=$this->model
                        ->where(['ticket.id_tech_cat' => session('id_tech_cat') ]) 
                        ->join('status' , 'ticket.id_status = status.id_status')
                        ->join('technicien_cat' , 'ticket.id_tech_cat = technicien_cat.id_tech_cat')
                        ->orderBy('ticket.id_status' , 'ASC' )->findAll();
            $status= $this->st->findAll();
            return view('dashboard/techDachboard' , [
                "tickets"    => $tickets ,
                "pager" =>  $this->model->pager,
                "all"    => $all ,
                "finished"    => $finished ,
                "inprocess"    => $inprocess,
                "status"    => $status,
            ]);
        }
    }

    public function updateForm($id){
        // to be removed after filering
        if(!session()->has('logged') && session('id_cat') == 3){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }
        $cats= $this->cat->findAll();
        $ticket=    $this->model->where('id_ticket' , $id)
                                ->join('user' , 'user.id_user = ticket.id_user')
                                ->first();
        if(!$ticket){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("ce ticket est introuvable");
        }else
            return view('ticket/showTicket',[
                "ticket" =>  $ticket,
        ]);
    }

    public function updateTicket($id){
        // to be removed after filering
        if(!session()->has('logged') && session('id_cat') == 3){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }        

        $db = \Config\Database::connect();
        $status = $this->request->getPost('status');
        $comment = $this->request->getPost('comment');     
        $builder = $db->table('ticket');
        $data = [
            'comment' => $comment,
            'id_status'  => $status,
            'tech_id'  => session('user_id'),
        ];
        
        $builder->where('id_ticket', $id );
        if($builder->update($data)){
            
        // add new detail log row
            $detaillog = new Detail_Log();
            $detaillog->id_log = session('id_log');
            $detaillog->action = "edit ticket" ; 
            $detail = 'Technicien n° : ' . session('user_id') . ' , Ticket n°:' . $id . ' , Status : '.$status.' , commentaire : '. $comment ;
            $detaillog->detail = $detail ;
            $this->detaiLog->insert($detaillog);
        // end
            return redirect()->to("/tickets/TicketsByTechs/")->with("success" , "votre modifications sont effectuées!!");
        }
    }

    // for admin session
    public function displayAllTickets(){

        // to be removed after filering
        if(!session()->has('logged') && session('id_cat') == 2){
            return redirect()->to('/login/signinForm/')->with('errors' , 'Vous devez connecter pour cette action !!');
        }
        // to be removed after filering
        $db = \Config\Database::connect();
        if(session('id_cat') == 2 ){
                $tickets = $this->model->join('user' , 'user.id_user = ticket.id_user')
                ->join('status' , 'ticket.id_status = status.id_status')
                ->join('technicien_cat' , 'technicien_cat.id_tech_cat = ticket.id_tech_cat')
                ->orderBy('ticket.created_at' , 'DESC')
                ->findAll();  

            $all = $db->table('ticket')->countAllResults();
            $finished = $db->table('ticket')->where([
                'ticket.id_status'=> 2 
            ])->countAllResults();
            $inprocess = $db->table('ticket')->where([
                'ticket.id_status'=> 1
                ])->countAllResults();

            return  view('admin/tickets',[
                "tickets" =>  $tickets,
                "all"    => $all ,
                "finished"    => $finished ,
                "inprocess"    => $inprocess,
        ]);
        }else
            return redirect()->back()->with("errors" , "vous n'avez pas l'access pour cette action!!");
    }

    public function searchForTickets(){
        $db = \Config\Database::connect();
        $value = $this->request->getPost('name_id');
        $tickets = $this->model->where('user.id_user' , $value)
        ->join('user' , 'user.id_user = ticket.id_user')
        ->join('status' , 'ticket.id_status = status.id_status')
        ->join('technicien_cat' , 'technicien_cat.id_tech_cat = ticket.id_tech_cat')
        ->orderBy('ticket.updated_at' , 'DESC')
        ->findAll();
        if(!$tickets){
            $tickets=$this->model->like('user.fullname' , $value)
            ->join('user' , 'user.id_user = ticket.id_user')
            ->join('status' , 'ticket.id_status = status.id_status')
            ->join('technicien_cat' , 'technicien_cat.id_tech_cat = ticket.id_tech_cat')
            ->orderBy('ticket.updated_at' , 'DESC')
            ->findAll();
        }
        $all = $db->table('ticket')->countAllResults();
        $finished = $db->table('ticket')->where([
            'ticket.id_status'=> 2 
        ])->countAllResults();
        $inprocess = $db->table('ticket')->where([
            'ticket.id_status'=> 1
            ])->countAllResults();
    
            return  view('admin/tickets',[
                "tickets" =>  $tickets,
                "all"    => $all ,
                "finished"    => $finished ,
                "inprocess"    => $inprocess,
        ]);
    }
    
   
    //for ajax methods 
    
    public function afficherTicket(){
        $tickets = $this->model->where([
            'ticket.id_user' => session('user_id'),
        ])->join('status' , 'ticket.id_status = status.id_status')
        ->join('technicien_cat' , 'technicien_cat.id_tech_cat = ticket.id_tech_cat')
        ->orderBy('ticket.created_at' , 'DESC')
        ->findAll();
        echo json_encode($tickets);
    }
    
    public function afficherTicketTech(){
        $tickets=$this->model
                        ->where(['ticket.id_tech_cat' => session('id_tech_cat') ]) 
                        ->join('status' , 'ticket.id_status = status.id_status')
                        ->join('technicien_cat' , 'ticket.id_tech_cat = technicien_cat.id_tech_cat')
                        ->orderBy('ticket.id_status' , 'ASC' )->findAll();
        echo json_encode($tickets);
    }
    
    public function find($id){
        $ticket=    $this->model->where('id_ticket' , $id)
        ->join('user' , 'user.id_user = ticket.id_user')
        ->first();
        echo json_encode($ticket);
    }
    
    public function findT($id){
        $ticket=    $this->model->select('fullname ,title ,label_tech_cat , subject, comment ')
        ->where('id_ticket' , $id)
        ->join('technicien_cat' , 'ticket.id_tech_cat = technicien_cat.id_tech_cat')
        ->join('user' , 'user.id_user = ticket.id_user')
        ->first();
        echo json_encode($ticket);
    }
    
    public function all(){
        $tickets =    $this->model->join('technicien_cat' , 'ticket.id_tech_cat = technicien_cat.id_tech_cat')
        ->join('user' , 'user.id_user = ticket.id_user')
        ->join('status' , 'ticket.id_status = status.id_status')
        ->findAll();
        echo json_encode($tickets);
    }
    
    public function updateT($id){
        $db = \Config\Database::connect();
        $status = $this->request->getPost('statusTK');
        $comment = $this->request->getPost('commentTK');     
        $builder = $db->table('ticket');
        $data = [
            'comment' => $comment,
            'id_status' => $status,
            'tech_id'  => session('user_id'),
        ];
        $builder->where('id_ticket', $id );
        if($builder->update($data)){
            
        // add new detail log row
            $detaillog = new Detail_Log();
            $detaillog->id_log = session('id_log');
            $detaillog->action = "edit ticket" ; 
            $detail = 'Technicien n° : ' . session('user_id') . ' , Ticket n°:' . $id . ' , Status : '.$status.' , commentaire : '. $comment ;
            $detaillog->detail = $detail ;
            $this->detaiLog->insert($detaillog);
        // end
            return redirect()->to("/tickets/TicketsByTechs/");
        }
    }
}
