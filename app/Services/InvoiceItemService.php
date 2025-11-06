<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceItemService
{
    /**
     * Update invoice items in a transaction.
     *
     * @param Invoice $invoice
     * @param array $itemsData
     * @return void
     */
    public function updateItems(Invoice $invoice, array $itemsData): void
    {
        DB::transaction(function () use ($invoice, $itemsData) {
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            // Update or create items
            foreach ($itemsData as $itemData) {
                if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {
                    // Update existing item
                    $item = InvoiceItem::find($itemData['id']);
                    $item->update($itemData);
                    $updatedItemIds[] = $itemData['id'];
                } else {
                    // Create new item
                    $item = $invoice->items()->create($itemData);
                    $updatedItemIds[] = $item->id;
                }
            }

            // Delete items that were removed
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                InvoiceItem::whereIn('id', $itemsToDelete)->delete();
            }

            // Recalculate invoice total
            $this->recalculateInvoiceTotal($invoice);
        });
    }

    /**
     * Recalculate the invoice total based on items.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function recalculateInvoiceTotal(Invoice $invoice): void
    {
        $total = $invoice->items()->sum('total_amount');
        $invoice->update(['total' => $total]);
    }

    /**
     * Calculate item total based on days, hours, and rate.
     *
     * @param float $days
     * @param float $hours
     * @param float $rate
     * @return float
     */
    public function calculateItemTotal(float $days, float $hours, float $rate): float
    {
        // Formula: (days * rate) + (hours / 8 * rate)
        return ($days * $rate) + (($hours / 8) * $rate);
    }
}
