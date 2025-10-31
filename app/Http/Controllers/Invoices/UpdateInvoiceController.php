<?php
namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\StoreInvoiceControllerRequest;
use App\Models\Invoice;

class UpdateInvoiceController extends Controller
{
    public function __invoke(StoreInvoiceControllerRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
    }
}
