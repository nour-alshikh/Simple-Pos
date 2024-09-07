<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute()
    {
        return asset("uploads/product_images/" . $this->image);
    }
    public function getProfitAttribute()
    {
        return  $this->sell_price - $this->purchase_price;
    }
    public function getProfitPercentageAttribute()
    {
        $profit =  $this->sell_price - $this->purchase_price;

        $profit_percentage = $profit * 100 / $this->purchase_price;

        return number_format($profit_percentage, 2);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
