<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class dashboard extends Controller
{
    public function index(): View
    {   $menu = 'Dashboard';
        return view('dashboard/index',['menu' => $menu]);
    }
}
