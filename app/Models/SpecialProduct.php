<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialProduct extends Model
{
    use HasFactory;

    protected $table = 'special_product';
    protected $primaryKey = 'special_product_id ';
    protected $guarded = ['special_product_id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
