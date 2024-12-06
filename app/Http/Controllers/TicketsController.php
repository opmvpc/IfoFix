<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    public function index()
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::all()
        ]);
    }
}