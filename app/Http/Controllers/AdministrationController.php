<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministrationController extends Controller
{
    public function index()
    {
        return Inertia::render('Administration/Index');
    }
}
