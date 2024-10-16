<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'page_title' => 'Dashboard',
            'url' => 'dashboard',
            'active' => 'dashboard',
        ]);
    }
}
