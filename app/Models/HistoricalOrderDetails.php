<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalOrderDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'historicalOrder_id',
        'product_id',
        'quantity',
        'subtotal_price',
        'historical_orders_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'historicalOrder_id' => 'integer',
            'product_id' => 'integer',
            'subtotal_price' => 'decimal:2',
            'historical_orders_id' => 'integer',
        ];
    }

    public function historicalOrders(): BelongsTo
    {
        return $this->belongsTo(HistoricalOrders::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function historicalOrder(): BelongsTo
    {
        return $this->belongsTo(\App\Models\HistoricalOrders::class);
    }
}
