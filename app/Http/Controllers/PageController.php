<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //index page

    public function index(){
        

        return view("index");
    }
}
