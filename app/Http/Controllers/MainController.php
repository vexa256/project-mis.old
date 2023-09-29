<?php

namespace App\Http\Controllers;

use DB;

class MainController extends Controller
{

    public function VirtualOffice()
    {

        $Projects = DB::table('projects')->get();

        $data = [
            'Title' => 'ECSA-HC Project Management System',
            'Desc'  => 'Virtual Office Dashboard',

        ];

        return view('scrn', $data);
    }
}
