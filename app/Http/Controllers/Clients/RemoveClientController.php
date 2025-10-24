<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;

class RemoveClientController extends Controller
{
    public function __invoke(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client removed successfully');
    }
}
