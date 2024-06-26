<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $primaryKey = 'order_id';
    protected $guarded = ["order_id"];
    public function items()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}

}
