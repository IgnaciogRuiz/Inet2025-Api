<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_code',
        'name',
        'description',
        'price',
        'scope',
        'capacity_id',
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
            'price' => 'decimal:2',
            'capacity_id' => 'integer',
        ];
    }

    public function capacity(): BelongsTo
    {
        return $this->belongsTo(Capacity::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function historicalOrderDetails(): HasMany
    {
        return $this->hasMany(HistoricalOrderDetails::class);
    }

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Cars::class);
    }

    public function flights(): BelongsToMany
    {
        return $this->belongsToMany(Flights::class);
    }

    public function stays(): BelongsToMany
    {
        return $this->belongsToMany(Stay::class);
    }
}
