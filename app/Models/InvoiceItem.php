<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $invoice_id
 * @property string $name
 * @property string $description
 * @property string $number_of_days
 * @property string $number_of_hours
 * @property string $day_rate
 * @property string $details
 * @property float $total_amount
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property-read \App\Models\Invoice $invoice
 *
 * @method static \Database\Factories\InvoiceItemFactory<static> factory($count = null, $state = [])
 */
class InvoiceItem extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceItemFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'invoice_id',
        'name',
        'description',
        'number_of_days',
        'number_of_hours',
        'day_rate',
        'details',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the invoice that owns the invoice item.
     *
     * @return BelongsTo<\App\Models\Invoice, $this>
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
