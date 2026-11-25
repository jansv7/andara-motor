<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'invoice_number',
        'motorcycle_id',
        'sale_date',
        'buyer_name',
        'buyer_phone',
        'buyer_address',
        'payment_method',
        'sale_price',
        'purchase_price_snapshot',
        'reconditioning_cost_snapshot',
        'profit',
        'notes',
        'cancel_reason',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'sale_price' => 'integer',
            'purchase_price_snapshot' => 'integer',
            'reconditioning_cost_snapshot' => 'integer',
            'profit' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Motorcycle, $this>
     */
    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
