<?php

namespace App\Controllers;

class Home extends BaseController
{
    // public function __construct()
    // {
    //     if(session()->has('logged')){
    //         return redirect()->to('/home/index');
    //     }else{
    //         return redirect()->to('login/signinForm');
    //    
    
    public function index()
    {
        return view('login/login');
    }
}
