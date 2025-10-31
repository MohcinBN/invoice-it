<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class EditInvoiceController extends Controller
{
    public function __invoke($id)
    {
        $clients = Client::all();
        $authUser = Auth::user();
        
        $invoice = Invoice::findOrFail($id);
        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,
            'clients' => $clients,
            'authUser' => $authUser,
        ]);
    }
}
