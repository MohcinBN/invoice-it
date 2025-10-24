<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Http\Requests\Clients\StoreClientRequest;

class StoreClientController extends Controller
{
    public function __invoke(StoreClientRequest $request)
    {
        $client = $request->validated();

        Client::create($client);

        return redirect()->route('clients.index')->with('success', 'Client created successfully');
    }
}
