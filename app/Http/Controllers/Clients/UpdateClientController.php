<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Http\Requests\Clients\UpdateClientRequest;

class UpdateClientController extends Controller
{
    public function __invoke(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully');
    }
}
