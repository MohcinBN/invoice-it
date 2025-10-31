<?php
namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class RemoveInvoiceController extends Controller
{
    public function __invoke($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice removed successfully');
    }
}