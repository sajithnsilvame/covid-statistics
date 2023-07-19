<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CovidStatController extends Controller
{
    public function getCovidData(){
        return view('home');
    }
}
