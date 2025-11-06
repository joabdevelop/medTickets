<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexOperacional()
    {
        return view('dashboard');
    }

    public function indexSla()
    {
        return view('dashboard.sla');
    }

    public function indexEquipe()
    {
        return view('dashboard.desempenhoEquipe');
    }
}
