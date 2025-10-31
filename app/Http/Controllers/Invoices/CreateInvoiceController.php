<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class CreateInvoiceController extends Controller
{
    public function __invoke()
    {
        $clients = Client::all();
        $authUser = Auth::user();
        
        return Inertia::render('Invoices/Create', [
            'clients' => $clients,
            'authUser' => $authUser,
        ]);
    }
}
