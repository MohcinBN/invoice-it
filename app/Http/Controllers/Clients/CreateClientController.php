<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CreateClientController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Clients/Create');
    }
}
