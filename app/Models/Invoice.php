<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property string $invoice_number
 * @property \DateTime $invoice_date
 * @property \DateTime $date_covered
 * @property string $status
 * @property float $total
 * @property string $template
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $items
 * @property-read int|null $items_count
 *
 * @method static \Database\Factories\InvoiceFactory<static> factory($count = null, $state = [])
 */
class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_id',
        'user_id',
        'invoice_number',
        'invoice_date',
        'date_covered',
        'status',
        'total',
        'template',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'invoice_date' => 'date',
        'date_covered' => 'date',
        'total' => 'decimal:2',
    ];

    /**
     * Get the client that owns the invoice.
     *
     * @return BelongsTo<\App\Models\Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the user that owns the invoice.
     *
     * @return BelongsTo<\App\Models\User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the invoice.
     *
     * @return HasMany<\App\Models\InvoiceItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
