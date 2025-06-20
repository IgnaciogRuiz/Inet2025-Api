<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'capacity',
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
        ];
    }

    protected function isPackage(): Attribute
    {
        return Attribute::get(function () {
            $count = 0;
            if ($this->flights()->exists()) $count++;
            if ($this->cars()->exists()) $count++;
            if ($this->stays()->exists()) $count++;

            return $count >= 2;
        });
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
        return $this->belongsToMany(Car::class);
    }

    public function flights(): BelongsToMany
    {
        return $this->belongsToMany(Flight::class);
    }

    public function stays(): BelongsToMany
    {
        return $this->belongsToMany(Stay::class);
    }
}
