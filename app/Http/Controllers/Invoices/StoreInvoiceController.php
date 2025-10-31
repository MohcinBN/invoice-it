<?php
namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\StoreInvoiceControllerRequest;
use App\Models\Invoice;

class StoreInvoiceController extends Controller
{
    public function __invoke(StoreInvoiceControllerRequest $request){
        $invoice = Invoice::create($request->validated());
        $invoice->save();
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }
}