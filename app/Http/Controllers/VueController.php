<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
{
    public function index()
    {
        return view('vue');
    }

    public function ajax()
    {
        return view('vueAjax');
    }
}