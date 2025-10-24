<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Inertia\Inertia;

class ClientControllerIndex extends Controller
{
    public function __invoke()
    {
        $clients = Client::paginate(10);
        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }
}
