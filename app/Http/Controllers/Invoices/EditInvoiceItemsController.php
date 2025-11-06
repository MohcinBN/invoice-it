<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Inertia\Inertia;
use Inertia\Response;

class EditInvoiceItemsController extends Controller
{
    /**
     * Display the invoice items editor.
     */
    public function __invoke(Invoice $invoice): Response
    {
        // Load the invoice with its items, client, and user
        $invoice->load(['items', 'client', 'user']);

        return Inertia::render('Invoices/EditItems', [
            'invoice' => $invoice,
        ]);
    }
}
