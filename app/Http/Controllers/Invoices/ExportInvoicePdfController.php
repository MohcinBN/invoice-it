<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Spatie\LaravelPdf\Facades\Pdf;

class ExportInvoicePdfController extends Controller
{
    /**
     * Export the invoice as PDF.
     */
    public function __invoke(Invoice $invoice)
    {
        // Load the invoice with its items, client, and user
        $invoice->load(['items', 'client', 'user']);

        // Determine which template to use (default to template_1)
        $template = $invoice->template ?? 'template_1';

        // Generate and return PDF
        return Pdf::view("pdf.invoices.{$template}", [
            'invoice' => $invoice,
        ])
            ->format('a4')
            ->name("invoice-{$invoice->invoice_number}.pdf")
            ->download();
    }
}
