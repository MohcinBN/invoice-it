<?php

namespace App\Http\Requests\Invoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceControllerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required',
            'user_id' => 'required',
            'invoice_date' => 'required|date',
            'invoice_number' => 'required',
            'date_covered_start' => 'required|date',
            'date_covered_end' => 'required|date',
            'status' => 'required',
            'template' => 'required',
            'total' => 'required',
        ];
    }
}
