<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }

        .company-info {
            flex: 1;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .invoice-title {
            text-align: right;
            flex: 1;
        }

        .invoice-title h1 {
            font-size: 36px;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 14px;
            color: #666;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .info-block {
            flex: 1;
        }

        .info-block h3 {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info-block p {
            margin-bottom: 5px;
            color: #555;
        }

        .info-block .label {
            font-weight: bold;
            color: #333;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background-color: #2563eb;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        .item-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }

        .item-description {
            color: #666;
            font-size: 11px;
        }

        .item-details {
            color: #888;
            font-size: 10px;
            margin-top: 5px;
            font-style: italic;
        }

        .totals {
            margin-left: auto;
            width: 300px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .total-row.grand-total {
            background-color: #2563eb;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            margin-top: 10px;
        }

        .total-label {
            font-weight: bold;
        }

        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 11px;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background-color: #10b981;
            color: white;
        }

        .status-pending {
            background-color: #f59e0b;
            color: white;
        }

        .status-draft {
            background-color: #6b7280;
            color: white;
        }

        .status-cancelled {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-name">{{ $invoice->user->name ?? 'Your Company' }}</div>
                <p>{{ $invoice->user->email ?? 'email@company.com' }}</p>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p class="invoice-number">#{{ $invoice->invoice_number }}</p>
                <span class="status-badge status-{{ strtolower($invoice->status) }}">
                    {{ $invoice->status }}
                </span>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-block">
                <h3>Bill To:</h3>
                <p><strong>{{ $invoice->client->name }}</strong></p>
                <p>{{ $invoice->client->email }}</p>
                <p>{{ $invoice->client->phone }}</p>
                <p>{{ $invoice->client->address }}</p>
            </div>
            <div class="info-block" style="text-align: right;">
                <h3>Invoice Details:</h3>
                <p><span class="label">Invoice Date:</span> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                <p><span class="label">Period Covered:</span> {{ $invoice->date_covered_start->format('M d, Y') }} - {{ $invoice->date_covered_end->format('M d, Y') }}</p>
                <p><span class="label">Status:</span> {{ ucfirst($invoice->status) }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Item</th>
                    <th class="text-center" style="width: 12%;">Days</th>
                    <th class="text-center" style="width: 12%;">Hours</th>
                    <th class="text-right" style="width: 15%;">Day Rate</th>
                    <th class="text-right" style="width: 15%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->name }}</div>
                        <div class="item-description">{{ $item->description }}</div>
                        @if($item->details)
                        <div class="item-details">{{ $item->details }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->number_of_days }}</td>
                    <td class="text-center">{{ $item->number_of_hours }}</td>
                    <td class="text-right">${{ number_format($item->day_rate, 2) }}</td>
                    <td class="text-right"><strong>${{ number_format($item->total_amount, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <span>${{ number_format($invoice->items->sum('total_amount'), 2) }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>${{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>If you have any questions about this invoice, please contact us.</p>
            <p>Generated on {{ now()->format('F d, Y') }}</p>
        </div>
    </div>
</body>
</html>
