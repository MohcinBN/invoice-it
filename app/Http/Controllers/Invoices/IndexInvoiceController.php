<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Invoice;

class IndexInvoiceController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Invoices/Index', [
            'invoices' => Invoice::paginate(10),
        ]);
    }
}
