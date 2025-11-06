<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['nullable', 'exists:invoice_items,id'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.number_of_days' => ['required', 'string', 'max:255'],
            'items.*.number_of_hours' => ['required', 'string', 'max:255'],
            'items.*.day_rate' => ['required', 'string', 'max:255'],
            'items.*.details' => ['required', 'string'],
            'items.*.total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'At least one item is required.',
            'items.min' => 'At least one item is required.',
            'items.*.name.required' => 'Item name is required.',
            'items.*.description.required' => 'Item description is required.',
            'items.*.number_of_days.required' => 'Number of days is required.',
            'items.*.number_of_hours.required' => 'Number of hours is required.',
            'items.*.day_rate.required' => 'Day rate is required.',
            'items.*.details.required' => 'Additional details are required.',
            'items.*.total_amount.required' => 'Total amount is required.',
            'items.*.total_amount.numeric' => 'Total amount must be a number.',
            'items.*.total_amount.min' => 'Total amount must be at least 0.',
        ];
    }
}
