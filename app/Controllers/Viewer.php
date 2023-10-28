<?php

namespace App\Controllers;

class Viewer extends BaseController
{
    public function index()
    {
        return view('v_viewer');
    }
}
