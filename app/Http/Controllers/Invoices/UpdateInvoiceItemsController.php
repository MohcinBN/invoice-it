<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInvoiceItemsRequest;
use App\Models\Invoice;
use App\Services\InvoiceItemService;
use Illuminate\Http\RedirectResponse;

class UpdateInvoiceItemsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly InvoiceItemService $invoiceItemService
    ) {
    }

    /**
     * Update the invoice items.
     */
    public function __invoke(UpdateInvoiceItemsRequest $request, Invoice $invoice): RedirectResponse
    {
        $validated = $request->validated();

        $this->invoiceItemService->updateItems($invoice, $validated['items']);

        return redirect()->route('invoices.items.edit', $invoice)
            ->with('success', 'Invoice items updated successfully.');
    }
}
